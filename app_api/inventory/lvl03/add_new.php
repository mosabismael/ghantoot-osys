<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	
	try{
		if( isset($_POST['division_name']) &&
		isset($_POST['is_finished']) &&
		isset($_POST['unit_id']) &&
		isset($_POST['section_id']) 
		){
			
			
			$division_id = 0;
			$division_code = '99999999';
			$division_name = test_inputs($_POST['division_name']);
			$section_id = (int) test_inputs($_POST['section_id']);
			
			$is_finished = (int) test_inputs($_POST['is_finished']);
			$unit_id = (int) test_inputs($_POST['unit_id']);
			
			
			
			$division_description = "";
			if( isset($_POST['division_description']) ){
				$division_description = test_inputs( $_POST['division_description'] );
			}
			
			
			
			$DivCount = 0;
			$qu_inv_03_divisions_sel = "SELECT COUNT(`division_id`) FROM  `inv_03_divisions`";
			$userStatement = mysqli_prepare($KONN,$qu_inv_03_divisions_sel);
			mysqli_stmt_execute($userStatement);
			$qu_inv_03_divisions_EXE = mysqli_stmt_get_result($userStatement);
			$inv_03_divisions_DATA;
			if(mysqli_num_rows($qu_inv_03_divisions_EXE)){
				$inv_03_divisions_DATA = mysqli_fetch_array($qu_inv_03_divisions_EXE);
				$DivCount = (int) $inv_03_divisions_DATA[0];
			}
			
			$DivClass = "";
			$DivZerol = "";
			$DivCount = $DivCount + 1;
			if( $DivCount < 10 ){
				$DivClass = "A";
				$DivZerol = "0";
				} else if( $DivCount >= 10 && $DivCount < 20 ){
				$DivClass = "B";
				$DivZerol = "";
				} else if( $DivCount >= 20 && $DivCount < 30 ){
				$DivClass = "C";
				$DivZerol = "";
				} else if( $DivCount >= 30 && $DivCount < 40 ){
				$DivClass = "D";
				$DivZerol = "";
				} else if( $DivCount >= 40 && $DivCount < 50 ){
				$DivClass = "E";
				$DivZerol = "";
				} else if( $DivCount >= 50 && $DivCount < 60 ){
				$DivClass = "F";
				$DivZerol = "";
				} else if( $DivCount >= 60 && $DivCount < 70 ){
				$DivClass = "G";
				$DivZerol = "";
				} else if( $DivCount >= 70 && $DivCount < 80 ){
				$DivClass = "H";
				$DivZerol = "";
				} else if( $DivCount >= 80 && $DivCount < 90 ){
				$DivClass = "I";
				$DivZerol = "";
				} else if( $DivCount >= 90 && $DivCount < 100 ){
				$DivClass = "J";
				$DivZerol = "";
				} else if( $DivCount >= 100 ){
				$DivClass = "KK";
				$DivZerol = "";
			}
			
			
			
			$division_code = "".$DivClass."".$DivZerol."".$DivCount.$section_id;
			
			//check code
			$qu_inv_03_divisions_sel = "SELECT * FROM  `inv_03_divisions` WHERE ((`division_name` = '$division_name') AND (`section_id` = $section_id))";
			$userStatement = mysqli_prepare($KONN,$qu_inv_03_divisions_sel);
			mysqli_stmt_execute($userStatement);
			$qu_inv_03_divisions_EXE = mysqli_stmt_get_result($userStatement);
			if( mysqli_num_rows($qu_inv_03_divisions_EXE) > 0 ){
				
					die( "0|division name already exist" );
				
			}
			
			
			//die("0|".$division_code);
			
			
			
			$qu_inv_03_divisions_ins = "INSERT INTO `inv_03_divisions` (
			`division_code`, 
			`division_name`, 
			`division_description`,  
			`section_id`, 
			`is_finished`, 
			`unit_id`
			) VALUES (
			'".$division_code."', 
			'".$division_name."', 
			'".$division_description."', 
			'".$section_id."', 
			'".$is_finished."', 
			'".$unit_id."' 
			);";
			$insertStatement = mysqli_prepare($KONN,$qu_inv_03_divisions_ins);
			mysqli_stmt_execute($insertStatement);
			$division_id = mysqli_insert_id($KONN);
			if( $division_id != 0 ){
				
				
				
				if( insert_state_change($KONN, "INV-Div-".$division_name, $division_id, "inv_03_divisions", $EMPLOYEE_ID) ) {
					die('1|Division Added');
					} else {
					die('0|Data Status Error 65154');
				}
				
				
				
				
				
				
				
			}
			
			
			
			
			
			} else {
			die('0|7wiu');
		}
	}
	catch(Exception $e){
		if ( is_resource($KONN)) {
			mysqli_close($KONN);
		}
	}
	finally{
		if ( is_resource($KONN)) {
			mysqli_close($KONN);
		}
	}
?>

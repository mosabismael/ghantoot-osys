<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	try{
		
		if( isset($_POST['subdivision_name']) && 
		isset($_POST['is_finished']) &&
		isset($_POST['unit_id']) &&
		isset($_POST['division_id']) 
		){
			
			
			$subdivision_id = 0;
			$subdivision_code = '99999999';
			$subdivision_name = test_inputs($_POST['subdivision_name']);
			$division_id = (int) test_inputs($_POST['division_id']);
			
			$is_finished = (int) test_inputs($_POST['is_finished']);
			$unit_id = (int) test_inputs($_POST['unit_id']);
			
			
			
			$subdivision_description = "";
			if( isset($_POST['subdivision_description']) ){
				$subdivision_description = test_inputs( $_POST['subdivision_description'] );
			}
			
			
			
			$DivCount = 0;
			$qu_inv_04_subdivisions_sel = "SELECT COUNT(`subdivision_id`) FROM  `inv_04_subdivisions`";
			$userStatement = mysqli_prepare($KONN,$qu_inv_04_subdivisions_sel);
			mysqli_stmt_execute($userStatement);
			$qu_inv_04_subdivisions_EXE = mysqli_stmt_get_result($userStatement);
			$inv_04_subdivisions_DATA;
			if(mysqli_num_rows($qu_inv_04_subdivisions_EXE)){
				$inv_04_subdivisions_DATA = mysqli_fetch_array($qu_inv_04_subdivisions_EXE);
				$DivCount = (int) $inv_04_subdivisions_DATA[0];
			}
			
			$DivClass = "";
			$DivZerol = "";
			$DivCount = $DivCount + 1;
			if( $DivCount < 10 ){
				$DivClass = "L";
				$DivZerol = "0";
				} else if( $DivCount >= 10 && $DivCount < 20 ){
				$DivClass = "M";
				$DivZerol = "";
				} else if( $DivCount >= 20 && $DivCount < 30 ){
				$DivClass = "N";
				$DivZerol = "";
				} else if( $DivCount >= 30 && $DivCount < 40 ){
				$DivClass = "O";
				$DivZerol = "";
				} else if( $DivCount >= 40 && $DivCount < 50 ){
				$DivClass = "P";
				$DivZerol = "";
				} else if( $DivCount >= 50 && $DivCount < 60 ){
				$DivClass = "Q";
				$DivZerol = "";
				} else if( $DivCount >= 60 && $DivCount < 70 ){
				$DivClass = "R";
				$DivZerol = "";
				} else if( $DivCount >= 70 && $DivCount < 80 ){
				$DivClass = "S";
				$DivZerol = "";
				} else if( $DivCount >= 80 && $DivCount < 90 ){
				$DivClass = "T";
				$DivZerol = "";
				} else if( $DivCount >= 90 && $DivCount < 100 ){
				$DivClass = "U";
				$DivZerol = "";
				} else if( $DivCount >= 100 ){
				$DivClass = "VV";
				$DivZerol = "";
			}
			
			
			
			$subdivision_code = "".$DivClass."".$DivZerol."".$DivCount;
			
			//check code
			$qu_inv_04_subdivisions_sel = "SELECT * FROM  `inv_04_subdivisions` WHERE ((`division_id` = '$division_id') AND (`subdivision_name` = '$subdivision_name'))";
			$userStatement = mysqli_prepare($KONN,$qu_inv_04_subdivisions_sel);
			mysqli_stmt_execute($userStatement);
			$qu_inv_04_subdivisions_EXE = mysqli_stmt_get_result($userStatement);
			if( mysqli_num_rows($qu_inv_04_subdivisions_EXE) > 0 ){
				die( "0|subdivision name already exist" );
			}
			
			
			// die("0|".$subdivision_code);
			
			
			
			$qu_inv_04_subdivisions_ins = "INSERT INTO `inv_04_subdivisions` (
			`subdivision_code`, 
			`subdivision_name`, 
			`subdivision_description`,  
			`division_id`, 
			`is_finished`, 
			`unit_id` 
			) VALUES (
			'".$subdivision_code."', 
			'".$subdivision_name."', 
			'".$subdivision_description."', 
			'".$division_id."', 
			'".$is_finished."', 
			'".$unit_id."' 
			);";
			$insertStatement = mysqli_prepare($KONN,$qu_inv_04_subdivisions_ins);
			mysqli_stmt_execute($insertStatement);
			$subdivision_id = mysqli_insert_id($KONN);
			if( $subdivision_id != 0 ){
				
				
				if( insert_state_change($KONN, "INV-subD-".$subdivision_name, $subdivision_id, "inv_04_subdivisions", $EMPLOYEE_ID) ) {
					die('1|Subdivision Added');
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

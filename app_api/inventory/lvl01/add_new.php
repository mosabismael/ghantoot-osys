<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	try{
		
		if( isset($_POST['family_icon']) &&
		isset($_POST['family_code']) &&
		isset($_POST['family_name']) 
		){
			
			
			$family_id = 0;
			$family_code = strtoupper( test_inputs($_POST['family_code']) );
			$family_icon = test_inputs($_POST['family_icon']);
			$family_name = test_inputs($_POST['family_name']);
			
			
			
			
			//check if Code exist
			$qu_inv_01_families_sel = "SELECT * FROM  `inv_01_families` WHERE `family_code` = '$family_code'";
			$userStatement = mysqli_prepare($KONN,$qu_inv_01_families_sel);
			mysqli_stmt_execute($userStatement);
			$qu_inv_01_families_EXE = mysqli_stmt_get_result($userStatement);
			$inv_01_families_DATA;
			if(mysqli_num_rows($qu_inv_01_families_EXE) > 0 ){
				die("0|Family Code Already Defined");
			}
			
			
			
			
			$qu_inv_01_families_sel = "SELECT * FROM  `inv_01_families` WHERE `family_name` = '$family_name'";
			$userStatement = mysqli_prepare($KONN,$qu_inv_01_families_sel);
			mysqli_stmt_execute($userStatement);
			$qu_inv_01_families_EXE = mysqli_stmt_get_result($userStatement);
			$inv_01_families_DATA;
			if(mysqli_num_rows($qu_inv_01_families_EXE) > 0 ){
				die("0|Family Name Already Defined");
			}
			
			
			
			
			
			
			
			
			
			$family_description = "";
			if( isset($_POST['family_description']) ){
				$family_description = test_inputs( $_POST['family_description'] );
			}
			
			$qu_inv_01_families_ins = "INSERT INTO `inv_01_families` (
			`family_code`, 
			`family_name`, 
			`family_icon`, 
			`family_description` 
			) VALUES (
			'".$family_code."', 
			'".$family_name."', 
			'".$family_icon."', 
			'".$family_description."' 
			);";
			$insertStatement = mysqli_prepare($KONN,$qu_inv_01_families_ins);
			mysqli_stmt_execute($insertStatement);
			$family_id = mysqli_insert_id($KONN);
			if( $family_id != 0 ){
				
				if( insert_state_change($KONN, "INV-Fact-".$family_name, $family_id, "inv_01_families", $EMPLOYEE_ID) ) {
					die('1|Family Added');
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

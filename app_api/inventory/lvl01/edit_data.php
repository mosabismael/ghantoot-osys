<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	try{
		if( isset($_POST['family_id']) &&
		isset($_POST['family_code']) &&
		isset($_POST['family_name']) &&
		isset($_POST['family_icon']) &&
		isset($_POST['family_description']) 
		){
			
			
			
			$family_id = test_inputs($_POST['family_id']);
			$family_code = strtoupper( test_inputs($_POST['family_code']) );
			$family_name = test_inputs($_POST['family_name']);
			$family_icon = test_inputs($_POST['family_icon']);
			
			
			$family_description = "";
			if( isset($_POST['family_description']) ){
				$family_description = test_inputs( $_POST['family_description'] );
			}
			
			$qu_inv_01_families_updt = "UPDATE  `inv_01_families` SET 
			`family_code` = '".$family_code."', 
			`family_name` = '".$family_name."', 
			`family_icon` = '".$family_icon."', 
			`family_description` = '".$family_description."'
			WHERE `family_id` = $family_id;";
			$updateStatement = mysqli_prepare($KONN,$qu_inv_01_families_updt);
			mysqli_stmt_execute($updateStatement);
			
			if( $family_id != 0 ){
				if( insert_state_change($KONN, "INV-Fact-Edit".$family_name, $family_id, "inv_01_families", $EMPLOYEE_ID) ) {
					die('1|Family Edited');
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

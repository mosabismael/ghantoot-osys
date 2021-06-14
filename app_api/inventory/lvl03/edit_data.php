<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		
		if( isset($_POST['division_id']) && 
		isset($_POST['is_finished']) && 
		isset($_POST['unit_id']) && 
		isset($_POST['division_name']) 
		){
			
			
			
			$division_id = test_inputs($_POST['division_id']);
			$division_name = test_inputs($_POST['division_name']);
			
			$is_finished = (int) test_inputs($_POST['is_finished']);
			$unit_id = (int) test_inputs($_POST['unit_id']);
			
			
			$division_description = "";
			if( isset($_POST['division_description']) ){
				$division_description = test_inputs( $_POST['division_description'] );
			}
			
			$qu_inv_03_divisions_updt = "UPDATE  `inv_03_divisions` SET 
			`is_finished` = '".$is_finished."', 
			`unit_id` = '".$unit_id."', 
			`division_name` = '".$division_name."', 
			`division_description` = '".$division_description."' 
			WHERE `division_id` = $division_id;";
			$updateStatement = mysqli_prepare($KONN,$qu_inv_03_divisions_updt);
			mysqli_stmt_execute($updateStatement);
			
			if( $division_id != 0 ){
				
				if( insert_state_change($KONN, "INV-Div-E-".$division_name, $division_id, "inv_03_divisions", $EMPLOYEE_ID) ) {
					die('1|Data Updated');
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

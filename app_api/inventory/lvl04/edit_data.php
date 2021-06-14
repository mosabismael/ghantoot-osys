<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	try{
		if( isset($_POST['subdivision_id']) && 
		isset($_POST['is_finished']) && 
		isset($_POST['unit_id']) && 
		isset($_POST['subdivision_name']) 
		){
			
			
			
			$subdivision_id = test_inputs($_POST['subdivision_id']);
			$subdivision_name = test_inputs($_POST['subdivision_name']);
			
			$is_finished = (int) test_inputs($_POST['is_finished']);
			$unit_id = (int) test_inputs($_POST['unit_id']);
			
			
			$subdivision_description = "";
			if( isset($_POST['subdivision_description']) ){
				$subdivision_description = test_inputs( $_POST['subdivision_description'] );
			}
			
			$qu_inv_04_subdivisions_updt = "UPDATE  `inv_04_subdivisions` SET 
			`is_finished` = '".$is_finished."', 
			`unit_id` = '".$unit_id."', 
			`subdivision_name` = '".$subdivision_name."', 
			`subdivision_description` = '".$subdivision_description."' 
			WHERE `subdivision_id` = $subdivision_id;";
			$updateStatement = mysqli_prepare($KONN,$qu_inv_04_subdivisions_updt);
			mysqli_stmt_execute($updateStatement);
			
			if( $subdivision_id != 0 ){
				if( insert_state_change($KONN, "INV-subD-E-".$subdivision_name, $subdivision_id, "inv_04_subdivisions", $EMPLOYEE_ID) ) {
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

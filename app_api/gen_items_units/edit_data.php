<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		if( isset($_POST['unit_name']) &&
		isset($_POST['unit_id']) ){
			
			
			
			$unit_id     = 0;
			$unit_name   = test_inputs($_POST['unit_name']);
			$unit_id     = test_inputs($_POST['unit_id']);
			
			
			
			$qu_gen_items_units_updt = "UPDATE  `gen_items_units` SET `unit_name` = '".$unit_name."' WHERE `unit_id` = $unit_id;";
			$updateStatement = mysqli_prepare($KONN,$qu_gen_items_units_updt);
			mysqli_stmt_execute($updateStatement);
			if( $unit_id != 0 ){
				
				
				if( insert_state_change($KONN, "Data Edited", $unit_id, "gen_items_units", $EMPLOYEE_ID) ) {
					die("1|Unit Edited");
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

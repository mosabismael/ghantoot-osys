<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		if( isset($_POST['disp_action_id']) &&
		isset($_POST['disp_action_code']) &&
		isset($_POST['disp_action_text']) 
		){
			
			
			
			$disp_action_id = test_inputs($_POST['disp_action_id']);
			$disp_action_code = test_inputs($_POST['disp_action_code']);
			$disp_action_text = test_inputs($_POST['disp_action_text']);
			
			$qu_hr_disp_actions_updt = "UPDATE  `hr_disp_actions` SET 
			`disp_action_code` = '".$disp_action_code."', 
			`disp_action_text` = '".$disp_action_text."' WHERE `disp_action_id` = $disp_action_id;";
			$updateStatement = mysqli_prepare($KONN,$qu_hr_disp_actions_updt);
			mysqli_stmt_execute($updateStatement);
			
			if( $disp_action_id != 0 ){
				
				
				if( insert_state_change($KONN, "Action Edited", $disp_action_id, "hr_disp_actions", $EMPLOYEE_ID) ) {
					die("1|Action Edited");
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

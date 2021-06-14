<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		if( isset($_POST['disp_action_code']) &&
		isset($_POST['disp_action_text']) 
		){
			
			$disp_action_id = 0;
			$disp_action_code = test_inputs($_POST['disp_action_code']);
			$disp_action_text = test_inputs($_POST['disp_action_text']);
			
			$qu_hr_disp_actions_ins = "INSERT INTO `hr_disp_actions` (
			`disp_action_code`, 
			`disp_action_text` 
			) VALUES (
			'".$disp_action_code."', 
			'".$disp_action_text."' 
			);";
			$insertStatement = mysqli_prepare($KONN,$qu_hr_disp_actions_ins);
			
			mysqli_stmt_execute($insertStatement);
			
			$disp_action_id = mysqli_insert_id($KONN);
			if( $disp_action_id != 0 ){
				
				
				if( insert_state_change($KONN, 'add-new', $disp_action_id, "hr_disp_actions", $EMPLOYEE_ID) ) {
					die("1|Action Added");
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

<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		
		if( isset($_POST['process_id']) ){
			
			
			$process_id = ( int ) test_inputs($_POST['process_id']);
			$job_order_id = 0;
			
			//get item data
			$actionChange = "DEL_Process";
			
			//check if there is any activities
			$qu_job_orders_processes_acts_sel = "SELECT * FROM  `job_orders_processes_acts` WHERE `process_id` = $process_id";
			$userStatement = mysqli_prepare($KONN,$qu_job_orders_processes_acts_sel);
			mysqli_stmt_execute($userStatement);
			$qu_job_orders_processes_acts_EXE = mysqli_stmt_get_result($userStatement);
			$job_orders_processes_acts_DATA;
			if(mysqli_num_rows($qu_job_orders_processes_acts_EXE) >= 1 ){
				die('0|Process is Filled');
			}
			
			
			//LOAD Process DATA
			$qu_job_orders_processes_sel = "SELECT `job_order_id` FROM  `job_orders_processes` WHERE `process_id` = $process_id";
			$userStatement = mysqli_prepare($KONN,$qu_job_orders_processes_acts_sel);
			mysqli_stmt_execute($userStatement);
			$qu_job_orders_processes_acts_EXE = mysqli_stmt_get_result($userStatement);
			$job_orders_processes_DATA;
			if(mysqli_num_rows($qu_job_orders_processes_EXE)){
				$job_orders_processes_DATA = mysqli_fetch_assoc($qu_job_orders_processes_EXE);
			}
			
			$job_order_id = ( int ) $job_orders_processes_DATA['job_order_id'];
			
			
			
			
			$qu_job_orders_processes_del = "DELETE FROM `job_orders_processes` WHERE `process_id` = $process_id";
			$deleteStatement = mysqli_prepare($KONN,$qu_job_orders_processes_del);
			
			mysqli_stmt_execute($deleteStatement);
			
			$current_state_id = get_current_state_id($KONN, $job_order_id, 'job_orders' );
			if( $current_state_id != 0 ){
				if( insert_state_change_dep($KONN, $actionChange."-".$process_id, $process_id, "process_deleted", 'job_orders_processes', $EMPLOYEE_ID, $current_state_id) ){
					die('1|Process Deleted');
					} else {
					die('0|Component State Error 01');
				}
				} else {
				die('0|Component State Error 02');
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

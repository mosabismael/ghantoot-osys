<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	try{
		if( isset($_POST['process_name']) && 
		isset($_POST['job_order_id']) 
		){
			
			$process_id = 0;
			$process_name = test_inputs($_POST['process_name']);
			$job_order_id = test_inputs($_POST['job_order_id']);
			
			$qu_job_orders_divisions_ins = "INSERT INTO `job_orders_processes` (
			`process_name`, 
			`job_order_id` 
			) VALUES (
			'".$process_name."', 
			'".$job_order_id."' 
			);";
			$insertStatement = mysqli_prepare($KONN,$qu_job_orders_divisions_ins);
			mysqli_stmt_execute($insertStatement);
			$process_id = mysqli_insert_id($KONN);
			if( $process_id != 0 ){
				
				
				$current_state_id = get_current_state_id($KONN, $job_order_id, 'job_orders' );
				if( $current_state_id != 0 ) {
					if( insert_state_change_dep($KONN, "New_Process", $process_id, $process_name, 'job_orders_processes', $EMPLOYEE_ID, $current_state_id) ) {
						//insert codes for division END
						die('1|Component Added');
						} else {
						die('0|Component State Error 01');
					}
					} else {
					die('0|Component State Error 02');
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

<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	try{
		if( isset($_POST['job_order_id']) && 
		isset($_POST['ts_date']) && 
		isset($_POST['ts_serial']) && 
		isset($_POST['machine_ids']) && 
		isset($_POST['date_froms']) && 
		isset($_POST['time_froms']) && 
		isset($_POST['date_tos']) && 
		isset($_POST['time_tos']) && 
		isset($_POST['total_times']) && 
		isset($_POST['task_ids'])  
		){
			
			$timesheet_id = 0;
			$job_order_id = test_inputs($_POST['job_order_id']);
			$project_id = 0;
			$ts_date = test_inputs($_POST['ts_date']);
			$ts_serial = test_inputs($_POST['ts_serial']);
			$created_date = date('Y-m-d H:i:00');
			$created_by = $EMPLOYEE_ID;
			
			
			
			
			$machine_ids   = $_POST['machine_ids'];
			$date_froms     = $_POST['date_froms'];
			$time_froms     = $_POST['time_froms'];
			$date_tos       = $_POST['date_tos'];
			$time_tos       = $_POST['time_tos'];
			$total_times    = $_POST['total_times'];
			$task_ids       = $_POST['task_ids'];
			
			
			
			
			
			$qu_job_orders_timesheets_machines_ins = "INSERT INTO `job_orders_timesheets_machines` (
			`job_order_id`, 
			`ts_date`, 
			`ts_serial`, 
			`created_date`, 
			`created_by` 
			) VALUES (
			'".$job_order_id."', 
			'".$ts_date."', 
			'".$ts_serial."', 
			'".$created_date."', 
			'".$created_by."' 
			);";
			$insertStatement = mysqli_prepare($KONN,$qu_job_orders_timesheets_machines_ins);
			mysqli_stmt_execute($insertStatement);
			$timesheet_id = mysqli_insert_id($KONN);
			if( $timesheet_id != 0 ){
				
				//INSERT RECORDS
				
				for( $E =0; $E < count( $machine_ids ) ; $E++ ){
					
					$record_id = 0;
					$machine_id    = test_inputs( $machine_ids[$E] );
					$date_from     = test_inputs( $date_froms[$E] );
					$time_from     = test_inputs( $time_froms[$E] );
					$date_to       = test_inputs( $date_tos[$E] );
					$time_to       = test_inputs( $time_tos[$E] );
					$total_time    = test_inputs( $total_times[$E] );
					$task_id       = test_inputs( $task_ids[$E] );
					
					$qu_job_orders_timesheets_machines_recs_ins = "INSERT INTO `job_orders_timesheets_machines_recs` (
					`machine_id`, 
					`date_from`, 
					`time_from`, 
					`date_to`, 
					`time_to`, 
					`total_time`, 
					`task_id`, 
					`timesheet_id` 
					) VALUES (
					'".$machine_id."', 
					'".$date_from."', 
					'".$time_from."', 
					'".$date_to."', 
					'".$time_to."', 
					'".$total_time."', 
					'".$task_id."', 
					'".$timesheet_id."' 
					);";
					$insertStatement = mysqli_prepare($KONN,$qu_job_orders_timesheets_machines_recs_ins);
					mysqli_stmt_execute($insertStatement);
					die( '0|ERR_65454' );
					
					
					
					
					
					
				} //END OF FOR LOOP
				
				
				die("1|machines_timesheets.php?added=1");
				
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

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
		isset($_POST['employee_ids']) &&
		isset($_POST['date_froms']) &&
		isset($_POST['time_froms']) &&
		isset($_POST['date_tos']) &&
		isset($_POST['time_tos']) &&
		isset($_POST['regular_times']) &&
		isset($_POST['ot_times']) &&
		isset($_POST['total_times']) &&
		isset($_POST['task_ids'])  
		){
			
			$timesheet_id = 0;
			$job_order_id = test_inputs($_POST['job_order_id']);
			$ts_date = test_inputs($_POST['ts_date']);
			$ts_serial = test_inputs($_POST['ts_serial']);
			$created_date = date('Y-m-d H:i:00');
			$created_by = $EMPLOYEE_ID;
			
			
			
			
			$employee_ids   = $_POST['employee_ids'];
			$date_froms     = $_POST['date_froms'];
			$time_froms     = $_POST['time_froms'];
			$date_tos       = $_POST['date_tos'];
			$time_tos       = $_POST['time_tos'];
			$regular_times  = $_POST['regular_times'];
			$ot_times       = $_POST['ot_times'];
			$total_times    = $_POST['total_times'];
			$task_ids       = $_POST['task_ids'];
			
			
			
			$qu_job_orders_timesheets_sel = "SELECT `timesheet_id` FROM  `job_orders_timesheets` WHERE `ts_serial` = '$ts_serial'";
			$userStatement = mysqli_prepare($KONN,$qu_job_orders_timesheets_sel);
			mysqli_stmt_execute($userStatement);
			$qu_job_orders_timesheets_EXE = mysqli_stmt_get_result($userStatement);
			$job_orders_timesheets_DATA;
			if( mysqli_num_rows($qu_job_orders_timesheets_EXE) > 0 ){
				die( '0|Timesheet Serial Duplicate' );
			}
			
			
			$qu_job_orders_timesheets_ins = "INSERT INTO `job_orders_timesheets` (
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
			$insertStatement = mysqli_prepare($KONN,$qu_job_orders_timesheets_ins);
			mysqli_stmt_execute($insertStatement);
			$timesheet_id = mysqli_insert_id($KONN);
			if( $timesheet_id != 0 ){
				
				//INSERT RECORDS
				
				for( $E =0; $E < count( $employee_ids ) ; $E++ ){
					
					$record_id = 0;
					$employee_id   = test_inputs( $employee_ids[$E] );
					$date_from     = test_inputs( $date_froms[$E] );
					$time_from     = test_inputs( $time_froms[$E] );
					$date_to       = test_inputs( $date_tos[$E] );
					$time_to       = test_inputs( $time_tos[$E] );
					$regular_time  = test_inputs( $regular_times[$E] );
					$ot_time       = test_inputs( $ot_times[$E] );
					$total_time    = test_inputs( $total_times[$E] );
					$task_id       = test_inputs( $task_ids[$E] );
					
					//add 1 minute
					$t_from_compare = "";
					$t_fromARR = explode(":", $time_from);
					
					$cm = (int) $t_fromARR[1];
					$cm = $cm + 1;
					$t_from_compare = $t_fromARR[0].":".$cm;
					
					
					
					//get is local value $employee_id
	$is_local = 0;
	$qu_hr_employees_sel = "SELECT `employee_type` FROM  `hr_employees` WHERE `employee_id` = $employee_id";
	$qu_hr_employees_EXE = mysqli_query($KONN, $qu_hr_employees_sel);
	$hr_employees_DATA;
	if(mysqli_num_rows($qu_hr_employees_EXE)){
		$hr_employees_DATA = mysqli_fetch_assoc($qu_hr_employees_EXE);
		$employee_type = $hr_employees_DATA['employee_type'];
		if( $employee_type == 'local' ){
			$is_local = 1;
		}
	}

					
					
					
					
					
					
					
					//check for overlap time
					$qu_job_orders_timesheets_recs_sel = "SELECT * FROM `job_orders_timesheets_recs` WHERE 
					((`date_from` = '$date_from') AND 
					(`date_to` = '$date_to') AND 
					(`time_from` <= '$time_to') AND 
					(`time_to` >= '$t_from_compare') AND 
					(`employee_id` = '$employee_id'))";
					$userStatement = mysqli_prepare($KONN,$qu_job_orders_timesheets_recs_sel);
					mysqli_stmt_execute($userStatement);
					$qu_job_orders_timesheets_recs_EXE = mysqli_stmt_get_result($userStatement);
					$job_orders_timesheets_recs_DATA;
					if(mysqli_num_rows($qu_job_orders_timesheets_recs_EXE)){
						$job_orders_timesheets_recs_DATA = mysqli_fetch_assoc($qu_job_orders_timesheets_recs_EXE);
						$record_id = $job_orders_timesheets_recs_DATA['record_id'];
						
						$qu_hr_employees_sel = "SELECT `employee_code` FROM  `hr_employees` WHERE `employee_id` = $employee_id";
						$userStatement = mysqli_prepare($KONN,$qu_hr_employees_sel);
						mysqli_stmt_execute($userStatement);
						$qu_hr_employees_EXE = mysqli_stmt_get_result($userStatement);
						$emp_code = "NA";
						if(mysqli_num_rows($qu_hr_employees_EXE)){
							$hr_employees_DATA = mysqli_fetch_assoc($qu_hr_employees_EXE);
							$emp_code = $hr_employees_DATA['employee_code'];
						}
						
						//delete inserted timesheet_id
						$qu_job_orders_timesheets_del = "DELETE FROM `job_orders_timesheets` WHERE `timesheet_id` = $timesheet_id";
						$deleteStatement = mysqli_prepare($KONN,$qu_job_orders_timesheets_del);
						
						mysqli_stmt_execute($deleteStatement);
						
						
						
						//give false feedback
						die("0|Time Overlap For Employee NO : ".$emp_code);
						
						
						} else {
						$qu_job_orders_timesheets_recs_ins = "INSERT INTO `job_orders_timesheets_recs` (
						`employee_id`, 
						`date_from`, 
						`time_from`, 
						`date_to`, 
						`time_to`, 
						`regular_time`, 
						`ot_time`, 
						`total_time`, 
						`task_id`, 
						`timesheet_id`, 
						`job_order_id`, 
						`is_local` 
						) VALUES (
						'".$employee_id."', 
						'".$date_from."', 
						'".$time_from."', 
						'".$date_to."', 
						'".$time_to."', 
						'".$regular_time."', 
						'".$ot_time."', 
						'".$total_time."', 
						'".$task_id."', 
						'".$timesheet_id."', 
						'".$job_order_id."', 
						'".$is_local."' 
						);";
						$insertStatement = mysqli_prepare($KONN,$qu_job_orders_timesheets_recs_ins);
						mysqli_stmt_execute($insertStatement);
						
					}	
					
				} //END OF FOR LOOP
				
				
				die("1|labours_timesheets.php?added=1");
				
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

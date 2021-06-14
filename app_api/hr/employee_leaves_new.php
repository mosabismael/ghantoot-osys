<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	try{
		if( isset($_POST['leave_date']) &&
		isset($_POST['start_time']) &&
		isset($_POST['start_date']) &&
		isset($_POST['end_date']) &&
		isset($_POST['end_time']) &&
		isset($_POST['leave_type_id']) &&
		isset($_POST['total_days']) &&
		isset($_POST['leave_status']) &&
		isset($_POST['memo']) &&
		isset($_POST['is_deducted']) && 
		isset($_POST['employee_id']) 
		){
			
			$leave_id = 0;
			$leave_date = test_inputs($_POST['leave_date']);
			
			$start_time = test_inputs($_POST['start_time']);
			$start_date = test_inputs($_POST['start_date']);
			$start_date = $start_date.' '.$start_time.':00';
			
			$end_time = test_inputs($_POST['end_time']);
			$end_date = test_inputs($_POST['end_date']);
			$end_date = $end_date.' '.$end_time.':00';
			
			
			$leave_type_id = test_inputs($_POST['leave_type_id']);
			$total_days = test_inputs($_POST['total_days']);
			$leave_status = test_inputs($_POST['leave_status']);
			$memo = test_inputs($_POST['memo']);
			$is_deducted = test_inputs($_POST['is_deducted']);
			$employee_id = test_inputs($_POST['employee_id']);
			
			
			$qu_hr_employees_leaves_ins = "INSERT INTO `hr_employees_leaves` (
			`leave_date`, 
			`start_date`, 
			`end_date`, 
			`leave_type_id`, 
			`total_days`, 
			`leave_status`, 
			`memo`, 
			`is_deducted`, 
			`employee_id` 
			) VALUES (
			'".$leave_date."', 
			'".$start_date."', 
			'".$end_date."', 
			'".$leave_type_id."', 
			'".$total_days."', 
			'".$leave_status."', 
			'".$memo."', 
			'".$is_deducted."', 
			'".$employee_id."' 
			);";
			
			$insertStatement = mysqli_prepare($KONN,$qu_hr_employees_leaves_ins);
			
			mysqli_stmt_execute($insertStatement);
			
			$leave_id = mysqli_insert_id($KONN);
			if( $leave_id != 0 ){
				
				if( insert_state_change($KONN, 'leave_added', $leave_id, "hr_employees_leaves", $EMPLOYEE_ID) ){
					die("1|Data Added");
				}
			}
			
			} else {
			die('0|noReq');
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

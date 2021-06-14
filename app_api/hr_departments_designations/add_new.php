<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		if( isset($_POST['designation_name']) &&
		isset($_POST['department_id']) &&
		isset($_POST['job_description']) 
		){
			
			$designation_id = 0;
			$designation_name = test_inputs($_POST['designation_name']);
			$job_description = test_inputs($_POST['job_description']);
			$department_id = ( int ) test_inputs($_POST['department_id']);
			
			$qu_hr_departments_designations_ins = "INSERT INTO `hr_departments_designations` (
			`designation_name`, 
			`job_description`, 
			`department_id` 
			) VALUES (
			'".$designation_name."', 
			'".$job_description."', 
			'".$department_id."' 
			);";
			$insertStatement = mysqli_prepare($KONN,$qu_hr_departments_designations_ins);
			
			mysqli_stmt_execute($insertStatement);
			
			$designation_id = mysqli_insert_id($KONN);
			if( $designation_id != 0 ){
				
				if( insert_state_change($KONN, 'add-new', $designation_id, "hr_departments_designations", $EMPLOYEE_ID) ) {
					die("1|Designation Added");
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

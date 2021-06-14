<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		if( isset($_POST['department_id']) &&
		isset($_POST['department_name']) &&
		isset($_POST['department_description']) 
		){
			
			
			$department_id = test_inputs($_POST['department_id']);
			$department_name = test_inputs($_POST['department_name']);
			$department_description = test_inputs($_POST['department_description']);
			
			$qu_hr_departments_updt = "UPDATE  `hr_departments` SET 
			`department_name` = '".$department_name."', 
			`department_description` = '".$department_description."' 
			WHERE `department_id` = $department_id;";
			$updateStatement = mysqli_prepare($KONN,$qu_hr_departments_updt);
			mysqli_stmt_execute($updateStatement);
			
			if( $department_id != 0 ){
				
				if( insert_state_change($KONN, "Department Edited", $department_id, "hr_departments", $EMPLOYEE_ID) ) {
					die("1|Department Edited");
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

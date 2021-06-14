<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		if( isset($_POST['employee_id']) &&
		isset($_POST['allowance_id']) &&
		isset($_POST['allowance_type']) &&
		isset($_POST['allowance_amount']) &&
		isset($_POST['active_from']) &&
		isset($_POST['active_to']) 
		){
			
			$record_id = 0;
			$employee_id = test_inputs($_POST['employee_id']);
			$allowance_id = test_inputs($_POST['allowance_id']);
			$allowance_type = test_inputs($_POST['allowance_type']);
			$allowance_amount = test_inputs($_POST['allowance_amount']);
			$active_from = test_inputs($_POST['active_from']);
			$active_to = test_inputs($_POST['active_to']);
			
			$qu_hr_employees_allowances_ins = "INSERT INTO `hr_employees_allowances` (
			`employee_id`, 
			`allowance_id`, 
			`allowance_type`, 
			`allowance_amount`, 
			`active_from`, 
			`active_to` 
			) VALUES (
			'".$employee_id."', 
			'".$allowance_id."', 
			'".$allowance_type."', 
			'".$allowance_amount."', 
			'".$active_from."', 
			'".$active_to."' 
			);";
			$insertStatement = mysqli_prepare($KONN,$qu_hr_employees_allowances_ins);
			
			mysqli_stmt_execute($insertStatement);
			
			$record_id = mysqli_insert_id($KONN);
			if( $record_id != 0 ){
				
				if( insert_state_change($KONN, 'allowance_added', $record_id, "hr_employees_allowances", $EMPLOYEE_ID) ){
					die("1|Data Added");
				}
				
				
				
				
				
			}
			
			
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

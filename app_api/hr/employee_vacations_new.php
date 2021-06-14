<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		if( isset($_POST['vacation_date']) && 
		isset($_POST['start_date']) &&
		isset($_POST['end_date']) && 
		isset($_POST['total_days']) &&
		isset($_POST['vacation_status']) &&
		isset($_POST['memo']) &&
		isset($_POST['is_passport_released']) && 
		isset($_POST['is_deducted']) && 
		isset($_POST['employee_id']) 
		){
			
			$vacation_id = 0;
			$vacation_date = test_inputs($_POST['vacation_date']);
			
			$start_date = test_inputs($_POST['start_date']);
			
			$end_date = test_inputs($_POST['end_date']);
			
			
			$total_days = test_inputs($_POST['total_days']);
			$vacation_status = test_inputs($_POST['vacation_status']);
			$memo = test_inputs($_POST['memo']);
			$is_passport_released = test_inputs($_POST['is_passport_released']);
			$is_deducted = test_inputs($_POST['is_deducted']);
			$employee_id = test_inputs($_POST['employee_id']);
			
			$qu_hr_employees_vacations_ins = "INSERT INTO `hr_employees_vacations` (
			`vacation_date`, 
			`start_date`, 
			`end_date`, 
			`total_days`, 
			`vacation_status`, 
			`memo`, 
			`is_passport_released`, 
			`is_deducted`, 
			`employee_id` 
			) VALUES (
			'".$vacation_date."', 
			'".$start_date."', 
			'".$end_date."', 
			'".$total_days."', 
			'".$vacation_status."', 
			'".$memo."', 
			'".$is_passport_released."', 
			'".$is_deducted."', 
			'".$employee_id."' 
			);";
			$insertStatement = mysqli_prepare($KONN,$qu_hr_employees_vacations_ins);
			
			mysqli_stmt_execute($insertStatement);
			
			$vacation_id = mysqli_insert_id($KONN);
			if( $vacation_id != 0 ){
				if( insert_state_change($KONN, 'vacation_added', $vacation_id, "hr_employees_vacations", $EMPLOYEE_ID) ){
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

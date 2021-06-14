<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		if( isset($_POST['employee_code']) &&
		isset($_POST['first_name']) &&
		isset($_POST['second_name']) &&
		isset($_POST['third_name']) &&
		isset($_POST['last_name']) &&
		isset($_POST['dob']) &&
		isset($_POST['mobile_personal']) &&
		isset($_POST['mobile_work']) &&
		isset($_POST['email_personal']) &&
		isset($_POST['email_work']) &&
		isset($_POST['gender']) &&
		isset($_POST['martial_status']) &&
		isset($_POST['certificate_id']) &&
		isset($_POST['graduation_date']) &&
		isset($_POST['join_date']) &&
		isset($_POST['nationality_id']) &&
		isset($_POST['leaves_total_annual']) &&
		isset($_POST['leaves_open_balance']) &&
		isset($_POST['basic_salary']) &&
		isset($_POST['bank_id']) &&
		isset($_POST['bank_account_no']) &&
		isset($_POST['iban_no']) &&
		isset($_POST['designation_id']) &&
		isset($_POST['department_id']) &&
		isset($_POST['employee_type']) && 
		isset($_POST['company_name']) && 
		isset($_POST['employee_address']) 
		){
			
			
			
			
			$employee_id = 0;
			$employee_code = test_inputs($_POST['employee_code']);
			$first_name = test_inputs($_POST['first_name']);
			$second_name = test_inputs($_POST['second_name']);
			$third_name = test_inputs($_POST['third_name']);
			$last_name = test_inputs($_POST['last_name']);
			
			$dob = test_inputs($_POST['dob']);
			$mobile_personal = test_inputs($_POST['mobile_personal']);
			$mobile_work = test_inputs($_POST['mobile_work']);
			$email_personal = test_inputs($_POST['email_personal']);
			$email_work = test_inputs($_POST['email_work']);
			$gender = test_inputs($_POST['gender']);
			$martial_status = test_inputs($_POST['martial_status']);
			$certificate_id = test_inputs($_POST['certificate_id']);
			$graduation_date = test_inputs($_POST['graduation_date']);
			$join_date = test_inputs($_POST['join_date']);
			$nationality_id = test_inputs($_POST['nationality_id']);
			$leaves_total_annual = test_inputs($_POST['leaves_total_annual']);
			$leaves_open_balance = test_inputs($_POST['leaves_open_balance']);
			$basic_salary = test_inputs($_POST['basic_salary']);
			$bank_id = test_inputs($_POST['bank_id']);
			$bank_account_no = test_inputs($_POST['bank_account_no']);
			$iban_no = test_inputs($_POST['iban_no']);
			$designation_id = test_inputs($_POST['designation_id']);
			$department_id = test_inputs($_POST['department_id']);
			$employee_address = test_inputs($_POST['employee_address']);
			
			$employee_type = test_inputs($_POST['employee_type']);
			$company_name = test_inputs($_POST['company_name']);
			
			$qu_hr_employees_ins = "INSERT INTO `hr_employees` (
			`employee_code`, 
			`first_name`, 
			`second_name`, 
			`third_name`, 
			`last_name`, 
			`dob`, 
			`mobile_personal`, 
			`mobile_work`, 
			`email_personal`, 
			`email_work`, 
			`gender`, 
			`martial_status`, 
			`certificate_id`, 
			`graduation_date`, 
			`join_date`, 
			`nationality_id`, 
			`leaves_total_annual`, 
			`leaves_open_balance`, 
			`basic_salary`, 
			`bank_id`, 
			`bank_account_no`, 
			`iban_no`, 
			`designation_id`, 
			`department_id`, 
			`employee_type`, 
			`company_name`, 
			`employee_address` 
			) VALUES (
			'".$employee_code."', 
			'".$first_name."', 
			'".$second_name."', 
			'".$third_name."', 
			'".$last_name."', 
			'".$dob."', 
			'".$mobile_personal."', 
			'".$mobile_work."', 
			'".$email_personal."', 
			'".$email_work."', 
			'".$gender."', 
			'".$martial_status."', 
			'".$certificate_id."', 
			'".$graduation_date."', 
			'".$join_date."', 
			'".$nationality_id."', 
			'".$leaves_total_annual."', 
			'".$leaves_open_balance."', 
			'".$basic_salary."', 
			'".$bank_id."', 
			'".$bank_account_no."', 
			'".$iban_no."', 
			'".$designation_id."', 
			'".$department_id."', 
			'".$employee_type."', 
			'".$company_name."', 
			'".$employee_address."' 
			);";
			$insertStatement = mysqli_prepare($KONN,$qu_hr_employees_ins);
			
			mysqli_stmt_execute($insertStatement);
			
			$employee_id = mysqli_insert_id($KONN);
			if( $employee_id != 0 ){
				die("1|Employee Added");
			}
			
			
			} else {
			die('0|no req');
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

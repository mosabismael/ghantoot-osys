<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	
	try{
		
		
		if(!isset($_POST['employee_id'])){
			die('7wiu');
		}
		
		$employee_id = (int) test_inputs( $_POST['employee_id'] );
		$return_arr;
		
		$q = "SELECT * FROM `hr_employees` WHERE `employee_id` = '".$employee_id."' ";
		$userStatement = mysqli_prepare($KONN,$q);
		mysqli_stmt_execute($userStatement);
		$q_exe = mysqli_stmt_get_result($userStatement);
		
		if(mysqli_num_rows($q_exe) == 0){
			$return_arr[] = array(  "employee_id" => 0,
			"first_name" => 'error factory name', 
			"employee_code" => 'error factory ref'
			);
			} else {
			$ARRAY_SRC = mysqli_fetch_assoc($q_exe);
			
			
			$return_arr[] = array(  "employee_id" => $ARRAY_SRC['employee_id'], 
			"employee_code" => $ARRAY_SRC['employee_code'], 
			"first_name" => $ARRAY_SRC['first_name'], 
			"second_name" => $ARRAY_SRC['second_name'], 
			"third_name" => $ARRAY_SRC['third_name'], 
			"last_name" => $ARRAY_SRC['last_name'], 
			"profile_pic" => $ARRAY_SRC['profile_pic'], 
			"dob" => $ARRAY_SRC['dob'], 
			"mobile_personal" => $ARRAY_SRC['mobile_personal'], 
			"mobile_work" => $ARRAY_SRC['mobile_work'], 
			"email_personal" => $ARRAY_SRC['email_personal'], 
			"email_work" => $ARRAY_SRC['email_work'], 
			"gender" => $ARRAY_SRC['gender'], 
			"martial_status" => $ARRAY_SRC['martial_status'], 
			"certificate_id" => $ARRAY_SRC['certificate_id'], 
			"graduation_date" => $ARRAY_SRC['graduation_date'], 
			"join_date" => $ARRAY_SRC['join_date'], 
			"nationality_id" => $ARRAY_SRC['nationality_id'], 
			"leaves_total_annual" => $ARRAY_SRC['leaves_total_annual'], 
			"leaves_open_balance" => $ARRAY_SRC['leaves_open_balance'], 
			"basic_salary" => $ARRAY_SRC['basic_salary'], 
			"bank_id" => $ARRAY_SRC['bank_id'], 
			"bank_account_no" => $ARRAY_SRC['bank_account_no'], 
			"iban_no" => $ARRAY_SRC['iban_no'], 
			"designation_id" => $ARRAY_SRC['designation_id'], 
			"department_id" => $ARRAY_SRC['department_id'], 
			"employee_status" => $ARRAY_SRC['employee_status'], 
			"employee_type" => $ARRAY_SRC['employee_type'], 
			"company_name" => $ARRAY_SRC['company_name'], 
			"employee_address" => $ARRAY_SRC['employee_address'] 
			);
			
		}
		
		
		echo json_encode($return_arr);
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

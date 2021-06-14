<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	
	try{
		
		if( isset($_POST['employee_id']) ){
			
			$employee_id = (int) test_inputs($_POST['employee_id']);
			$qqq = "";
			
			$employee_code = "";
			if( isset($_POST['employee_code']) ){
				$employee_code = test_inputs( $_POST['employee_code'] );
				$qqq = $qqq."`employee_code` = '".$employee_code."', ";
			}
			$first_name = "";
			if( isset($_POST['first_name']) ){
				$first_name = test_inputs( $_POST['first_name'] );
				$qqq = $qqq."`first_name` = '".$first_name."', ";
			}
			$second_name = "";
			if( isset($_POST['second_name']) ){
				$second_name = test_inputs( $_POST['second_name'] );
				$qqq = $qqq."`second_name` = '".$second_name."', ";
			}
			$third_name = "";
			if( isset($_POST['third_name']) ){
				$third_name = test_inputs( $_POST['third_name'] );
				$qqq = $qqq."`third_name` = '".$third_name."', ";
			}
			$last_name = "";
			if( isset($_POST['last_name']) ){
				$last_name = test_inputs( $_POST['last_name'] );
				$qqq = $qqq."`last_name` = '".$last_name."', ";
			}
			$profile_pic = "";
			if( isset($_POST['profile_pic']) ){
				$profile_pic = test_inputs( $_POST['profile_pic'] );
				$qqq = $qqq."`profile_pic` = '".$profile_pic."', ";
			}
			$dob = "";
			if( isset($_POST['dob']) ){
				$dob = test_inputs( $_POST['dob'] );
				$qqq = $qqq."`dob` = '".$dob."', ";
			}
			$mobile_personal = "";
			if( isset($_POST['mobile_personal']) ){
				$mobile_personal = test_inputs( $_POST['mobile_personal'] );
				$qqq = $qqq."`mobile_personal` = '".$mobile_personal."', ";
			}
			$mobile_work = "";
			if( isset($_POST['mobile_work']) ){
				$mobile_work = test_inputs( $_POST['mobile_work'] );
				$qqq = $qqq."`mobile_work` = '".$mobile_work."', ";
			}
			$email_personal = "";
			if( isset($_POST['email_personal']) ){
				$email_personal = test_inputs( $_POST['email_personal'] );
				$qqq = $qqq."`email_personal` = '".$email_personal."', ";
			}
			$email_work = "";
			if( isset($_POST['email_work']) ){
				$email_work = test_inputs( $_POST['email_work'] );
				$qqq = $qqq."`email_work` = '".$email_work."', ";
			}
			$gender = "";
			if( isset($_POST['gender']) ){
				$gender = test_inputs( $_POST['gender'] );
				$qqq = $qqq."`gender` = '".$gender."', ";
			}
			$martial_status = "";
			if( isset($_POST['martial_status']) ){
				$martial_status = test_inputs( $_POST['martial_status'] );
				$qqq = $qqq."`martial_status` = '".$martial_status."', ";
			}
			$certificate_id = "";
			if( isset($_POST['certificate_id']) ){
				$certificate_id = test_inputs( $_POST['certificate_id'] );
				$qqq = $qqq."`certificate_id` = '".$certificate_id."', ";
			}
			$graduation_date = "";
			if( isset($_POST['graduation_date']) ){
				$graduation_date = test_inputs( $_POST['graduation_date'] );
				$qqq = $qqq."`graduation_date` = '".$graduation_date."', ";
			}
			$join_date = "";
			if( isset($_POST['join_date']) ){
				$join_date = test_inputs( $_POST['join_date'] );
				$qqq = $qqq."`join_date` = '".$join_date."', ";
			}
			$nationality_id = "";
			if( isset($_POST['nationality_id']) ){
				$nationality_id = test_inputs( $_POST['nationality_id'] );
				$qqq = $qqq."`nationality_id` = '".$nationality_id."', ";
			}
			$leaves_total_annual = "";
			if( isset($_POST['leaves_total_annual']) ){
				$leaves_total_annual = test_inputs( $_POST['leaves_total_annual'] );
				$qqq = $qqq."`leaves_total_annual` = '".$leaves_total_annual."', ";
			}
			$leaves_open_balance = "";
			if( isset($_POST['leaves_open_balance']) ){
				$leaves_open_balance = test_inputs( $_POST['leaves_open_balance'] );
				$qqq = $qqq."`leaves_open_balance` = '".$leaves_open_balance."', ";
			}
			$basic_salary = "";
			if( isset($_POST['basic_salary']) ){
				$basic_salary = test_inputs( $_POST['basic_salary'] );
				$qqq = $qqq."`basic_salary` = '".$basic_salary."', ";
			}
			$bank_id = "";
			if( isset($_POST['bank_id']) ){
				$bank_id = test_inputs( $_POST['bank_id'] );
				$qqq = $qqq."`bank_id` = '".$bank_id."', ";
			}
			$bank_account_no = "";
			if( isset($_POST['bank_account_no']) ){
				$bank_account_no = test_inputs( $_POST['bank_account_no'] );
				$qqq = $qqq."`bank_account_no` = '".$bank_account_no."', ";
			}
			$iban_no = "";
			if( isset($_POST['iban_no']) ){
				$iban_no = test_inputs( $_POST['iban_no'] );
				$qqq = $qqq."`iban_no` = '".$iban_no."', ";
			}
			$designation_id = "";
			if( isset($_POST['designation_id']) ){
				$designation_id = test_inputs( $_POST['designation_id'] );
				$qqq = $qqq."`designation_id` = '".$designation_id."', ";
			}
			$department_id = "";
			if( isset($_POST['department_id']) ){
				$department_id = test_inputs( $_POST['department_id'] );
				$qqq = $qqq."`department_id` = '".$department_id."', ";
			}
			$employee_address = "";
			if( isset($_POST['employee_address']) ){
				$employee_address = test_inputs( $_POST['employee_address'] );
				$qqq = $qqq."`employee_address` = '".$employee_address."', ";
			}
			
			$employee_status = "";
			if( isset($_POST['employee_status']) ){
				$employee_status = test_inputs( $_POST['employee_status'] );
				$qqq = $qqq."`employee_status` = '".$employee_status."', ";
			}
			
			$employee_type = "";
			if( isset($_POST['employee_type']) ){
				$employee_type = test_inputs( $_POST['employee_type'] );
				$qqq = $qqq."`employee_type` = '".$employee_type."', ";
			}
			
			$company_name = "";
			if( isset($_POST['company_name']) ){
				$company_name = test_inputs( $_POST['company_name'] );
				$qqq = $qqq."`company_name` = '".$company_name."', ";
			}
			
			if( $qqq != "" ){
				$qqq =  substr($qqq, 0, -2);
				$qu_hr_employees_updt = "UPDATE  `hr_employees` SET ".$qqq."  WHERE `employee_id` = $employee_id;";
				$updateStatement = mysqli_prepare($KONN,$qu_hr_employees_updt);
				mysqli_stmt_execute($updateStatement);
				// $IAM_ARRAY[] = array( "result" => "1" );
				die('1|DATA Updated');
				
				} else {
				// $IAM_ARRAY[] = array( "result" => "ERR-NO REQUEST DATA" );
				die('0|ERR-NO REQUEST DATA');
			}
			
			} else {
			die('0|7wiu');
		}
		
		// echo json_encode($IAM_ARRAY);
		die();
		
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

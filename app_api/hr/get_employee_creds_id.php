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
		
		$q = "SELECT * FROM `hr_employees_creds` WHERE `employee_id` = '".$employee_id."' ";
		$userStatement = mysqli_prepare($KONN,$q);
		mysqli_stmt_execute($userStatement);
		$q_exe = mysqli_stmt_get_result($userStatement);
		
		if(mysqli_num_rows($q_exe) == 0){
			
			
			
			//insert empty record
			
			
			
			
			$return_arr[] = array(  "employee_credential_id" => 0, 
			"passport_issue_date" => 0, 
			"passport_expiry_date" => 0, 
			"passport_no" => 0, 
			"visa_issue_date" => 0, 
			"visa_expiry_date" => 0, 
			"visa_no" => 0, 
			"eid_issue_date" => 0, 
			"eid_expiry_date" => 0, 
			"eid_no" => 0, 
			"eid_card_no" => 0, 
			"labour_issue_date" => 0, 
			"labour_expiry_date" => 0, 
			"labour_no" => 0, 
			"license_issue_date" => 0, 
			"license_expiry_date" => 0, 
			"license_no" => 0, 
			"civil_id" => 0, 
			"employee_id" => $employee_id
			);
			} else {
			$ARRAY_SRC = mysqli_fetch_assoc($q_exe);
			
			
			$return_arr[] = array(  "employee_credential_id" => $ARRAY_SRC['employee_credential_id'], 
			"passport_issue_date" => $ARRAY_SRC['passport_issue_date'], 
			"passport_expiry_date" => $ARRAY_SRC['passport_expiry_date'], 
			"passport_no" => $ARRAY_SRC['passport_no'], 
			"visa_issue_date" => $ARRAY_SRC['visa_issue_date'], 
			"visa_expiry_date" => $ARRAY_SRC['visa_expiry_date'], 
			"visa_no" => $ARRAY_SRC['visa_no'], 
			"eid_issue_date" => $ARRAY_SRC['eid_issue_date'], 
			"eid_expiry_date" => $ARRAY_SRC['eid_expiry_date'], 
			"eid_no" => $ARRAY_SRC['eid_no'], 
			"eid_card_no" => $ARRAY_SRC['eid_card_no'], 
			"labour_issue_date" => $ARRAY_SRC['labour_issue_date'], 
			"labour_expiry_date" => $ARRAY_SRC['labour_expiry_date'], 
			"labour_no" => $ARRAY_SRC['labour_no'], 
			"license_issue_date" => $ARRAY_SRC['license_issue_date'], 
			"license_expiry_date" => $ARRAY_SRC['license_expiry_date'], 
			"license_no" => $ARRAY_SRC['license_no'], 
			"civil_id" => $ARRAY_SRC['civil_id'], 
			"employee_id" => $ARRAY_SRC['employee_id'] 
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

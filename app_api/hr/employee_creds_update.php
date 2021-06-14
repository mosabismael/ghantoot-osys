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
			
			$passport_issue_date = "";
			if( isset($_POST['passport_issue_date']) ){
				$passport_issue_date = test_inputs( $_POST['passport_issue_date'] );
				$qqq = $qqq."`passport_issue_date` = '".$passport_issue_date."', ";
			}
			$passport_expiry_date = "";
			if( isset($_POST['passport_expiry_date']) ){
				$passport_expiry_date = test_inputs( $_POST['passport_expiry_date'] );
				$qqq = $qqq."`passport_expiry_date` = '".$passport_expiry_date."', ";
			}
			$passport_no = "";
			if( isset($_POST['passport_no']) ){
				$passport_no = test_inputs( $_POST['passport_no'] );
				$qqq = $qqq."`passport_no` = '".$passport_no."', ";
			}
			$visa_issue_date = "";
			if( isset($_POST['visa_issue_date']) ){
				$visa_issue_date = test_inputs( $_POST['visa_issue_date'] );
				$qqq = $qqq."`visa_issue_date` = '".$visa_issue_date."', ";
			}
			$visa_expiry_date = "";
			if( isset($_POST['visa_expiry_date']) ){
				$visa_expiry_date = test_inputs( $_POST['visa_expiry_date'] );
				$qqq = $qqq."`visa_expiry_date` = '".$visa_expiry_date."', ";
			}
			$visa_no = "";
			if( isset($_POST['visa_no']) ){
				$visa_no = test_inputs( $_POST['visa_no'] );
				$qqq = $qqq."`visa_no` = '".$visa_no."', ";
			}
			$eid_issue_date = "";
			if( isset($_POST['eid_issue_date']) ){
				$eid_issue_date = test_inputs( $_POST['eid_issue_date'] );
				$qqq = $qqq."`eid_issue_date` = '".$eid_issue_date."', ";
			}
			$eid_expiry_date = "";
			if( isset($_POST['eid_expiry_date']) ){
				$eid_expiry_date = test_inputs( $_POST['eid_expiry_date'] );
				$qqq = $qqq."`eid_expiry_date` = '".$eid_expiry_date."', ";
			}
			$eid_no = "";
			if( isset($_POST['eid_no']) ){
				$eid_no = test_inputs( $_POST['eid_no'] );
				$qqq = $qqq."`eid_no` = '".$eid_no."', ";
			}
			$eid_card_no = "";
			if( isset($_POST['eid_card_no']) ){
				$eid_card_no = test_inputs( $_POST['eid_card_no'] );
				$qqq = $qqq."`eid_card_no` = '".$eid_card_no."', ";
			}
			$labour_issue_date = "";
			if( isset($_POST['labour_issue_date']) ){
				$labour_issue_date = test_inputs( $_POST['labour_issue_date'] );
				$qqq = $qqq."`labour_issue_date` = '".$labour_issue_date."', ";
			}
			$labour_expiry_date = "";
			if( isset($_POST['labour_expiry_date']) ){
				$labour_expiry_date = test_inputs( $_POST['labour_expiry_date'] );
				$qqq = $qqq."`labour_expiry_date` = '".$labour_expiry_date."', ";
			}
			$labour_no = "";
			if( isset($_POST['labour_no']) ){
				$labour_no = test_inputs( $_POST['labour_no'] );
				$qqq = $qqq."`labour_no` = '".$labour_no."', ";
			}
			$license_issue_date = "";
			if( isset($_POST['license_issue_date']) ){
				$license_issue_date = test_inputs( $_POST['license_issue_date'] );
				$qqq = $qqq."`license_issue_date` = '".$license_issue_date."', ";
			}
			$license_expiry_date = "";
			if( isset($_POST['license_expiry_date']) ){
				$license_expiry_date = test_inputs( $_POST['license_expiry_date'] );
				$qqq = $qqq."`license_expiry_date` = '".$license_expiry_date."', ";
			}
			$license_no = "";
			if( isset($_POST['license_no']) ){
				$license_no = test_inputs( $_POST['license_no'] );
				$qqq = $qqq."`license_no` = '".$license_no."', ";
			}
			$civil_id = "";
			if( isset($_POST['civil_id']) ){
				$civil_id = test_inputs( $_POST['civil_id'] );
				$qqq = $qqq."`civil_id` = '".$civil_id."', ";
			}
			
			
			if( $qqq != "" ){
				$qqq =  substr($qqq, 0, -2);
				$qu_hr_employees_creds_updt = "UPDATE  `hr_employees_creds` SET ".$qqq."  WHERE `employee_id` = $employee_id;";
				
				
				//check if has profile or no
				$q = "SELECT * FROM `hr_employees_creds` WHERE `employee_id` = '".$employee_id."' ";
				$q_exe = mysqli_query($KONN, $q);
				$userStatement = mysqli_prepare($KONN,$q);
				mysqli_stmt_execute($userStatement);
				$q_exe = mysqli_stmt_get_result($userStatement);
				if(mysqli_num_rows($q_exe) == 0){
					//insert
					$qu_hr_employees_creds_updt = "INSERT INTO `hr_employees_creds` (
					`passport_issue_date`, 
					`passport_expiry_date`, 
					`passport_no`, 
					`visa_issue_date`, 
					`visa_expiry_date`, 
					`visa_no`, 
					`eid_issue_date`, 
					`eid_expiry_date`, 
					`eid_no`, 
					`eid_card_no`, 
					`labour_issue_date`, 
					`labour_expiry_date`, 
					`labour_no`, 
					`license_issue_date`, 
					`license_expiry_date`, 
					`license_no`, 
					`civil_id`, 
					`employee_id` 
					) VALUES (
					'".$passport_issue_date."', 
					'".$passport_expiry_date."', 
					'".$passport_no."', 
					'".$visa_issue_date."', 
					'".$visa_expiry_date."', 
					'".$visa_no."', 
					'".$eid_issue_date."', 
					'".$eid_expiry_date."', 
					'".$eid_no."', 
					'".$eid_card_no."', 
					'".$labour_issue_date."', 
					'".$labour_expiry_date."', 
					'".$labour_no."', 
					'".$license_issue_date."', 
					'".$license_expiry_date."', 
					'".$license_no."', 
					'".$civil_id."', 
					'".$employee_id."' 
					);";
					
					} else {
					//update
					$qu_hr_employees_creds_updt = "UPDATE  `hr_employees_creds` SET ".$qqq."  WHERE `employee_id` = $employee_id;";
					$updateStatement = mysqli_prepare($KONN,$qu_hr_employees_creds_updt);
					mysqli_stmt_execute($updateStatement);
					$IAM_ARRAY[] = array( "result" => "1" );
					die('1|DATA Updated');
					
				}
				
				
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

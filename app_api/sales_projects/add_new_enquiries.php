<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{

		if(
			isset($_POST['client_name']) &&
		isset($_POST['enquiry_type']) &&
		isset($_POST['date']) &&
		isset($_POST['subject_name']) &&
		isset($_POST['details']) &&
		isset($_POST['budget']) &&

		isset($_POST['attn_name'])){		
			$enquiry_id = 0;
			$client_name = test_inputs($_POST['client_name']);
			$enquiry = test_inputs($_POST['enquiry_type']);
			$date = test_inputs($_POST['date']);
			$details = test_inputs($_POST['details']);
			$subject = test_inputs($_POST['subject_name']);
			$attn = test_inputs($_POST['attn_name']);
			$budget = test_inputs($_POST['budget']);
			die('0|7wiu');


			$qu_gen_enquiry_ins = "INSERT INTO `enquiries` (
			`client_id`, 
			`enquiry_type`, 
			`date`, 
			`subject`,
			`attn`,
			`details`,
			`budget`
			) VALUES (
			'".$client_name."', 
			'".$enquiry."', 
			'".$date."', 
			'".$subject."',
			'".$attn."',
			'".$details."',
			'".$budget."'
			);";
			$insertStatement = mysqli_prepare($KONN,$qu_gen_enquiry_ins);
			
			mysqli_stmt_execute($insertStatement);
			
			$enquiry_id = mysqli_insert_id($KONN);
			if( $enquiry_id != 0 ){
				
				if( insert_state_change($KONN, 'Enquiries_added', $enquiry_id, "enquiries", $EMPLOYEE_ID) ){
					die('1|enquiries_List.php');
					} else {
					die('0| State Error 035532');
				}
				
				
				
			}	
			}
			
			else {
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

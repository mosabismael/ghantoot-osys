<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		if( isset($_POST['record_term']) &&
		isset($_POST['record_term_id']) ){
			
			
			
			$record_term_id     = 0;
			$record_term   = test_inputs($_POST['record_term']);
			$record_term_id     = test_inputs($_POST['record_term_id']);
			
			
			
			$qu_job_orders_billing_terms_recs_updt = "UPDATE  `job_orders_billing_terms_recs` SET `record_term` = '".$record_term."' WHERE `record_term_id` = $record_term_id;";
			$updateStatement = mysqli_prepare($KONN,$qu_job_orders_billing_terms_recs_updt);
			mysqli_stmt_execute($updateStatement);
			if( $record_term_id != 0 ){
				
				
				if( insert_state_change($KONN, "Data Edited", $record_term_id, "job_orders_billing_terms_recs", $EMPLOYEE_ID) ) {
					die("1|Term Edited");
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

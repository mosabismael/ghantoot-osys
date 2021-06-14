<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		if( isset($_POST['record_term'])){
			
			
			
			$record_term_id = 0;
			$record_term = test_inputs($_POST['record_term']);
			
			
			$qu_job_orders_billing_terms_recs_sel = "SELECT * FROM  `job_orders_billing_terms_recs` WHERE `record_term` = '$record_term' ";
			$userStatement = mysqli_prepare($KONN,$qu_job_orders_billing_terms_recs_sel);
			mysqli_stmt_execute($userStatement);
			$qu_job_orders_billing_terms_recs_EXE = mysqli_stmt_get_result($userStatement);
			$job_orders_billing_terms_recs_DATA;
			if(mysqli_num_rows($qu_job_orders_billing_terms_recs_EXE)){
				die("0|Unit Already Exist");
			}
			
			
			
			
			
			
			
			
			$qu_job_orders_billing_terms_recs_ins = "INSERT INTO `job_orders_billing_terms_recs` (
			`record_term`
			) VALUES (
			'".$record_term."'
			);";
			$insertStatement = mysqli_prepare($KONN,$qu_job_orders_billing_terms_recs_ins);
			
			mysqli_stmt_execute($insertStatement);
			
			$record_term_id = mysqli_insert_id($KONN);
			if( $record_term_id != 0 ){
				
				
				if( insert_state_change($KONN, "New-UOM", $record_term_id, "job_orders_billing_terms_recs", $EMPLOYEE_ID) ) {
					die("1|Term Added");
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

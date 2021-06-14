<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		if( isset($_POST['job_order_id']) && 
		isset($_POST['inputBillPercentage']) && 
		isset($_POST['record_term_id']) 
		){
			
			
			$job_order_id = 0;
			$job_order_id        = ( int ) test_inputs($_POST['job_order_id']);
			$record_percentage   = ( double ) test_inputs($_POST['inputBillPercentage']);
			$record_term_id      = ( int ) test_inputs($_POST['record_term_id']);
			
			
			
			
			
			$record_id = 0;
			$qu_job_orders_billing_terms_ins = "INSERT INTO `job_orders_billing_terms` (
			`record_percentage`, 
			`record_term_id`, 
			`job_order_id` 
			) VALUES (
			'".$record_percentage."', 
			'".$record_term_id."', 
			'".$job_order_id."' 
			);";
			$insertStatement = mysqli_prepare($KONN,$qu_job_orders_billing_terms_ins);
			
			mysqli_stmt_execute($insertStatement);
			
			$record_id = mysqli_insert_id($KONN);
			
			$current_state_id = get_current_state_id($KONN, $job_order_id, 'job_orders' );
			if( $current_state_id != 0 ){
				if( insert_state_change_dep($KONN, "bill-term-inserted", $job_order_id, $record_term_id, 'job_orders', $EMPLOYEE_ID, $current_state_id) ){
					die('1|Good');
					} else {
					die('0|Component State Error 01');
				}
				} else {
				die('0|Component State Error 02');
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

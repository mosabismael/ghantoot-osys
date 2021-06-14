<?php
	
	
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		
		
		if(!isset($_POST['job_order_id'])){
			die('0|ERR_REQ_4568674653');
		}
		
		
		if(!isset($_POST['project_amount'])){
			die('0|ERR_REQ_4568674653');
		}
		
		$job_order_id   = ( int ) test_inputs( $_POST['job_order_id'] );
		$project_amount = ( double ) test_inputs( $_POST['project_amount'] );
		$quotation_id = 0;
		
		$token_status = 'pending_project_prepare';
		
		$qu_job_orders_updt = "UPDATE  `job_orders` SET 
		`project_amount` = '".$project_amount."'
		WHERE `job_order_id` = $job_order_id;";
		$updateStatement = mysqli_prepare($KONN,$qu_job_orders_updt);
		mysqli_stmt_execute($updateStatement);
		$current_state_id = get_current_state_id($KONN, $job_order_id, 'job_orders' );
		if( $current_state_id != 0 ){
			if( insert_state_change_dep($KONN, "Amount-Change", $job_order_id, $project_amount, 'job_orders', $EMPLOYEE_ID, $current_state_id) ){
				die('1|Good');
				} else {
				die('0|Component State Error 01');
			}
			} else {
			die('0|Component State Error 02');
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

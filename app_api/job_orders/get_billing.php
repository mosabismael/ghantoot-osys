<?php
	
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	try{
		
		if(!isset($_POST['job_order_id'])){
			die('7wiu');
		}
		
		$job_order_id = (int) $_POST['job_order_id'];
		
		
		
		$IAM_ARRAY;
		$q = "SELECT * FROM  `job_orders_billing_terms` WHERE `job_order_id` = $job_order_id";
		$userStatement = mysqli_prepare($KONN,$q);
		mysqli_stmt_execute($userStatement);
		$q_exe = mysqli_stmt_get_result($userStatement);
		if(mysqli_num_rows($q_exe) != 0){
			
			while( $ARRAY_SRC = mysqli_fetch_assoc($q_exe) ){
				
				$record_term_id = ( int ) $ARRAY_SRC['record_term_id'];
				$record_term = '';
				
				if( $record_term_id != 0 ){
					
					$qu_job_orders_billing_terms_recs_sel = "SELECT `record_term` FROM  `job_orders_billing_terms_recs` WHERE `record_term_id` = $record_term_id";
					$userStatement = mysqli_prepare($KONN,$qu_job_orders_billing_terms_recs_sel);
					mysqli_stmt_execute($userStatement);
					$qu_job_orders_billing_terms_recs_EXE = mysqli_stmt_get_result($userStatement);
					$job_orders_billing_terms_recs_DATA;
					if(mysqli_num_rows($qu_job_orders_billing_terms_recs_EXE)){
						$job_orders_billing_terms_recs_DATA = mysqli_fetch_assoc($qu_job_orders_billing_terms_recs_EXE);
						$record_term = $job_orders_billing_terms_recs_DATA['record_term'];
					}
					
					
				}
				
				
				$IAM_ARRAY[] = array(  "record_id" => $ARRAY_SRC['record_id'], 
				"record_percentage" => $ARRAY_SRC['record_percentage'], 
				"record_term" => $record_term 
				);
			}
			
			} else {
			
			$IAM_ARRAY[] = array(  "record_id" => 0, 
			"record_percentage" => 0, 
			"record_term_id" => 0, 
			"job_order_id" => 0 
			);
			
			
		}
		
		
		echo json_encode($IAM_ARRAY);
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

<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	
	
	try{
		
		if(!isset($_POST['ids_id'])){
			die('7wiu');
		}
		
		$record_term_id = (int) test_inputs( $_POST['ids_id'] );
		$IAM_ARRAY;
		
		$q = "SELECT * FROM  `job_orders_billing_terms_recs` WHERE `record_term_id` = $record_term_id";
		$userStatement = mysqli_prepare($KONN,$q);
		mysqli_stmt_execute($userStatement);
		$q_exe = mysqli_stmt_get_result($userStatement);
		
		if(mysqli_num_rows($q_exe) == 0){
			
			$IAM_ARRAY[] = array(  "record_term_id" => 0, 
			"record_term" => 0
			);
			
			
			
			} else {
			$ARRAY_SRC = mysqli_fetch_assoc($q_exe);
			
			
			$IAM_ARRAY[] = array(  "record_term_id" => $ARRAY_SRC['record_term_id'], 
			"record_term" => $ARRAY_SRC['record_term']
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

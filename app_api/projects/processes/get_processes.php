<?php
	
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	try{
		
		if(!isset($_POST['job_order_id'])){
			die('7wiu');
		}
		
		$job_order_id = (int) $_POST['job_order_id'];
		
		
		
		$IAM_ARRAY;
		
		$q = "SELECT * FROM  `job_orders_processes` WHERE `job_order_id` = $job_order_id";
		$userStatement = mysqli_prepare($KONN,$q);
		mysqli_stmt_execute($userStatement);
		$q_exe = mysqli_stmt_get_result($userStatement);
		
		if(mysqli_num_rows($q_exe) != 0){
			
			while( $ARRAY_SRC = mysqli_fetch_assoc($q_exe) ){
				
				$IAM_ARRAY[] = array(  "process_id" => $ARRAY_SRC['process_id'], 
				"process_name" => $ARRAY_SRC['process_name'], 
				"job_order_id" => $ARRAY_SRC['job_order_id'] 
				);
				
			}
			
			} else {
			
			$IAM_ARRAY[] = array(  "process_id" => 0, 
			"process_name" => 0, 
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

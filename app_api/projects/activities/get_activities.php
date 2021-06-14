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
		
		$q = "SELECT * FROM  `job_orders_processes_acts` WHERE `job_order_id` = $job_order_id";
		$userStatement = mysqli_prepare($KONN,$q);
		mysqli_stmt_execute($userStatement);
		$q_exe = mysqli_stmt_get_result($userStatement);
		
		if(mysqli_num_rows($q_exe) != 0){
			
			while( $ARRAY_SRC = mysqli_fetch_assoc($q_exe) ){
				$process_id = $ARRAY_SRC['process_id'];
				$qu_job_orders_processes_sel = "SELECT `process_name` FROM  `job_orders_processes` WHERE `process_id` = $process_id";
				$qu_job_orders_processes_EXE = mysqli_query($KONN, $qu_job_orders_processes_sel);
				$process_name = "";
				if(mysqli_num_rows($qu_job_orders_processes_EXE)){
					$job_orders_processes_DATA = mysqli_fetch_assoc($qu_job_orders_processes_EXE);
					$process_name = $job_orders_processes_DATA['process_name'];
				}
				
				
				
				$IAM_ARRAY[] = array(  "activity_id" => $ARRAY_SRC['activity_id'], 
				"activity_name" => $ARRAY_SRC['activity_name'], 
				"process_id" => $ARRAY_SRC['process_id'], 
				"process_name" => $process_name, 
				"job_order_id" => $ARRAY_SRC['job_order_id'] 
				);
				
				
			}
			
			} else {
			
			$IAM_ARRAY[] = array(  "activity_id" => 0, 
			"activity_name" => 0, 
			"process_id" => 0, 
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

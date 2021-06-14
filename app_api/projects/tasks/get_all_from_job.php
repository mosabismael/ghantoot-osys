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
		
		$q = "SELECT * FROM  `job_orders_processes_acts_tasks` WHERE `job_order_id` = $job_order_id";
		$userStatement = mysqli_prepare($KONN,$q);
		mysqli_stmt_execute($userStatement);
		$q_exe = mysqli_stmt_get_result($userStatement);
		
		if(mysqli_num_rows($q_exe) != 0){
			
			while( $ARRAY_SRC = mysqli_fetch_assoc($q_exe) ){
				$activity_id = $ARRAY_SRC['activity_id'];
				$process_id  = $ARRAY_SRC['process_id'];
				
				$qu_projects_processes_sel = "SELECT `activity_name` FROM  `job_orders_processes_acts` WHERE `activity_id` = $activity_id";
				$userStatement = mysqli_prepare($KONN,$qu_projects_processes_sel);
				mysqli_stmt_execute($userStatement);
				$qu_projects_processes_EXE = mysqli_stmt_get_result($userStatement);
				$activity_name = "";
				if(mysqli_num_rows($qu_projects_processes_EXE)){
					$projects_processes_DATA = mysqli_fetch_assoc($qu_projects_processes_EXE);
					$activity_name = $projects_processes_DATA['activity_name'];
				}
				
				$qu_projects_processes_sel = "SELECT `process_name` FROM  `job_orders_processes` WHERE `process_id` = $process_id";
				$userStatement = mysqli_prepare($KONN,$qu_projects_processes_sel);
				mysqli_stmt_execute($userStatement);
				$qu_projects_processes_EXE = mysqli_stmt_get_result($userStatement);
				$process_name = "";
				if(mysqli_num_rows($qu_projects_processes_EXE)){
					$projects_processes_DATA = mysqli_fetch_assoc($qu_projects_processes_EXE);
					$process_name = $projects_processes_DATA['process_name'];
				}
				
				
				
				$IAM_ARRAY[] = array(  "task_id" => $ARRAY_SRC['task_id'], 
				"task_name" => $ARRAY_SRC['task_name'], 
				"activity_id" => $ARRAY_SRC['activity_id'], 
				"activity_name" => $activity_name, 
				"process_name" => $process_name
				);
				
				
			}
			
			} else {
			
			$IAM_ARRAY[] = array(  "task_id" => 0, 
			"activity_name" => 0, 
			"activity_id" => 0
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

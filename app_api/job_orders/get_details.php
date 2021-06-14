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
		
		$q = "SELECT * FROM  `job_orders` WHERE `job_order_id` = $job_order_id";
		$userStatement = mysqli_prepare($KONN,$q);
		mysqli_stmt_execute($userStatement);
		$q_exe = mysqli_stmt_get_result($userStatement);
		
		
		
		
		if(mysqli_num_rows($q_exe) == 0){
			$IAM_ARRAY[] = array(  "job_order_id" => 0, 
			"job_order_ref" => 0, 
			"project_name" => 0, 
			"job_order_type" => 0, 
			"project_amount" => 0, 
			"project_manager_id" => 0, 
			"job_order_status" => 0, 
			"created_date" => 0, 
			"created_by" => 0 
			);
			
			
			} else {
			$ARRAY_SRC = mysqli_fetch_assoc($q_exe);
			
			$BY = get_emp_name($KONN, $ARRAY_SRC['created_by'] );
			$project_manager = get_emp_name($KONN, $ARRAY_SRC['project_manager_id'] );
			
			$job_order_id = ( int ) $ARRAY_SRC['job_order_id'];
			$contract_attach = $ARRAY_SRC['contract_attach'];
			
			if( $contract_attach == '' ){
				$contract_attach = 'na';
			}
			
			$IAM_ARRAY[] = array(  "job_order_id" => $ARRAY_SRC['job_order_id'], 
			"job_order_ref" => $ARRAY_SRC['job_order_ref'], 
			"project_name" => $ARRAY_SRC['project_name'], 
			"contract_attach" => $contract_attach, 
			"job_order_type" => $ARRAY_SRC['job_order_type'], 
			"project_manager_id" => $ARRAY_SRC['project_manager_id'], 
			"project_manager" => $project_manager, 
			"project_amount" => $ARRAY_SRC['project_amount'], 
			"job_order_status" => $ARRAY_SRC['job_order_status'], 
			"created_date" => $ARRAY_SRC['created_date'], 
			"created_by" => $ARRAY_SRC['created_by'], 
			"created_by_name" => $BY 
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

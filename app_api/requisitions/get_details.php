<?php
	
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	try{
		
		if(!isset($_POST['requisition_id'])){
			die('7wiu');
		}
		
		$requisition_id = (int) $_POST['requisition_id'];
		$q = "update users_notifications set is_notified = 1 where requisition_id = $requisition_id and receiver_id = $EMPLOYEE_ID";
		$userStatement = mysqli_prepare($KONN,$q);
		mysqli_stmt_execute($userStatement);
		
		
		
		$IAM_ARRAY;
		
		$q = "SELECT * FROM  `pur_requisitions` WHERE `requisition_id` = $requisition_id";
		$userStatement = mysqli_prepare($KONN,$q);
		mysqli_stmt_execute($userStatement);
		$q_exe = mysqli_stmt_get_result($userStatement);
		
		
		
		
		
		if(mysqli_num_rows($q_exe) == 0){
			$IAM_ARRAY[] = array(  "requisition_id" => 0, 
			"created_date" => 0, 
			"required_date" => 0, 
			"estimated_date" => 0, 
			"requisition_ref" => 0, 
			"requisition_type" => 0, 
			"job_order_id" => 0, 
			"requisition_status" => 0, 
			"requisition_notes" => 0, 
			"ordered_by" => 0 
			);
			
			} else {
			$ARRAY_SRC = mysqli_fetch_assoc($q_exe);
			
			$BY = get_emp_name($KONN, $ARRAY_SRC['ordered_by'] );
			
			$job_order_id = ( int ) $ARRAY_SRC['job_order_id'];
			
			
			$job_order_ref   = "";
			$project_name    = "";
			$job_order_type  = "";
			
			if( $job_order_id != 0 ){
				//load details
				$qu_job_orders_sel = "SELECT * FROM  `job_orders` WHERE `job_order_id` = $job_order_id";
				$userStatement = mysqli_prepare($KONN,$qu_job_orders_sel);
		mysqli_stmt_execute($userStatement);
		$qu_job_orders_EXE = mysqli_stmt_get_result($userStatement);
				$job_orders_DATA;
				if(mysqli_num_rows($qu_job_orders_EXE)){
					$job_orders_DATA = mysqli_fetch_assoc($qu_job_orders_EXE);
					$job_order_ref = $job_orders_DATA['job_order_ref'];
					$project_name = $job_orders_DATA['project_name'];
					$job_order_type = $job_orders_DATA['job_order_type'];
				}
				
			}
			
			
			
			
			
			$IAM_ARRAY[] = array(  "requisition_id" => $ARRAY_SRC['requisition_id'], 
			"created_date" => $ARRAY_SRC['created_date'], 
			"required_date" => $ARRAY_SRC['required_date'], 
			"estimated_date" => $ARRAY_SRC['estimated_date'], 
			"requisition_ref" => $ARRAY_SRC['requisition_ref'], 
			"requisition_type" => $ARRAY_SRC['requisition_type'], 
			"job_order_id" => $ARRAY_SRC['job_order_id'], 
			"job_order_ref" => $job_order_ref, 
			"project_name" => $project_name, 
			"job_order_type" => $job_order_type, 
			"requisition_status" => $ARRAY_SRC['requisition_status'], 
			"requisition_notes" => $ARRAY_SRC['requisition_notes'], 
			"is_material" => $ARRAY_SRC['is_material'], 
			"ordered_by" => $BY 
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

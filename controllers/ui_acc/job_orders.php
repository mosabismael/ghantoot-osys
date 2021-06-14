<?php
	require_once('../../bootstrap/app_config.php');
	require_once('../../bootstrap/chk_log_user.php');
	
	$IAM_ARRAY = array();
	
	
	$CUR_PAGE = 0;
	$per_page = 20;
	$totPages = 0;
	
	if( isset( $_POST['page'] ) ){
		$CUR_PAGE = ( int ) test_inputs( $_POST['page'] );
	}
	if( isset( $_POST['showperpage'] ) ){
		$per_page = ( int ) test_inputs( $_POST['showperpage'] );
	}
	
	$start=abs(($CUR_PAGE-1)*$per_page);
	
	
	

	$serchCond = "";
	if( isset( $_POST['cond'] ) ){
		$serchCond = $_POST['cond'];
	}

	
	
	
	
	$sNo = $start + 1;
	$qu_job_orders_sel = "SELECT * FROM  `job_orders`  $serchCond ORDER BY `job_order_id` DESC LIMIT $start,$per_page";


	$qu_job_orders_EXE = mysqli_query($KONN, $qu_job_orders_sel);
	if(mysqli_num_rows($qu_job_orders_EXE)){
		while($job_orders_REC = mysqli_fetch_assoc($qu_job_orders_EXE)){
			
			$job_order_id = $job_orders_REC['job_order_id'];
			$job_order_ref = $job_orders_REC['job_order_ref'];
			$project_name = $job_orders_REC['project_name'];
			$job_order_type = $job_orders_REC['job_order_type'];
			$job_order_status = $job_orders_REC['job_order_status'];
			$created_date = $job_orders_REC['created_date'];
			$project_manager_id = $job_orders_REC['project_manager_id'];
		
		$project_manager = get_emp_name($KONN, $project_manager_id );
	
$IAM_ARRAY[] = array(  "sNo" => $sNo,
						"job_order_id" => $job_order_id, 
						"job_order_ref" => $job_order_ref,
						"project_name" => $project_name,
						"job_order_type" => $job_order_type, 
						"created_date" => $created_date, 
						"project_manager" => $project_manager, 
						"job_order_status" => $job_order_status
						);
						
		$sNo++;
		}
		
	}
	echo json_encode($IAM_ARRAY);
	
?>


			
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
	
	$serchCond = "";
	if( isset( $_POST['cond'] ) ){
		$serchCond = $_POST['cond'];
	}
	
	$start=abs(($CUR_PAGE-1)*$per_page);
	
	
	
	
	
	
	
	$sNo = $start + 1;
	$qu_pur_requisitions_sel = "SELECT * FROM  `pur_requisitions` WHERE ( (`requisition_status` <> 'deleted') AND (`ordered_by` = '$EMPLOYEE_ID') $serchCond ) ORDER BY `requisition_id` DESC LIMIT $start,$per_page";

	
	
	
	$qu_pur_requisitions_EXE = mysqli_query($KONN, $qu_pur_requisitions_sel);
	if(mysqli_num_rows($qu_pur_requisitions_EXE)){
		while($pur_requisitions_REC = mysqli_fetch_assoc($qu_pur_requisitions_EXE)){
		$requisition_id = $pur_requisitions_REC['requisition_id'];
		$requisition_ref = $pur_requisitions_REC['requisition_ref'];
		$requisition_type = $pur_requisitions_REC['requisition_type'];
		$requisition_status = $pur_requisitions_REC['requisition_status'];
		$requisition_notes = $pur_requisitions_REC['requisition_notes'];
		$ordered_by = $pur_requisitions_REC['ordered_by'];
		$created_date = $pur_requisitions_REC['created_date'];
		
		$BY = get_emp_name($KONN, $ordered_by );
		
		$job_order_id = $pur_requisitions_REC['job_order_id'];
		$project = "";
		if( $job_order_id != 0 ){
			$qu_job_orders_sel = "SELECT * FROM  `job_orders` WHERE `job_order_id` = $job_order_id";
			$qu_job_orders_EXE = mysqli_query($KONN, $qu_job_orders_sel);
			$job_orders_DATA;
			if(mysqli_num_rows($qu_job_orders_EXE)){
				$job_orders_DATA = mysqli_fetch_assoc($qu_job_orders_EXE);
			}
			$job_order_ref = $job_orders_DATA['job_order_ref'];
			$project_name = $job_orders_DATA['project_name'];
			
			$project = $job_order_ref.' - '.$project_name;
			
		}
		
		
		$current_state_id = get_current_state_id($KONN, $requisition_id, 'pur_requisitions' );
		$qu_gen_status_change_sel = "SELECT * FROM  `gen_status_change` WHERE `status_id` = $current_state_id";
		$qu_gen_status_change_EXE = mysqli_query($KONN, $qu_gen_status_change_sel);
		$gen_status_change_DATA;
		if(mysqli_num_rows($qu_gen_status_change_EXE)){
			$gen_status_change_DATA = mysqli_fetch_assoc($qu_gen_status_change_EXE);
		}

		$status_id = $gen_status_change_DATA['status_id'];
		$status_action = $gen_status_change_DATA['status_action'];
		$status_date = $gen_status_change_DATA['status_date'];
		$item_id = $gen_status_change_DATA['item_id'];
		$item_type = $gen_status_change_DATA['item_type'];
		$action_by = $gen_status_change_DATA['action_by'];
		
		$Desk = get_emp_name($KONN, $action_by );
		
		

$IAM_ARRAY[] = array(  "sno" => $sNo, 
					"requisition_id" => $pur_requisitions_REC['requisition_id'], 
					"requisition_ref" => $pur_requisitions_REC['requisition_ref'], 
					"created_date" => $pur_requisitions_REC['created_date'], 
					"project" => $project, 
					"BY" => $BY, 
					"requisition_status" => $pur_requisitions_REC['requisition_status']
					);
		
		$sNo++;
		}
		
							
	}
		echo json_encode($IAM_ARRAY);
	
?>
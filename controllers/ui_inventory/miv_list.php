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
	$qu_inv_mivs_sel = "SELECT * FROM  `inv_mivs` $serchCond ORDER BY `miv_id` DESC LIMIT $start,$per_page";


	$qu_inv_mivs_EXE = mysqli_query($KONN, $qu_inv_mivs_sel);
	if(mysqli_num_rows($qu_inv_mivs_EXE)){
		while($inv_mivs_REC = mysqli_fetch_assoc($qu_inv_mivs_EXE)){
			
		$miv_id           = ( int ) $inv_mivs_REC['miv_id'];
		$miv_ref          = $inv_mivs_REC['miv_ref'];
		$created_date     = $inv_mivs_REC['created_date'];
		$received_date    = $inv_mivs_REC['received_date'];
		$created_byID     = ( int ) $inv_mivs_REC['created_by'];
		$received_byID    = ( int ) $inv_mivs_REC['received_by'];
		$miv_status       = $inv_mivs_REC['miv_status'];
		$job_order_id     = ( int ) $inv_mivs_REC['job_order_id'];
		
		
		$created_by = '';
		if( $created_byID != 0 ){
			$created_by = get_emp_name($KONN, $created_byID );
		} else {
			$created_by = "NA";
			$created_date = "NA";
		}
		
		$received_by = '';
		if( $received_byID != 0 ){
			$received_by = get_emp_name($KONN, $received_byID );
		} else {
			$received_by = "NA";
			$received_date = "NA";
		}
		
	if( $received_date == null ){
		$received_date = 'NA';
	}
		
	$qu_job_orders_sel = "SELECT * FROM  `job_orders` WHERE `job_order_id` = $job_order_id";
	$qu_job_orders_EXE = mysqli_query($KONN, $qu_job_orders_sel);
	$job_order_ref = '';
	$project_name = '';
	$client_id = 0;
	if(mysqli_num_rows($qu_job_orders_EXE)){
		$job_orders_DATA = mysqli_fetch_assoc($qu_job_orders_EXE);
		$job_order_id = $job_orders_DATA['job_order_id'];
		$job_order_ref = $job_orders_DATA['job_order_ref'];
		$project_name = $job_orders_DATA['project_name'];
		$client_id = $job_orders_DATA['client_id'];
	}
		
		

$IAM_ARRAY[] = array(  "sno" => $sNo, 
					"miv_id" => $miv_id, 
					"miv_ref" => $miv_ref, 
					"job_order_ref" => $job_order_ref, 
					"project_name" => $project_name, 
					"created_date" => $created_date, 
					"created_by" => $created_by ,
					"received_date" => $received_date, 
					"received_by" => $received_by, 
					"miv_status" => $miv_status
					);
		
		$sNo++;
		}
		
	}
	echo json_encode($IAM_ARRAY);
	
?>




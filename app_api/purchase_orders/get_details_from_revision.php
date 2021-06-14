<?php
	
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	
	try{
		if(!isset($_POST['po_id'])){
			die('7wiu');
		}
		
		$po_id = (int) $_POST['po_id'];
		$rev_no = (int) $_POST['rev_no'];
		
		
		$IAM_ARRAY;
		
		$q = "SELECT * FROM  `purchase_orders_revision` WHERE `po_id` = $po_id and rev_no = $rev_no-1" ;
		$userStatement = mysqli_prepare($KONN,$q);
		mysqli_stmt_execute($userStatement);
		$q_exe = mysqli_stmt_get_result($userStatement);
		
		
		
		
		
		if(mysqli_num_rows($q_exe) == 0){
			$IAM_ARRAY[] = array(  "po_id" => 0, 
			"po_ref" => 0, 
			"rev_no" => 0, 
			"po_date" => 0, 
			"delivery_date" => 0, 
			"delivery_period_id" => 0, 
			"discount_percentage" => 0, 
			"discount_amount" => 0, 
			"is_vat_included" => 0, 
			"payment_term_id" => 0, 
			"currency_id" => 0, 
			"exchange_rate" => 0, 
			"supplier_quotation_ref" => 0, 
			"attached_supplier_quotation" => 0, 
			"notes" => 0, 
			"po_status" => 0, 
			"supplier_id" => 0, 
			"requisition_id" => 0, 
			"job_order_id" => 0, 
			"employee_id" => 0 
			);
			
			
			} else {
			$ARRAY_SRC = mysqli_fetch_assoc($q_exe);
			
			$employee_name             = get_emp_name( $KONN, $ARRAY_SRC['employee_id'] );
			$supplier_name             = get_supplier_name($ARRAY_SRC['supplier_id'], $KONN );
			$payment_term_title        = get_payment_term_title($ARRAY_SRC['payment_term_id'], $KONN );
			$delivery_period_title     = get_delivery_period_title($ARRAY_SRC['delivery_period_id'], $KONN );
			$currency_name             = get_currency_name($ARRAY_SRC['currency_id'], $KONN );
			$requisition_ref           = get_requisition_ref($ARRAY_SRC['requisition_id'], $KONN );
			
			$job_order_id = (int) $ARRAY_SRC['job_order_id'];
			
			$project = "NA";
			if( $job_order_id != 0 ){
				$qu_job_orders_sel = "SELECT * FROM  `job_orders` WHERE `job_order_id` = $job_order_id";
				$userStatement = mysqli_prepare($KONN,$qu_job_orders_sel);
				mysqli_stmt_execute($userStatement);
				$qu_job_orders_EXE = mysqli_stmt_get_result($userStatement);
				$job_orders_DATA;
				if(mysqli_num_rows($qu_job_orders_EXE)){
					$job_orders_DATA = mysqli_fetch_assoc($qu_job_orders_EXE);
					$job_order_ref = $job_orders_DATA['job_order_ref'];
					$project_name = $job_orders_DATA['project_name'];
					$project = $job_order_ref.' - '.$project_name;
				}
			}
			
			
			$IAM_ARRAY[] = array(  "po_id" => $ARRAY_SRC['po_id'], 
			"po_ref" => $ARRAY_SRC['po_ref'], 
			"rev_no" => $ARRAY_SRC['rev_no']+1, 
			"po_date" => $ARRAY_SRC['po_date'], 
			"delivery_date" => $ARRAY_SRC['delivery_date'], 
			"delivery_period_id" => $ARRAY_SRC['delivery_period_id'], 
			"delivery_period_title" => $delivery_period_title, 
			"discount_percentage" => $ARRAY_SRC['discount_percentage'], 
			"discount_amount" => $ARRAY_SRC['discount_amount'], 
			"is_vat_included" => $ARRAY_SRC['is_vat_included'], 
			"payment_term_id" => $ARRAY_SRC['payment_term_id'], 
			"payment_term_title" => $payment_term_title, 
			"currency_id" => $ARRAY_SRC['currency_id'], 
			"currency_name" => $currency_name, 
			"exchange_rate" => $ARRAY_SRC['exchange_rate'], 
			"supplier_quotation_ref" => $ARRAY_SRC['supplier_quotation_ref'], 
			"attached_supplier_quotation" => $ARRAY_SRC['attached_supplier_quotation'], 
			"notes" => $ARRAY_SRC['notes'], 
			"po_status" => $ARRAY_SRC['po_status'], 
			"supplier_id" => $ARRAY_SRC['supplier_id'], 
			"supplier_name" => $supplier_name, 
			"requisition_id" => $ARRAY_SRC['requisition_id'], 
			"requisition_ref" => $requisition_ref, 
			"job_order_id" => $ARRAY_SRC['job_order_id'], 
			"project" => $project, 
			"employee_id" => $ARRAY_SRC['employee_id'], 
			"employee_name" => $employee_name 
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

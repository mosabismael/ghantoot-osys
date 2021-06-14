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
	
	$arrangeCond = "po_id";
	if( isset( $_POST['rearrange'] ) && $_POST['rearrange']!="" ){
		$arrangeCond = $_POST['rearrange'];
	}
	
	
	
	
	
	$sNo = $start + 1;
	$qu_purchase_orders_sel = "SELECT * FROM  `purchase_orders` WHERE ( ( `po_status` <> 'draft' )  $serchCond ) ORDER BY $arrangeCond ASC LIMIT $start,$per_page";

	//echo $qu_purchase_orders_sel;
	$qu_purchase_orders_EXE = mysqli_query($KONN, $qu_purchase_orders_sel);
	if(mysqli_num_rows($qu_purchase_orders_EXE)){
		while($purchase_orders_REC = mysqli_fetch_assoc($qu_purchase_orders_EXE)){
			
			$po_id = $purchase_orders_REC['po_id'];
			$po_ref = $purchase_orders_REC['po_ref'];
			$rev_no = $purchase_orders_REC['rev_no'];
			$po_date = $purchase_orders_REC['po_date'];
			$delivery_date = $purchase_orders_REC['delivery_date'];
			$delivery_period_id = $purchase_orders_REC['delivery_period_id'];
			$discount_percentage = $purchase_orders_REC['discount_percentage'];
			$discount_amount = $purchase_orders_REC['discount_amount'];
			$is_vat_included = $purchase_orders_REC['is_vat_included'];
			$payment_term_id = $purchase_orders_REC['payment_term_id'];
			$currency_id = $purchase_orders_REC['currency_id'];
			$exchange_rate = $purchase_orders_REC['exchange_rate'];
			$supplier_quotation_ref = $purchase_orders_REC['supplier_quotation_ref'];
			$attached_supplier_quotation = $purchase_orders_REC['attached_supplier_quotation'];
			$notes = $purchase_orders_REC['notes'];
			$po_status = $purchase_orders_REC['po_status'];
			$supplier_id = $purchase_orders_REC['supplier_id'];
			$requisition_id = $purchase_orders_REC['requisition_id'];
			$job_order_id = $purchase_orders_REC['job_order_id'];
			$employee_id = $purchase_orders_REC['employee_id'];
		
			$BY       = get_emp_name($KONN, $employee_id );
			$supplier = get_supplier_name( $supplier_id, $KONN );
		
		
		
		
	$qu_job_orders_sel = "SELECT * FROM  `job_orders` WHERE `job_order_id` = $job_order_id";
	$qu_job_orders_EXE = mysqli_query($KONN, $qu_job_orders_sel);
	$job_order_type = '';
	$job_order_ref = '';
	if(mysqli_num_rows($qu_job_orders_EXE)){
		$job_orders_DATA = mysqli_fetch_assoc($qu_job_orders_EXE);
		$job_order_type = $job_orders_DATA['job_order_type'];
		$job_order_ref = $job_orders_DATA['job_order_ref'];
	}
	
	$qu_pur_requisitions_sel = "SELECT * FROM  `pur_requisitions` WHERE `requisition_id` = $requisition_id";
	$qu_pur_requisitions_EXE = mysqli_query($KONN, $qu_pur_requisitions_sel);
	$requisition_ref = "NA";
	if(mysqli_num_rows($qu_pur_requisitions_EXE)){
		$pur_requisitions_DATA = mysqli_fetch_assoc($qu_pur_requisitions_EXE);
		$requisition_ref = $pur_requisitions_DATA['requisition_ref'];
	}
	
    
$IAM_ARRAY[] = array(  "sno" => $sNo, 
						"po_id" => $purchase_orders_REC['po_id'], 
						"po_ref" => $purchase_orders_REC['po_ref'], 
						"supplier" => $supplier, 
						"job_order_ref" => $job_order_ref, 
						"job_order_type" => $job_order_type, 
						"requisition_ref" => $requisition_ref, 
						"rev_no" => $purchase_orders_REC['rev_no'], 
						"po_date" => $purchase_orders_REC['po_date'], 
						"delivery_date" => $purchase_orders_REC['delivery_date'], 
						"delivery_period_id" => $purchase_orders_REC['delivery_period_id'], 
						"discount_percentage" => $purchase_orders_REC['discount_percentage'], 
						"discount_amount" => $purchase_orders_REC['discount_amount'], 
						"is_vat_included" => $purchase_orders_REC['is_vat_included'], 
						"payment_term_id" => $purchase_orders_REC['payment_term_id'], 
						"currency_id" => $purchase_orders_REC['currency_id'], 
						"exchange_rate" => $purchase_orders_REC['exchange_rate'], 
						"supplier_quotation_ref" => $purchase_orders_REC['supplier_quotation_ref'], 
						"attached_supplier_quotation" => $purchase_orders_REC['attached_supplier_quotation'], 
						"notes" => $purchase_orders_REC['notes'], 
						"po_status" => $purchase_orders_REC['po_status'], 
						"supplier_id" => $purchase_orders_REC['supplier_id'], 
						"requisition_id" => $purchase_orders_REC['requisition_id'], 
						"job_order_id" => $purchase_orders_REC['job_order_id'], 
						"employee_id" => $purchase_orders_REC['employee_id'], 
						"approved_by" => $purchase_orders_REC['approved_by'], 
						"approved_by_date" => $purchase_orders_REC['approved_by_date'], 
						"approved_acc_by" => $purchase_orders_REC['approved_acc_by'], 
						"approved_acc_by_date" => $purchase_orders_REC['approved_acc_by_date'], 
						"man_by" => $purchase_orders_REC['man_by'], 
						"man_by_date" => $purchase_orders_REC['man_by_date'] 
						);
						
		$sNo++;
		}
		
							
	}
		echo json_encode($IAM_ARRAY);
	
?>
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
	$qu_purchase_orders_sel = "SELECT * FROM  `purchase_orders` WHERE ((`po_status` = 'generated') $serchCond) LIMIT $start,$per_page";
	
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
		
		
		$reqRef    = 'NA';
		$Requester = 'NA';
		if( $requisition_id != 0 ){
			$qu_pur_requisitions_sel = "SELECT * FROM  `pur_requisitions` WHERE `requisition_id` = $requisition_id";
			$qu_pur_requisitions_EXE = mysqli_query($KONN, $qu_pur_requisitions_sel);
			if(mysqli_num_rows($qu_pur_requisitions_EXE)){
				$pur_requisitions_DATA = mysqli_fetch_assoc($qu_pur_requisitions_EXE);
				$reqRef     = $pur_requisitions_DATA['requisition_ref'];
				$ordered_by = $pur_requisitions_DATA['ordered_by'];
				$Requester  = get_emp_name($KONN, $ordered_by );
			}
		}
			
			
			
			$IAM_ARRAY[] = array(  "sNo" => $sNo, 
			"po_date" => $po_date,
			"supplier" => $supplier,
			"Requester" => $Requester, 
			"delivery_date" => $delivery_date, 
			"po_id" => $po_id, 
			"po_ref" => $po_ref, 
			"reqRef" => $reqRef,
			"po_status" => $po_status
			);
			
			
		}
		
	}
	
	
		echo json_encode($IAM_ARRAY);
	
?>



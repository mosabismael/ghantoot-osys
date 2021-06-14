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
	$qu_purchase_orders_sel = "SELECT * FROM  `purchase_orders` WHERE ( (( `po_status` = 'pending_acc_approval' ) OR (`po_status` = 'pending_approval')  OR (`po_status` = 'activated')  OR (`po_status` = 'pending_man'))  $serchCond )LIMIT $start,$per_page";


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
			
		
		$approved_by = $purchase_orders_REC['approved_by'];
		$approved_by_date = $purchase_orders_REC['approved_by_date'];
		$approved_acc_by = $purchase_orders_REC['approved_acc_by'];
		$approved_acc_by_date = $purchase_orders_REC['approved_acc_by_date'];
		$man_by = $purchase_orders_REC['man_by'];
		$man_by_date = $purchase_orders_REC['man_by_date'];
		
			$BY       = get_emp_name($KONN, $employee_id );
			$supplier = get_supplier_name( $supplier_id, $KONN );
			
			
		$current_state_id = get_current_state_id($KONN, $po_id, 'purchase_orders' );
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
		
$TT = "hhh";
if( $job_order_id != 0 ){
    
	$qu_job_orders_sel = "SELECT * FROM  `job_orders` WHERE `job_order_id` = $job_order_id";
	$qu_job_orders_EXE = mysqli_query($KONN, $qu_job_orders_sel);
	$job_orders_DATA;
	if(mysqli_num_rows($qu_job_orders_EXE)){
		$job_orders_DATA = mysqli_fetch_assoc($qu_job_orders_EXE);
		$TT = $job_orders_DATA['job_order_type'];
	}
	
}




		if( $po_status == 'pending_acc_approval' ){
			
		    $Desk = get_emp_name($KONN, $approved_acc_by );
			
		} else if( $po_status == 'pending_man' ){
			
		    $Desk = get_emp_name($KONN, $man_by );
			
		} else if( $po_status == 'activated' ) {
			
		    $Desk = get_emp_name($KONN, $action_by );
			
		}
		
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
	
    
$IAM_ARRAY[] = array(  "sno" => $sNo, 
						"reqRef" => $reqRef,
						"Desk" => $Desk,
						"Requester" => $Requester,
						"po_id" => $purchase_orders_REC['po_id'], 
						"po_ref" => $purchase_orders_REC['po_ref'], 
						"supplier" => $supplier, 
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






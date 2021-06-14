<?php
	
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	try{
		
		if(!isset($_POST['rfq_id'])){
			die('7wiu');
		}
		
		$rfq_id = (int) $_POST['rfq_id'];
		
		
		
		$IAM_ARRAY;
		
		$q = "SELECT * FROM  `pur_requisitions_rfq` WHERE `rfq_id` = $rfq_id";
		$userStatement = mysqli_prepare($KONN,$q);
		mysqli_stmt_execute($userStatement);
		$q_exe = mysqli_stmt_get_result($userStatement);
		
		
		
		
		
		if(mysqli_num_rows($q_exe) == 0){
			
			$IAM_ARRAY[] = array(  "rfq_id" => 0, 
			"supplier_id" => 0, 
			"requisition_id" => 0, 
			"created_date" => 0, 
			"employee_id" => 0 
			);
			
			
			} else {
			$ARRAY_SRC = mysqli_fetch_assoc($q_exe);
			$requisition_id = $ARRAY_SRC['requisition_id'];
			
			
			
			$price_list_id = 0;
			$currency_id = 1;
			$exchange_rate = 0;
			$is_vat_included = 1;
			$supplier_quotation_ref = '';
			$attached_supplier_quotation = '';
			$attached_supplier_quotation1 = '';
			$delivery_period_id = 1;
			$payment_term_id = 16;
			$discount_amount = 0;
			$discount_percentage = 0;
			$notes = '';
			
			
			//check for PL details
			$qu_pur_requisitions_pls_sel = "SELECT * FROM  `pur_requisitions_pls` WHERE 
			((`requisition_id` = $requisition_id) AND 
			(`rfq_id` = $rfq_id))";
			$userStatement = mysqli_prepare($KONN,$qu_pur_requisitions_pls_sel);
		mysqli_stmt_execute($userStatement);
		$qu_pur_requisitions_pls_EXE = mysqli_stmt_get_result($userStatement);
			$pur_requisitions_pls_DATA;
			if(mysqli_num_rows($qu_pur_requisitions_pls_EXE)){
				$pur_requisitions_pls_DATA = mysqli_fetch_assoc($qu_pur_requisitions_pls_EXE);
				$price_list_id = $pur_requisitions_pls_DATA['price_list_id'];
				$currency_id = $pur_requisitions_pls_DATA['currency_id'];
				$exchange_rate = $pur_requisitions_pls_DATA['exchange_rate'];
				$is_vat_included = $pur_requisitions_pls_DATA['is_vat_included'];
				$supplier_quotation_ref = $pur_requisitions_pls_DATA['supplier_quotation_ref'];
				$attached_supplier_quotation = $pur_requisitions_pls_DATA['attached_supplier_quotation'];
				$attached_supplier_quotation1 = $pur_requisitions_pls_DATA['attached_supplier_quotation1'];
				$delivery_period_id = $pur_requisitions_pls_DATA['delivery_period_id'];
				$payment_term_id = $pur_requisitions_pls_DATA['payment_term_id'];
				$discount_amount = $pur_requisitions_pls_DATA['discount_amount'];
				$discount_percentage = $pur_requisitions_pls_DATA['discount_percentage'];
				$notes = $pur_requisitions_pls_DATA['notes'];
				$rfq_id = $pur_requisitions_pls_DATA['rfq_id'];
				$requisition_id = $pur_requisitions_pls_DATA['requisition_id'];
				$supplier_id = $pur_requisitions_pls_DATA['supplier_id'];
				$added_date = $pur_requisitions_pls_DATA['added_date'];
				$employee_id = $pur_requisitions_pls_DATA['employee_id'];
			}
			
			
			
			
			
			
			
			
			
			$IAM_ARRAY[] = array(  "rfq_id" => $ARRAY_SRC['rfq_id'], 
			"supplier_id" => $ARRAY_SRC['supplier_id'], 
			"requisition_id" => $ARRAY_SRC['requisition_id'], 
			"created_date" => $ARRAY_SRC['created_date'], 
			"employee_id" => $ARRAY_SRC['employee_id'], 
			"price_list_id" => $price_list_id, 
			"currency_id" => $currency_id, 
			"exchange_rate" => $exchange_rate, 
			"is_vat_included" => $is_vat_included, 
			"supplier_quotation_ref" => $supplier_quotation_ref, 
			"attached_supplier_quotation" => $attached_supplier_quotation,
			"attached_supplier_quotation1" => $attached_supplier_quotation1,
			"delivery_period_id" => $delivery_period_id, 
			"payment_term_id" => $payment_term_id, 
			"discount_percentage" => $discount_percentage, 
			"discount_amount" => $discount_amount, 
			"notes" => $notes
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

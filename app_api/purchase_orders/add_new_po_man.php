<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		
		if( isset($_POST['requisition_id']) && 
		isset($_POST['supplier_id']) && 
		isset($_POST['currency_id']) && 
		isset($_POST['supplier_quotation_ref']) && 
		isset($_POST['delivery_period_id']) && 
		isset($_POST['payment_term_id'])  
		){
			
			
			
			$po_ref                   = "";
			$requisition_id           = (int) test_inputs($_POST['requisition_id']);
			$supplier_id              = (int) test_inputs($_POST['supplier_id']);
			$currency_id              = (int) test_inputs($_POST['currency_id']);
			
			
			
			$supplier_quotation_ref   = test_inputs($_POST['supplier_quotation_ref']);
			
			$delivery_period_id       = (int) test_inputs($_POST['delivery_period_id']);
			$payment_term_id          = (int) test_inputs($_POST['payment_term_id']);
			
			
			if( isset( $_POST['notes'] ) ){
				$notes = test_inputs($_POST['notes']);
			}
			if( $notes == 'undefined' ){
				$notes = "";
			}
			
			$po_ref = $_POST['po_ref'];
			
			$po_id = 0;
			
			$q = "UPDATE purchase_orders set supplier_id = $supplier_id , currency_id = $currency_id , supplier_quotation_ref = $supplier_quotation_ref , delivery_period_id = $delivery_period_id , payment_term_id = $payment_term_id , notes = '".$notes."' where po_ref = '".$po_ref."'";
			$insertStatement = mysqli_prepare($KONN,$q);
			mysqli_stmt_execute($insertStatement);
			$po_id = mysqli_insert_id($KONN);
			
			if( insert_state_change($KONN, "pending_approval"  , $po_id, "purchase_orders", $EMPLOYEE_ID) ) {
				die("1|purchase_orders.php");
				} else {
				die('0|Data Status Error 65154');
			}
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			}  else {
			die('0|'.mysqli_error($KONN));
		
			}
		
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
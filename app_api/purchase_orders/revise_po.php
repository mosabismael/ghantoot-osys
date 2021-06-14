<?php
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		if( !isset( $_POST['po_id'] ) ){
			die('0|ERR_REQ_4568674653');
		}
		
		$po_id = ( int ) $_POST['po_id'];
		$created_by = 0;
		
		$qu_purchase_orders_updt = "INSERT INTO purchase_orders_revision (po_id , po_ref , rev_no, po_date , delivery_date , delivery_period_id, discount_percentage , discount_amount , is_vat_included , payment_term_id , currency_id, exchange_rate , supplier_quotation_ref , attached_supplier_quotation , notes , po_status , supplier_id , requisition_id , job_order_id , employee_id , approved_by , approved_by_date , approved_acc_by, approved_acc_by_date , man_by , man_by_date , attached_supplier_quotation1) SELECT po_id , po_ref , rev_no, po_date , delivery_date , delivery_period_id, discount_percentage , discount_amount , is_vat_included , payment_term_id , currency_id, exchange_rate , supplier_quotation_ref , attached_supplier_quotation , notes , po_status , supplier_id , requisition_id , job_order_id , employee_id , approved_by , approved_by_date , approved_acc_by, approved_acc_by_date , man_by , man_by_date , attached_supplier_quotation1 FROM purchase_orders WHERE po_id = $po_id;";
		$updateStatement = mysqli_prepare($KONN,$qu_purchase_orders_updt);
		mysqli_stmt_execute($updateStatement);
		
		$date_add = Date('y:m:d', strtotime('+3 days'));
		
		$qu_pur_requisitions_updt = "INSERT INTO  `users_notifications` (`notification_title`, `notification_content`, `notification_link`, `sender_id`, `receiver_id`, `notification_time`, `is_notified`, `po_id`, `requisition_id`) 
		values ('draft_po', '$po_id is po drafted', 'purchase_orders_draft.php', $EMPLOYEE_ID , $EMPLOYEE_ID, '$date_add'  , 0, $po_id, '');";
		$updateStatement = mysqli_prepare($KONN,$qu_pur_requisitions_updt);
		mysqli_stmt_execute($updateStatement);
		
		
		
		$po_status = 'revised';
		$qu_purchase_orders_updt = "UPDATE  `purchase_orders` SET 
		`rev_no` = `rev_no` + 1, 
		`po_status` = '".$po_status."' 
		WHERE `po_id` = $po_id;";
		$updateStatement = mysqli_prepare($KONN,$qu_purchase_orders_updt);
		mysqli_stmt_execute($updateStatement);
		if( insert_state_change($KONN, $po_status, $po_id, "purchase_orders", $EMPLOYEE_ID) ){
			
			
			
			//change status back to draft
			$po_status = 'draft';
			$qu_purchase_orders_updt = "UPDATE  `purchase_orders` SET 
			`po_status` = '".$po_status."' 
			WHERE `po_id` = $po_id;";
			$updateStatement = mysqli_prepare($KONN,$qu_purchase_orders_updt);
			mysqli_stmt_execute($updateStatement);
			if( insert_state_change($KONN, $po_status, $po_id, "purchase_orders", $created_by) ){
				//change status back to draft
				die("1|Good");
				} else {
				die('0|Component State Error 01');
			}
			
			
			
			} else {
		die('0|Component State Error 01');
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
				
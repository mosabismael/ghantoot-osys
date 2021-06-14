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
		$approved_acc_by = 0;
		$po_id           = ( int ) $_POST['po_id'];
		
		$qu_purchase_orders_sel = "SELECT `approved_acc_by` FROM  `purchase_orders` WHERE `po_id` = $po_id";
		$userStatement = mysqli_prepare($KONN,$qu_purchase_orders_sel);
		mysqli_stmt_execute($userStatement);
		$qu_purchase_orders_EXE = mysqli_stmt_get_result($userStatement);
		$purchase_orders_DATA;
		if(mysqli_num_rows($qu_purchase_orders_EXE)){
			$purchase_orders_DATA = mysqli_fetch_assoc($qu_purchase_orders_EXE);
			$approved_acc_by = ( int ) $purchase_orders_DATA['approved_acc_by'];
		}
		
		
		
		
		$date_add = Date('y:m:d', strtotime('+3 days'));
		
		$qu_pur_requisitions_updt = "INSERT INTO  `users_notifications` (`notification_title`, `notification_content`, `notification_link`, `sender_id`, `receiver_id`, `notification_time`, `is_notified`, `po_id`, `requisition_id`) 
		values ('pending_acc_approval', '$po_id is pending approval', 'purchase_orders_draft.php', $EMPLOYEE_ID , $approved_acc_by, '$date_add'  , 0, $po_id, '');";
		$updateStatement = mysqli_prepare($KONN,$qu_pur_requisitions_updt);
		mysqli_stmt_execute($updateStatement);
		
		
		
		
		
		
		
		
		
		$approved_by_date = date('Y-m-d H:i:00');
		
		$po_status = 'pending_acc_approval';
		
		$current_state_id = get_current_state_id($KONN, $po_id, 'purchase_orders' );
		if( $current_state_id != 0 ){
			if( !insert_state_change_dep($KONN, "App-PO", $po_id, "PO-approved", 'purchase_orders', $EMPLOYEE_ID, $current_state_id) ){
				die('0|Component State Error 01');
			}
			} else {
			die('0|Component State Error 02');
		}
		
		
		$qu_purchase_orders_updt = "UPDATE  `purchase_orders` SET 
		`approved_by_date` = '".$approved_by_date."', 
		`po_status` = '".$po_status."'
		WHERE `po_id` = $po_id;";
	$updateStatement = mysqli_prepare($KONN,$qu_purchase_orders_updt);
	mysqli_stmt_execute($updateStatement);
	
	if( insert_state_change($KONN, $po_status, $po_id, "purchase_orders", $approved_acc_by) ){
	die("1|Good");
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
		
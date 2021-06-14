<?php
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		if( isset( $_POST['po_id'] ) && 
		isset( $_POST['approved_by'] ) && 
		isset( $_POST['approved_acc_by'] ) && 
		isset( $_POST['man_by'] ) ){
			
			$po_id            = ( int ) $_POST['po_id'];
			$approved_by      = ( int ) $_POST['approved_by'];
			$approved_acc_by  = ( int ) $_POST['approved_acc_by'];
			$man_by           = ( int ) $_POST['man_by'];
			
			
			
			
			$date_add = Date('y:m:d', strtotime('+3 days'));
			
			$qu_pur_requisitions_updt = "INSERT INTO  `users_notifications` (`notification_title`, `notification_content`, `notification_link`, `sender_id`, `receiver_id`, `notification_time`, `is_notified`, `po_id`, `requisition_id`) 
			values ('pending_approval', '$po_id is pending approval', 'purchase_orders_draft.php', $EMPLOYEE_ID , $approved_by, '$date_add'  , 0, $po_id, '');";
			$updateStatement = mysqli_prepare($KONN,$qu_pur_requisitions_updt);
			mysqli_stmt_execute($updateStatement);
			
			
			
			$po_status = 'activated';
			
			$qu_purchase_orders_updt = "UPDATE  `purchase_orders` SET 
			`approved_by` = '".$approved_by."', 
			`approved_acc_by` = '".$approved_acc_by."', 
			`man_by` = '".$man_by."', 
			`po_status` = '".$po_status."' 
			WHERE `po_id` = $po_id;";
			$updateStatement = mysqli_prepare($KONN,$qu_purchase_orders_updt);
			mysqli_stmt_execute($updateStatement);
			if( insert_state_change($KONN, $po_status, $po_id, "purchase_orders", $EMPLOYEE_ID) ){
				
				
				
				
				$po_status = 'pending_approval';
				$qu_purchase_orders_updt02 = "UPDATE  `purchase_orders` SET 
				`po_status` = '".$po_status."' , view_status = 0
				WHERE `po_id` = $po_id;";
				$updateStatement = mysqli_prepare($KONN,$qu_purchase_orders_updt02);
				mysqli_stmt_execute($updateStatement);
				
				if( insert_state_change($KONN, $po_status, $po_id, "purchase_orders", $approved_by) ){
					$requisition_id = 0;
					$po_req_sel = "SELECT `requisition_id` FROM `purchase_orders` where po_id = $po_id;";
					$qu_purchase_orders_apps_EXE = mysqli_query($KONN, $po_req_sel);
					if(mysqli_num_rows($qu_purchase_orders_apps_EXE)){
						while($purchase_orders_apps_REC = mysqli_fetch_assoc($qu_purchase_orders_apps_EXE)){
							$requisition_id = $purchase_orders_apps_REC['requisition_id'];
						}
					}
					
					die("1|requisitions_waiting_supplier.php?finish=".$requisition_id);
					} else {
					die('0|Component State Error 0222');
				}
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				} else {
				die('0|Component State Error 01');
			}
			
			
			
			} else {
			die('0|ERR_REQ_4568674653');
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

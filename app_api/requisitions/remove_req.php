<?php
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		if( !isset( $_POST['requisition_id'] ) ){
			die('0|ERR_REQ_4568674653');
		}
		
		$requisition_id = ( int ) $_POST['requisition_id'];
		
		
		
		
		
		
		
		//check if there is generated PO from this requisition 
		$qu_purchase_orders_sel = "SELECT COUNT(`po_id`) FROM  `purchase_orders` WHERE `requisition_id` = $requisition_id";
		$qu_purchase_orders_EXE = mysqli_query($KONN, $qu_purchase_orders_sel);
		$purchase_orders_DATA;
		if(mysqli_num_rows($qu_purchase_orders_EXE)){
			$purchase_orders_DATA = mysqli_fetch_array($qu_purchase_orders_EXE);
			$poCOUNTS = ( int ) $purchase_orders_DATA[0];
			if( $poCOUNTS > 0 ){
				die('0|Requisition Cannot be deleted, PO attached has been created');
			}
		}

		
		
		
		$date_add = Date('y:m:d', strtotime('+3 days'));
		
		$qu_pur_requisitions_updt = "INSERT INTO  `users_notifications` (`notification_title`, `notification_content`, `notification_link`, `sender_id`, `receiver_id`, `notification_time`, `is_notified`, `po_id`, `requisition_id`) 
		values ('delete_req', '$requisition_id is deleted', 'requisitions_my.php', $EMPLOYEE_ID , $EMPLOYEE_ID, '$date_add'  , 0, '', $requisition_id);";
		$updateStatement = mysqli_prepare($KONN,$qu_pur_requisitions_updt);
		mysqli_stmt_execute($updateStatement);
		
		
		
		
		
		
		$requisition_status = 'deleted';
		
		$qu_pur_requisitions_updt = "UPDATE  `pur_requisitions` SET 
		`requisition_status` = '".$requisition_status."'
		WHERE `requisition_id` = $requisition_id;";
		$updateStatement = mysqli_prepare($KONN,$qu_pur_requisitions_updt);
		mysqli_stmt_execute($updateStatement);
		if( insert_state_change($KONN, $requisition_status, $requisition_id, "pur_requisitions", $EMPLOYEE_ID) ){
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

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
		
		
		
		$date_add = Date('y:m:d', strtotime('+3 days'));
		$qu_pur_requisitions_sel = "SELECT employee_id FROM  `purchase_orders` WHERE ( ( `po_id` = $po_id )  )";
		$qu_pur_requisitions_EXE = mysqli_query($KONN, $qu_pur_requisitions_sel);
		if(mysqli_num_rows($qu_pur_requisitions_EXE)){
			while($pur_requisitions_DATA = mysqli_fetch_array($qu_pur_requisitions_EXE)){
				$emp_id = $pur_requisitions_DATA['employee_id'];
				
				$qu_pur_requisitions_updt = "INSERT INTO  `users_notifications` (`notification_title`, `notification_content`, `notification_link`, `sender_id`, `receiver_id`, `notification_time`, `is_notified`, `po_id`, `requisition_id`) 
				values ('pm_denied', '$po_id is po denied', 'purchase_orders_draft.php', $EMPLOYEE_ID , $emp_id, '$date_add'  , 0, $po_id, '');";
				$updateStatement = mysqli_prepare($KONN,$qu_pur_requisitions_updt);
				mysqli_stmt_execute($updateStatement);
			}
		}
		
		$po_status = 'pm_denied';
		
		$qu_purchase_orders_updt = "UPDATE  `purchase_orders` SET 
		`po_status` = '".$po_status."'
		WHERE `po_id` = $po_id;";
		$updateStatement = mysqli_prepare($KONN,$qu_purchase_orders_updt);
		mysqli_stmt_execute($updateStatement);
		if( insert_state_change($KONN, $po_status, $po_id, "purchase_orders", $EMPLOYEE_ID) ){
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

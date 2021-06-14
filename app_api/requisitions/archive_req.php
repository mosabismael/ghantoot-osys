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
		
		
		/*$qQ = "SELECT COUNT(`req_item_id`) FROM `pur_requisitions_items` WHERE requisition_id = $requisition_id";
		$userStatement = mysqli_prepare($KONN,$qQ);
		mysqli_stmt_execute($userStatement);
		$q_exe = mysqli_stmt_get_result($userStatement);
		$result = mysqli_fetch_array($q_exe);
		$count = $result[0];
		if($count == 0){
			die("0|Requisition cannot be sent to archive. No item found.");
		}*/
		
		
		$requisition_status = 'archive';
		
		/*$qu_pur_requisitions_updt = "UPDATE  `pur_requisitions` SET 
		`requisition_status` = '".$requisition_status."' , view_status = 0
		WHERE `requisition_id` = $requisition_id;";
		$updateStatement = mysqli_prepare($KONN,$qu_pur_requisitions_updt);
		mysqli_stmt_execute($updateStatement);*/
		
		$date_add = Date('y:m:d', strtotime('+3 days'));
		
		$qu_pur_requisitions_updt = "INSERT INTO  `users_notifications` (`notification_title`, `notification_content`, `notification_link`, `sender_id`, `receiver_id`, `notification_time`, `is_notified`, `po_id`, `requisition_id`) 
		values ('archive_req', '$requisition_id is archived', 'requisitions_my.php', $EMPLOYEE_ID , $EMPLOYEE_ID, '$date_add'  , 0, '', $requisition_id);";
		$updateStatement = mysqli_prepare($KONN,$qu_pur_requisitions_updt);
		mysqli_stmt_execute($updateStatement);
		
			// die("1|Good");
			
			
			
			
			//convert to waiting_rfq
			
			$requisition_status = 'archive';
			
			$qu_pur_updt = "UPDATE  `pur_requisitions` SET 
			`requisition_status` = '".$requisition_status."'
			WHERE `requisition_id` = $requisition_id;";
			$updateStatement = mysqli_prepare($KONN,$qu_pur_updt);
			mysqli_stmt_execute($updateStatement);
			
			//get procurment id
			$pID = 119;
			die("1|Good");
			
			
			
			
			
			
			
			
			
			
			
			
			
		
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

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
		
		
		$qQ = "SELECT COUNT(`req_item_id`) FROM `pur_requisitions_items` WHERE requisition_id = $requisition_id";
		$userStatement = mysqli_prepare($KONN,$qQ);
		mysqli_stmt_execute($userStatement);
		$q_exe = mysqli_stmt_get_result($userStatement);
		$result = mysqli_fetch_array($q_exe);
		$count = $result[0];
		if($count == 0){
			die("0|Requisition cannot be sent for appoval. No item found.");
		}
		
		
		
		$date_add = Date('y:m:d', strtotime('+3 days'));
		
		$qu_pur_requisitions_updt = "INSERT INTO  `users_notifications` (`notification_title`, `notification_content`, `notification_link`, `sender_id`, `receiver_id`, `notification_time`, `is_notified`, `po_id`, `requisition_id`) 
		values ('approve_req', '$requisition_id is sent to purchase', 'requisitions_my.php', $EMPLOYEE_ID , $EMPLOYEE_ID, '$date_add'  , 0, '', $requisition_id);";
		$updateStatement = mysqli_prepare($KONN,$qu_pur_requisitions_updt);
		mysqli_stmt_execute($updateStatement);
		
		
		$qu_pur_requisitions_sel = "SELECT employee_id FROM  `users` WHERE ( ( `dept_code` = 'PUR' )  ) group by employee_id";
		$qu_pur_requisitions_EXE = mysqli_query($KONN, $qu_pur_requisitions_sel);
		if(mysqli_num_rows($qu_pur_requisitions_EXE)){
			while($pur_requisitions_DATA = mysqli_fetch_array($qu_pur_requisitions_EXE)){
				
				$emp_id = $pur_requisitions_DATA['employee_id'];
				$qu_pur_requisitions_updt = "INSERT INTO  `users_notifications` (`notification_title`, `notification_content`, `notification_link`, `sender_id`, `receiver_id`, `notification_time`, `is_notified`, `po_id`, `requisition_id`) 
				values ('approve_req', '$requisition_id is sent for approval', 'requisitions_my.php', $EMPLOYEE_ID , $emp_id , '$date_add'  , 0, '', $requisition_id);";
				$updateStatement = mysqli_prepare($KONN,$qu_pur_requisitions_updt);
				mysqli_stmt_execute($updateStatement);
				
			}
		}
		
		$requisition_status = 'sent_to_purchase';
		
		$qu_pur_requisitions_updt = "UPDATE  `pur_requisitions` SET 
		`requisition_status` = '".$requisition_status."' 
		WHERE `requisition_id` = $requisition_id;";
		$updateStatement = mysqli_prepare($KONN,$qu_pur_requisitions_updt);
		mysqli_stmt_execute($updateStatement);
		if( insert_state_change($KONN, $requisition_status, $requisition_id, "pur_requisitions", $EMPLOYEE_ID) ){
			// die("1|Good");
			
			
			
			
			//convert to waiting_rfq
			
			$requisition_status = 'waiting_rfq';
			
			$qu_pur_updt = "UPDATE  `pur_requisitions` SET 
			`requisition_status` = '".$requisition_status."'
		WHERE `requisition_id` = $requisition_id;";
		$updateStatement = mysqli_prepare($KONN,$qu_pur_updt);
		mysqli_stmt_execute($updateStatement);
		
		//get procurment id
		$pID = 119;
		if( insert_state_change($KONN, $requisition_status, $requisition_id, "pur_requisitions", $pID) ){
			die("1|Good");
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
				
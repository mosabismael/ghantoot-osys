<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		if( isset($_POST['requisition_type']) &&
		isset($_POST['requisition_status']) && 
		isset($_POST['required_date']) && 
		isset($_POST['is_material']) && 
		isset($_POST['job_order_id']) 
		){
			
			
			$requisition_id = 0;
			$created_date = date('Y-m-d H:i:00');
			$required_date = test_inputs($_POST['required_date']);
			
			$is_material = ( int ) test_inputs($_POST['is_material']);
			
			$requisition_ref = "";
			$requisition_status = test_inputs($_POST['requisition_status']);
			
			$requisition_type = test_inputs($_POST['requisition_type']);
			
			$job_order_id = (int) test_inputs($_POST['job_order_id']);
			
			
			$ordered_by = $EMPLOYEE_ID;
			
			
			$requisition_notes = "";
			if( isset($_POST['requisition_notes']) ){
				$requisition_notes = test_inputs( $_POST['requisition_notes'] );
			}
			if( $requisition_notes == 'undefined' ){
				$requisition_notes = '';
			}
			
			if( $requisition_type != 'joborder' ){
				$job_order_id = '0';
			}
			
			
			//get requisition_ref
			$tot_count_DB = 0;
			$qu_inquiries_sel = "SELECT COUNT(`requisition_id`) FROM  `pur_requisitions`";
			$userStatement = mysqli_prepare($KONN,$qu_inquiries_sel);
			mysqli_stmt_execute($userStatement);
			$qu_inquiries_EXE = mysqli_stmt_get_result($userStatement);
			$inquiries_DATA;
			if(mysqli_num_rows($qu_inquiries_EXE)){
				$inquiries_DATA = mysqli_fetch_array($qu_inquiries_EXE);
				$tot_count_DB = (int) $inquiries_DATA [0];
			}
			$nwNO = $tot_count_DB + 1;
			$tot_count_DB_res = "";
			if($tot_count_DB < 10){
				$tot_count_DB_res = '0000'.$nwNO;
				} else if( $tot_count_DB >= 10 && $tot_count_DB < 100 ){
				$tot_count_DB_res = '000'.$nwNO;
				} else if( $tot_count_DB >= 100 && $tot_count_DB < 1000 ){
				$tot_count_DB_res = '00'.$nwNO;
				} else if( $tot_count_DB >= 1000 && $tot_count_DB < 10000 ){
				$tot_count_DB_res = '0'.$nwNO;
				} else if( $tot_count_DB >= 10000 && $tot_count_DB < 100000 ){
				$tot_count_DB_res = ''.$nwNO;
				} else {
				$tot_count_DB_res = "NaN";
			}
			$requisition_ref = $DEPT_CODE."-RQ".$tot_count_DB_res;
			
			
			
			
			$qu_pur_requisitions_ins = "INSERT INTO `pur_requisitions` (
			`created_date`, 
			`required_date`, 
			`requisition_ref`, 
			`requisition_type`, 
			`job_order_id`, 
			`requisition_status`, 
			`requisition_notes`, 
			`is_material`, 
			`ordered_by` 
			) VALUES (
			'".$created_date."', 
			'".$required_date."', 
			'".$requisition_ref."', 
			'".$requisition_type."', 
			'".$job_order_id."', 
			'".$requisition_status."', 
			'".$requisition_notes."', 
			'".$is_material."', 
			'".$ordered_by."' 
			);";
			$insertStatement = mysqli_prepare($KONN,$qu_pur_requisitions_ins);
			mysqli_stmt_execute($insertStatement);
			$requisition_id = mysqli_insert_id($KONN);
			
			
			$date_add = Date('y:m:d', strtotime('+3 days'));
			
			$qu_pur_requisitions_updt = "INSERT INTO  `users_notifications` (`notification_title`, `notification_content`, `notification_link`, `sender_id`, `receiver_id`, `notification_time`, `is_notified`, `po_id`, `requisition_id`) 
			values ('draft_req', '$requisition_id is created', 'requisitions_my.php', $EMPLOYEE_ID , $EMPLOYEE_ID, '$date_add'  , 0, '', $requisition_id);";
			$updateStatement = mysqli_prepare($KONN,$qu_pur_requisitions_updt);
			mysqli_stmt_execute($updateStatement);
			
			
			
			
			
			if( insert_state_change($KONN, $requisition_status, $requisition_id, "pur_requisitions", $EMPLOYEE_ID) ) {
				die("1|Requisitions Added");
				} else {
				die('0|Data Status Error 65154');
			}
			
			
			
			
			
			
			
			
			
		
		} else {
		die('0|7wiu');
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
				
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
		
		
		$requisition_status = 'waiting_rfq';
		
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

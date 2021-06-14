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
		
		
		$po_status = 'pending_approval';
		
		
		//get po ref
		
		//get requisition_ref
		$po_ref = "";
		$tot_count_DB = 0;
		$qu_inquiries_sel = "SELECT COUNT(`po_id`) FROM  `purchase_orders` WHERE `po_date` LIKE '".date('Y-m-')."%'";
		$userStatement = mysqli_prepare($KONN,$qu_inquiries_sel);
		mysqli_stmt_execute($userStatement);
		$qu_inquiries_EXE = mysqli_stmt_get_result($userStatement);
		$inquiries_DATA;
		if(mysqli_num_rows($qu_inquiries_EXE)){
			$inquiries_DATA = mysqli_fetch_array($qu_inquiries_EXE);
			$tot_count_DB = (int) $inquiries_DATA [0];
		}
		$tot_count_DB = $tot_count_DB + 1;
		$tot_count_DB_res = $tot_count_DB;
		if($tot_count_DB < 10){
			$tot_count_DB_res = '0'.$tot_count_DB;
		}
		$po_ref = "PO".date('Ymd').$tot_count_DB_res;
		$po_date = date('Y-m-d H:i:00');
		
		$qu_purchase_orders_updt = "UPDATE  `purchase_orders` SET 
		`po_ref` = '".$po_ref."', 
		`po_date` = '".$po_date."', 
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

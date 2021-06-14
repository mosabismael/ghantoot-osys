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
		
		
		$po_status = 'activated';
		
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

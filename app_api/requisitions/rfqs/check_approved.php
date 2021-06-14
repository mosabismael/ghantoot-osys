<?php
	
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	if(!isset($_POST['requisition_id'])){
		die('7wiu');
	}
	if(!isset($_POST['req_item_id'])){
		die('7wiu02');
	}
	
	$requisition_id = (int) $_POST['requisition_id'];
	$req_item_id    = (int) $_POST['req_item_id'];
	
	$isApproved = false;
	$APP_pl_record_id = 0;
	$qu_pur_requisitions_pls_items_sel = "SELECT * FROM  `pur_requisitions_pls_items` WHERE 
	((`requisition_id` = $requisition_id) AND 
	(`is_approved` = '1') AND 
	(`requisition_item_id` = $req_item_id));";
	$userStatement = mysqli_prepare($KONN,$qu_pur_requisitions_pls_items_sel);
	mysqli_stmt_execute($userStatement);
	$qu_pur_requisitions_pls_items_EXE = mysqli_stmt_get_result($userStatement);
	$pur_requisitions_pls_items_DATA;
	if( mysqli_num_rows($qu_pur_requisitions_pls_items_EXE) == 1 ){
		$pur_requisitions_pls_items_DATA = mysqli_fetch_assoc($qu_pur_requisitions_pls_items_EXE);
		$APP_pl_record_id = ( int ) $pur_requisitions_pls_items_DATA['pl_record_id'];
		$isApproved = true;
	}
	$IAM_ARRAY[] = array( "is_approved" => $isApproved);
	echo json_encode($IAM_ARRAY);
?>
<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	try{
		if( isset($_POST['requisition_id']) && 
		isset($_POST['supplier_id']) && 
		isset($_POST['rfq_id']) && 
		isset($_POST['price_list_id']) && 
		isset($_POST['pl_record_id']) && 
		isset($_POST['req_item_id']) 
		){
			
			
			$requisition_id = (int) test_inputs($_POST['requisition_id']);
			$supplier_id    = (int) test_inputs($_POST['supplier_id']);
			$rfq_id         = (int) test_inputs($_POST['rfq_id']);
			$price_list_id  = (int) test_inputs($_POST['price_list_id']);
			$pl_record_id   = (int) test_inputs($_POST['pl_record_id']);
			$req_item_id    = (int) test_inputs($_POST['req_item_id']);
			
			
			
			
			//load item id
			$qu_pur_requisitions_pls_items_updt = "UPDATE  `pur_requisitions_pls_items` SET 
			`is_approved` = '1'
			WHERE ((`requisition_id` = $requisition_id) AND 
			(`supplier_id` = $supplier_id) AND 
			(`rfq_id` = $rfq_id) AND 
			(`price_list_id` = $price_list_id) AND 
			(`pl_record_id` = $pl_record_id) AND 
			(`requisition_item_id` = $req_item_id));";
			$updateStatement = mysqli_prepare($KONN,$qu_pur_requisitions_pls_items_updt);
			mysqli_stmt_execute($updateStatement);
			
			die("1|Price Approved");
			
			
			
			
			}  else {
			die('0|bad req 54545');
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
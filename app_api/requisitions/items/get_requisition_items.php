<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	$IAM_ARRAY = array();
	try{
		if( isset($_POST['req_item_id']) ){
			
			
			$req_item_id = ( int ) test_inputs($_POST['req_item_id']);
			$requisition_id = 0;
			
			//get item data
			$qu_pur_requisitions_items_sel = "SELECT * FROM  `pur_requisitions_items` WHERE `req_item_id` = $req_item_id";
			$userStatement = mysqli_prepare($KONN,$qu_pur_requisitions_items_sel);
			mysqli_stmt_execute($userStatement);
			$qu_pur_requisitions_items_EXE = mysqli_stmt_get_result($userStatement);
			$ARRAY_SRC;
			if( mysqli_num_rows($qu_pur_requisitions_items_EXE) == 1 ){
				$ARRAY_SRC = mysqli_fetch_assoc($qu_pur_requisitions_items_EXE);
				} else {
				die("0|failed item");
			}
			
			
			
			
			
			$IAM_ARRAY[] = array(  "req_item_id" => $ARRAY_SRC['req_item_id'], 
			"family_id" => $ARRAY_SRC['family_id'], 
			"section_id" => $ARRAY_SRC['section_id'], 
			"division_id" => $ARRAY_SRC['division_id'], 
			"subdivision_id" => $ARRAY_SRC['subdivision_id'], 
			"category_id" => $ARRAY_SRC['category_id'], 
			"item_code_id" => $ARRAY_SRC['item_code_id'], 
			"item_qty" => $ARRAY_SRC['item_qty'], 
			"certificate_required" => $ARRAY_SRC['certificate_required'], 
			"requisition_id" => $ARRAY_SRC['requisition_id'] 
			);
			
			
			echo json_encode($IAM_ARRAY);
			
			
			
			
			
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

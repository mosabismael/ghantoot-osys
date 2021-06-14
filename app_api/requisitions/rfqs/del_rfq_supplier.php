<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	try{
		if( isset($_POST['rfq_item_id']) ){
			
			
			$rfq_item_id = ( int ) test_inputs($_POST['rfq_item_id']);
			$supplier_id = ( int ) test_inputs($_POST['supplier_id']);
			
			$requisition_id = 0;
			
			//get item data
			$actionChange = "RFQ_Item-DELETE";
			
			
			
			
			
			$qu_pur_requisitions_rfq_items_sel = "SELECT * FROM  `pur_requisitions_rfq_items` WHERE `rfq_item_id` = $rfq_item_id and supplier_id = $supplier_id;";
			$userStatement = mysqli_prepare($KONN,$qu_pur_requisitions_rfq_items_sel);
			mysqli_stmt_execute($userStatement);
			$qu_pur_requisitions_rfq_items_EXE = mysqli_stmt_get_result($userStatement);
			$pur_requisitions_rfq_items_DATA;
			if( mysqli_num_rows($qu_pur_requisitions_rfq_items_EXE) == 1 ){
				$pur_requisitions_rfq_items_DATA = mysqli_fetch_assoc($qu_pur_requisitions_rfq_items_EXE);
				} else {
				die("0|failed item");
			}
			$req_item_id = $pur_requisitions_rfq_items_DATA['req_item_id'];
			$rfq_id = $pur_requisitions_rfq_items_DATA['rfq_id'];
			
			
			
			
			$qu_pur_requisitions_rfq_items_del = "DELETE FROM `pur_requisitions_rfq` WHERE `rfq_id` = $rfq_id;";
			echo $qu_pur_requisitions_rfq_items_del;
			$deleteStatement = mysqli_prepare($KONN,$qu_pur_requisitions_rfq_items_del);
			
			mysqli_stmt_execute($deleteStatement);
			
			
			$qu_pur_requisitions_rfq_items_del = "DELETE FROM `pur_requisitions_rfq_items` WHERE `rfq_item_id` = $rfq_item_id and supplier_id = $supplier_id;";
			echo $qu_pur_requisitions_rfq_items_del;
			$deleteStatement = mysqli_prepare($KONN,$qu_pur_requisitions_rfq_items_del);
			
			mysqli_stmt_execute($deleteStatement);
			
			$current_state_id = get_current_state_id($KONN, $requisition_id, 'pur_requisitions' );
			if( $current_state_id != 0 ){
				if( insert_state_change_dep($KONN, $actionChange."-".$rfq_item_id, $rfq_item_id, "item_deleted", 'pur_requisitions_rfq_items', $EMPLOYEE_ID, $current_state_id) ){
					die('1|RFQ Item Deleted');
					} else {
					die('0|Component State Error 01');
				}
				} else {
				die('0|Component State Error 02');
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

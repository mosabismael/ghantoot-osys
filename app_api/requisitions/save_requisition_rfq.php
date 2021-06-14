<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		
		if( isset($_POST['requisition_id']) && isset($_POST['item_ids']) && isset($_POST['supplier_ids']) ){
			
			
			$requisition_id = 0;
			
			$requisition_id = (int) test_inputs($_POST['requisition_id']);
			
			$item_ids     = $_POST['item_ids'];
			$supplier_ids = $_POST['supplier_ids'];
			
			
			for( $E = 0 ; $E < count( $item_ids ) ; $E++ ){
				
				$item_id     = (int) test_inputs( $item_ids[$E] );
				$supplier_id = (int) test_inputs( $supplier_ids[$E] );
				
				
				$qu_pur_requisitions_items_updt = "UPDATE  `pur_requisitions_items` SET 
				`supplier_id` = '".$supplier_id."'
				WHERE ((`item_id` = $item_id) AND (`requisition_id` = $requisition_id));";
				$updateStatement = mysqli_prepare($KONN,$qu_pur_requisitions_items_updt);
				mysqli_stmt_execute($updateStatement);
				
				
			} // END OF LOOP
			
			
			$current_state_id = get_current_state_id($KONN, $requisition_id, 'pur_requisitions' );
			if( $current_state_id != 0 ){
				if( insert_state_change_dep($KONN, "RFQ_LIST_ADDED", $requisition_id, "RFQ", 'pur_requisitions_items', $EMPLOYEE_ID, $current_state_id) ){
					die('1|RFQ Saved');
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

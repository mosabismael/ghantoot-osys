<?php
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	
	try{
		
		
		
		if( isset($_POST['supplier_ids']) &&
		isset($_POST['req_items']) &&
		isset($_POST['requisition_id']) ){
			
			
			$requisition_id = ( int ) test_inputs( $_POST['requisition_id'] );
			$supplier_ids = $_POST['supplier_ids'];
			$req_items = $_POST['req_items'];
			
			$created_date = date('Y-m-d H:i:00');
			
			
			
			for( $E=0; $E < count( $supplier_ids ) ; $E++ ){
				$supplier_id = ( int ) test_inputs( $supplier_ids[$E] );
				
				
				
				$qu_pur_requisitions_rfq_ins = "INSERT INTO `pur_requisitions_rfq` (
				`supplier_id`, 
				`requisition_id`, 
				`created_date`, 
				`employee_id` 
				) VALUES (
				'".$supplier_id."', 
				'".$requisition_id."', 
				'".$created_date."', 
				'".$EMPLOYEE_ID."' 
				);";
				$insertStatement = mysqli_prepare($KONN,$qu_pur_requisitions_rfq_ins);
				mysqli_stmt_execute($insertStatement);
				$rfq_id = mysqli_insert_id($KONN);
				
				if( $rfq_id != 0 ){
					//insert items
					for( $Z=0; $Z < count( $req_items ) ; $Z++ ){
						$req_item_id = ( int ) test_inputs( $req_items[$Z] );					
						$qu_pur_requisitions_rfq_items_ins = "INSERT INTO `pur_requisitions_rfq_items` (
						`req_item_id`, 
						`supplier_id`, 
						`rfq_id` 
						) VALUES (
						'".$req_item_id."', 
						'".$supplier_id."', 
						'".$rfq_id."' 
						);";
						$insertStatement = mysqli_prepare($KONN,$qu_pur_requisitions_rfq_items_ins);
						mysqli_stmt_execute($insertStatement);
						
					}
				}
				
				
				
				
				//end of main loop
			}
			
			
			die('1|RFQ Inserted');
			
			} else {
			die('0|ERR_REQ_4568674653');
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

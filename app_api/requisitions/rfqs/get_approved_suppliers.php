<?php
	
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	
	try{
		if(!isset($_POST['requisition_id'])){
			die('7wiu');
		}
		
		$requisition_id = (int) $_POST['requisition_id'];
		
		
		
		$IAM_ARRAY;
		
		$q = "SELECT DISTINCT `supplier_id` FROM  `pur_requisitions_pls_items` WHERE 
		((`requisition_id` = $requisition_id) AND 
		(`is_approved` = '1'))";
		$userStatement = mysqli_prepare($KONN,$q);
		mysqli_stmt_execute($userStatement);
		$q_exe = mysqli_stmt_get_result($userStatement);
		
		
		
		if(mysqli_num_rows($q_exe) != 0){
			
			while( $ARRAY_SRC = mysqli_fetch_assoc($q_exe) ){
				$supplier_id = $ARRAY_SRC['supplier_id'];
				
				
				$qu_suppliers_list_sel = "SELECT `supplier_code`, `supplier_name` FROM  `suppliers_list` WHERE `supplier_id` = $supplier_id";
				$userStatement = mysqli_prepare($KONN,$qu_suppliers_list_sel);
				mysqli_stmt_execute($userStatement);
				$qu_suppliers_list_EXE = mysqli_stmt_get_result($userStatement);
				$suppliers_list_DATA;
				if(mysqli_num_rows($qu_suppliers_list_EXE)){
					$suppliers_list_DATA = mysqli_fetch_assoc($qu_suppliers_list_EXE);
				}
				$supplier_code = $suppliers_list_DATA['supplier_code'];
				$supplier_name = $suppliers_list_DATA['supplier_name'];
				
				$po_id = 0;	
				$po_status = "";
				$qu_purchase_orders_sel = "SELECT * FROM  `purchase_orders` WHERE 
				((`requisition_id` = $requisition_id) AND 
				(`supplier_id` = $supplier_id))";
				$userStatement = mysqli_prepare($KONN,$qu_purchase_orders_sel);
				mysqli_stmt_execute($userStatement);
				$qu_purchase_orders_EXE = mysqli_stmt_get_result($userStatement);
				$purchase_orders_DATA;
				if(mysqli_num_rows($qu_purchase_orders_EXE)){
					$purchase_orders_DATA = mysqli_fetch_assoc($qu_purchase_orders_EXE);
					$po_id = $purchase_orders_DATA['po_id'];
					$po_status = $purchase_orders_DATA['po_status'];
				}
				
				
				
				
				
				$IAM_ARRAY[] = array(   "supplier_id" => $ARRAY_SRC['supplier_id'], 
				"po_id" => $po_id, 
				"supplier_code" => $supplier_code, 
				"supplier_name" => $supplier_name,
				"po_status" => $po_status
				);
			}
			
			} else {
			
			$IAM_ARRAY[] = array(  "rfq_id" => 0, 
			"supplier_id" => 0, 
			"requisition_id" => 0, 
			"created_date" => 0, 
			"employee_id" => 0 ,
			"po_status" =>""
			);
			
			
		}
		
		
		echo json_encode($IAM_ARRAY);
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

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
		
		$q = "SELECT * FROM  `pur_requisitions_rfq` WHERE `requisition_id` = $requisition_id group by supplier_id";
		$userStatement = mysqli_prepare($KONN,$q);
		mysqli_stmt_execute($userStatement);
		$q_exe = mysqli_stmt_get_result($userStatement);
		
		if(mysqli_num_rows($q_exe) != 0){
			
			while( $ARRAY_SRC = mysqli_fetch_assoc($q_exe) ){
				$supplier_id = $ARRAY_SRC['supplier_id'];
				$rfq_id = $ARRAY_SRC['rfq_id'];
				
				$qu_suppliers_list_sel = "SELECT `supplier_code`, `supplier_name`, `supplier_email` FROM  `suppliers_list` WHERE `supplier_id` = $supplier_id";
				$userStatement = mysqli_prepare($KONN,$qu_suppliers_list_sel);
		mysqli_stmt_execute($userStatement);
		$qu_suppliers_list_EXE = mysqli_stmt_get_result($userStatement);
				$suppliers_list_DATA;
				if(mysqli_num_rows($qu_suppliers_list_EXE)){
					$suppliers_list_DATA = mysqli_fetch_assoc($qu_suppliers_list_EXE);
				}
				$supplier_code = $suppliers_list_DATA['supplier_code'];
				$supplier_name = $suppliers_list_DATA['supplier_name'];
				$supplier_email = $suppliers_list_DATA['supplier_email'];
				
				
				
				$qu_pur_requisitions_pls_sel = "SELECT `price_list_id` FROM  `pur_requisitions_pls` WHERE `rfq_id` = $rfq_id";
				$userStatement = mysqli_prepare($KONN,$qu_pur_requisitions_pls_sel);
		mysqli_stmt_execute($userStatement);
		$qu_pur_requisitions_pls_EXE = mysqli_stmt_get_result($userStatement);
				$pur_requisitions_pls_DATA;
				
				$price_list_id = 0;
				if(mysqli_num_rows($qu_pur_requisitions_pls_EXE)){
					$pur_requisitions_pls_DATA = mysqli_fetch_assoc($qu_pur_requisitions_pls_EXE);
					$price_list_id = ( int ) $pur_requisitions_pls_DATA['price_list_id'];
					
				}
				
				
				
				
				
				
				
				
				
				
				$IAM_ARRAY[] = array(  "rfq_id" => $ARRAY_SRC['rfq_id'], 
				"supplier_id" => $ARRAY_SRC['supplier_id'], 
				"supplier_code" => $supplier_code, 
				"supplier_name" => $supplier_name, 
				"supplier_email" => $supplier_email, 
				"requisition_id" => $ARRAY_SRC['requisition_id'], 
				"created_date" => $ARRAY_SRC['created_date'], 
				"price_list_id" => $price_list_id, 
				"employee_id" => $ARRAY_SRC['employee_id']
				);
			}
			
			} else {
			
			$IAM_ARRAY[] = array(  "rfq_id" => 0, 
			"supplier_id" => 0, 
			"requisition_id" => 0, 
			"created_date" => 0, 
			"employee_id" => 0 
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

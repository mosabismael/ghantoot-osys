<?php
	
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	$item_name = '';
	$reqItmID = 0;
	$IAM_ARRAY;
	try{
		$IAM_ARRAY[] = array(  "supplier_id" => 0, 
		"email" => "" 
		);
		
		
		
		if(!isset($_POST['requisition_id'])){
			die('7wiu');
		}
		
		if(!isset($_POST['req_item_ids'])){
			die('7wiu02');
		}
		
		$requisition_id = (int) test_inputs( $_POST['requisition_id'] );
		$req_item_ids_REQUEST = $_POST['req_item_ids'];
		$reqItms_ids = explode( '-', $req_item_ids_REQUEST );
		$preID = 0;
		
		for( $A=0 ; $A < count( $reqItms_ids ) ; $A++ ){
			$CC = $A + 1;
			$reqItmID = ( int ) $reqItms_ids[$A];
			
			
			
			$q = "SELECT `supplier_id` FROM  `pur_requisitions_rfq_items` WHERE `req_item_id` = $reqItmID";
			$userStatement = mysqli_prepare($KONN,$q);
			mysqli_stmt_execute($userStatement);
			$q_exe = mysqli_stmt_get_result($userStatement);
			if(mysqli_num_rows($q_exe) != 0){
				while( $ARRAY_SRC = mysqli_fetch_assoc($q_exe) ){
					$supplier_id = $ARRAY_SRC['supplier_id'];
					$qu_suppliers_list_sel = "SELECT * FROM  `suppliers_list` WHERE `supplier_id` = $supplier_id";
					$userStatement = mysqli_prepare($KONN,$qu_suppliers_list_sel);
					mysqli_stmt_execute($userStatement);
					$qu_suppliers_list_EXE = mysqli_stmt_get_result($userStatement);
					$thsEmail = "";
					if(mysqli_num_rows($qu_suppliers_list_EXE)){
						$suppliers_list_DATA = mysqli_fetch_assoc($qu_suppliers_list_EXE);
						$thsEmail = $suppliers_list_DATA['supplier_email'];
						if( $preID != $supplier_id ){
							$IAM_ARRAY[] = array(  "supplier_id" => $supplier_id, 
							"email" => $thsEmail 
							);
						}
						$preID = $supplier_id;
					}
				}
			}
			
			
			
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

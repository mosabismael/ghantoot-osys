<?php
	
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	try{
		
		if(!isset($_POST['rfq_id'])){
			die('7wiu');
		}
		
		$rfq_id = (int) $_POST['rfq_id'];
		
		
		
		$IAM_ARRAY;
		
		$q = "SELECT * FROM  `pur_requisitions_rfq_items` WHERE `rfq_id` = $rfq_id";
		$userStatement = mysqli_prepare($KONN,$q);
		mysqli_stmt_execute($userStatement);
		$q_exe = mysqli_stmt_get_result($userStatement);
		
		if(mysqli_num_rows($q_exe) != 0){
			
			while( $ARRAY_SRC = mysqli_fetch_assoc($q_exe) ){
				
				
				$rfq_item_id = $ARRAY_SRC['rfq_item_id'];
				$req_item_id = $ARRAY_SRC['req_item_id'];
				$supplier_id = $ARRAY_SRC['supplier_id'];
				
				
				
				$qu_pur_requisitions_items_sel = "SELECT * FROM  `pur_requisitions_items` WHERE `req_item_id` = $req_item_id";
				$userStatement = mysqli_prepare($KONN,$qu_pur_requisitions_items_sel);
				mysqli_stmt_execute($userStatement);
				$qu_pur_requisitions_items_EXE = mysqli_stmt_get_result($userStatement);
				$pur_requisitions_items_DATA;
				if(mysqli_num_rows($qu_pur_requisitions_items_EXE)){
					$pur_requisitions_items_DATA = mysqli_fetch_assoc($qu_pur_requisitions_items_EXE);
				}
				$req_item_id = $pur_requisitions_items_DATA['req_item_id'];
				$family_id = $pur_requisitions_items_DATA['family_id'];
				$section_id = $pur_requisitions_items_DATA['section_id'];
				$division_id = $pur_requisitions_items_DATA['division_id'];
				$subdivision_id = $pur_requisitions_items_DATA['subdivision_id'];
				$category_id = $pur_requisitions_items_DATA['category_id'];
				$item_code_id = $pur_requisitions_items_DATA['item_code_id'];
				$item_qty = $pur_requisitions_items_DATA['item_qty'];
				$certificate_required = $pur_requisitions_items_DATA['certificate_required'];
				$item_unit_id = $pur_requisitions_items_DATA['item_unit_id'];
				$requisition_id = $pur_requisitions_items_DATA['requisition_id'];
				
				
				
				
				//check if this item has prices inserted on this RFQ or no
				$item_price = 0;
				$qu_pur_requisitions_pls_items_sel = "SELECT `pl_item_price` FROM  `pur_requisitions_pls_items` 
				WHERE ((`requisition_item_id` = $req_item_id) 
				AND (`rfq_id` = $rfq_id) 
				AND (`requisition_id` = $requisition_id) )";
				$userStatement = mysqli_prepare($KONN,$qu_pur_requisitions_pls_items_sel);
				mysqli_stmt_execute($userStatement);
				$qu_pur_requisitions_pls_items_EXE = mysqli_stmt_get_result($userStatement);
				$pur_requisitions_pls_items_DATA;
				if(mysqli_num_rows($qu_pur_requisitions_pls_items_EXE)){
					$pur_requisitions_pls_items_DATA = mysqli_fetch_assoc($qu_pur_requisitions_pls_items_EXE);
					$item_price = $pur_requisitions_pls_items_DATA['pl_item_price'];
				}
				
				
				
				
				
				
				
				
				
				
				
				
				$item_unit_id = get_unit_name( $pur_requisitions_items_DATA['item_unit_id'], $KONN );
				
				$family_id = $pur_requisitions_items_DATA['family_id'];
				$lv2       = $pur_requisitions_items_DATA['section_id'];
				$lv3       = $pur_requisitions_items_DATA['division_id'];
				$lv4       = $pur_requisitions_items_DATA['subdivision_id'];
				$lv5       = $pur_requisitions_items_DATA['category_id'];
				
				//$item_name = get_item_name( $pur_requisitions_items_DATA['item_code_id'], $lv5, $lv4, $lv3, $lv2, 1, $KONN );
				$item_name = get_item_description( $pur_requisitions_items_DATA['req_item_id'], 'req_item_id', 'pur_requisitions_items', $KONN );
				
				$IAM_ARRAY[] = array(  "req_item_id" => $pur_requisitions_items_DATA['req_item_id'], 
				"family_id" => $pur_requisitions_items_DATA['family_id'], 
				"section_id" => $pur_requisitions_items_DATA['section_id'], 
				"division_id" => $pur_requisitions_items_DATA['division_id'], 
				"subdivision_id" => $pur_requisitions_items_DATA['subdivision_id'], 
				"category_id" => $pur_requisitions_items_DATA['category_id'], 
				"item_name" => $item_name, 
				"item_price" => $item_price, 
				"item_code_id" => $pur_requisitions_items_DATA['item_code_id'], 
				"item_qty" => $pur_requisitions_items_DATA['item_qty'], 
				"certificate_required" => $pur_requisitions_items_DATA['certificate_required'], 
				"item_unit_name" => $item_unit_id, 
				"item_unit_name02" => $item_unit_id, 
				"rfq_item_id" => $rfq_item_id, 
				"rfq_id" => $ARRAY_SRC['rfq_id'] 
				);
			}
			
			} else {
			
			$IAM_ARRAY[] = array(  "req_item_id" => 0, 
			"family_id" => 0, 
			"section_id" => 0, 
			"division_id" => 0, 
			"subdivision_id" => 0, 
			"category_id" => 0, 
			"item_code_id" => 0, 
			"item_qty" => 0, 
			"certificate_required" => 0, 
			"item_unit_id" => 0, 
			"rfq_id" => 0 
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

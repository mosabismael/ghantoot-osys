<?php
	
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	
	$requisition_id = 0;
	try{
		
		if(!isset($_POST['po_id'])){
			die('7wiu');
		}
		
		$po_id = (int) $_POST['po_id'];
		$qu_purchase_orders_sel = "SELECT `requisition_id` FROM  `purchase_orders` WHERE `po_id` = $po_id";
		$userStatement = mysqli_prepare($KONN,$qu_purchase_orders_sel);
		mysqli_stmt_execute($userStatement);
		$qu_purchase_orders_EXE = mysqli_stmt_get_result($userStatement);
		$purchase_orders_DATA;
		if(mysqli_num_rows($qu_purchase_orders_EXE)){
			$purchase_orders_DATA = mysqli_fetch_assoc($qu_purchase_orders_EXE);
			$requisition_id = ( int ) $purchase_orders_DATA['requisition_id'];
		}
		
		$qu_purchase_orders_sel = "SELECT `is_material` FROM  `pur_requisitions` WHERE `requisition_id` = $requisition_id";
		$userStatement = mysqli_prepare($KONN,$qu_purchase_orders_sel);
		mysqli_stmt_execute($userStatement);
		$qu_purchase_orders_EXE = mysqli_stmt_get_result($userStatement);
		$purchase_orders_DATA;
		if(mysqli_num_rows($qu_purchase_orders_EXE)){
			$purchase_orders_DATA = mysqli_fetch_assoc($qu_purchase_orders_EXE);
			$is_material = ( int ) $purchase_orders_DATA['is_material'];
		}
		
		$IAM_ARRAY;
		
		$q = "SELECT * FROM  `purchase_orders_items` WHERE `po_id` = $po_id";
		$userStatement = mysqli_prepare($KONN,$q);
		mysqli_stmt_execute($userStatement);
		$q_exe = mysqli_stmt_get_result($userStatement);
		
		if(mysqli_num_rows($q_exe) != 0){
			
			while( $ARRAY_SRC = mysqli_fetch_assoc($q_exe) ){
				$item_unit_name = get_unit_name( $ARRAY_SRC['unit_id'], $KONN );
				
				$limited_id = ( int ) $ARRAY_SRC['limited_id'];
				
				$family_id = $ARRAY_SRC['family_id'];
				$lv2 = $ARRAY_SRC['section_id'];
				$lv3 = $ARRAY_SRC['division_id'];
				$lv4 = $ARRAY_SRC['subdivision_id'];
				$lv5 = $ARRAY_SRC['category_id'];
				$lv6 = $ARRAY_SRC['item_code_id'];
				$item_name = "NA";
				
				if( $limited_id == 0 ){
					$item_name = get_item_description( $ARRAY_SRC['po_item_id'], 'po_item_id', 'purchase_orders_items', $KONN );
					} else {
					$qu_purchase_orders_items_limited_list_sel = "SELECT * FROM  `purchase_orders_items_limited_list` WHERE `limited_id` = $limited_id";
					$qu_purchase_orders_items_limited_list_EXE = mysqli_query($KONN, $qu_purchase_orders_items_limited_list_sel);
					if(mysqli_num_rows($qu_purchase_orders_items_limited_list_EXE)){
						$purchase_orders_items_limited_list_DATA = mysqli_fetch_assoc($qu_purchase_orders_items_limited_list_EXE);
						$item_name = $purchase_orders_items_limited_list_DATA['limited_text'];
						$item_unit_name = "NA";
					}
					
				}
				
				
				
				//get the reg item ID
				$qu_pur_requisitions_items_sel = "SELECT `item_days`,`req_item_id` FROM  `pur_requisitions_items` WHERE 
				((`family_id` = $family_id) AND 
				(`section_id` = $lv2) AND 
				(`division_id` = $lv3) AND 
				(`subdivision_id` = $lv4) AND 
				(`category_id` = $lv5) AND 
				(`item_code_id` = $lv6) AND 
				(`requisition_id` = $requisition_id))";
				$userStatement = mysqli_prepare($KONN,$qu_pur_requisitions_items_sel);
				mysqli_stmt_execute($userStatement);
				$qu_pur_requisitions_items_EXE = mysqli_stmt_get_result($userStatement);
				$req_item_id = 0;
				if(mysqli_num_rows($qu_pur_requisitions_items_EXE)){
					$pur_requisitions_items_DATA = mysqli_fetch_assoc($qu_pur_requisitions_items_EXE);
					$req_item_id = ( int ) $pur_requisitions_items_DATA['req_item_id'];
					$item_days = ( int ) $pur_requisitions_items_DATA['item_days'];
				}
				
				
				
				$IAM_ARRAY[] = array(  "po_item_id" => $ARRAY_SRC['po_item_id'], 
				"family_id" => $ARRAY_SRC['family_id'], 
				"section_id" => $ARRAY_SRC['section_id'], 
				"division_id" => $ARRAY_SRC['division_id'], 
				"subdivision_id" => $ARRAY_SRC['subdivision_id'], 
				"category_id" => $ARRAY_SRC['category_id'], 
				"item_name" => $item_name, 
				"item_code_id" => $ARRAY_SRC['item_code_id'], 
				"item_qty" => $ARRAY_SRC['item_qty'], 
				"item_price" => $ARRAY_SRC['item_price'], 
				"certificate_required" => $ARRAY_SRC['certificate_required'], 
				"item_unit_name" => $item_unit_name, 
				"req_item_id" => $req_item_id, 
				"requisition_id" => $requisition_id, 
				"po_id" => $ARRAY_SRC['po_id'] ,
				"is_material" => $is_material,
				"item_days" => $item_days
				);
			}
			
			} else {
			
			$IAM_ARRAY[] = array(  "po_item_id" => 0, 
			"family_id" => 0, 
			"section_id" => 0, 
			"division_id" => 0, 
			"subdivision_id" => 0, 
			"category_id" => 0, 
			"item_code_id" => 0, 
			"item_qty" => 0, 
			"certificate_required" => 0, 
			"item_unit_id" => 0, 
			"po_id" => 0 
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

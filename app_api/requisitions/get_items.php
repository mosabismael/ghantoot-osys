<?php
	
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	try{
		
		if(!isset($_POST['requisition_id'])){
			die('7wiu');
		}
		
		$requisition_id = (int) $_POST['requisition_id'];
		
		
		
		$IAM_ARRAY;
		
		$q = "SELECT * FROM  `pur_requisitions_items` WHERE `requisition_id` = $requisition_id";
		$userStatement = mysqli_prepare($KONN,$q);
		mysqli_stmt_execute($userStatement);
		$q_exe = mysqli_stmt_get_result($userStatement);
		
		if(mysqli_num_rows($q_exe) != 0){
			
			while( $ARRAY_SRC = mysqli_fetch_assoc($q_exe) ){
				$item_unit_id = get_unit_name( $ARRAY_SRC['item_unit_id'], $KONN );
				
				$family_id = ( int ) $ARRAY_SRC['family_id'];
				$lv2       = ( int ) $ARRAY_SRC['section_id'];
				$lv3       = ( int ) $ARRAY_SRC['division_id'];
				$lv4       = ( int ) $ARRAY_SRC['subdivision_id'];
				$lv5       = ( int ) $ARRAY_SRC['category_id'];
				$lv6       = ( int ) $ARRAY_SRC['item_code_id'];
				
				$item_name = get_item_description( $ARRAY_SRC['req_item_id'], 'req_item_id', 'pur_requisitions_items', $KONN );
				
				
				//get item_stock_qty
				
				//check current stock for this item
				$qu_inv_stock_sel = "SELECT SUM(`qty`) FROM  `inv_stock` WHERE ((`family_id` = $family_id) AND 
				(`section_id` = $lv2) AND 
				(`division_id` = $lv3) AND 
				(`subdivision_id` = $lv4) AND 
				(`category_id` = $lv5) AND 
				(`item_code_id` = $lv6) AND 
				(`stock_status` = 'in_stock'))";
				$userStatement = mysqli_prepare($KONN,$qu_inv_stock_sel);
				mysqli_stmt_execute($userStatement);
				$qu_inv_stock_EXE = mysqli_stmt_get_result($userStatement);
				$item_stock_qty = 0;
				if(mysqli_num_rows($qu_inv_stock_EXE)){
					$inv_stock_DATA = mysqli_fetch_array($qu_inv_stock_EXE);
					$item_stock_qty = ( double ) $inv_stock_DATA[0];
				}
				
				
				
				
				$IAM_ARRAY[] = array(  "req_item_id" => $ARRAY_SRC['req_item_id'], 
				"family_id" => $ARRAY_SRC['family_id'], 
				"section_id" => $ARRAY_SRC['section_id'], 
				"division_id" => $ARRAY_SRC['division_id'], 
				"subdivision_id" => $ARRAY_SRC['subdivision_id'], 
				"category_id" => $ARRAY_SRC['category_id'], 
				"item_name" => $item_name, 
				"item_code_id" => $ARRAY_SRC['item_code_id'], 
				"item_qty" => $ARRAY_SRC['item_qty'], 
				"item_stock_qty" => $item_stock_qty, 
				"item_days" => $ARRAY_SRC['item_days'], 
				"certificate_required" => $ARRAY_SRC['certificate_required'], 
				"item_unit_id" => $item_unit_id, 
				"requisition_id" => $ARRAY_SRC['requisition_id'] 
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
			"requisition_id" => 0 
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

<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	try{
		if( isset($_POST['family_id']) &&
		isset($_POST['section_id']) &&
		isset($_POST['division_id']) &&
		isset($_POST['subdivision_id']) &&
		isset($_POST['category_id']) &&
		isset($_POST['item_code_id']) &&
		isset($_POST['item_qty']) && 
		isset($_POST['item_unit_id']) && 
		isset($_POST['certificate_required']) && 
		isset($_POST['item_days']) && 
		isset($_POST['requisition_id']) 
		){
			
			
			$req_item_id = 0;
			
			$family_id      = ( int ) test_inputs($_POST['family_id']);
			$section_id     = ( int ) test_inputs($_POST['section_id']);
			$division_id    = ( int ) test_inputs($_POST['division_id']);
			$subdivision_id = ( int ) test_inputs($_POST['subdivision_id']);
			$category_id    = ( int ) test_inputs($_POST['category_id']);
			$item_code_id   = ( int ) test_inputs($_POST['item_code_id']);
			
			$item_qty             = ( double ) test_inputs($_POST['item_qty']);
			$item_days            = test_inputs($_POST['item_days']);
			$item_unit_id         = test_inputs($_POST['item_unit_id']);
			$certificate_required = test_inputs($_POST['certificate_required']);
			$item_cr              = test_inputs($_POST['item_cr']);
			$requisition_id       = ( int ) test_inputs($_POST['requisition_id']);
			
			
			
			if( $item_cr == 'undefined' ){
				$certificate_required = "NO";
				} else {
				$certificate_required = $item_cr;
			}
			
			
			//check total number of items
			$qu_pur_requisitions_items_sel = "SELECT COUNT(`req_item_id`) FROM  `pur_requisitions_items` WHERE `requisition_id` = $requisition_id";
			$userStatement = mysqli_prepare($KONN,$qu_pur_requisitions_items_sel);
			mysqli_stmt_execute($userStatement);
			$qu_pur_requisitions_items_EXE = mysqli_stmt_get_result($userStatement);
			$totItems = 0;
			if(mysqli_num_rows($qu_pur_requisitions_items_EXE) > 0){
				$pur_requisitions_items_DATA = mysqli_fetch_array($qu_pur_requisitions_items_EXE);
				$totItems                    = ( int ) $pur_requisitions_items_DATA[0];
			}
			if( $totItems >= 10 ){
				die("0|Items Limit Exceeded for this requisition, Max Allowed is 10 Items only");
			}
			
			
			
			
			/*
				//check current stock for this item
				$qu_inv_stock_sel = "SELECT SUM(`qty`) FROM  `inv_stock` WHERE ((`family_id` = $family_id) AND 
				(`section_id` = $section_id) AND 
				(`division_id` = $division_id) AND 
				(`subdivision_id` = $subdivision_id) AND 
				(`category_id` = $category_id) AND 
				(`item_code_id` = $item_code_id) AND 
				(`stock_status` = 'in_stock'))";
				$qu_inv_stock_EXE = mysqli_query($KONN, $qu_inv_stock_sel);
				$totStock = 0;
				if(mysqli_num_rows($qu_inv_stock_EXE)){
				$inv_stock_DATA = mysqli_fetch_array($qu_inv_stock_EXE);
				$totStock = ( double ) $inv_stock_DATA[0];
				}
				
				
				if( $item_qty <= $totStock ){
				die('0|Item Available in the stock, Available Quantity is '.$totStock);
				}
				
				
			*/
			
			
			
			$actionChange = "New_Item";
			$hasOld = false;
			$ItemOldQty = 0;
			
			
			
			
			
			
			
			$qu_pur_requisitions_items_ins = "INSERT INTO `pur_requisitions_items` (
			`family_id`, 
			`section_id`, 
			`division_id`, 
			`subdivision_id`, 
			`category_id`, 
			`item_code_id`, 
			`item_qty`, 
			`item_days`, 
			`certificate_required`, 
			`item_unit_id`, 
			`requisition_id` 
			) VALUES (
			'".$family_id."', 
			'".$section_id."', 
			'".$division_id."', 
			'".$subdivision_id."', 
			'".$category_id."', 
			'".$item_code_id."', 
			'".$item_qty."', 
			'".$item_days."', 
			'".$certificate_required."', 
			'".$item_unit_id."', 
			'".$requisition_id."' 
			);";
			
			//check if item is added or no
			//if added then raise quantity otherwise add new item
			/*
				$qu_pur_requisitions_items_sel = "SELECT * FROM  `pur_requisitions_items` 
				WHERE ((`item_code_id` = '$item_code_id') AND (`requisition_id` = '$requisition_id'))";
				$qu_pur_requisitions_items_EXE = mysqli_query($KONN, $qu_pur_requisitions_items_sel);
				$pur_requisitions_items_DATA;
				if( mysqli_num_rows($qu_pur_requisitions_items_EXE) > 0 ){
				$pur_requisitions_items_DATA = mysqli_fetch_assoc($qu_pur_requisitions_items_EXE);
				$req_item_id = $pur_requisitions_items_DATA['req_item_id'];
				$ItemOldQty = (double) $pur_requisitions_items_DATA['item_qty'];
				$actionChange = "Item_quantity_change";
				$hasOld = true;
				$item_qty = $item_qty + $ItemOldQty;
				$qu_pur_requisitions_items_ins = "UPDATE  `pur_requisitions_items` SET 
				`item_qty` = '".$item_qty."' WHERE ( (`req_item_id` = $req_item_id) AND (`requisition_id` = '$requisition_id') );";
				}
			*/
			$insertStatement = mysqli_prepare($KONN,$qu_pur_requisitions_items_ins);
			mysqli_stmt_execute($insertStatement);
			if( $hasOld == false ){
				$req_item_id = mysqli_insert_id($KONN);
			}
			
			if( $req_item_id != 0 ){
				
				
				$STATE_name = "New_Item";
				
				
				
				$current_state_id = get_current_state_id($KONN, $requisition_id, 'pur_requisitions' );
				if( $current_state_id != 0 ){
					if( insert_state_change_dep($KONN, $actionChange."-".$requisition_id."(".$item_qty.")", $req_item_id, $STATE_name, 'pur_requisitions_items', $EMPLOYEE_ID, $current_state_id) ){
						die('1|Item Added');
						} else {
						die('0|Component State Error 01');
					}
					} else {
					die('0|Component State Error 02');
				}
				
				
				
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

<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	try{
		if( isset($_POST['requisition_id']) ){
			
			
			$requisition_id = 0;
			
			$requisition_id = (int) test_inputs($_POST['requisition_id']);
			
			//update requisition status
			
			$requisition_status = 'finished';
			
			$qu_pur_requisitions_updt = "UPDATE  `pur_requisitions` SET 
			`requisition_status` = '".$requisition_status."'
			WHERE `requisition_id` = $requisition_id;";
			$updateStatement = mysqli_prepare($KONN,$qu_pur_requisitions_updt);
			mysqli_stmt_execute($updateStatement);
			if( insert_state_change($KONN, $requisition_status, $requisition_id, "pur_requisitions", $EMPLOYEE_ID) ){
				
				
				//generate POs
				$qu_pur_requisitions_items_sel = "SELECT DISTINCT(`supplier_id`) FROM  `pur_requisitions_items` WHERE `requisition_id` = $requisition_id";
				$userStatement = mysqli_prepare($KONN,$qu_pur_requisitions_items_sel);
				mysqli_stmt_execute($userStatement);
				$qu_pur_requisitions_items_EXE = mysqli_stmt_get_result($userStatement);
				if(mysqli_num_rows($qu_pur_requisitions_items_EXE)){
					while($pur_requisitions_items_REC = mysqli_fetch_assoc($qu_pur_requisitions_items_EXE)){
						
						$rfq_id = 0;
						$supplier_id = $pur_requisitions_items_REC['supplier_id'];
						$created_date = date( 'Y-m-d H:i:00' );
						
						$qu_pur_requisitions_pls_sel = "SELECT * FROM  `pur_requisitions_pls` 
						WHERE ( (`supplier_id` = $supplier_id) AND 
						(`requisition_id` = $requisition_id) )";
						$userStatement = mysqli_prepare($KONN,$qu_pur_requisitions_pls_sel);
						mysqli_stmt_execute($userStatement);
						$qu_pur_requisitions_pls_EXE = mysqli_stmt_get_result($userStatement);
						$pur_requisitions_pls_DATA;
						if(mysqli_num_rows($qu_pur_requisitions_pls_EXE)){
							$pur_requisitions_pls_DATA = mysqli_fetch_assoc($qu_pur_requisitions_pls_EXE);
						}
						$price_list_id = $pur_requisitions_pls_DATA['price_list_id'];
						$currency_id = $pur_requisitions_pls_DATA['currency_id'];
						$exchange_rate = $pur_requisitions_pls_DATA['exchange_rate'];
						$is_vat_included = $pur_requisitions_pls_DATA['is_vat_included'];
						$vendor_quotation_ref = $pur_requisitions_pls_DATA['vendor_quotation_ref'];
						$attached_vendor_quotation = $pur_requisitions_pls_DATA['attached_vendor_quotation'];
						$delivery_period_id = $pur_requisitions_pls_DATA['delivery_period_id'];
						$discount_amount = $pur_requisitions_pls_DATA['discount_amount'];
						$notes = $pur_requisitions_pls_DATA['notes'];
						$rfq_id = $pur_requisitions_pls_DATA['rfq_id'];
						$requisition_id = $pur_requisitions_pls_DATA['requisition_id'];
						$supplier_id = $pur_requisitions_pls_DATA['supplier_id'];
						$added_date = $pur_requisitions_pls_DATA['added_date'];
						$employee_id = $pur_requisitions_pls_DATA['employee_id'];
						
						
						
						
						$po_status = 'draft';
						$qu_purchase_orders_ins = "INSERT INTO `purchase_orders` (
						`po_ref`, 
						`rev_no`, 
						`delivery_period_id`, 
						`discount_amount`, 
						`is_vat_included`, 
						`currency_id`, 
						`exchange_rate`, 
						`notes`, 
						`po_status`, 
						`price_list_id`, 
						`supplier_id`, 
						`requisition_id`, 
						`employee_id` 
						) VALUES (
						'', 
						'0', 
						'".$delivery_period_id."', 
						'".$discount_amount."', 
						'".$is_vat_included."',  
						'".$currency_id."', 
						'".$exchange_rate."', 
						'".$notes."', 
						'draft', 
						'".$price_list_id."', 
						'".$supplier_id."', 
						'".$requisition_id."', 
						'".$EMPLOYEE_ID."' 
						);";
						$insertStatement = mysqli_prepare($KONN,$qu_purchase_orders_ins);
						mysqli_stmt_execute($insertStatement);
						
						$po_id = mysqli_insert_id($KONN);
						if( $po_id != 0 ){
							//insert change for PO
							
							if( !insert_state_change($KONN, $po_status, $po_id, "purchase_orders", $EMPLOYEE_ID) ) {
								die('0|Data Status Error 8797896');
							}
							
							
							
							//insert PO items
							
							$qu_pur_requisitions_pls_items_sel = "SELECT * FROM  `pur_requisitions_pls_items` 
							WHERE (( `requisition_id` = $requisition_id ) 
							AND (`supplier_id` = $supplier_id ) 
							AND (`price_list_id` = $price_list_id ))";
							$userStatement = mysqli_prepare($KONN,$qu_pur_requisitions_pls_items_sel);
							mysqli_stmt_execute($userStatement);
							$qu_pur_requisitions_pls_items_EXE = mysqli_stmt_get_result($userStatement);
							if(mysqli_num_rows($qu_pur_requisitions_pls_items_EXE)){
								while($pur_requisitions_pls_items_REC = mysqli_fetch_assoc($qu_pur_requisitions_pls_items_EXE)){
									
									$item_code_id = ( double ) $pur_requisitions_pls_items_REC['item_code_id'];
									$requisition_item_id = ( int ) $pur_requisitions_pls_items_REC['requisition_item_id'];
									$item_qty = ( double ) $pur_requisitions_pls_items_REC['item_qty'];
									$item_price = ( double ) $pur_requisitions_pls_items_REC['pl_item_price'];
									
									$unit_id = get_item_unit_id( $item_code_id, $KONN );
									
									
									$qu_purchase_orders_items_ins = "INSERT INTO `purchase_orders_items` (
									`item_code_id`, 
									`unit_id`, 
									`item_qty`, 
									`item_price`, 
									`po_id` 
									) VALUES (
									'".$item_code_id."', 
									'".$unit_id."', 
									'".$item_qty."', 
									'".$item_price."', 
									'".$po_id."' 
									);";
									$insertStatement = mysqli_prepare($KONN,$qu_purchase_orders_items_ins);
									mysqli_stmt_execute($insertStatement);
									$po_item_id = mysqli_insert_id($KONN);
									
									$current_state_id = get_current_state_id($KONN, $po_id, 'purchase_orders' );
									if( $current_state_id != 0 ){
										if( !insert_state_change_dep($KONN, "NEW_Item-".$po_id."(".$item_qty.")", $po_item_id, "NI", 'purchase_orders_items', $EMPLOYEE_ID, $current_state_id) ){
											
											die('0|Component State Error 01');
										}
										} else {
										die('0|Component State Error 02');
									}
									
									
									
									
									
									
									
									
									
								}
							}
							
							
							
							
							
							
							
							
						}
						
						
						
						
						
						
						
						
						
						
						
					}
				}
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				die("1|Good");
				
				
				
				} else {
				die('0|Component State Error 01');
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
		
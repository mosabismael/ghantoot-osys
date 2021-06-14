<?php
	require_once('../../bootstrap/app_config.php');
	require_once('../../bootstrap/chk_log_user.php');
	
	$IAM_ARRAY = array();
	
	
	$CUR_PAGE = 0;
	$per_page = 20;
	$totPages = 0;
	$cond = "";
	if(isset($_POST['cond'])){
			$cond =   $_POST['cond'] ;
	}
	if( isset( $_POST['page'] ) ){
		$CUR_PAGE = ( int ) test_inputs( $_POST['page'] );
	}
	if( isset( $_POST['showperpage'] ) ){
		$per_page = ( int ) test_inputs( $_POST['showperpage'] );
	}
	
	$start=abs(($CUR_PAGE-1)*$per_page);
	
	
	
	
	
	
	$sNo = $start + 1;
	
	$qu_purchase_orders_sel = "SELECT * FROM  `purchase_orders` WHERE ( ((`po_status` <> 'draft') AND (`po_status` <> 'deleted')) $cond )  ORDER BY `po_id` DESC LIMIT $start,$per_page";
	
	
	$qu_purchase_orders_EXE = mysqli_query($KONN, $qu_purchase_orders_sel);
	if(mysqli_num_rows($qu_purchase_orders_EXE)){
		while($purchase_orders_REC = mysqli_fetch_assoc($qu_purchase_orders_EXE)){
			
			$po_id = $purchase_orders_REC['po_id'];
			$PO_REF = $purchase_orders_REC['po_ref'];
			$po_date = $purchase_orders_REC['po_date'];
			$supplier_id = $purchase_orders_REC['supplier_id'];
			$job_order_idT = $purchase_orders_REC['job_order_id'];
			
			$requisition_id = $purchase_orders_REC['requisition_id'];
			
			$job_order_ref    = "NA";
			$requisition_ref  = "NA";
			$REQ_created_date = "NA";
			
			if( $job_order_idT != 0 ){
				$qu_job_orders_sel = "SELECT * FROM  `job_orders` WHERE `job_order_id` = $job_order_idT";
				$qu_job_orders_EXE = mysqli_query($KONN, $qu_job_orders_sel);
				$job_orders_DATA;
				if(mysqli_num_rows($qu_job_orders_EXE)){
					$job_orders_DATA = mysqli_fetch_assoc($qu_job_orders_EXE);
				}
				$job_order_ref = $job_orders_DATA['job_order_ref'];
			}
			
			
			
			
			$qu_pur_requisitions_sel = "SELECT * FROM  `pur_requisitions` WHERE `requisition_id` = $requisition_id";
			$qu_pur_requisitions_EXE = mysqli_query($KONN, $qu_pur_requisitions_sel);
			$pur_requisitions_DATA;
			if(mysqli_num_rows($qu_pur_requisitions_EXE)){
				$pur_requisitions_DATA = mysqli_fetch_assoc($qu_pur_requisitions_EXE);
				$requisition_id = $pur_requisitions_DATA['requisition_id'];
				$created_date = explode(' ', $pur_requisitions_DATA['created_date']);
				
				
				
				$REQ_created_date = $created_date[0];
				
				$required_date = $pur_requisitions_DATA['required_date'];
				
				$requisition_ref = $pur_requisitions_DATA['requisition_ref'];
				
				// $job_order_id = $pur_requisitions_DATA['job_order_id'];
				// $requisition_status = $pur_requisitions_DATA['requisition_status'];
				// $requisition_notes = $pur_requisitions_DATA['requisition_notes'];
				// $rejection_notes = $pur_requisitions_DATA['rejection_notes'];
				// $ordered_by = $pur_requisitions_DATA['ordered_by'];
				// $is_material = $pur_requisitions_DATA['is_material'];
			}
			
			$qu_suppliers_list_sel = "SELECT * FROM  `suppliers_list` WHERE `supplier_id` = $supplier_id";
			$qu_suppliers_list_EXE = mysqli_query($KONN, $qu_suppliers_list_sel);
			$supplier = '';
			if(mysqli_num_rows($qu_suppliers_list_EXE)){
				$suppliers_list_DATA = mysqli_fetch_assoc($qu_suppliers_list_EXE);
				$supplier = $suppliers_list_DATA['supplier_name'];
			}
			
			
			
			$qu_purchase_orders_items_sel = "SELECT * FROM  `purchase_orders_items` WHERE `po_id` = $po_id";
			$qu_purchase_orders_items_EXE = mysqli_query($KONN, $qu_purchase_orders_items_sel);
			if(mysqli_num_rows($qu_purchase_orders_items_EXE)){
				while($purchase_orders_items_REC = mysqli_fetch_assoc($qu_purchase_orders_items_EXE)){
					$po_item_id = $purchase_orders_items_REC['po_item_id'];
					$family_id = $purchase_orders_items_REC['family_id'];
					$section_id = $purchase_orders_items_REC['section_id'];
					$division_id = $purchase_orders_items_REC['division_id'];
					$subdivision_id = $purchase_orders_items_REC['subdivision_id'];
					$category_id = $purchase_orders_items_REC['category_id'];
					$item_code_id = $purchase_orders_items_REC['item_code_id'];
					$unit_id = $purchase_orders_items_REC['unit_id'];
					$item_qty = $purchase_orders_items_REC['item_qty'];
					
					$item_price = $purchase_orders_items_REC['item_price'];
					$item_status = $purchase_orders_items_REC['item_status'];
					$certificate_required = $purchase_orders_items_REC['certificate_required'];
					$limited_id = $purchase_orders_items_REC['limited_id'];
					$req_item_id = $purchase_orders_items_REC['req_item_id'];
					$po_id = $purchase_orders_items_REC['po_id'];
					
					$Item_UOM = get_unit_name( $unit_id, $KONN );
					$Item_Description = get_item_description_dashed( $po_item_id, 'po_item_id', 'purchase_orders_items', $KONN );
					
					$Amount = $item_qty * $item_price;
					
					
					$IAM_ARRAY[] = array(  "sno" => $sNo, 
					"po_id" => $purchase_orders_REC['po_id'], 
					"Item_Description" => $Item_Description, 
					"Item_UOM" => $Item_UOM, 
					"requisition_ref" => $requisition_ref, 
					"REQ_created_date" => $REQ_created_date, 
					"PO_REF" => $PO_REF, 
					"job_order_ref" => $job_order_ref, 
					"item_price" => $item_price, 
					"item_qty" => $item_qty, 
					"Amount" => number_format( $Amount, 2), 
					"supplier" => $supplier,
					"jo_id" => $job_order_idT,
					"requisition_id" => $requisition_id
					);
					$sNo++;
					
				}
			}
			//items loop END
		}
	}
	echo json_encode($IAM_ARRAY);
	
?>
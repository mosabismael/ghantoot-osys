<?php
	require_once('../../bootstrap/app_config.php');
	require_once('../../bootstrap/chk_log_user.php');
	
	$IAM_ARRAY = array();
	
	
	$CUR_PAGE = 0;
	$per_page = 20;
	$totPages = 0;
	
	if( isset( $_POST['page'] ) ){
		$CUR_PAGE = ( int ) test_inputs( $_POST['page'] );
	}
	if( isset( $_POST['showperpage'] ) ){
		$per_page = ( int ) test_inputs( $_POST['showperpage'] );
	}
	
	$start=abs(($CUR_PAGE-1)*$per_page);
	
	$serchCond = "";
	if( isset( $_POST['cond'] ) ){
		$serchCond = $_POST['cond'];
	}
	
	
	
	
	
	$sNo = $start + 1;
	$qu_inv_stock_sel = "SELECT * FROM  `inv_stock` WHERE `stock_status` = 'rejected' $serchCond LIMIT $start,$per_page";
	
	$qu_inv_stock_EXE = mysqli_query($KONN, $qu_inv_stock_sel);
	if(mysqli_num_rows($qu_inv_stock_EXE)){
		while($inv_stock_REC = mysqli_fetch_assoc($qu_inv_stock_EXE)){
			$memo = "";
			$stock_id = $inv_stock_REC['stock_id'];
			$stock_barcode = $inv_stock_REC['stock_barcode'];
			$family_id = $inv_stock_REC['family_id'];
			$section_id = $inv_stock_REC['section_id'];
			$division_id = $inv_stock_REC['division_id'];
			$subdivision_id = $inv_stock_REC['subdivision_id'];
			$category_id = $inv_stock_REC['category_id'];
			$item_code_id = $inv_stock_REC['item_code_id'];
			$unit_id = $inv_stock_REC['unit_id'];
			$qty = $inv_stock_REC['qty'];
			$cost_price = $inv_stock_REC['cost_price'];
			$currency_id = $inv_stock_REC['currency_id'];
			$exchange_rate = $inv_stock_REC['exchange_rate'];
			$area_id  = ( int ) $inv_stock_REC['area_id'];
			$rack_id  = ( int ) $inv_stock_REC['rack_id'];
			$shelf_id = ( int ) $inv_stock_REC['shelf_id'];
			$mrv_id = $inv_stock_REC['mrv_id'];
			$stock_status = $inv_stock_REC['stock_status'];
			$supplier_id = $inv_stock_REC['supplier_id'];
			$po_id = $inv_stock_REC['po_id'];
			$memo = $inv_stock_REC['memo'];
			if($inv_stock_REC['memo'] == null)
				$memo = "";
			
			
			$qu_suppliers_list_sel = "SELECT `supplier_name` FROM  `suppliers_list` WHERE `supplier_id` = $supplier_id";
			$qu_suppliers_list_EXE = mysqli_query($KONN, $qu_suppliers_list_sel);
			$supplier_name = "";
			if(mysqli_num_rows($qu_suppliers_list_EXE)){
				$suppliers_list_DATA = mysqli_fetch_assoc($qu_suppliers_list_EXE);
				$supplier_name = $suppliers_list_DATA['supplier_name'];
			}
			
			
			$item_unit_name = get_unit_name( $inv_stock_REC['unit_id'], $KONN );
			$item_name = "NA";
			$item_name = get_item_description( $stock_id, 'stock_id', 'inv_stock', $KONN );
			
			
			$qu_purchase_orders_sel = "SELECT `po_ref` FROM  `purchase_orders` WHERE `po_id` = $po_id";
			$qu_purchase_orders_EXE = mysqli_query($KONN, $qu_purchase_orders_sel);
			$po_ref = "";
			if(mysqli_num_rows($qu_purchase_orders_EXE)){
				$purchase_orders_DATA = mysqli_fetch_assoc($qu_purchase_orders_EXE);
				$po_ref = $purchase_orders_DATA['po_ref'];
			}
			
			
			
			$IAM_ARRAY[] = array(  "sNo" => $sNo, 
			"stock_id" => $stock_id,
			"item_name" => $item_name,
			"qty" => $qty, 
			"supplier_name" => $supplier_name, 
			"po_id" => $po_id, 
			"po_ref" => $po_ref, 
			"memo" => $memo
			);
			
			
		}
		
		
	}
		echo json_encode($IAM_ARRAY);
	
?>



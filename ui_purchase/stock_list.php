<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 1;
	$subPageID = 4;
	
	
?>
<!DOCTYPE html>
<html dir="<?=$lang_dir; ?>" lang="<?=$lang; ?>">
<head>
	<?php include('app/meta.php'); ?>
    <?php include('app/assets.php'); ?>
</head>
<body>
<?php

	$WHERE = "requisitions";
	include('app/header.php');
	//PAGE DATA START -----------------------------------------------///---------------------------------
?>



<div class="row">
	<div class="col-100">
		<table id="dataTable" class="tabler" border="2" style="font-size:10px;">
			<thead>
				<tr>
					<th rowspan="2"><?=lang("Barcode", "AAR"); ?></th>
					<th rowspan="2"><?=lang("Supplier", "AAR"); ?></th>
					<th rowspan="2"><?=lang("Item", "AAR"); ?></th>
					<th rowspan="2"><?=lang("Qty", "AAR"); ?></th>
					<th rowspan="2"><?=lang("UOM", "AAR"); ?></th>
					<th colspan="3"><?=lang("Placement", "AAR"); ?></th>
					<th rowspan="2"><?=lang("Status", "AAR"); ?></th>
				</tr>
				<tr>
					<th><?=lang("Area", "AAR"); ?></th>
					<th><?=lang("Rack", "AAR"); ?></th>
					<th><?=lang("Shelf", "AAR"); ?></th>
				</tr>
			</thead>
			<tbody>
<?php
	$sNo = 0;
	
	$qu_inv_stock_sel = "SELECT * FROM  `inv_stock` WHERE `stock_status` = 'in_stock'";
	$qu_inv_stock_EXE = mysqli_query($KONN, $qu_inv_stock_sel);
	if(mysqli_num_rows($qu_inv_stock_EXE)){
		while($inv_stock_REC = mysqli_fetch_assoc($qu_inv_stock_EXE)){
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


	$qu_suppliers_list_sel = "SELECT * FROM  `suppliers_list` WHERE `supplier_id` = $supplier_id";
	$qu_suppliers_list_EXE = mysqli_query($KONN, $qu_suppliers_list_sel);
	$supplier_name = "";
	if(mysqli_num_rows($qu_suppliers_list_EXE)){
		$suppliers_list_DATA = mysqli_fetch_assoc($qu_suppliers_list_EXE);
		$supplier_name = $suppliers_list_DATA['supplier_name'];
	}


		$item_unit_name = get_unit_name( $inv_stock_REC['unit_id'], $KONN );
		$item_name = "NA";
		$item_name = get_item_description( $stock_id, 'stock_id', 'inv_stock', $KONN );
		
	$area_name = "";
	$rack_name = "";
	$shelf_name = "";
		
if( $area_id != 0 ){
	$qu_wh_areas_sel = "SELECT * FROM  `wh_areas` WHERE `area_id` = $area_id";
	$qu_wh_areas_EXE = mysqli_query($KONN, $qu_wh_areas_sel);
	if(mysqli_num_rows($qu_wh_areas_EXE)){
		$wh_areas_DATA = mysqli_fetch_assoc($qu_wh_areas_EXE);
		$area_name = $wh_areas_DATA['area_name'];
	}

		
	$qu_wh_racks_sel = "SELECT * FROM  `wh_racks` WHERE `rack_id` = $rack_id";
	$qu_wh_racks_EXE = mysqli_query($KONN, $qu_wh_racks_sel);
	if(mysqli_num_rows($qu_wh_racks_EXE)){
		$wh_racks_DATA = mysqli_fetch_assoc($qu_wh_racks_EXE);
		$rack_name = $wh_racks_DATA['rack_name'];
	}

		
	$qu_wh_shelfs_sel = "SELECT * FROM  `wh_shelfs` WHERE `shelf_id` = $shelf_id";
	$qu_wh_shelfs_EXE = mysqli_query($KONN, $qu_wh_shelfs_sel);
	if(mysqli_num_rows($qu_wh_shelfs_EXE)){
		$wh_shelfs_DATA = mysqli_fetch_assoc($qu_wh_shelfs_EXE);
		$shelf_name = $wh_shelfs_DATA['shelf_name'];
	}
}

		
		
		?>
			<tr id="po-<?=$stock_id; ?>">
				<td onclick="showPoDetails(<?=$stock_id; ?>, '<?=$stock_barcode; ?>', 'viewPOdetails');"><span id="poREF-<?=$stock_id; ?>" class="text-primary"><?=$stock_barcode; ?></span></td>
				<td><?=$supplier_name; ?></td>
				<td><?=$item_name; ?></td>
				<td><?=$qty; ?></td>
				<td><?=$item_unit_name; ?></td>
				<td><?=$area_name; ?></td>
				<td><?=$rack_name; ?></td>
				<td><?=$shelf_name; ?></td>
				<td><?=$stock_status; ?></td>
			</tr>
		<?php
		}
	} else {
?>
			<tr>
				<td colspan="11">NO DATA FOUND</td>
			</tr>
<?php
	}
	
	
?>
			</tbody>
		</table>
	</div>
	<div class="zero"></div>
</div>


<?php
	//PAGE DATA END   ----------------------------------------------///---------------------------------
	include('app/footer.php');
?>

</body>
</html>
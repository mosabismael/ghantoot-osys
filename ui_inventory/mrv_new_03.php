<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 2;
	$subPageID = 5;
	
	
	
if( isset($_POST['po_id']) && 
	isset($_POST['dn_ref']) && 
	isset($_POST['supplier_id']) &&
	isset($_POST['item_ids']) && 
	isset($_POST['item_qts']) 
	){
		
	$full_rec = 0;
	$part_rec = 0;

	$mrv_id = 0;
	$mrv_ref = "";
	$created_date = date('Y-m-d H:i:00');
	$created_by = $EMPLOYEE_ID;
	$item_ids = $_POST['item_ids'];
	$item_qts = $_POST['item_qts'];
	$dn_ref = test_inputs($_POST['dn_ref']);
	$mrv_status = "draft";
	$supplier_id = ( int ) test_inputs($_POST['supplier_id']);
	$po_id       = ( int ) test_inputs($_POST['po_id']);
	
	
	//calc mrv_ref
	$qu_inv_mrvs_sel = "SELECT COUNT(`mrv_id`) FROM  `inv_mrvs` WHERE `created_date` LIKE '".date('Y-m-')."%' ";
	$qu_inv_mrvs_EXE = mysqli_query($KONN, $qu_inv_mrvs_sel);
	$nwNO         = 0;
	$tot_count_DB = 0;
	if(mysqli_num_rows($qu_inv_mrvs_EXE)){
		$inv_mrvs_DATA = mysqli_fetch_array($qu_inv_mrvs_EXE);
		$tot_count_DB = ( int ) $inv_mrvs_DATA[0];
	}
	
	$nwNO = $tot_count_DB + 1;
	$tot_count_DB_res = "";
	
		if($tot_count_DB < 10){
			$tot_count_DB_res = '000'.$nwNO;
		} else if( $tot_count_DB >= 10 && $tot_count_DB < 100 ){
			$tot_count_DB_res = '00'.$nwNO;
		} else if( $tot_count_DB >= 100 && $tot_count_DB < 1000 ){
			$tot_count_DB_res = '0'.$nwNO;
		} else {
			$tot_count_DB_res = ''.$nwNO;
		}
		$mrv_ref = "MRV".date('ym').$tot_count_DB_res;
		
	
	$qu_inv_mrvs_ins = "INSERT INTO `inv_mrvs` (
						`mrv_ref`, 
						`created_date`, 
						`created_by`, 
						`dn_ref`, 
						`mrv_status`, 
						`po_id`, 
						`supplier_id` 
					) VALUES (
						'".$mrv_ref."', 
						'".$created_date."', 
						'".$created_by."', 
						'".$dn_ref."', 
						'".$mrv_status."', 
						'".$po_id."', 
						'".$supplier_id."' 
					);";

	
	if(mysqli_query($KONN, $qu_inv_mrvs_ins)){
		$mrv_id = mysqli_insert_id($KONN);
		if( $mrv_id != 0 ){
			
			//load PO details
	$qu_purchase_orders_sel = "SELECT * FROM  `purchase_orders` WHERE `po_id` = $po_id";
	$qu_purchase_orders_EXE = mysqli_query($KONN, $qu_purchase_orders_sel);
	$purchase_orders_DATA;
	if(mysqli_num_rows($qu_purchase_orders_EXE)){
		$purchase_orders_DATA = mysqli_fetch_assoc($qu_purchase_orders_EXE);
	}
		$currency_id = $purchase_orders_DATA['currency_id'];
		$exchange_rate = $purchase_orders_DATA['exchange_rate'];


		//insert mrv items
		
		for( $E=0; $E<count( $item_ids ) ; $E++ ){
			$po_item_id   = ( int ) test_inputs( $item_ids[$E] );
			$item_rec_qty = ( double ) test_inputs( $item_qts[$E] );
			
		if( $item_rec_qty != 0 ){
			$qu_purchase_orders_items_sel = "SELECT * FROM  `purchase_orders_items` WHERE `po_item_id` = $po_item_id";
			$qu_purchase_orders_items_EXE = mysqli_query($KONN, $qu_purchase_orders_items_sel);
			$purchase_orders_items_DATA;
			if(mysqli_num_rows($qu_purchase_orders_items_EXE)){
				$purchase_orders_items_DATA = mysqli_fetch_assoc($qu_purchase_orders_items_EXE);
			}
			$itemRemainQTY =0;
			$family_id = $purchase_orders_items_DATA['family_id'];
			$section_id = $purchase_orders_items_DATA['section_id'];
			$division_id = $purchase_orders_items_DATA['division_id'];
			$subdivision_id = $purchase_orders_items_DATA['subdivision_id'];
			$category_id = $purchase_orders_items_DATA['category_id'];
			$item_code_id = $purchase_orders_items_DATA['item_code_id'];
			$unit_id = $purchase_orders_items_DATA['unit_id'];
			$po_qty       = ( double ) $purchase_orders_items_DATA['item_qty'];
			$item_qty_rec = ( double ) $purchase_orders_items_DATA['item_qty_rec'];
			$cost_price = $purchase_orders_items_DATA['item_price'];
			$stock_status = 'draft';
			$stock_barcode = 'STK'.$mrv_id.'0'.$po_id.''.$po_item_id.'0'.date('s').$E;
			
			$itemRemainQTY = $po_qty - $item_qty_rec;
			
			$item_status = 'NA';
			//determine po status
			if( $item_rec_qty ==  $itemRemainQTY ){
				$full_rec = $full_rec + 1;
				$item_status = 'fully_arrived';
			} else {
				$part_rec = $part_rec + 1;
				$item_status = 'partial_arrived';
			}
			
	//update item pre qty
	
	$item_rec_qtyA = $item_rec_qty + $item_qty_rec;
	$qu_purchase_orders_items_updt = "UPDATE  `purchase_orders_items` SET 
						`item_qty_rec` = '".$item_rec_qtyA."', 
						`item_status` = '".$item_status."'
						WHERE `po_item_id` = $po_item_id;";

	if(!mysqli_query($KONN, $qu_purchase_orders_items_updt)){
		die('0|item--updt-err-52554');
	}

			$qu_inv_stock_ins = "INSERT INTO `inv_stock` (
								`stock_barcode`, 
								`family_id`, 
								`section_id`, 
								`division_id`, 
								`subdivision_id`, 
								`category_id`, 
								`item_code_id`, 
								`unit_id`, 
								`qty`, 
								`cost_price`, 
								`currency_id`, 
								`exchange_rate`, 
								`mrv_id`, 
								`stock_status`, 
								`supplier_id`, 
								`po_id`, 
								`po_item_id` 
							) VALUES (
								'".$stock_barcode."', 
								'".$family_id."', 
								'".$section_id."', 
								'".$division_id."', 
								'".$subdivision_id."', 
								'".$category_id."', 
								'".$item_code_id."', 
								'".$unit_id."', 
								'".$item_rec_qty."', 
								'".$cost_price."', 
								'".$currency_id."', 
								'".$exchange_rate."', 
								'".$mrv_id."', 
								'".$stock_status."', 
								'".$supplier_id."', 
								'".$po_id."', 
								'".$po_item_id."' 
							);";
							
			if(!mysqli_query($KONN, $qu_inv_stock_ins)){
				die( 'itemAddError'.mysqli_error( $KONN ) );
			}
			
			
		}
			//end of for loop
		}






		
		//insert state change
			if( insert_state_change($KONN, $mrv_status, $mrv_id, "inv_mrvs", $EMPLOYEE_ID) ) {
				
				
				
				
				
				
				

						//update po status
	$po_status = 'material_arrived';
	
	if( $part_rec != 0 ){
		$po_status = 'partially_material_arrived';
	} else {
		$po_status = 'fully_material_arrived';
	}
	
	
	
	$qu_purchase_orders_updt = "UPDATE  `purchase_orders` SET 
						`po_status` = '".$po_status."'
						WHERE `po_id` = $po_id;";

	if(mysqli_query($KONN, $qu_purchase_orders_updt)){
		if( insert_state_change($KONN, $po_status, $po_id, "purchase_orders", $EMPLOYEE_ID) ){
			header("location:mrv_list.php?added=".$mrv_id);
		} else {
			die('0|Component State Error 6546541654');
		}
	}
				
				
				
				
			} else {
				die('0|Data Status Error 65154');
			}
			
		
		
		
		
		
		
		} else {
			die( 'ddd='.$mrv_id );
		}
	} else {
		die( mysqli_error( $KONN ) );
	}
		
		
		
		
		
		
		
		die('dddd');
	}
	
	
	

	
	$supplier_id = 0;
	$po_id       = 0;
	
	if( isset( $_GET['supplier_id'] ) ){
		$supplier_id = ( int ) $_GET['supplier_id'];
	} else {
		header("location:mrv_list.php?noSupp=1");
	}
	
	if( isset( $_GET['po_id'] ) ){
		$po_id = ( int ) $_GET['po_id'];
	} else {
		header("location:mrv_list.php?noPO=1");
	}
	
	
	
	
	
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
		<form action="mrv_new_03.php" method="POST">
		
			<div class="row col-50">
				<div class="nwFormGroup">
					<label><?=lang("Selected_Supplier:", "AAR"); ?></label>
					<select class="frmData" id="new-supplier_id" name="supplier_id" required>
		<?php
			$sNo = 0;
			$qu_suppliers_list_sel = "SELECT * FROM  `suppliers_list` WHERE `supplier_id` = '$supplier_id'";
			$qu_suppliers_list_EXE = mysqli_query($KONN, $qu_suppliers_list_sel);
			if( mysqli_num_rows($qu_suppliers_list_EXE) == 1 ){
				while($suppliers_list_REC = mysqli_fetch_assoc($qu_suppliers_list_EXE)){
					$supp_id       = ( int ) $suppliers_list_REC['supplier_id'];
					$supplier_name = $suppliers_list_REC['supplier_name'];
				
				?>
						<option value="<?=$supp_id; ?>"><?=$supplier_name; ?></option>
				<?php
				}
			} else {
				header("location:mrv_list.php?wrongIDs=1");
			}
		?>
					</select>
				</div>
				<div class="zero"></div>
			</div>
		
			<div class="row col-50">
				<div class="nwFormGroup">
					<label><?=lang("Selected_PO:", "AAR"); ?></label>
					<select class="frmData" id="new-po_id" name="po_id" required>
		<?php
			$sNo = 0;
			$qu_purchase_orders_sel = "SELECT * FROM  `purchase_orders` WHERE `po_id` = '$po_id'";
			$qu_purchase_orders_EXE = mysqli_query($KONN, $qu_purchase_orders_sel);
			if( mysqli_num_rows($qu_purchase_orders_EXE) == 1 ){
				while($purchase_orders_REC = mysqli_fetch_assoc($qu_purchase_orders_EXE)){
					$po_id       = ( int ) $purchase_orders_REC['po_id'];
					$po_ref = $purchase_orders_REC['po_ref'];
				
				?>
						<option value="<?=$po_id; ?>"><?=$po_ref; ?></option>
				<?php
				}
			}
		?>
					</select>
				</div>
				<div class="zero"></div>
			</div>
			<div class="zero"></div>
		
			<div class="row col-50">
				<div class="nwFormGroup">
					<label><?=lang("Delivery_Note_Ref:", "AAR"); ?></label>
					<input type="text" class="frmData" id="new-dn_ref" name="dn_ref" required>
				</div>
				<div class="zero"></div>
			</div>
			<div class="zero"></div>
				
				
				
				
				
				
		<table class="tabler" border="1">
			<thead>
				<tr>
					<th><?=lang('No.'); ?></th>
					<th style="width:50%;"><?=lang('name'); ?></th>
					<th><?=lang('Requsted_qty'); ?></th>
					<th><?=lang('Previously<br>_Received_qty'); ?></th>
					<th><?=lang('Received_qty'); ?></th>
					<th><?=lang('UOM'); ?></th>
				</tr>
			</thead>
			<tbody id="added_PO_items">
			
			
<?php
	$qu_purchase_orders_items_sel = "SELECT * FROM  `purchase_orders_items` WHERE ((`po_id` = $po_id) AND (`item_status` <> 'fully_received') AND (`limited_id` = 0))";
	$qu_purchase_orders_items_EXE = mysqli_query($KONN, $qu_purchase_orders_items_sel);
	if(mysqli_num_rows($qu_purchase_orders_items_EXE)){
		$CC=0;
		while($purchase_orders_items_REC = mysqli_fetch_assoc($qu_purchase_orders_items_EXE)){
			$CC++;
			
			$po_item_id             = $purchase_orders_items_REC['po_item_id'];
			$family_id              = $purchase_orders_items_REC['family_id'];
			$section_id             = $purchase_orders_items_REC['section_id'];
			$division_id            = $purchase_orders_items_REC['division_id'];
			$subdivision_id         = $purchase_orders_items_REC['subdivision_id'];
			$category_id            = $purchase_orders_items_REC['category_id'];
			$item_code_id           = $purchase_orders_items_REC['item_code_id'];
			$unit_id                = $purchase_orders_items_REC['unit_id'];
			$item_qty               = ( double ) $purchase_orders_items_REC['item_qty'];
			$item_qty_rec           = ( double ) $purchase_orders_items_REC['item_qty_rec'];
			$item_price             = ( double ) $purchase_orders_items_REC['item_price'];
			$certificate_required   = $purchase_orders_items_REC['certificate_required'];
			$limited_id             = ( int ) $purchase_orders_items_REC['limited_id'];
			
			
			
			$item_unit_name = get_unit_name( $purchase_orders_items_REC['unit_id'], $KONN );
			
		$family_id = $purchase_orders_items_REC['family_id'];
		$lv2       = $purchase_orders_items_REC['section_id'];
		$lv3       = $purchase_orders_items_REC['division_id'];
		$lv4       = $purchase_orders_items_REC['subdivision_id'];
		$lv5       = $purchase_orders_items_REC['category_id'];
		$item_name = "NA";
		
		$item_name = get_item_description( $po_item_id, 'po_item_id', 'purchase_orders_items', $KONN );
			
			$itemRemain = $item_qty - $item_qty_rec;
			
			
		?>
				<tr id="poItem-<?=$po_item_id; ?>" class="po_item_list" idler="<?=$po_item_id; ?>">
					<input class="frmData"
							id="new-po_item_id<?=$po_item_id; ?>"
							name="item_ids[]"
							type="hidden"
							value="<?=$po_item_id; ?>"
							req="1"
							den="0"
							alerter="<?=lang("Please_Check_items", "AAR"); ?>">
					<td><?=$CC; ?></td>
					<td><?=$item_name; ?></td>
					<td style="widtd:5%;"><?=$item_qty; ?></td>
					<td style="widtd:5%;"><?=$item_qty_rec; ?></td>
					<td style="widtd:5%;">
						<input class="frmData"
							id="new-po_item_id<?=$po_item_id; ?>"
							name="item_qts[]"
							type="number" 
							min="0" 
							max="<?=$itemRemain; ?>"  
							value="<?=$itemRemain; ?>" 
							step="00.001" 
							req="1"
							den="0"
							alerter="<?=lang("Please_Check_items", "AAR"); ?>">
					
					</td>
					<td><?=$item_unit_name; ?></td>
				</tr>
		<?php
		}
	}
?>
			</tbody>
		</table>





<div class="viewerBodyButtons">
		<a href="mrv_new_01.php"><button type="button">
			<?=lang('Back', 'ARR', 1); ?>
		</button></a>
		<a href="mrv_list.php"><button type="button">
			<?=lang('Cancel', 'ARR', 1); ?>
		</button></a>
		<button type="submit">
			<?=lang('Finish', 'ARR', 1); ?>
		</button>
</div>
			
		</form>
	</div>
	<div class="zero"></div>
</div>


<?php
	//PAGE DATA END   ----------------------------------------------///---------------------------------
	include('app/footer.php');
?>
</body>
</html>
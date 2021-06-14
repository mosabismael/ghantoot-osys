<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 2;
	$subPageID = 5;
	
	$supplier_id = 0;
	if( isset( $_GET['supplier_id'] ) ){
		$supplier_id = ( int ) $_GET['supplier_id'];
	} else {
		header("location:mrv_list.php?noSupp=1");
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
		<form action="mrv_new_03.php" method="GET">
		
			<div class="row col-100">
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
		
			<div class="row col-100">
				<div class="nwFormGroup">
					<label><?=lang("Select_PO:", "AAR"); ?></label>
					<select class="frmData" id="new-po_id" name="po_id" required>
						<option value="0" disabled selected><?=lang("Please_Select", "غير محدد"); ?></option>
		<?php
			$sNo = 0;
			$qu_purchase_orders_sel = "SELECT * FROM  `purchase_orders` WHERE ((`supplier_id` = '$supplier_id') AND ((`po_status` = 'pending_arrival') OR (`po_status` = 'partially_material_arrived')) ) ORDER BY `po_id` DESC";
			$qu_purchase_orders_EXE = mysqli_query($KONN, $qu_purchase_orders_sel);
			if( mysqli_num_rows($qu_purchase_orders_EXE) > 0 ){
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
				


<div class="viewerBodyButtons">
		<a href="mrv_new_01.php"><button type="button">
			<?=lang('Back', 'ARR', 1); ?>
		</button></a>
		<a href="mrv_list.php"><button type="button">
			<?=lang('Cancel', 'ARR', 1); ?>
		</button></a>
		<button type="submit">
			<?=lang('Next', 'ARR', 1); ?>
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
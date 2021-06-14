<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";

	$menuId = 2;
	$subPageID = 5;
	
	
	$mrv_id = 0;
	if( isset( $_GET['mrv_id'] ) ){
		$mrv_id = ( int ) $_GET['mrv_id'];
	} else {
		header("location:mrv_list.php?noMRV=1");
	}
	
	$stock_id = 0;
	if( isset( $_GET['stock_id'] ) ){
		$stock_id = ( int ) $_GET['stock_id'];
	} else {
		header("location:mrv_list.php?noStock=1");
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
		<form action="mrv_place_items_03.php" method="GET">
					<input class="frmData"
							id="new-mrv_id<?=$mrv_id; ?>"
							name="mrv_id"
							type="hidden"
							value="<?=$mrv_id; ?>"
							req="1"
							den="0"
							alerter="<?=lang("Please_Check_items", "AAR"); ?>">
		
			<div class="row col-100">
			
			
			

		<table class="tabler" border="1">
			<thead>
				<tr>
					<th style="width:50%;"><?=lang('name'); ?></th>
					<th><?=lang('Received_qty'); ?></th>
					<th><?=lang('UOM'); ?></th>
				</tr>
			</thead>
			<tbody id="added_PO_items">
			
			
<?php
	$qu_inv_stock_sel = "SELECT * FROM  `inv_stock` WHERE ( (`stock_id` = $stock_id) AND (`stock_status` = 'pending_placement') ) LIMIT 1";
	$qu_inv_stock_EXE = mysqli_query($KONN, $qu_inv_stock_sel);
	if(mysqli_num_rows($qu_inv_stock_EXE)){
		$CC=0;
		while($inv_stock_REC = mysqli_fetch_assoc($qu_inv_stock_EXE)){
			
			$stock_id               = ( int ) $inv_stock_REC['stock_id'];
			$item_qty               = ( double ) $inv_stock_REC['qty'];
			
			$item_unit_name = get_unit_name( $inv_stock_REC['unit_id'], $KONN );
			
		$item_name = "NA";
		
		$item_name = get_item_description( $stock_id, 'stock_id', 'inv_stock', $KONN );
			
			
			
			
		?>
				<tr id="poItem-<?=$stock_id; ?>" class="po_item_list" idler="<?=$stock_id; ?>">
					<input class="frmData"
							id="new-stock_id<?=$stock_id; ?>"
							name="stock_id"
							type="hidden"
							value="<?=$stock_id; ?>"
							req="1"
							den="0"
							alerter="<?=lang("Please_Check_items", "AAR"); ?>">
					<td><?=$item_name; ?></td>
					<td style="widtd:5%;"><?=$item_qty; ?></td>
					<td><?=$item_unit_name; ?></td>
				</tr>
		<?php
		}
	}
?>
			</tbody>
		</table>
			
			
			
			
			</div>
		
			<div class="row col-100">
				<div class="nwFormGroup">
					<label><?=lang("Select_Area:", "AAR"); ?></label>
					<select class="frmData" id="new-area_id" name="area_id" required>
						<option value="0" disabled selected><?=lang("Please_Select", "غير محدد"); ?></option>
		<?php
			$sNo = 0;
			$qu_wh_areas_sel = "SELECT * FROM  `wh_areas` ORDER BY `area_name` ASC";
			$qu_wh_areas_EXE = mysqli_query($KONN, $qu_wh_areas_sel);
			if(mysqli_num_rows($qu_wh_areas_EXE)){
				while($wh_areas_REC = mysqli_fetch_assoc($qu_wh_areas_EXE)){
					$supp_id       = ( int ) $wh_areas_REC['area_id'];
					$area_name = $wh_areas_REC['area_name'];
				
				?>
						<option value="<?=$supp_id; ?>"><?=$area_name; ?></option>
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
		<a href="mrv_list_pending_placement.php"><button type="button">
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
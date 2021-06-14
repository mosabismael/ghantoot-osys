<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";

	$menuId = 1;
	$subPageID = 4;
	
	
	$stock_id = 0;
	if( isset( $_GET['stock_id'] ) ){
		$stock_id = ( int ) $_GET['stock_id'];
	} else {
		header("location:stock_list.php?noSTKidV=1");
	}
	
	
	$qu_inv_stock_sel = "SELECT * FROM  `inv_stock` WHERE `stock_id` = $stock_id";
	$qu_inv_stock_EXE = mysqli_query($KONN, $qu_inv_stock_sel);
	$inv_stock_DATA;
	if(mysqli_num_rows($qu_inv_stock_EXE)){
		$inv_stock_DATA = mysqli_fetch_assoc($qu_inv_stock_EXE);
	}
	
		$stock_barcode = $inv_stock_DATA['stock_barcode'];
		$family_id = $inv_stock_DATA['family_id'];
		$section_id = $inv_stock_DATA['section_id'];
		$division_id = $inv_stock_DATA['division_id'];
		$subdivision_id = $inv_stock_DATA['subdivision_id'];
		$category_id = $inv_stock_DATA['category_id'];
		$item_code_id = $inv_stock_DATA['item_code_id'];
		$unit_id = $inv_stock_DATA['unit_id'];
		$qty = $inv_stock_DATA['qty'];
		$cost_price = $inv_stock_DATA['cost_price'];
		$currency_id = $inv_stock_DATA['currency_id'];
		$exchange_rate = $inv_stock_DATA['exchange_rate'];
		$mrv_id = $inv_stock_DATA['mrv_id'];
		$memo = $inv_stock_DATA['memo'];
		$stock_status = $inv_stock_DATA['stock_status'];
		$supplier_id = $inv_stock_DATA['supplier_id'];
		$po_id = $inv_stock_DATA['po_id'];
		$po_item_id = $inv_stock_DATA['po_item_id'];

		$item_name = "NA";
		$item_name = get_item_description( $stock_id, 'stock_id', 'inv_stock', $KONN );
	
	
		$area_id = $inv_stock_DATA['area_id'];
		$rack_id = $inv_stock_DATA['rack_id'];
		$shelf_id = $inv_stock_DATA['shelf_id'];
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


<script>
var area_id   = parseInt( <?=$area_id; ?> );
var rack_id   = parseInt( <?=$rack_id; ?> );
var shelf_id  = parseInt( <?=$shelf_id; ?> );
</script>

<div class="row">
	<div class="col-100">
		<form action="mrv_place_items_02.php" method="GET">
			
			<h3>Select New Placement :</h3>
			<h4><?=$item_name; ?></h4>

			<div class="row col-100">
				<div class="nwFormGroup">
					<label><?=lang("Select_Area:", "AAR"); ?></label>
					<select class="frmData" id="new-area_idP" name="area_id" required>
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
		
		
			<div class="row col-100">
				<div class="nwFormGroup">
					<label><?=lang("Select_Rack:", "AAR"); ?></label>
					<select class="frmData" id="new-rack_idP" name="rack_id" required>
		<?php
			$sNo = 0;
			$qu_wh_racks_sel = "SELECT * FROM  `wh_racks` WHERE  `rack_id` = $rack_id ORDER BY `rack_name` ASC";
			$qu_wh_racks_EXE = mysqli_query($KONN, $qu_wh_racks_sel);
			if(mysqli_num_rows($qu_wh_racks_EXE)){
				while($wh_racks_REC = mysqli_fetch_assoc($qu_wh_racks_EXE)){
					$rack_id       = ( int ) $wh_racks_REC['rack_id'];
					$rack_name = $wh_racks_REC['rack_name'];
				
				?>
						<option value="<?=$rack_id; ?>"><?=$rack_name; ?></option>
				<?php
				}
			}
		?>
					</select>
				</div>
				<div class="zero"></div>
			</div>
			<div class="zero"></div>
			
			<div class="row col-100">
				<div class="nwFormGroup">
					<label><?=lang("Select_Shelf:", "AAR"); ?></label>
					<select class="frmData" id="new-shelf_idP" name="shelf_id" required>
		<?php
			$sNo = 0;
			$qu_wh_shelfs_sel = "SELECT * FROM  `wh_shelfs` WHERE  `shelf_id` = $shelf_id ORDER BY `shelf_name` ASC";
			$qu_wh_shelfs_EXE = mysqli_query($KONN, $qu_wh_shelfs_sel);
			if(mysqli_num_rows($qu_wh_shelfs_EXE)){
				while($wh_shelfs_REC = mysqli_fetch_assoc($qu_wh_shelfs_EXE)){
					$shelf_id       = ( int ) $wh_shelfs_REC['shelf_id'];
					$shelf_name = $wh_shelfs_REC['shelf_name'];
				
				?>
						<option value="<?=$shelf_id; ?>"><?=$shelf_name; ?></option>
				<?php
				}
			}
		?>
					</select>
				</div>
				<div class="zero"></div>
			</div>
			<div class="zero"></div>
			
			
			
			
			
			
		</form>
	</div>
	<div class="zero"></div>
</div>


<script>

function change_area(){
	var dataID = parseInt( $('#new-area_idP').val() );
	if( dataID != 0 ){
		start_loader();
			$('#new-rack_idP').html('<option value="0" disabled selected>--Please Select Area--</option>');
			$('#new-shelf_idP').html('<option value="0" disabled selected>--Please Select Rack--</option>');
		
		$.ajax({
		url      :"<?=api_root; ?>inv_stock/get_racks.php",
		data     :{ 'area_id': dataID },
		dataType :"html",
		type     :'POST',
		success  :function(data){
			end_loader();
			$('#new-rack_idP').html(data);
			},
		error    :function(){
			alert('Data Error No: 2132132');
			is_selectedP = false;
			},
		});
	} else {
		is_selectedP = false;
	}
}

function change_rack(){
	var dataID = parseInt( $('#new-rack_idP').val() );
	if( dataID != 0 ){
		start_loader();
			$('#new-shelf_idP').html('<option value="0" disabled selected>--Please Select Rack--</option>');
		
		$.ajax({
		url      :"<?=api_root; ?>inv_stock/get_shelfs.php",
		data     :{ 'rack_id': dataID },
		dataType :"html",
		type     :'POST',
		success  :function(data){
			end_loader();
			$('#new-shelf_idP').html(data);
			},
		error    :function(){
			alert('Data Error No: 2132132');
			is_selectedP = false;
			},
		});
	} else {
		is_selectedP = false;
		
	}
}


function change_shelf(){
	var dataID = parseInt( $('#new-shelf_idP').val() );
	var aId = parseInt( $('#new-area_idP').val() );
	var rId = parseInt( $('#new-rack_idP').val() );
	
	if( dataID != 0 ){
		start_loader();
		
		
		$.ajax({
		url      :"<?=api_root; ?>inv_stock/get_stock.php",
		data     :{ 'shelf_id': dataID, 'rack_id': rId, 'area_id': aId, },
		dataType :"html",
		type     :'POST',
		success  :function(data){
			end_loader();
			
			},
		error    :function(){
			alert('Data Error No: 2132132');
			is_selectedP = false;
			},
		});
	} else {
		is_selectedP = false;
		
	}
}

$('#new-area_idP').on( 'change', function(){
	change_area();
} );
$('#new-rack_idP').on( 'change', function(){
	change_rack();
} );
$('#new-shelf_idP').on( 'change', function(){
	change_shelf();
} );
</script>

<?php
	//PAGE DATA END   ----------------------------------------------///---------------------------------
	include('app/footer.php');
?>
</body>
</html>
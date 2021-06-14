

<div class="row">
	<div class="col-100">

<form>


<div class="col-50">
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('Select_Item', 'ARR', 1); ?></label>
		<select class="frmData" 
				id="new-stock_id" 
				name="stock_id" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_Code01", "AAR"); ?>">
					<option value="0" selected>--- Please Select---</option>
<?php
	$qu_inv_01_families_sel = "SELECT * FROM  `inv_stock` WHERE ( (`stock_status` = 'in_stock') ) ORDER BY `stock_id` ASC";
	$qu_inv_01_families_EXE = mysqli_query($KONN, $qu_inv_01_families_sel);
	if(mysqli_num_rows($qu_inv_01_families_EXE)){
		while($inv_stock_REC = mysqli_fetch_assoc($qu_inv_01_families_EXE)){
			
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
			$area_id = $inv_stock_REC['area_id'];
			$rack_id = $inv_stock_REC['rack_id'];
			$shelf_id = $inv_stock_REC['shelf_id'];
			$mrv_id = $inv_stock_REC['mrv_id'];
			$supplier_id = $inv_stock_REC['supplier_id'];
			$po_id = $inv_stock_REC['po_id'];
			$po_item_id = $inv_stock_REC['po_item_id'];
			
			$unit_name = get_unit_name( $unit_id, $KONN );
			
	$qu_wh_areas_sel = "SELECT * FROM  `wh_areas` WHERE `area_id` = $area_id";
	$qu_wh_areas_EXE = mysqli_query($KONN, $qu_wh_areas_sel);
	$area_name = "";
	if(mysqli_num_rows($qu_wh_areas_EXE)){
		$wh_areas_DATA = mysqli_fetch_assoc($qu_wh_areas_EXE);
		$area_name = $wh_areas_DATA['area_name'];
	}

	$qu_wh_racks_sel = "SELECT * FROM  `wh_racks` WHERE `rack_id` = $rack_id";
	$qu_wh_racks_EXE = mysqli_query($KONN, $qu_wh_racks_sel);
	$rack_name = "";
	if(mysqli_num_rows($qu_wh_racks_EXE)){
		$wh_racks_DATA = mysqli_fetch_assoc($qu_wh_racks_EXE);
		$rack_name = $wh_racks_DATA['rack_name'];
	}

	$qu_wh_shelfs_sel = "SELECT * FROM  `wh_shelfs` WHERE `shelf_id` = $shelf_id";
	$qu_wh_shelfs_EXE = mysqli_query($KONN, $qu_wh_shelfs_sel);
	$shelf_name = "";
	if(mysqli_num_rows($qu_wh_shelfs_EXE)){
		$wh_shelfs_DATA = mysqli_fetch_assoc($qu_wh_shelfs_EXE);
		$shelf_name = $wh_shelfs_DATA['shelf_name'];
	}
	
			
		?>
		<option value="<?=$stock_id; ?>" 
				id="stock-<?=$stock_id; ?>" 
				dt-unit="<?=$unit_name; ?>" 
				dt-area="<?=$area_name; ?>" 
				dt-rack="<?=$rack_name; ?>" 
				dt-shelf="<?=$shelf_name; ?>" 
				dt-qty="<?=$qty; ?>" ><?=$stock_barcode; ?></option>
		<?php
		}
	}
?>
		</select>
	</div>
	<br>
	<br>
	<div class="nwFormGroup">
		<div class="" id="ItemDescription"></div>
	</div>
</div>


<div class="col-50">
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('UOM', 'ARR', 1); ?></label>
		<input type="text" 
				id="uom" 
				req="1" 
				den="0" 
				value="0" 
				alerter="<?=lang("Please_Check_item_qty", "AAR"); ?>" disabled>
	</div>
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('Available_Quantity', 'ARR', 1); ?></label>
		<input type="text" 
				id="av_qty" 
				req="1" 
				den="0" 
				value="0" 
				alerter="<?=lang("Please_Check_item_qty", "AAR"); ?>" disabled>
	</div>
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('Req_Quantity', 'ARR', 1); ?></label>
		<input class="frmData" type="text" 
				id="new-item_qty" 
				name="item_qty" 
				req="1" 
				den="0" 
				value="0" 
				alerter="<?=lang("Please_Check_item_qty", "AAR"); ?>">
	</div>
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('Remain_Quantity', 'ARR', 1); ?></label>
		<input type="text" 
				id="rem_qty" 
				value="0" 
				alerter="<?=lang("Please_Check_item_qty", "AAR"); ?>" disabled>
	</div>
	<br>
	
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('AREA', 'ARR', 1); ?></label>
		<input type="text" id="area_name" disabled>
	</div>
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('Rack', 'ARR', 1); ?></label>
		<input type="text" id="rack_name" disabled>
	</div>
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('Shelf', 'ARR', 1); ?></label>
		<input type="text" id="shelf_name" disabled>
	</div>
	<br>
	
</div>

	<div class="zero"></div>
	<br>
	<br>
	<br>

	<div class="form-alerts"></div>
	<div class="zero"></div>

<div class="col-100">
	<div class="viewerBodyButtons text-center">
		<button type="button" onclick="addStockItem();">
			<?=lang('Add', 'ARR', 1); ?>
		</button>
		<button type="button" onclick="hide_details('NewItemDetails');resetSlctr(true);">
			<?=lang("Cancel", "AAR"); ?>
		</button>

	</div>
</div>



<script>
var is_selected = false;
var sel_stock = 0;
var sel_Desc = '';
var CC = 1500;

function addStockItem(){
	CC++;
	if( is_selected == true ){
		if( sel_stock != 0 ){
			var sel_qty = parseFloat( $('#new-item_qty').val() );
			if( isNaN( sel_qty ) ){ sel_qty = 0; }
				if( sel_qty != 0 ){
					var nw_l = '<tr id="added-' + CC + '">' + 
								'	<td onclick="remItem(' + CC + ');"><i class="fas fa-trash"></i></td>' + 
								'	<td>' + sel_Desc + '</td>' + 
								'	<td>' + sel_qty + '</td>' + 
								'	<input type="hidden" value="' + sel_stock + '" name="stock_ids[]">' + 
								'	<input type="hidden" value="' + sel_qty + '" name="stock_qtys[]">' + 
								'</tr>';
					$('#added_point').before( nw_l );
					// hide_details('NewItemDetails');
					alert("Item_Added");
					resetSlctr( false );
				} else {
					alert("please fill the required quantity to proceed !!");
				}
		}
	}
}

function remItem( remID ){
	$('#added-' + remID).remove();
}


function fill_DT( sID ){
	var area  = $('#stock-' + sID ).attr('dt-area');
	var rack  = $('#stock-' + sID ).attr('dt-rack');
	var shelf = $('#stock-' + sID ).attr('dt-shelf');
	
	$('#area_name').val( $('#stock-' + sID ).attr('dt-area') );
	$('#rack_name').val( $('#stock-' + sID ).attr('dt-rack') );
	$('#shelf_name').val( $('#stock-' + sID ).attr('dt-shelf') );
	
	$('#av_qty').val( $('#stock-' + sID ).attr('dt-qty') );
	
	$('#uom').val( $('#stock-' + sID ).attr('dt-unit') );
	
	
}

$('#new-item_qty').on("keyup", function(){
	$('#rem_qty').val( 0 );
	if( is_selected == true ){
			var rq_qty = parseFloat( $('#new-item_qty').val() );
			if( isNaN( rq_qty ) ){ rq_qty = 0; }
		
		if( rq_qty < 0 ){
			$('#new-item_qty').val(0);
		} else {
			
			$('#rem_qty').val( 0 );
			var av_qty = parseFloat( $('#av_qty').val() );
			if( isNaN( av_qty ) ){ av_qty = 0; }
			
			var rem_qty = av_qty - rq_qty;
			$('#rem_qty').val( rem_qty );
			
		
			if( rq_qty > av_qty ){
				$('#new-item_qty').val( 0 );
				$('#rem_qty').val( 0 );
				alert("Required Quantity Exceeded Available Quantity");
				
			}

			
		}
		
		
		
		
		
		
	}
	
	
	
	
	
	
} );

function resetSlctr( is_main ){
	sel_stock = 0;
	if( is_main == true ){
		$('#new-stock_id').val(0);
	}
	$('#ItemDescription').html("");
	$('#new-item_qty').val(0);
	$('#av_qty').val(0);
	
	$('#area_name').val( "" );
	$('#rack_name').val( "" );
	$('#shelf_name').val( "" );
	$('#uom').val( "" );
}

function change_family(){
	var dataID = parseInt( $('#new-stock_id').val() );
	if( dataID != 0 ){
		start_loader();
		
		resetSlctr( false );
		
		$.ajax({
		url      :"<?=api_root; ?>inv_stock/load_item_details.php",
		data     :{ 'stock_id': dataID },
		dataType :"html",
		type     :'POST',
		success  :function(data){
			is_selected = true;
			sel_stock = dataID;
			fill_DT( dataID );
			end_loader();
			$('#ItemDescription').html(data);
			sel_Desc = data;
			},
		error    :function(){
			alert('Data Error No: 2132132');
			is_selected = false;
			},
		});
	} else {
		is_selected = false;
		resetSlctr( false );
		
	}
}

</script>
	<div class="zero"></div>
</form>
		
		
	</div>
	<div class="zero"></div>
</div>

<script>
$('#new-stock_id').on( 'change', function(){
	change_family();
} );
</script>

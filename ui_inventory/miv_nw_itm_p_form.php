

<div class="row">
	<div class="col-100">

<form>


<div class="col-50">
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('Select_Area', 'ARR', 1); ?></label>
		<select class="frmData" id="new-area_idP" name="area_id">
					<option value="0" selected>--- Please Select---</option>
<?php
	$qu_wh_areas_sel = "SELECT * FROM  `wh_areas` ";
	$qu_wh_areas_EXE = mysqli_query($KONN, $qu_wh_areas_sel);
	if(mysqli_num_rows($qu_wh_areas_EXE)){
		while($wh_areas_REC = mysqli_fetch_assoc($qu_wh_areas_EXE)){
			$Tarea_id = $wh_areas_REC['area_id'];
			$Tarea_name = $wh_areas_REC['area_name'];
			
		?>
		<option value="<?=$Tarea_id; ?>"><?=$Tarea_name; ?></option>
		<?php
		}
	}
?>
		</select>
	</div>
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('Select_Rack', 'ARR', 1); ?></label>
		<select class="frmData" id="new-rack_idP" name="rack_id">
		</select>
	</div>
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('Select_Shelf', 'ARR', 1); ?></label>
		<select class="frmData" id="new-shelf_idP" name="shelf_id">
		</select>
	</div>
	<br>
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('Select_Item', 'ARR', 1); ?></label>
		<select class="frmData" id="newP-stock_id" name="stock_id">
		</select>
	</div>
	<br>
</div>




<div class="col-50">
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('UOM', 'ARR', 1); ?></label>
		<input type="text" 
				id="uomP" 
				req="1" 
				den="0" 
				value="0" 
				alerter="<?=lang("Please_Check_item_qty", "AAR"); ?>" disabled>
	</div>
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('Available_Quantity', 'ARR', 1); ?></label>
		<input type="text" 
				id="av_qtyP" 
				req="1" 
				den="0" 
				value="0" 
				alerter="<?=lang("Please_Check_item_qty", "AAR"); ?>" disabled>
	</div>
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('Req_Quantity', 'ARR', 1); ?></label>
		<input class="frmData" type="text" 
				id="new-item_qtyP" 
				name="item_qty" 
				req="1" 
				den="0" 
				value="0" 
				alerter="<?=lang("Please_Check_item_qty", "AAR"); ?>">
	</div>
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('Remain_Quantity', 'ARR', 1); ?></label>
		<input type="text" 
				id="rem_qtyP" 
				value="0" 
				alerter="<?=lang("Please_Check_item_qty", "AAR"); ?>" disabled>
	</div>
	<br>
	
	
	<div class="nwFormGroup">
		<div class="" id="ItemDescriptionP"></div>
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
		<button type="button" onclick="addStockItemP();">
			<?=lang('Add', 'ARR', 1); ?>
		</button>
		<button type="button" onclick="hide_details('NewItemPlaceDetails');resetSlctrP(true);">
			<?=lang("Cancel", "AAR"); ?>
		</button>

	</div>
</div>



<script>
var is_selectedP = false;
var sel_stockP = 0;
var sel_DescP = '';
var CCP = 1500;

function addStockItemP(){
	CCP++;
	if( is_selectedP == true ){
		if( sel_stockP != 0 ){
			var sel_qtyP = parseFloat( $('#new-item_qtyP').val() );
			if( isNaN( sel_qtyP ) ){ sel_qtyP = 0; }
				if( sel_qtyP != 0 ){
					var nw_l = '<tr id="addedP-' + CCP + '">' + 
								'	<td onclick="remItemP(' + CCP + ');"><i class="fas fa-trash"></i></td>' + 
								'	<td>' + sel_DescP + '</td>' + 
								'	<td>' + sel_qtyP + '</td>' + 
								'	<input type="hidden" value="' + sel_stockP + '" name="stock_ids[]">' + 
								'	<input type="hidden" value="' + sel_qtyP + '" name="stock_qtys[]">' + 
								'</tr>';
					$('#added_point').before( nw_l );
					// hide_details('NewItemPlaceDetails');
					alert("Item_Added");
					resetSlctrP( false );
				} else {
					alert("please fill the required quantity to proceed !!");
				}
		}
	}
}

function remItemP( remID ){
	$('#addedP-' + remID).remove();
}


function fill_DTP( sID ){
	var area  = $('#stock-' + sID ).attr('dt-area');
	var rack  = $('#stock-' + sID ).attr('dt-rack');
	var shelf = $('#stock-' + sID ).attr('dt-shelf');
	
	$('#area_name').val( $('#stock-' + sID ).attr('dt-area') );
	$('#rack_name').val( $('#stock-' + sID ).attr('dt-rack') );
	$('#shelf_name').val( $('#stock-' + sID ).attr('dt-shelf') );
	
	$('#av_qtyP').val( $('#stock-' + sID ).attr('dt-qty') );
	
	$('#uomP').val( $('#stock-' + sID ).attr('dt-unit') );
	
	
}

$('#new-item_qtyP').on("keyup", function(){
	$('#rem_qtyP').val( 0 );
	if( is_selectedP == true ){
			var rq_qty = parseFloat( $('#new-item_qtyP').val() );
			if( isNaN( rq_qty ) ){ rq_qty = 0; }
		
		if( rq_qty < 0 ){
			$('#new-item_qtyP').val(0);
		} else {
			
			$('#rem_qtyP').val( 0 );
			var av_qtyP = parseFloat( $('#av_qtyP').val() );
			if( isNaN( av_qtyP ) ){ av_qtyP = 0; }
			
			var rem_qtyP = av_qtyP - rq_qty;
			$('#rem_qtyP').val( rem_qtyP );
			
		
			if( rq_qty > av_qtyP ){
				$('#new-item_qtyP').val( 0 );
				$('#rem_qtyP').val( 0 );
				alert("Required Quantity Exceeded Available Quantity");
				
			}

			
		}
		
		
		
		
		
		
	}
	
} );

function resetSlctrP( is_main ){
	sel_stockP = 0;
	if( is_main == true ){
		$('#newP-stock_id').val(0);
	}
	$('#ItemDescriptionP').html("");
	$('#new-item_qtyP').val(0);
	$('#av_qtyP').val(0);
	
	$('#area_name').val( "" );
	$('#rack_name').val( "" );
	$('#shelf_name').val( "" );
	$('#uomP').val( "" );
}

function change_familyP(){
	var dataID = parseInt( $('#newP-stock_id').val() );
	if( dataID != 0 ){
		start_loader();
		
		resetSlctrP( false );
		
		$.ajax({
		url      :"<?=api_root; ?>inv_stock/load_item_details.php",
		data     :{ 'stock_id': dataID },
		dataType :"html",
		type     :'POST',
		success  :function(data){
			is_selectedP = true;
			sel_stockP = dataID;
			fill_DTP( dataID );
			end_loader();
			$('#ItemDescriptionP').html(data);
			sel_DescP = data;
			},
		error    :function(){
			alert('Data Error No: 2132132');
			is_selectedP = false;
			},
		});
	} else {
		is_selectedP = false;
		resetSlctrP( false );
		
	}
}

function change_area(){
	var dataID = parseInt( $('#new-area_idP').val() );
	if( dataID != 0 ){
		start_loader();
		
		resetSlctrP( false );
		
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
		resetSlctrP( false );
		
	}
}

function change_rack(){
	var dataID = parseInt( $('#new-rack_idP').val() );
	if( dataID != 0 ){
		start_loader();
		
		resetSlctrP( false );
		
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
		resetSlctrP( false );
		
	}
}


function change_shelf(){
	var dataID = parseInt( $('#new-shelf_idP').val() );
	var aId = parseInt( $('#new-area_idP').val() );
	var rId = parseInt( $('#new-rack_idP').val() );
	
	if( dataID != 0 ){
		start_loader();
		
		resetSlctrP( false );
		
		$.ajax({
		url      :"<?=api_root; ?>inv_stock/get_stock.php",
		data     :{ 'shelf_id': dataID, 'rack_id': rId, 'area_id': aId, },
		dataType :"html",
		type     :'POST',
		success  :function(data){
			end_loader();
			$('#newP-stock_id').html(data);
			},
		error    :function(){
			alert('Data Error No: 2132132');
			is_selectedP = false;
			},
		});
	} else {
		is_selectedP = false;
		resetSlctrP( false );
		
	}
}

</script>
	<div class="zero"></div>
</form>
		
		
	</div>
	<div class="zero"></div>
</div>

<script>
$('#newP-stock_id').on( 'change', function(){
	change_familyP();
} );
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

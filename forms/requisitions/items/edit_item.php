

<div class="row">
	<div class="col-100">

<form 
id="add-new-item-form" 
id-modal="add_new_requisition_item" 
id-details="EditItemDetails" 
api="<?=api_root; ?>requisitions/items/add_new_requisition_item.php">
				
	

		
<input class="frmData" type="hidden" 
		id="new-requisition_id" 
		name="requisition_id" 
		value="" 
		req="1" 
		den="0" 
		alerter="<?=lang("Please_Check_requisition_id", "AAR"); ?>">



	<div class="zero"></div>

<div class="col-50">
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('L-01', 'ARR', 1); ?></label>
		<select class="frmData" 
				id="new-family_id" 
				name="family_id" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_Code01", "AAR"); ?>">
					<option value="0" selected>--- Please Select---</option>
<?php
	$qu_inv_01_families_sel = "SELECT `family_id`, `family_code`, `family_name`, `is_material` FROM  `inv_01_families` ORDER BY `family_id` ASC";
	$qu_inv_01_families_EXE = mysqli_query($KONN, $qu_inv_01_families_sel);
	if(mysqli_num_rows($qu_inv_01_families_EXE)){
		while($f_REC = mysqli_fetch_array($qu_inv_01_families_EXE)){
			$is_material = ( int ) $f_REC[3];
		?>
		<option class="is_material-<?=$is_material; ?>" id="fm-<?=$f_REC[0]; ?>" is_finished="0" value="<?=$f_REC[0]; ?>"><?=$f_REC[0]; ?> - <?=$f_REC[2]; ?> ( <?=$f_REC[1]; ?> )</option>
		<?php
		}
	}
?>
		</select>
	</div>
	<br>
	<div id="f-section_id" class="nwFormGroup">
		<label class="lbl_class"><?=lang('L-02', 'ARR', 1); ?></label>
		<select class="frmData" 
				id="new-section_id" 
				name="section_id" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_Code02", "AAR"); ?>">
		</select>
	</div>
	<br>
	<div id="f-division_id" class="nwFormGroup">
		<label class="lbl_class"><?=lang('L-03', 'ARR', 1); ?></label>
		<select class="frmData" 
				id="news-division_id" 
				name="division_id" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_Code03", "AAR"); ?>">
		</select>
	</div>
	<br>
	<div id="f-subdivision_id" class="nwFormGroup">
		<label class="lbl_class"><?=lang('L-04', 'ARR', 1); ?></label>
		<select class="frmData" 
				id="new-subdivision_id" 
				name="subdivision_id" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_Code04", "AAR"); ?>">
		</select>
	</div>
	<br>
	<div id="f-category_id" class="nwFormGroup">
		<label class="lbl_class"><?=lang('L-05', 'ARR', 1); ?></label>
		<select class="frmData" 
				id="new-category_id" 
				name="category_id" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_Code05", "AAR"); ?>">
		</select>
	</div>
	<br>
	<div id="f-item_code_id" class="nwFormGroup">
		<label class="lbl_class"><?=lang('L-06', 'ARR', 1); ?></label>
		<select class="frmData" 
				id="new-item_code_id" 
				name="item_code_id" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_Code06", "AAR"); ?>">
		</select>
	</div>
</div>


<div class="col-50">
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('Quantity', 'ARR', 1); ?></label>
		<input class="frmData" type="text" 
				id="new-item_qty" 
				name="item_qty" 
				req="1" 
				den="0" 
				value="0" 
				alerter="<?=lang("Please_Check_item_qty", "AAR"); ?>">
	</div>
	<br>
	<div class="nwFormGroup" id="showDaysValue">
		<label class="lbl_class"><?=lang('NO. Days', 'ARR', 1); ?></label>
		<input class="frmData" type="text" 
				id="new-item_days" 
				name="item_days" 
				req="1" 
				den="0" 
				value="1" 
				alerter="<?=lang("Please_Check_item_Days", "AAR"); ?>">
	</div>
	<br>
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('U.O.M', 'ARR', 1); ?></label>
		<select class="frmData"
				id="new-item_unit_id" 
				name="item_unit_id" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_UOM", "AAR"); ?>" disabled readonly>
					<option value="0" selected>--- Please Select Code---</option>
<?php
	$qu_gen_items_units_sel = "SELECT `unit_id`, `unit_name` FROM  `gen_items_units`";
	$qu_gen_items_units_EXE = mysqli_query($KONN, $qu_gen_items_units_sel);
	if(mysqli_num_rows($qu_gen_items_units_EXE)){
		while($gen_items_units_REC = mysqli_fetch_array($qu_gen_items_units_EXE)){
		?>
		<option value="<?=$gen_items_units_REC[0]; ?>"><?=$gen_items_units_REC[1]; ?></option>
		<?php
		}
	}
?>
		</select>
	</div>
	<br>
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('Certificate_Required', 'ARR', 1); ?></label>
		<input class="frmData" type="checkbox" 
				id="new-certificate_required" 
				name="certificate_required" 
				req="1" 
				den=""  
				alerter="<?=lang("Please_Check_item_qty", "AAR"); ?>">
	</div>
	
	<div class="nwFormGroup">
		<label class="lbl_class">&nbsp;</label>
		<input class="frmData" type="text" 
				id="new-item_cr" 
				name="item_cr" 
				req="0" 
				den="" 
				value="" 
				alerter="<?=lang("Please_Check_CR", "AAR"); ?>" disabled>
	</div>
	
	
</div>
<script>

	$('#new-certificate_required').on('change', function(){
		
		if ($(this).is(":checked")) {
			 $('#new-item_cr').prop('disabled', false);
			 $('#new-item_cr').attr('req', '1');
			 $('#new-item_cr').val('');
		} else {
			 $('#new-item_cr').prop('disabled', true);
			 $('#new-item_cr').attr('req', '0');
			 $('#new-item_cr').val('');
		}
		
	});
	
</script>

	<div class="zero"></div>
	<br>
	<br>
	<br>

	<div class="form-alerts"></div>
	<div class="zero"></div>

<div class="col-100">
	<div class="viewerBodyButtons text-center">
		<button type="button" onclick="submit_form('add-new-item-form', 'close_details');">
			<?=lang('Edit', 'ARR', 1); ?>
		</button>
		<button type="button" onclick="hide_details('NewItemDetails');">
			<?=lang("Cancel", "AAR"); ?>
		</button>

	</div>
</div>



<script>
function change_category(){
	var dataID = parseInt( $('#new-category_id').val() );
	if( dataID != 0 ){
		
		var is_f = parseInt( $('#cats-' + dataID).attr('is_finished') );
		if( is_f == 0 ){
			$.ajax({
			url      :"<?=api_root; ?>inventory/lvl06/get_dt.php",
			data     :{ 'data_id': dataID },
			dataType :"html",
			type     :'POST',
			success  :function(data){
				$('#f-item_code_id').show();
				$('#new-item_code_id').html(data);
				},
			error    :function(){
				alert('Data Error No: 5467653');
				},
			});
		} else {
			//hide rest
			//change unit
			var nwUnit = parseInt( $('#cats-' + dataID).attr('unit_id') );
			$('#new-item_unit_id').val( nwUnit );
		}
		
		
			
			
	}
}

function change_subdivision(){
	var dataID = parseInt( $('#new-subdivision_id').val() );
	if( dataID != 0 ){
		
		var is_f = parseInt( $('#subdivs-' + dataID).attr('is_finished') );
		if( is_f == 0 ){
			$.ajax({
			url      :"<?=api_root; ?>inventory/lvl05/get_dt.php",
			data     :{ 'data_id': dataID },
			dataType :"html",
			type     :'POST',
			success  :function(data){
				$('#new-item_code_id').html('');
				$('#new-category_id').html('');
				$('#f-category_id').show();
				$('#new-category_id').html(data);
				},
			error    :function(){
				alert('Data Error No: 5467653');
				},
			});
		} else {
			//hide rest
			//change unit
			var nwUnit = parseInt( $('#subdivs-' + dataID).attr('unit_id') );
			$('#new-item_unit_id').val( nwUnit );
		}
		
		
		
		
	}
}

function change_division(){
	var dataID = parseInt( $('#news-division_id').val() );
	if( dataID != 0 ){
		
		var is_f = parseInt( $('#divs-' + dataID).attr('is_finished') );
		if( is_f == 0 ){
			$.ajax({
			url      :"<?=api_root; ?>inventory/lvl04/get_dt.php",
			data     :{ 'data_id': dataID },
			dataType :"html",
			type     :'POST',
			success  :function(data){
				$('#new-item_code_id').html('');
				$('#new-category_id').html('');
				$('#new-subdivision_id').html('');
				$('#f-subdivision_id').show();
				$('#new-subdivision_id').html(data);
				},
			error    :function(){
				alert('Data Error No: 5467653');
				},
			});
		} else {
			//hide rest
			//change unit
			var nwUnit = parseInt( $('#divs-' + dataID).attr('unit_id') );
			$('#new-item_unit_id').val( nwUnit );
			
		}
		
		
	}
}

function change_section(){
	var dataID = parseInt( $('#new-section_id').val() );
	if( dataID != 0 ){
		
		var is_f = parseInt( $('#sec-' + dataID).attr('is_finished') );
		if( is_f == 0 ){
			$.ajax({
			url      :"<?=api_root; ?>inventory/lvl03/get_dt.php",
			data     :{ 'data_id': dataID },
			dataType :"html",
			type     :'POST',
			success  :function(data){
				$('#new-item_code_id').html('');
				$('#new-category_id').html('');
				$('#new-subdivision_id').html('');
				$('#news-division_id').html('');
				
				$('#f-division_id').show();
				$('#news-division_id').html(data);
				},
			error    :function(){
				alert('Data Error No: 5467653');
				},
			});
		} else {
			//hide rest
			//change unit
			var nwUnit = parseInt( $('#sec-' + dataID).attr('unit_id') );
			$('#new-item_unit_id').val( nwUnit );
			
		}
		
		
	}
}

function change_family(){
	hideAll();
	var dataID = parseInt( $('#new-family_id').val() );
	if( dataID != 0 ){
		clearAll();
				
		var is_f = parseInt( $('#fm-' + dataID).attr('is_finished') );
		if( is_f == 0 ){
			$.ajax({
			url      :"<?=api_root; ?>inventory/lvl02/get_dt.php",
			data     :{ 'data_id': dataID },
			dataType :"html",
			type     :'POST',
			success  :function(data){
				//clear all others
				$('#f-section_id').show();
				$('#new-section_id').html(data);
				},
			error    :function(){
				alert('Data Error No: 5467653');
				},
			});
		} else {
			//hide rest
			
			
		}
	}
}

function hideAll(){
	$('#f-item_code_id').hide();
	$('#f-category_id').hide();
	$('#f-subdivision_id').hide();
	$('#f-division_id').hide();
	$('#f-section_id').hide();
}

function clearAll(){
	$('#new-item_code_id').html('');
	$('#new-category_id').html('');
	$('#new-subdivision_id').html('');
	$('#news-division_id').html('');
	$('#new-section_id').html('');
}
		
</script>


<script>
$('#new-item_code_id').on('change', function(){
	var codeID = parseInt( $('#new-item_code_id').val() );
	if( codeID != 0 ){
		var codeDesc = $('#coder-' + codeID).attr('desc');
		var codeUnit = parseInt( $('#coder-' + codeID).attr('uniter') );
		// $('#new-sub_division_description').val( codeDesc );
		$('#new-item_unit_id').val( codeUnit );
	} else {
		// $('#new-sub_division_description').val( '' );
		$('#new-item_unit_id').val( '0' );
	}
} );
</script>

















					<div class="zero"></div>
</form>
		
		
	</div>
	<div class="zero"></div>
</div>

<script>
$('#new-family_id').on( 'change', function(){
	change_family();
} );
$('#new-section_id').on( 'change', function(){
	change_section();
} );
$('#news-division_id').on( 'change', function(){
	change_division();
} );
$('#new-subdivision_id').on( 'change', function(){
	change_subdivision();
} );
$('#new-category_id').on( 'change', function(){
	change_category();
} );















hideAll();
</script>

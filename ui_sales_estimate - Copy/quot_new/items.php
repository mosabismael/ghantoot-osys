


<?php
$pID = 0;
if( isset( $_GET['project_id'] ) ){
	$pID = (int) test_inputs( $_GET['project_id'] );
}
?>








	<div class="form-grp">
		<div class="form-title">
			<label><?=lang('Added_items'); ?></label><div class="borderer"></div>
		</div>
	</div>

		<input type="hidden" class="frmData" 
				id="has-items" 
				name="has-items" 
				req="1" 
				den="0" 
				value="0"
				alerter="<?=lang("No_items_were_added", "AAR"); ?>">
	<div class="form-grp">
<div class="form-item col-100">
	<label><?=lang('vat_included'); ?></label>
		<select class="frmData" 
				id="new-is_vat_included" 
				name="is_vat_included" 
				req="1" 
				den="100" 
				alerter="<?=lang("Please_Check_VAT", "AAR"); ?>">
			<option value="1" selected><?=lang('YES'); ?></option>
			<option value="0"><?=lang('NO'); ?></option>
		</select>
		<br>
</div>
		<div class="form-item col-100">
			<table class="tabler">
				<thead>
					<tr>
						<th><?=lang('---'); ?></th>
						<th><?=lang('No.'); ?></th>
						<th><?=lang('name'); ?></th>
						<th><?=lang('qty'); ?></th>
						<th><?=lang('price'); ?></th>
						<th><?=lang('Totals'); ?></th>
					</tr>
				</thead>
				<tbody>
				
				
				
<?php
if( $pID != 0 ){
	$itmCount = 1500;
	$countCount = 0;
	$qu_z_work_scope_sel = "SELECT * FROM  `z_work_scope` WHERE `project_id` = $pID";
	$qu_z_work_scope_EXE = mysqli_query($KONN, $qu_z_work_scope_sel);
	if(mysqli_num_rows($qu_z_work_scope_EXE)){
		while($z_work_scope_REC = mysqli_fetch_assoc($qu_z_work_scope_EXE)){
			$scope_id = $z_work_scope_REC['scope_id'];
			$item_name = $z_work_scope_REC['item_name'];
			$item_qty = $z_work_scope_REC['item_qty'];
			$unit_id = $z_work_scope_REC['unit_id'];
			$project_id = $z_work_scope_REC['project_id'];
			$item_price = $z_work_scope_REC['item_price'];
			$itmCount++;
			$countCount++;
			$tsTot = $item_qty * $item_price;
			$thsUnitName = '';
			
	$qu_gen_items_units_sel = "SELECT `unit_name` FROM  `gen_items_units` WHERE `unit_id` = $unit_id";
	$qu_gen_items_units_EXE = mysqli_query($KONN, $qu_gen_items_units_sel);
	$unit_name = "";
	if(mysqli_num_rows($qu_gen_items_units_EXE)){
		$gen_items_units_DATA = mysqli_fetch_assoc($qu_gen_items_units_EXE);
		$unit_name = $gen_items_units_DATA['unit_name'];
	}

			
			
		?>
<tr id="itemo-<?=$itmCount; ?>" class="quote_item" idler="<?=$itmCount; ?>">
	<td><i onclick="rem_item(<?=$itmCount; ?>);" class="fa fa-trash" style="color:red;cursor:pointer;" area-hidden="true"></i></td>
	<td class="item-c"><?=$countCount; ?></td>
	<td><?=$item_name; ?></td>
	<td><span class="qtyer"><?=$item_qty; ?></span>(<?=$unit_name; ?>)</td>
	<td class="pricer"><?=number_format($item_price, 3); ?></td>
	<td class="pricer"><?=number_format($tsTot, 3); ?></td>
	<input class="frmData" type="hidden" id="new-item_names1" name="item_names[]" req="1" den="" value="<?=$item_name; ?>" alerter="Please_Check_Items">
	<input class="frmData" type="hidden" id="new-item_qtys1" name="item_qtys[]" req="1" den="0" value="<?=$item_qty; ?>" alerter="Please_Check_Items">
	<input class="frmData" type="hidden" id="new-item_units1" name="item_units[]" req="1" den="0" value="<?=$unit_id; ?>" alerter="Please_Check_Items">
	<input class="frmData" type="hidden" id="new-item_prices1" name="item_prices[]" req="1" den="" value="<?=$item_price; ?>" alerter="Please_Check_Items">
</tr>
		<?php
		}
	}
}
?>
				
				
				
				
				
<tr id="added_items"><td colspan="6"><hr></td></tr>	
<tr>
	<td colspan="2">
		<div class="form-item">
		<select id="item_unit" class="data-elem">
			<option value="0" disabled selected><?=lang('---select Unit ---'); ?></option>
<?php
$qpt = "SELECT * FROM `gen_items_units`";
$QER_E = mysqli_query($KONN, $qpt);
	if(mysqli_num_rows($QER_E) > 0){
		while($pt_dt = mysqli_fetch_assoc($QER_E)){
?>
	<option value="<?=$pt_dt['unit_id']; ?>" id="uniter-<?=$pt_dt['unit_id']; ?>" uniter="<?=$pt_dt['unit_name']; ?>"><?=$pt_dt['unit_name']; ?></option>
<?php
		}
	}
?>
		</select>
		</div>
	</td>
	<td>
		<div class="form-item">
			<input type="text" placeholder="<?=lang('item_name'); ?>" id="item_name" value="">
		</div>
	</td>
	<td>
		<div class="form-item">
			<input type="text" placeholder="<?=lang('item_qty'); ?>" id="item_qty">
		</div>
	</td>
	<td>
		<div class="form-item">
			<input type="text" placeholder="<?=lang('item_price'); ?>" id="item_price">
		</div>
	</td>
	<td>
		<div class="form-item">
			<button class="btn btn-info" onclick="add_item();" type="button">&nbsp;&nbsp;&nbsp;<?=lang('Add_item'); ?>&nbsp;&nbsp;&nbsp;</button>
		</div>
	</td>
</tr>
				
				</tbody>
				<thead>
					<tr>
						<th colspan="5" style="text-align:right;"><?=lang('Sub_Total_:'); ?></th>
						<th id="sub_total"><?=lang('00'); ?></th>
					</tr>
					<tr>
						<th colspan="5" style="text-align:right;"><?=lang('Discount_amount_:'); ?></th>
						<th id="discount_amount">
							<input type="text" class="frmData" 
									id="txt_discount_amount" 
									name="discount_amount" 
									req="1" 
									den="" 
									value="00"
									alerter="<?=lang("Please_Check_discount_Value", "AAR"); ?>">
						</th>
					</tr>
					<tr>
						<th colspan="5" style="text-align:right;"><?=lang('total_before_vat_:'); ?></th>
						<th id="total_before_vat"><?=lang('00'); ?></th>
					</tr>
					<tr>
						<th colspan="5" style="text-align:right;"><?=lang('VAT_(5%)_:'); ?></th>
						<th id="vat_total"><?=lang('00'); ?></th>
					</tr>
					<tr>
						<th colspan="5" style="text-align:right;"><?=lang('Total_:'); ?></th>
						<th id="all_total"><?=lang('00'); ?></th>
					</tr>
				</thead>
			</table>
		</div>
		<div class="zero"></div>
	</div>

	

<script>
var items_c = 0;
var itemsCount = 0;
function add_item(){
	//collect data
	items_c++;
	var item_name = $('#item_name').val();
	var item_qty = parseInt( $('#item_qty').val() );
	if( isNaN( item_qty ) ){
		item_qty = 0;
	}
	var item_unit = parseInt( $('#item_unit').val() );
	if( isNaN( item_unit ) ){
		item_unit = 0;
	}
	if( item_unit != 0 ){
		
		var ths_tot = 0;
		var item_unit_name = $('#uniter-' + item_unit).attr("uniter");
		var item_price = parseFloat( $('#item_price').val() );
		
		if( isNaN( item_price ) ){
			item_price = 0;
		}
		
		var inputer = '';
		
		inputer +=  '<input class="frmData" type="hidden" ' + 
					'		id="new-item_names' + items_c + '" ' + 
					'		name="item_names[]" ' + 
					'		req="1" ' + 
					'		den="" ' + 
					'		value="' + item_name + '"' + 
					'		alerter="Please_Check_Items">';
		inputer +=  '<input class="frmData" type="hidden" ' + 
					'		id="new-item_qtys' + items_c + '" ' + 
					'		name="item_qtys[]" ' + 
					'		req="1" ' + 
					'		den="0" ' + 
					'		value="' + item_qty + '"' + 
					'		alerter="Please_Check_Items">';
		inputer +=  '<input class="frmData" type="hidden" ' + 
					'		id="new-item_units' + items_c + '" ' + 
					'		name="item_units[]" ' + 
					'		req="1" ' + 
					'		den="0" ' + 
					'		value="' + item_unit + '"' + 
					'		alerter="Please_Check_Items">';
		inputer +=  '<input class="frmData" type="hidden" ' + 
					'		id="new-item_prices' + items_c + '" ' + 
					'		name="item_prices[]" ' + 
					'		req="1" ' + 
					'		den="" ' + 
					'		value="' + item_price + '"' + 
					'		alerter="Please_Check_Items">';
					
					
		ths_tot = item_qty * item_price;
		
		
		if(item_name != ""){
			
			var nw_tr = '<tr id="itemo-' + items_c + '" class="quote_item" idler="' + items_c + '">'+ 
							'<td><i onclick="rem_item(' + items_c + ');" class="fa fa-trash" style="color:red;cursor:pointer;" area-hidden="true"></i></td>'+ 
							'<td class="item-c">' + items_c + '</td>'+ 
							'<td>' + item_name + '</td>'+ 
							'<td><span class="qtyer">' + item_qty + '</span>' + "(" + item_unit_name + ")" + '</td>'+ 
							'<td class="pricer">' + item_price.toFixed(3) + '</td>'+ 
							'<td class="pricer">' + ths_tot.toFixed(3) + '</td>'+ 
							'' + inputer +
						'</tr>';
			
			$('#added_items').before(nw_tr);
			ClearInputForm();
			itemsCount++;
			fix_counters();
			
		} else {
			alert( "Please Insert Item Name" );
		}
		
	} else {
		alert( "Please Select Item Unit" );
	}
	
	
	
	
	
}

function ClearInputForm(){
	$('#item_name').val('');
	$('#item_qty').val('');
	$('#item_unit').val('0');
	$('#item_price').val('');
}

function fixItemCheck(){
	if( itemsCount != 0 ){
		$('#has-items').val(1);
	}else {
		$('#has-items').val(0);
	}
}

function rem_item(idd){
	$('#itemo-' + idd).remove();
	itemsCount--;
	fix_counters();
}

function fix_counters(){
	fixItemCheck();
	var cc = 0;
	$('.item-c').each(function(){
		cc++;
		$(this).html(cc);
	});
	
	var sub_tot = 0;
	$('.quote_item').each(function(){
		var idd = parseInt($(this).attr('idler'));
		var ths_qty = parseFloat($('#itemo-' + idd + ' .qtyer').html());
		var ths_prc = parseFloat($('#itemo-' + idd + ' .pricer').html());
		sub_tot = (ths_qty * ths_prc) + sub_tot;
	});
	
	
	var discount_amount = parseFloat( $('#txt_discount_amount').val() );
	if( isNaN( discount_amount ) ){
		discount_amount = 0;
	}
	
	$('#sub_total').html(sub_tot.toFixed(3));
	// vat_total
	// all_total
	sub_tot = sub_tot - discount_amount;
	
	var isVat = parseInt( $('#new-is_vat_included').val() );
	var vat = 0;
	if( isVat == 1 ){
		var vat = sub_tot * 0.05;
	}
	
	
	
	
	
	
	
	var all = sub_tot + vat;
	
	// $('#txt_discount_amount').val(discount_amount.toFixed(3));
	$('#total_before_vat').html(sub_tot.toFixed(3));
	$('#vat_total').html(vat.toFixed(3));
	$('#all_total').html(all.toFixed(3));
	
	
}

$('#txt_discount_amount').on('input', function(){
	fix_counters();
} );

$('#new-is_vat_included').on('change', function(){
	fix_counters();
} );


</script>

<br>
<br>
<br>
<br>
<br>
	
<div class="btns-holder">
	<button class="btn btn-primary" type="button" onClick="set_tabber(2);"><?=lang('Previous'); ?></button>
	<button class="btn btn-primary" type="button" onClick="set_tabber(4);"><?=lang('next'); ?></button>
</div>
	

	<div class="form-grp">
	
		<div class="form-item col-100">
			<table class="tabler">
				<thead>
					<tr>
						<th><?=lang('---'); ?></th>
						<th><?=lang('Start_Date'); ?></th>
						<th><?=lang('Duration'); ?>(Days)</th>
						<th><?=lang('End_Date'); ?></th>
					</tr>
				</thead>
				<tbody>
				
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


function rem_item(idd){
	$('#itemo-' + idd).remove();
	itemsCount--;
	fix_counters();
}

function fix_counters(){
	
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
	
	
	
	
	
	
	var all = sub_tot + vat;
	
	
}


</script>

<br>
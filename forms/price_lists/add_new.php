



<div class="row">
	<div class="col-100">
<form 
id="add-new-pl-form" 
id-modal="add_new_requisition_rfq" 
id-details="addPriceListDetails" 
api="<?=api_root; ?>requisitions/price_lists/add_price_list.php">


<input class="frmData" type="hidden" 
		id="pl-new-requisition_id" 
		name="requisition_id" 
		value="" 
		req="1" 
		den="0" 
		alerter="<?=lang("Please_Check_requisition", "AAR"); ?>">
		
<input class="frmData" type="hidden" 
		id="pl-new-supplier_id" 
		name="supplier_id" 
		value="" 
		req="1" 
		den="0" 
		alerter="<?=lang("Please_Check_requisition", "AAR"); ?>">
		
<input class="frmData" type="hidden" 
		id="pl-new-rfq_id" 
		name="rfq_id" 
		value="" 
		req="1" 
		den="0" 
		alerter="<?=lang("Please_Check_requisition", "AAR"); ?>">
		
		

<div class="col-50">
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('Supplier_Name', 'AA', 1); ?></label>
		<input class="readOnly important" 
				id="pl-new-supplier_name" 
				type="text" readonly>
	</div>
</div>

<div class="col-50">
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('Requisition_REF', 'AA', 1); ?></label>
		<input class="readOnly important" 
				id="pl-new-requisition_ref" 
				type="text" readonly>
	</div>
</div>
		
		
		

<div class="col-50">
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('currency', 'ARR', 1); ?></label>
		<select class="frmData" 
				id="pl-new-currency_id" 
				name="currency_id" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_currency", "AAR"); ?>">
				<option value="0" selected><?=lang('Please_Select', 'AA', 1); ?></option>
<?php
	$qu_FETCH_sel = "SELECT `currency_id`, `currency_name` FROM  `gen_currencies`";
	$qu_FETCH_EXE = mysqli_query($KONN, $qu_FETCH_sel);
	if(mysqli_num_rows($qu_FETCH_EXE)){
		while($fetched_DT = mysqli_fetch_array($qu_FETCH_EXE)){
		?>
		<option id="cur-<?=$fetched_DT[0]; ?>" cur="<?=$fetched_DT[1]; ?>" value="<?=$fetched_DT[0]; ?>"><?=$fetched_DT[1]; ?></option>
		<?php
		}
	}
?>
			</select>
	</div>
</div>
<script>
$('#pl-new-currency_id').on( 'change', function(){
	var ths_vv = parseInt( $('#pl-new-currency_id').val() );
	if( ths_vv != 0 ){
		var cur_n = $('#cur-' + ths_vv ).attr('cur');
		$('#cur_name').html( cur_n );
	}
} );

</script>

<div class="col-50">
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('vat_included', 'ARR', 1); ?></label>
		<select class="frmData" 
				id="pl-new-is_vat_included" 
				name="is_vat_included" 
				req="1" 
				den="100" 
				alerter="<?=lang("Please_Check_VAT", "AAR"); ?>">
					<option value="1" selected><?=lang('YES'); ?></option>
					<option value="0"><?=lang('NO'); ?></option>
			</select>
	</div>
</div>

<div class="zero"></div>

<div class="col-50">
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('Supplier quotation ref', 'AA', 1); ?></label>
		<input class="frmData" 
				id="pl-new-supplier_quotation_ref" 
				name="supplier_quotation_ref" 
				type="text"
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_supplier_quotation_ref", "AAR"); ?>">
				
		
	</div>
</div>

<div class="col-50">
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('delivery_period', 'ARR', 1); ?></label>
		<select class="frmData" 
				id="pl-new-delivery_period_id" 
				name="delivery_period_id" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_delivery_period", "AAR"); ?>">
				<option value="0" selected><?=lang('Please_Select', 'AA', 1); ?></option>
<?php
	$qu_FETCH_sel = "SELECT `delivery_period_id`, `delivery_period_title` FROM  `gen_delivery_periods`";
	$qu_FETCH_EXE = mysqli_query($KONN, $qu_FETCH_sel);
	if(mysqli_num_rows($qu_FETCH_EXE)){
		while($fetched_DT = mysqli_fetch_array($qu_FETCH_EXE)){
		?>
		<option value="<?=$fetched_DT[0]; ?>"><?=$fetched_DT[1]; ?></option>
		<?php
		}
	}
?>
			</select>
	</div>
</div>


<div class="col-50">
	<div class="nwFormGroup">
		<label class="lbl_class">
			<a id="viewQuoteSupp" target="_blank"><i class="fas fa-paperclip"></i></a>
			&nbsp;&nbsp;<?=lang('quotation', 'AA', 1); ?>
		</label>
		<input class="frmData" 
				id="pl-new-attached_supplier_quotation" 
				name="attached_supplier_quotation" 
				type="file"
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Attach_quotation_file", "AAR"); ?>">
		<input class="frmData" 
				id="pl-new-attached_supplier_quotation1" 
				name="attached_supplier_quotation1" 
				type="file"
				req="0" 
				den="0" 
				alerter="<?=lang("Please_Check_supplier_quotation_file", "AAR"); ?>"><br/>
				
		    
	</div>
</div>

	

<div class="col-50">
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('payment_term', 'ARR', 1); ?></label>
		<select class="frmData" 
				id="pl-new-payment_term_id" 
				name="payment_term_id" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_payment_term", "AAR"); ?>">
				<option value="0" selected><?=lang('Please_Select', 'AA', 1); ?></option>
<?php
	$qu_FETCH_sel = "SELECT `payment_term_id`, `payment_term_title` FROM  `gen_payment_terms`";
	$qu_FETCH_EXE = mysqli_query($KONN, $qu_FETCH_sel);
	if(mysqli_num_rows($qu_FETCH_EXE)){
		while($fetched_DT = mysqli_fetch_array($qu_FETCH_EXE)){
		?>
		<option value="<?=$fetched_DT[0]; ?>"><?=$fetched_DT[1]; ?></option>
		<?php
		}
	}
?>
			</select>
	</div>
</div>
<div class="zero"></div>
<div class="col-100">
<div class="element-to-paste-filename" style = "float:left"></div>
</div>
<div class="col-50">
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('notes', 'ARR', 1); ?></label>
		<textarea class="frmData" type="text" 
				id="pl-new-notes" 
				name="notes" 
				req="0" 
				den="" 
				rows="5"
				alerter="<?=lang("Please_Check_requisition_notes", "AAR"); ?>"></textarea>
	</div>
</div>

<div class="zero"></div>
		
		
		
		
		
		
		
		
		
		
		<table class="tabler" border="1">
			<thead>
				<tr>
					<th>--</th>
					<th><?=lang('No.'); ?></th>
					<th><?=lang('name'); ?></th>
					<th style="width:10%;"><?=lang('qty'); ?></th>
					<th><?=lang('UOM'); ?></th>
					<th><?=lang('U.P'); ?></th>
					<th style="width:15%;"><?=lang('Total'); ?> ( <span id="cur_name">please select currency</span> )</th>
				</tr>
			</thead>
			<tbody id="added_rfq_items"></tbody>
			<tbody>
<tr>
	<td colspan="5">&nbsp;</td>
	<td style="text-align:right;">
	Discount Amount 
		<input class="frmData discount_per" 
				id="pl-new-discount_per" 
				name="discount_percentage" 
				onClick="this.select();"
				type="number" 
				value="0" step="0.5" min="0" max="100" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_discount_percentage", "AAR"); ?>">
	(%) :
	</td>
	<td>
		<input class="frmData discount_amount" 
				id="pl-new-discount_amount" 
				name="discount_amount" 
				type="text" 
				value="0"
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_discount_amount", "AAR"); ?>" readonly>
	</td>
</tr>

<tr>
	<td colspan="5">&nbsp;</td>
	<td style="text-align:right;">Sub Total :</td>
	<td style="text-align:center;">
		<input id="total_before_vat" type="text" value="0" disabled>
	</td>
</tr>
<tr>
	<td colspan="5">&nbsp;</td>
	<td style="text-align:right;">Total Vat Amount :</td>
	<td style="text-align:center;">
		<input id="total_vat_amount" type="text" value="0" disabled>
	</td>
</tr>
<tr>
	<td colspan="5">&nbsp;</td>
	<td style="text-align:right;">Total :</td>
	<td style="text-align:center;">
		<input id="all_total" type="text" value="0" disabled>
	</td>
</tr>
				
			
			</tbody>
		</table>
		
			
	<div class="form-alerts" id="add-pl-form-alerts"></div>
	<div class="zero"></div>
	
			<div class="viewerBodyButtons">
				<button id="savePlButton" type="button" onclick="submit_form('add-new-pl-form', 'close_details');"><?=lang("Add", "AAR"); ?></button>
				<button type="button" onclick="hide_details('addPriceListDetails');"><?=lang("Cancel", "AAR"); ?></button>
			</div>
</form>

	</div>
</div>








<script>
function cal_table(){
	var totBeforeVat = 0;
	$('.item_list').each( function(){
		var itemId = $(this).attr('idler');
		var ths_qty = parseFloat( $('#new-item_qtys' + itemId).val() );
		if( isNaN( ths_qty ) ){
			ths_qty = 0;
		}
		console.log(ths_qty);
		
		var ths_price = parseFloat( $('#new-item_prices' + itemId).val() );
		if( isNaN( ths_price ) ){
			ths_price = 0;
		}
		var thsTot = ths_qty * ths_price;
		totBeforeVat = totBeforeVat + thsTot;
		$('#new-total' + itemId).val( insertDecimal(thsTot) );
		
		
	} );
	
	var disAmount = 0;
	var discount_percentage = parseFloat( $('#pl-new-discount_per').val() );
	if( isNaN( discount_percentage ) ){
		discount_percentage = 0;
	}
	
	var is_vat = parseInt( $('#pl-new-is_vat_included').val() );
	var discount_amount = totBeforeVat * (discount_percentage / 100 );
		
	
	vatPer = 0.05;
	if( is_vat == 0 ){
		vatPer = 0;
	}
	
	var totAfterVat = 0;
	var totVat      = 0;
	
	
	totBeforeVat = totBeforeVat - discount_amount;
	totVat = totBeforeVat * vatPer;
	totAfterVat = totBeforeVat + totVat;
	
	
	$('#pl-new-discount_amount').val( insertDecimal(discount_amount) );
	$('#total_before_vat').val( insertDecimal(totBeforeVat) );
	$('#total_vat_amount').val( insertDecimal(totVat) );
	$('#all_total').val( insertDecimal(totAfterVat) );
	
	
}


</script>







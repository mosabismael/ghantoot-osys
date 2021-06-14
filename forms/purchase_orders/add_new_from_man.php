	<form 
	id="add-new-man-form" 
	class="boxes-holder" 
	api="<?=api_root; ?>purchase_orders/add_new_po_man.php">
	
	
	<div class="row col-33">
		<div class="nwFormGroup">
			<label><?=lang("po_ref", "AAR"); ?></label>
			<input class="" 
					type="text"
					value="AUTO"
					req="1" 
					den="0" 
					alerter="<?=lang("Please_Check_requisition_type", "AAR"); ?>" disabled>
		</div>
		<div class="nwFormGroup">
			<label><?=lang("rev_no", "AAR"); ?></label>
			<input type="text" value="0" class="readOnly">
		</div>
		<div class="nwFormGroup">
			<label class="lbl_class"><?=lang('Created_By', 'ARR', 1); ?></label>
			<input  class="" 
					type="text" 
					value="<?=$USER_NAME; ?>"  disabled>
		</div>
	</div>
	
	<div class="row col-33">
		<div class="nwFormGroup">
			<label><?=lang("requisition", "AAR"); ?></label>
			<select class="frmData" 
					id="new-man-requisition_id" 
					name="requisition_id" 
					req="1" 
					den="0" 
					alerter="<?=lang("Please_Check_requisition", "AAR"); ?>">
					<option value="0" selected><?=lang("Please_Select", "غير محدد"); ?></option>
<?php
	$sNo = 0;
	$qu_pur_requisitions_sel = "SELECT * FROM  `pur_requisitions` ORDER BY `requisition_id` DESC";
	$qu_pur_requisitions_EXE = mysqli_query($KONN, $qu_pur_requisitions_sel);
	if(mysqli_num_rows($qu_pur_requisitions_EXE)){
		while($pur_requisitions_REC = mysqli_fetch_assoc($qu_pur_requisitions_EXE)){
			
		$req_id = $pur_requisitions_REC['requisition_id'];
		$requisition_ref = $pur_requisitions_REC['requisition_ref'];
		$requisition_type = $pur_requisitions_REC['requisition_type'];
		
		?>
			<option id="new-man-sel-req-<?=$req_id; ?>" value="<?=$req_id; ?>"><?=$requisition_ref; ?>( <?=$requisition_type; ?> )</option>
		<?php
		}
	}
?>
				</select>
		</div>

		<div class="nwFormGroup">
			<label class="lbl_class"><?=lang('Job_Order', 'ARR', 1); ?></label>
			<select class="frmData" 
					id="new-man-job_order_id" 
					name="job_order_id" 
					req="1" 
					den="" 
					alerter="<?=lang("Please_Check_Job_Order", "AAR"); ?>">
					<option value="0" selected><?=lang("NA", "غير محدد"); ?></option>
				</select>
		</div>
		
		<div class="nwFormGroup">
			<label><?=lang("Project", "AAR"); ?></label>
			<input type="text" value="0" class="readOnly">
		</div>
	</div>
	
	<div class="row col-33">
		<div class="nwFormGroup">
			<label><?=lang("PO_Status", "AAR"); ?></label>
			<input type="text" value="Draft" class="readOnly">
		</div>
		
		<div class="nwFormGroup">
			<label><?=lang("PO_date", "AAR"); ?></label>
			<input type="text" value="<?=date('Y-m-d'); ?>" class="readOnly">
		</div>
	</div>
	
	
	
	<div class="row col-100">
		<hr>
	</div>
		<div class="zero"></div>
	
	

<div class="col-33">

		<div class="nwFormGroup">
			<label><?=lang("Supplier", "AAR"); ?></label>
			<select class="frmData" 
					id="new-man-supplier_id" 
					name="supplier_id" 
					req="1" 
					den="0" 
					alerter="<?=lang("Please_Check_supplier", "AAR"); ?>">
					<option value="0" selected><?=lang("Please_Select", "غير محدد"); ?></option>
<?php
	$sNo = 0;
	$qu_suppliers_list_sel = "SELECT * FROM  `suppliers_list` ORDER BY `supplier_id` DESC";
	$qu_suppliers_list_EXE = mysqli_query($KONN, $qu_suppliers_list_sel);
	if(mysqli_num_rows($qu_suppliers_list_EXE)){
		while($suppliers_list_REC = mysqli_fetch_assoc($qu_suppliers_list_EXE)){
		$sNo++;
			$supp_id = $suppliers_list_REC['supplier_id'];
			$supplier_code = $suppliers_list_REC['supplier_code'];
			$supplier_name = $suppliers_list_REC['supplier_name'];
		
		?>
			<option id="new-man-sel-supp-<?=$supp_id; ?>" value="<?=$supp_id; ?>"><?=$supplier_code; ?> - <?=$supplier_name; ?></option>
		<?php
		}
	}
?>
				</select>
		</div>
		
	
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('Supplier quot. ref', 'AA', 1); ?></label>
		<input class="frmData" 
				id="new-man-supplier_quotation_ref" 
				name="supplier_quotation_ref" 
				type="text"
				value=""
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_supplier_quotation_ref", "AAR"); ?>">
	</div>
	
	<div class="nwFormGroup">
		<label class="lbl_class"><i class="fas fa-paperclip"></i>&nbsp;&nbsp;<?=lang('quotation', 'AA', 1); ?></label>
		<input class="frmData" 
				id="new-man-attached_supplier_quotation" 
				name="attached_supplier_quotation" 
				type="file"
				req="0" 
				den="0" 
				alerter="<?=lang("Please_Check_supplier_quotation_file", "AAR"); ?>">
	</div>
	
		
		
		
		
</div>


<div class="col-33">

	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('delivery_period', 'ARR', 1); ?></label>
		<select class="frmData" 
				id="new-man-delivery_period_id" 
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

	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('payment_term', 'ARR', 1); ?></label>
		<select class="frmData" 
				id="new-man-payment_term_id" 
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


<div class="col-33">
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('currency', 'ARR', 1); ?></label>
		<select class="frmData" 
				id="new-man-currency_id" 
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
	
	
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('vat_included', 'ARR', 1); ?></label>
		<select class="frmData" 
				id="new-man-is_vat_included" 
				name="is_vat_included" 
				req="1" 
				den="100" 
				alerter="<?=lang("Please_Check_VAT", "AAR"); ?>">
			<option value="1" selected><?=lang('YES'); ?></option>
			<option value="0"><?=lang('NO'); ?></option>
			</select>
	</div>
	
	
	
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('notes', 'ARR', 1); ?></label>
		<textarea class="frmData" type="text" 
				id="new-man-notes" 
				name="notes" 
				req="0" 
				den="" 
				rows="3"
				alerter="<?=lang("Please_Check_requisition_notes", "AAR"); ?>"></textarea>
	</div>
	
	
	
</div>
	
	
	<div class="row col-100">
		<br>
		<hr>
		<br>
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
					<th style="width:15%;"><?=lang('Total'); ?> ( <span id="cur_name_man">please select currency</span> )</th>
				</tr>
			</thead>
			<tbody id="added_PO_man_items">
			
			
			
			
			</tbody>
			<tbody>
<tr>
	<td colspan="5">&nbsp;</td>
	<td style="text-align:right;">
	Discount Amount 
		<input class="frmData discount_per" 
				id="new-man-discount_per" 
				name="discount_percentage" 
				value="0"
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
				id="new-man-discount_amount" 
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
		<input id="new-man-total_before_vat" type="text" value="0" disabled>
	</td>
</tr>
<tr>
	<td colspan="5">&nbsp;</td>
	<td style="text-align:right;">Total Vat Amount :</td>
	<td style="text-align:center;">
		<input id="new-man-total_vat_amount" type="text" value="0" disabled>
	</td>
</tr>
<tr>
	<td colspan="5">&nbsp;</td>
	<td style="text-align:right;">Total :</td>
	<td style="text-align:center;">
		<input id="new-man-all_total" type="text" value="0" disabled>
	</td>
</tr>
				
			
			</tbody>
		</table>
	
	
	<div class="row col-100">
		<br>
		<hr>
		<br>
	</div>
		<div class="zero"></div>

		<table class="tabler" border="1">
			<thead>
				<tr>
					<th><span onclick="resetTermsMan();" style="color:red;cursor:pointer;font-size:12px;"><?=lang('RESET'); ?></span></th>
					<th><?=lang('No.'); ?></th>
					<th><?=lang('terms_and_conditions'); ?></th>
				</tr>
			</thead>
			<tbody id="added_PO_man_terms">
			
<?php
	$qu_purchase_orders_terms_list_sel = "SELECT * FROM  `purchase_orders_terms_list`";
	$qu_purchase_orders_terms_list_EXE = mysqli_query($KONN, $qu_purchase_orders_terms_list_sel);
	if(mysqli_num_rows($qu_purchase_orders_terms_list_EXE)){
		$TC = 0;
		while($purchase_orders_terms_list_REC = mysqli_fetch_assoc($qu_purchase_orders_terms_list_EXE)){
			$TC++;
			$term_id = $purchase_orders_terms_list_REC['term_id'];
			$term_title = $purchase_orders_terms_list_REC['term_title'];
			$term_title_ar = $purchase_orders_terms_list_REC['term_title_ar'];
		?>
				<tr id="term-<?=$term_id; ?>">
					<td>
<i title="Delete this item" onclick="$('#term-<?=$term_id; ?>').remove();fixTermsTableman();" class="fas fa-trash"></i>
					</td>
					<th class="po_terms_countMAN"><?=$TC; ?></td>
					<td>
					<input class="frmData"
							id="new-man-po_term<?=$term_id; ?>"
							name="term_ids[]"
							type="hidden"
							value="<?=$term_id; ?>"
							req="1"
							den="0"
							alerter="<?=lang("Please_Check_terms", "AAR"); ?>">
					<?=$term_title; ?>
					</td>
				</tr>
		<?php
		}
	}
?>
			
			</tbody>
		</table>
		
	
	<div class="form-alerts"></div>
	<div class="zero"></div>

<div class="viewerBodyButtons">
		<button type="button" onclick="submit_form('add-new-man-form', 'forward_page');">
			<?=lang('Add', 'ARR', 1); ?>
		</button>
		<button type="button" onclick="hide_details('addNewPOfromPLdetails');">
			<?=lang('Cancel', 'ARR', 1); ?>
		</button>
</div>
			
	</form>
	

<script>
$('#new-man-currency_id').on( 'change', function(){
	var ths_vv = parseInt( $('#new-man-currency_id').val() );
	if( ths_vv != 0 ){
		var cur_n = $('#cur-' + ths_vv ).attr('cur');
		$('#cur_name_man').html( cur_n );
	}
} );
$('#new-man-currency_id').change();


function fixTermsTableman(){
	var TermsCount = 0;
	$('.po_terms_countMAN').each( function(){
		TermsCount++;
		$(this).html( TermsCount );
	} );
}






function cal_table_man(){
	var totBeforeVat = 0;
	$('.po_man_item_list').each( function(){
		var itemId = $(this).attr('idler');
		// console.log(itemId );
		var ths_qty = parseFloat( $('#new-man-po_item_qty' + itemId).val() );
		if( isNaN( ths_qty ) ){
			ths_qty = 0;
		}
		
		var ths_price = parseFloat( $('#new-man-po_item_price' + itemId).val() );
		if( isNaN( ths_price ) ){
			ths_price = 0;
		}
		var thsTot = ths_qty * ths_price;
		totBeforeVat = totBeforeVat + thsTot;
		$('#new-man-po_item_tot' + itemId).val( thsTot.toFixed(3) );
		
		
	} );
	
	var disAmount = 0;
	var discount_percentage = parseFloat( $('#new-man-discount_per').val() );
	if( isNaN( discount_percentage ) ){
		discount_percentage = 0;
	}
	
	var is_vat = parseInt( $('#new-man-is_vat_included').val() );
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
	
	
	$('#new-man-discount_amount').val( discount_amount.toFixed(3) );
	$('#new-man-total_before_vat').val( totBeforeVat.toFixed(3) );
	$('#new-man-total_vat_amount').val( totVat.toFixed(3) );
	$('#new-man-all_total').val( totAfterVat.toFixed(3) );
	
	
}



function delPoManItem( IDD ){
	var aa = confirm('Are you sure, this will remove the item from PO ?');
	if( aa == true ){
		$('#' + IDD).remove();
	}
}





function initTableManEvents(){
	$('.item_man_qtys').on( 'input', function(){
		cal_table_man();
	} );
	$('.item_man_prices').on( 'input', function(){
		cal_table_man();
	} );
	$('#new-man-discount_amount').on( 'input', function(){
		// cal_table_man();
	} );
	$('#new-man-is_vat_included').on( 'input', function(){
		cal_table_man();
	} );
	$('#new-man-discount_per').on( 'input', function(){
		cal_table_man();
	} );
}

var added_PO_man_terms = $('#added_PO_man_terms').html();

function resetTermsMan(){
	$('#added_PO_man_terms').html('');
	$('#added_PO_man_terms').html(added_PO_man_terms);
}



init_nwFormGroup();

initTableManEvents();
cal_table_man();
</script>

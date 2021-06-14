<form 
id="view-po-details-form" 
class="boxes-holder" 
api="<?=api_root; ?>purchase_orders/add_new_po_man.php">
	
	
	
	<div class="row col-33">
		<div class="nwFormGroup">
			<label><?=lang("po_ref", "AAR"); ?></label>
			<input class="po_ref" 
			type="text"
			value="AUTO"
			req="1" 
			den="0" 
			alerter="<?=lang("Please_Check_requisition_type", "AAR"); ?>" disabled>
		</div>
		<div class="nwFormGroup">
			<label class="lbl_class"><?=lang('Created_By', 'ARR', 1); ?></label>
			<input  class="created_by" 
			type="text" 
			value="<?=$USER_NAME; ?>"  disabled>
		</div>
		<div class="nwFormGroup">
			<label class="lbl_class"><?=lang('Revision Number', 'ARR', 1); ?></label>
			<input  class="rev_no" 
			type="text" 
			value=""  disabled>
		</div>
	</div>
	
	
	<div class="row col-33">
		<div class="nwFormGroup">
			<label><?=lang("requisition", "AAR"); ?></label>
			<input class="frmData requisition_id readOnly" 
			id="view-requisition_id" 
			name="requisition_id" 
			type="text"
			req="1" 
			den="0" 
			alerter="<?=lang("Please_Check_requisition", "AAR"); ?>">
		</div>
		
		<div class="nwFormGroup">
			<label class="lbl_class"><?=lang('Job_Order / Project', "AAR"); ?></label>
			<input class="frmData job_order_project readOnly" 
			id="view-job_order_project" 
			name="job_order_project" 
			type="text"
			req="1" 
			den="0" 
			alerter="<?=lang("Please_Check_requisition", "AAR"); ?>">
		</div>
	</div>
	
<div class="row col-33">
<div class="nwFormGroup">
<label><?=lang("PO_Status", "AAR"); ?></label>
<input type="text" value="NEW" class="readOnly po_status">
</div>

<div class="nwFormGroup">
<label><?=lang("PO_date", "AAR"); ?></label>
<input type="text" value="" class="po_date readOnly">
</div>
</div>


<div class="row col-100">
<hr>
</div>
<div class="zero"></div>

<div class="row col-33">
<div class="nwFormGroup">
<label><?=lang("Supplier", "AAR"); ?></label>
<input type="text" value="NEW" class="readOnly supplier_id">
</div>

<div class="nwFormGroup">
<label><?=lang("Supplier quot. ref", "AAR"); ?>(
<a id="viewQuoteSupp" target="_blank"><i class="fas fa-paperclip"></i></a>
)</label>
<input type="text" value="" class="readOnly supplier_quotation_ref">
</div>
</div>

<div class="row col-33">
<div class="nwFormGroup">
<label><?=lang("delivery_period", "AAR"); ?></label>
<input type="text" value="NEW" class="readOnly delivery_period_id">
</div>

<div class="nwFormGroup">
<label><?=lang("payment_term", "AAR"); ?></label>
<input type="text" value="" class="readOnly payment_term_id">
</div>
</div>

<div class="row col-33">
<div class="nwFormGroup">
<label><?=lang("currency", "AAR"); ?></label>
<input type="text" value="NEW" class="readOnly currency_id">
</div>

<div class="nwFormGroup">
<label><?=lang("notes", "AAR"); ?></label>
<textarea class="frmData readOnly notes" type="text" 
id="view-notes" 
name="notes" 
req="0" 
den="" 
rows="3"
alerter="<?=lang("Please_Check_requisition_notes", "AAR"); ?>"></textarea>
</div>
</div>
<div class="row col-100">
<hr>
</div>
<div class="zero"></div>


<div class="tabs">
<div class="tabsHeader">
<div onclick="set_tabber(1);loadPOItems();" class="tabsIdSel-1 activeHeaderTab"><?=lang("Items", "AAR"); ?></div>
<div onclick="set_tabber(3);fetch_item_status(activePO, 'purchase_orders');"" class="tabsIdSel-3"><?=lang("Status_Change", "AAR"); ?></div>
</div>
<div class="tabsId-1 tabsBody tabsBodyActive">




<table class="tabler" border="1">
<thead>
<tr>
<th><?=lang('NO.'); ?></th>
<th style="width:40%;"><?=lang('Item'); ?></th>
<th style="width:10%;"><?=lang('qty'); ?></th>
<th><?=lang('UOM'); ?></th>
<th><?=lang('Days'); ?></th>
<th><?=lang('U.P'); ?></th>
<th style="width:15%;"><?=lang('Total'); ?> ( <span id="cur_name_view">NA</span> )</th>
</tr>
</thead>
<tbody id="added_PO_view_items"></tbody>
<tbody>
<?php
/*
<tr>
<td colspan="5">&nbsp;</td>
<td style="text-align:right;">
Discount Amount 
<input class="frmData discount_percentage discount_per" 
id="view-discount_percentage" 
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
id="view-discount_amount" 
name="discount_amount" 
type="text" 
value="sss"
req="1" 
den="" 
alerter="<?=lang("Please_Check_discount_amount", "AAR"); ?>" readonly>
</td>
</tr>
*/
?>
<input class="frmData" 
id="DELview-discount_percentage" 
name="discount_percentage" 
value="0"
onClick="this.select();"
type="hidden" 
value="0" 
req="1" 
den="" 
alerter="<?=lang("Please_Check_discount_percentage", "AAR"); ?>">
<input class="frmData" 
id="DELview-discount_amount" 
name="discount_amount" 
type="hidden" 
	value="0"
	req="1" 
	den="" 
	alerter="<?=lang("Please_Check_discount_amount", "AAR"); ?>" readonly>
	<tr>
	<td colspan="5">&nbsp;</td>
	<td style="text-align:right;">Sub Total :</td>
	<td style="text-align:center;">
	<input id="view-total_before_vat" type="text" value="0" disabled>
	</td>
	</tr>
	<tr>
	<td colspan="5">&nbsp;</td>
	<td style="text-align:right;">Total Vat Amount :</td>
	<td style="text-align:center;">
	<input class="frmData is_vat_included" 
	id="view-is_vat_included" 
	name="is_vat_included" 
	type="hidden" 
	value="0"
	req="1" 
	den="" 
	alerter="<?=lang("Please_Check_discount_amount", "AAR"); ?>" readonly>
	<input id="view-total_vat_amount" type="text" value="0" disabled>
	</td>
	</tr>
	<tr>
	<td colspan="5">&nbsp;</td>
	<td style="text-align:right;">Total :</td>
	<td style="text-align:center;">
	<input id="view-all_total" type="text" value="0" disabled>
	</td>
	</tr>
	
	</tbody>
	</table>
	
	
	
	
	</div>
	
	
	<div class="tabsId-3 tabsBody" id="fetched_status_change"></div>
	
	
	
	</div>
	
	
	
	<div class="form-alerts"></div>
	<div class="zero"></div>
	
	<div class="viewerBodyButtons">
	<button type="button" onclick="approvePO();">
	<?=lang('Approve_PO', 'ARR', 1); ?>
	</button>
	<button type="button" onclick="denyPO();">
	<?=lang('Deny_PO', 'ARR', 1); ?>
	</button>
	<button type="button" onclick="hide_details('viewPOdetails');">
	<?=lang('Close', 'ARR', 1); ?>
	</button>
	</div>	
	</form>
	
	
	
	
	<script>
	
	
	
	
	function cal_view_table(){
	var totBeforeVat = 0;
	$('.po_view_item_list').each( function(){
	var itemId = $(this).attr('idler');
	// console.log(itemId );
	var ths_qty = parseFloat( $('#view-po_item_qty' + itemId).val() );
	if( isNaN( ths_qty ) ){
	ths_qty = 0;
	}
	
	var ths_price = parseFloat( $('#view-po_item_price' + itemId).val() );
	if( isNaN( ths_price ) ){
	ths_price = 0;
	}
	var thsTot = ths_qty * ths_price;
	totBeforeVat = totBeforeVat + thsTot;
	$('#view-po_item_tot' + itemId).val( thsTot.toFixed(3) );
	
	
	} );
	
	var disAmount = 0;
	var discount_percentage = parseFloat( $('#view-discount_percentage').val() );
	if( isNaN( discount_percentage ) ){
	discount_percentage = 0;
	}
	
	var is_vat = parseInt( $('#view-is_vat_included').val() );
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
	
	
	$('#view-discount_amount').val( discount_amount.toFixed(3) );
	$('#view-total_before_vat').val( totBeforeVat.toFixed(3) );
	$('#view-total_vat_amount').val( totVat.toFixed(3) );
	$('#view-all_total').val( totAfterVat.toFixed(3) );
	
	
	}
	
	</script>	
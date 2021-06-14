<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 2;
	$subPageID = 7;
	
	
	$created_date = "";
	$required_date = "";
	$estimated_date = "";
	$requisition_ref = "";
	$requisition_type = "";
	$job_order_id = 0;
	$requisition_status = "";
	$requisition_notes = "";
	$ordered_by = 0;
	$price_list_id = 0;

	$currency_id = 0;
	$exchange_rate = 0;
	$is_vat_included = 0;
	$supplier_quotation_ref = "";
	$attached_supplier_quotation = "";
	$delivery_period_id = 0;
	$payment_term_id = 0;
	$discount_percentage = 0;
	$discount_amount = 0;
	$notes = "";
	$rfq_id = 0;
	
	
	$po_id = 0;
	
	if( isset( $_GET['po_id'] ) ){
		$po_id = ( int ) test_inputs( $_GET['po_id'] );
	} else {
		header("purchase_orders_drafts.php?err=375");
	}
	
	
	$loadDt = true;
	
	$qu_purchase_orders_sel = "SELECT * FROM  `purchase_orders` WHERE `po_id` = $po_id";
	$qu_purchase_orders_EXE = mysqli_query($KONN, $qu_purchase_orders_sel);
	$purchase_orders_DATA;
	if(mysqli_num_rows($qu_purchase_orders_EXE)){
		$purchase_orders_DATA = mysqli_fetch_assoc($qu_purchase_orders_EXE);
	} else {
		header("purchase_orders_drafts.php?err=375");
	}
	
		$po_ref = $purchase_orders_DATA['po_ref'];
		$rev_no = $purchase_orders_DATA['rev_no'];
		$po_date = $purchase_orders_DATA['po_date'];
		$delivery_date = $purchase_orders_DATA['delivery_date'];
		$delivery_period_id = $purchase_orders_DATA['delivery_period_id'];
		$discount_percentage = $purchase_orders_DATA['discount_percentage'];
		$discount_amount = $purchase_orders_DATA['discount_amount'];
		$is_vat_included = $purchase_orders_DATA['is_vat_included'];
		$payment_term_id = $purchase_orders_DATA['payment_term_id'];
		$currency_id = $purchase_orders_DATA['currency_id'];
		$exchange_rate = $purchase_orders_DATA['exchange_rate'];
		$supplier_quotation_ref = $purchase_orders_DATA['supplier_quotation_ref'];
		$attached_supplier_quotation = $purchase_orders_DATA['attached_supplier_quotation'];
		$notes = $purchase_orders_DATA['notes'];
		$po_status = $purchase_orders_DATA['po_status'];
		$supplier_id = $purchase_orders_DATA['supplier_id'];
		$requisition_id = $purchase_orders_DATA['requisition_id'];
		$job_order_id = $purchase_orders_DATA['job_order_id'];
		
	
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
		
		
		
<form 
	id="add-new-form" 
	class="boxes-holder" 
	api="<?=api_root; ?>purchase_orders/edit_po_draft.php">
	
	
	<div class="row col-33">
		<div class="nwFormGroup">
			<label><?=lang("po_ref", "AAR"); ?></label>
			<input class="" 
					type="text"
					value="<?=$po_ref; ?>"
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
			<input class="frmData" 
					type="hidden" 
					name="po_id" 
					value="<?=$po_id; ?>" 
					req="1" 
					den="0" 
					alerter="<?=lang("Please_Check_po_id", "AAR"); ?>">
			<select class="frmData" 
					id="new-requisition_id" 
					name="requisition_id" 
					req="1" 
					den="0" 
					alerter="<?=lang("Please_Check_requisition", "AAR"); ?>" disabled>
<?php
	$sNo = 0;
	$qu_pur_requisitions_sel = "SELECT * FROM  `pur_requisitions` WHERE `requisition_id` = $requisition_id";
	$qu_pur_requisitions_EXE = mysqli_query($KONN, $qu_pur_requisitions_sel);
	if(mysqli_num_rows($qu_pur_requisitions_EXE)){
		while($pur_requisitions_REC = mysqli_fetch_assoc($qu_pur_requisitions_EXE)){
		$requisition_ref = $pur_requisitions_REC['requisition_ref'];
		$requisition_type = $pur_requisitions_REC['requisition_type'];
		
		?>
			<option id="new-sel-req-<?=$requisition_id; ?>" value="<?=$requisition_id; ?>"><?=$requisition_ref; ?>( <?=$requisition_type; ?> )</option>
		<?php
		}
	}
?>
				</select>
		</div>
		

		<div class="nwFormGroup">
			<label class="lbl_class"><?=lang('Job_Order', 'ARR', 1); ?></label>
			<select class="frmData" 
					id="new-job_order_id" 
					name="job_order_id" 
					req="1" 
					den="" 
					alerter="<?=lang("Please_Check_Job_Order", "AAR"); ?>" disabled>
<?php
	$qu_job_orders_sel = "SELECT * FROM  `job_orders` WHERE `job_order_id` = $job_order_id";
	$qu_job_orders_EXE = mysqli_query($KONN, $qu_job_orders_sel);
	$project_name = '';
	if(mysqli_num_rows($qu_job_orders_EXE)){
		while($job_orders_REC = mysqli_fetch_assoc($qu_job_orders_EXE)){
			
			$job_order_ref = $job_orders_REC['job_order_ref'];
			$project_name = $job_orders_REC['project_name'];
			$job_order_type = $job_orders_REC['job_order_type'];
			$job_order_status = $job_orders_REC['job_order_status'];
			$created_date = $job_orders_REC['created_date'];
			$created_by = $job_orders_REC['created_by'];
		?>
					<option value="<?=$job_order_id; ?>"><?=$job_order_ref; ?> - <?=$job_order_type; ?></option>
		<?php
		}
	}
?>
				</select>
		</div>
		
		<div class="nwFormGroup">
			<label><?=lang("Project", "AAR"); ?></label>
			<input type="text" value="0" value="<?=$project_name; ?>" class="readOnly" disabled>
		</div>
	</div>
	
	<div class="row col-33">
		<div class="nwFormGroup">
			<label><?=lang("PO_Status", "AAR"); ?></label>
			<input type="text" value="NEW" class="readOnly">
		</div>
		
		<div class="nwFormGroup">
			<label><?=lang("PO_date", "AAR"); ?></label>
			<input type="text" value="<?=$po_date; ?>" class="readOnly">
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
					id="new-supplier_id" 
					name="supplier_id" 
					req="1" 
					den="0" 
					alerter="<?=lang("Please_Check_supplier", "AAR"); ?>" disabled>
<?php
	$sNo = 0;
	$qu_suppliers_list_sel = "SELECT * FROM `suppliers_list`  WHERE `supplier_id` = $supplier_id ";
	$qu_suppliers_list_EXE = mysqli_query($KONN, $qu_suppliers_list_sel);
	if(mysqli_num_rows($qu_suppliers_list_EXE)){
		while($suppliers_list_REC = mysqli_fetch_assoc($qu_suppliers_list_EXE)){
		$sNo++;
			$supp_id = $suppliers_list_REC['supplier_id'];
			$supplier_name = $suppliers_list_REC['supplier_name'];
		
		?>
			<option id="new-sel-supp-<?=$supp_id; ?>" value="<?=$supp_id; ?>"><?=$supplier_name; ?></option>
		<?php
		}
	}
?>
				</select>
		</div>
		
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('Supplier quot. ref', 'AA', 1); ?></label>
		<input class="frmData" 
				id="new-supplier_quotation_ref" 
				name="supplier_quotation_ref" 
				type="text"
				value="<?=$supplier_quotation_ref; ?>"
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_supplier_quotation_ref", "AAR"); ?>" disabled>
	</div>
	
	
</div>


<div class="col-33">

	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('delivery_period', 'ARR', 1); ?></label>
		<select class="frmData" 
				id="new-delivery_period_id" 
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
<script>
$('#new-delivery_period_id').val('<?=$delivery_period_id; ?>');
</script>

	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('payment_term', 'ARR', 1); ?></label>
		<select class="frmData" 
				id="new-payment_term_id" 
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
<script>
$('#new-payment_term_id').val('<?=$payment_term_id; ?>');
</script>

</div>


<div class="col-33">
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('currency', 'ARR', 1); ?></label>
		<select class="frmData" 
				id="new-currency_id" 
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
<script>
$('#new-currency_id').val('<?=$currency_id; ?>');
</script>
	
	
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('vat_included', 'ARR', 1); ?></label>
		<select class="frmData" 
				id="new-is_vat_included" 
				name="is_vat_included" 
				req="1" 
				den="100" 
				alerter="<?=lang("Please_Check_VAT", "AAR"); ?>">
			<option value="1" selected><?=lang('YES'); ?></option>
			<option value="0"><?=lang('NO'); ?></option>
			</select>
	</div>
<script>
$('#new-is_vat_included').val('<?=$is_vat_included; ?>');
</script>
	
	
	
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('notes', 'ARR', 1); ?></label>
		<textarea class="frmData" type="text" 
				id="new-notes" 
				name="notes" 
				req="0" 
				den="" 
				rows="3"
				alerter="<?=lang("Please_Check_requisition_notes", "AAR"); ?>"><?=$notes; ?></textarea>
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
					<!--th><span onclick="resetItems();" style="color:red;cursor:pointer;font-size:12px;"><?=lang('RESET'); ?></span></th-->
					<th><?=lang('No.'); ?></th>
					<th><?=lang('name'); ?></th>
					<th style="width:10%;"><?=lang('qty'); ?></th>
					<th><?=lang('UOM'); ?></th>
					<th><?=lang('U.P'); ?></th>
					<th style="width:15%;"><?=lang('Total'); ?> ( <span id="cur_name">please select currency</span> )</th>
				</tr>
			</thead>
			<tbody id="added_PO_items">
<?php

$totBeforeVAT = 0;

$qu_purchase_orders_items_sel = "SELECT * FROM  `purchase_orders_items` WHERE `po_id` = $po_id";
$qu_purchase_orders_items_EXE = mysqli_query($KONN, $qu_purchase_orders_items_sel);
if(mysqli_num_rows($qu_purchase_orders_items_EXE)){
		$CC = 0;
	while($purchase_orders_items_REC = mysqli_fetch_assoc($qu_purchase_orders_items_EXE)){
		
		$CC++;
		$po_item_id = $purchase_orders_items_REC['po_item_id'];
		$family_id = $purchase_orders_items_REC['family_id'];
		$section_id = $purchase_orders_items_REC['section_id'];
		$division_id = $purchase_orders_items_REC['division_id'];
		$subdivision_id = $purchase_orders_items_REC['subdivision_id'];
		$category_id = $purchase_orders_items_REC['category_id'];
		$item_code_id = $purchase_orders_items_REC['item_code_id'];
		$unit_id = $purchase_orders_items_REC['unit_id'];
		$item_qty   = ( double ) $purchase_orders_items_REC['item_qty'];
		$item_price = ( double ) $purchase_orders_items_REC['item_price'];
		$certificate_required = $purchase_orders_items_REC['certificate_required'];
		$po_id = $purchase_orders_items_REC['po_id'];
		
		
		

$item_name = get_item_description( $po_item_id, 'po_item_id', 'purchase_orders_items', $KONN );

$item_unit_name = get_unit_name( $unit_id, $KONN );



$thsTOT = $item_qty * $item_price;

$totBeforeVAT = $totBeforeVAT + $thsTOT;

			
			
		?>
				<tr id="poItem-<?=$po_item_id; ?>" class="po_item_list" idler="<?=$po_item_id; ?>">
					<input class="frmData"
							id="new-po_item_id<?=$po_item_id; ?>"
							name="po_item_ids[]"
							type="hidden"
							value="<?=$po_item_id; ?>"
							req="1"
							den="0"
							alerter="<?=lang("Please_Check_items", "AAR"); ?>">
					<!--td><i title="Delete this item" onclick="delPoItem('poItem-<?=$po_item_id; ?>');" class="fas fa-trash"></i></td-->
					<td><?=$CC; ?></td>
					<td><?=$item_name; ?></td>
					<td style="widtd:10%;">
					
						<input class="frmData item_qtys" 
								id="new-po_item_qty<?=$po_item_id; ?>" 
								name="item_qtys[]" 
								type="text" 
								value="<?=$item_qty; ?>" 
								onclick="this.select();" 
								req="1" 
								den="0" 
								alerter="<?=lang("Please_Check_items", "AAR"); ?>">
					
					</td>
					<td><?=$item_unit_name; ?></td>
					<td>
						<input class="frmData item_prices" 
								id="new-po_item_price<?=$po_item_id; ?>" 
								name="item_prices[]" 
								type="text" 
								value="<?=$item_price; ?>" 
								onclick="this.select();" 
								req="1" 
								den="0" 
								alerter="<?=lang("Please_Check_items", "AAR"); ?>">
					</td>
					<td>
						<input class="" 
								id="new-po_item_tot<?=$po_item_id; ?>" 
								name="item_tots[]" 
								type="text" 
								value="0" 
								onclick="this.select();" 
								req="1" 
								den="0" 
								alerter="<?=lang("Please_Check_items", "AAR"); ?>" disabled>
					</td>
				</tr>
<?php
	}
}
	
	
?>
			 
			
			
			
			
			</tbody>
			<tbody>
<?php
$totBeforeVAT = $totBeforeVAT - $discount_amount;
?>
<tr>
	<td colspan="4">&nbsp;</td>
	<td style="text-align:right;">Sub Total :</td>
	<td style="text-align:center;">
		<input id="new-total_before_vat" type="text" value="<?=$totBeforeVAT; ?>" disabled>
	</td>
</tr>
<?php
$VATamount = $totBeforeVAT * 0.05;
?>
<tr>
	<td colspan="4">&nbsp;</td>
	<td style="text-align:right;">Total Vat Amount :</td>
	<td style="text-align:center;">
		<input id="new-total_vat_amount" type="text" value="<?=$VATamount; ?>" disabled>
	</td>
</tr>
<?php
$totAfterVAT = $totBeforeVAT + $VATamount;
?>
<tr>
	<td colspan="4">&nbsp;</td>
	<td style="text-align:right;">Total :</td>
	<td style="text-align:center;">
		<input id="new-all_total" type="text" value="<?=$totAfterVAT; ?>" disabled>
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
					<th><span onclick="resetTerms();" style="color:red;cursor:pointer;font-size:12px;"><?=lang('RESET'); ?></span></th>
					<th><?=lang('No.'); ?></th>
					<th><?=lang('terms_and_conditions'); ?></th>
				</tr>
			</thead>
			<tbody id="added_PO_terms">
			
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
<i title="Delete this item" onclick="$('#term-<?=$term_id; ?>').remove();fixTermsTable();" class="fas fa-trash"></i>
					</td>
					<th class="po_terms_count"><?=$TC; ?></td>
					<td>
					<input class="frmData"
							id="new-po_term<?=$term_id; ?>"
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
		<button type="button" onclick="submit_form('add-new-form', 'forward_page');">
			<?=lang('Add', 'ARR', 1); ?>
		</button>
		<button type="button" onclick="hide_details('addNewPOfromPLdetails');">
			<?=lang('Cancel', 'ARR', 1); ?>
		</button>
</div>
			
	</form>
	

<script>
$('#new-currency_id').on( 'change', function(){
	var ths_vv = parseInt( $('#new-currency_id').val() );
	if( ths_vv != 0 ){
		var cur_n = $('#cur-' + ths_vv ).attr('cur');
		$('#cur_name').html( cur_n );
	}
} );
$('#new-currency_id').change();

<?php
if( $loadDt == true ){
?>
show_details( 'addNewPOfromPLdetails', 'Add New PO' );
<?php
}
?>



function fixTermsTable(){
	var TermsCount = 0;
	$('.po_terms_count').each( function(){
		TermsCount++;
		$(this).html( TermsCount );
	} );
}






function cal_table(){
	var totBeforeVat = 0;
	$('.po_item_list').each( function(){
		var itemId = $(this).attr('idler');
		// console.log(itemId );
		var ths_qty = parseFloat( $('#new-po_item_qty' + itemId).val() );
		if( isNaN( ths_qty ) ){
			ths_qty = 0;
		}
		
		var ths_price = parseFloat( $('#new-po_item_price' + itemId).val() );
		if( isNaN( ths_price ) ){
			ths_price = 0;
		}
		var thsTot = ths_qty * ths_price;
		totBeforeVat = totBeforeVat + thsTot;
		$('#new-po_item_tot' + itemId).val( insertDecimal(thsTot) );
		
		
	} );
	
	var disAmount = 0;
	/*
	var discount_percentage = parseFloat( $('#new-discount_per').val() );
	if( isNaN( discount_percentage ) ){
		discount_percentage = 0;
	}
	*/
	
	
	
	
	discount_percentage = 0;
	var is_vat = parseInt( $('#new-is_vat_included').val() );
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
	
	
	// $('#new-discount_amount').val( discount_amount.toFixed(3) );
	$('#new-total_before_vat').val( insertDecimal(totBeforeVat) );
	$('#new-total_vat_amount').val( insertDecimal(totVat) );
	$('#new-all_total').val( insertDecimal(totAfterVat) );
	
	
}



function delPoItem( IDD ){
	var aa = confirm('Are you sure, this will remove the item from PO, you can undo by refreshing the page ?');
	if( aa == true ){
		$('#' + IDD).remove();
		cal_table();
	}
}





function initTableEvents(){
	$('.item_qtys').on( 'input', function(){
		cal_table();
	} );
	$('.item_prices').on( 'input', function(){
		cal_table();
	} );
	$('#new-discount_amount').on( 'input', function(){
		// cal_table();
	} );
	$('#new-is_vat_included').on( 'input', function(){
		cal_table();
	} );
	$('#new-discount_per').on( 'input', function(){
		cal_table();
	} );
}

var added_PO_terms = $('#added_PO_terms').html();

function resetTerms(){
	$('#added_PO_terms').html('');
	$('#added_PO_terms').html(added_PO_terms);
}

var added_PO_items = $('#added_PO_items').html();

function resetItems(){
	$('#added_PO_items').html('');
	$('#added_PO_items').html(added_PO_items);
	cal_table();
}



init_nwFormGroup();

initTableEvents();
cal_table();
</script>

		
		
		
	</div>
	<div class="zero"></div>
</div>


<?php
	//PAGE DATA END   ----------------------------------------------///---------------------------------
	include('app/footer.php');
?>
</body>
</html>
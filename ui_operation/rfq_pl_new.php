<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	$page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	// $page_title=$page_description=$page_keywords=$page_author= "Site Title";
	
	
	
	//service operations
	$MainServiceID = 19;
	$subServiceID  = 0;
	//load service data
	//check if service is allowed for this user or no
	require_once('../bootstrap/load_service_user.php');
	
	
	

	
	$rfq_id = 0;
	if( !isset( $_GET['rfq_id'] ) ){
		header("location:../index.php");
	} else {
		$rfq_id = (int) test_inputs( $_GET['rfq_id'] );
	}
	
	
		$qu_pur_requisitions_rfq_sel = "SELECT * FROM  `pur_requisitions_rfq` WHERE `rfq_id` = $rfq_id";
	$qu_pur_requisitions_rfq_EXE = mysqli_query($KONN, $qu_pur_requisitions_rfq_sel);
	$pur_requisitions_rfq_DATA;
	if(mysqli_num_rows($qu_pur_requisitions_rfq_EXE)){
		$pur_requisitions_rfq_DATA = mysqli_fetch_assoc($qu_pur_requisitions_rfq_EXE);
	}

		$rfq_id = $pur_requisitions_rfq_DATA['rfq_id'];
		$supplier_id = $pur_requisitions_rfq_DATA['supplier_id'];
		$requisition_id = $pur_requisitions_rfq_DATA['requisition_id'];
		$created_date = $pur_requisitions_rfq_DATA['created_date'];
		
	$qu_pur_requisitions_sel = "SELECT * FROM  `pur_requisitions` WHERE `requisition_id` = $requisition_id";
	$qu_pur_requisitions_EXE = mysqli_query($KONN, $qu_pur_requisitions_sel);
	$pur_requisitions_DATA;
	if(mysqli_num_rows($qu_pur_requisitions_EXE)){
		$pur_requisitions_DATA = mysqli_fetch_assoc($qu_pur_requisitions_EXE);
	}
		$requisition_ref = $pur_requisitions_DATA['requisition_ref'];
		$requisition_type = $pur_requisitions_DATA['requisition_type'];
		$requisition_type_id = $pur_requisitions_DATA['requisition_type_id'];
		$requisition_status = $pur_requisitions_DATA['requisition_status'];
		$requisition_notes = $pur_requisitions_DATA['requisition_notes'];
		$employee_id = $pur_requisitions_DATA['employee_id'];
		
		
		
	$qu_suppliers_list_sel = "SELECT * FROM  `suppliers_list` WHERE `supplier_id` = $supplier_id";
	$qu_suppliers_list_EXE = mysqli_query($KONN, $qu_suppliers_list_sel);
	$suppliers_list_DATA;
	if(mysqli_num_rows($qu_suppliers_list_EXE)){
		$suppliers_list_DATA = mysqli_fetch_assoc($qu_suppliers_list_EXE);
	}
		$supplier_code = $suppliers_list_DATA['supplier_code'];
		$supplier_name = $suppliers_list_DATA['supplier_name'];
		$supplier_type = $suppliers_list_DATA['supplier_type'];
		$supplier_cat = $suppliers_list_DATA['supplier_cat'];
		$website = $suppliers_list_DATA['website'];
		$country = $suppliers_list_DATA['country'];
		$address = $suppliers_list_DATA['address'];
		$trn_no = $suppliers_list_DATA['trn_no'];

		
		
		
		
	$qu_hr_employees_sel = "SELECT * FROM  `hr_employees` WHERE `employee_id` = $employee_id";
	$qu_hr_employees_EXE = mysqli_query($KONN, $qu_hr_employees_sel);
	$hr_employees_DATA;
	if(mysqli_num_rows($qu_hr_employees_EXE)){
		$hr_employees_DATA = mysqli_fetch_assoc($qu_hr_employees_EXE);
	}
	
		$employee_code = $hr_employees_DATA['employee_code'];
		$first_name = $hr_employees_DATA['first_name'];
		$last_name = $hr_employees_DATA['last_name'];
		
		
		$employee_name = $first_name.' '.$last_name;
		
		
		
	
	
	
	
	
	
?>
<!DOCTYPE html>
<html dir="<?=$lang_dir; ?>" lang="<?=$lang; ?>">
<head>
	<?php include('app/meta.php'); ?>
    <?php include('app/assets.php'); ?>
</head>
<body>
<?php
	include('app/header.php');
	//PAGE DATA START -----------------------------------------------///---------------------------------
?>


<div class="panel panelPrimary">
	<div class="panelHeader">
		<?=lang("Add_New_Price_List_From_","AAR"); ?><b><?=$supplier_name; ?></b>
	</div><!-- panelHeader END -->
	<div class="panelBody">
	
	
	
<div class="row">
	<div class="col-100" id="add_new_requisition">
		<div class="form-alerts" style="width: 50%;margin: 0 auto;text-align: left;"></div>
	</div>
</div>
	
				<form 
				id="add-new-requisition-form" 
				id-modal="add_new_requisition" 
				class="boxes-holder" 
				api="<?=api_root; ?>requisitions/price_lists/add_price_list.php">
				

			<input class="frmData" 
					id="new-rfq_id" 
					name="rfq_id" 
					type="hidden" 
					value="<?=$rfq_id; ?>"
					req="1" 
					den="0" 
					alerter="<?=lang("Please_Check_requisition", "AAR"); ?>">
			<input class="frmData" 
					id="new-requisition_id" 
					name="requisition_id" 
					type="hidden" 
					value="<?=$requisition_id; ?>"
					req="1" 
					den="0" 
					alerter="<?=lang("Please_Check_requisition", "AAR"); ?>">
			<input class="frmData" 
					id="new-supplier_id" 
					name="supplier_id" 
					type="hidden" 
					value="<?=$supplier_id; ?>"
					req="1" 
					den="0" 
					alerter="<?=lang("Please_Check_requisition", "AAR"); ?>">
					
<div class="col-50">
	<div class="form-grp">
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
</div>
<script>
$('#new-currency_id').on( 'change', function(){
	var ths_vv = parseInt( $('#new-currency_id').val() );
	if( ths_vv != 0 ){
		var cur_n = $('#cur-' + ths_vv ).attr('cur');
		$('#cur_name').html( cur_n );
	}
} );
</script>

<div class="col-50">
	<div class="form-grp">
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
</div>

<div class="col-50">
	<div class="form-grp">
		<label class="lbl_class"><?=lang('Vendor quotation ref', 'AA', 1); ?></label>
		<input class="frmData" 
				id="new-vendor_quotation_ref" 
				name="vendor_quotation_ref" 
				type="text"
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_vendor_quotation_ref", "AAR"); ?>">
	</div>
</div>

<div class="col-50">
	<div class="form-grp">
		<label class="lbl_class"><?=lang('Vendor quotation file', 'AA', 1); ?></label>
		<input class="frmData" 
				id="new-attached_vendor_quotation" 
				name="attached_vendor_quotation" 
				type="file"
				req="0" 
				den="0" 
				alerter="<?=lang("Please_Check_vendor_quotation_file", "AAR"); ?>">
	</div>
</div>


<div class="col-50">
	<div class="form-grp">
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
</div>


<div class="col-50">
	<div class="form-grp">
		<label class="lbl_class"><?=lang('notes', 'ARR', 1); ?></label>
		<textarea class="frmData" type="text" 
				id="new-notes" 
				name="notes" 
				req="0" 
				den="" 
				rows="8"
				alerter="<?=lang("Please_Check_requisition_notes", "AAR"); ?>"></textarea>
	</div>
</div>


<div class="col-100">

			<table class="tabler">
				<thead>
					<tr>
						<th><?=lang('No.'); ?></th>
						<th><?=lang('name'); ?></th>
						<th><?=lang('qty'); ?></th>
						<th><?=lang('U.P'); ?></th>
						<th><?=lang('Total'); ?> ( <span id="cur_name">please select currency</span> )</th>
					</tr>
				</thead>
				<tbody>
<?php
	$itemC = 0;
	$qu_pur_requisitions_items_sel = "SELECT * FROM  `pur_requisitions_items` 
										WHERE ((`requisition_id` = $requisition_id) AND (`supplier_id` = $supplier_id))";
	$qu_pur_requisitions_items_EXE = mysqli_query($KONN, $qu_pur_requisitions_items_sel);
	if(mysqli_num_rows($qu_pur_requisitions_items_EXE)){
	
		while($pur_requisitions_items_REC = mysqli_fetch_assoc($qu_pur_requisitions_items_EXE)){
			$itemC++;
			$item_id = $pur_requisitions_items_REC['item_id'];
			$item_qty = $pur_requisitions_items_REC['item_qty'];
			$item_code_id = $pur_requisitions_items_REC['item_code_id'];
			
			$THS_supplier_id = ( int ) $pur_requisitions_items_REC['supplier_id'];
			
			$hirarcy = get_item_name( $item_code_id, $KONN );
			$unit_name = get_item_unit_name( $item_code_id, $KONN );
			
		?>
<tr id="itemo-<?=$item_id; ?>" class="item_list" idler="<?=$item_id; ?>">

<td class="item-c"><?=$itemC; ?></td>
<td><?=$hirarcy; ?></td>
<td><span id="qty-<?=$item_id; ?>"><?=$item_qty; ?></span>(<?=$unit_name; ?>)</td>
<td>
			<input class="frmData" 
					id="new-item_id<?=$item_id; ?>" 
					name="item_ids[]" 
					type="hidden" 
					value="<?=$item_id; ?>"
					req="1" 
					den="0" 
					alerter="<?=lang("Please_Check_items", "AAR"); ?>">

	<div class="col-100">
		<div class="form-grp">
			<input class="frmData item_prices" 
					id="new-item_prices<?=$item_id; ?>" 
					name="item_prices[]" 
					type="text" 
					value="0"
					req="1" 
					den="0" 
					alerter="<?=lang("Please_Check_item_no", "AAR"); ?>.<?=$itemC; ?> price">
		</div>
	</div>
		<div class="zero"></div>

</td>
<td>
	<div class="col-100">
		<div class="form-grp">
			<input id="new-total<?=$item_id; ?>" type="text" value="0" disabled>
		</div>
	</div>
		<div class="zero"></div>
</td>

</tr>
		<?php
		}
	}
?>

<tr>
	<td colspan="3">&nbsp;</td>
	<td style="text-align:right;">Discount Amount :</td>
	<td>
		<div class="col-100">
			<div class="form-grp">
				<input class="frmData" 
						id="new-discount_amount" 
						name="discount_amount" 
						type="text" 
						value="0"
						req="1" 
						den="" 
						alerter="<?=lang("Please_Check_discount_amount", "AAR"); ?>.<?=$itemC; ?> price">
			</div>
		</div>
	</td>
</tr>

<tr>
	<td colspan="3">&nbsp;</td>
	<td style="text-align:right;">Sub Total :</td>
	<td>
		<div class="col-100">
			<div class="form-grp">
				<input id="total_before_vat" type="text" value="0" disabled>
			</div>
		</div>
	</td>
</tr>
<tr>
	<td colspan="3">&nbsp;</td>
	<td style="text-align:right;">Total Vat Amount :</td>
	<td>
		<div class="col-100">
			<div class="form-grp">
				<input id="total_vat_amount" type="text" value="0" disabled>
			</div>
		</div>
	</td>
</tr>
<tr>
	<td colspan="3">&nbsp;</td>
	<td style="text-align:right;">Total :</td>
	<td>
		<div class="col-100">
			<div class="form-grp">
				<input id="all_total" type="text" value="0" disabled>
			</div>
		</div>
	</td>
</tr>
				
				</tbody>
			</table>

</div>

	<div class="zero"></div>
			
<div class="btns-holder text-center">
	<button class="btn btn-success" type="button" onclick="submit_form('add-new-requisition-form', 'forward_page');"><?=lang('ADD'); ?></button>
</div>


	<div class="zero"></div>

	

</form>
	
	
	
	</div><!-- panelBody END -->
	<div class="panelFooter">
		&nbsp;
	</div><!-- panelFooter END -->
</div><!-- panel END -->






<script>
function cal_table(){
	var totBeforeVat = 0;
	$('.item_list').each( function(){
		var itemId = $(this).attr('idler');
		var ths_qty = parseFloat( $('#qty-' + itemId).html() );
		console.log(ths_qty);
		
		var ths_price = parseFloat( $('#new-item_prices' + itemId).val() );
		var thsTot = ths_qty * ths_price;
		totBeforeVat = totBeforeVat + thsTot;
		$('#new-total' + itemId).val( thsTot.toFixed(3) );
		
		
	} );
	
	var disAmount = 0;
	
	
	var is_vat = parseInt( $('#new-is_vat_included').val() );
	var discount_amount = parseFloat( $('#new-discount_amount').val() );
	
	vatPer = 0.05;
	if( is_vat == 0 ){
		vatPer = 0;
	}
	
	var totAfterVat = 0;
	var totVat      = 0;
	
	
	totBeforeVat = totBeforeVat - discount_amount;
	totVat = totBeforeVat * vatPer;
	totAfterVat = totBeforeVat + totVat;
	
	
	$('#total_before_vat').val( totBeforeVat.toFixed(3) );
	$('#total_vat_amount').val( totVat.toFixed(3) );
	$('#all_total').val( totAfterVat.toFixed(3) );
	
	
}


$('.item_prices').on( 'input', function(){
	cal_table();
} );
$('#new-discount_amount').on( 'input', function(){
	cal_table();
} );
$('#new-is_vat_included').on( 'input', function(){
	cal_table();
} );

</script>



















<?php
	//PAGE DATA END   ----------------------------------------------///---------------------------------
	include('app/footer.php');
?>
<script>

</script>
</body>
</html>
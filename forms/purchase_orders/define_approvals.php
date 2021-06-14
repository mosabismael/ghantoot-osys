<form 
id="define-po-approval-form" 
class="boxes-holder" 
api="<?=api_root; ?>purchase_orders/define_approve_map.php">

	
	<input class="frmData" 
			id="appv-po_id" 
			name="po_id" 
			value="0"
			type="hidden" 
			value="0" 
			req="1" 
			den="" 
			alerter="<?=lang("Please_Check_PO", "AAR"); ?>">
	
	<div class="row col-100">
		<div class="nwFormGroup">
			<label><?=lang("PM_Approval", "AAR"); ?></label>
			<select class="frmData approved_by" 
					id="appv-approved_by" 
					name="approved_by" 
					req="1" 
					den="0" 
					alerter="<?=lang("Please_Check_PM", "AAR"); ?>">
				<option value="0" selected>--- Please Select ---</option>
<?php
	$qu_purchase_orders_apps_sel = "SELECT `employee_id` FROM  `purchase_orders_apps` WHERE `typo` = 'pm'";
	$qu_purchase_orders_apps_EXE = mysqli_query($KONN, $qu_purchase_orders_apps_sel);
	if(mysqli_num_rows($qu_purchase_orders_apps_EXE)){
		while($purchase_orders_apps_REC = mysqli_fetch_assoc($qu_purchase_orders_apps_EXE)){
		$ths_ID = $purchase_orders_apps_REC['employee_id'];
		$namer = get_emp_name($KONN, $ths_ID );
		?>
				<option value="<?=$ths_ID; ?>"><?=$namer; ?></option>
		<?php
		}
	}
?>
			</select>
		</div>
		
		<div class="nwFormGroup">
			<label class="lbl_class"><?=lang('Accounts', "AAR"); ?></label>
			<select class="frmData approved_acc_by" 
					id="appv-approved_acc_by" 
					name="approved_acc_by" 
					req="1" 
					den="0" 
					alerter="<?=lang("Please_Check_Accounts", "AAR"); ?>">
				<option value="0" selected>--- Please Select ---</option>
<?php
	$qu_purchase_orders_apps_sel = "SELECT `employee_id` FROM  `purchase_orders_apps` WHERE `typo` = 'acc'";
	$qu_purchase_orders_apps_EXE = mysqli_query($KONN, $qu_purchase_orders_apps_sel);
	if(mysqli_num_rows($qu_purchase_orders_apps_EXE)){
		while($purchase_orders_apps_REC = mysqli_fetch_assoc($qu_purchase_orders_apps_EXE)){
		$ths_ID = $purchase_orders_apps_REC['employee_id'];
		$namer = get_emp_name($KONN, $ths_ID );
		?>
				<option value="<?=$ths_ID; ?>"><?=$namer; ?></option>
		<?php
		}
	}
?>
			</select>
		</div>
		
		<div class="nwFormGroup">
			<label class="lbl_class"><?=lang('Management', "AAR"); ?></label>
			<select class="frmData man_by" 
					id="appv-man_by" 
					name="man_by" 
					req="1" 
					den="" 
					alerter="<?=lang("Please_Check_Management", "AAR"); ?>">
				<option value="0" selected>--- NA ---</option>
<?php
	$qu_purchase_orders_apps_sel = "SELECT `employee_id` FROM  `purchase_orders_apps` WHERE `typo` = 'man'";
	$qu_purchase_orders_apps_EXE = mysqli_query($KONN, $qu_purchase_orders_apps_sel);
	if(mysqli_num_rows($qu_purchase_orders_apps_EXE)){
		while($purchase_orders_apps_REC = mysqli_fetch_assoc($qu_purchase_orders_apps_EXE)){
		$ths_ID = $purchase_orders_apps_REC['employee_id'];
		$namer = get_emp_name($KONN, $ths_ID );
		?>
				<option value="<?=$ths_ID; ?>"><?=$namer; ?></option>
		<?php
		}
	}
?>
			</select>
		</div>
		
		
		
		
		
	</div>
	
	
	
	
	
	<div class="row col-100">
		<hr>
	</div>
		<div class="zero"></div>
		


	<div class="form-alerts"></div>
	<div class="zero"></div>

	<div class="viewerBodyButtons">
		<button type="button" onclick="submit_form('define-po-approval-form', 'forward_page');">
			<?=lang('Send', 'ARR', 1); ?>
		</button>
		<button type="button" onclick="hide_details('poDefineAppsDetails');">
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
<div class="form-grp">
	<div class="form-title">
		<label><?=lang('quotation_Informations'); ?></label><div class="borderer"></div>
	</div>
</div>

<div class="form-grp">
<?php
$min_v = 0;
$max_v = 30;
?>
	<div class="form-item col-33">
		<label><?=lang('Validity_Days'); ?> = (<span id="validity_span">1</span>)</label>
		<input class="frmData" type="range" 
				id="new-valid_until" 
				name="valid_until" 
				step="1"
				min="<?=$min_v; ?>" max="<?=$max_v; ?>" value="<?=$min_v; ?>" list="validity_list"
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_Validity_Days", "AAR"); ?>">
				
				
	</div>
<datalist id="validity_list">
<?php
for($I=$min_v;$I<=$max_v;$I++){
	echo "<option>$I</option>";
}
?>
</datalist>

	<div class="form-item col-33">
		<label><?=lang('RFQ_No'); ?></label>
		<input class="frmData" type="text" 
				id="new-rfq_no" 
				name="rfq_no" 
				 placeholder="<?=lang('rfq_no'); ?>"
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_RFQ_No", "AAR"); ?>">
	</div>
	<div class="form-item col-33">
		<label><?=lang('Date'); ?></label>
		<input class="frmData has_date" type="text" 
				id="new-quotation_date" 
				name="quotation_date" 
				value="<?=date('Y-m-d'); ?>"
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_Quotation_Date", "AAR"); ?>">
	</div>
	<br>
	<br>
	<div class="form-item col-100">
	<span class="noter">* <?=lang('Quotation is valid until : '); ?><span id="valid_to"><?php echo date('l Y-m-d', strtotime(date('Y-m-d') . "+1 day")); ?></span></span>
		
	</div>
<script>
	$('#new-valid_until').on('input', function(){
		var days = parseInt($(this).val());
		$('#validity_span').html(days);
		start_date = new Date($("#new-quotation_date").attr('value'));
		var end_date = new Date(start_date);
		end_date.setDate(start_date.getDate() + days);
		
        var weekdays = new Array(7);
        weekdays[0] = "Sunday";
        weekdays[1] = "Monday";
        weekdays[2] = "Tuesday";
        weekdays[3] = "Wednesday";
        weekdays[4] = "Thursday";
        weekdays[5] = "Friday";
        weekdays[6] = "Saturday";
        var r = weekdays[end_date.getDay()];
		$('#valid_to').html(r + ' ' + end_date.getFullYear() + '-' + ("0" + (end_date.getMonth() + 1)).slice(-2) + '-' + ("0" + end_date.getDate()).slice(-2));
		
	});
</script>
	<div class="zero"></div>
</div>


<div class="form-grp">
	<div class="form-title">
		<label><?=lang('payment_Informations'); ?></label><div class="borderer"></div>
	</div>
</div>

<div class="form-grp">


	<div class="form-item col-50">
		<label><?=lang('payment_term'); ?></label>
		<select class="frmData" 
				id="new-payment_term_id" 
				name="payment_term_id" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_payment_Term", "AAR"); ?>">
			<option value="0"><?=lang('---please select payment_Term---'); ?></option>
<?php
$qpt = "SELECT * FROM `gen_payment_terms` ";
$QER_E = mysqli_query($KONN, $qpt);
if(mysqli_num_rows($QER_E) > 0){
	while($pt_dt = mysqli_fetch_assoc($QER_E)){
?>
	<option value="<?=$pt_dt['payment_term_id']; ?>"><?=$pt_dt['payment_term_title']; ?></option>
<?php
	}
}
?>
		</select>
	</div>
	
	<div class="form-item col-50">
		<label><?=lang('Currency'); ?></label>
		<select class="frmData" 
				id="new-currency_id" 
				name="currency_id" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_currency", "AAR"); ?>">
<?php
$q = "SELECT * FROM `gen_currencies`";
$q_exe = mysqli_query($KONN, $q);
if(mysqli_num_rows($q_exe) > 0){
	while($record = mysqli_fetch_assoc($q_exe)){
?>
	<option value="<?=$record['currency_id']; ?>"><?=lang($record['currency_name']); ?></option>
<?php
		}
	}
?>
		</select>
	</div>

	
	<div class="zero"></div>
</div>


<div class="form-grp">
	<div class="form-title">
		<label><?=lang('Delivery_Conditions'); ?></label><div class="borderer"></div>
	</div>
</div>

<div class="form-grp">

	
	<div class="form-item col-50">
		<label><?=lang('delivery_period'); ?></label>
		<select class="frmData" 
				id="new-delivery_period_id" 
				name="delivery_period_id" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_delivery_period", "AAR"); ?>">
			<option value="0">--PLEASE SELECT--</option>
<?php
$q = "SELECT * FROM `gen_delivery_periods`";
$q_exe = mysqli_query($KONN, $q);
if(mysqli_num_rows($q_exe) > 0){
	while($record = mysqli_fetch_assoc($q_exe)){
?>
	<option value="<?=$record['delivery_period_id']; ?>"><?=$record['delivery_period_title']; ?> (<?=$record['delivery_period_days']; ?>) days </option>
<?php
		}
	}
?>
		</select>
	</div>
	
	<div class="form-item col-50">
		<label><?=lang('delivery_method'); ?></label>
		<select class="frmData" 
				id="new-delivery_method" 
				name="delivery_method" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_delivery_method", "AAR"); ?>">
			<option value="no_delivery"><?=lang('No delivery'); ?></option>
			<option value="at_client_place" selected><?=lang('At_Client_Place'); ?></option>
		</select>
	</div>
	
	<div class="zero"></div>
</div>
	
	
<div class="form-grp">
	<div class="form-item col-100">
		<label><?=lang('extra_Notes'); ?></label>
		<textarea class="frmData" 
				id="new-quotation_notes" 
				name="quotation_notes" 
				req="0" 
				den="" 
				alerter="<?=lang("Please_Check_quotation_notes", "AAR"); ?>"></textarea>
	</div>
	
	
	<div class="zero"></div>
</div>

<div class="btns-holder">
	<button class="btn btn-primary" type="button" onClick="set_tabber(2);"><?=lang('Next'); ?></button>
</div>
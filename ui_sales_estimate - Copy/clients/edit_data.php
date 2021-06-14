
<form 
id="edit-client-form" 
id-modal="edit_client_modal" 
class="boxes-holder" 
api="<?=api_root; ?>clients/edit_client_data.php">

		<input class="frmData" type="hidden" 
				id="edit-client_id" 
				name="client_id" 
				value="<?=$client_id; ?>" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_client_DATA", "AAR"); ?>">


<div class="col-33">
	<div class="form-grp">
		<label class="lbl_class"><?=lang('Client Code', 'ARR', 1); ?></label>
		<input class="frmData" type="text" 
				id="edit-client_code" 
				name="client_code" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_client_code", "AAR"); ?>">
	</div>
</div>

<div class="col-33">
	<div class="form-grp">
		<label class="lbl_class"><?=lang('Client Name', 'ARR', 1); ?></label>
		<input class="frmData" type="text" 
				id="edit-client_name" 
				name="client_name" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_client_name", "AAR"); ?>">
	</div>
</div>

<div class="col-33">
	<div class="form-grp">
		<label class="lbl_class"><?=lang('Client_Category', 'ARR', 1); ?></label>
		<select class="frmData" 
				id="edit-client_category" 
				name="client_category" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_Account_Type", "AAR"); ?>">
			<option value="0" selected><?=lang('Please Selcet', 'ARR', 1); ?></option>
			<option value="A"><?=lang('A', 'ARR', 1); ?></option>
			<option value="B"><?=lang('B', 'ARR', 1); ?></option>
			<option value="C"><?=lang('C', 'ARR', 1); ?></option>
			<option value="D"><?=lang('D', 'ARR', 1); ?></option>
		</select>
	</div>
</div>
<div class="zero"></div>

<div class="col-33">
	<div class="form-grp">
		<label class="lbl_class"><?=lang('Website', 'ARR', 1); ?></label>
		<input class="frmData" type="text" 
				id="edit-website" 
				name="website" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_website", "AAR"); ?>">
	</div>
</div>

<div class="col-33">
	<div class="form-grp">
		<label class="lbl_class"><?=lang('Phone', 'ARR', 1); ?></label>
		<input class="frmData" type="text" 
				id="edit-phone" 
				name="phone" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_phone", "AAR"); ?>">
	</div>
</div>

<div class="col-33">
	<div class="form-grp">
		<label class="lbl_class"><?=lang('Email', 'ARR', 1); ?></label>
		<input class="frmData" type="text" 
				id="edit-email" 
				name="email" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_email", "AAR"); ?>">
	</div>
</div>



<div class="zero"></div>




<div class="col-50">
	<div class="form-grp">
		<label class="lbl_class"><?=lang('city', 'ARR', 1); ?></label>
		<select class="frmData" 
				id="edit-city" 
				name="city" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_city", "AAR"); ?>">
				<option value="0" selected><?=lang("Please_Select", "غير محدد"); ?></option>
<?php
	$qu_loc_areas_sel = "SELECT * FROM  `gen_countries_cities` ";
	$qu_loc_areas_EXE = mysqli_query($KONN, $qu_loc_areas_sel);
	if(mysqli_num_rows($qu_loc_areas_EXE)){
		while($loc_areas_REC = mysqli_fetch_assoc($qu_loc_areas_EXE)){
		?>
		
				<option value="<?=$loc_areas_REC["city_id"]; ?>"><?=$loc_areas_REC["city_name"]; ?></option>
		<?php
		}
	}
?>
			</select>
	</div>
</div>

<div class="col-50">
	<div class="form-grp">
		<label class="lbl_class"><?=lang('Coountry', 'ARR', 1); ?></label>
		<select class="frmData" 
				id="edit-country" 
				name="country" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_country", "AAR"); ?>">
				<option value="0" selected><?=lang("Please_Select", "غير محدد"); ?></option>
<?php
	$qu_loc_areas_sel = "SELECT * FROM  `gen_countries` ";
	$qu_loc_areas_EXE = mysqli_query($KONN, $qu_loc_areas_sel);
	if(mysqli_num_rows($qu_loc_areas_EXE)){
		while($loc_areas_REC = mysqli_fetch_assoc($qu_loc_areas_EXE)){
		?>
		
				<option value="<?=$loc_areas_REC["country_id"]; ?>"><?=$loc_areas_REC["country_name"]; ?></option>
		<?php
		}
	}
?>
			</select>
	</div>
</div>
<div class="zero"></div>


<div class="col-50">
	<div class="form-grp">
		<label class="lbl_class"><?=lang('TRN No', 'ARR', 1); ?></label>
		<input class="frmData" type="text" 
				id="edit-trn_no" 
				name="trn_no" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_TRN", "AAR"); ?>">
	</div>
</div>

<?php
/*
<div class="col-50">
	<div class="form-grp">
		<label class="lbl_class"><?=lang('payment_term', 'ARR', 1); ?></label>
		<select class="frmData" 
				id="edit-payment_term_id" 
				name="payment_term_id" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_payment_term", "AAR"); ?>">
				<option value="0" selected><?=lang("Please_Select", "غير محدد"); ?></option>
<?php
	$qu_loc_areas_sel = "SELECT * FROM  `acc_payment_terms` ";
	$qu_loc_areas_EXE = mysqli_query($KONN, $qu_loc_areas_sel);
	if(mysqli_num_rows($qu_loc_areas_EXE)){
		while($loc_areas_REC = mysqli_fetch_assoc($qu_loc_areas_EXE)){
		?>
		
				<option value="<?=$loc_areas_REC["payment_term_id"]; ?>"><?=$loc_areas_REC["payment_term_title"]; ?></option>
		<?php
		}
	}
?>
			</select>
	</div>
</div>
*/
?>

<div class="col-50">
	<div class="form-grp">
		<label class="lbl_class"><?=lang('Client Address', 'ARR', 1); ?></label>
		<textarea class="frmData" type="text" 
				id="edit-client_address" 
				name="client_address" 
				req="0" 
				den="" 
				alerter="<?=lang("Please_Check_Account_NO", "AAR"); ?>"></textarea>
	</div>
</div>

	<div class="zero"></div>
	


<div class="form-item col-100">
	<div class="col-100" id="edit_client_modal">
		<div class="form-alerts" style="width: 50%;margin: 0 auto;text-align: left;"></div>
	</div>
</div>
<div class="btns-holder">
	<button class="btn btn-success" type="button" onclick="submit_form('edit-client-form', 'nothing');"><?=lang('Save Information'); ?></button>
</div>













</form>
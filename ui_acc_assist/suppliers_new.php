<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 4;
	$subPageID = 9;
?>
<!DOCTYPE html>
<html dir="<?=$lang_dir; ?>" lang="<?=$lang; ?>">
<head>
	<?php include('app/meta.php'); ?>
    <?php include('app/assets.php'); ?>
</head>
<body>
<?php

	$WHERE = "";
	include('app/header.php');
	//PAGE DATA START -----------------------------------------------///---------------------------------
?>



<div class="row">

				<form 
				id="add-new-form" 
				class="boxes-holder" 
				api="<?=api_root; ?>suppliers/add_new_supplier.php">
				
				
		<input  class="frmData" 
				type="hidden"
				id="new-country" 
				name="country" 
				value="100"
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_country", "AAR"); ?>">
				


<div class="col-50">
	<div class="form-grp">
		<label class="lbl_class"><?=lang('Supplier Account No', 'ARR', 1); ?></label>
		<input  class="frmData" 
				type="text"
				id="new-supplier_code" 
				name="supplier_code" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_-supplier_code", "AAR"); ?>">
	</div>
</div>
	<div class="zero"></div>

<div class="col-50">
	<div class="form-grp">
		<label class="lbl_class"><?=lang('Supplier Name', 'ARR', 1); ?></label>
		<input  class="frmData" 
				type="text"
				id="new-supplier_name" 
				name="supplier_name" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_-supplier_name", "AAR"); ?>">
	</div>
</div>

<div class="col-50">
	<div class="form-grp">
		<label class="lbl_class"><?=lang('Trn No', 'ARR', 1); ?></label>
		<input  class="frmData" 
				type="text"
				id="new-trn_no" 
				name="trn_no" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_trn_no", "AAR"); ?>">
	</div>
</div>
	<div class="zero"></div>
	
<div class="col-50">
	<div class="form-grp">
		<label class="lbl_class"><?=lang('Supplier Type', 'ARR', 1); ?></label>
		<select class="frmData" 
				id="new-supplier_type" 
				name="supplier_type" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_supplier_type", "AAR"); ?>">
				<option value="local"><?=lang("local", "AAR"); ?></option>
				<option value="overseas"><?=lang("overseas", "AAR"); ?></option>
			</select>
	</div>
</div>

<div class="col-50">
	<div class="form-grp">
		<label class="lbl_class"><?=lang('Supplier Cat', 'ARR', 1); ?></label>
		<select class="frmData" 
				id="new-supplier_cat" 
				name="supplier_cat" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_supplier_cat", "AAR"); ?>">
				<option value="A"><?=lang("A", "AAR"); ?></option>
				<option value="B"><?=lang("B", "AAR"); ?></option>
				<option value="C"><?=lang("C", "AAR"); ?></option>
				<option value="D"><?=lang("D", "AAR"); ?></option>
			</select>
	</div>
</div>


	<div class="zero"></div>
<div class="col-50">
	<div class="form-grp">
		<label class="lbl_class"><?=lang('Supplier Email', 'ARR', 1); ?></label>
		<input  class="frmData" 
				type="text"
				id="new-supplier_email" 
				name="supplier_email" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_-supplier_email", "AAR"); ?>">
	</div>
</div>

<div class="col-50">
	<div class="form-grp">
		<label class="lbl_class"><?=lang('Website', 'ARR', 1); ?></label>
		<input  class="frmData" 
				type="text"
				id="new-website" 
				name="website" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_-website", "AAR"); ?>">
	</div>
</div>


	<div class="zero"></div>


<div class="col-50">
	<div class="form-grp">
		<label class="lbl_class"><?=lang('contact_person', 'ARR', 1); ?></label>
		<input  class="frmData" 
				type="text"
				id="new-contact_person" 
				name="contact_person" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_contact_person", "AAR"); ?>">
	</div>
</div>


<div class="col-50">
	<div class="form-grp">
		<label class="lbl_class"><?=lang('Supplier Phone', 'ARR', 1); ?></label>
		<input  class="frmData" 
				type="text"
				id="new-supplier_phone" 
				name="supplier_phone" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_supplier_phone", "AAR"); ?>">
	</div>
</div>

	<div class="zero"></div>
	
<div class="col-100">
	<div class="form-grp">
		<label class="lbl_class"><?=lang('Address', 'ARR', 1); ?></label>
		<textarea  class="frmData" 
				id="new-address" 
				name="address" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_-address", "AAR"); ?>"></textarea>
	</div>
</div>

	<div class="zero"></div>




	<div class="form-alerts"></div>
	<div class="zero"></div>

<div class="viewerBodyButtons">
		<button type="button" onclick="submit_form('add-new-form', 'forward_page');">
			<?=lang('Save', 'ARR', 1); ?>
		</button>
		<button type="button" onclick="hide_modal();">
			<?=lang('Cancel', 'ARR', 1); ?>
		</button>
</div>

	<div class="zero"></div>
	

</form>
	<div class="zero"></div>
</div>


<?php
	//PAGE DATA END   ----------------------------------------------///---------------------------------
	include('app/footer.php');
?>















<script>

init_nwFormGroup();
</script>

</body>
</html>
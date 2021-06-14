<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 1;
	$subPageID = 10;
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
id="add-new-client-form" 
id-modal="add_new_client" 
class="boxes-holder" 
api="<?=api_root; ?>clients/add_new_client.php">


<div class="col-33">
	<div class="form-grp">
		<label class="lbl_class"><?=lang('Client Account No.', 'ARR', 1); ?></label>
		<input class="frmData" type="text" 
				id="new-client_code" 
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
				id="new-client_name" 
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
				id="new-client_category" 
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
				id="new-website" 
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
				id="new-phone" 
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
				id="new-email" 
				name="email" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_email", "AAR"); ?>">
	</div>
</div>



<div class="zero"></div>



<div class="col-50">
	<div class="form-grp">
		<label class="lbl_class"><?=lang('Country', 'ARR', 1); ?></label>
		<select class="frmData" 
				id="new-country" 
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


<div class="col-50">
	<div class="form-grp">
		<label class="lbl_class"><?=lang('city', 'ARR', 1); ?></label>
		<select class="frmData" 
				id="new-city" 
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
<div class="zero"></div>


<div class="col-50">
	<div class="form-grp">
		<label class="lbl_class"><?=lang('TRN No', 'ARR', 1); ?></label>
		<input class="frmData" type="text" 
				id="new-trn_no" 
				name="trn_no" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_TRN", "AAR"); ?>">
	</div>
</div>




<div class="col-50">
	<div class="form-grp">
		<label class="lbl_class"><?=lang('Client Address', 'ARR', 1); ?></label>
		<textarea class="frmData" type="text" 
				id="new-address" 
				name="address" 
				req="0" 
				den="" 
				alerter="<?=lang("Please_Check_Account_NO", "AAR"); ?>"></textarea>
	</div>
</div>

	<div class="zero"></div>
	
<div class="col-100 text-center" id="add_new_client">
		<!-- <div class="form-alerts"></div> -->
<button type="button"  onclick="submit_form('add-new-client-form', 'forward_page');" class="btn btn-primary"><?=lang("Add", "AAR"); ?></button>
			
	<div class="zero"></div>
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
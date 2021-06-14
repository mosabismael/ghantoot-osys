<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 1;
	$subPageID = 11;
	
	if( !isset( $_GET['client_id'] ) ){
		header("location:clients.php?ww=0");
	}
	
	$client_id = (int) test_inputs( $_GET['client_id'] );
	
	
	$qu_gen_clients_sel = "SELECT * FROM  `gen_clients` WHERE `client_id` = $client_id";
	$qu_gen_clients_EXE = mysqli_query($KONN, $qu_gen_clients_sel);
	$gen_clients_DATA;
	if(mysqli_num_rows($qu_gen_clients_EXE)){
		$gen_clients_DATA = mysqli_fetch_assoc($qu_gen_clients_EXE);
	} else {
		header("location:clients.php?ww=0");
	}


		$client_code = $gen_clients_DATA['client_code'];
		$client_name = $gen_clients_DATA['client_name'];
		$client_category = $gen_clients_DATA['client_category'];
		$website = $gen_clients_DATA['website'];
		$phone = $gen_clients_DATA['phone'];
		$email = $gen_clients_DATA['email'];
		$city = $gen_clients_DATA['city'];
		$country = $gen_clients_DATA['country'];
		$address = $gen_clients_DATA['address'];
		$trn_no = $gen_clients_DATA['trn_no'];
		$payment_term_id = $gen_clients_DATA['payment_term_id'];
		$is_deleted = $gen_clients_DATA['is_deleted'];
	
	
	
	
	
	
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
id="add-edit-client-form" 
id-modal="edit_client_data" 
class="boxes-holder" 
api="<?=api_root; ?>clients/edit_client_data.php">


		<input class="frmData" type="hidden" 
				id="edit-client_id" 
				name="client_id" 
				value="<?=$client_id; ?>" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_client", "AAR"); ?>">


<div class="col-50">
	<div class="form-grp">
		<label class="lbl_class"><?=lang('Client Account No.', 'ARR', 1); ?></label>
		<input class="frmData" type="text" 
				id="edit-client_code" 
				name="client_code" 
				value="<?=$client_code; ?>" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_client_code", "AAR"); ?>">
	</div>
</div>

<?php
	$qu_acc_accounts_sel = "SELECT `account_id` FROM  `acc_accounts` WHERE `account_no` = '$client_code'";
	$qu_acc_accounts_EXE = mysqli_query($KONN, $qu_acc_accounts_sel);
	$account_id = 0;
	if(mysqli_num_rows($qu_acc_accounts_EXE)){
		$acc_accounts_DATA = mysqli_fetch_assoc($qu_acc_accounts_EXE);
		$account_id = $acc_accounts_DATA['account_id'];
	} else {
?>
<div class="col-50">
	<div class="form-grp">
		<label class="lbl_class"><?=lang('Account_Details', 'ARR', 1); ?></label>
<div class="viewerBodyButtons">
		<a href="acc_coa.php?add_ar=<?=$client_id; ?>"><button type="button"><?=lang('Create_Account', 'ARR', 1); ?></button></a>
</div>
	</div>
</div>
<?php
	}
?>
	<div class="zero"></div>
<div class="col-50">
	<div class="form-grp">
		<label class="lbl_class"><?=lang('Client Name', 'ARR', 1); ?></label>
		<input class="frmData" type="text" 
				id="edit-client_name" 
				name="client_name" 
				value="<?=$client_name; ?>" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_client_name", "AAR"); ?>">
	</div>
</div>

<div class="col-50">
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
<script>
	$('#edit-client_category').val('<?=$client_category; ?>');
</script>
<div class="zero"></div>

<div class="col-33">
	<div class="form-grp">
		<label class="lbl_class"><?=lang('Website', 'ARR', 1); ?></label>
		<input class="frmData" type="text" 
				id="edit-website" 
				name="website" 
				value="<?=$website; ?>" 
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
				value="<?=$phone; ?>" 
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
				value="<?=$email; ?>" 
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
<script>
	$('#edit-country').val("<?=$country; ?>");
</script>


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
<script>
	$('#edit-city').val("<?=$city; ?>");
</script>
<div class="zero"></div>


<div class="col-50">
	<div class="form-grp">
		<label class="lbl_class"><?=lang('TRN No', 'ARR', 1); ?></label>
		<input class="frmData" type="text" 
				id="edit-trn_no" 
				name="trn_no" 
				value="<?=$trn_no; ?>" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_TRN", "AAR"); ?>">
	</div>
</div>




<div class="col-50">
	<div class="form-grp">
		<label class="lbl_class"><?=lang('Client Address', 'ARR', 1); ?></label>
		<textarea class="frmData" type="text" 
				id="edit-address" 
				name="address" 
				req="0" 
				den="" 
				alerter="<?=lang("Please_Check_Account_NO", "AAR"); ?>"><?=$address; ?></textarea>
	</div>
</div>

	<div class="zero"></div>
	
<div class="col-100 text-center" id="edit_client_data">
		<div class="form-alerts"></div>
<button type="button"  onclick="submit_form('add-edit-client-form', 'nothing');" class="btn btn-primary"><?=lang("Save", "AAR"); ?></button>
			
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

<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 3;
	$subPageID = 30;
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
<?php
if(isset($_GET['user'])){
	$user = '';
}
	$user =  $_GET['user'];
	$enquiry =  $_GET['enquiry_id'];

	
?>

<form 
id="add-new-client-form" 
id-modal="add_new_project" 
class="boxes-holder" 
api="<?=api_root; ?>sales_projects/add_new_project.php">




			<input class="frmData" type="hidden" 
					id="new-client_id" 
					name="client_id" 
					value="<?=$user?>"
					alerter="<?=lang("Please_Check_Client_Name", "AAR"); ?>">
	
                    <input class="frmData" type="hidden" 
					id="new-project_name" 
					name="project_name" 
					value=""
					>
                    <input class="frmData" type="hidden" 
					id="new-project_notes" 
					name="project_notes" 
					value=""
					>
                    <input class="frmData" type="hidden" 
					id="new-enquiry" 
					name="enquiry" 
					value="<?=$enquiry?>"
					>


<div class="zero"></div>

<div class="col-50">
	<div class="form-grp">
		<label class="lbl_class"><?=lang('estimation_type', 'ARR', 1); ?></label>
		<select class="frmData"
				id="new-project_type" 
				name="project_type" 
				req="0" 
				den="" 
				alerter="<?=lang("Please_Check_estimation_type", "AAR"); ?>" >
				<option selected disabled>---Select one---</option>
				<option value = "steel">Steel</option>
				<option value = "Marine">Marine</option>
				<option value = "others">Construction</option>
		</select>
	</div>
</div>


	<div class="zero"></div>
	
<div class="col-100 text-center" id="add_new_project">
		<div class="form-alerts"></div>
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

</body>
</html>
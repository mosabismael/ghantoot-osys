
<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 5;
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
if(isset($_GET['quotation_id'])){
	$quotation = '';
}
	$quotation =  $_GET['quotation_id'];

	
?>

<form 
id="add-new-client-form" 
id-modal="add_subnew_project" 
class="boxes-holder" 
api="<?=api_root; ?>sales_projects/add_subnew_project.php">


<div class="zero"></div>

<div class="col-50">
	<div class="form-grp">
		<label class="lbl_class"><?=lang('project_name', 'ARR', 1); ?></label>
		<input class="frmData" type="text" 
				id="new-project_name" 
				name="project_name" 
				req="0" 
				den="" 
				alerter="<?=lang("Please_Check_project_notes", "AAR"); ?>" >
				<input class="frmData" type="hidden" 
				id="new-quotation" 
				name="quotation" 
				value="<?= $quotation; ?>"
				req="0" 
				den=""
				 >

	</div>
</div>



<div class="col-50">
	<div class="form-grp">
		<label class="lbl_class"><?=lang('project_notes', 'ARR', 1); ?></label>
		<textarea class="frmData" type="text" 
				id="new-project_notes" 
				name="project_notes" 
				req="0" 
				den="" 
				alerter="<?=lang("Please_Check_project_notes", "AAR"); ?>"></textarea>
	</div>
</div>

	<div class="zero"></div>
	
<div class="col-100 text-center" id="add_subnew_project">
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

</body>
</html>
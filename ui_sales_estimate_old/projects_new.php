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


<form 
id="add-new-client-form" 
id-modal="add_new_project" 
class="boxes-holder" 
api="<?=api_root; ?>sales_projects/add_new_project.php">




<div class="row">
	<div class="col-100">
	
		<div class="form-grp">
			<label><?=lang('Client_Name'); ?></label>
			<input class="frmData" type="text" 
					id="new-client_name" 
					name="client_name" 
					list="clients-data"
					value=""
					req="1" 
					den="" 
					placeholder="<?=lang('Type Client Name to Select'); ?>" 
					alerter="<?=lang("Please_Check_client_name", "AAR"); ?>">

					<span class="noter" id="clien_load_res">* <?=lang('fill client name to load information'); ?></span>
		<datalist id="clients-data">
<?php
$q = "SELECT `client_name` FROM `gen_clients`";
$q_exe = mysqli_query($KONN, $q);
if(mysqli_num_rows($q_exe) > 0){
	while($record = mysqli_fetch_assoc($q_exe)){
?>
<option><?=$record['client_name']; ?></option>
<?php
		}
	}
?>
		</datalist>
		</div>
	</div>
	
	
			<input class="frmData" type="hidden" 
					id="new-client_id" 
					name="client_id" 
					req="1" 
					den="0" 
					value="0"
					alerter="<?=lang("Please_Check_Client_Name", "AAR"); ?>">
	
</div>



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
	</div>
</div>

<div class="col-50">
	<div class="form-grp">
		<label class="lbl_class"><?=lang('project_type', 'ARR', 1); ?></label>
		<select class="frmData"
				id="new-project_type" 
				name="project_type" 
				req="0" 
				den="" 
				alerter="<?=lang("Please_Check_project_type", "AAR"); ?>" >
				<option selected disabled>---Select one---</option>
				<option value = "steel">Steel</option>
				<option value = "Marine">Marine</option>
				<option value = "others">Others</option>
		</select>
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

function loadClient(){
	var client_name = $('#new-client_name').val().trim();
	if(client_name != ''){
		
		$.ajax({
		url      :"<?=api_root; ?>/clients/get_client_info.php",
		data     :{'client_name': client_name, 'operation': 1},
		dataType :"JSON",
		type     :'POST',
		success  :function(response){
				var client_id = response[0].client_id;
				var client_name = response[0].client_name;
				var payment_term_id = response[0].payment_term_id;
				payment_term_id = parseInt(payment_term_id);
				
				
				$('#new-client_id').val(client_id);
				// $('#new-client_name').val(client_name);
				if(client_id != '0'){
					$('#clien_load_res').html('<span style="color:green;">Client Information Loaded</span>');
					isClientSelected = true;
				} else {
					isClientSelected = false;
					$('#clien_load_res').html('<span style="color:red;">Client Information ERROR</span>');
				}
				
			},
		error    :function(){
			alert('Data Error No: 5467653');
			isClientSelected = false;
			},
		});
	}
}

$("#new-client_name").on('input',function(){
	loadClient();
});
</script>

</body>
</html>
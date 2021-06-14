<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "ACC";
	
	$menuId = 1;
	$subPageID = 2;
?>
<!DOCTYPE html>
<html dir="<?=$lang_dir; ?>" lang="<?=$lang; ?>">
<html>
<head>
	<?php include('app/meta.php'); ?>
    <?php include('app/assets.php'); ?>
</head>
<body>
<?php
	include('app/header.php');
	//PAGE DATA START -----------------------------------------------///---------------------------------
?>





<div class="row">
	<div class="col-100">
		
<a onclick="add_new_modal_unit();" class="actionBtn"><button type="button"><i class="fas fa-plus"></i><?=lang("Add_New", "AAR"); ?></button></a>
<br>
		
		<table id="dataTable" class="tabler" border="2">
			<thead>
				<tr>
					<th style="width: 30%;"><?=lang("Type_Name", "AAR"); ?></th>
					<th style="width: 70%;"><?=lang("Description", "AAR"); ?></th>
				</tr>
			</thead>
			<tbody>
<?php
	$sNo = 0;
	$qu_acc_accounts_types_sel = "SELECT * FROM  `acc_accounts_types` ORDER BY `account_type_name` ASC";
	$qu_acc_accounts_types_EXE = mysqli_query($KONN, $qu_acc_accounts_types_sel);
	if(mysqli_num_rows($qu_acc_accounts_types_EXE)){
		while($acc_accounts_types_REC = mysqli_fetch_assoc($qu_acc_accounts_types_EXE)){
			$account_type_id = $acc_accounts_types_REC['account_type_id'];
			$account_type_name = $acc_accounts_types_REC['account_type_name'];
			$account_type_name_ar = $acc_accounts_types_REC['account_type_name_ar'];
			$account_type_description = $acc_accounts_types_REC['account_type_description'];
			
		
		?>
			<tr id="boxdata-<?=$account_type_id; ?>">
				<td onclick="edit_data(<?=$account_type_id; ?>);" style="text-align:left;"><span id="Acc-<?=$account_type_id; ?>" class="text-primary cell-title"><?=$account_type_name; ?></span></td>
				<td style="text-align:left;"><?=$account_type_description; ?></td>
			</tr>
		<?php
		}
	} else {
?>
			<tr>
				<td colspan="2">NO DATA FOUND</td>
			</tr>

<?php
	}
	
?>
			</tbody>
		</table>
		
	</div>
	<div class="zero"></div>
</div>




<!--    ///////////////////      add_new_modal_unit Modal START    ///////////////////            -->
<div class="modal" id="add_new_modal_unit">
	<div class="modal-container">
		<div class="modal-header">
			<?php include("app/modal_header.php"); ?>
		</div>
		<div class="modal-body">
			
				<form 
				id="add-new-account-form" 
				id-modal="add_new_modal_unit" 
				class="boxes-holder" 
				api="<?=api_root; ?>acc_accounts_types/add_new.php">
				
				
<div class="col-50">
	<div class="nwFormGroup">
		<label><?=lang("account_type_name", "AR"); ?></label>
        <input class="frmData" type="text" 
        		id="new-account_type_name" 
        		name="account_type_name" 
        		req="1" 
        		den="" 
        		alerter="<?=lang("Please_Check_account_type_name", "AAR"); ?>">
	</div>
</div>


<div class="col-50">
	<div class="nwFormGroup">
		<label><?=lang("account_type_description", "AR"); ?></label>
        <textarea class="frmData" 
        		id="new-account_type_description" 
        		name="account_type_description" 
        		req="0" rows="8" 
        		den="" 
        		alerter="<?=lang("Please_Check_account_type_description", "AAR"); ?>"></textarea>
	</div>
</div>
	
	
<div class="col-100">
	<div class="nwFormGroup">
		<br>
		<br>
	</div>
</div>
	

<div class="zero"></div>

	<div class="form-alerts"></div>
	<div class="zero"></div>

<div class="viewerBodyButtons">
		<button type="button" onclick="submit_form('add-new-account-form', 'reload_page');">
			<?=lang('Add', 'ARR', 1); ?>
		</button>
		<button type="button" onclick="hide_modal();">
			<?=lang('Cancel', 'ARR', 1); ?>
		</button>
</div>


	

</form>
			
			
		</div>
	</div>
	<div class="zero"></div>
</div>


<!--    ///////////////////      add_new_modal_unit Modal END    ///////////////////            -->



<!--    ///////////////////      edit_modal_unit Modal START    ///////////////////            -->
<div class="modal" id="edit_modal_unit">
	<div class="modal-container">
		<div class="modal-header">
			<?php include("app/modal_header.php"); ?>
		</div>
		<div class="modal-body">
			
				<form 
				id="edit-account-form" 
				id-modal="edit_modal_unit" 
				class="boxes-holder" 
				api="<?=api_root; ?>acc_accounts_types/edit_data.php">


<input class="frmData" type="hidden" 
		id="edit-account_type_id" 
		name="account_type_id" 
		value="0" 
		req="1" 
		den="0" 
		alerter="<?=lang("Please_Check_unit", "AAR"); ?>">


<div class="col-50">
	<div class="nwFormGroup">
		<label><?=lang("account_type_name", "AR"); ?></label>
        <input class="frmData" type="text" 
        		id="edit-account_type_name" 
        		name="account_type_name" 
        		req="1" 
        		den="" 
        		alerter="<?=lang("Please_Check_account_type_name", "AAR"); ?>">
	</div>
</div>


<div class="col-50">
	<div class="nwFormGroup">
		<label><?=lang("account_type_description", "AR"); ?></label>
        <textarea class="frmData" 
        		id="edit-account_type_description" 
        		name="account_type_description" 
        		req="0" rows="8" 
        		den="" 
        		alerter="<?=lang("Please_Check_account_type_description", "AAR"); ?>"></textarea>
	</div>
</div>
	
<div class="col-100">
	<div class="nwFormGroup">
		<br>
		<br>
	</div>
</div>



	<div class="zero"></div>


	<div class="form-alerts"></div>
	<div class="zero"></div>

<div class="viewerBodyButtons">
		<button type="button" onclick="submit_form('edit-account-form', 'reload_page');">
			<?=lang('Save', 'ARR', 1); ?>
		</button>
		<button type="button" onclick="hide_modal();">
			<?=lang('Cancel', 'ARR', 1); ?>
		</button>
</div>

	

</form>
			
			
		</div>
	</div>
	<div class="zero"></div>
</div>
<!--    ///////////////////      edit_modal_unit Modal END    ///////////////////            -->

<script>
function del_data( ids_id ){
	var aa = confirm("Are you sure, action cannot be undone ?");
	if( aa == true ){
		alert("ACC Assigned with items, cannot be deleted !");
		/*
		$.ajax({
			url      :"<?=api_root; ?>acc_accounts_types/rem_data.php",
			data     :{'typo': 'pc_call', 'account_type_id': ids_id},
			dataType :"html",
			type     :'POST',
			success  :function(response){
				$('#boxdata-' + ids_id).remove();
			},
			error    :function(){
				alert('Code Not Applied');
			},
		});
		*/
	}
}





function edit_data( ids_id ){
	var titler = '<?=lang("Edit", "AAR"); ?>' + ' :: ';
	
	titler = titler + $('#boxdata-' + ids_id + ' .cell-title').text();
	
	$.ajax({
		url      :"<?=api_root; ?>acc_accounts_types/get_data.php",
		data     :{'typo': 'pc_call', 'ids_id': ids_id},
		dataType :"JSON",
		type     :'POST',
		success  :function(response){
			
$('#edit-account_type_id').val(response[0].account_type_id);
$('#edit-account_type_name').val(response[0].account_type_name);
$('#edit-account_type_description').val(response[0].account_type_description);




			show_modal( 'edit_modal_unit' , titler );

				// end_loader();
				
		},
		error    :function(){
			alert('Code Not Applied');
		},
	});
}

function add_new_modal_unit(){
	var titler = '<?=lang("Add_New_Entry", "AAR"); ?>';
	show_modal( 'add_new_modal_unit' , titler );
}
</script>





<?php
	//PAGE DATA END   ----------------------------------------------///---------------------------------
	include('app/footer.php');
?>
<script>

</script>
</body>
</html>
<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "ACC COA";
	
	$menuId = 1;
	$subPageID = 1;
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
					<th style="width: 15%;"><?=lang("Account_NO.", "AAR"); ?></th>
					<th style="width: 30%;"><?=lang("Account_Name", "AAR"); ?></th>
					<th><?=lang("Current_Balance", "AAR"); ?></th>
					<th><?=lang("Type", "AAR"); ?></th>
					<th><?=lang("Last_Updated", "AAR"); ?></th>
					<th>---</th>
				</tr>
			</thead>
			<tbody>
<?php
	$sNo = 0;
	$qu_acc_accounts_sel = "SELECT * FROM  `acc_accounts` ORDER BY `account_no` ASC";
	$qu_acc_accounts_EXE = mysqli_query($KONN, $qu_acc_accounts_sel);
	if(mysqli_num_rows($qu_acc_accounts_EXE)){
		while($acc_accounts_REC = mysqli_fetch_assoc($qu_acc_accounts_EXE)){
			$account_id = $acc_accounts_REC['account_id'];
			$account_no = $acc_accounts_REC['account_no'];
			$account_name = $acc_accounts_REC['account_name'];
			$account_type_id = $acc_accounts_REC['account_type_id'];
			$account_description = $acc_accounts_REC['account_description'];
			$opening_balance = $acc_accounts_REC['opening_balance'];
			$current_balance = $acc_accounts_REC['current_balance'];
			$last_updated = $acc_accounts_REC['last_updated'];
		
		
		
	$qu_acc_accounts_types_sel = "SELECT * FROM  `acc_accounts_types` WHERE `account_type_id` = $account_type_id";
	$qu_acc_accounts_types_EXE = mysqli_query($KONN, $qu_acc_accounts_types_sel);
	$account_type_name = "NA";
	if(mysqli_num_rows($qu_acc_accounts_types_EXE)){
		$acc_accounts_types_DATA = mysqli_fetch_assoc($qu_acc_accounts_types_EXE);
		$account_type_name = $acc_accounts_types_DATA['account_type_name'];
	}

		
		
		
		
		?>
			<tr id="boxdata-<?=$account_id; ?>">
				<td><?=$account_no; ?></td>
				<td onclick="edit_data(<?=$account_id; ?>);" style="text-align:left;"><span id="Acc-<?=$account_id; ?>" class="text-primary cell-title"><?=$account_name; ?></span></td>
				<td><?=$current_balance; ?></td>
				<td><?=$account_type_name; ?></td>
				<td><?=$last_updated; ?></td>
				<td><a href="acc_cycle.php?acc_id=<?=$account_id; ?>" style="color:blue;"><?=lang("View_Transactions", "AAR"); ?></a></td>
			</tr>
		<?php
		}
	} else {
?>
			<tr>
				<td colspan="7">NO DATA FOUND</td>
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
				api="<?=api_root; ?>acc_accounts/add_new.php">
				
<div class="col-50">
	<div class="nwFormGroup">
		<label><?=lang("account_NO", "AR"); ?></label>
        <input class="frmData" type="text" 
        		id="new-account_no" 
        		name="account_no" 
        		req="1" 
        		den="" 
        		alerter="<?=lang("Please_Check_account_no", "AAR"); ?>">
	</div>
</div>
				
<div class="col-50">
	<div class="nwFormGroup">
		<label><?=lang("account_name", "AR"); ?></label>
        <input class="frmData" type="text" 
        		id="new-account_name" 
        		name="account_name" 
        		req="1" 
        		den="" 
        		alerter="<?=lang("Please_Check_account_name", "AAR"); ?>">
	</div>
</div>

				
<div class="col-50">
	<div class="nwFormGroup">
		<label><?=lang("Opening_balance", "AR"); ?></label>
        <input class="frmData" type="text" 
        		id="new-opening_balance" 
        		name="opening_balance" 
				value="0" 
        		req="1" 
        		den="" 
        		alerter="<?=lang("Please_Check_opening_balance", "AAR"); ?>">
	</div>
</div>


<div class="col-50">
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('account_type', 'ARR', 1); ?></label>
        <select class="frmData" 
        		id="new-account_type_id" 
        		name="account_type_id" 
        		req="1" 
        		den="0" 
        		alerter="<?=lang("Please_Check_account_type", "AAR"); ?>">
					<option value="0" selected>--- Please Select---</option>
<?php
	$qu_acc_accounts_types_sel = "SELECT `account_type_id`, `account_type_name` FROM  `acc_accounts_types` ORDER BY `account_type_name` ASC";
	$qu_acc_accounts_types_EXE = mysqli_query($KONN, $qu_acc_accounts_types_sel);
	if(mysqli_num_rows($qu_acc_accounts_types_EXE)){
		while($acc_accounts_types_REC = mysqli_fetch_array($qu_acc_accounts_types_EXE)){
			
		?>
		<option value="<?=$acc_accounts_types_REC[0]; ?>"><?=$acc_accounts_types_REC[1]; ?></option>
		<?php
		}
	}
?>
		</select>
	</div>
</div>
	
	
<div class="col-100">
	<div class="nwFormGroup">
		<br>
		<br>
	</div>
</div>

<div class="col-50">
	<div class="nwFormGroup">
		<label><?=lang("account_description", "AR"); ?></label>
        <textarea class="frmData" 
        		id="new-account_description" 
        		name="account_description" 
        		req="0" rows="8" 
        		den="" 
        		alerter="<?=lang("Please_Check_account_description", "AAR"); ?>"></textarea>
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
		<button type="button" onclick="submit_form('add-new-account-form', 'forward_page');">
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
				api="<?=api_root; ?>acc_accounts/edit_data.php">


<input class="frmData" type="hidden" 
		id="edit-account_id" 
		name="account_id" 
		value="0" 
		req="1" 
		den="0" 
		alerter="<?=lang("Please_Check_unit", "AAR"); ?>">

				

<div class="col-50">
	<div class="nwFormGroup">
		<label><?=lang("account_NO", "AR"); ?></label>
        <input class="frmData" type="text" 
        		id="edit-account_no" 
        		name="account_no" 
        		req="1" 
        		den="" 
        		alerter="<?=lang("Please_Check_account_no", "AAR"); ?>">
	</div>
</div>
				
<div class="col-50">
	<div class="nwFormGroup">
		<label><?=lang("account_name", "AR"); ?></label>
        <input class="frmData" type="text" 
        		id="edit-account_name" 
        		name="account_name" 
        		req="1" 
        		den="" 
        		alerter="<?=lang("Please_Check_account_name", "AAR"); ?>">
	</div>
</div>

				
<div class="col-50">
	<div class="nwFormGroup">
		<label><?=lang("Opening_balance", "AR"); ?></label>
        <input class="frmData" type="text" 
        		id="edit-opening_balance" 
        		name="opening_balance" 
				value="0" 
        		req="1" 
        		den="" 
        		alerter="<?=lang("Please_Check_opening_balance", "AAR"); ?>">
	</div>
</div>


<div class="col-50">
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('account_type', 'ARR', 1); ?></label>
        <select class="frmData" 
        		id="edit-account_type_id" 
        		name="account_type_id" 
        		req="1" 
        		den="0" 
        		alerter="<?=lang("Please_Check_account_type", "AAR"); ?>">
					<option value="0" selected>--- Please Select---</option>
<?php
	$qu_acc_accounts_types_sel = "SELECT `account_type_id`, `account_type_name` FROM  `acc_accounts_types` ORDER BY `account_type_name` ASC";
	$qu_acc_accounts_types_EXE = mysqli_query($KONN, $qu_acc_accounts_types_sel);
	if(mysqli_num_rows($qu_acc_accounts_types_EXE)){
		while($acc_accounts_types_REC = mysqli_fetch_array($qu_acc_accounts_types_EXE)){
			
		?>
		<option value="<?=$acc_accounts_types_REC[0]; ?>"><?=$acc_accounts_types_REC[1]; ?></option>
		<?php
		}
	}
?>
		</select>
	</div>
</div>
	
	
<div class="col-100">
	<div class="nwFormGroup">
		<br>
		<br>
	</div>
</div>

<div class="col-50">
	<div class="nwFormGroup">
		<label><?=lang("account_description", "AR"); ?></label>
        <textarea class="frmData" 
        		id="edit-account_description" 
        		name="account_description" 
        		req="0" rows="8" 
        		den="" 
        		alerter="<?=lang("Please_Check_account_description", "AAR"); ?>"></textarea>
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
			url      :"<?=api_root; ?>acc_accounts/rem_data.php",
			data     :{'typo': 'pc_call', 'account_id': ids_id},
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
		url      :"<?=api_root; ?>acc_accounts/get_data.php",
		data     :{'typo': 'pc_call', 'ids_id': ids_id},
		dataType :"JSON",
		type     :'POST',
		success  :function(response){
			
$('#edit-account_id').val(response[0].account_id);
$('#edit-account_no').val(response[0].account_no);
$('#edit-account_name').val(response[0].account_name);
$('#edit-account_type_id').val(response[0].account_type_id);
$('#edit-account_description').val(response[0].account_description);
$('#edit-opening_balance').val(response[0].opening_balance);
$('#edit-current_balance').val(response[0].current_balance);
$('#edit-last_updated').val(response[0].last_updated);




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





<?php
if( isset( $_GET['add_ap'] ) ){
	$supp = ( int ) test_inputs( $_GET['add_ap'] );
	if( $supp != 0 ){
		$qu_suppliers_list_sel = "SELECT `supplier_code`, `supplier_name` FROM  `suppliers_list` WHERE `supplier_id` = $supp";
		$qu_suppliers_list_EXE = mysqli_query($KONN, $qu_suppliers_list_sel);
		$suppliers_list_DATA;
		if(mysqli_num_rows($qu_suppliers_list_EXE)){
			$suppliers_list_DATA = mysqli_fetch_assoc($qu_suppliers_list_EXE);
			$supplier_code = $suppliers_list_DATA['supplier_code'];
			$supplier_name = $suppliers_list_DATA['supplier_name'];
?>
<script>
	$('#new-account_no').val('<?=$supplier_code; ?>');
	$('#new-account_name').val('<?=$supplier_name; ?>');
	$('#new-account_type_id').val(1);
	add_new_modal_unit();
</script>
<?php
		}
	}
}
?>



<?php
if( isset( $_GET['add_ar'] ) ){
	$supp = ( int ) test_inputs( $_GET['add_ar'] );
	if( $supp != 0 ){
		$qu_gen_clients_sel = "SELECT `client_code`, `client_name` FROM  `gen_clients` WHERE `client_id` = $supp";
		$qu_gen_clients_EXE = mysqli_query($KONN, $qu_gen_clients_sel);
		$gen_clients_DATA;
		if(mysqli_num_rows($qu_gen_clients_EXE)){
			$gen_clients_DATA = mysqli_fetch_assoc($qu_gen_clients_EXE);
			$client_code = $gen_clients_DATA['client_code'];
			$client_name = $gen_clients_DATA['client_name'];
?>
<script>
	$('#new-account_no').val('<?=$client_code; ?>');
	$('#new-account_name').val('<?=$client_name; ?>');
	$('#new-account_type_id').val(2);
	add_new_modal_unit();
</script>
<?php
		}
	}
}
?>

















</body>
</html>
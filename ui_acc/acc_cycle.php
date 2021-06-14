<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "ACC Cycle";
	
	$menuId = 1;
	$subPageID = 5;
	
	
	
	
	
	
	
	
	
	
	$acc_id = 0;
	if( isset( $_GET['acc_id'] ) ){
		$acc_id = ( int ) test_inputs( $_GET['acc_id'] );
	}
	
	
	
	
	
	
	
	
	
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
		
		
		<table id="dataTable" class="tabler" border="2">
			<thead>
				<tr>
					<th><?=lang("Sys_ID", "AAR"); ?></th>
					<th><?=lang("created_date", "AAR"); ?></th>
					<th><?=lang("ref_no", "AAR"); ?></th>
					<th><?=lang("debit", "AAR"); ?></th>
					<th><?=lang("credit", "AAR"); ?></th>
					<th style="width: 20%;"><?=lang("account", "AAR"); ?></th>
					<th><?=lang("memo", "AAR"); ?></th>
					<th><?=lang("typo", "AAR"); ?></th>
					<th><?=lang("By", "AAR"); ?></th>
				</tr>
			</thead>
			<tbody>
<?php
	$sNo = 0;
	
	$qu_acc_cycle_sel = "SELECT * FROM  `acc_cycle` ORDER BY `cycle_id` DESC";
	
	
	
	if( $acc_id != 0 ){
		$qu_acc_cycle_sel = "SELECT * FROM  `acc_cycle` WHERE (( `account_id` = $acc_id )) ORDER BY `cycle_id` DESC";
	}
	
	
	
	$tot_c = 0;
	$tot_d = 0;
	
	
	
	
	$qu_acc_cycle_EXE = mysqli_query($KONN, $qu_acc_cycle_sel);
	if(mysqli_num_rows($qu_acc_cycle_EXE)){
		while($acc_cycle_REC = mysqli_fetch_assoc($qu_acc_cycle_EXE)){

			$cycle_id = $acc_cycle_REC['cycle_id'];
			$created_date = $acc_cycle_REC['created_date'];
			$ref_no = $acc_cycle_REC['ref_no'];
			$debit = ( double ) $acc_cycle_REC['debit'];
			$credit =  ( double ) $acc_cycle_REC['credit'];
			$account_id = $acc_cycle_REC['account_id'];
			$memo = $acc_cycle_REC['memo'];
			$typo = $acc_cycle_REC['typo'];
			$related_id = $acc_cycle_REC['related_id'];
			$employee_id = $acc_cycle_REC['employee_id'];
			$BY = get_emp_name($KONN, $employee_id );
			
			
			
	$qu_acc_accounts_sel = "SELECT `account_name` FROM  `acc_accounts` WHERE `account_id` = $account_id";
	$qu_acc_accounts_EXE = mysqli_query($KONN, $qu_acc_accounts_sel);
	$account_name = "NA";
	if(mysqli_num_rows($qu_acc_accounts_EXE)){
		$acc_accounts_DATA = mysqli_fetch_assoc($qu_acc_accounts_EXE);
		$account_name = $acc_accounts_DATA['account_name'];
	}

			$tot_c = $tot_c + $credit;
			$tot_d = $tot_d + $debit;
		
		?>
			<tr id="boxdata-<?=$cycle_id; ?>">
				<td><?=$cycle_id; ?></td>
				<td><?=$created_date; ?></td>
				<td><?=$ref_no; ?></td>
				<td><?=number_format($debit, 3); ?></td>
				<td><?=number_format($credit, 3); ?></td>
				<td><?=$account_name; ?></td>
				<td><?=$memo; ?></td>
				<td><?=$typo; ?></td>
				<td><?=$BY; ?></td>
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
			<!--tr id="boxdata-0">
				<th colspan="3">&nbsp;</th>
				<th><?=number_format($tot_d, 3); ?></th>
				<th><?=number_format($tot_c, 3); ?></th>
				<th colspan="4">&nbsp;</th>
			</tr-->
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
				api="<?=api_root; ?>acc_cycle/add_new.php">
				
				
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
				api="<?=api_root; ?>acc_cycle/edit_data.php">


<input class="frmData" type="hidden" 
		id="edit-cycle_id" 
		name="cycle_id" 
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
			url      :"<?=api_root; ?>acc_cycle/rem_data.php",
			data     :{'typo': 'pc_call', 'cycle_id': ids_id},
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
		url      :"<?=api_root; ?>acc_cycle/get_data.php",
		data     :{'typo': 'pc_call', 'ids_id': ids_id},
		dataType :"JSON",
		type     :'POST',
		success  :function(response){
			
$('#edit-cycle_id').val(response[0].cycle_id);
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
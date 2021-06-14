<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "ACC COA";
	
	$menuId = 1;
	$subPageID = 11;
	
	$page = 1;
	$showPerPage = 20;
	$totPages = 0;
	$qu_COUNT_sel = "SELECT COUNT(*) FROM  `acc_coa` ";
	$qu_COUNT_EXE = mysqli_query($KONN, $qu_COUNT_sel);
	if(mysqli_num_rows($qu_COUNT_EXE)){
		$job_COUNT_DATA = mysqli_fetch_array($qu_COUNT_EXE);
		$totPages = ( int ) $job_COUNT_DATA[0];
	}
	$totPages = ceil($totPages / $showPerPage);
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
		
		<div class="tableForm">
		<div class="tableFormGroup">
			<input type="text" name="searcher" />
			<button type="button"><i class="fas fa-search"></i></button>
		</div>
	</div>
	<div class="table">
		<div class="tableHeader">
			<div class="tr">
				<div class="th"><?=lang("Account_NO", "AAR"); ?></div>
				<div class="th"><?=lang("Account_Name", "AAR"); ?></div>
				<div class="th"><?=lang("Current_Balance", "AAR"); ?></div>
				<div class="th"><?=lang("Type", "AAR"); ?></div>
				
			
			</div>
		</div>
		<div class="tableBody" id="tableBody"></div>
	</div>
	<div class="tablePagination">
		<div class="pageNum arrowPager" id="prePatchBtn" onclick="showPrePageBatch('ui_acc/<?=basename($_SERVER['PHP_SELF']); ?>', <?=$showPerPage; ?>, <?=$totPages; ?>);"><i class="fas fa-angle-double-left"></i></div>
<?php
for( $i=$page ; $i<$page+5 ; $i++ ){
	$CLS = '';
	if( $page == $i ){
		$CLS = 'activePage';
	}
	$iView = ''.$i;
	if( $i < 10 ){
		$iView = '0'.$i;
	}
	if( $i <= $totPages ){
?>
		<div onclick="loadTableData( <?=$i; ?>, <?=$showPerPage; ?>, 'ui_acc/<?=basename($_SERVER['PHP_SELF']); ?>' );" class="pageNum imVarPager pn-<?=$i; ?> <?=$CLS; ?>"><?=$iView; ?></div>
<?php
	}
}
?>
<div id="addPagerPoint"></div>
		<div class="pageNum arrowPager" id="nextPatchBtn" onclick="showNextPageBatch('ui_acc/<?=basename($_SERVER['PHP_SELF']); ?>', <?=$showPerPage; ?>, <?=$totPages; ?>);"><i class="fas fa-angle-double-right"></i></div>
	</div>
<script>
var thsPage = 'ui_acc/<?=basename($_SERVER['PHP_SELF']); ?>';
function bindData( response ){
	$('#tableBody').html('');
	var cc = 0;
	for( i=0 ; i < response.length ; i ++ ){
		cc++;
		
		var tr = '' + 
			'<div class = "tr" id="boxdata-' + response[i].account_id + '">' + 
			'	<div class = "td">' + response[i].account_no + '</div>' + 
			'	<div class = "td" style="text-align:left;"><span id="Acc-'+response[i].account_id +'" class="text-primary cell-title cursored">' + response[i].account_name + '</span></div>' + 
			'	<div class = "td">' + response[i].current_balance + '</div>' + 
			'	<div class = "td">' + response[i].account_type_name + '</div>' + 
			'</div>';
			
			
		$('#tableBody').append( tr );
				
		
	}
}


</script>
</div>
		
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
				api="<?=api_root; ?>acc_coa/add_new.php">
				
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
	$qu_acc_coa_types_sel = "SELECT `account_type_id`, `account_type_name` FROM  `acc_coa_types` ORDER BY `account_type_name` ASC";
	$qu_acc_coa_types_EXE = mysqli_query($KONN, $qu_acc_coa_types_sel);
	if(mysqli_num_rows($qu_acc_coa_types_EXE)){
		while($acc_coa_types_REC = mysqli_fetch_array($qu_acc_coa_types_EXE)){
			
		?>
		<option value="<?=$acc_coa_types_REC[0]; ?>"><?=$acc_coa_types_REC[1]; ?></option>
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
				api="<?=api_root; ?>acc_coa/edit_data.php">


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
	$qu_acc_coa_types_sel = "SELECT `account_type_id`, `account_type_name` FROM  `acc_coa_types` ORDER BY `account_type_name` ASC";
	$qu_acc_coa_types_EXE = mysqli_query($KONN, $qu_acc_coa_types_sel);
	if(mysqli_num_rows($qu_acc_coa_types_EXE)){
		while($acc_coa_types_REC = mysqli_fetch_array($qu_acc_coa_types_EXE)){
			
		?>
		<option value="<?=$acc_coa_types_REC[0]; ?>"><?=$acc_coa_types_REC[1]; ?></option>
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
			url      :"<?=api_root; ?>acc_coa/rem_data.php",
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
		url      :"<?=api_root; ?>acc_coa/get_data.php",
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
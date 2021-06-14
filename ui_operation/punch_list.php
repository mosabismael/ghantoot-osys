<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "Inv Coding";
	
	
	$menuId = 10;
	$subPageID = 21;
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
                    <th style="width: 5%;">
                        <a onclick="add_new_modal_unit();"><button type="button" class="btn-success"><?=lang("Add_New", "AAR"); ?></button></a>
                    </th>
					<th style="width: 50%;"><?=lang("Item", "AAR"); ?></th>
					<th><?=lang("open_date", "AAR"); ?></th>
					<th><?=lang("Options", "AAR"); ?></th>
				</tr>
			</thead>
			<tbody>
<?php
	$sNo = 0;
	$qu_punch_list_sel = "SELECT * FROM  `punch_list` WHERE `punch_status` = 'open' ";
	$qu_punch_list_EXE = mysqli_query($KONN, $qu_punch_list_sel);
	if(mysqli_num_rows($qu_punch_list_EXE)){
		while($punch_list_REC = mysqli_fetch_assoc($qu_punch_list_EXE)){
			$sNo++;
		$punch_id = $punch_list_REC['punch_id'];
		$punch_txt = $punch_list_REC['punch_txt'];
		$punch_status = $punch_list_REC['punch_status'];
		$open_date = $punch_list_REC['open_date'];
		
		
		?>
			<tr id="boxdata-<?=$punch_id; ?>">
				<td><?=$sNo; ?></td>
				<td style="text-align:left;"><?=$punch_txt; ?></td>
				<td><?=$open_date; ?></td>
				<td>
					<button type="button" style="padding: 5px;" onclick="do_data(<?=$punch_id; ?>);">Close</button>
					<!--button type="button" style="padding: 5px;" onclick="del_data(<?=$punch_id; ?>);">Delete</button-->
				</td>
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
				id="add-new-unit-form" 
				id-modal="add_new_modal_unit" 
				class="boxes-holder" 
				api="<?=api_root; ?>punch_list/add_new.php">
				
<div class="col-100">
	<div class="form-grp">
		<label>open_date</label>
        <input class="frmData has_date" type="text" 
        		id="new-open_date" 
        		name="open_date" 
        		req="1" 
        		den="" 
        		alerter="<?=lang("Please_Check_open_date", "AAR"); ?>">
	</div>
</div>

<div class="col-100">
	<div class="form-grp">
		<label>Text</label>
        <textarea class="frmData" 
        		id="new-punch_txt" 
        		name="punch_txt" 
        		req="1" 
        		den="" 
        		alerter="<?=lang("Please_Check_punch_txt", "AAR"); ?>">( dept ) : textHere</textarea>
	</div>
</div>


<div class="zero"></div>

	<div class="form-alerts"></div>
	<div class="zero"></div>

<div class="viewerBodyButtons">
		<button type="button" onclick="submit_form('add-new-unit-form', 'reload_page');">
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

<script>
function do_data( ids_id ){
	var aa = confirm("Are you sure, action cannot be undone ?");
	if( aa == true ){
		
		$.ajax({
			url      :"<?=api_root; ?>punch_list/chk_data.php",
			data     :{'typo': 'pc_call', 'punch_id': ids_id},
			dataType :"html",
			type     :'POST',
			success  :function(response){
				$('#boxdata-' + ids_id).remove();
			},
			error    :function(){
				alert('Code Not Applied');
			},
		});
	}
}





function edit_data( ids_id ){
	var titler = '<?=lang("Edit", "AAR"); ?>' + ' :: ';
	
	titler = titler + $('#boxdata-' + ids_id + ' .cell-title').text();
	
	$.ajax({
		url      :"<?=api_root; ?>punch_list/get_data.php",
		data     :{'typo': 'pc_call', 'ids_id': ids_id},
		dataType :"JSON",
		type     :'POST',
		success  :function(response){
			
$('#edit-punch_id').val(response[0].punch_id);
$('#edit-punch_txt').val(response[0].punch_txt);




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
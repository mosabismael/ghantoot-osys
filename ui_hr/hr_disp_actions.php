<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "Time Tables";
	
	$menuId = 8;
	$subPageID = 12;
		
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
<script>
			function reload() {
                window.location = window.location.href;
			}
			function mySearchFunction() {
				// Declare variables
				var input, filter, table, tr, td, i, txtValue;
				input = document.getElementById("searcherBox");
				filter = input.value.toUpperCase();
				table = document.getElementById("dataTable");
				tr = table.getElementsByTagName("tr");
				indexNumber = $('#search_option').val();
				// Loop through all table rows, and hide those who don't match the search query
				for (i = 0; i < tr.length; i++) {
					td = tr[i].getElementsByTagName("td")[indexNumber];
					if (td) {
						txtValue = td.textContent || td.innerText;
						if (txtValue.toUpperCase().indexOf(filter) > -1) {
							tr[i].style.display = "";
							} else {
							tr[i].style.display = "none";
						}
					}
				}
			}
		</script>
<div class="row">
	<div class="col-100">
		<div class="tableForm">
					<div class="tableFormGroup">
						<select id = "search_option">
							<option value = "" selected disabled> Select Column</option>
							<option value = "1">Code</option>
							<option value = "2">Action</option>
						</select>
						<input type="text" name="searcher" id="searcherBox" onkeyup="mySearchFunction()" autocomplete="off" placeholder="Search..." />
						<div class="resultClass" id = "resulter"></div>
						<button id = "reload" onclick = "reload()">X</button>
						
					</div>
				</div>
		<table id="dataTable" class="tabler" border="2">
			<thead>
				<tr>
                    <th style="width: 30%;" colspan="2">
                        <a onclick="add_new_modal_action();"><button type="button" class="btn-success"><?=lang("Add_New", "AAR"); ?></button></a>
                    </th>
					<th style="width: 40%;" colspan="2"><?=lang("Displanary_Action", "AAR"); ?></th>
				</tr>
				<tr>
                    <th>NO.</th>
					<th><?=lang("Code", "AAR"); ?></th>
					<th><?=lang("Action", "AAR"); ?></th>
				</tr>
			</thead>
			<tbody>
<?php
	$sNo = 0;
	$qu_hr_disp_actions_sel = "SELECT * FROM  `hr_disp_actions`";
	$qu_hr_disp_actions_EXE = mysqli_query($KONN, $qu_hr_disp_actions_sel);
	if(mysqli_num_rows($qu_hr_disp_actions_EXE)){
		while($hr_disp_actions_REC = mysqli_fetch_assoc($qu_hr_disp_actions_EXE)){
			$sNo++;
		$disp_action_id = $hr_disp_actions_REC['disp_action_id'];
		$disp_action_code = $hr_disp_actions_REC['disp_action_code'];
		$disp_action_text = $hr_disp_actions_REC['disp_action_text'];
		
		
		?>
			<tr id="boxdata-<?=$disp_action_id; ?>">
				<td><?=$sNo; ?></td>
				<td onclick="edit_data(<?=$disp_action_id; ?>);"><span id="poREF-<?=$disp_action_id; ?>" class="text-primary"><?=$disp_action_code; ?></span></td>
				<td><?=$disp_action_text; ?></td>
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




<!--    ///////////////////      add_new_modal_action Modal START    ///////////////////            -->
<div class="modal" id="add_new_modal_action">
	<div class="modal-container">
		<div class="modal-header">
			<?php include("app/modal_header.php"); ?>
		</div>
		<div class="modal-body">
			
				<form 
				id="add-new-action-form" 
				id-modal="add_new_modal_action" 
				class="boxes-holder" 
				api="<?=api_root; ?>hr_disp_actions/add_new.php">

				
<div class="col-100">
	<div class="form-grp">
		<label>Action Code</label>
        <input class="frmData" type="text" 
        		id="new-disp_action_code" 
        		name="disp_action_code" 
        		req="1" 
        		den="" 
        		alerter="<?=lang("Please_Check_disp_action_code", "AAR"); ?>">
	</div>
</div>
	<div class="zero"></div>
	
	
<div class="col-100">
	<div class="form-grp">
		<label>Action Description</label>
        <input class="frmData" type="text" 
        		id="new-disp_action_text" 
        		name="disp_action_text" 
        		req="1" 
        		den="" 
        		alerter="<?=lang("Please_Check_Description", "AAR"); ?>">
	</div>
</div>

	<div class="zero"></div>
	

	<div class="form-alerts"></div>
	<div class="zero"></div>

<div class="viewerBodyButtons">
		<button type="button" onclick="submit_form('add-new-action-form', 'reload_page');">
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


<!--    ///////////////////      add_new_modal_action Modal END    ///////////////////            -->



<!--    ///////////////////      edit_modal_action Modal START    ///////////////////            -->
<div class="modal" id="edit_modal_action">
	<div class="modal-container">
		<div class="modal-header">
			<?php include("app/modal_header.php"); ?>
		</div>
		<div class="modal-body">
			
				<form 
				id="edit-action-form" 
				id-modal="edit_modal_action" 
				class="boxes-holder" 
				api="<?=api_root; ?>hr_disp_actions/edit_data.php">


<input class="frmData" type="hidden" 
		id="edit-disp_action_id" 
		name="disp_action_id" 
		value="0" 
		req="1" 
		den="0" 
		alerter="<?=lang("Please_Check_action", "AAR"); ?>">

				

				
<div class="col-100">
	<div class="form-grp">
		<label>Action Code</label>
        <input class="frmData" type="text" 
        		id="edit-disp_action_code" 
        		name="disp_action_code" 
        		req="1" 
        		den="" 
        		alerter="<?=lang("Please_Check_disp_action_code", "AAR"); ?>">
	</div>
</div>
	<div class="zero"></div>
	
	
<div class="col-100">
	<div class="form-grp">
		<label>Action Description</label>
        <input class="frmData" type="text" 
        		id="edit-disp_action_text" 
        		name="disp_action_text" 
        		req="1" 
        		den="" 
        		alerter="<?=lang("Please_Check_Description", "AAR"); ?>">
	</div>
</div>

	<div class="zero"></div>

	<div class="form-alerts"></div>
	<div class="zero"></div>

<div class="viewerBodyButtons">
		<button type="button" onclick="submit_form('edit-action-form', 'reload_page');">
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
<!--    ///////////////////      edit_modal_action Modal END    ///////////////////            -->

<script>
function del_data( ids_id ){
	var aa = confirm("Are you sure, action cannot be undone ?");
	if( aa == true ){
		alert("Unit Assigned with items, cannot be deleted !");
		/*
		$.ajax({
			url      :"<?=api_root; ?>hr_disp_actions/rem_data.php",
			data     :{'disp_action_code': 'pc_call', 'disp_action_id': ids_id},
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
		url      :"<?=api_root; ?>hr_disp_actions/get_data.php",
		data     :{'disp_action_code': 'pc_call', 'ids_id': ids_id},
		dataType :"JSON",
		type     :'POST',
		success  :function(response){
			
$('#edit-disp_action_id').val(response[0].disp_action_id);
$('#edit-disp_action_text').val(response[0].disp_action_text);
$('#edit-disp_action_code').val(response[0].disp_action_code);


			show_modal( 'edit_modal_action' , titler );

				// end_loader();
				
		},
		error    :function(){
			alert('Code Not Applied');
		},
	});
}

function add_new_modal_action(){
	var titler = '<?=lang("Add_New_Entry", "AAR"); ?>';
	show_modal( 'add_new_modal_action' , titler );
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
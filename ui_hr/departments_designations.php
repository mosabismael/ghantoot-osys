<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "Designations";
	
	$menuId = 8;
	$subPageID = 14;
	
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
					<a onclick="add_new_modal_department();"><button type="button" class="btn-success"><?=lang("Add_New", "AAR"); ?></button></a>
					
					<div class="tableForm">
						<div class="tableFormGroup">
							<select id = "search_option">
								<option value = "" selected disabled> Select Column</option>
								<option value = "1">Designation</option>
								<option value = "2">Department</option>
							</select>
							<input type="text" name="searcher" id="searcherBox" onkeyup="mySearchFunction()" autocomplete="off" placeholder="Search..." />
							<div class="resultClass" id = "resulter"></div>
							<button id = "reload" onclick = "reload()">X</button>
							
						</div>
					</div>
					<table id="dataTable" class="tabler" border="2">
						
						
						<thead>
							<tr>
								<th>NO.</th>
								<th><?=lang("Designation", "AAR"); ?></th>
								<th><?=lang("Department", "AAR"); ?></th>
							</tr>
						</thead>
						
						<tbody>
							<?php
								$sNo = 0;
								$qu_hr_departments_designations_sel = "SELECT * FROM  `hr_departments_designations` ORDER BY `department_id` ASC";
								$qu_hr_departments_designations_EXE = mysqli_query($KONN, $qu_hr_departments_designations_sel);
								if(mysqli_num_rows($qu_hr_departments_designations_EXE)){
									while($hr_departments_designations_REC = mysqli_fetch_assoc($qu_hr_departments_designations_EXE)){
										$sNo++;
										$designation_id = $hr_departments_designations_REC['designation_id'];
										$designation_name = $hr_departments_designations_REC['designation_name'];
										$job_description = $hr_departments_designations_REC['job_description'];
									$department_id = $hr_departments_designations_REC['department_id'];
									
									$qu_hr_departments_sel = "SELECT * FROM  `hr_departments` WHERE `department_id` = $department_id";
									$qu_hr_departments_EXE = mysqli_query($KONN, $qu_hr_departments_sel);
									$department_name = "";
									if(mysqli_num_rows($qu_hr_departments_EXE)){
									$hr_departments_DATA = mysqli_fetch_assoc($qu_hr_departments_EXE);
									$department_name = $hr_departments_DATA['department_name'];
									}
									
									
									
									?>
									<tr id="boxdata-<?=$designation_id; ?>">
									<td><?=$sNo; ?></td>
									<td onclick="edit_data(<?=$designation_id; ?>);"><span id="poREF-<?=$designation_id; ?>" class="cell-title text-primary"><?=$designation_name; ?></span></td>
									<td><?=$department_name; ?></td>
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
									
									
									
									
									<!--    ///////////////////      add_new_modal_department Modal START    ///////////////////            -->
									<div class="modal" id="add_new_modal_department">
									<div class="modal-container">
									<div class="modal-header">
									<?php include("app/modal_header.php"); ?>
									</div>
									<div class="modal-body">
									
									<form 
									id="add-new-desig-form" 
									id-modal="add_new_modal_department" 
									class="boxes-holder" 
									api="<?=api_root; ?>hr_departments_designations/add_new.php">
									
									
									<div class="col-100">
									<div class="form-grp">
									<label>Department</label>
									<select class="frmData" 
									id="new-department_id" 
									name="department_id" 
									req="1" 
									den="0" 
									alerter="<?=lang("Please_Check_Action", "AAR"); ?>">
									<option value="0" selected>--- Please Select---</option>
									<?php
									$qu_disp_actions_sel = "SELECT * FROM  `hr_departments` ORDER BY `department_id` ASC";
									$qu_disp_actions_EXE = mysqli_query($KONN, $qu_disp_actions_sel);
									if(mysqli_num_rows($qu_disp_actions_EXE)){
									while($disp_actions_REC = mysqli_fetch_assoc($qu_disp_actions_EXE)){
									$NAMER = $disp_actions_REC['department_name'];
									?>
									<option value="<?=$disp_actions_REC['department_id']; ?>"><?=$NAMER; ?></option>
									<?php
									}
									}
									?>
									</select>
									</div>
									</div>
									<div class="zero"></div>
									
									
									<div class="col-100">
									<div class="form-grp">
									<label>designation_name</label>
									<input class="frmData" 
									id="new-designation_name" 
									name="designation_name" 
									req="1" 
									den="" 
									alerter="<?=lang("Please_Check_from", "AAR"); ?>">
									</div>
									</div>
									
									<div class="col-100">
									<div class="form-grp">
									<label>job_description</label>
									<textarea class="frmData" 
									id="new-job_description" 
									name="job_description" 
									req="1" 
									den="" 
									alerter="<?=lang("Please_Check_Description", "AAR"); ?>"></textarea>
									</div>
									</div>
									
									
									<div class="zero"></div>
									
									<div class="form-alerts"></div>
									<div class="zero"></div>
									
									<div class="viewerBodyButtons">
									<button type="button" onclick="submit_form('add-new-desig-form', 'reload_page');">
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
									
									
									<!--    ///////////////////      add_new_modal_department Modal END    ///////////////////            -->
									
									
									
									<!--    ///////////////////      edit_modal_department Modal START    ///////////////////            -->
									<div class="modal" id="edit_modal_department">
									<div class="modal-container">
									<div class="modal-header">
									<?php include("app/modal_header.php"); ?>
									</div>
									<div class="modal-body">
									
									<form 
									id="edit-desig-form" 
									id-modal="edit_modal_department" 
									class="boxes-holder" 
									api="<?=api_root; ?>hr_departments_designations/edit_data.php">
									
									
									<input class="frmData" type="hidden" 
									id="edit-designation_id" 
									name="designation_id" 
									value="0" 
									req="1" 
									den="0" 
									alerter="<?=lang("Please_Check_department", "AAR"); ?>">
									
									
									
									<div class="col-100">
									<div class="form-grp">
									<label>Department</label>
									<select class="frmData" 
									id="edit-department_id" 
									name="department_id" 
									req="1" 
									den="0" 
									alerter="<?=lang("Please_Check_Action", "AAR"); ?>">
									<option value="0" selected>--- Please Select---</option>
									<?php
									$qu_disp_actions_sel = "SELECT * FROM  `hr_departments` ORDER BY `department_id` ASC";
									$qu_disp_actions_EXE = mysqli_query($KONN, $qu_disp_actions_sel);
									if(mysqli_num_rows($qu_disp_actions_EXE)){
									while($disp_actions_REC = mysqli_fetch_assoc($qu_disp_actions_EXE)){
									$NAMER = $disp_actions_REC['department_name'];
									?>
									<option value="<?=$disp_actions_REC['department_id']; ?>"><?=$NAMER; ?></option>
									<?php
									}
									}
									?>
									</select>
									</div>
									</div>
									<div class="zero"></div>
									
									<div class="col-100">
									<div class="form-grp">
									<label>designation_name</label>
									<input class="frmData" 
									id="edit-designation_name" 
									name="designation_name" 
									req="1" 
									den="" 
									alerter="<?=lang("Please_Check_from", "AAR"); ?>">
									</div>
									</div>
									
									<div class="col-100">
									<div class="form-grp">
									<label>job_description</label>
									<textarea class="frmData" 
									id="edit-job_description" 
									name="job_description" 
									req="1" 
									den="" 
									alerter="<?=lang("Please_Check_Description", "AAR"); ?>"></textarea>
									</div>
									</div>
									
									
									<div class="zero"></div>
									
									
									<div class="form-alerts"></div>
									<div class="zero"></div>
									
									<div class="viewerBodyButtons">
									<button type="button" onclick="submit_form('edit-desig-form', 'reload_page');">
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
									<!--    ///////////////////      edit_modal_department Modal END    ///////////////////            -->
									
									<script>
									function del_data( ids_id ){
									var aa = confirm("Are you sure, action cannot be undone ?");
									if( aa == true ){
									alert("Unit Assigned with items, cannot be deleted !");
									/*
									$.ajax({
									url      :"<?=api_root; ?>hr_departments_designations/rem_data.php",
									data     :{'typo': 'pc_call', 'designation_id': ids_id},
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
									url      :"<?=api_root; ?>hr_departments_designations/get_data.php",
									data     :{'typo': 'pc_call', 'ids_id': ids_id},
									dataType :"JSON",
									type     :'POST',
									success  :function(response){
									
									$('#edit-designation_id').val(response[0].designation_id);
									
									$('#edit-designation_name').val(response[0].designation_name);
									$('#edit-job_description').val(response[0].job_description);
									$('#edit-department_id').val(response[0].department_id);
									
									
									show_modal( 'edit_modal_department' , titler );
									
									// end_loader();
									
									},
									error    :function(){
									alert('Code Not Applied');
									},
									});
									}
									
									function add_new_modal_department(){
									var titler = '<?=lang("Add_New_Entry", "AAR"); ?>';
									show_modal( 'add_new_modal_department' , titler );
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
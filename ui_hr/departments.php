<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "Departments";
	
	$menuId = 8;
	$subPageID = 13;
	
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
					td = tr[i].getElementsByTagName("td")[1];
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
							
							<input type="text" name="searcher" id="searcherBox" onkeyup="mySearchFunction()" autocomplete="off" placeholder="Search..." />
							<div class="resultClass" id = "resulter"></div>
							<button id = "reload" onclick = "reload()">X</button>
							
						</div>
					</div>
					<table id="dataTable" class="tabler" border="2">
						
						
						<thead>
							<tr>
								<th>NO.</th>
								<th><?=lang("Department", "AAR"); ?></th>
							</tr>
						</thead>
						
						<tbody>
							<?php
								$sNo = 0;
								$qu_hr_departments_sel = "SELECT * FROM  `hr_departments`";
								$qu_hr_departments_EXE = mysqli_query($KONN, $qu_hr_departments_sel);
								if(mysqli_num_rows($qu_hr_departments_EXE)){
									while($hr_departments_REC = mysqli_fetch_assoc($qu_hr_departments_EXE)){
										$sNo++;
										$department_id = $hr_departments_REC['department_id'];
										$department_name = $hr_departments_REC['department_name'];
										$department_name_ar = $hr_departments_REC['department_name_ar'];
										$department_description = $hr_departments_REC['department_description'];
									
									
									?>
									<tr id="boxdata-<?=$department_id; ?>">
									<td><?=$sNo; ?></td>
									<td onclick="edit_data(<?=$department_id; ?>);"><span id="poREF-<?=$department_id; ?>" class="cell-title text-primary"><?=$department_name; ?></span></td>
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
									id="add-new-department-form" 
									id-modal="add_new_modal_department" 
									class="boxes-holder" 
									api="<?=api_root; ?>hr_departments/add_new.php">
									
									
									<div class="zero"></div>
									
									
									<div class="col-100">
									<div class="form-grp">
									<label>department_name</label>
									<input class="frmData" 
									id="new-department_name" 
									name="department_name" 
									req="1" 
									den="" 
									alerter="<?=lang("Please_Check_from", "AAR"); ?>">
									</div>
									</div>
									
									<div class="col-100">
									<div class="form-grp">
									<label>department_description</label>
									<textarea class="frmData" 
									id="new-department_description" 
									name="department_description" 
									req="1" 
									den="" 
									alerter="<?=lang("Please_Check_Description", "AAR"); ?>"></textarea>
									</div>
									</div>
									
									
									<div class="zero"></div>
									
									<div class="form-alerts"></div>
									<div class="zero"></div>
									
									<div class="viewerBodyButtons">
									<button type="button" onclick="submit_form('add-new-department-form', 'reload_page');">
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
									id="edit-department-form" 
									id-modal="edit_modal_department" 
									class="boxes-holder" 
									api="<?=api_root; ?>hr_departments/edit_data.php">
									
									
									<input class="frmData" type="hidden" 
									id="edit-department_id" 
									name="department_id" 
									value="0" 
									req="1" 
									den="0" 
									alerter="<?=lang("Please_Check_department", "AAR"); ?>">
									
									
									
									<div class="col-100">
									<div class="form-grp">
									<label>department_name</label>
									<input class="frmData" 
									id="edit-department_name" 
									name="department_name" 
									req="1" 
									den="" 
									alerter="<?=lang("Please_Check_from", "AAR"); ?>">
									</div>
									</div>
									
									<div class="col-100">
									<div class="form-grp">
									<label>department_description</label>
									<textarea class="frmData" 
									id="edit-department_description" 
									name="department_description" 
									req="1" 
									den="" 
									alerter="<?=lang("Please_Check_Description", "AAR"); ?>"></textarea>
									</div>
									</div>
									
									
									<div class="zero"></div>
									
									
									<div class="form-alerts"></div>
									<div class="zero"></div>
									
									<div class="viewerBodyButtons">
									<button type="button" onclick="submit_form('edit-department-form', 'reload_page');">
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
									url      :"<?=api_root; ?>hr_departments/rem_data.php",
									data     :{'typo': 'pc_call', 'department_id': ids_id},
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
									url      :"<?=api_root; ?>hr_departments/get_data.php",
									data     :{'typo': 'pc_call', 'ids_id': ids_id},
									dataType :"JSON",
									type     :'POST',
									success  :function(response){
									
									$('#edit-department_id').val(response[0].department_id);
									
									$('#edit-department_name').val(response[0].department_name);
									$('#edit-department_description').val(response[0].department_description);
									
									
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
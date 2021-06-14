<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "Inv Coding";
	
	
	$menuId = 6;
	$subPageID = 131;
	
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
								<option value = "1">Group</option>
								<option value = "2">Process</option>
								<option value = "3">Activity Name</option>
								<option value = "4">UOM</option>
								<option value = "5">KPI</option>
								<option value = "6">Manhour cost</option>
							</select>
							<input type="text" name="searcher" id="searcherBox" onkeyup="mySearchFunction()" autocomplete="off" placeholder="Search..." />
							<div class="resultClass" id = "resulter"></div>
							<button id = "reload" onclick = "reload()">X</button>
							
						</div>
					</div>
					<table id="dataTable" class="tabler" border="2" style="font-size:10px;">
						<thead>
							<tr>
								<th>
									<a onclick="add_new_modal_norm();"><button type="button" class="btn-success"><?=lang("Add_New", "AAR"); ?></button></a>
								</th>
								<th><?=lang("Group", "AAR"); ?></th>
								<th><?=lang("Process", "AAR"); ?></th>
								<th><?=lang("Activity_Name", "AAR"); ?></th>
								<th><?=lang("UOM", "AAR"); ?></th>
								<th><?=lang("KPI", "AAR"); ?></th>
								<th><?=lang("manHour_Cost", "AAR"); ?></th>
								<th><?=lang("Options", "AAR"); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$sNo = 0;
								$qu_gen_company_norms_sel = "SELECT * FROM  `gen_company_norms`";
								$qu_gen_company_norms_EXE = mysqli_query($KONN, $qu_gen_company_norms_sel);
								if(mysqli_num_rows($qu_gen_company_norms_EXE)){
									while($gen_company_norms_REC = mysqli_fetch_assoc($qu_gen_company_norms_EXE)){
										$sNo++;
										$norm_id = $gen_company_norms_REC['norm_id'];
										$group_name = $gen_company_norms_REC['group_name'];
										$process_name = $gen_company_norms_REC['process_name'];
										$norm_act_name = $gen_company_norms_REC['norm_act_name'];
										$unit_id = $gen_company_norms_REC['unit_id'];
										$activity_kpi = $gen_company_norms_REC['activity_kpi'];
										$manhour_cost = $gen_company_norms_REC['manhour_cost'];
										
										
										$qu_gen_items_units_sel = "SELECT * FROM  `gen_items_units` WHERE `unit_id` = $unit_id";
										$qu_gen_items_units_EXE = mysqli_query($KONN, $qu_gen_items_units_sel);
										$unit_name = "";
										if(mysqli_num_rows($qu_gen_items_units_EXE)){
											$gen_items_units_DATA = mysqli_fetch_assoc($qu_gen_items_units_EXE);
											$unit_id = $gen_items_units_DATA['unit_id'];
											$unit_name = $gen_items_units_DATA['unit_name'];
											$data_type = $gen_items_units_DATA['data_type'];
										}
										
										
										
									?>
									<tr id="boxdata-<?=$norm_id; ?>">
										<td><?=$sNo; ?></td>
										<td><?=$group_name; ?></td>
										<td><?=$process_name; ?></td>
										<td onclick="edit_data(<?=$norm_id; ?>);"><span id="poREF-<?=$norm_id; ?>" class="text-primary"><?=$norm_act_name; ?></span></td>
										<td><?=$unit_name; ?></td>
										<td><?=$activity_kpi; ?></td>
										<td><?=$manhour_cost; ?></td>
										<td>
											<button type="button" style="padding: 5px;" onclick="edit_data(<?=$norm_id; ?>);">Edit</button>
											<button type="button" style="padding: 5px;" onclick="del_data(<?=$norm_id; ?>);">Delete</button>
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
					<div class="zero"></div>
				</div>
				
				
				
				
				<!--    ///////////////////      add_new_modal_norm Modal START    ///////////////////            -->
				<div class="modal" id="add_new_modal_norm">
					<div class="modal-container">
						<div class="modal-header">
						<?php include("app/modal_header.php"); ?>
					</div>
					<div class="modal-body">
						
						<form 
						id="add-new-norm-form" 
						id-modal="add_new_modal_norm" 
						class="boxes-holder" 
						api="<?=api_root; ?>gen_company_norms/add_new.php">
							
							
							<div class="col-100">
								<div class="form-grp">
									<label>Group Name</label>
									<input class="frmData" type="text" 
									id="new-group_name" 
									name="group_name" 
									req="1" 
									den="" 
									alerter="<?=lang("Please_Check_group_name", "AAR"); ?>">
								</div>
							</div>
							
							
							<div class="col-100">
								<div class="form-grp">
									<label>Process Name</label>
									<input class="frmData" type="text" 
									id="new-process_name" 
									name="process_name" 
									req="1" 
									den="" 
									alerter="<?=lang("Please_Check_process_name", "AAR"); ?>">
								</div>
							</div>
							
							<div class="col-100">
								<div class="form-grp">
									<label>Activity Name</label>
									<input class="frmData" type="text" 
									id="new-norm_act_name" 
									name="norm_act_name" 
									req="1" 
									den="" 
								alerter="<?=lang("Please_Check_norm_act_name", "AAR"); ?>">
								</div>
								</div>
								
								<div class="col-100">
								<div class="form-grp">
								<label>UOM</label>
								<select class="frmData" 
								id="new-unit_id" 
								name="unit_id" 
								req="1" 
								den="0" 
								alerter="<?=lang("Please_Check_item_unit", "AAR"); ?>">
								<option value="0" selected>--- Please Select Unit---</option>
								<?php
								$qu_gen_items_units_sel = "SELECT `unit_id`, `unit_name` FROM  `gen_items_units`";
								$qu_gen_items_units_EXE = mysqli_query($KONN, $qu_gen_items_units_sel);
								if(mysqli_num_rows($qu_gen_items_units_EXE)){
								while($gen_items_units_REC = mysqli_fetch_array($qu_gen_items_units_EXE)){
								?>
								<option value="<?=$gen_items_units_REC[0]; ?>"><?=$gen_items_units_REC[1]; ?></option>
								<?php
								}
								}
								?>
								</select>
								</div>
								</div>
								
								<div class="col-50">
								<div class="form-grp">
								<label>activity kpi</label>
								<input class="frmData" type="text" 
								id="new-activity_kpi" 
								name="activity_kpi" 
								req="1" 
								den="" 
								alerter="<?=lang("Please_Check_activity_kpi", "AAR"); ?>">
								</div>
								</div>
								
								<div class="col-50">
								<div class="form-grp">
								<label>manhour cost</label>
								<input class="frmData" type="text" 
								id="new-manhour_cost" 
								name="manhour_cost" 
								req="1" 
								den="" 
								alerter="<?=lang("Please_Check_manhour_cost", "AAR"); ?>">
								</div>
								</div>
								
								
								<div class="zero"></div>
								
								<div class="form-alerts"></div>
								<div class="zero"></div>
								
								<div class="viewerBodyButtons">
								<button type="button" onclick="submit_form('add-new-norm-form', 'reload_page');">
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
								
								
								<!--    ///////////////////      add_new_modal_norm Modal END    ///////////////////            -->
								
								
								
								<!--    ///////////////////      edit_modal_norm Modal START    ///////////////////            -->
								<div class="modal" id="edit_modal_norm">
								<div class="modal-container">
								<div class="modal-header">
								<?php include("app/modal_header.php"); ?>
								</div>
								<div class="modal-body">
								
								<form 
								id="edit-norm-form" 
								id-modal="edit_modal_norm" 
								class="boxes-holder" 
								api="<?=api_root; ?>gen_company_norms/edit_data.php">
								
								
								<input class="frmData" type="hidden" 
								id="edit-norm_id" 
								name="norm_id" 
								value="0" 
								req="1" 
								den="0" 
								alerter="<?=lang("Please_Check_unit", "AAR"); ?>">
								
								
								<div class="col-100">
								<div class="form-grp">
								<label>Group Name</label>
								<input class="frmData" type="text" 
								id="edit-group_name" 
								name="group_name" 
								req="1" 
								den="" 
								alerter="<?=lang("Please_Check_group_name", "AAR"); ?>">
								</div>
								</div>
								
								
								<div class="col-100">
								<div class="form-grp">
								<label>Process Name</label>
								<input class="frmData" type="text" 
								id="edit-process_name" 
								name="process_name" 
								req="1" 
								den="" 
								alerter="<?=lang("Please_Check_process_name", "AAR"); ?>">
								</div>
								</div>
								
								
								<div class="col-100">
								<div class="form-grp">
								<label>Activity Name</label>
								<input class="frmData" type="text" 
								id="edit-norm_act_name" 
								name="norm_act_name" 
								req="1" 
								den="" 
								alerter="<?=lang("Please_Check_norm_act_name", "AAR"); ?>">
								</div>
								</div>
								
								<div class="col-50">
								<div class="form-grp">
								<label>UOM</label>
								<select class="frmData" 
								id="edit-unit_id" 
								name="unit_id" 
								req="1" 
								den="0" 
								alerter="<?=lang("Please_Check_item_unit", "AAR"); ?>">
								<option value="0" selected>--- Please Select Unit---</option>
								<?php
								$qu_gen_items_units_sel = "SELECT `unit_id`, `unit_name` FROM  `gen_items_units`";
								$qu_gen_items_units_EXE = mysqli_query($KONN, $qu_gen_items_units_sel);
								if(mysqli_num_rows($qu_gen_items_units_EXE)){
								while($gen_items_units_REC = mysqli_fetch_array($qu_gen_items_units_EXE)){
								?>
								<option value="<?=$gen_items_units_REC[0]; ?>"><?=$gen_items_units_REC[1]; ?></option>
								<?php
								}
								}
								?>
								</select>
								</div>
								</div>
								
								<div class="col-50">
								<div class="form-grp">
								<label>activity kpi</label>
								<input class="frmData" type="text" 
								id="edit-activity_kpi" 
								name="activity_kpi" 
								req="1" 
								den="" 
								alerter="<?=lang("Please_Check_activity_kpi", "AAR"); ?>">
								</div>
								</div>
								
								<div class="col-50">
								<div class="form-grp">
								<label>manhour cost</label>
								<input class="frmData" type="text" 
								id="edit-manhour_cost" 
								name="manhour_cost" 
								req="1" 
								den="" 
								alerter="<?=lang("Please_Check_manhour_cost", "AAR"); ?>">
								</div>
								</div>
								
								<div class="zero"></div>
								
								
								<div class="form-alerts"></div>
								<div class="zero"></div>
								
								<div class="viewerBodyButtons">
								<button type="button" onclick="submit_form('edit-norm-form', 'reload_page');">
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
								<!--    ///////////////////      edit_modal_norm Modal END    ///////////////////            -->
								
								<script>
								function del_data( ids_id ){
								var aa = confirm("Are you sure, action cannot be undone ?");
								if( aa == true ){
								alert("Unit Assigned with items, cannot be deleted !");
								/*
								$.ajax({
								url      :"<?=api_root; ?>gen_company_norms/rem_data.php",
								data     :{'typo': 'pc_call', 'norm_id': ids_id},
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
								
								
								function add_new_modal_norm(){
								var titler = '<?=lang("Add_New_Entry", "AAR"); ?>';
								show_modal( 'add_new_modal_norm' , titler );
								}
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								function edit_data( ids_id ){
								var titler = '<?=lang("Edit", "AAR"); ?>' + ' :: ';
								
								titler = titler + $('#boxdata-' + ids_id + ' .cell-title').text();
								
								$.ajax({
								url      :"<?=api_root; ?>gen_company_norms/get_data.php",
								data     :{'typo': 'pc_call', 'ids_id': ids_id},
								dataType :"JSON",
								type     :'POST',
								success  :function(response){
								
								
								$('#edit-norm_id').val(response[0].norm_id);
								$('#edit-group_name').val(response[0].group_name);
								$('#edit-process_name').val(response[0].process_name);
								$('#edit-norm_act_name').val(response[0].norm_act_name);
								$('#edit-unit_id').val(response[0].unit_id);
								$('#edit-activity_kpi').val(response[0].activity_kpi);
								$('#edit-manhour_cost').val(response[0].manhour_cost);
								
								
								show_modal( 'edit_modal_norm' , titler );
								
								// end_loader();
								
								},
								error    :function(){
								alert('Code Not Applied');
								},
								});
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
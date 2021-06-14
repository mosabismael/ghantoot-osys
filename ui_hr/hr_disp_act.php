<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "Site Title";
	
	$menuId = 5;
	$subPageID = 7;
	
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
								<option value = "0">Sys Id</option>
								<option value = "1">Employee Name</option>
								<option value = "2">Action</option>
								<option value = "3">State</option>
							</select>
							<input type="text" name="searcher" id="searcherBox" onkeyup="mySearchFunction()" autocomplete="off" placeholder="Search..." />
							<div class="resultClass" id = "resulter"></div>
							<button id = "reload" onclick = "reload()">X</button>
							
						</div>
					</div>
					<table class="tabler" id="dataTable">
						<thead>
							<tr>
								<th><?=lang("Sys_Id", "AAR"); ?></th>
								<th><?=lang("employee_Name", "AAR"); ?></th>
								<th><?=lang("Action", "AAR"); ?></th>
								<th><?=lang("State", "AAR"); ?></th>
								<th>&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							<?php
								
								$qu_hr_employees_disp_actions_sel = "SELECT * FROM  `hr_employees_disp_actions`";
								$qu_hr_employees_disp_actions_EXE = mysqli_query($KONN, $qu_hr_employees_disp_actions_sel);
								if(mysqli_num_rows($qu_hr_employees_disp_actions_EXE)){
									while($hr_employees_disp_actions_REC = mysqli_fetch_assoc($qu_hr_employees_disp_actions_EXE)){
										
										$record_id = $hr_employees_disp_actions_REC['record_id'];
										$employee_id = $hr_employees_disp_actions_REC['employee_id'];
										$disp_action_id = $hr_employees_disp_actions_REC['disp_action_id'];
										
										
										$disp_act_status = get_current_state($KONN, $record_id, "hr_employees_disp_actions" );
										
										
									$qu_hr_employees_sel = "SELECT * FROM  `hr_employees` WHERE `employee_id` = $employee_id";
									$qu_hr_employees_EXE = mysqli_query($KONN, $qu_hr_employees_sel);
									$hr_employees_DATA;
									if(mysqli_num_rows($qu_hr_employees_EXE)){
									$hr_employees_DATA = mysqli_fetch_assoc($qu_hr_employees_EXE);
									}
									
									$employee_code = $hr_employees_DATA['employee_code'];
									$first_name = $hr_employees_DATA['first_name'];
									$last_name = $hr_employees_DATA['last_name'];
									$join_date = $hr_employees_DATA['join_date'];
									
									$qu_hr_disp_actions_sel = "SELECT * FROM  `hr_disp_actions` WHERE `disp_action_id` = $disp_action_id";
									$qu_hr_disp_actions_EXE = mysqli_query($KONN, $qu_hr_disp_actions_sel);
									$hr_disp_actions_DATA;
									if(mysqli_num_rows($qu_hr_disp_actions_EXE)){
									$hr_disp_actions_DATA = mysqli_fetch_assoc($qu_hr_disp_actions_EXE);
									}
									$disp_action_code = $hr_disp_actions_DATA['disp_action_code'];
									$disp_action_text = $hr_disp_actions_DATA['disp_action_text'];
									
									
									?>
									<tr id="all-<?=$record_id; ?>">
									<td>HRDA-<?=$record_id; ?></td>
									<td class="cell-title"><a href="hr_employees_profile.php?employee_id=<?=$employee_id; ?>&b=<?=basename($_SERVER['PHP_SELF']); ?>" style="color:blue;"><?=$employee_code; ?> - <?=$first_name." ".$last_name; ?></a></td>
									<td><?=$disp_action_code; ?></td>
									<td class="stater"><?=$disp_act_status; ?></td>
									<td class="text-center">
									
									<a href="print/hr_disp_act_print.php?idd=<?=$record_id; ?>" target="_blank" title="<?=lang("print", "AAR"); ?>"><i class="fas fa-print"></i></a>
									<a onclick="deleteRecord(<?=$record_id; ?>);" title="<?=lang("Delete", "AAR"); ?>"><i style="color: red;" class="fas fa-trash-alt"></i></a>
									
									<?php
									if( $disp_act_status == 'draft' ){
									?>
									<a onclick="activateDispAct(<?=$record_id; ?>);" id="act-<?=$record_id; ?>" title="<?=lang("Activate", "AAR"); ?>"><i class="fas fa-check"></i></a>
									
									<a onclick="approveDispAct(<?=$record_id; ?>);" id="app-<?=$record_id; ?>" style="display:none;" title="<?=lang("Approve", "AAR"); ?>"><i class="fas fa-thumbs-up"></i></a>
									<a onclick="denyDispAct(<?=$record_id; ?>);" id="den-<?=$record_id; ?>" style="display:none;" title="<?=lang("Deny", "AAR"); ?>"><i class="fas fa-times"></i></a>
									
									
									
									<?php
									} else if( $disp_act_status == 'pending_approval' ){
									?>
									<a onclick="approveDispAct(<?=$record_id; ?>);" id="app-<?=$record_id; ?>" title="<?=lang("Approve", "AAR"); ?>"><i class="fas fa-thumbs-up"></i></a>
									<a onclick="denyDispAct(<?=$record_id; ?>);" id="den-<?=$record_id; ?>" title="<?=lang("Deny", "AAR"); ?>"><i class="fas fa-times"></i></a>
									
									<?php
									} else {
									?>
									---
									<?php
									}
									?>
									</td>
									
									</tr>
									<?php
									
									}
									}
									
									?>
									</tbody>
									</table>
									
									
									
									<script>
									
									function deleteRecord( recID ){
									var aa = confirm("This will delete current record");
									if( aa == true ){
									start_loader();
									$.ajax({
									url      :"<?=api_root; ?>hr/employee_disp_act_status.php",
									data     :{'record': recID },
									dataType :"HTML",
									type     :'POST',
									success  :function(response){
									end_loader();
									var resAr = response.split('|');
									var res = parseInt( resAr[0] );
									if( res == 1){
									$('#all-' + recID).remove();
									} else {
									alert( resAr[1] );
									}
									
									
									},
									error    :function(){
									alert('Code Not Applied');
									},
									});
									}
									}
									function changeDispActStatus( recID, state ){
									start_loader();
									$.ajax({
									url      :"<?=api_root; ?>hr/employee_disp_act_status.php",
									data     :{'record': recID, 'status': state},
									dataType :"JSON",
									type     :'POST',
									success  :function(response){
									var res = response['result'];
									
									if( res == true ){
									
									var nw_stater = response['nw_stater'];
									$('#all-' + recID + ' .stater').text( nw_stater );
									
									if( nw_stater == 'pending_approval' ){
									$('#act-' + recID).remove();
									$('#app-' + recID).css('display', 'inline-block');
									$('#den-' + recID).css('display', 'inline-block');
									} else {
									$('#app-' + recID).remove();
									$('#den-' + recID).remove();
									}
									
									} else {
									alert( 'Failed' );
									}
									
									end_loader();
									},
									error    :function(){
									alert('Code Not Applied');
									},
									});
									}
									
									function activateDispAct( recID ){
									var aa = confirm("This will Activate current record");
									if( aa == true ){
									changeDispActStatus( recID, '3' );
									}
									}
									function approveDispAct( recID ){
									var aa = confirm("This will Approve current record");
									if( aa == true ){
									changeDispActStatus( recID, '1' );
									}
									}
									function denyDispAct( recID ){
									var aa = confirm("This will Deny current record");
									if( aa == true ){
									changeDispActStatus( recID, '2' );
									}
									}
									
									</script>
									
									
									
									</div>
									
									
									<div class="zero"></div>
									</div>
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									<!--    ///////////////////      add_new_da_modal Modal START    ///////////////////            -->
									<div class="modal" id="add_new_da_modal">
									<div class="modal-container">
									<div class="modal-header">
									<?php include("app/modal_header.php"); ?>
									</div>
									<div class="modal-body">
									
									<form 
									id="new-employee-da-form" 
									id-modal="add_new_da_modal" 
									class="boxes-holder" 
									api="<?=api_root; ?>hr/employee_disp_act_new.php">
									
									
									
									<div class="col-50">
									<div class="form-grp">
									<label>Employee Name</label>
									<select class="frmData" 
									id="new-employee_id" 
									name="employee_id" 
									req="1" 
									den="0" 
									alerter="<?=lang("Please_Check_employee", "AAR"); ?>">
									<option value="0" selected>--- Please Select---</option>
									<?php
									$qu_hr_employees_sel = "SELECT `employee_id`, `first_name`, `last_name` FROM  `hr_employees` ORDER BY `first_name` ASC, `last_name` ASC";
									$qu_hr_employees_EXE = mysqli_query($KONN, $qu_hr_employees_sel);
									if(mysqli_num_rows($qu_hr_employees_EXE)){
									while($hr_employees_REC = mysqli_fetch_assoc($qu_hr_employees_EXE)){
									$NAMER = $hr_employees_REC['first_name'].' '.$hr_employees_REC['last_name'];
									?>
									<option value="<?=$hr_employees_REC['employee_id']; ?>"><?=$NAMER; ?></option>
									<?php
									}
									}
									?>
									</select>
									</div>
									</div>
									
									<div class="col-50">
									<div class="form-grp">
									<label>Submission Date</label>
									<input class="frmData" type="text" 
									id="new-created_date" 
									name="created_date" 
									req="1" 
									den="" 
									alerter="<?=lang("Please_Check_created_date ", "AAR"); ?>" value="<?=date('Y-m-d'); ?>" disabled>
									</div>
									</div>
									
									<div class="col-100">
									<div class="form-grp">
									<label>Action By Employee</label>
									<select class="frmData" 
									id="new-disp_action_id" 
									name="disp_action_id" 
									req="1" 
									den="0" 
									alerter="<?=lang("Please_Check_Action", "AAR"); ?>">
									<option value="0" selected>--- Please Select---</option>
									<?php
									$qu_disp_actions_sel = "SELECT * FROM  `hr_disp_actions` ORDER BY `disp_action_code` ASC";
									$qu_disp_actions_EXE = mysqli_query($KONN, $qu_disp_actions_sel);
									if(mysqli_num_rows($qu_disp_actions_EXE)){
									while($disp_actions_REC = mysqli_fetch_assoc($qu_disp_actions_EXE)){
									$NAMER = $disp_actions_REC['disp_action_code'];
									?>
									<option value="<?=$disp_actions_REC['disp_action_id']; ?>" 
									id="disp-<?=$disp_actions_REC['disp_action_id']; ?>" 
									dt-v="<?=$disp_actions_REC['disp_action_text']; ?>"><?=$NAMER; ?></option>
									<?php
									}
									}
									?>
									</select>
									
									<textarea id="action_by_employee" readonly disabled></textarea>
									</div>
									</div>
									
									
									<div class="col-50">
									<div class="form-grp">
									<label>Warning</label>
									<select class="frmData" 
									id="new-warning" 
									name="warning" 
									req="1" 
									den="1500" 
									alerter="<?=lang("Please_Check_warning", "AAR"); ?>">
									<option value="1500" selected>--- Please Select---</option>
									<option value="0">No Warning</option>
									<option value="1">First Warning</option>
									<option value="2">Second Warning</option>
									<option value="3">Third Warning</option>
									<option value="4">Final Warning</option>
									</select>
									</div>
									</div>
									
									<div class="col-50">
									<div class="form-grp">
									<label>Deductions</label>
									<select class="frmData" 
									id="new-deductions" 
									name="deductions" 
									req="1" 
									den="1500" 
									alerter="<?=lang("Please_Check_deduction", "AAR"); ?>">
									<option value="1500" selected>--- Please Select---</option>
									<option value="0">No Deduction</option>
									<option value="0.5">Half Day Deduction</option>
									<option value="1">1 - Day Deduction</option>
									<option value="2">2 - Day Deduction</option>
									<option value="3">3 - Day Deduction</option>
									<option value="4">4 - Day Deduction</option>
									<option value="5">5 - Day Deduction</option>
									<option value="6">6 - Day Deduction</option>
									<option value="7">7 - Day Deduction</option>
									<option value="8">8 - Day Deduction</option>
									<option value="9">9 - Day Deduction</option>
									<option value="10">10 - Day Deduction</option>
									<option value="11">11 - Day Deduction</option>
									<option value="12">12 - Day Deduction</option>
									<option value="13">13 - Day Deduction</option>
									<option value="14">14 - Day Deduction</option>
									<option value="15">15 - Day Deduction</option>
									<option value="16">16 - Day Deduction</option>
									<option value="17">17 - Day Deduction</option>
									<option value="18">18 - Day Deduction</option>
									<option value="19">19 - Day Deduction</option>
									<option value="20">20 - Day Deduction</option>
									</select>
									</div>
									</div>
									
									
									<div class="col-50">
									<div class="form-grp">
									<label>Status</label>
									<select class="frmData" 
									id="new-disp_act_status" 
									name="disp_act_status" 
									req="1" 
									den="" 
									alerter="<?=lang("Please_Check_status ", "AAR"); ?>" disabled>
									<option value="pending_approval" selected>Pending Approval</option>
									<option value="approved">Approved</option>
									</select>
									</div>
									</div>
									
									
									
									<div class="col-50">
									<div class="form-grp">
									<label>memo</label>
									<textarea class="frmData" 
									id="new-memo" 
									name="memo" 
									req="0" 
									den="" 
									alerter="<?=lang("Please_Check_memo ", "AAR"); ?>"></textarea>
									</div>
									</div>
									
									
									<div class="form-alerts"></div>
									<div class="zero"></div>
									
									<div class="viewerBodyButtons">
									<button type="button" onclick="submit_form('new-employee-da-form', 'reload_page');">
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
									
									
									<!--    ///////////////////      add_new_da_modal Modal END    ///////////////////            -->
									
									
									<script>
									$('#new-disp_action_id').on('change', function(){
									var dispID = parseInt( $('#new-disp_action_id').val() );
									if( dispID != 0 ){
									var dispTxt = $('#disp-' + dispID).attr('dt-v');
									
									$("#action_by_employee").val( dispTxt );
									}
									});
									
									
									function add_new_da_modal(){
									var titler = '<?=lang("Add_New_Entry", "AAR"); ?>';
									show_modal( 'add_new_da_modal' , titler );
									}
									
									
									</script>
									
									
									
									
									
									<?php
									//PAGE DATA END   ----------------------------------------------///---------------------------------
									include('app/footer.php');
									?>
									<?php
									if( isset( $_GET['add_new'] ) ){
									?>
									<script>
									add_new_da_modal();
									</script>
									<?php
									}
									?>
									</body>
									</html>									
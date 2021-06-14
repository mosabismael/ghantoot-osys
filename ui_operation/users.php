<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "Inv Coding";
	
	$menuId = 5;
	$subPageID = 11;
	
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
					<div class="tableForm">
						<div class="tableFormGroup">
							<select id = "search_option">
								<option value = "" selected disabled> Select Column</option>
								<option value = "1">Employee</option>
								<option value = "2">Email</option>
								<option value = "3">Level</option>
								<option value = "4">Code</option>
							</select>
							<input type="text" name="searcher" id="searcherBox" onkeyup="mySearchFunction()" autocomplete="off" placeholder="Search..." />
							<div class="resultClass" id = "resulter"></div>
							<button id = "reload" onclick = "reload()">X</button>
							
						</div>
					</div>
					<table id="dataTable" class="tabler" border="2">
						<thead>
							<tr>
								<th><?=lang("NO.", "AAR"); ?></th>
								<th><?=lang("Employee", "AAR"); ?></th>
								<th><?=lang("Email", "AAR"); ?></th>
								<th><?=lang("Level", "AAR"); ?></th>
								<th><?=lang("Code", "AAR"); ?></th>
								<th><?=lang("Options", "AAR"); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$sNo = 0;
								$qu_users_sel = "SELECT * FROM  `users`";
								$qu_users_EXE = mysqli_query($KONN, $qu_users_sel);
								if(mysqli_num_rows($qu_users_EXE)){
									while($users_REC = mysqli_fetch_assoc($qu_users_EXE)){
										$sNo++;
										$user_id = $users_REC['user_id'];
										$email = $users_REC['email'];
										$level = $users_REC['level'];
										$dept_code = $users_REC['dept_code'];
										$status = $users_REC['status'];
										$employee_id = $users_REC['employee_id'];
										
										$BY       = get_emp_name($KONN, $employee_id );
										
										
										
									?>
									<tr id="boxdata-<?=$user_id; ?>">
										<td><?=$sNo; ?></td>
										<td onclick="edit_data(<?=$user_id; ?>);"><span id="usrName-<?=$user_id; ?>" class="text-primary"><?=$BY; ?></span></td>
										<td><?=$email; ?></td>
										<td><?=$level; ?></td>
										<td><?=$dept_code; ?></td>
										<td>
											<button type="button" onclick="del_data(<?=$user_id; ?>);">Del</button>
											<button type="button" onclick="editPass(<?=$user_id; ?>);">Reset Pass</button>
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
			
			
			
			
			<!--    ///////////////////      add_new_modal_user Modal START    ///////////////////            -->
			<div class="modal" id="add_new_modal_user">
				<div class="modal-container">
					<div class="modal-header">
						<?php include("app/modal_header.php"); ?>
					</div>
					<div class="modal-body">
						
						<form 
						id="add-new-user-form" 
						id-modal="add_new_modal_user" 
						class="boxes-holder" 
						api="<?=api_root; ?>users/add_new.php">
							
							
							
							<div class="col-100">
								<div class="form-grp">
									<label class="lbl_class"><?=lang('Employee', 'ARR', 1); ?></label>
									<select class="frmData" 
									id="new-employee_id" 
									name="employee_id" 
									req="1" 
									den="0" 
									alerter="<?=lang("Please_Check_Employee", "AAR"); ?>">
										<option value="0" selected><?=lang("Please_Select", "غير محدد"); ?></option>
										<?php
											$qu_hr_employees_sel = "SELECT `employee_id`, `employee_code`, `first_name`, `last_name` FROM  `hr_employees` ORDER BY `first_name` ASC;";
											$qu_hr_employees_EXE = mysqli_query($KONN, $qu_hr_employees_sel);
											if(mysqli_num_rows($qu_hr_employees_EXE)){
												while($hr_employees_REC = mysqli_fetch_assoc($qu_hr_employees_EXE)){
													$employee_id = $hr_employees_REC['employee_id'];
													$namer = $hr_employees_REC['employee_code']."- ".$hr_employees_REC['first_name']." ".$hr_employees_REC['last_name'];
												?>
												<option value="<?=$employee_id; ?>"><?=$namer; ?></option>
												<?php
												}
											}
										?>
									</select>
								</div>
							</div>
							<div class="zero"></div>
							
							<div class="col-50">
								<div class="form-grp">
									<label>email</label>
									<input class="frmData" type="email" 
									id="new-email" 
									name="email" 
									req="1" 
									den="" 
									alerter="<?=lang("Please_Check_email", "AAR"); ?>">
								</div>
							</div>
							
							<div class="col-50">
								<div class="form-grp">
									<label>password</label>
									<input class="frmData" type="password" 
									id="new-password" 
									name="password" 
									req="1" 
									den="" 
									alerter="<?=lang("Please_Check_password", "AAR"); ?>">
								</div>
							</div>
							
							<div class="zero"></div>
							
							<div class="col-50">
								<div class="form-grp">
									<label class="lbl_class"><?=lang('Level', 'ARR', 1); ?></label>
									<select class="frmData" 
									id="new-level" 
									name="level" 
									req="1" 
									den="0" 
									alerter="<?=lang("Please_Check_Level", "AAR"); ?>">
										<option value="0" selected>--- Please Select Code---</option>
										<option value="acc" selected>ACC Manager</option>
										<option value="acc_assist" selected>ACC Assistant</option>
										<option value="data_entry" selected>data_entry</option>
										<option value="hr" selected>hr</option>
										<option value="inventory" selected>inventory</option>
										<option value="operation" selected>operation</option>
										<option value="qhse" selected>QHSE</option>
										<option value="purchase" selected>purchase</option>
										<option value="reports" selected>reports</option>
										<option value="sales_estimate" selected>Sales & Estimations</option>
									</select>
								</div>
							</div>
							
							<div class="col-50">
								<div class="form-grp">
									<label>dept. code</label>
									<input class="frmData" type="text" 
									id="new-dept_code" 
									name="dept_code" 
									req="1" 
									den="" 
									alerter="<?=lang("Please_Check_dept_code", "AAR"); ?>">
								</div>
							</div>
							
							<div class="zero"></div>
							
							<div class="col-100">
								<div class="form-grp">
									<label class="lbl_class"><?=lang('status', 'ARR', 1); ?></label>
									<select class="frmData" 
									id="new-status" 
									name="status" 
									req="1" 
									den="0" 
									alerter="<?=lang("Please_Check_status", "AAR"); ?>">
										<option value="active" selected>Active</option>
										<option value="deactivated">Deactivated</option>
									</select>
								</div>
							</div>
							
							
							
							<div class="zero"></div>
							
							
							<div class="form-alerts"></div>
							<div class="zero"></div>
							
							<div class="viewerBodyButtons">
								<button type="button" onclick="submit_form('add-new-user-form', 'reload_page');">
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
			
			
			<!--    ///////////////////      add_new_modal_user Modal END    ///////////////////            -->
			
			
			
			<!--    ///////////////////      reset_pass_modal Modal START    ///////////////////            -->
			<div class="modal" id="reset_pass_modal">
				<div class="modal-container">
					<div class="modal-header">
						<?php include("app/modal_header.php"); ?>
					</div>
					<div class="modal-body">
						
						<form 
						id="reset-pass-form" 
						id-modal="reset_pass_modal" 
						class="boxes-holder" 
						api="<?=api_root; ?>users/updt_pass.php">
							
							
							<input class="frmData" type="hidden" 
							id="respass-user_id" 
							name="user_id" 
							value="0" 
							req="1" 
							den="0" 
							alerter="<?=lang("Please_Check_user", "AAR"); ?>">
							
							
							<div class="col-100">
								<div class="form-grp">
									<label>New Password</label>
									<input class="frmData" type="password" 
									id="respass-nw_pass" 
									name="nw_pass" 
									req="1" 
									den="" 
									alerter="<?=lang("Please_Check_new_Password", "AAR"); ?>">
								</div>
							</div>
							<div class="zero"></div>
							<div class="form-alerts"></div>
							<div class="zero"></div>
							
							<div class="viewerBodyButtons">
								<button type="button" onclick="submit_form('reset-pass-form', 'reload_page');">
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
			<!--    ///////////////////      reset_pass_modal Modal END    ///////////////////            -->
			
			
			<!--    ///////////////////      edit_modal_user Modal START    ///////////////////            -->
			<div class="modal" id="edit_modal_user">
				<div class="modal-container">
					<div class="modal-header">
						<?php include("app/modal_header.php"); ?>
					</div>
					<div class="modal-body">
						
						<form 
						id="edit-user-form" 
						id-modal="edit_modal_user" 
						class="boxes-holder" 
						api="<?=api_root; ?>users/edit_data.php">
							
							
							<input class="frmData" type="hidden" 
							id="edit-user_id" 
							name="user_id" 
							value="0" 
							req="1" 
							den="0" 
							alerter="<?=lang("Please_Check_user", "AAR"); ?>">
							
							
							<div class="col-50">
								<div class="form-grp">
									<label>email</label>
									<input class="frmData" type="email" 
									id="edit-email" 
									name="email" 
									req="1" 
									den="" 
									alerter="<?=lang("Please_Check_email", "AAR"); ?>">
								</div>
							</div>
							
							
							<div class="zero"></div>
							
							<div class="col-50">
								<div class="form-grp">
									<label class="lbl_class"><?=lang('Level', 'ARR', 1); ?></label>
									<select class="frmData" 
									id="edit-level" 
									name="level" 
									req="1" 
									den="0" 
									alerter="<?=lang("Please_Check_Level", "AAR"); ?>">
										<option value="0" selected>--- Please Select Code---</option>
										<option value="acc" selected>acc</option>
										<option value="data_entry" selected>data_entry</option>
										<option value="hr" selected>hr</option>
										<option value="inventory" selected>inventory</option>
										<option value="operation" selected>operation</option>
										<option value="purchase" selected>purchase</option>
										<option value="reports" selected>reports</option>
										<option value="sales_estimate" selected>Sales & Estimations</option>
									</select>
								</div>
							</div>
							
							<div class="col-50">
								<div class="form-grp">
									<label>dept. code</label>
									<input class="frmData" type="text" 
									id="edit-dept_code" 
									name="dept_code" 
									req="1" 
									den="" 
									alerter="<?=lang("Please_Check_dept_code", "AAR"); ?>">
								</div>
							</div>
							
							<div class="zero"></div>
							
							<div class="col-100">
								<div class="form-grp">
									<label class="lbl_class"><?=lang('status', 'ARR', 1); ?></label>
									<select class="frmData" 
									id="edit-status" 
									name="status" 
									req="1" 
									den="0" 
									alerter="<?=lang("Please_Check_status", "AAR"); ?>">
										<option value="active" selected>Active</option>
										<option value="deactivated">Deactivated</option>
									</select>
								</div>
							</div>
							
							<div class="zero"></div>
							
							
							<div class="form-alerts"></div>
							<div class="zero"></div>
							
							<div class="viewerBodyButtons">
								<button type="button" onclick="submit_form('edit-user-form', 'reload_page');">
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
			<!--    ///////////////////      edit_modal_user Modal END    ///////////////////            -->
			
			<script>
				function del_data( ids_id ){
					var aa = confirm("Are you sure, action cannot be undone ?");
					if( aa == true ){
						
						$.ajax({
							url      :"<?=api_root; ?>users/rem_data.php",
							data     :{'typo': 'pc_call', 'user_id': ids_id},
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
						url      :"<?=api_root; ?>users/get_data.php",
						data     :{'typo': 'pc_call', 'ids_id': ids_id},
						dataType :"JSON",
						type     :'POST',
						success  :function(response){
							
							
							$('#edit-user_id').val(response[0].user_id);
							$('#edit-email').val(response[0].email);
							$('#edit-level').val(response[0].level);
							$('#edit-dept_code').val(response[0].dept_code);
							$('#edit-status').val(response[0].statuser);
							
							
							
							show_modal( 'edit_modal_user' , titler );
							
							// end_loader();
							
						},
						error    :function(){
							alert('Code Not Applied');
						},
					});
				}
				
				function editPass( usrID ){
					usrID = parseInt( usrID );
					if( usrID != 0 ){
						var titler = '<?=lang("Edit_User_Password", "AAR"); ?>';
						var usrName = $('#usrName-' + usrID).text();
						titler = titler + " :: " + usrName;
						$('#respass-user_id').val( usrID );
						show_modal( 'reset_pass_modal' , titler );
					}
				}
				
				function add_new_modal_user(){
					var titler = '<?=lang("Add_New_Entry", "AAR"); ?>';
					show_modal( 'add_new_modal_user' , titler );
				}
				
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
			
			
			
			
			
			<?php
				//PAGE DATA END   ----------------------------------------------///---------------------------------
				include('app/footer.php');
			?>
			<?php
				if( isset( $_GET['add_new'] ) ){
				?>
				<script>
					add_new_modal_user();
				</script>
				<?php
				}
			?>
		</body>
	</html>		
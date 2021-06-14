<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "Site Title";
	
	
	$menuId = 6;
	$subPageID = 8;
	
	$page = 1;
	$showPerPage = 20;
	$totPages = 0;
	$qu_COUNT_sel = "SELECT count(*) FROM  `hr_employees_deductions`";
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
								<option value = "2">Join Date</option>
								<option value = "3">Deduction Amount</option>
								<option value = "4">Submission Date </option>
								<option value = "5">Effective Date</option>
								<option value = "6">Status</option>
							</select>
							<input type="text" name="searcher" id="searcherBox" onkeyup="mySearchFunction()" autocomplete="off" placeholder="Search..." />
							<div class="resultClass" id = "resulter"></div>
							<button id = "reload" onclick = "reload()">X</button>
							
						</div>
					</div>
					<table id="dataTable" class="tabler" border="2" style="font-size:10px;">
						<thead>
							<tr>
								<th><?=lang("Sys_Id", "AAR"); ?></th>
								<th><?=lang("employee_Name", "AAR"); ?></th>
								<th><?=lang("Join_date", "AAR"); ?></th>
								<th><?=lang("deduction_amount", "AAR"); ?></th>
								<th><?=lang("Submission_date", "AAR"); ?></th>
								<th><?=lang("Effective_date", "AAR"); ?></th>
								<th><?=lang("Status", "AAR"); ?></th>
								<th></th>
							</tr>
						</thead>
						<tbody class="tableBody" id="tableBody"></tbody>
					</table>
					<div class="tablePagination">
						<div class="pageNum arrowPager" id="prePatchBtn" onclick="showPrePageBatch('ui_hr/<?=basename($_SERVER['PHP_SELF']); ?>', <?=$showPerPage; ?>, <?=$totPages; ?>);"><i class="fas fa-angle-double-left"></i></div>
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
								<div onclick="loadTableData( <?=$i; ?>, <?=$showPerPage; ?>, 'ui_hr/<?=basename($_SERVER['PHP_SELF']); ?>' );" class="pageNum imVarPager pn-<?=$i; ?> <?=$CLS; ?>"><?=$iView; ?></div>
								<?php
								}
							}
						?>
						<div id="addPagerPoint"></div>
						<div class="pageNum arrowPager" id="nextPatchBtn" onclick="showNextPageBatch('ui_hr/<?=basename($_SERVER['PHP_SELF']); ?>', <?=$showPerPage; ?>, <?=$totPages; ?>);"><i class="fas fa-angle-double-right"></i></div>
					</div>
					<script>
						var thsPage = 'ui_hr/<?=basename($_SERVER['PHP_SELF']); ?>';
						function bindData( response ){
							$('#tableBody').html('');
							var cc = 0;
							for( i=0 ; i < response.length ; i ++ ){
								cc++;
								var button = "";
								if( response[i].deduction_status == 'draft' ){
									
									button = '<a onclick="activateDeduction('+response[i].deduction_id+');" id="act-'+response[i].deduction_id+'" title="<?=lang("Activate", "AAR"); ?>"><i class="fas fa-check"></i></a>'+
									'<a onclick="approveDeduction('+response[i].deduction_id+');" id="app-'+response[i].deduction_id+'" style="display:none;" title="<?=lang("Approve", "AAR"); ?>"><i class="fas fa-thumbs-up"></i></a>'+
									'<a onclick="denyDeduction('+response[i].deduction_id+');" id="den-'+response[i].deduction_id+'" style="display:none;" title="<?=lang("Deny", "AAR"); ?>"><i class="fas fa-times"></i></a>';
								} 
								else if( response[i].deduction_status == 'pending_approval' ){
									button = '<a onclick="approveLeave('+response[i].deduction_id+');" id="app-'+response[i].deduction_id+'" title="<?=lang("Approve", "AAR"); ?>"><i class="fas fa-thumbs-up"></i></a>'+
									'<a onclick="denyLeave('+response[i].deduction_id+');" id="den-'+response[i].deduction_id+'" title="<?=lang("Deny", "AAR"); ?>"><i class="fas fa-times"></i></a>';
								}
								
								
								var tr = '' + 
								'<tr id="all-' + response[i].deduction_id + '">' + 
								'	<td> HRDED-' + response[i].deduction_id + '</td>' + 
								'	<td class = "cell-title"><a href="hr_employees_profile.php?employee_id='+response[i].employee_id+'&b=<?=basename($_SERVER['PHP_SELF']); ?>" style="color:blue;">'+response[i].employee_code+' - '+response[i].first_name+' '+response[i].last_name+'</a></td>'+ 
								'	<td>' + response[i].join_date + '</td>' + 
								'	<td>' + response[i].deduction_amount + '</td>' + 
								'	<td>' + response[i].deduction_date + '</td>' + 
								'	<td>' + response[i].deduction_effective_date + '</td>' + 
								'	<div class = "td stater">' + response[i].deduction_status + '</td>' + 
								'	<div class = "td text-center">' +
								'	<a href="print/hr_leaves_print.php?idd='+response[i].deduction_id+'" target="_blank" title="<?=lang("print", "AAR"); ?>"><i class="fas fa-print"></i></a>'+	
								'	<a onclick="deleteRecord('+response[i].deduction_id+');" title="<?=lang("Delete", "AAR"); ?>"><i style="color: red;" class="fas fa-trash-alt"></i></a>'+ button +
								'	</td>' + 
								'</tr>';
								$('#tableBody').append( tr );
								
								
								
							}
						}
						
						
					</script>
				</div>
				
				
				
				
				
				<script>
					
					function deleteRecord( recID ){
						var aa = confirm("This will delete current record");
						if( aa == true ){
							start_loader();
							$.ajax({
								url      :"<?=api_root; ?>hr/employee_deduction_status.php",
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
					function changeDeductionStatus( recID, state ){
						start_loader();
						$.ajax({
							url      :"<?=api_root; ?>hr/employee_deduction_status.php",
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
					
					function activateDeduction( recID ){
						var aa = confirm("This will Activate current record");
						if( aa == true ){
							changeDeductionStatus( recID, '3' );
						}
					}
					function approveDeduction( recID ){
						var aa = confirm("This will Approve current record");
						if( aa == true ){
							changeDeductionStatus( recID, '1' );
						}
					}
					function denyDeduction( recID ){
						var aa = confirm("This will Deny current record");
						if( aa == true ){
							changeDeductionStatus( recID, '2' );
						}
					}
					
				</script>
				
				
				
			</div>
			
			
			<div class="zero"></div>
		</div>
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		<!--    ///////////////////      add_new_employee_deduction Modal START    ///////////////////            -->
		<div class="modal" id="add_new_employee_deduction">
			<div class="modal-container">
				<div class="modal-header">
					<?php include("app/modal_header.php"); ?>
				</div>
				<div class="modal-body">
					
					<form 
					id="new-employee-deduction-form" 
					id-modal="add_new_employee_deduction" 
					class="boxes-holder" 
					api="<?=api_root; ?>hr/employee_deduction_new.php">
						
						
						
						<div class="col-100">
							<div class="form-grp">
								<label>Employee</label>
								<select class="frmData" 
								id="deduction-new-employee_id" 
								name="employee_id" 
								req="1" 
								den="0" 
								alerter="<?=lang("Please_Check_employee", "AAR"); ?>">
									<option value="0" selected>--- Please Select---</option>
									<?php
										$qu_hr_employees_sel = "SELECT `employee_id`, `first_name`, `last_name` FROM  `hr_employees` WHERE ( ( `employee_type` = 'local' ) ) ORDER BY `first_name` ASC, `last_name` ASC";
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
								<label>Deduction Date</label>
								<input class="frmData" type="text" 
								id="deduction-new-deduction_date" 
								name="deduction_date" 
								req="1" 
								den="" value="<?=date('Y-m-d'); ?>" 
								alerter="<?=lang("Please_Check_deduction_date", "AAR"); ?>">
							</div>
						</div>
						
						<div class="col-50">
							<div class="form-grp">
								<label>Effective Date</label>
								<input class="frmData has_date" type="text" 
								id="deduction-new-deduction_effective_date" 
								name="deduction_effective_date" 
								req="1" 
								den="" 
								alerter="<?=lang("Please_Check_deduction_effective_date", "AAR"); ?>">
							</div>
						</div>
						
						
						<div class="col-50">
							<div class="form-grp">
								<label>deduction amount</label>
								<input class="frmData" type="text" 
								id="deduction-new-deduction_amount" 
								name="deduction_amount" 
								req="1" 
								den="" 
								alerter="<?=lang("Please_Check_deduction_amount", "AAR"); ?>">
							</div>
						</div>
						
						
						
						<div class="col-50">
							<div class="form-grp">
								<label>Status</label>
								<select class="frmData" 
								id="new-deduction_status" 
								name="deduction_status" 
								req="1" 
								den="" 
								alerter="<?=lang("Please_Check_deduction_status ", "AAR"); ?>" disabled>
									<option value="draft" selected>Draft</option>
									<option value="pending_approval">Pending Approval</option>
									<option value="approved">Approved</option>
								</select>
							</div>
						</div>
						
						<div class="col-100">
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
							<button type="button" onclick="submit_form('new-employee-deduction-form', 'reload_page');">
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
		
		
		<!--    ///////////////////      add_new_employee Modal END    ///////////////////            -->
		
		
		<script>
			
			
			function add_new_employee_deduction(){
				var titler = '<?=lang("Add_New_Employee deduction", "AAR"); ?>';
				show_modal( 'add_new_employee_deduction' , titler );
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
				add_new_employee_deduction();
			</script>
			<?php
			}
		?>
	</body>
</html>
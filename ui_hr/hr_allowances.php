<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "Site Title";
	
	$SERCHCOND = "";
	$thsSEARCH = "";
	$thsREF    = "";
	if( isset( $_GET['search'] ) ){
		$thsSEARCH = test_inputs( $_GET['search'] );
		
	}
	if( isset( $_GET['value'] ) ){
		$thsREF = test_inputs( $_GET['value'] );
		$SERCHCOND = " WHERE (`$thsSEARCH` = '$thsREF')";
	}
	$thsPageName    = basename($_SERVER['PHP_SELF']);
	$thsPageArr     = explode('.', $thsPageName);
	$thsPageNameREQ = $thsPageArr[0];
	
	
	$menuId = 2;
	$subPageID = 4;
	
	$page = 1;
	$showPerPage = 20;
	$totPages = 0;
	$qu_COUNT_sel = "SELECT count(*) FROM  `hr_employees_allowances`";
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
			
			$(function(){
				if(<?=isset( $_GET['search'] )?>){
					document.getElementById('search_option').value = '<?=$thsSEARCH?>';
					document.getElementById('searcherBox').value = '<?=$thsREF?>';
				}
			});
			
			
            function reload() {
                window.location = window.location.href.split("?")[0];
			}
			
		</script>
			
			
			
			<div class="row">
				<div class="col-100">
					<div class="tableHolder">
						<div class="tableForm">
							<div class="tableFormGroup">
								<select id = "search_option">
									<option value = "" selected disabled> Select Column</option>
									<option value = "employee_id">Employee Name</option>
									<option value = "allowance_id">Allowance</option>
									<option value = "allowance_type">Type</option>
									<option value = "allowance_amount">Amount</option>
								</select>
								<input type="text" name="searcher" id="searcherBox" autocomplete="off" placeholder="Search..." />
								<div class="resultClass" id = "resulter"></div>
								<button id = "reload" onclick = "reload()">X</button>
								
							</div>
							<script>
								var sthsSearchCond = "<?=$SERCHCOND; ?>";
								$(document).ready(function(){
									$('#resulter').hide();
									$('#searcherBox').on("focus", function(){
										var dtt = $(this).val();
										if( dtt.length ){
											$('#searcherBox').keyup();
											} else {
											$('#resulter').html('');
											$('#resulter').hide();
										}
									});
									$('#searcherBox').on("focusout", function(){
										setTimeout( function(){
											$('#resulter').hide();
										}, 500 );
									});
									$('#searcherBox').on("keyup input", function(){
										/* Get input value on change */
										var inputVal = $(this).val();
										var search_option = $('#search_option').val();
										var resultDropdown = $(this).siblings(".resultClass");
										if(inputVal.length){
											$.get("<?=$thsPageNameREQ; ?>_search.php", {term: inputVal, searchoption : search_option}).done(function(data){
												// Display the returned data in browser
												resultDropdown.html(data);
												$('#resulter').show();
												document.getElementById("resulter").style.display = "block"; 
											});
											} else{
											resultDropdown.empty();
											$('#resulter').hide();
											document.getElementById("resulter").style.display = "none"; 
										}
									});
								});
							</script>
						</div>
						<div class="table">
							<div class="tableHeader">
								<div class="tr">
									<div class="th"><?=lang("Sys_Id", "AAR"); ?></div>
									<div class="th"><?=lang("employee", "AAR"); ?></div>
									<div class="th"><?=lang("Join_date", "AAR"); ?></div>
									<div class="th"><?=lang("allowance", "AAR"); ?></div>
									<div class="th"><?=lang("Type", "AAR"); ?></div>
									<div class="th"><?=lang("amount", "AAR"); ?></div>
									<div class="th"><?=lang("date", "AAR"); ?></div>
									<div class="th"></div>
								</div>
							</div>
							<div class="tableBody" id="tableBody"></div>
						</div>
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
									
									var tr = '' + 
									'<div class = "tr" id="all-' + response[i].record_id + '">' + 
									'	<div class = "td"> HRALW-' + response[i].record_id + '</div>' + 
									'	<div class = "td cell-title"> <a href="hr_employees_profile.php?employee_id='+response[i].employee_id+'&b=<?=basename($_SERVER['PHP_SELF']); ?>" style="color:blue;">'+response[i].employee_code+' - '+response[i].first_name+' '+response[i].last_name+'</a></div>' + 
									'	<div class = "td">' + response[i].join_date + '</div>' + 
									'	<div class = "td">' + response[i].allowance_title + '</div>' + 
									'	<div class = "td">' + response[i].allowance_type + '</div>' + 
									'	<div class = "td">' + response[i].allowance_amount + '</div>' + 
									'	<div class = "td">' + response[i].active_from +' - ' + response[i].active_to + '</div>' + 
									'	<div class = "td text-center"> '+
									'	<a href="print/hr_allowances_print.php?idd='+response[i].record_id+'" target="_blank" title="<?=lang("print", "AAR"); ?>">'+
									'	<i class="fas fa-print"></i></a> '+
									'	<a onclick="deleteRecord('+response[i].record_id+');" id="del-'+response[i].record_id+'" title="<?=lang("Delete", "AAR"); ?>"><i style="color: red;" class="fas fa-trash-alt"></i></a></div>' + 			
									'</div>';
									$('#tableBody').append( tr );
									
									
								}
							}
							
							
						</script>
					</div>
				</div>
				
				
				<div class="zero"></div>
			</div>
			
			
			<script>
				function changeAllowanceStatus( recID, state ){
					start_loader();
					$.ajax({
						url      :"<?=api_root; ?>hr/employee_allowance_status.php",
						data     :{'record': recID, 'status': state},
						dataType :"JSON",
						type     :'POST',
						success  :function(response){
							var res = response['result'];
							
							if( res == true ){
								var nw_stater = response['nw_stater'];
								$('#all-' + recID + ' .stater').text( nw_stater );
								if( nw_stater == 'approved' ){
									$('#app-' + recID).remove();
									$('#den-' + recID).remove();
									$('#del-' + recID).remove();
									$('#dea-' + recID).css('display', 'inline-block');
									} else {
									$('#app-' + recID).remove();
									$('#den-' + recID).remove();
									$('#del-' + recID).remove();
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
				
				function approveAllowance( recID ){
					var aa = confirm("This will Approve current record");
					if( aa == true ){
						changeAllowanceStatus( recID, '1' );
					}
				}
				function denyAllowance( recID ){
					var aa = confirm("This will Deny current record");
					if( aa == true ){
						changeAllowanceStatus( recID, '2' );
					}
				}
				function deleteRecord( recID ){
					var aa = confirm("This will delete current record");
					if( aa == true ){
						start_loader();
						$.ajax({
							url      :"<?=api_root; ?>hr/employee_allowance_status.php",
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
				function deActivateAllowance( recID ){
					var aa = confirm("This will Deactivate current record");
					if( aa == true ){
						changeAllowanceStatus( recID, '4' );
					}
				}
			</script>
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			<!--    ///////////////////      add_new_employee_allowance Modal START    ///////////////////            -->
			<div class="modal" id="add_new_employee_allowance">
				<div class="modal-container">
					<div class="modal-header">
						<?php include("app/modal_header.php"); ?>
					</div>
					<div class="modal-body">
						
						
						<form 
						id="new-employee-allowance-form" 
						id-modal="add_new_employee_allowance" 
						class="boxes-holder" 
						api="<?=api_root; ?>hr/employee_allowance_new.php">
							
							
							
							
							
							<div class="col-100">
								<div class="form-grp">
									<label>Employee</label>
									<select class="frmData" type="text" 
									id="employees_allowances-new-itm-employee_id" 
									name="employee_id" 
									req="1" 
									den="" 
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
							
							<div class="col-33">
								<div class="form-grp">
									<label>allowance</label>
									<select class="frmData" type="text" 
									id="employees_allowances-new-itm-allowance_id" 
									name="allowance_id" 
									req="1" 
									den="" 
									alerter="<?=lang("Please_Check_allowance", "AAR"); ?>">
										<option value="0" selected>--- Please Select---</option>
										<?php
											$qu_hr_employees_allowances_ids_sel = "SELECT `allowance_id`, `allowance_title` FROM  `hr_employees_allowances_ids`";
											$qu_hr_employees_allowances_ids_EXE = mysqli_query($KONN, $qu_hr_employees_allowances_ids_sel);
											if(mysqli_num_rows($qu_hr_employees_allowances_ids_EXE)){
												while($hr_employees_allowances_ids_REC = mysqli_fetch_array($qu_hr_employees_allowances_ids_EXE)){
													$NAMER = $hr_employees_allowances_ids_REC[1];
												?>
												<option value="<?=$hr_employees_allowances_ids_REC[0]; ?>"><?=$NAMER; ?></option>
												<?php
												}
											}
										?>
									</select>
									
								</div>
							</div>
							
							<div class="col-33">
								<div class="form-grp">
									<label>Allowance Type</label>
									<select class="frmData" type="text" 
									id="employees_allowances-new-itm-allowance_type" 
									name="allowance_type" 
									req="1" 
									den="" 
									alerter="<?=lang("Please_Check_allowance_type", "AAR"); ?>">
										<option value="0"> Please Select</option>
										<option value="monthly"> Monthly</option>
										<option value="annualy"> Annualy</option>
									</select>
								</div>
							</div>
							
							<div class="col-33">
								<div class="form-grp">
									<label>Allownce Amount</label>
									<input class="frmData" type="text" 
									id="employees_allowances-new-itm-allowance_amount" 
									name="allowance_amount" 
									req="1" 
									den="0" 
									alerter="<?=lang("Please_Check_allowance_amount", "AAR"); ?>">
								</div>
							</div>
							
							
							<div class="col-50">
								<div class="form-grp">
									<label>Active From</label>
									<input class="frmData has_date" type="text" 
									id="employees_allowances-new-itm-active_from" 
									name="active_from" 
									req="1" 
									den="" 
									alerter="<?=lang("Please_Check_active_from", "AAR"); ?>">
								</div>
							</div>
							
							<div class="col-50">
								<div class="form-grp">
									<label>Active To</label>
									<input class="frmData has_date" type="text" 
									id="employees_allowances-new-itm-active_to" 
									name="active_to" 
									req="1" 
									den="" 
									alerter="<?=lang("Please_Check_active_to", "AAR"); ?>">
								</div>
							</div>
							
							
							
							<div class="form-alerts"></div>
							<div class="zero"></div>
							
							<div class="viewerBodyButtons">
								<button type="button" onclick="submit_form('new-employee-allowance-form', 'reload_page');">
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
				
				
				function add_new_employee_allowance(){
					var titler = '<?=lang("Add_New_Employee Allowance", "AAR"); ?>';
					show_modal( 'add_new_employee_allowance' , titler );
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
					add_new_employee_allowance();
				</script>
				<?php
				}
			?>
		</body>
	</html>	
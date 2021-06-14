<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "Site Title";
	
	
	
	$menuId = 3;
	$subPageID = 5;
	
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
	
	
	$page = 1;
	$showPerPage = 20;
	$totPages = 0;
	$qu_COUNT_sel = "SELECT count(*) FROM  `hr_employees_leaves`";
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
									<option value = "leave_type_id">Leave Type</option>
									<option value = "start_date">Start Time</option>
									<option value = "end_date">End Time</option>
									<option value = "leave_status">Status</option>
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
									<div class="th"><?=lang("employee_Name", "AAR"); ?></div>
								<div class="th"><?=lang("Leave_Type", "AAR"); ?></div>
								<div class="th"><?=lang("start_time", "AAR"); ?></div>
								<div class="th"><?=lang("end_time", "AAR"); ?></div>
								<div class="th"><?=lang("Status", "AAR"); ?></div>
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
							var button = "";
							if( response[i].leave_status == 'draft' ){
							
							button = '<a onclick="activateLeave('+response[i].leave_id+');" id="act-'+response[i].leave_id+'" title="<?=lang("Activate", "AAR"); ?>"><i class="fas fa-check"></i></a>'+
							'<a onclick="approveLeave('+response[i].leave_id+');" id="app-'+response[i].leave_id+'" style="display:none;" title="<?=lang("Approve", "AAR"); ?>"><i class="fas fa-thumbs-up"></i></a>'+
							'<a onclick="denyLeave('+response[i].leave_id+');" id="den-'+response[i].leave_id+'" style="display:none;" title="<?=lang("Deny", "AAR"); ?>"><i class="fas fa-times"></i></a>';
							} else if( response[i].leave_status == 'pending_approval' ){
							button = '<a onclick="approveLeave('+response[i].leave_id+');" id="app-'+response[i].leave_id+'" title="<?=lang("Approve", "AAR"); ?>"><i class="fas fa-thumbs-up"></i></a>'+
							'<a onclick="denyLeave('+response[i].leave_id+');" id="den-'+response[i].leave_id+'" title="<?=lang("Deny", "AAR"); ?>"><i class="fas fa-times"></i></a>';
							}
							
							
							var tr = '' + 
							'<div class = "tr" id="leave-' + response[i].leave_id + '">' + 
							'	<div class = "td"> HRLV-' + response[i].leave_id + '</div>' + 
							'	<div class = "td cell-title"><a href="hr_employees_profile.php?employee_id='+response[i].employee_id+'&b=<?=basename($_SERVER['PHP_SELF']); ?>" style="color:blue;">'+response[i].employee_code+' - '+response[i].first_name+' '+response[i].last_name+'</a></div>'+ 
							'	<div class = "td">' + response[i].leave_type_name + '</div>' + 
							'	<div class = "td">' + response[i].start_date + '</div>' + 
							'	<div class = "td">' + response[i].end_date + '</div>' + 
							'	<div class = "td stater">' + response[i].leave_status + '</div>' + 
							'	<div class = "td text-center">' +
							'	<a href="print/hr_leaves_print.php?idd='+response[i].leave_id+'" target="_blank" title="<?=lang("print", "AAR"); ?>"><i class="fas fa-print"></i></a>'+	
							'	<a onclick="deleteRecord('+response[i].leave_id+');" title="<?=lang("Delete", "AAR"); ?>"><i style="color: red;" class="fas fa-trash-alt"></i></a>'+ button +
							'	</div>' + 
							'</div>';
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
							url      :"<?=api_root; ?>hr/employee_leaves_status.php",
							data     :{'record': recID },
							dataType :"HTML",
							type     :'POST',
							success  :function(response){
							end_loader();
							var resAr = response.split('|');
							var res = parseInt( resAr[0] );
							if( res == 1){
							$('#leave-' + recID).remove();
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
							function changeLeaveStatus( recID, state ){
							start_loader();
							$.ajax({
							url      :"<?=api_root; ?>hr/employee_leaves_status.php",
							data     :{'record': recID, 'status': state},
							dataType :"JSON",
							type     :'POST',
							success  :function(response){
							var res = response['result'];
							
							if( res == true ){
							
							var nw_stater = response['nw_stater'];
							$('#leave-' + recID + ' .stater').text( nw_stater );
							
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
							
							function activateLeave( recID ){
							var aa = confirm("This will Activate current record");
							if( aa == true ){
							changeLeaveStatus( recID, '3' );
							}
							}
							function approveLeave( recID ){
							var aa = confirm("This will Approve current record");
							if( aa == true ){
							changeLeaveStatus( recID, '1' );
							}
							}
							function denyLeave( recID ){
							var aa = confirm("This will Deny current record");
							if( aa == true ){
							changeLeaveStatus( recID, '2' );
							}
							}
							
							</script>
							
							
							
							</div>
							
							
							<div class="zero"></div>
							</div>
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							<!--    ///////////////////      add_new_leave_modal Modal START    ///////////////////            -->
							<div class="modal" id="add_new_leave_modal">
							<div class="modal-container">
							<div class="modal-header">
							<?php include("app/modal_header.php"); ?>
							</div>
							<div class="modal-body">
							
							<form 
							id="new-employee-leave-form" 
							id-modal="add_new_leave_modal" 
							class="boxes-holder" 
							api="<?=api_root; ?>hr/employee_leaves_new.php">
							
							
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
							id="new-leave_date" 
							name="leave_date" 
							req="1" 
							den="" 
							alerter="<?=lang("Please_Check_leave_date ", "AAR"); ?>" value="<?=date('Y-m-d'); ?>" disabled>
							</div>
							</div>
							
							<div class="col-25">
							<div class="form-grp">
							<label>Start Date</label>
							<input class="frmData has_date" type="text" 
							id="new-start_date" 
							name="start_date" 
							req="1" 
							den="" 
							alerter="<?=lang("Please_Check_start_date ", "AAR"); ?>">
							</div>
							</div>
							<div class="col-25">
							<div class="form-grp">
							<label>Start Time</label>
							<select class="frmData" 
							id="new-start_time" 
							name="start_time" 
							req="1" 
							den="0" 
							alerter="<?=lang("Please_Check_start_time ", "AAR"); ?>">
							<option value="0" selected>--- Please Select---</option>
							<?php
							for( $i = 0 ; $i <=24 ; $i++ ){
							$Hour = $i.':00';
							?>
							<option value="<?=$Hour; ?>"><?=$Hour; ?></option>
							<?php
							}
							?>
							</select>
							</div>
							</div>
							
							
							<div class="col-25">
							<div class="form-grp">
							<label>End Date</label>
							<input class="frmData has_date" type="text" 
							id="new-end_date" 
							name="end_date" 
							req="1" 
							den="" 
							alerter="<?=lang("Please_Check_end_date ", "AAR"); ?>">
							</div>
							</div>
							<div class="col-25">
							<div class="form-grp">
							<label>End Time</label>
							<select class="frmData" 
							id="new-end_time" 
							name="end_time" 
							req="1" 
							den="0" 
							alerter="<?=lang("Please_Check_end_time ", "AAR"); ?>">
							<option value="0" selected>--- Please Select---</option>
							<?php
							for( $i = 0 ; $i <=24 ; $i++ ){
							$Hour = $i.':00';
							?>
							<option value="<?=$Hour; ?>"><?=$Hour; ?></option>
							<?php
							}
							?>
							</select>
							</div>
							</div>
							
							<div class="col-50">
							<div class="form-grp">
							<label> Total Days</label>
							<input class="frmData" type="text" 
							id="new-total_days" 
							name="total_days" 
							req="1" 
							den="" 
							alerter="<?=lang("Please_Check_total_days ", "AAR"); ?>" readonly disabled>
							</div>
							</div>
							
							<script>
							function Ncalc_def(){
							var date1 = new Date($('#new-start_date').val());
							var date2  = new Date($('#new-end_date').val());
							
							var timeDiff = Math.abs(date2.getTime() - date1.getTime());
							var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
							
							
							if(!isNaN(diffDays)){
							if(diffDays == 0){
							$('#new-total_days').val('1');
							} else {
							$('#new-total_days').val(diffDays);
							}
							}
							}
							
							
							$('#new-start_date').on('change', function(){
							Ncalc_def();
							});
							$('#new-end_date').on('change', function(){
							Ncalc_def();
							});
							
							</script>
							
							
							<div class="col-50">
							<div class="form-grp">
							<label>Leave Type</label>
							<select class="frmData" 
							id="new-leave_type_id" 
							name="leave_type_id" 
							req="1" 
							den="0" 
							alerter="<?=lang("Please_Check_leave_type ", "AAR"); ?>">
							<option value="0" selected>--- Please Select---</option>
							<?php
							$qu_hr_employees_leave_types_sel = "SELECT * FROM  `hr_employees_leave_types`";
							$qu_hr_employees_leave_types_EXE = mysqli_query($KONN, $qu_hr_employees_leave_types_sel);
							if(mysqli_num_rows($qu_hr_employees_leave_types_EXE)){
							while($hr_employees_leave_types_REC = mysqli_fetch_assoc($qu_hr_employees_leave_types_EXE)){
							$NAMER = $hr_employees_leave_types_REC['leave_type_name'.$lang_db];
							?>
							<option value="<?=$hr_employees_leave_types_REC['leave_type_id']; ?>"><?=$NAMER; ?></option>
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
							<label>Is Deducted</label>
							<select class="frmData" 
							id="new-is_deducted" 
							name="is_deducted" 
							req="1" 
							den="" 
							alerter="<?=lang("Please_Check_is_deducted ", "AAR"); ?>">
							<option value="1"> Yes</option>
							<option value="0"> No</option>
							</select>
							</div>
							</div>
							
							
							
							
							<div class="col-50">
							<div class="form-grp">
							<label>Status</label>
							<select class="frmData" 
							id="new-leave_status" 
							name="leave_status" 
							req="1" 
							den="" 
							alerter="<?=lang("Please_Check_leave_status ", "AAR"); ?>" disabled>
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
							<button type="button" onclick="submit_form('new-employee-leave-form', 'reload_page');">
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
							
							
							function add_new_leave_modal(){
							var titler = '<?=lang("Add_New_leave", "AAR"); ?>';
							show_modal( 'add_new_leave_modal' , titler );
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
							add_new_leave_modal();
							</script>
							<?php
							}
							?>
							</body>
							</html>										
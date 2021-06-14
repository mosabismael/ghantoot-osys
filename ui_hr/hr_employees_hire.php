<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "Site Title";
	
	
	$menuId = 1;
	$subPageID = 3;
	
	$SERCHCOND = "";
	$thsSEARCH = "";
	$thsREF    = "";
	if( isset( $_GET['search'] ) ){
		$thsSEARCH = test_inputs( $_GET['search'] );
		
	}
	if( isset( $_GET['value'] ) ){
		$thsREF = test_inputs( $_GET['value'] );
		$SERCHCOND = " AND (`$thsSEARCH` = '$thsREF')";
	}
	$thsPageName    = basename($_SERVER['PHP_SELF']);
	$thsPageArr     = explode('.', $thsPageName);
	$thsPageNameREQ = $thsPageArr[0];
	
	$page = 1;
	$showPerPage = 20;
	$totPages = 0;
	$qu_COUNT_sel = "SELECT count(*) FROM  `hr_employees` WHERE ( ( `employee_type` = 'hire' ) $SERCHCOND ) ";
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
			<?php
				/*
					<div class="row">
					<?php
					$drch_name = "";
					$srch_nameCOND = "";
					if( isset( $_GET['search_name'] ) ){
					$drch_name = test_inputs( $_GET['search_name'] );
					if( $drch_name != "" ){
					$srch_nameCOND = "( (`employee_id` = '$drch_name') OR (`employee_code` = '$drch_name') OR (`first_name` LIKE '%$drch_name%' ) OR (`last_name` LIKE '%$drch_name%' ) )";
					}
					}
					
					$srch_country = 0;
					$srch_countryCOND = "";
					if( isset( $_GET['country_id'] ) ){
					$srch_country = (int) test_inputs( $_GET['country_id'] );
					if( $srch_country != 0 ){
					$srch_countryCOND = "( `nationality_id` = $srch_country )";
					}
					}
					$srch_dept = 0;
					$srch_deptCOND = "";
					if( isset( $_GET['department_id'] ) ){
					$srch_dept = (int) test_inputs( $_GET['department_id'] );
					if( $srch_dept != 0 ){
					$srch_deptCOND = "( `department_id` = $srch_dept )";
					}
					}
					
					$COND = "";
					
					if( $srch_nameCOND != '' ){
					$COND = $COND.$srch_nameCOND;
					}
					
					if( $srch_countryCOND != '' && $COND != '' ){
					$COND = $COND.' AND '.$srch_countryCOND;
					} elseif( $srch_countryCOND != '' ) {
					$COND = $srch_countryCOND;
					}
					
					if( $srch_deptCOND != '' && $COND != '' ){
					$COND = $COND.' AND '.$srch_deptCOND;
					} elseif( $srch_deptCOND != '' ) {
					$COND = $srch_deptCOND;
					}
					
					// echo $COND;
					?>
					<form class="searcher">
					<input type="text" name="search_name" value="<?=$drch_name; ?>" id="search-text" placeholder="<?=lang("Search_By_Name-code-ID", "AAR"); ?>" list="employees_list">
					
					<select name="department_id" id="search-dept">
					<option value="0" selected><?=lang("All_Departments", "AAR"); ?></option>
					<?php
					$qu_loc_areas_sel = "SELECT * FROM  `hr_departments` ";
					$qu_loc_areas_EXE = mysqli_query($KONN, $qu_loc_areas_sel);
					if(mysqli_num_rows($qu_loc_areas_EXE)){
					while($loc_areas_REC = mysqli_fetch_assoc($qu_loc_areas_EXE)){
					?>
					
					<option value="<?=$loc_areas_REC["department_id"]; ?>"><?=$loc_areas_REC["department_name".$lang_db]; ?></option>
					<?php
					}
					}
					?>
					</select>
					<script>$("#search-dept").val('<?=$srch_dept; ?>');</script>
					<select name="country_id" id="search-nat">
					<option value="0" selected><?=lang("All_Nationalities", "AAR"); ?></option>
					<?php
					$qu_loc_areas_sel = "SELECT * FROM  `gen_countries` ";
					$qu_loc_areas_EXE = mysqli_query($KONN, $qu_loc_areas_sel);
					if(mysqli_num_rows($qu_loc_areas_EXE)){
					while($loc_areas_REC = mysqli_fetch_assoc($qu_loc_areas_EXE)){
					?>
					
					<option value="<?=$loc_areas_REC["country_id"]; ?>"><?=$loc_areas_REC["country_name"]; ?></option>
					<?php
					}
					}
					?>
					</select>
					<script>$("#search-nat").val('<?=$srch_country; ?>');</script>
					<button type="submit" class="btn btn-primary" id="search-option"><?=lang("Search", "AAR"); ?></button>
					</form>
					</div>
					
					<datalist id="employees_list">
					<?php
					$qu_hr_employees_sel = "SELECT * FROM  `hr_employees` ORDER BY `first_name` ASC, `last_name` ASC";
					$qu_hr_employees_EXE = mysqli_query($KONN, $qu_hr_employees_sel);
					if(mysqli_num_rows($qu_hr_employees_EXE)){
					while($hr_employees_REC = mysqli_fetch_assoc($qu_hr_employees_EXE)){
					?>
					<option><?=$hr_employees_REC["employee_id"]; ?></option>
					<option><?=$hr_employees_REC["employee_code"]; ?></option>
					<option><?=$hr_employees_REC["first_name"]; ?></option>
					<option><?=$hr_employees_REC["last_name"]; ?></option>
					<?php
					}
					}
					?>
					</datalist>
				*/
			?>
			
			
			
			<div class="row">
				<div class="col-100">
					
					<div class="tableHolder">
						<div class="tableForm">
							<div class="tableFormGroup">
								<select id = "search_option">
									<option value = "" selected disabled> Select Column</option>
									<option value = "employee_id">Sys Id - Employee code</option>
									<option value = "first_name">Employee Name</option>
									<option value = "join_date">Join Date</option>
									<option value = "nationality_id">Nationality</option>
									<option value = "department_id">Department</option>
									<option value = "designation_id">Designation</option>
									<option value = "employee_type">Type</option>
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
									<div class="th"><?=lang("NO.", "AAR"); ?></div>
									<div class="th"><?=lang("Sys_Id - employee_code", "AAR"); ?></div>
								<div class="th"><?=lang("Name", "AAR"); ?></div>
								<div class="th"><?=lang("Join_date", "AAR"); ?></div>
								<div class="th"><?=lang("nationality", "AAR"); ?></div>
								<div class="th"><?=lang("dept", "AAR"); ?></div>
								<div class="th"><?=lang("Type", "AAR"); ?></div>
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
				'<div class = "tr" id="emp-' + response[i].employee_id + '">' + 
				'	<div class = "td">' + response[i].sNo + '</div>' + 
				'	<div class = "td">' + response[i].employee_id + ' - '+ response[i].employee_code+'</div>' + 
				'	<div class = "td cell-title"> <a href="hr_employees_profile.php?employee_id='+response[i].employee_id+'&b=<?=basename($_SERVER['PHP_SELF']); ?>" style="color:blue;">'+response[i].first_name+' '+response[i].last_name+'</a></div>' + 
				'	<div class = "td">' + response[i].join_date + '</div>' + 
				'	<div class = "td">' + response[i].country_name + '</div>' + 
				'	<div class = "td">' + response[i].department_name + ' - '+ response[i].designation_name+'</div>' + 
				'	<div class = "td">' + response[i].employee_type + '</div>' + 
				'	<div class = "td text-center"> '+
				'	<a onclick="edit_modal_employee(' + response[i].employee_id + ');" title="<?=lang("Edit_Details", "AAR"); ?>"><i class="far fa-id-card"></i></a>'+
				'	<a onclick="view_employee_creds(' + response[i].employee_id + ');" title="<?=lang("Edit_Credintials", "AAR"); ?>"><i class="far fa-credit-card"></i></a></div>'+
				'</div>';
				$('#tableBody').append( tr );
				}
				}
				
				
				</script>
				</div>
				
				
				</div>
				
				
				<div class="zero"></div>
				</div>
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				<!--    ///////////////////      add_new_employee Modal START    ///////////////////            -->
				<div class="modal" id="add_new_employee">
				<div class="modal-container">
				<div class="modal-header">
				<?php include("app/modal_header.php"); ?>
				</div>
				<div class="modal-body">
				
				
				<form 
				id="new-employee-form" 
				id-modal="add_new_employee" 
				class="boxes-holder" 
				api="<?=api_root; ?>hr/employee_new.php">
				
				
				<div class="col-100">
				<div class="form-grp">
				<label><?=lang('Employee Code', 'ARR', 1); ?></label>
				<input class="frmData" type="text" 
				id="new_emp_profile-employee_code" 
				name="employee_code" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_employee_code", "AAR"); ?>">
				</div>
				</div>
				<div class="zero"></div>
				<div class="col-25">
				<div class="form-grp">
				<label><?=lang('First Name', 'ARR', 1); ?></label>
				<input class="frmData" type="text" 
				id="new_emp_profile-first_name" 
				name="first_name" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_first_name", "AAR"); ?>">
				</div>
				</div>
				
				<div class="col-25">
				<div class="form-grp">
				<label><?=lang('Second Name', 'ARR', 1); ?></label>
				<input class="frmData" type="text" 
				id="new_emp_profile-second_name" 
				name="second_name" 
				req="0" 
				den="" 
				alerter="<?=lang("Please_Check_second_name", "AAR"); ?>">
				</div>
				</div>
				
				<div class="col-25">
				<div class="form-grp">
				<label><?=lang('Third Name', 'ARR', 1); ?></label>
				<input class="frmData" type="text" 
				id="new_emp_profile-third_name" 
				name="third_name" 
				req="0" 
				den="" 
				alerter="<?=lang("Please_Check_third_name", "AAR"); ?>">
				</div>
				</div>
				
				<div class="col-25">
				<div class="form-grp">
				<label><?=lang('Last Name', 'ARR', 1); ?></label>
				<input class="frmData" type="text" 
				id="new_emp_profile-last_name" 
				name="last_name" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_last_name", "AAR"); ?>">
				</div>
				</div>
				
				<!--div class="col-50">
				<div class="form-grp">
				<label><?=lang('Profile Pic', 'ARR', 1); ?></label>
				<input name="profile_pic" id="new_emp_profile-profile_pic" type="file" required>
				</div>
				</div-->
				
				<div class="col-33">
				<div class="form-grp">
				<label><?=lang('Dob', 'ARR', 1); ?></label>
				<input class="frmData has_date" type="text" 
				id="new_emp_profile-dob" 
				name="dob" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_dob", "AAR"); ?>">
				</div>
				</div>
				
				<div class="col-33">
				<div class="form-grp">
				<label><?=lang('Gender', 'ARR', 1); ?></label>
				<select class="frmData" 
				id="new_emp_profile-gender" 
				name="gender" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_gender", "AAR"); ?>">
				<option value="male"><?=lang('Male', 'ARR', 1); ?></option>
				<option value="female"><?=lang('Female', 'ARR', 1); ?></option>
				</select>
				</div>
				</div>
				
				<div class="col-33">
				<div class="form-grp">
				<label><?=lang('Martial Status', 'ARR', 1); ?></label>
				<select class="frmData" 
				id="new_emp_profile-martial_status" 
				name="martial_status" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_martial_status", "AAR"); ?>">
				<option value="single"><?=lang('single', 'ARR', 1); ?></option>
				<option value="married"><?=lang('married', 'ARR', 1); ?></option>
				<option value="divorced"><?=lang('divorced', 'ARR', 1); ?></option>
				<option value="widow"><?=lang('widow', 'ARR', 1); ?></option>
				</select>
				</div>
				</div>
				<div class="zero"></div>
				
				<div class="col-25">
				<div class="form-grp">
				<label><?=lang('Mobile Personal', 'ARR', 1); ?></label>
				<input class="frmData" type="text" 
				id="new_emp_profile-mobile_personal" 
				name="mobile_personal" 
				req="0" 
				den="" 
				alerter="<?=lang("Please_Check_mobile_personal", "AAR"); ?>">
				</div>
				</div>
				
				<div class="col-25">
				<div class="form-grp">
				<label><?=lang('Mobile Work', 'ARR', 1); ?></label>
				<input class="frmData" type="text" 
				id="new_emp_profile-mobile_work" 
				name="mobile_work" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_mobile_work", "AAR"); ?>">
				</div>
				</div>
				
				<div class="col-25">
				<div class="form-grp">
				<label><?=lang('Email Personal', 'ARR', 1); ?></label>
				<input class="frmData" type="email" 
				id="new_emp_profile-email_personal" 
				name="email_personal" 
				req="0" 
				den="" 
				alerter="<?=lang("Please_Check_email_personal", "AAR"); ?>">
				</div>
				</div>
				
				<div class="col-25">
				<div class="form-grp">
				<label><?=lang('Email Work', 'ARR', 1); ?></label>
				<input class="frmData" type="email" 
				id="new_emp_profile-email_work" 
				name="email_work" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_email_work", "AAR"); ?>">
				</div>
				</div>
				<div class="zero"></div>
				<div class="col-25">
				<div class="form-grp">
				<label><?=lang('Certificate', 'ARR', 1); ?></label>
				<select class="frmData" 
				id="new_emp_profile-certificate_id" 
				name="certificate_id" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_certificate_id", "AAR"); ?>">
				<option value="0" selected><?=lang("Please_Select", "غير محدد"); ?></option>
				<?php
				$qu_loc_areas_sel = "SELECT * FROM  `hr_certificates` ";
				$qu_loc_areas_EXE = mysqli_query($KONN, $qu_loc_areas_sel);
				if(mysqli_num_rows($qu_loc_areas_EXE)){
				while($loc_areas_REC = mysqli_fetch_assoc($qu_loc_areas_EXE)){
				?>
				
				<option value="<?=$loc_areas_REC["certificate_id"]; ?>"><?=$loc_areas_REC["certificate_name".$lang_db]; ?></option>
				<?php
				}
				}
				?>
				</select>
				</div>
				</div>
				
				<div class="col-25">
				<div class="form-grp">
				<label><?=lang('Graduation Date', 'ARR', 1); ?></label>
				<input class="frmData has_date" type="text" 
				id="new_emp_profile-graduation_date" 
				name="graduation_date" 
				req="0" 
				den="" 
				alerter="<?=lang("Please_Check_graduation_date", "AAR"); ?>">
				</div>
				</div>
				
				<div class="col-25">
				<div class="form-grp">
				<label><?=lang('Join Date', 'ARR', 1); ?></label>
				<input class="frmData has_date" type="text" 
				id="new_emp_profile-join_date" 
				name="join_date" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_join_date", "AAR"); ?>">
				</div>
				</div>
				
				<div class="col-25">
				<div class="form-grp">
				<label><?=lang('Nationality', 'ARR', 1); ?></label>
				<select class="frmData" 
				id="new_emp_profile-nationality_id" 
				name="nationality_id" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_nationality", "AAR"); ?>">
				<option value="0" selected><?=lang("Please_Select", "غير محدد"); ?></option>
				<?php
				$qu_loc_areas_sel = "SELECT * FROM  `gen_countries` ";
				$qu_loc_areas_EXE = mysqli_query($KONN, $qu_loc_areas_sel);
				if(mysqli_num_rows($qu_loc_areas_EXE)){
				while($loc_areas_REC = mysqli_fetch_assoc($qu_loc_areas_EXE)){
				?>
				
				<option value="<?=$loc_areas_REC["country_id"]; ?>"><?=$loc_areas_REC["country_name"]; ?></option>
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
				<label><?=lang('Leaves Total Annual', 'ARR', 1); ?></label>
				<input class="frmData" type="number" 
				id="new_emp_profile-leaves_total_annual" 
				name="leaves_total_annual" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_leaves_total_annual", "AAR"); ?>">
				</div>
				</div>
				
				<div class="col-50">
				<div class="form-grp">
				<label><?=lang('Leaves Open Balance', 'ARR', 1); ?></label>
				<input class="frmData" type="text" 
				id="new_emp_profile-leaves_open_balance" 
				name="leaves_open_balance" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_leaves_open_balance", "AAR"); ?>">
				</div>
				</div>
				<div class="zero"></div>
				
				<div class="col-25">
				<div class="form-grp">
				<label><?=lang('Basic Salary', 'ARR', 1); ?></label>
				<input class="frmData" type="text" 
				id="new_emp_profile-basic_salary" 
				name="basic_salary" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_basic_salary", "AAR"); ?>">
				</div>
				</div>
				
				<div class="col-25">
				<div class="form-grp">
				<label><?=lang('Bank', 'ARR', 1); ?></label>
				<select class="frmData" 
				id="new_emp_profile-bank_id" 
				name="bank_id" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_bank", "AAR"); ?>">
				<option value="0" selected><?=lang("Please_Select", "غير محدد"); ?></option>
				<?php
				$qu_loc_areas_sel = "SELECT * FROM  `gen_banks` ";
				$qu_loc_areas_EXE = mysqli_query($KONN, $qu_loc_areas_sel);
				if(mysqli_num_rows($qu_loc_areas_EXE)){
				while($loc_areas_REC = mysqli_fetch_assoc($qu_loc_areas_EXE)){
				?>
				
				<option value="<?=$loc_areas_REC["bank_id"]; ?>"><?=$loc_areas_REC["bank_name".$lang_db]; ?></option>
				<?php
				}
				}
				?>
				</select>
				</div>
				</div>
				
				<div class="col-25">
				<div class="form-grp">
				<label><?=lang('Bank Account No', 'ARR', 1); ?></label>
				<input class="frmData" type="text" 
				id="new_emp_profile-bank_account_no" 
				name="bank_account_no" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_bank_account_no", "AAR"); ?>">
				</div>
				</div>
				
				<div class="col-25">
				<div class="form-grp">
				<label><?=lang('Iban No', 'ARR', 1); ?></label>
				<input class="frmData" type="text" 
				id="new_emp_profile-iban_no" 
				name="iban_no" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_iban_no", "AAR"); ?>">
				</div>
				</div>
				<div class="zero"></div>
				
				<div class="col-50">
				<div class="form-grp">
				<label><?=lang('Department', 'ARR', 1); ?></label>
				<select class="frmData" 
				id="new_emp_profile-department_id" 
				name="department_id" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_department", "AAR"); ?>">
				<option value="0" selected><?=lang("Please_Select", "غير محدد"); ?></option>
				<?php
				$qu_loc_areas_sel = "SELECT * FROM  `hr_departments` ";
				$qu_loc_areas_EXE = mysqli_query($KONN, $qu_loc_areas_sel);
				if(mysqli_num_rows($qu_loc_areas_EXE)){
				while($loc_areas_REC = mysqli_fetch_assoc($qu_loc_areas_EXE)){
				?>
				
				<option value="<?=$loc_areas_REC["department_id"]; ?>"><?=$loc_areas_REC["department_name".$lang_db]; ?></option>
				<?php
				}
				}
				?>
				</select>
				</div>
				</div>
				
				<div class="col-50">
				<div class="form-grp">
				<label><?=lang('Designation', 'ARR', 1); ?></label>
				<select class="frmData" 
				id="new_emp_profile-designation_id" 
				name="designation_id" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_designation", "AAR"); ?>">
				<option value="0" selected><?=lang("Please_Select", "غير محدد"); ?></option>
				<?php
				$qu_loc_areas_sel = "SELECT * FROM  `hr_departments_designations` ";
				$qu_loc_areas_EXE = mysqli_query($KONN, $qu_loc_areas_sel);
				if(mysqli_num_rows($qu_loc_areas_EXE)){
				while($loc_areas_REC = mysqli_fetch_assoc($qu_loc_areas_EXE)){
				?>
				
				<option value="<?=$loc_areas_REC["designation_id"]; ?>"><?=$loc_areas_REC["designation_name".$lang_db]; ?></option>
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
				<label><?=lang('Employee Address', 'ARR', 1); ?></label>
				<textarea class="frmData" 
				id="new_emp_profile-employee_address" 
				name="employee_address" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_Address", "AAR"); ?>"></textarea>
				</div>
				</div>
				<div class="zero"></div>
				
				<div class="col-50">
				<div class="form-grp">
				<label><?=lang('employee_type', 'ARR', 1); ?></label>
				<select class="frmData" 
				id="new_emp_profile-employee_type" 
				name="employee_type" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_employee_type", "AAR"); ?>">
				<option value="local"><?=lang('local', 'ARR', 1); ?></option>
				<option value="hire"><?=lang('hire', 'ARR', 1); ?></option>
				</select>
				</div>
				</div>
				
				
				<div class="col-50">
				<div class="form-grp">
				<label><?=lang('company_name', 'ARR', 1); ?></label>
				<input class="frmData" type="text" 
				id="new_emp_profile-company_name" 
				name="company_name" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_company_name", "AAR"); ?>">
				</div>
				</div>
				
				
				
				<div class="zero"></div>
				<div class="form-alerts"></div>
				<div class="zero"></div>
				
				<div class="viewerBodyButtons">
				<button type="button" onclick="submit_form('new-employee-form', 'reload_page');">
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
				
				
				
				
				
				
				
				
				
				
				
				
				
				<!--    ///////////////////      view_employee_creds Modal START    ///////////////////            -->
				<div class="modal" id="view_employee_creds">
				<div class="modal-container">
				<div class="modal-header">
				<?php include("app/modal_header.php"); ?>
				</div>
				<div class="modal-body">
				
				
				<form 
				id="v-employee-creds-form" 
				id-modal="view_employee_creds" 
				class="boxes-holder" 
				api="<?=api_root; ?>hr/employee_creds_update.php">
				
				
				<div class="col-50">
				<div class="form-grp">
				<label><?=lang('Employee ID', 'ARR', 1); ?></label>
				<input class="frmData" type="text" 
				id="v_emp_creds-employee_id" 
				name="employee_id" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_employee", "AAR"); ?>" required readonly>
				</div>
				</div>
				
				<div class="col-50">
				<div class="form-grp">
				<label><?=lang('Civil Id', 'ARR', 1); ?></label>
				<input class="frmData" type="text" 
				id="v_emp_creds-civil_id" 
				name="civil_id" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_civil_id", "AAR"); ?>">
				
				</div>
				</div>
				
				
				<div class="zero"></div>
				
				<div class="col-33">
				<div class="form-grp">
				<label><?=lang('Passport Issue Date', 'ARR', 1); ?></label>
				<input class="frmData has_date" type="text" 
				id="v_emp_creds-passport_issue_date" 
				name="passport_issue_date" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_passport_issue_date", "AAR"); ?>">
				</div>
				</div>
				
				<div class="col-33">
				<div class="form-grp">
				<label><?=lang('Passport Expiry Date', 'ARR', 1); ?></label>
				<input class="frmData has_date" type="text" 
				id="v_emp_creds-passport_expiry_date" 
				name="passport_expiry_date" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_passport_expiry_date", "AAR"); ?>">
				</div>
				</div>
				
				<div class="col-33">
				<div class="form-grp">
				<label><?=lang('Passport No', 'ARR', 1); ?></label>
				<input class="frmData" type="text" 
				id="v_emp_creds-passport_no" 
				name="passport_no" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_passport_no", "AAR"); ?>">
				</div>
				</div>
				
				<div class="col-33">
				<div class="form-grp">
				<label><?=lang('Visa Issue Date', 'ARR', 1); ?></label>
				<input class="frmData has_date" type="text" 
				id="v_emp_creds-visa_issue_date" 
				name="visa_issue_date" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_visa_issue_date", "AAR"); ?>">
				</div>
				</div>
				
				<div class="col-33">
				<div class="form-grp">
				<label><?=lang('Visa Expiry Date', 'ARR', 1); ?></label>
				<input class="frmData has_date" type="text" 
				id="v_emp_creds-visa_expiry_date" 
				name="visa_expiry_date" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_visa_expiry_date", "AAR"); ?>">
				
				</div>
				</div>
				
				<div class="col-33">
				<div class="form-grp">
				<label><?=lang('Visa No', 'ARR', 1); ?></label>
				<input class="frmData" type="text" 
				id="v_emp_creds-visa_no" 
				name="visa_no" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_visa_no", "AAR"); ?>">
				
				</div>
				</div>
				
				<div class="col-25">
				<div class="form-grp">
				<label><?=lang('Eid Issue Date', 'ARR', 1); ?></label>
				<input class="frmData has_date" type="text" 
				id="v_emp_creds-eid_issue_date" 
				name="eid_issue_date" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_eid_issue_date", "AAR"); ?>">
				
				</div>
				</div>
				
				<div class="col-25">
				<div class="form-grp">
				<label><?=lang('Eid Expiry Date', 'ARR', 1); ?></label>
				<input class="frmData has_date" type="text" 
				id="v_emp_creds-eid_expiry_date" 
				name="eid_expiry_date" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_eid_expiry_date", "AAR"); ?>">
				
				</div>
				</div>
				
				<div class="col-25">
				<div class="form-grp">
				<label><?=lang('Eid No', 'ARR', 1); ?></label>
				<input class="frmData" type="text" 
				id="v_emp_creds-eid_no" 
				name="eid_no" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_eid_no", "AAR"); ?>">
				
				</div>
				</div>
				
				<div class="col-25">
				<div class="form-grp">
				<label><?=lang('Eid Card No', 'ARR', 1); ?></label>
				<input class="frmData" type="text" 
				id="v_emp_creds-eid_card_no" 
				name="eid_card_no" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_eid_card_no", "AAR"); ?>">
				
				</div>
				</div>
				
				<div class="col-33">
				<div class="form-grp">
				<label><?=lang('Labour Issue Date', 'ARR', 1); ?></label>
				<input class="frmData has_date" type="text" 
				id="v_emp_creds-labour_issue_date" 
				name="labour_issue_date" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_labour_issue_date", "AAR"); ?>">
				
				</div>
				</div>
				
				<div class="col-33">
				<div class="form-grp">
				<label><?=lang('Labour Expiry Date', 'ARR', 1); ?></label>
				<input class="frmData has_date" type="text" 
				id="v_emp_creds-labour_expiry_date" 
				name="labour_expiry_date" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_labour_expiry_date", "AAR"); ?>">
				
				</div>
				</div>
				
				<div class="col-33">
				<div class="form-grp">
				<label><?=lang('Labour No', 'ARR', 1); ?></label>
				<input class="frmData" type="text" 
				id="v_emp_creds-labour_no" 
				name="labour_no" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_labour_no", "AAR"); ?>">
				
				</div>
				</div>
				
				<div class="col-33">
				<div class="form-grp">
				<label><?=lang('Driving License Issue Date', 'ARR', 1); ?></label>
				<input class="frmData has_date" type="text" 
				id="v_emp_creds-license_issue_date" 
				name="license_issue_date" 
				req="0" 
				den="" 
				alerter="<?=lang("Please_Check_license_issue_date", "AAR"); ?>">
				
				</div>
				</div>
				
				<div class="col-33">
				<div class="form-grp">
				<label><?=lang('Driving License Expiry Date', 'ARR', 1); ?></label>
				<input class="frmData has_date" type="text" 
				id="v_emp_creds-license_expiry_date" 
				name="license_expiry_date" 
				req="0" 
				den="" 
				alerter="<?=lang("Please_Check_license_expiry_date", "AAR"); ?>">
				
				</div>
				</div>
				
				<div class="col-33">
				<div class="form-grp">
				<label><?=lang('Driving License No', 'ARR', 1); ?></label>
				<input class="frmData" type="text" 
				id="v_emp_creds-license_no" 
				name="license_no" 
				req="0" 
				den="" 
				alerter="<?=lang("Please_Check_license_no", "AAR"); ?>">
				
				</div>
				</div>
				
				
				
				<div class="form-alerts"></div>
				<div class="zero"></div>
				
				<div class="viewerBodyButtons">
				<button type="button" onclick="submit_form('v-employee-creds-form', 'reload_page');">
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
				
				
				<!--    ///////////////////      view_employee_creds Modal END    ///////////////////            -->
				
				
				
				
				
				
				
				<!--    ///////////////////      edit_modal_employee Modal START    ///////////////////            -->
				<div class="modal" id="edit_modal_employee">
				<div class="modal-container">
				<div class="modal-header">
				<?php include("app/modal_header.php"); ?>
				</div>
				<div class="modal-body">
				
				<form 
				id="edit-employee-form" 
				id-modal="edit_modal_employee" 
				class="boxes-holder" 
				api="<?=api_root; ?>hr/employee_edit.php">
				
				<input class="frmData" type="hidden" 
				id="v_emp_profile-employee_id" 
				name="employee_id" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_Employee", "AAR"); ?>">
				
				
				
				<div class="col-100">
				<div class="form-grp">
				<label><?=lang('Employee Code', 'ARR', 1); ?></label>
				<input class="frmData" type="text" 
				id="v_emp_profile-employee_code" 
				name="employee_code" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_employee_code", "AAR"); ?>">
				</div>
				</div>
				
				<div class="col-25">
				<div class="form-grp">
				<label><?=lang('First Name', 'ARR', 1); ?></label>
				<input class="frmData" type="text" 
				id="v_emp_profile-first_name" 
				name="first_name" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_first_name", "AAR"); ?>">
				</div>
				</div>
				
				<div class="col-25">
				<div class="form-grp">
				<label><?=lang('Second Name', 'ARR', 1); ?></label>
				<input class="frmData" type="text" 
				id="v_emp_profile-second_name" 
				name="second_name" 
				req="0" 
				den="" 
				alerter="<?=lang("Please_Check_second_name", "AAR"); ?>">
				</div>
				</div>
				
				<div class="col-25">
				<div class="form-grp">
				<label><?=lang('Third Name', 'ARR', 1); ?></label>
				<input class="frmData" type="text" 
				id="v_emp_profile-third_name" 
				name="third_name" 
				req="0" 
				den="" 
				alerter="<?=lang("Please_Check_third_name", "AAR"); ?>">
				</div>
				</div>
				
				<div class="col-25">
				<div class="form-grp">
				<label><?=lang('Last Name', 'ARR', 1); ?></label>
				<input class="frmData" type="text" 
				id="v_emp_profile-last_name" 
				name="last_name" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_last_name", "AAR"); ?>">
				</div>
				</div>
				
				<!--div class="col-50">
				<div class="form-grp">
				<label><?=lang('Profile Pic', 'ARR', 1); ?></label>
				<input name="profile_pic" id="v_emp_profile-profile_pic" type="file" required>
				</div>
				</div-->
				
				<div class="col-33">
				<div class="form-grp">
				<label><?=lang('Dob', 'ARR', 1); ?></label>
				<input class="frmData has_date" type="text" 
				id="v_emp_profile-dob" 
				name="dob" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_dob", "AAR"); ?>">
				</div>
				</div>
				
				<div class="col-33">
				<div class="form-grp">
				<label><?=lang('Gender', 'ARR', 1); ?></label>
				<select class="frmData" 
				id="v_emp_profile-gender" 
				name="gender" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_gender", "AAR"); ?>">
				<option value="male"><?=lang('Male', 'ARR', 1); ?></option>
				<option value="female"><?=lang('Female', 'ARR', 1); ?></option>
				</select>
				</div>
				</div>
				
				<div class="col-33">
				<div class="form-grp">
				<label><?=lang('Martial Status', 'ARR', 1); ?></label>
				<select class="frmData" 
				id="v_emp_profile-martial_status" 
				name="martial_status" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_martial_status", "AAR"); ?>">
				<option value="single"><?=lang('single', 'ARR', 1); ?></option>
				<option value="married"><?=lang('married', 'ARR', 1); ?></option>
				<option value="divorced"><?=lang('divorced', 'ARR', 1); ?></option>
				<option value="widow"><?=lang('widow', 'ARR', 1); ?></option>
				</select>
				</div>
				</div>
				<div class="zero"></div>
				
				<div class="col-25">
				<div class="form-grp">
				<label><?=lang('Mobile Personal', 'ARR', 1); ?></label>
				<input class="frmData" type="text" 
				id="v_emp_profile-mobile_personal" 
				name="mobile_personal" 
				req="0" 
				den="" 
				alerter="<?=lang("Please_Check_mobile_personal", "AAR"); ?>">
				</div>
				</div>
				
				<div class="col-25">
				<div class="form-grp">
				<label><?=lang('Mobile Work', 'ARR', 1); ?></label>
				<input class="frmData" type="text" 
				id="v_emp_profile-mobile_work" 
				name="mobile_work" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_mobile_work", "AAR"); ?>">
				</div>
				</div>
				
				<div class="col-25">
				<div class="form-grp">
				<label><?=lang('Email Personal', 'ARR', 1); ?></label>
				<input class="frmData" type="email" 
				id="v_emp_profile-email_personal" 
				name="email_personal" 
				req="0" 
				den="" 
				alerter="<?=lang("Please_Check_email_personal", "AAR"); ?>">
				</div>
				</div>
				
				<div class="col-25">
				<div class="form-grp">
				<label><?=lang('Email Work', 'ARR', 1); ?></label>
				<input class="frmData" type="email" 
				id="v_emp_profile-email_work" 
				name="email_work" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_email_work", "AAR"); ?>">
				</div>
				</div>
				
				<div class="zero"></div>
				<div class="col-50">
				<div class="form-grp">
				<label><?=lang('Certificate', 'ARR', 1); ?></label>
				<select class="frmData" 
				id="v_emp_profile-certificate_id" 
				name="certificate_id" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_certificate_id", "AAR"); ?>">
				<option value="0" selected><?=lang("Please_Select", "غير محدد"); ?></option>
				<?php
				$qu_loc_areas_sel = "SELECT * FROM  `hr_certificates` ";
				$qu_loc_areas_EXE = mysqli_query($KONN, $qu_loc_areas_sel);
				if(mysqli_num_rows($qu_loc_areas_EXE)){
				while($loc_areas_REC = mysqli_fetch_assoc($qu_loc_areas_EXE)){
				?>
				
				<option value="<?=$loc_areas_REC["certificate_id"]; ?>"><?=$loc_areas_REC["certificate_name".$lang_db]; ?></option>
				<?php
				}
				}
				?>
				</select>
				</div>
				</div>
				
				<div class="col-50">
				<div class="form-grp">
				<label><?=lang('Graduation Date', 'ARR', 1); ?></label>
				<input class="frmData has_date" type="text" 
				id="v_emp_profile-graduation_date" 
				name="graduation_date" 
				req="0" 
				den="" 
				alerter="<?=lang("Please_Check_graduation_date", "AAR"); ?>">
				</div>
				</div>
				
				<div class="col-50">
				<div class="form-grp">
				<label><?=lang('Join Date', 'ARR', 1); ?></label>
				<input class="frmData has_date" type="text" 
				id="v_emp_profile-join_date" 
				name="join_date" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_join_date", "AAR"); ?>">
				</div>
				</div>
				
				<div class="col-50">
				<div class="form-grp">
				<label><?=lang('Nationality', 'ARR', 1); ?></label>
				<select class="frmData" 
				id="v_emp_profile-nationality_id" 
				name="nationality_id" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_nationality", "AAR"); ?>">
				<option value="0" selected><?=lang("Please_Select", "غير محدد"); ?></option>
				<?php
				$qu_loc_areas_sel = "SELECT * FROM  `gen_countries` ";
				$qu_loc_areas_EXE = mysqli_query($KONN, $qu_loc_areas_sel);
				if(mysqli_num_rows($qu_loc_areas_EXE)){
				while($loc_areas_REC = mysqli_fetch_assoc($qu_loc_areas_EXE)){
				?>
				
				<option value="<?=$loc_areas_REC["country_id"]; ?>"><?=$loc_areas_REC["country_name"]; ?></option>
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
				<label><?=lang('Leaves Total Annual', 'ARR', 1); ?></label>
				<input class="frmData" type="number" 
				id="v_emp_profile-leaves_total_annual" 
				name="leaves_total_annual" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_leaves_total_annual", "AAR"); ?>">
				</div>
				</div>
				
				
				<div class="col-50">
				<div class="form-grp">
				<label><?=lang('Leaves Open Balance', 'ARR', 1); ?></label>
				<input class="frmData" type="number" 
				id="v_emp_profile-leaves_open_balance" 
				name="leaves_open_balance" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_leaves_open_balance", "AAR"); ?>">
				</div>
				</div>
				<div class="zero"></div>
				
				<div class="col-25">
				<div class="form-grp">
				<label><?=lang('Basic Salary', 'ARR', 1); ?></label>
				<input class="frmData" type="text" 
				id="v_emp_profile-basic_salary" 
				name="basic_salary" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_basic_salary", "AAR"); ?>">
				</div>
				</div>
				
				<div class="col-25">
				<div class="form-grp">
				<label><?=lang('Bank', 'ARR', 1); ?></label>
				<select class="frmData" 
				id="v_emp_profile-bank_id" 
				name="bank_id" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_bank", "AAR"); ?>">
				<option value="0" selected><?=lang("Please_Select", "غير محدد"); ?></option>
				<?php
				$qu_loc_areas_sel = "SELECT * FROM  `gen_banks` ";
				$qu_loc_areas_EXE = mysqli_query($KONN, $qu_loc_areas_sel);
				if(mysqli_num_rows($qu_loc_areas_EXE)){
				while($loc_areas_REC = mysqli_fetch_assoc($qu_loc_areas_EXE)){
				?>
				
				<option value="<?=$loc_areas_REC["bank_id"]; ?>"><?=$loc_areas_REC["bank_name".$lang_db]; ?></option>
				<?php
				}
				}
				?>
				</select>
				</div>
				</div>
				
				<div class="col-25">
				<div class="form-grp">
				<label><?=lang('Bank Account No', 'ARR', 1); ?></label>
				<input class="frmData" type="text" 
				id="v_emp_profile-bank_account_no" 
				name="bank_account_no" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_bank_account_no", "AAR"); ?>">
				</div>
				</div>
				
				<div class="col-25">
				<div class="form-grp">
				<label><?=lang('Iban No', 'ARR', 1); ?></label>
				<input class="frmData" type="text" 
				id="v_emp_profile-iban_no" 
				name="iban_no" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_iban_no", "AAR"); ?>">
				</div>
				</div>
				<div class="zero"></div>
				
				<div class="col-50">
				<div class="form-grp">
				<label><?=lang('Department', 'ARR', 1); ?></label>
				<select class="frmData" 
				id="v_emp_profile-department_id" 
				name="department_id" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_department", "AAR"); ?>">
				<option value="0" selected><?=lang("Please_Select", "غير محدد"); ?></option>
				<?php
				$qu_loc_areas_sel = "SELECT * FROM  `hr_departments` ";
				$qu_loc_areas_EXE = mysqli_query($KONN, $qu_loc_areas_sel);
				if(mysqli_num_rows($qu_loc_areas_EXE)){
				while($loc_areas_REC = mysqli_fetch_assoc($qu_loc_areas_EXE)){
				?>
				
				<option value="<?=$loc_areas_REC["department_id"]; ?>"><?=$loc_areas_REC["department_name".$lang_db]; ?></option>
				<?php
				}
				}
				?>
				</select>
				</div>
				</div>
				
				<div class="col-50">
				<div class="form-grp">
				<label><?=lang('Designation', 'ARR', 1); ?></label>
				<select class="frmData" 
				id="v_emp_profile-designation_id" 
				name="designation_id" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_designation", "AAR"); ?>">
				<option value="0" selected><?=lang("Please_Select", "غير محدد"); ?></option>
				<?php
				$qu_loc_areas_sel = "SELECT * FROM  `hr_departments_designations` ";
				$qu_loc_areas_EXE = mysqli_query($KONN, $qu_loc_areas_sel);
				if(mysqli_num_rows($qu_loc_areas_EXE)){
				while($loc_areas_REC = mysqli_fetch_assoc($qu_loc_areas_EXE)){
				?>
				
				<option value="<?=$loc_areas_REC["designation_id"]; ?>"><?=$loc_areas_REC["designation_name".$lang_db]; ?></option>
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
				<label><?=lang('Employee Address', 'ARR', 1); ?></label>
				<textarea class="frmData" 
				id="v_emp_profile-employee_address" 
				name="employee_address" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_Address", "AAR"); ?>"></textarea>
				</div>
				</div>
				
				
				
				
				<div class="col-50">
				<div class="form-grp">
				<label><?=lang('Employee_Status', 'ARR', 1); ?></label>
				<select class="frmData" 
				id="v_emp_profile-employee_status" 
				name="employee_status" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_employee_status", "AAR"); ?>">
				<option value="active"><?=lang('Active', 'ARR', 1); ?></option>
				<option value="suspended"><?=lang('Suspended', 'ARR', 1); ?></option>
				<option value="canceled"><?=lang('Canceled', 'ARR', 1); ?></option>
				</select>
				</div>
				</div>
				<div class="zero"></div>
				
				
				<div class="col-50">
				<div class="form-grp">
				<label><?=lang('employee_type', 'ARR', 1); ?></label>
				<select class="frmData" 
				id="v_emp_profile-employee_type" 
				name="employee_type" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_employee_type", "AAR"); ?>">
				<option value="local"><?=lang('local', 'ARR', 1); ?></option>
				<option value="hire"><?=lang('hire', 'ARR', 1); ?></option>
				</select>
				</div>
				</div>
				
				
				<div class="col-50">
				<div class="form-grp">
				<label><?=lang('company_name', 'ARR', 1); ?></label>
				<input class="frmData" type="text" 
				id="v_emp_profile-company_name" 
				name="company_name" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_company_name", "AAR"); ?>">
				</div>
				</div>
				
				
				
				<div class="zero"></div>
				
				
				<div class="form-alerts"></div>
				<div class="zero"></div>
				
				<div class="viewerBodyButtons">
				<button type="button" onclick="submit_form('edit-employee-form', 'reload_page');">
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
				
				
				<!--    ///////////////////      edit_modal_employee Modal END    ///////////////////            -->
				
				<script>
				function view_employee_creds( employee_id ){
				var ths_title = $('#emp-' + employee_id + ' .cell-title').text();
				var titler = '<?=lang("View Credintials Details ::", "عرض ملف ::"); ?>' + ths_title;
				show_modal( 'view_employee_creds' , titler );
				
				$.ajax({
				url      :"<?=api_root; ?>hr/get_employee_creds_id.php",
				data     :{'typo': 'pc_call', 'employee_id': employee_id},
				dataType :"JSON",
				type     :'POST',
				success  :function(response){
				
				$('#v_emp_creds-employee_id').val(response[0].employee_id);
				$('#v_emp_creds-employee_credential_id').val(response[0].employee_credential_id);
				$('#v_emp_creds-passport_issue_date').val(response[0].passport_issue_date);
				$('#v_emp_creds-passport_expiry_date').val(response[0].passport_expiry_date);
				$('#v_emp_creds-passport_no').val(response[0].passport_no);
				$('#v_emp_creds-visa_issue_date').val(response[0].visa_issue_date);
				$('#v_emp_creds-visa_expiry_date').val(response[0].visa_expiry_date);
				$('#v_emp_creds-visa_no').val(response[0].visa_no);
				$('#v_emp_creds-eid_issue_date').val(response[0].eid_issue_date);
				$('#v_emp_creds-eid_expiry_date').val(response[0].eid_expiry_date);
				$('#v_emp_creds-eid_no').val(response[0].eid_no);
				$('#v_emp_creds-eid_card_no').val(response[0].eid_card_no);
				$('#v_emp_creds-labour_issue_date').val(response[0].labour_issue_date);
				$('#v_emp_creds-labour_expiry_date').val(response[0].labour_expiry_date);
				$('#v_emp_creds-labour_no').val(response[0].labour_no);
				$('#v_emp_creds-license_issue_date').val(response[0].license_issue_date);
				$('#v_emp_creds-license_expiry_date').val(response[0].license_expiry_date);
				$('#v_emp_creds-license_no').val(response[0].license_no);
				$('#v_emp_creds-civil_id').val(response[0].civil_id);
				
				
				
				
				
				// end_loader();
				
				},
				error    :function(){
				alert('Code Not Applied');
				},
				});
				
				}
				
				
				function add_new_employee(){
				var titler = '<?=lang("Add_New_Employee", "AAR"); ?>';
				show_modal( 'add_new_employee' , titler );
				}
				
				function edit_modal_employee( employee_id ){
				var ths_title = $('#emp-' + employee_id + ' .cell-title').text();
				var titler = '<?=lang("View details ::", "عرض ملف المنشأة ::"); ?>' + ths_title;
				show_modal( 'edit_modal_employee' , titler );
				
				$.ajax({
				url      :"<?=api_root; ?>hr/get_employee_profile_id.php",
				data     :{'typo': 'pc_call', 'employee_id': employee_id},
				dataType :"JSON",
				type     :'POST',
				success  :function(response){
				
				$('#v_emp_profile-employee_id').val(response[0].employee_id);
				$('#v_emp_profile-employee_code').val(response[0].employee_code);
				$('#v_emp_profile-first_name').val(response[0].first_name);
				$('#v_emp_profile-second_name').val(response[0].second_name);
				$('#v_emp_profile-third_name').val(response[0].third_name);
				$('#v_emp_profile-last_name').val(response[0].last_name);
				$('#v_emp_profile-profile_pic').val(response[0].profile_pic);
				$('#v_emp_profile-dob').val(response[0].dob);
				$('#v_emp_profile-mobile_personal').val(response[0].mobile_personal);
				$('#v_emp_profile-mobile_work').val(response[0].mobile_work);
				$('#v_emp_profile-email_personal').val(response[0].email_personal);
				$('#v_emp_profile-email_work').val(response[0].email_work);
				$('#v_emp_profile-gender').val(response[0].gender);
				$('#v_emp_profile-martial_status').val(response[0].martial_status);
				$('#v_emp_profile-certificate_id').val(response[0].certificate_id);
				$('#v_emp_profile-graduation_date').val(response[0].graduation_date);
				$('#v_emp_profile-join_date').val(response[0].join_date);
				$('#v_emp_profile-nationality_id').val(response[0].nationality_id);
				$('#v_emp_profile-leaves_total_annual').val(response[0].leaves_total_annual);
				$('#v_emp_profile-leaves_open_balance').val(response[0].leaves_open_balance);
				$('#v_emp_profile-basic_salary').val(response[0].basic_salary);
				$('#v_emp_profile-bank_id').val(response[0].bank_id);
				$('#v_emp_profile-bank_account_no').val(response[0].bank_account_no);
				$('#v_emp_profile-iban_no').val(response[0].iban_no);
				$('#v_emp_profile-designation_id').val(response[0].designation_id);
				$('#v_emp_profile-department_id').val(response[0].department_id);
				$('#v_emp_profile-employee_address').val(response[0].employee_address);
				$('#v_emp_profile-employee_status').val(response[0].employee_status);
				
				
				$('#v_emp_profile-employee_type').val(response[0].employee_type);
				$('#v_emp_profile-company_name').val(response[0].company_name);
				
				
				
				
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
<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "Inv Coding";
	
	
	$menuId = 6;
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
								<th style="width: 5%;">
									<a onclick="add_new_modal_unit();"><button type="button" class="btn-success"><?=lang("Add_New", "AAR"); ?></button></a>
								</th>
								<th style="width: 80%;"><?=lang("Unit", "AAR"); ?></th>
								<th><?=lang("Options", "AAR"); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$sNo = 0;
								$qu_job_orders_billing_terms_recs_sel = "SELECT * FROM  `job_orders_billing_terms_recs`";
								$qu_job_orders_billing_terms_recs_EXE = mysqli_query($KONN, $qu_job_orders_billing_terms_recs_sel);
								if(mysqli_num_rows($qu_job_orders_billing_terms_recs_EXE)){
									while($job_orders_billing_terms_recs_REC = mysqli_fetch_assoc($qu_job_orders_billing_terms_recs_EXE)){
										$sNo++;
										$record_term_id = $job_orders_billing_terms_recs_REC['record_term_id'];
										$record_term = $job_orders_billing_terms_recs_REC['record_term'];
										
										
									?>
									<tr id="boxdata-<?=$record_term_id; ?>">
										<td><?=$sNo; ?></td>
										<td onclick="edit_data(<?=$record_term_id; ?>);"><span id="poREF-<?=$record_term_id; ?>" class="text-primary"><?=$record_term; ?></span></td>
										<td>
											<button type="button" style="padding: 5px;" onclick="edit_data(<?=$record_term_id; ?>);">Edit</button>
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
										
										
										
										
										<!--    ///////////////////      add_new_modal_unit Modal START    ///////////////////            -->
										<div class="modal" id="add_new_modal_unit">
										<div class="modal-container">
										<div class="modal-header">
										<?php include("app/modal_header.php"); ?>
										</div>
										<div class="modal-body">
										
										<form 
										id="add-new-unit-form" 
										id-modal="add_new_modal_unit" 
										class="boxes-holder" 
										api="<?=api_root; ?>job_orders_billing_terms_recs/add_new.php">
										
										<div class="col-50">
										<div class="form-grp">
										<label>record_term</label>
										<input class="frmData" type="text" 
										id="new-record_term" 
										name="record_term" 
										req="1" 
										den="" 
										alerter="<?=lang("Please_Check_record_term", "AAR"); ?>">
										</div>
										</div>
										
										
										<div class="zero"></div>
										
										<div class="form-alerts"></div>
										<div class="zero"></div>
										
										<div class="viewerBodyButtons">
										<button type="button" onclick="submit_form('add-new-unit-form', 'reload_page');">
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
										
										
										<!--    ///////////////////      add_new_modal_unit Modal END    ///////////////////            -->
										
										
										
										<!--    ///////////////////      edit_modal_unit Modal START    ///////////////////            -->
										<div class="modal" id="edit_modal_unit">
										<div class="modal-container">
										<div class="modal-header">
										<?php include("app/modal_header.php"); ?>
										</div>
										<div class="modal-body">
										
										<form 
										id="edit-unit-form" 
										id-modal="edit_modal_unit" 
										class="boxes-holder" 
										api="<?=api_root; ?>job_orders_billing_terms_recs/edit_data.php">
										
										
										<input class="frmData" type="hidden" 
										id="edit-record_term_id" 
										name="record_term_id" 
										value="0" 
										req="1" 
										den="0" 
										alerter="<?=lang("Please_Check_unit", "AAR"); ?>">
										
										
										<div class="col-50">
										<div class="form-grp">
										<label>record_term</label>
										<input class="frmData" type="text" 
										id="edit-record_term" 
										name="record_term" 
										req="1" 
										den="" 
										alerter="<?=lang("Please_Check_record_term", "AAR"); ?>">
										</div>
										</div>
										
										<div class="zero"></div>
										
										
										<div class="form-alerts"></div>
										<div class="zero"></div>
										
										<div class="viewerBodyButtons">
										<button type="button" onclick="submit_form('edit-unit-form', 'reload_page');">
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
										<!--    ///////////////////      edit_modal_unit Modal END    ///////////////////            -->
										
										<script>
										function edit_data( ids_id ){
										var titler = '<?=lang("Edit", "AAR"); ?>' + ' :: ';
										
										titler = titler + $('#boxdata-' + ids_id + ' .cell-title').text();
										
										$.ajax({
										url      :"<?=api_root; ?>job_orders_billing_terms_recs/get_data.php",
										data     :{'typo': 'pc_call', 'ids_id': ids_id},
										dataType :"JSON",
										type     :'POST',
										success  :function(response){
										
										$('#edit-record_term_id').val(response[0].record_term_id);
										$('#edit-record_term').val(response[0].record_term);
										
										
										
										
										show_modal( 'edit_modal_unit' , titler );
										
										// end_loader();
										
										},
										error    :function(){
										alert('Code Not Applied');
										},
										});
										}
										
										function add_new_modal_unit(){
										var titler = '<?=lang("Add_New_Entry", "AAR"); ?>';
										show_modal( 'add_new_modal_unit' , titler );
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
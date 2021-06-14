<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "Inv Coding";
	
	
	$menuId = 5;
	$subPageID = 15;
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
									<a onclick="add_new_modal_lim_itm();"><button type="button" class="btn-success"><?=lang("Add_New", "AAR"); ?></button></a>
								</th>
								<th style="width: 80%;"><?=lang("Item", "AAR"); ?></th>
								<th><?=lang("Options", "AAR"); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$sNo = 0;
								$qu_purchase_orders_items_limited_list_sel = "SELECT * FROM  `purchase_orders_items_limited_list`";
								$qu_purchase_orders_items_limited_list_EXE = mysqli_query($KONN, $qu_purchase_orders_items_limited_list_sel);
								if(mysqli_num_rows($qu_purchase_orders_items_limited_list_EXE)){
									while($purchase_orders_items_limited_list_REC = mysqli_fetch_assoc($qu_purchase_orders_items_limited_list_EXE)){
										$sNo++;
										$limited_id = $purchase_orders_items_limited_list_REC['limited_id'];
										$limited_text = $purchase_orders_items_limited_list_REC['limited_text'];
										
										
									?>
									<tr id="boxdata-<?=$limited_id; ?>">
										<td><?=$sNo; ?></td>
										<td><span id="poREF-<?=$limited_id; ?>" class="text-primary"><?=$limited_text; ?></span></td>
										<td>
											<button type="button" style="padding: 5px;" onclick="edit_data(<?=$limited_id; ?>);">Edit</button>
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
										
										
										
										
										<!--    ///////////////////      add_new_modal_lim_itm Modal START    ///////////////////            -->
										<div class="modal" id="add_new_modal_lim_itm">
										<div class="modal-container">
										<div class="modal-header">
										<?php include("app/modal_header.php"); ?>
										</div>
										<div class="modal-body">
										
										<form 
										id="add-new-lim_itm-form" 
										id-modal="add_new_modal_lim_itm" 
										class="boxes-holder" 
										api="<?=api_root; ?>purchase_orders_items_limited_list/add_new.php">
										
										<div class="col-100">
										<div class="form-grp">
										<label>Text</label>
										<textarea class="frmData" 
										id="new-limited_text" 
										name="limited_text" 
										rows="8" 
										req="1" 
										den="" 
										alerter="<?=lang("Please_Check_text", "AAR"); ?>"></textarea>
										</div>
										</div>
										
										
										<div class="zero"></div>
										
										<div class="form-alerts"></div>
										<div class="zero"></div>
										
										<div class="viewerBodyButtons">
										<button type="button" onclick="submit_form('add-new-lim_itm-form', 'reload_page');">
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
										
										
										<!--    ///////////////////      add_new_modal_lim_itm Modal END    ///////////////////            -->
										
										
										
										<!--    ///////////////////      edit_modal_lim_itm Modal START    ///////////////////            -->
										<div class="modal" id="edit_modal_lim_itm">
										<div class="modal-container">
										<div class="modal-header">
										<?php include("app/modal_header.php"); ?>
										</div>
										<div class="modal-body">
										
										<form 
										id="edit-lim_itm-form" 
										id-modal="edit_modal_lim_itm" 
										class="boxes-holder" 
										api="<?=api_root; ?>purchase_orders_items_limited_list/edit_data.php">
										
										
										<input class="frmData" type="hidden" 
										id="edit-limited_id" 
										name="limited_id" 
										value="0" 
										req="1" 
										den="0" 
										alerter="<?=lang("Please_Check_lim_itm", "AAR"); ?>">
										
										
										<div class="col-100">
										<div class="form-grp">
										<label>limited_text</label>
										<textarea class="frmData" 
										id="edit-limited_text" 
										name="limited_text" 
										rows="8" 
										req="1" 
										den="" 
										alerter="<?=lang("Please_Check_text", "AAR"); ?>"></textarea>
										</div>
										</div>
										
										<div class="zero"></div>
										
										
										<div class="form-alerts"></div>
										<div class="zero"></div>
										
										<div class="viewerBodyButtons">
										<button type="button" onclick="submit_form('edit-lim_itm-form', 'reload_page');">
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
										<!--    ///////////////////      edit_modal_lim_itm Modal END    ///////////////////            -->
										
										<script>
										function del_data( ids_id ){
										var aa = confirm("Are you sure, action cannot be undone ?");
										if( aa == true ){
										alert("Item Assigned with items, cannot be deleted !");
										/*
										$.ajax({
										url      :"<?=api_root; ?>purchase_orders_items_limited_list/rem_data.php",
										data     :{'typo': 'pc_call', 'limited_id': ids_id},
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
										url      :"<?=api_root; ?>purchase_orders_items_limited_list/get_data.php",
										data     :{'typo': 'pc_call', 'ids_id': ids_id},
										dataType :"JSON",
										type     :'POST',
										success  :function(response){
										
										$('#edit-limited_id').val(response[0].limited_id);
										$('#edit-limited_text').val(response[0].limited_text);
										
										
										
										
										show_modal( 'edit_modal_lim_itm' , titler );
										
										// end_loader();
										
										},
										error    :function(){
										alert('Code Not Applied');
										},
										});
										}
										
										function add_new_modal_lim_itm(){
										var titler = '<?=lang("Add_New_Entry", "AAR"); ?>';
										show_modal( 'add_new_modal_lim_itm' , titler );
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
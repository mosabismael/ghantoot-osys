<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "Inv Coding";
	
	$menuId = 9;
	$subPageID = 20;
	
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
								<option value = "1">Tree</option>
								<option value = "2">Options</option>
								
							</select>
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
								<th style="width: 50%;"><?=lang("Tree", "AAR"); ?></th>
								<th><?=lang("Options", "AAR"); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$sNo = 0;
								$qu_acc_biling_tree_sel = "SELECT * FROM  `acc_biling_tree`";
								$qu_acc_biling_tree_EXE = mysqli_query($KONN, $qu_acc_biling_tree_sel);
								if(mysqli_num_rows($qu_acc_biling_tree_EXE)){
									while($acc_biling_tree_REC = mysqli_fetch_assoc($qu_acc_biling_tree_EXE)){
										$sNo++;
										$tree_id   = ( int ) $acc_biling_tree_REC['tree_id'];
										$tree_name = $acc_biling_tree_REC['tree_name'];
										$tree_cats = $acc_biling_tree_REC['tree_cats'];
										
										
									?>
									<tr id="boxdata-<?=$tree_id; ?>">
									<td><?=$sNo; ?></td>
									<td onclick="edit_data(<?=$tree_id; ?>);"><span id="poREF-<?=$tree_id; ?>" class="text-primary"><?=$tree_name; ?></span></td>
									<td><?=$tree_cats; ?></td>
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
									api="<?=api_root; ?>acc_biling_tree/add_new.php">
									
									<div class="col-50">
									<div class="form-grp">
									<label><?=lang('tree_name', 'ARR', 1); ?></label>
									<input class="frmData" type="text" 
									id="new-tree_name" 
									name="tree_name" 
									req="1" 
									den="" 
									alerter="<?=lang("Please_Check_tree_name", "AAR"); ?>">
									</div>
									</div>
									<div class="col-50">
									<div class="form-grp">
									<label><?=lang('Options', 'ARR', 1); ?></label>
									<textarea class="frmData" type="text" 
									id="new-tree_cats" 
									name="tree_cats" 
									req="1" 
									placeholder="<?=lang('Sepearate_each_item_with_dash(-) EX : Design-Supply', 'ARR', 1); ?>" 
									rows="8"
									den="" 
									alerter="<?=lang("Please_Check_tree_cats", "AAR"); ?>"></textarea>
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
									api="<?=api_root; ?>acc_biling_tree/edit_data.php">
									
									
									<input class="frmData" type="hidden" 
									id="edit-tree_id" 
									name="tree_id" 
									value="0" 
									req="1" 
									den="0" 
									alerter="<?=lang("Please_Check_unit", "AAR"); ?>">
									
									
									<div class="col-50">
									<div class="form-grp">
									<label>tree_name</label>
									<input class="frmData" type="text" 
									id="edit-tree_name" 
									name="tree_name" 
									req="1" 
									den="" 
									alerter="<?=lang("Please_Check_tree_name", "AAR"); ?>">
									</div>
									</div>
									<div class="col-50">
									<div class="form-grp">
									<label><?=lang('Options', 'ARR', 1); ?></label>
									<textarea class="frmData" type="text" 
									id="edit-tree_cats" 
									name="tree_cats" 
									req="1" 
									placeholder="<?=lang('Sepearate_each_item_with_dash(-) EX : Design-Supply', 'ARR', 1); ?>" 
									rows="8"
									den="" 
									alerter="<?=lang("Please_Check_tree_cats", "AAR"); ?>"></textarea>
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
									function del_data( ids_id ){
									var aa = confirm("Are you sure, action cannot be undone ?");
									if( aa == true ){
									alert("Tree Assigned with items, cannot be deleted !");
									/*
									$.ajax({
									url      :"<?=api_root; ?>acc_biling_tree/rem_data.php",
									data     :{'typo': 'pc_call', 'tree_id': ids_id},
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
									ids_id = parseInt( ids_id );
									if( ids_id != 1 ){
									$.ajax({
									url      :"<?=api_root; ?>acc_biling_tree/get_data.php",
									data     :{'typo': 'pc_call', 'ids_id': ids_id},
									dataType :"JSON",
									type     :'POST',
									success  :function(response){
									
									$('#edit-tree_id').val(response[0].tree_id);
									$('#edit-tree_name').val(response[0].tree_name);
									$('#edit-tree_cats').val(response[0].tree_cats);
									
									
									
									
									show_modal( 'edit_modal_unit' , titler );
									
									// end_loader();
									
									},
									error    :function(){
									alert('Code Not Applied');
									},
									});
									}
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
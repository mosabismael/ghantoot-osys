<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 6;
	$subPageID = 17;
?>
<!DOCTYPE html>
<html dir="<?=$lang_dir; ?>" lang="<?=$lang; ?>">
	<head>
		<?php include('app/meta.php'); ?>
		<?php include('app/assets.php'); ?>
	</head>
	<body>
		<?php
			
			$WHERE = "inv_assets_cats";
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
				
				<table class="tabler" border="2" id = "dataTable">
					<thead>
						<tr>
							<th>
								<a style="color: red;cursor:pointer;" onclick="show_details( 'newAssetDetails', 'Add New Asset' );">
									<span><?=lang("Add_New", "AAR"); ?></span>
								</a>
							</th>
							<th><?=lang("Name", "AAR"); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php
							$sNo = 0;
							$qu_inv_assets_cats_sel = "SELECT * FROM  `inv_assets_cats` ORDER BY `asset_cat_id` DESC";
							$qu_inv_assets_cats_EXE = mysqli_query($KONN, $qu_inv_assets_cats_sel);
							if(mysqli_num_rows($qu_inv_assets_cats_EXE)){
								while($inv_assets_cats_REC = mysqli_fetch_assoc($qu_inv_assets_cats_EXE)){
									$sNo++;
									
									$asset_cat_id = $inv_assets_cats_REC['asset_cat_id'];
									$asset_cat_name = $inv_assets_cats_REC['asset_cat_name'];
									
									
									
								?>
								<tr>
									<td><?=$sNo; ?></td>
									<td onclick="edit_data(<?=$asset_cat_id; ?>);"><span class="text-primary" id="shelf-<?=$asset_cat_id; ?>"><?=$asset_cat_name; ?></span></td>
								</tr>
								<?php
								}
							}
						?>
					</tbody>
				</table>
			</div>
			<div class="zero"></div>
		</div>
		
		
		
		
		
		<?php
		//PAGE DATA END   ----------------------------------------------///---------------------------------
		include('app/footer.php');
		?>
		
		
		
		
		
		
		
		
		<!--    ///////////////////      add_new_modal Modal START    ///////////////////            -->
		<div class="DetailsViewer ViewerOnTop" id="newAssetDetails">
		<div class="viewerContainer">
		<div class="viewerHeader">
		<img src="<?=uploads_root; ?>/logo_icon.png" />
		<h1>REFREFREF</h1>
		<i onclick="hide_details('newAssetDetails');" class="fas fa-times"></i>
		</div>
		<div class="viewerBody">
		
		<form 
		id="add-new-item-form" 
		id-modal="add_new_modal" 
		id-details="newAssetDetails" 
		api="<?=api_root; ?>inv_assets_cats/add_new.php">
		
		
		
		
		
		<div class="col-50">
		<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('Name', 'ARR', 1); ?></label>
		<input class="frmData" type="text" 
		id="new-asset_cat_name" 
		name="asset_cat_name" 
		req="1" 
		den="" 
		alerter="<?=lang("Please_Check_asset_cat_name", "AAR"); ?>">
		</div>
		</div>
		
		
		
		
		
		
		<div class="zero"></div>
		<br><br><br>
		<div class="form-alerts"></div>
		<div class="zero"></div>
		<div class="col-100">
		<div class="viewerBodyButtons text-center">
		<button type="button" onclick="submit_form('add-new-item-form', 'reload_page');">
		<?=lang('Save', 'ARR', 1); ?>
		</button>
		<button type="button" onclick="hide_details('newAssetDetails');">
		<?=lang("Cancel", "AAR"); ?>
		</button>
		
		</div>
		</div>
		
		<div class="zero"></div>
		</form>
		
		
		</div>
		<div class="zero"></div>
		</div>
		
		
		
		
		</div>
		</div>
		</div>
		<!--    ///////////////////      add_new_modal Modal END    ///////////////////            -->
		
		
		
		
		
		
		
		
		
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
		api="<?=api_root; ?>inv_assets_cats/edit_data.php">
		
		
		<input class="frmData" type="hidden" 
		id="edit-asset_cat_id" 
		name="asset_cat_id" 
		value="0" 
		req="1" 
		den="0" 
		alerter="<?=lang("Please_Check_asset_cat_id", "AAR"); ?>">
		
		
		
		
		
		<div class="col-50">
		<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('Name', 'ARR', 1); ?></label>
		<input class="frmData" type="text" 
		id="edit-asset_cat_name" 
		name="asset_cat_name" 
		req="1" 
		den="" 
		alerter="<?=lang("Please_Check_asset_cat_name", "AAR"); ?>">
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
		<!--    ///////////////////      edit_modal_unit Modal END    ///////////////////   --> 
		
		
		
		
		
		
		
		
		
		
		
		
		
		<script>
		function edit_data( ids_id ){
		var titler = '<?=lang("Edit", "AAR"); ?>' + ' :: ';
		
		titler = titler + $('#shelf-' + ids_id).text();
		
		$.ajax({
		url      :"<?=api_root; ?>inv_assets_cats/get_data.php",
		data     :{'typo': 'pc_call', 'ids_id': ids_id},
		dataType :"JSON",
		type     :'POST',
		success  :function(response){
		
		$('#edit-asset_cat_id').val(response[0].asset_cat_id);
		$('#edit-asset_cat_name').val(response[0].asset_cat_name);
		
		
		
		show_modal( 'edit_modal_unit' , titler );
		
		// end_loader();
		
		},
		error    :function(){
		alert('Code Not Applied');
		},
		});
		}
		
		
		init_nwFormGroup();
		</script>
		
		</body>
		</html>		
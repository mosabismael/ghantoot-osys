<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 4;
	$subPageID = 11;
	
	
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
	$qu_pur_requisitions_sel = "SELECT count(*) FROM  `inv_assets`";
	$qu_pur_requisitions_EXE = mysqli_query($KONN, $qu_pur_requisitions_sel);
	if(mysqli_num_rows($qu_pur_requisitions_EXE)){
		$pur_requisitions_DATA = mysqli_fetch_array($qu_pur_requisitions_EXE);
		$totPages = ( int ) $pur_requisitions_DATA[0];
	}
	$totPages = ceil($totPages / $showPerPage);
?>
<!DOCTYPE html>
<html dir="<?=$lang_dir; ?>" lang="<?=$lang; ?>">
	<head>
		<?php include('app/meta.php'); ?>
		<?php include('app/assets.php'); ?>
	</head>
	<body>
		<?php
			
			$WHERE = "inv_assets";
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
								<option value = "asset_name">Name</option>
								<option value = "asset_sno">S.NO</option>
								<option value = "asset_brand">Brand</option>
								<option value = "asset_cat_id">Category</option>
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
							<div class = "th">
								<a style="color: red;cursor:pointer;" onclick="show_details( 'newAssetDetails', 'Add New Asset' );">
								<span><?=lang("Add_New", "AAR"); ?></span></a></div>
								<div class="th"><?=lang("Name", "AAR"); ?></div>
								<div class="th"><?=lang("S.NO.", "AAR"); ?></div>
								<div class="th"><?=lang("Brand", "AAR"); ?></div>
								<div class="th"><?=lang("Category", "AAR"); ?></div>
								<div class="th"><?=lang("Status", "AAR"); ?></div>
								<div class="th"><?=lang("Options", "AAR"); ?></div>
						</div>
					</div>
					<div class="tableBody" id="tableBody"></div>
				</div>
				<div class="tablePagination">
					<div class="pageNum arrowPager" id="prePatchBtn" onclick="showPrePageBatch('ui_inventory/<?=basename($_SERVER['PHP_SELF']); ?>', <?=$showPerPage; ?>, <?=$totPages; ?>);"><i class="fas fa-angle-double-left"></i></div>
					<?php
						for( $i=$page ; $i<$page+10 ; $i++ ){
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
							<div onclick="loadTableData( <?=$i; ?>, <?=$showPerPage; ?>, 'ui_inventory/<?=basename($_SERVER['PHP_SELF']); ?>' );" class="pageNum imVarPager pn-<?=$i; ?> <?=$CLS; ?>"><?=$iView; ?></div>
							<?php
							}
							}
							?>
							<div id="addPagerPoint"></div>
							<div class="pageNum arrowPager" id="nextPatchBtn" onclick="showNextPageBatch('ui_inventory/<?=basename($_SERVER['PHP_SELF']); ?>', <?=$showPerPage; ?>, <?=$totPages; ?>);"><i class="fas fa-angle-double-right"></i></div>
							</div>
							<script>
							var thsPage = 'ui_inventory/<?=basename($_SERVER['PHP_SELF']); ?>';
							function bindData( response ){
							$('#tableBody').html('');
							var cc = 0;
							for( i=0 ; i < response.length ; i ++ ){
							cc++;
							var req_item_id = parseInt( response[i].req_item_id );
							
							var tr = '' + 
							'<div class = "tr">' + 
							'	<div class = "td">' + response[i].sno + '</div>' + 
							'	<div class = "td" onclick="edit_data(' + response[i].asset_id +');"><span class="text-primary cursor" id="shelf-'+response[i].asset_id+'">' + response[i].asset_name + '</span></div>' + 
							'	<div class = "td">' + response[i].asset_sno + '</div>' + 
							'	<div class = "td">' + response[i].asset_brand + '</div>' + 
							'	<div class = "td">' + response[i].asset_cat_name + '</div>' + 
							'	<div class = "td">' + response[i].asset_status + '</div>' + 
							'	<div class = "td"><a href="assets_list_attachments.php?asset_id='+response[i].asset_id+'"><button type="button">Attachments</button></a></div>' + 
							'</div>';
							$('#tableBody').append( tr );
							
							}
							}
							
							/*
							
							*/
							
							</script>
							</div>
							
							
							
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
							api="<?=api_root; ?>inv_assets/add_new.php">
							
							
							
							
							
							<div class="col-50">
							<div class="nwFormGroup">
							<label class="lbl_class"><?=lang('Tag', 'ARR', 1); ?></label>
							<input class="frmData" type="text" 
							id="new-asset_tag" 
							name="asset_tag" 
							req="1" 
							den="" 
							alerter="<?=lang("Please_Check_asset_name", "AAR"); ?>">
							</div>
							</div>
							
							<div class="col-50">
							<div class="nwFormGroup">
							<label class="lbl_class"><?=lang('Name', 'ARR', 1); ?></label>
							<input class="frmData" type="text" 
							id="new-asset_name" 
							name="asset_name" 
							req="1" 
							den="" 
							alerter="<?=lang("Please_Check_asset_name", "AAR"); ?>">
							</div>
							</div>
							
							<div class="col-50">
							<div class="nwFormGroup">
							<label class="lbl_class"><?=lang('S.NO.', 'ARR', 1); ?></label>
							<input class="frmData" type="text" 
							id="new-asset_sno" 
							name="asset_sno" 
							req="1" 
							den="" 
							alerter="<?=lang("Please_Check_SNO", "AAR"); ?>">
							</div>
							</div>
							
							<div class="col-50">
							<div class="nwFormGroup">
							<label class="lbl_class"><?=lang('Brand', 'ARR', 1); ?></label>
							<input class="frmData" type="text" 
							id="new-asset_brand" 
							name="asset_brand" 
							req="1" 
							den="" 
							alerter="<?=lang("Please_Check_brand", "AAR"); ?>">
							</div>
							</div>
							
							<div class="col-50">
							<div class="nwFormGroup">
							<label class="lbl_class"><?=lang('Expiry_Date', 'ARR', 1); ?></label>
							<input class="frmData has_date" type="text" 
							id="new-expiry_date" 
							name="expiry_date" 
							req="1" 
							den="" 
							alerter="<?=lang("Please_Check_expiry_date", "AAR"); ?>">
							</div>
							</div>
							
							<div class="col-50">
							<div class="nwFormGroup">
							<label class="lbl_class"><?=lang('PO_ref', 'ARR', 1); ?></label>
							<select class="frmData" id="new-asset_po" name="asset_po" required>
							<option value="0" selected><?=lang("Not_Applicable", "غير محدد"); ?></option>
							<?php
							$sNo = 0;
							$qu_purchase_orders_sel = "SELECT `po_id`, `po_ref` FROM  `purchase_orders` ORDER BY `po_id` DESC";
							$qu_purchase_orders_EXE = mysqli_query($KONN, $qu_purchase_orders_sel);
							if( mysqli_num_rows($qu_purchase_orders_EXE) > 0 ){
							while($purchase_orders_REC = mysqli_fetch_assoc($qu_purchase_orders_EXE)){
							$po_idT  = ( int ) $purchase_orders_REC['po_id'];
							$po_refT = $purchase_orders_REC['po_ref'];
							
							?>
							<option value="<?=$po_idT; ?>"><?=$po_refT; ?></option>
							<?php
							}
							}
							?>
							</select>
							</div>
							</div>
							
							
							<div class="col-50">
							<div class="nwFormGroup">
							<label class="lbl_class"><?=lang('Category', 'ARR', 1); ?></label>
							<select class="frmData" 
							id="new-asset_cat_id" 
							name="asset_cat_id" 
							req="1" 
							den="0" 
							alerter="<?=lang("Please_Check_Asset", "AAR"); ?>">
							<option value="0" selected>--- Please Select---</option>
							<?php
							$qu_inv_assets_cats_sel = "SELECT `asset_cat_id`, `asset_cat_name` FROM  `inv_assets_cats` ORDER BY `asset_cat_name` ASC";
							$qu_inv_assets_cats_EXE = mysqli_query($KONN, $qu_inv_assets_cats_sel);
							if(mysqli_num_rows($qu_inv_assets_cats_EXE)){
							while($inv_assets_cats_REC = mysqli_fetch_array($qu_inv_assets_cats_EXE)){
							
							?>
							<option value="<?=$inv_assets_cats_REC[0]; ?>"><?=$inv_assets_cats_REC[1]; ?></option>
							<?php
							}
							}
							?>
							</select>
							</div>
							</div>
							
							<div class="col-50">
							<div class="nwFormGroup">
							<label class="lbl_class"><?=lang('Certificate', 'ARR', 1); ?></label>
							<select class="frmData" 
							id="new-asset_certificate" 
							name="asset_certificate" 
							req="1" 
							den="" 
							alerter="<?=lang("Please_Check_Asset", "AAR"); ?>">
							<option value="1">applicable</option>
							<option value="0" selected>not applicable</option>
							</select>
							</div>
							</div>
							
							<div class="col-50">
							<div class="nwFormGroup">
							<label class="lbl_class"><?=lang('Status', 'ARR', 1); ?></label>
							<select class="frmData" 
							id="new-asset_status" 
							name="asset_status" 
							req="1" 
							den="0" 
							alerter="<?=lang("Please_Check_Asset", "AAR"); ?>">
							<option value="operational" selected>Operational</option>
							<option value="under_maintenance">Under Maintenance</option>
							<option value="damaged">Damaged</option>
							</select>
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
							api="<?=api_root; ?>inv_assets/edit_data.php">
							
							
							<input class="frmData" type="hidden" 
							id="edit-asset_id" 
							name="asset_id" 
							value="0" 
							req="1" 
							den="0" 
							alerter="<?=lang("Please_Check_asset_id", "AAR"); ?>">
							
							
							
							
							
							
							<div class="col-50">
							<div class="nwFormGroup">
							<label class="lbl_class"><?=lang('Tag', 'ARR', 1); ?></label>
							<input class="frmData" type="text" 
							id="edit-asset_tag" 
							name="asset_tag" 
							req="1" 
							den="" 
							alerter="<?=lang("Please_Check_asset_name", "AAR"); ?>">
							</div>
							</div>
							
							<div class="col-50">
							<div class="nwFormGroup">
							<label class="lbl_class"><?=lang('Name', 'ARR', 1); ?></label>
							<input class="frmData" type="text" 
							id="edit-asset_name" 
							name="asset_name" 
							req="1" 
							den="" 
							alerter="<?=lang("Please_Check_asset_name", "AAR"); ?>">
							</div>
							</div>
							
							<div class="col-50">
							<div class="nwFormGroup">
							<label class="lbl_class"><?=lang('S.NO.', 'ARR', 1); ?></label>
							<input class="frmData" type="text" 
							id="edit-asset_sno" 
							name="asset_sno" 
							req="1" 
							den="" 
							alerter="<?=lang("Please_Check_SNO", "AAR"); ?>">
							</div>
							</div>
							
							<div class="col-50">
							<div class="nwFormGroup">
							<label class="lbl_class"><?=lang('Brand', 'ARR', 1); ?></label>
							<input class="frmData" type="text" 
							id="edit-asset_brand" 
							name="asset_brand" 
							req="1" 
							den="" 
							alerter="<?=lang("Please_Check_brand", "AAR"); ?>">
							</div>
							</div>
							
							<div class="col-50">
							<div class="nwFormGroup">
							<label class="lbl_class"><?=lang('Expiry_Date', 'ARR', 1); ?></label>
							<input class="frmData has_date" type="text" 
							id="edit-expiry_date" 
							name="expiry_date" 
							req="1" 
							den="" 
							alerter="<?=lang("Please_Check_expiry_date", "AAR"); ?>">
							</div>
							</div>
							
							<div class="col-50">
							<div class="nwFormGroup">
							<label class="lbl_class"><?=lang('PO_ref', 'ARR', 1); ?></label>
							<select class="frmData" id="edit-asset_po" name="asset_po" required>
							<option value="0" selected><?=lang("Not_Applicable", "غير محدد"); ?></option>
							<?php
							$sNo = 0;
							$qu_purchase_orders_sel = "SELECT `po_id`, `po_ref` FROM  `purchase_orders` ORDER BY `po_id` DESC";
							$qu_purchase_orders_EXE = mysqli_query($KONN, $qu_purchase_orders_sel);
							if( mysqli_num_rows($qu_purchase_orders_EXE) > 0 ){
							while($purchase_orders_REC = mysqli_fetch_assoc($qu_purchase_orders_EXE)){
							$po_idT  = ( int ) $purchase_orders_REC['po_id'];
							$po_refT = $purchase_orders_REC['po_ref'];
							
							?>
							<option value="<?=$po_idT; ?>"><?=$po_refT; ?></option>
							<?php
							}
							}
							?>
							</select>
							</div>
							</div>
							
							
							<div class="col-50">
							<div class="nwFormGroup">
							<label class="lbl_class"><?=lang('Category', 'ARR', 1); ?></label>
							<select class="frmData" 
							id="edit-asset_cat_id" 
							name="asset_cat_id" 
							req="1" 
							den="0" 
							alerter="<?=lang("Please_Check_Asset", "AAR"); ?>">
							<option value="0" selected>--- Please Select---</option>
							<?php
							$qu_inv_assets_cats_sel = "SELECT `asset_cat_id`, `asset_cat_name` FROM  `inv_assets_cats` ORDER BY `asset_cat_name` ASC";
							$qu_inv_assets_cats_EXE = mysqli_query($KONN, $qu_inv_assets_cats_sel);
							if(mysqli_num_rows($qu_inv_assets_cats_EXE)){
							while($inv_assets_cats_REC = mysqli_fetch_array($qu_inv_assets_cats_EXE)){
							
							?>
							<option value="<?=$inv_assets_cats_REC[0]; ?>"><?=$inv_assets_cats_REC[1]; ?></option>
							<?php
							}
							}
							?>
							</select>
							</div>
							</div>
							
							<div class="col-50">
							<div class="nwFormGroup">
							<label class="lbl_class"><?=lang('Certificate', 'ARR', 1); ?></label>
							<select class="frmData" 
							id="edit-asset_certificate" 
							name="asset_certificate" 
							req="1" 
							den="" 
							alerter="<?=lang("Please_Check_Asset", "AAR"); ?>">
							<option value="1">applicable</option>
							<option value="0" selected>not applicable</option>
							</select>
							</div>
							</div>
							
							<div class="col-50">
							<div class="nwFormGroup">
							<label class="lbl_class"><?=lang('Status', 'ARR', 1); ?></label>
							<select class="frmData" 
							id="edit-asset_status" 
							name="asset_status" 
							req="1" 
							den="0" 
							alerter="<?=lang("Please_Check_Asset", "AAR"); ?>">
							<option value="operational" selected>Operational</option>
							<option value="under_maintenance">Under Maintenance</option>
							<option value="damaged">Damaged</option>
							</select>
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
							url      :"<?=api_root; ?>inv_assets/get_data.php",
							data     :{'typo': 'pc_call', 'ids_id': ids_id},
							dataType :"JSON",
							type     :'POST',
							success  :function(response){
							
							$('#edit-asset_id').val(response[0].asset_id);
							$('#edit-asset_name').val(response[0].asset_name);
							$('#edit-asset_sno').val(response[0].asset_sno);
							$('#edit-asset_brand').val(response[0].asset_brand);
							$('#edit-expiry_date').val(response[0].expiry_date);
							$('#edit-asset_po').val(response[0].asset_po);
							$('#edit-asset_cat_id').val(response[0].asset_cat_id);
							$('#edit-asset_tag').val(response[0].asset_tag);
							$('#edit-asset_certificate').val(response[0].asset_certificate);
							$('#edit-asset_status').val(response[0].asset_status);
							
							
							
							show_modal( 'edit_modal_unit' , titler );
							
							// end_loader();
							
							},
							error    :function(){
							alert('Code Not Applied');
							},
							});
							}
							
							
							init_nwFormGroup();
							
							$(document).ready(function(){
							$(".filterSearch").on("keyup", function() {
							var value = $(this).val().toLowerCase();
							var TBL = $(this).attr('tbl-id');
							$("#" + TBL + " tr").filter(function() {
							$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
							});
							});
							});
							</script>
							
							</body>
							</html>													
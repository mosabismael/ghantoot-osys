<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
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
		$SERCHCOND = " WHERE (`$thsSEARCH` = '$thsREF')";
	}
	$thsPageName    = basename($_SERVER['PHP_SELF']);
	$thsPageArr     = explode('.', $thsPageName);
	$thsPageNameREQ = $thsPageArr[0];
	
	
	
	$page = 1;
	$showPerPage = 20;
	$totPages = 0;
	$qu_pur_requisitions_sel = "SELECT count(*) FROM  `wh_shelfs` ";
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
			
			$WHERE = "wh_shelfs";
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
								<option value = "shelf_name">Name</option>
								<option value = "rack_id">Rack</option>
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
								<div class = "th"> <a style="color: red;cursor:pointer;" onclick="show_details( 'newRackDetails', 'Add New Rack' );"><?=lang("Add_New", "AAR"); ?></a></div>
								<div class="th" style="width:30%;"><?=lang("Name", "AAR"); ?></div>
							<div class="th"><?=lang("Rack", "AAR"); ?></div>
						<div class="th"><?=lang("Area", "AAR"); ?></div>
						
						
						
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
						var button = "";
						if( response[i].mrv_status == 'draft' ){
						button = '<a href="mrv_send_qc.php?mrv_id='+response[i].mrv_id+'" class=""><button type="button"><?=lang("Request_Inspection", "AAR"); ?></button></a>';
						
						}
						
						
						
						var tr = '' + 
						'<div class = "tr">' + 
						'	<div class = "td">' + response[i].sNo + '</div>' + 
						'	<div class = "td" onclick="edit_data('+response[i].shelf_id+');"><span id="shelf-'+response[i].shelf_id+'" class="text-primary">'+response[i].shelf_name+'</span></div>'+
						'	<div class = "td">' + response[i].rack_name + '</div>' + 
						'	<div class = "td">' + response[i].area_name+ '</div>' + 
						'</div>';
						$('#tableBody').append( tr );
						
						}
						}
						
						</script>
						</div>
						
						
						
						</div>
						<div class="zero"></div>
						</div>
						
						
						
						<!--    ///////////////////      NewTaskDetails VIEW START    ///////////////////            -->
						<div class="DetailsViewer ViewerOnTop" id="NewTaskDetails">
						<div class="viewerContainer">
						<div class="viewerHeader">
						<img src="<?=uploads_root; ?>/logo_icon.png" />
						<h1>REFREFREF</h1>
						<i onclick="hide_details('NewTaskDetails');" class="fas fa-times"></i>
						</div>
						<div class="viewerBody">
						<?php include('../forms/projects/tasks/add_new.php'); ?>
						</div>
						</div>
						</div>
						<!--    ///////////////////      NewTaskDetails VIEW END    ///////////////////            -->
						
						
						
						
						
						<?php
						//PAGE DATA END   ----------------------------------------------///---------------------------------
						include('app/footer.php');
						?>
						
						
						
						
						
						
						
						
						<!--    ///////////////////      add_new_modal Modal START    ///////////////////            -->
						<div class="DetailsViewer ViewerOnTop" id="newRackDetails">
						<div class="viewerContainer">
						<div class="viewerHeader">
						<img src="<?=uploads_root; ?>/logo_icon.png" />
						<h1>REFREFREF</h1>
						<i onclick="hide_details('newRackDetails');" class="fas fa-times"></i>
						</div>
						<div class="viewerBody">
						
						<form 
						id="add-new-item-form" 
						id-modal="add_new_modal" 
						id-details="newRackDetails" 
						api="<?=api_root; ?>inventory/shelfs/add_new.php">
						
						
						
						
						
						<div class="col-50">
						<div class="nwFormGroup">
						<label class="lbl_class"><?=lang('shelf Name', 'ARR', 1); ?></label>
						<input class="frmData" type="text" 
						id="new-shelf_name" 
						name="shelf_name" 
						req="1" 
						den="" 
						alerter="<?=lang("Please_Check_shelf_name", "AAR"); ?>">
						</div>
						</div>
						
						
						<div class="col-50">
						<div class="nwFormGroup">
						<label class="lbl_class"><?=lang('Rack', 'ARR', 1); ?></label>
						<select class="frmData" 
						id="new-rack_id" 
						name="rack_id" 
						req="1" 
						den="0" 
						alerter="<?=lang("Please_Check_Rack", "AAR"); ?>">
						<option value="0" selected>--- Please Select---</option>
						<?php
						$qu_wh_racks_sel = "SELECT `rack_id`, `rack_name`, `area_id` FROM  `wh_racks` ORDER BY `rack_name` ASC";
						$qu_wh_racks_EXE = mysqli_query($KONN, $qu_wh_racks_sel);
						if(mysqli_num_rows($qu_wh_racks_EXE)){
						while($wh_racks_REC = mysqli_fetch_array($qu_wh_racks_EXE)){
						$thsArea = ( int ) $wh_racks_REC[2];
						$qu_wh_areas_sel = "SELECT `area_name` FROM  `wh_areas` WHERE `area_id` = $thsArea";
						$qu_wh_areas_EXE = mysqli_query($KONN, $qu_wh_areas_sel);
						$area_nameT = "NA";
						if(mysqli_num_rows($qu_wh_areas_EXE)){
						$wh_areas_DATA = mysqli_fetch_assoc($qu_wh_areas_EXE);
						$area_nameT = $wh_areas_DATA['area_name'];
						}
						?>
						<option value="<?=$wh_racks_REC[0]; ?>"><?=$wh_racks_REC[1]; ?> - <?=$area_nameT; ?></option>
						<?php
						}
						}
						?>
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
						<button type="button" onclick="hide_details('newRackDetails');">
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
						api="<?=api_root; ?>inventory/shelfs/update_details.php">
						
						
						<input class="frmData" type="hidden" 
						id="edit-shelf_id" 
						name="shelf_id" 
						value="0" 
						req="1" 
						den="0" 
						alerter="<?=lang("Please_Check_shelf_id", "AAR"); ?>">
						
						
						
						
						<div class="col-50">
						<div class="nwFormGroup">
						<label class="lbl_class"><?=lang('shelf Name', 'ARR', 1); ?></label>
						<input class="frmData" type="text" 
						id="edit-shelf_name" 
						name="shelf_name" 
						req="1" 
						den="" 
						alerter="<?=lang("Please_Check_shelf_name", "AAR"); ?>">
						</div>
						</div>
						
						
						<div class="col-50">
						<div class="nwFormGroup">
						<label class="lbl_class"><?=lang('Rack', 'ARR', 1); ?></label>
						<select class="frmData" 
						id="edit-rack_id" 
						name="rack_id" 
						req="1" 
						den="0" 
						alerter="<?=lang("Please_Check_Rack", "AAR"); ?>">
						<option value="0" selected>--- Please Select---</option>
						<?php
						$qu_wh_racks_sel = "SELECT `rack_id`, `rack_name`, `area_id` FROM  `wh_racks` ORDER BY `rack_name` ASC";
						$qu_wh_racks_EXE = mysqli_query($KONN, $qu_wh_racks_sel);
						if(mysqli_num_rows($qu_wh_racks_EXE)){
						while($wh_racks_REC = mysqli_fetch_array($qu_wh_racks_EXE)){
						$thsArea = ( int ) $wh_racks_REC[2];
						$qu_wh_areas_sel = "SELECT `area_name` FROM  `wh_areas` WHERE `area_id` = $thsArea";
						$qu_wh_areas_EXE = mysqli_query($KONN, $qu_wh_areas_sel);
						$area_nameT = "NA";
						if(mysqli_num_rows($qu_wh_areas_EXE)){
						$wh_areas_DATA = mysqli_fetch_assoc($qu_wh_areas_EXE);
						$area_nameT = $wh_areas_DATA['area_name'];
						}
						?>
						<option value="<?=$wh_racks_REC[0]; ?>"><?=$wh_racks_REC[1]; ?> - <?=$area_nameT; ?></option>
						<?php
						}
						}
						?>
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
						url      :"<?=api_root; ?>inventory/shelfs/get_details.php",
						data     :{'typo': 'pc_call', 'ids_id': ids_id},
						dataType :"JSON",
						type     :'POST',
						success  :function(response){
						
						$('#edit-rack_id').val(response[0].rack_id);
						$('#edit-shelf_id').val(response[0].shelf_id);
						$('#edit-shelf_name').val(response[0].shelf_name);
						
						
						
						
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
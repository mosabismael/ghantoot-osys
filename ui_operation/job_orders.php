<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 3;
	$subPageID = 8;
	
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
	$qu_COUNT_sel = "SELECT COUNT(`job_order_id`) FROM  `job_orders`  WHERE ( (`job_order_status` = 'active') $SERCHCOND )";
	$qu_COUNT_EXE = mysqli_query($KONN, $qu_COUNT_sel);
	if(mysqli_num_rows($qu_COUNT_EXE)){
		$job_COUNT_DATA = mysqli_fetch_array($qu_COUNT_EXE);
		$totPages = ( int ) $job_COUNT_DATA[0];
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
			
			$WHERE = "job_orders";
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
				
				<!-- NEW TABLE START -->
				<div class="tableHolder">
					<div class="tableForm">
						<div class="tableFormGroup">
							<select id = "search_option">
								<option value = "" selected disabled> Select Column</option>
								<option value = "job_order_ref">Job order REF</option>
								<option value = "project_name">Project Name</option>
								<option value = "job_order_type">Type</option>
								<option value = "created_date">Created Date</option>
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
								<div class="th"><?=lang("Job_Order_REF", "AAR"); ?></div>
							<div class="th"><?=lang("Project_Name", "AAR"); ?></div>
							<div class="th"><?=lang("Type", "AAR"); ?></div>
							<div class="th"><?=lang("Created_date", "AAR"); ?></div>
							<div class="th"><?=lang("PM", "AAR"); ?></div>
							<div class="th"><?=lang("Status", "AAR"); ?></div>
							<div class="th"><?=lang("Opt", "AAR"); ?></div>
							</div>
							</div>
							<div class="tableBody" id="tableBody"></div>
							</div>
							<div class="tablePagination">
							<div class="pageNum arrowPager" id="prePatchBtn" onclick="showPrePageBatch('ui_operation/<?=basename($_SERVER['PHP_SELF']); ?>', <?=$showPerPage; ?>, <?=$totPages; ?>);"><i class="fas fa-angle-double-left"></i></div>
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
							<div onclick="loadTableData( <?=$i; ?>, <?=$showPerPage; ?>, 'ui_operation/<?=basename($_SERVER['PHP_SELF']); ?>' );" class="pageNum imVarPager pn-<?=$i; ?> <?=$CLS; ?>"><?=$iView; ?></div>
							<?php
							}
							}
							?>
							<div id="addPagerPoint"></div>
							<div class="pageNum arrowPager" id="nextPatchBtn" onclick="showNextPageBatch('ui_operation/<?=basename($_SERVER['PHP_SELF']); ?>', <?=$showPerPage; ?>, <?=$totPages; ?>);"><i class="fas fa-angle-double-right"></i></div>
							</div>
							<script>
							var thsPage = 'ui_operation/<?=basename($_SERVER['PHP_SELF']); ?>';
							function bindData( response ){
							$('#tableBody').html('');
							var cc = 0;
							for( i=0 ; i < response.length ; i ++ ){
							cc++;
							var req_item_id = parseInt( response[i].req_item_id );
							
							var tr = '' + 
							'<div class = "tr" id="jo-' + response[i].job_order_id + '">' + 
							'	<div class = "td">' + response[i].sno + '</div>' + 
							'	<div class = "td" onclick="showJoDetails(' + response[i].job_order_id + ", '" + response[i].job_order_ref  + "'" +  ", 'viewJoDetails'" + ');"><span id="joREF-'+response[i].job_order_id+'" class="text-primary cursored">' + response[i].job_order_ref + '</span></div>' + 
							'	<div class = "td">' + response[i].project_name + '</div>' + 
							'	<div class = "td">' + response[i].job_order_type + '</div>' + 
							'	<div class = "td">' + response[i].created_date + '</div>' + 
							'	<div class = "td">' + response[i].project_manager + '</div>' + 
							'	<div class = "td">' + response[i].job_order_status + '</div>' + 
							'	<div class = "td">' + 
							'		<button type="button" onclick="delJobOrder(' + response[i].job_order_id + ');"><?=lang("Delete", "AAR"); ?></button>' + 
							'	</div>' + 
							'</div>';
							$('#tableBody').append( tr );
							}
							}
							
							/*
							
							*/
							
							</script>
							</div>
							<!-- NEW TABLE END -->
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							</div>
							<div class="zero"></div>
							</div>
							
							
							
							
							<!--    ///////////////////      View JO details VIEW START    ///////////////////            -->
							<div class="DetailsViewer" id="viewJoDetails">
							<div class="viewerContainer">
							<div class="viewerHeader">
							<img src="<?=uploads_root; ?>/logo_icon.png" />
							<h1>REFREFREF</h1>
							<i onclick="hide_details('viewJoDetails');" class="fas fa-times"></i>
							</div>
							<div class="viewerBody">
							<?php include('../forms/job_orders/view_jo.php'); ?>
							</div>
							</div>
							</div>
							<!--    ///////////////////      View REQ details VIEW END     ///////////////////            -->
							
							
							
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
							
							
							<!--    ///////////////////      NewActivityDetails VIEW START    ///////////////////            -->
							<div class="DetailsViewer ViewerOnTop" id="NewActivityDetails">
							<div class="viewerContainer">
							<div class="viewerHeader">
							<img src="<?=uploads_root; ?>/logo_icon.png" />
							<h1>REFREFREF</h1>
							<i onclick="hide_details('NewActivityDetails');" class="fas fa-times"></i>
							</div>
							<div class="viewerBody">
							<?php include('../forms/projects/activities/add_new.php'); ?>
							</div>
							</div>
							</div>
							<!--    ///////////////////      NewActivityDetails VIEW END    ///////////////////            -->
							
							
							
							
							
							
							<!--    ///////////////////      NewProcessDetails VIEW START    ///////////////////            -->
							<div class="DetailsViewer ViewerOnTop" id="NewProcessDetails">
							<div class="viewerContainer">
							<div class="viewerHeader">
							<img src="<?=uploads_root; ?>/logo_icon.png" />
							<h1>REFREFREF</h1>
							<i onclick="hide_details('NewProcessDetails');" class="fas fa-times"></i>
							</div>
							<div class="viewerBody">
							<?php include('../forms/projects/processes/add_new.php'); ?>
							</div>
							</div>
							</div>
							<!--    ///////////////////      NewProcessDetails VIEW END    ///////////////////            -->
							
							
							
							
							
							<?php
							//PAGE DATA END   ----------------------------------------------///---------------------------------
							include('app/footer.php');
							?>
							
							
							
							
							
							
							
							
							<!--    ///////////////////      add_new_modal Modal START    ///////////////////            -->
							<div class="modal" id="add_new_modal">
							<div class="modal-container">
							<div class="modal-header">
							<?php include("app/modal_header.php"); ?>
							</div>
							<div class="modal-body">
							
							<?php include('../forms/job_orders/add_new.php'); ?>
							
							
							</div>
							</div>
							<div class="zero"></div>
							</div>
							
							
							<!--    ///////////////////      add_new_modal Modal END    ///////////////////            -->
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							<script>
							
							$(document).ready(function(){
							$(".filterSearch").on("keyup", function() {
							var value = $(this).val().toLowerCase();
							var TBL = $(this).attr('tbl-id');
							$("#" + TBL + " tr").filter(function() {
							$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
							});
							});
							});
							
							
							
							
							
							
							
							
							
							init_nwFormGroup();
							</script>
							
							<?php
							if( isset( $_GET['add_new'] ) ){
							?>
							<script>
							show_modal( 'add_new_modal', 'New Job Order' );
							</script>
							<?php
							}
							?>
							</body>
							</html>														
<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 3;
	$subPageID = 10;
	
	
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
	$qu_pur_requisitions_sel = "SELECT count(*) FROM  `inv_mivs`";
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
			
			$WHERE = "requisitions";
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
				
				
				<a href="miv_new_01.php" class="actionBtn"><button type="button"><i class="fas fa-plus"></i><?=lang("Issue_New", "AAR"); ?></button></a>
				
				<div class="tableHolder">
					<div class="tableForm">
						<div class="tableFormGroup">
							<select id = "search_option">
								<option value = "" selected disabled> Select Column</option>
								<option value = "miv_ref">MIV REF</option>
								<option value = "job_order_id">Project</option>
								<option value = "created_date">Created Date</option>
								<option value = "miv_status">Status</option>
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
								<div class = "th"><?=lang("MIV_REF", "AAR"); ?></div>
							<div class="th" style="width:30%;"><?=lang("Project", "AAR"); ?></div>
						<div class="th"><?=lang("Created_date", "AAR"); ?></div>
						<div class="th"><?=lang("Created_By", "AAR"); ?></div>
						<div class="th"><?=lang("received_Date", "AAR"); ?></div>
						<div class="th"><?=lang("received_By", "AAR"); ?></div>
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
						var button = "";
						if( response[i].miv_status == 'draft' ){
						button = '<a href="miv_select_items.php?miv_id='+response[i].miv_id+'" class=""><button type="button"><?=lang("Select_Items", "AAR"); ?></button></a>';
						
						}
						
						
						
						var tr = '' + 
						'<div class = "tr" id = "po-"'+response[i].miv_id+'>' + 
						'	<div class = "td" onclick="showPoDetails(' + response[i].miv_id + ", '" + response[i].miv_ref  + "'" +  ", 'viewPOdetails'" + ');"><span class="text-primary cursor" id="poREF-'+response[i].miv_id+'">' + response[i].miv_ref + '</span></div>' + 
						'	<div class = "td" style="text-align:left;">' + response[i].job_order_ref + ' - ' +response[i].project_name+ '</div>' + 
						'	<div class = "td">' + response[i].created_date + '</div>' + 
						'	<div class = "td">' + response[i].created_by + '</div>' + 
						'	<div class = "td">' + response[i].received_date + '</div>' + 
						'	<div class = "td">' + response[i].received_by + '</div>' + 
						'	<div class = "td">' + response[i].miv_status + '</div>' + 
						'	<div class = "td"><a href="miv_view_details.php?miv_id='+response[i].miv_id+'"><button type="button"><?=lang("Details", "AAR"); ?></button></a>'+button+'</div>' + 
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
						<?php
						//PAGE DATA END   ----------------------------------------------///---------------------------------
						include('app/footer.php');
						?>
						
						</body>
						</html>						
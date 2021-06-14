<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "Site Title";
	
	
	
	$menuId = 1;
	$subPageID = 31;
	
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
	$qu_COUNT_sel = "SELECT count(*) FROM  `hr_interviews` $SERCHCOND";
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
					
					
					<a href="hr_interviews_new.php"><button type="button"><?=lang("Add_New", "AAR"); ?></button></a>
					
					<div class="tableHolder">
						<div class="tableForm">
							<div class="tableFormGroup">
								<select id = "search_option">
									<option value = "" selected disabled> Select Column</option>
									<option value = "interview_id">Interview Id</option>
									<option value = "candidate_name">Candidate Name</option>
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
									<div class="th"><?=lang("Sys_Id - employee_code", "AAR"); ?></div>
									<div class="th"><?=lang("candidate_name", "AAR"); ?></div>
								<div class="th"><?=lang("created_date", "AAR"); ?></div>
								<div class="th"><?=lang("created_by", "AAR"); ?></div>
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
								'<div class = "tr" id="all-' + response[i].interview_id + '">' + 
								'	<div class = "td"> <a href="hr_interviews_details.php?interview_id='+response[i].interview_id+'" style="color:blue;">HRINT-'+response[i].interview_id+'</a></div>' + 
								'	<div class = "td cell-title">' + response[i].candidate_name + '</div>' + 
								'	<div class = "td">' + response[i].created_date + '</div>' + 
								'	<div class = "td">' + response[i].NAMER + '</div>' + 
								'	<div class = "td text-center"> '+
								'	<a href="hr_allowances_print.php?idd=' + response[i].interview_id + '" target="_blank" title="<?=lang("print", "AAR"); ?>"><i class="fas fa-print"></i></a></div>'+
								'</div>';
								$('#tableBody').append( tr );
								
								
								}
								}
								
								
								</script>
								</div>
								
								
								
								
								</div>
								
								
								<div class="zero"></div>
								</div>
								
								
								
								
								
								
								
								
								
								
								<?php
								//PAGE DATA END   ----------------------------------------------///---------------------------------
								include('app/footer.php');
								?>
								
								</body>
								</html>								
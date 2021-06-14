<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	$menuId = 4;
	$subPageID = 14;
	
	
	
	if( isset( $_POST['is_approve'] ) && isset( $_POST['supplier_id'] ) ){
	    
	    $is_approve  = ( int ) test_inputs( $_POST['is_approve'] );
	    $supplier_id = ( int ) test_inputs( $_POST['supplier_id'] );
	    
		
		$qu_suppliers_list_updt = "UPDATE  `suppliers_list` SET 
		`is_approved` = '".$is_approve."'
		WHERE `supplier_id` = $supplier_id;";
        
		if(!mysqli_query($KONN, $qu_suppliers_list_updt)){
			die("ERR0-7863873dd".mysqli_error( $KONN ));
		}
	    
	    
	}
	
	$page = 1;
	$showPerPage = 20;
	$totPages = 0;
	
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
	
	
	
	
	$qu_COUNT_sel = "SELECT count(`supplier_id`) FROM  `suppliers_list` $SERCHCOND ";
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
				
				<div class="tableHolder">
					<div class="tableForm">
						<div class="tableFormGroup">
							<select id = "search_option">
								<option value = "" selected disabled> Select Column</option>
								<option value = "supplier_code">Code</option>
								<option value = "supplier_name">Name</option>
								<option value = "trn_no">TRN</option>
								<option value = "supplier_phone">Phone</option>
								<option value = "supplier_email">Email</option>
								<option value = "address">Address</option>
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
							<div class="th"><?=lang("Code", "AAR"); ?></div>
							<div class="th"><?=lang("Name", "AAR"); ?></div>
							<div class="th"><?=lang("TRN", "AAR"); ?></div>
						<div class="th"><?=lang("Phone", "AAR"); ?></div>
						<div class="th"><?=lang("email", "AAR"); ?></div>
						<div class="th"><?=lang("address", "AAR"); ?></div>
						<div class="th"><?=lang("Approved_List", "AAR"); ?></div>
						</div>
						</div>
						<div class="tableBody" id="tableBody"></div>
						</div>
						<div class="tablePagination">
						<div class="pageNum arrowPager" id="prePatchBtn" onclick="showPrePageBatch('ui_purchase/<?=basename($_SERVER['PHP_SELF']); ?>', <?=$showPerPage; ?>, <?=$totPages; ?>);"><i class="fas fa-angle-double-left"></i></div>
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
						<div onclick="loadTableData( <?=$i; ?>, <?=$showPerPage; ?>, 'ui_purchase/<?=basename($_SERVER['PHP_SELF']); ?>' );" class="pageNum imVarPager pn-<?=$i; ?> <?=$CLS; ?>"><?=$iView; ?></div>
						<?php
						}
						}
						?>
						<div id="addPagerPoint"></div>
						<div class="pageNum arrowPager" id="nextPatchBtn" onclick="showNextPageBatch('ui_purchase/<?=basename($_SERVER['PHP_SELF']); ?>', <?=$showPerPage; ?>, <?=$totPages; ?>);"><i class="fas fa-angle-double-right"></i></div>
						</div>
						<script>
						var thsPage = 'ui_purchase/<?=basename($_SERVER['PHP_SELF']); ?>';
						function bindData( response ){
						$('#tableBody').html('');
						var cc = 0;
						for( i=0 ; i < response.length ; i ++ ){
						cc++;
						var req_item_id = parseInt( response[i].req_item_id );
						var button = '<form method="POST"><input type="hidden" name="supplier_id" value="'+response[i].supplier_id+'"><input type="hidden" name="is_approve" value="0"><button type="submit"><?=lang("Remove_From_Approved", "AAR"); ?></button></form>';
						if(response[i].is_approved == '0'){
						button = '<form method="POST"><input type="hidden" name="supplier_id" value="'+response[i].supplier_id+'"><input type="hidden" name="is_approve" value="1"><button type="submit"><?=lang("Approved", "AAR"); ?></button></form>';
						}
						var tr = '' + 
						'<div class = "tr" id="req-' + response[i].supplier_id + '">' + 
						'	<div class = "td">' + response[i].sNo + '</div>' + 
						'	<div class = "td" ><a href="suppliers_edit.php?supplier_id='+response[i].supplier_id+'" id="reqREF-'+response[i].supplier_id+'" class="text-primary">'+response[i].supplier_code+'</a></div>'+
						'	<div class = "td">' + response[i].supplier_name + '</div>' + 
						'	<div class = "td">' + response[i].trn_no + '</div>' + 
						'	<div class = "td">' + response[i].supplier_phone + '</div>' + 
						'	<div class = "td">' + response[i].supplier_email + '</div>' + 
						'	<div class = "td">' + response[i].address + '</div>' + 
						'	<div class = "td">' + 
						'	<form method="POST">' + 
						'	   <input type="hidden" name="supplier_id" value="' + response[i].supplier_id + '">' + 
						'	   <input type="hidden" name="is_approve" value="' + response[i].is_approved + '">' + 
						'    	<button type="submit">' + response[i].btn + '</button>' + 
						'	</form>' + 
						'	</div>' + 
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
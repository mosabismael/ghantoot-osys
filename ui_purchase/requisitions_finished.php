<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 1;
	$subPageID = 4;
	
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
	$qu_pur_requisitions_sel = "SELECT count(*) FROM  `pur_requisitions` WHERE ((`requisition_status` = 'finish_req') $SERCHCOND )";
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
				
				<div class="tableHolder">
					<div class="tableForm">
						<div class="tableFormGroup">
							<select id = "search_option">
								<option value = "" selected disabled> Select Column</option>
								<option value = "requisition_ref">Requisition REF</option>
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
								<div class="th"><?=lang("REF", "AAR"); ?></div>
								<div class="th"><?=lang("Created_date", "AAR"); ?></div>
								<div class="th"><?=lang("BY", "AAR"); ?></div>
								<div class="th"><?=lang("Status", "AAR"); ?></div>
							</div>
						</div>
						<div class="tableBody" id="tableBody"></div>
					</div>
					<div class="tablePagination">
						<div class="pageNum arrowPager" id="prePatchBtn" onclick="showPrePageBatch('ui_purchase/<?=basename($_SERVER['PHP_SELF']); ?>', <?=$showPerPage; ?>, <?=$totPages; ?>);"><i class="fas fa-angle-double-left"></i></div>
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
								
								var tr = '' + 
								'<div class = "tr" id="req-' + response[i].requisition_id + '">' + 
								'	<div class = "td">' + response[i].sno + '</div>' + 
								'	<div class = "td" onclick="showReqDetails(' + response[i].requisition_id + ", '" + response[i].requisition_ref  + "'" +  ", 'viewItemDetails'" + ');"><span id="reqREF-'+response[i].requisition_id+'" class="text-primary cursored">' + response[i].requisition_ref + '</span></div>' + 
								'	<div class = "td">' + response[i].created_date + '</div>' + 
								'	<div class = "td">' + response[i].BY + '</div>' + 
								'	<div class = "td" id="reqStatus-' + response[i].requisition_id + '">' + response[i].requisition_status + '</div>' + 
								'</div>';
								$('#tableBody').append( tr );
								
								
							}
						}
						
						/*
							
						*/
						
					</script>
					
				</div>
				<div class="zero"></div>
			</div>
			
			
			<?php
				//PAGE DATA END   ----------------------------------------------///---------------------------------
				include('app/footer.php');
				?>
			<script>
				var activeREQ = 0;
				var is_materialREQ = 0;
				
				
				
				
				function waiting_supplier( IDD ){
					var aa = confirm( 'Are you sure, this action cannot be undo ?' );
					if( aa == true && activeREQ != 0 ){
						start_loader('Sending Requisition...');
						$.ajax({
							url      :"<?=api_root; ?>requisitions/waiting_supplier.php",
							data     :{ 'requisition_id': activeREQ },
							dataType :"html",
							type     :'POST',
							success  :function(data){
								end_loader();
								var aa = data.split('|');
								res = parseInt( aa[0] );
								if( res == 1 ){
									location.reload();
									} else {
									alert('Error - ' + aa[1]);
								}
								
							},
							error    :function(){
								end_loader();
								alert('Data Error No: 5467653');
							},
						});
					}
				}
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				function showReqDetails( reqID, reqRef , detailsView ){
					reqID = parseInt( reqID );
					$('#new-requisition_id').val(reqID);
					$('#new-file-requisition_id').val(reqID);
					$('#req_items').html('');
					$('#rfq_supps').html('');
					$('#rfqSups').html('');
					$('#rfq_lists').html('');
					ReqStatus = $('#reqStatus-' + reqID).html();
					set_tabber(1);
					activeREQ = reqID;
					loadDetails( reqID, detailsView, reqRef );
				}
				function loadDetails( reqID, detailsView, reqRef ){
					start_loader("Loading Requisition Details...");
					$.ajax({
						url      :"<?=api_root; ?>requisitions/get_details.php",
						data     :{ 'requisition_id': reqID },
						dataType :"json",
						type     :'POST',
						success  :function( response ){
							end_loader();
							$('#' + detailsView + ' .requisition_id').val(response[0].requisition_id);
							$('#' + detailsView + ' .created_date').val(response[0].created_date);
							$('#' + detailsView + ' .required_date').val(response[0].required_date);
							$('#' + detailsView + ' .estimated_date').val(response[0].estimated_date);
							$('#' + detailsView + ' .requisition_ref').val(response[0].requisition_ref);
							$('#' + detailsView + ' .requisition_type').val(response[0].requisition_type);
							
							is_materialREQ = parseInt( response[0].is_material );
							
							
							var job_order_id = parseInt( response[0].job_order_id );
							if( job_order_id != 0 ){
								$('#' + detailsView + ' .job_order_id').val(response[0].job_order_ref);
								$('#' + detailsView + ' .project_no').val(response[0].project_name + ' - ' + response[0].job_order_type);
								} else {
								$('#' + detailsView + ' .job_order_id').val("NA");
								$('#' + detailsView + ' .project_no').val("NA");
							}
							$('#' + detailsView + ' .requisition_status').val(response[0].requisition_status);
							$('#' + detailsView + ' .requisition_notes').val(response[0].requisition_notes);
							$('#' + detailsView + ' .ordered_by').val(response[0].ordered_by);
							//load items
							
							show_details(detailsView, reqRef);
							notificationMenu();
							if( ReqStatus != 'draft' ){
								$('#addNewReqItemBtn').css('display', 'none');
							}
							loadReqItems();
							
						},
						error    :function(){
							end_loader();
							alert('Data Error No: 5467653');
						},
					});
					
				}
				
				function loadReqItems( ){
					start_loader('Loading Requisition Items...');
					$.ajax({
						url      :"<?=api_root; ?>requisitions/get_items.php",
						data     :{ 'requisition_id': activeREQ },
						dataType :"json",
						type     :'POST',
						success  :function( response ){
							if( is_materialREQ == 1 ){
								$('#showDaysValue').hide();
								$('.is_material-1').show();
								} else {
								$('#showDaysValue').show();
								$('.is_material-1').hide();
							}
							end_loader();
							$('#req_items').html('');
							//load items
							var cc = 0;
							for( i=0 ; i < response.length ; i ++ ){
								cc++;
								var req_item_id    = parseInt( response[i].req_item_id );
								if( req_item_id != 0 ){
									/*
										var family_id      = response[i].family_id;
										var section_id     = response[i].section_id;
										var division_id    = response[i].division_id;
										var subdivision_id = response[i].subdivision_id;
										var category_id    = response[i].category_id;
										var item_code_id   = response[i].item_code_id;
									*/
									var item_name       = response[i].item_name;
									var item_qty       = response[i].item_qty;
									var item_days      = response[i].item_days;
									var certificate_required     = response[i].certificate_required;
									var item_unit_id   = response[i].item_unit_id;
									var item_stock_qty = response[i].item_stock_qty;
									
									var reqOpts = '';
									if( ReqStatus == 'draft' ){
										reqOpts = '<i title="Delete this item" onclick="delReqItem(' + req_item_id + ');" class="fas fa-trash"></i>';
									}
									
									var item_days_v = '';
									if( is_materialREQ == 1 ){
										item_days_v = '--';
										$('#showDaysValue').hide();
										} else {
										item_days_v = item_days;
										$('#showDaysValue').show();
									}
									
									var tr = '' + 
									'<tr id="reqItem-' + req_item_id + '">' + 
									'	<td><input type="checkbox" class="itemCheck" req_item="' + req_item_id + '" idd="reqItem-' + req_item_id + '"></td>' + 
									'	<td>' + cc + '</td>' + 
									'	<td>' + item_name + '</td>' + 
									'	<td>' + item_stock_qty + '</td>' + 
									'	<td>' + item_qty + '</td>' + 
									'	<td>' + item_days_v + '</td>' + 
									'	<td>' + item_unit_id + '</td>' + 
									'	<td>' + certificate_required + '</td>' + 
									'	<td>' + reqOpts + '</td>' + 
									'</tr>';
									
									$('#req_items').append(tr);
								}
							}
							initEventSelect();
							
						},
						error    :function(){
							end_loader();
							alert('Data Error No: 5467653');
						},
					});
					
				}
				function delPl_Item( rfq_item_id ){
					rfq_item_id = parseInt( rfq_item_id );
					if( rfq_item_id != 0 ){
						var aa = confirm( 'Are you sure, this action cannot be undo ?' );
						if( aa == true ){
							
							start_loader('Deleting RFQ Items...');
							$.ajax({
								url      :"<?=api_root; ?>requisitions/rfqs/del_rfq_item.php",
								data     :{ 'rfq_item_id': rfq_item_id },
								dataType :"html",
								type     :'POST',
								success  :function(data){
									end_loader();
									var aa = data.split('|');
									res = parseInt( aa[0] );
									if( res == 1 ){
										$( '#itemo-' + rfq_item_id ).remove();
										} else {
										alert('Error deleting item - ' + aa[1]);
									}
									
								},
								error    :function(){
									end_loader();
									alert('Data Error No: 5467653');
								},
							});
							
							
							
							
							
						}
					}
				}
				
				function delReqItem( itmID ){
					itmID = parseInt( itmID );
					if( itmID != 0 ){
						var aa = confirm( 'Are you sure, this action cannot be undo ?' );
						if( aa == true ){
							
							start_loader('Deleting Requisition Items...');
							$.ajax({
								url      :"<?=api_root; ?>requisitions/items/del_requisition_item.php",
								data     :{ 'req_item_id': itmID },
								dataType :"html",
								type     :'POST',
								success  :function(data){
									end_loader();
									var aa = data.split('|');
									res = parseInt( aa[0] );
									if( res == 1 ){
										$('#reqItem-' + itmID).remove();
										} else {
										alert('Error deleting item - ' + aa[1]);
									}
									
								},
								error    :function(){
									end_loader();
									alert('Data Error No: 5467653');
								},
							});
							
							
							
							
							
						}
					}
				}
				
				function selAllItems(){
					
					if ($('#selAll').is(":checked")) {
						//select all
						
						$('.itemCheck').each( function(){
							$(this).prop('checked', true);
							var idd = $(this).attr('idd');
							$('#'+ idd).addClass('selected');
						} );
						
						
						} else {
						//deselect all
						$('.itemCheck').each( function(){
							$(this).prop('checked', false);
							var idd = $(this).attr('idd');
							$('#'+ idd).removeClass('selected');
						} );
						
					}
					
				}
				function initEventSelect(){
					$('.itemCheck').on('change', function(){
						
						if ($(this).is(":checked")) {
							var idd = $(this).attr('idd');
							$('#'+ idd).addClass('selected');
							} else {
							var idd = $(this).attr('idd');
							$('#'+ idd).removeClass('selected');
						}
					});
				}
				
				
				
				function loadSupplierList(){
					start_loader('Loading Suppliers List...');
					$.ajax({
						url      :"<?=api_root; ?>suppliers/get_suppliers_list.php",
						data     :{ 'requisition_id': 0 },
						dataType :"json",
						type     :'POST',
						success  :function( response ){
							end_loader();
							$('#rfq_supps').html('');
							//load items
							var cc = 0;
							for( i=0 ; i < response.length ; i ++ ){
								cc++;
								
								var supplier_id    = parseInt( response[i].supplier_id );
								if( supplier_id != 0 ){
									var supplier_code= response[i].supplier_code;
									var supplier_name= response[i].supplier_name;
									var supplier_phone= response[i].supplier_phone;
									
									var tr = '' + 
									'<tr id="reqSup-' + supplier_id + '">' + 
									'	<td><input title="select ' + supplier_name + '" type="checkbox" class="supCheck" idd="reqSup-' + supplier_id + '" reqSup="' + supplier_id + '"></td>' + 
									'	<td>' + supplier_code + '</td>' + 
									'	<td>' + supplier_name + '</td>' + 
									'	<td>' + supplier_phone + '</td>' + 
									'</tr>';
									
									$('#rfq_supps').append(tr);
								}
							}
							initSupplierSelect();
							show_details('rfqDetails', 'RFQ Supplier Select');
							
						},
						error    :function(){
							end_loader();
							alert('Data Error No: 5467653');
						},
					});
					
				}
				
				function initSupplierSelect(){
					$('.supCheck').on('change', function(){
						
						if ($(this).is(":checked")) {
							var idd = $(this).attr('idd');
							$('#'+ idd).addClass('selected');
							} else {
							var idd = $(this).attr('idd');
							$('#'+ idd).removeClass('selected');
						}
					});
				}
				
				function generateRFQ(){
					var selItems = '';
					var selctedCount = 0;
					
					$('#rfqItems').html('');
					
					//take selected items
					$('.itemCheck').each( function(){
						
						if ($(this).is(":checked")) {
							selctedCount++;
							var reqItem = $(this).attr('req_item');
							
							var THStr = '<input class="frmData" type="hidden" ' + 
							'	id="rfq-requisitionITEMS' + reqItem + '"  ' + 
							'	name="req_items[]"  ' + 
							'	value="' + reqItem + '"  ' + 
							'	req="1"  ' + 
							'	den="0"  ' + 
							'	alerter="<?=lang("Please_Check_requisition_Items", "AAR"); ?>">';
							
							
							selItems = selItems + THStr;
							
							
						}
						
						
						
					});
					
					if( selctedCount != 0 ){
						//add them to rfq form
						$('#rfqItems').html(selItems);
						
						$('#rfq-requisition_id').val(activeREQ);
						
						//show supplierSelector
						loadSupplierList();
						
						
						} else {
						alert("Please Select Items to generate RFQ");
					}
					
				}
				
				function createRFQs(){
					var selItems = '';
					var selctedCount = 0;
					$('#rfqSups').html('');
					//take selected items
					$('.supCheck').each( function(){
						
						if ($(this).is(":checked")) {
							selctedCount++;
							var reqSup = $(this).attr('reqSup');
							
							var THStr = '<input class="frmData" type="hidden" ' + 
							'	id="rfq-requisitionITEMS' + reqSup + '"  ' + 
							'	name="supplier_ids[]"  ' + 
							'	value="' + reqSup + '"  ' + 
							'	req="1"  ' + 
							'	den="0"  ' + 
							'	alerter="<?=lang("Please_Check_suppliers", "AAR"); ?>">';
							
							
							selItems = selItems + THStr;
							
							
						}
						
						
						
					});
					
					if( selctedCount != 0 ){
						//add them to rfq form
						$('#rfqSups').append(selItems);
						
						//submit form
						submit_form('add-new-rfq-form', 'close_details');
						
						} else {
						alert("Please Select Suppliers to generate RFQ");
					}
					
				}
				
				
				
				
				
				
				
				
				function loadApprovedSupps( ){
					$('#compSupp_lists').html('');
					start_loader('Loading Approved Suppliers...');
					$.ajax({
						url      :"<?=api_root; ?>requisitions/rfqs/get_approved_suppliers.php",
						data     :{ 'requisition_id': activeREQ },
						dataType :"json",
						type     :'POST',
						success  :function( response ){
							
							end_loader();
							
							//load items
							var cc = 0;
							for( i=0 ; i < response.length ; i ++ ){
								cc++;
								
								var supplier_id    = parseInt( response[i].supplier_id );
								if( supplier_id != 0 ){
									var supplier_code  = response[i].supplier_code;
									var supplier_name  = response[i].supplier_name;
									var po_id          = parseInt( response[i].po_id );
									
									
									
									var rfqOpt = '<button type="button"><a href="purchase_orders_drafts.php?add_new=1&supplier_id=' + supplier_id + '&requisition_id=' + activeREQ + '" title="Generate PO">Generate PO</a></button>';
									
									
									if( po_id != 0 ){
										if(response[i].po_status == "pending_arrival"){
											rfqOpt = '<button type="button"><a href="prints/po_print.php?po_id=' + po_id + '" target="_blank" title="Print PO">Print PO</a></button>';
										}
										else{
											rfqOpt = "";
										}
									}
									
									
									var tr = '' + 
									'<tr id="compSupp-' + supplier_id + '">' + 
									'	<td>' + cc + '</td>' + 
									'	<td id="AppSupplier-' + supplier_id + '">' + supplier_code + ' - ' + supplier_name + '</td>' + 
									'	<td>' + rfqOpt + '</td>' + 
									'</tr>';
									
									$('#compSupp_lists').append(tr);
								}
							}
							initEventSelect();
							
						},
						error    :function(){
							end_loader();
							alert('Data Error No: 5467653');
						},
					});
				
				}
				
				
				
				
				function loadRFQs( ){
				start_loader('Loading Requisition RFQs...');
				$.ajax({
				url      :"<?=api_root; ?>requisitions/rfqs/get_requisition_rfqs.php",
				data     :{ 'requisition_id': activeREQ },
				dataType :"json",
				type     :'POST',
				success  :function( response ){
				end_loader();
				$('#rfq_lists').html('');
				//load items
				var cc = 0;
				for( i=0 ; i < response.length ; i ++ ){
				cc++;
				
				var rfq_id    = parseInt( response[i].rfq_id );
				if( rfq_id != 0 ){
				var supplier_code  = response[i].supplier_code;
				var supplier_name  = response[i].supplier_name;
				var supplier_id    = response[i].supplier_id;
				var requisition_id = response[i].requisition_id;
				var created_date   = response[i].created_date;
				var price_list_id  = parseInt( response[i].price_list_id );
				
				var rfqOpt = '';
				
				if( price_list_id == 0 ){
				rfqOpt = '<a title="add Supplier Price" onclick="add_new_pl_detail(' + rfq_id + ');"><i class="fas fa-dollar-sign"></i></a>' + 
				'<a title="print RFQ" href="prints/rfq_print.php?rfq_id=' + rfq_id + '" target="_blank"><i class="fas fa-print"></i></a>'; 
				} else {
				rfqOpt = '<a title="print Price List" href="prints/pl_print.php?price_list_id=' + price_list_id + '&rfq_id=' + rfq_id + '" target="_blank"><i class="fas fa-list"></i></a>'; 
				rfqOpt = '<a title="View Supplier Price" onclick="View_pl_detail(' + rfq_id + ');"><i class="fas fa-eye"></i></a>' + rfqOpt;
				rfqOpt = '<a title="Supplier Price Added"><i class="fas fa-check" style="color:green;"></i></a>' + rfqOpt;
				}
				
				
				
				var tr = '' + 
				'<tr id="rfq-' + rfq_id + '">' + 
				'	<td>' + cc + '</td>' + 
				'	<td id="supplier-' + supplier_id + '">' + supplier_code + ' - ' + supplier_name + '</td>' + 
				'	<td>' + created_date + '</td>' + 
				'	<td>' + rfqOpt + '</td>' + 
				'</tr>';
				
				$('#rfq_lists').append(tr);
				}
				}
				initEventSelect();
				
				},
				error    :function(){
				end_loader();
				alert('Data Error No: 5467653');
				},
				});
				
				}
				
				var activeRFQ = 0;
				function add_new_pl_detail( rfqID ){
				rfqID = parseInt( rfqID );
				activeRFQ = rfqID;
				loadRfqDetails('');
				}
				function View_pl_detail( rfqID ){
				rfqID = parseInt( rfqID );
				activeRFQ = rfqID;
				loadRfqDetails('View Supplier Price');
				}
				
				
				function loadRfqDetails( TT ){
				start_loader("Loading RFQ Details...");
				clear_form('#add-new-pl-form');
				
				
				$.ajax({
				url      :"<?=api_root; ?>requisitions/rfqs/get_details.php",
				data     :{ 'rfq_id': activeRFQ },
				dataType :"json",
				type     :'POST',
				success  :function( response ){
				$('#addPriceListDetails #pl-new-discount_amount').val( 0 );
				$('#pl-new-discount_per').val(0);
				$('#add-pl-form-alerts').html('');
				
				
				var reqREF = $('#reqREF-' + response[0].requisition_id).html();
				var supName = $('#supplier-' + response[0].supplier_id).html();
				
				$('#addPriceListDetails #pl-new-rfq_id').val(response[0].rfq_id);
				$('#addPriceListDetails #pl-new-supplier_id').val(response[0].supplier_id);
				$('#addPriceListDetails #pl-new-requisition_id').val(response[0].requisition_id);
				$('#addPriceListDetails #pl-new-requisition_ref').val(reqREF);
				$('#addPriceListDetails #pl-new-supplier_name').val(supName);
				var price_list_id = parseInt( response[0].price_list_id );
				if( price_list_id != 0 ){
				$('#WHATEVER-price_list_id').val(response[0].price_list_id);
				$('#addPriceListDetails #pl-new-currency_id').val(response[0].currency_id);
				
				$('#addPriceListDetails #pl-new-is_vat_included').val(response[0].is_vat_included);
				$('#addPriceListDetails #pl-new-supplier_quotation_ref').val(response[0].supplier_quotation_ref);
				$('#addPriceListDetails #pl-new-delivery_period_id').val(response[0].delivery_period_id);
				$('#addPriceListDetails #pl-new-payment_term_id').val(response[0].payment_term_id);
				$('#addPriceListDetails #pl-new-discount_amount').val(response[0].discount_amount);
				$('#addPriceListDetails #pl-new-discount_per').val(response[0].discount_percentage);
				$('#addPriceListDetails #pl-new-notes').val(response[0].notes);
				}
				
				
				$('#pl-new-currency_id').change();
				
				//load items
				if( TT == '' ){
				$('#savePlButton').css('display', 'inline-block');
				show_details('addPriceListDetails', 'Add Supplier Pricing');
				loadRfqItems();
				} else {
				$('#savePlButton').css('display', 'none');
				// loadPlDetails();
				show_details('addPriceListDetails', 'View Supplier Pricing');
				loadRfqItems();
				}
				
				end_loader();
				},
				error    :function(){
				end_loader();
				alert('Data Error No: 5467653');
				},
				});
				
				}
				
				function loadRfqItems( ){
				start_loader('Loading RFQ Items...');
				$('#added_rfq_items').html('');
				$.ajax({
				url      :"<?=api_root; ?>requisitions/rfqs/get_items.php",
				data     :{ 'rfq_id': activeRFQ },
				dataType :"json",
				type     :'POST',
				success  :function( response ){
				end_loader();
				//load items
				var cc = 0;
				for( i=0 ; i < response.length ; i ++ ){
				cc++;
				var req_item_id    = parseInt( response[i].req_item_id );
				if( req_item_id != 0 ){
				/*
				var family_id      = response[i].family_id;
				var section_id     = response[i].section_id;
				var division_id    = response[i].division_id;
				var subdivision_id = response[i].subdivision_id;
				var category_id    = response[i].category_id;
				var item_code_id   = response[i].item_code_id;
				*/
				var rfq_item_id           = response[i].rfq_item_id;
				var item_name             = response[i].item_name;
				var item_price            = parseFloat( response[i].item_price );
				var item_qty              = parseFloat( response[i].item_qty );
				var item_unit_name        = response[i].item_unit_name;
				var certificate_required  = response[i].certificate_required;
				
				
				var tr = '' + 
				'<tr id="itemo-' + rfq_item_id + '" class="item_list" idler="' + req_item_id + '">' + 
				'	<td><i title="Delete this item" onclick="delPl_Item(' + rfq_item_id + ');" class="fas fa-trash"></i></td>' + 
				'	<td>' + cc + '</td>' + 
				'	<td>' + item_name + '</td>' + 
				'	<td>' + 
				'		<input class="frmData item_qtys" ' + 
				'				id="new-item_qtys' + req_item_id + '" ' + 
				'				name="item_qtys[]" ' + 
				'				type="text" ' + 
				'				onClick="this.select();"' + 
				'				value="' + item_qty + '"' + 
				'				req="1" ' + 
				'				den="0" ' + 
				'				alerter="<?=lang("Please_Check_item_no", "AAR"); ?>.' + cc + ' QTY" readonly>' + 
				'	</td>' + 
				'	<td>' + item_unit_name + '</td>' + 
				'	<td>' + 
				'		<input class="frmData" ' + 
				'				id="new-item_id' + req_item_id + '" ' + 
				'				name="item_ids[]" ' + 
				'				type="hidden" ' + 
				'				value="' + req_item_id + '"' + 
				'				req="1" ' + 
				'				den="0" ' + 
				'				alerter="<?=lang("Please_Check_items", "AAR"); ?>">' + 
				'		<input class="frmData item_prices" ' + 
				'				id="new-item_prices' + req_item_id + '" ' + 
				'				name="item_prices[]" ' + 
				'				type="text" ' + 
				'				value="' + item_price + '"' + 
				'				onClick="this.select();"' + 
				'				req="1" ' + 
				'				den="0" ' + 
				'				alerter="<?=lang("Please_Check_item_no", "AAR"); ?>.' + cc + ' price">' + 
				'	</td>' + 
				'	<td>' + 
				'		<input id="new-total' + req_item_id + '" type="text" value="0" disabled>' + 
				'	</td>' + 
				'</tr>';
				
				$('#added_rfq_items').append(tr);
				}
				}
				
				$('.item_qtys').on( 'input', function(){
				cal_table();
				} );
				$('.item_prices').on( 'input', function(){
				cal_table();
				} );
				$('#pl-new-discount_amount').on( 'input', function(){
				// cal_table();
				} );
				$('#pl-new-is_vat_included').on( 'input', function(){
				cal_table();
				} );
				$('#pl-new-discount_per').on( 'input', function(){
				cal_table();
				} );
				
				cal_table();
				},
				error    :function(){
				end_loader();
				alert('Data Error No: 5467653');
				},
				});
				
				}
				
				
				
				
				
				
				
				
				
				
				
				
				
				function comparisonSheet(){
				var selItems = '';
				var CS_item = 0;
				var selctedCount = 0;
				
				// $('#rfqItems').html('');
				
				//take selected items
				$('.itemCheck').each( function(){
				
				if ($(this).is(":checked")) {
				selctedCount++;
				CS_item = $(this).attr('req_item');
				
				
				}
				});
				
				if( selctedCount == 0 ){
				alert("Please Select Items to View Comparison Sheet");
				} else if( selctedCount == 1 ) {
				//do code to load CS
				//FROM HERE CHAMP
				if( CS_item != 0 ){
				loadComparisonSheet( CS_item );
				}
				} else {
				alert("At least one item should be Selected to View Comparison Sheet");
				}
				
				}
				
				
				function loadComparisonSheet( ITM ){
				$('#fetched_CS').html( '' );
				start_loader("Loading Comparison Sheet Details...");
				$.ajax({
				url      :"<?=api_root; ?>requisitions/load_cs_details.php",
				data     :{ 'requisition_id': activeREQ, 'req_item_id': ITM },
				dataType :"html",
				type     :'POST',
				success  :function( response ){
				$('#fetched_CS').html( response );
				show_details('CSviewDetail', 'Comparison Sheet');
				end_loader();
				},
				error    :function(){
				end_loader();
				alert('Data Error No: 5467653');
				},
				});
				}
				
				
				
				function changeCsDecision( pl_record_id, req_item_id ){
				var aa = confirm('Are you sure, this will change the decision for this comparison sheet, action cannot be undone ?');
				if( aa == true ){
				var cd_notes = $('#cd_notes').val();
				if( cd_notes != '' ){
				start_loader("Changing Decision...");
				$.ajax({
				url      :"<?=api_root; ?>requisitions/price_lists/change_decision.php",
				data     :{ 'notes': cd_notes, 'pl_record_id': pl_record_id },
				dataType :"html",
				type     :'POST',
				success  :function( response ){
				//split response
				//alert user with reult
				//close details
				// 
				end_loader();
				var ARR = response.split('|');
				var res = parseInt( ARR[0] );
				if( res == 1 ){
				alert( ARR[1] );
				hide_details('CSviewDetail');
				loadComparisonSheet( req_item_id );
				} else {
				alert( ARR[1] );
				}
				
				},
				error    :function(){
				end_loader();
				alert('Data Error No: 5467653');
				},
				});
				} else {
				alert( "Please Inert reason for changing decision" );
				}
				}
				}
				
				
				function approvePriceListItem(  supplier_id,  rfq_id,  price_list_id,  req_item_id, requisition_id, pl_record_id){
				var aa = confirm('Are you sure, this will deny all other offers and approve this price, action cannot be undone ?');
				if( aa == true ){
				start_loader("Approving Offer...");
				$.ajax({
				url      :"<?=api_root; ?>requisitions/price_lists/approve_pl_item.php",
				data     :{ 'supplier_id': supplier_id, 'rfq_id': rfq_id, 'price_list_id': price_list_id, 'req_item_id': req_item_id, 'requisition_id': requisition_id, 'pl_record_id': pl_record_id },
				dataType :"html",
				type     :'POST',
				success  :function( response ){
				//split response
				//alert user with reult
				//close details
				// 
				end_loader();
				var ARR = response.split('|');
				var res = parseInt( ARR[0] );
				if( res == 1 ){
				alert( ARR[1] );
				hide_details('CSviewDetail');
				loadComparisonSheet( req_item_id );
				} else {
				alert( ARR[1] );
				}
				
				},
				error    :function(){
				end_loader();
				alert('Data Error No: 5467653');
				},
				});
				}
				}
				
				
				
				
				function step_backward( IDD ){
				var aa = confirm( 'Are you sure, this action cannot be undo ?' );
				if( aa == true && activeREQ != 0 ){
				start_loader('Sending Requisition...');
				$.ajax({
				url      :"<?=api_root; ?>requisitions/step_backward.php",
				data     :{ 'requisition_id': activeREQ },
				dataType :"html",
				type     :'POST',
				success  :function(data){
				end_loader();
				var aa = data.split('|');
				res = parseInt( aa[0] );
				if( res == 1 ){
				location.reload();
				} else {
				alert('Error - ' + aa[1]);
				}
				
				},
				error    :function(){
				end_loader();
				alert('Data Error No: 5467653');
				},
				});
				}
				}
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				</script>
				
				
				
				
				
				
				<!--    ///////////////////      View req details VIEW START    ///////////////////            -->
				<div class="DetailsViewer" id="viewItemDetails">
				<div class="viewerContainer">
				<div class="viewerHeader">
				<img src="<?=uploads_root; ?>/logo_icon.png" />
				<h1>REFREFREF</h1>
				<i onclick="hide_details('viewItemDetails');" class="fas fa-times"></i>
				</div>
				<div class="viewerBody">
				
				<?php
				include('requisition_header.php');
				?>
				
				
				<div class="tabs">
				<div class="tabsHeader">
				<div onclick="set_tabber(1);loadReqItems();" class="tabsIdSel-1 activeHeaderTab"><?=lang("Items", "AAR"); ?></div>
				<div onclick="set_tabber(5);loadRFQs();" class="tabsIdSel-5"><?=lang("RFQs_List", "AAR"); ?></div>
				<div onclick="set_tabber(6);loadApprovedSupps();" class="tabsIdSel-6"><?=lang("Compatative_Suppliers", "AAR"); ?></div>
				<div onclick="set_tabber(2);fetch_requisition_media();" class="tabsIdSel-2" style = "float:right;"><?=lang("Documents", "AAR"); ?></div>
				<div onclick="set_tabber(3);fetch_item_status(activeREQ, 'pur_requisitions');" class="tabsIdSel-3" style = "float:right;"><?=lang("Status_Change", "AAR"); ?></div>
				</div>
				<div class="tabsId-1 tabsBody tabsBodyActive">
				
				
				<table class="tabler" border="1">
				<thead>
				<tr>
				<th><input type="checkbox" id="selAll" onclick="selAllItems();" title="<?=lang("Select_All", "AAR"); ?>"></th>
				<th><?=lang("NO", "AAR"); ?></th>
				<th><?=lang("Item", "AAR"); ?></th>
				<th><?=lang("Stock", "AAR"); ?></th>
				<th><?=lang("Qty", "AAR"); ?></th>
				<th><?=lang("Days", "AAR"); ?></th>
				<th><?=lang("UOM", "AAR"); ?></th>
				<th style = "width: 10%;"><?=lang("Certificate", "AAR"); ?></th>
				<th>--</th>
				</tr>
				</thead>
				<tbody id="req_items"></tbody>
				</table>
				
				
				<div class="viewerBodyButtons">
				<button id="addNewReqItemBtn" type="button" onclick="show_details('NewItemDetails', 'Add_New_Item');"><?=lang("Add_Item", "AAR"); ?></button>
				<button type="button" onclick="generateRFQ();"><?=lang("RFQs", "AAR"); ?></button>
				<button type="button" onclick="comparisonSheet();"><?=lang("Comparison_Sheet", "AAR"); ?></button>
				</div>
				</div>
				
				<div class="tabsId-2 tabsBody">
				<div class="row">
				<?php include('../forms/requisitions/documents/add_new.php'); ?>
				</div>
				<table class="tabler">
				<thead>
				<tr>
				<th><?=lang("Preview","AAR"); ?></th>
				<th><?=lang("Link", "AAR"); ?></th>
				<th><?=lang("Date", "AAR"); ?></th>
				<th><?=lang("Description", "AAR"); ?></th>
				<th><?=lang("By", "AAR"); ?></th>
				<th><?=lang("Type","AAR"); ?></th>
				</tr>
				</thead>
				<tbody id="fetched_requisition_media"></tbody>
				</table>
				<script>
				function fetch_requisition_media(){
				start_loader("Loading Requisition Media ...");
				$('#fetched_ststus').html();
				$.ajax({
				url      :"<?=api_root; ?>requisitions/get_media.php",
				data     :{ 'requisition_id': activeREQ},
				dataType :"html",
				type     :'POST',
				success  :function(data){
				end_loader();
				$('#fetched_requisition_media').html(data);
				},
				error    :function(){
				alert('Data Error No: 5467653');
				},
				});
				
				}
				</script>
				</div>
				
				<div class="tabsId-3 tabsBody" id="fetched_status_change"></div>
				
				<div class="tabsId-5 tabsBody">
				<table class="tabler" border="1">
				<thead>
				<tr>
				<th><?=lang("NO", "AAR"); ?></th>
				<th><?=lang("Supplier", "AAR"); ?></th>
				<th><?=lang("Created_date", "AAR"); ?></th>
				<th>--</th>
				</tr>
				</thead>
				<tbody id="rfq_lists"></tbody>
				</table>
				</div>
				
				<div class="tabsId-6 tabsBody">
				<table class="tabler" border="1">
				<thead>
				<tr>
				<th><?=lang("NO", "AAR"); ?></th>
				<th><?=lang("Supplier", "AAR"); ?></th>
				<th>--</th>
				</tr>
				</thead>
				<tbody id="compSupp_lists"></tbody>
				</table>
				</div>
				
				</div>
				
				
				
				<div class="viewerBodyButtons">
				<button type="button" onclick="step_backward();"><?=lang("Step_Backward", "AAR"); ?></button>
				<button type="button" onclick="hide_details('viewItemDetails');"><?=lang("close", "AAR"); ?></button>
				</div>
				</div>
				</div>
				</div>
				<!--    ///////////////////      View req details VIEW END     ///////////////////            -->
				
				
				
				
				
				
				
				
				
				
				<!--    ///////////////////      NewItemDetails VIEW START    ///////////////////            -->
				<div class="DetailsViewer ViewerOnTop" id="NewItemDetails">
				<div class="viewerContainer">
				<div class="viewerHeader">
				<img src="<?=uploads_root; ?>/logo_icon.png" />
				<h1>REFREFREF</h1>
				<i onclick="hide_details('NewItemDetails');" class="fas fa-times"></i>
				</div>
				<div class="viewerBody">
				<?php include('../forms/requisitions/items/add_new.php'); ?>
				</div>
				</div>
				</div>
				<!--    ///////////////////      NewItemDetails VIEW END    ///////////////////            -->
				
				
				
				
				
				
				
				
				
				
				<!--    ///////////////////      CSviewDetail VIEW START    ///////////////////            -->
				<div class="DetailsViewer ViewerOnTop" id="CSviewDetail">
				<div class="viewerContainer">
				<div class="viewerHeader">
				<img src="<?=uploads_root; ?>/logo_icon.png" />
				<h1>REFREFREF</h1>
				<i onclick="hide_details('CSviewDetail');" class="fas fa-times"></i>
				</div>
				<div class="viewerBody" id="fetched_CS">fff</div>
				</div>
				</div>
				<!--    ///////////////////      CSviewDetail VIEW END    ///////////////////            -->
				
				
				
				
				
				<!--    ///////////////////      addPriceListDetails VIEW START    ///////////////////            -->
				<div class="DetailsViewer ViewerOnTop" id="addPriceListDetails">
				<div class="viewerContainer">
				<div class="viewerHeader">
				<img src="<?=uploads_root; ?>/logo_icon.png" />
				<h1>REFREFREF</h1>
				<i onclick="hide_details('addPriceListDetails');" class="fas fa-times"></i>
				</div>
				<div class="viewerBody">
				
				
				<?php
				include('../forms/price_lists/add_new.php');
				?>
				
				</div>
				</div>
				</div>
				<!--    ///////////////////      addPriceListDetails VIEW END    ///////////////////            -->
				
				
				
				
				
				
				
				
				
				<!--    ///////////////////      rfqDetails VIEW START    ///////////////////            -->
				<div class="DetailsViewer ViewerOnTop" id="rfqDetails">
				<div class="viewerContainer">
				<div class="viewerHeader">
				<img src="<?=uploads_root; ?>/logo_icon.png" />
				<h1>REFREFREF</h1>
				<i onclick="hide_details('rfqDetails');" class="fas fa-times"></i>
				</div>
				<div class="viewerBody">
				
				
				<form 
				id="add-new-rfq-form" 
				id-modal="add_new_requisition_rfq" 
				id-details="rfqDetails" 
				api="<?=api_root; ?>requisitions/rfqs/add_new_requisition_rfq.php">
				
				<input class="frmData" type="hidden" 
				id="rfq-requisition_id" 
				name="requisition_id" 
				value="" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_requisition", "AAR"); ?>">
				
				<div class="form-alerts"></div>
				<div class="zero"></div>
				
				<div id="rfqItems" style="display:none;" ></div>
				<div id="rfqSups" style="display:none;" ></div>
				
				<div class="viewerBodyButtons">
				<button type="button" onclick="createRFQs();"><?=lang("Create_RFQs", "AAR"); ?></button>
				<button type="button" onclick="hide_details('rfqDetails');"><?=lang("Cancel", "AAR"); ?></button>
				</div>
				<div class="filterSearchContainer text-left">
				<input class="filterSearch" tbl-id="supplierSelector" type="text" placeholder="Search..">
				</div>
				
				<table id="supplierSelector" class="tabler" border="1">
				
				
				<thead>
				<tr id="myHeader">
				<th><input type="checkbox" id="selAll" onclick="selAllItems();" title="<?=lang("Select_All", "AAR"); ?>"></th>
				<th><?=lang("Code", "AAR"); ?></th>
				<th><?=lang("Name", "AAR"); ?></th>
				<th><?=lang("Phone", "AAR"); ?></th>
				</tr>
				</thead>
				<tbody id="rfq_supps"></tbody>
				</table>
				
				</form>	
				
				
				</div>
				</div>
				</div>
				<!--    ///////////////////      rfqDetails VIEW END    ///////////////////            -->
				
				
				<!--    ///////////////////      add_new_modal Modal START    ///////////////////            -->
				<div class="modal" id="add_new_modal">
				<div class="modal-container">
				<div class="modal-header">
				<?php include("app/modal_header.php"); ?>
				</div>
				<div class="modal-body">
				<?php include('../forms/requisitions/add_new_requisition.php'); ?>
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
				
				</body>
				</html>											
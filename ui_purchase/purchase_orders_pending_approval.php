<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 2;
	$subPageID = 10;
	
	
	$supplier_id = 0;
	$requisition_id = 0;
	$loadDt = false;
	
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
	$qu_COUNT_sel = "SELECT count(`po_id`) FROM  `purchase_orders` WHERE ( (( `po_status` = 'pending_acc_approval' ) OR (`po_status` = 'pending_approval')  OR (`po_status` = 'activated')  OR (`po_status` = 'pending_man') )  $SERCHCOND  )";
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
		<?php
			
			$WHERE = "requisitions";
			include('app/header.php');
			//PAGE DATA START -----------------------------------------------///---------------------------------
		?>
		
		
		
		<div class="row">
			<div class="col-100">
				<div class="tableHolder">
					<div class="tableForm">
						<div class="tableFormGroup">
							<select id = "search_option">
								<option value = "" selected disabled> Select Column</option>
								<option value = "po_ref">PO REF</option>
								<option value = "supplier_id">Supplier</option>
								<option value = "po_date">Created date</option>
								<option value = "delivery_date">Delivery date</option>
								<option value = "requisition_id">Requisition</option>
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
							<div class="th"><?=lang("PO_REF", "AAR"); ?></div>
							<div class="th"><?=lang("REQ_REF", "AAR"); ?></div>
							<div class="th"><?=lang("Requester", "AAR"); ?></div>
							<div class="th"><?=lang("Supplier", "AAR"); ?></div>
							<div class="th"><?=lang("Created_date", "AAR"); ?></div>
							<div class="th"><?=lang("Delivery_date", "AAR"); ?></div>
							<div class="th"><?=lang("On_Whos_Desk", "AAR"); ?></div>
							<div class="th"><?=lang("Status", "AAR"); ?></div>
							<div class="th"><?=lang("Options", "AAR"); ?></div>
							
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
							
							var tr = '' + 
							'<div class = "tr" id="po-' + response[i].po_id + '">' + 
							'	<div class = "td">' + response[i].sno + '</div>' + 
							'	<div class = "td" onclick="showPoDetails(' + response[i].po_id + ", '" + response[i].po_ref  + "'" +  ", 'viewPOdetails'" + ');"><span id="joREF-'+response[i].po_id +'" class="text-primary">' + response[i].po_ref + '</span></div>' + 
							'	<div class = "td" onclick="showReqDetails(' + response[i].requisition_id + ", '" + response[i].reqRef  + "'" +  ", 'viewItemDetails'" + ');"><span id="joREF-'+response[i].requisition_id +'" class="text-primary cursored">' + response[i].reqRef + '</span></div>' + 
							'	<div class = "td">' + response[i].Requester + '</div>' + 
							'	<div class = "td">' + response[i].supplier + '</div>' + 
							'	<div class = "td">' + response[i].po_date + '</div>' + 
							'	<div class = "td">' + response[i].delivery_date + '</div>' + 
							'	<div class = "td">' + response[i].Desk + '</div>' + 
							'	<div class = "td">' + response[i].po_status + '</div>' + 
							'	<div class = "td">' + 
							'	<a title="Print PO" href="prints/po_print.php?po_id='+response[i].po_id+'" target="_blank"><i class="fas fa-print"></i></a>'+
							'		<button type="button" onclick="viewPriceHistory(' + response[i].po_id + ');"><?=lang("Price History", "AAR"); ?></button>' + 
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
	<script>
	
	function closehistory(){
				$('#history').hide();
			}
			
			function viewPriceHistory(po_id){
				
				$.ajax({
					url      :"<?=api_root; ?>purchase_orders/get_items.php",
					data     :{ 'po_id': po_id },
					dataType :"json",
					type     :'POST',
					success  :function( response ){
						end_loader();
						$('#history').show();
						$('#historybody').html('');
						//load items
						var cc = 0;
						for( i=0 ; i < response.length ; i ++ ){
							cc++;
							var po_item_id    = parseInt( response[i].po_item_id );
							if( po_item_id != 0 ){
								var family_id      = response[i].family_id;
								var section_id     = response[i].section_id;
								var division_id    = response[i].division_id;
								var subdivision_id = response[i].subdivision_id;
								var category_id    = response[i].category_id;
								var item_code_id   = response[i].item_code_id;
								var item_name      = response[i].item_name;
								viewItemDetails(family_id , section_id , division_id , subdivision_id , category_id , item_code_id, item_name);
								
							}
						}
					}
				});
			}
			
			function viewItemDetails(family_id, section_id, division_id, subdivision_id, category_id, item_code_id, item_name){
				$.ajax({
					type: "GET",
					url: "view_item_history.php",
					data     :{ 'family_id': family_id, 'section_id':section_id, 'division_id':division_id,'subdivision_id':subdivision_id,'category_id':category_id,'item_code_id':item_code_id},
					dataType :"json",
					success: function(response) {
						for( i=0 ; i < response.length ; i ++ ){
							var new_tr = '<tr>'+
							'<td>'+response[i].no+'</td>'+
							'<td>'+item_name+'</td>'+
							'<td>'+response[i].item_price+'</td>'+
							'<td>'+response[i].item_qty+'</td>'+
							'<td onclick="showPoDetails(' + response[i].po_id + ", '" +response[i].po_ref+ "'" +  ", 'viewPOdetails'" + ');"><span id="joREF-'+response[i].po_id +'" class="text-primary cursored">' +response[i].po_ref+ '</span></td>'+
							'<td>'+response[i].supplier_code+'</td>'+
							'	<div class = "td" </div>' + 
							
							'<td onclick="showReqDetails(' + response[i].requisition_id + ", '" +response[i].requisition_REF+ "'" +  ", 'viewItemDetails'" + ');"><span id="joREF-'+response[i].requisition_id +'" class="text-primary cursored">'+response[i].requisition_REF+'</span></td>'+
							'<td>'+response[i].po_date+'</td>'+
							'</tr>';
							$('#historybody').append(new_tr);
							
						}
						
						//show_details(viewPOdetails, item_name);	
					}
					
				});
			}
		var activePO = 0;
		function showPoDetails( po_id, po_ref, viewPOdetails ){
			po_id = parseInt( po_id );
			if( po_id != 0 ){
				activePO = po_id;
				//zero form
				
				//load form details
				start_loader("Loading PO Details...");
				$.ajax({
					url      :"<?=api_root; ?>purchase_orders/get_details.php",
					data     :{ 'po_id': activePO },
					dataType :"json",
					type     :'POST',
					success  :function( response ){
						end_loader();
						
						
						$('#' + viewPOdetails + ' .po_id').val(response[0].po_id);
						$('#' + viewPOdetails + ' .po_ref').val(response[0].po_ref);
						$('#' + viewPOdetails + ' .rev_no').val(response[0].rev_no);
						$('#' + viewPOdetails + ' .po_date').val(response[0].po_date);
						$('#' + viewPOdetails + ' .delivery_date').val(response[0].delivery_date);
						$('#' + viewPOdetails + ' .delivery_period_id').val(response[0].delivery_period_title);
						$('#' + viewPOdetails + ' .discount_percentage').val(response[0].discount_percentage);
						$('#' + viewPOdetails + ' .discount_amount').val(response[0].discount_amount);
						$('#' + viewPOdetails + ' .is_vat_included').val(response[0].is_vat_included);
						$('#' + viewPOdetails + ' .payment_term_id').val(response[0].payment_term_title);
						$('#' + viewPOdetails + ' .currency_id').val(response[0].currency_name);
						$('#' + viewPOdetails + ' #cur_name_view').html(response[0].currency_name);
						$('#' + viewPOdetails + ' .exchange_rate').val(response[0].exchange_rate);
						$('#' + viewPOdetails + ' .supplier_quotation_ref').val(response[0].supplier_quotation_ref);
						// $('#' + viewPOdetails + ' .attached_supplier_quotation').val(response[0].attached_supplier_quotation);
						$('#' + viewPOdetails + ' .notes').val(response[0].notes);
						$('#' + viewPOdetails + ' .po_status').val(response[0].po_status);
						$('#' + viewPOdetails + ' .supplier_id').val(response[0].supplier_name);
						$('#' + viewPOdetails + ' .requisition_id').val(response[0].requisition_ref);
						$('#' + viewPOdetails + ' .job_order_id').val(response[0].job_order_id);
						$('#' + viewPOdetails + ' .job_order_project').val(response[0].project);
						$('#' + viewPOdetails + ' .employee_id').val(response[0].employee_id);
						$('#' + viewPOdetails + ' .requisition_id').attr('onclick', 'showReqDetails(' + response[0].requisition_id + ", '" + response[0].requisition_ref + "'," +"'viewItemDetails'" + ')' );
							
						//load items
						loadPOItems('disabled');
						notificationMenu();
							
					},
					error    :function(){
						end_loader();
						alert('Data Error No: 5467653');
					},
				});
				
				
				//load PO items
				
				
				show_details(viewPOdetails, po_ref);
			}
		}
		
		
		
		
		function activatePO(){
			start_loader();
			var aa = confirm("Are You Sure, this will activate the current PO ?");
			if( aa == true ){
				$.ajax({
					url      :"<?=api_root; ?>purchase_orders/activate_po.php",
					data     :{ 'po_id': activePO },
					dataType :"html",
					type     :'POST',
					success  :function(data){
						dt_arr = data.split('|');
						dt_res = parseInt(dt_arr[0]);
						if(dt_res == 1){
							location.reload();
							} else {
							alert(dt_arr[1]);
						}
					},
					error    :function(){
						alert('Data Error No: 5467653');
					},
				});
				} else {
				end_loader();
			}
		}
		
		
		
		
		function loadPOItems(inputClass){
			start_loader('Loading PO Items...');
			$.ajax({
				url      :"<?=api_root; ?>purchase_orders/get_items.php",
				data     :{ 'po_id': activePO },
				dataType :"json",
				type     :'POST',
				success  :function( response ){
					end_loader();
					$('#added_PO_view_items').html('');
					//load items
					var cc = 0;
					for( i=0 ; i < response.length ; i ++ ){
						cc++;
						var po_item_id    = parseInt( response[i].po_item_id );
						if( po_item_id != 0 ){
							/*
								var family_id      = response[i].family_id;
								var section_id     = response[i].section_id;
								var division_id    = response[i].division_id;
								var subdivision_id = response[i].subdivision_id;
								var category_id    = response[i].category_id;
								var item_code_id   = response[i].item_code_id;
							*/
							var item_name        = response[i].item_name;
							var item_qty         = parseFloat( response[i].item_qty );
							var item_price       = parseFloat( response[i].item_price );
							var item_unit_name   = response[i].item_unit_name;
							var item_days      = response[i].item_days;
								var is_materialREQ = response[i].is_material;
								var item_days_v = '';
								if( is_materialREQ == 1 ){
									item_days_v = '--';
									} else {
									item_days_v = item_days;
								}
							var thsTot = item_qty * item_price;
							var tr = '' + 
							'				<tr id="poItem-' + po_item_id + '" class="po_view_item_list" idler="' + po_item_id + '">' + 
							'					<input class="frmData"' + 
							'							id="view-po_item_id' + po_item_id + '"' + 
							'							name="item_ids[]"' + 
							'							type="hidden"' + 
							'							value="' + po_item_id + '"' + 
							'							req="1"' + 
							'							den="0"' + 
							'							alerter="<?=lang("Please_Check_items", "AAR"); ?>">' + 
							'					<td>' + cc + '</td>' + 
							'					<td>' + item_name + '</td>' + 
							'					<td style="widtd:10%;">' + 
							'						<input class="frmData item_qtys" ' + 
							'								id="view-po_item_qty' + po_item_id + '" ' + 
							'								name="item_qtys[]" ' + 
							'								type="text" ' + 
							'								value="' + item_qty + '" ' + 
							'								onclick="this.select();" ' + 
							'								req="1" ' + 
							'								den="0" ' + 
							'								alerter="<?=lang("Please_Check_items", "AAR"); ?>" ' + inputClass + '>' + 
							'					</td>' + 
							'					<td>' + item_unit_name + '</td>' +
							'					<td>' + item_days_v + '</td>' +
							'					<td>' + 
							'						<input class="frmData item_prices" ' + 
							'								id="view-po_item_price' + po_item_id + '" ' + 
							'								name="item_prices[]" ' + 
							'								type="text" ' + 
							'								value="' + item_price + '" ' + 
							'								onclick="this.select();" ' + 
							'								req="1" ' + 
							'								den="0" ' + 
							'								alerter="<?=lang("Please_Check_items", "AAR"); ?>" ' + inputClass + '>' + 
							'					</td>' + 
							'					<td>' + 
							'						<input class="" ' + 
							'								id="view-po_item_tot' + po_item_id + '" ' + 
							'								name="item_tots[]" ' + 
							'								type="text" ' + 
							'								value="' + thsTot + '" ' + 
							'								onclick="this.select();" ' + 
							'								req="1" ' + 
							'								den="0" ' + 
							'								alerter="<?=lang("Please_Check_items", "AAR"); ?>" disabled>' + 
							'					</td>' + 
							'				</tr>';
							
							$('#added_PO_view_items').append(tr);
						}
					}
					cal_view_table();
					
				},
				error    :function(){
					end_loader();
					alert('Data Error No: 5467653');
				},
			});
		}
		
		var activeREQ = 0;
		var ReqStatus = '';
		
		function showReqDetails( reqID, reqRef , detailsView ){
			reqID = parseInt( reqID );
			$('#new-requisition_id').val(reqID);
			$('#new-file-requisition_id').val(reqID);
			$('#req_items').html('');
			$('#rfq_supps').html('');
			$('#rfqSups').html('');
			$('#rfq_lists').html('');
			$('#addNewReqItemBtn').css('display', 'inline-block');
			
			
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
							var certificate_required     = response[i].certificate_required;
							var item_unit_id   = response[i].item_unit_id;
							var item_stock_qty = 0;
							var item_days      = response[i].item_days;
								var is_materialREQ = response[i].is_material;
								
								
								
								var item_days_v = '';
								if( is_materialREQ == 1 ){
									item_days_v = '--';
									} else {
									item_days_v = item_days;
								}
							var reqOpts = '';
							if( ReqStatus == 'draft' ){
								reqOpts = '<i title="Delete this item" onclick="delReqItem(' + req_item_id + ');" class="fas fa-trash"></i>';
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
	</script>
	
	
	
	
	
	
	<!--    ///////////////////      viewPOdetails details VIEW START    ///////////////////            -->
	<div class="DetailsViewer" id="viewPOdetails">
		<div class="viewerContainer">
			<div class="viewerHeader">
				<img src="<?=uploads_root; ?>/logo_icon.png" />
				<h1>viewPOdetails</h1>
				<i onclick="hide_details('viewPOdetails');" class="fas fa-times"></i>
			</div>
			<div class="viewerBody" id="po_view_details">
				<?php
					require_once('../forms/purchase_orders/view_po_details.php');
				?>
			</div>
		</div>
	</div>
	<!--    ///////////////////     viewPOdetails details END     ///////////////////            -->
	
	
	
	<!--    ///////////////////      addNewPOMandetails details VIEW START    ///////////////////            -->
	<div class="DetailsViewer" id="addNewPOMandetails">
		<div class="viewerContainer">
			<div class="viewerHeader">
				<img src="<?=uploads_root; ?>/logo_icon.png" />
				<h1>addNewPOMandetails</h1>
				<i onclick="hide_details('addNewPOMandetails');" class="fas fa-times"></i>
			</div>
			<div class="viewerBody">
				<?php
					require_once('../forms/purchase_orders/add_new_from_man.php');
				?>
			</div>
		</div>
	</div>
	<!--    ///////////////////      addNewPOMandetails details END     ///////////////////            -->
	
	
	
	
	<!--    ///////////////////      addNewPOfromPLdetails details VIEW START    ///////////////////            -->
	<div class="DetailsViewer" id="addNewPOfromPLdetails">
		<div class="viewerContainer">
			<div class="viewerHeader">
				<img src="<?=uploads_root; ?>/logo_icon.png" />
				<h1>addNewPOfromPLdetails</h1>
				<i onclick="hide_details('addNewPOfromPLdetails');" class="fas fa-times"></i>
			</div>
			<div class="viewerBody">
				<?php
					require_once('../forms/purchase_orders/add_new_from_pl.php');
				?>
			</div>
		</div>
	</div>
	<!--    ///////////////////      addNewPOfromPLdetails details END     ///////////////////            -->
	
	<!--    ///////////////////      viewPOdetails details VIEW START    ///////////////////            -->
		<div class = "history" id = "history" style = "height: 300px;margin-left: 1.5%;overflow:auto;">
			History
			<i class="fas fa-times" onclick = "closehistory();" style = "float: right;margin-right: 2%;margin-top: 1%;"></i>
			<div class="table">
				<div class = "tableHeader">
					<div class = "tr">
						<div class = "th"><?=lang('No.'); ?></div>
						<div class = "th"><?=lang('name'); ?></div>
						<div class = "th"><?=lang('item_price'); ?></div>
						<div class = "th"><?=lang('item_qty'); ?></div>
						<div class = "th"><?=lang('po_ref'); ?></div>
						<div class = "th"><?=lang('supplier_code'); ?></div>
						<div class = "th"><?=lang('requisition_REF'); ?></div>
						<div class = "th"><?=lang('po_date'); ?></div>
						
					</div>
				</div>
				<div class = "tableBody" id = "historybody">
				</div>
			</div>
			
		</div>
		<!--    ///////////////////     View Item History details END     ///////////////////            -->
		
	
	<!--    ///////////////////      View req details VIEW START    ///////////////////            -->
	<div class="DetailsViewer" id="viewItemDetails">
		<div class="viewerContainer">
			<div class="viewerHeader">
				<img src="<?=uploads_root; ?>/logo_icon.png" />
				<h1>REFREFREF</h1>
				<i onclick="hide_details('viewItemDetails');" class="fas fa-times"></i>
			</div>
			<div class="viewerBody">
				
				<div class="row col-33">
					<div class="nwFormGroup">
						<label><?=lang("job_order", "AAR"); ?></label>
						<input type="text" class="job_order_id readOnly">
					</div>
					<div class="nwFormGroup">
						<label><?=lang("Project_Name", "AAR"); ?></label>
						<input type="text" class="project_no readOnly">
					</div>
					<div class="nwFormGroup">
						<label><?=lang("required_date", "AAR"); ?></label>
						<input type="text" class="required_date readOnly">
					</div>
					
					
					<!--
						<div class="nwFormGroup">
						<label><?=lang("Requisition_Type", "AAR"); ?></label>
						<input type="text" class="requisition_type important">
						</div>
					-->
				</div>
				
				<div class="row col-33">
					<div class="nwFormGroup">
						<label><?=lang("created_by", "AAR"); ?></label>
						<input type="text" class="ordered_by important">
					</div>
					<div class="nwFormGroup">
						<label><?=lang("Created_date", "AAR"); ?></label>
						<input type="text" class="created_date important">
					</div>
					<div class="nwFormGroup">
						<label><?=lang("requisition_status", "AAR"); ?></label>
						<input type="text" class="requisition_status important">
					</div>
					<!--div class="nwFormGroup">
						<label><?=lang("estimated_date", "AAR"); ?></label>
						<input type="text" class="estimated_date readOnly">
					</div-->
				</div>
				
				<div class="row col-33">
					<!--div class="nwFormGroup">
						<label><?=lang("requisition_id", "AAR"); ?></label>
						<input type="text" class="requisition_id readOnly">
					</div-->
					<div class="nwFormGroup">
						<label><?=lang("requisition_notes", "AAR"); ?></label>
						<textarea class="requisition_notes readOnly" rows="6"></textarea>
					</div>
				</div>
				<div class="zero"></div>
				
				<div class="tabs">
					<div class="tabsHeader">
						<div onclick="set_tabber(1);loadReqItems();" class="tabsIdSel-1 activeHeaderTab"><?=lang("Items", "AAR"); ?></div>
						<div onclick="set_tabber(2);fetch_requisition_media();" class="tabsIdSel-2"><?=lang("Documents", "AAR"); ?></div>
						<div onclick="set_tabber(3);fetch_item_status(activeREQ, 'pur_requisitions');"" class="tabsIdSel-3"><?=lang("Status_Change", "AAR"); ?></div>
					</div>
					<div class="tabsId-1 tabsBody tabsBodyActive">
						
						
						<table class="tabler" border="1">
							<thead>
								<tr>
									<th>---</th>
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
				</div>
				
				
				
				<div class="viewerBodyButtons">
					<button id="addNewReqItemBtn" type="button" onclick="show_details('NewItemDetails', 'Add_New_Item');"><?=lang("Add_Item", "AAR"); ?></button>
					<button type="button" onclick="hide_details('viewItemDetails');"><?=lang("close", "AAR"); ?></button>
				</div>
			</div>
		</div>
	</div>
	<!--    ///////////////////      View req details VIEW END     ///////////////////            -->
	
	
	
</body>
</html>
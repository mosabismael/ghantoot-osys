<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	$menuId = 7;
	$subPageID = 15;
	
	
	
	
	
	$jo_id = 0;
	$COND01 = "";
	
	if( isset( $_GET['jo_id'] ) ){
		$jo_id = ( int ) test_inputs( $_GET['jo_id'] );
		if( $jo_id != 0 ){
			$COND01 = "AND (`job_order_id` = '$jo_id')";
		}
	}
	
	
	
	$date_from = "";
	$COND02 = "";
	
	if( isset( $_GET['date_from'] ) ){
		$date_from = test_inputs( $_GET['date_from'] );
		if( $date_from != "" ){
			$COND01 = $COND01 . "AND (`po_date` >= '$date_from')";
		}
	}
	
	$date_to = "";
	$COND03 = "";
	
	if( isset( $_GET['date_to'] ) ){
		$date_to = test_inputs( $_GET['date_to'] );
		if( $date_to != "" ){
			$COND01 = $COND01 . "AND (`po_date` <= '$date_to')";
		}
	}
	
	
	
	
	
	
	$page = 1;
	$showPerPage = 20;
	$totPages = 0;
	$qu_COUNT_sel = "SELECT COUNT(`po_id`) FROM  `purchase_orders` WHERE ( ((`po_status` <> 'draft') AND (`po_status` <> 'deleted')) $COND01  ) ORDER BY `po_id` DESC";
	
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
		
		<?php
		?>
		
		
		
		<div class="row">
			<div class="col-100">
				<form action="material_costing.php" method="GET">
					
					
					<div class="col-25">
						<div class="nwFormGroup">
							<label><?=lang("Date_From:", "AAR"); ?></label>
							<input class="frmData has_date" value="<?=$date_from; ?>" id="new-date_from" name="date_from">
						</div>
						<div class="zero"></div>
					</div>
					<div class="col-25">
						<div class="nwFormGroup">
							<label><?=lang("Date_To:", "AAR"); ?></label>
							<input class="frmData has_date" value="<?=$date_to; ?>" id="new-date_to" name="date_to">
						</div>
						<div class="zero"></div>
					</div>
					
					
					<div class="col-25">
						<div class="nwFormGroup">
							<label><?=lang("Job_Order:", "AAR"); ?></label>
							<select class="frmData" id="new-job_order_id" name="jo_id">
								<option value="0" selected><?=lang("All", "غير محدد"); ?></option>
								<?php
									$sNo = 0;
									$qu_job_orders_sel = "SELECT * FROM  `job_orders` ORDER BY `job_order_ref` ASC";
									$qu_job_orders_EXE = mysqli_query($KONN, $qu_job_orders_sel);
									if(mysqli_num_rows($qu_job_orders_EXE)){
										while($job_orders_REC = mysqli_fetch_assoc($qu_job_orders_EXE)){
											$job_order_id  = ( int ) $job_orders_REC['job_order_id'];
											$job_order_ref = $job_orders_REC['job_order_ref'];
											
										?>
										<option value="<?=$job_order_id; ?>"><?=$job_order_ref; ?></option>
										<?php
										}
									}
								?>
							</select>
							<script>
								$('#new-job_order_id').val(<?=$jo_id; ?>);
							</script>
						</div>
						<div class="zero"></div>
					</div>
					
					<div class="col-25">
						<div class="nwFormGroup">
							<br>
							<button type="submit">&nbsp;&nbsp;&nbsp;&nbsp;<?=lang("Search", "AAR"); ?>&nbsp;&nbsp;&nbsp;&nbsp;</button>
						</div>
						<div class="zero"></div>
					</div>
					<div class="zero"></div>
					
				</form>
			</div>
			<div class="col-100">
				
				
				<!-- NEW TABLE START -->
				<div class="tableHolder">
					<!--div class="tableForm">
						<div class="tableFormGroup">
						<input type="text" name="searcher" />
						</div>
					</div-->
					<div class="table">
						<div class="tableHeader">
							<div class="tr">
								<div class="th"><?=lang("NO.", "AAR"); ?></div>
								<div class="th"><?=lang("Item_Description", "AAR"); ?></div>
								<div class="th"><?=lang("UOM", "AAR"); ?></div>
								<div class="th"><?=lang("REQ_No", "AAR"); ?></div>
								<div class="th"><?=lang("REQ_Date", "AAR"); ?></div>
								<div class="th"><?=lang("PO_No", "AAR"); ?></div>
								<div class="th"><?=lang("Job_No", "AAR"); ?></div>
								<div class="th"><?=lang("Unit_Rate", "AAR"); ?></div>
								<div class="th"><?=lang("QTY", "AAR"); ?></div>
								<div class="th"><?=lang("Amount", "AAR"); ?></div>
								<div class="th"><?=lang("Supplier", "AAR"); ?></div>
							</div>
						</div>
						<div class="tableBody" id="tableBody"></div>
					</div>
					<div class="tablePagination">
						<div class="pageNum arrowPager" id="prePatchBtn" onclick="showPrePageBatch('ui_operation/<?=basename($_SERVER['PHP_SELF']); ?>', <?=$showPerPage; ?>, <?=$totPages; ?>, <?=$COND?>);"><i class="fas fa-angle-double-left"></i></div>
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
						var sthsSearchCond = <?php echo json_encode($COND01);?>;
						function bindData( response ){
							$('#tableBody').html('');
							var cc = 0;
							var totalAmount = 0;
							for( i=0 ; i < response.length ; i ++ ){
								cc++;
								var tr = '' + 
								'<div class = "tr" id="req-' + response[i].po_id + '">' + 
								'	<div class = "td">' + response[i].sno + '</div>' + 
								'	<div class = "td">' + response[i].Item_Description + '</div>' + 
								'	<div class = "td">' + response[i].Item_UOM + '</div>' + 
								'	<div class = "td" onclick="showReqDetails(' + response[i].requisition_id + ", '" + response[i].requisition_ref  + "'" +  ", 'viewItemDetails'" + ');"><span id="reqREF-'+response[i].requisition_id+'" class="text-primary cursored">' + response[i].requisition_ref + '</span> </div>' + 
								'	<div class = "td">' + response[i].REQ_created_date + '</div>' + 
								'	<div class = "td" onclick="showPoDetails(' + response[i].po_id + ", '" + response[i].PO_REF  + "'" +  ", 'viewPOdetails'" + ');"><span id="joREF-'+response[i].po_id +'" class="text-primary cursored">' +  response[i].PO_REF + '</span></div>' + 
								'	<div class = "td">' + response[i].job_order_ref + '</div>' + 
								'	<div class = "td">' + response[i].item_price + '</div>' + 
								'	<div class = "td">' + response[i].item_qty + '</div>' + 
								'	<div class = "td">' + response[i].Amount + '</div>' + 
								'	<div class = "td">' + response[i].supplier + '</div>' + 
								'</div>';
								$('#tableBody').append( tr );
								totalAmount += parseFloat(response[i].Amount);
							}
							
							var tr = '<div class = "tr">'+
							'<div class = "td"></div>'+
							'<div class = "td"></div>'+
							'<div class = "td"></div>'+
							'<div class = "td"></div>'+
							'<div class = "td"></div>'+
							'<div class = "td"></div>'+
							'<div class = "td"></div>'+
							'<div class = "td"></div>'+
							'<div class ="td" style = "font-size: 25px;">Amount:</div>'+
							'<div class = "td" style = "font-size: 25px;">'+totalAmount+'</div>'+
							'<div class = "td"></div>'+
							'</div>';
							$('#tableBody').append(tr);
						}
						
						
					</script>
				</div>
				<!-- NEW TABLE END -->
				
				
			</div>
			<div class="zero"></div>
		</div>
		
		
		<?php
			//PAGE DATA END   ----------------------------------------------///---------------------------------
			include('app/footer.php');
		?>
		
		
		
		
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
		<script>
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
							$('#' + viewPOdetails + ' .created_by').val(response[0].employee_name);
							
							$('#' + viewPOdetails + ' .requisition_id').attr('onclick', 'showReqDetails(' + response[0].requisition_id + ", '" + response[0].requisition_ref + "'," +"'viewItemDetails'" + ')' );
							
							
							//load items 
							loadPOItems('disabled');
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
								var item_days      = response[i].item_days;
								var is_materialREQ = response[i].is_material;
								var item_stock_qty = 0;
								
								var reqOpts = '';
								if( ReqStatus == 'draft' ){
									reqOpts = '<i title="Delete this item" onclick="delReqItem(' + req_item_id + ');" class="fas fa-trash"></i>';
								}
								var item_days_v = '';
								if( is_materialREQ == 1 ){
									item_days_v = '--';
									} else {
									item_days_v = item_days;
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
							require_once('../forms/purchase_orders/view_po_details_view.php');
							?>
							</div>
							</div>
							</div>
							<!--    ///////////////////     viewPOdetails details END     ///////////////////            -->
							
							
							
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
							
							</body>
							</html>														
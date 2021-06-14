<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 7;
	$subPageID = 14;
	
	
	$reqArr = explode('&',  $_SERVER['QUERY_STRING'] );
	$totReq = "";
	foreach( $reqArr as $getReq ){
		$thsReqArr = explode('=',  $getReq );
		if( $thsReqArr[0] == 'page' ){
			
			} else {
			$totReq = $totReq.'&'.$getReq;
		}
	}
	
	
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
			$jo_id = 0;
			$COND01 = "";
			
			if( isset( $_GET['jo_id'] ) ){
				$jo_id = ( int ) test_inputs( $_GET['jo_id'] );
				if( $jo_id != 0 ){
					$COND01 = "AND (`job_order_id` = '$jo_id')";
				}
			}
			$cond05 = "";
			if( isset( $_GET['item_name'] ) ){
				$item_name = ( int ) test_inputs( $_GET['item_name'] );
				if( $item_name != 0 ){
					$cond05 = "AND (`req_item_id` = '$item_name')";
				}
			}
			
			$date_from = "";
			$COND02 = "";
			
			if( isset( $_GET['date_from'] ) ){
				$date_from = test_inputs( $_GET['date_from'] );
				if( $date_from != "" ){
					$COND02 = "AND (`created_date` >= '$date_from')";
				}
			}
			
			$date_to = "";
			$COND03 = "";
			
			if( isset( $_GET['date_to'] ) ){
				$date_to = test_inputs( $_GET['date_to'] );
				if( $date_to != "" ){
					$COND03 = "AND (`created_date` <= '$date_to')";
				}
			}
			
			
			
			
			
			
			
			
			
			$page = 1;
			$showPerPage = 10;
			$totPages = 0;
			
			
			
			
			
			$qu_COUNT_sel = "SELECT COUNT(`requisition_id`) FROM  `pur_requisitions` WHERE ( ((`requisition_status` <> 'draft') AND (`requisition_status` <> 'deleted')) $COND01 $COND02 $COND03 ) ORDER BY `requisition_id` DESC";
			$qu_COUNT_EXE = mysqli_query($KONN, $qu_COUNT_sel);
			if(mysqli_num_rows($qu_COUNT_EXE)){
				$job_COUNT_DATA = mysqli_fetch_array($qu_COUNT_EXE);
				$totPages = ( int ) $job_COUNT_DATA[0];
			}
			$totPages = ceil($totPages / $showPerPage);
			
			
			
			
			
			
			if( isset( $_GET['page'] ) ){
				$page = ( int ) test_inputs( $_GET['page'] );
			}
			/*
				if( isset( $_POST['showperpage'] ) ){
				$showPerPage = ( int ) test_inputs( $_POST['showperpage'] );
				}
			*/
			
			$start=abs(($page-1)*$showPerPage);
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
		?>
		
		<div class="row">
			<div class="col-100">
				<form action="material_tracking.php" method="GET">
					
					
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
							<label><?=lang("Item_Name:", "AAR"); ?></label>
							<select class="frmData" id="new-item_name" name="item_name">
								<option value="0" selected><?=lang("All", "غير محدد"); ?></option>
								<?php
									$q = "SELECT * FROM  `pur_requisitions_items`";
									$q_exe = mysqli_query($KONN, $q);
									
									if(mysqli_num_rows($q_exe) != 0){
										
										while( $ARRAY_SRC = mysqli_fetch_assoc($q_exe) ){
											$Item_UOM = get_unit_name( $ARRAY_SRC['item_unit_id'], $KONN );
											
											$Item_Description = get_item_description_dashed( $ARRAY_SRC['req_item_id'], 'req_item_id', 'pur_requisitions_items', $KONN );
											
										?>
										<option value="<?=$ARRAY_SRC['req_item_id']; ?>"><?=$Item_Description?></option>
										<?php
										}
									}
								?>
							</select>
							<script>
								$('#new-item_name').val(<?=$item_name; ?>);
							</script>
						</div>
						<div class="zero"></div>
					</div>
					
					<div class="col-25" >
						<div class="nwFormGroup">
							<br>
							<button type="submit" >&nbsp;&nbsp;&nbsp;&nbsp;<?=lang("Search", "AAR"); ?>&nbsp;&nbsp;&nbsp;&nbsp;</button>
						</div>
						<div class="zero"></div>
					</div>
					<div class="zero"></div>
					
				</form>
			</div>
			<div class="col-100">
				
				<div class="table">
					<div class="tableHeader">
						<div class="tr">
							<div class="th"><?=lang("Item_Description", "AAR"); ?></div>
							<div class="th"><?=lang("REQ_No", "AAR"); ?></div>
							<div class="th"><?=lang("REQ_Stt", "AAR"); ?></div>
							<div class="th"><?=lang("REQ_Date", "AAR"); ?></div>
							<div class="th"><?=lang("PO_No", "AAR"); ?></div>
							<div class="th"><?=lang("Job_No", "AAR"); ?></div>
							<div class="th"><?=lang("Req_Qty", "AAR"); ?></div>
							<div class="th"><?=lang("Arrived<br>QTY", "AAR"); ?></div>
							<div class="th"><?=lang("under_inspection", "AAR"); ?></div>
							<div class="th"><?=lang("Rejected<br>QTY", "AAR"); ?></div>
							<div class="th"><?=lang("Receieved<br>QTY", "AAR"); ?></div>
						</div>
					</div>
					<div class="tableBody" id="tableBody">
						<?php
							
							$sNo = 0;
							$inspected_Qty = 0;
							$Recieved_Qty = 0;
							$qu_pur_requisitions_sel = "SELECT * FROM  `pur_requisitions` WHERE ( ((`requisition_status` <> 'draft') AND (`requisition_status` <> 'deleted')) $COND01 $COND02 $COND03 ) ORDER BY `requisition_id` DESC LIMIT $start,$showPerPage";
							$qu_pur_requisitions_EXE = mysqli_query($KONN, $qu_pur_requisitions_sel);
							if(mysqli_num_rows($qu_pur_requisitions_EXE)){
								while($pur_requisitions_REC = mysqli_fetch_assoc($qu_pur_requisitions_EXE)){
									$inspected_Qty = 0;
									$Recieved_Qty = 0;
									$sNo++;
									$requisition_id = $pur_requisitions_REC['requisition_id'];
									$requisition_ref = $pur_requisitions_REC['requisition_ref'];
									$requisition_type = $pur_requisitions_REC['requisition_type'];
									$requisition_status = $pur_requisitions_REC['requisition_status'];
									$requisition_notes = $pur_requisitions_REC['requisition_notes'];
									$ordered_by = $pur_requisitions_REC['ordered_by'];
									$dateArr = explode(' ', $pur_requisitions_REC['created_date'] );
									
									$REQ_created_date = $dateArr[0];
									
									$BY = get_emp_name($KONN, $ordered_by );
									$Item_Description = "NA";
									$Item_UOM = "NA";
									$PO_REF = "NA";
									$job_order_ref = "NA";
									$Req_Qty = 0;
									$Del_Qty = 0;
									$Del_Date = "NA";
									$Del_Status = "Pending PO";
									$Rejected_Qty = 0;
									
									
									$job_order_id = $pur_requisitions_REC['job_order_id'];
									$project = "";
									if( $job_order_id != 0 ){
										$qu_job_orders_sel = "SELECT * FROM  `job_orders` WHERE `job_order_id` = $job_order_id";
										$qu_job_orders_EXE = mysqli_query($KONN, $qu_job_orders_sel);
										$job_orders_DATA;
										if(mysqli_num_rows($qu_job_orders_EXE)){
											$job_orders_DATA = mysqli_fetch_assoc($qu_job_orders_EXE);
										}
										$job_order_ref = $job_orders_DATA['job_order_ref'];
										$project_name = $job_orders_DATA['project_name'];
									}
									
									
									//get PO details
									$qu_purchase_orders_sel = "SELECT * FROM  `purchase_orders` WHERE `requisition_id` = $requisition_id";
									$qu_purchase_orders_EXE = mysqli_query($KONN, $qu_purchase_orders_sel);
									$po_id = 0;
									$PO_STATUS = '';
									if(mysqli_num_rows($qu_purchase_orders_EXE)){
										$purchase_orders_DATA = mysqli_fetch_assoc($qu_purchase_orders_EXE);
										$po_id = ( int ) $purchase_orders_DATA['po_id'];
										$PO_REF = $purchase_orders_DATA['po_ref'];
										$rev_no = $purchase_orders_DATA['rev_no'];
										$po_date = $purchase_orders_DATA['po_date'];
										$delivery_date = $purchase_orders_DATA['delivery_date'];
										$PO_STATUS = $purchase_orders_DATA['po_status'];
										$Del_Status = $PO_STATUS;
									}
									
									//items loop start
									$q = "SELECT * FROM  `pur_requisitions_items` WHERE `requisition_id` = $requisition_id $cond05;" ;
									$q_exe = mysqli_query($KONN, $q);
									if(mysqli_num_rows($q_exe) != 0){
										
										while( $ARRAY_SRC = mysqli_fetch_assoc($q_exe) ){
											$Item_UOM = get_unit_name( $ARRAY_SRC['item_unit_id'], $KONN );
											
											$Req_Qty = $ARRAY_SRC['item_qty'];
											
											$family_id = $ARRAY_SRC['family_id'];
											$lv2 = $ARRAY_SRC['section_id'];
											$lv3 = $ARRAY_SRC['division_id'];
											$lv4 = $ARRAY_SRC['subdivision_id'];
											$lv5 = $ARRAY_SRC['category_id'];
											$lv6 = $ARRAY_SRC['item_code_id'];
											
											$Item_Description = get_item_description_dashed( $ARRAY_SRC['req_item_id'], 'req_item_id', 'pur_requisitions_items', $KONN );
											$po_item_id = 0;		
											//get po item id
											$qu_purchase_orders_items_sel = "SELECT `po_item_id`, `item_status`, `item_qty`, `item_qty_rec` FROM  `purchase_orders_items` WHERE 
											((`family_id` = $family_id) AND 
											(`section_id` = $lv2) AND 
											(`division_id` = $lv3) AND 
											(`subdivision_id` = $lv4) AND 
											(`category_id` = $lv5) AND 
											(`item_code_id` = $lv6) AND 
											(`po_id` = $po_id))";
											$qu_purchase_orders_items_EXE = mysqli_query($KONN, $qu_purchase_orders_items_sel);
											$Ful_Qty = 0;
											$Del_Qty = 0;
											$stock_status = '';
											if(mysqli_num_rows($qu_purchase_orders_items_EXE)){
												$purchase_orders_items_DATA = mysqli_fetch_assoc($qu_purchase_orders_items_EXE);
												$po_item_id  = $purchase_orders_items_DATA['po_item_id'];
												$item_status = $purchase_orders_items_DATA['item_status'];
												$Ful_Qty = ( double ) $purchase_orders_items_DATA['item_qty'];
												$Del_Qty = ( double ) $purchase_orders_items_DATA['item_qty_rec'];
												$Del_Status = $item_status;
												if( ($item_status == 'partial_arrived') || ($item_status == 'fully_arrived') ){
													
													//get stock status
													$qu_inv_stock_sel = "SELECT `stock_status`, `qty` FROM  `inv_stock` WHERE ((`po_item_id` = $po_item_id) AND (`po_id` = $po_id)) ORDER BY `stock_id` ASC";
													$qu_inv_stock_EXE = mysqli_query($KONN, $qu_inv_stock_sel);
													if(mysqli_num_rows($qu_inv_stock_EXE)){
														$inspected_Qty = 0;
														$Recieved_Qty = 0;
														while($inv_stock_REC = mysqli_fetch_assoc($qu_inv_stock_EXE)){
															$THSqty = 0;
															
															$stock_status = $inv_stock_REC['stock_status'];
															$THSqty = ( double ) $inv_stock_REC['qty'];
															
															if( ($stock_status == 'pending_placement') ) {
																$Recieved_Qty = $Recieved_Qty + $THSqty;
																
																
																} else if ($stock_status == 'under_inspection') {
																$inspected_Qty = $inspected_Qty + $THSqty;
																
																} else if ($stock_status == 'rejected') {
																$Rejected_Qty = $Rejected_Qty + $THSqty;
																
															}
															
															
														}
													}
													
													
												}
											}
											//get po item status
											//if po item stt is fully_arrived or partial_arrived then show stock stt
										?>
										<div class="tr" id="req-<?=$requisition_id; ?>" data-tt="">
											<div class="td"><?=$Item_Description; ?></div>
											<div class="td" onclick="showReqDetails(<?=$requisition_id; ?>,'<?=$requisition_ref; ?>', 'viewItemDetails');"><span id="reqREF-<?=$requisition_ref; ?>" class="text-primary cursored"><?=$requisition_ref; ?></span></div>
											<div class="td"><?=$requisition_status; ?></div>
											<div class="td"><?=$REQ_created_date; ?></div>
											<div class="td" onclick="showPoDetails(<?=$po_id?>, '<?=$PO_REF; ?>', 'viewPOdetails');"><span id="joREF-<?=$po_id?>" class="text-primary cursored"><?=$PO_REF; ?></span></div>
											<div class="td"><?=$job_order_ref; ?></div>
											<div class="td"><?=$Req_Qty; ?></div>
											<div class="td"><?=$Del_Qty; ?></div>
											<div class="td"><?=$inspected_Qty; ?></div>
											<div class="td"><?=$Rejected_Qty; ?></div>
											<div class="td"><?=$Recieved_Qty; ?></div>
										</div>
										<?php
										}
									}
									
									
									
									
									
									//items loop END
									
									
								}
							}
							
						?>
					</div>
				</div>
				
				<div class="tablePagination">
					<!--div class="pageNum arrowPager" id="prePatchBtn" onclick="showPrePageBatch('ui_operation/<?=basename($_SERVER['PHP_SELF']); ?>', <?=$showPerPage; ?>, <?=$totPages; ?>);"><i class="fas fa-angle-double-left"></i></div-->
					<?php
						$Starter = $page - 5;
						$endder = $page+ 10;
						
						if($Starter < 1){
							$Starter = 1;
						}
						
						for( $i=$Starter ; $i< $endder ; $i++ ){
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
							<a href="<?=basename($_SERVER['PHP_SELF']); ?>?page=<?=$i; ?><?=$totReq; ?>">
								<div class="pageNum imVarPager pn-<?=$i; ?> <?=$CLS; ?>"><?=$iView; ?></div>
							</a>
							<?php
							}
						}
					?>
					<div id="addPagerPoint"></div>
					<!--div class="pageNum arrowPager" id="nextPatchBtn" onclick="showNextPageBatch('ui_operation/<?=basename($_SERVER['PHP_SELF']); ?>', <?=$showPerPage; ?>, <?=$totPages; ?>);"><i class="fas fa-angle-double-right"></i></div-->
				</div>
				
			</div>
			<div class="zero"></div>
		</div>
		
		
		<?php
			//PAGE DATA END   ----------------------------------------------///---------------------------------
			include('app/footer.php');
		?>
		<script>
			
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
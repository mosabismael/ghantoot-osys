<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 2;
	$subPageID = 1111;
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
	
	$supplier_id = 0;
	$requisition_id = 0;
	$loadDt = false;
	
	$page = 1;
	$showPerPage = 20;
	$totPages = 0;
	$qu_COUNT_sel = "SELECT count(*) FROM  `inv_stock` WHERE `stock_status` = 'rejected'";
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
								<option value = "qty">Qty</option>
								<option value = "po_id">PO REF</option>
								<option value = "supplier_id">Supplier</option>
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
					
				</div>
				<div class="table">
					<div class="tableHeader">
						<div class="tr">
							<div class="th"><?=lang("NO.", "AAR"); ?></div>
							<div class="th"><?=lang("Item", "AAR"); ?></div>
							<div class="th"><?=lang("Qty", "AAR"); ?></div>
							<div class="th"><?=lang("PO_REF", "AAR"); ?></div>
							<div class="th"><?=lang("Supplier", "AAR"); ?></div>
							<div class="th"><?=lang("Memo", "AAR"); ?></div>
							<div class="th"><?=lang("Opts", "AAR"); ?></div>
							
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
							'<div class = "tr" id="po-' + response[i].stock_id + '">' + 
							'	<div class = "td">' + response[i].sNo + '</div>' + 
							'	<div class = "td">' + response[i].item_name + '</div>' + 
							'	<div class = "td">' + response[i].qty + '</div>' + 
							'	<div class = "td" onclick="showPoDetails('+response[i].po_id+ ",'" +response[i].po_ref+ "'" +",'viewPOdetails'"+');"><span id="poREF-'+response[i].stock_id+'" class="text-primary">'+response[i].po_ref+'</span></div>'+
							'	<div class = "td">' + response[i].supplier_name + '</div>' + 
							'	<div class = "td">' + response[i].memo + '</div>' + 
							'	<div class = "td">' + 
							'	<button type="button"><?=lang("Cancel_&_Delete", "AAR"); ?></button>'+
							'	<br>'+
							'	<button type="button"><?=lang("Inspect_Again", "AAR"); ?></button>'+
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
		
		
		
		
		function revisePO(){
			start_loader();
			var aa = confirm("Are You Sure, this will Revise the current PO ?");
			if( aa == true ){
				$.ajax({
					url      :"<?=api_root; ?>purchase_orders/revise_po.php",
					data     :{ 'po_id': activePO },
					dataType :"html",
					type     :'POST',
					success  :function(data){
						dt_arr = data.split('|');
						dt_res = parseInt(dt_arr[0]);
						if(dt_res == 1){
							window.location.href = "purchase_orders_drafts.php";
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
	
	
	</body>
	</html>				
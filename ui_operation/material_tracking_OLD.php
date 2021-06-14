<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	$pageID = 65;
	$subPageID = 1;
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
					<br>
					<button type="submit">&nbsp;&nbsp;&nbsp;&nbsp;<?=lang("Search", "AAR"); ?>&nbsp;&nbsp;&nbsp;&nbsp;</button>
				</div>
				<div class="zero"></div>
			</div>
				<div class="zero"></div>
			
		</form>
	</div>
	<div class="col-100">
		
		<table id="dataTable" class="tabler" border="2">
			<thead>
				<tr>
					<th><?=lang("Item_Description", "AAR"); ?></th>
					<th><?=lang("REQ_No", "AAR"); ?></th>
					<th><?=lang("REQ_Stt", "AAR"); ?></th>
					<th><?=lang("REQ_Date", "AAR"); ?></th>
					<th><?=lang("PO_No", "AAR"); ?></th>
					<th><?=lang("Job_No", "AAR"); ?></th>
					<th><?=lang("Req_Qty", "AAR"); ?></th>
					<th><?=lang("Del_Qty", "AAR"); ?></th>
					<th><?=lang("Del_Date", "AAR"); ?></th>
					<th><?=lang("Del_Status", "AAR"); ?></th>
				</tr>
			</thead>
			<tbody>
<?php
	$sNo = 0;
	
	$qu_pur_requisitions_sel = "SELECT * FROM  `pur_requisitions` WHERE ( ((`requisition_status` <> 'draft') AND (`requisition_status` <> 'deleted')) $COND01 $COND02 $COND03 ) ORDER BY `requisition_id` DESC";
	$qu_pur_requisitions_EXE = mysqli_query($KONN, $qu_pur_requisitions_sel);
	if(mysqli_num_rows($qu_pur_requisitions_EXE)){
		while($pur_requisitions_REC = mysqli_fetch_assoc($qu_pur_requisitions_EXE)){
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
	$q = "SELECT * FROM  `pur_requisitions_items` WHERE `requisition_id` = $requisition_id";
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
				$qu_inv_stock_sel = "SELECT `stock_status` FROM  `inv_stock` WHERE ((`po_item_id` = $po_item_id) AND (`po_id` = $po_id))";
				$qu_inv_stock_EXE = mysqli_query($KONN, $qu_inv_stock_sel);
				$inv_stock_DATA;
				if(mysqli_num_rows($qu_inv_stock_EXE)){
					$inv_stock_DATA = mysqli_fetch_assoc($qu_inv_stock_EXE);
					$stock_status = $inv_stock_DATA['stock_status'];
					
					if( ($item_status == 'partial_arrived') ) {
						$Del_Status = 'partial_received';
						
						
					} else if ($item_status == 'fully_arrived') {
						$Del_Status = 'fully_received';
						
						
					}
					
					
					
				}

			
		}
	}
		
		
		if( $Del_Qty == 0 ){
			$Del_Status = 'pending_arrival';
		} else {
			
			if( $Del_Qty < $Ful_Qty ){
				
				if($stock_status == 'draft'){
					$Del_Status = 'partial_arrived';
				} else {
					$Del_Status = 'partial_received';
				}
				
			} else if( $Del_Qty == $Ful_Qty ){
				
				if($stock_status == 'draft'){
					$Del_Status = 'fully_arrived';
				} else {
					$Del_Status = 'fully_received';
				}
				
			}
			
		}
		
		
		//get po item status
		//if po item stt is fully_arrived or partial_arrived then show stock stt
		
		?>
			<tr id="req-<?=$requisition_id; ?>">
				<td><?=$Item_Description; ?></td>
				<td><?=$requisition_ref; ?></td>
				<td><?=$requisition_status; ?></td>
				<td><?=$REQ_created_date; ?></td>
				<td><?=$PO_REF; ?></td>
				<td><?=$job_order_ref; ?></td>
				<td><?=$Req_Qty; ?></td>
				<td><?=$Del_Qty; ?></td>
				<td><?=$Del_Date; ?></td>
				<td><?=$Del_Status; ?></td>
			</tr>
		<?php
		}
	}
		
		
		
		
		
		//items loop END
		
		
		}
	}
?>
			</tbody>
		</table>
		
	</div>
	<div class="zero"></div>
</div>


<?php
	//PAGE DATA END   ----------------------------------------------///---------------------------------
	include('app/footer.php');
?>
<script>
function activate_req( IDD ){
	var aa = confirm( 'Are you sure, this action cannot be undo ?' );
	if( aa == true ){
		start_loader('Sending Requisition...');
		$.ajax({
			url      :"<?=api_root; ?>requisitions/activate_req.php",
			data     :{ 'requisition_id': IDD },
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
	
}

function initSupplierSelect(){
	
}

function generateRFQ(){
	
}

function createRFQs(){
	
	
}








function loadApprovedSupps( ){
	
}




function loadRFQs( ){
	
}

var activeRFQ = 0;
function add_new_pl_detail( rfqID ){
	
}
function View_pl_detail( rfqID ){
	
}


function loadRfqDetails( TT ){
	
	
}

function loadRfqItems( ){
	
}













function comparisonSheet(){
	
}


function loadComparisonSheet( ITM ){
	
}



function changeCsDecision( pl_record_id, req_item_id ){
	
}


function approvePriceListItem(  supplier_id,  rfq_id,  price_list_id,  req_item_id, requisition_id, pl_record_id){
	
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
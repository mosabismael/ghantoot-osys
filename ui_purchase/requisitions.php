<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 1;
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



<div class="row">
	<div class="col-100">
		
		<table id="dataTable" class="tabler" border="2">
			<thead>
				<tr>
					<th><?=lang("NO.", "AAR"); ?></th>
					<th><?=lang("REF", "AAR"); ?></th>
					<th><?=lang("Created_date", "AAR"); ?></th>
					<th><?=lang("BY", "AAR"); ?></th>
					<th><?=lang("On_whos_Desk", "AAR"); ?></th>
					<th><?=lang("Status", "AAR"); ?></th>
					<th>--</th>
				</tr>
			</thead>
			<tbody>
<?php
	$sNo = 0;
	$qu_pur_requisitions_sel = "SELECT * FROM  `pur_requisitions` WHERE ((`requisition_status` = 'draft') AND (`ordered_by` = '$EMPLOYEE_ID')) ORDER BY `requisition_id` DESC";
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
		$created_date = $pur_requisitions_REC['created_date'];
		
		$BY = get_emp_name($KONN, $ordered_by );
		
		
		$current_state_id = get_current_state_id($KONN, $requisition_id, 'pur_requisitions' );
	$qu_gen_status_change_sel = "SELECT * FROM  `gen_status_change` WHERE `status_id` = $current_state_id";
	$qu_gen_status_change_EXE = mysqli_query($KONN, $qu_gen_status_change_sel);
	$gen_status_change_DATA;
	if(mysqli_num_rows($qu_gen_status_change_EXE)){
		$gen_status_change_DATA = mysqli_fetch_assoc($qu_gen_status_change_EXE);
	}

		$status_id = $gen_status_change_DATA['status_id'];
		$status_action = $gen_status_change_DATA['status_action'];
		$status_date = $gen_status_change_DATA['status_date'];
		$item_id = $gen_status_change_DATA['item_id'];
		$item_type = $gen_status_change_DATA['item_type'];
		$action_by = $gen_status_change_DATA['action_by'];
		
		$Desk = get_emp_name($KONN, $action_by );
		
		
		?>
			<tr id="req-<?=$requisition_id; ?>">
				<td><?=$sNo; ?></td>
				<td onclick="showReqDetails(<?=$requisition_id; ?>, '<?=$requisition_ref; ?>', 'viewItemDetails');"><span id="reqREF-<?=$requisition_id; ?>" class="text-primary"><?=$requisition_ref; ?></span></td>
				<td><?=$created_date; ?></td>
				<td><?=$BY; ?></td>
				<td><?=$Desk; ?></td>
				<td id="reqStatus-<?=$requisition_id; ?>"><?=$requisition_status; ?></td>
				<td id="">
		<?php
			if( $requisition_status == 'draft' ){
		?>
					<button type="button" onclick="remove_req(<?=$requisition_id; ?>);"><?=lang("Delete", "AAR"); ?></button>
		<?php
			}
		?>
				</td>
			</tr>
		<?php
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

function remove_req( IDD ){
	var aa = confirm( 'Are you sure, this action cannot be undo ?' );
	if( aa == true ){
		start_loader('Deleting Requisition...');
		$.ajax({
			url      :"<?=api_root; ?>requisitions/remove_req.php",
			data     :{ 'requisition_id': IDD },
			dataType :"html",
			type     :'POST',
			success  :function(data){
					end_loader();
					var aa = data.split('|');
					res = parseInt( aa[0] );
					if( res == 1 ){
						
						$( '#req-' + IDD ).remove();
						
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
var is_materialREQ = 0;



function waiting_rfq( IDD ){
	var aa = confirm( 'Are you sure, this action cannot be undo ?' );
	if( aa == true && activeREQ != 0 ){
		start_loader('Sending Requisition...');
		$.ajax({
			url      :"<?=api_root; ?>requisitions/waiting_rfq.php",
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



var activeRFQ = 0;


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
					<div onclick="set_tabber(2);fetch_requisition_media();" class="tabsIdSel-2"><?=lang("Documents", "AAR"); ?></div>
					<div onclick="set_tabber(3);fetch_item_status(activeREQ, 'pur_requisitions');"" class="tabsIdSel-3"><?=lang("Status_Change", "AAR"); ?></div>
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
				<button type="button" onclick="waiting_rfq();"><?=lang("Finish_Draft", "AAR"); ?></button>
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



<?php
if( isset( $_GET['add_new'] ) ){
?>
<script>
show_modal( 'add_new_modal', 'material requisition' );
</script>
<?php
}
?>







</body>
</html>
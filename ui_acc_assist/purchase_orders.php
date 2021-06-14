<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 3;
	$subPageID = 7;
	
	
	$supplier_id = 0;
	$requisition_id = 0;
	$loadDt = false;
	
	if( isset( $_GET['supplier_id'] ) && isset( $_GET['requisition_id'] ) ){
		$requisition_id = ( int ) test_inputs( $_GET['requisition_id'] );
		$supplier_id = ( int ) test_inputs( $_GET['supplier_id'] );
	}
	
	
	
	if( $supplier_id != 0 && $requisition_id != 0  ){
		$loadDt = true;
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



<div class="row">
	<div class="col-100">
		
		<table id="dataTable" class="tabler" border="2">
			<thead>
				<tr>
                    <th>
                        NO.
                    </th>
					<th><?=lang("PO_REF", "AAR"); ?></th>
					<th><?=lang("Supplier", "AAR"); ?></th>
					<th><?=lang("Created_date", "AAR"); ?></th>
					<th><?=lang("Delivery_date", "AAR"); ?></th>
					<th><?=lang("BY", "AAR"); ?></th>
					<th><?=lang("Status", "AAR"); ?></th>
					<th><?=lang("Options", "AAR"); ?></th>
				</tr>
			</thead>
			<tbody>
<?php
	$sNo = 0;
	$qu_purchase_orders_sel = "SELECT * FROM  `purchase_orders` WHERE `po_status` = 'pending_acc_approval'";
	$qu_purchase_orders_EXE = mysqli_query($KONN, $qu_purchase_orders_sel);
	if(mysqli_num_rows($qu_purchase_orders_EXE)){
		while($purchase_orders_REC = mysqli_fetch_assoc($qu_purchase_orders_EXE)){
			$sNo++;
			$po_id = $purchase_orders_REC['po_id'];
			$po_ref = $purchase_orders_REC['po_ref'];
			$rev_no = $purchase_orders_REC['rev_no'];
			$po_date = $purchase_orders_REC['po_date'];
			$delivery_date = $purchase_orders_REC['delivery_date'];
			$delivery_period_id = $purchase_orders_REC['delivery_period_id'];
			$discount_percentage = $purchase_orders_REC['discount_percentage'];
			$discount_amount = $purchase_orders_REC['discount_amount'];
			$is_vat_included = $purchase_orders_REC['is_vat_included'];
			$payment_term_id = $purchase_orders_REC['payment_term_id'];
			$currency_id = $purchase_orders_REC['currency_id'];
			$exchange_rate = $purchase_orders_REC['exchange_rate'];
			$supplier_quotation_ref = $purchase_orders_REC['supplier_quotation_ref'];
			$attached_supplier_quotation = $purchase_orders_REC['attached_supplier_quotation'];
			$notes = $purchase_orders_REC['notes'];
			$po_status = $purchase_orders_REC['po_status'];
			$supplier_id = $purchase_orders_REC['supplier_id'];
			$requisition_id = $purchase_orders_REC['requisition_id'];
			$job_order_id = $purchase_orders_REC['job_order_id'];
			$employee_id = $purchase_orders_REC['employee_id'];
		
			$BY       = get_emp_name($KONN, $employee_id );
			$supplier = get_supplier_name( $supplier_id, $KONN );
		
		
		?>
			<tr id="po-<?=$po_id; ?>">
				<td><?=$sNo; ?></td>
				<td onclick="showPoDetails(<?=$po_id; ?>, '<?=$po_ref; ?>', 'viewPOdetails');"><span id="poREF-<?=$po_id; ?>" class="text-primary"><?=$po_ref; ?></span></td>
				<td><?=$supplier; ?></td>
				<td><?=$po_date; ?></td>
				<td><?=$delivery_date; ?></td>
				<td><?=$BY; ?></td>
				<td><?=$po_status; ?></td>
				<td>
<a title="Print PO" href="prints/po_print.php?po_id=<?=$po_id; ?>" target="_blank"><i class="fas fa-print"></i></a>
				</td>
			</tr>
		<?php
		}
	} else {
?>
			<tr>
				<td colspan="7">NO DATA FOUND</td>
			</tr>

<?php
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

$('#' + viewPOdetails + ' #viewQuoteSupp').attr('href', '../uploads/' + response[0].attached_supplier_quotation);
		
$('#' + viewPOdetails + ' .notes').val(response[0].notes);
$('#' + viewPOdetails + ' .po_status').val(response[0].po_status);
$('#' + viewPOdetails + ' .supplier_id').val(response[0].supplier_name);
$('#' + viewPOdetails + ' .requisition_id').val(response[0].requisition_ref);
$('#' + viewPOdetails + ' .job_order_id').val(response[0].job_order_id);
$('#' + viewPOdetails + ' .job_order_project').val(response[0].project);
$('#' + viewPOdetails + ' .employee_id').val(response[0].employee_id);
$('#' + viewPOdetails + ' .created_by').val(response[0].employee_name);

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




function approvePO(){
	start_loader();
	var aa = confirm("Are You Sure, this will approve the current PO ?");
	if( aa == true ){
		$.ajax({
			url      :"<?=api_root; ?>purchase_orders/approve_po.php",
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


function denyPO(){
	start_loader();
	var aa = confirm("Are You Sure, this will reject the current PO ?");
	if( aa == true ){
		$.ajax({
			url      :"<?=api_root; ?>purchase_orders/deny_po_from_acc.php",
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


function loadCS( reqItmId, reqID ){
	
	$('#fetched_CS').html( '' );
	start_loader("Loading Comparison Sheet Details...");
	$.ajax({
		url      :"<?=api_root; ?>requisitions/load_cs_details.php",
		data     :{ 'requisition_id': reqID, 'req_item_id': reqItmId, 'is_print': 1 },
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
				var reItm        = parseInt( response[i].req_item_id );
				var reqId        = parseInt( response[i].requisition_id );
				
				var item_name        = response[i].item_name;
				var item_qty         = parseFloat( response[i].item_qty );
				var item_price       = parseFloat( response[i].item_price );
				var item_unit_name   = response[i].item_unit_name;
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
'					<td><center><button type="button" onclick="loadCS(' + reItm + ", " + reqId + ');" style="padding: 15%;"><?=lang("View_CS", "AAR"); ?></button></center></td>' + 
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
			require_once('../forms/purchase_orders/view_po_details_accounts.php');
		?>
		</div>
	</div>
</div>
<!--    ///////////////////     viewPOdetails details END     ///////////////////            -->


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
<!--    ///////////////////      CSviewDetail VIEW END    ///////////////////   


</body>
</html>
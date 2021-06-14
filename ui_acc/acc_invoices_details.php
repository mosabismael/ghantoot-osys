<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	
	$menuId = 75;
	$subPageID = 100;
	
	if( isset( $_POST['invoice_id'] ) && 
		isset( $_POST['client_id'] ) && 
		isset( $_POST['account_id'] ) 
		){
		$invoice_id  = ( int ) test_inputs( $_POST['invoice_id'] );
		$client_id   = ( int ) test_inputs( $_POST['client_id'] );
		$account_id  = ( int ) test_inputs( $_POST['account_id'] );
		
		
		$invoiceSubTot  = 0;
		$invoiceVAT     = 0;
		$invoiceTotal   = 0;
		
		//get invoice total
		$qu_acc_invoices_items_sel = "SELECT * FROM  `acc_invoices_items` WHERE `invoice_id` = $invoice_id";
		$qu_acc_invoices_items_EXE = mysqli_query($KONN, $qu_acc_invoices_items_sel);
		if(mysqli_num_rows($qu_acc_invoices_items_EXE)){
			while($acc_invoices_items_REC = mysqli_fetch_assoc($qu_acc_invoices_items_EXE)){
				$q   = ( double ) $acc_invoices_items_REC['item_qty'];
				$p   = ( double ) $acc_invoices_items_REC['item_price'];
				$thsTot = 0;
				$thsTot = $q * $p;
				$invoiceSubTot = $invoiceSubTot + $thsTot;
			}
		}



		$invoiceVAT = $invoiceSubTot * 0.05;
		
		$invoiceTotal = $invoiceSubTot + $invoiceVAT;
		
		// die('t='.number_format( $invoiceTotal, 3) );
		
		
		//get active vat acc
	$qu_acc_accounts_sel = "SELECT * FROM  `acc_accounts` WHERE `account_type_id` = '17' LIMIT 1";
	$qu_acc_accounts_EXE = mysqli_query($KONN, $qu_acc_accounts_sel);
	$vatAcc_id = 0;
	if(mysqli_num_rows($qu_acc_accounts_EXE)){
		$acc_accounts_DATA = mysqli_fetch_assoc($qu_acc_accounts_EXE);
		$vatAcc_id = $acc_accounts_DATA['account_id'];
	}
		
		
		//get active vat acc
	$qu_acc_accounts_sel = "SELECT * FROM  `acc_accounts` WHERE `account_type_id` = '18' LIMIT 1";
	$qu_acc_accounts_EXE = mysqli_query($KONN, $qu_acc_accounts_sel);
	$revAcc_id = 0;
	if(mysqli_num_rows($qu_acc_accounts_EXE)){
		$acc_accounts_DATA = mysqli_fetch_assoc($qu_acc_accounts_EXE);
		$revAcc_id = $acc_accounts_DATA['account_id'];
	}

		
		//reflect VAT amount as Debit
					$cycle_id = 0;
					$created_date = date('Y-m-d H:i:00');
					$ref_no = "Invoice_submit";
					$debit = 0;
					$credit = $invoiceVAT;
					$typo = "AUTO-VAT-DBT";
					$related_id = $invoice_id;
					$qu_acc_cycle_ins = "INSERT INTO `acc_cycle` (
										`created_date`, 
										`ref_no`, 
										`debit`, 
										`credit`, 
										`account_id`, 
										`typo`, 
										`related_id`, 
										`employee_id` 
									) VALUES (
										'".$created_date."', 
										'".$ref_no."', 
										'".$debit."', 
										'".$credit."', 
										'".$vatAcc_id."', 
										'".$typo."', 
										'".$related_id."', 
										'".$EMPLOYEE_ID."' 
									);";

					if(!mysqli_query($KONN, $qu_acc_cycle_ins)){
						die("ERR-111");
					}
	$last_updated = date("Y-m-d H:i:00");

	$qu_acc_accounts_updt = "UPDATE  `acc_accounts` SET 
						`current_balance` = `current_balance` + ".$invoiceVAT.", 
						`last_updated` = '".$last_updated."'
						WHERE `account_id` = $vatAcc_id;";

	if(!mysqli_query($KONN, $qu_acc_accounts_updt)){
		die("ERR-999");
	}
		
		
		//reflect amount as credit on client acc
					$cycle_id = 0;
					$created_date = date('Y-m-d H:i:00');
					$ref_no = "Invoice_submit";
					$debit = $invoiceTotal;
					$credit = 0;
					$typo = "AUTO-INV-CRDT";
					$related_id = $invoice_id;
					$qu_acc_cycle_ins = "INSERT INTO `acc_cycle` (
										`created_date`, 
										`ref_no`, 
										`debit`, 
										`credit`, 
										`account_id`, 
										`typo`, 
										`related_id`, 
										`employee_id` 
									) VALUES (
										'".$created_date."', 
										'".$ref_no."', 
										'".$debit."', 
										'".$credit."', 
										'".$account_id."', 
										'".$typo."', 
										'".$related_id."', 
										'".$EMPLOYEE_ID."' 
									);";

					if(!mysqli_query($KONN, $qu_acc_cycle_ins)){
						die("ERR-111");
					}

	$qu_acc_accounts_updt = "UPDATE  `acc_accounts` SET 
						`current_balance` = `current_balance` - ".$invoiceTotal.", 
						`last_updated` = '".$last_updated."'
						WHERE `account_id` = $account_id;";

	if(!mysqli_query($KONN, $qu_acc_accounts_updt)){
		die("ERR-999");
	}
					
					
					
					
		
		//reflect amount as SALES REV
					$cycle_id = 0;
					$created_date = date('Y-m-d H:i:00');
					$ref_no = "Invoice_submit";
					$debit = 0;
					$credit = $invoiceSubTot;
					$typo = "AUTO-INV-CRDT";
					$related_id = $invoice_id;
					$qu_acc_cycle_ins = "INSERT INTO `acc_cycle` (
										`created_date`, 
										`ref_no`, 
										`debit`, 
										`credit`, 
										`account_id`, 
										`typo`, 
										`related_id`, 
										`employee_id` 
									) VALUES (
										'".$created_date."', 
										'".$ref_no."', 
										'".$debit."', 
										'".$credit."', 
										'".$revAcc_id."', 
										'".$typo."', 
										'".$related_id."', 
										'".$EMPLOYEE_ID."' 
									);";

					if(!mysqli_query($KONN, $qu_acc_cycle_ins)){
						die("ERR-111");
					}

		$qu_acc_accounts_updt = "UPDATE  `acc_accounts` SET 
							`current_balance` = `current_balance` + ".$invoiceSubTot.", 
							`last_updated` = '".$last_updated."'
							WHERE `account_id` = $revAcc_id;";

		if(!mysqli_query($KONN, $qu_acc_accounts_updt)){
			die("ERR-999");
		}
					
	}

	
	$invoice_id = 0;
	
	if( isset( $_GET['invoice_id'] ) ){
		$invoice_id = ( int ) $_GET['invoice_id'];
	} else {
		header("location:acc_biling.php?noBill=1");
	}
	
	
	$qu_acc_invoices_sel = "SELECT * FROM  `acc_invoices` WHERE `invoice_id` = $invoice_id";
	$qu_acc_invoices_EXE = mysqli_query($KONN, $qu_acc_invoices_sel);
	$acc_invoices_DATA;
	if(mysqli_num_rows($qu_acc_invoices_EXE)){
		$acc_invoices_DATA = mysqli_fetch_assoc($qu_acc_invoices_EXE);
	} else {
		header("location:acc_biling.php?noBill=2");
	}
	
		$invoice_id = $acc_invoices_DATA['invoice_id'];
		$invoice_ref = $acc_invoices_DATA['invoice_ref'];
		$invoice_type = $acc_invoices_DATA['invoice_type'];
		$payment_term_id = $acc_invoices_DATA['payment_term_id'];
		$client_id = $acc_invoices_DATA['client_id'];
		$client_ref = $acc_invoices_DATA['client_ref'];
		$client_contact = $acc_invoices_DATA['client_contact'];
		$invoice_date = $acc_invoices_DATA['invoice_date'];
		$due_date = $acc_invoices_DATA['due_date'];
		$job_order_id = $acc_invoices_DATA['job_order_id'];
		$bill_id = $acc_invoices_DATA['bill_id'];
		$created_date = $acc_invoices_DATA['created_date'];
		$created_by = $acc_invoices_DATA['created_by'];
		$invoice_status = $acc_invoices_DATA['invoice_status'];



	
	
	
	$qu_job_orders_sel = "SELECT * FROM  `job_orders` WHERE `job_order_id` = '$job_order_id' LIMIT 1";
	$qu_job_orders_EXE = mysqli_query($KONN, $qu_job_orders_sel);
	$job_order_ref = '';
	$client_name = '';
	if(mysqli_num_rows($qu_job_orders_EXE)){
		while($job_orders_REC = mysqli_fetch_assoc($qu_job_orders_EXE)){
			$job_order_ref = $job_orders_REC['job_order_ref'];
			$client_name = $job_orders_REC['client_name'];
		
		}
	} else {
		header("location:acc_biling.php?noBill=3");
	}
	
	$qu_gen_clients_sel = "SELECT * FROM  `gen_clients` WHERE `client_name` = '$client_name'";
	$qu_gen_clients_EXE = mysqli_query($KONN, $qu_gen_clients_sel);
	$gen_clients_DATA;
	if(mysqli_num_rows($qu_gen_clients_EXE)){
		$gen_clients_DATA = mysqli_fetch_assoc($qu_gen_clients_EXE);
	} else {
		header("location:acc_biling.php?noBill=4");
	}
		$client_id = ( int ) $gen_clients_DATA['client_id'];
		$client_code = $gen_clients_DATA['client_code'];
		$client_name = $gen_clients_DATA['client_name'];
		
	
	
	
	
	$qu_acc_accounts_sel = "SELECT `account_id` FROM  `acc_accounts` WHERE `account_no` = '$client_code'";
	$qu_acc_accounts_EXE = mysqli_query($KONN, $qu_acc_accounts_sel);
	$account_id = 0;
	if(mysqli_num_rows($qu_acc_accounts_EXE)){
		$acc_accounts_DATA = mysqli_fetch_assoc($qu_acc_accounts_EXE);
		$account_id = ( int ) $acc_accounts_DATA['account_id'];
	} else {
		header("location:acc_biling.php?noBill=5");
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
		<form action="acc_invoices_details.php" method="POST">
					<input class="frmData"
							id="new-invoice_id<?=$invoice_id; ?>"
							name="invoice_id"
							type="hidden"
							value="<?=$invoice_id; ?>"
							req="1"
							den="0"
							alerter="<?=lang("Please_Check_invoice_id", "AAR"); ?>">
					<input class="frmData"
							id="new-client_id<?=$invoice_id; ?>"
							name="client_id"
							type="hidden"
							value="<?=$client_id; ?>"
							req="1"
							den="0"
							alerter="<?=lang("Please_Check_client", "AAR"); ?>">
					<input class="frmData"
							id="new-account_id<?=$invoice_id; ?>"
							name="account_id"
							type="hidden"
							value="<?=$account_id; ?>"
							req="1"
							den="0"
							alerter="<?=lang("Please_Check_client_account", "AAR"); ?>">
		
			<div class="row col-50">
				<div class="nwFormGroup">
					<label><?=lang("Select_Type:", "AAR"); ?></label>
					<select class="frmData" id="new-invoice_type" name="invoice_type" readonly>
<?php
	if( $bill_type == 'steel' ){
?>
						<option value="steel" selected><?=lang("Steel", "غير محدد"); ?></option>
<?php
	}
?>
<?php
	if( $bill_type == 'marine' ){
?>
						<option value="marine"><?=lang("Marine", "غير محدد"); ?></option>
<?php
	}
?>
					</select>
				</div>
				<div class="zero"></div>
			</div>
<script>
$('#new-invoice_type').val('<?=$invoice_type; ?>');
</script>
			<div class="row col-50">
				<div class="nwFormGroup">
					<label><?=lang("Select_Job_Order:", "AAR"); ?></label>
					<select class="frmData" id="new-job_order_id" name="job_order_id">
						<option value="<?=$job_order_id; ?>"><?=$job_order_ref; ?> - <?=$client_name; ?></option>
					</select>
				</div>
				<div class="zero"></div>
			</div>
		
			<div class="row col-50">
				<div class="nwFormGroup">
					<label><?=lang("client_ref:", "AAR"); ?></label>
					<input type="text" class="frmData" id="new-client_ref" name="client_ref" value="<?=$client_ref; ?>">
				</div>
				<div class="zero"></div>
			</div>
		
			<div class="row col-50">
				<div class="nwFormGroup">
					<label><?=lang("client_contact:", "AAR"); ?></label>
					<input type="text" class="frmData" id="new-client_contact" name="client_contact" value="<?=$client_contact; ?>">
				</div>
				<div class="zero"></div>
			</div>
			
			<div class="row col-50">
				<div class="nwFormGroup">
					<label><?=lang("Select_payment_term:", "AAR"); ?></label>
					<select class="frmData" id="new-payment_term_id" name="payment_term_id">
		<?php
			$sNo = 0;
			$qu_gen_payment_terms_sel = "SELECT * FROM  `gen_payment_terms`";
			$qu_gen_payment_terms_EXE = mysqli_query($KONN, $qu_gen_payment_terms_sel);
			if(mysqli_num_rows($qu_gen_payment_terms_EXE)){
				while($gen_payment_terms_REC = mysqli_fetch_assoc($qu_gen_payment_terms_EXE)){
					$payment_term_idT = $gen_payment_terms_REC['payment_term_id'];
					$payment_term_title = $gen_payment_terms_REC['payment_term_title'];
				
				?>
						<option value="<?=$payment_term_idT; ?>"><?=$payment_term_title; ?></option>
				<?php
				}
			}
		?>
					</select>
				</div>
				<div class="zero"></div>
			</div>
<script>
$('#new-payment_term_id').val('<?=$payment_term_id; ?>');
</script>
			
			<div class="row col-50">
				<div class="nwFormGroup">
					<label><?=lang("Invoice_Date:", "AAR"); ?></label>
					<input type="text" class="frmData has_date" id="new-invoice_date" name="invoice_date" value="<?=$invoice_date; ?>">
				</div>
				<div class="zero"></div>
			</div>
			
			<div class="row col-50">
				<div class="nwFormGroup">
					<label><?=lang("Due_Date:", "AAR"); ?></label>
					<input type="text" class="frmData has_date" id="new-due_date" name="due_date" value="<?=$due_date; ?>">
				</div>
				<div class="zero"></div>
			</div>
			
			<div class="zero"></div>
			<div class="row col-100">
				<br>
				<hr>
				<br>
			</div>
			<div class="zero"></div>
			
			
			
			
			
			<div class="row col-100">
			
			
			
<table class="tabler">
	<thead>
		<tr>
			<th>--</th>
			<th><?=lang("item", "sss", 1); ?></th>
			<th><?=lang("UOM", "sss", 1); ?></th>
			<th><?=lang("Qty", "sss", 1); ?></th>
			<th><?=lang("U.P", "sss", 1); ?></th>
			<th><?=lang("Total", "sss", 1); ?></th>
		</tr>
	</thead>
	<tbody id="added_items">
	
<?php
	$qu_acc_invoices_items_sel = "SELECT * FROM  `acc_invoices_items` WHERE `invoice_id` = $invoice_id";
	$qu_acc_invoices_items_EXE = mysqli_query($KONN, $qu_acc_invoices_items_sel);
	if(mysqli_num_rows($qu_acc_invoices_items_EXE)){
		$itemsC = 0;
		while($acc_invoices_items_REC = mysqli_fetch_assoc($qu_acc_invoices_items_EXE)){
			$itemsC++;
			$item_desc = $acc_invoices_items_REC['item_desc'];
			$unit_id = $acc_invoices_items_REC['unit_id'];
			$item_qty = $acc_invoices_items_REC['item_qty'];
			$item_price = $acc_invoices_items_REC['item_price'];
		?>
				<tr class="item" id="addedItem-<?=$itemsC; ?>">
					<td><?=$itemsC; ?></td>
					<td>
						<div class="nwFormGroup">
							<textarea name="item_descs[]" placeholder="Item Name"><?=$item_desc; ?></textarea>
						</div>
					</td>
					<td>
						<div class="nwFormGroup">
							<select class="frmData" id="new-unit_id<?=$itemsC; ?>" name="unit_ids[]">
				<?php
					$sNo = 0;
					$qu_gen_items_units_sel = "SELECT * FROM  `gen_items_units`";
					$qu_gen_items_units_EXE = mysqli_query($KONN, $qu_gen_items_units_sel);
					if(mysqli_num_rows($qu_gen_items_units_EXE)){
						while($gen_items_units_REC = mysqli_fetch_assoc($qu_gen_items_units_EXE)){
							$unit_idTHS = $gen_items_units_REC['unit_id'];
							$unit_name = $gen_items_units_REC['unit_name'];
						
						?>
								<option value="<?=$unit_idTHS; ?>"><?=$unit_name; ?></option>
						<?php
						}
					}
				?>
							</select>
						</div>
					</td>
<script>
$('#new-unit_id<?=$itemsC; ?>').val('<?=$unit_id; ?>');
</script>
					<td>
						<div class="nwFormGroup">
							<input type="text" class="qty" name="item_qtys[]" value="<?=$item_qty; ?>" placeholder="Item Qty">
						</div>
					</td>
					<td>
						<div class="nwFormGroup">
							<input type="text" class="price" name="item_prices[]" value="<?=$item_price; ?>" placeholder="Unit Price">
						</div>
					</td>
					<td>
						<div class="nwFormGroup">
							<input type="text" class="tot" name="item_tots[]" value="0" readonly>
						</div>
					</td>
				</tr>
		
		
		
		
		
		
		<?php
		}
	}

?>
	
	
		<tr>
			<th colspan="4">--</th>
			<th><?=lang("Sub_Total:", "sss", 1); ?></th>
			<th  id="sub_tot">15651.232</th>
		</tr>
		<tr>
			<th colspan="4">--</th>
			<th><?=lang("Vat_(5%):", "sss", 1); ?></th>
			<th  id="vat_amount">00.000</th>
		</tr>
		<tr>
			<th colspan="4">--</th>
			<th><?=lang("Total:", "sss", 1); ?></th>
			<th  id="grand_tot">00.000</th>
		</tr>
	</tbody>
</table>
			
			
			
			</div>
			
			
			<div class="zero"></div>
				


<div class="viewerBodyButtons">
		<a><button type="submit">
			<?=lang('Confirm', 'ARR', 1); ?>
		</button></a>
		<a href="acc_invoices.php"><button type="button">
			<?=lang('Back', 'ARR', 1); ?>
		</button></a>
</div>
			
		</form>
	</div>
	<div class="zero"></div>
</div>
<script>
var tot_recs = 100;

function addNewRec(){
	tot_recs++;
	var nw_rec = '<tr id="addedItem-' + tot_recs + '">' + 
				'	<td><i title="Delete this item" onclick="delItem(' + tot_recs + ');" class="fas fa-trash"></i></td>' + 
				'	<td>' + 
				'		<div class="nwFormGroup">' + 
				'			<textarea name="item_descs[]" placeholder="Item Name" required></textarea>' + 
				'		</div>' + 
				'	</td>' + 
				'	<td>' + 
				'		<div class="nwFormGroup">' + 
				'			<select class="frmData" id="new-unit_id" name="unit_ids[]" required>' + 
				'				<option value="0" disabled selected><?=lang("Please_Select", "غير محدد"); ?></option>' + 
				<?php
					$sNo = 0;
					$qu_gen_items_units_sel = "SELECT * FROM  `gen_items_units` ORDER BY `unit_name` ASC";
					$qu_gen_items_units_EXE = mysqli_query($KONN, $qu_gen_items_units_sel);
					if(mysqli_num_rows($qu_gen_items_units_EXE)){
						while($gen_items_units_REC = mysqli_fetch_assoc($qu_gen_items_units_EXE)){
							$unit_id       = ( int ) $gen_items_units_REC['unit_id'];
							$unit_name = $gen_items_units_REC['unit_name'];
						
						?>
				'				<option value="<?=$unit_id; ?>"><?=$unit_name; ?></option>' + 
						<?php
						}
					}
				?>
				'			</select>' + 
				'		</div>' + 
				'	</td>' + 
				'	<td>' + 
				'		<div class="nwFormGroup">' + 
				'			<input type="text" name="item_qtys[]" placeholder="Item Aty" required>' + 
				'		</div>' + 
				'	</td>' + 
				'	<td>' + 
				'		<div class="nwFormGroup">' + 
				'			<input type="text" name="item_prices[]" placeholder="Unit Price" required>' + 
				'		</div>' + 
				'	</td>' + 
				'</tr>';
	
	
			$('#added_items').before( nw_rec );
			initTableEvents();
			calcTable();
	
	
	
}




function calcTable(){
	var subTot = 0;
	$('.item').each( function(){
		var ths_id = $(this).attr( 'id' );
		var thsQty = parseInt( $('#' + ths_id + ' .qty').val() );
		var thsPrc = parseFloat( $('#' + ths_id + ' .price').val() );
		var thsTot = thsQty * thsPrc;
		subTot = subTot + thsTot;
		$('#' + ths_id + ' .tot').val( thsTot.toFixed(3) );
	} );
	
	
	
	vatPercentage = 0.05;
	
	var vatAmount = subTot * vatPercentage;
	
	var grandTot = subTot + vatAmount;
	
	
	$('#sub_tot').html( subTot.toFixed(3) );
	$('#vat_amount').html( vatAmount.toFixed(3) );
	$('#grand_tot').html( grandTot.toFixed(3) );
	
	
	
}

function initTableEvents(){
	$('.qty').on( 'input', function(){
		calcTable();
	} );
	$('.price').on( 'input', function(){
		calcTable();
	} );
	
}




function delItem( id ){
	$('#addedItem-' + id).remove();
}













calcTable();
initTableEvents();
</script>

<?php
	//PAGE DATA END   ----------------------------------------------///---------------------------------
	include('app/footer.php');
?>
</body>
</html>
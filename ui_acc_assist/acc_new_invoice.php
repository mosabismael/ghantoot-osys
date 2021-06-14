<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 75;
	$subPageID = 100;
	
	
if( isset($_POST['invoice_type']) && 
	isset($_POST['payment_term_id']) &&  
	isset($_POST['account_id']) &&  
	isset($_POST['client_id']) &&  
	isset($_POST['client_ref']) &&
	isset($_POST['client_contact']) &&
	isset($_POST['invoice_date']) &&
	isset($_POST['due_date']) &&
	isset($_POST['job_order_id']) &&
	isset($_POST['bill_id']) && 
	isset($_POST['item_descs']) && 
	isset($_POST['unit_ids']) && 
	isset($_POST['item_qtys']) && 
	isset($_POST['item_prices']) 
	){

	$invoice_id = 0;
	$invoice_ref = "";
	$invoice_type = test_inputs($_POST['invoice_type']);
	$payment_term_id = test_inputs($_POST['payment_term_id']);
	$client_id = test_inputs($_POST['client_id']);
	$account_id = test_inputs($_POST['account_id']);
	$client_ref = test_inputs($_POST['client_ref']);
	$client_contact = test_inputs($_POST['client_contact']);
	$invoice_date = test_inputs($_POST['invoice_date']);
	$due_date = test_inputs($_POST['due_date']);
	$job_order_id = test_inputs($_POST['job_order_id']);
	$bill_id = test_inputs($_POST['bill_id']);
	$created_date = date('Y-m-d');
	$created_by = $EMPLOYEE_ID;
	$invoice_status = "added";
	$clientAccId = ( int ) $account_id;



	//calc invoice_ref
	$qu_acc_invoices_sel = "SELECT COUNT(`invoice_id`) FROM  `acc_invoices` WHERE `created_date` LIKE '".date('Y-m-')."%' ";
	$qu_acc_invoices_EXE = mysqli_query($KONN, $qu_acc_invoices_sel);
	$nwNO         = 0;
	$tot_count_DB = 0;
	if(mysqli_num_rows($qu_acc_invoices_EXE)){
		$acc_invoices_DATA = mysqli_fetch_array($qu_acc_invoices_EXE);
		$tot_count_DB = ( int ) $acc_invoices_DATA[0];
	}
	
	$nwNO = $tot_count_DB + 1;
	$tot_count_DB_res = "";
	
		if($tot_count_DB < 10){
			$tot_count_DB_res = '000'.$nwNO;
		} else if( $tot_count_DB >= 10 && $tot_count_DB < 100 ){
			$tot_count_DB_res = '00'.$nwNO;
		} else if( $tot_count_DB >= 100 && $tot_count_DB < 1000 ){
			$tot_count_DB_res = '0'.$nwNO;
		} else {
			$tot_count_DB_res = ''.$nwNO;
		}
		$invoice_ref = "GOMI-".$tot_count_DB_res.'-'.date('y');
		
	




	$qu_acc_invoices_ins = "INSERT INTO `acc_invoices` (
						`invoice_ref`, 
						`invoice_type`, 
						`payment_term_id`, 
						`client_id`, 
						`client_ref`, 
						`client_contact`, 
						`invoice_date`, 
						`due_date`, 
						`job_order_id`, 
						`bill_id`, 
						`created_date`, 
						`created_by`, 
						`invoice_status` 
					) VALUES (
						'".$invoice_ref."', 
						'".$invoice_type."', 
						'".$payment_term_id."', 
						'".$client_id."', 
						'".$client_ref."', 
						'".$client_contact."', 
						'".$invoice_date."', 
						'".$due_date."', 
						'".$job_order_id."', 
						'".$bill_id."', 
						'".$created_date."', 
						'".$created_by."', 
						'".$invoice_status."' 
					);";


	if(mysqli_query($KONN, $qu_acc_invoices_ins)){
		$invoice_id = ( int ) mysqli_insert_id($KONN);
		if( $invoice_id != 0 ){
			
			
			//update billing state
		$bill_status = 'invoice_created';
		$qu_acc_biling_updt = "UPDATE  `acc_biling` SET 
							`bill_status` = '".$bill_status."' 
							WHERE `bill_id` = $bill_id;";

		if(mysqli_query($KONN, $qu_acc_biling_updt)){
			
	if( !insert_state_change($KONN, $bill_status, $bill_id, "acc_biling", $EMPLOYEE_ID) ) {
		die('0|Component State Error 789');
	}
		}
			
			
			
			
			
			
			
			
			
			
		//insert state change
			if( insert_state_change($KONN, $invoice_status, $invoice_id, "acc_invoices", $EMPLOYEE_ID) ) {
				
				//insert Items
	$item_descs    = $_POST['item_descs'];
	$unit_ids      = $_POST['unit_ids'];
	$item_qtys     = $_POST['item_qtys'];
	$item_prices   = $_POST['item_prices'];
	$is_trees      = $_POST['is_trees'];
	
	
	$invTotBefVat = 0;
	
	for( $E=0; $E < count( $item_descs ) ; $E++ ){
		
		$item_desc     = test_inputs( $item_descs[$E] );
		$unit_id       = test_inputs( $unit_ids[$E] );
		$item_qty      = ( double ) test_inputs( $item_qtys[$E] );
		$item_price    = ( double ) test_inputs( $item_prices[$E] );
		$is_tree       = ( int ) test_inputs( $is_trees[$E] );
		
		
		
		if( $is_tree == 0 ){
			$invTotBefVat = $invTotBefVat + ( $item_qty * $item_price );
			
			$qu_acc_invoices_items_ins = "INSERT INTO `acc_invoices_items` (
								`item_desc`, 
								`unit_id`, 
								`item_qty`, 
								`item_price`, 
								`invoice_id` 
							) VALUES (
								'".$item_desc."', 
								'".$unit_id."', 
								'".$item_qty."', 
								'".$item_price."', 
								'".$invoice_id."' 
							);";

			if(!mysqli_query($KONN, $qu_acc_invoices_items_ins)){
				die('Itm_Add_ERR');
			}
		}
	}
	
	
	$account_type_id = 0;
	
	//add vat to tot
	$vatAmount = $invTotBefVat * 0.05;
	
	$invTot = $invTotBefVat + $vatAmount;
	
	
	//reflect on accounts
	$salesRevAcc = 0;
	
	
	$invoice_type = trim( $invoice_type );
	
	$account_type_id  = 18;
	if( $invoice_type == 'steel' ){
		$account_type_id  = 18;
	} else if( $invoice_type == 'marine' ) {
		$account_type_id  = 19;
	} else {
		$account_type_id  = 18;
	}
	
	
	
	//get sales rev acc
	$qu_acc_accounts_sel = "SELECT `account_id` FROM  `acc_accounts` WHERE `account_type_id` = $account_type_id LIMIT 1";
	$qu_acc_accounts_EXE = mysqli_query($KONN, $qu_acc_accounts_sel);
	if(mysqli_num_rows($qu_acc_accounts_EXE)){
		$acc_accounts_DATA = mysqli_fetch_assoc($qu_acc_accounts_EXE);
		$salesRevAcc = ( int ) $acc_accounts_DATA['account_id'];
	}

	
	if( $salesRevAcc != 0 ){
		
		
		

	//get VAT ACC
	$vatAccId = 0;
	$qu_acc_accounts_sel = "SELECT `account_id` FROM  `acc_accounts` WHERE `account_type_id` = 17 LIMIT 1";
	$qu_acc_accounts_EXE = mysqli_query($KONN, $qu_acc_accounts_sel);
	if(mysqli_num_rows($qu_acc_accounts_EXE)){
		$acc_accounts_DATA = mysqli_fetch_assoc($qu_acc_accounts_EXE);
		$vatAccId = ( int ) $acc_accounts_DATA['account_id'];
	}
	if( $vatAccId != 0 ){
		//reflect VAT amount
		$last_updated = date('Y-m-d h:i:00');
		//reflect on accounts
		
		$qu_acc_accounts_updt = "UPDATE  `acc_accounts` SET 
								`last_updated` = '".$last_updated."' WHERE `account_id` = $vatAccId;";
		if(!mysqli_query($KONN, $qu_acc_accounts_updt)){
			die( 'ERR-54544' );
		}
		
			//insert account_cycle records
			$created_date = date('Y-m-d h:i:00');
			$ref_no = 'INVOICE-'.$invoice_ref.'-'.$invoice_id;
			$debit = 0;
			$credit = $vatAmount;
			$memo = "";
			$typo = "AUTO-INVOICE-VAT";
			
			$qu_acc_cycle_ins = "INSERT INTO `acc_cycle` (
								`created_date`, 
								`ref_no`, 
								`debit`, 
								`credit`, 
								`account_id`, 
								`memo`, 
								`typo`, 
								`employee_id`
							) VALUES (
								'".$created_date."', 
								'".$ref_no."', 
								'".$debit."', 
								'".$credit."', 
								'".$vatAccId."', 
								'".$memo."', 
								'".$typo."', 
								'".$EMPLOYEE_ID."'
							);";

			if(!mysqli_query($KONN, $qu_acc_cycle_ins)){
				die( 'ERR-888' );
			}
		
		
	}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		$last_updated = date('Y-m-d h:i:00');
		//reflect on accounts
		
		$qu_acc_accounts_updt = "UPDATE  `acc_accounts` SET 
								`last_updated` = '".$last_updated."' WHERE `account_id` = $clientAccId;";
		if(!mysqli_query($KONN, $qu_acc_accounts_updt)){
			die( 'ERR-54544' );
		}
		
		$qu_acc_accounts_updt = "UPDATE  `acc_accounts` SET 
								`last_updated` = '".$last_updated."' WHERE `account_id` = $salesRevAcc;";
		if(!mysqli_query($KONN, $qu_acc_accounts_updt)){
			die( 'ERR-2635' );
		}
		

			//insert account_cycle records
			$created_date = date('Y-m-d h:i:00');
			$ref_no = 'INVOICE-'.$invoice_ref.'-'.$invoice_id;
			$debit = $invTot;
			$credit = 0;
			$memo = "";
			$typo = "AUTO-ACC-INVOICE";
			
			$qu_acc_cycle_ins = "INSERT INTO `acc_cycle` (
								`created_date`, 
								`ref_no`, 
								`debit`, 
								`credit`, 
								`account_id`, 
								`memo`, 
								`typo`, 
								`employee_id`
							) VALUES (
								'".$created_date."', 
								'".$ref_no."', 
								'".$debit."', 
								'".$credit."', 
								'".$clientAccId."', 
								'".$memo."', 
								'".$typo."', 
								'".$EMPLOYEE_ID."'
							);";

			if(!mysqli_query($KONN, $qu_acc_cycle_ins)){
				die( 'ERR-888' );
			}
			
			$created_date = date('Y-m-d h:i:00');
			$ref_no = 'INVOICE-'.$invoice_ref.'-'.$invoice_id;
			$debit = 0;
			$credit = $invTotBefVat;
			$memo = "";
			$typo = "AUTO-ACC-INVOICE";
			
			$qu_acc_cycle_ins = "INSERT INTO `acc_cycle` (
								`created_date`, 
								`ref_no`, 
								`debit`, 
								`credit`, 
								`account_id`, 
								`memo`, 
								`typo`, 
								`employee_id`
							) VALUES (
								'".$created_date."', 
								'".$ref_no."', 
								'".$debit."', 
								'".$credit."', 
								'".$salesRevAcc."', 
								'".$memo."', 
								'".$typo."', 
								'".$EMPLOYEE_ID."'
							);";

			if(!mysqli_query($KONN, $qu_acc_cycle_ins)){
				die( 'ERR-888' );
			}
			
	} else {
		echo 'No-Rev-ACC';
		die("");
	}
	
	
	header("location:acc_biling.php?added_inv=".$invoice_id);
				die("dd");
				
				
			} else {
				die('0|Data Status Error 65154');
			}
			
		}
	}

}

	
	$bill_id = 0;
	
	if( isset( $_GET['bill_id'] ) ){
		$bill_id = ( int ) $_GET['bill_id'];
	} else {
		header("location:acc_biling.php?noBill=1");
	}
	
	
	$qu_acc_biling_sel = "SELECT * FROM  `acc_biling` WHERE `bill_id` = $bill_id";
	$qu_acc_biling_EXE = mysqli_query($KONN, $qu_acc_biling_sel);
	$acc_biling_DATA;
	if(mysqli_num_rows($qu_acc_biling_EXE)){
		$acc_biling_DATA = mysqli_fetch_assoc($qu_acc_biling_EXE);
	} else {
		header("location:acc_biling.php?noBill=2");
	}
	
		$bill_type = $acc_biling_DATA['bill_type'];
		$bill_ref = $acc_biling_DATA['bill_ref'];
		$client_ref = $acc_biling_DATA['client_ref'];
		$client_contact = $acc_biling_DATA['client_contact'];
		$created_date = $acc_biling_DATA['created_date'];
		$created_by = $acc_biling_DATA['created_by'];
		$job_order_id = $acc_biling_DATA['job_order_id'];
		$bill_status = $acc_biling_DATA['bill_status'];
		$contract_attach = $acc_biling_DATA['contract_attach'];
		$client_id = $acc_biling_DATA['client_id'];
	



	
	
	
	$qu_job_orders_sel = "SELECT * FROM  `job_orders` WHERE `job_order_id` = '$job_order_id' LIMIT 1";
	$qu_job_orders_EXE = mysqli_query($KONN, $qu_job_orders_sel);
	$job_order_ref = '';
	$client_name = '';
	if(mysqli_num_rows($qu_job_orders_EXE)){
		while($job_orders_REC = mysqli_fetch_assoc($qu_job_orders_EXE)){
			$job_order_ref = $job_orders_REC['job_order_ref'];
		}
	} else {
		header("location:acc_biling.php?noBill=3");
	}
	
	$qu_gen_clients_sel = "SELECT * FROM  `gen_clients` WHERE `client_id` = '$client_id'";
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
		<form action="acc_new_invoice.php" method="POST">
					<input class="frmData"
							id="new-bill_id<?=$bill_id; ?>"
							name="bill_id"
							type="hidden"
							value="<?=$bill_id; ?>"
							req="1"
							den="0"
							alerter="<?=lang("Please_Check_bill_id", "AAR"); ?>">
					<input class="frmData"
							id="new-client_id<?=$bill_id; ?>"
							name="client_id"
							type="hidden"
							value="<?=$client_id; ?>"
							req="1"
							den="0"
							alerter="<?=lang("Please_Check_client", "AAR"); ?>">
					<input class="frmData"
							id="new-account_id<?=$account_id; ?>"
							name="account_id"
							type="hidden"
							value="<?=$account_id; ?>"
							req="1"
							den="0"
							alerter="<?=lang("Please_Check_client", "AAR"); ?>">
		
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
		
			<div class="row col-50">
				<div class="nwFormGroup">
					<label><?=lang("Select_Job_Order:", "AAR"); ?></label>
					<select class="frmData" id="new-job_order_id" name="job_order_id">
						<option value="<?=$job_order_id; ?>"><?=$job_order_ref; ?> - <?=$client_name; ?></option>
					</select>
				</div>
				<div class="zero"></div>
			</div>
		<div class="zero"></div>
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
			<div class="zero"></div>
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
					$payment_term_id = $gen_payment_terms_REC['payment_term_id'];
					$payment_term_title = $gen_payment_terms_REC['payment_term_title'];
				
				?>
						<option value="<?=$payment_term_id; ?>"><?=$payment_term_title; ?></option>
				<?php
				}
			}
		?>
					</select>
				</div>
				<div class="zero"></div>
			</div>
			
			<div class="row col-50">
				<div class="nwFormGroup">
					<label><?=lang("Invoice_Date:", "AAR"); ?></label>
					<input type="text" class="frmData has_date" id="new-invoice_date" name="invoice_date" value="<?=date('Y-m-d'); ?>">
				</div>
				<div class="zero"></div>
			</div>
			<div class="zero"></div>
<?php
	if( $contract_attach != 'na' ){
?>
			<div class="row col-50">
				<div class="nwFormGroup">
					<label><?=lang("Contract:", "AAR"); ?></label>
					<a style="color:red;" href="../uploads/<?=$contract_attach; ?>" target="_blank"><span><?=lang("View_Attachment", "AAR"); ?></span></a>
				</div>
				<div class="zero"></div>
			</div>
<?php
	}
?>
			<div class="row col-50">
				<div class="nwFormGroup">
					<label><?=lang("Due_Date:", "AAR"); ?></label>
					<input type="text" class="frmData has_date" id="new-due_date" name="due_date" value="<?=date('Y-m-d'); ?>">
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
	$qu_acc_biling_items_sel = "SELECT * FROM  `acc_biling_items` WHERE `bill_id` = $bill_id";
	$qu_acc_biling_items_EXE = mysqli_query($KONN, $qu_acc_biling_items_sel);
	if(mysqli_num_rows($qu_acc_biling_items_EXE)){
		$itemsC = 0;
		while($acc_biling_items_REC = mysqli_fetch_assoc($qu_acc_biling_items_EXE)){
			$itemsC++;
			$bill_item_id = $acc_biling_items_REC['bill_item_id'];
			$item_desc = $acc_biling_items_REC['item_desc'];
			$unit_id = ( int ) $acc_biling_items_REC['unit_id'];
			$item_qty = $acc_biling_items_REC['item_qty'];
			$item_price = $acc_biling_items_REC['item_price'];
			$is_tree = $acc_biling_items_REC['is_tree'];
			
			
			if( $unit_id == 0 ){
				$unit_id = 13;
			}
			
			
			
			
			
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
							<input type="hidden" name="is_trees[]" value="<?=$is_tree; ?>">
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
			<?=lang('Add_Invoice', 'ARR', 1); ?>
		</button></a>
		<a href="acc_biling.php"><button type="button">
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
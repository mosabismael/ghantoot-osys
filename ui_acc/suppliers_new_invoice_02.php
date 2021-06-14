<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	
	
	
	function getPOtotal( $poID, $CONN ){
		$thisTotaler = 0;
		$qu_purchase_orders_items_sel = "SELECT `item_qty`, `item_price` FROM  `purchase_orders_items` WHERE `po_id` = $poID";
		$qu_purchase_orders_items_EXE = mysqli_query($CONN, $qu_purchase_orders_items_sel);
		if(mysqli_num_rows($qu_purchase_orders_items_EXE)){
			while($purchase_orders_items_REC = mysqli_fetch_array($qu_purchase_orders_items_EXE)){
				$itemQty     = ( double ) $purchase_orders_items_REC[0];
				$itemPrice   = ( double ) $purchase_orders_items_REC[1];
				$thisTotaler = $thisTotaler + ( $itemQty * $itemPrice );
			}
		}
		return $thisTotaler;
	}
	
	
	
	
	
	
	
	
	
	
	$menuId = 4;
	$subPageID = 11;
	
	$RES = '';

if( isset($_POST['supplier_id']) && 
	isset($_POST['po_id']) && 
	isset($_POST['account_id']) && 
	isset($_POST['invoice_ref']) && 
	isset($_POST['invoice_date']) && 
	isset($_POST['due_date']) && 
	isset($_POST['total_amount']) && 
	isset($_POST['currency_id']) && 
	isset($_POST['is_vat'])
	){
		
	$supplier_inv_id = 0;
	$supplier_id     = ( int ) test_inputs($_POST['supplier_id']);
	$account_id      = ( int ) test_inputs($_POST['account_id']);
	$po_id           = ( int ) test_inputs($_POST['po_id']);
	$invoice_ref     = test_inputs($_POST['invoice_ref']);
	$invoice_date    = test_inputs($_POST['invoice_date']);
	$due_date        = test_inputs($_POST['due_date']);
	$total_amountREQ = ( double ) test_inputs($_POST['total_amount']);
	$total_amount    = 0;
	$is_vat          = ( int ) test_inputs($_POST['is_vat']);
	$currency_id     = ( int ) test_inputs($_POST['currency_id']);
	
	$invoice_status  = "pending_payment";
	
	$created_date    = date( 'Y-m-d H:i:00' );
	$created_by      = $EMPLOYEE_ID;
	$exchange_rate   = 0;
	$is_cur_main     = 0;
	
	
	//get exchange rate
	$qu_gen_currencies_sel = "SELECT `exchange_rate`, `is_main` FROM  `gen_currencies` WHERE `currency_id` = $currency_id";
	$qu_gen_currencies_EXE = mysqli_query($KONN, $qu_gen_currencies_sel);
	if(mysqli_num_rows($qu_gen_currencies_EXE)){
		$gen_currencies_DATA = mysqli_fetch_assoc($qu_gen_currencies_EXE);
		$exchange_rate = ( double ) $gen_currencies_DATA['exchange_rate'];
		$is_cur_main       = ( int ) $gen_currencies_DATA['is_main'];
	}

	
	$amountInMainCurrency = 0;
	
		if( $is_cur_main == 1 ){
			//its AED no change
			$amountInMainCurrency = $total_amountREQ;
		} else {
			
			//get exchange rate for main currency
	$MAINexchange_rate = 0;
	$qu_gen_currencies_sel = "SELECT `exchange_rate` FROM  `gen_currencies` WHERE ((`is_main` = 1)) LIMIT 1";
	$qu_gen_currencies_EXE = mysqli_query($KONN, $qu_gen_currencies_sel);
	if(mysqli_num_rows($qu_gen_currencies_EXE)){
		$gen_currencies_DATA = mysqli_fetch_assoc($qu_gen_currencies_EXE);
		$MAINexchange_rate   = ( double ) $gen_currencies_DATA['exchange_rate'];
	}

			
			//convert value to AED
			$amountInMainCurrency = $total_amountREQ / $MAINexchange_rate;
			
		}
		
		$total_amount = $amountInMainCurrency;
		 
	
	//invoice_attach
	$invoice_attach = 'na';
	if(isset($_FILES['invoice_attach']) && $_FILES['invoice_attach']["tmp_name"]){
		//upload side image
		$upload_res = upload_picture('invoice_attach', 9000, 'uploads', '../');
		if($upload_res == true){
			$invoice_attach = $upload_res;
		} else {
			die('s4443='.$upload_res);
		}
	}
	
	
	if( $supplier_id != 0 ){
		
		
		//check if main currency or not
		
		if( $is_cur_main == 1 ){
			//its AED no change
		} else {
			//convert value to AED
		}
		
		
		$totVat = 0;
		if( $is_vat == 1 ){
			$totVat = $total_amount * 0.05;
		}
		$tot_aftr_VAT = $totVat + $total_amount;
		
		


	$qu_acc_suppliers_invoices_ins = "INSERT INTO `acc_suppliers_invoices` (
						`supplier_id`, 
						`po_id`, 
						`invoice_ref`, 
						`invoice_date`, 
						`due_date`, 
						`currency_id`, 
						`exchange_rate`, 
						`invoice_attach`, 
						`total_amount`, 
						`is_vat`, 
						`invoice_status`, 
						`created_date`, 
						`created_by` 
					) VALUES (
						'".$supplier_id."', 
						'".$po_id."', 
						'".$invoice_ref."', 
						'".$invoice_date."', 
						'".$due_date."', 
						'".$currency_id."', 
						'".$exchange_rate."', 
						'".$invoice_attach."', 
						'".$total_amountREQ."', 
						'".$is_vat."', 
						'".$invoice_status."', 
						'".$created_date."', 
						'".$created_by."' 
					);";


	if(mysqli_query($KONN, $qu_acc_suppliers_invoices_ins)){
		
		
			$supplier_inv_id = mysqli_insert_id($KONN);
			if( $supplier_inv_id != 0 ){
			//insert state change
				if( insert_state_change($KONN, $invoice_status, $supplier_inv_id, "acc_suppliers_invoices", $EMPLOYEE_ID) ) {
					
					
					
					
					
					
					
					//reflect on supp acc
					//get supplier account
		$last_updated = date('Y-m-d h:i:00');
		$qu_acc_accounts_updt = "UPDATE  `acc_accounts` SET 
								`last_updated` = '".$last_updated."' WHERE `account_id` = $account_id;";
		if(!mysqli_query($KONN, $qu_acc_accounts_updt)){
			die( 'ERR-54544' );
		}
			//insert account_cycle records
			$created_date = date('Y-m-d h:i:00');
			$ref_no = 'INV-'.$invoice_ref.'-'.$supplier_inv_id;
			$debit = 0;
			$credit = $tot_aftr_VAT;
			$memo = "";
			$typo = "AUTO-INV-".$invoice_ref;
			
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
								'".$account_id."', 
								'".$memo."', 
								'".$typo."', 
								'".$EMPLOYEE_ID."'
							);";

			if(!mysqli_query($KONN, $qu_acc_cycle_ins)){
				die( 'ERR-888' );
			}
					
					
					
					
if( $is_vat == 1 ){
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
			$ref_no = 'INVSupp-'.$invoice_ref.'-'.$supplier_inv_id;
			$debit = $totVat;
			$credit = 0;
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
}


//TODO
//add value before VAT to project account if it belongs toa  project



					header("location:suppliers_invoices.php?added=".$supplier_inv_id);
					die();
					
				} else {
					die('0|Data Status Error 65154');
				}
			}
		} else {
			die("ERR-123-".mysqli_error( $KONN ));
		}
	
	} else {
		$RES = 'Supplier not defined';
	}

}



	$supplier_id = 0;
	if( isset( $_GET['supplier_id'] ) ){
		$supplier_id = ( int ) $_GET['supplier_id'];
	} else {
		header("location:suppliers.php?noSupp=1");
	}








	//get supplier account
	$qu_suppliers_list_sel = "SELECT `supplier_code` FROM  `suppliers_list` WHERE `supplier_id` = $supplier_id";
	$qu_suppliers_list_EXE = mysqli_query($KONN, $qu_suppliers_list_sel);
	$sup_account_id = 0;
	if(mysqli_num_rows($qu_suppliers_list_EXE)){
		$suppliers_list_DATA = mysqli_fetch_assoc($qu_suppliers_list_EXE);
		$supplier_code = $suppliers_list_DATA['supplier_code'];
		
		
			$qu_acc_accounts_sel = "SELECT * FROM  `acc_accounts` WHERE `account_no` = '$supplier_code' LIMIT 1";
			$qu_acc_accounts_EXE = mysqli_query($KONN, $qu_acc_accounts_sel);
			$acc_accounts_DATA;
			if(mysqli_num_rows($qu_acc_accounts_EXE)){
				$acc_accounts_DATA = mysqli_fetch_assoc($qu_acc_accounts_EXE);
				$sup_account_id = ( int ) $acc_accounts_DATA['account_id'];
				
			} else {
				header("location:suppliers_new_invoice_01.php?noAcc=1");
			}

		
		
	} else {
		header("location:suppliers_new_invoice_01.php?noAcc=1");
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
		<form action="suppliers_new_invoice_02.php" method="POST" enctype="multipart/form-data">
		
		
			<div class="row col-100">
				<div class="nwFormGroup">
					<label><?=lang("Select_Supplier:", "AAR"); ?></label>
					<input type="hidden" id="new-sup_account_id" name="account_id" value="<?=$sup_account_id; ?>" required>
					<select class="frmData" id="new-supplier_id" name="supplier_id" required>
		<?php
			$sNo = 0;
			$qu_suppliers_list_sel = "SELECT * FROM  `suppliers_list` WHERE `supplier_id` = '$supplier_id'";
			$qu_suppliers_list_EXE = mysqli_query($KONN, $qu_suppliers_list_sel);
			if(mysqli_num_rows($qu_suppliers_list_EXE)){
				while($suppliers_list_REC = mysqli_fetch_assoc($qu_suppliers_list_EXE)){
					$supplier_id       = ( int ) $suppliers_list_REC['supplier_id'];
					
			$supplier_code = $suppliers_list_REC['supplier_code'];
			$supplier_name = $suppliers_list_REC['supplier_name'];
				
				?>
						<option value="<?=$supplier_id; ?>" selected><?=$supplier_name; ?></option>
				<?php
				
				
		
				}
			}
		?>
					</select>
				</div>
				<div class="zero"></div>
			</div>
		
			<div class="row col-100">
				<div class="nwFormGroup">
					<label><?=lang("Select_PO:", "AAR"); ?></label>
					<select class="frmData" id="new-po_id" name="po_id" required>
						<option value="0" disabled selected><?=lang("Please_Select", "غير محدد"); ?></option>
		<?php
			$sNo = 0;
			$qu_purchase_orders_sel = "SELECT * FROM  `purchase_orders` WHERE ((`supplier_id` = '$supplier_id') AND ((`po_status` = 'pending_arrival') OR (`po_status` = 'fullly_material_arrived') OR (`po_status` = 'partially_material_arrived')) ) ORDER BY `po_id` DESC";
			$qu_purchase_orders_EXE = mysqli_query($KONN, $qu_purchase_orders_sel);
			if( mysqli_num_rows($qu_purchase_orders_EXE) > 0 ){
				while($purchase_orders_REC = mysqli_fetch_assoc($qu_purchase_orders_EXE)){
					$po_id       = ( int ) $purchase_orders_REC['po_id'];
					$po_ref = $purchase_orders_REC['po_ref'];
				
					$qu_inv_stock_sel = "SELECT COUNT(`stock_id`) FROM  `inv_stock` WHERE 
																		((`stock_status` = 'rejected') AND 
																		 (`po_id` = $po_id))";
					$qu_inv_stock_EXE = mysqli_query($KONN, $qu_inv_stock_sel);
					if(mysqli_num_rows($qu_inv_stock_EXE)){
						$inv_stock_DATA = mysqli_fetch_array($qu_inv_stock_EXE);
						$tot_rejected = ( int ) $inv_stock_DATA[0];
						if( $tot_rejected == 0 ){
							
							
							//get total amount of this PO
						$totPO = ( double ) getPOtotal( $po_id, $KONN );
							
							
				?>
						<option value="<?=$po_id; ?>" id="poTot-<?=$po_id; ?>" data-tot="<?=$totPO; ?>"><?=$po_ref; ?></option>
				<?php
						}
					}
				
				}
			}
		?>
					</select>
				</div>
				<div class="zero"></div>
			</div>
		
			<div class="row col-100">
				<div class="nwFormGroup">
					<label><?=lang("invoice_ref:", "AAR"); ?></label>
					<input type="text" class="frmData" id="new-invoice_ref" name="invoice_ref" required>
				</div>
				<div class="zero"></div>
			</div>
		
			<div class="row col-100">
				<div class="nwFormGroup">
					<label><?=lang("invoice_date:", "AAR"); ?></label>
					<input type="text" class="frmData has_date" id="new-invoice_date" name="invoice_date" required>
				</div>
				<div class="zero"></div>
			</div>
		
			<div class="row col-100">
				<div class="nwFormGroup">
					<label><?=lang("due_date:", "AAR"); ?></label>
					<input type="text" class="frmData has_date" id="new-due_date" name="due_date" required>
				</div>
				<div class="zero"></div>
			</div>
		
			<div class="row col-100">
				<div class="nwFormGroup">
					<label><?=lang("Attach_Invoice:", "AAR"); ?></label>
					<input type="file" class="frmData" id="new-invoice_attach" name="invoice_attach" required>
				</div>
				<div class="zero"></div>
			</div>
		

			<div class="row col-100">
				<div class="nwFormGroup">
					<label><?=lang("Invoice_Currency:", "AAR"); ?></label>
					<select class="frmData" id="new-currency_id" name="currency_id" required>
						<option value="0" disabled selected><?=lang("Please_Select", "غير محدد"); ?></option>
		<?php
			$qu_gen_currencies_sel = "SELECT `currency_id`, `currency_name` FROM  `gen_currencies`";
			$qu_gen_currencies_EXE = mysqli_query($KONN, $qu_gen_currencies_sel);
			if(mysqli_num_rows($qu_gen_currencies_EXE)){
				while($gen_currencies_REC = mysqli_fetch_assoc($qu_gen_currencies_EXE)){
					$currency_id = $gen_currencies_REC['currency_id'];
					$currency_name = $gen_currencies_REC['currency_name'];
				?>
						<option value="<?=$currency_id; ?>"><?=$currency_name; ?></option>
				<?php
				}
			}
		?>
					</select>
				</div>
				<div class="zero"></div>
			</div>
		
		
			<div class="row col-100">
				<div class="nwFormGroup">
					<label><?=lang("Total_amount (WITHOUT VAT):", "AAR"); ?></label>
					<input type="text" class="frmData" id="new-total_amount" name="total_amount" required>
				</div>
				<div class="zero"></div>
			</div>
<script>
$('#new-po_id').on('change', function(){
	var selctdPO = parseInt( $('#new-po_id').val() );
	if( selctdPO != 0 ){
		var selPoTot = parseFloat( $('#poTot-' + selctdPO).attr('data-tot') );
		if( isNaN( selPoTot ) ){
			selPoTot = 0;
		}
		$('#new-total_amount').val( selPoTot );
	}
} );
</script>
		
			<div class="row col-100">
				<div class="nwFormGroup">
					<label><?=lang("VAT:", "AAR"); ?></label>
					<select class="frmData" id="new-is_vat" name="is_vat" required>
						<option value="1">YES</option>
						<option value="0">NO</option>
					</select>
				</div>
				<div class="zero"></div>
			</div>
			
			<div class="zero"></div>
				


<div class="viewerBodyButtons">
		<?=$RES; ?><br>
		<a href="suppliers_new_invoice_01.php"><button type="button">
			<?=lang('Back', 'ARR', 1); ?>
		</button></a>
		<button type="submit">
			<?=lang('Next', 'ARR', 1); ?>
		</button>
</div>
			
		</form>
	</div>
	<div class="zero"></div>
</div>


<?php
	//PAGE DATA END   ----------------------------------------------///---------------------------------
	include('app/footer.php');
?>
</body>
</html>
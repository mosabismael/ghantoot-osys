<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	$menuId = 4;
	$subPageID = 13;
	$RES = '';
	
	
if( isset($_POST['payment_type']) && 
	isset($_POST['account_rec']) && 
	isset($_POST['account_pay']) && 
	isset($_POST['payment_amount']) && 
	isset($_POST['receipt_ref']) && 
	isset($_POST['cheque_no']) && 
	isset($_POST['cheque_date']) && 
	isset($_POST['transfer_no']) && 
	isset($_POST['supplier_id']) 
	){

	$supp_payment_id = 0;
	$payment_amount = ( double ) test_inputs($_POST['payment_amount']);
	$account_rec = ( int ) test_inputs($_POST['account_rec']);
	$account_pay = ( int ) test_inputs($_POST['account_pay']);
	$payment_type = test_inputs($_POST['payment_type']);
	$receipt_ref = test_inputs($_POST['receipt_ref']);
	$cheque_no   = test_inputs($_POST['cheque_no']);
	$cheque_date = test_inputs($_POST['cheque_date']);
	$transfer_no = test_inputs($_POST['transfer_no']);
	$payment_date = date( 'Y-m-d H:i:00' );
	$created_by = $EMPLOYEE_ID;
	$supplier_id = test_inputs($_POST['supplier_id']);
	

	$qu_acc_suppliers_payments_ins = "INSERT INTO `acc_suppliers_payments` (
						`payment_type`, 
						`account_pay`, 
						`account_rec`, 
						`payment_amount`, 
						`receipt_ref`, 
						`cheque_no`, 
						`cheque_date`, 
						`transfer_no`, 
						`payment_date`, 
						`created_by`, 
						`supplier_id` 
					) VALUES (
						'".$payment_type."', 
						'".$account_pay."', 
						'".$account_rec."', 
						'".$payment_amount."', 
						'".$receipt_ref."', 
						'".$cheque_no."', 
						'".$cheque_date."', 
						'".$transfer_no."', 
						'".$payment_date."', 
						'".$created_by."', 
						'".$supplier_id."' 
					);";

	if(mysqli_query($KONN, $qu_acc_suppliers_payments_ins)){
		$supp_payment_id = mysqli_insert_id($KONN);
		if( $supp_payment_id != 0 ){
			
			$last_updated = date('Y-m-d h:i:00');
		//reflect on accounts
			$qu_acc_accounts_updt = "UPDATE  `acc_accounts` SET 
									`last_updated` = '".$last_updated."' WHERE `account_id` = $account_rec;";
			if(!mysqli_query($KONN, $qu_acc_accounts_updt)){
				die( 'ERR-54544' );
			}
		//reflect on accounts
			$qu_acc_accounts_updt = "UPDATE  `acc_accounts` SET 
									`last_updated` = '".$last_updated."' WHERE `account_id` = $account_pay;";
			if(!mysqli_query($KONN, $qu_acc_accounts_updt)){
				die( 'ERR-54544' );
			}
		
		//insert account_cycle records
			$created_date = date('Y-m-d h:i:00');
			$ref_no = 'PAY-SUP-'.$supp_payment_id;
			$debit = $payment_amount;
			$credit = 0;
			$memo = "";
			$typo = "SUP-PAYMENT-ISSUED";
			
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
								'".$account_rec."', 
								'".$memo."', 
								'".$typo."', 
								'".$EMPLOYEE_ID."'
							);";

			if(!mysqli_query($KONN, $qu_acc_cycle_ins)){
				die( 'ERR-888' );
			}
		
		//insert account_cycle records
			$created_date = date('Y-m-d h:i:00');
			$ref_no = 'PAY-SUP-'.$supp_payment_id;
			$debit = 0;
			$credit = $payment_amount;
			$memo = "";
			$typo = "SUP-PAYMENT-ISSUED";
			
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
								'".$account_pay."', 
								'".$memo."', 
								'".$typo."', 
								'".$EMPLOYEE_ID."'
							);";

			if(!mysqli_query($KONN, $qu_acc_cycle_ins)){
				die( 'ERR-888' );
			}
			
			
		//insert state change
			if( insert_state_change($KONN, "Payment-Issued", $supp_payment_id, "acc_suppliers_payments", $EMPLOYEE_ID) ) {
				header("location:suppliers_invoices.php?supp_payment_id=".$supp_payment_id);
				die();
			} else {
				die('0|Data Status Error 65154');
			}
		}
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
				header("location:suppliers_pay_expense_01.php?noAcc=1");
			}

		
		
	} else {
		header("location:suppliers_pay_expense_01.php?noAcc=1");
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
		<form action="suppliers_pay_expense_02.php" method="POST" enctype="multipart/form-data">
		
		
			<div class="row col-100">
				<div class="nwFormGroup">
					<label><?=lang("Select_Supplier:", "AAR"); ?></label>
					<input type="hidden" id="new-sup_account_id" name="account_rec" value="<?=$sup_account_id; ?>" required>
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
					<label><?=lang("Select_Payment_Type:", "AAR"); ?></label>
					<select class="frmData" id="new-payment_type" name="payment_type" required>
						<option value="0" disabled selected><?=lang("Please_Select", "غير محدد"); ?></option>
						<option value="cheque"><?=lang("Cheque", "غير محدد"); ?></option>
						<option value="cash"><?=lang("Cash", "غير محدد"); ?></option>
						<option value="bank_transfer"><?=lang("Bank_Transfer", "غير محدد"); ?></option>
					</select>
				</div>
				<div class="zero"></div>
			</div>
		
			<div class="row col-100">
				<div class="nwFormGroup">
					<label><?=lang("Select_Account:", "AAR"); ?></label>
					<select class="frmData" id="new-account_pay" name="account_pay" required>
						<option value="0" disabled selected><?=lang("Please_Select", "غير محدد"); ?></option>
		<?php
			$qu_acc_accounts_sel = "SELECT `account_id`, `account_no`, `account_name` FROM  `acc_accounts` WHERE 
					( (`account_type_id` = '3' ) || (`account_type_id` = '9' ) || (`account_type_id` = '10' )) 
					ORDER BY `account_no` ASC";
			$qu_acc_accounts_EXE = mysqli_query($KONN, $qu_acc_accounts_sel);
			if(mysqli_num_rows($qu_acc_accounts_EXE)){
				while($acc_accounts_REC = mysqli_fetch_assoc($qu_acc_accounts_EXE)){
					$account_id   = ( int ) $acc_accounts_REC['account_id'];
					$account_name = $acc_accounts_REC['account_name'];
					$account_no   = $acc_accounts_REC['account_no'];
				?>
						<option value="<?=$account_id; ?>"><?=$account_no; ?> - <?=$account_name; ?></option>
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
					<label><?=lang("payment_amount:", "AAR"); ?></label>
					<input type="text" class="frmData" id="new-payment_amount" name="payment_amount" required>
				</div>
				<div class="zero"></div>
			</div>
		
			<div class="row col-100">
				<div class="nwFormGroup">
					<label><?=lang("receipt_ref:", "AAR"); ?></label>
					<input type="text" class="frmData" id="new-receipt_ref" name="receipt_ref" required>
				</div>
				<div class="zero"></div>
			</div>
		
			<div class="row col-100">
				<div class="nwFormGroup">
					<label><?=lang("cheque_no:", "AAR"); ?>( <?=lang("Leave_zero_If_not_applicable:", "AAR"); ?> )</label>
					<input type="text" class="frmData" id="new-cheque_no" value="0" name="cheque_no" required>
				</div>
				<div class="zero"></div>
			</div>
		
			<div class="row col-100">
				<div class="nwFormGroup">
					<label><?=lang("cheque_Date:", "AAR"); ?>( <?=lang("Leave_Empty_If_not_applicable:", "AAR"); ?> )</label>
					<input type="text" class="frmData has_date" id="new-cheque_date" name="cheque_date" required>
				</div>
				<div class="zero"></div>
			</div>
		
			<div class="row col-100">
				<div class="nwFormGroup">
					<label><?=lang("Transfer_no:", "AAR"); ?>( <?=lang("Leave_zero_If_not_applicable:", "AAR"); ?> )</label>
					<input type="text" class="frmData" id="new-transfer_no" value="0" name="transfer_no" required>
				</div>
				<div class="zero"></div>
			</div>
			
			<div class="zero"></div>
				


<div class="viewerBodyButtons">
		<?=$RES; ?><br>
		<a href="suppliers_pay_expense_01.php"><button type="button">
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
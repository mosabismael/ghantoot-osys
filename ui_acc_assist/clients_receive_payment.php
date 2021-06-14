<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 5;
	$subPageID = 170;
	

	
if( isset($_POST['payment_type']) && 
	isset($_POST['account_rec']) && 
	isset($_POST['payment_amount']) && 
	isset($_POST['receipt_ref']) && 
	isset($_POST['cheque_no']) && 
	isset($_POST['cheque_date']) && 
	isset($_POST['transfer_no']) && 
	isset($_POST['client_id']) 
	){

	$client_payment_id = 0;
	$payment_amount = ( double ) test_inputs($_POST['payment_amount']);
	$account_rec = ( int ) test_inputs($_POST['account_rec']);
	$payment_type = test_inputs($_POST['payment_type']);
	$receipt_ref = test_inputs($_POST['receipt_ref']);
	$cheque_no   = test_inputs($_POST['cheque_no']);
	$cheque_date = test_inputs($_POST['cheque_date']);
	$transfer_no = test_inputs($_POST['transfer_no']);
	$payment_date = date( 'Y-m-d H:i:00' );
	$created_by = $EMPLOYEE_ID;
	$client_id = test_inputs($_POST['client_id']);
	
	$qu_gen_clients_sel = "SELECT `client_code` FROM  `gen_clients` WHERE `client_id` = $client_id";
	$qu_gen_clients_EXE = mysqli_query($KONN, $qu_gen_clients_sel);
	$client_code = '';
	if(mysqli_num_rows($qu_gen_clients_EXE)){
		$gen_clients_DATA = mysqli_fetch_assoc($qu_gen_clients_EXE);
		$client_code = $gen_clients_DATA['client_code'];
	}

	
		//get client account_id
	$qu_acc_accounts_sel = "SELECT `account_id` FROM  `acc_accounts` WHERE `account_no` = '$client_code' LIMIT 1";
	$qu_acc_accounts_EXE = mysqli_query($KONN, $qu_acc_accounts_sel);
	$client_ACC;
	if(mysqli_num_rows($qu_acc_accounts_EXE)){
		$acc_accounts_DATA = mysqli_fetch_assoc($qu_acc_accounts_EXE);
		$client_ACC = ( int ) $acc_accounts_DATA['account_id'];
	} else {
		die("ACC NOT DEFINED");
	}
			

	$qu_acc_clients_payments_ins = "INSERT INTO `acc_clients_payments` (
						`payment_type`, 
						`payment_amount`, 
						`receipt_ref`, 
						`cheque_no`, 
						`cheque_date`, 
						`transfer_no`, 
						`payment_date`, 
						`created_by`, 
						`client_id` 
					) VALUES (
						'".$payment_type."', 
						'".$payment_amount."', 
						'".$receipt_ref."', 
						'".$cheque_no."', 
						'".$cheque_date."', 
						'".$transfer_no."', 
						'".$payment_date."', 
						'".$created_by."', 
						'".$client_id."' 
					);";

	if(mysqli_query($KONN, $qu_acc_clients_payments_ins)){
		$client_payment_id = mysqli_insert_id($KONN);
		if( $client_payment_id != 0 ){
			
			$last_updated = date('Y-m-d h:i:00');
		//reflect on accounts
			$qu_acc_accounts_updt = "UPDATE  `acc_accounts` SET 
									`last_updated` = '".$last_updated."' WHERE `account_id` = $client_ACC;";
			if(!mysqli_query($KONN, $qu_acc_accounts_updt)){
				die( 'ERR-54544' );
			}
		//reflect on accounts
			$qu_acc_accounts_updt = "UPDATE  `acc_accounts` SET 
									`last_updated` = '".$last_updated."' WHERE `account_id` = $account_rec;";
			if(!mysqli_query($KONN, $qu_acc_accounts_updt)){
				die( 'ERR-54544' );
			}
		
		//insert account_cycle records
			$created_date = date('Y-m-d h:i:00');
			$ref_no = 'REC-PAY-'.$client_payment_id;
			$debit = 0;
			$credit = $payment_amount;
			$memo = "";
			$typo = "CLIENT-PAYMENT-RECEIVED";
			
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
								'".$client_ACC."', 
								'".$memo."', 
								'".$typo."', 
								'".$EMPLOYEE_ID."'
							);";

			if(!mysqli_query($KONN, $qu_acc_cycle_ins)){
				die( 'ERR-888' );
			}
		
		//insert account_cycle records
			$created_date = date('Y-m-d h:i:00');
			$ref_no = 'REC-PAY-'.$client_payment_id;
			$debit = $payment_amount;
			$credit = 0;
			$memo = "";
			$typo = "CLIENT-PAYMENT-RECEIVED";
			
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
			
			
		//insert state change
			if( insert_state_change($KONN, "Payment-Received", $client_payment_id, "acc_clients_payments", $EMPLOYEE_ID) ) {
				header("location:clients.php?client_payment_id=".$client_payment_id);
			} else {
				die('0|Data Status Error 65154');
			}
		}
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



<div class="row">
	<div class="col-100">
		<form action="clients_receive_payment.php" method="POST">
		
			<div class="row col-100">
				<div class="nwFormGroup">
					<label><?=lang("Select_Client:", "AAR"); ?></label>
					<select class="frmData" id="new-client_id" name="client_id" required>
						<option value="0" disabled selected><?=lang("Please_Select", "غير محدد"); ?></option>
		<?php
			$sNo = 0;
			$qu_gen_clients_sel = "SELECT * FROM  `gen_clients` ORDER BY `client_name` ASC";
			$qu_gen_clients_EXE = mysqli_query($KONN, $qu_gen_clients_sel);
			if(mysqli_num_rows($qu_gen_clients_EXE)){
				while($gen_clients_REC = mysqli_fetch_assoc($qu_gen_clients_EXE)){
					$client_id       = ( int ) $gen_clients_REC['client_id'];
					$client_name = $gen_clients_REC['client_name'];
					$client_code = $gen_clients_REC['client_code'];


	$qu_acc_accounts_sel = "SELECT `account_id` FROM  `acc_accounts` WHERE `account_no` = '$client_code' LIMIT 1";
	$qu_acc_accounts_EXE = mysqli_query($KONN, $qu_acc_accounts_sel);
	$acc_accounts_DATA;
	if(mysqli_num_rows($qu_acc_accounts_EXE)){
		$acc_accounts_DATA = mysqli_fetch_assoc($qu_acc_accounts_EXE);
		$account_id = $acc_accounts_DATA['account_id'];
				?>
						<option value="<?=$client_id; ?>"><?=$client_name; ?> - <?=$client_code; ?></option>
				<?php
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
					<select class="frmData" id="new-account_rec" name="account_rec" required>
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
		<a href="acc_biling.php"><button type="button">
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
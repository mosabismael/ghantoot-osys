<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		if( isset($_POST['account_no']) && 
		isset($_POST['account_name']) && 
		isset($_POST['account_type_id']) && 
		isset($_POST['account_description']) && 
		isset($_POST['opening_balance']) ){
			
			
			$account_id = 0;
			$account_no = test_inputs($_POST['account_no']);
			$account_name = test_inputs($_POST['account_name']);
			$account_type_id = test_inputs($_POST['account_type_id']);
			$account_description = test_inputs($_POST['account_description']);
			if( $account_description == '' ){
				$account_description = 'NA';
			}
			$opening_balance = ( double ) test_inputs($_POST['opening_balance']);
			$current_balance = $opening_balance;
			$last_updated = date('Y-m-d H:i:00');
			
			
			$qu_acc_accounts_sel = "SELECT * FROM  `acc_accounts` WHERE `account_name` = '$account_name' ";
			$userStatement = mysqli_prepare($KONN,$qu_acc_accounts_sel);
			mysqli_stmt_execute($userStatement);
			$qu_acc_accounts_EXE = mysqli_stmt_get_result($userStatement);
			if(mysqli_num_rows($qu_acc_accounts_EXE)){
				die("0|Account Name Already Exist");
			}
			
			$qu_acc_accounts_sel = "SELECT * FROM  `acc_accounts` WHERE `account_no` = '$account_no' ";
			$userStatement = mysqli_prepare($KONN,$qu_acc_accounts_sel);
			mysqli_stmt_execute($userStatement);
			$qu_acc_accounts_EXE = mysqli_stmt_get_result($userStatement);
			if(mysqli_num_rows($qu_acc_accounts_EXE)){
				die("0|Account NO Already Exist");
			}
			
			$qu_acc_accounts_ins = "INSERT INTO `acc_accounts` (
			`account_no`, 
			`account_name`, 
			`account_type_id`, 
			`account_description`, 
			`opening_balance`, 
			`current_balance`, 
			`last_updated`
			) VALUES (
			'".$account_no."', 
			'".$account_name."', 
			'".$account_type_id."', 
			'".$account_description."', 
			'".$opening_balance."', 
			'".$current_balance."', 
			'".$last_updated."'
			);";
			$insertStatement = mysqli_prepare($KONN,$qu_acc_accounts_ins);
			mysqli_stmt_execute($insertStatement);
			$account_id = mysqli_insert_id($KONN);
			if( $account_id != 0 ){
				
				if( !insert_state_change($KONN, "New-COA", $account_id, "acc_accounts", $EMPLOYEE_ID) ) {
					die('0|Data Status Error 65154');
				}
				
				
				$cycle_id = 0;
				$created_date = date('Y-m-d H:i:00');
				$ref_no = "Open Balance";
				$debit = 0;
				$credit = $opening_balance;
				
				
				
				
				if( $opening_balance == 0 ){
					$debit = 0;
					$credit = 0;
					} else if( $opening_balance > 0 ){
					$debit = 0;
					$credit = $opening_balance;
					} else if( $opening_balance < 0 ){
					$debit = $opening_balance;
					$credit = 0;
				}
				
				
				
				$typo = "AUTO-ACC-OB";
				
				$related_id = 0;
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
				$insertStatement = mysqli_prepare($KONN,$qu_acc_cycle_ins);
				mysqli_stmt_execute($insertStatement);
				$cycle_id = mysqli_insert_id($KONN);
				if( $cycle_id != 0 ){
					die('1|acc_coa.php');
				}
				
				
				
				
				
				
				
				
				
			}
			
			
			
			
			} else {
			die('0|7wiu');
	}
}
catch(Exception $e){
	if ( is_resource($KONN)) {
		mysqli_close($KONN);
	}
}
finally{
	if ( is_resource($KONN)) {
		mysqli_close($KONN);
	}
}
?>

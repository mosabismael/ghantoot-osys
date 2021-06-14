<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	try{
		
		if( isset($_POST['src_id']) &&
		isset($_POST['dst_id']) &&
		isset($_POST['amount']) &&
		isset($_POST['notes']) 
		){
			
			$return_arr;
			$src_id = (int) test_inputs($_POST['src_id']);
			$dst_id = (int) test_inputs($_POST['dst_id']);
			$amount = (double) test_inputs($_POST['amount']);
			$notes = test_inputs($_POST['notes']);
			
			$last_updated = date('Y-m-d h:i:00');
			
			
			
			
			$employee_id = $EMPLOYEE_ID;
			
			
			
			
			$qu_acc_accounts_sel = "SELECT * FROM  `acc_accounts` WHERE `account_id` = $src_id";
			$userStatement = mysqli_prepare($KONN,$qu_acc_accounts_sel);
			mysqli_stmt_execute($userStatement);
			$qu_acc_accounts_EXE = mysqli_stmt_get_result($userStatement);
			$dst_account_DATA;
			$src_account_DATA;
			$src_account_DATA = mysqli_fetch_assoc($qu_acc_accounts_EXE);
			
			
			$qu_acc_accounts_sel = "SELECT * FROM  `acc_accounts` WHERE `account_id` = $dst_id";
			$userStatement = mysqli_prepare($KONN,$qu_acc_accounts_sel);
			mysqli_stmt_execute($userStatement);
			$qu_acc_accounts_EXE = mysqli_stmt_get_result($userStatement);
			$dst_account_DATA;
			$dst_account_DATA = mysqli_fetch_assoc($qu_acc_accounts_EXE);
			
			
			
			
			//calc dst new balance and update
			$dst_ORG = (double) $dst_account_DATA['current_balance'];
			$dst_new_balance = $dst_ORG + $amount;
			$qu_acc_accounts_updt = "UPDATE  `acc_accounts` SET 
			`current_balance` = '".$dst_new_balance."', `last_updated` = '".$last_updated."' WHERE `account_id` = $dst_id;";
			$updateStatement = mysqli_prepare($KONN,$qu_acc_accounts_updt);
			mysqli_stmt_execute($updateStatement);
			
			
			//calc src new balance and update
			$src_ORG = (double) $src_account_DATA['current_balance'];
			$src_new_balance = $src_ORG - $amount;
			$qu_acc_accounts_updt = "UPDATE  `acc_accounts` SET 
			`current_balance` = '".$src_new_balance."', `last_updated` = '".$last_updated."' WHERE `account_id` = $src_id;";
			$updateStatement = mysqli_prepare($KONN,$qu_acc_accounts_updt);
			mysqli_stmt_execute($updateStatement);
			
			
			
			//insert account_cycle records
			$created_date = date('Y-m-d h:i:00');
			$ref_no = 'CshMngEx-'.date('Ymdhi00');
			$debit = $amount;
			$credit = 0;
			$account_id =$src_id;
			$memo = $notes;
			$typo = "AUTO-ACC-EXCHANGE";
			
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
			'".$employee_id."'
			);";
			$insertStatement = mysqli_prepare($KONN,$qu_acc_cycle_ins);
			
			mysqli_stmt_execute($insertStatement);
			
			//insert account_cycle records
			$created_date = date('Y-m-d h:i:01');
			$ref_no = 'CshMngEx-'.date('Ymdhi01');
			$debit = 0;
			$credit = $amount;
			$account_id =$dst_id;
			$memo = $notes;
			$typo = "AUTO-ACC-EXCHANGE";
			
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
			'".$employee_id."'
			);";
			$insertStatement = mysqli_prepare($KONN,$qu_acc_cycle_ins);
			
			mysqli_stmt_execute($insertStatement);
			
			$return_arr[] = array( "res" => "success" );
			echo json_encode($return_arr);
			die();
			
			
			
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
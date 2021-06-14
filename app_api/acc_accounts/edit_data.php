<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		if( isset($_POST['account_id']) &&
		isset($_POST['account_no']) &&
		isset($_POST['account_name']) &&
		isset($_POST['account_type_id']) &&
		isset($_POST['account_description']) &&
		isset($_POST['opening_balance']) 
		){
			
			
			$account_id = test_inputs($_POST['account_id']);
			$account_no = test_inputs($_POST['account_no']);
			$account_name = test_inputs($_POST['account_name']);
			$account_type_id = test_inputs($_POST['account_type_id']);
			$account_description = test_inputs($_POST['account_description']);
			$opening_balance = test_inputs($_POST['opening_balance']);
			$last_updated = date('Y-m-d H:i:00');
			
			
			$qu_acc_accounts_sel = "SELECT `account_no`, `account_name` FROM  `acc_accounts` WHERE `account_id` = $account_id";
			$userStatement = mysqli_prepare($KONN,$qu_acc_accounts_sel);
			mysqli_stmt_execute($userStatement);
			$qu_acc_accounts_EXE = mysqli_stmt_get_result($userStatement);
			$O_account_no = '';
			$O_account_name = '';
			if(mysqli_num_rows($qu_acc_accounts_EXE)){
				$acc_accounts_DATA = mysqli_fetch_assoc($qu_acc_accounts_EXE);
				$O_account_no = $acc_accounts_DATA['account_no'];
				$O_account_name = $acc_accounts_DATA['account_name'];
			}
			
			if( $O_account_name != $account_name ){
				$qu_acc_accounts_sel = "SELECT * FROM  `acc_accounts` WHERE `account_name` = '$account_name' ";
				$userStatement = mysqli_prepare($KONN,$qu_acc_accounts_sel);
				mysqli_stmt_execute($userStatement);
				$qu_acc_accounts_EXE = mysqli_stmt_get_result($userStatement);
				if(mysqli_num_rows($qu_acc_accounts_EXE)){
					die("0|Account Name Already Exist");
				}
			}
			
			if( $O_account_no != $account_no ){
				$qu_acc_accounts_sel = "SELECT * FROM  `acc_accounts` WHERE `account_no` = '$account_no' ";
				$userStatement = mysqli_prepare($KONN,$qu_acc_accounts_sel);
				mysqli_stmt_execute($userStatement);
				$qu_acc_accounts_EXE = mysqli_stmt_get_result($userStatement);
				if(mysqli_num_rows($qu_acc_accounts_EXE)){
					die("0|Account NO Already Exist");
				}
			}
			
			
			
			
			
			
			
			
			
			
			$qu_acc_accounts_updt = "UPDATE  `acc_accounts` SET 
			`account_no` = '".$account_no."', 
			`account_name` = '".$account_name."', 
			`account_type_id` = '".$account_type_id."', 
			`account_description` = '".$account_description."', 
			`opening_balance` = '".$opening_balance."', 
			`last_updated` = '".$last_updated."' 
			WHERE `account_id` = $account_id;";
			$updateStatement = mysqli_prepare($KONN,$qu_acc_accounts_updt);
			mysqli_stmt_execute($updateStatement);
			if( $account_id != 0 ){
				
				
				if( insert_state_change($KONN, "Data Edited", $account_id, "acc_accounts", $EMPLOYEE_ID) ) {
					die("1|Acc Edited");
					} else {
					die('0|Data Status Error 65154');
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

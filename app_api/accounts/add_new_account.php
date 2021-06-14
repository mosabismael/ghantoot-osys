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
		isset($_POST['opening_balance']) 
		){
			
			
			$account_id = 0;
			$account_no = test_inputs($_POST['account_no']);
			$account_name = test_inputs($_POST['account_name']);
			$account_type_id = (int) test_inputs($_POST['account_type_id']);
			
			$opening_balance = (double) test_inputs($_POST['opening_balance']);
			$current_balance = "0";
			
			$account_description = "";
			if( isset($_POST['account_description']) ){
				$account_description = test_inputs( $_POST['account_description'] );
			}
			
			$qu_acc_accounts_ins = "INSERT INTO `acc_accounts` (
			`account_no`, 
			`account_name`, 
			`account_type_id`, 
			`account_description`, 
			`opening_balance`, 
			`current_balance`
			) VALUES (
			'".$account_no."', 
			'".$account_name."', 
			'".$account_type_id."', 
			'".$account_description."', 
			'".$opening_balance."', 
			'".$opening_balance."'
			);";
			$insertStatement = mysqli_prepare($KONN,$qu_acc_accounts_ins);
			
			mysqli_stmt_execute($insertStatement);
			
			$account_id = mysqli_insert_id($KONN);
			if( $account_id != 0 ){
				
				//check if open balance is not 0
				if( $opening_balance != 0 ){
					//insert record at acc cycle
					
					
					$cycle_id = 0;
					$created_date = date('Y-m-d H:i:00');
					$ref_no = "Open Balance";
					$debit = 0;
					$credit = $opening_balance;
					
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
						die('1|Account Added');
					}
					
					
					
					} else {
					die('1|Account Added');
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

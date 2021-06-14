<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	try{
		
		if( isset($_POST['account_id']) &&
		isset($_POST['employee_id']) 
		){
			
			
			$account_id = (int) test_inputs($_POST['account_id']);
			$employee_id = (int) test_inputs($_POST['employee_id']);
			
			
			$ended_date = date('Y-m-d H:i:00');
			
			
			
			
			$qu_acc_accounts_links_updt = "UPDATE  `acc_accounts_links` SET 
			`is_deleted` = '1', 
			`ended_date` = '".$ended_date."',  
			`deleted_by` = '".$EMPLOYEE_ID."'
			WHERE `account_id` = $account_id;";
			$updateStatement = mysqli_prepare($KONN,$qu_acc_accounts_links_updt);
			mysqli_stmt_execute($updateStatement);
			
			
			
			
			
			
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

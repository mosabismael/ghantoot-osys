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
			
			
			
			$notes = "";
			if( isset($_POST['notes']) ){
				$notes = test_inputs( $_POST['notes'] );
			}
			$created_date = date('Y-m-d H:i:00');
			
			
			
			
			$qu_acc_accounts_links_updt = "UPDATE  `acc_accounts_links` SET 
			`is_deleted` = '1', 
			`ended_date` = '".$created_date."',  
			`deleted_by` = '".$EMPLOYEE_ID."'
			WHERE `account_id` = $account_id;";
			$updateStatement = mysqli_prepare($KONN,$qu_acc_accounts_links_updt);
			mysqli_stmt_execute($updateStatement);
			
			
			
			
			
			
			$qu_acc_accounts_links_ins = "INSERT INTO `acc_accounts_links` (
			`employee_id`, 
			`account_id`, 
			`created_date`, 
			`notes`, 
			`is_deleted`, 
			`added_by`
			) VALUES (
			'".$employee_id."', 
			'".$account_id."', 
			'".$created_date."', 
			'".$notes."', 
			'0', 
			'".$EMPLOYEE_ID."'
			);";
			$insertStatement = mysqli_prepare($KONN,$qu_acc_accounts_links_ins);
			
			mysqli_stmt_execute($insertStatement);
			
			$link_id = mysqli_insert_id($KONN);
			if( $link_id != 0 ){
				die('1|Account Connection Added');
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

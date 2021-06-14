<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		if( isset($_POST['account_type_id']) &&
		isset($_POST['account_type_name']) && 
		isset($_POST['account_type_description']) 
		){
			
			$account_type_id = test_inputs($_POST['account_type_id']);
			$account_type_name = test_inputs($_POST['account_type_name']);
			$account_type_description = test_inputs($_POST['account_type_description']);
			
			
			
			
			$qu_acc_accounts_types_sel = "SELECT * FROM  `acc_accounts_types` WHERE `account_type_name` = '$account_type_name' ";
			$userStatement = mysqli_prepare($KONN,$qu_acc_accounts_types_sel);
			mysqli_stmt_execute($userStatement);
			$qu_acc_accounts_types_EXE = mysqli_stmt_get_result($userStatement);
			if(mysqli_num_rows($qu_acc_accounts_types_EXE)){
				die("0|Name Already Exist");
			}
			
			
			
			
			
			$qu_acc_accounts_types_updt = "UPDATE  `acc_accounts_types` SET 
			`account_type_name` = '".$account_type_name."', 
			`account_type_description` = '".$account_type_description."'
			WHERE `account_type_id` = $account_type_id;";
			$updateStatement = mysqli_prepare($KONN,$qu_acc_accounts_types_updt);
			mysqli_stmt_execute($updateStatement);
			if( $account_type_id != 0 ){
				
				if( insert_state_change($KONN, "Data Edited", $account_type_id, "acc_accounts_types", $EMPLOYEE_ID) ) {
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

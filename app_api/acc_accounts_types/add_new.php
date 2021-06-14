<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		if( isset($_POST['account_type_name']) && 
		isset($_POST['account_type_description']) 
		){
			
			$account_type_id = 0;
			$account_type_name = test_inputs($_POST['account_type_name']);
			$account_type_name_ar = $account_type_name;
			$account_type_description = test_inputs($_POST['account_type_description']);
			
			$qu_acc_accounts_types_sel = "SELECT * FROM  `acc_accounts_types` WHERE `account_type_name` = '$account_type_name' ";
			$userStatement = mysqli_prepare($KONN,$qu_acc_accounts_types_sel);
			mysqli_stmt_execute($userStatement);
			$qu_acc_accounts_types_EXE = mysqli_stmt_get_result($userStatement);
			if(mysqli_num_rows($qu_acc_accounts_types_EXE)){
				die("0|Name Already Exist");
			}
			
			
			
			$qu_acc_accounts_types_ins = "INSERT INTO `acc_accounts_types` (
			`account_type_name`, 
			`account_type_name_ar`, 
			`account_type_description` 
			) VALUES (
			'".$account_type_name."', 
			'".$account_type_name_ar."', 
			'".$account_type_description."' 
			);";
			$insertStatement = mysqli_prepare($KONN,$qu_acc_accounts_types_ins);
			mysqli_stmt_execute($insertStatement);
			$account_type_id = mysqli_insert_id($KONN);
			if( $account_type_id != 0 ){
				
				if( insert_state_change($KONN, "New-ACC-typo", $account_type_id, "acc_accounts_types", $EMPLOYEE_ID) ) {
					die("1|ACC Type Added");
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

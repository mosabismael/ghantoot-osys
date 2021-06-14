<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		
		if( isset($_POST['account_id']) ){
			
			$account_id = test_inputs($_POST['account_id']);
			$qu_users_sel = "SELECT `current_balance` FROM  `acc_accounts` WHERE `account_id` = '$account_id'";
			$userStatement = mysqli_prepare($KONN,$qu_users_sel);
			mysqli_stmt_execute($userStatement);
			$qu_users_EXE = mysqli_stmt_get_result($userStatement);
			
			$return_arr;
			$acc_DATA = mysqli_fetch_assoc($qu_users_EXE);
			
			$return_arr[] = array( "balance" => $acc_DATA['current_balance'] );
			
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
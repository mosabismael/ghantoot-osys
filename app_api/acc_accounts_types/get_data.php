<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	
	try{
		
		
		if(!isset($_POST['ids_id'])){
			die('7wiu');
		}
		
		$account_type_id = (int) test_inputs( $_POST['ids_id'] );
		$IAM_ARRAY;
		
		$q = "SELECT * FROM  `acc_accounts_types` WHERE `account_type_id` = $account_type_id";
		$userStatement = mysqli_prepare($KONN,$q);
		mysqli_stmt_execute($userStatement);
		$q_exe = mysqli_stmt_get_result($userStatement);
		
		if(mysqli_num_rows($q_exe) == 0){
			
			$IAM_ARRAY[] = array(  "account_type_id" => 0, 
			"account_type_name" => 0, 
			"account_type_name_ar" => 0, 
			"account_type_description" => 0 
			);
			
			
			} else {
			$ARRAY_SRC = mysqli_fetch_assoc($q_exe);
			
			$IAM_ARRAY[] = array(  "account_type_id" => $ARRAY_SRC['account_type_id'], 
			"account_type_name" => $ARRAY_SRC['account_type_name'], 
			"account_type_name_ar" => $ARRAY_SRC['account_type_name_ar'], 
			"account_type_description" => $ARRAY_SRC['account_type_description'] 
			);
			
			
			
		}
		
		
		echo json_encode($IAM_ARRAY);
		
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

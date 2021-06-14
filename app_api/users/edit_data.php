<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{	
		if( isset($_POST['email']) &&
		isset($_POST['user_id']) &&
		isset($_POST['level']) &&
		isset($_POST['dept_code']) &&
		isset($_POST['status']) 
		){
			
			
			
			$user_id     = 0;
			$email       = test_inputs($_POST['email']);
			$user_id     = test_inputs($_POST['user_id']);
			$level       = test_inputs($_POST['level']);
			$dept_code   = test_inputs($_POST['dept_code']);
			$status      = test_inputs($_POST['status']);
			
			
			$qu_users_updt = "UPDATE  `users` SET 
			`email` = '".$email."', 
			`level` = '".$level."', 
			`dept_code` = '".$dept_code."', 
			`status` = '".$status."' 
			WHERE `user_id` = $user_id;";
			$updateStatement = mysqli_prepare($KONN,$qu_users_updt);
			mysqli_stmt_execute($updateStatement);
			if( $user_id != 0 ){
				
				die("1|User Edited");
				
				
				
				
				
				} else {
				die('0|S-EER');
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
				
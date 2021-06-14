<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		if( isset($_POST['user_id']) &&
		isset($_POST['nw_pass']) ){
			
			
			
			$user_id     = 0;
			$user_id     = ( int ) test_inputs($_POST['user_id']);
			$nw_pass     = md5( test_inputs($_POST['nw_pass']) );
			
			
			$qu_users_updt = "UPDATE  `users` SET 
			`password` = '".$nw_pass."' 
			WHERE `user_id` = $user_id;";
			$updateStatement = mysqli_prepare($KONN,$qu_users_updt);
			mysqli_stmt_execute($updateStatement);
			
			if( $user_id != 0 ){
				
				die("1|User Edited");
				
				
				
				
				
			}
			else {
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

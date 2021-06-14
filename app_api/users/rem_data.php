<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		if( isset($_POST['user_id']) ){
			
			
			
			$user_id = 0;
			$user_id = ( int ) test_inputs($_POST['user_id']);
			
			$qu_users_del = "DELETE FROM `users` WHERE `user_id` = $user_id";
			$deleteStatement = mysqli_prepare($KONN,$qu_users_del);
			
			mysqli_stmt_execute($deleteStatement);
				die("1|User Deleted");
			
			
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

<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		if( isset($_POST['email']) &&
		isset($_POST['password']) &&
		isset($_POST['level']) &&
		isset($_POST['dept_code']) &&
		isset($_POST['status']) &&
		isset($_POST['employee_id']) 
		){
			
			
			
			$user_id = 0;
			$email = test_inputs($_POST['email']);
			$password = md5( test_inputs($_POST['password']) );
			$level = test_inputs($_POST['level']);
			$dept_code = test_inputs($_POST['dept_code']);
			$status = test_inputs($_POST['status']);
			$employee_id = test_inputs($_POST['employee_id']);
			
			$qu_users_ins = "INSERT INTO `users` (
			`email`, 
			`password`, 
			`level`, 
			`dept_code`, 
			`status`, 
			`employee_id` 
			) VALUES (
			'".$email."', 
			'".$password."', 
			'".$level."', 
			'".$dept_code."', 
			'".$status."', 
			'".$employee_id."' 
			);";
			$insertStatement = mysqli_prepare($KONN,$qu_users_ins);
			mysqli_stmt_execute($insertStatement);
			$user_id = mysqli_insert_id($KONN);
			if( $user_id != 0 ){
				
				die("1|User Added");
				
				
				
				
				
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

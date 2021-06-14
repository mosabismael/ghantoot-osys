<?php

session_start();

$USER_ID = 0;
$USER_NAME = "";
$EMAIL = "";
$LEVEL = "";



if( isset( $_SESSION['level'] ) && 
	isset( $_SESSION['email'] ) && 
	isset( $_SESSION['user_id'] ) && 
	isset( $_SESSION['user_name'] ) ){
		
	
	$LEVEL = ( int ) $_SESSION['level'];
	$EMAIL = $_SESSION['email'];
	$USER_ID = $_SESSION['user_id'];
	$USER_NAME = $_SESSION['user_name'];
	
	
	
	
	$qu_users_sel = "SELECT `level` FROM  `users` WHERE `user_id` = $USER_ID";
	$qu_users_EXE = mysqli_query($KONN, $qu_users_sel);
	$ths_lvl = 0;
	if(mysqli_num_rows($qu_users_EXE)){
		$users_DATA = mysqli_fetch_assoc($qu_users_EXE);
		$ths_lvl = ( int ) $users_DATA['level'];
	}

	
	
	
	
	if( $ths_lvl != 2 ){
		header("location:../index.php?w=300");
		die();
	}
	
	
} else {
	header("location:../index.php?w=200");
	die();
}


?>
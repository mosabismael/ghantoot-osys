<?php

session_start();

$USER_ID = 0;
$USER_NAME = "";
$EMAIL = "";
$LEVEL = "";

$EMPLOYEE_ID = "";
$PROFILE_PIC = "";
$DESIGNATION_ID = "";
$DEPARTMENT_ID = "";


if( isset( $_SESSION['level'] ) && 
	isset( $_SESSION['email'] ) && 
	isset( $_SESSION['user_id'] ) && 
	isset( $_SESSION['user_name'] ) ){
		
	$LEVEL = $_SESSION['level'];
	$DEPT_CODE = $_SESSION['dept_code'];
	$EMAIL = $_SESSION['email'];
	$USER_ID = ( int ) $_SESSION['user_id'];
	$USER_NAME = $_SESSION['user_name'];
	$EMPLOYEE_ID = $_SESSION['employee_id'];
	$PROFILE_PIC = $_SESSION['profile_pic'];
	$DESIGNATION_ID = $_SESSION['designation_id'];
	$DEPARTMENT_ID = $_SESSION['department_id'];
	
	$ths_lvl = 0;
	/*
	if( $USER_ID != 0 ){
		$qu_users_sel = "SELECT `level` FROM  `users` WHERE `user_id` = $USER_ID";
		$qu_users_EXE = mysqli_query($KONN, $qu_users_sel);
		$ths_lvl = 0;
		if(mysqli_num_rows($qu_users_EXE)){
			$users_DATA = mysqli_fetch_assoc($qu_users_EXE);
			$ths_lvl = $users_DATA['level'];
		} else {
			header("location:../index.php?w=350");
			die();
		}
	}
	if( $ths_lvl != $LEVEL ){
		header("location:../index.php?w=300");
		die();
	}
	
	*/
	
} else {
    //var_dump( $_SESSION );
   // die();
	header("location:../index.php?w=2899");
	die();
}


?>
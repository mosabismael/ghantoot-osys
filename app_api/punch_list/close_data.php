<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		if( isset($_POST['punch_id']) ){
			
			
			
			$punch_id     = 0;
			$punch_id     = test_inputs($_POST['punch_id']);
			$close_date = date('Y-m-d');
			$punch_status = 'close';
			
			
			$qu_punch_list_updt = "UPDATE  `punch_list` SET `punch_status` = '".$punch_status."', 
			`close_date` = '".$close_date."' 
			WHERE `punch_id` = $punch_id;";
			$updateStatement = mysqli_prepare($KONN,$qu_punch_list_updt);
			mysqli_stmt_execute($updateStatement);
			if( $punch_id != 0 ){
				die("1|Task Under Checking");
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

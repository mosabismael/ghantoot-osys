<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		if( isset($_POST['job_order_id']) ){
			
			
			$job_order_id = ( int ) test_inputs($_POST['job_order_id']);
			
			
			$qu_job_orders_updt = "UPDATE  `job_orders` SET `job_order_status` = 'deleted' WHERE `job_order_id` = $job_order_id;";
			
			$updateStatement = mysqli_prepare($KONN,$qu_job_orders_updt);
			mysqli_stmt_execute($updateStatement);
			die('1|Good');
				
				
			
			
			
			
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

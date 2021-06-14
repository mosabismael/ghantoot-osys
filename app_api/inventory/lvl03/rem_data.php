<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	try{
		
		if( isset($_POST['code_id']) ){
			
			$code_id = (int) test_inputs($_POST['code_id']);
			
			$qu_inv_03_divisions_updt = "DELETE FROM  `inv_03_divisions` WHERE `division_id` = $code_id;";
			$deleteStatement = mysqli_prepare($KONN,$qu_inv_03_divisions_updt);
			
			mysqli_stmt_execute($deleteStatement);
			
			if( $code_id != 0 ){
				die('1|Data Removed');
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

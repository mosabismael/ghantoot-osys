<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		
		if( isset($_POST['price_list_id']) ){
			
			
			$price_list_id = (int) test_inputs($_POST['price_list_id']);
			
			$qu_pur_requisitions_pls_del = "DELETE FROM `pur_requisitions_pls` WHERE `price_list_id` = $price_list_id";
			$deleteStatement = mysqli_prepare($KONN,$qu_pur_requisitions_pls_del);
			
			mysqli_stmt_execute($deleteStatement);
			
			
			$qu_pur_requisitions_pls_items_del = "DELETE FROM `pur_requisitions_pls_items` WHERE `price_list_id` = $price_list_id";
			$deleteStatement = mysqli_prepare($KONN,$qu_pur_requisitions_pls_items_del);
			
			mysqli_stmt_execute($deleteStatement);
			die('1|deleted');
			
			
			
			
			
			
			
			
			
			}  else {
			die('0|bad req 54545');
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
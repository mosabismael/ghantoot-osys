<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		if( isset($_POST['limited_text']) &&
		isset($_POST['limited_id']) ){
			
			
			
			$limited_id     = 0;
			$limited_text   = test_inputs($_POST['limited_text']);
			$limited_id     = test_inputs($_POST['limited_id']);
			
			
			
			$qu_purchase_orders_items_limited_list_updt = "UPDATE  `purchase_orders_items_limited_list` SET `limited_text` = '".$limited_text."' WHERE `limited_id` = $limited_id;";
			$updateStatement = mysqli_prepare($KONN,$qu_purchase_orders_items_limited_list_updt);
			mysqli_stmt_execute($updateStatement);
			if( $limited_id != 0 ){
				
				
				if( insert_state_change($KONN, "Data Edited", $limited_id, "purchase_orders_items_limited_list", $EMPLOYEE_ID) ) {
					die("1|Item Edited");
					} else {
					die('0|Data Status Error 65154');
				}
				
				
				
				
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

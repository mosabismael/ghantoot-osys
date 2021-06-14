<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		if( isset($_POST['limited_text'])){
			
			
			
			$limited_id = 0;
			$limited_text = test_inputs($_POST['limited_text']);
			
			
			$qu_purchase_orders_items_limited_list_sel = "SELECT * FROM  `purchase_orders_items_limited_list` WHERE `limited_text` = '$limited_text' ";
			$userStatement = mysqli_prepare($KONN,$qu_purchase_orders_items_limited_list_sel);
			mysqli_stmt_execute($userStatement);
			$qu_purchase_orders_items_limited_list_EXE = mysqli_stmt_get_result($userStatement);
			$purchase_orders_items_limited_list_DATA;
			if(mysqli_num_rows($qu_purchase_orders_items_limited_list_EXE)){
				die("0|Item Already Exist");
			}
			
			$qu_purchase_orders_items_limited_list_ins = "INSERT INTO `purchase_orders_items_limited_list` (
			`limited_text`
			) VALUES (
			'".$limited_text."'
			);";
			$insertStatement = mysqli_prepare($KONN,$qu_purchase_orders_items_limited_list_ins);
			
			mysqli_stmt_execute($insertStatement);
			
			$limited_id = mysqli_insert_id($KONN);
			if( $limited_id != 0 ){
				
				
				if( insert_state_change($KONN, "New-PO_lim_item", $limited_id, "purchase_orders_items_limited_list", $EMPLOYEE_ID) ) {
					die("1|Item Added");
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

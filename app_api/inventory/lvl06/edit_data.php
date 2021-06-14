<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	try{
		if( isset($_POST['code_id']) && 
		isset($_POST['code_unit_id']) && 
		isset($_POST['item_name']) 
		){
			
			
			
			$code_id = test_inputs($_POST['code_id']);
			$item_name = test_inputs($_POST['item_name']);
			$code_unit_id = test_inputs($_POST['code_unit_id']);
			$surface_area = test_inputs($_POST['item_sa']);
			$weight = test_inputs($_POST['item_weight']);
			
			
			
			$item_description = "";
			if( isset($_POST['item_description']) ){
				$item_description = test_inputs( $_POST['item_description'] );
			}
			
			$qu_inv_06_codes_updt = "UPDATE  `inv_06_codes` SET 
			`item_name` = '".$item_name."', 
			`surface_area` = '".$surface_area."', 
			`weight` = '".$weight."', 
			`code_unit_id` = '".$code_unit_id."', 
			`item_description` = '".$item_description."' 
			WHERE `code_id` = $code_id;";
			$updateStatement = mysqli_prepare($KONN,$qu_inv_06_codes_updt);
			mysqli_stmt_execute($updateStatement);
			
			if( $code_id != 0 ){
				
				if( insert_state_change($KONN, "INV-Itm-E-".$item_name, $code_id, "inv_06_codes", $EMPLOYEE_ID) ) {
					die('1|Data Updated');
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

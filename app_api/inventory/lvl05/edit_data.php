<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		
		if( isset($_POST['category_id']) && 
		isset($_POST['is_finished']) && 
		isset($_POST['unit_id']) && 
		isset($_POST['category_name']) 
		){
			
			
			
			$category_id = test_inputs($_POST['category_id']);
			$category_name = test_inputs($_POST['category_name']);
			
			$is_finished = (int) test_inputs($_POST['is_finished']);
			$unit_id = (int) test_inputs($_POST['unit_id']);
			
			
			
			
			$category_description = "";
			if( isset($_POST['category_description']) ){
				$category_description = test_inputs( $_POST['category_description'] );
			}
			
			$qu_inv_05_categories_updt = "UPDATE  `inv_05_categories` SET 
			`is_finished` = '".$is_finished."', 
			`unit_id` = '".$unit_id."', 
			`category_name` = '".$category_name."', 
			`category_description` = '".$category_description."' 
			WHERE `category_id` = $category_id;";
			$updateStatement = mysqli_prepare($KONN,$qu_inv_05_categories_updt);
			mysqli_stmt_execute($updateStatement);
			
			if( $category_id != 0 ){
				
				if( insert_state_change($KONN, "INV-Cat-E-".$category_name, $category_id, "inv_05_categories", $EMPLOYEE_ID) ) {
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

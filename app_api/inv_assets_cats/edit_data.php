<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		if( isset($_POST['asset_cat_id']) &&
		isset($_POST['asset_cat_name'])  
		){
			
			
			$asset_cat_id = test_inputs($_POST['asset_cat_id']);
			$asset_cat_name = test_inputs($_POST['asset_cat_name']);
			
			
			$qu_inv_assets_cats_updt = "UPDATE  `inv_assets_cats` SET 
			`asset_cat_name` = '".$asset_cat_name."'
			WHERE `asset_cat_id` = $asset_cat_id;";
			$updateStatement = mysqli_prepare($KONN,$qu_inv_assets_cats_updt);
			mysqli_stmt_execute($updateStatement);
			if( $asset_cat_id != 0 ){
				
				
				if( insert_state_change($KONN, "Data Edited", $asset_cat_id, "inv_assets_cats", $EMPLOYEE_ID) ) {
					die("1|Data Edited");
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

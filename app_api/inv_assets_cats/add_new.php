<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		if( isset($_POST['asset_cat_name']) ){
			
			
			$asset_cat_id = 0;
			$asset_cat_name = test_inputs($_POST['asset_cat_name']);
			
			$qu_inv_assets_cats_ins = "INSERT INTO `inv_assets_cats` (
			`asset_cat_name` 
			) VALUES (
			'".$asset_cat_name."'
			);";
			$insertStatement = mysqli_prepare($KONN,$qu_inv_assets_cats_ins);
			
			mysqli_stmt_execute($insertStatement);
			
			$qu_inv_assets_cats_ins = mysqli_insert_id($KONN);
			
			$asset_cat_id = mysqli_insert_id($KONN);
			if( $asset_cat_id != 0 ){
				
				if( insert_state_change($KONN, "new_asset_inserted", $asset_cat_id, "inv_assets_cats", $EMPLOYEE_ID) ) {
					die("1|Asset Added");
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

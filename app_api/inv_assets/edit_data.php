<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		if( isset($_POST['asset_id']) &&
		isset($_POST['asset_tag']) &&
		isset($_POST['asset_name']) &&
		isset($_POST['asset_sno']) &&
		isset($_POST['asset_brand']) &&
		isset($_POST['expiry_date']) &&
		isset($_POST['asset_po']) &&
		isset($_POST['asset_certificate']) &&
		isset($_POST['asset_status']) &&
		isset($_POST['asset_cat_id']) 
		){
			
			
			$asset_id = test_inputs($_POST['asset_id']);
			$asset_tag = test_inputs($_POST['asset_tag']);
			$asset_name = test_inputs($_POST['asset_name']);
			$asset_sno = test_inputs($_POST['asset_sno']);
			$asset_brand = test_inputs($_POST['asset_brand']);
			$expiry_date = test_inputs($_POST['expiry_date']);
			$asset_po = test_inputs($_POST['asset_po']);
			$asset_certificate = test_inputs($_POST['asset_certificate']);
			$asset_status = test_inputs($_POST['asset_status']);
			$asset_cat_id = test_inputs($_POST['asset_cat_id']);
			
			
			
			$qu_inv_assets_updt = "UPDATE  `inv_assets` SET 
			`asset_tag` = '".$asset_tag."', 
			`asset_name` = '".$asset_name."', 
			`asset_sno` = '".$asset_sno."', 
			`asset_brand` = '".$asset_brand."', 
			`expiry_date` = '".$expiry_date."', 
			`asset_po` = '".$asset_po."', 
			`asset_certificate` = '".$asset_certificate."', 
			`asset_status` = '".$asset_status."', 
			`asset_cat_id` = '".$asset_cat_id."'
			WHERE `asset_id` = $asset_id;";
			$updateStatement = mysqli_prepare($KONN,$qu_inv_assets_updt);
			mysqli_stmt_execute($updateStatement);
			if( $asset_id != 0 ){
				
				if( insert_state_change($KONN, "Data Edited", $asset_id, "inv_assets", $EMPLOYEE_ID) ) {
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

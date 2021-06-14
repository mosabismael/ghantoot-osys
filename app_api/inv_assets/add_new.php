<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		if( isset($_POST['asset_name']) &&
		isset($_POST['asset_sno']) &&
		isset($_POST['asset_brand']) &&
		isset($_POST['asset_po']) &&
		isset($_POST['asset_cat_id']) 
		){
			
			
			$asset_id = 0;
			$asset_tag = test_inputs($_POST['asset_name']);
			$asset_name = test_inputs($_POST['asset_name']);
			$asset_sno = test_inputs($_POST['asset_sno']);
			$asset_brand = test_inputs($_POST['asset_brand']);
			//$expiry_date = test_inputs($_POST['expiry_date']);
			$asset_po = test_inputs($_POST['asset_po']);
			//$asset_certificate = test_inputs($_POST['asset_certificate']);
			//$asset_status = test_inputs($_POST['asset_status']);
			$asset_cat_id = test_inputs($_POST['asset_cat_id']);
			
			$qu_inv_assets_ins = "INSERT INTO `inv_assets` (
			`asset_tag`, 
			`asset_name`, 
			`asset_sno`, 
			`asset_brand`, 
			`asset_po`, 
			`asset_cat_id` 
			) VALUES (
			'".$asset_tag."', 
			'".$asset_name."', 
			'".$asset_sno."', 
			'".$asset_brand."', 
			'".$asset_po."', 
			'".$asset_cat_id."' 
			);";
			$insertStatement = mysqli_prepare($KONN,$qu_inv_assets_ins);
			
			mysqli_stmt_execute($insertStatement);
			
			$asset_id = mysqli_insert_id($KONN);
			if( $asset_id != 0 ){
				
				die("1|Asset Added");
				
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

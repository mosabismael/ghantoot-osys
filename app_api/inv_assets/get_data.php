<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	
	try{
		
		
		if(!isset($_POST['ids_id'])){
			die('7wiu');
		}
		
		$asset_id = (int) test_inputs( $_POST['ids_id'] );
		$IAM_ARRAY;
		
		$q = "SELECT * FROM  `inv_assets` WHERE `asset_id` = $asset_id";
		$userStatement = mysqli_prepare($KONN,$q);
		mysqli_stmt_execute($userStatement);
		$q_exe = mysqli_stmt_get_result($userStatement);
		
		if(mysqli_num_rows($q_exe) == 0){
			
			$IAM_ARRAY[] = array(  "asset_id" => 0, 
			"asset_tag" => 0, 
			"asset_name" => 0, 
			"asset_sno" => 0, 
			"asset_brand" => 0, 
			"expiry_date" => 0, 
			"asset_po" => 0, 
			"asset_certificate" => 0, 
			"asset_status" => 0, 
			"asset_cat_id" => 0 
			);
			
			
			
			
			} else {
			$ARRAY_SRC = mysqli_fetch_assoc($q_exe);
			
			
			$IAM_ARRAY[] = array(  "asset_id" => $ARRAY_SRC['asset_id'], 
			"asset_tag" => $ARRAY_SRC['asset_tag'], 
			"asset_name" => $ARRAY_SRC['asset_name'], 
			"asset_sno" => $ARRAY_SRC['asset_sno'], 
			"asset_brand" => $ARRAY_SRC['asset_brand'], 
			"expiry_date" => $ARRAY_SRC['expiry_date'], 
			"asset_po" => $ARRAY_SRC['asset_po'], 
			"asset_certificate" => $ARRAY_SRC['asset_certificate'], 
			"asset_status" => $ARRAY_SRC['asset_status'], 
			"asset_cat_id" => $ARRAY_SRC['asset_cat_id'] 
			);
			
			
			
			
		}
		
		
		echo json_encode($IAM_ARRAY);
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

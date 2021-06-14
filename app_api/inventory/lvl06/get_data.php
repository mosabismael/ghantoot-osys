<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	
	
	try{
		
		if(!isset($_POST['ids_id'])){
			die('7wiu');
		}
		
		$code_id = (int) test_inputs( $_POST['ids_id'] );
		$IAM_ARRAY;
		
		$q = "SELECT * FROM  `inv_06_codes` WHERE `code_id` = $code_id";
		$userStatement = mysqli_prepare($KONN,$q);
		mysqli_stmt_execute($userStatement);
		$q_exe = mysqli_stmt_get_result($userStatement);
		
		if(mysqli_num_rows($q_exe) == 0){
			$IAM_ARRAY[] = array(  "code_id" => 0, 
			"code_tag" => 0, 
			"item_name" => 0, 
			"code_unit_id" => 0, 
			"item_description" => 0, 
			"category_id" => 0 ,
			"weight" => 0,
			"surface_area" => 0
			);
			
			
			
			} else {
			$ARRAY_SRC = mysqli_fetch_assoc($q_exe);
			
			
			$IAM_ARRAY[] = array(  "code_id" => $ARRAY_SRC['code_id'], 
			"code_tag" => $ARRAY_SRC['code_tag'], 
			"item_name" => $ARRAY_SRC['item_name'], 
			"surface_area" => $ARRAY_SRC['surface_area'], 
			"weight" => $ARRAY_SRC['weight'], 
			"code_unit_id" => $ARRAY_SRC['code_unit_id'], 
			"item_description" => $ARRAY_SRC['item_description'], 
			"category_id" => $ARRAY_SRC['category_id'] 
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

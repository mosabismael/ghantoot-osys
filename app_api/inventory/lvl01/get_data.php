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
		
		$family_id = (int) test_inputs( $_POST['ids_id'] );
		$return_arr;
		
		$q = "SELECT * FROM  `inv_01_families` WHERE `family_id` = '$family_id' ";
		$userStatement = mysqli_prepare($KONN,$q);
		mysqli_stmt_execute($userStatement);
		$q_exe = mysqli_stmt_get_result($userStatement);
		
		if(mysqli_num_rows($q_exe) == 0){
			$return_arr[] = array(  "family_id" => 0, 
			"family_code" => 0, 
			"family_name" => 0, 
			"family_icon" => 0, 
			"family_description" => 0 
			);
			
			} else {
			$ARRAY_SRC = mysqli_fetch_assoc($q_exe);
			
			
			$return_arr[] = array(  "family_id" => $ARRAY_SRC['family_id'], 
			"family_code" => $ARRAY_SRC['family_code'], 
			"family_name" => $ARRAY_SRC['family_name'], 
			"family_icon" => $ARRAY_SRC['family_icon'], 
			"family_description" => $ARRAY_SRC['family_description'] 
			);
			
			
			
		}
		
		
		echo json_encode($return_arr);
		
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

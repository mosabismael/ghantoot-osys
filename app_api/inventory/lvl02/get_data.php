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
		
		$section_id = (int) test_inputs( $_POST['ids_id'] );
		$IAM_ARRAY;
		
		$q = "SELECT * FROM  `inv_02_sections` WHERE `section_id` = '$section_id' ";
		$userStatement = mysqli_prepare($KONN,$q);
		mysqli_stmt_execute($userStatement);
		$q_exe = mysqli_stmt_get_result($userStatement);
		
		if(mysqli_num_rows($q_exe) == 0){
			$IAM_ARRAY[] = array(  "section_id" => 0, 
			"section_code" => 0, 
			"section_name" => 0, 
			"section_description" => 0, 
			"family_id" => 0 
			);
			
			
			} else {
			$ARRAY_SRC = mysqli_fetch_assoc($q_exe);
			
			
			$IAM_ARRAY[] = array(  "section_id" => $ARRAY_SRC['section_id'], 
			"section_code" => $ARRAY_SRC['section_code'], 
			"section_name" => $ARRAY_SRC['section_name'], 
			"section_description" => $ARRAY_SRC['section_description'], 
			"is_finished" => $ARRAY_SRC['is_finished'], 
			"unit_id" => $ARRAY_SRC['unit_id'], 
			"family_id" => $ARRAY_SRC['family_id'] 
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

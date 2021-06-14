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
		
		$division_id = (int) test_inputs( $_POST['ids_id'] );
		$IAM_ARRAY;
		
		$q = "SELECT * FROM  `inv_03_divisions` WHERE `division_id` = $division_id";
		$userStatement = mysqli_prepare($KONN,$q);
		mysqli_stmt_execute($userStatement);
		$q_exe = mysqli_stmt_get_result($userStatement);
		
		if(mysqli_num_rows($q_exe) == 0){
			$IAM_ARRAY[] = array(  "division_id" => 0, 
			"division_code" => 0, 
			"division_name" => 0, 
			"division_description" => 0, 
			"section_id" => 0 
			);
			
			
			
			} else {
			$ARRAY_SRC = mysqli_fetch_assoc($q_exe);
			
			
			$IAM_ARRAY[] = array(  "division_id" => $ARRAY_SRC['division_id'], 
			"division_code" => $ARRAY_SRC['division_code'], 
			"division_name" => $ARRAY_SRC['division_name'], 
			"division_description" => $ARRAY_SRC['division_description'], 
			"is_finished" => $ARRAY_SRC['is_finished'], 
			"unit_id" => $ARRAY_SRC['unit_id'], 
			"section_id" => $ARRAY_SRC['section_id'] 
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

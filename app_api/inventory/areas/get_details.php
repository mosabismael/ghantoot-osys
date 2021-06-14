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
		
		$area_id = (int) $_POST['ids_id'];
		
		$IAM_ARRAY;
		
		$q = "SELECT * FROM `wh_areas` WHERE `area_id` = '".$area_id."'";
		$userStatement = mysqli_prepare($KONN,$q);
		mysqli_stmt_execute($userStatement);
		$q_exe = mysqli_stmt_get_result($userStatement);
		
		
		
		if(mysqli_num_rows($q_exe) == 0){
			$IAM_ARRAY[] = array(  "area_id" => 0, 
			"area_name" => 0
			);
			
			} else {
			$ARRAY_SRC = mysqli_fetch_assoc($q_exe);
			
			
			
			
			$IAM_ARRAY[] = array(  "area_id" => $ARRAY_SRC['area_id'], 
			"area_name" => $ARRAY_SRC['area_name']
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

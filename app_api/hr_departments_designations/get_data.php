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
		
		$designation_id = (int) test_inputs( $_POST['ids_id'] );
		$IAM_ARRAY;
		
		$q = "SELECT * FROM  `hr_departments_designations` WHERE `designation_id` = $designation_id";
		$userStatement = mysqli_prepare($KONN,$q);
		mysqli_stmt_execute($userStatement);
		$q_exe = mysqli_stmt_get_result($userStatement);
		
		if(mysqli_num_rows($q_exe) == 0){
			
			$IAM_ARRAY[] = array(  "designation_id" => 0, 
			"designation_name" => 0, 
			"designation_name_ar" => 0, 
			"job_description" => 0, 
			"department_id" => 0 
			);
			
			
			
			} else {
			$ARRAY_SRC = mysqli_fetch_assoc($q_exe);
			
			$IAM_ARRAY[] = array(  "designation_id" => $ARRAY_SRC['designation_id'], 
			"designation_name" => $ARRAY_SRC['designation_name'], 
			"designation_name_ar" => $ARRAY_SRC['designation_name_ar'], 
			"job_description" => $ARRAY_SRC['job_description'], 
			"department_id" => $ARRAY_SRC['department_id'] 
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

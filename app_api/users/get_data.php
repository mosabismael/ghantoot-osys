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
		
		$user_id = (int) test_inputs( $_POST['ids_id'] );
		$IAM_ARRAY;
		
		$q = "SELECT * FROM  `users` WHERE `user_id` = $user_id";
		$userStatement = mysqli_prepare($KONN,$q);
		mysqli_stmt_execute($userStatement);
		$result = mysqli_stmt_get_result($userStatement);
		if($result->num_rows == 0){
			
			$IAM_ARRAY[] = array(  "user_id" => 0, 
			"email" => 0, 
			"level" => 0, 
			"dept_code" => 0, 
			"status" => 0, 
			"employee_id" => 0 
			);
			
			
		
		} else {
		$ARRAY_SRC = $result->fetch_assoc();
		
		
		$IAM_ARRAY[] = array(  "user_id" => $ARRAY_SRC['user_id'], 
		"email" => $ARRAY_SRC['email'], 
		"level" => $ARRAY_SRC['level'], 
		"dept_code" => $ARRAY_SRC['dept_code'], 
		"statuser" => $ARRAY_SRC['status'], 
		"employee_id" => $ARRAY_SRC['employee_id'] 
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

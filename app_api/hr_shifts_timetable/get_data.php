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
		
		$shift_id = (int) test_inputs( $_POST['ids_id'] );
		$IAM_ARRAY;
		
		$q = "SELECT * FROM  `hr_shifts_timetable` WHERE `shift_id` = $shift_id";
		$userStatement = mysqli_prepare($KONN,$q);
		mysqli_stmt_execute($userStatement);
		$q_exe = mysqli_stmt_get_result($userStatement);
		
		if(mysqli_num_rows($q_exe) == 0){
			
			$IAM_ARRAY[] = array(  "shift_id" => 0, 
			"hr_from" => 0, 
			"hr_to" => 0, 
			"day_shift" => 0, 
			"typo" => 0 
			);
			
			
			
			} else {
			$ARRAY_SRC = mysqli_fetch_assoc($q_exe);
			
			
			$IAM_ARRAY[] = array(  "shift_id" => $ARRAY_SRC['shift_id'], 
			"hr_from" => $ARRAY_SRC['hr_from'], 
			"hr_to" => $ARRAY_SRC['hr_to'], 
			"day_shift" => $ARRAY_SRC['day_shift'], 
			"typo" => $ARRAY_SRC['typo'] 
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

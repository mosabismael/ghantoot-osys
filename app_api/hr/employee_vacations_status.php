<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	try{
		if( isset($_POST['record']) ){
			
			$vacation_id = (int) test_inputs($_POST['record']);
			$qu_hr_employees_vacations_del = "DELETE FROM `hr_employees_vacations` WHERE `vacation_id` = $vacation_id";
			$deleteStatement = mysqli_prepare($KONN,$qu_hr_employees_vacations_del);
			
			mysqli_stmt_execute($deleteStatement);
			
			if( insert_state_change($KONN, 'Vacation_Deleted', $vacation_id, "hr_employees_vacations", $EMPLOYEE_ID) ){
				die("1|Data Deleted");
			}
			
			
			
			
			} else {
			die('0|7wiu');
		}
		
		// echo json_encode($IAM_ARRAY);
		die();
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

<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		if( isset($_POST['hr_from']) &&
		isset($_POST['hr_to']) &&
		isset($_POST['day_shift']) &&
		isset($_POST['typo']) 
		){
			
			$shift_id = 0;
			$hr_from = test_inputs($_POST['hr_from']);
			$hr_to = test_inputs($_POST['hr_to']);
			$day_shift = test_inputs($_POST['day_shift']);
			$typo = test_inputs($_POST['typo']);
			
			$qu_hr_shifts_timetable_ins = "INSERT INTO `hr_shifts_timetable` (
			`hr_from`, 
			`hr_to`, 
			`day_shift`, 
			`typo` 
			) VALUES (
			'".$hr_from."', 
			'".$hr_to."', 
			'".$day_shift."', 
			'".$typo."' 
			);";
			$insertStatement = mysqli_prepare($KONN,$qu_hr_shifts_timetable_ins);
			
			mysqli_stmt_execute($insertStatement);
			
			$shift_id = mysqli_insert_id($KONN);
			if( $shift_id != 0 ){
				
				
				if( insert_state_change($KONN, 'add-new', $shift_id, "hr_shifts_timetable", $EMPLOYEE_ID) ) {
					die("1|Shift Added");
					} else {
					die('0|Data Status Error 65154');
				}
				
			}
			
			
			
			
			
			} else {
			die('0|7wiu');
		}
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

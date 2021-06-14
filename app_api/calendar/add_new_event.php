<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		if( isset($_POST['event_date']) &&
		isset($_POST['event_time']) &&
		isset($_POST['event_title']) &&
		isset($_POST['notes'])  
		){
			
			$event_id = 0;
			$eventDate = test_inputs($_POST['event_date']);
			$event_time = test_inputs($_POST['event_time']);
			
			$event_date = $eventDate.' '.$event_time.':00';
			
			$event_title = test_inputs($_POST['event_title']);
			$notes = test_inputs($_POST['notes']);
			$employee_id = $EMPLOYEE_ID;
			
			
			$added_date = date('Y-m-d H:i:00');
			
			$qu_events_ins = "INSERT INTO `gen_events` (
			`event_date`, 
			`event_title`, 
			`notes`, 
			`employee_id`, 
			`added_date` 
			) VALUES (
			'".$event_date."', 
			'".$event_title."', 
			'".$notes."', 
			'".$employee_id."', 
			'".$added_date."' 
			);";
			$insertStatement = mysqli_prepare($KONN,$qu_events_ins);
			
			mysqli_stmt_execute($insertStatement);
			
			$event_id = mysqli_insert_id($KONN);
			if( $event_id != 0 ){
				die("1|Event Inserted");
			}
			
			
			} else {
			die("0|65485456");
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

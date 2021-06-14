<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{	
		if( isset($_POST['punch_txt']) && isset($_POST['punch_txt']) ){
			
			
			
			$punch_id = 0;
			$punch_txt = test_inputs($_POST['punch_txt']);
			$open_date = test_inputs($_POST['open_date']);
			// $open_date = date('Y-m-d');
			$punch_status = 'open';
			
			
			
			$qu_punch_list_ins = "INSERT INTO `punch_list` (
			`punch_status`, 
			`punch_txt`, 
			`open_date`
			) VALUES (
			'".$punch_status."', 
			'".$punch_txt."', 
			'".$open_date."'
			);";
			$insertStatement = mysqli_prepare($KONN,$qu_punch_list_ins);
			
			mysqli_stmt_execute($insertStatement);
			
			$punch_id = mysqli_insert_id($KONN);
			if( $punch_id != 0 ){
				
				die("1|Item Added");
				
				
			}
			} else {
			die('0|S-EER');
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

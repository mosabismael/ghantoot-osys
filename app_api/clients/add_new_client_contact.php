<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	try{
		if( isset($_POST['contact_name']) &&
		isset($_POST['contact_phone']) &&
		isset($_POST['contact_email']) &&
		isset($_POST['contact_position']) &&
		isset($_POST['client_id']) 
		){
			
			$contact_id = 0;
			$contact_name = test_inputs($_POST['contact_name']);
			$contact_phone = test_inputs($_POST['contact_phone']);
			$contact_email = test_inputs($_POST['contact_email']);
			$contact_position = test_inputs($_POST['contact_position']);
			$client_id = test_inputs($_POST['client_id']);
			
			$qu_gen_clients_contacts_ins = "INSERT INTO `gen_clients_contacts` (
			`contact_name`, 
			`contact_phone`, 
			`contact_email`, 
			`contact_position`, 
			`client_id` 
			) VALUES (
			'".$contact_name."', 
			'".$contact_phone."', 
			'".$contact_email."', 
			'".$contact_position."', 
			'".$client_id."' 
			);";
			$insertStatement = mysqli_prepare($KONN,$qu_gen_clients_contacts_ins);
			
			mysqli_stmt_execute($insertStatement);
			
			$contact_id = mysqli_insert_id($KONN);
			if( $contact_id != 0 ){
				
				$current_state_id = get_current_state_id($KONN, $client_id, 'gen_clients' );
				if( $current_state_id != 0 ){
					
					if( insert_state_change_dep($KONN, "New_Contact", $contact_id, $contact_name, 'gen_clients_contacts', $EMPLOYEE_ID, $current_state_id) ){
						die('1|Contact Added');
						} else {
						die('0|Component State Error 01');
					}
					
					} else {
					die('0|Component State Error 02');
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

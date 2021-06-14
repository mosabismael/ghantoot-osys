<?php
	
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	try{
		
		if(!isset($_POST['contact_id'])){
			die('0|Bad_Req');
		}
		
		$contact_id = $_POST['contact_id'];
		
		$qu_gen_clients_contacts_sel = "SELECT * FROM  `gen_clients_contacts` WHERE `contact_id` = $contact_id";
		$userStatement = mysqli_prepare($KONN,$qu_gen_clients_contacts_sel);
		mysqli_stmt_execute($userStatement);
		$qu_gen_clients_contacts_EXE = mysqli_stmt_get_result($userStatement);
		$gen_clients_contacts_DATA;
		if(mysqli_num_rows($qu_gen_clients_contacts_EXE)){
			$gen_clients_contacts_DATA = mysqli_fetch_assoc($qu_gen_clients_contacts_EXE);
		}
		$contact_name = $gen_clients_contacts_DATA['contact_name'];
		$client_id = $gen_clients_contacts_DATA['client_id'];
		
		
		
		
		$q = "DELETE FROM `gen_clients_contacts` WHERE `contact_id` = '".$contact_id."' ";
		$deleteStatement = mysqli_prepare($KONN,$q);
		
		mysqli_stmt_execute($deleteStatement);
		
		
		
		$current_state_id = get_current_state_id($KONN, $client_id, 'gen_clients' );
		if( $current_state_id != 0 ){
			
			if( insert_state_change_dep($KONN, "Deleted_Contact", $contact_id, $contact_name, 'gen_clients_contacts', $EMPLOYEE_ID, $current_state_id) ){
				die('1|good');
				} else {
				die('0|Component State Error 01');
			}
			
			
			
			
			
			
			
			
			} else {
			die('0|BAD');
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

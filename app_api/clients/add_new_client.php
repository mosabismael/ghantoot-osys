<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		
		if( isset($_POST['client_code']) &&
		isset($_POST['client_name']) &&
		isset($_POST['client_category']) &&
		isset($_POST['website']) &&
		isset($_POST['phone']) &&
		isset($_POST['email']) &&
		isset($_POST['city']) &&
		isset($_POST['country']) && 
		isset($_POST['trn_no']) 
		){
			
			
			$client_id = 0;
			$client_code = test_inputs($_POST['client_code']);
			$client_name = test_inputs($_POST['client_name']);
			$client_category = test_inputs($_POST['client_category']);
			$website = test_inputs($_POST['website']);
			$phone = test_inputs($_POST['phone']);
			$email = test_inputs($_POST['email']);
			$city = test_inputs($_POST['city']);
			$country = test_inputs($_POST['country']);
			
			$trn_no = test_inputs($_POST['trn_no']);
			$is_deleted = "0";
			
			
			$address = "";
			if( isset($_POST['address']) ){
				$address = test_inputs( $_POST['address'] );
			}
			
			$qu_gen_clients_ins = "INSERT INTO `gen_clients` (
			`client_code`, 
			`client_name`, 
			`client_category`, 
			`website`, 
			`phone`, 
			`email`, 
			`city`, 
			`country`, 
			`address`, 
			`trn_no`, 
			`is_deleted` 
			) VALUES (
			'".$client_code."', 
			'".$client_name."', 
			'".$client_category."', 
			'".$website."', 
			'".$phone."', 
			'".$email."', 
			'".$city."', 
			'".$country."', 
			'".$address."', 
			'".$trn_no."', 
			'".$is_deleted."' 
			);";
			$insertStatement = mysqli_prepare($KONN,$qu_gen_clients_ins);
			
			mysqli_stmt_execute($insertStatement);
			
			$client_id = mysqli_insert_id($KONN);
			if( $client_id != 0 ){
				
				if( insert_state_change($KONN, 'Client_added', $client_id, "gen_clients", $EMPLOYEE_ID) ){
					die('1|gen_clients.php?added=1');
					} else {
					die('0| State Error 035532');
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

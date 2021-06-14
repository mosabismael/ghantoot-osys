<?php
	
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	try{
		
		
		
		
		if(!isset($_POST['client_id'])){
			die('7wiu');
		}
		
		$client_id = $_POST['client_id'];
		$return_arr;
		
		$q = "SELECT * FROM `gen_clients` WHERE `client_id` = '".$client_id."' ";
		$userStatement = mysqli_prepare($KONN,$q);
		mysqli_stmt_execute($userStatement);
		$q_exe = mysqli_stmt_get_result($userStatement);
		
		
		
		
		if(mysqli_num_rows($q_exe) == 0){
			$return_arr[] = array(  "client_id" => 0, 
			"client_code" => 0, 
			"client_name" => 0, 
			"client_category" => 0, 
			"website" => 0, 
			"phone" => 0, 
			"email" => 0, 
			"city" => 0, 
			"country" => 0, 
			"address" => 0, 
			"trn_no" => 0, 
			"is_deleted" => 0 
			);
			} else {
			$client_DATA = mysqli_fetch_assoc($q_exe);
			
			
			$return_arr[] = array(  "client_id" => $client_DATA['client_id'], 
			"client_code" => $client_DATA['client_code'], 
			"client_name" => $client_DATA['client_name'], 
			"client_category" => $client_DATA['client_category'], 
			"website" => $client_DATA['website'], 
			"phone" => $client_DATA['phone'], 
			"email" => $client_DATA['email'], 
			"city" => $client_DATA['city'], 
			"country" => $client_DATA['country'], 
			"address" => $client_DATA['address'], 
			"trn_no" => $client_DATA['trn_no'], 
			"is_deleted" => $client_DATA['is_deleted'] 
			);
			
			
		}
		
		
		echo json_encode($return_arr);
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

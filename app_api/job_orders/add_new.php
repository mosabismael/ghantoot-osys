<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		if( isset($_POST['job_order_ref']) && 
		isset($_POST['project_manager_id']) && 
		isset($_POST['project_name']) && 
		isset($_POST['job_order_type']) && 
		isset($_POST['project_amount']) && 
		isset($_POST['client_id']) && 
		isset($_POST['job_order_status']) 
		){
			
			
			$job_order_id = 0;
			$project_manager_id = test_inputs($_POST['project_manager_id']);
			$job_order_ref = test_inputs($_POST['job_order_ref']);
			$project_name = test_inputs($_POST['project_name']);
			$client_id = ( int ) test_inputs($_POST['client_id']);
			$job_order_type = test_inputs($_POST['job_order_type']);
			$project_amount = ( double ) test_inputs($_POST['project_amount']);
			$job_order_status = test_inputs($_POST['job_order_status']);
			$created_date = date('Y-m-d H:i:00');
			$created_by = $EMPLOYEE_ID;
			
			
			
			$qu_job_orders_sel = "SELECT * FROM  `job_orders` WHERE ((`project_name` = '$project_name') AND ( `job_order_ref` = '$job_order_ref' ) )";
			$userStatement = mysqli_prepare($KONN,$qu_job_orders_sel);
			mysqli_stmt_execute($userStatement);
			$qu_job_orders_EXE = mysqli_stmt_get_result($userStatement);
			if(mysqli_num_rows($qu_job_orders_EXE)){
				die('0|Project Name Already Exist');
			}
			
			
			$qu_job_orders_sel = "SELECT * FROM  `job_orders` WHERE `job_order_ref` = '$job_order_ref'";
			$userStatement = mysqli_prepare($KONN,$qu_job_orders_sel);
			mysqli_stmt_execute($userStatement);
			$qu_job_orders_EXE = mysqli_stmt_get_result($userStatement);
			if(mysqli_num_rows($qu_job_orders_EXE)){
				die('0|Job Ref Already Exist');
			}
			
			
			
			//contract_attach
			
			$contract_attach = 'na';
			
			if(isset($_FILES['contract_attach']) && $_FILES['contract_attach']["tmp_name"]){
				//upload side image
				$upload_res = upload_picture('contract_attach', 9000, 'uploads', '../../');
				if($upload_res == true){
					$contract_attach = $upload_res;
					} else {
					die('s4443='.$upload_res);
				}
			}
			
			
			
			
			$qu_job_orders_ins = "INSERT INTO `job_orders` (
			`job_order_ref`, 
			`project_name`, 
			`client_id`, 
			`project_amount`, 
			`contract_attach`, 
			`job_order_type`, 
			`project_manager_id`, 
			`job_order_status`, 
			`created_date`, 
			`created_by` 
			) VALUES (
			'".$job_order_ref."', 
			'".$project_name."', 
			'".$client_id."', 
			'".$project_amount."', 
			'".$contract_attach."', 
			'".$job_order_type."', 
			'".$project_manager_id."', 
			'".$job_order_status."', 
			'".$created_date."', 
			'".$created_by."' 
			);";
			
			$insertStatement = mysqli_prepare($KONN,$qu_job_orders_ins);
			
			mysqli_stmt_execute($insertStatement);
			
			$job_order_id = mysqli_insert_id($KONN);
			
			if( insert_state_change($KONN, $job_order_status, $job_order_id, "job_orders", $EMPLOYEE_ID) ) {
				die("1|Job Order Added");
				} else {
				die('0|Data Status Error 65154');
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

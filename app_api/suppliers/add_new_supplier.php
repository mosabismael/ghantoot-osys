<?php
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		if( isset($_POST['supplier_code']) &&
		isset($_POST['supplier_name']) &&
		isset($_POST['supplier_type']) &&
		isset($_POST['supplier_cat']) &&
		isset($_POST['supplier_email']) &&
		isset($_POST['website']) &&
		isset($_POST['country']) &&
		isset($_POST['address']) &&
		isset($_POST['contact_person']) &&
		isset($_POST['supplier_phone']) &&
		isset($_POST['trn_no']) 
		){
			
			$supplier_id = 0;
			
			$supplier_code = test_inputs($_POST['supplier_code']);
			$supplier_name = test_inputs($_POST['supplier_name']);
			$supplier_type = test_inputs($_POST['supplier_type']);
			$supplier_cat = test_inputs($_POST['supplier_cat']);
			$supplier_email = test_inputs($_POST['supplier_email']);
			$website = test_inputs($_POST['website']);
			$country = test_inputs($_POST['country']);
			$address = test_inputs($_POST['address']);
			$contact_person = test_inputs($_POST['contact_person']);
			$supplier_phone = test_inputs($_POST['supplier_phone']);
			$trn_no = test_inputs($_POST['trn_no']);
			
			
			$qu_suppliers_list_ins = "INSERT INTO `suppliers_list` (
			`supplier_code`, 
			`supplier_name`, 
			`supplier_type`, 
			`supplier_cat`, 
			`supplier_email`, 
			`website`, 
			`country`, 
			`address`, 
			`contact_person`, 
			`supplier_phone`, 
			`trn_no` 
			) VALUES (
			'".$supplier_code."', 
			'".$supplier_name."', 
			'".$supplier_type."', 
			'".$supplier_cat."', 
			'".$supplier_email."', 
			'".$website."', 
			'".$country."', 
			'".$address."', 
			'".$contact_person."', 
			'".$supplier_phone."', 
			'".$trn_no."' 
			);";
			$insertStatement = mysqli_prepare($KONN,$qu_suppliers_list_ins);
			
			mysqli_stmt_execute($insertStatement);
			
			die('1|suppliers.php?added=1');
			
			
			
			
			
			} else {
			die('0|ERR_REQ_4568674653');
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

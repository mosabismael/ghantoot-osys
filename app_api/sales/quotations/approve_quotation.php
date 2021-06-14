<?php
	
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	try{
		
		if(!isset($_POST['quotation_id'])){
			die('0|ERR_REQ_4568674653');
		}
		
		$quotation_id = $_POST['quotation_id'];
		
		
		$quotation_status = 'approved';
		
		$qu_sales_quotations_updt = "UPDATE  `sales_quotations` SET 
		`quotation_status` = '".$quotation_status."'
		WHERE `quotation_id` = $quotation_id;";
		$updateStatement = mysqli_prepare($KONN,$qu_sales_quotations_updt);
		mysqli_stmt_execute($updateStatement);
		if( insert_state_change($KONN, $quotation_status, $quotation_id, "sales_quotations", $EMPLOYEE_ID) ){
			
			
			
			
			
			$quotation_status = 'published';
			
			$qu_sales_quotations_updt = "UPDATE  `sales_quotations` SET 
			`quotation_status` = '".$quotation_status."'
			WHERE `quotation_id` = $quotation_id;";
			$updateStatement = mysqli_prepare($KONN,$qu_sales_quotations_updt);
			mysqli_stmt_execute($updateStatement);
			die('1|Good');
			
			
			
			
			
			} else {
			die('0|Component State Error 01');
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

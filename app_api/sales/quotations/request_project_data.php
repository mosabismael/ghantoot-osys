<?php
	
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	try{
		
		if( isset($_POST['quotation_id']) && isset($_POST['token_id'])  ){
			
			
			
			
			
			$quotation_id = ( int ) test_inputs( $_POST['quotation_id'] );
			$token_id     = ( int ) test_inputs( $_POST['token_id'] );
			
			
			$quotation_status = 'pending_project_prepare';
			
			$qu_sales_quotations_updt = "UPDATE  `sales_quotations` SET 
			`quotation_status` = '".$quotation_status."'
			WHERE `quotation_id` = $quotation_id;";
			$updateStatement = mysqli_prepare($KONN,$qu_sales_quotations_updt);
			mysqli_stmt_execute($updateStatement);
			
			if( insert_state_change($KONN, $quotation_status, $quotation_id, "sales_quotations", $EMPLOYEE_ID) ){
				
				
				
				
				
				
				$token_status = 'pending_project_prepare';
				
				$qu_tkn_data_updt = "UPDATE  `tkn_data` SET 
				`token_status` = '".$token_status."'
				WHERE `token_id` = $token_id;";
				$updateStatement = mysqli_prepare($KONN,$qu_tkn_data_updt);
				mysqli_stmt_execute($updateStatement);
				
				die('1|Good');
				
				
				
				
				
				
				
				
				
			}
			
			
			
			
			
			
			
		
		
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

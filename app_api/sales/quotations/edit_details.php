<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	
	try{
		
		if( isset($_POST['quotation_id']) &&
		isset($_POST['rfq_no']) &&
		isset($_POST['quotation_date']) &&
		isset($_POST['payment_term_id']) &&
		isset($_POST['currency_id']) &&
		isset($_POST['delivery_period_id']) &&
		isset($_POST['delivery_method']) && 
		isset($_POST['valid_until']) && 
		isset($_POST['pak_tr_amount']) && 
		isset($_POST['coo_amount'])
		){
			
			$quotation_id = 0;
			
			$quotation_id = (int) test_inputs($_POST['quotation_id']);
			$rfq_no = test_inputs($_POST['rfq_no']);
			$quotation_date = test_inputs($_POST['quotation_date']);
			$payment_term_id = test_inputs($_POST['payment_term_id']);
			$currency_id = test_inputs($_POST['currency_id']);
			$delivery_period_id = test_inputs($_POST['delivery_period_id']);
			$delivery_method = test_inputs($_POST['delivery_method']);
			
			$valid_until = test_inputs($_POST['valid_until']);
			$valid_date;
			
			$pak_tr_amount = test_inputs($_POST['pak_tr_amount']);
			$coo_amount = test_inputs($_POST['coo_amount']);
			
			$employee_id = $EMPLOYEE_ID;
			
			$quotation_notes = "";
			if( isset($_POST['quotation_notes']) ){
				$quotation_notes = test_inputs( $_POST['quotation_notes'] );
			}
			
			//CALC DATES
			
			$valid_date   = date('Y-m-d', strtotime($quotation_date. ' + '.$valid_until.' days'));
			
			
			
			
			
			// die("0|am here CCC--".$quotation_ref."---".$valid_date);
			
			$qu_sales_quotations_updt = "UPDATE  `sales_quotations` SET 
			`rfq_no` = '".$rfq_no."', 
			`quotation_date` = '".$quotation_date."', 
			`payment_term_id` = '".$payment_term_id."', 
			`currency_id` = '".$currency_id."', 
			`delivery_period_id` = '".$delivery_period_id."', 
			`delivery_method` = '".$delivery_method."', 
			`quotation_notes` = '".$quotation_notes."', 
			`valid_until` = '".$valid_until."', 
			`valid_date` = '".$valid_date."', 
			`pak_tr_amount` = '".$pak_tr_amount."', 
			`coo_amount` = '".$coo_amount."' 
			WHERE `quotation_id` = $quotation_id;";
			$updateStatement = mysqli_prepare($KONN,$qu_sales_quotations_updt);
			mysqli_stmt_execute($updateStatement);
			if( $quotation_id != 0 ){
				
				die("1|Sales Quotation Updated");
				
				
				
				
				
			}
			else {
				die('0|wrong request');
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

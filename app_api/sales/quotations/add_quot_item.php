<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	
	try{
		
		if( isset($_POST['rfq_id'])){
			
			$rfq_no = test_inputs($_POST['rfq_id']);
			$item_name = test_inputs($_POST['item_name']);
			$item_price = test_inputs($_POST['item_price']);
			$item_qty = test_inputs($_POST['item_qty']);
			$item_unit = test_inputs($_POST['item_unit']);
			
			
			$qu_sales_quotations_ins = "INSERT INTO `sales_quotations_items` (
			`q_item_name`, 
			`q_item_price`, 
			`q_item_qty`, 
			`unit_id`, 
			`quotation_id`
			) VALUES (
			'".$item_name."', 
			'".$item_price."', 
			'".$item_qty."', 
			'".$item_unit."', 
			'".$rfq_no."'
			);";
			$insertStatement = mysqli_prepare($KONN,$qu_sales_quotations_ins);
			
			mysqli_stmt_execute($insertStatement);
			
			
			$quotation_id = mysqli_insert_id($KONN);
			if( $quotation_id != 0 ){
				
				if( insert_state_change($KONN, $rfq_no, $quotation_id, "sales_quotations_items", $EMPLOYEE_ID) ) {
					$curentState = get_current_state_id($KONN, $quotation_id, "sales_quotations_items" );
					
					
					
					
					
					
					
					
					} else {
					die('0|Data Status Error 65154');
				}
				
				
				
				
				
				} else {
				die('0|S-EER'.mysqli_error($KONN));
			}
			
			
			
			
			} else {
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

<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	try{
		if( isset($_POST['po_id']) && 
		isset($_POST['currency_id']) && 
		isset($_POST['delivery_period_id']) && 
		isset($_POST['payment_term_id']) && 
		isset($_POST['is_vat_included']) && 
		isset($_POST['po_item_ids']) && 
		isset($_POST['item_qtys']) && 
		isset($_POST['item_prices']) && 
		isset($_POST['term_ids'])
		){
			
			
			
			$po_id = 0;
			$rev_no = 0;
			$notes = "";
			
			$po_id                    = (int) test_inputs($_POST['po_id']);
			
			$currency_id              = (int) test_inputs($_POST['currency_id']);
			
			
			$is_vat_included          = (int) test_inputs($_POST['is_vat_included']);
			
			$delivery_period_id       = (int) test_inputs($_POST['delivery_period_id']);
			$payment_term_id          = (int) test_inputs($_POST['payment_term_id']);
			$po_date = date('Y-m-d');
			
			if( isset( $_POST['notes'] ) ){
				$notes = test_inputs($_POST['notes']);
			}
			if( $notes == 'undefined' ){
				$notes = "";
			}
			
			
			$po_item_ids     = $_POST['po_item_ids'];
			$item_prices  = $_POST['item_prices'];
			$item_qtys    = $_POST['item_qtys'];
			$term_ids     = $_POST['term_ids'];
			
			
			$added_date    = date('Y-m-d H:i:00');
			
			
			$qu_gen_currencies_sel = "SELECT `exchange_rate` FROM  `gen_currencies` WHERE `currency_id` = $currency_id";
			$userStatement = mysqli_prepare($KONN,$qu_gen_currencies_sel);
			mysqli_stmt_execute($userStatement);
			$qu_gen_currencies_EXE = mysqli_stmt_get_result($userStatement);
			$gen_currencies_DATA;
			if(mysqli_num_rows($qu_gen_currencies_EXE)){
				$gen_currencies_DATA = mysqli_fetch_assoc($qu_gen_currencies_EXE);
			}
			
			$exchange_rate = $gen_currencies_DATA['exchange_rate'];
			
			
			
			$delivery_period_days = 0;
			$qu_gen_delivery_periods_sel = "SELECT `delivery_period_days` FROM  `gen_delivery_periods` WHERE `delivery_period_id` = $delivery_period_id";
			$userStatement = mysqli_prepare($KONN,$qu_gen_delivery_periods_sel);
			mysqli_stmt_execute($userStatement);
			$qu_gen_delivery_periods_EXE = mysqli_stmt_get_result($userStatement);
			$gen_delivery_periods_DATA;
			if(mysqli_num_rows($qu_gen_delivery_periods_EXE)){
				$gen_delivery_periods_DATA = mysqli_fetch_assoc($qu_gen_delivery_periods_EXE);
				$delivery_period_days = (int) $gen_delivery_periods_DATA['delivery_period_days'];
			}
			
			
			//CALC DATES
			$delivery_period_days = $delivery_period_days + 1;
			$delivery_date   = date('Y-m-d', strtotime($po_date. ' + '.$delivery_period_days.' days'));
			
			$po_status = 'draft';
			
			$qu_purchase_orders_updt = "UPDATE  `purchase_orders` SET 
			`po_date` = '".$po_date."', 
			`delivery_date` = '".$delivery_date."', 
			`delivery_period_id` = '".$delivery_period_id."', 
			`is_vat_included` = '".$is_vat_included."', 
			`payment_term_id` = '".$payment_term_id."', 
			`currency_id` = '".$currency_id."', 
			`exchange_rate` = '".$exchange_rate."', 
			`notes` = '".$notes."' 
			WHERE `po_id` = $po_id;";
			$updateStatement = mysqli_prepare($KONN,$qu_purchase_orders_updt);
			mysqli_stmt_execute($updateStatement);
			if( $po_id != 0 ){
				
				//insert items
				for($zz=0;$zz<count($po_item_ids);$zz++){
					$po_item_id          = test_inputs( $po_item_ids[$zz] );
					$item_price          = test_inputs( $item_prices[$zz] );
					$item_qty            = test_inputs( $item_qtys[$zz] );
					
					
					$qu_purchase_orders_items_updt = "UPDATE  `purchase_orders_items` SET 
					`item_qty` = '".$item_qty."', 
					`item_price` = '".$item_price."' WHERE `po_item_id` = $po_item_id;";
					$updateStatement = mysqli_prepare($KONN,$qu_purchase_orders_items_updt);
					mysqli_stmt_execute($updateStatement);
					
					
					//end of for loop
				}
				
				//delete old terms
				$qu_purchase_orders_terms_del = "DELETE FROM `purchase_orders_terms` WHERE `po_id` = $po_id";
				$deleteStatement = mysqli_prepare($KONN,$qu_purchase_orders_terms_del);
				
				mysqli_stmt_execute($deleteStatement);
				//insert Terms
				for( $EE=0;$EE<count($term_ids);$EE++ ){
					$term_id = test_inputs( $term_ids[$EE] );
					$qu_purchase_orders_terms_ins = "INSERT INTO `purchase_orders_terms` (
					`po_id`, 
					`term_id` 
					) VALUES (
					'".$po_id."', 
					'".$term_id."' 
					);";
					
					if( !mysqli_query($KONN, $qu_purchase_orders_terms_ins) ){
						die('ERR57845441');
					}
					//end of for loop
				}
				
				
				
				
				
				
				
				
				if( insert_state_change($KONN, $po_status, $po_id, "purchase_orders", $EMPLOYEE_ID) ) {
					die("1|purchase_orders_drafts.php");
					} else {
					die('0|Data Status Error 65154');
				}
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				}  else {
				die('0|ERR565775');
			}
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			}  else {
			die('0|bad req 54545');
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
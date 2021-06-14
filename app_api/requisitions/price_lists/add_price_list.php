<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		
		if( isset($_POST['requisition_id']) && 
		isset($_POST['supplier_id']) && 
		isset($_POST['currency_id']) && 
		isset($_POST['supplier_quotation_ref']) && 
		isset($_POST['delivery_period_id']) && 
		isset($_POST['payment_term_id']) && 
		isset($_POST['rfq_id']) && 
		isset($_POST['is_vat_included']) && 
		isset($_POST['discount_percentage']) && 
		isset($_POST['discount_amount']) && 
		isset($_POST['item_ids']) && 
		isset($_POST['item_qtys']) && 
		isset($_POST['item_prices'])
		){
			
			$requisition_id           = (int) test_inputs($_POST['requisition_id']);
			$supplier_id              = (int) test_inputs($_POST['supplier_id']);
			$currency_id              = (int) test_inputs($_POST['currency_id']);
			$rfq_id                   = (int) test_inputs($_POST['rfq_id']);
			
			$is_vat_included          = (int) test_inputs($_POST['is_vat_included']);
			
			$discount_percentage      = ( double ) test_inputs($_POST['discount_percentage']);
			$discount_amount          = test_inputs($_POST['discount_amount']);
			
			$supplier_quotation_ref   = test_inputs($_POST['supplier_quotation_ref']);
			
			$delivery_period_id       = test_inputs($_POST['delivery_period_id']);
			$payment_term_id          = test_inputs($_POST['payment_term_id']);
			
			
			if( isset( $_POST['notes'] ) ){
				$notes = test_inputs($_POST['notes']);
			}
			if( $notes == 'undefined' ){
				$notes = "";
			}
			
			
			$item_ids     = $_POST['item_ids'];
			$item_prices  = $_POST['item_prices'];
			$item_qtys    = $_POST['item_qtys'];
			
			
			$price_list_id = 0;
			$added_date    = date('Y-m-d H:i:00');
			
			
			$attached_supplier_quotation = "no-file.jpg";
			
			if( isset($_FILES['pl-new-attached_supplier_quotation']) && $_FILES['pl-new-attached_supplier_quotation']["tmp_name"] ){
				$upload_res = upload_picture('pl-new-attached_supplier_quotation', 9000, 'uploads', '../../../');
				
				if($upload_res == true){
					$attached_supplier_quotation = $upload_res;
					} else {
					die('s4443='.$upload_res);
				}
			}
			$attached_supplier_quotation1 = "no-file.jpg";
			
			if( isset($_FILES['pl-new-attached_supplier_quotation1']) && $_FILES['pl-new-attached_supplier_quotation1']["tmp_name"] ){
				$upload_res = upload_picture('pl-new-attached_supplier_quotation1', 9000, 'uploads', '../../../');
				if($upload_res == true){
					$attached_supplier_quotation1 = $upload_res;
					} else {
					die('s4443='.$upload_res);
				}
			}
			
			$qu_gen_currencies_sel = "SELECT `exchange_rate` FROM  `gen_currencies` WHERE `currency_id` = $currency_id";
			$userStatement = mysqli_prepare($KONN,$qu_gen_currencies_sel);
			mysqli_stmt_execute($userStatement);
			$qu_gen_currencies_EXE = mysqli_stmt_get_result($userStatement);
			$gen_currencies_DATA;
			if(mysqli_num_rows($qu_gen_currencies_EXE)){
				$gen_currencies_DATA = mysqli_fetch_assoc($qu_gen_currencies_EXE);
			}
			
			$exchange_rate = $gen_currencies_DATA['exchange_rate'];
			
			$qu_pur_requisitions_pls_ins = "INSERT INTO `pur_requisitions_pls` (
			`currency_id`, 
			`exchange_rate`, 
			`is_vat_included`, 
			`supplier_quotation_ref`, 
			`attached_supplier_quotation`,
			`attached_supplier_quotation1`,
			`delivery_period_id`, 
			`payment_term_id`, 
			`discount_percentage`, 
			`discount_amount`, 
			`notes`, 
			`rfq_id`, 
			`requisition_id`, 
			`supplier_id`, 
			`employee_id`, 
			`added_date` 
			) VALUES (
			'".$currency_id."', 
			'".$exchange_rate."', 
			'".$is_vat_included."', 
			'".$supplier_quotation_ref."', 
			'".$attached_supplier_quotation."', 
			'".$attached_supplier_quotation1."', 
			'".$delivery_period_id."', 
			'".$payment_term_id."', 
			'".$discount_percentage."', 
			'".$discount_amount."', 
			'".$notes."', 
			'".$rfq_id."', 
			'".$requisition_id."', 
			'".$supplier_id."', 
			'".$EMPLOYEE_ID."', 
			'".$added_date."' 
			);";
			
			// die("0|".$qu_pur_requisitions_pls_ins);
			$insertStatement = mysqli_prepare($KONN,$qu_pur_requisitions_pls_ins);
			mysqli_stmt_execute($insertStatement);
			$price_list_id = mysqli_insert_id($KONN);
			if( $price_list_id != 0 ){
				
				for($zz=0;$zz<count($item_ids);$zz++){
					$requisition_item_id = test_inputs( $item_ids[$zz] );
					$pl_item_price       = test_inputs( $item_prices[$zz] );
					$pl_item_qty         = test_inputs( $item_qtys[$zz] );
					
					$qu_pur_requisitions_items_sel = "SELECT `item_code_id` FROM  `pur_requisitions_items` WHERE `req_item_id` = $requisition_item_id";
					$userStatement = mysqli_prepare($KONN,$qu_pur_requisitions_items_sel);
					mysqli_stmt_execute($userStatement);
					$qu_pur_requisitions_items_EXE = mysqli_stmt_get_result($userStatement);
					$pur_requisitions_items_DATA;
					if(mysqli_num_rows($qu_pur_requisitions_items_EXE)){
						$pur_requisitions_items_DATA = mysqli_fetch_assoc($qu_pur_requisitions_items_EXE);
					}
					$item_code_id = $pur_requisitions_items_DATA['item_code_id'];
					
					
					
					
					
					$qu_pur_requisitions_pls_items_ins = "INSERT INTO `pur_requisitions_pls_items` (
					`item_code_id`, 
					`requisition_item_id`, 
					`item_qty`, 
					`pl_item_price`, 
					`price_list_id`, 
					`rfq_id`, 
					`requisition_id`, 
					`supplier_id`
					) VALUES (
					'".$item_code_id."', 
					'".$requisition_item_id."', 
					'".$pl_item_qty."', 
					'".$pl_item_price."', 
					'".$price_list_id."', 
					'".$rfq_id."', 
					'".$requisition_id."', 
					'".$supplier_id."' 
					);";
					
					$insertStatement = mysqli_prepare($KONN,$qu_pur_requisitions_pls_items_ins);
					mysqli_stmt_execute($insertStatement);
					
				}
				
				
				
				
				
				//add state change for requisition
				$current_state_id = get_current_state_id($KONN, $requisition_id, 'pur_requisitions' );
				if( $current_state_id != 0 ){
					if( insert_state_change_dep($KONN, "added-PL".$requisition_id, $price_list_id, "priceList", 'pur_requisitions_pls', $EMPLOYEE_ID, $current_state_id) ){
						die('1|Price List Added');
						} else {
						die('0|Component State Error 01');
					}
				} 
				else {
					die('0|Component State Error 02');
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
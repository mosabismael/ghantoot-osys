<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		
		if( isset($_POST['requisition_id']) && 
		isset($_POST['job_order_id']) && 
		isset($_POST['supplier_id']) && 
		isset($_POST['currency_id']) && 
		isset($_POST['supplier_quotation_ref']) && 
		isset($_POST['delivery_period_id']) && 
		isset($_POST['payment_term_id']) && 
		isset($_POST['is_vat_included']) && 
		isset($_POST['discount_percentage']) && 
		isset($_POST['discount_amount']) && 
		isset($_POST['item_ids']) && 
		isset($_POST['item_qtys']) && 
		isset($_POST['item_prices']) && 
		isset($_POST['term_ids'])
		){
			
			
			
			$po_ref                   = "";
			$requisition_id           = (int) test_inputs($_POST['requisition_id']);
			$job_order_id             = (int) test_inputs($_POST['job_order_id']);
			$supplier_id              = (int) test_inputs($_POST['supplier_id']);
			$currency_id              = (int) test_inputs($_POST['currency_id']);
			
			
			$is_vat_included          = (int) test_inputs($_POST['is_vat_included']);
			
			$discount_percentage      = ( double ) test_inputs($_POST['discount_percentage']);
			$discount_amount          = test_inputs($_POST['discount_amount']);
			
			$supplier_quotation_ref   = test_inputs($_POST['supplier_quotation_ref']);
			
			$delivery_period_id       = (int) test_inputs($_POST['delivery_period_id']);
			$payment_term_id          = (int) test_inputs($_POST['payment_term_id']);
			
			
			if( isset( $_POST['notes'] ) ){
				$notes = test_inputs($_POST['notes']);
			}
			if( $notes == 'undefined' ){
				$notes = "";
			}
			
			
			$item_ids             = $_POST['item_ids'];
			$item_prices          = $_POST['item_prices'];
			$item_qtys            = $_POST['item_qtys'];
			$term_ids             = $_POST['term_ids'];
			$term_texts           = $_POST['term_texts'];
			
			
			$po_id = 0;
			$added_date    = date('Y-m-d H:i:00');
			
			
			$attached_supplier_quotation = "no-file.jpg";
			if( isset( $_POST['data_file_old'] ) ){
				$attached_supplier_quotation   = test_inputs($_POST['data_file_old']);
			}
			$attached_supplier_quotation1 = "no-file.jpg";
			if( isset( $_POST['data_file_old1'] ) ){
				$attached_supplier_quotation   = test_inputs($_POST['data_file_old1']);
			}
			
			
			if( isset( $_FILES['new-attached_supplier_quotation'] ) ){
				$upload_res = upload_picture('new-attached_supplier_quotation', 9000, 'uploads', '../../');
				if($upload_res == true){
					$attached_supplier_quotation = $upload_res;
				}
			}
			
			if( isset( $_FILES['new-attached_supplier_quotation1'] ) ){
				$upload_res = upload_picture('new-attached_supplier_quotation1', 9000, 'uploads', '../../');
				if($upload_res == true){
					$attached_supplier_quotation1 = $upload_res;
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
			
			
			//get po_ref
			$tot_count_DB = 0;
			$qu_purchase_orders_sel = "SELECT COUNT(`po_id`) FROM  `purchase_orders` WHERE `po_date` LIKE '".date('Y')."-%'";
			$userStatement = mysqli_prepare($KONN,$qu_purchase_orders_sel);
			mysqli_stmt_execute($userStatement);
			$qu_purchase_orders_EXE = mysqli_stmt_get_result($userStatement);
			$purchase_orders_DATA;
			if(mysqli_num_rows($qu_purchase_orders_EXE)){
				$purchase_orders_DATA = mysqli_fetch_array($qu_purchase_orders_EXE);
				$tot_count_DB = (int) $purchase_orders_DATA [0];
			}
			$nwNO = $tot_count_DB + 525;
			$tot_count_DB_res = "";
			if($tot_count_DB < 10){
				$tot_count_DB_res = '000'.$nwNO;
				} else if( $tot_count_DB >= 10 && $tot_count_DB < 100 ){
				$tot_count_DB_res = '00'.$nwNO;
				} else if( $tot_count_DB >= 100 && $tot_count_DB < 1000 ){
				$tot_count_DB_res = '0'.$nwNO;
				} else {
				$tot_count_DB_res = ''.$nwNO;
			}
			$po_ref = "PO".date('y').$tot_count_DB_res;
			$po_date = date('Y-m-d');
			
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
			
			$qu_purchase_orders_ins = "INSERT INTO `purchase_orders` (
			`po_ref`, 
			`rev_no`, 
			`po_date`, 
			`delivery_date`, 
			`delivery_period_id`, 
			`discount_percentage`, 
			`discount_amount`, 
			`is_vat_included`, 
			`payment_term_id`, 
			`currency_id`, 
			`exchange_rate`, 
			`supplier_quotation_ref`, 
			`attached_supplier_quotation`, 
			`attached_supplier_quotation1`, 
			`notes`, 
			`po_status`, 
			`supplier_id`, 
			`requisition_id`, 
			`job_order_id`, 
			`employee_id`,
			`view_status`
			) VALUES (
			'".$po_ref."', 
			'0', 
			'".$po_date."', 
			'".$delivery_date."', 
			'".$delivery_period_id."', 
			'".$discount_percentage."', 
			'".$discount_amount."', 
			'".$is_vat_included."', 
			'".$payment_term_id."', 
			'".$currency_id."', 
			'".$exchange_rate."', 
			'".$supplier_quotation_ref."', 
			'".$attached_supplier_quotation."',
			'".$attached_supplier_quotation1."', 
			'".$notes."', 
			'".$po_status."', 
			'".$supplier_id."', 
			'".$requisition_id."', 
			'".$job_order_id."', 
			'".$EMPLOYEE_ID."',
			'0'
			);";
			$insertStatement = mysqli_prepare($KONN,$qu_purchase_orders_ins);
			mysqli_stmt_execute($insertStatement);
			$po_id = mysqli_insert_id($KONN);
			
			
			$date_add = Date('y:m:d', strtotime('+3 days'));
			
			$qu_pur_requisitions_updt = "INSERT INTO  `users_notifications` (`notification_title`, `notification_content`, `notification_link`, `sender_id`, `receiver_id`, `notification_time`, `is_notified`, `po_id`, `requisition_id`) 
			values ('draft_po', '$po_id is drafted', 'purchase_orders_draft.php', $EMPLOYEE_ID , $EMPLOYEE_ID, '$date_add'  , 0, $po_id, '');";
			$updateStatement = mysqli_prepare($KONN,$qu_pur_requisitions_updt);
			mysqli_stmt_execute($updateStatement);
			
			
			
			if( $po_id != 0 ){
				
				
				for($zz=0;$zz<count($item_ids);$zz++){
					$pl_record_id         = test_inputs( $item_ids[$zz] );
					$item_price           = test_inputs( $item_prices[$zz] );
					$item_qty             = test_inputs( $item_qtys[$zz] );
					
					$qu_pur_requisitions_pls_items_sel = "SELECT `requisition_item_id` FROM  `pur_requisitions_pls_items` WHERE `pl_record_id` = $pl_record_id";
					$userStatement = mysqli_prepare($KONN,$qu_pur_requisitions_pls_items_sel);
					mysqli_stmt_execute($userStatement);
					$qu_pur_requisitions_pls_items_EXE = mysqli_stmt_get_result($userStatement);
					$pur_requisitions_pls_items_DATA;
					$requisition_item_id = 0;
					if(mysqli_num_rows($qu_pur_requisitions_pls_items_EXE)){
						$pur_requisitions_pls_items_DATA = mysqli_fetch_assoc($qu_pur_requisitions_pls_items_EXE);
						$requisition_item_id = $pur_requisitions_pls_items_DATA['requisition_item_id'];
					}
					
					
					if( $requisition_item_id != 0 ){
						
						$qu_pur_requisitions_items_sel = "SELECT * FROM  `pur_requisitions_items` WHERE `req_item_id` = $requisition_item_id";
						$userStatement = mysqli_prepare($KONN,$qu_pur_requisitions_items_sel);
						mysqli_stmt_execute($userStatement);
						$qu_pur_requisitions_items_EXE = mysqli_stmt_get_result($userStatement);
						$pur_requisitions_items_DATA;
						if(mysqli_num_rows($qu_pur_requisitions_items_EXE)){
							$pur_requisitions_items_DATA = mysqli_fetch_assoc($qu_pur_requisitions_items_EXE);
						}
						$family_id = $pur_requisitions_items_DATA['family_id'];
						$section_id = $pur_requisitions_items_DATA['section_id'];
						$division_id = $pur_requisitions_items_DATA['division_id'];
						$subdivision_id = $pur_requisitions_items_DATA['subdivision_id'];
						$category_id = $pur_requisitions_items_DATA['category_id'];
						$item_code_id = $pur_requisitions_items_DATA['item_code_id'];
						
						$certificate_required = $pur_requisitions_items_DATA['certificate_required'];
						$unit_id = $pur_requisitions_items_DATA['item_unit_id'];
						
						
						
						$qu_purchase_orders_items_ins = "INSERT INTO `purchase_orders_items` (
						`family_id`, 
						`section_id`, 
						`division_id`, 
						`subdivision_id`, 
						`category_id`, 
						`item_code_id`, 
						`unit_id`, 
						`item_qty`, 
						`item_price`, 
						`certificate_required`, 
						`req_item_id`, 
						`po_id` 
						) VALUES (
						'".$family_id."', 
						'".$section_id."', 
						'".$division_id."', 
						'".$subdivision_id."', 
						'".$category_id."', 
						'".$item_code_id."', 
						'".$unit_id."', 
						'".$item_qty."', 
						'".$item_price."', 
						'".$certificate_required."', 
						'".$requisition_item_id."', 
						'".$po_id."' 
						);";
						
						$insertStatement = mysqli_prepare($KONN,$qu_purchase_orders_items_ins);
						mysqli_stmt_execute($insertStatement);
						
						
						
						
						//end of re item chk
					}
					//end of for loop
				}
				
				//insert limited tiems
				if( isset( $_POST['limited_ids'] ) ){
					
					$limited_ids     = $_POST['limited_ids'];
					$limited_prices  = $_POST['limited_prices'];
					$limited_qtys    = $_POST['limited_qtys'];
					
					for($MM=0;$MM<count($limited_ids);$MM++){
						$limited_id             = test_inputs( $limited_ids[$MM] );
						$item_priceLim          = test_inputs( $limited_prices[$MM] );
						$item_qtyLim            = test_inputs( $limited_qtys[$MM] );
						
						$LI_purchase_orders_items_ins = "INSERT INTO `purchase_orders_items` (
						`family_id`, 
						`section_id`, 
						`division_id`, 
						`subdivision_id`, 
						`category_id`, 
						`item_code_id`, 
						`unit_id`, 
						`item_qty`, 
						`item_price`, 
						`certificate_required`, 
						`limited_id`, 
						`po_id` 
						) VALUES (
						'0', 
						'0', 
						'0', 
						'0', 
						'0', 
						'0', 
						'0', 
						'".$item_qtyLim."', 
						'".$item_priceLim."', 
						'NO', 
						'".$limited_id."', 
						'".$po_id."' 
						);";
						
						
						$insertStatement = mysqli_prepare($KONN,$LI_purchase_orders_items_ins);
						mysqli_stmt_execute($insertStatement);
						
					}
				}
				
				//insert Terms
				for( $EE=0;$EE<count($term_ids);$EE++ ){
					$term_id   = ( int ) test_inputs( $term_ids[$EE] );
					$term_text = test_inputs( $term_texts[$EE] );
					
					$qu_purchase_orders_terms_ins = "INSERT INTO `purchase_orders_terms` (
					`po_id`, 
					`term_id`, 
					`term_text` 
					) VALUES (
					'".$po_id."', 
					'".$term_id."', 
					'".$term_text."' 
					);";
					$insertStatement = mysqli_prepare($KONN,$qu_purchase_orders_terms_ins);
					mysqli_stmt_execute($insertStatement);
					
					
					//end of for loop
				}
				
				
				
				
				
				
				if( insert_state_change($KONN, $po_status, $po_id, "purchase_orders", $EMPLOYEE_ID) ) {
					die("1|purchase_orders_drafts.php?click=".$po_id);
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
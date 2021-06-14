<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	
	try{
		
		if( isset($_POST['rfq_no']) &&
		isset($_POST['quotation_date']) &&
		isset($_POST['payment_term_id']) &&
		isset($_POST['currency_id']) &&
		isset($_POST['delivery_period_id']) &&
		isset($_POST['delivery_method']) && 
		isset($_POST['valid_until']) && 
		isset($_POST['pak_tr_amount']) && 
		isset($_POST['coo_amount']) && 
		isset($_POST['is_vat_included']) && 
		isset($_POST['client_id']) 
		){
			
			$quotation_id = 0;
			$quotation_ref = "";
			$rev_no = "0";
			
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
			$discount_amount = 0;
			$is_vat_included = test_inputs($_POST['is_vat_included']);
			$client_id = test_inputs($_POST['client_id']);
			$employee_id = $EMPLOYEE_ID;
			$quotation_status = "draft";
			
			$quotation_notes = "";
			if( isset($_POST['quotation_notes']) ){
				$quotation_notes = test_inputs( $_POST['quotation_notes'] );
			}
			
			
			
			
			//CALC REF
			$tot_dt;
			$c_q = "SELECT COUNT(*) FROM `sales_quotations` WHERE `quotation_date` LIKE '".date('Y-m')."-%'";
			$userStatement = mysqli_prepare($KONN,$c_q);
			mysqli_stmt_execute($userStatement);
			$c_exe = mysqli_stmt_get_result($userStatement);
			if($c_exe){
				$tot_dt = mysqli_fetch_array($c_exe);
			}
			$tt = (int) $tot_dt[0];
			$db_count = $tt + 1;
			
			
			$db_count_res = ''.$db_count;
			if($db_count < 10){
				$db_count_res = '0'.$db_count;
			}
			
			$quotation_ref ="GQ".date('ymd').$db_count_res;
			
			
			
			//CALC DATES
			
			$valid_date   = date('Y-m-d', strtotime($quotation_date. ' + '.$valid_until.' days'));
			
			
			
			
			
			// die("0|am here CCC--".$quotation_ref."---".$valid_date);
			
			
			
			$qu_sales_quotations_ins = "INSERT INTO `sales_quotations` (
			`quotation_ref`, 
			`rev_no`, 
			`rfq_no`, 
			`quotation_date`, 
			`payment_term_id`, 
			`currency_id`, 
			`delivery_period_id`, 
			`delivery_method`, 
			`quotation_notes`, 
			`valid_until`, 
			`valid_date`, 
			`pak_tr_amount`, 
			`coo_amount`, 
			`discount_amount`, 
			`is_vat_included`, 
			`client_id`, 
			`employee_id`, 
			`quotation_status` 
			) VALUES (
			'".$quotation_ref."', 
			'".$rev_no."', 
			'".$rfq_no."', 
			'".$quotation_date."', 
			'".$payment_term_id."', 
			'".$currency_id."', 
			'".$delivery_period_id."', 
			'".$delivery_method."', 
			'".$quotation_notes."', 
			'".$valid_until."', 
			'".$valid_date."', 
			'".$pak_tr_amount."', 
			'".$coo_amount."', 
			'".$discount_amount."', 
			'".$is_vat_included."', 
			'".$client_id."', 
			'".$EMPLOYEE_ID."', 
			'".$quotation_status."' 
			);";
			$insertStatement = mysqli_prepare($KONN,$qu_sales_quotations_ins);
			
			mysqli_stmt_execute($insertStatement);
			
			
			$quotation_id = mysqli_insert_id($KONN);
			if( $quotation_id != 0 ){
				
				if( insert_state_change($KONN, $quotation_status, $quotation_id, "sales_quotations", $EMPLOYEE_ID) ) {
					$curentState = get_current_state_id($KONN, $quotation_id, "sales_quotations" );
					
					
					if( isset( $_POST['contact_ids'] ) ){
						$link_id = 0;
						$contact_ids = $_POST['contact_ids'];
						for( $G = 0 ; $G < count( $contact_ids ) ; $G++ ){
							$contact_id = (int) test_inputs( $contact_ids[$G] );
							
							$qu_gen_clients_contacts_sel = "SELECT * FROM  `gen_clients_contacts` WHERE `contact_id` = $contact_id";
							$userStatement = mysqli_prepare($KONN,$qu_gen_clients_contacts_sel);
							mysqli_stmt_execute($userStatement);
							$qu_gen_clients_contacts_EXE = mysqli_stmt_get_result($userStatement);
							$contact_name = "NA";
							if(mysqli_num_rows($qu_gen_clients_contacts_EXE)){
								$gen_clients_contacts_DATA = mysqli_fetch_assoc($qu_gen_clients_contacts_EXE);
								$contact_name = $gen_clients_contacts_DATA['contact_name'];
							}
							
							
							
							
							
							
							
							$qu_sales_quotations_contacts_ins = "INSERT INTO `sales_quotations_contacts` (
							`contact_id`, 
							`quotation_id` 
							) VALUES (
							'".$contact_id."', 
							'".$quotation_id."' 
							);";
							$insertStatement = mysqli_prepare($KONN,$qu_sales_quotations_contacts_ins);
							
							mysqli_stmt_execute($insertStatement);
							$link_id = mysqli_insert_id( $KONN );
								die("0|ERROR STATE CONTACTS");
							
						}
					}
					
					
					
					
					
					
					
					die("1|quotations_details.php?quotation_id=$quotation_id");
					
					
					
					
					
					
					
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

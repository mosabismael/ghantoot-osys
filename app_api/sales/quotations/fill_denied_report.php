<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	
	try{
		
		if( isset($_POST['quotation_id']) &&
		isset($_POST['reason_id']) &&
		isset($_POST['denial_notes'])
		){
			
			$record_id = 0;
			$quotation_id = test_inputs($_POST['quotation_id']);
			$reason_id = test_inputs($_POST['reason_id']);
			$denial_notes = test_inputs($_POST['denial_notes']);
			$denial_date = date("Y-m-d H:i:00");
			
			
			$token_id = 0;
			$rev_no = 0;
			$quotation_ref = "";
			$qu_sales_quotations_sel = "SELECT * FROM  `sales_quotations` WHERE `quotation_id` = $quotation_id";
			$userStatement = mysqli_prepare($KONN,$qu_sales_quotations_sel);
			mysqli_stmt_execute($userStatement);
			$qu_sales_quotations_EXE = mysqli_stmt_get_result($userStatement);
			$sales_quotations_DATA;
			if( mysqli_num_rows($qu_sales_quotations_EXE) == 1 ){
				$sales_quotations_DATA = mysqli_fetch_assoc($qu_sales_quotations_EXE);
				$quotation_ref = $sales_quotations_DATA['quotation_ref'];
				$rev_no = ( int ) $sales_quotations_DATA['rev_no'];
				$quotation_ref = $quotation_ref.'-'.$rev_no;
				$token_id = ( int ) $sales_quotations_DATA['token_id'];
			}
			
			$qu_sales_quotations_denial_reasons_sel = "SELECT * FROM  `sales_quotations_denial_reasons` WHERE `reason_id` = $reason_id";
			$qu_sales_quotations_denial_reasons_EXE = mysqli_query($KONN, $qu_sales_quotations_denial_reasons_sel);
			$sales_quotations_denial_reasons_DATA;
			if(mysqli_num_rows($qu_sales_quotations_denial_reasons_EXE)){
				$sales_quotations_denial_reasons_DATA = mysqli_fetch_assoc($qu_sales_quotations_denial_reasons_EXE);
			}
			$reason_name = $sales_quotations_denial_reasons_DATA['reason_name'];
			
			
			
			// die("0|am here CCC--".$quotation_ref);
			
			
			$qu_sales_quotations_denials_ins = "INSERT INTO `sales_quotations_denials` (
			`quotation_id`, 
			`rev_no`, 
			`reason_id`, 
			`denial_notes`, 
			`denial_date`, 
			`employee_id` 
			) VALUES (
			'".$quotation_id."', 
			'".$rev_no."', 
			'".$reason_id."', 
			'".$denial_notes."', 
			'".$denial_date."', 
			'".$EMPLOYEE_ID."' 
			);";
			$insertStatement = mysqli_prepare($KONN,$qu_sales_quotations_denials_ins);
			
			mysqli_stmt_execute($insertStatement);
			
			$record_id = mysqli_insert_id($KONN);
			if( $record_id != 0 ){
				
				//insert_change_for_quotation
				$current_state_id = get_current_state_id($KONN, $quotation_id, 'sales_quotations' );
				if( $current_state_id != 0 ){
					if( insert_state_change_dep($KONN, "denial_report_submitted", $quotation_id, $reason_name, 'sales_quotations', $EMPLOYEE_ID, $current_state_id) ){
						
						
						//change quotation status
						
						$quotation_status = 'client_denied';
						$qu_sales_quotations_updt = "UPDATE  `sales_quotations` SET 
						`quotation_status` = '".$quotation_status."'
						WHERE `quotation_id` = $quotation_id;";
						$updateStatement = mysqli_prepare($KONN,$qu_sales_quotations_updt);
						mysqli_stmt_execute($updateStatement);
						die("1|sales_quotations.php?reported=1");
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						} else {
						die('0|Component State Error 0100');
					}
					} else {
					die('0|Component State Error 0101');
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
						
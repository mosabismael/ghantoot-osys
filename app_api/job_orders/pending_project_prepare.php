<?php
	
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	
	try{
		if(!isset($_POST['token_id'])){
			die('0|ERR_REQ_4568674653');
		}
		
		$token_id = $_POST['token_id'];
		$quotation_id = 0;
		
		$token_status = 'pending_project_prepare';
		
		$qu_tkn_data_updt = "UPDATE  `tkn_data` SET 
		`token_status` = '".$token_status."'
		WHERE `token_id` = $token_id;";
		$updateStatement = mysqli_prepare($KONN,$qu_tkn_data_updt);
		mysqli_stmt_execute($updateStatement);
		
		if( insert_state_change($KONN, $token_status, $token_id, "tkn_data", $EMPLOYEE_ID) ){
			
			/*
				//check if there is quotation inserted
				$qu_sales_quotations_sel = "SELECT `quotation_id` FROM  `sales_quotations` WHERE ((`token_id` = '$token_id') AND (`quotation_status` = 'draft'))";
				$qu_sales_quotations_EXE = mysqli_query($KONN, $qu_sales_quotations_sel);
				$sales_quotations_DATA;
				if(mysqli_num_rows($qu_sales_quotations_EXE)){
				$sales_quotations_DATA = mysqli_fetch_assoc($qu_sales_quotations_EXE);
				$quotation_id = (int) $sales_quotations_DATA['quotation_id'];
				
				$quotation_status = 'pending_project_prepare';
				
				$qu_sales_quotations_updt = "UPDATE  `sales_quotations` SET 
				`quotation_status` = '".$quotation_status."'
				WHERE `quotation_id` = $quotation_id;";
				
				if(mysqli_query($KONN, $qu_sales_quotations_updt)){
				if( insert_state_change($KONN, $quotation_status, $quotation_id, "sales_quotations", $EMPLOYEE_ID) ){
				die('1|Good');
				}
				}
				
				} else {
				die('1|Good');
				}
			*/
			
			//insert notification for eng dept for token requested project
			
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

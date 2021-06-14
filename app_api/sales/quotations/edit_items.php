<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	
	try{
		
		if( isset($_POST['quotation_id']) &&
		isset($_POST['discount_amount']) && 
		isset($_POST['is_vat_included']) && 
		isset($_POST['q_item_ids']) && 
		isset($_POST['item_names']) && 
		isset($_POST['item_qtys']) && 
		isset($_POST['item_units']) && 
		isset($_POST['item_prices'])  
		){
			
			$quotation_id = 0;
			
			$quotation_id = (int) test_inputs($_POST['quotation_id']);
			$discount_amount = test_inputs($_POST['discount_amount']);
			$is_vat_included = test_inputs($_POST['is_vat_included']);
			
			$item_ids = $_POST['q_item_ids'];
			$item_names = $_POST['item_names'];
			$item_qtys = $_POST['item_qtys'];
			$item_units = $_POST['item_units'];
			$item_prices = $_POST['item_prices'];
			
			// die("0|am here CCC--".$quotation_ref."---".$valid_date);
			
			$qu_sales_quotations_updt = "UPDATE  `sales_quotations` SET 
			`discount_amount` = '".$discount_amount."', 
			`is_vat_included` = '".$is_vat_included."' 
			WHERE `quotation_id` = $quotation_id;";
			
			$updateStatement = mysqli_prepare($KONN,$qu_sales_quotations_updt);
			mysqli_stmt_execute($updateStatement);
			if( $quotation_id != 0 ){
				
				
				$curentState = get_current_state_id($KONN, $quotation_id, "sales_quotations" );
				
				
				//edit quotation items
				$notDeleteCond = "";
				$ItemIdsDel = "";
				//count current items
				for($i=0;$i<count($item_ids);$i++){
					$q_item_id    = (int) test_inputs( $item_ids[$i] );
					$q_item_name  = test_inputs( $item_names[$i] );
					if( $q_item_id != 0 ){
						//add to ignore list
						$notDeleteCond = "( `q_item_id` <> '$q_item_id' ) AND ".$notDeleteCond;
						$ItemIdsDel = $ItemIdsDel.'-'.$q_item_id;
					}
				}
				$notDeleteCond = rtrim($notDeleteCond, 'AND ');
				
				// die("0|".$notDeleteCond);
				
				if( $notDeleteCond != "" ){
					$notDeleteCond = " WHERE (".$notDeleteCond.")";
					//excute old delete
					$qu_sales_quotations_items_del = "DELETE FROM `sales_quotations_items` ".$notDeleteCond;
					$deleteStatement = mysqli_prepare($KONN,$qu_sales_quotations_items_del);
					
					mysqli_stmt_execute($deleteStatement);
					die("0|ERROR STATE CONTACTS");
					
					
				} else {
					//die('0|Data Delete Error 457748');
					
				}
				
				
				
				for($i=0;$i<count($item_names);$i++){
					$q_item_id    = (int) test_inputs( $item_ids[$i] );
					$q_item_name  = test_inputs( $item_names[$i] );
					$q_item_qty   = test_inputs( $item_qtys[$i] );
					$unit_id      = test_inputs( $item_units[$i] );
					$q_item_price = test_inputs( $item_prices[$i] );
					
					if( $q_item_id == 0 ){
						$qu_sales_quotations_items_ins = "INSERT INTO `sales_quotations_items` (
						`q_item_name`, 
						`q_item_price`, 
						`q_item_qty`, 
						`unit_id`, 
						`quotation_id` 
						) VALUES (
						'".$q_item_name."', 
						'".$q_item_price."', 
						'".$q_item_qty."', 
						'".$unit_id."', 
						'".$quotation_id."' 
						);";
						$insertStatement = mysqli_prepare($KONN,$qu_sales_quotations_items_ins);
						
						mysqli_stmt_execute($insertStatement);
						
						$q_item_id = mysqli_insert_id( $KONN );
						if( !insert_state_change_dep($KONN, "add_quotations_Itm-".$q_item_id, $q_item_id, "new_item-".$q_item_name, "sales_quotations_items", $EMPLOYEE_ID, $curentState) ){
							die("0|ERROR STATE CONTACTS");
						}
						
						
					}
				}
				
				die("1|sales Quotation Updated");
				
				
				
				
				
				
				
				
				
				
				
				
				
				
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

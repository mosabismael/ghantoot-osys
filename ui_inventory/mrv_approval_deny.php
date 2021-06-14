<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 8;
	$subPageID = 17;
	
	
if( isset($_POST['mrv_id']) &&
	isset($_POST['item_id']) 
	){
		

	$mrv_id = 0;
	$inspected_date = date('Y-m-d H:i:00');
	$stock_id = ( int ) $_POST['item_id'];
	$mrv_id  = ( int ) test_inputs($_POST['mrv_id']);
	
	$mrv_status = "itm-inspctd-Den-".$stock_id;
	
	
	$qu_inv_mrvs_sel = "SELECT * FROM  `inv_mrvs` WHERE `mrv_id` = $mrv_id";
	$qu_inv_mrvs_EXE = mysqli_query($KONN, $qu_inv_mrvs_sel);
	$created_by = 0;
	if(mysqli_num_rows($qu_inv_mrvs_EXE)){
		$inv_mrvs_DATA = mysqli_fetch_assoc($qu_inv_mrvs_EXE);
		$created_by = $inv_mrvs_DATA['created_by'];
	}

	
	
	//update status
	$current_state_id = get_current_state_id($KONN, $mrv_id, 'inv_mrvs' );
	if( $current_state_id != 0 ){
		if( insert_state_change_dep($KONN, "item-inspect", $mrv_id, $mrv_status, 'inv_mrvs', $EMPLOYEE_ID, $current_state_id) ){
			
			$stock_status = 'rejected';
			$qu_inv_stock_updt = "UPDATE  `inv_stock` SET 
								`stock_status` = '".$stock_status."' 
								WHERE `stock_id` = $stock_id;";

					if( mysqli_query($KONN, $qu_inv_stock_updt) ){
						
						
						
		header("location:mrv_approval.php?mrv_id=".$mrv_id);
		die();
						
						
						
					} else {
						die( 'itemUpdtError'.mysqli_error( $KONN ) );
					}
			
			
			
		} else {
			die( 'comErr'.mysqli_error( $KONN ) );
		}
	} else {
		die('0|Component State Error 02');
	}
		
		
		
		
		
		
		
		
	}
	
	
	
	
?>
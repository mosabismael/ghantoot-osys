<?php
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		if( !isset( $_POST['stock_id'] ) ){
			die('0|ERR_REQ_453334653');
		}
		
		$stock_id = ( int ) $_POST['stock_id'];
		$qu_inv_stock_sel = "SELECT * FROM  `inv_stock` WHERE `stock_id` = $stock_id";
		$userStatement = mysqli_prepare($KONN,$qu_inv_stock_sel);
		mysqli_stmt_execute($userStatement);
		$qu_inv_stock_EXE = mysqli_stmt_get_result($userStatement);
		$inv_stock_DATA;
		if(mysqli_num_rows($qu_inv_stock_EXE)){
			$inv_stock_DATA = mysqli_fetch_assoc($qu_inv_stock_EXE);
			} else {
			die('0|ERR_REQ_453334653');
		}
		
		$stock_barcode = $inv_stock_DATA['stock_barcode'];
		
		$item_name = $stock_barcode."<br>".get_item_description( $stock_id, 'stock_id', 'inv_stock', $KONN );
		
		
		
		
		
		
		
		
		
		
		
		echo $item_name;
		die();
		
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

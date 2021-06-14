<?php
	
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	
	try{
		
		$IAM_ARRAY;
		
		$q = "SELECT * FROM  `suppliers_list`";
		$userStatement = mysqli_prepare($KONN,$q);
		mysqli_stmt_execute($userStatement);
		$result = mysqli_stmt_get_result($userStatement);
		
		if($result->num_rows != 0){
			
			while( $ARRAY_SRC = mysqli_fetch_assoc($result) ){
				
				$IAM_ARRAY[] = array(  "supplier_id" => $ARRAY_SRC['supplier_id'], 
				"supplier_code" => $ARRAY_SRC['supplier_code'], 
				"supplier_name" => $ARRAY_SRC['supplier_name'], 
				"supplier_type" => $ARRAY_SRC['supplier_type'], 
				"supplier_cat" => $ARRAY_SRC['supplier_cat'], 
				"website" => $ARRAY_SRC['website'], 
				"country" => $ARRAY_SRC['country'], 
				"address" => $ARRAY_SRC['address'], 
				"supplier_phone" => $ARRAY_SRC['supplier_phone'], 
				"trn_no" => $ARRAY_SRC['trn_no'] 
				);
				
				
			}
			
			} else {
			
			$IAM_ARRAY[] = array(  "supplier_id" => 0, 
			"supplier_code" => 0, 
			"supplier_name" => 0, 
			"supplier_type" => 0, 
			"supplier_cat" => 0, 
			"website" => 0, 
			"country" => 0, 
			"address" => 0, 
			"supplier_phone" => 0, 
			"trn_no" => 0 
			);
			
			
		}
		
		
		echo json_encode($IAM_ARRAY);
		
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

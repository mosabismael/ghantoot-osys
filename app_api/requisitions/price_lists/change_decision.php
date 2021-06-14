<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		
		if( isset($_POST['notes']) && 
		isset($_POST['pl_record_id']) 
		){
			
			
			$denial_reason  = test_inputs($_POST['notes']);
			$pl_record_id    = (int) test_inputs($_POST['pl_record_id']);
			
			
			
			
			//load item id
			$qu_pur_requisitions_pls_items_updt = "UPDATE  `pur_requisitions_pls_items` SET 
			`is_approved` = '0', 
			`denial_reason` = '".$denial_reason."'
			WHERE ((`pl_record_id` = $pl_record_id));";
			$updateStatement = mysqli_prepare($KONN,$qu_pur_requisitions_pls_items_updt);
			mysqli_stmt_execute($updateStatement);
			
			die("1|Price Decision Changed");
			
			
			
			
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
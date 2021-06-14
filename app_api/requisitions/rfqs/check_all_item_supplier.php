<?php
	
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	try{
		
		if(!isset($_POST['requisition_id'])){
			die('7wiu');
		}
		
		$requisition_id = (int) $_POST['requisition_id'];
		
		
		
		$IAM_ARRAY;
		$req_item_id= 0;
		$q = "SELECT * FROM  pur_requisitions_items items WHERE items.requisition_id = $requisition_id ";
		$userStatement = mysqli_prepare($KONN,$q);
		mysqli_stmt_execute($userStatement);
		$q_exe = mysqli_stmt_get_result($userStatement);
		
		if(mysqli_num_rows($q_exe) != 0){
			
			while( $ARRAY_SRC = mysqli_fetch_assoc($q_exe) ){
				$enter = 0;
				$req_item_id = ( int ) $ARRAY_SRC['req_item_id'];
				$count2=0;
				$q_1 = "SELECT * FROM  pur_requisitions_rfq_items items WHERE items.req_item_id = $req_item_id ";
				$userStatement1 = mysqli_prepare($KONN,$q_1);
				mysqli_stmt_execute($userStatement1);
				$q_exe_1 = mysqli_stmt_get_result($userStatement1);
				
				if(mysqli_num_rows($q_exe_1) != 0){
					
					
					$enter = 1;
					
				}
				if($enter == 0){
					$IAM_ARRAY[] = array(  "result" => "false", 
					);
					die (json_encode($IAM_ARRAY));
				}
				
			}
		}
		
		
		$IAM_ARRAY[] = array(  "result" => "true", 
		);	
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

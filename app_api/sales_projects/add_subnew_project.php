<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{

		if(
		isset($_POST['project_name']) &&
		isset($_POST['quotation_id'])){		
			$project_name = test_inputs($_POST['project_name']);
			$project_notes = test_inputs($_POST['project_notes']);
            $quotation_id = test_inputs($_POST['quotation_id']);

            
			$qu_project_ins = "UPDATE  `z_project` SET 
			`project_name` = '".$project_name."' WHERE `quotation_id` = $quotation_id;";
				$insertStatement = mysqli_prepare($KONN,$qu_project_ins);
				
				mysqli_stmt_execute($insertStatement);
			
		
			}
			
			else {
			die('0|7wiu');
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

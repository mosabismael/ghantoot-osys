<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		
		if( isset($_POST['section_id']) && 
		isset($_POST['is_finished']) && 
		isset($_POST['unit_id']) && 
		isset($_POST['section_name']) 
		){
			
			$section_id = test_inputs($_POST['section_id']);
			$section_name = test_inputs($_POST['section_name']);
			
			$is_finished = (int) test_inputs($_POST['is_finished']);
			$unit_id = (int) test_inputs($_POST['unit_id']);
			
			
			$section_description = "";
			if( isset($_POST['section_description']) ){
				$section_description = test_inputs( $_POST['section_description'] );
			}
			
			$qu_inv_02_sections_updt = "UPDATE  `inv_02_sections` SET 
			`is_finished` = '".$is_finished."', 
			`unit_id` = '".$unit_id."', 
			`section_name` = '".$section_name."', 
			`section_description` = '".$section_description."' 
			WHERE `section_id` = $section_id;";
			$updateStatement = mysqli_prepare($KONN,$qu_inv_02_sections_updt);
			mysqli_stmt_execute($updateStatement);
			if( $section_id != 0 ){
				
				if( insert_state_change($KONN, "INV-Sec-E-".$section_name, $section_id, "inv_02_sections", $EMPLOYEE_ID) ) {
					die('1|Data Updated');
					} else {
					die('0|Data Status Error 65154');
				}
				
			}
			
			
			
			
			
			
			} else {
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

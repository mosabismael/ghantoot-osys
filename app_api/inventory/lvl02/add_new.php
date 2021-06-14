<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	try{
		
		if( isset($_POST['section_name']) &&
		isset($_POST['is_finished']) &&
		isset($_POST['unit_id']) &&
		isset($_POST['family_id']) 
		){
			
			$section_id = 0;
			$section_code = 999;
			$section_name = test_inputs($_POST['section_name']);
			$family_id = (int) test_inputs($_POST['family_id']);
			
			$is_finished = (int) test_inputs($_POST['is_finished']);
			$unit_id = (int) test_inputs($_POST['unit_id']);
			
			
			//code starts at 101 till 999
			//get code
			$SectionsCount = 0;
			$qu_inv_02_sections_sel = "SELECT COUNT(`section_id`) FROM  `inv_02_sections` ";
			$userStatement = mysqli_prepare($KONN,$qu_inv_02_sections_sel);
			mysqli_stmt_execute($userStatement);
			$qu_inv_02_sections_EXE = mysqli_stmt_get_result($userStatement);
			$inv_02_sections_DATA;
			if(mysqli_num_rows($qu_inv_02_sections_EXE)){
				$inv_02_sections_DATA = mysqli_fetch_array($qu_inv_02_sections_EXE);
				$SectionsCount = (int) $inv_02_sections_DATA[0];
			}
			
			
			$section_code = $SectionsCount + 101;
			$section_code = $section_code.'';
			
			
			//check if code Exist
			$qu_inv_02_sections_sel = "SELECT * FROM  `inv_02_sections` WHERE ((`section_name` = '$section_name') AND (`family_id` = '$family_id'))";
			$userStatement = mysqli_prepare($KONN,$qu_inv_02_sections_sel);
			mysqli_stmt_execute($userStatement);
			$qu_inv_02_sections_EXE = mysqli_stmt_get_result($userStatement);
			$inv_02_sections_DATA;
			if( mysqli_num_rows($qu_inv_02_sections_EXE) > 0 ){
				die( "0|Section name already exist" );
			}
			
			// die("0|".$section_code );
			
			
			$section_description = "";
			if( isset($_POST['section_description']) ){
				$section_description = test_inputs( $_POST['section_description'] );
			}
			
			$qu_inv_02_sections_ins = "INSERT INTO `inv_02_sections` (
			`section_code`, 
			`section_name`, 
			`section_description`,  
			`family_id`, 
			`is_finished`, 
			`unit_id`
			) VALUES (
			'".$section_code."', 
			'".$section_name."', 
		'".$section_description."', 
		'".$family_id."', 
		'".$is_finished."', 
		'".$unit_id."' 
		);";
		$insertStatement = mysqli_prepare($KONN,$qu_inv_02_sections_ins);
		mysqli_stmt_execute($insertStatement);
		$section_id = mysqli_insert_id($KONN);
		if( $section_id != 0 ){
		
		if( insert_state_change($KONN, "INV-Sec-".$section_name, $section_id, "inv_02_sections", $EMPLOYEE_ID) ) {
		die('1|Section Added');
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
				
<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	try{
		
		if( isset($_POST['category_name']) && 
		isset($_POST['is_finished']) && 
		isset($_POST['unit_id']) && 
		isset($_POST['subdivision_id']) 
		){
			
			
			$category_id = 0;
			$category_code = "ERROR";
			$category_name = test_inputs($_POST['category_name']);
			$subdivision_id = (int) test_inputs($_POST['subdivision_id']);
			
			$is_finished = (int) test_inputs($_POST['is_finished']);
			$unit_id = (int) test_inputs($_POST['unit_id']);
			
			
			
			$category_description = "";
			if( isset($_POST['category_description']) ){
				$category_description = test_inputs( $_POST['category_description'] );
			}
			
			
			
			//define code
			$DivCount = 0;
			$qu_inv_05_categories_sel = "SELECT COUNT(`category_id`) FROM  `inv_05_categories` WHERE `subdivision_id` = $subdivision_id";
			$userStatement = mysqli_prepare($KONN,$qu_inv_05_categories_sel);
			mysqli_stmt_execute($userStatement);
			$qu_inv_05_categories_EXE = mysqli_stmt_get_result($userStatement);
			$inv_05_categories_DATA;
			if(mysqli_num_rows($qu_inv_05_categories_EXE)){
				$inv_05_categories_DATA = mysqli_fetch_array($qu_inv_05_categories_EXE);
				$DivCount = (int) $inv_05_categories_DATA[0];
			}
			
			$DivCount = $DivCount + 10;
			
			
			if( $DivCount > 99 ){
				$DivCount = $DivCount + 101;
			}
			
			
			
			$category_code = $DivCount;
			
			$qu_inv_05_categories_sel = "SELECT * FROM  `inv_05_categories` WHERE ((`category_name` = '$category_name') AND (`subdivision_id` = $subdivision_id))";
			$userStatement = mysqli_prepare($KONN,$qu_inv_05_categories_sel);
			mysqli_stmt_execute($userStatement);
			$qu_inv_05_categories_EXE = mysqli_stmt_get_result($userStatement);
			$inv_05_categories_DATA;
			if( mysqli_num_rows($qu_inv_05_categories_EXE) > 0 ){
					die( "0|Category name already exist" );
			}
			
			
			
			// die("0|".$category_code);
			
			
			
			$qu_inv_05_categories_ins = "INSERT INTO `inv_05_categories` (
			`category_code`, 
			`category_name`, 
			`category_description`,  
			`subdivision_id`, 
			`is_finished`, 
			`unit_id` 
			) VALUES (
			'".$category_code."', 
			'".$category_name."', 
			'".$category_description."', 
			'".$subdivision_id."', 
			'".$is_finished."', 
			'".$unit_id."' 
			);";
			
			
			$insertStatement = mysqli_prepare($KONN,$qu_inv_05_categories_ins);
			mysqli_stmt_execute($insertStatement);
			$category_id = mysqli_insert_id($KONN);
			
			if( $category_id != 0 ){
				
				if( insert_state_change($KONN, "INV-Cat-".$category_name, $category_id, "inv_05_categories", $EMPLOYEE_ID) ) {
					die('1|Category Added');
					} else {
					die('0|Data Status Error 65154');
				}
				
				
				} else {
				die( mysqli_error($KONN) );
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

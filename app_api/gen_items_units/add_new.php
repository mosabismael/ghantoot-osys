<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		if( isset($_POST['unit_name'])){
			
			
			
			$unit_id = 0;
			$unit_name = test_inputs($_POST['unit_name']);
			
			
			$qu_gen_items_units_sel = "SELECT * FROM  `gen_items_units` WHERE `unit_name` = '$unit_name' ";
			$userStatement = mysqli_prepare($KONN,$qu_gen_items_units_sel);
			mysqli_stmt_execute($userStatement);
			$qu_gen_items_units_EXE = mysqli_stmt_get_result($userStatement);
			$gen_items_units_DATA;
			if(mysqli_num_rows($qu_gen_items_units_EXE)){
				die("0|Unit Already Exist");
			}
			
			
			
			
			
			
			
			
			$qu_gen_items_units_ins = "INSERT INTO `gen_items_units` (
			`unit_name`
			) VALUES (
			'".$unit_name."'
			);";
			$insertStatement = mysqli_prepare($KONN,$qu_gen_items_units_ins);
			
			mysqli_stmt_execute($insertStatement);
			
			$unit_id = mysqli_insert_id($KONN);
			if( $unit_id != 0 ){
				
				
				if( insert_state_change($KONN, "New-UOM", $unit_id, "gen_items_units", $EMPLOYEE_ID) ) {
					die("1|Unit Added");
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

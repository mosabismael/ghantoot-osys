<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	try{
		if( isset($_POST['rack_name']) && isset($_POST['area_id']) ){
			
			
			$rack_id = 0;
			$rack_name = test_inputs($_POST['rack_name']);
			$area_id = test_inputs($_POST['area_id']);
			
			if( $rack_name != '' && $area_id != 0 ){
				
				$qu_wh_racks_sel = "SELECT * FROM  `wh_racks` WHERE `rack_name` = '$rack_name' AND `area_id` = $area_id ";
				$userStatement = mysqli_prepare($KONN,$qu_wh_racks_sel);
				mysqli_stmt_execute($userStatement);
				$qu_wh_racks_EXE = mysqli_stmt_get_result($userStatement);
				$wh_racks_DATA;
				if( mysqli_num_rows($qu_wh_racks_EXE) > 0 ){
					die('0|rack Name Already Exisit');
				}
				
				
				$qu_wh_racks_ins = "INSERT INTO `wh_racks` (
				`rack_name`, 
				`area_id`
				) VALUES (
				'".$rack_name."', 
				'".$area_id."'
				);";
				$insertStatement = mysqli_prepare($KONN,$qu_wh_racks_ins);
				mysqli_stmt_execute($insertStatement);
				$user_id = mysqli_insert_id($KONN);
				die('1|Added New|'.$rack_name);
				
				} else {
				die('0|bad Name');
			}
			
			} else {
			die('0|bad request');
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

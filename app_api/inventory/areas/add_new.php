<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		
		if( isset($_POST['area_name']) ){
			
			
			$area_id = 0;
			
			$area_name = test_inputs($_POST['area_name']);
			
			if( $area_name != '' ){
				
				$qu_wh_areas_sel = "SELECT * FROM  `wh_areas` WHERE `area_name` = '$area_name'";
				$userStatement = mysqli_prepare($KONN,$qu_wh_areas_sel);
				mysqli_stmt_execute($userStatement);
				$qu_wh_areas_EXE = mysqli_stmt_get_result($userStatement);
				$wh_areas_DATA;
				if( mysqli_num_rows($qu_wh_areas_EXE) > 0 ){
					die('0|Area Name Already Exisit');
				}
				
				
				$qu_wh_areas_ins = "INSERT INTO `wh_areas` (
				`area_name`
				) VALUES (
				'".$area_name."'
				);";
				$insertStatement = mysqli_prepare($KONN,$qu_wh_areas_ins);
				mysqli_stmt_execute($insertStatement);
				die('1|Added New|'.$area_name);
				
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

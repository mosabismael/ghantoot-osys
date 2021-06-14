<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		
		if( isset($_POST['rack_id']) && 
		isset($_POST['area_id']) && 
		isset($_POST['rack_name']) 
		){
			
			$rack_id = test_inputs($_POST['rack_id']);
			$rack_name = test_inputs($_POST['rack_name']);
			$area_id = test_inputs($_POST['area_id']);
			
			
			
			if( $rack_name != '' ){
				
				$qu_wh_racks_sel = "SELECT * FROM  `wh_racks` WHERE `rack_name` = '$rack_name' AND `area_id` = $area_id ";
				$userStatement = mysqli_prepare($KONN,$qu_wh_racks_sel);
				mysqli_stmt_execute($userStatement);
				$qu_wh_racks_EXE = mysqli_stmt_get_result($userStatement);
				$wh_racks_DATA;
				if( mysqli_num_rows($qu_wh_racks_EXE) > 0 ){
					die('0|Rack Name Already Exisit');
					} else {
					$qu_rackts_updt = "UPDATE  `wh_racks` SET 
					`rack_name` = '".$rack_name."',
					`area_id` = '".$area_id."'
					WHERE `rack_id` = $rack_id;";
					$updateStatement = mysqli_prepare($KONN,$qu_rackts_updt);
					mysqli_stmt_execute($updateStatement);
					die('1|Save Succeed');
					
				}
				
				
				
				
			}
			
			
			
			
			
			
			
			
			} else {
			die('bad request');
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

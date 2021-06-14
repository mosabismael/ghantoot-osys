<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	try{
		if( isset($_POST['area_id']) && 
		isset($_POST['area_name']) 
		){
			
			$area_id = test_inputs($_POST['area_id']);
			$area_name = test_inputs($_POST['area_name']);
			
			
			
			if( $area_name != '' ){
				
				$qu_wh_areas_sel = "SELECT * FROM  `wh_areas` WHERE `area_name` = '$area_name' ";
				$userStatement = mysqli_prepare($KONN,$qu_wh_areas_sel);
		mysqli_stmt_execute($userStatement);
		$qu_wh_areas_EXE = mysqli_stmt_get_result($userStatement);
				$wh_areas_DATA;
				if( mysqli_num_rows($qu_wh_areas_EXE) > 0 ){
					die('0|Area Name Already Exisit');
					} else {
					$qu_areats_updt = "UPDATE  `wh_areas` SET 
					`area_name` = '".$area_name."' WHERE `area_id` = $area_id;";
					
					if(mysqli_query($KONN, $qu_areats_updt)){
						die('1|Save Succeed');
					}
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

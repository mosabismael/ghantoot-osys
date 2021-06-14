<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		if( isset($_POST['shelf_id']) && 
		isset($_POST['rack_id']) && 
		isset($_POST['shelf_name']) 
		){
			
			$shelf_id = test_inputs($_POST['shelf_id']);
			$shelf_name = test_inputs($_POST['shelf_name']);
			$rack_id = test_inputs($_POST['rack_id']);
			
			
			
			if( $shelf_name != '' ){
				
				$qu_wh_shelfs_sel = "SELECT * FROM  `wh_shelfs` WHERE `shelf_name` = '$shelf_name' AND `rack_id` = $rack_id ";
				$userStatement = mysqli_prepare($KONN,$qu_wh_shelfs_sel);
				mysqli_stmt_execute($userStatement);
				$qu_wh_shelfs_EXE = mysqli_stmt_get_result($userStatement);
				$wh_shelfs_DATA;
				if( mysqli_num_rows($qu_wh_shelfs_EXE) > 0 ){
					die('0|Shelf Name Already Exisit');
					} else {
					$qu_shelfts_updt = "UPDATE  `wh_shelfs` SET 
					`shelf_name` = '".$shelf_name."',
					`rack_id` = '".$rack_id."'
					WHERE `shelf_id` = $shelf_id;";
					$updateStatement = mysqli_prepare($KONN,$qu_shelfts_updt);
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

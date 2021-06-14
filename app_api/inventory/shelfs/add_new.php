<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		if( isset($_POST['shelf_name']) && isset($_POST['rack_id']) ){
			
			
			$shelf_id = 0;
			$shelf_name = test_inputs($_POST['shelf_name']);
			$rack_id = test_inputs($_POST['rack_id']);
			
			if( $shelf_name != '' && $rack_id != 0 ){
				
				$qu_wh_shelfs_sel = "SELECT * FROM  `wh_shelfs` WHERE `shelf_name` = '$shelf_name' AND `rack_id` = $rack_id ";
				$userStatement = mysqli_prepare($KONN,$qu_wh_shelfs_sel);
				mysqli_stmt_execute($userStatement);
				$qu_wh_shelfs_EXE = mysqli_stmt_get_result($userStatement);
				$wh_shelfs_DATA;
				if( mysqli_num_rows($qu_wh_shelfs_EXE) > 0 ){
					die('0|Shelf Name Already Exisit');
				}
				
				
				$qu_wh_shelfs_ins = "INSERT INTO `wh_shelfs` (
				`shelf_name`, 
				`rack_id`
				) VALUES (
				'".$shelf_name."', 
				'".$rack_id."'
				);";
				$insertStatement = mysqli_prepare($KONN,$qu_wh_shelfs_ins);
				mysqli_stmt_execute($insertStatement);
				$qu_wh_shelfs_ins = mysqli_insert_id($KONN);
				die('1|Added New|'.$shelf_name);
				
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

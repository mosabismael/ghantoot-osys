<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	
	try{
		
		
		if( isset($_POST['service_ids']) && isset($_POST['is_favs']) ){
			
			$service_ids = $_POST['service_ids'];
			$is_favs = $_POST['is_favs'];
			
			
			//count how many favs are there
			$favsCount = 0;
			for( $i = 0; $i < count( $is_favs ) ; $i++ ){
				$ths_fav = (int) test_inputs( $is_favs[$i] );
				if($ths_fav == 1 ){ $favsCount++; }
			}
			
			if($favsCount > 6 ){ 
				die( '0|'.lang("Favourite icons should be less than 6", "AAR") );
			}
			// die('0|'.$favsCount);
			
			
			$qu_sys_services_users_updtMain = "UPDATE  `sys_services_users` SET 
			`is_fav` = '0'
			WHERE `user_id` = $USER_ID;";
			$updateStatement = mysqli_prepare($KONN,$qu_sys_services_users_updtMain);
			mysqli_stmt_execute($updateStatement);
			
			
			for( $Z = 0; $Z < count( $service_ids ) ; $Z++ ){
				$service_id = (int) test_inputs( $service_ids[$Z] );
				$is_fav = (int) test_inputs( $is_favs[$Z] );
				$qu_sys_services_users_updt = "UPDATE  `sys_services_users` SET 
				`is_fav` = '".$is_fav."'
				WHERE `service_id` = $service_id AND `user_id` = $USER_ID;";
				$updateStatement = mysqli_prepare($KONN,$qu_sys_services_users_updt);
				mysqli_stmt_execute($updateStatement);
				
			}
			die( '1|'.lang("Favourite icons Updated", "AAR") );
			
			
			
			
			
			
			
			
			
			
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

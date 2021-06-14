<?php

	$qu_sys_services_sel = "SELECT * FROM  `sys_services` WHERE `service_id` = $MainServiceID";
	$qu_sys_services_EXE = mysqli_query($KONN, $qu_sys_services_sel);
	$sys_services_DATA;
	if(mysqli_num_rows($qu_sys_services_EXE)){
		$sys_services_DATA = mysqli_fetch_assoc($qu_sys_services_EXE);
	} else {
		die("Please Contact Support :: 65464");
	}
	$service_title = $sys_services_DATA['service_title'];
	$service_title_ar = $sys_services_DATA['service_title_ar'];
	$service_link = $sys_services_DATA['service_link'];
	$service_icon = $sys_services_DATA['service_icon'];
	$is_dependent = $sys_services_DATA['is_dependent'];
	$dependent_ids = $sys_services_DATA['dependent_ids'];
	
	$WHERE = $sys_services_DATA['service_title'.$lang_db];



	$qu_sys_services_users_sel = "SELECT COUNT(`link_id`) FROM  `sys_services_users` WHERE 
									((`service_id` = $MainServiceID) AND (`user_id` = $USER_ID) AND (`subservice_id`  IS NULL))";
	$qu_sys_services_users_EXE = mysqli_query($KONN, $qu_sys_services_users_sel);
	$sys_services_users_COUNT;
	if(mysqli_num_rows($qu_sys_services_users_EXE)){

		$sys_services_users_COUNT = mysqli_fetch_array($qu_sys_services_users_EXE);
		$linkCount = (int) $sys_services_users_COUNT[0];
		if( $linkCount != 1 ){
			header("location:index.php?qq=".$linkCount);
			die();
		}
		
	} else {
		die("Please Contact Support :: 49648766");
	}
	
	
	
	
	if( $subServiceID != 0 ){
		
		
		
	$qu_sub_sys_services_subs_sel = "SELECT * FROM  `sys_services_subs` WHERE `subservice_id` = $subServiceID";
	$qu_sub_sys_services_subs_EXE = mysqli_query($KONN, $qu_sub_sys_services_subs_sel);
	$sub_sys_services_subs_DATA;
	if(mysqli_num_rows($qu_sub_sys_services_subs_EXE)){
		$sub_sys_services_subs_DATA = mysqli_fetch_assoc($qu_sub_sys_services_subs_EXE);
		
		$qu_sys_services_subs_users_sel = "SELECT COUNT(`link_id`) FROM  `sys_services_users` WHERE 
										((`service_id` = $MainServiceID) AND (`user_id` = $USER_ID) AND (`subservice_id` = $subServiceID))";
		$qu_sys_services_subs_users_EXE = mysqli_query($KONN, $qu_sys_services_subs_users_sel);
		
		$sys_services_subs_users_COUNT;
		if(mysqli_num_rows($qu_sys_services_subs_users_EXE)){

			$sys_services_subs_users_COUNT = mysqli_fetch_array($qu_sys_services_subs_users_EXE);
			$linkCount = (int) $sys_services_subs_users_COUNT[0];
			if( $linkCount != 1 ){
				header("location:index.php?vvv=".$linkCount);
				die();
			}
			
		} else {
			die("Please Contact Support :: 49648766".$qu_sys_services_subs_users_sel);
		}
		
		
		
		$WHERE = $WHERE.' - '.$sub_sys_services_subs_DATA['subservice_title'.$lang_db];
	}

		
		
		
		
		
	}
	
	
	
	
	
	
?>
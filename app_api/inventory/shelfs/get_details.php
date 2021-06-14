<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		
		if(!isset($_POST['ids_id'])){
			die('7wiu');
		}
		
		$shelf_id = (int) $_POST['ids_id'];
		
		$IAM_ARRAY;
		
		$q = "SELECT * FROM `wh_shelfs` WHERE `shelf_id` = '".$shelf_id."'";
		$userStatement = mysqli_prepare($KONN,$q);
		mysqli_stmt_execute($userStatement);
		$q_exe = mysqli_stmt_get_result($userStatement);
		
		
		
		if(mysqli_num_rows($q_exe) == 0){
			$IAM_ARRAY[] = array(  "shelf_id" => 0, 
			"shelf_name" => 0, 
			"rack_id" => 0
			);
			
			} else {
			$ARRAY_SRC = mysqli_fetch_assoc($q_exe);
			
			
			/*		
				$shelf_type_id = $ARRAY_SRC['shelf_type_id'];
				$qu_shelfs_types_sel = "SELECT * FROM  `shelfs_types` WHERE `shelf_type_id` = $shelf_type_id";
				$qu_shelfs_types_EXE = mysqli_query($KONN, $qu_shelfs_types_sel);
				$shelfs_types_DATA;
				if(mysqli_num_rows($qu_shelfs_types_EXE)){
				$shelfs_types_DATA = mysqli_fetch_assoc($qu_shelfs_types_EXE);
				}
			*/
			
			
			
			
			
			
			
			$IAM_ARRAY[] = array(  "shelf_id" => $ARRAY_SRC['shelf_id'], 
			"shelf_name" => $ARRAY_SRC['shelf_name'], 
			"rack_id" => $ARRAY_SRC['rack_id']
			);
			
			
			
		}
		
		
		echo json_encode($IAM_ARRAY);
		
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

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
		
		$rack_id = (int) $_POST['ids_id'];
		
		$IAM_ARRAY;
		
		$q = "SELECT * FROM `wh_racks` WHERE `rack_id` = '".$rack_id."'";
		$userStatement = mysqli_prepare($KONN,$q);
		mysqli_stmt_execute($userStatement);
		$q_exe = mysqli_stmt_get_result($userStatement);
		
		
		
		if(mysqli_num_rows($q_exe) == 0){
			$IAM_ARRAY[] = array(  "rack_id" => 0, 
			"rack_name" => 0, 
			"area_id" => 0
			);
			
			} else {
			$ARRAY_SRC = mysqli_fetch_assoc($q_exe);
			
			
			/*		
				$rack_type_id = $ARRAY_SRC['rack_type_id'];
				$qu_racks_types_sel = "SELECT * FROM  `racks_types` WHERE `rack_type_id` = $rack_type_id";
				$qu_racks_types_EXE = mysqli_query($KONN, $qu_racks_types_sel);
				$racks_types_DATA;
				if(mysqli_num_rows($qu_racks_types_EXE)){
				$racks_types_DATA = mysqli_fetch_assoc($qu_racks_types_EXE);
				}
			*/
			
			
			
			
			
			
			
			$IAM_ARRAY[] = array(  "rack_id" => $ARRAY_SRC['rack_id'], 
			"rack_name" => $ARRAY_SRC['rack_name'], 
			"area_id" => $ARRAY_SRC['area_id']
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

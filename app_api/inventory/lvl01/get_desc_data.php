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
		
		$family_id = (int) test_inputs( $_POST['ids_id'] );
		$return_arr;
		
		$q = "SELECT * FROM  `inv_01_families_descs` WHERE `family_id` = '$family_id' LIMIT 1";
		$userStatement = mysqli_prepare($KONN,$q);
		mysqli_stmt_execute($userStatement);
		$q_exe = mysqli_stmt_get_result($userStatement);
		
		if(mysqli_num_rows($q_exe) == 0){
			
			
			//INSERT ROW for the selected family
			$lvl = "";
			$qu_inv_01_families_descs_ins = "INSERT INTO `inv_01_families_descs` (
			`lvl01`, 
			`lvl02`, 
			`lvl03`, 
			`lvl04`, 
			`lvl05`, 
			`lvl06`, 
			`family_id` 
			) VALUES (
			'".$lvl."', 
			'".$lvl."', 
			'".$lvl."', 
			'".$lvl."', 
			'".$lvl."', 
			'".$lvl."', 
			'".$family_id."' 
			);";
			$insertStatement = mysqli_prepare($KONN,$qu_inv_01_families_descs_ins);
			mysqli_stmt_execute($insertStatement);
			
			
			
			
			
			
			
			
			
			
			
			$return_arr[] = array(  "lvl01" => "", 
			"lvl02" => "", 
			"lvl03" => "", 
			"lvl04" => "", 
			"lvl05" => "", 
			"lvl06" => "", 
			"family_id" => $family_id
			);
			
			
			} else {
			$ARRAY_SRC = mysqli_fetch_assoc($q_exe);
			
			
			$return_arr[] = array(  "lvl01" => $ARRAY_SRC['lvl01'], 
			"lvl02" => $ARRAY_SRC['lvl02'], 
			"lvl03" => $ARRAY_SRC['lvl03'], 
			"lvl04" => $ARRAY_SRC['lvl04'], 
			"lvl05" => $ARRAY_SRC['lvl05'], 
			"lvl06" => $ARRAY_SRC['lvl06'], 
			"family_id" => $family_id 
			);
			
			
			
			
		}
		
		
		echo json_encode($return_arr);
		
		
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

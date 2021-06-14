<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		
		if( isset($_POST['lvl01']) && 
		isset($_POST['lvl02']) && 
		isset($_POST['lvl03']) && 
		isset($_POST['lvl04']) && 
		isset($_POST['lvl05']) && 
		isset($_POST['lvl06']) && 
		isset($_POST['family_id']) 
		){
			
			
			
			$lvl01 = test_inputs($_POST['lvl01']);
			$lvl02 = test_inputs($_POST['lvl02']);
			$lvl03 = test_inputs($_POST['lvl03']);
			$lvl04 = test_inputs($_POST['lvl04']);
			$lvl05 = test_inputs($_POST['lvl05']);
			$lvl06 = test_inputs($_POST['lvl06']);
			$family_id = test_inputs($_POST['family_id']);
			
			
			
			$qu_inv_01_families_descs_updt = "UPDATE  `inv_01_families_descs` SET 
			`lvl01` = '".$lvl01."', 
			`lvl02` = '".$lvl02."', 
			`lvl03` = '".$lvl03."', 
			`lvl04` = '".$lvl04."', 
			`lvl05` = '".$lvl05."', 
			`lvl06` = '".$lvl06."'
			WHERE `family_id` = $family_id;";
			$updateStatement = mysqli_prepare($KONN,$qu_inv_01_families_descs_updt);
			mysqli_stmt_execute($updateStatement);
			
			if( $family_id != 0 ){
				die('1|Family Updated');
			}
			
			
			
			
			
			
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

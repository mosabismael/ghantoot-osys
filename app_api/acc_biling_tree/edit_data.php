<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		if( isset($_POST['tree_name']) &&
		isset($_POST['tree_cats']) &&
		isset($_POST['tree_id']) ){
			
			
			
			$tree_id     = 0;
			$tree_name   = test_inputs($_POST['tree_name']);
			$tree_cats   = test_inputs($_POST['tree_cats']);
			$tree_id     = test_inputs($_POST['tree_id']);
			
			
			
			$qu_acc_biling_tree_updt = "UPDATE  `acc_biling_tree` SET `tree_name` = '".$tree_name."', `tree_cats` = '".$tree_cats."' WHERE `tree_id` = $tree_id;";
			$updateStatement = mysqli_prepare($KONN,$qu_acc_biling_tree_updt);
			mysqli_stmt_execute($updateStatement);
			if( $tree_id != 0 ){
				
				
				if( insert_state_change($KONN, "Data Edited", $tree_id, "acc_biling_tree", $EMPLOYEE_ID) ) {
					die("1|Tree Edited");
					} else {
					die('0|Data Status Error 65154');
				}
				
				
				
				
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

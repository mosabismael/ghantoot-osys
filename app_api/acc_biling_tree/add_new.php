<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		if( isset($_POST['tree_name']) && 
		isset($_POST['tree_cats']) ){
			
			
			
			$tree_id = 0;
			$tree_name = test_inputs($_POST['tree_name']);
			$tree_cats = test_inputs($_POST['tree_cats']);
			
			
			$qu_acc_biling_tree_sel = "SELECT * FROM  `acc_biling_tree` WHERE `tree_name` = '$tree_name' ";
			$userStatement = mysqli_prepare($KONN,$qu_acc_biling_tree_sel);
			mysqli_stmt_execute($userStatement);
			$qu_acc_biling_tree_EXE = mysqli_stmt_get_result($userStatement);
			$acc_biling_tree_DATA;
			if(mysqli_num_rows($qu_acc_biling_tree_EXE)){
				die("0|Tree Already Exist");
			}
			
			
			
			
			
			
			
			
			$qu_acc_biling_tree_ins = "INSERT INTO `acc_biling_tree` (
			`tree_name`, 
			`tree_cats`
			) VALUES (
			'".$tree_name."', 
			'".$tree_cats."'
			);";
			$insertStatement = mysqli_prepare($KONN,$qu_acc_biling_tree_ins);
			mysqli_stmt_execute($insertStatement);
			$tree_id = mysqli_insert_id($KONN);
			if( $tree_id != 0 ){
				
				
				if( insert_state_change($KONN, "New-TREE", $tree_id, "acc_biling_tree", $EMPLOYEE_ID) ) {
					die("1|Tree Added");
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

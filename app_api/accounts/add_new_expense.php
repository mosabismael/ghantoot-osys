<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	try{
		
		if( isset($_POST['expense_name']) &&
		isset($_POST['account_id']) 
		){
			
			
			$expense_description = "";
			if( isset($_POST['expense_description']) ){
				$expense_description = test_inputs( $_POST['expense_description'] );
			}
			
			
			$expense_id = 0;
			$expense_name = test_inputs($_POST['expense_name']);
			$account_id = test_inputs($_POST['account_id']);
			$date_added = date('Y-m-d h:i:00');
			$added_by = $EMPLOYEE_ID;
			
			$qu_acc_expenses_ins = "INSERT INTO `acc_expenses` (
			`expense_name`, 
			`expense_description`, 
			`account_id`, 
			`date_added`, 
			`added_by` 
			) VALUES (
			'".$expense_name."', 
			'".$expense_description."', 
			'".$account_id."', 
			'".$date_added."', 
			'".$added_by."' 
			);";
			$insertStatement = mysqli_prepare($KONN,$qu_acc_expenses_ins);
			
			mysqli_stmt_execute($insertStatement);
			
			$expense_id = mysqli_insert_id($KONN);
			if( $expense_id != 0 ){
				die('1|Expense Added');
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

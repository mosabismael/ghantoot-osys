<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		if( isset($_POST['created_date']) &&
		isset($_POST['disp_action_id']) &&
		isset($_POST['warning']) &&
		isset($_POST['deductions']) && 
		isset($_POST['memo']) && 
		isset($_POST['disp_act_status']) &&
		isset($_POST['employee_id']) 
		){
			
			$record_id = 0;
			$created_date = test_inputs($_POST['created_date']);
			$disp_action_id = test_inputs($_POST['disp_action_id']);
			$warning = test_inputs($_POST['warning']);
			$deductions = test_inputs($_POST['deductions']);
			
			$memo = test_inputs($_POST['memo']);
			$added_by = $EMPLOYEE_ID;
			$disp_act_status = test_inputs($_POST['disp_act_status']);
			$employee_id = test_inputs($_POST['employee_id']);
			
			$qu_hr_employees_disp_actions_ins = "INSERT INTO `hr_employees_disp_actions` (
			`created_date`, 
			`disp_action_id`, 
			`warning`, 
			`deductions`, 
			`memo`, 
			`added_by`, 
			`disp_act_status`, 
			`employee_id` 
			) VALUES (
			'".$created_date."', 
			'".$disp_action_id."', 
			'".$warning."', 
			'".$deductions."', 
			'".$memo."', 
			'".$added_by."', 
			'".$disp_act_status."', 
			'".$employee_id."' 
			);";
			$insertStatement = mysqli_prepare($KONN,$qu_hr_employees_disp_actions_ins);
			
			mysqli_stmt_execute($insertStatement);
			
			$record_id = mysqli_insert_id($KONN);
			if( $record_id != 0 ){
				if( insert_state_change($KONN, 'DA_added', $record_id, "hr_employees_disp_actions", $EMPLOYEE_ID) ){
					die("1|Data Added");
				}
			}
			} else {
			die("0|Data Error22".mysqli_error( $KONN ) );
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

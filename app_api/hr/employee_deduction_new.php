<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		if( isset($_POST['deduction_date']) &&
		isset($_POST['deduction_effective_date']) &&
		isset($_POST['deduction_amount']) &&
		isset($_POST['deduction_status']) &&
		isset($_POST['memo']) && 
		isset($_POST['employee_id']) 
		){
			
			$deduction_id = 0;
			$deduction_date = test_inputs($_POST['deduction_date']);
			$deduction_effective_date = test_inputs($_POST['deduction_effective_date']);
			$deduction_amount = test_inputs($_POST['deduction_amount']);
			$deduction_status = test_inputs($_POST['deduction_status']);
			$memo = test_inputs($_POST['memo']);
			
			$employee_id = test_inputs($_POST['employee_id']);
			
			$qu_hr_employees_deductions_ins = "INSERT INTO `hr_employees_deductions` (
			`deduction_date`, 
			`deduction_effective_date`, 
			`deduction_amount`, 
			`deduction_status`, 
			`memo`, 
			`employee_id` 
			) VALUES (
			'".$deduction_date."', 
			'".$deduction_effective_date."', 
			'".$deduction_amount."', 
			'".$deduction_status."', 
			'".$memo."', 
			'".$employee_id."' 
			);";
			$insertStatement = mysqli_prepare($KONN,$qu_hr_employees_deductions_ins);
			
			mysqli_stmt_execute($insertStatement);
			
			$deduction_id = mysqli_insert_id($KONN);
			if( $deduction_id != 0 ){
				if( insert_state_change($KONN, 'Deduction_added', $deduction_id, "hr_employees_deductions", $EMPLOYEE_ID) ){
					die("1|Data Added");
				}
			}
			} else {
			die("0|Data Error".mysqli_error( $KONN ));
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

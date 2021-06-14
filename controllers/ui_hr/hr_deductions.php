<?php
	require_once('../../bootstrap/app_config.php');
	require_once('../../bootstrap/chk_log_user.php');
	
	$IAM_ARRAY = array();
	
	
	$CUR_PAGE = 0;
	$per_page = 20;
	$totPages = 0;
	
	if( isset( $_POST['page'] ) ){
		$CUR_PAGE = ( int ) test_inputs( $_POST['page'] );
	}
	if( isset( $_POST['showperpage'] ) ){
		$per_page = ( int ) test_inputs( $_POST['showperpage'] );
	}
	
	$start=abs(($CUR_PAGE-1)*$per_page);
	
	
	
	
	
	
	
	$sNo = $start + 1;
	$qu_hr_employees_deductions_sel = "SELECT * FROM  `hr_employees_deductions` LIMIT $start,$per_page";
	
	
	$qu_hr_employees_deductions_EXE = mysqli_query($KONN, $qu_hr_employees_deductions_sel);
	if(mysqli_num_rows($qu_hr_employees_deductions_EXE)){
		while($hr_employees_deductions_REC = mysqli_fetch_assoc($qu_hr_employees_deductions_EXE)){
			
			$deduction_id = $hr_employees_deductions_REC['deduction_id'];
			$employee_id = $hr_employees_deductions_REC['employee_id'];
			$deduction_date = $hr_employees_deductions_REC['deduction_date'];
			$deduction_effective_date = $hr_employees_deductions_REC['deduction_effective_date'];
			$deduction_amount = $hr_employees_deductions_REC['deduction_amount'];
			
			$deduction_status = get_current_state($KONN, $deduction_id, "hr_employees_deductions" );
			
			$qu_hr_employees_sel = "SELECT * FROM  `hr_employees` WHERE `employee_id` = $employee_id";
			$qu_hr_employees_EXE = mysqli_query($KONN, $qu_hr_employees_sel);
			$hr_employees_DATA;
			if(mysqli_num_rows($qu_hr_employees_EXE)){
				$hr_employees_DATA = mysqli_fetch_assoc($qu_hr_employees_EXE);
			}
			
			$employee_code = $hr_employees_DATA['employee_code'];
			$first_name = $hr_employees_DATA['first_name'];
			$last_name = $hr_employees_DATA['last_name'];
			$join_date = $hr_employees_DATA['join_date'];
			
			
			
			$IAM_ARRAY[] = array(  "deduction_id" => $deduction_id, 
			"employee_id" => $employee_id,
			"employee_code" => $employee_code,
			"first_name" => $first_name, 
			"last_name" => $last_name, 
			"join_date" => $join_date, 
			"deduction_amount" => number_format($deduction_amount,3), 
			"deduction_status" => $deduction_status, 
			"deduction_effective_date" => $deduction_effective_date,
			"deduction_date"=>$deduction_date
			);
			
			$sNo++;
		}
		
	}
	echo json_encode($IAM_ARRAY);
	
?>






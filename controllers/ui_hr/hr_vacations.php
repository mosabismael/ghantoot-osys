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
	$qu_hr_employees_vacations_sel = "SELECT * FROM  `hr_employees_vacations` LIMIT $start,$per_page";


	$qu_hr_employees_vacations_EXE = mysqli_query($KONN, $qu_hr_employees_vacations_sel);
	if(mysqli_num_rows($qu_hr_employees_vacations_EXE)){
		while($hr_employees_vacations_REC = mysqli_fetch_assoc($qu_hr_employees_vacations_EXE)){
			
			$vacation_id = $hr_employees_vacations_REC['vacation_id'];
			$employee_id = $hr_employees_vacations_REC['employee_id'];
			
			$start_date = $hr_employees_vacations_REC['start_date'];
			$end_date = $hr_employees_vacations_REC['end_date'];
			
			
			$vacation_status = get_current_state($KONN, $vacation_id, "hr_employees_vacations" );
			
			
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
    
$IAM_ARRAY[] = array(  "vacation_id" => $vacation_id, 
						"employee_id" => $employee_id,
						"employee_code" => $employee_code,
						"first_name" => $first_name, 
						"last_name" => $last_name, 
						"start_date" => $start_date, 
						"end_date" => $end_date,
						"vacation_status" => $vacation_status
						);
						
		$sNo++;
		}
		
	}
	echo json_encode($IAM_ARRAY);
	
?>



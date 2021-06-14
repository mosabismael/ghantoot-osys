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
	
	
	
	
	$serchCond = "";
	if( isset( $_POST['cond'] ) ){
		$serchCond = $_POST['cond'];
	}
	
	
	
	
	$sNo = $start + 1;
	$qu_hr_employees_allowances_sel = "SELECT * FROM  `hr_employees_allowances` $serchCond LIMIT $start,$per_page";


	$qu_hr_employees_allowances_EXE = mysqli_query($KONN, $qu_hr_employees_allowances_sel);
	if(mysqli_num_rows($qu_hr_employees_allowances_EXE)){
		while($hr_employees_allowances_REC = mysqli_fetch_assoc($qu_hr_employees_allowances_EXE)){
			
			
			
			
			$record_id = $hr_employees_allowances_REC['record_id'];
			$employee_id = $hr_employees_allowances_REC['employee_id'];
			$allowance_id = $hr_employees_allowances_REC['allowance_id'];
			$allowance_type = $hr_employees_allowances_REC['allowance_type'];
			$allowance_amount = $hr_employees_allowances_REC['allowance_amount'];
			$allowance_amount = $hr_employees_allowances_REC['allowance_amount'];
			
			$active_from = $hr_employees_allowances_REC['active_from'];
			$active_to = $hr_employees_allowances_REC['active_to'];
			
			
			//$allowance_status = get_current_state($KONN, $record_id, "hr_employees_allowances" );
			
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


	$qu_hr_employees_allowances_ids_sel = "SELECT * FROM  `hr_employees_allowances_ids` WHERE `allowance_id` = $allowance_id";
	$qu_hr_employees_allowances_ids_EXE = mysqli_query($KONN, $qu_hr_employees_allowances_ids_sel);
	$hr_employees_allowances_ids_DATA;
	if(mysqli_num_rows($qu_hr_employees_allowances_ids_EXE)){
		$hr_employees_allowances_ids_DATA = mysqli_fetch_assoc($qu_hr_employees_allowances_ids_EXE);
	}
	
		$allowance_title = $hr_employees_allowances_ids_DATA['allowance_title'];
		$allowance_description = $hr_employees_allowances_ids_DATA['allowance_description'];
	
    
$IAM_ARRAY[] = array(  "record_id" => $record_id, 
						"employee_id" => $employee_id,
						"employee_code" => $employee_code,
						"first_name" => $first_name, 
						"last_name" => $last_name, 
						"join_date" => $join_date, 
						"allowance_title" => $allowance_title, 
						"allowance_type" => $allowance_type, 
						"allowance_amount" => number_format($allowance_amount, 3), 
						"active_from" => $active_from, 
						"active_to" => $active_to
						);
						
		$sNo++;
		}
		
	}
	echo json_encode($IAM_ARRAY);
	
?>


		
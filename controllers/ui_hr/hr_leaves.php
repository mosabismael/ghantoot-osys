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
	$qu_hr_employees_leaves_sel = "SELECT * FROM  `hr_employees_leaves` $serchCond LIMIT $start,$per_page";
	
	$qu_hr_employees_leaves_EXE = mysqli_query($KONN, $qu_hr_employees_leaves_sel);
	if(mysqli_num_rows($qu_hr_employees_leaves_EXE)){
		while($hr_employees_leaves_REC = mysqli_fetch_assoc($qu_hr_employees_leaves_EXE)){
			
			$leave_id = $hr_employees_leaves_REC['leave_id'];
			$employee_id = $hr_employees_leaves_REC['employee_id'];
			$leave_type_id = $hr_employees_leaves_REC['leave_type_id'];
			$start_date = $hr_employees_leaves_REC['start_date'];
			$end_date = $hr_employees_leaves_REC['end_date'];
			
			$leave_status = get_current_state($KONN, $leave_id, "hr_employees_leaves" );

			
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


	$qu_hr_employees_leave_types_sel = "SELECT * FROM  `hr_employees_leave_types` WHERE `leave_type_id` = $leave_type_id";
	$qu_hr_employees_leave_types_EXE = mysqli_query($KONN, $qu_hr_employees_leave_types_sel);
	$hr_employees_leave_types_DATA;
	if(mysqli_num_rows($qu_hr_employees_leave_types_EXE)){
		$hr_employees_leave_types_DATA = mysqli_fetch_assoc($qu_hr_employees_leave_types_EXE);
	}
	
		$leave_type_name = $hr_employees_leave_types_DATA['leave_type_name'];
	
    
$IAM_ARRAY[] = array(  "leave_id" => $leave_id, 
						"employee_id" => $employee_id,
						"employee_code" => $employee_code,
						"first_name" => $first_name, 
						"last_name" => $last_name, 
						"start_date" => $start_date, 
						"end_date" => $end_date, 
						"leave_type_name" => $leave_type_name, 
						"leave_status" => $leave_status
						);
						
		$sNo++;
		}
		
	}
	echo json_encode($IAM_ARRAY);
	
?>



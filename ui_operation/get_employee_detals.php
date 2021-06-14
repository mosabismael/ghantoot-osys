<?php
	
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	
	$IAM_ARRAY  = array();
	if(isset($_GET['emp_type'])){
		$emp_type = $_GET['emp_type'];
	}
	$employee_id = 0;
	if(isset($_GET['employee_id'])){
		$employee_id = $_GET['employee_id'];
	}
	
	$qu_FETCH_sel = "SELECT `employee_id`,`first_name`, `second_name`, `third_name`, employee_code FROM  `hr_employees` where employee_type = '$emp_type'";
	$qu_FETCH_EXE = mysqli_query($KONN, $qu_FETCH_sel);
	if(mysqli_num_rows($qu_FETCH_EXE)){
		while($fetched_DT = mysqli_fetch_array($qu_FETCH_EXE)){
			$job_order_idDT = $fetched_DT[0];
			
			$SEL = "";
			if( $employee_id == $job_order_idDT ){
				$SEL = "selected";
			}
		$IAM_ARRAY[] = array(  "emp_id" => $fetched_DT[0], 
			"SEL" => $SEL, 
			"first_name" => $fetched_DT[1], 
			"second_name" => str_replace('undefined',"",$fetched_DT[2]), 
			"third_name" => str_replace('undefined',"",$fetched_DT[3]),
			"employee_code" => $fetched_DT[4]
			);
			
		}
	}
	echo json_encode($IAM_ARRAY);
?>
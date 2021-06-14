
<?php
	require_once('../../bootstrap/app_config.php');
	require_once('../../bootstrap/chk_log_user.php');
	
	$IAM_ARRAY = array();
	
	
	$CUR_PAGE = 0;
	$per_page = 20;
	$totPages = 0;
	
	$cond = "";
	if( isset( $_POST['cond'] ) ){
		$cond = $_POST['cond'] ;
	}
	if( isset( $_POST['page'] ) ){
		$CUR_PAGE = ( int ) test_inputs( $_POST['page'] );
	}
	if( isset( $_POST['showperpage'] ) ){
		$per_page = ( int ) test_inputs( $_POST['showperpage'] );
	}
	
	$start=abs(($CUR_PAGE-1)*$per_page);
	
	
	
	
	
	
	
	$sNo = $start + 1;
	$qu_hr_employees_sel = "SELECT * FROM  `hr_employees` WHERE ( ( `employee_type` = 'local' ) $cond )  ORDER BY `first_name` ASC, `last_name` ASC LIMIT $start,$per_page";


	$qu_hr_employees_EXE = mysqli_query($KONN, $qu_hr_employees_sel);
	if(mysqli_num_rows($qu_hr_employees_EXE)){
		while($hr_employees_REC = mysqli_fetch_assoc($qu_hr_employees_EXE)){
		
		$country_id = $hr_employees_REC["nationality_id"];
		$department_id = $hr_employees_REC["department_id"];
		$designation_id = $hr_employees_REC["designation_id"];
		$employee_type = $hr_employees_REC["employee_type"];
		$country_name = "";
		$department_name = "";
		$designation_name = "";
		
		$qu_gen_countries_sel = "SELECT * FROM  `gen_countries` WHERE `country_id` = $country_id";
		$qu_gen_countries_EXE = mysqli_query($KONN, $qu_gen_countries_sel);
		$gen_countries_DATA;
		if(mysqli_num_rows($qu_gen_countries_EXE)){
			$gen_countries_DATA = mysqli_fetch_assoc($qu_gen_countries_EXE);
			$country_name = $gen_countries_DATA['country_name'];
		}

		$qu_hr_departments_sel = "SELECT * FROM  `hr_departments` WHERE `department_id` = $department_id";
		$qu_hr_departments_EXE = mysqli_query($KONN, $qu_hr_departments_sel);
		$hr_departments_DATA;
		if(mysqli_num_rows($qu_hr_departments_EXE)){
			$hr_departments_DATA = mysqli_fetch_assoc($qu_hr_departments_EXE);
			$department_name = $hr_departments_DATA['department_name'];
		}

		$qu_hr_departments_designations_sel = "SELECT * FROM  `hr_departments_designations` WHERE `designation_id` = $designation_id";
		$qu_hr_departments_designations_EXE = mysqli_query($KONN, $qu_hr_departments_designations_sel);
		$hr_departments_designations_DATA;
		if(mysqli_num_rows($qu_hr_departments_designations_EXE)){
			$hr_departments_designations_DATA = mysqli_fetch_assoc($qu_hr_departments_designations_EXE);
			$designation_name = $hr_departments_designations_DATA['designation_name'];
		}
	
$IAM_ARRAY[] = array(  "sNo" => $sNo,
						"join_date" => $hr_employees_REC["join_date"], 
						"employee_id" => $hr_employees_REC["employee_id"],
						"employee_code" => $hr_employees_REC["employee_code"],
						"first_name" => $hr_employees_REC["first_name"], 
						"last_name" => $hr_employees_REC["last_name"], 
						"country_name" => $country_name, 
						"department_name" => $department_name, 
						"designation_name" => $designation_name, 
						"employee_type" => $employee_type
						);
						
		$sNo++;
		}
		
	}
	echo json_encode($IAM_ARRAY);
	
?>






		

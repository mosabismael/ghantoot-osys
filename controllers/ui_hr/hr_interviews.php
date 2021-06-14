<?php
	require_once('../../bootstrap/app_config.php');
	require_once('../../bootstrap/chk_log_user.php');
	
	$IAM_ARRAY = array();
	
	
	$CUR_PAGE = 0;
	$per_page = 20;
	$totPages = 0;
	
	$cond = "";
	if( isset( $_POST['cond'] ) ){
		$cond =  $_POST['cond'] ;
	}
	
	if( isset( $_POST['page'] ) ){
		$CUR_PAGE = ( int ) test_inputs( $_POST['page'] );
	}
	if( isset( $_POST['showperpage'] ) ){
		$per_page = ( int ) test_inputs( $_POST['showperpage'] );
	}
	
	$start=abs(($CUR_PAGE-1)*$per_page);
	
	
	
	
	
	
	
	$sNo = $start + 1;
	$qu_hr_interviews_sel = "SELECT * FROM  `hr_interviews` $cond LIMIT $start,$per_page";


	$qu_hr_interviews_EXE = mysqli_query($KONN, $qu_hr_interviews_sel);
	if(mysqli_num_rows($qu_hr_interviews_EXE)){
		while($hr_interviews_REC = mysqli_fetch_assoc($qu_hr_interviews_EXE)){
			
			$interview_id = $hr_interviews_REC['interview_id'];
			$candidate_name = $hr_interviews_REC['candidate_name'];
			$candidate_age = $hr_interviews_REC['candidate_age'];
			$candidate_gender = $hr_interviews_REC['candidate_gender'];
			$candidate_nationality = $hr_interviews_REC['candidate_nationality'];
			$candidate_religion = $hr_interviews_REC['candidate_religion'];
			$candidate_education = $hr_interviews_REC['candidate_education'];
			$candidate_last_employer = $hr_interviews_REC['candidate_last_employer'];
			$candidate_last_salary = $hr_interviews_REC['candidate_last_salary'];
			$candidate_last_designation = $hr_interviews_REC['candidate_last_designation'];
			$job_title = $hr_interviews_REC['job_title'];
			$total_experience = $hr_interviews_REC['total_experience'];
			$notice_period = $hr_interviews_REC['notice_period'];
			$created_date = $hr_interviews_REC['created_date'];
			$created_by = $hr_interviews_REC['created_by'];
			
	$qu_hr_employees_sel = "SELECT * FROM  `hr_employees` WHERE `employee_id` = $created_by";
	$qu_hr_employees_EXE = mysqli_query($KONN, $qu_hr_employees_sel);
	$NAMER = "";
	if(mysqli_num_rows($qu_hr_employees_EXE)){
		$hr_employees_DATA = mysqli_fetch_assoc($qu_hr_employees_EXE);
		$NAMER = $hr_employees_DATA['first_name'].' '.$hr_employees_DATA['last_name'];
	}
	
$IAM_ARRAY[] = array(  "interview_id" => $interview_id,
						"NAMER" => $NAMER, 
						"created_date" => $created_date, 
						"candidate_name" => $candidate_name
						);
						
		$sNo++;
		}
		
	}
	echo json_encode($IAM_ARRAY);
	
?>




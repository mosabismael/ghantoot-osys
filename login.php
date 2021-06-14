<?php

	require_once('bootstrap/app_config.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	$page_id = 100;
	
	$RES = "";
	$IAM_ARRAY = array();
	if( isset( $_POST['ad_n'] ) && isset( $_POST['ad_p'] ) ){
		
		$name = test_inputs( $_POST['ad_n'] );
		$pass = md5( test_inputs( $_POST['ad_p'] ) );
		$ths_date = date("Y-m-d");
		
			$qu_users_sel = "SELECT * FROM  `users` WHERE `email` = '$name' 
			AND `password` = '$pass' AND `status` = 'active'  ";
			
			
			$qu_users_EXE = mysqli_query($KONN, $qu_users_sel);
			$users_DATA;
			if(mysqli_num_rows($qu_users_EXE) == 1 ){
				$users_DATA = mysqli_fetch_assoc($qu_users_EXE);
				$user_id = $users_DATA['user_id'];
				$email = $users_DATA['email'];
				$dept_code = $users_DATA['dept_code'];
				$level = $users_DATA['level'];
				$employee_id = $users_DATA['employee_id'];
				
				$first_name = "";
				$last_name = "";
				$profile_pic = 'no-pic.jpg';
				$designation_id = 0;
				$department_id = 0;
				
				
				
				if( $employee_id != 0 ){
					$qu_hr_employees_sel = "SELECT * FROM  `hr_employees` 
											WHERE `employee_id` = $employee_id";
					$qu_hr_employees_EXE = mysqli_query($KONN, $qu_hr_employees_sel);
					$hr_employees_DATA;
					if(mysqli_num_rows($qu_hr_employees_EXE)){
						$hr_employees_DATA = mysqli_fetch_assoc($qu_hr_employees_EXE);
						$first_name = $hr_employees_DATA['first_name'];
						$last_name = $hr_employees_DATA['last_name'];
						$profile_pic = $hr_employees_DATA['profile_pic'];
						$designation_id = $hr_employees_DATA['designation_id'];
						$department_id = $hr_employees_DATA['department_id'];
						
						
						
						
						$IAM_ARRAY[] = array(  
						"status" => "success",
						"level" => $level, 
						"dept_code" => $dept_code,
						"email" => $email,
						"user_id" => $user_id, 
						"user_name" =>  $first_name.' '.$last_name, 
						"employee_id" => $employee_id, 
						"profile_pic" => $profile_pic, 
						"designation_id" => $designation_id, 
						"department_id" => $department_id,
						"message" => ""
						);
						
					} else {
						$IAM_ARRAY[] = array(  
						"status" => "failure",
						"message" => "Wrong Username Or Password"
						);
						
					}
					
				} else {
					$IAM_ARRAY[] = array(  
						"status" => "failure",
						"message" => "Wrong Username Or Password"
						);
				}

				
				
				
				
				
				
				
				
				
				
				
				
				
				
			} else {
				$IAM_ARRAY[] = array(  
						"status" => "failure",
						"message" => "Wrong Username Or Password"
						);
			}
			
		
		
		
		
		
	}
	echo json_encode($IAM_ARRAY);

?>
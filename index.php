<?php

	require_once('bootstrap/app_config.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	$page_id = 100;
	
	$RES = "";
	
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
						
						
						$GOTO = "ui_".$level."/index.php";
						session_start();
						$_SESSION['level'] = $level;
						$_SESSION['dept_code'] = $dept_code;
						$_SESSION['email'] = $email;
						$_SESSION['user_id'] = $user_id;
						$_SESSION['user_name'] = $first_name.' '.$last_name;
						$_SESSION['user_id'] = $user_id;
						
						$_SESSION['employee_id'] = $employee_id;
						$_SESSION['profile_pic'] = $profile_pic;
						$_SESSION['designation_id'] = $designation_id;
						$_SESSION['department_id'] = $department_id;
						
						
						header("location:".$GOTO);
						die();
						
					} else {
						$RES = "Wrong Username Or Password";
					}
					
				} else {
					$RES = "Wrong Username Or Password";
				}

				
				
				
				
				
				
				
				
				
				
				
				
				
				
			} else {
				$RES = "Wrong Username Or Password";
			}
			
		
		
		
		
		
	}
	

?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<html>
<head>

<style>



body {
	width:100%;
	margin:0 auto;
	min-width: 500px;
	max-width: 3500px;
	font-size:100%;
    font-family: 'calibri', sans-serif;
	overflow-x: hidden !important;
  background-color: #eaf1f6;
  overflow-y: hidden;
}

* {
	margin:0;
	padding:0;
}
.zero {
  float: none;
  clear: both;
}
*,
*::before,
*::after {
  box-sizing: inherit;
}
* {
  transition: all 0.3s ease-in-out;
}


.loginPanelBox {
  width: 25%;
  height: 70%;
  margin: 0 auto;
  background: rgba(255,255,255,0.6);
  border-radius: 6px;
  box-shadow: var(--boxShadow);
  position: absolute;
  top: 10%;
  right: 5%;
  overflow: hidden !important;
}

.loginPanelLogo {
  width: 100%;
  padding: 5% 0%;
  display: inline-block;
  vertical-align: middle;
  text-align: center;
  background: #FFFFFF;
}
.loginPanelLogo img {
	width: 50%;
}
.loginPanelForm {
  width: 90%;
  margin:  2% auto;
  display: block;
  vertical-align: middle;
  text-align: center;
  margin-top: 5%;
}
.loginPanelFormElem {
  width: 95%;
  margin: 5% auto;
}
.loginPanelFormElem label {
  text-align: left;
  display: block;
  margin: 1% auto;
  
}
.loginPanelFormElem input {
  width: 96%;
  margin: 1% auto;
  padding: 3% 1%;
  border: 1px solid rgba(0,0,0,0.3);
  border-radius: 3px;
  background: rgba(0,0,0,0.1);
}

.loginPanelFormElem button {
  width: 96%;
  margin: 1% auto;
  padding: 3% 1%;
  border: 1px solid rgba(0,0,0,0.3);
  border-radius: 3px;
  background: #0ccbff;
}







#myVideo {
  position: fixed;
  right: 0;
  bottom: 0;
  min-width: 100%;
  min-height: 100%;
}
</style>

</head>

<body>

<video autoplay muted loop id="myVideo">
  <source src="login_vid.mp4" type="video/mp4">
</video>


	<br>
	<br>

	<div class="loginPanelBox">
		<div class="loginPanelLogo">
			<img src="uploads/logo_hor.png">
		</div>
		<form method="POST" class="loginPanelForm">
			<div class="loginPanelFormElem">
				<label>Username :</label>
				<input type="email" name="ad_n" required>
			</div>
			<div class="loginPanelFormElem">
				<label>Password :</label>
				<input type="password" name="ad_p" required>
			</div>
			<div class="loginPanelFormElem" style="color:red;">
				<label><?=$RES; ?></label>
			</div>
			<div class="loginPanelFormElem ">
				<button type="submit" class="btn btn-danger">Log In</button>
			</div>
		</form>
		<div class="zero"></div>
	</div>

	<div class="zero"></div>




	<br>

</body>
</html>
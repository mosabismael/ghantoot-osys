<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	
	$flag = 0;
	if(isset($_REQUEST["term"]) && strlen($_REQUEST["term"]) >0){
		$search_option = $_REQUEST['searchoption'];
		
		
		
		//-------------------GET MY REQs-----------------
		$sql = "SELECT `$search_option` FROM `hr_employees`  WHERE (  (`$search_option` LIKE ? )  ) group by $search_option";
		
		if($search_option == 'employee_id'){
			$sql = "SELECT * FROM  `hr_employees` typ  WHERE ( (typ.employee_id LIKE ? OR typ.employee_code LIKE ? )  ) group by typ.$search_option";
		}
		if($search_option == 'first_name'){
			$sql = "SELECT * FROM  `hr_employees` typ  WHERE ( ( typ.first_name LIKE ? OR typ.last_name LIKE ? )   ) group by typ.$search_option";
		}
		if($search_option == 'nationality_id'){
			$sql = "SELECT * FROM  hr_employees typ , gen_countries con   WHERE ( ( con.country_name LIKE ?  ) AND con.country_id = typ.nationality_id  ) group by typ.$search_option";
		}
		if($search_option == 'department_id'){
			$sql = "SELECT * FROM  hr_employees typ , hr_departments dept  WHERE ( ( dept.department_name LIKE ?  ) AND typ.department_id = dept.department_id   ) group by typ.$search_option";
		}
		if($search_option == 'designation_id'){
			$sql = "SELECT * FROM  hr_employees typ , hr_departments dept , hr_departments_designations des WHERE ( ( des.designation_name LIKE ?) AND  typ.designation_id = des.designation_id   ) group by typ.$search_option";
		}
		
		if($stmt = mysqli_prepare($KONN, $sql)){
			// Bind variables to the prepared statement as parameters
			if($search_option == 'first_name'){
			mysqli_stmt_bind_param($stmt, "ss", $param_term , $param_term );
			}
			else if($search_option == 'employee_id'){
			mysqli_stmt_bind_param($stmt, "ss", $param_term , $param_term);
				
			}
			else{
			mysqli_stmt_bind_param($stmt, "s", $param_term);
			}
			// Set parameters
			$param_term = '%' . $_REQUEST["term"] . '%';
			
			// Attempt to execute the prepared statement
			if(mysqli_stmt_execute($stmt)){
				$result = mysqli_stmt_get_result($stmt);
				// Check number of rows in the result set
				if(mysqli_num_rows($result) > 0){
					// Fetch result rows as an associative array
					while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
						if($search_option == 'first_name'){
							echo "<a href='hr_employees.php?search=".$search_option."&value=".$row["$search_option"]."'>" .   $row["first_name"] . " " . $row["last_name"]. "</a>";
						}
						else if($search_option == 'employee_id'){
							echo "<a href='hr_employees.php?search=".$search_option."&value=".$row["$search_option"]."'>" .  $row["employee_id"]. " - " . $row["employee_code"] . "</a>";
						}
						else if($search_option == 'department_id'){
							echo "<a href='hr_employees.php?search=".$search_option."&value=".$row["$search_option"]."'>" .  $row["department_name"]  .  "</a>";
						}
						else if($search_option == 'nationality_id'){
							echo "<a href='hr_employees.php?search=".$search_option."&value=".$row["$search_option"]."'>" .  $row["country_name"]  .  "</a>";
						}
						else if($search_option == 'designation_id'){
							echo "<a href='hr_employees.php?search=".$search_option."&value=".$row["$search_option"]."'>" .   $row["designation_name"] .  "</a>";
						}
						else{
							echo "<a href='hr_employees.php?search=".$search_option."&value=".$row["$search_option"]."'>" . $row["$search_option"] . "</a>";
							
						}
						$flag = 1;
					}
				}
				} else{
				echo "ERROR: Could not able to execute $sql. " . mysqli_error($KONN);
			}
		}
		
		//-----------------------------------------
		
		
	}
	if($flag ==0 ){
		echo "No match found";
	}
	
	
	?>	
<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	
	$flag = 0;
	if(isset($_REQUEST["term"]) && strlen($_REQUEST["term"]) >0){
		$search_option = $_REQUEST['searchoption'];
		
		
		
		//-------------------GET MY REQs-----------------
		$sql = "SELECT `$search_option` FROM `hr_employees_allowances`  WHERE (  (`$search_option` LIKE ? )  ) group by $search_option";
		
		if($search_option == 'allowance_id'){
			$sql = "SELECT * FROM `hr_employees_allowances` leav, `hr_employees_allowances_ids` typ  WHERE ( (typ.allowance_title LIKE ? )  AND(leav.allowance_id = typ.allowance_id  )  ) group by typ.$search_option";
		}
		if($search_option == 'employee_id'){
			$sql = "SELECT * FROM `hr_employees_allowances` leav, `hr_employees` typ  WHERE ( (typ.employee_code LIKE ? OR typ.first_name LIKE ? OR typ.last_name LIKE ? )  AND(leav.employee_id = typ.employee_id  )  ) group by typ.$search_option";
		}
		
		if($stmt = mysqli_prepare($KONN, $sql)){
			// Bind variables to the prepared statement as parameters
			if($search_option == 'employee_id'){
			mysqli_stmt_bind_param($stmt, "sss", $param_term , $param_term, $param_term);
				
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
						if($search_option == 'employee_id'){
							echo "<a href='hr_allowances.php?search=".$search_option."&value=".$row["$search_option"]."'>" .  $row["employee_code"] . " ". $row["first_name"] . " " . $row["last_name"]. "</a>";
						}
						else if($search_option == 'allowance_id'){
							echo "<a href='hr_allowances.php?search=".$search_option."&value=".$row["$search_option"]."'>" .  $row["allowance_title"] . "</a>";
						}
						else{
							echo "<a href='hr_allowances.php?search=".$search_option."&value=".$row["$search_option"]."'>" . $row["$search_option"] . "</a>";
							
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
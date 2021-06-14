<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	
	$flag = 0;
	if(isset($_REQUEST["term"]) && strlen($_REQUEST["term"]) >0){
		$search_option = $_REQUEST['searchoption'];
		
		
		
		//-------------------GET MY REQs-----------------
		$sql = "SELECT `$search_option` FROM `pur_requisitions`  WHERE ( (`requisition_status` <> 'deleted') AND (`$search_option` LIKE ? ) AND (`ordered_by` = '$EMPLOYEE_ID') ) AND `requisition_status` = 'archive' group by $search_option";
		
		if($search_option == 'job_order_id'){
			$sql = "SELECT * FROM `pur_requisitions` req, `job_orders` job  WHERE ( (`requisition_status` <> 'deleted') AND  ((job.job_order_ref LIKE ?) OR (job.project_name LIKE ?)) AND `requisition_status` = 'archive' AND(req.job_order_id = job.job_order_id  ) AND (`ordered_by` = '$EMPLOYEE_ID') ) group by job.$search_option";
		}
		
		
		
		if($stmt = mysqli_prepare($KONN, $sql)){
			// Bind variables to the prepared statement as parameters
			if($search_option == 'job_order_id'){
				mysqli_stmt_bind_param($stmt, "ss", $param_term, $param_term);
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
							if($search_option == 'job_order_id'){
								echo "<a href='requisitions_draft.php?search=".$search_option."&value=".$row["$search_option"]."'>" . $row["job_order_ref"] . " " . $row["project_name"] . "</a>";
							}
							else{
								echo "<a href='requisitions_draft.php?search=".$search_option."&value=".$row["$search_option"]."'>" . $row["$search_option"] . "</a>";
							
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
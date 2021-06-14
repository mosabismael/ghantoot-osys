<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	
	$flag = 0;
	if(isset($_REQUEST["term"]) && strlen($_REQUEST["term"]) >0){
		$search_option = $_REQUEST['searchoption'];
		
		
		
		//-------------------GET MY REQs-----------------
		$sql = "SELECT `$search_option` FROM `inv_stock`  WHERE (  (`$search_option` LIKE ? )  ) AND `stock_status` = 'rejected' group by $search_option";
		
		if($search_option == 'supplier_id'){
			$sql = "SELECT * FROM `inv_stock` req, `suppliers_list` job  WHERE (  ((job.supplier_name LIKE ?) ) AND `stock_status` = 'rejected' AND(req.supplier_id = job.supplier_id  )  ) group by job.$search_option";
		}
		if($search_option == 'po_id'){
			$sql = "SELECT * FROM `inv_stock` req, `purchase_orders` job  WHERE (  ((job.po_ref LIKE ?) ) AND `stock_status` = 'rejected' AND(req.po_id = job.po_id  )  ) group by job.$search_option";
		}
		
		
		if($stmt = mysqli_prepare($KONN, $sql)){
			// Bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmt, "s", $param_term);
			
			// Set parameters
			$param_term = '%' . $_REQUEST["term"] . '%';
			
			// Attempt to execute the prepared statement
			if(mysqli_stmt_execute($stmt)){
				$result = mysqli_stmt_get_result($stmt);
				// Check number of rows in the result set
				if(mysqli_num_rows($result) > 0){
					// Fetch result rows as an associative array
					while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
							if($search_option == 'supplier_id'){
								echo "<a href='stock_rejected_materials.php?search=".$search_option."&value=".$row["$search_option"]."'>" . $row["supplier_name"]  . "</a>";
							}
							else if($search_option == 'po_id'){
								echo "<a href='stock_rejected_materials.php?search=".$search_option."&value=".$row["$search_option"]."'>" . $row["po_ref"]  . "</a>";
							}
							else{
								echo "<a href='stock_rejected_materials.php?search=".$search_option."&value=".$row["$search_option"]."'>" . $row["$search_option"] . "</a>";
							
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
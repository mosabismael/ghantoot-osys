<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	
	$flag = 0;
	if(isset($_REQUEST["term"]) && strlen($_REQUEST["term"]) >0){
		$search_option = $_REQUEST['searchoption'];
		
		
		
		//-------------------GET MY REQs-----------------
		$sql = "SELECT $search_option FROM  `purchase_orders`  WHERE ( (( `po_status` = 'pending_acc_approval' ) OR (`po_status` = 'pending_approval')  OR (`po_status` = 'activated')  OR (`po_status` = 'pending_man') ) AND (`po_status` <> 'draft') AND (`$search_option` LIKE ? ) ) group by $search_option";
		
		if($search_option == 'supplier_id'){
			$sql = "SELECT * FROM  `purchase_orders` pur , suppliers_list sup  WHERE ( (( `po_status` = 'pending_acc_approval' ) OR (`po_status` = 'pending_approval')  OR (`po_status` = 'activated')  OR (`po_status` = 'pending_man') ) AND (sup.supplier_code LIKE ? or sup.supplier_name LIKE ?) and  (`po_status` <> 'draft') AND (pur.supplier_id = sup.supplier_id ) ) group by sup.$search_option";
		}	
		if($search_option == 'requisition_id'){
			$sql = "SELECT * FROM  `purchase_orders` pur , pur_requisitions req  WHERE ( (( `po_status` = 'pending_acc_approval' ) OR (`po_status` = 'pending_approval')  OR (`po_status` = 'activated')  OR (`po_status` = 'pending_man') ) AND (req.requisition_ref LIKE ? ) and  (`po_status` <> 'draft') AND (req.requisition_id = pur.requisition_id ) ) group by req.$search_option";
		}
		if($search_option == 'job_order_id'){
			$sql = "SELECT * FROM  `purchase_orders` pur , job_orders job  WHERE ( (( `po_status` = 'pending_acc_approval' ) OR (`po_status` = 'pending_approval')  OR (`po_status` = 'activated')  OR (`po_status` = 'pending_man') ) AND (job.job_order_ref LIKE ? ) and  (`po_status` <> 'draft') AND (job.job_order_id = pur.job_order_id ) ) group by job.$search_option";
		}
		
		if($stmt = mysqli_prepare($KONN, $sql)){
			// Bind variables to the prepared statement as parameters
			if($search_option == 'supplier_id'){
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
						if($search_option == 'supplier_id'){
							echo "<a href='purchase_orders_pending_approval.php?search=".$search_option."&value=".$row["$search_option"]."'>" . $row["supplier_code"] ." ". $row["supplier_name"]. "</a>";
						}
						else if($search_option == 'requisition_id'){
							echo "<a href='purchase_orders_pending_approval.php?search=".$search_option."&value=".$row["$search_option"]."'>" . $row["requisition_ref"]. "</a>";
						}
						else if($search_option == 'job_order_id'){
							echo "<a href='purchase_orders_pending_approval.php?search=".$search_option."&value=".$row["$search_option"]."'>" . $row["job_order_ref"]. "</a>";
						}
						else{
							echo "<a href='purchase_orders_pending_approval.php?search=".$search_option."&value=".$row["$search_option"]."'>" . $row["$search_option"] . "</a>";
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


		
<?php
		$OFFSET = 0;
	if(isset($_POST["offset"])){
			$OFFSET = $_POST["offset"];
	}
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/app_db.php');


	$IAM_ARRAY;
				$sNo = $OFFSET ;
				$qu_pur_requisitions_sel = "SELECT * FROM  `pur_requisitions` ORDER BY `requisition_id` DESC limit 10 OFFSET $OFFSET" ;
				$newobj ;
				$qu_pur_requisitions_EXE = mysqli_query($KONN, $qu_pur_requisitions_sel);
				if(mysqli_num_rows($qu_pur_requisitions_EXE)){
				while($pur_requisitions_REC = mysqli_fetch_assoc($qu_pur_requisitions_EXE)){
					$sNo++;
					$requisition_id = $pur_requisitions_REC['requisition_id'];
					$requisition_ref = $pur_requisitions_REC['requisition_ref'];
					$requisition_type = $pur_requisitions_REC['requisition_type'];
					$requisition_status = $pur_requisitions_REC['requisition_status'];
					$requisition_notes = $pur_requisitions_REC['requisition_notes'];
					$ordered_by = $pur_requisitions_REC['ordered_by'];
					$created_date = $pur_requisitions_REC['created_date'];
					
					$BY = get_emp_name($KONN, $ordered_by );
					$job_order_id = $pur_requisitions_REC['job_order_id'];
					$project = "";
					if( $job_order_id != 0 ){
						$qu_job_orders_sel = "SELECT * FROM  `job_orders` WHERE `job_order_id` = $job_order_id";
						$qu_job_orders_EXE = mysqli_query($KONN, $qu_job_orders_sel);
						$job_orders_DATA;
						if(mysqli_num_rows($qu_job_orders_EXE)){
							$job_orders_DATA = mysqli_fetch_assoc($qu_job_orders_EXE);
						}
						$job_order_ref = $job_orders_DATA['job_order_ref'];
						$project_name = $job_orders_DATA['project_name'];
						
						$project = $job_order_ref.' - '.$project_name;
						
					}
					
$IAM_ARRAY[] = array(  "sno" => $sNo, 
					"requisition_id" => $pur_requisitions_REC['requisition_id'], 
					"requisition_ref" => $pur_requisitions_REC['requisition_ref'], 
					"created_date" => $pur_requisitions_REC['created_date'], 
					"project" => $project, 
					"BY" => $BY, 
					"requisition_status" => $pur_requisitions_REC['requisition_status']
					);
					
								}

							}
							echo json_encode($IAM_ARRAY);
						?>
				

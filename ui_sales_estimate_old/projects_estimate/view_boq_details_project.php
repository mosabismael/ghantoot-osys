<?php
	require_once('../../bootstrap/app_config.php');
	require_once('../../bootstrap/chk_log_user.php');
	if(isset($_GET['project_id'])){
		$project_id = $_GET['project_id'];
	}
	$IAM_ARRAY = array();
	
	$qu_boq_sel = "SELECT * from z_boq boq , z_project_level1 level1 where boq.level1_id = level1.level1_id and level1.project_id = $project_id";
	$qu_boq_EXE = mysqli_query($KONN, $qu_boq_sel);
	$no = 0;
	if(mysqli_num_rows($qu_boq_EXE)){
		while($project_level1_REC = mysqli_fetch_assoc($qu_boq_EXE)){
			$boq_id = $project_level1_REC['boq_id'];
			
			
			$qu_project_level1_sel = "SELECT * FROM  `z_boq_details` boq , z_items_units iu  WHERE `boq_id` = $boq_id and boq.type_id = iu.unit_id" ;
			$qu_project_level1_EXE = mysqli_query($KONN, $qu_project_level1_sel);
			
			if(mysqli_num_rows($qu_project_level1_EXE)){
				while($project_level1_REC = mysqli_fetch_assoc($qu_project_level1_EXE)){
					$no++;
					$boq_detail_id = $project_level1_REC['boq_detail_id'];
					$boq_name = $project_level1_REC['boq_name'];
					$boq_qty = $project_level1_REC['boq_qty'];
					$boq_price = $project_level1_REC['boq_price'];
					$type_name = $project_level1_REC['unit_name'];
					$boq_total = $project_level1_REC['boq_total'];
					$IAM_ARRAY[] = array(  "no" => $no,
					"boq_detail_id" => $boq_detail_id, 
					"boq_name" => $boq_name,
					"boq_qty" => $boq_qty,
					"boq_price" => $boq_price,
					"type_name" => $type_name,
					"boq_total" => $boq_total
					);
				}
			}
		}
	}
	echo json_encode($IAM_ARRAY);
	
?>		
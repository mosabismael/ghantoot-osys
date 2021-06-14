<?php
	require_once('../../bootstrap/app_config.php');
	require_once('../../bootstrap/chk_log_user.php');
	if(isset($_GET['boq_id'])){
		$boq_id = $_GET['boq_id'];
	}
	$IAM_ARRAY = array();
	$qu_project_level1_sel = "SELECT * FROM  `z_manhour_detail` boq , gen_items_units iu  WHERE `boq_id` = $boq_id and boq.weight_unit = iu.unit_id" ;
	$qu_project_level1_EXE = mysqli_query($KONN, $qu_project_level1_sel);
	$no = 0;
	if(mysqli_num_rows($qu_project_level1_EXE)){
		while($project_level1_REC = mysqli_fetch_assoc($qu_project_level1_EXE)){
			$no++;
			$boq_detail_id = $project_level1_REC['manhour_detail_id'];
			$boq_name = $project_level1_REC['name'];
			$boq_qty = $project_level1_REC['weight'];
			$boq_price = $project_level1_REC['unit_cost'];
			$type_name = $project_level1_REC['unit_name'];
			$boq_total = $project_level1_REC['total_cost'];
			$manhour = $project_level1_REC['manhour'];
			$type_id = $project_level1_REC['weight_unit'];
			$manhour_cost = $project_level1_REC['manhour_cost'];
			$material_group = $project_level1_REC['material_group'];
			$surface_area = $project_level1_REC['surface_area'];
			$standard = $project_level1_REC['standard'];
			$material_group = $project_level1_REC['material_group'];
			$number_coat = $project_level1_REC['number_coat'];
			
			$IAM_ARRAY[] = array(  "no" => $no,
			"boq_detail_id" => $boq_detail_id, 
			"boq_name" => $boq_name,
			"boq_qty" => (float)$boq_qty,
			"boq_price" => (float)$boq_price,
			"type_name" => $type_name,
			"boq_total" => (float)$boq_total,
			"manhour" => $manhour,
			"type_id" => $type_id,
			"manhour_cost" => $manhour_cost,
			"group" => $material_group,
			"surface_area" => $surface_area,
			"standard" => $standard,
			"number_coat" => $number_coat
			);
		}
	}
	echo json_encode($IAM_ARRAY);
	
?>		
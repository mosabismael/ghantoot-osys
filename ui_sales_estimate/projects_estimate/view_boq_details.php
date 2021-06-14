<?php
	require_once('../../bootstrap/app_config.php');
	require_once('../../bootstrap/chk_log_user.php');
	if(isset($_GET['boq_id'])){
		$boq_id = $_GET['boq_id'];
	}
	$IAM_ARRAY = array();
	$qu_project_level1_sel = "SELECT * FROM  `z_boq_details` boq , gen_items_units iu  WHERE `boq_id` = $boq_id and boq.type_id = iu.unit_id" ;
	$qu_project_level1_EXE = mysqli_query($KONN, $qu_project_level1_sel);
	$no = 0;
	if(mysqli_num_rows($qu_project_level1_EXE)){
		while($project_level1_REC = mysqli_fetch_assoc($qu_project_level1_EXE)){
			$no++;
			$boq_detail_id = $project_level1_REC['boq_detail_id'];
			$boq_name = $project_level1_REC['boq_name'];
			$boq_qty = $project_level1_REC['boq_qty'];
			$boq_price = $project_level1_REC['boq_price'];
			$type_name = $project_level1_REC['unit_name'];
			$boq_total = $project_level1_REC['boq_total'];
			$manhour = $project_level1_REC['manhour'];
			$type_id = $project_level1_REC['type_id'];
			$complexity = $project_level1_REC['complexity'];
			$section_id = $project_level1_REC['section_id'];
			$category_id = $project_level1_REC['category_id'];
			$family_id = $project_level1_REC['family_id'];
			$division_id = $project_level1_REC['division_id'];
			$subdivision_id = $project_level1_REC['subdivision_id'];
			$item_code_id = $project_level1_REC['item_code_id'];
			$boq_surfacearea = $project_level1_REC['boq_surfacearea'];
			$boq_length = $project_level1_REC['boq_length'];
			$boq_length_unit_id = $project_level1_REC['boq_length_unit_id'];
			$boq_surfacearea_unit_id = $project_level1_REC['boq_surfacearea_unit_id'];
			
			
			
			$no_coat = $project_level1_REC['no_coat'];
			$vol_solids = $project_level1_REC['vol_solids'];
			$loss_factor = $project_level1_REC['loss_factor'];
			$icf = $project_level1_REC['icf'];
			$avg_dft = $project_level1_REC['avg_dft'];
			$tot_paint = $project_level1_REC['tot_paint'];
			$percentage = $project_level1_REC['percentage'];
			
			$qu_project_unit = "SELECT * FROM  gen_items_units iu  WHERE  iu.unit_id = $boq_length_unit_id" ;
			$qu_project_unit_EXE = mysqli_query($KONN, $qu_project_unit);
			if(mysqli_num_rows($qu_project_unit_EXE)){
				$project_unit_REC = mysqli_fetch_assoc($qu_project_unit_EXE);
				$unit_name_length = $project_unit_REC['unit_name'];
			}
			$qu_project_unit = "SELECT * FROM  gen_items_units iu  WHERE  iu.unit_id = $boq_surfacearea_unit_id" ;
			$qu_project_unit_EXE = mysqli_query($KONN, $qu_project_unit);
			if(mysqli_num_rows($qu_project_unit_EXE)){
				$project_unit_REC = mysqli_fetch_assoc($qu_project_unit_EXE);
				$unit_name_surfacearea = $project_unit_REC['unit_name'];
			}
			$IAM_ARRAY[] = array(  "no" => $no,
			"no_coat" => $no_coat,
			"vol_solids" => $vol_solids,
			"loss_factor" => $loss_factor,
			"icf" => $icf,
			"avg_dft" => $avg_dft,
			"tot_paint" => $tot_paint,
			"percentage" => $percentage,
			"boq_detail_id" => $boq_detail_id, 
			"boq_name" => $boq_name,
			"boq_qty" => (float)$boq_qty,
			"boq_price" => (float)$boq_price,
			"type_name" => $type_name,
			"boq_total" => (float)$boq_total,
			"manhour" => $manhour,
			"type_id" => $type_id,
			"complexity" => $complexity,
			"item_code_id" => $item_code_id,
			"family_id" => $family_id,
			"category_id" => $category_id,
			"section_id" => $section_id,
			"subdivision_id" => $subdivision_id,
			"division_id" => $division_id,
			"boq_surfacearea"=>(float)$boq_surfacearea,
			"boq_length"=> $boq_length,
			"boq_surfacearea_unit_id"=> $boq_surfacearea_unit_id,
			"boq_length_unit_id" => $boq_length_unit_id,
			"unit_name_length" => $unit_name_length,
			"unit_name_surfacearea" => $unit_name_surfacearea
			);
		}
	}
	echo json_encode($IAM_ARRAY);
	
?>		
<?php
	require_once('../../bootstrap/app_config.php');
	require_once('../../bootstrap/chk_log_user.php');
	$IAM_ARRAY = array();
	if( isset($_GET['profile']) &&
	isset($_GET['level1_id']) 
	){
		$project_id = ( int ) test_inputs($_GET['project_id']);
		$level1_id = ( int ) test_inputs($_GET['level1_id']);
		$level2_id = ( int ) test_inputs($_GET['level2_id']);
		$weight = (float)test_inputs($_GET['weight']);
		$profile = test_inputs($_GET['profile']);
		$complexity = test_inputs($_GET['complexity']);
		$length = test_inputs($_GET['length']);
		$surfacearea = (float)test_inputs($_GET['surfacearea']);
		$level3_id = 0;
		$qu_level1_template_SEL = "";
		$material_group = "";
		if(substr( $profile, 0, 2 ) == "UB" || substr( $profile, 0, 2 ) == "UC" ){
			$qu_level1_template_SEL = "SELECT * FROM `z_project_level3` where level2_id = $level2_id and level3_name = 'UB/UC'";
			$material_group = 'Sections';
		}
		else if( substr( $profile, 0, 2 ) == "PL"){
			$qu_level1_template_SEL = "SELECT * FROM `z_project_level3` where level2_id = $level2_id and level3_name = 'Plates'";
			$material_group = 'Plates';
		}
		else if(substr( $profile, 0, 3 ) == "RHS" || substr( $profile, 0, 3 ) == "SHS"){
			$qu_level1_template_SEL = "SELECT * FROM `z_project_level3` where level2_id = $level2_id and level3_name = 'SHS/RHS'";
			$material_group = 'Sections';
			
		}
		else if(substr( $profile, 0, 2 ) == "UP"){
			$qu_level1_template_SEL = "SELECT * FROM `z_project_level3` where level2_id = $level2_id and level3_name = 'HB/IB/UP'";
			$material_group = 'Sections';
		}
		else if(substr( $profile, 0, 4 ) == "CHQD"){
			$qu_level1_template_SEL = "SELECT * FROM `z_project_level3` where level2_id = $level2_id and level3_name = 'Chequered Plates'";
			$material_group = 'Plates';
		}
		else{
			$qu_level1_template_SEL = "SELECT * FROM `z_project_level3` where level2_id = $level2_id and level3_name = 'Angles'";
			$material_group = 'Sections';
		}
		
		$qu_level1_template_EXE = mysqli_query($KONN, $qu_level1_template_SEL);
		if(mysqli_num_rows($qu_level1_template_EXE)){
			$level1_template_REC = mysqli_fetch_assoc($qu_level1_template_EXE);
			$level3_id = $level1_template_REC['level3_id'];
		}
		$qu_boq_SEL = "SELECT * FROM `z_boq` where level1_id = $level1_id and level2_id = $level2_id and level3_id = $level3_id and level4_id=0 and level5_id =0";
		
		$qu_boq_EXE = mysqli_query($KONN, $qu_boq_SEL);
		if(mysqli_num_rows($qu_boq_EXE)){
			$qu_boq_REC = mysqli_fetch_assoc($qu_boq_EXE);
			$id = $qu_boq_REC['boq_id'];
		}
		else{
			$qu_project_level1_ins = "INSERT INTO `z_boq` (
			`level1_id`, 
			`level2_id`,
			`level3_id`,
			`level4_id`,
			`level5_id`,
			`project_id`
			) VALUES (
			'".$level1_id."', 
			'".$level2_id."',
			'".$level3_id."',
			'0',
			'0',
			'".$project_id."'
			);";
			
			mysqli_query($KONN, $qu_project_level1_ins);
			$id = mysqli_insert_id($KONN);
		}
		$painting_id =0;
		$qu_boq_SEL = "SELECT * FROM `z_boq` where project_id = $project_id and boq_material_name= 'Painting' ";
		
		$qu_boq_EXE = mysqli_query($KONN, $qu_boq_SEL);
		if(mysqli_num_rows($qu_boq_EXE)){
			$qu_boq_REC = mysqli_fetch_assoc($qu_boq_EXE);
			$painting_id = $qu_boq_REC['boq_id'];
		}
		else{
			/*$qu_project_level1_ins = "INSERT INTO `z_boq` (
			`level1_id`, 
			`level2_id`,
			`level3_id`,
			`level4_id`,
			`level5_id`,
			`project_id`,
			`boq_material_name`
			) VALUES (
			'".$level1_id."', 
			'".$level2_id."',
			'".$level3_id."',
			'0',
			'0',
			'".$project_id."',
			'Painting'
			);";
			
			mysqli_query($KONN, $qu_project_level1_ins);
			$painting_id = mysqli_insert_id($KONN);
		*/}
		$blasting_id = 0;
		$qu_boq_SEL = "SELECT * FROM `z_boq` where project_id = $project_id and boq_material_name = 'Blasting'";
		
		$qu_boq_EXE = mysqli_query($KONN, $qu_boq_SEL);
		if(mysqli_num_rows($qu_boq_EXE)){
			$qu_boq_REC = mysqli_fetch_assoc($qu_boq_EXE);
			$blasting_id = $qu_boq_REC['boq_id'];
		}
		else{
			/*$qu_project_level1_ins = "INSERT INTO `z_boq` (
			`level1_id`, 
			`level2_id`,
			`level3_id`,
			`level4_id`,
			`level5_id`,
			`project_id`,
			`boq_material_name`
			) VALUES (
			'".$level1_id."', 
			'".$level2_id."',
			'".$level3_id."',
			'0',
			'0',
			'".$project_id."',
			'Blasting'
			);";
			
			mysqli_query($KONN, $qu_project_level1_ins);
			$blasting_id = mysqli_insert_id($KONN);
		*/}
		
		$qu_boq_SEL = "SELECT * FROM `z_boq` boq, z_manhour_detail det where boq.project_id = $project_id and boq.boq_material_name='Steel fabrication' and boq.boq_id = det.boq_id and det.name = '".$complexity."'";
		$boq_weight = 0;
		$unit_cost = 0;
		$boq_manhour_id = 0;
		$qu_boq_EXE = mysqli_query($KONN, $qu_boq_SEL);
		if(mysqli_num_rows($qu_boq_EXE)){
			$qu_boq_REC = mysqli_fetch_assoc($qu_boq_EXE);
			$boq_sf_id = $qu_boq_REC['boq_id'];
			$boq_weigth = $qu_boq_REC['weight'];
			$boq_manhour_id = $qu_boq_REC['manhour_detail_id'];
			$unit_cost = $qu_boq_REC['unit_cost'];
		}
		
		$boq_weight = $weight + (float) $boq_weight;
		$manpower_total_cost = $boq_weight * (float)$unit_cost;
		$qu_project_level1_ins = "INSERT INTO `z_boq_details` (
		`boq_name`, 
		`boq_id`,
		`type_id`,
		`boq_length_unit_id`,
		`boq_surfacearea_unit_id`,
		`boq_qty`,
		`complexity`,
		`boq_length`,
		`boq_surfacearea`
		) VALUES (
		'".$profile."', 
		'".$id."',
		'15',
		'5',
		'9',
		'".$weight."',
		'".$complexity."',
		'".$length."',
		'".$surfacearea."'
		);";
		mysqli_query($KONN, $qu_project_level1_ins);
		
		$qu_project_level1_ins = "UPDATE `z_manhour_detail` SET
		`weight`= '".$boq_weight."' , `total_cost`= '".$manpower_total_cost."' where manhour_detail_id = '".$boq_manhour_id."' ;";
		mysqli_query($KONN, $qu_project_level1_ins);
		
		
		$qu_boq_SEL = "SELECT * FROM `gen_company_norms` norms where norm_act_name = 'Blasting' ";
		$boq_weight = 0;
		$qu_boq_EXE = mysqli_query($KONN, $qu_boq_SEL);
		if(mysqli_num_rows($qu_boq_EXE)){
			$qu_boq_REC = mysqli_fetch_assoc($qu_boq_EXE);
			$manhour = $qu_boq_REC['activity_kpi'];
			$manhour_cost = $qu_boq_REC['manhour_cost'];
		}	
		$qu_project_level1_ins = "INSERT INTO `z_manhour_detail` (
		`name`, 
		`boq_id`,
		`material_group`,
		`surface_area`,
		`weight_unit`,
		`manhour`,
		`manhour_cost`,
		`unit_cost`,
		`standard`,
		`total_cost`
		) VALUES (
		'".$profile."', 
		'".$blasting_id."',
		'".$material_group."',
		'".$surfacearea."',
		'1',
		'".$manhour."',
		'".$manhour_cost."',
		'".$manhour*$manhour_cost."',
		'2.5',
		'".$manhour*$manhour_cost * $surfacearea."'
		);";
		echo $qu_project_level1_ins;
		mysqli_query($KONN, $qu_project_level1_ins);
		
		
		
		$qu_boq_SEL = "SELECT * FROM `gen_company_norms` norms where norm_act_name = 'Painting' ";
		$boq_weight = 0;
		$qu_boq_EXE = mysqli_query($KONN, $qu_boq_SEL);
		if(mysqli_num_rows($qu_boq_EXE)){
			$qu_boq_REC = mysqli_fetch_assoc($qu_boq_EXE);
			$manhour = $qu_boq_REC['activity_kpi'];
			$manhour_cost = $qu_boq_REC['manhour_cost'];
		}	
		$qu_project_level1_ins = "INSERT INTO `z_manhour_detail` (
		`name`, 
		`boq_id`,
		`material_group`,
		`surface_area`,
		`weight_unit`,
		`manhour`,
		`manhour_cost`,
		`unit_cost`,
		`number_coat`,
		`total_cost`
		) VALUES (
		'".$profile."', 
		'".$painting_id."',
		'".$material_group."',
		'".$surfacearea."',
		'1',
		'".$manhour."',
		'".$manhour_cost."',
		'".$manhour*$manhour_cost."',
		'1',
		'".$manhour*$manhour_cost * $surfacearea."'
		);";
		mysqli_query($KONN, $qu_project_level1_ins);
		
		
		
		
		
		
	}
	echo json_encode($IAM_ARRAY);
?>							
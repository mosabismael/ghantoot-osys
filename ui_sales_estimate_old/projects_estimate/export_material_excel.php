<?php
	require_once('../../bootstrap/app_config.php');
	require_once('../../bootstrap/chk_log_user.php');
	$IAM_ARRAY = array();
	if( isset($_GET['profile']) &&
	isset($_GET['level1_id']) 
	){
		
		
		$level1_id = ( int ) test_inputs($_GET['level1_id']);
		$weight = (float)test_inputs($_GET['weight']);
		$profile = test_inputs($_GET['profile']);
		$complexity = test_inputs($_GET['complexity']);
		$length = test_inputs($_GET['length']);
		$surfacearea = (float)test_inputs($_GET['surfacearea']);
		$level2_id = 0;
		$qu_level1_template_SEL = "";
		if(substr( $profile, 0, 2 ) == "UB" || substr( $profile, 0, 2 ) == "UC" ){
			$qu_level1_template_SEL = "SELECT * FROM `z_project_level2` where level1_id = $level1_id and level2_name = 'UB/UL'";
			
		}
		else if(substr( $profile, 0, 4 ) == "CHQD" || substr( $profile, 0, 2 ) == "PL"){
			$qu_level1_template_SEL = "SELECT * FROM `z_project_level2` where level1_id = $level1_id and level2_name = 'Plates'";
			
		}
		else if(substr( $profile, 0, 3 ) == "RHS" || substr( $profile, 0, 3 ) == "SHS"){
			$qu_level1_template_SEL = "SELECT * FROM `z_project_level2` where level1_id = $level1_id and level2_name = 'SHS/RHS'";
		
			
		}
		else if(substr( $profile, 0, 2 ) == "UP"){
			$qu_level1_template_SEL = "SELECT * FROM `z_project_level2` where level1_id = $level1_id and level2_name = 'HB/IB/UP'";
			
		}
		else{
			$qu_level1_template_SEL = "SELECT * FROM `z_project_level2` where level1_id = $level1_id and level2_name = 'UB/UL'";
			
		}
		
		$qu_level1_template_EXE = mysqli_query($KONN, $qu_level1_template_SEL);
		if(mysqli_num_rows($qu_level1_template_EXE)){
			$level1_template_REC = mysqli_fetch_assoc($qu_level1_template_EXE);
			$level2_id = $level1_template_REC['level2_id'];
		}
		$qu_boq_SEL = "SELECT * FROM `z_boq` where level1_id = $level1_id and level2_id = $level2_id and level3_id = 0 and level4_id=0 and level5_id =0";
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
			`level5_id`
			) VALUES (
			'".$level1_id."', 
			'".$level2_id."',
			'0',
			'0',
			'0'
			);";
			
			mysqli_query($KONN, $qu_project_level1_ins);
			$id = mysqli_insert_id($KONN);
		}
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
		
		
		}
		echo json_encode($IAM_ARRAY);
	?>						
<?php
	require_once('../../bootstrap/app_config.php');
	require_once('../../bootstrap/chk_log_user.php');
	
	if(isset($_GET['level1_id'])){
		$level1_id = $_GET['level1_id'];
	}
	if(isset($_GET['level2_id'])){
		$level2_id = $_GET['level2_id'];
	}
	if(isset($_GET['level3_id'])){
		$level3_id = $_GET['level3_id'];
	}
	if(isset($_GET['level4_id'])){
		$level4_id = $_GET['level4_id'];
	}
	if(isset($_GET['level5_id'])){
		$level5_id = $_GET['level5_id'];
	}
	if(isset($_GET['project_id'])){
		$project_id = $_GET['project_id'];
	}
	
	
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
	'".$level4_id."',
	'".$level5_id."',
	'".$project_id."'
	);";
	
	mysqli_query($KONN, $qu_project_level1_ins);
	$id = mysqli_insert_id($KONN);
	echo $id;
?>
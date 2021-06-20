<?php
	require_once('../../bootstrap/app_config.php');
	require_once('../../bootstrap/chk_log_user.php');
	
	if(isset($_GET['item_name'])){
		$item_name = $_GET['item_name'];
	}
	if(isset($_GET['level1_id'])){
		$level1_id = $_GET['level1_id'];
	}
	
	$boq_id = 0;
	$qu_project_level1_ins = "SELECT boq_id from z_boq where project_id = $level1_id and boq_material_name = '$item_name'";
	$userStatement = mysqli_prepare($KONN,$qu_project_level1_ins);
	mysqli_stmt_execute($userStatement);
	$qu_gen_status_change_EXE = mysqli_stmt_get_result($userStatement);
	if(mysqli_num_rows($qu_gen_status_change_EXE)){
		$gen_status_change_REC = mysqli_fetch_assoc($qu_gen_status_change_EXE);
		$boq_id = $gen_status_change_REC['boq_id'];
	}
	echo $boq_id;
?>
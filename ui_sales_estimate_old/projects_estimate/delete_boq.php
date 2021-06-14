<?php
	require_once('../../bootstrap/app_config.php');
	require_once('../../bootstrap/chk_log_user.php');
	
	
	if(isset($_GET['boq_id'])){
		$boq_id = $_GET['boq_id'];
	}
	$qu_boq_sel = "SELECT SUM(boq_total) as total from z_boq_details where boq_id = '".$boq_id."';";
	$qu_boq_EXE = mysqli_query($KONN, $qu_boq_sel);
	
	if(mysqli_num_rows($qu_boq_EXE)){
		$qu_boq_REC = mysqli_fetch_assoc($qu_boq_EXE);
		$total = $qu_boq_REC['total'];
		echo $total;
	}
	
	
	$qu_project_level1_ins = "DELETE FROM z_boq_details where boq_id = '".$boq_id."';";
	mysqli_query($KONN, $qu_project_level1_ins);
	$qu_project_level1_ins = "DELETE FROM z_boq where boq_id = '".$boq_id."';";
	mysqli_query($KONN, $qu_project_level1_ins);
	
?>
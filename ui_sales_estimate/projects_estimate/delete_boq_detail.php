<?php
	require_once('../../bootstrap/app_config.php');
	require_once('../../bootstrap/chk_log_user.php');
	
	
	if(isset($_GET['boq_detail_id'])){
		$boq_detail_id = $_GET['boq_detail_id'];
	}
	$is_boq = '1';
	if(isset($_GET['is_boq'])){
		$is_boq = $_GET['is_boq'];
	}
	
	$qu_project_level1_ins = "DELETE FROM z_manhour_detail where manhour_detail_id = '".$boq_detail_id."';";
	
	if($is_boq ==1){
		$qu_project_level1_ins = "DELETE FROM z_boq_details where boq_detail_id = '".$boq_detail_id."';";
	}
	mysqli_query($KONN, $qu_project_level1_ins);
	

?>
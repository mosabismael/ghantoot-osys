<?php
	require_once('../../bootstrap/app_config.php');
	require_once('../../bootstrap/chk_log_user.php');
	
	
	if(isset($_GET['scope_id'])){
		$scope_id = $_GET['scope_id'];
	}
	
	
	$qu_project_level1_ins = "DELETE FROM z_work_scope where scope_id = '".$scope_id."';";
	mysqli_query($KONN, $qu_project_level1_ins);
	

?>
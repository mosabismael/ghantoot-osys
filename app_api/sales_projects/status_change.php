<?php
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	if(isset($_GET['project_id'])){
			$project_id = (int) $_GET['project_id'];
			
			$qu_update_status_SEL = "UPDATE `z_project` SET `project_status` = 'Completed' WHERE project_id = $project_id";
			$UpdateStatement = mysqli_prepare($KONN,$qu_update_status_SEL);
			
			mysqli_stmt_execute($UpdateStatement);
			
	}
?>
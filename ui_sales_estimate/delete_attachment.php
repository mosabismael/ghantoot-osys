<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	
	
	if(isset($_GET['attachment_id'])){
		$attachment_id = $_GET['attachment_id'];
	}
	
	
	$qu_project_level1_ins = "DELETE FROM enquiry_attachment where attachment_id = '".$attachment_id."';";
	mysqli_query($KONN, $qu_project_level1_ins);
	
	
?>
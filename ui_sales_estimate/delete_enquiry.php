<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	
	
	if(isset($_GET['enquiry_id'])){
		$enquiry_id = $_GET['enquiry_id'];
	}
	
	
	$qu_project_level1_ins = "DELETE FROM enquiry_attachment where enquiry_id = '".$enquiry_id."';";
	mysqli_query($KONN, $qu_project_level1_ins);
	
	$qu_project_level1_ins = "DELETE FROM enquiries where enquiry_id = '".$enquiry_id."';";
	mysqli_query($KONN, $qu_project_level1_ins);
	
?>
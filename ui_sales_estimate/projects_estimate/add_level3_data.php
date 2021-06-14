<?php
	require_once('../../bootstrap/app_config.php');
	require_once('../../bootstrap/chk_log_user.php');
	
	$product_name = $_GET['name'];
	$prod_desc = $_GET['description'];
	$level2_id = $_GET['level2_id'];
	$id = $_GET['id'];
	$type_id = $_GET['type_id'];
	if($id==0){
		$qu_project_level3_ins = "INSERT INTO `z_project_level3` (
		`level3_name`, 
		`level2_id` ,
		`level3_description`,
		`type_id`
		) VALUES (
		'".$product_name."', 
		'".$level2_id."' ,
		'".$prod_desc."',
		'".$type_id."'
		);";
	}
	else{
		$qu_project_level3_ins = "update `z_project_level3` set
		`level3_name` = '".$product_name."', 
		`level2_id` ='".$level2_id."',
		`level3_description` ='".$prod_desc."',
		`type_id` ='".$type_id."'
		where level3_id = '".$id."';";
	}
	mysqli_query($KONN, $qu_project_level3_ins);
	
?>
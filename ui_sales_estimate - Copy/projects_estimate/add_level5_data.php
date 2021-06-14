<?php
	require_once('../../bootstrap/app_config.php');
	require_once('../../bootstrap/chk_log_user.php');
	
	$product_name = $_GET['name'];
	$prod_desc = $_GET['description'];
	$level4_id = $_GET['level4_id'];
	$id = $_GET['id'];
	$type_id = $_GET['type_id'];
	if($id==0){
		$qu_project_level5_ins = "INSERT INTO `z_project_level5` (
		`level5_name`, 
		`level4_id` ,
		`level5_description`,
		`type_id`
		) VALUES (
		'".$product_name."', 
		'".$level4_id."' ,
		'".$prod_desc."',
		'".$type_id."'
		);";
	}
	else{
		$qu_project_level5_ins = "update `z_project_level5` set
		`level5_name` = '".$product_name."', 
		`level4_id` ='".$level4_id."',
		`level5_description` ='".$prod_desc."',
		`type_id` ='".$type_id."'
		where level5_id = '".$id."';";
	}
	mysqli_query($KONN, $qu_project_level5_ins);
	
	
?>
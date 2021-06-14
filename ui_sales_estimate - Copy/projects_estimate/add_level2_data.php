<?php
	require_once('../../bootstrap/app_config.php');
	require_once('../../bootstrap/chk_log_user.php');
	
		$product_name = $_GET['name'];
		$prod_desc = $_GET['description'];
		$level1_id = $_GET['level1_id'];
		$id = $_GET['id'];
		$type_id = $_GET['type_id'];
		if($id==0){
			$qu_project_level2_ins = "INSERT INTO `z_project_level2` (
			`level2_name`, 
			`level1_id`,
			`level2_description`,
			`type_id`
			) VALUES (
			'".$product_name."', 
			'".$level1_id."' ,
			'".$prod_desc."',
			'".$type_id."'
			);";
		}
		else{
			$qu_project_level2_ins = "update `z_project_level2` set
			`level2_name` = '".$product_name."', 
			`level1_id` ='".$level1_id."',
			`level2_description` ='".$prod_desc."',
			`type_id` ='".$type_id."'
			where level2_id = '".$id."';";
		}
		
		mysqli_query($KONN, $qu_project_level2_ins);	
	
?>
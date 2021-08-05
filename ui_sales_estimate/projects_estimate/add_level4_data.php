<?php
	require_once('../../bootstrap/app_config.php');
	require_once('../../bootstrap/chk_log_user.php');
	
		$product_name = $_GET['name'];
		$prod_desc = $_GET['description'];
		$level3_id = $_GET['level3_id'];
		$id = $_GET['id'];
		$type_id = $_GET['type_id'];
		$quantity = $_GET['quantity'];
		$complexity = $_GET['complexity'];
		$length = $_GET['length'];
		$surface_area = $_GET['surface_area'];
		$cost = $_GET['cost'];

		
		if($id==0){
			$qu_project_level4_ins = "INSERT INTO `z_project_level4` (
			`level4_name`, 
			`level3_id` ,
			`level4_description`,
			`type_id`,
			`quantity`,
			`complexity`,
			`length`,
			`surface_area`,
			`cost`

			) VALUES (
			'".$product_name."', 
			'".$level3_id."',
			'".$prod_desc."',
			'".$type_id."',
			'".$quantity."',
			'".$complexity."',
			'".$length."',
			'".$surface_area."',
			'".$cost."'
			);";
		}
		else{
			$qu_project_level4_ins = "update `z_project_level4` set
			`level4_name` = '".$product_name."', 
			`level3_id` ='".$level3_id."',
			`level4_description` ='".$prod_desc."',
			`type_id` ='".$type_id."'
			where level4_id = '".$id."';";
		}
		mysqli_query($KONN, $qu_project_level4_ins);
		
	
?>
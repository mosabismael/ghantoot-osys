<?php
	require_once('../../bootstrap/app_config.php');
	require_once('../../bootstrap/chk_log_user.php');
	
		$product_name = $_GET['name'];
		$prod_desc = $_GET['description'];
		$level3_id = $_GET['level3_id'];
		$id = $_GET['id'];
		$type_id = $_GET['type_id'];

		$boq_qty = $_GET['item_qty-4'];
		$complexity = $_GET['item_complexity-4'];
		$boq_length = $_GET['item_length-4'];
		$boq_price = $_GET['item_price-4'];
		$boq_surfacearea = $_GET['item_surface_area-4'];
		$type_id = $_GET['type_id'];

		if($id==0){
			$qu_project_level4_ins = "INSERT INTO `z_project_level4` (
			`level4_name`, 
			`level3_id` ,
			`level4_description`,
			`type_id`
			) VALUES (
			'".$product_name."', 
			'".$level3_id."',
			'".$prod_desc."',
			'".$type_id."'
			);";
		}
		$qu_z_boq_details_ins = "INSERT INTO `z_boq_details` (
			`boq_name`, 
			`boq_qty` ,
			`complexity`,
			`boq_length`,
			`boq_surfacearea`,
			`boq_price`
			) VALUES (
			'".$product_name."', 
			'".$boq_qty."',
			'".$complexity."',
			'".$boq_length."',
			'".$boq_surfacearea."',
			'".$boq_price."'

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
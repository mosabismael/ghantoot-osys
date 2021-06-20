<?php
	require_once('../../bootstrap/app_config.php');
	require_once('../../bootstrap/chk_log_user.php');
	
	if(isset($_GET['item_name'])){
		$item_name = $_GET['item_name'];
	}
	if(isset($_GET['item_qty'])){
		$item_qty = (float)$_GET['item_qty'];
	}
	if(isset($_GET['item_price'])){
		$item_price = (float)$_GET['item_price'];
	}
	if(isset($_GET['item_tot'])){
		$item_tot = (float)$_GET['item_tot'];
	}
	if(isset($_GET['item_unit'])){
		$item_unit = $_GET['item_unit'];
	}
	if(isset($_GET['boq_id'])){
		$boq_id = $_GET['boq_id'];
		if($boq_id == 0){
			if(isset($_GET['name'])){
				$name = $_GET['name'];
				$project_id = $_GET['project_id'];
				$qu_project_level1_ins = "SELECT boq_id from z_boq where project_id = $project_id and boq_material_name = '$name'";
				$userStatement = mysqli_prepare($KONN,$qu_project_level1_ins);
				mysqli_stmt_execute($userStatement);
				$qu_gen_status_change_EXE = mysqli_stmt_get_result($userStatement);
				if(mysqli_num_rows($qu_gen_status_change_EXE)){
					$gen_status_change_REC = mysqli_fetch_assoc($qu_gen_status_change_EXE);
					$boq_id = $gen_status_change_REC['boq_id'];
				}
			}
		}
	}
	if(isset($_GET['item_manhour'])){
		$item_manhour = $_GET['item_manhour'];
	}
	if(isset($_GET['item_manhour_cost'])){
		$item_manhour_cost = $_GET['item_manhour_cost'];
	}
	
	$surface_area = "";
	if(isset($_GET['surface_area'])){
		$surface_area = $_GET['surface_area'];
	}
	$standard = "";
	if(isset($_GET['standard'])){
		$standard = $_GET['standard'];
	}
	$number_coat = 0;
	if(isset($_GET['number_coat'])){
		$number_coat = $_GET['number_coat'];
	}
	$group = "";
	if(isset($_GET['group'])){
		$group = $_GET['group'];
	}
	
	$qu_project_level1_ins = "INSERT INTO `z_manhour_detail` (
	`name`, 
	`weight`,
	`manhour`,
	`manhour_cost`,
	`unit_cost`,
	`total_cost`,
	`surface_area`,
	`material_group`,
	`standard`,
	`number_coat`,
	`weight_unit`,
	`boq_id`
	) VALUES (
	'".$item_name."', 
	'".$item_qty."',
	'".$item_manhour."',
	'".$item_manhour_cost."',
	'".$item_price."',
	'".round($item_tot,3)."',
	'".$surface_area."',
	'".$group."',
	'".$standard."',
	'".$number_coat."',
	'".$item_unit."',
	'".$boq_id."'
	);";
	mysqli_query($KONN, $qu_project_level1_ins);
	$id = mysqli_insert_id($KONN);
	echo $id;
?>
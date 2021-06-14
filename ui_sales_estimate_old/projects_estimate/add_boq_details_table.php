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
	}
	if(isset($_GET['item_manhour'])){
		$item_manhour = $_GET['item_manhour'];
	}
	if(isset($_GET['complexity'])){
		$complexity = $_GET['complexity'];
	}
	if(isset($_GET['family_id'])){
		$family_id = $_GET['family_id'];
	}
	if(isset($_GET['section_id'])){
		$section_id = $_GET['section_id'];
	}
	if(isset($_GET['division_id'])){
		$division_id = $_GET['division_id'];
	}
	if(isset($_GET['subdivision_id'])){
		$subdivision_id = $_GET['subdivision_id'];
	}
	if(isset($_GET['category_id'])){
		$category_id = $_GET['category_id'];
	}
	if(isset($_GET['item_code_id'])){
		$item_code_id = $_GET['item_code_id'];
	}
	if(isset($_GET['item_length'])){
		$item_length = $_GET['item_length'];
	}
	if(isset($_GET['item_surfacearea'])){
		$item_surfacearea = (float)$_GET['item_surfacearea'];
	}
	if(isset($_GET['item_surfacearea_unit'])){
		$item_surfacearea_unit = $_GET['item_surfacearea_unit'];
	}
	if(isset($_GET['item_length_unit'])){
		$item_length_unit = $_GET['item_length_unit'];
	}
	$qu_project_level1_ins = "INSERT INTO `z_boq_details` (
	`boq_name`, 
	`boq_qty`,
	`boq_price`,
	`boq_id`,
	`type_id`,
	`manhour`,
	`boq_total`,
	`complexity`,
	`family_id`,
	`section_id`,
	`subdivision_id`,
	`division_id`,
	`category_id`,
	`item_code_id`,
	`boq_surfacearea`,
	`boq_length`,
	`boq_surfacearea_unit_id`,
	`boq_length_unit_id`
	) VALUES (
	'".$item_name."', 
	'".$item_qty."',
	'".$item_price."',
	'".$boq_id."',
	'".$item_unit."',
	'".$item_manhour."',
	'".round($item_tot,3)."',
	'".$complexity."',
	'".$family_id."',
	'".$section_id."',
	'".$subdivision_id."',
	'".$division_id."',
	'".$category_id."',
	'".$item_code_id."',
	'".$item_surfacearea."',
	'".$item_length."',
	'".$item_surfacearea_unit."',
	'".$item_length_unit."'
	);";
	mysqli_query($KONN, $qu_project_level1_ins);
	$id = mysqli_insert_id($KONN);
	echo $id;
?>
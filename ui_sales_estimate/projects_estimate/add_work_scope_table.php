<?php
	require_once('../../bootstrap/app_config.php');
	require_once('../../bootstrap/chk_log_user.php');
	
	if(isset($_GET['item_name'])){
		$item_name = $_GET['item_name'];
	}
	if(isset($_GET['item_qty'])){
		$item_qty = $_GET['item_qty'];
	}
	if(isset($_GET['item_price'])){
		$item_price = $_GET['item_price'];
	}
	
	if(isset($_GET['project_id'])){
		$project_id = $_GET['project_id'];
	}
	if(isset($_GET['unit_id'])){
		$unit_id = $_GET['unit_id'];
	}
	
	$qu_project_level1_ins = "INSERT INTO `z_work_scope` (
	`item_name`, 
	`item_qty`,
	`project_id`,
	`item_price`,
	`unit_id`
	) VALUES (
	'".$item_name."', 
	'".$item_qty."',
	'".$project_id."',
	'".$item_price."',
	'".$unit_id."'
	);";
	mysqli_query($KONN, $qu_project_level1_ins);
	$id = mysqli_insert_id($KONN);
	echo $id;
?>
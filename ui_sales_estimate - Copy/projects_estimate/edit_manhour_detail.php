<?php
	require_once('../../bootstrap/app_config.php');
	require_once('../../bootstrap/chk_log_user.php');
	
	if(isset($_GET['item_name'])){
		$item_name = $_GET['item_name'];
	}
	$item_qty = 0;
	if(isset($_GET['item_qty']) && $_GET['item_qty']!='undefined'){
		$item_qty = $_GET['item_qty'];
	}
	if(isset($_GET['item_price'])){
		$item_price = $_GET['item_price'];
	}
	$unit_id = 1;
	if(isset($_GET['unit_id']) && $_GET['unit_id'] != 'undefined'){
		$unit_id = $_GET['unit_id'];
	}
	if(isset($_GET['boq_id'])){
		$boq_id = $_GET['boq_id'];
	}
	if(isset($_GET['boq_detail_id'])){
		$boq_detail_id = $_GET['boq_detail_id'];
	}
	if(isset($_GET['number_coat']) && $_GET['number_coat']!='undefined'){
		$number_coat = $_GET['number_coat'];
	}
	if(isset($_GET['surface_area']) && $_GET['surface_area']!='undefined'){
		$surface_area = $_GET['surface_area'];
		$item_qty = $number_coat * $surface_area;
	}
	if(isset($_GET['standard'])){
		$standard = $_GET['standard'];
	}
	$qu_project_level1_ins = "UPDATE `z_manhour_detail` SET
	`name` = '".$item_name."', 
	`weight` = '".$item_qty."',
	`unit_cost` = '".$item_price."',
	`boq_id` = '".$boq_id."',
	`weight_unit` = '".$unit_id."',
	`standard` = '".$standard."',
	`surface_area` = '".$surface_area."',
	`number_coat` = '".$number_coat."',
	`total_cost` = '".$item_qty*$item_price."'
	where manhour_detail_id = $boq_detail_id";
	
	mysqli_query($KONN, $qu_project_level1_ins);
	
?>
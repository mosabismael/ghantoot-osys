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
	
	if(isset($_GET['unit_id'])){
		$unit_id = $_GET['unit_id'];
	}
	if(isset($_GET['boq_id'])){
		$boq_id = $_GET['boq_id'];
	}
	if(isset($_GET['boq_detail_id'])){
		$boq_detail_id = $_GET['boq_detail_id'];
	}
	
	$qu_project_level1_ins = "UPDATE `z_boq_details` SET
	`boq_name` = '".$item_name."', 
	`boq_qty` = '".$item_qty."',
	`boq_price` = '".$item_price."',
	`boq_id` = '".$boq_id."',
	`type_id` = '".$unit_id."',
	`boq_total` = '".$item_qty*$item_price."'
	where boq_detail_id = $boq_detail_id";
	mysqli_query($KONN, $qu_project_level1_ins);
	
?>
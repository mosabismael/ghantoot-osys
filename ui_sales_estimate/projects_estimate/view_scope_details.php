<?php
	require_once('../../bootstrap/app_config.php');
	require_once('../../bootstrap/chk_log_user.php');
	if(isset($_GET['project_id'])){
		$project_id = $_GET['project_id'];
	}
	$IAM_ARRAY = array();
	$qu_project_level1_sel = "SELECT * FROM  `z_work_scope` scope , gen_items_units iu WHERE `project_id` = $project_id  and iu.unit_id = scope.unit_id ";
	$qu_project_level1_EXE = mysqli_query($KONN, $qu_project_level1_sel);
	$no = 0;
	if(mysqli_num_rows($qu_project_level1_EXE)){
		while($project_level1_REC = mysqli_fetch_assoc($qu_project_level1_EXE)){
			$no++;
			$scope_id = $project_level1_REC['scope_id'];
			$item_name = $project_level1_REC['item_name'];
			$item_qty = $project_level1_REC['item_qty'];
			$item_price = $project_level1_REC['item_price'];
			$unit_name = $project_level1_REC['unit_name'];
			$ths_tot = $item_qty * $item_price;
			$IAM_ARRAY[] = array(  "no" => $no,
						"scope_id" => $scope_id, 
						"item_name" => $item_name,
						"item_qty" => $item_qty,
						"item_price" => intval($item_price),
						"ths_tot" => intval($ths_tot),
						"unit_name" => $unit_name
						);
		}
	}
	echo json_encode($IAM_ARRAY);
		
		?>		
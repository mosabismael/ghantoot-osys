<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	
	$IAM_ARRAY = array();
	$qpt = "SELECT * FROM `gen_items_units`";
	$QER_E = mysqli_query($KONN, $qpt);
	if(mysqli_num_rows($QER_E) > 0){
		while($pt_dt = mysqli_fetch_assoc($QER_E)){
		$unit_id= $pt_dt['unit_id'];
		$unit_name = $pt_dt['unit_name'];
			$IAM_ARRAY[] = array(  "unit_id" => $unit_id,
			"unit_name" => $unit_name
			
			);
		}
	}
	echo json_encode($IAM_ARRAY);
?>
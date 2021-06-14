<?php
	require_once('../../bootstrap/app_config.php');
	require_once('../../bootstrap/chk_log_user.php');
	
	$IAM_ARRAY  = array();
	
	
	$level4_id = 0;
	$level3_id = 0;
	$level2_id = 0;
	$level1_id = 0;
	
	
	if( isset( $_POST['id'] ) ){
		$level4_id = ( int ) test_inputs( $_POST['id'] );
	}
	if( isset( $_POST['level3_id'] ) ){
		$level3_id = ( int ) test_inputs( $_POST['level3_id'] );
	}
	if( isset( $_POST['level2_id'] ) ){
		$level2_id = ( int ) test_inputs( $_POST['level2_id'] );
	}
	if( isset( $_POST['level1_id'] ) ){
		$level1_id = ( int ) test_inputs( $_POST['level1_id'] );
	}
	
	
	
	
	
	
	$sNo =  1;
	$qu_project_level5_sel = "SELECT * FROM  `z_project_level5` l5, z_levels_type t WHERE `level4_id` = $level4_id and t.type_id = l5.type_id";
	$qu_project_level5_EXE = mysqli_query($KONN, $qu_project_level5_sel);
	$no = 0;
	if(mysqli_num_rows($qu_project_level5_EXE)){
		while($project_level5_REC = mysqli_fetch_assoc($qu_project_level5_EXE)){
			$no++;
			$level5_id = $project_level5_REC['level5_id'];
			$level5_name = $project_level5_REC['level5_name'];
			$level4_id = $project_level5_REC['level4_id'];
			$level5_description = $project_level5_REC['level5_description'];
			$type_id = $project_level5_REC['type_id'];
			$type_name = $project_level5_REC['type_name'];
			
			$qu_boq_sel = "SELECT * FROM  `z_boq` boq WHERE `level1_id` = $level1_id  and level2_id = $level2_id and level3_id = $level3_id and level4_id = $level4_id and level5_id = $level5_id "  ;
			$qu_boq_EXE = mysqli_query($KONN, $qu_boq_sel);
			$boq_id = 0;
			$show_complete = 0;
			$total_amount =0;
			if(mysqli_num_rows($qu_boq_EXE)){
				$qu_boq_REC = mysqli_fetch_assoc($qu_boq_EXE);
				$boq_id = $qu_boq_REC['boq_id'];
				$qu_sum_sel = "SELECT IFNULL(SUM(boq_total),0) as total FROM  `z_boq_details`  WHERE boq_id = $boq_id"  ;
				$qu_sum_EXE = mysqli_query($KONN, $qu_sum_sel);
				
				if(mysqli_num_rows($qu_sum_EXE)){
					$qu_sum_REC = mysqli_fetch_assoc($qu_sum_EXE);
					$total_amount = $qu_sum_REC['total'];
				}
			}
			
			$IAM_ARRAY[] = array(  "sno" => $sNo, 
			"level5_id" => $level5_id, 
			"level5_name" => $level5_name, 
			"level4_id" => $level4_id, 
			"level5_description" => $level5_description, 
			"type_id" => $type_id,
			"type_name" => $type_name,
			"boq_id" => $boq_id,
			"total_amount" => number_format($total_amount,3,'.',''),
			"show_complete" => $show_complete
			);
			
			$sNo++;
		}
		
		
	}
	echo json_encode($IAM_ARRAY);
?>
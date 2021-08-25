<?php
	require_once('../../bootstrap/app_config.php');
	require_once('../../bootstrap/chk_log_user.php');
	
	$IAM_ARRAY  = array();
	
	
	$level3_id = 0;
	$level2_id = 0;
	$level1_id = 0;
	
	if( isset( $_POST['id'] ) ){
		$level3_id = ( int ) test_inputs( $_POST['id'] );
	}
	if( isset( $_POST['level2_id'] ) ){
		$level2_id = ( int ) test_inputs( $_POST['level2_id'] );
	}
	if( isset( $_POST['level1_id'] ) ){
		$level1_id = ( int ) test_inputs( $_POST['level1_id'] );
	}
	
	
	
	
	
	$sNo =  1;
	$qu_project_level4_sel = "SELECT * FROM  `z_project_level4` l4, z_levels_type t WHERE `level3_id` = $level3_id and t.type_id = l4.type_id;";
	$qu_project_level4_EXE = mysqli_query($KONN, $qu_project_level4_sel);
	$no = 0;
	if(mysqli_num_rows($qu_project_level4_EXE)){
		while($project_level4_REC = mysqli_fetch_assoc($qu_project_level4_EXE)){
			$no++;
			$level4_id = $project_level4_REC['level4_id'];
			$level4_name = $project_level4_REC['level4_name'];
			$level3_id = $project_level4_REC['level3_id'];
			$level4_description = $project_level4_REC['level4_description'];
			$type_id = $project_level4_REC['type_id'];
			$type_name = $project_level4_REC['type_name'];
			$quantity = $project_level4_REC['quantity'];
			$complexity = $project_level4_REC['complexity'];
			$length = $project_level4_REC['length']; 
			$surface_area = $project_level4_REC['surface_area'];
			$cost = $project_level4_REC['cost'];
			$qu_prject_sel = "SELECT count(*) as count FROM  `z_project_level5` WHERE `level4_id` = $level4_id "  ;
			$qu_project_EXE = mysqli_query($KONN, $qu_prject_sel);
			$total_amount = 0;
			$boq_id =0;
			$show_complete = '0';
			if(mysqli_num_rows($qu_project_EXE)){
				$qu_project_REC = mysqli_fetch_assoc($qu_project_EXE);
				$count = $qu_project_REC['count'];
				if($count != 0){
					
					$qu_sum_sel = "SELECT IFNULL(SUM(boq_total),0) as total FROM  `z_boq` boq , z_boq_details boqDet WHERE boq.boq_id = boqDet.boq_id and `level1_id` = $level1_id and level2_id = $level2_id and level3_id = $level3_id and level4_id = $level4_id" ;
					$qu_sum_EXE = mysqli_query($KONN, $qu_sum_sel);
					
					if(mysqli_num_rows($qu_sum_EXE)){
						$qu_sum_REC = mysqli_fetch_assoc($qu_sum_EXE);
						$total_amount = $qu_sum_REC['total'];
						$show_complete = '1';
					}
					$qu_sum_sel = "SELECT IFNULL(SUM(total_cost),0) as total FROM  `z_boq` boq , z_manhour_detail boqDet WHERE boq.boq_id = boqDet.boq_id and `level1_id` = $level1_id and level2_id = $level2_id and level3_id = $level3_id and level4_id = $level4_id"  ;
					$qu_sum_EXE = mysqli_query($KONN, $qu_sum_sel);
					
					if(mysqli_num_rows($qu_sum_EXE)){
						$qu_sum_REC = mysqli_fetch_assoc($qu_sum_EXE);
						$total_amount = (float) $total_amount+(float)$qu_sum_REC['total'];
						$show_complete = '1';
					}
				}
				
				else{
					$qu_boq_sel = "SELECT * FROM  `z_boq` boq WHERE `level1_id` = $level1_id  and level2_id = $level2_id and level3_id = $level3_id and level4_id = $level4_id and level5_id = 0 "  ;
					$qu_boq_EXE = mysqli_query($KONN, $qu_boq_sel);
					if(mysqli_num_rows($qu_boq_EXE)){
						$qu_boq_REC = mysqli_fetch_assoc($qu_boq_EXE);
						$boq_id = $qu_boq_REC['boq_id'];
						
						
						$qu_sum_sel = "SELECT IFNULL(SUM(boq_total),0) as total FROM  `z_boq_details`  WHERE boq_id = $boq_id"  ;
						$qu_sum_EXE = mysqli_query($KONN, $qu_sum_sel);
						
						if(mysqli_num_rows($qu_sum_EXE)){
							$qu_sum_REC = mysqli_fetch_assoc($qu_sum_EXE);
							$total_amount = $qu_sum_REC['total'];
						}
						$qu_sum_sel = "SELECT IFNULL(SUM(total_cost),0) as total FROM  `z_manhour_detail`  WHERE boq_id = $boq_id"  ;
						$qu_sum_EXE = mysqli_query($KONN, $qu_sum_sel);
						
						if(mysqli_num_rows($qu_sum_EXE)){
							$qu_sum_REC = mysqli_fetch_assoc($qu_sum_EXE);
							$total_amount = (float)$total_amount + (float)$qu_sum_REC['total'];
						}
					}
				}
			}
			
			$IAM_ARRAY[] = array(  "sno" => $sNo, 
			"level4_id" => $level4_id, 
			"level4_name" => $level4_name, 
			"level3_id" => $level3_id, 
			"quantity" => $quantity, 
			"complexity" => $complexity, 
			"length" => $length, 
			"surface_area" => $surface_area, 
			"cost" => $cost, 
			"level4_description" => $level4_description, 
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
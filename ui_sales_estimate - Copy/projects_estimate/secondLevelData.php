<?php
	require_once('../../bootstrap/app_config.php');
	require_once('../../bootstrap/chk_log_user.php');
	
	$IAM_ARRAY  = array();
	
	
	$level2_id = 0;
	$level1_id = 0;
	if( isset( $_POST['id'] ) ){
		$level2_id = ( int ) test_inputs( $_POST['id'] );
	}
	if( isset( $_POST['level1_id'] ) ){
		$level1_id = ( int ) test_inputs( $_POST['level1_id'] );
	}
	
	
	
	
	
	
	$sNo =  1;
	$qu_project_level3_sel = "SELECT * FROM  `z_project_level3` l3, z_levels_type t WHERE `level2_id` = $level2_id and t.type_id = l3.type_id";
	$qu_project_level3_EXE = mysqli_query($KONN, $qu_project_level3_sel);
	if(mysqli_num_rows($qu_project_level3_EXE)){
		while($project_level3_REC = mysqli_fetch_assoc($qu_project_level3_EXE)){
			$level3_id = $project_level3_REC['level3_id'];
			$level3_name = $project_level3_REC['level3_name'];
			$level2_id = $project_level3_REC['level2_id'];
			$level3_description = $project_level3_REC['level3_description'];
			$type_id = $project_level3_REC['type_id'];
			$type_name = $project_level3_REC['type_name'];
			
			$qu_prject_sel = "SELECT count(*) as count FROM  `z_project_level4` WHERE `level3_id` = $level3_id "  ;
			$qu_project_EXE = mysqli_query($KONN, $qu_prject_sel);
			$total_amount = 0;
			$boq_id =0;
			$show_complete = '0';
			if(mysqli_num_rows($qu_project_EXE)){
				$qu_project_REC = mysqli_fetch_assoc($qu_project_EXE);
				$count = $qu_project_REC['count'];
				if($count != 0){
					
					$qu_sum_sel = "SELECT IFNULL(SUM(boq_total),0) as total FROM  `z_boq` boq , z_boq_details boqDet WHERE boq.boq_id = boqDet.boq_id and `level1_id` = $level1_id and level2_id = $level2_id and level3_id = $level3_id" ;
					$qu_sum_EXE = mysqli_query($KONN, $qu_sum_sel);
					
					if(mysqli_num_rows($qu_sum_EXE)){
						$qu_sum_REC = mysqli_fetch_assoc($qu_sum_EXE);
						$total_amount = $qu_sum_REC['total'];
						$show_complete = '1';
					}
					$qu_sum_sel = "SELECT IFNULL(SUM(total_cost),0) as total FROM  `z_boq` boq , z_manhour_detail boqDet WHERE boq.boq_id = boqDet.boq_id and `level1_id` = $level1_id and level2_id = $level2_id and level3_id = $level3_id"  ;
					$qu_sum_EXE = mysqli_query($KONN, $qu_sum_sel);
					
					if(mysqli_num_rows($qu_sum_EXE)){
						$qu_sum_REC = mysqli_fetch_assoc($qu_sum_EXE);
						$total_amount = (float) $total_amount+(float)$qu_sum_REC['total'];
						$show_complete = '1';
					}
				}
				
				else{
					$qu_boq_sel = "SELECT * FROM  `z_boq` boq WHERE `level1_id` = $level1_id  and level2_id = $level2_id and level3_id = $level3_id and level4_id = 0 and level5_id = 0 "  ;
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
			"level3_id" => $level3_id, 
			"level3_name" => $level3_name, 
			"level2_id" => $level2_id, 
			"level3_description" => $level3_description, 
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
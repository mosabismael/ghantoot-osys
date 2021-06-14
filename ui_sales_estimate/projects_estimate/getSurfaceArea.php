
<?php
	require_once('../../bootstrap/app_config.php');
	require_once('../../bootstrap/chk_log_user.php');
	
	$IAM_ARRAY = array();
	
	
	$level1_id = 0;
	
	if( isset( $_POST['level1_id'] ) ){
		$level1_id = ( int ) test_inputs( $_POST['level1_id'] );
	}
	
	
	
	
	
	
	
	$sNo =  1;
	$qu_project_level2_sel = "SELECT * FROM  `z_project_level2` l2, `z_project_level3` l3 , `z_boq` boq , `z_boq_details` boqdet WHERE boq.boq_id = boqdet.boq_id and boq.level1_id = l2.level1_id and boq.level2_id = l2.level2_id and boq.level3_id = l3.level3_id and boq.level4_id = 0 and boq.level5_id = 0 and l2.level2_id = l3.level2_id and l2.level1_id = $level1_id and l2.level2_name = 'Steel';" ;
	//echo $qu_project_level2_sel;
	$qu_project_level2_EXE = mysqli_query($KONN, $qu_project_level2_sel);
	$tot_sa = 0;
	$boq_sa_unit = 15;
	if(mysqli_num_rows($qu_project_level2_EXE)){
		while($project_level2_REC = mysqli_fetch_assoc($qu_project_level2_EXE)){
			
			$boq_sa = $project_level2_REC['boq_surfacearea'];
			$boq_sa_unit = $project_level2_REC['boq_surfacearea_unit_id'];
			
			$tot_sa += $boq_sa;
			
			
			$sNo++;
		}
		
		
	}
	$IAM_ARRAY = array(  "tot_sa" => $tot_sa,
	"total_sa_unit" => $boq_sa_unit
	);
	echo json_encode($IAM_ARRAY);
	
	
?>



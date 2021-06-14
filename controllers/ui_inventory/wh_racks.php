
<?php
	require_once('../../bootstrap/app_config.php');
	require_once('../../bootstrap/chk_log_user.php');
	
	$IAM_ARRAY = array();
	
	
	$CUR_PAGE = 0;
	$per_page = 20;
	$totPages = 0;
	
	if( isset( $_POST['page'] ) ){
		$CUR_PAGE = ( int ) test_inputs( $_POST['page'] );
	}
	if( isset( $_POST['showperpage'] ) ){
		$per_page = ( int ) test_inputs( $_POST['showperpage'] );
	}
	
	$start=abs(($CUR_PAGE-1)*$per_page);
	
	
	$serchCond = "";
	if( isset( $_POST['cond'] ) ){
		$serchCond = $_POST['cond'];
	}
	
	
	
	
	
	
	$sNo = $start + 1;
	$qu_wh_racks_sel = "SELECT * FROM  `wh_racks` $serchCond ORDER BY `rack_id` DESC LIMIT $start,$per_page";

	$qu_wh_racks_EXE = mysqli_query($KONN, $qu_wh_racks_sel);
	if(mysqli_num_rows($qu_wh_racks_EXE)){
		while($wh_racks_REC = mysqli_fetch_assoc($qu_wh_racks_EXE)){
			
			$rack_id = $wh_racks_REC['rack_id'];
			$rack_name = $wh_racks_REC['rack_name'];
			$area_id = $wh_racks_REC['area_id'];
			
			
			
			
			
	$qu_wh_areas_sel = "SELECT * FROM  `wh_areas` WHERE `area_id` = $area_id";
	$qu_wh_areas_EXE = mysqli_query($KONN, $qu_wh_areas_sel);
	$area_name = "NA";
	if(mysqli_num_rows($qu_wh_areas_EXE)){
		$wh_areas_DATA = mysqli_fetch_assoc($qu_wh_areas_EXE);
		$area_id = $wh_areas_DATA['area_id'];
		$area_name = $wh_areas_DATA['area_name'];
	}

		

$IAM_ARRAY[] = array(  "sNo" => $sNo, 
					"rack_id" => $rack_id, 
					"rack_name" => $rack_name, 
					"area_id" => $area_id, 
					"area_name" => $area_name
					);
					
		
		$sNo++;
		}
		
	}
	echo json_encode($IAM_ARRAY);
	
?>






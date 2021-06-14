<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	$levelName = $_GET["levelName"];
	$id = $_GET["id"];
	
	if($levelName == "level1"){
		$qu_project_level1_sel = "SELECT count(*) as count FROM  `z_project_level2` WHERE `level1_id` = $id";
		$qu_project_level1_EXE = mysqli_query($KONN, $qu_project_level1_sel);
		$project_level1_DATA;
		$count = 0;
		if(mysqli_num_rows($qu_project_level1_EXE)){
			$project_level1_DATA = mysqli_fetch_assoc($qu_project_level1_EXE);
			$count = $project_level1_DATA['count'];
		}
		if($count == 0){
			$qu_project_level1_del = "DELETE FROM `z_project_level1` WHERE `level1_id` = $id";
			mysqli_query($KONN, $qu_project_level1_del);
			$res = ["status" => "0"];
		}
		else{
			$res = ["status" => "1"];
			header('Content-Type: application/json');
			echo json_encode($res);
		}
		
	}
	else if($levelName == "level2"){
		$qu_project_level2_sel = "SELECT count(*) as count FROM  `z_project_level3` WHERE `level2_id` = $id";
		$qu_project_level2_EXE = mysqli_query($KONN, $qu_project_level2_sel);
		$project_level3_DATA;
		$count = 0;
		if(mysqli_num_rows($qu_project_level2_EXE)){
			$project_level2_DATA = mysqli_fetch_assoc($qu_project_level2_EXE);
			$count = $project_level2_DATA['count'];
		}
		if($count == 0){
			$qu_project_level2_del = "DELETE FROM `z_project_level2` WHERE `level2_id` = $id";
			mysqli_query($KONN, $qu_project_level2_del);
			$res = ["status" => "0"];
		}
		else{
			$res = ["status" => "1"];
			header('Content-Type: application/json');
			echo json_encode($res);
		}
	}
	else if($levelName == "level3"){
		$qu_project_level3_sel = "SELECT count(*) as count FROM  `z_project_level4` WHERE `level3_id` = $id";
		$qu_project_level3_EXE = mysqli_query($KONN, $qu_project_level3_sel);
		$project_level3_DATA;
		$count = 0;
		if(mysqli_num_rows($qu_project_level3_EXE)){
			$project_level3_DATA = mysqli_fetch_assoc($qu_project_level3_EXE);
			$count = $project_level3_DATA['count'];
		}
		if($count == 0){
			$qu_project_level3_del = "DELETE FROM `z_project_level3` WHERE `level3_id` = $id";
			mysqli_query($KONN, $qu_project_level3_del);
			$res = ["status" => "0"];
		}
		else{
			$res = ["status" => "1"];
			header('Content-Type: application/json');
			echo json_encode($res);
		}
	}
	else if($levelName == "level4"){
		$qu_project_level4_sel = "SELECT count(*) as count FROM  `z_project_level5` WHERE `level4_id` = $id";
		$qu_project_level4_EXE = mysqli_query($KONN, $qu_project_level4_sel);
		$project_level4_DATA;
		$count = 0;
		if(mysqli_num_rows($qu_project_level4_EXE)){
			$project_level4_DATA = mysqli_fetch_assoc($qu_project_level4_EXE);
			$count = $project_level4_DATA['count'];
		}
		if($count == 0){
			$qu_project_level4_del = "DELETE FROM `z_project_level4` WHERE `level4_id` = $id";
			mysqli_query($KONN, $qu_project_level4_del);
			$res = ["status" => "0"];
		}
		else{
			$res = ["status" => "1"];
			header('Content-Type: application/json');
			echo json_encode($res);
		}
	}
	else if($levelName == "level5"){
		
		$qu_project_level5_del = "DELETE FROM `z_project_level5` WHERE `level5_id` = $id";
		mysqli_query($KONN, $qu_project_level5_del);
		$res = ["status" => "0"];
	}
	else if($levelName == "boq"){
		$qu_boq_del = "DELETE FROM `boq` WHERE `boq_id` = $id";
		mysqli_query($KONN, $qu_boq_del);
		$res = ["status" => "0"];
	}
	else{
		$res = ["status" => "2"];
	}
?>
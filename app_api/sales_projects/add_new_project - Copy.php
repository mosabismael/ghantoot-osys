<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		
		if( isset($_POST['client_id']) &&
		isset($_POST['project_name']) && 
		isset($_POST['project_notes']) &&
		isset($_POST['project_type'])
		){
			
			
			$project_id = 0;
			$client_id = ( int ) test_inputs($_POST['client_id']);
			
			$project_name = test_inputs($_POST['project_name']);
			
			$created_date = date("Y-m-d");
			$project_status = "draft";
			
			$project_notes = "";
			if( isset($_POST['project_notes']) ){
				$project_notes = test_inputs( $_POST['project_notes'] );
			}
			
			$project_type = test_inputs($_POST['project_type']);
			
			$qu_z_project_ins = "INSERT INTO `z_project` (
			`project_name`, 
			`created_date`, 
			`project_notes`, 
			`client_id`, 
			`employee_id`, 
			`project_status` ,
			`project_type`
			) VALUES (
			'".$project_name."', 
			'".$created_date."', 
			'".$project_notes."', 
			'".$client_id."', 
			'".$EMPLOYEE_ID."', 
			'".$project_status."',
			'".$project_type."'
			);";
			
			$insertStatement = mysqli_prepare($KONN,$qu_z_project_ins);
			
			mysqli_stmt_execute($insertStatement);
			
			$project_id = mysqli_insert_id($KONN);
			if( $project_id != 0 ){
				
				
				$qu_level1_template_SEL = "SELECT * FROM `z_project_level1_template` order by arrange asc ";
				$qu_level1_template_EXE = mysqli_query($KONN, $qu_level1_template_SEL);
				if(mysqli_num_rows($qu_level1_template_EXE)){
					while($level1_template_REC = mysqli_fetch_assoc($qu_level1_template_EXE)){
						$level1_name = $level1_template_REC['level1_name'];
						
						$qu_level1_insert = "INSERT INTO `z_project_level1` (
						`level1_name`, 
						`type_id`, 
						`project_id` 
						) VALUES (
						'".$level1_name."', 
						'1', 
						'".$project_id."' 
						);";
						$insertStatement = mysqli_prepare($KONN,$qu_level1_insert);
						mysqli_stmt_execute($insertStatement);
						if($level1_name == 'materials'){
							$level1_id = mysqli_insert_id($KONN);
							$qu_level2_material_template_SEL = "SELECT * FROM `z_project_level2_material_template` ";
							$qu_level2_material_template_EXE = mysqli_query($KONN, $qu_level2_material_template_SEL);
							if(mysqli_num_rows($qu_level2_material_template_EXE)){
								while($qu_level2_material_template_REC = mysqli_fetch_assoc($qu_level2_material_template_EXE)){
									$level2_material_name = $qu_level2_material_template_REC['level2_material_name'];
									
									$qu_level2_insert = "INSERT INTO `z_project_level2` (
									`level2_name`, 
									`type_id`, 
									`level1_id` 
									) VALUES (
									'".$level2_material_name."', 
									'4', 
									'".$level1_id."' 
									);";
									$insertStatement1 = mysqli_prepare($KONN,$qu_level2_insert);
									mysqli_stmt_execute($insertStatement1);
								}
							}
						}
					}
				}
				die('1|projects_list.php?added=1');
				
				
				
				
				
				
			}
			
			
			
			
			
			} else {
			die('0|7wiu');
		}
	}
	catch(Exception $e){
		if ( is_resource($KONN)) {
			mysqli_close($KONN);
		}
	}
	finally{
		if ( is_resource($KONN)) {
			mysqli_close($KONN);
		}
	}
?>
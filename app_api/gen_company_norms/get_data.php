<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	
	try{
		
		
		if(!isset($_POST['ids_id'])){
			die('7wiu');
		}
		
		$norm_id = (int) test_inputs( $_POST['ids_id'] );
		$IAM_ARRAY;
		
		$q = "SELECT * FROM  `gen_company_norms` WHERE `norm_id` = $norm_id";
		$userStatement = mysqli_prepare($KONN,$q);
		mysqli_stmt_execute($userStatement);
		$q_exe = mysqli_stmt_get_result($userStatement);
		
		if(mysqli_num_rows($q_exe) == 0){
			
				$IAM_ARRAY[] = array(  "norm_id" => 0, 
										"norm_act_name" => 0, 
										"unit_id" => 0, 
										"activity_kpi" => 0, 
										"manhour_cost" => 0 
										);

			
			
			
			} else {
			$ARRAY_SRC = mysqli_fetch_assoc($q_exe);
			
			
			$IAM_ARRAY[] = array(  "norm_id" => $ARRAY_SRC['norm_id'], 
									"group_name" => $ARRAY_SRC['group_name'], 
									"process_name" => $ARRAY_SRC['process_name'], 
									"norm_act_name" => $ARRAY_SRC['norm_act_name'], 
									"unit_id" => $ARRAY_SRC['unit_id'], 
									"activity_kpi" => $ARRAY_SRC['activity_kpi'], 
									"manhour_cost" => $ARRAY_SRC['manhour_cost'] 
									);
			
			
			
		}
		
		
		echo json_encode($IAM_ARRAY);
		
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

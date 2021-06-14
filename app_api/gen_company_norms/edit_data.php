<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		if( isset($_POST['norm_id']) &&
			isset($_POST['norm_act_name']) &&
			isset($_POST['group_name']) &&
			isset($_POST['process_name']) &&
			isset($_POST['norm_act_name']) &&
			isset($_POST['unit_id']) &&
			isset($_POST['activity_kpi']) &&
			isset($_POST['manhour_cost']) 
			){
			
			
			

			$norm_id = test_inputs($_POST['norm_id']);
			$group_name = test_inputs($_POST['group_name']);
			$process_name = test_inputs($_POST['process_name']);
			$norm_act_name = test_inputs($_POST['norm_act_name']);
			$unit_id = test_inputs($_POST['unit_id']);
			$activity_kpi = test_inputs($_POST['activity_kpi']);
			$manhour_cost = test_inputs($_POST['manhour_cost']);
			
					
			$qu_gen_company_norms_sel = "SELECT * FROM  `gen_company_norms` WHERE ((`norm_id` <> '$norm_id') AND (`norm_act_name` = '$norm_act_name')) ";
			$userStatement = mysqli_prepare($KONN,$qu_gen_company_norms_sel);
			mysqli_stmt_execute($userStatement);
			$qu_gen_company_norms_EXE = mysqli_stmt_get_result($userStatement);
			$gen_company_norms_DATA;
			if(mysqli_num_rows($qu_gen_company_norms_EXE)){
				die("0|Activity Name Already Exist");
			}
			
			
			$qu_gen_company_norms_updt = "UPDATE  `gen_company_norms` SET 
								`group_name` = '".$group_name."', 
								`process_name` = '".$process_name."', 
								`norm_act_name` = '".$norm_act_name."', 
								`unit_id` = '".$unit_id."', 
								`activity_kpi` = '".$activity_kpi."', 
								`manhour_cost` = '".$manhour_cost."'
								WHERE `norm_id` = $norm_id;";
						
			$updateStatement = mysqli_prepare($KONN,$qu_gen_company_norms_updt);
			mysqli_stmt_execute($updateStatement);
			if( $norm_id != 0 ){
				
				
				if( insert_state_change($KONN, "Data Edited", $norm_id, "gen_company_norms", $EMPLOYEE_ID) ) {
					die("1|Norm Edited");
					} else {
					die('0|Data Status Error 65154');
				}
				
				
				
				
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

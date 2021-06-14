<?php
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		if( !isset( $_POST['requisition_id'] ) ){
			die('0|ERR_REQ_4568674653');
		}
		if( !isset( $_POST['rejection_notes'] ) ){
			die('0|ERR_REQ_4568674653');
		}
		
		$requisition_id = ( int ) $_POST['requisition_id'];
		$rejection_notes = $_POST['rejection_notes'];
		
		
		$requisition_status = 'sent_back';
		
		$qu_pur_requisitions_updt = "UPDATE  `pur_requisitions` SET 
		`rejection_notes` = '".$rejection_notes."', 
		`requisition_status` = '".$requisition_status."' 
		WHERE `requisition_id` = $requisition_id;";
		$updateStatement = mysqli_prepare($KONN,$qu_pur_requisitions_updt);
		mysqli_stmt_execute($updateStatement);
		if( insert_state_change($KONN, $requisition_status, $requisition_id, "pur_requisitions", $EMPLOYEE_ID) ){
			// die("1|Good");
			
			
			
			$current_state_id = get_current_state_id($KONN, $requisition_id, 'pur_requisitions' );
			if( $current_state_id != 0 ){
				if( !insert_state_change_dep($KONN, "Rejected-PUR", $requisition_id, $rejection_notes, 'pur_requisitions', $EMPLOYEE_ID, $current_state_id) ){
					die('0|Component State Error 01');
				}
				} else {
				die('0|Component State Error 02');
			}
			
			
			//convert to draft
			
			$requisition_status = 'draft';
			
			$qu_pur_updt = "UPDATE  `pur_requisitions` SET 
			`requisition_status` = '".$requisition_status."'
			WHERE `requisition_id` = $requisition_id;";
			$updateStatement = mysqli_prepare($KONN,$qu_pur_updt);
			mysqli_stmt_execute($updateStatement);
			
			//get PM ID
			$qu_gen_status_change_sel = "SELECT * FROM  `gen_status_change` WHERE ((`status_action` = 'draft') AND (`item_id` = '$requisition_id') AND (`item_type` = 'pur_requisitions')) ORDER BY `status_id` DESC  ";
			$userStatement = mysqli_prepare($KONN,$qu_gen_status_change_sel);
			mysqli_stmt_execute($userStatement);
			$qu_gen_status_change_EXE = mysqli_stmt_get_result($userStatement);
			$pmID = 0;
			if(mysqli_num_rows($qu_gen_status_change_EXE)){
				$gen_status_change_DATA = mysqli_fetch_assoc($qu_gen_status_change_EXE);
				$pmID = ( int ) $gen_status_change_DATA['action_by'];
			}
			
			
			
			
			if( insert_state_change($KONN, $requisition_status, $requisition_id, "pur_requisitions", $pmID) ){
				
				die("1|Good");
			}
			
			
			
			
			
			
			
			
			
			
			
			
			} else {
			die('0|Component State Error 01');
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

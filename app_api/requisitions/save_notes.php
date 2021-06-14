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
		if( !isset( $_POST['requisition_notes'] ) ){
			die('0|ERR_REQ_45655553');
		}
		
		$requisition_id = ( int ) $_POST['requisition_id'];
		$requisition_notes = test_inputs( $_POST['requisition_notes'] );
		
		
		$requisition_status = 'finish_req';
		
		$qu_pur_requisitions_updt = "UPDATE  `pur_requisitions` SET 
		`requisition_notes` = '".$requisition_notes."'
		WHERE `requisition_id` = $requisition_id;";
		$updateStatement = mysqli_prepare($KONN,$qu_pur_requisitions_updt);
		mysqli_stmt_execute($updateStatement);
		
		
		$current_state_id = get_current_state_id($KONN, $requisition_id, 'pur_requisitions' );
		if( $current_state_id != 0 ){
			if( insert_state_change_dep($KONN, "Saved-Notes", $requisition_id, $requisition_notes, 'pur_requisitions', $EMPLOYEE_ID, $current_state_id) ){
				die("1|Good");
			}
			} else {
			die('0|Component State Error 02');
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

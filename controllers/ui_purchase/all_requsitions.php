
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
	$qu_pur_requisitions_sel = "SELECT * FROM  `pur_requisitions` WHERE ( ( `requisition_status` <> 'deleted' )  $serchCond ) ORDER BY `requisition_id` ASC LIMIT $start,$per_page";


	$qu_pur_requisitions_EXE = mysqli_query($KONN, $qu_pur_requisitions_sel);
	if(mysqli_num_rows($qu_pur_requisitions_EXE)){
		while($pur_requisitions_REC = mysqli_fetch_assoc($qu_pur_requisitions_EXE)){
			
			
			
		$requisition_id = $pur_requisitions_REC['requisition_id'];
		$requisition_ref = $pur_requisitions_REC['requisition_ref'];
		$requisition_type = $pur_requisitions_REC['requisition_type'];
		$requisition_status = $pur_requisitions_REC['requisition_status'];
		$requisition_notes = $pur_requisitions_REC['requisition_notes'];
		$ordered_by = $pur_requisitions_REC['ordered_by'];
		$created_date = $pur_requisitions_REC['created_date'];
		
		$BY = get_emp_name($KONN, $ordered_by );
		
		

$IAM_ARRAY[] = array(  "sno" => $sNo, 
					"requisition_id" => $pur_requisitions_REC['requisition_id'], 
					"requisition_ref" => $pur_requisitions_REC['requisition_ref'], 
					"created_date" => $pur_requisitions_REC['created_date'], 
					"BY" => $BY, 
					"requisition_status" => $pur_requisitions_REC['requisition_status']
					);
		
		$sNo++;
		}
		
						
	}
		echo json_encode($IAM_ARRAY);
	
?>



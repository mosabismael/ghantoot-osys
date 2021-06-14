<?php
	
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	$item_name = '';
	$reqItmID = 0;
	$IAM_ARRAY;
	
	try{
		
		if(!isset($_POST['requisition_id'])){
			die('7wiu');
		}
		
		if(!isset($_POST['req_item_ids'])){
			die('7wiu02');
		}
		
		$requisition_id = (int) test_inputs( $_POST['requisition_id'] );
		$req_item_ids_REQUEST = $_POST['req_item_ids'];
		$reqItms_ids = explode( '-', $req_item_ids_REQUEST );
		
		
		for( $A=0 ; $A < count( $reqItms_ids ) ; $A++ ){
			$CC = $A + 1;
			$reqItmID = ( int ) $reqItms_ids[$A];
			$qu_pur_requisitions_items_sel = "SELECT * FROM  `pur_requisitions_items` WHERE `req_item_id` = $reqItmID";
			$userStatement = mysqli_prepare($KONN,$qu_pur_requisitions_items_sel);
			mysqli_stmt_execute($userStatement);
			$qu_pur_requisitions_items_EXE = mysqli_stmt_get_result($userStatement);
			$item_name = "";
			if(mysqli_num_rows($qu_pur_requisitions_items_EXE)){
				$pur_requisitions_items_DATA = mysqli_fetch_assoc($qu_pur_requisitions_items_EXE);
				$req_item_id = $pur_requisitions_items_DATA['req_item_id'];
				$family_id = $pur_requisitions_items_DATA['family_id'];
				$section_id = $pur_requisitions_items_DATA['section_id'];
				$division_id = $pur_requisitions_items_DATA['division_id'];
				$subdivision_id = $pur_requisitions_items_DATA['subdivision_id'];
				$category_id = $pur_requisitions_items_DATA['category_id'];
				$item_code_id = $pur_requisitions_items_DATA['item_code_id'];
				$item_qty = $pur_requisitions_items_DATA['item_qty'];
				$certificate_required = $pur_requisitions_items_DATA['certificate_required'];
				$item_unit_id = $pur_requisitions_items_DATA['item_unit_id'];
				$unitName = get_item_unit_name( $pur_requisitions_items_DATA['item_unit_id'], $KONN );
				
				$family_id = $pur_requisitions_items_DATA['family_id'];
				$lv2 = $pur_requisitions_items_DATA['section_id'];
				$lv3 = $pur_requisitions_items_DATA['division_id'];
				$lv4 = $pur_requisitions_items_DATA['subdivision_id'];
				$lv5 = $pur_requisitions_items_DATA['category_id'];
				
				$item_namer = get_item_description( $pur_requisitions_items_DATA['req_item_id'], 'req_item_id', 'pur_requisitions_items', $KONN );
				$item_namer = rtrim($item_namer, '<br></div>');
				$item_namer = str_replace('<br>', '%0D%0A      ', $item_namer);
				$item_namer = strip_tags($item_namer); 
				$item_name .= $CC.'  '.$item_namer.'                                                 '.$item_qty.'                '.$unitName. '               '.$certificate_required.'%0D%0A';
				
				$IAM_ARRAY[] = array(  "req_item_id" => $req_item_id, 
				"item_name" => $item_name
				);
			}
			
			
			
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

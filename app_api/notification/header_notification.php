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
	$qu_purchase_orders_sel = "SELECT count(*)  as count , notification_title FROM  `users_notifications` where is_notified = 0  and po_id != 0 $serchCond group by is_notified;";
	$qu_purchase_orders_EXE = mysqli_query($KONN, $qu_purchase_orders_sel);
	if(mysqli_num_rows($qu_purchase_orders_EXE)){
		while($purchase_orders_REC = mysqli_fetch_assoc($qu_purchase_orders_EXE)){
			
			$count = $purchase_orders_REC['count'];
			$po_status = $purchase_orders_REC['notification_title'];
		
			
			
			
			$IAM_ARRAY[] = array(  "sNo" => $sNo, 
			"count" => (int)$count,
			"po_status" => $po_status
			);
			
			
		}
		
	}
	
	
		echo json_encode($IAM_ARRAY);
	
?>



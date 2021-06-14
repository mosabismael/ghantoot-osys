
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
	$qu_inv_mrvs_sel = "SELECT * FROM  `inv_mrvs` WHERE `mrv_status` = 'inspection_required' $serchCond ORDER BY `mrv_id` DESC LIMIT $start,$per_page";

	$qu_inv_mrvs_EXE = mysqli_query($KONN, $qu_inv_mrvs_sel);
	if(mysqli_num_rows($qu_inv_mrvs_EXE)){
		while($inv_mrvs_REC = mysqli_fetch_assoc($qu_inv_mrvs_EXE)){
			
		$mrv_id           = ( int ) $inv_mrvs_REC['mrv_id'];
		$po_id            = ( int ) $inv_mrvs_REC['po_id'];
		$mrv_ref          = $inv_mrvs_REC['mrv_ref'];
		$created_date     = $inv_mrvs_REC['created_date'];
		$created_byID     = ( int ) $inv_mrvs_REC['created_by'];
		$inspected_date   = $inv_mrvs_REC['inspected_date'];
		$inspected_byID   = ( int ) $inv_mrvs_REC['inspected_by'];
		$mrv_status       = $inv_mrvs_REC['mrv_status'];
		$supplier_id      = ( int ) $inv_mrvs_REC['supplier_id'];
		
		
		if( $created_byID != 0 ){
			$created_by = get_emp_name($KONN, $created_byID );
		} else {
			$created_by = "NA";
			$created_date = "NA";
		}
		
		if( $inspected_byID != 0 ){
			$inspected_by = get_emp_name($KONN, $inspected_byID );
		} else {
			$inspected_by = "NA";
			$inspected_date = "NA";
		}
		
		if( $supplier_id != 0 ){
			$supplier = get_supplier_name( $supplier_id, $KONN );
		} else {
			$supplier = "NA";
		}
		
		$po_ref = "NA";
	$qu_purchase_orders_sel = "SELECT * FROM  `purchase_orders` WHERE `po_id` = $po_id";
	$qu_purchase_orders_EXE = mysqli_query($KONN, $qu_purchase_orders_sel);
	$purchase_orders_DATA;
	if(mysqli_num_rows($qu_purchase_orders_EXE)){
		$purchase_orders_DATA = mysqli_fetch_assoc($qu_purchase_orders_EXE);
		$po_ref = $purchase_orders_DATA['po_ref'];
	}

		

$IAM_ARRAY[] = array(  "mrv_id" => $mrv_id, 
					"mrv_ref" => $mrv_ref, 
					"supplier" => $supplier, 
					"po_ref" => $po_ref, 
					"po_id" => $po_id,
					"inspected_date" => $inspected_date, 
					"created_date" => $created_date, 
					"created_by" => $created_by ,
					"inspected_by" => $inspected_by, 
					"mrv_status" => $mrv_status,
					"inspected_byID" => $inspected_byID,
					"employee_id" => $EMPLOYEE_ID
					);
					
		
		$sNo++;
		}
		
	}
	echo json_encode($IAM_ARRAY);
	
?>








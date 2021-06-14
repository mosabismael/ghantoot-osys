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
	$qu_suppliers_list_sel = "SELECT * FROM  `suppliers_list` $serchCond ORDER BY `supplier_name` ASC LIMIT $start,$per_page";

	$qu_suppliers_list_EXE = mysqli_query($KONN, $qu_suppliers_list_sel);
	if(mysqli_num_rows($qu_suppliers_list_EXE)){
		while($suppliers_list_REC = mysqli_fetch_assoc($qu_suppliers_list_EXE)){
		$supplier_id = $suppliers_list_REC['supplier_id'];
		$supplier_code = $suppliers_list_REC['supplier_code'];
		$supplier_name = $suppliers_list_REC['supplier_name'];
		$supplier_type = $suppliers_list_REC['supplier_type'];
		$supplier_cat = $suppliers_list_REC['supplier_cat'];
		$supplier_email = $suppliers_list_REC['supplier_email'];
		$website = $suppliers_list_REC['website'];
		$country = $suppliers_list_REC['country'];
		$address = $suppliers_list_REC['address'];
		$supplier_phone = $suppliers_list_REC['supplier_phone'];
		$trn_no = $suppliers_list_REC['trn_no'];
		$is_approved = ( int ) $suppliers_list_REC['is_approved'];
		
		$btnTXT = "approve";
		if($is_approved == 1){
			$btnTXT = "Remove_From_Approved";
			$is_approved = 0;
		} else {
			$is_approved = 1;
		}
    
$IAM_ARRAY[] = array(  "sNo" => $sNo, 
						"supplier_id" => $supplier_id,
						"supplier_code" => $supplier_code,
						"supplier_name" => $supplier_name, 
						"supplier_type" => $supplier_type, 
						"supplier_cat" => $supplier_cat, 
						"supplier_email" => $supplier_email, 
						"website" => $website, 
						"country" => $country, 
						"address" => $address, 
						"supplier_phone" => $supplier_phone, 
						"trn_no" => $trn_no, 
						"btn" => $btnTXT, 
						"is_approved" => $is_approved 
						);
						
		$sNo++;
		}
		
							
	}
		echo json_encode($IAM_ARRAY);
	
?>


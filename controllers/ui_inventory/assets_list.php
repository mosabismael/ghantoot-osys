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
	$qu_inv_assets_sel = "SELECT * FROM  `inv_assets` $serchCond ORDER BY `asset_id` DESC LIMIT $start,$per_page";


	$qu_inv_assets_EXE = mysqli_query($KONN, $qu_inv_assets_sel);
	if(mysqli_num_rows($qu_inv_assets_EXE)){
		while($inv_assets_REC = mysqli_fetch_assoc($qu_inv_assets_EXE)){
			
			$asset_id = $inv_assets_REC['asset_id'];
			$asset_tag = $inv_assets_REC['asset_tag'];
			$asset_name = $inv_assets_REC['asset_name'];
			$asset_sno = $inv_assets_REC['asset_sno'];
			$asset_brand = $inv_assets_REC['asset_brand'];
			$asset_po = $inv_assets_REC['asset_po'];
			$asset_certificate = $inv_assets_REC['asset_certificate'];
			$asset_status = $inv_assets_REC['asset_status'];
			$asset_cat_id = $inv_assets_REC['asset_cat_id'];
			
			
			
			
	$qu_inv_assets_cats_sel = "SELECT * FROM  `inv_assets_cats` WHERE `asset_cat_id` = $asset_cat_id";
	$qu_inv_assets_cats_EXE = mysqli_query($KONN, $qu_inv_assets_cats_sel);
	$area_id = 0;
	$asset_cat_name = "NA";
	if(mysqli_num_rows($qu_inv_assets_cats_EXE)){
		$inv_assets_cats_DATA = mysqli_fetch_assoc($qu_inv_assets_cats_EXE);
		$asset_cat_name = $inv_assets_cats_DATA['asset_cat_name'];
	}
		
		

$IAM_ARRAY[] = array(  "sno" => $sNo, 
					"asset_id" => $asset_id, 
					"asset_name" => $asset_name, 
					"asset_sno" => $asset_sno, 
					"asset_brand" => $asset_brand, 
					"asset_cat_name" => $asset_cat_name, 
					"asset_status" => $asset_status 
					);
		
		$sNo++;
		}
		
							
	}
	echo json_encode($IAM_ARRAY);
	
?>

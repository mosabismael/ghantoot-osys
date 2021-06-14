<?php
		$OFFSET = 0;
		$barcode = 0;
	if(isset($_GET["barcode"])){
			$barcode = $_GET["barcode"];
	}
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/app_db.php');


	$IAM_ARRAY;
				$sNo = $OFFSET ;
				$qu_pur_requisitions_sel = "SELECT item.item_name, stock.qty, inmiv.created_date as invoicedate , mrv.created_date as receiveddate ,DATEDIFF(inmiv.created_date , mrv.created_date) as date FROM inv_stock stock , inv_mrvs mrv,inv_mivs inmiv , inv_mivs_items mivitems ,inv_06_codes item where stock.category_id = item.code_id and mrv.mrv_id = stock.mrv_id and mivitems.stock_id = stock.stock_id and mivitems.miv_id = inmiv.miv_id and stock.stock_barcode='$barcode';" ;
				$newobj ;
				$qu_pur_requisitions_EXE = mysqli_query($KONN, $qu_pur_requisitions_sel);
				if(mysqli_num_rows($qu_pur_requisitions_EXE)){
				while($pur_requisitions_REC = mysqli_fetch_assoc($qu_pur_requisitions_EXE)){
					$sNo++;
					
					
					
$IAM_ARRAY[] = array(  "sno" => $sNo, 
					"item_name" => $pur_requisitions_REC['item_name'], 
					"date" => intval($pur_requisitions_REC['date']),
					"qty" => intval($pur_requisitions_REC['qty']),
					"receiveddate" => $pur_requisitions_REC['receiveddate'],
					"invoicedate" => $pur_requisitions_REC['invoicedate']
					);
					
								}
				}
							echo json_encode($IAM_ARRAY);
						?>
				
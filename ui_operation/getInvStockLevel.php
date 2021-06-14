<?php
		$OFFSET = 0;
	if(isset($_POST["offset"])){
			$OFFSET = $_POST["offset"];
	}
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/app_db.php');


	$ROW_ARRAY;
	$COL_ARRAY;
	$DATA_ARRAY;
			
				$sNo = $OFFSET ;
				$qu_pur_requisitions_sel = "SELECT stock.category_id , item.item_name, stock.qty FROM inv_stock stock , inv_06_codes item where stock.category_id = item.code_id group by stock.category_id limit 10 " ;
				$newobj ;
				$qu_pur_requisitions_EXE = mysqli_query($KONN, $qu_pur_requisitions_sel);
				if(mysqli_num_rows($qu_pur_requisitions_EXE)){
				while($pur_requisitions_REC = mysqli_fetch_assoc($qu_pur_requisitions_EXE)){
					$sNo++;
					$category_id = $pur_requisitions_REC['category_id'];
					$item_name = $pur_requisitions_REC['item_name'];
					$qty = $pur_requisitions_REC['qty'];
					
					
					
					
$DATA_ARRAY[] = array( "qty" => intval($qty), 
					"item_name" => $item_name
					
					);

					
								}

							}
							echo json_encode($DATA_ARRAY);
						?>
				

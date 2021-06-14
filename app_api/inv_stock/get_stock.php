<?php
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try/{
		if( !isset( $_POST['shelf_id'] ) ){
			die('0|ERR_REQ_453334653');
		}
		
		$shelf_id = ( int ) $_POST['shelf_id'];
		$area_id  = ( int ) $_POST['area_id'];
		$rack_id  = ( int ) $_POST['rack_id'];
		
		
		$qu_inv_01_families_sel = "SELECT * FROM  `inv_stock` WHERE ( (`stock_status` = 'in_stock') AND ((`shelf_id` = '$shelf_id') AND (`rack_id` = '$rack_id') AND (`area_id` = '$area_id')) ) ORDER BY `stock_id` ASC";
		$userStatement = mysqli_prepare($KONN,$qu_inv_01_families_sel);
		mysqli_stmt_execute($userStatement);
		$qu_inv_01_families_EXE = mysqli_stmt_get_result($userStatement);
		if(mysqli_num_rows($qu_inv_01_families_EXE)){
		?>
		<option value="0" selected>Please Select</option>
		<?php
			while($inv_stock_REC = mysqli_fetch_assoc($qu_inv_01_families_EXE)){
				
				$stock_id = $inv_stock_REC['stock_id'];
				$stock_barcode = $inv_stock_REC['stock_barcode'];
				$family_id = $inv_stock_REC['family_id'];
				$section_id = $inv_stock_REC['section_id'];
				$division_id = $inv_stock_REC['division_id'];
				$subdivision_id = $inv_stock_REC['subdivision_id'];
				$category_id = $inv_stock_REC['category_id'];
				$item_code_id = $inv_stock_REC['item_code_id'];
				$unit_id = $inv_stock_REC['unit_id'];
				$qty = $inv_stock_REC['qty'];
				$cost_price = $inv_stock_REC['cost_price'];
				$currency_id = $inv_stock_REC['currency_id'];
				$exchange_rate = $inv_stock_REC['exchange_rate'];
				$area_id = $inv_stock_REC['area_id'];
				$rack_id = $inv_stock_REC['rack_id'];
				$shelf_id = $inv_stock_REC['shelf_id'];
				$mrv_id = $inv_stock_REC['mrv_id'];
				$supplier_id = $inv_stock_REC['supplier_id'];
				$po_id = $inv_stock_REC['po_id'];
				$po_item_id = $inv_stock_REC['po_item_id'];
				
				$unit_name = get_unit_name( $unit_id, $KONN );
				
				$qu_wh_areas_sel = "SELECT * FROM  `wh_areas` WHERE `area_id` = $area_id";
				userStatement = mysqli_prepare($KONN,$qu_wh_areas_sel);
				mysqli_stmt_execute($userStatement);
				$qu_wh_areas_EXE = mysqli_stmt_get_result($userStatement);
				$area_name = "";
				if(mysqli_num_rows($qu_wh_areas_EXE)){
					$wh_areas_DATA = mysqli_fetch_assoc($qu_wh_areas_EXE);
					$area_name = $wh_areas_DATA['area_name'];
				}
				
				$qu_wh_racks_sel = "SELECT * FROM  `wh_racks` WHERE `rack_id` = $rack_id";
				$userStatement = mysqli_prepare($KONN,$qu_wh_racks_sel);
				mysqli_stmt_execute($userStatement);
				$qu_wh_racks_EXE = mysqli_stmt_get_result($userStatement);
				$rack_name = "";
				if(mysqli_num_rows($qu_wh_racks_EXE)){
					$wh_racks_DATA = mysqli_fetch_assoc($qu_wh_racks_EXE);
					$rack_name = $wh_racks_DATA['rack_name'];
				}
				
				$qu_wh_shelfs_sel = "SELECT * FROM  `wh_shelfs` WHERE `shelf_id` = $shelf_id";
				$userStatement = mysqli_prepare($KONN,$qu_wh_shelfs_sel);
				mysqli_stmt_execute($userStatement);
				$qu_wh_shelfs_EXE = mysqli_stmt_get_result($userStatement);
				$shelf_name = "";
				if(mysqli_num_rows($qu_wh_shelfs_EXE)){
					$wh_shelfs_DATA = mysqli_fetch_assoc($qu_wh_shelfs_EXE);
					$shelf_name = $wh_shelfs_DATA['shelf_name'];
				}
				
				
			?>
			<option value="<?=$stock_id; ?>" 
			id="stock-<?=$stock_id; ?>" 
			dt-unit="<?=$unit_name; ?>" 
			dt-area="<?=$area_name; ?>" 
			dt-rack="<?=$rack_name; ?>" 
			dt-shelf="<?=$shelf_name; ?>" 
			dt-qty="<?=$qty; ?>" ><?=$stock_barcode; ?></option>
			<?php
			}
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

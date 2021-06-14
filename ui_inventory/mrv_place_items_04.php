<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";

	$menuId = 2;
	$subPageID = 5;
	
	
	
	if( isset( $_POST['mrv_id'] ) && 
		isset( $_POST['stock_id'] ) && 
		isset( $_POST['area_id'] ) && 
		isset( $_POST['rack_id'] ) && 
		isset( $_POST['shelf_id'] ) ){
		
		
		
		$mrv_id    = ( int ) $_POST['mrv_id'];
		$stock_id  = ( int ) $_POST['stock_id'];
		$area_id   = ( int ) $_POST['area_id'];
		$rack_id   = ( int ) $_POST['rack_id'];
		$shelf_id  = ( int ) $_POST['shelf_id'];
		
		//get po_id
	$qu_inv_mrvs_sel = "SELECT * FROM  `inv_mrvs` WHERE `mrv_id` = $mrv_id";
	$qu_inv_mrvs_EXE = mysqli_query($KONN, $qu_inv_mrvs_sel);
	$po_id = 0;
	if(mysqli_num_rows($qu_inv_mrvs_EXE)){
		$inv_mrvs_DATA = mysqli_fetch_assoc($qu_inv_mrvs_EXE);
		$po_id = ( int ) $inv_mrvs_DATA['po_id'];
	}

		
		
		
		
		$stock_status = 'in_stock';
		$qu_inv_stock_updt = "UPDATE  `inv_stock` SET 
							`area_id` = '".$area_id."', 
							`rack_id` = '".$rack_id."', 
							`shelf_id` = '".$shelf_id."', 
							`stock_status` = '".$stock_status."'
							WHERE `stock_id` = $stock_id;";

		if(mysqli_query($KONN, $qu_inv_stock_updt)){
			
			
			//insert state change
				if( insert_state_change($KONN, $stock_status, $stock_id, "inv_stock", $EMPLOYEE_ID) ) {
					
					
					//check MRV items state if all placed then place MRV
					$qu_inv_stock_sel = "SELECT * FROM  `inv_stock` WHERE ( (`mrv_id` = $mrv_id) AND (`stock_status` = 'pending_placement') )";
					$qu_inv_stock_EXE = mysqli_query($KONN, $qu_inv_stock_sel);
					if( mysqli_num_rows($qu_inv_stock_EXE) > 0 ){
						//go to placement items phase 1
						header("location:mrv_place_items_01.php?mrv_id=".$mrv_id);
						die("CHek_administrator");
					} else {
						//MRV items all placed
						//change MRV state to in_stock
						
	$mrv_status = "placement_finished";
	$current_state_id = get_current_state_id($KONN, $mrv_id, 'inv_mrvs' );
	if( $current_state_id != 0 ){
		if( insert_state_change_dep($KONN, "placement-finished", $mrv_id, $mrv_status, 'inv_mrvs', $EMPLOYEE_ID, $current_state_id) ){
			
			
			//assign mrv to new user
			$mrv_status = 'in_stock';
			$qu_inv_mrvs_updt = "UPDATE  `inv_mrvs` SET 
								`mrv_status` = '".$mrv_status."' 
								WHERE `mrv_id` = $mrv_id;";

			if(mysqli_query($KONN, $qu_inv_mrvs_updt)){
				//insert state change
					if( insert_state_change($KONN, $mrv_status, $mrv_id, "inv_mrvs", $EMPLOYEE_ID) ) {
						
						
						//update po status
	$po_status = 'material_received';
	$qu_purchase_orders_updt = "UPDATE  `purchase_orders` SET 
						`po_status` = '".$po_status."'
						WHERE `po_id` = $po_id;";

	if(mysqli_query($KONN, $qu_purchase_orders_updt)){
		if( insert_state_change($KONN, $po_status, $po_id, "purchase_orders", $EMPLOYEE_ID) ){
			header("location:mrv_list_pending_placement.php?updated=".$mrv_id);
		} else {
			die('0|Component State Error 6546541654');
		}
	}
						
						
						
						
						
						
						
						
						
						
					} else {
						die('0|Data Status Error 65154');
					}
				
			} else {
				die( 'sdds'.mysqli_error( $KONN ) );
			}
			
			
			
			
		} else {
			die( 'comErr'.mysqli_error( $KONN ) );
		}
	} else {
		die('0|Component State Error 02');
	}
						
						
						
						
						
					}

					
					
					
					
				} else {
					die('0|Data Status Error 65154');
				}
			
			
			
			
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	$mrv_id = 0;
	if( isset( $_GET['mrv_id'] ) ){
		$mrv_id = ( int ) $_GET['mrv_id'];
	} else {
		header("location:mrv_list.php?noMRV=1");
	}
	
	$stock_id = 0;
	if( isset( $_GET['stock_id'] ) ){
		$stock_id = ( int ) $_GET['stock_id'];
	} else {
		header("location:mrv_list.php?noStock=1");
	}
	
	$area_id = 0;
	if( isset( $_GET['area_id'] ) ){
		$area_id = ( int ) $_GET['area_id'];
	} else {
		header("location:mrv_list.php?noArea=1");
	}
	
	$rack_id = 0;
	if( isset( $_GET['rack_id'] ) ){
		$rack_id = ( int ) $_GET['rack_id'];
	} else {
		header("location:mrv_list.php?noRack=1");
	}
?>
<!DOCTYPE html>
<html dir="<?=$lang_dir; ?>" lang="<?=$lang; ?>">
<head>
	<?php include('app/meta.php'); ?>
    <?php include('app/assets.php'); ?>
</head>
<body>
<?php

	$WHERE = "requisitions";
	include('app/header.php');
	//PAGE DATA START -----------------------------------------------///---------------------------------
?>



<div class="row">
	<div class="col-100">
		<form action="mrv_place_items_04.php" method="POST">
					<input class="frmData"
							id="new-mrv_id<?=$mrv_id; ?>"
							name="mrv_id"
							type="hidden"
							value="<?=$mrv_id; ?>"
							req="1"
							den="0"
							alerter="<?=lang("Please_Check_items", "AAR"); ?>">
		
			<div class="row col-100">
			
			
			

		<table class="tabler" border="1">
			<thead>
				<tr>
					<th style="width:50%;"><?=lang('name'); ?></th>
					<th><?=lang('Received_qty'); ?></th>
					<th><?=lang('UOM'); ?></th>
				</tr>
			</thead>
			<tbody id="added_PO_items">
			
			
<?php
	$qu_inv_stock_sel = "SELECT * FROM  `inv_stock` WHERE ( (`stock_id` = $stock_id) AND (`stock_status` = 'pending_placement') ) LIMIT 1";
	$qu_inv_stock_EXE = mysqli_query($KONN, $qu_inv_stock_sel);
	if(mysqli_num_rows($qu_inv_stock_EXE)){
		$CC=0;
		while($inv_stock_REC = mysqli_fetch_assoc($qu_inv_stock_EXE)){
			
			$stock_id               = ( int ) $inv_stock_REC['stock_id'];
			$item_qty               = ( double ) $inv_stock_REC['qty'];
			
			$item_unit_name = get_unit_name( $inv_stock_REC['unit_id'], $KONN );
			
		$item_name = "NA";
		
		$item_name = get_item_description( $stock_id, 'stock_id', 'inv_stock', $KONN );
			
			
			
			
		?>
				<tr id="poItem-<?=$stock_id; ?>" class="po_item_list" idler="<?=$stock_id; ?>">
					<input class="frmData"
							id="new-stock_id<?=$stock_id; ?>"
							name="stock_id"
							type="hidden"
							value="<?=$stock_id; ?>"
							req="1"
							den="0"
							alerter="<?=lang("Please_Check_items", "AAR"); ?>">
					<td><?=$item_name; ?></td>
					<td style="widtd:5%;"><?=$item_qty; ?></td>
					<td><?=$item_unit_name; ?></td>
				</tr>
		<?php
		}
	}
?>
			</tbody>
		</table>
			
			
			
			
			</div>
		
			<div class="row col-100">
				<div class="nwFormGroup">
					<label><?=lang("Select_Area:", "AAR"); ?></label>
					<select class="frmData" id="new-area_id" name="area_id" required>
		<?php
			$sNo = 0;
			$qu_wh_areas_sel = "SELECT * FROM  `wh_areas` WHERE `area_id` = $area_id";
			$qu_wh_areas_EXE = mysqli_query($KONN, $qu_wh_areas_sel);
			if(mysqli_num_rows($qu_wh_areas_EXE)){
				while($wh_areas_REC = mysqli_fetch_assoc($qu_wh_areas_EXE)){
					$area_id       = ( int ) $wh_areas_REC['area_id'];
					$area_name = $wh_areas_REC['area_name'];
				
				?>
						<option value="<?=$area_id; ?>" selected><?=$area_name; ?></option>
				<?php
				}
			}
		?>
					</select>
				</div>
				<div class="zero"></div>
			</div>
			<div class="zero"></div>
		
			<div class="row col-100">
				<div class="nwFormGroup">
					<label><?=lang("Select_Rack:", "AAR"); ?></label>
					<select class="frmData" id="new-rack_id" name="rack_id" required>
		<?php
			$sNo = 0;
			$qu_wh_racks_sel = "SELECT * FROM  `wh_racks` WHERE  `rack_id` = $rack_id LIMIT 1";
			$qu_wh_racks_EXE = mysqli_query($KONN, $qu_wh_racks_sel);
			if(mysqli_num_rows($qu_wh_racks_EXE)){
				while($wh_racks_REC = mysqli_fetch_assoc($qu_wh_racks_EXE)){
					$rack_id       = ( int ) $wh_racks_REC['rack_id'];
					$rack_name = $wh_racks_REC['rack_name'];
				
				?>
						<option value="<?=$rack_id; ?>" selected><?=$rack_name; ?></option>
				<?php
				}
			}
		?>
					</select>
				</div>
				<div class="zero"></div>
			</div>
			<div class="zero"></div>
		
			<div class="row col-100">
				<div class="nwFormGroup">
					<label><?=lang("Select_Shelf:", "AAR"); ?></label>
					<select class="frmData" id="new-shelf_id" name="shelf_id" required>
						<option value="0" disabled selected><?=lang("Please_Select", "غير محدد"); ?></option>
		<?php
			$sNo = 0;
			$qu_wh_shelfs_sel = "SELECT * FROM  `wh_shelfs` WHERE  `rack_id` = $rack_id ORDER BY `shelf_name` ASC";
			$qu_wh_shelfs_EXE = mysqli_query($KONN, $qu_wh_shelfs_sel);
			if(mysqli_num_rows($qu_wh_shelfs_EXE)){
				while($wh_shelfs_REC = mysqli_fetch_assoc($qu_wh_shelfs_EXE)){
					$shelf_id       = ( int ) $wh_shelfs_REC['shelf_id'];
					$shelf_name = $wh_shelfs_REC['shelf_name'];
				
				?>
						<option value="<?=$shelf_id; ?>"><?=$shelf_name; ?></option>
				<?php
				}
			}
		?>
					</select>
				</div>
				<div class="zero"></div>
			</div>
			<div class="zero"></div>
				


<div class="viewerBodyButtons">
		<a href="mrv_list_pending_placement.php"><button type="button">
			<?=lang('Cancel', 'ARR', 1); ?>
		</button></a>
		<button type="submit">
			<?=lang('Finish', 'ARR', 1); ?>
		</button>
</div>
			
		</form>
	</div>
	<div class="zero"></div>
</div>


<?php
	//PAGE DATA END   ----------------------------------------------///---------------------------------
	include('app/footer.php');
?>
</body>
</html>
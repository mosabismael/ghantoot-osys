<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 3;
	$subPageID = 10;
	
	
	
if( isset($_POST['stock_qtys']) &&
	isset($_POST['miv_id']) &&
	isset($_POST['stock_ids']) 
	){

	$miv_item_id  = 0;
	$miv_id       = test_inputs($_POST['miv_id']);
	$stock_ids    = $_POST['stock_ids'];
	$stock_qtys   = $_POST['stock_qtys'];
	
	
	//delete any existing miv items
	$qu_inv_mivs_items_del = "DELETE FROM `inv_mivs_items` WHERE `miv_id` = $miv_id";
	if(mysqli_query($KONN, $qu_inv_mivs_items_del)){
		
		//insert new items
		for( $E=0 ; $E < count( $stock_ids ) ; $E++ ){
			
			$qty      = test_inputs( $stock_qtys[$E] );
			$stock_id = test_inputs( $stock_ids[$E] );
			
			
			//reduce quantity
	$qu_inv_stock_sel = "SELECT `qty` FROM  `inv_stock` WHERE `stock_id` = $stock_id";
	$qu_inv_stock_EXE = mysqli_query($KONN, $qu_inv_stock_sel);
	$Stock_QTY = 0;
	if(mysqli_num_rows($qu_inv_stock_EXE)){
		$inv_stock_DATA = mysqli_fetch_assoc($qu_inv_stock_EXE);
		$Stock_QTY      = ( double ) $inv_stock_DATA['qty'];
	}
	$sNewQty = 0;
	
	if( $qty <= $Stock_QTY ){
		$sNewQty = $Stock_QTY - $qty;
		$qu_inv_mivs_items_ins = "INSERT INTO `inv_mivs_items` (
							`qty`, 
							`miv_id`, 
							`stock_id` 
						) VALUES (
							'".$qty."', 
							'".$miv_id."', 
							'".$stock_id."' 
						);";

		if(mysqli_query($KONN, $qu_inv_mivs_items_ins)){
			//update stock new qty

			$qu_inv_stock_updt = "UPDATE  `inv_stock` SET 
								`qty` = '".$sNewQty."'
								WHERE `stock_id` = $stock_id;";

			if(!mysqli_query($KONN, $qu_inv_stock_updt)){
				die("ITEM-Failed-455");
			}
		} else {
			die("ITEM-Failed-455");
		}
				
		
	}

			
			
			
			
			
		
	//END OF FOR LOOP
		}

		
	} else {
		die("Del-Failed-1321");
	}


	//LOOP through miv items and deduct stock values
	
	
	//update miv status
			$miv_status = 'material_issued';
			$qu_inv_mivs_updt = "UPDATE  `inv_mivs` SET 
								`miv_status` = '".$miv_status."' 
								WHERE `miv_id` = $miv_id;";

			if(mysqli_query($KONN, $qu_inv_mivs_updt)){
				//insert state change
					if( insert_state_change($KONN, $miv_status, $miv_id, "inv_mivs", $EMPLOYEE_ID) ) {
						header("location:miv_list.php?items-added=1");
						die();
					} else {
						die('0|Data Status Error 65154');
					}
	
			} else {
				die( '864-'.mysqli_error( $KONN ) );
			}
			
	
	
	
	
	
	
	
	
	
	

}

	
	
	
	
	
	
	$miv_id = 0;
	if( isset( $_GET['miv_id'] ) ){
		$miv_id = ( int ) $_GET['miv_id'];
	} else {
		header("location:miv_list.php?no_miv_id=1");
	}
	
	
	$qu_inv_mivs_sel = "SELECT * FROM  `inv_mivs` WHERE `miv_id` = $miv_id";
	$qu_inv_mivs_EXE = mysqli_query($KONN, $qu_inv_mivs_sel);
	$inv_mivs_DATA;
	if(mysqli_num_rows($qu_inv_mivs_EXE)){
		$inv_mivs_DATA = mysqli_fetch_assoc($qu_inv_mivs_EXE);
	} else {
		header("location:miv_list.php?no_miv_id=5");
	}
		$miv_id = $inv_mivs_DATA['miv_id'];
		$miv_ref = $inv_mivs_DATA['miv_ref'];
		$created_date = $inv_mivs_DATA['created_date'];
		$created_by = $inv_mivs_DATA['created_by'];
		$received_date = $inv_mivs_DATA['received_date'];
		$received_by = $inv_mivs_DATA['received_by'];
		$miv_status = $inv_mivs_DATA['miv_status'];
		$job_order_id = $inv_mivs_DATA['job_order_id'];

	$selPoId = 0;
	if( isset( $_GET['po_id'] ) ){
		$selPoId = ( int ) $_GET['po_id'];
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
		<form action="miv_select_items.php" method="POST">
		
			<input type="hidden" value="<?=$miv_id; ?>" name="miv_id">
			
			<div class="row col-100">
				<div class="nwFormGroup">
					<label><?=lang("Selected_Job_Order:", "AAR"); ?></label>
					<select class="frmData" id="new-job_order_id" name="job_order_id" required>
		<?php
			$qu_job_orders_sel = "SELECT * FROM  `job_orders` WHERE `job_order_id` = '$job_order_id'";
			$qu_job_orders_EXE = mysqli_query($KONN, $qu_job_orders_sel);
			if(mysqli_num_rows($qu_job_orders_EXE)){
				while($job_orders_REC = mysqli_fetch_assoc($qu_job_orders_EXE)){
					$job_order_idT  = ( int ) $job_orders_REC['job_order_id'];
					$job_order_refT = $job_orders_REC['job_order_ref'];
					$project_nameT  = $job_orders_REC['project_name'];
				
				?>
						<option value="<?=$job_order_idT; ?>" selected><?=$job_order_refT; ?> - <?=$project_nameT; ?></option>
				<?php
				}
			}
		?>
					</select>
				</div>
				<div class="zero"></div>
			</div>
		
		
			<div class="row col-100">
				<div class="nwFormGroup">
					<label><?=lang("Selected_Receiver:", "AAR"); ?></label>
					<select class="frmData" id="new-received_by" name="received_by" required>
		<?php
			$qu_hr_employees_sel = "SELECT `employee_id`, `employee_code`, `first_name`, `last_name` FROM  `hr_employees` WHERE `employee_id` = '$received_by'";
			$qu_hr_employees_EXE = mysqli_query($KONN, $qu_hr_employees_sel);
			if(mysqli_num_rows($qu_hr_employees_EXE)){
				while($hr_employees_REC = mysqli_fetch_assoc($qu_hr_employees_EXE)){
					$employee_id  = ( int ) $hr_employees_REC['employee_id'];
					$employee_code = $hr_employees_REC['employee_code'];
					$first_name = $hr_employees_REC['first_name'];
					$last_name = $hr_employees_REC['last_name'];
				
				?>
						<option value="<?=$employee_id; ?>" selected><?=$employee_code; ?> - <?=$first_name; ?> <?=$last_name; ?></option>
				<?php
				}
			}
		?>
					</select>
				</div>
				<div class="zero"></div>
			</div>
			
			
			<div class="zero"></div>
				





<table class="tabler">
	<thead>
		<tr>
			<th><?=lang("--", "AAR"); ?></th>
			<th><?=lang("Item", "AAR"); ?></th>
			<th><?=lang("Qty", "AAR"); ?></th>
		</tr>
	</thead>
	<tbody>
		
		
		
		
<?php
if( $selPoId != 0 ){
	$qu_inv_stock_sel = "SELECT `stock_id`, `qty`, `stock_barcode` FROM  `inv_stock` WHERE ((`stock_status` = 'in_stock') AND (`po_id` = $selPoId))";
	$qu_inv_stock_EXE = mysqli_query($KONN, $qu_inv_stock_sel);
	if(mysqli_num_rows($qu_inv_stock_EXE)){
		$CC = 10;
		while($stock_REC = mysqli_fetch_array($qu_inv_stock_EXE)){
			$CC++;
			$TTstock_id = (int) $stock_REC[0];
			$TTqty = (double) $stock_REC[1];
			$TTstock_barcode = $stock_REC[2];
			
			$TTitem_name = $TTstock_barcode."<br>".get_item_description( $stock_REC[0], 'stock_id', 'inv_stock', $KONN );
			
?>
<tr id="added-<?=$CC; ?>">
	<td onclick="remItem(<?=$CC; ?>);"><i class="fas fa-trash"></i></td>
	<td><?=$TTitem_name; ?></td>
	<td><?=$TTqty; ?></td>
	<input type="hidden" value="<?=$TTstock_id; ?>" name="stock_ids[]">
	<input type="hidden" value="<?=$TTqty; ?>" name="stock_qtys[]">
</tr>
<?php
		}
	}
}
?>
		
		
		
		<tr id="added_point">
			<td onclick="show_details('NewItemDetails', 'Add_New_Item');resetSlctr(true);"><?=lang("Add_By_Barcode", "AAR"); ?></td>
			<td></td>
			<td onclick="show_details('NewItemPlaceDetails', 'Add_New_Item');resetSlctr(true);"><?=lang("Add_By_place", "AAR"); ?></td>
		</tr>
	</tbody>
</table>










<div class="viewerBodyButtons">
		<button type="submit">
			<?=lang('Save', 'ARR', 1); ?>
		</button>
		<a href="miv_list.php"><button type="button">
			<?=lang('Cancel', 'ARR', 1); ?>
		</button></a>
		<a onclick="show_details('selPODetails', 'Add_New_Item');resetSlctr(true);"><button type="button">
			<?=lang('Fill_By_PO', 'ARR', 1); ?>
		</button></a>
</div>
			
		</form>
	</div>
	<div class="zero"></div>
</div>








<!--    ///////////////////      selPODetails VIEW START    ///////////////////            -->
<div class="DetailsViewer ViewerOnTop" id="selPODetails">
	<div class="viewerContainer">
		<div class="viewerHeader">
			<img src="<?=uploads_root; ?>/logo_icon.png" />
			<h1>REFREFREF</h1>
			<i onclick="hide_details('selPODetails');" class="fas fa-times"></i>
		</div>
		<div class="viewerBody">
			
			
			
			
			
			

<div class="row">
	<div class="col-100">

		<form action="miv_select_items.php" method="GET">

			<input type="hidden" value="<?=$miv_id; ?>" name="miv_id">
<div class="col-100">
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('Select_PO', 'ARR', 1); ?></label>
		<select class="frmData" id="new-po_id" name="po_id" >
					<option value="0" selected>--- Please Select---</option>
<?php
	$qu_purchase_orders_sel = "SELECT `po_id`, `po_ref`, `po_status` FROM  `purchase_orders` WHERE (((`po_status` = 'fully_material_arrived') OR (`po_status` = 'material_received') OR (`po_status` = 'partially_material_arrived')) AND (`job_order_id` = $job_order_id))";
	$qu_purchase_orders_EXE = mysqli_query($KONN, $qu_purchase_orders_sel);
	if(mysqli_num_rows($qu_purchase_orders_EXE)){
		while($purchase_orders_REC = mysqli_fetch_array($qu_purchase_orders_EXE)){
			$Tpo_id = $purchase_orders_REC[0];
			$Tpo_ref = $purchase_orders_REC[1];
			$Tpo_status = $purchase_orders_REC[2];
	
			
		?>
		<option value="<?=$Tpo_id; ?>"><?=$Tpo_ref; ?></option>
		<?php
		}
	}
?>

		</select>
	</div>
</div>
			

<div class="viewerBodyButtons">
		<button type="submit">
			<?=lang('Confirm', 'ARR', 1); ?>
		</button>
		<a onclick="hide_details('selPODetails');"><button type="button">
			<?=lang('Cancel', 'ARR', 1); ?>
		</button></a>
</div>
			
		</form>
	</div>
</div>
		</div>
	</div>
</div>
<!--    ///////////////////      selPODetails VIEW END    ///////////////////            -->




<!--    ///////////////////      NewItemDetails VIEW START    ///////////////////            -->
<div class="DetailsViewer ViewerOnTop" id="NewItemDetails">
	<div class="viewerContainer">
		<div class="viewerHeader">
			<img src="<?=uploads_root; ?>/logo_icon.png" />
			<h1>REFREFREF</h1>
			<i onclick="hide_details('NewItemDetails');" class="fas fa-times"></i>
		</div>
		<div class="viewerBody">
			<?php include('miv_nw_itm_form.php'); ?>
		</div>
	</div>
</div>
<!--    ///////////////////      NewItemDetails VIEW END    ///////////////////            -->


<!--    ///////////////////      NewItemPlaceDetails VIEW START    ///////////////////            -->
<div class="DetailsViewer ViewerOnTop" id="NewItemPlaceDetails">
	<div class="viewerContainer">
		<div class="viewerHeader">
			<img src="<?=uploads_root; ?>/logo_icon.png" />
			<h1>REFREFREF</h1>
			<i onclick="hide_details('NewItemPlaceDetails');" class="fas fa-times"></i>
		</div>
		<div class="viewerBody">
			<?php include('miv_nw_itm_p_form.php'); ?>
		</div>
	</div>
</div>
<!--    ///////////////////      NewItemPlaceDetails VIEW END    ///////////////////            -->


<?php
	//PAGE DATA END   ----------------------------------------------///---------------------------------
	include('app/footer.php');
?>
</body>
</html>
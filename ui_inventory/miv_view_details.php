<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 3;
	$subPageID = 10;
	
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
		<form>
			
			<div class="row col-100">
				<div class="nwFormGroup">
					<label><?=lang("Selected_Job_Order:", "AAR"); ?></label>
					<select class="frmData" id="new-job_order_id" name="job_order_id" disabled>
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
					<select class="frmData" id="new-received_by" name="received_by" disabled>
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
			<th><?=lang("NO", "AAR"); ?></th>
			<th><?=lang("Item", "AAR"); ?></th>
			<th><?=lang("Qty", "AAR"); ?></th>
		</tr>
	</thead>
	<tbody>
		
		
		
		
<?php
if( $miv_id != 0 ){
	$qu_inv_mivs_items_sel = "SELECT `stock_id`, `qty` FROM  `inv_mivs_items` WHERE ((`miv_id` = $miv_id))";
	$qu_inv_mivs_items_EXE = mysqli_query($KONN, $qu_inv_mivs_items_sel);
	if(mysqli_num_rows($qu_inv_mivs_items_EXE)){
		$CC = 0;
		while($stock_REC = mysqli_fetch_array($qu_inv_mivs_items_EXE)){
			$CC++;
			$TTstock_id = (int) $stock_REC[0];
			$TTqty = (double) $stock_REC[1];
			
	$qu_inv_stock_sel = "SELECT `stock_barcode` FROM  `inv_stock` WHERE `stock_id` = $TTstock_id";
	$qu_inv_stock_EXE = mysqli_query($KONN, $qu_inv_stock_sel);
	$TTstock_barcode = "";
	if(mysqli_num_rows($qu_inv_stock_EXE)){
		$inv_stock_DATA = mysqli_fetch_assoc($qu_inv_stock_EXE);
		$TTstock_barcode = $inv_stock_DATA['stock_barcode'];
	}

			
			
			
			
			
			$TTitem_name = $TTstock_barcode."<br>".get_item_description( $TTstock_id, 'stock_id', 'inv_stock', $KONN );
			
?>
<tr id="added-<?=$CC; ?>">
	<td><?=$CC; ?>.</td>
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
	</tbody>
</table>










<div class="viewerBodyButtons">
		<a href="miv_list.php"><button type="button">
			<?=lang('Back', 'ARR', 1); ?>
		</button></a>
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
<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 9;
	$subPageID = 19;
	
	
	$bill_id = 0;
	
	if( isset( $_GET['bill_id'] ) ){
		$bill_id = ( int ) $_GET['bill_id'];
	} else {
		header("location:acc_biling.php?noBill=1");
	}
	
	
	$qu_acc_biling_sel = "SELECT * FROM  `acc_biling` WHERE `bill_id` = $bill_id";
	$qu_acc_biling_EXE = mysqli_query($KONN, $qu_acc_biling_sel);
	$acc_biling_DATA;
	if(mysqli_num_rows($qu_acc_biling_EXE)){
		$acc_biling_DATA = mysqli_fetch_assoc($qu_acc_biling_EXE);
	}
	
		$bill_type = $acc_biling_DATA['bill_type'];
		$bill_ref = $acc_biling_DATA['bill_ref'];
		$client_ref = $acc_biling_DATA['client_ref'];
		$created_date = $acc_biling_DATA['created_date'];
		$created_by = $acc_biling_DATA['created_by'];
		$job_order_id = $acc_biling_DATA['job_order_id'];
		$bill_status = $acc_biling_DATA['bill_status'];
		$contract_attach = $acc_biling_DATA['contract_attach'];
		
		
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
		<form action="acc_biling_new_02.php" method="POST">
					<input class="frmData"
							id="new-bill_id<?=$bill_id; ?>"
							name="bill_id"
							type="hidden"
							value="<?=$bill_id; ?>"
							req="1"
							den="0"
							alerter="<?=lang("Please_Check_bill_id", "AAR"); ?>">
		
			<div class="row col-50">
				<div class="nwFormGroup">
					<label><?=lang("Type:", "AAR"); ?></label>
					<select class="frmData" id="new-bill_type" name="bill_type" disabled>
<?php
	if( $bill_type == 'steel' ){
?>
						<option value="steel" selected><?=lang("Steel", "غير محدد"); ?></option>
<?php
	}
?>
<?php
	if( $bill_type == 'marine' ){
?>
						<option value="marine"><?=lang("Marine", "غير محدد"); ?></option>
<?php
	}
?>
					</select>
				</div>
				<div class="zero"></div>
			</div>
		
			<div class="row col-50">
				<div class="nwFormGroup">
					<label><?=lang("Job_Order:", "AAR"); ?></label>
					<select class="frmData" id="new-job_order_id" name="job_order_id" disabled>
		<?php
			$sNo = 0;
			$qu_job_orders_sel = "SELECT * FROM  `job_orders` WHERE `job_order_id` = '$job_order_id'";
			$qu_job_orders_EXE = mysqli_query($KONN, $qu_job_orders_sel);
			if(mysqli_num_rows($qu_job_orders_EXE)){
				while($job_orders_REC = mysqli_fetch_assoc($qu_job_orders_EXE)){
					$job_order_ref = $job_orders_REC['job_order_ref'];
					$client_idT = $job_orders_REC['client_id'];
					
					
					
		$qu_gen_clients_sel = "SELECT `client_id`, `client_name` FROM  `gen_clients` WHERE `client_id` = '$client_idT'";
		$qu_gen_clients_EXE = mysqli_query($KONN, $qu_gen_clients_sel);
		if(mysqli_num_rows($qu_gen_clients_EXE)){
			$gen_clients_DATA = mysqli_fetch_assoc($qu_gen_clients_EXE);
			$client_name = $gen_clients_DATA['client_name'];
			
		
				
				?>
						<option value="<?=$job_order_id; ?>"><?=$job_order_ref; ?> - <?=$client_name; ?></option>
				<?php
		}
				}
			}
		?>
					</select>
				</div>
				<div class="zero"></div>
			</div>
		
			<div class="row col-50">
				<div class="nwFormGroup">
					<label><?=lang("client_ref:", "AAR"); ?></label>
					<input type="text" class="frmData" id="new-client_ref" value="<?=$client_ref; ?>" disabled>
				</div>
				<div class="zero"></div>
			</div>
<?php
	if( $contract_attach != 'na' ){
?>
			<div class="row col-50">
				<div class="nwFormGroup">
					<label><?=lang("Contract:", "AAR"); ?></label>
					<a href="../uploads/<?=$contract_attach; ?>" target="_blank"><span><?=lang("View", "AAR"); ?></span></a>
				</div>
				<div class="zero"></div>
			</div>
<?php
	}
?>
			
			
			<div class="zero"></div>
			<div class="row col-100">
				<br>
				<hr>
				<br>
			</div>
			<div class="zero"></div>
			
			
			
			
			
			<div class="row col-100">
			
			
			
<table class="tabler">
	<thead>
		<tr>
			<th>--</th>
			<th><?=lang("item", "sss", 1); ?></th>
			<th><?=lang("UOM", "sss", 1); ?></th>
			<th><?=lang("Qty", "sss", 1); ?></th>
			<th><?=lang("U.P", "sss", 1); ?></th>
			<th><?=lang("Total", "sss", 1); ?></th>
		</tr>
	</thead>
	<tbody id="added_items">
	
<?php
	$qu_acc_biling_items_sel = "SELECT * FROM  `acc_biling_items` WHERE `bill_id` = $bill_id ORDER BY `bill_item_id` ASC";
	$qu_acc_biling_items_EXE = mysqli_query($KONN, $qu_acc_biling_items_sel);
	if(mysqli_num_rows($qu_acc_biling_items_EXE)){
		$itemsC = 1;
		$itmCount = 0;
		while($acc_biling_items_REC = mysqli_fetch_assoc($qu_acc_biling_items_EXE)){
			$THStot = 0;
			$itmCount++;
			$bill_item_id = $acc_biling_items_REC['bill_item_id'];
			$item_desc = $acc_biling_items_REC['item_desc'];
			$unit_id = $acc_biling_items_REC['unit_id'];
			$item_qty = $acc_biling_items_REC['item_qty'];
			$item_price = $acc_biling_items_REC['item_price'];
			
			$is_tree = ( int ) $acc_biling_items_REC['is_tree'];
			
			$thsCss = '';
				
			if( $is_tree == 0 ){
				$itmCount = $itemsC.'.'.$itmCount;
			} else {
				$itmCount = $itemsC;
			}
			
			
			$THStot = $item_price * $item_qty;
			
			if( $is_tree == 1 ){
				$itmCount = 0;
				$thsCss = 'important';
			
		?>
				<tr class=" important" id="addedItem-<?=$itemsC; ?>">
					<td><?=$itemsC; ?></td>
					<td colspan="2">
						<div class="nwFormGroup">
							<textarea style="width:100%;" name="item_descs[]" placeholder="Item Name" readonly><?=$item_desc; ?></textarea>
						</div>
					</td>
					<td><?=$item_qty; ?></td>
					<td><?=$item_price; ?></td>
					<td><?=$THStot; ?></td>
				</tr>
		<?php
			} else {
				$itemsC++;
		?>
				<tr class="item" id="addedItem-<?=$itemsC; ?>">
					<td><?=$itmCount; ?></td>
					<td>
						<div class="nwFormGroup">
							<textarea style="width:100%;" name="item_descs[]" placeholder="Item Name" readonly><?=$item_desc; ?></textarea>
						</div>
					</td>
					<td>
						<div class="nwFormGroup">
							<select class="frmData" id="new-unit_id" name="unit_ids[]" readonly>
				<?php
					$sNo = 0;
					$qu_gen_items_units_sel = "SELECT * FROM  `gen_items_units` WHERE `unit_id` = '$unit_id'";
					$qu_gen_items_units_EXE = mysqli_query($KONN, $qu_gen_items_units_sel);
					if(mysqli_num_rows($qu_gen_items_units_EXE)){
						while($gen_items_units_REC = mysqli_fetch_assoc($qu_gen_items_units_EXE)){
							$unit_name = $gen_items_units_REC['unit_name'];
						
						?>
								<option value="<?=$unit_id; ?>"><?=$unit_name; ?></option>
						<?php
						}
					}
				?>
							</select>
						</div>
					</td>
					<td>
						<div class="nwFormGroup">
							<input type="text" class="qty" name="item_qtys[]" value="<?=$item_qty; ?>" placeholder="Item Qty" readonly>
						</div>
					</td>
					<td>
						<div class="nwFormGroup">
							<input type="text" class="price" name="item_prices[]" value="<?=$item_price; ?>" placeholder="Unit Price" readonly>
						</div>
					</td>
					<td>
						<div class="nwFormGroup">
							<input type="text" class="tot" name="item_tots[]" value="0" readonly>
						</div>
					</td>
				</tr>
		<?php
			}
		
		
		
		
		
		
		
		}
	}

?>
	
	
		<tr>
			<th colspan="4">--</th>
			<th><?=lang("Sub_Total:", "sss", 1); ?></th>
			<th  id="sub_tot">15651.232</th>
		</tr>
		<tr>
			<th colspan="4">--</th>
			<th><?=lang("Vat_(5%):", "sss", 1); ?></th>
			<th  id="vat_amount">15651.232</th>
		</tr>
		<tr>
			<th colspan="4">--</th>
			<th><?=lang("Total:", "sss", 1); ?></th>
			<th  id="grand_tot">15651.232</th>
		</tr>
	</tbody>
</table>
			
			
			
			</div>
			
			
			<div class="zero"></div>
				


<div class="viewerBodyButtons">
		<a href="acc_biling.php"><button type="button">
			<?=lang('Back', 'ARR', 1); ?>
		</button></a>
</div>
			
		</form>
	</div>
	<div class="zero"></div>
</div>
<script>
var tot_recs = 100;

function addNewRec(){
	tot_recs++;
	var nw_rec = '<tr id="addedItem-' + tot_recs + '">' + 
				'	<td><i title="Delete this item" onclick="delItem(' + tot_recs + ');" class="fas fa-trash"></i></td>' + 
				'	<td>' + 
				'		<div class="nwFormGroup">' + 
				'			<textarea name="item_descs[]" placeholder="Item Name" required></textarea>' + 
				'		</div>' + 
				'	</td>' + 
				'	<td>' + 
				'		<div class="nwFormGroup">' + 
				'			<select class="frmData" id="new-unit_id" name="unit_ids[]" required>' + 
				'				<option value="0" disabled selected><?=lang("Please_Select", "غير محدد"); ?></option>' + 
				<?php
					$sNo = 0;
					$qu_gen_items_units_sel = "SELECT * FROM  `gen_items_units` ORDER BY `unit_name` ASC";
					$qu_gen_items_units_EXE = mysqli_query($KONN, $qu_gen_items_units_sel);
					if(mysqli_num_rows($qu_gen_items_units_EXE)){
						while($gen_items_units_REC = mysqli_fetch_assoc($qu_gen_items_units_EXE)){
							$unit_id       = ( int ) $gen_items_units_REC['unit_id'];
							$unit_name = $gen_items_units_REC['unit_name'];
						
						?>
				'				<option value="<?=$unit_id; ?>"><?=$unit_name; ?></option>' + 
						<?php
						}
					}
				?>
				'			</select>' + 
				'		</div>' + 
				'	</td>' + 
				'	<td>' + 
				'		<div class="nwFormGroup">' + 
				'			<input type="text" name="item_qtys[]" placeholder="Item Aty" required>' + 
				'		</div>' + 
				'	</td>' + 
				'	<td>' + 
				'		<div class="nwFormGroup">' + 
				'			<input type="text" name="item_prices[]" placeholder="Unit Price" required>' + 
				'		</div>' + 
				'	</td>' + 
				'</tr>';
				
			$('#added_items').append( nw_rec );
}





function calcTable(){
	var subTot = 0;
	$('.item').each( function(){
		var ths_id = $(this).attr( 'id' );
		var thsQty = parseInt( $('#' + ths_id + ' .qty').val() );
		var thsPrc = parseFloat( $('#' + ths_id + ' .price').val() );
		var thsTot = thsQty * thsPrc;
		subTot = subTot + thsTot;
		$('#' + ths_id + ' .tot').val( thsTot.toFixed(3) );
	} );
	
	
	
	vatPercentage = 0.05;
	
	var vatAmount = subTot * vatPercentage;
	
	var grandTot = subTot + vatAmount;
	
	
	$('#sub_tot').html( subTot.toFixed(3) );
	$('#vat_amount').html( vatAmount.toFixed(3) );
	$('#grand_tot').html( grandTot.toFixed(3) );
	
	
	
}
calcTable();

function delItem( id ){
	$('#addedItem-' + id).remove();
}
</script>

<?php
	//PAGE DATA END   ----------------------------------------------///---------------------------------
	include('app/footer.php');
?>
</body>
</html>
<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 8;
	$subPageID = 17;
	
	
if( isset($_POST['mrv_id']) &&
	isset($_POST['item_id']) 
	){
		

	$mrv_id = 0;
	$inspected_date = date('Y-m-d H:i:00');
	$stock_id = ( int ) $_POST['item_id'];
	$mrv_id  = ( int ) test_inputs($_POST['mrv_id']);
	
	$mrv_status = "itm-inspctd-".$stock_id;
	
	
	$qu_inv_mrvs_sel = "SELECT * FROM  `inv_mrvs` WHERE `mrv_id` = $mrv_id";
	$qu_inv_mrvs_EXE = mysqli_query($KONN, $qu_inv_mrvs_sel);
	$created_by = 0;
	if(mysqli_num_rows($qu_inv_mrvs_EXE)){
		$inv_mrvs_DATA = mysqli_fetch_assoc($qu_inv_mrvs_EXE);
		$created_by = $inv_mrvs_DATA['created_by'];
	}

	
	
	//update status
	$current_state_id = get_current_state_id($KONN, $mrv_id, 'inv_mrvs' );
	if( $current_state_id != 0 ){
		if( insert_state_change_dep($KONN, "item-inspect", $mrv_id, $mrv_status, 'inv_mrvs', $EMPLOYEE_ID, $current_state_id) ){
			
			$stock_status = 'pending_placement';
			$qu_inv_stock_updt = "UPDATE  `inv_stock` SET 
								`stock_status` = '".$stock_status."' 
								WHERE `stock_id` = $stock_id;";

					if( mysqli_query($KONN, $qu_inv_stock_updt) ){
						
						
						
//check if mrv fully approved
	$qu_inv_stock_sel = "SELECT COUNT(`stock_id`) FROM  `inv_stock` WHERE ( (`mrv_id` = $mrv_id) AND (`stock_status` = 'under_inspection') )";
	$qu_inv_stock_EXE = mysqli_query($KONN, $qu_inv_stock_sel);
	$remain_C = 0;
	if(mysqli_num_rows($qu_inv_stock_EXE)){
		$inv_stock_DATA = mysqli_fetch_array($qu_inv_stock_EXE);
		$remain_C = ( int ) $inv_stock_DATA[0];
	}

	if( $remain_C == 0 ){
		//change mrv status to pending_placement
			//assign mrv to new user
			$mrv_status = 'pending_placement';
			$qu_inv_mrvs_updt = "UPDATE  `inv_mrvs` SET 
								`mrv_status` = '".$mrv_status."' WHERE `mrv_id` = $mrv_id;";

			if(mysqli_query($KONN, $qu_inv_mrvs_updt)){
				//insert state change
					if( insert_state_change($KONN, $mrv_status, $mrv_id, "inv_mrvs", $created_by) ) {
						
						header("location:mrv_list.php?approved=".$mrv_id);
						die();
						
					} else {
						die('0|Data Status Error 65154');
					}
				
			} else {
				die( 'sdds'.mysqli_error( $KONN ) );
			}
		
	} else {
		//go back to approval page
		header("location:mrv_approval.php?mrv_id=".$mrv_id);
		die();
	}
						
						
						
						
						
						
						
					} else {
						die( 'itemUpdtError'.mysqli_error( $KONN ) );
					}
			
			
			
		} else {
			die( 'comErr'.mysqli_error( $KONN ) );
		}
	} else {
		die('0|Component State Error 02');
	}
		
		
		
		
		
		
		
		
	}
	
	
	

	
	$mrv_id = 0;
	
	if( isset( $_GET['mrv_id'] ) ){
		$mrv_id = ( int ) $_GET['mrv_id'];
	} else {
		header("location:mrv_list.php?noMRV=1");
	}
	
	
	$qu_inv_mrvs_sel = "SELECT * FROM  `inv_mrvs` WHERE `mrv_id` = $mrv_id";
	$qu_inv_mrvs_EXE = mysqli_query($KONN, $qu_inv_mrvs_sel);
	$inv_mrvs_DATA;
	if(mysqli_num_rows($qu_inv_mrvs_EXE)){
		$inv_mrvs_DATA = mysqli_fetch_assoc($qu_inv_mrvs_EXE);
	}
	
		$mrv_ref = $inv_mrvs_DATA['mrv_ref'];
		$created_date = $inv_mrvs_DATA['created_date'];
		$created_by = $inv_mrvs_DATA['created_by'];
		$inspected_date = $inv_mrvs_DATA['inspected_date'];
		$inspected_by = $inv_mrvs_DATA['inspected_by'];
		$dn_ref = $inv_mrvs_DATA['dn_ref'];
		$mrv_status = $inv_mrvs_DATA['mrv_status'];
		$supplier_id = $inv_mrvs_DATA['supplier_id'];

	
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
		
			<div class="row col-50">
				<div class="nwFormGroup">
					<label><?=lang("Supplier:", "AAR"); ?></label>
					<select class="frmData" id="new-supplier_id" name="supplier_id" disabled>
		<?php
			$sNo = 0;
			$qu_suppliers_list_sel = "SELECT * FROM  `suppliers_list` WHERE `supplier_id` = '$supplier_id'";
			$qu_suppliers_list_EXE = mysqli_query($KONN, $qu_suppliers_list_sel);
			if( mysqli_num_rows($qu_suppliers_list_EXE) == 1 ){
				while($suppliers_list_REC = mysqli_fetch_assoc($qu_suppliers_list_EXE)){
					$supp_id       = ( int ) $suppliers_list_REC['supplier_id'];
					$supplier_name = $suppliers_list_REC['supplier_name'];
				
				?>
						<option value="<?=$supp_id; ?>"><?=$supplier_name; ?></option>
				<?php
				}
			} else {
				header("location:mrv_list.php?wrongIDs=1");
			}
		?>
					</select>
				</div>
				<div class="zero"></div>
			</div>
			
		
			<div class="row col-50">
				<div class="nwFormGroup">
					<label><?=lang("Delivery_Note_Ref:", "AAR"); ?></label>
					<input type="text" class="frmData" id="new-dn_ref" name="dn_ref" value="<?=$dn_ref; ?>" disabled>
				</div>
				<div class="zero"></div>
			</div>
			<div class="zero"></div>
				
				
				
				
				
				
		<table class="tabler" border="1">
			<thead>
				<tr>
					<th style="width:50%;"><?=lang('name'); ?></th>
					<th><?=lang('Received_qty'); ?></th>
					<th><?=lang('UOM'); ?></th>
					<th><?=lang('Status'); ?></th>
					<th>---</th>
				</tr>
			</thead>
			<tbody id="added_PO_items">
			
			
<?php
	$qu_inv_stock_sel = "SELECT * FROM  `inv_stock` WHERE ( (`mrv_id` = $mrv_id) )";
	$qu_inv_stock_EXE = mysqli_query($KONN, $qu_inv_stock_sel);
	if(mysqli_num_rows($qu_inv_stock_EXE)){
		$CC=0;
		while($inv_stock_REC = mysqli_fetch_assoc($qu_inv_stock_EXE)){
			
			$stock_id               = ( int ) $inv_stock_REC['stock_id'];
			$item_qty               = ( double ) $inv_stock_REC['qty'];
			$stock_status           = $inv_stock_REC['stock_status'];
			
			$item_unit_name = get_unit_name( $inv_stock_REC['unit_id'], $KONN );
		
		$item_name = get_item_description( $stock_id, 'stock_id', 'inv_stock', $KONN );
			
			
			
			
		?>
				<tr id="poItem-<?=$stock_id; ?>" class="po_item_list" idler="<?=$stock_id; ?>">
					<td><?=$item_name; ?></td>
					<td style="widtd:5%;"><?=$item_qty; ?></td>
					<td><?=$item_unit_name; ?></td>
					<td><?=$stock_status; ?></td>
					<td>
<?php
	if( $stock_status == 'under_inspection' ){
?>
						<form action="mrv_approval.php" method="POST">
							<input class="frmData" name="mrv_id" type="hidden" value="<?=$mrv_id; ?>">
							<input class="frmData"
									id="new-stock_id<?=$stock_id; ?>"
									name="item_id"
									type="hidden"
									value="<?=$stock_id; ?>"
									req="1"
									den="0"
									alerter="<?=lang("Please_Check_items", "AAR"); ?>">
							<button type="submit">
								<?=lang('Approve', 'ARR', 1); ?>
							</button>
						</form>
						<form action="mrv_approval_deny.php" method="POST">
							<input class="frmData" name="mrv_id" type="hidden" value="<?=$mrv_id; ?>">
							<input class="frmData"
									id="new-stock_id<?=$stock_id; ?>"
									name="item_id"
									type="hidden"
									value="<?=$stock_id; ?>"
									req="1"
									den="0"
									alerter="<?=lang("Please_Check_items", "AAR"); ?>">
							<button type="submit">
								<?=lang('Deny', 'ARR', 1); ?>
							</button>
						</form>
<?php
	}
?>
					</td>
				</tr>
		<?php
		}
	}
?>
			</tbody>
		</table>
				
				
				
				
				
				

<div class="viewerBodyButtons">
		<a href="mrv_list.php"><button type="button">
			<?=lang('Finish', 'ARR', 1); ?>
		</button></a>

</div>

	</div>
	<div class="zero"></div>
</div>

<script>

function delPoItem( IDD ){
	var aa = confirm('Are you sure, this will remove the item from PO, you can undo by clicking on reset button?');
	if( aa == true ){
		$('#' + IDD).remove();
	}
}
var added_PO_items = $('#added_PO_items').html();

function resetItems(){
	$('#added_PO_items').html('');
	$('#added_PO_items').html(added_PO_items);
}

</script>

<?php
	//PAGE DATA END   ----------------------------------------------///---------------------------------
	include('app/footer.php');
?>
</body>
</html>
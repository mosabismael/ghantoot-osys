<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 9;
	$subPageID = 18;
	
	
	
	
if( isset($_POST['item_descs']) &&
	isset($_POST['unit_ids']) &&
	isset($_POST['item_qtys']) &&
	isset($_POST['item_prices']) &&
	isset($_POST['is_trees']) &&
	isset($_POST['bill_id']) 
	){

	$bill_item_id  = 0;
	$item_descs    = $_POST['item_descs'];
	$unit_ids      = $_POST['unit_ids'];
	$item_qtys     = $_POST['item_qtys'];
	$item_prices   = $_POST['item_prices'];
	$is_trees      = $_POST['is_trees'];
	
	$bill_id = ( int ) test_inputs($_POST['bill_id']);


	$qu_acc_biling_items_del = "DELETE FROM `acc_biling_items` WHERE `bill_id` = $bill_id";
	if(!mysqli_query($KONN, $qu_acc_biling_items_del)){
		die('Itm_Del_ERR');
		
	}



	for( $E=0; $E< count( $item_descs ) ; $E++ ){
		
		$item_desc     = test_inputs( $item_descs[$E] );
		$unit_id       = test_inputs( $unit_ids[$E] );
		$item_qty      = ( double ) test_inputs( $item_qtys[$E] );
		$item_price    = ( double ) test_inputs( $item_prices[$E] );
		$is_tree       = ( int ) test_inputs( $is_trees[$E] );
		
		if( $is_tree == 1 ){
			$item_price    = 0;
			$item_qty      = 0;
			$unit_id       = 0;
		}
		
		
			$qu_acc_biling_items_ins = "INSERT INTO `acc_biling_items` (
								`item_desc`, 
								`unit_id`, 
								`item_qty`, 
								`item_price`, 
								`is_tree`, 
								`bill_id` 
							) VALUES (
								'".$item_desc."', 
								'".$unit_id."', 
								'".$item_qty."', 
								'".$item_price."', 
								'".$is_tree."', 
								'".$bill_id."' 
							);";

			if(!mysqli_query($KONN, $qu_acc_biling_items_ins)){
				die('Itm_Add_ERR');
			}
	}
	header("location:acc_biling.php?added=".$bill_id);
}

	
	
	
	
	
	
	
	
	
	
	
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
	} else {
		header("location:acc_biling.php?noBill=2");
		die();
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
		
		<div class="row col-100">
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
					
$client_name = "";
		$qu_gen_clients_sel = "SELECT `client_id`, `client_name` FROM  `gen_clients` WHERE `client_id` = '$client_idT'";
		$qu_gen_clients_EXE = mysqli_query($KONN, $qu_gen_clients_sel);
		if(mysqli_num_rows($qu_gen_clients_EXE)){
			$gen_clients_DATA = mysqli_fetch_assoc($qu_gen_clients_EXE);
			$client_id = ( int ) $gen_clients_DATA['client_id'];
			$client_name = $gen_clients_DATA['client_name'];
		}
				
				?>
						<option value="<?=$job_order_id; ?>"><?=$job_order_ref; ?> - <?=$client_name; ?></option>
				<?php
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
			
			
			
		</div>
			
			<div class="row col-100">
<table class="tabler">
	<thead>
		<tr>
			<th colspan="3"><?=lang("Scope_Of_Work", "sss", 1); ?></th>
		</tr>
	</thead>
	<tbody>
<?php
	$qu_acc_biling_tree_sel = "SELECT * FROM  `acc_biling_tree`";
	$qu_acc_biling_tree_EXE = mysqli_query($KONN, $qu_acc_biling_tree_sel);
	if(mysqli_num_rows($qu_acc_biling_tree_EXE)){
		while($acc_biling_tree_REC = mysqli_fetch_assoc($qu_acc_biling_tree_EXE)){
		$tree_id = $acc_biling_tree_REC['tree_id'];
		$tree_name = $acc_biling_tree_REC['tree_name'];
		$tree_cats = $acc_biling_tree_REC['tree_cats'];
		
		$cats_arr = explode('-', $tree_cats);
		
		?>
		<tr>
			<td id="tree-<?=$tree_id; ?>"><?=$tree_name; ?></td>
			<td>
	<?php
	for( $C = 0 ; $C < count( $cats_arr ) ; $C++  ){ 
		$catName = $cats_arr[$C];
		if( $catName != '' ){
	?>

				<div class="nwFormGroup">
					
					<label><?=$catName; ?></label>
					<input class="opt-<?=$tree_id; ?>" id="chk-<?=$tree_id; ?>-<?=$C; ?>" namer="<?=$catName; ?>" type="checkbox">
				</div>
	<?php
		}
	}
	?>
			</td>
			<td>
				<button type="button" onclick="addTree(<?=$tree_id; ?>);"><?=lang("Add", "AAR"); ?></button>
			</td>
		</tr>
		<?php
		}
	}
?>
	</tbody>
</table>
			</div>
			
			<div class="row col-100">
			
<table class="tabler">
	<thead>
		<tr>
			<th colspan="2">--</th>
			<th><?=lang("item", "sss", 1); ?></th>
			<th><?=lang("UOM", "sss", 1); ?></th>
			<th><?=lang("Qty", "sss", 1); ?></th>
			<th><?=lang("U.P", "sss", 1); ?></th>
			<th><?=lang("Total", "sss", 1); ?></th>
		</tr>
	</thead>
	<tbody>

<?php
	$qu_acc_biling_items_sel = "SELECT * FROM  `acc_biling_items` WHERE `bill_id` = $bill_id ORDER BY `bill_item_id` ASC";
	$qu_acc_biling_items_EXE = mysqli_query($KONN, $qu_acc_biling_items_sel);
	if(mysqli_num_rows($qu_acc_biling_items_EXE)){
		$itemsC = 1;
		$itmCount = 0;
		$tID = 0;
		while($acc_biling_items_REC = mysqli_fetch_assoc($qu_acc_biling_items_EXE)){
			$tID++;
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
			
			if( $is_tree == 1 ){
				$itmCount = 0;
				$thsCss = 'important';
			
		?>
				
				<tr class=" important treeItemm-<?=$tID; ?>" id="addedItem-<?=$bill_item_id; ?>">
				<td><i title="Delete this item" onclick="delItem(<?=$bill_item_id; ?>);" class="fas fa-trash"></i></td>
				<td><i title="Delete this item" onclick="AddtreeItem(<?=$tID; ?>);" class="fas fa-plus"></i></td>
				<td colspan="2">
					<div class="nwFormGroup">
						<textarea style="width: 100%;" name="item_descs[]" placeholder="Item Name" required><?=$item_desc; ?></textarea>
						<input type="hidden" name="is_trees[]" value="1">
						<input type="hidden" name="unit_ids[]" value="0">
						<input type="hidden" name="item_qtys[]" value="0">
						<input type="hidden" name="item_prices[]" value="0">
						<input type="hidden" name="item_tots[]" value="0">
					</div>
				</td>
				<td colspan="3"></td>
				</tr>
		<?php
			} else {
				$itemsC++;
		?>
				<tr class="item" id="addedItem-<?=$bill_item_id; ?>">
				<td>--</td>
				<td><i title="Delete this item" onclick="delItem(<?=$bill_item_id; ?>);" class="fas fa-trash"></i></td>
				<td>
					<div class="nwFormGroup">
						<input type="hidden" name="is_trees[]" value="0">
						<textarea style="width: 100%;" name="item_descs[]" placeholder="Item Name" required><?=$item_desc; ?></textarea>
					</div>
				</td>
				<td>
					<div class="nwFormGroup">
						<select class="frmData" id="new-unit_id<?=$bill_item_id; ?>" name="unit_ids[]" required>
							<option value="0" disabled selected><?=lang("Please_Select", "غير محدد"); ?></option>
				<?php
					$sNo = 0;
					$qu_gen_items_units_sel = "SELECT * FROM  `gen_items_units` ORDER BY `unit_name` ASC";
					$qu_gen_items_units_EXE = mysqli_query($KONN, $qu_gen_items_units_sel);
					if(mysqli_num_rows($qu_gen_items_units_EXE)){
						while($gen_items_units_REC = mysqli_fetch_assoc($qu_gen_items_units_EXE)){
							$THSunit_id       = ( int ) $gen_items_units_REC['unit_id'];
							$unit_name = $gen_items_units_REC['unit_name'];
						
						?>
							<option value="<?=$THSunit_id; ?>"><?=$unit_name; ?></option>
						<?php
						}
					}
				?>
						</select>
<script>
$('#new-unit_id<?=$bill_item_id; ?>').val('<?=$unit_id; ?>');
</script>
					</div>
				</td>
				<td>
					<div class="nwFormGroup">
						<input type="text" class="qty" name="item_qtys[]" value="<?=$item_qty; ?>" placeholder="Item Qty" required>
					</div>
				</td>
				<td>
					<div class="nwFormGroup">
						<input type="text" class="price" name="item_prices[]" value="<?=$item_price; ?>" placeholder="Unit Price" required>
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
	
	
	
		<tr id="added_items">
			<th colspan="5">--</th>
			<th><?=lang("Sub_Total:", "sss", 1); ?></th>
			<th  id="sub_tot">00.000</th>
		</tr>
		<tr>
			<th colspan="5">--</th>
			<th><?=lang("Vat_(5%):", "sss", 1); ?></th>
			<th  id="vat_amount">00.000</th>
		</tr>
		<tr>
			<th colspan="5">--</th>
			<th><?=lang("Total:", "sss", 1); ?></th>
			<th  id="grand_tot">00.000</th>
		</tr>
	</tbody>
</table>
			
			
			
			</div>
			
			
			<div class="zero"></div>
				


<div class="viewerBodyButtons">
		<a href="acc_biling.php"><button type="button">
			<?=lang('Cancel', 'ARR', 1); ?>
		</button></a>
		<button type="submit">
			<?=lang('Next', 'ARR', 1); ?>
		</button>
</div>
			
		</form>
	</div>
	<div class="zero"></div>
</div>
<script>
var tot_recs = 1500;


function addTree( tID ){
	var thsNamer = $('#tree-' + tID).text();
	var colecter = '';
	$('.opt-' + tID).each( function(){
		var idd = $(this).attr('id');
		var nam = $(this).attr('namer');
		if( $("#" + idd).prop('checked') ) {
			colecter = colecter + ', ' + nam;
		}
	} );
	colecter = colecter.substring(1).trim();
	
	if( colecter == '' ){
		colecter = thsNamer;
	} else {
		colecter = colecter + ' Of ' + thsNamer;
	}
	
	tot_recs++;
	var nw_rec = '<tr class="item important treeItemm-' + tID + '" id="addedItem-' + tot_recs + '">' + 
				'	<td><i title="Delete this item" onclick="delItem(' + tot_recs + ');" class="fas fa-trash"></i></td>' + 
				'	<td><i title="Delete this item" onclick="AddtreeItem(' + tID + ');" class="fas fa-plus"></i></td>' + 
				'	<td>' + 
				'		<div class="nwFormGroup">' + 
				'			<textarea style="width: 100%;" name="item_descs[]" placeholder="Item Name" required>' + colecter + '</textarea>' + 
				'			<input type="hidden" name="is_trees[]" value="1">' + 
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
				'			<input type="text" class="qty" name="item_qtys[]" value="0" placeholder="Item Qty" required>' + 
				'		</div>' + 
				'	</td>' + 
				'	<td>' + 
				'		<div class="nwFormGroup">' + 
				'			<input type="text" class="price" name="item_prices[]" value="0" placeholder="Unit Price" required>' + 
				'		</div>' + 
				'	</td>' + 
				'	<td>' + 
				'		<div class="nwFormGroup">' + 
				'			<input type="text" class="tot" name="item_tots[]" value="0" readonly>' + 
				'		</div>' + 
				'	</td>' + 
				'</tr>';
	
	
	$('#added_items').before( nw_rec );
			initTableEvents();
			calcTable();
}





function AddtreeItem( TT ){
	tot_recs++;
	var nw_rec = '<tr class="item" id="addedItem-' + tot_recs + '">' + 
				'	<td>--</td>' + 
				'	<td><i title="Delete this item" onclick="delItem(' + tot_recs + ');" class="fas fa-trash"></i></td>' + 
				'	<td>' + 
				'		<div class="nwFormGroup">' + 
				'			<input type="hidden" name="is_trees[]" value="0">' + 
				'			<textarea style="width: 100%;" name="item_descs[]" placeholder="Item Name" required></textarea>' + 
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
				'			<input type="text" class="qty" name="item_qtys[]" value="0" placeholder="Item Qty" required>' + 
				'		</div>' + 
				'	</td>' + 
				'	<td>' + 
				'		<div class="nwFormGroup">' + 
				'			<input type="text" class="price" name="item_prices[]" value="0" placeholder="Unit Price" required>' + 
				'		</div>' + 
				'	</td>' + 
				'	<td>' + 
				'		<div class="nwFormGroup">' + 
				'			<input type="text" class="tot" name="item_tots[]" value="0" readonly>' + 
				'		</div>' + 
				'	</td>' + 
				'</tr>';
	
	
			$('.treeItemm-' + TT ).after( nw_rec );
			initTableEvents();
			calcTable();
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

function initTableEvents(){
	$('.qty').on( 'input', function(){
		calcTable();
	} );
	$('.price').on( 'input', function(){
		calcTable();
	} );
	
}

function delItem( id ){
	$('#addedItem-' + id).remove();
}









			initTableEvents();
			calcTable();
</script>

<?php
	//PAGE DATA END   ----------------------------------------------///---------------------------------
	include('app/footer.php');
?>
</body>
</html>
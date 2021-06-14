<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	$menuId = 2;
	$subPageID = 5;
	
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
		<table class="tabler" border="2">
			<thead>
				<tr>
					<th><?=lang("MRV_REF", "AAR"); ?></th>
					<th style="width:30%;"><?=lang("Supplier", "AAR"); ?></th>
					<th><?=lang("Created_date", "AAR"); ?></th>
					<th><?=lang("Created_By", "AAR"); ?></th>
					<th><?=lang("Inspection_date", "AAR"); ?></th>
					<th><?=lang("Inspected_By", "AAR"); ?></th>
					<th><?=lang("Status", "AAR"); ?></th>
					<th><?=lang("Options", "AAR"); ?></th>
				</tr>
			</thead>
			<tbody>
<?php
	$sNo = 0;
	$qu_inv_mrvs_sel = "SELECT * FROM  `inv_mrvs` WHERE `mrv_status` = 'inspection_required' ORDER BY `mrv_id` DESC";
	$qu_inv_mrvs_EXE = mysqli_query($KONN, $qu_inv_mrvs_sel);
	if(mysqli_num_rows($qu_inv_mrvs_EXE)){
		while($inv_mrvs_REC = mysqli_fetch_assoc($qu_inv_mrvs_EXE)){
			
		$mrv_id           = ( int ) $inv_mrvs_REC['mrv_id'];
		$mrv_ref          = $inv_mrvs_REC['mrv_ref'];
		$created_date     = $inv_mrvs_REC['created_date'];
		$created_byID     = ( int ) $inv_mrvs_REC['created_by'];
		$inspected_date   = $inv_mrvs_REC['inspected_date'];
		$inspected_byID   = ( int ) $inv_mrvs_REC['inspected_by'];
		$mrv_status       = $inv_mrvs_REC['mrv_status'];
		$supplier_id      = ( int ) $inv_mrvs_REC['supplier_id'];
		
		
		if( $created_byID != 0 ){
			$created_by = get_emp_name($KONN, $created_byID );
		} else {
			$created_by = "NA";
			$created_date = "NA";
		}
		
		if( $inspected_byID != 0 ){
			$inspected_by = get_emp_name($KONN, $inspected_byID );
		} else {
			$inspected_by = "NA";
			$inspected_date = "NA";
		}
		
		if( $supplier_id != 0 ){
			$supplier = get_supplier_name( $supplier_id, $KONN );
		} else {
			$supplier = "NA";
		}
		
			
		
		
		?>
			<tr id="mrv-<?=$mrv_id; ?>">
				<td onclick="showPoDetails(<?=$mrv_id; ?>, '<?=$mrv_ref; ?>', 'viewPOdetails');"><span id="poREF-<?=$mrv_id; ?>" class="text-primary"><?=$mrv_ref; ?></span></td>
				<td style="text-align:left;"><?=$supplier; ?></td>
				<td><?=$created_date; ?></td>
				<td><?=$created_by; ?></td>
				<td><?=$inspected_date; ?></td>
				<td><?=$inspected_by; ?></td>
				<td><?=$mrv_status; ?></td>
				<td>
<?php
	if( $mrv_status == 'inspection_required' ){
?>
<a href="mrv_approval.php?mrv_id=<?=$mrv_id; ?>" class=""><button type="button"><?=lang("Start_Approvals", "AAR"); ?></button></a>
<?php
	}
?>
				</td>
			</tr>
		<?php
		}
	} else {
?>
			<tr>
				<td colspan="8">NO DATA FOUND</td>
			</tr>

<?php
	}
	
?>
			</tbody>
		</table>
		
	</div>
	<div class="zero"></div>
</div>


<?php
	//PAGE DATA END   ----------------------------------------------///---------------------------------
	include('app/footer.php');
?>

</body>
</html>
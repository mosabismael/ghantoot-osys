<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "Inv Coding";
	
	$menuId = 4;
	$subPageID = 12;
?>
<!DOCTYPE html>
<html dir="<?=$lang_dir; ?>" lang="<?=$lang; ?>">
<html>
<head>
	<?php include('app/meta.php'); ?>
    <?php include('app/assets.php'); ?>
</head>
<body>
<?php
	include('app/header.php');
	//PAGE DATA START -----------------------------------------------///---------------------------------
?>





<div class="row">
	<div class="col-100">
	
		<table id="dataTable" class="tabler" border="2">
			<thead>
				<tr>
					<th><?=lang("Invoice_REF", "AAR"); ?></th>
					<th><?=lang("Supplier", "AAR"); ?></th>
					<th><?=lang("Total", "AAR"); ?></th>
					<th><?=lang("Created_Date", "AAR"); ?></th>
					<th><?=lang("Status", "AAR"); ?></th>
					<th><?=lang("Options", "AAR"); ?></th>
				</tr>
			</thead>
			<tbody>
<?php
	$sNo = 0;
	$qu_acc_suppliers_invoices_sel = "SELECT * FROM  `acc_suppliers_invoices` ";
	$qu_acc_suppliers_invoices_EXE = mysqli_query($KONN, $qu_acc_suppliers_invoices_sel);
	if(mysqli_num_rows($qu_acc_suppliers_invoices_EXE)){
		while($acc_suppliers_invoices_REC = mysqli_fetch_assoc($qu_acc_suppliers_invoices_EXE)){
			$sNo++;
			$supplier_inv_id = $acc_suppliers_invoices_REC['supplier_inv_id'];
			$supplier_id = $acc_suppliers_invoices_REC['supplier_id'];
			$po_id = $acc_suppliers_invoices_REC['po_id'];
			$invoice_ref = $acc_suppliers_invoices_REC['invoice_ref'];
			$invoice_date = $acc_suppliers_invoices_REC['invoice_date'];
			$due_date = $acc_suppliers_invoices_REC['due_date'];
			$invoice_attach = $acc_suppliers_invoices_REC['invoice_attach'];
			$total_amount = $acc_suppliers_invoices_REC['total_amount'];
			$is_vat = $acc_suppliers_invoices_REC['is_vat'];
			$invoice_status = $acc_suppliers_invoices_REC['invoice_status'];
			$created_date = $acc_suppliers_invoices_REC['created_date'];
			$created_by = $acc_suppliers_invoices_REC['created_by'];
			// $BY       = get_emp_name($KONN, $employee_id );
			
			
	$qu_suppliers_list_sel = "SELECT `supplier_name` FROM  `suppliers_list` WHERE `supplier_id` = $supplier_id";
	$qu_suppliers_list_EXE = mysqli_query($KONN, $qu_suppliers_list_sel);
	$supplier_name = "";
	if(mysqli_num_rows($qu_suppliers_list_EXE)){
		$suppliers_list_DATA = mysqli_fetch_assoc($qu_suppliers_list_EXE);
		$supplier_name = $suppliers_list_DATA['supplier_name'];
	}

		?>
			<tr id="boxdata-<?=$supplier_inv_id; ?>">
				<td><?=$invoice_ref; ?></td>
				<td><?=$supplier_name; ?></td>
				<td><?=number_format($total_amount, 3); ?></td>
				<td><?=$created_date; ?></td>
				<td><?=$invoice_status; ?></td>
				<td>
				<a target="_blank" href="../uploads/<?=$invoice_attach; ?>"><button type="button">View</button></a>
				</td>
			</tr>
		<?php
		
		}
	} else {
?>
			<tr>
				<td colspan="7">NO DATA FOUND</td>
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
<script>

</script>
</body>
</html>
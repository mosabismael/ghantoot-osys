<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "Inv Coding";
	
	$menuId = 5;
	$subPageID = 16;
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
					<th><?=lang("Inoice_REF", "AAR"); ?></th>
					<th><?=lang("Bill_REF", "AAR"); ?></th>
					<th><?=lang("Job_Order", "AAR"); ?></th>
					<th><?=lang("Client", "AAR"); ?></th>
					<th><?=lang("Client_REF", "AAR"); ?></th>
					<th><?=lang("Created_Date", "AAR"); ?></th>
					<th><?=lang("Type", "AAR"); ?></th>
					<th><?=lang("Status", "AAR"); ?></th>
					<th><?=lang("Options", "AAR"); ?></th>
				</tr>
			</thead>
			<tbody>
<?php
	$sNo = 0;
	$qu_acc_invoices_sel = "SELECT * FROM  `acc_invoices`";
	$qu_acc_invoices_EXE = mysqli_query($KONN, $qu_acc_invoices_sel);
	if(mysqli_num_rows($qu_acc_invoices_EXE)){
		while($acc_invoices_REC = mysqli_fetch_assoc($qu_acc_invoices_EXE)){
			$sNo++;
		$invoice_id = $acc_invoices_REC['invoice_id'];
		$bill_id = $acc_invoices_REC['bill_id'];
		$client_id = $acc_invoices_REC['client_id'];
		$invoice_type = $acc_invoices_REC['invoice_type'];
		$invoice_ref = $acc_invoices_REC['invoice_ref'];
		$client_ref = $acc_invoices_REC['client_ref'];
		$created_date = $acc_invoices_REC['created_date'];
		$created_by = $acc_invoices_REC['created_by'];
		$job_order_id = $acc_invoices_REC['job_order_id'];
		$invoice_status = $acc_invoices_REC['invoice_status'];
		
			// $BY       = get_emp_name($KONN, $employee_id );
			
		
	$qu_job_orders_sel = "SELECT * FROM  `job_orders` WHERE `job_order_id` = $job_order_id";
	$qu_job_orders_EXE = mysqli_query($KONN, $qu_job_orders_sel);
	$job_orders_DATA;
	if(mysqli_num_rows($qu_job_orders_EXE)){
		$job_orders_DATA = mysqli_fetch_assoc($qu_job_orders_EXE);
		$project_name = $job_orders_DATA['project_name'];
		$client_id = $job_orders_DATA['client_id'];
		
		$job_order_type = $job_orders_DATA['job_order_type'];
		$project_manager_id = $job_orders_DATA['project_manager_id'];
		$job_order_status = $job_orders_DATA['job_order_status'];
		// $created_date = $job_orders_DATA['created_date'];
		$created_by = $job_orders_DATA['created_by'];
	}
		$job_order_ref = $job_orders_DATA['job_order_ref'];
		
		//load client DATA
	$qu_gen_clients_sel = "SELECT * FROM  `gen_clients` WHERE `client_id` = $client_id";
	$qu_gen_clients_EXE = mysqli_query($KONN, $qu_gen_clients_sel);
	$gen_clients_DATA;
	if(mysqli_num_rows($qu_gen_clients_EXE)){
		$gen_clients_DATA = mysqli_fetch_assoc($qu_gen_clients_EXE);
	}
		$client_id = $gen_clients_DATA['client_id'];
		$client_code = $gen_clients_DATA['client_code'];
		$client_name = $gen_clients_DATA['client_name'];

	$qu_acc_biling_sel = "SELECT * FROM  `acc_biling` WHERE `bill_id` = $bill_id";
	$qu_acc_biling_EXE = mysqli_query($KONN, $qu_acc_biling_sel);
	$bill_refRes = 'NA';
	if(mysqli_num_rows($qu_acc_biling_EXE)){
		$acc_biling_DATA = mysqli_fetch_assoc($qu_acc_biling_EXE);
		$bill_ref = $acc_biling_DATA['bill_ref'];
		$bill_refRes = "<a href='acc_billing_details.php?bill_id=$bill_id'>$bill_ref</a>";
	}

		?>
			<tr id="boxdata-<?=$invoice_id; ?>">
				<td><?=$invoice_ref; ?></td>
				<td class="text-primary"><?=$bill_refRes; ?></td>
				<td><?=$job_order_ref; ?></td>
				<td><?=$client_name; ?></td>
				<td><?=$client_ref; ?></td>
				<td><?=$created_date; ?></td>
				<td><?=$invoice_type; ?></td>
				<td><?=$invoice_status; ?></td>
				<td>
<a href="prints/acc_invoice_print.php?invoice_id=<?=$invoice_id; ?>" target="_blank"><button type="button">Print Invoice</button></a>
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
<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "Inv Coding";
	
	$menuId = 5;
	$subPageID = 17;
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
		<a href="acc_biling_new_01.php" class="actionBtn"><button type="button"><i class="fas fa-plus"></i><?=lang("Add_New", "AAR"); ?></button></a>

		<table id="dataTable" class="tabler" border="2">
			<thead>
				<tr>
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
	$qu_acc_biling_sel = "SELECT * FROM  `acc_biling` WHERE `bill_status` <> 'draft' ";
	$qu_acc_biling_EXE = mysqli_query($KONN, $qu_acc_biling_sel);
	if(mysqli_num_rows($qu_acc_biling_EXE)){
		while($acc_biling_REC = mysqli_fetch_assoc($qu_acc_biling_EXE)){
			$sNo++;
		$bill_id = $acc_biling_REC['bill_id'];
		$client_id = $acc_biling_REC['client_id'];
		$bill_type = $acc_biling_REC['bill_type'];
		$bill_ref = $acc_biling_REC['bill_ref'];
		$client_ref = $acc_biling_REC['client_ref'];
		$created_date = $acc_biling_REC['created_date'];
		$created_by = $acc_biling_REC['created_by'];
		$job_order_id = $acc_biling_REC['job_order_id'];
		$bill_status = $acc_biling_REC['bill_status'];
		
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
		
		
		$invoice_id = 0;
	$qu_acc_invoices_sel = "SELECT * FROM  `acc_invoices` WHERE `bill_id` = $bill_id";
	$qu_acc_invoices_EXE = mysqli_query($KONN, $qu_acc_invoices_sel);
	$acc_invoices_DATA;
	if(mysqli_num_rows($qu_acc_invoices_EXE)){
		$acc_invoices_DATA = mysqli_fetch_assoc($qu_acc_invoices_EXE);
		$invoice_id = ( int ) $acc_invoices_DATA['invoice_id'];
	}

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

		
		?>
			<tr id="boxdata-<?=$bill_id; ?>">
				<td class="text-primary"><a href="acc_billing_details.php?bill_id=<?=$bill_id; ?>"><?=$bill_ref; ?></a></td>
				<td><?=$job_order_ref; ?></td>
				<td><?=$client_name; ?></td>
				<td><?=$client_ref; ?></td>
				<td><?=$created_date; ?></td>
				<td><?=$bill_type; ?></td>
				<td><?=$bill_status; ?></td>
				<td>
		<?php
			if( $bill_status == 'draft' ){
		?>
					<a href="acc_billing_send_acc.php?bill_id=<?=$bill_id; ?>"><button type="button">Send To ACC</button></a>
		<?php
			} else if( $bill_status == 'invoice_created' ){
		?>
					<a href="prints/acc_invoice_print.php?invoice_id=<?=$invoice_id; ?>" target="_blank"><button type="button">Open Invoice</button></a>
		<?php
			} else if( $bill_status == 'sent_to_acc' ){
				
				//get client ID
				$qu_acc_accounts_sel = "SELECT `account_id` FROM  `acc_accounts` WHERE `account_no` = '$client_code'";
				$qu_acc_accounts_EXE = mysqli_query($KONN, $qu_acc_accounts_sel);
				$account_id = 0;
				if(mysqli_num_rows($qu_acc_accounts_EXE)){
					$acc_accounts_DATA = mysqli_fetch_assoc($qu_acc_accounts_EXE);
					$account_id = $acc_accounts_DATA['account_id'];
		?>
					<a href="acc_billing_details.php?bill_id=<?=$bill_id; ?>"><button type="button">Details</button></a>
		<?php
				
				}
		?>
					<a href="acc_billing_attachments.php?bill_id=<?=$bill_id; ?>"><button type="button">Attachments</button></a>
				</td>
			</tr>
		<?php
		
	
				
		}
		
		
		
		
		
		
		
		
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
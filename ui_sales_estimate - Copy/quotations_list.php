<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 2;
	$subPageID = 21;
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
	
<table id="dataTable" class="tabler" border="2">
	<thead>
		<tr>
			<th><?=lang("Sys_Id", "AAR"); ?></th>
			<th><?=lang("REF", "AAR"); ?># - <?=lang("REV", "AAR"); ?></th>
			<th><?=lang("RFQ", "AAR"); ?></th>
			<th><?=lang("Date", "AAR"); ?></th>
			<th><?=lang("Token_-_Client_Name", "AAR"); ?></th>
			<th><?=lang("Valid_Until", "AAR"); ?></th>
			<th><?=lang("Status", "AAR"); ?></th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
<?php
	$qu_sales_quotations_sel = "SELECT * FROM  `sales_quotations`";
	$qu_sales_quotations_EXE = mysqli_query($KONN, $qu_sales_quotations_sel);
	if(mysqli_num_rows($qu_sales_quotations_EXE)){
		while($sales_quotations_REC = mysqli_fetch_assoc($qu_sales_quotations_EXE)){
			$quotation_id = $sales_quotations_REC['quotation_id'];
			$client_id = $sales_quotations_REC['client_id'];
			$valider_std = $sales_quotations_REC['valid_date'];
			$valider = $sales_quotations_REC['valid_date'];
			$quotation_status = $sales_quotations_REC['quotation_status'];
			$stater = $quotation_status;
			
			$isExpired = false;
			
			
	$qu_gen_clients_sel = "SELECT * FROM  `gen_clients` WHERE `client_id` = $client_id";
	$qu_gen_clients_EXE = mysqli_query($KONN, $qu_gen_clients_sel);
	$client_name = "NA";
	if(mysqli_num_rows($qu_gen_clients_EXE)){
		$gen_clients_DATA = mysqli_fetch_assoc($qu_gen_clients_EXE);
		$client_id = $gen_clients_DATA['client_id'];
		$client_name = $gen_clients_DATA['client_name'];
	}
	
			if($valider_std < date('Y-m-d')){
				$valider = '<span style="color:red;">'.$valider.'</span>';
				$isExpired = false;
				$stater = $quotation_status." - Expired";
			}
		?>
		<tr id="quote-<?=$quotation_id; ?>">
			<td><?=$quotation_id; ?></td>
			<td><?=$sales_quotations_REC["quotation_ref"]; ?> - <?=$sales_quotations_REC["rev_no"]; ?></td>
			<td><?=$sales_quotations_REC["rfq_no"]; ?></td>
			<td><?=$sales_quotations_REC["quotation_date"]; ?></td>
			<td><?=$client_name; ?></td>
			<td><?=$valider; ?></td>
			<td><?=$stater; ?></td>
			<td class="text-center">
				<a href="quotations_details.php?quotation_id=<?=$quotation_id; ?>" title="<?=lang("Account Details", "AAR"); ?>"><i class="fas fa-info-circle"></i></a>
			</td>
		</tr>
		<?php
		}
	} else {
		?>
		<tr id="quote-0">
			<td colspan="8"><?=lang("No Data Found", "AAR"); ?></td>
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
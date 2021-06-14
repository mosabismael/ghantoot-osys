<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "ACC Report";
	
	$menuId = 7;
	$subPageID = 23;
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


<?php
$jo_id = 0;
$COND01 = "";

if( isset( $_GET['jo_id'] ) ){
	$jo_id = ( int ) test_inputs( $_GET['jo_id'] );
	if( $jo_id != 0 ){
		$COND01 = "AND (`job_order_id` = '$jo_id')";
	}
}



$date_from = "";
$COND02 = "";

if( isset( $_GET['date_from'] ) ){
	$date_from = test_inputs( $_GET['date_from'] );
	if( $date_from != "" ){
		$COND02 = "AND (`created_date` >= '$date_from')";
	}
}

$date_to = "";
$COND03 = "";

if( isset( $_GET['date_to'] ) ){
	$date_to = test_inputs( $_GET['date_to'] );
	if( $date_to != "" ){
		$COND03 = "AND (`created_date` <= '$date_to')";
	}
}
?>




<div class="row">
	<div class="col-100">
		<form action="report_balance_sheet.php" method="GET">
			
			
			<div class="col-33">
				<div class="nwFormGroup">
					<label><?=lang("Date_From:", "AAR"); ?></label>
					<input class="frmData has_date" value="<?=$date_from; ?>" id="new-date_from" name="date_from">
				</div>
				<div class="zero"></div>
			</div>
			<div class="col-33">
				<div class="nwFormGroup">
					<label><?=lang("Date_To:", "AAR"); ?></label>
					<input class="frmData has_date" value="<?=$date_to; ?>" id="new-date_to" name="date_to">
				</div>
				<div class="zero"></div>
			</div>
			
			<div class="col-33">
				<div class="nwFormGroup">
					<br>
					<button type="submit">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=lang("Search", "AAR"); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
				</div>
				<div class="zero"></div>
			</div>
				<div class="zero"></div>
			
		</form>
	</div>
	<div class="col-100">
	
		
		
		
<table class="tabler" style="text-align:left;width:80%;">
	<thead>
		<tr>
			<th colspan="2"><?=lang("REVENUE", "AAR"); ?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>---<?=lang("Sales-Marine", "AAR"); ?></td>
			<td>00.000</td>
		</tr>
		<tr>
			<td>---<?=lang("Sales-Steel", "AAR"); ?></td>
			<td>00.000</td>
		</tr>
		<tr>
			<td><strong style="width:100%;"><?=lang("Net_Sales", "AAR"); ?></strong></td>
			<td>00.000</td>
		</tr>
		<tr>
			<td colspan="2"><hr></td>
		</tr>
	</tbody>
	
	
	
	
	
	

	<thead>
		<tr>
			<th colspan="2"><?=lang("Cost_Of_Goods_Sold", "AAR"); ?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>---<?=lang("Materials", "AAR"); ?></td>
			<td>00.000</td>
		</tr>
		<tr>
			<td>---<?=lang("ManPower", "AAR"); ?></td>
			<td>00.000</td>
		</tr>
		<tr>
			<td>---<?=lang("Equipments", "AAR"); ?></td>
			<td>00.000</td>
		</tr>
		<tr>
			<td>---<?=lang("OverHead", "AAR"); ?></td>
			<td>00.000</td>
		</tr>
		
		<tr>
			<td><strong style="width:100%;"><?=lang("Total_Cost_Of_Goods_Sold", "AAR"); ?></strong></td>
			<td>00.000</td>
		</tr>
		<tr>
			<td><strong style="width:100%;"><?=lang("Gross_Profit", "AAR"); ?></strong></td>
			<td>00.000</td>
		</tr>
		<tr>
			<td colspan="2"><hr></td>
		</tr>
	</tbody>
	
	<thead>
		<tr>
			<th colspan="2"><?=lang("Operating_Expenses", "AAR"); ?></th>
		</tr>
	</thead>
	
		<tr>
			<td><strong style="width:100%;"><?=lang("Total_Operating_Expenses", "AAR"); ?></strong></td>
			<td>00.000</td>
		</tr>
		<tr>
			<td colspan="2"><hr></td>
		</tr>
	</tbody>
	
	<thead>
		<tr>
			<th colspan="2"><?=lang("Operating_Profit", "AAR"); ?></th>
		</tr>
	</thead>
	
		<tr>
			<td><strong style="width:100%;"><?=lang("Total_Operating_Profit", "AAR"); ?></strong></td>
			<td>00.000</td>
		</tr>
		<tr>
			<td colspan="2"><hr></td>
		</tr>
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
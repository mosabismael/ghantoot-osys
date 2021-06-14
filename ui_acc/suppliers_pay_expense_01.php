<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 4;
	$subPageID = 13;
	
	$RES = '';
	


	
$noAcc = "";
if( isset( $_GET['noAcc'] ) ){
	$RES = 'Supplier Account not defined<br>';
}
	








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
		<form action="suppliers_pay_expense_02.php" method="get">
		
		
			<div class="row col-100">
				<div class="nwFormGroup">
					<label><?=lang("Select_Supplier:", "AAR"); ?></label>
					<select class="frmData" id="new-supplier_id" name="supplier_id" required>
						<option value="0" disabled selected><?=lang("Please_Select", "غير محدد"); ?></option>
		<?php
			$sNo = 0;
			$qu_suppliers_list_sel = "SELECT * FROM  `suppliers_list` ORDER BY `supplier_name` ASC";
			$qu_suppliers_list_EXE = mysqli_query($KONN, $qu_suppliers_list_sel);
			if(mysqli_num_rows($qu_suppliers_list_EXE)){
				while($suppliers_list_REC = mysqli_fetch_assoc($qu_suppliers_list_EXE)){
					$supplier_id       = ( int ) $suppliers_list_REC['supplier_id'];
					
			$supplier_code = $suppliers_list_REC['supplier_code'];
			$supplier_name = $suppliers_list_REC['supplier_name'];
			$supplier_type = $suppliers_list_REC['supplier_type'];
			$supplier_cat = $suppliers_list_REC['supplier_cat'];
			$supplier_email = $suppliers_list_REC['supplier_email'];
			$website = $suppliers_list_REC['website'];
			$country = $suppliers_list_REC['country'];
			$address = $suppliers_list_REC['address'];
			$contact_person = $suppliers_list_REC['contact_person'];
			$supplier_phone = $suppliers_list_REC['supplier_phone'];
			$trn_no = $suppliers_list_REC['trn_no'];
				
				?>
						<option value="<?=$supplier_id; ?>"><?=$supplier_name; ?></option>
				<?php
				
				
		
				}
			}
		?>
					</select>
				</div>
				<div class="zero"></div>
			</div>
		
			
			<div class="zero"></div>
				


<div class="viewerBodyButtons">
		<?=$RES; ?><br>
		<a href="acc_biling.php"><button type="button">
			<?=lang('Back', 'ARR', 1); ?>
		</button></a>
		<button type="submit">
			<?=lang('Next', 'ARR', 1); ?>
		</button>
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
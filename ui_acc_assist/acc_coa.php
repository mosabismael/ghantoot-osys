<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "ACC COA";
	
	$menuId = 1;
	$subPageID = 1;
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
		
<a onclick="add_new_modal_unit();" class="actionBtn"><button type="button"><i class="fas fa-plus"></i><?=lang("Add_New", "AAR"); ?></button></a>
<br>
		
		<table id="dataTable" class="tabler" border="2">
			<thead>
				<tr>
					<th style="width: 15%;"><?=lang("Account_NO.", "AAR"); ?></th>
					<th style="width: 30%;"><?=lang("Account_Name", "AAR"); ?></th>
					<th><?=lang("Current_Balance", "AAR"); ?></th>
					<th><?=lang("Type", "AAR"); ?></th>
					<th><?=lang("Last_Updated", "AAR"); ?></th>
					<th>---</th>
				</tr>
			</thead>
			<tbody>
<?php
	$sNo = 0;
	$qu_acc_accounts_sel = "SELECT * FROM  `acc_accounts` ORDER BY `account_no` ASC";
	$qu_acc_accounts_EXE = mysqli_query($KONN, $qu_acc_accounts_sel);
	if(mysqli_num_rows($qu_acc_accounts_EXE)){
		while($acc_accounts_REC = mysqli_fetch_assoc($qu_acc_accounts_EXE)){
			$account_id = $acc_accounts_REC['account_id'];
			$account_no = $acc_accounts_REC['account_no'];
			$account_name = $acc_accounts_REC['account_name'];
			$account_type_id = $acc_accounts_REC['account_type_id'];
			$account_description = $acc_accounts_REC['account_description'];
			$opening_balance = $acc_accounts_REC['opening_balance'];
			$current_balance = $acc_accounts_REC['current_balance'];
			$last_updated = $acc_accounts_REC['last_updated'];
		
		
		
	$qu_acc_accounts_types_sel = "SELECT * FROM  `acc_accounts_types` WHERE `account_type_id` = $account_type_id";
	$qu_acc_accounts_types_EXE = mysqli_query($KONN, $qu_acc_accounts_types_sel);
	$account_type_name = "NA";
	if(mysqli_num_rows($qu_acc_accounts_types_EXE)){
		$acc_accounts_types_DATA = mysqli_fetch_assoc($qu_acc_accounts_types_EXE);
		$account_type_name = $acc_accounts_types_DATA['account_type_name'];
	}

		
		
		
		
		?>
			<tr id="boxdata-<?=$account_id; ?>">
				<td><?=$account_no; ?></td>
				<td onclick="edit_data(<?=$account_id; ?>);" style="text-align:left;"><span id="Acc-<?=$account_id; ?>" class="text-primary cell-title"><?=$account_name; ?></span></td>
				<td><?=$current_balance; ?></td>
				<td><?=$account_type_name; ?></td>
				<td><?=$last_updated; ?></td>
				<td><a href="acc_cycle.php?acc_id=<?=$account_id; ?>" style="color:blue;"><?=lang("View_Transactions", "AAR"); ?></a></td>
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
</body>
</html>
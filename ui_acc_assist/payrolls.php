<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 6;
	$subPageID = 181;
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
			<th style="width: 20%;"><?=lang("REF", "AAR"); ?></th>
			<th><?=lang("Month", "AAR"); ?></th>
			<th><?=lang("Year", "AAR"); ?></th>
			<th><?=lang("Created_By", "AAR"); ?></th>
			<th><?=lang("Opts", "AAR"); ?></th>
		</tr>
	</thead>
	<tbody>
<?php
	$qu_acc_payrolls_sel = "SELECT * FROM  `acc_payrolls`";
	$qu_acc_payrolls_EXE = mysqli_query($KONN, $qu_acc_payrolls_sel);
	if(mysqli_num_rows($qu_acc_payrolls_EXE)){
		while($acc_payrolls_REC = mysqli_fetch_assoc($qu_acc_payrolls_EXE)){
			$payroll_id = $acc_payrolls_REC['payroll_id'];
			$payroll_year = $acc_payrolls_REC['payroll_year'];
			$payroll_month = $acc_payrolls_REC['payroll_month'];
			$created_date = $acc_payrolls_REC['created_date'];
			$created_by = $acc_payrolls_REC['created_by'];
			$qu_hr_employees_sel = "SELECT * FROM  `hr_employees` WHERE `employee_id` = $created_by";
			$qu_hr_employees_EXE = mysqli_query($KONN, $qu_hr_employees_sel);
			$Namer = "";
			if(mysqli_num_rows($qu_hr_employees_EXE)){
				$hr_employees_DATA = mysqli_fetch_assoc($qu_hr_employees_EXE);
				$Namer  = $hr_employees_DATA['first_name'].' '.$hr_employees_DATA['last_name'];
			}
			//generate ref base on month and year
			$REF = "ACC_PR-".$payroll_year.'-'.$payroll_month;
?>
		<tr id="emp-<?=$payroll_id; ?>">
			<td style="text-align:left;"><a href="payrolls_detail.php?payroll_id=<?=$payroll_id; ?>" id="reqREF-<?=$payroll_id; ?>" class="text-primary"><?=$REF; ?></a></td>
			<td><?=$payroll_month; ?></td>
			<td><?=$payroll_year; ?></td>
			<td><?=$Namer; ?></td>
			<td>--</td>
		</tr>
		<?php
		}
	} else {
		?>
		<tr id="emp-<?=$payroll_id; ?>">
			<td colspan="5"><?=lang("No Data Found", "AAR"); ?></td>
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
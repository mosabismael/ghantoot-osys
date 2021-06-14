<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 6;
	$subPageID = 181;
	
	
	
	
	
	
	$allTOTPO = 0;
		$qu_purchase_orders_items_sel = "SELECT * FROM  `purchase_orders_items` ";
	$qu_purchase_orders_items_EXE = mysqli_query($KONN, $qu_purchase_orders_items_sel);
	if(mysqli_num_rows($qu_purchase_orders_items_EXE)){
		while($purchase_orders_items_REC = mysqli_fetch_assoc($qu_purchase_orders_items_EXE)){
			$item_qty   = ( double ) $purchase_orders_items_REC['item_qty'];
			$item_price = ( double ) $purchase_orders_items_REC['item_price'];
			
			$thsTOT = $item_qty * $item_price;
			$allTOTPO = $allTOTPO + $thsTOT;
		
		}
	}

	
	
	
	
	
	
$THSmonth = date('m');
$THSyear  = date('Y');
	
if( isset( $_GET['ts_month'] ) ){
	$THSmonth = ( int ) test_inputs( $_GET['ts_month'] );
}
	
if( isset( $_GET['ts_year'] ) ){
	$THSyear = ( int ) test_inputs( $_GET['ts_year'] );
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
		
<!--a href="clients_new.php" class="actionBtn"><button type="button"><i class="fas fa-plus"></i><?=lang("Add_New", "AAR"); ?></button></a-->
<br>

		<form action="payrolls.php" method="GET">
<table class="tabler" border="2">
	<thead>
		<tr>
			<th><?=lang("Month", "AAR"); ?></th>
			<th><?=lang("Year", "AAR"); ?></th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>
				<select class="frmData" id="new-ts_month" name="ts_month" required>
					<option value="0" disabled selected><?=lang("Please_Select", "غير محدد"); ?></option>
					
				<?php
				$mStart = 1;
				$mEnd   = 12;
				for( $M = $mStart ; $M <= $mEnd ; $M++){
					$M_v = ''.$M;
					if( $M < 10 ){
						$M_v = '0'.$M;
					}
				?>
				<option value="<?=$M_v; ?>"><?=$M_v; ?></option>
				<?php
				}
				?>
				</select>
	<script>
	$('#new-ts_month').val('<?=$THSmonth; ?>');
	</script>
			</td>
			<td>
				<select class="frmData" id="new-ts_year" name="ts_year" required>
					<option value="0" disabled selected><?=lang("Please_Select", "غير محدد"); ?></option>
					
				<?php
				$yStart = ( int ) date('Y');
				$yEnd   = ( int ) date('Y') + 2;
				for( $Y = $yStart ; $Y <= $yEnd ; $Y++){
				?>
				<option value="<?=$Y; ?>"><?=$Y; ?></option>
				<?php
				}
				?>
				</select>
	<script>
	$('#new-ts_year').val('<?=$THSyear; ?>');
	</script>
			</td>
			<td><button type="submit">&nbsp;&nbsp;&nbsp;<?=lang("View", "AAR"); ?>&nbsp;&nbsp;&nbsp;</button></td>
		</tr>
	</tbody>
</table>
	</form>
<table id="dataTable" class="tabler" border="2">
	<thead>
		<tr>
			<th><?=lang("Code", "AAR"); ?></th>
			<th style="width: 30%;"><?=lang("Name", "AAR"); ?></th>
			<th><?=lang("Basic_Rate", "AAR"); ?></th>
			<th title="<?=lang("OT", "AAR"); ?>"><?=lang("OT", "AAR"); ?></th>
			<th title="<?=lang("HRA", "AAR"); ?>"><?=lang("HRA", "AAR"); ?></th>
			<th><?=lang("Trans/living/other/<br>Allow.", "AAR"); ?></th>
			<th><?=lang("Air Ticket<br>Allow.", "AAR"); ?></th>
			<th><?=lang("Food<br>Allow.", "AAR"); ?></th>
			<th><?=lang("Gross_Pay.", "AAR"); ?></th>
			<th><?=lang("Adujt.", "AAR"); ?></th>
			<th><?=lang("Total_Pay", "AAR"); ?></th>
		</tr>
	</thead>
	<tbody>
<?php
		$totBasic      = 0;
		$totAllowance  = 0;
		$totDeductions = 0;
		$totDA         = 0;
		$totAll        = 0;
		$ZERO          = 0;
		
	$qu_hr_employees_sel = "SELECT * FROM  `hr_employees` WHERE `employee_type` = 'local'";
	$qu_hr_employees_EXE = mysqli_query($KONN, $qu_hr_employees_sel);
	if(mysqli_num_rows($qu_hr_employees_EXE)){
		while($hr_employees_REC = mysqli_fetch_assoc($qu_hr_employees_EXE)){
			$ths_employee_id  = ( int ) $hr_employees_REC['employee_id'];
			$employee_code  = $hr_employees_REC['employee_code'];
			$Namer  = $hr_employees_REC['first_name'].' '.$hr_employees_REC['last_name'];
			$basic_salary  = ( double ) $hr_employees_REC['basic_salary'];
			$ZERO = '0.000';
			$thsTOT = 0;
			
			$dailyRate = 0;
			$hourRate = 0;
			$holidayRate = 0;
			$thsAlowance = 0;
			$thsDeduction = 0;
			$thsDisActions = 0;
			$thsDeductedDays = 0;
			
			
			$lastday =cal_days_in_month( CAL_GREGORIAN, $THSmonth, $THSyear );
			
			$monthStart = $THSyear.'-'.$THSmonth.'-1';
			$monthEnd = $THSyear.'-'.$THSmonth.'-'.$lastday;
			
			//calc allowance
	$qu_hr_employees_allowances_sel = "SELECT SUM(`allowance_amount`) FROM  `hr_employees_allowances` WHERE ( ((`active_from` <= '$monthStart') AND (`active_to` >= '$monthEnd')) AND (`employee_id` = $ths_employee_id) AND (`allowance_type` = 'monthly'))";
	$qu_hr_employees_allowances_EXE = mysqli_query($KONN, $qu_hr_employees_allowances_sel);
	$hr_employees_allowances_DATA;
	if(mysqli_num_rows($qu_hr_employees_allowances_EXE)){
		$hr_employees_allowances_DATA = mysqli_fetch_array($qu_hr_employees_allowances_EXE);
		$thsAlowance = ( double ) $hr_employees_allowances_DATA[0];
	}

			
			
			//calc deductions
	$qu_hr_employees_deductions_sel = "SELECT SUM(`deduction_amount`)  FROM  `hr_employees_deductions` WHERE 
																				((`employee_id` = $ths_employee_id) AND 
																				 ( (`deduction_effective_date` >= '$monthStart') AND (`deduction_effective_date` <= '$monthEnd') ) )";
	$qu_hr_employees_deductions_EXE = mysqli_query($KONN, $qu_hr_employees_deductions_sel);
	$hr_employees_deductions_DATA;
	if(mysqli_num_rows($qu_hr_employees_deductions_EXE)){
		$hr_employees_deductions_DATA = mysqli_fetch_array($qu_hr_employees_deductions_EXE);
		$thsDeduction = ( double ) $hr_employees_deductions_DATA[0];
	}

			
			
			//calc displanary actions
			$qu_hr_employees_disp_actions_sel = "SELECT SUM(`deductions`) FROM  `hr_employees_disp_actions` WHERE 
																					((`employee_id` = $ths_employee_id) AND 
																				 ( (`created_date` >= '$monthStart') AND (`created_date` <= '$monthEnd') ) )";
			$qu_hr_employees_disp_actions_EXE = mysqli_query($KONN, $qu_hr_employees_disp_actions_sel);
			if(mysqli_num_rows($qu_hr_employees_disp_actions_EXE)){
				$hr_employees_disp_actions_DATA = mysqli_fetch_array($qu_hr_employees_disp_actions_EXE);
				$thsDeductedDays = ( int ) $hr_employees_disp_actions_DATA[0];
			}
			
			$thsTOT = ( ( $thsAlowance ) - ( $thsDeduction + $thsDisActions ) ) + $basic_salary;
			$holidayRate = 0;
			//calc work value per day
			$dailyRate        = $thsTOT / 26;
			$dailyRateHoliday = $basic_salary / 26;
			
			$hourRate  = $dailyRate / 8;
			$holidayRate  = $dailyRateHoliday / 8;
			$dailyRate = number_format( $dailyRate, 3 );
			$holidayRate = number_format( $holidayRate, 3 );
			$hourRate = number_format( $hourRate, 3 );
			
			
			$thsDisActions = $thsDeductedDays * $dailyRate;
			
			
			
			
			
			
			$thsTOT = ( ( $thsAlowance ) - ( $thsDeduction + $thsDisActions ) ) + $basic_salary;
			
		
		$totBasic      = $totBasic + $basic_salary;
		
		$totAllowance  = $totAllowance + $thsAlowance;
		
		$totDeductions = $totDeductions + $thsDeduction;
		
		$totDA         = $totDA + $thsDisActions;
		
		$totAll        = $totAll + $thsTOT;
		
		
			
		?>
		<tr id="emp-<?=$ths_employee_id; ?>">
			<td><?=$employee_code; ?></td>
<td style="text-align:left;"><a href="payrolls_detail.php?employee_id=<?=$ths_employee_id; ?>" id="reqREF-<?=$ths_employee_id; ?>" class="text-primary"><?=$Namer; ?></a></td>
			<td title="<?=lang("Basic_Salary", "AAR"); ?>"><?=$basic_salary; ?></td>
			<td title="<?=lang("Hour_Rate", "AAR"); ?>"><?=$hourRate; ?></td>
			<td title="<?=lang("Holiday_Rate", "AAR"); ?>"><?=$holidayRate; ?></td>
			<td title="<?=lang("Allowances_Total", "AAR"); ?>"><?=$thsAlowance; ?></td>
			<td title="<?=lang("Leaves_Total", "AAR"); ?>"><?=$ZERO; ?></td>
			<td title="<?=lang("Deductions_Total", "AAR"); ?>"><?=$thsDeduction; ?></td>
			<td title="<?=lang("Displinary_Actions_Total", "AAR"); ?>"><?=$thsDisActions; ?></td>
			<td title="<?=lang("Displinary_Actions_Total", "AAR"); ?>"><?=$ZERO; ?></td>
			<td title="<?=lang("Total_Salary", "AAR"); ?>"><?=$thsTOT; ?></td>
		</tr>
		<?php
		}
	} else {
		?>
		<tr id="emp-<?=$ths_employee_id; ?>">
			<td colspan="5"><?=lang("No Data Found", "AAR"); ?></td>
		</tr>
		<?php
	}
	
?>
		<tr>
			<td></td>
			<td>--</td>
			<td>--</td>
			<td><?=lang("Totals :", "AAR"); ?></td>
			<td title="<?=lang("Basic_Salary", "AAR"); ?>"><?=$totBasic; ?></td>
			<td title="<?=lang("Allowances_Total", "AAR"); ?>"><?=$totAllowance; ?></td>
			<td title="<?=lang("Leaves_Total", "AAR"); ?>"><?=$ZERO; ?></td>
			<td title="<?=lang("Deductions_Total", "AAR"); ?>"><?=$totDeductions; ?></td>
			<td title="<?=lang("Displinary_Actions_Total", "AAR"); ?>"><?=$totDA; ?></td>
			<td title="<?=lang("Total_Salary", "AAR"); ?>"><?=$totAll; ?></td>
			<td title="<?=lang("Total_Salary", "AAR"); ?>"><?=$totAll; ?></td>
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

init_nwFormGroup();
</script>

</body>
</html>
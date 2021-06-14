<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 9;
	$subPageID = 16;
	
	
	
	
	$employee_id = 0;
	if( isset( $_GET['employee_id'] ) ){
		$employee_id = ( int ) test_inputs( $_GET['employee_id'] );
	}
	
	
	
	if( $employee_id != 0 ){
		
	$qu_hr_employees_sel = "SELECT * FROM  `hr_employees` WHERE `employee_id` = $employee_id";
	$qu_hr_employees_EXE = mysqli_query($KONN, $qu_hr_employees_sel);
	$hr_employees_DATA;
	if(mysqli_num_rows($qu_hr_employees_EXE)){
		$hr_employees_DATA = mysqli_fetch_assoc($qu_hr_employees_EXE);
	}
		$employee_code = $hr_employees_DATA['employee_code'];
		$first_name = $hr_employees_DATA['first_name'];
		$second_name = $hr_employees_DATA['second_name'];
		$third_name = $hr_employees_DATA['third_name'];
		$last_name = $hr_employees_DATA['last_name'];
		$profile_pic = $hr_employees_DATA['profile_pic'];
		$dob = $hr_employees_DATA['dob'];
		$mobile_personal = $hr_employees_DATA['mobile_personal'];
		$mobile_work = $hr_employees_DATA['mobile_work'];
		$email_personal = $hr_employees_DATA['email_personal'];
		$email_work = $hr_employees_DATA['email_work'];
		$gender = $hr_employees_DATA['gender'];
		$martial_status = $hr_employees_DATA['martial_status'];
		$certificate_id = $hr_employees_DATA['certificate_id'];
		$graduation_date = $hr_employees_DATA['graduation_date'];
		$join_date = $hr_employees_DATA['join_date'];
		$nationality_id = $hr_employees_DATA['nationality_id'];
		$leaves_total_annual = $hr_employees_DATA['leaves_total_annual'];
		$leaves_open_balance = $hr_employees_DATA['leaves_open_balance'];
		$basic_salary = ( double ) $hr_employees_DATA['basic_salary'];
		$bank_id = $hr_employees_DATA['bank_id'];
		$bank_account_no = $hr_employees_DATA['bank_account_no'];
		$iban_no = $hr_employees_DATA['iban_no'];
		$designation_id = $hr_employees_DATA['designation_id'];
		$department_id = $hr_employees_DATA['department_id'];
		$employee_address = $hr_employees_DATA['employee_address'];
		$employee_status = $hr_employees_DATA['employee_status'];
		$employee_type = $hr_employees_DATA['employee_type'];
		$company_name = $hr_employees_DATA['company_name'];

		$namer = $hr_employees_DATA['first_name'].' '.$hr_employees_DATA['last_name'];
	
	
	
		
		$qu_hr_departments_sel = "SELECT * FROM  `hr_departments` WHERE `department_id` = $department_id";
		$qu_hr_departments_EXE = mysqli_query($KONN, $qu_hr_departments_sel);
		$department_name = "";
		if(mysqli_num_rows($qu_hr_departments_EXE)){
			$hr_departments_DATA = mysqli_fetch_assoc($qu_hr_departments_EXE);
			$department_name = $hr_departments_DATA['department_name'];
		}

		$qu_hr_departments_designations_sel = "SELECT * FROM  `hr_departments_designations` WHERE `designation_id` = $designation_id";
		$qu_hr_departments_designations_EXE = mysqli_query($KONN, $qu_hr_departments_designations_sel);
		$designation_name = "";
		if(mysqli_num_rows($qu_hr_departments_designations_EXE)){
			$hr_departments_designations_DATA = mysqli_fetch_assoc($qu_hr_departments_designations_EXE);
			$designation_name = $hr_departments_designations_DATA['designation_name'];
		}
	
	
	
	
	
	
	
	
			$dailyRate = 0;
			$hourRate = 0;
	
	
	
	
			
			//calc work value per day
			$dailyRate = $basic_salary / 26;
			$hourRate  = $dailyRate / 8;
			$dailyRate = number_format( $dailyRate, 3 );
			$hourRate = number_format( $hourRate, 3 );
	
	
	
	
	
	
	
	
	}
	
	
	$backer = "";
	if( isset( $_GET['b'] ) ){
		$backer = test_inputs( $_GET['b'] );
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


<?php
if( $employee_id != 0 ){
?>
<div class="row">
	<div class="col-100">
<a href="<?=$backer; ?>" class="actionBtn"><button type="button"><?=lang("Back", "AAR"); ?></button></a>
<br>
<table class="tabler" border="2">
	<thead>
		<tr>
			<th colspan="5"><?=lang("Employee_Details", "AAR"); ?></th>
		</tr>
		<tr>
			<th><?=lang("Code", "AAR"); ?></th>
			<th style="width: 30%;"><?=lang("Name", "AAR"); ?></th>
			<th><?=lang("Join_Date", "AAR"); ?></th>
			<th><?=lang("designation", "AAR"); ?></th>
			<th><?=lang("department", "AAR"); ?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?=$employee_code; ?></td>
			<td><?=$namer; ?></td>
			<td><?=$join_date; ?></td>
			<td><?=$department_name; ?></td>
			<td><?=$designation_name; ?></td>
		</tr>
	</tbody>
</table>
	</div>
	<div class="zero"></div>
</div>


<div class="row">
	<div class="col-100">
<table class="tabler" border="2">
	<thead>
		<tr>
			<th><?=lang("Employee_Attendance", "AAR"); ?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><a href="employees_ts_details.php?employee_id=<?=$employee_id; ?>&b=<?=basename($_SERVER['PHP_SELF']); ?>" class="actionBtn" style="text-align:center;margin:0 auto;display:block;"><button type="button" style=""><?=lang("View_Attendance", "AAR"); ?></button></a></td>
		</tr>
	</tbody>
</table>
	</div>
	<div class="zero"></div>
</div>

<div class="row">
	<div class="col-100">
<table class="tabler" border="2">
	<thead>
		<tr>
			<th colspan="6"><?=lang("Employee_Salary_Rates", "AAR"); ?></th>
		</tr>
		<tr>
			<th style="width: 30%;"><?=lang("basic_salary", "AAR"); ?></th>
			<th><?=lang("Daily_Rate", "AAR"); ?></th>
			<th><?=lang("Hour_Rate", "AAR"); ?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?=number_format($basic_salary, 3); ?></td>
			<td><?=number_format($dailyRate, 3); ?></td>
			<td><?=number_format($hourRate, 3); ?></td>
		</tr>
	</tbody>
</table>
	</div>
	<div class="zero"></div>
</div>


<div class="row">
	<div class="col-100">
<table class="tabler" border="2">
	<thead>
		<tr>
			<th colspan="6"><?=lang("Allowances", "AAR"); ?></th>
		</tr>
		<tr>
			<th><?=lang("Sys_Id", "AAR"); ?></th>
			<th style="width:30%;"><?=lang("allowance", "AAR"); ?></th>
			<th><?=lang("Type", "AAR"); ?></th>
			<th><?=lang("amount", "AAR"); ?></th>
			<th><?=lang("date", "AAR"); ?></th>
		</tr>
	</thead>
	<tbody>
<?php

	$qu_hr_employees_allowances_sel = "SELECT * FROM  `hr_employees_allowances` WHERE `employee_id` = '$employee_id'";
	$qu_hr_employees_allowances_EXE = mysqli_query($KONN, $qu_hr_employees_allowances_sel);
	if(mysqli_num_rows($qu_hr_employees_allowances_EXE)){
		while($hr_employees_allowances_REC = mysqli_fetch_assoc($qu_hr_employees_allowances_EXE)){
			
			
			
			
			$record_id = $hr_employees_allowances_REC['record_id'];
			$employee_id = $hr_employees_allowances_REC['employee_id'];
			$allowance_id = $hr_employees_allowances_REC['allowance_id'];
			$allowance_type = $hr_employees_allowances_REC['allowance_type'];
			$allowance_amount = $hr_employees_allowances_REC['allowance_amount'];
			
			$active_from = $hr_employees_allowances_REC['active_from'];
			$active_to = $hr_employees_allowances_REC['active_to'];
			
			
			$allowance_status = get_current_state($KONN, $record_id, "hr_employees_allowances" );


	$qu_hr_employees_allowances_ids_sel = "SELECT * FROM  `hr_employees_allowances_ids` WHERE `allowance_id` = $allowance_id";
	$qu_hr_employees_allowances_ids_EXE = mysqli_query($KONN, $qu_hr_employees_allowances_ids_sel);
	$hr_employees_allowances_ids_DATA;
	if(mysqli_num_rows($qu_hr_employees_allowances_ids_EXE)){
		$hr_employees_allowances_ids_DATA = mysqli_fetch_assoc($qu_hr_employees_allowances_ids_EXE);
	}
	
		$allowance_title = $hr_employees_allowances_ids_DATA['allowance_title'];
		$allowance_description = $hr_employees_allowances_ids_DATA['allowance_description'];
		
		?>
		<tr id="all-<?=$record_id; ?>">
			<td>HRALW-<?=$record_id; ?></td>
			<td><?=$allowance_title; ?></td>
			<td><?=$allowance_type; ?></td>
			<td><?=number_format($allowance_amount, 3); ?></td>
			<td><?=$active_from; ?> - <?=$active_to; ?></td>
		</tr>
		<?php
		
		}
	}
	
?>
	</tbody>
</table>
	</div>
	<div class="zero"></div>
</div>


<div class="row">
	<div class="col-100">
<table class="tabler" border="2">
	<thead>
		<tr>
			<th colspan="6"><?=lang("Leaves", "AAR"); ?></th>
		</tr>
		<tr>
			<th><?=lang("Sys_Id", "AAR"); ?></th>
			<th style="width:30%;"><?=lang("Leave_Type", "AAR"); ?></th>
			<th><?=lang("start_time", "AAR"); ?></th>
			<th><?=lang("end_time", "AAR"); ?></th>
		</tr>
	</thead>
	<tbody>
<?php

	$qu_hr_employees_leaves_sel = "SELECT * FROM  `hr_employees_leaves` WHERE `employee_id` = '$employee_id'";
	$qu_hr_employees_leaves_EXE = mysqli_query($KONN, $qu_hr_employees_leaves_sel);
	if(mysqli_num_rows($qu_hr_employees_leaves_EXE)){
		while($hr_employees_leaves_REC = mysqli_fetch_assoc($qu_hr_employees_leaves_EXE)){
			
			$leave_id = $hr_employees_leaves_REC['leave_id'];
			$employee_id = $hr_employees_leaves_REC['employee_id'];
			$leave_type_id = $hr_employees_leaves_REC['leave_type_id'];
			$start_date = $hr_employees_leaves_REC['start_date'];
			$end_date = $hr_employees_leaves_REC['end_date'];


	$qu_hr_employees_leave_types_sel = "SELECT * FROM  `hr_employees_leave_types` WHERE `leave_type_id` = $leave_type_id";
	$qu_hr_employees_leave_types_EXE = mysqli_query($KONN, $qu_hr_employees_leave_types_sel);
	$hr_employees_leave_types_DATA;
	if(mysqli_num_rows($qu_hr_employees_leave_types_EXE)){
		$hr_employees_leave_types_DATA = mysqli_fetch_assoc($qu_hr_employees_leave_types_EXE);
	}
	
		$leave_type_name = $hr_employees_leave_types_DATA['leave_type_name'];
		
		?>
		<tr id="leave-<?=$leave_id; ?>">
			<td>HRLV-<?=$leave_id; ?></td>
			<td><?=$leave_type_name; ?></td>
			<td><?=$start_date; ?></td>
			<td><?=$end_date; ?></td>
		</tr>
		<?php
		
		}
	}
	
?>
	</tbody>
</table>
	</div>
	<div class="zero"></div>
</div>


<div class="row">
	<div class="col-100">
<table class="tabler" border="2">
	<thead>
		<tr>
			<th colspan="6"><?=lang("Deductions", "AAR"); ?></th>
		</tr>
		<tr>
			<th><?=lang("Sys_Id", "AAR"); ?></th>
			<th style="width:30%;"><?=lang("deduction_amount", "AAR"); ?></th>
			<th><?=lang("Submission_date", "AAR"); ?></th>
			<th><?=lang("Effective_date", "AAR"); ?></th>
		</tr>
	</thead>
	<tbody>
<?php

	$qu_hr_employees_deductions_sel = "SELECT * FROM  `hr_employees_deductions` WHERE `employee_id` = '$employee_id'";
	$qu_hr_employees_deductions_EXE = mysqli_query($KONN, $qu_hr_employees_deductions_sel);
	if(mysqli_num_rows($qu_hr_employees_deductions_EXE)){
		while($hr_employees_deductions_REC = mysqli_fetch_assoc($qu_hr_employees_deductions_EXE)){
			
			$deduction_id = $hr_employees_deductions_REC['deduction_id'];
			$employee_id = $hr_employees_deductions_REC['employee_id'];
			$deduction_date = $hr_employees_deductions_REC['deduction_date'];
			$deduction_effective_date = $hr_employees_deductions_REC['deduction_effective_date'];
			$deduction_amount = $hr_employees_deductions_REC['deduction_amount'];
		
		?>
		<tr id="all-<?=$deduction_id; ?>">
			<td>HRDED-<?=$deduction_id; ?></td>
			<td><?=number_format($deduction_amount, 3); ?></td>
			<td><?=$deduction_date; ?></td>
			<td><?=$deduction_effective_date; ?></td>
		</tr>
		<?php
		
		}
	}
	
?>
	
	</tbody>
</table>
	</div>
	<div class="zero"></div>
</div>



<div class="row">
	<div class="col-100">
<table class="tabler" border="2">
	<thead>
		<tr>
			<th colspan="6"><?=lang("Displanary_Actions", "AAR"); ?></th>
		</tr>
		<tr>
			<th><?=lang("Sys_Id", "AAR"); ?></th>
			<th style="width:30%;"><?=lang("Action", "AAR"); ?></th>
			<th><?=lang("Date", "AAR"); ?></th>
			<th><?=lang("Amount(_Days_)", "AAR"); ?></th>
			<th><?=lang("Amount(_Rate_)", "AAR"); ?></th>
		</tr>
	</thead>
	<tbody>
<?php

	$qu_hr_employees_disp_actions_sel = "SELECT * FROM  `hr_employees_disp_actions` WHERE `employee_id` = '$employee_id'";
	$qu_hr_employees_disp_actions_EXE = mysqli_query($KONN, $qu_hr_employees_disp_actions_sel);
	if(mysqli_num_rows($qu_hr_employees_disp_actions_EXE)){
		while($hr_employees_disp_actions_REC = mysqli_fetch_assoc($qu_hr_employees_disp_actions_EXE)){
			
			$record_id = $hr_employees_disp_actions_REC['record_id'];
			$disp_action_id = $hr_employees_disp_actions_REC['disp_action_id'];
			$created_date = $hr_employees_disp_actions_REC['created_date'];
			$deductions = ( int ) $hr_employees_disp_actions_REC['deductions'];
			

	$qu_hr_disp_actions_sel = "SELECT * FROM  `hr_disp_actions` WHERE `disp_action_id` = $disp_action_id";
	$qu_hr_disp_actions_EXE = mysqli_query($KONN, $qu_hr_disp_actions_sel);
	$hr_disp_actions_DATA;
	if(mysqli_num_rows($qu_hr_disp_actions_EXE)){
		$hr_disp_actions_DATA = mysqli_fetch_assoc($qu_hr_disp_actions_EXE);
	}
		$disp_action_code = $hr_disp_actions_DATA['disp_action_code'];
		$disp_action_text = $hr_disp_actions_DATA['disp_action_text'];

		$thsAmount = $dailyRate * $deductions;
		?>
		<tr id="all-<?=$record_id; ?>">
			<td>HRDA-<?=$record_id; ?></td>
			<td><?=$disp_action_text; ?></td>
			<td><?=$created_date; ?></td>
			<td><?=$deductions; ?></td>
			<td><?=number_format( $thsAmount, 3 ); ?></td>
		</tr>
		<?php
		
		}
	}
	
?>
	</tbody>
</table>
	</div>
	<div class="zero"></div>
</div>
<?php
} else {
?>

<div class="row">
	<div class="col-100">
		<form action="hr_employees_profile.php" id="formerData" method="GET">
			<div class="col-75">
				<div class="nwFormGroup">
					<label><?=lang("Employee:", "AAR"); ?></label>
					<select class="frmData" id="new-employee_id" name="employee_id" required>
				<option value="0" selected disabled>Please Select</option>
				<?php
					$qu_hr_employees_sel = "SELECT `employee_id`, `first_name`, `last_name` FROM  `hr_employees` WHERE ( ( `employee_type` = 'local' ) ) ORDER BY `first_name` ASC, `last_name` ASC";
					$qu_hr_employees_EXE = mysqli_query($KONN, $qu_hr_employees_sel);
					if(mysqli_num_rows($qu_hr_employees_EXE)){
						while($hr_employees_REC = mysqli_fetch_assoc($qu_hr_employees_EXE)){
							$NAMER = $hr_employees_REC['first_name'].' '.$hr_employees_REC['last_name'];
						?>
						<option value="<?=$hr_employees_REC['employee_id']; ?>"><?=$NAMER; ?></option>
						<?php
						}
					}
				?>
					</select>
<script>
$('#new-employee_id').val('<?=$employee_id; ?>');
</script>
				</div>
				<div class="zero"></div>
			</div>
			<div class="col-25">
				<div class="nwFormGroup">
					<button type="submit" style="padding: 1% 5%;"><?=lang("Show_Data", "AAR"); ?></button>
				</div>
				<div class="zero"></div>
			</div>
		</form>
	</div>
</div>




<?php
}
?>

<?php
	//PAGE DATA END   ----------------------------------------------///---------------------------------
	include('app/footer.php');
?>



</body>
</html>
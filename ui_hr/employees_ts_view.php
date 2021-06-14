<?php
function getDayNum( $Dater ){
	$timestamp = strtotime($Dater);
	return date('d', $timestamp);
}
function getDayName( $Dater ){
	$timestamp = strtotime($Dater);
	return date('D', $timestamp);
}

	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "Time Tables";
	$menuId = 8;
	$subPageID = 11;
	

	$ts_id = 0;
	$Sel_day_date = "0";
	
	if( isset( $_GET['ts_id'] ) ){
		$ts_id = ( int ) $_GET['ts_id'];
	} else {
		header("location:employees_ts.php?noTS=1");
	}
	
	if( isset( $_GET['day_date'] ) ){
		$Sel_day_date = $_GET['day_date'];
	}
	
	$qu_hr_employees_ts_sel = "SELECT * FROM  `hr_employees_ts` WHERE `ts_id` = $ts_id";
	$qu_hr_employees_ts_EXE = mysqli_query($KONN, $qu_hr_employees_ts_sel);
	$hr_employees_ts_DATA;
	if(mysqli_num_rows($qu_hr_employees_ts_EXE)){
		$hr_employees_ts_DATA = mysqli_fetch_assoc($qu_hr_employees_ts_EXE);
	} else {
		header("location:employees_ts.php?noTS=1");
	}

		$ts_ref = $hr_employees_ts_DATA['ts_ref'];
		$ts_year = $hr_employees_ts_DATA['ts_year'];
		$ts_month = $hr_employees_ts_DATA['ts_month'];
		
		
		
		
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
		<form action="employees_ts_view.php" id="formerData" method="GET">
			<input type="hidden" name="ts_id" value="<?=$ts_id; ?>">
			<div class=" col-33">
				<div class="nwFormGroup">
					<label><?=lang("Year:", "AAR"); ?></label>
					<select class="frmData" id="new-ts_year" name="ts_year" disabled>
						<option value="<?=$ts_year; ?>"><?=$ts_year; ?></option>
					</select>
				</div>
				<div class="zero"></div>
			</div>
			<div class="col-33">
				<div class="nwFormGroup">
					<label><?=lang("Month:", "AAR"); ?></label>
					<select class="frmData" id="new-ts_month" name="ts_month" disabled>
						<option value="<?=$ts_month; ?>"><?=$ts_month; ?></option>
					</select>
				</div>
				<div class="zero"></div>
			</div>
			<div class="col-33">
				<div class="nwFormGroup">
					<label><?=lang("Day:", "AAR"); ?></label>
					<select class="frmData" id="new-day_date" name="day_date">
						<option value="0" selected disabled>Please Select Day</option>
				<?php
				$init_Day = "";
				$start_day = 1;
				$tot_days  =cal_days_in_month(CAL_GREGORIAN, $ts_month, $ts_year);
				
		for( $D = $start_day ; $D <= $tot_days ; $D++){
						
						$Dview = ''.$D;
						if( $D < 10 ){
							$Dview = '0'.$D;
						}
						$Mview = ''.$ts_month;
						if( $ts_month < 10 ){
							$Mview = '0'.$ts_month;
						}
						$day_date = $ts_year.'-'.$Mview.'-'.$Dview;
						$day_dateView = $Dview.'-'.$Mview.'-'.$ts_year;
						if( $D == 1 ){
							$init_Day = $day_date;
						}
				?>
						<option value="<?=$day_date; ?>"><?=$day_dateView; ?></option>
				<?php
		}
	
				?>
					</select>
				</div>
				<div class="zero"></div>
			</div>
		
			<div class="zero"></div>
				<hr>
				<br>
<script>
$('#new-day_date').val('<?=$Sel_day_date; ?>');
</script>


<div class="col-100" style="width:100%;">
			<br><br>
			<table class="tabler" style="width:100%;" border="1">
				<thead>
					<tr>
						<th colspan="2">&nbsp;</th>
						<th colspan="2" style="width:40%;"><?=lang('Employee'); ?></th>
						<th colspan="2" style="width:40%;"><?=lang('Duty'); ?></th>
					</tr>
					<tr>
						<th colspan="2"><?=lang('No.'); ?></th>
						<th><?=lang('ID'); ?></th>
						<th><?=lang('Name'); ?></th>
						<th><?=lang('Duty_From'); ?></th>
						<th><?=lang('Duty_To'); ?></th>
					</tr>
				</thead>
				<tbody>
				
<?php
	$qu_hr_employees_ts_days_sel = "SELECT * FROM  `hr_employees_ts_days` WHERE ((`day_date` = '$Sel_day_date') AND (`ts_id` = $ts_id))";
	$qu_hr_employees_ts_days_EXE = mysqli_query($KONN, $qu_hr_employees_ts_days_sel);
	if(mysqli_num_rows($qu_hr_employees_ts_days_EXE)){
		$CC = 0;
		while($hr_employees_ts_days_REC = mysqli_fetch_assoc($qu_hr_employees_ts_days_EXE)){
			$CC++;
			$day_id = $hr_employees_ts_days_REC['day_id'];
			$day_date = $hr_employees_ts_days_REC['day_date'];
			$time_in = $hr_employees_ts_days_REC['time_in'];
			$time_out = $hr_employees_ts_days_REC['time_out'];
			$employee_id = $hr_employees_ts_days_REC['employee_id'];
			
			$toARR = explode(":", $time_out);
			$tOut  = $toARR[0].":".$toARR[1];
			
			$inARR = explode(":", $time_in);
			$tIn   = $inARR[0].":".$inARR[1];
			
	$qu_hr_employees_sel = "SELECT `employee_code`, `first_name`, `last_name` FROM  `hr_employees` WHERE `employee_id` = $employee_id";
	$qu_hr_employees_EXE = mysqli_query($KONN, $qu_hr_employees_sel);
	$employee_code = "";
	$NAMER = "";
	if(mysqli_num_rows($qu_hr_employees_EXE)){
		$hr_employees_DATA = mysqli_fetch_assoc($qu_hr_employees_EXE);
		$employee_code = $hr_employees_DATA['employee_code'];
		$NAMER = $hr_employees_DATA['first_name']." ".$hr_employees_DATA['last_name'];
	}

			
?>
<tr class="ts_record" id="rec-<?=$CC; ?>" ids="<?=$CC; ?>"  night="1">
	<td title="Delete This Record" style="text-align: center;" onclick="delRec(<?=$CC; ?>);"><i class="fas fa-trash"></i></td>
	<td style="text-align: center;" class="serialNo" ><?=$CC; ?></td>
	<td>
		<input class="frmData employee_code" list="employee_codes" ids="<?=$CC; ?>" 
				id="new-employee_code<?=$CC; ?>" 
				name="employee_codes[]" 
				value="<?=$employee_code; ?>" 
				type="text"
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_employee_code", "AAR"); ?>" style="width:100%;">
	</td>
	<td>
		<input class="frmData employee_id" ids="<?=$CC; ?>" 
				id="new-employee_id<?=$CC; ?>" 
				name="employee_ids[]" 
				value="<?=$employee_id; ?>" 
				type="hidden"
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_employee_code", "AAR"); ?>">
		<input class="frmData day_ids" ids="<?=$CC; ?>" 
				id="new-day_ids<?=$CC; ?>" 
				name="day_ids[]" 
				value="<?=$day_id; ?>" 
				type="hidden"
				value="0"
				req="1" 
				den="" 
				alerter="<?=lang("Please_day_ids", "AAR"); ?>">
		<input class="employee_name" value="<?=$NAMER; ?>"  id="new-employee_name<?=$CC; ?>" type="text" disabled style="width:100%;">
	</td>
	<td style="text-align: center;">
		<input class="frmData date_from has_date" ids="<?=$CC; ?>" 
				id="new-date_from<?=$CC; ?>" 
				name="date_froms[]" 
				type="text"
				value="<?=$day_date; ?>"
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_date_from", "AAR"); ?>" disabled>
		<input class="frmData time_from has_time" ids="<?=$CC; ?>" 
				id="new-time_from<?=$CC; ?>" 
				name="time_froms[]" 
				type="text"
				value="<?=$tIn; ?>" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_time_from", "AAR"); ?>">
	</td>
	<td style="text-align: center;">
		<input class="frmData date_to has_date" ids="<?=$CC; ?>" 
				id="new-date_to<?=$CC; ?>" 
				name="date_tos[]" 
				type="text"
				value="<?=$day_date; ?>"
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_date_from", "AAR"); ?>" disabled>
		<input class="frmData time_to has_time" ids="<?=$CC; ?>" 
				id="new-time_to<?=$CC; ?>" 
				name="time_tos[]" 
				value="<?=$tOut; ?>" 
				type="text"
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_time_from", "AAR"); ?>">
	</td>
					</tr>
<?php
		}
	}
?>
				</tbody>
			</table>
			<br><br>

</div>

		
			<div class="zero"></div>
				<hr>
				<br>


<div class="viewerBodyButtons">
		<a href="employees_ts.php"><button type="button">
			<?=lang('Back', 'ARR', 1); ?>
		</button></a>
</div>
			
		</form>
	</div>
	<div class="zero"></div>
</div>

<script>
	$('#new-day_date').on( 'change', function(){
		$('#formerData').submit();
	} );
</script>







<?php
	//PAGE DATA END   ----------------------------------------------///---------------------------------
	include('app/footer.php');
?>



<datalist id="employee_codes" style="display:none;">
<?php
	$qu_hr_employees_sel = "SELECT `employee_id`, `employee_code`, `first_name`, `last_name` FROM  `hr_employees`";
	$qu_hr_employees_EXE = mysqli_query($KONN, $qu_hr_employees_sel);
	if(mysqli_num_rows($qu_hr_employees_EXE)){
		while($hr_employees_REC = mysqli_fetch_assoc($qu_hr_employees_EXE)){
		$employee_id = $hr_employees_REC['employee_id'];
		$employee_code = trim( $hr_employees_REC['employee_code'] );
		$namer = $hr_employees_REC['first_name'].' '.$hr_employees_REC['last_name'];
		?>
		<dt id="code-<?=$employee_code; ?>" style="display:none;"><?=$namer; ?></dt>
		<option><?=$employee_code; ?></option>
		<?php
		}
	}

?>
</datalist>

<div id="employee_ids" style="display:none;">
<?php
	$qu_hr_employees_sel = "SELECT `employee_id`, `employee_code`, `first_name`, `last_name` FROM  `hr_employees`";
	$qu_hr_employees_EXE = mysqli_query($KONN, $qu_hr_employees_sel);
	if(mysqli_num_rows($qu_hr_employees_EXE)){
		while($hr_employees_REC = mysqli_fetch_assoc($qu_hr_employees_EXE)){
		$employee_id = $hr_employees_REC['employee_id'];
		$employee_code = trim( $hr_employees_REC['employee_code'] );
		$namer = $hr_employees_REC['first_name'].' '.$hr_employees_REC['last_name'];
		?>
		<div id="emp-<?=$employee_code; ?>" style="display:none;"><?=$employee_id; ?></div>
		<?php
		}
	}

?>
</div>








</body>
</html>
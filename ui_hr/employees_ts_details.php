<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "Time Tables";
	$menuId = 9;
	$subPageID = 15;
	
	
function getDayNum( $Dater ){
	$timestamp = strtotime($Dater);
	return date('d', $timestamp);
}
function getDayName( $Dater ){
	$timestamp = strtotime($Dater);
	return date('D', $timestamp);
}

	
	$backer = "";
	if( isset( $_GET['b'] ) ){
		$backer = test_inputs( $_GET['b'] );
	}
	
	

	$employee_id = 0;
	$Sel_day_date = "0";
	
	if( isset( $_GET['employee_id'] ) ){
		$employee_id = ( int ) $_GET['employee_id'];
	}
	
	
	
	
	if( isset( $_GET['day_date'] ) ){
		$Sel_day_date = $_GET['day_date'];
	}
	
	
	
	$qu_hr_employees_sel = "SELECT `first_name`, `last_name` FROM  `hr_employees` WHERE `employee_id` = $employee_id";
	$qu_hr_employees_EXE = mysqli_query($KONN, $qu_hr_employees_sel);
	$namer = "";
	if(mysqli_num_rows($qu_hr_employees_EXE)){
		$hr_employees_DATA = mysqli_fetch_assoc($qu_hr_employees_EXE);
		$namer = $hr_employees_DATA['first_name'].' '.$hr_employees_DATA['last_name'];
	}

	
	$ts_year = "";
	if( isset( $_GET['ts_year'] ) ){
		$ts_year = $_GET['ts_year'];
	} else {
		$ts_year = date('Y');
	}
	$ts_month = "";
	if( isset( $_GET['ts_month'] ) ){
		$ts_month = $_GET['ts_month'];
	} else {
		$ts_month = date('n');
		if( $ts_month != 1 ){
			$ts_month = $ts_month - 1;
		}
		
	}
	$qu_hr_employees_ts_sel = "SELECT * FROM  `hr_employees_ts` WHERE ((`ts_year` = '$ts_year') AND (`ts_month` = '$ts_month'))";
	$qu_hr_employees_ts_EXE = mysqli_query($KONN, $qu_hr_employees_ts_sel);
	$ts_id = 0;
	$ts_ref = "";
	if(mysqli_num_rows($qu_hr_employees_ts_EXE)){
		$hr_employees_ts_DATA = mysqli_fetch_assoc($qu_hr_employees_ts_EXE);
		$ts_id = ( int ) $hr_employees_ts_DATA['ts_id'];
		$ts_ref = $hr_employees_ts_DATA['ts_ref'];
		$ts_year = $hr_employees_ts_DATA['ts_year'];
		$ts_month = $hr_employees_ts_DATA['ts_month'];
	}
	
	
		
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
		<form action="employees_ts_details.php" id="formerData" method="GET">
					<input type="hidden" name="b" value="<?=$backer; ?>">
			<div class="col-25">
				<div class="nwFormGroup">
					<label><?=lang("Employee:", "AAR"); ?></label>
					<select class="frmData" id="new-employee_id" name="employee_id">
				<option value="0" selected>--- All ---</option>
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
			<div class=" col-25">
				<div class="nwFormGroup">
					<label><?=lang("Year:", "AAR"); ?></label>
					<select class="frmData" id="new-ts_year" name="ts_year">
						<option value="<?=$ts_year; ?>"><?=$ts_year; ?></option>
					</select>
				</div>
				<div class="zero"></div>
			</div>
			<div class="col-25">
				<div class="nwFormGroup">
					<label><?=lang("Month:", "AAR"); ?></label>
					<select class="frmData" id="new-ts_month" name="ts_month">
<?php
	for( $m=1; $m<=12; $m++ ){
		$mV = ''.$m;
		if( $m < 10 ){
			$mV = '0'.$m;
		}
?>
						<option value="<?=$m; ?>"><?=$mV; ?></option>
<?php
	}
?>
					</select>
				</div>
				<div class="zero"></div>
			</div>
<script>
$('#new-ts_month').val('<?=$ts_month; ?>');
</script>
			<div class="col-25">
				<div class="nwFormGroup">
					<button type="submit" style="padding: 1% 5%;"><?=lang("Show_Data", "AAR"); ?></button>
				</div>
				<div class="zero"></div>
			</div>
		
			<div class="zero"></div>
				<hr>
				<br>


<div class="col-100" style="width:100%;">
			<br><br>
			<table class="tabler" style="width:100%;" border="1">
				<thead>
					<tr>
						<th><?=lang('NO.'); ?></th>
						<th><?=lang('Code'); ?></th>
						<th><?=lang('Name'); ?></th>
						<th><?=lang('Day'); ?></th>
						<th><?=lang('Date'); ?></th>
						<th><?=lang('Check_In'); ?></th>
						<th><?=lang('Check_Out'); ?></th>
<?php
	if( $employee_id != 0 ){
?>
						<th><?=lang('Delay - Minutes'); ?></th>
<?php
	}
?>
					</tr>
				</thead>
				<tbody>
				
<?php
$totDelay = 0;

if( $ts_id != 0 ){
	
	$empCond = "";
	$limCond = "";
	if( $employee_id != 0 ){
		$empCond = " AND (`employee_id` = $employee_id)";
		$limCond = "";
	} else {
		$limCond = " LIMIT 25";
	}
	
	$qu_hr_employees_ts_days_sel = "SELECT * FROM  `hr_employees_ts_days` WHERE ( (`ts_id` = $ts_id) $empCond ) ORDER BY `day_date` ASC $limCond";
	
	
	
	
	
	
	$qu_hr_employees_ts_days_EXE = mysqli_query($KONN, $qu_hr_employees_ts_days_sel);
	if(mysqli_num_rows($qu_hr_employees_ts_days_EXE)){
		$CC = 0;
		$totDelay = 0;
		while($hr_employees_ts_days_REC = mysqli_fetch_assoc($qu_hr_employees_ts_days_EXE)){
			$CC++;
			
			
			
			$day_id        = $hr_employees_ts_days_REC['day_id'];
			$day_date      = $hr_employees_ts_days_REC['day_date'];
			$time_in       = $hr_employees_ts_days_REC['time_in'];
			$time_out      = $hr_employees_ts_days_REC['time_out'];
			$employee_idT  = $hr_employees_ts_days_REC['employee_id'];
			$dayName       = date('l', strtotime($day_date));
			
			$toARR = explode(":", $time_out);
			$tOut  = $toARR[0].":".$toARR[1];
			$inARR = explode(":", $time_in);
			$tIn   = $inARR[0].":".$inARR[1];
			
			
			
			$datetime1 = strtotime($day_date.' 07:30:00');
			$datetime2 = strtotime($day_date.' '.$tIn);
			$interval  = abs($datetime2 - $datetime1);
			$minutes   = round($interval / 60);
			$delay     = $minutes;
			$totDelay  = $totDelay + $delay;
			
			
	$qu_hr_employees_sel = "SELECT `employee_code`, `first_name`, `last_name` FROM  `hr_employees` WHERE `employee_id` = $employee_idT";
	$qu_hr_employees_EXE = mysqli_query($KONN, $qu_hr_employees_sel);
	$employee_codeT = "NA";
	$Namer = "NA";
	if(mysqli_num_rows($qu_hr_employees_EXE)){
		$hr_employees_DATA = mysqli_fetch_assoc($qu_hr_employees_EXE);
		$employee_codeT = $hr_employees_DATA['employee_code'];
		$Namer          = $hr_employees_DATA['first_name'].' '.$hr_employees_DATA['last_name'];
	}

?>
<tr class="ts_record" id="rec-<?=$CC; ?>" ids="<?=$CC; ?>"  night="1">
	<td style="text-align: center;" class="serialNo" ><?=$CC; ?></td>
	<td style="text-align: center;"><?=$employee_codeT; ?></td>
	<td style="text-align: center;"><?=$Namer; ?></td>
	<td style="text-align: center;"><?=$dayName; ?></td>
	<td style="text-align: center;"><?=$day_date; ?></td>
	<td style="text-align: center;"><?=$tIn; ?></td>
	<td style="text-align: center;"><?=$tOut; ?></td>
<?php
	if( $employee_id != 0 ){
?>
	<td style="text-align: center;"><?=$delay; ?></td>
<?php
	}
?>
</tr>
<?php
		}
	}
}



	if( $employee_id != 0 ){
$hours = intval($totDelay/60);
$minutes = $totDelay - ($hours * 60);
?>
<tr class="ts_record" id="rec-0" ids="0"  night="1">
	<td colspan="6" style="text-align: right;" >Total Delay :</td>
	<td colspan="2" style="text-align: center;"><?='('.$hours.') Hour AND ('.$minutes.') Minutes'; ?></td>
</tr>
<?php
	}
?>
				</tbody>
			</table>
			<br><br>

</div>

		
			<div class="zero"></div>
				<hr>
				<br>


<?php
	if( $employee_id != 0 ){
?>
<div class="viewerBodyButtons">
		<a href="employees_ts_details_print.php?employee_id=<?=$employee_id; ?>&ts_id=<?=$ts_id; ?>" target="_blank"><button type="button">
			<?=lang('Print', 'ARR', 1); ?>
		</button></a>
</div>
<?php
	}
?>
			
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
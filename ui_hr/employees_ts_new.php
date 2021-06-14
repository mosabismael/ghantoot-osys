<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "Time Tables";
	$menuId = 8;
	$subPageID = 11;
	
	
if( isset($_POST['ts_year']) && isset($_POST['ts_month']) ){

	$ts_id = 0;
	$ts_ref = "";
	$ts_year = ( int ) test_inputs($_POST['ts_year']);
	$ts_month = ( int ) test_inputs($_POST['ts_month']);
	$created_date = date('Y-m-d H:i:00');
	$created_by = $EMPLOYEE_ID;
	$ts_status = 'draft';
	
	//calc ref
	$qu_hr_employees_ts_sel = "SELECT COUNT(`ts_id`) FROM  `hr_employees_ts` WHERE ( (`ts_year` = '$ts_year') AND (`ts_month` = '$ts_month') )";
	$qu_hr_employees_ts_EXE = mysqli_query($KONN, $qu_hr_employees_ts_sel);
	$tot_count_DB = 0;
	$tot_count_DB_res = "";
	if(mysqli_num_rows($qu_hr_employees_ts_EXE)){
		$hr_employees_ts_DATA = mysqli_fetch_array($qu_hr_employees_ts_EXE);
		$tot_count_DB = ( int ) $hr_employees_ts_DATA[0];
	}

	$nwNO = $tot_count_DB + 1;
	
		if($nwNO < 10){
			$tot_count_DB_res = '000'.$nwNO;
		} else if( $nwNO >= 10 && $nwNO < 100 ){
			$tot_count_DB_res = '00'.$nwNO;
		} else if( $nwNO >= 100 && $nwNO < 1000 ){
			$tot_count_DB_res = '0'.$nwNO;
		} else {
			$tot_count_DB_res = ''.$nwNO;
		}
		
		$M_v = ''.$ts_month;
		if( $ts_month < 10 ){
			$M_v = '0'.$ts_month;
		}
						
	$ts_ref = "ETS-".$ts_year.''.$M_v.''.$tot_count_DB_res;
	
	
	$qu_hr_employees_ts_sel = "SELECT `ts_id` FROM  `hr_employees_ts` WHERE ( (`ts_year` = '$ts_year') AND (`ts_month` = '$ts_month') )";
	$qu_hr_employees_ts_EXE = mysqli_query($KONN, $qu_hr_employees_ts_sel);
	if(mysqli_num_rows($qu_hr_employees_ts_EXE)){
		$hr_employees_ts_DATA = mysqli_fetch_assoc($qu_hr_employees_ts_EXE);
		$ts_id = $hr_employees_ts_DATA['ts_id'];
		header("location:employees_ts_new_01.php?ts_id=".$ts_id);
		die();
	}
	
	
	
	
	$qu_hr_employees_ts_ins = "INSERT INTO `hr_employees_ts` (
						`ts_ref`, 
						`ts_year`, 
						`ts_month`, 
						`created_date`, 
						`created_by`, 
						`ts_status` 
					) VALUES (
						'".$ts_ref."', 
						'".$ts_year."', 
						'".$ts_month."', 
						'".$created_date."', 
						'".$created_by."', 
						'".$ts_status."' 
					);";

	if(mysqli_query($KONN, $qu_hr_employees_ts_ins)){
		$ts_id = mysqli_insert_id($KONN);
		if( $ts_id != 0 ){
			
			

		//insert state change
			if( insert_state_change($KONN, $ts_status, $ts_id, "hr_employees_ts", $EMPLOYEE_ID) ) {
				
				/*
				//insert days for timesheet
				$start_day = 1;
				$tot_days  =cal_days_in_month(CAL_GREGORIAN, $ts_month, $ts_year);
				
				for( $D = $start_day ; $D <= $tot_days ; $D++){
					$day_date = $ts_year.'-'.$ts_month.'-'.$D;
						
						
					$qu_hr_employees_ts_days_ins = "INSERT INTO `hr_employees_ts_days` (
										`day_date`,
										`ts_id` 
									) VALUES (
										'".$day_date."',
										'".$ts_id."' 
									);";


					if( !mysqli_query($KONN, $qu_hr_employees_ts_days_ins)){
						die("ERR-".mysqli_error( $KONN ));
					}
				}
				*/
				header("location:employees_ts_new_01.php?ts_id=".$ts_id);
				
			} else {
				die('0|Data Status Error 65154');
			}
			
			
			
			
			
			
			
			
			
		}
	}

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
		<form action="employees_ts_new.php" method="POST">
		
			<div class="row col-100">
				<div class="nwFormGroup">
					<label><?=lang("Select_Year:", "AAR"); ?></label>
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
				</div>
				<div class="zero"></div>
			</div>
<script>
$('#new-ts_year').val("<?=date('Y'); ?>");
</script>
			<div class="row col-100">
				<div class="nwFormGroup">
					<label><?=lang("Select_Month:", "AAR"); ?></label>
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
				</div>
				<div class="zero"></div>
			</div>
<script>
$('#new-ts_month').val("<?=date('m'); ?>");
</script>

		
			<div class="zero"></div>
				


<div class="viewerBodyButtons">
		<a href="employees_ts.php"><button type="button">
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
<script>

</script>
</body>
</html>
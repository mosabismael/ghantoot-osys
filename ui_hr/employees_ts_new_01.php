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
	$page_title=$page_description=$page_keywords=$page_author= "Select Day";
	
	$menuId = 8;
	$subPageID = 11;
	
	
	$ts_id = 0;
	
	if( isset( $_GET['ts_id'] ) ){
		$ts_id = ( int ) $_GET['ts_id'];
	} else {
		header("location:employees_ts.php?noTS=1");
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
		<form action="employees_ts_new_02.php" id="getDayData" method="GET">
			<input type="hidden" name="ts_id" value="<?=$ts_id; ?>">
			<div class=" col-25">
				<div class="nwFormGroup">
					<label><?=lang("Year:", "AAR"); ?></label>
					<select class="frmData" id="new-ts_year" name="ts_year" disabled>
						<option value="<?=$ts_year; ?>"><?=$ts_year; ?></option>
					</select>
				</div>
				<div class="zero"></div>
			</div>
			<div class="col-25">
				<div class="nwFormGroup">
					<label><?=lang("Month:", "AAR"); ?></label>
					<select class="frmData" id="new-ts_month" name="ts_month" disabled>
						<option value="<?=$ts_month; ?>"><?=$ts_month; ?></option>
					</select>
				</div>
				<div class="zero"></div>
			</div>
			
			<div class="col-25">
				<div class="nwFormGroup">
					<label><?=lang("Day:", "AAR"); ?></label>
					<select class="frmData" id="new-day_date" name="day_date">
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
<script>
	$('#new-day_id').val(<?=$init_Day; ?>);
</script>
				</div>
				<div class="zero"></div>
			</div>
			
			<div class="zero"></div>
				<hr>
				<br>


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

<script>




function calculateADD(time1, time2) {
     time1 = time1.split(':');
	 time2 = time2.split(':');
     var hours1 = parseInt(time1[0], 10);
	 var hours2 = parseInt(time2[0], 10);
	 var mins1 = parseInt(time1[1], 10);
	 var mins2 = parseInt(time2[1], 10);
     var hours = hours2 + hours1;
	 var mins = 0;

     // get hours
     if(hours < 0) {
		 hours = 24 + hours;
	 }

     // get minutes
     var minsTot = mins2 + mins1;

     // convert to fraction of 60
     mins = minsTot % 60;
		
		if( mins >= 60 ){
			hours++;
		}
     // hours += mins;
     // hours = hours.toFixed(2);
     return hours + ':' + mins;
 }
		
function calcTimeDiff(){
	$('.days').each( function(){
      var t1 = "00:00";
      var mins = 0;
      var hrs = 0;
	  
		var thsDate = $(this).val();
		// console.log( thsDate );
		
		var timeIN  = $('#time_in-' + thsDate).val();
		var timeOut = $('#time_out-' + thsDate).val();
		var timeOT  = $('#ot_total-' + thsDate).val();
		
		
		
		var strt = new Date(thsDate + " " + timeIN);
		var end = new Date(thsDate + " " + timeOut);
		
		var rt_total = calcTime( strt, end );
		
		var day_total = calculateADD(rt_total, timeOT);
			
		$('#rt_total-' + thsDate).val( rt_total );
		$('#day_total-' + thsDate).val( day_total );
		
		
	} );
	
}





function calcTime( dtStart, dtEnd ){
    // var dtStart = new Date("7/20/2015 " + t1);
    // var dtEnd = new Date("7/20/2015 " + t2);
	
	 var diff;
	 
	if( dtEnd > dtStart ){
		diff = (dtEnd - dtStart) / 1000;
	} else {
		diff = (dtStart - dtEnd) / 1000;
	}

	var totalTime = 0;

	if (diff > 60*60*12) {
		totalTime = formatDate(60*60*12);
	} else {
		totalTime = formatDate(diff);
	}
	
    return totalTime;
}


function formatDate(diff) {
	var hours = parseInt(diff / 3600) % 24;
	var minutes = parseInt(diff / 60) % 60;
	var seconds = diff % 60;

	return (hours < 10 ? "0" + hours : hours) + ":" + (minutes < 10 ? "0" + minutes : minutes);
}








$('.time_in').on( 'focusout', function(){
	calcTimeDiff();
} );

$('.time_out').on( 'focusout', function(){
	calcTimeDiff();
} );

$('.ot_total').on( 'focusout', function(){
	calcTimeDiff();
} );

$('#new-day_id').on( 'change', function(){
	$('#getDayData').submit();
} );




calcTimeDiff();


</script>




<?php
	//PAGE DATA END   ----------------------------------------------///---------------------------------
	include('app/footer.php');
?>
<script>

</script>
</body>
</html>
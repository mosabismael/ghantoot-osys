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
	
if( isset($_POST['ts_id']) && 
	isset($_POST['day_date']) && 
	isset($_POST['day_ids']) && 
	isset($_POST['employee_ids']) && 
	isset($_POST['time_froms']) && 
	isset($_POST['time_tos'])  
	){
		
		
	$day_id = 0;
	
	$day_date     = test_inputs( $_POST['day_date'] );
	$day_ids      = $_POST['day_ids'];
	$time_froms   = $_POST['time_froms'];
	$time_tos     = $_POST['time_tos'];
	$employee_ids = $_POST['employee_ids'];
	
	
	$ts_id = ( int ) test_inputs($_POST['ts_id']);

		
$qu_hr_employees_ts_days_updt = "";

	for( $E = 0 ; $E < count( $employee_ids ) ; $E++ ){
		
		$day_id = 0;
		$employee_id = ( int ) test_inputs( $employee_ids[$E] );
		$time_in     = test_inputs( $time_froms[$E] );
		$time_out    = test_inputs( $time_tos[$E] );
		$day_id      = ( int ) test_inputs( $day_ids[$E] );
		
		if( $employee_id != 0 ){
    		if( $day_id == 0 ){
    			//INSERT
    			$qu_hr_employees_ts_days_updt = "INSERT INTO `hr_employees_ts_days` (
    								`day_date`, 
    								`time_in`, 
    								`time_out`, 
    								`ts_id`, 
    								`employee_id` 
    							) VALUES (
    								'".$day_date."', 
    								'".$time_in."', 
    								'".$time_out."', 
    								'".$ts_id."', 
    								'".$employee_id."' 
    							);";
    		} else {
    			//UPDATE
    	$qu_hr_employees_ts_days_updt = "UPDATE  `hr_employees_ts_days` SET  
    						`time_in` = '".$time_in."', 
    						`time_out` = '".$time_out."', 
    						`employee_id` = '".$employee_id."'
    						WHERE `day_id` = $day_id;";
    		}


       
    		if( !mysqli_query($KONN, $qu_hr_employees_ts_days_updt)){
    			die("ERR-".mysqli_error( $KONN ));
    		}
        }
		
		
		
	}
	
	$current_state_id = get_current_state_id($KONN, $ts_id, 'hr_employees_ts' );
	if( $current_state_id != 0 ){
		if( insert_state_change_dep($KONN, "days-modified", $ts_id, "TS-Edit", 'hr_employees_ts', $EMPLOYEE_ID, $current_state_id) ){
			
			header("location:employees_ts.php?active=1");
			die();
			
		} else {
			die( 'comErr'.mysqli_error( $KONN ) );
		}
	} else {
		die('0|Component State Error 02');
	}
		
	
	
	
	
		

}




	$ts_id = 0;
	$day_date = "";
	
	if( isset( $_GET['ts_id'] ) ){
		$ts_id = ( int ) $_GET['ts_id'];
	} else {
		header("location:employees_ts.php?noTS=1");
	}
	
	if( isset( $_GET['day_date'] ) ){
		$day_date = $_GET['day_date'];
	} else {
		header("location:employees_ts.php?noDD=1");
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
		<form action="employees_ts_new_02.php" method="POST">
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
						<option value="<?=$day_date; ?>"><?=$day_date; ?></option>
					</select>
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
	$qu_hr_employees_ts_days_sel = "SELECT * FROM  `hr_employees_ts_days` WHERE ((`day_date` = '$day_date') AND (`ts_id` = $ts_id))";
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
					
					<tr id="addedPoint">
						<td colspan="10" style="text-align: center;">
<button class="btn btn-primary" title="New Record" type="button" onclick="addRec();"><i class="fas fa-plus-square"></i></button>
						
						</td>
					</tr>
				
				
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
		<button type="submit">
			<?=lang('Save', 'ARR', 1); ?>
		</button>
</div>
			
		</form>
	</div>
	<div class="zero"></div>
</div>

<script>
totRecs = 1500;

function delRec(recID){
	$('#rec-' + recID ).remove();
	fixTableNumbering();
}

function makeNight( rec ){
	var isNight = parseInt( $('#rec-' + rec ).attr('night') );
	if( isNight == 0 ){
		$('#rec-' + rec + ' .time_from').val('19:00');
		$('#rec-' + rec + ' .time_to').val('04:00');
		$('#rec-' + rec ).attr('night', '1');
		MakeNightDate( rec );
		$('#shiftBtn-' + rec).addClass( 'fa-moon' );
		$('#shiftBtn-' + rec).removeClass( 'fa-sun' );
		
	} else {
		$('#rec-' + rec + ' .time_from').val('07:30');
		$('#rec-' + rec + ' .time_to').val('16:30');
		$('#rec-' + rec ).attr('night', '0');
		addDateToRec( rec );
		$('#shiftBtn-' + rec).addClass( 'fa-sun' );
		$('#shiftBtn-' + rec).removeClass( 'fa-moon' );
	}
		calcTimeDiff();
}


function addDateToRec( REC ) {
	var ts_date = $('#new-day_date').val();
	var dd = new Date( ts_date );
	dd.setDate( dd.getDate() + 1 );
	$('#rec-' + REC + ' .date_from').val( ts_date );
	$('#rec-' + REC + ' .date_to').val( ts_date );
	
}

function MakeNightDate( REC ) {
	var ts_date = $('#new-day_date').val();
	var dd = new Date( ts_date );
	dd.setDate( dd.getDate() + 1 );
	$('#rec-' + REC + ' .date_from').val( ts_date );
	
	var mm = parseInt( dd.getMonth() );
	mm = mm + 1;
	var thsM = "";
	if( mm < 10 ){
		thsM = "0" + mm;
	} else {
		thsM = mm;
	}
	
	var DD = parseInt( dd.getDate() );
	var thsD = "";
	if( DD < 10 ){
		thsD = "0" + DD;
	} else {
		thsD = DD;
	}
	
	$('#rec-' + REC + ' .date_to').val( dd.getFullYear() + "-" + thsM + "-" + thsD );
	
}


function addRec(){
	addTsRec();
}

function addTsRec(){

	totRecs++;
	
	var tr = 		'<tr class="ts_record" id="rec-' + totRecs + '" ids="' + totRecs + '"  night="1">' + 
					'	<td title="Delete This Record" style="text-align: center;" onclick="delRec(' + totRecs + ');"><i class="fas fa-trash"></i></td>' + 
					'	<td style="text-align: center;" class="serialNo" >' + totRecs + '</td>' + 
					'	<td>' + 
					'		<input class="frmData employee_code" list="employee_codes" ids="' + totRecs + '" ' + 
					'				id="new-employee_code' + totRecs + '" ' + 
					'				name="employee_codes[]" ' + 
					'				type="text"' + 
					'				req="1" ' + 
					'				den="" ' + 
					'				alerter="<?=lang("Please_Check_employee_code", "AAR"); ?>" style="width:100%;">' + 
					'	</td>' + 
					'	<td>' + 
					'		<input class="frmData employee_id" ids="' + totRecs + '" ' + 
					'				id="new-employee_id' + totRecs + '" ' + 
					'				name="employee_ids[]" ' + 
					'				type="hidden"' + 
					'				req="1" ' + 
					'				den="" ' + 
					'				alerter="<?=lang("Please_Check_employee_code", "AAR"); ?>">' + 
					'		<input class="frmData day_ids" ids="' + totRecs + '" ' + 
					'				id="new-day_ids' + totRecs + '" ' + 
					'				name="day_ids[]" ' + 
					'				type="hidden"' + 
					'				value="0"' + 
					'				req="1" ' + 
					'				den="" ' + 
					'				alerter="<?=lang("Please_day_ids", "AAR"); ?>">' + 
					'		<input class="employee_name" id="new-employee_name' + totRecs + '" type="text" disabled style="width:100%;">' + 
					'	</td>' + 
					'	<td style="text-align: center;">' + 
					'		<input class="frmData date_from has_date" ids="' + totRecs + '" ' + 
					'				id="new-date_from' + totRecs + '" ' + 
					'				name="date_froms[]" ' + 
					'				type="text"' + 
					'				value="<?=$day_date; ?>"' + 
					'				req="1" ' + 
					'				den="" ' + 
					'				alerter="<?=lang("Please_Check_date_from", "AAR"); ?>" disabled>' + 
					'		<input class="frmData time_from has_time" ids="' + totRecs + '" ' + 
					'				id="new-time_from' + totRecs + '" ' + 
					'				name="time_froms[]" ' + 
					'				type="text"' + 
					'				req="1" ' + 
					'				den="" ' + 
					'				alerter="<?=lang("Please_Check_time_from", "AAR"); ?>">' + 
					'	</td>' + 
					'	<td style="text-align: center;">' + 
					'		<input class="frmData date_to has_date" ids="' + totRecs + '" ' + 
					'				id="new-date_to' + totRecs + '" ' + 
					'				name="date_tos[]" ' + 
					'				type="text"' + 
					'				value="<?=$day_date; ?>"' + 
					'				req="1" ' + 
					'				den="" ' + 
					'				alerter="<?=lang("Please_Check_date_from", "AAR"); ?>" disabled>' + 
					'		<input class="frmData time_to has_time" ids="' + totRecs + '" ' + 
					'				id="new-time_to' + totRecs + '" ' + 
					'				name="time_tos[]" ' + 
					'				type="text"' + 
					'				req="1" ' + 
					'				den="" ' + 
					'				alerter="<?=lang("Please_Check_time_from", "AAR"); ?>">' + 
					'	</td>' + 
					'</tr>';
	$('#addedPoint').before(tr);
	fixTableNumbering();
	initTableEvents();
	do_time_picker();
	do_date_picker();
	makeNight( totRecs );
	addDateToRec( totRecs );
	calcTimeDiff();
}


function msToTime(s) {
  var ms = s % 1000;
  s = (s - ms) / 1000;
  var secs = s % 60;
  s = (s - secs) / 60;
  var mins = s % 60;
  var hrs = (s - mins) / 60;

  return hrs;
}

var getDayTimeDiff = function(date1, date2) {
	
  // var date1 = new Date(start);
  // var date2 = new Date(end);
  var dd  =  date2.getTime() - date1.getTime();
  return msToTime( dd );
}


function calcTimeDiff(){
	$('.ts_record').each( function(){
		
		
		
		var ts_date = $('#new-day_date').val();
		$('#rec-' + thsREC + ' .date_from').val( ts_date );
		
		//if night
		
		$('#rec-' + thsREC + ' .date_to').val();
		
		
		
		
		var thsREC = $(this).attr('ids');
		
		var Tstart = $('#rec-' + thsREC + ' .time_from').val();
		var Tend   = $('#rec-' + thsREC + ' .time_to').val();
		
		var Dstart = $('#rec-' + thsREC + ' .date_from').val();
		var Dend   = $('#rec-' + thsREC + ' .date_to').val();
		
		
		var strt = new Date(Dstart + " " + Tstart);
		var end = new Date(Dend + " " + Tend);
		
		var Dif = calcTime( strt, end );
		
		// check if break within time range
		var isLunch = false;
		
		
		var lunchStart = new Date(Dstart + " 12:30:00");
		var lunchEnd   = new Date(Dend + " 13:30:00");
		
		var NtlunchStart = new Date(Dstart + " 21:00:00");
		var NtlunchEnd   = new Date(Dstart + " 22:00:00");
		
		
		if( lunchStart > strt && lunchEnd < end ){
			isLunch = true;
		}
		
		if( NtlunchStart > strt && NtlunchEnd < end ){
			isLunch = true;
		}
		
		console.log( NtlunchStart );
		console.log( NtlunchEnd );
		
		var TotHours = getDayTimeDiff( strt, end );
		
		if( isLunch == true ){
			TotHours = TotHours - 1;
		}
		
		if( TotHours <= 0 ){
			TotHours = 0;
		}
		
		
		var OT = 0;
		var RT = TotHours;
		if( TotHours > 8 ){
			OT = TotHours - 8;
			RT = 8;
		}
		
		//check if friday
		var Day = strt.getDay();
		if( Day == 5 ){
			//its friday, all are OT
			OT = TotHours;
			RT = 0;
		}
		
		
		
		
		$('#rec-' + thsREC + ' .total_time').val( TotHours );
		$('#rec-' + thsREC + ' .regular_time').val( RT );
		$('#rec-' + thsREC + ' .ot_time').val( OT );
		
		
		
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


function fixTableNumbering(){
	var tot = 0;
	$('.serialNo').each( function(){
		tot++;
		$(this).html(tot);
	} );
}

function getEmpName( thsCode, thsIDDD ){
	
	// console.log('s-11-' + thsCode);
	if( thsCode != '' ){
		var thsName = $('#code-' + thsCode).html();
		if( thsName != '' ){
			// console.log('s-2-' + thsName);
			var empID = parseInt( $('#emp-' + thsCode).html() );
			if( isNaN( empID ) ){
				empID = 0;
			}
			if( empID != 0 ){
				$('#new-employee_name' + thsIDDD).val(thsName);
				$('#new-employee_id' + thsIDDD).val(empID);
			}
				
		} else {
			// console.log('e2');
		}
	} else {
		// console.log('e11');
	}
	
}

function initTableEvents(){
	$('.employee_code').on( 'input', function(){
		var thsID = $(this).val();
		var thsIDd = $(this).attr('ids');
		getEmpName(thsID, thsIDd);
	} );
	$('.time_from').on( 'input', function(){
		calcTimeDiff();
	} );
	$('.time_to').on( 'input', function(){
		calcTimeDiff();
	} );
	$('.date_from').on( 'change', function(){
		calcTimeDiff();
	} );
	$('.date_to').on( 'change', function(){
		calcTimeDiff();
	} );
	$('#new-day_date').on( 'change', function(){
		calcTimeDiff();
	} );
}

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
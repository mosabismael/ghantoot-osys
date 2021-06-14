<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 1;
	$subPageID = 1;
	
	
	
?>
<!DOCTYPE html>
<html dir="<?=$lang_dir; ?>" lang="<?=$lang; ?>">
<head>
	<?php include('app/meta.php'); ?>
    <?php include('app/assets.php'); ?>
</head>
<body>
<?php
	$noAside = true;
	include('app/header.php');
	//PAGE DATA START -----------------------------------------------///---------------------------------
?>



				<form 
				id="add-new-timesheet-form" 
				id-modal="add_new_timesheet" 
				class="boxes-holder" 
				api="<?=api_root; ?>projects/timesheets/add_new_timesheet.php">
				


					
<div class="col-33">
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('Job Order', 'ARR', 1); ?></label>
		<select class="frmData" 
				id="new-job_order_id" 
				name="job_order_id" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_job_order", "AAR"); ?>">
				<option value="0" selected><?=lang('Please_Select', 'AA', 1); ?></option>
<?php
	$qu_FETCH_sel = "SELECT `job_order_id`, `job_order_ref`, `project_name` FROM  `job_orders`";
	$qu_FETCH_EXE = mysqli_query($KONN, $qu_FETCH_sel);
	if(mysqli_num_rows($qu_FETCH_EXE)){
		while($fetched_DT = mysqli_fetch_array($qu_FETCH_EXE)){
			
		?>
		<option value="<?=$fetched_DT[0]; ?>"><?=$fetched_DT[1].'-'.$fetched_DT[2]; ?></option>
		<?php
	
		}
	}
?>
			</select>
	</div>
</div>
<script>
$('#new-job_order_id').on( "change", function(){
	fetchTasks();
} );


function fillTasks(){
	var tasks = $('#loaded_tasks').html();
	$('.task_id').each( function(){
		$(this).html( tasks );
	} );
}

function fetchTasks(){
	var jobID = parseInt( $('#new-job_order_id').val() );
	if( jobID != 0 ){
		

	$.ajax({
		url      :"<?=api_root; ?>projects/tasks/get_all_from_job.php",
		data     :{ 'job_order_id': jobID },
		dataType :"json",
		type     :'POST',
		success  :function( response ){
				end_loader();
				$('#loaded_tasks').html(''); //-----------------------------------------------------------------
			//load items
			var cc = 0;
			$('#loaded_tasks').append('<option value="0" selected><?=lang("Please_Select_Project_To_View_Tasks", "AA", 1); ?></option>');
			for( i=0 ; i < response.length ; i ++ ){
				cc++;
				var task_id    = parseInt( response[i].task_id );
				if( task_id != 0 ){
					
				var namer = response[i].process_name + ' - ' + response[i].activity_name + ' - ' + response[i].task_name;
				
				
				var tr = '' + 
						'<option value="' + task_id + '">' + namer  + '</option>';
				
				$('#loaded_tasks').append(tr);
				}
			}
			
			fillTasks();
			
			},
		error    :function(){
				end_loader();
			alert('Data Error No: 5467653');
			},
		});
		
		
		
	}
}


</script>

<div class="col-33">
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('Date', 'AA', 1); ?></label>
		<input class="frmData has_date" 
				id="new-ts_date" 
				name="ts_date" 
				type="text"
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_date", "AAR"); ?>">
	</div>
</div>

<div class="col-33">
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('Serial', 'AA', 1); ?></label>
		<input class="frmData" 
				id="new-ts_serial" 
				name="ts_serial" 
				type="text"
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_Serial", "AAR"); ?>">
	</div>
</div>




<div class="col-100" style="width:100%;">
			<br><br>
			<table class="tabler" style="width:100%;" border="1">
				<thead>
					<tr>
						<th colspan="1">&nbsp;</th>
						<th colspan="2" style="width:25%;"><?=lang('Employee'); ?></th>
						<th colspan="2" style="width:30%;"><?=lang('Duty'); ?></th>
						<th colspan="3" style="width:25%;"><?=lang('Timing'); ?></th>
						<th style="width:15%;"><?=lang('Project'); ?></th>
					</tr>
					<tr>
						<th><?=lang('No.'); ?></th>
						<th><?=lang('ID'); ?></th>
						<th><?=lang('Name'); ?></th>
						<th><?=lang('Duty_From'); ?></th>
						<th><?=lang('Duty_To'); ?></th>
						<th><?=lang('RT'); ?></th>
						<th><?=lang('OT'); ?></th>
						<th><?=lang('TT'); ?></th>
						<th><?=lang('Task'); ?></th>
					</tr>
				</thead>
				<tbody>
				
				

					
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
	<div class="col-100" id="add_new_timesheet">
		<div class="form-alerts" style="width: 50%;margin: 0 auto;text-align: left;"></div>
	</div>
			
<div class="btns-holder text-center">
	<button class="btn btn-success" type="button" onclick="submit_form('add-new-timesheet-form', 'forward_page');"><?=lang('Save Timesheet'); ?></button>
	<a href="labours_timesheets.php"><button class="btn btn-warning" type="button" onclick=""><?=lang('Cancel'); ?></button></a>
</div>


	<div class="zero"></div>

	

</form>
	
	
	
	


<script>
totRecs = 1500;



//CALC all OT on friday
//LOCAL OR HIRE
//day   shift lunch 1230 -> 1330
//night shift lunch 21 -> 22




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
		$('#rec-' + rec + ' .time_to').val('16:29');
		$('#rec-' + rec ).attr('night', '0');
		addDateToRec( rec );
		$('#shiftBtn-' + rec).addClass( 'fa-sun' );
		$('#shiftBtn-' + rec).removeClass( 'fa-moon' );
	}
		calcTimeDiff();
}


function addDateToRec( REC ) {
	var ts_date = $('#new-ts_date').val();
	var dd = new Date( ts_date );
	dd.setDate( dd.getDate() + 1 );
	$('#rec-' + REC + ' .date_from').val( ts_date );
	$('#rec-' + REC + ' .date_to').val( ts_date );
	
}

function MakeNightDate( REC ) {
	var ts_date = $('#new-ts_date').val();
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
	var ts_date = $('#new-ts_date').val();
	var jobID   = parseInt( $('#new-job_order_id').val() );
	if( ts_date != '' ){
		if( jobID != 0 ){
			addTsRec();
		} else {
			alert( "Please Select Desired Project" );
			$('#new-job_order_id').focus();
		}
	} else {
		alert( "Please Select Timesheet Date" );
		$('#new-ts_date').focus();
	}
}

function addTsRec(){

	totRecs++;
	
	var tr = 		'<tr class="ts_record" id="rec-' + totRecs + '" ids="' + totRecs + '"  night="1">' + 
					'	<td title="Delete This Record" style="text-align: center;" class="serialNo"  onclick="delRec(' + totRecs + ');">' + totRecs + '</td>' + 
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
					'				alerter="<?=lang("Please_Check_employee_code", "AAR"); ?>" style="width:100%;">' + 
					'		<input class="employee_name" id="new-employee_name' + totRecs + '" type="text" disabled style="width:100%;">' + 
					'	</td>' + 
					'	<td style="text-align: center;">' + 
					'		<i id="shiftBtn-' + totRecs + '" onclick="makeNight(' + totRecs + ');" title="Change Shift" class="fas fa-sun"></i>' + 
					'		<input class="frmData date_from has_date" ids="' + totRecs + '" ' + 
					'				id="new-date_from' + totRecs + '" ' + 
					'				name="date_froms[]" ' + 
					'				type="text"' + 
					'				req="1" ' + 
					'				den="" ' + 
					'				alerter="<?=lang("Please_Check_date_from", "AAR"); ?>">' + 
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
					'				req="1" ' + 
					'				den="" ' + 
					'				alerter="<?=lang("Please_Check_date_from", "AAR"); ?>">' + 
					'		<input class="frmData time_to has_time" ids="' + totRecs + '" ' + 
					'				id="new-time_to' + totRecs + '" ' + 
					'				name="time_tos[]" ' + 
					'				type="text"' + 
					'				req="1" ' + 
					'				den="" ' + 
					'				alerter="<?=lang("Please_Check_time_from", "AAR"); ?>">' + 
					'	</td>' + 
					'	<td>' + 
					'		<input class="frmData regular_time" ids="' + totRecs + '" ' + 
					'				id="new-regular_time' + totRecs + '" ' + 
					'				name="regular_times[]" ' + 
					'				type="text"' + 
					'				req="1" ' + 
					'				den="" ' + 
					'				alerter="<?=lang("Please_Check_time_from", "AAR"); ?>" disabled style="width:100%;">' + 
					'	</td>' + 
					'	<td>' + 
					'		<input class="frmData ot_time" ids="' + totRecs + '" ' + 
					'				id="new-ot_time' + totRecs + '" ' + 
					'				name="ot_times[]" ' + 
					'				type="text"' + 
					'				req="1" ' + 
					'				den="" ' + 
					'				alerter="<?=lang("Please_Check_time_from", "AAR"); ?>" disabled style="width:100%;">' + 
					'	</td>' + 
					'	<td>' + 
					'		<input class="frmData total_time" ids="' + totRecs + '" ' + 
					'				id="new-total_time' + totRecs + '" ' + 
					'				name="total_times[]" ' + 
					'				type="text"' + 
					'				req="1" ' + 
					'				den="" ' + 
					'				alerter="<?=lang("Please_Check_time_from", "AAR"); ?>" disabled style="width:100%;">' + 
					'	</td>' + 
					'	<td>' + 
					'		<select class="frmData task_id" ' + 
					'				id="new-task_id' + totRecs + '" ' + 
					'				name="task_ids[]" ' + 
					'				req="1" ' + 
					'				den="0" ' + 
					'				alerter="<?=lang("Please_Check_job_order", "AAR"); ?>" style="width:100%;">' + 
					'				<option value="0" selected><?=lang("Please_Select_Project_To_View_Tasks", "AA", 1); ?></option>' + 
					'			</select>' + 
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
	fillTasks();
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
		
		
		
		var ts_date = $('#new-ts_date').val();
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
	$('#new-ts_date').on( 'change', function(){
		calcTimeDiff();
	} );
}

</script>
















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


<div id="loaded_tasks" style="display:none;"></div>

<?php
	//PAGE DATA END   ----------------------------------------------///---------------------------------
	include('app/footer.php');
?>
<script>






init_nwFormGroup();
</script>
</body>
</html>
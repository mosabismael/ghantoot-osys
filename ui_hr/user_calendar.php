<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	$page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	// $page_title=$page_description=$page_keywords=$page_author= "Site Title";
	$page_id = 0;
	$WHERE = lang("calendar", "AAR");
	$pageID = 0;
	$subPageID = 0;
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


<div class="text-center">
<div class="calendar">
	<div class="calendar-datepicker">
		
		<div class="calendar-datepicker-top">
		
			<div class="calendar-datepicker-month">
				<i onclick="min_month();" class="fas fa-angle-double-left"></i>
				<span id="calendar-month"><?=date('m'); ?></span>
				<i onclick="max_month();" class="fas fa-angle-double-right"></i>
			</div>
			
			<div class="calendar-datepicker-year">
				<i onclick="min_year();" class="fas fa-minus-square"></i>
				<span id="calendar-year"><?=date('Y'); ?></span>
				<i onclick="max_year();" class="fas fa-plus-square"></i>
			</div>
			
			<div class="zero"></div>
		</div>
		
		<div class="calendar-datepicker-weeker">
				
					<div class="weeker-header">
						<div class="weekday"><span>Su</div>
						<div class="weekday"><span>Mo</div>
						<div class="weekday"><span>Tu</div>
						<div class="weekday"><span>We</div>
						<div class="weekday"><span>Th</div>
						<div class="weekday"><span>Fr</div>
						<div class="weekday"><span>Sa</div>
					</div>
					<div class="weeker-body"></div>
					
		</div>
		
	</div>
	<div class="calendar-viewer">
		<div class="viewed-app">
			<div class="app-details">
				Select Event to view details
			</div>
		</div>
	</div>
	<div class="zero"></div>
	<div class="calendar-lister">
		<table>
			<thead>
				<tr>
					<th style="width:10%;">NO.</th>
					<th style="width:20%;">Time</th>
					<th>Event</th>
				</tr>
			</thead>
			<tbody id="apps-data"></tbody>
		</table>
	</div>
	
	
	<div class="zero"></div>
</div>
<div class="calendar-options">
	<i onclick="show_modal( 'add_new_event' , 'add new event' );" class="far fa-calendar-plus" title="add event"></i>
	<i onclick="call_calendar_apps();" class="fas fa-sync" title="Refresh"></i>
</div>


	<div id="calendar-settings">
		<span class="year"><?=date('Y'); ?></span>
		<span class="month"><?=date('m'); ?></span>
		<span class="day"><?=date('d'); ?></span>
	</div>


</div>



<div id="calendar-data">
<?php
$yearMIN = date('Y');
$yearMAX = date('Y') + 3;
for( $year = $yearMIN; $year <= $yearMAX ; $year++ ){
?>
	<div id="year-<?=$year; ?>">
<?php
	$monthMIN = 1;
	$monthMAX = 12;
	for( $month = $monthMIN; $month <= $monthMAX ; $month++ ){
?>
		<div id="y-<?=$year; ?>-m-<?=$month; ?>">
					<?php
					$tot_days = cal_days_in_month( CAL_GREGORIAN, $month, $year );
					$thisDay = date('d');
					for( $day = 1; $day <= $tot_days ; $day++ ){
						
						$thisID = $day;
						$dayName = $day;
						if( $day < 10 ){
							$dayName = '0' + $day;
						}
					?>
						<div id="day-<?=$thisID; ?>" 
							onclick="setDay('<?=$thisID; ?>', true);" 
							dt-day="<?=$day; ?>"
							dt-month="<?=$month; ?>"
							dt-year="<?=$year; ?>"
							class="weekday"><span><?=$dayName; ?></span>
						</div>
					<?php
					}
					?>
	
			<div class="zero"></div>
		</div>
<?php
	}
?>
	</div>
<?php
}
?>
</div>





<!--    ///////////////////      add_new_ Modal START    ///////////////////            -->
<div class="modal" id="add_new_event">
	<div class="modal-closer">
		<div class="closer-btns">
			<i class="far fa-check-circle modal_saver" onclick="submit_form('new-app-form', 'call_back');" title="<?=lang("Save", "AAR"); ?>"></i>
			<i class="far fa-times-circle modal_cancel" onclick="hide_modal();" title="<?=lang("Cancel", "AAR"); ?>"></i>
		</div>
		<div class="form-alerts"></div>
	</div>
	<div class="modal-container">
		<div class="modal-header">
			<h1></h1>
		</div>
		<div class="modal-body">
				<form 
				id="new-app-form" 
				id-modal="add_new_event" 
				id-callback="call_calendar_apps" 
				class="boxes-holder" 
				api="<?=api_root; ?>calendar/add_new_event.php">
				
				
<div class="zero"></div>

<div class="col-50">
	<div class="form-grp">
		<label>Event Date</label>
		<input class="frmData has_date" type="text" 
		id="new-event_date" 
		name="event_date" 
		req="1" 
		den="" defaulter="" 
		alerter="<?=lang("Please_Select_Date", "AAR"); ?>">
	</div>
</div>
<div class="col-50">
	<div class="form-grp">
		<label>Event Time</label>
		<select class="frmData" 
		id="new-event_time" 
		name="event_time" 
		req="1" 
		den="500" defaulter=""
		alerter="<?=lang("Please_Select_time", "AAR"); ?>">
			<option value="500" selected>--- Please Select---</option>
<?php
for( $i = 0 ; $i <=24 ; $i++ ){
	$Hour = $i.':00';
	$Hour2 = $i.':30';
?>
	<option value="<?=$Hour; ?>"><?=$Hour; ?></option>
<?php
}
?>
		</select>
	</div>
</div>



	<div class="zero"></div>
	
<div class="col-50">
	<div class="form-grp">
		<label>Event Title</label>
		<input class="frmData" type="text" 
		id="new-event_title" 
		name="event_title" 
		req="1" 
		den="" defaulter="" 
		alerter="<?=lang("Please_Insert_Title", "AAR"); ?>">
	</div>
</div>
	
<div class="col-50">
	<div class="form-grp">
		<label>Event details</label>
		<textarea class="frmData" type="text" 
		id="new-notes" 
		name="notes" 
		req="1" 
		den="" defaulter="" 
		alerter="<?=lang("Please_Insert_details", "AAR"); ?>"></textarea>
	</div>
</div>

	
	
	<div class="zero"></div>
	

</form>
			
			
		</div>
	</div>
	<div class="zero"></div>
</div>


<!--    ///////////////////      add_new_event Modal END    ///////////////////            -->





















<?php
	//PAGE DATA END   ----------------------------------------------///---------------------------------
	include('app/footer.php');
?>
<script>
var curViewer = $('.calendar-viewer').html();
function set_def_app_details(){
	$('.calendar-viewer').html(curViewer);
}
function show_app_details( appID ){
	
	var appTime = $('#app-'+appID).attr('app-time');
	var event_title = $('#app-'+appID).attr('app-title');
	var appNotes = $('#app-'+appID).attr('app-notes');
	
	
	
	var appNW = '<div class="viewed-app">' + 
					'	<div class="app-time">' + 
					appTime + 
					'	</div>' + 
					'	<div class="app-patient">' + 
					event_title + 
					'	</div>' + 
					'	<div class="app-details">' + 
					appNotes + 
					'	</div>' + 
				'</div>';
	$('.calendar-viewer').html(appNW);
					
}


var minYear = <?=date('Y'); ?>;
var maxYear = <?=date('Y') + 3; ?>;
var curYear = <?=date('Y'); ?>;

var curMonthRES = <?=date('m'); ?> + '';
var curMonth = <?=date('m'); ?>;
var curDay = <?=date('d'); ?>;


function min_month(){
	curMonth = curMonth - 1;
	if( curMonth < 1 ){
		curMonth = 12;
	}
	setMonth( curMonth );
	setDay(1, true);
}
function max_month(){
	curMonth = curMonth + 1;
	if( curMonth > 12 ){
		curMonth = 1;
	}
	setMonth( curMonth );
	setDay(1, true);
}

function min_year(){
	curYear = curYear - 1;
	if( curYear < minYear ){
		curYear = minYear;
	}
	setYear( curYear );
	// setMonth( 1 );
	setDay(1, true);
}
function max_year(){
	curYear = curYear + 1;
	if( curYear > maxYear ){
		curYear = minYear;
	}
	setYear( curYear );
	// setMonth( 1 );
	setDay(1, true);
}


function setYear( yearNO ){
	$("#calendar-year").html(yearNO);
	$("#calendar-settings .year").html(curYear);
}

function setMonth( MonthNO ){
	curMonth = MonthNO;
	$("#calendar-month").html(MonthNO);
	curMonthRES = '';
		if(curMonth < 10){
			curMonthRES = '0' + curMonth;
		} else {
			curMonthRES = curMonth;
		}
	$("#calendar-month").html(curMonthRES);
	$("#calendar-settings .month").html(curMonth);
}

function setDay(dayID, isGetData){
	// alert(dayID);
	curDay = dayID;
	$('.weeker-body .selected-day').removeClass('selected-day');
	$('#day-' + dayID).addClass('selected-day');
	$("#calendar-settings .day").html(curDay);
	if( isGetData == true ){
		get_calendar_data();
	}
	$('#new-event_date').val(curYear + '-' + curMonthRES + '-' + curDay);
}

function call_calendar_apps(){
	set_loader(10);
	start_loader();
	

	$.ajax({
		url      :"<?=api_root; ?>calendar/get_day_apps.php",
		data     :{'day': curDay, 'month': curMonth, 'year': curYear},
		dataType :"HTML",
		type     :'POST',
		success  :function(response){
			
			$('#apps-data').html(response);
			set_def_app_details();
	set_loader(100);
	end_loader();
				
		},
		error    :function(){
			alert('Code Not Applied');
		},
	});
	
	
}

function get_calendar_data(){
	var ths_data = $('#y-' + curYear + '-m-' + curMonth ).html();
	console.log('#y-' + curYear + '-m-' + curMonth);
	$('.weeker-body').html(ths_data);
	setDay(curDay, false);
	fix_calendar();
	call_calendar_apps();
}

function fix_calendar(){
	//make calendar-viewer height AS calendar-datepicker height
	var datepickerHeight = $('.calendar-datepicker').height();
	datepickerHeight = datepickerHeight + 30;
	$('.calendar-viewer').css('height', datepickerHeight + 'px');
}











get_calendar_data();
</script>










</body>
</html>
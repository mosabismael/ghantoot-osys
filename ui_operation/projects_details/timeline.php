

<form  class="form-grp"
id="save-timeline-form" 
id-modal="save_timeline_modal" 
api="<?=api_root; ?>sales/quotations/add_new.php">
	<input type="hidden" name="job_order_id" class="frmData" value="<?=$job_order_id; ?>" req="1" den="" alerter="<?=lang("Please_Check_inputs", "AAR"); ?>">
		
		<div class="form-item col-100">
			<table class="tabler">
				<thead>
					<tr>
						<th style="width:40%;"><?=lang('---'); ?></th>
						<th><?=lang('Start_Date'); ?></th>
						<th><?=lang('Duration'); ?>(Days)</th>
						<th><?=lang('End_Date'); ?></th>
					</tr>
				</thead>
<?php
	$qu_job_orders_processes_sel = "SELECT * FROM  `job_orders_groups` WHERE `job_order_id` = $job_order_id";
	$qu_job_orders_processes_EXE = mysqli_query($KONN, $qu_job_orders_processes_sel);
	if(mysqli_num_rows($qu_job_orders_processes_EXE)){
		while($job_orders_processes_REC = mysqli_fetch_assoc($qu_job_orders_processes_EXE)){
			$group_id = $job_orders_processes_REC['group_id'];
			$group_name = $job_orders_processes_REC['group_name'];
			$job_order_id = $job_orders_processes_REC['job_order_id'];
		?>
				<tbody id="tl-group-<?=$group_id; ?>">
			<tr class="joGroups" id="tl-thsprocess-<?=$group_id; ?>">
				<input type="hidden" name="group_ids[]" class="frmData" value="<?=$group_id; ?>" req="1" den="" alerter="<?=lang("Please_Check_inputs", "AAR"); ?>">
				<td class="text-left"><span class="jo_g">G</span><?=$group_name; ?></td>
				<td><input type="text" name="g_start_dates[]" class="frmData startDate readOnly" readonly req="0" den="" alerter="<?=lang("Please_Check_inputs", "AAR"); ?>"></td>
				<td><input type="number" name="g_durations[" class="frmData duration readOnly" readonly req="0" den="" alerter="<?=lang("Please_Check_inputs", "AAR"); ?>"></td>
				<td><input type="text" name="g_end_dates[]" class="frmData endDate readOnly" readonly req="0" den="" alerter="<?=lang("Please_Check_inputs", "AAR"); ?>"></td>
			</tr>
			
<?php
	$qu_job_orders_processes_sel = "SELECT * FROM  `job_orders_processes` WHERE `job_order_id` = $job_order_id";
	$qu_job_orders_processes_EXE = mysqli_query($KONN, $qu_job_orders_processes_sel);
	if(mysqli_num_rows($qu_job_orders_processes_EXE)){
		while($job_orders_processes_REC = mysqli_fetch_assoc($qu_job_orders_processes_EXE)){
			$process_id = $job_orders_processes_REC['process_id'];
			$process_name = $job_orders_processes_REC['process_name'];
			$job_order_id = $job_orders_processes_REC['job_order_id'];
		?>
		
			<tr class="joProcess" id="tl-thsprocess-<?=$process_id; ?>">
				<input type="hidden" name="process_ids[]" class="frmData" value="<?=$process_id; ?>" req="1" den="" alerter="<?=lang("Please_Check_inputs", "AAR"); ?>">
				<td class="text-left"><span class="jo_p">P</span><?=$process_name; ?></td>
				<td><input type="text" name="p_start_dates[]" class="frmData startDate readOnly" readonly req="0" den="" alerter="<?=lang("Please_Check_inputs", "AAR"); ?>"></td>
				<td><input type="number" name="p_durations[" class="frmData duration readOnly" readonly req="0" den="" alerter="<?=lang("Please_Check_inputs", "AAR"); ?>"></td>
				<td><input type="text" name="p_end_dates[]" class="frmData endDate readOnly" readonly req="0" den="" alerter="<?=lang("Please_Check_inputs", "AAR"); ?>"></td>
			</tr>
			
			
<?php
	$qu_job_orders_processes_acts_sel = "SELECT * FROM  `job_orders_processes_acts` WHERE `process_id` = $process_id";
	$qu_job_orders_processes_acts_EXE = mysqli_query($KONN, $qu_job_orders_processes_acts_sel);
	if(mysqli_num_rows($qu_job_orders_processes_acts_EXE)){
		while($job_orders_processes_acts_REC = mysqli_fetch_assoc($qu_job_orders_processes_acts_EXE)){
			$activity_id = $job_orders_processes_acts_REC['activity_id'];
			$activity_name = $job_orders_processes_acts_REC['activity_name'];
			$process_id = $job_orders_processes_acts_REC['process_id'];
			$job_order_id = $job_orders_processes_acts_REC['job_order_id'];
		?>
			<tr class="joActivity" id="tl-activity-<?=$activity_id; ?>">
				<input type="hidden" name="activity_ids[]" class="frmData" value="<?=$activity_id; ?>" req="1" den="" alerter="<?=lang("Please_Check_inputs", "AAR"); ?>">
				<td class="text-left"><span class="jo_a">A</span><?=$activity_name; ?></td>
				<td><input type="text" name="a_start_dates[]" class="frmData startDate readOnly tl-proAct-strt-<?=$process_id; ?>" readonly req="0" den="" alerter="<?=lang("Please_Check_inputs", "AAR"); ?>"></td>
				<td><input type="number" name="a_durations[]" class="frmData duration readOnly" readonly req="0" den="" alerter="<?=lang("Please_Check_inputs", "AAR"); ?>"></td>
				<td><input type="text" name="a_end_dates[]" class="frmData endDate readOnly tl-proAct-end-<?=$process_id; ?>" readonly req="0" den="" alerter="<?=lang("Please_Check_inputs", "AAR"); ?>"></td>
			</tr>
			
			
			
<?php
	$qu_job_orders_processes_acts_tasks_sel = "SELECT * FROM  `job_orders_processes_acts_tasks` WHERE `activity_id` = $activity_id";
	$qu_job_orders_processes_acts_tasks_EXE = mysqli_query($KONN, $qu_job_orders_processes_acts_tasks_sel);
	if(mysqli_num_rows($qu_job_orders_processes_acts_tasks_EXE)){
		while($job_orders_processes_acts_tasks_REC = mysqli_fetch_assoc($qu_job_orders_processes_acts_tasks_EXE)){
			$task_id = $job_orders_processes_acts_tasks_REC['task_id'];
			$task_name = $job_orders_processes_acts_tasks_REC['task_name'];
			$activity_id = $job_orders_processes_acts_tasks_REC['activity_id'];
			$process_id = $job_orders_processes_acts_tasks_REC['process_id'];
			$job_order_id = $job_orders_processes_acts_tasks_REC['job_order_id'];
		?>
			<tr class="joTask" id="tl-task-<?=$task_id; ?>">
				<input type="hidden" name="task_ids[]" class="frmData" value="<?=$task_id; ?>" req="1" den="" alerter="<?=lang("Please_Check_inputs", "AAR"); ?>">
				<td class="text-left"><span class="jo_t">T</span><?=$task_name; ?></td>
				<td><input type="text" name="t_start_dates[]" onchange="calcTimeline(<?=$task_id; ?>, <?=$activity_id; ?>, <?=$process_id; ?>);" class="frmData startDate has_date tl-actTasks-strt-<?=$activity_id; ?>"  req="0" den="" alerter="<?=lang("Please_Check_inputs", "AAR"); ?>"></td>
				<td><input type="number" name="t_durations[]" onchange="calcTimeline(<?=$task_id; ?>, <?=$activity_id; ?>, <?=$process_id; ?>);" class="frmData duration tl-actTasks-dur-<?=$activity_id; ?>"  req="0" den="" alerter="<?=lang("Please_Check_inputs", "AAR"); ?>"></td>
				<td><input type="text" name="t_end_dates[]" onchange="calcTimeline(<?=$task_id; ?>, <?=$activity_id; ?>, <?=$process_id; ?>);" class="frmData endDate readOnly tl-actTasks-end-<?=$activity_id; ?>" readonly req="0" den="" alerter="<?=lang("Please_Check_inputs", "AAR"); ?>"></td>
			</tr>
		<?php
		}
	}
?>
			
			
			
		<?php
		}
	}
?>
			
			
			
			
			
		<?php
		}
	}
?>
			
				</tbody>
		<?php
		}
	}
?>
				
				
			</table>
		</div>
		<div class="zero"></div>
<div class="row">
	<div class="col-100" id="save_timeline_modal">
		<div class="form-alerts" style="width: 50%;margin: 0 auto;text-align: left;"></div>
	</div>
</div>
	
<div class="btns-holder">
	<button class="btn btn-success" type="button" onclick="submit_form('save-timeline-form', 'nothing');"><?=lang('SAVE_TIMELINE'); ?></button>
</div>
	
	</form>

	

<script>
Date.prototype.addDays = function(days) {
    var date = new Date(this.valueOf());
    date.setDate(date.getDate() + days);
    return date;
}

function calcTimeline( task, activity, process ){
	//get start date
	var strtDateCHK = $('#tl-task-' + task + ' .startDate').val();
	var endDate  = '';
	
	if( strtDateCHK != '' ){
		
		var days = parseInt( $('#tl-task-' + task + ' .duration').val() );
		
		if( isNaN( days ) ){
			days = 0;
			$('#tl-task-' + task + ' .duration').val('0');
		}
		start_date = new Date( $('#tl-task-' + task + ' .startDate').attr('value') );
		var end_date = new Date(start_date);
		end_date.setDate(start_date.getDate() + days);
		$('#tl-task-' + task + ' .endDate').attr( 'value', end_date.getFullYear() + '-' + ("0" + (end_date.getMonth() + 1)).slice(-2) + '-' + ("0" + end_date.getDate()).slice(-2) );
		
		calcActivity( activity, process );
		
	} else {
		alert('Please Select a valid start date');
		$('#tl-task-' + task + ' .startDate').focus();
	}
}


function calcActivity( actID, processID ){
		//collect all start dates and find oldest one
		var i = 0;
		var strtDates = [];
		$('.tl-actTasks-strt-' + actID).each( function(){
			var thsV = $(this).attr('value');
			if( thsV != '' ){
				strtDates[i] = thsV;
				i++;
			}
			
		} );
		var orderedStartDates = strtDates.sort(function(a, b) {
		  return Date.parse(a) - Date.parse(b);
		});
		$('#tl-activity-' + actID + ' .startDate').attr( 'value', orderedStartDates[0] );
		
		//collect all end dates and find newest one
		var i = 0;
		var endDates = [];
		$('.tl-actTasks-end-' + actID).each( function(){
			var thsV = $(this).attr('value');
			if( thsV != '' ){
				endDates[i] = thsV;
				i++;
			}
		} );
		i = i -1;
		var orderedStartDates = endDates.sort(function(a, b) {
		  return Date.parse(a) - Date.parse(b);
		});
		$('#tl-activity-' + actID + ' .endDate').attr( 'value', orderedStartDates[i] );
		
		//calc total duration for activity
		var ACTstart_date = new Date( $('#tl-activity-' + actID + ' .startDate').attr('value') );
		var ACTend_date   = new Date( $('#tl-activity-' + actID + ' .endDate').attr('value') );
		var diffTime      = Math.abs(ACTend_date - ACTstart_date);
		var diffDays      = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
		diffDays          = diffDays + 1;
		$('#tl-activity-' + actID + ' .duration').val( diffDays );
		calcProcess( processID );
}

function calcProcess( proID ){
		//collect all start dates and find oldest one
		var i = 0;
		var strtDates = [];
		$('.tl-proAct-strt-' + proID).each( function(){
			var thsV = $(this).attr('value');
			if( thsV != '' ){
				strtDates[i] = thsV;
				i++;
			}
			
		} );
		var orderedStartDates = strtDates.sort(function(a, b) {
		  return Date.parse(a) - Date.parse(b);
		});
		$('#tl-thsprocess-' + proID + ' .startDate').attr( 'value', orderedStartDates[0] );
		
		//collect all end dates and find newest one
		var i = 0;
		var endDates = [];
		$('.tl-proAct-end-' + proID).each( function(){
			var thsV = $(this).attr('value');
			if( thsV != '' ){
				endDates[i] = thsV;
				i++;
			}
		} );
		i = i -1;
		var orderedStartDates = endDates.sort(function(a, b) {
		  return Date.parse(a) - Date.parse(b);
		});
		$('#tl-thsprocess-' + proID + ' .endDate').attr( 'value', orderedStartDates[i] );
		
		//calc total duration for activity
		var ACTstart_date = new Date( $('#tl-thsprocess-' + proID + ' .startDate').attr('value') );
		var ACTend_date   = new Date( $('#tl-thsprocess-' + proID + ' .endDate').attr('value') );
		var diffTime      = Math.abs(ACTend_date - ACTstart_date);
		var diffDays      = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
		diffDays          = diffDays + 1;
		$('#tl-thsprocess-' + proID + ' .duration').val( diffDays );
}
</script>

<br>
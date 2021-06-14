<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	
	$menuId = 3;
	$subPageID = 5;
	
	
	
	
	$job_order_id = 0;
	$ts_date_from = "";
	$ts_date_to = "";
	
	
	if( isset( $_GET['job_order_id'] ) ){
		$job_order_id = ( int ) test_inputs( $_GET['job_order_id'] );
	}
	
	if( isset( $_GET['ts_date_from'] ) ){
		$ts_date_from = test_inputs( $_GET['ts_date_from'] );
	}
	
	if( isset( $_GET['ts_date_to'] ) ){
		$ts_date_to = test_inputs( $_GET['ts_date_to'] );
	}
	
	
	
	$COND = "";
	
	
	
	
	
	
?>
<!DOCTYPE html>
<html dir="<?=$lang_dir; ?>" lang="<?=$lang; ?>">
<head>
	<?php include('app/meta.php'); ?>
    <?php include('app/assets.php'); ?>
</head>
<body>
<?php

	$WHERE = "projects";
	include('app/header.php');
	//PAGE DATA START -----------------------------------------------///---------------------------------
?>



<div class="row">
	<form class="col-100" method="GET">

<div class="col-25">
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('Job Order', 'ARR', 1); ?></label>
		<select class="frmData" 
				id="new-job_order_id" 
				name="job_order_id" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_job_order", "AAR"); ?>">
				<option value="0" selected><?=lang('All_Projects', 'AA', 1); ?></option>
<?php
	$qu_FETCH_sel = "SELECT `job_order_id`, `job_order_ref`, `project_name` FROM  `job_orders`";
	$qu_FETCH_EXE = mysqli_query($KONN, $qu_FETCH_sel);
	if(mysqli_num_rows($qu_FETCH_EXE)){
		while($fetched_DT = mysqli_fetch_array($qu_FETCH_EXE)){
			$job_order_idDT = $fetched_DT[0];
			
			$SEL = "";
			if( $job_order_id == $job_order_idDT ){
				$SEL = "selected";
			}
			
		?>
		<option value="<?=$fetched_DT[0]; ?>" <?=$SEL; ?>><?=$fetched_DT[1].'-'.$fetched_DT[2]; ?></option>
		<?php
	
		}
	}
?>
			</select>
	</div>
</div>

<div class="col-25">
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('Level', 'ARR', 1); ?></label>
		<select class="frmData" 
				id="leveler" 
				name="leveler" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_job_order", "AAR"); ?>">
				<option value="0" selected><?=lang('All', 'AA', 1); ?></option>
				<option value="1"><?=lang('Projects', 'AA', 1); ?></option>
				<option value="2"><?=lang('Processes', 'AA', 1); ?></option>
				<option value="3"><?=lang('Activities', 'AA', 1); ?></option>
				<option value="4"><?=lang('Tasks', 'AA', 1); ?></option>
			</select>
	</div>
</div>
	
<script>
$('#leveler').on( "change", function(){
	var lvl = parseInt( $('#leveler').val() );
	
	if( lvl == 1 ){
		//project
		//hide all
		$('.process').hide();
		$('.activity').hide();
		$('.task').hide();
	} else if( lvl == 2 ){
		//process
		$('.process').show();
		$('.activity').hide();
		$('.task').hide();
		
	} else if( lvl == 3 ){
		//activity
		$('.process').show();
		$('.activity').show();
		$('.task').hide();
		
	} else if( lvl == 4 ){
		//tasks
		$('.process').show();
		$('.activity').show();
		$('.task').show();
	} else if( lvl == 0 ){
		//all
		$('.process').show();
		$('.activity').show();
		$('.task').show();
	}
	
	
} );
</script>

<div class="col-25">
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('From', 'AA', 1); ?></label>
		<input class="frmData has_date" 
				id="new-ts_date_from" 
				name="ts_date_from" 
				value="<?=$ts_date_from; ?>" 
				type="text"
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_date", "AAR"); ?>">
	</div>
</div>
	

<div class="col-25">
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('To', 'AA', 1); ?></label>
		<input class="frmData has_date" 
				id="new-ts_date_to" 
				name="ts_date_to" 
				value="<?=$ts_date_to; ?>" 
				type="text"
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_date", "AAR"); ?>">
	</div>
</div>

<div class="col-25">
<div class="btns-holder text-center">
	<button class="btn btn-success" type="submit"><?=lang('Search'); ?></button>
</div>
</div>
	
	
	
	</form>
	
	
	
	
	<div class="col-100">
		
		<table class="tabler" border="2">
			<thead>
				<tr>
					<th colspan="3" style="width:40%;" rowspan="2"><?=lang("Project_Name", "AAR"); ?></th>
					<th colspan="2"><?=lang("RT", "AAR"); ?></th>
					<th colspan="2"><?=lang("OT", "AAR"); ?></th>
					<th colspan="2"><?=lang("TT", "AAR"); ?></th>
				</tr>
				<tr>
					<th><?=lang("L", "AAR"); ?></th>
					<th><?=lang("H", "AAR"); ?></th>
					<th><?=lang("L", "AAR"); ?></th>
					<th><?=lang("H", "AAR"); ?></th>
					<th><?=lang("L", "AAR"); ?></th>
					<th><?=lang("H", "AAR"); ?></th>
				</tr>
			</thead>
			<tbody>
<?php

	$JO_COND = "";
	if( $job_order_id != 0 ){
		$JO_COND = " WHERE (( `job_order_id` = '$job_order_id' )) ";
	}
	
	$qu_job_orders_sel = "SELECT * FROM  `job_orders` $JO_COND";
	$qu_job_orders_EXE = mysqli_query($KONN, $qu_job_orders_sel);
	if(mysqli_num_rows($qu_job_orders_EXE)){
		while($job_orders_REC = mysqli_fetch_assoc($qu_job_orders_EXE)){
	//STR -- JOB ORDER -----------------------------
		$job_order_id = $job_orders_REC['job_order_id'];
		$job_order_ref = $job_orders_REC['job_order_ref'];
		$project_name = $job_orders_REC['project_name'];
		$job_order_type = $job_orders_REC['job_order_type'];
		$project_manager_id = $job_orders_REC['project_manager_id'];
		$job_order_status = $job_orders_REC['job_order_status'];
		$created_date = $job_orders_REC['created_date'];
		$created_by = $job_orders_REC['created_by'];
		
?>
			<tr class="job" id="job-<?=$job_order_id; ?>">
				<td colspan="3"><strong style="width: 100%;"><?=$project_name; ?></strong></td>
				<td class="l_rt">0</td>
				<td class="h_rt">0</td>
				<td class="l_ot">0</td>
				<td class="h_ot">0</td>
				<td class="l_tt">0</td>
				<td class="h_tt">0</td>
			</tr>
<?php
	//STR -- PROCESS -----------------------------
		$qu_job_orders_processes_sel = "SELECT * FROM  `job_orders_processes` WHERE `job_order_id` = $job_order_id";
		$qu_job_orders_processes_EXE = mysqli_query($KONN, $qu_job_orders_processes_sel);
		if(mysqli_num_rows($qu_job_orders_processes_EXE)){
			while($job_orders_processes_REC = mysqli_fetch_assoc($qu_job_orders_processes_EXE)){
			$process_id = $job_orders_processes_REC['process_id'];
			$process_name = $job_orders_processes_REC['process_name'];
			$job_order_id = $job_orders_processes_REC['job_order_id'];
?>
			<tr class="process" id="process-<?=$process_id; ?>" process="<?=$process_id; ?>" job="<?=$job_order_id; ?>">
				<td><?=$process_name; ?></td>
				<td colspan="2">&nbsp;</td>
				<td class="l_rt">0</td>
				<td class="h_rt">0</td>
				<td class="l_ot">0</td>
				<td class="h_ot">0</td>
				<td class="l_tt">0</td>
				<td class="h_tt">0</td>
			</tr>
<?php
	//STR -- ACT -----------------------------
			$qu_job_orders_processes_acts_sel = "SELECT * FROM  `job_orders_processes_acts` WHERE `process_id` = $process_id";
			$qu_job_orders_processes_acts_EXE = mysqli_query($KONN, $qu_job_orders_processes_acts_sel);
			if(mysqli_num_rows($qu_job_orders_processes_acts_EXE)){
				while($job_orders_processes_acts_REC = mysqli_fetch_assoc($qu_job_orders_processes_acts_EXE)){
				$activity_id = $job_orders_processes_acts_REC['activity_id'];
				$activity_name = $job_orders_processes_acts_REC['activity_name'];
				$process_id = $job_orders_processes_acts_REC['process_id'];
				$job_order_id = $job_orders_processes_acts_REC['job_order_id'];
?>
			<tr class="activity" id="activity-<?=$activity_id; ?>" activity="<?=$activity_id; ?>" process="<?=$process_id; ?>" job="<?=$job_order_id; ?>">
				<td>&nbsp;</td>
				<td><?=$activity_name; ?></td>
				<td>&nbsp;</td>
				<td class="l_rt">0</td>
				<td class="h_rt">0</td>
				<td class="l_ot">0</td>
				<td class="h_ot">0</td>
				<td class="l_tt">0</td>
				<td class="h_tt">0</td>
			</tr>
			
<?php
	//STR -- TASK -----------------------------
	$qu_job_orders_processes_acts_tasks_sel = "SELECT * FROM  `job_orders_processes_acts_tasks` WHERE `activity_id` = $activity_id";
	$qu_job_orders_processes_acts_tasks_EXE = mysqli_query($KONN, $qu_job_orders_processes_acts_tasks_sel);
	if(mysqli_num_rows($qu_job_orders_processes_acts_tasks_EXE)){
		while($job_orders_processes_acts_tasks_REC = mysqli_fetch_assoc($qu_job_orders_processes_acts_tasks_EXE)){
		$task_id = $job_orders_processes_acts_tasks_REC['task_id'];
		$task_name = $job_orders_processes_acts_tasks_REC['task_name'];
		$activity_id = $job_orders_processes_acts_tasks_REC['activity_id'];
		$process_id = $job_orders_processes_acts_tasks_REC['process_id'];
		$job_order_id = $job_orders_processes_acts_tasks_REC['job_order_id'];
		
		
		
		//calc times
		//get related timesheets based on job_order_id 
		$RT = 0;
		$OT = 0;
		$TT = 0;
	$qu_job_orders_timesheets_sel = "SELECT * FROM  `job_orders_timesheets` WHERE `job_order_id` = $job_order_id";
	$qu_job_orders_timesheets_EXE = mysqli_query($KONN, $qu_job_orders_timesheets_sel);
	if(mysqli_num_rows($qu_job_orders_timesheets_EXE)){
		while($job_orders_timesheets_REC = mysqli_fetch_assoc($qu_job_orders_timesheets_EXE)){
		$timesheet_id = $job_orders_timesheets_REC['timesheet_id'];
		
			$qu_job_orders_timesheets_recs_sel = "SELECT * FROM  `job_orders_timesheets_recs` WHERE 
														((`timesheet_id` = $timesheet_id) AND ( `task_id` = $task_id))";
			$qu_job_orders_timesheets_recs_EXE = mysqli_query($KONN, $qu_job_orders_timesheets_recs_sel);
			if(mysqli_num_rows($qu_job_orders_timesheets_recs_EXE)){
				while($job_orders_timesheets_recs_REC = mysqli_fetch_assoc($qu_job_orders_timesheets_recs_EXE)){
					$regular_time = (double) $job_orders_timesheets_recs_REC['regular_time'];
					$ot_time      = (double) $job_orders_timesheets_recs_REC['ot_time'];
					$total_time   = (double) $job_orders_timesheets_recs_REC['total_time'];
					$RT = $RT + $regular_time;
					$OT = $OT + $ot_time;
					$TT = $TT + $total_time;
				
				
				
				}
			}

		
		}
	}
	
?>
			<tr class="task" id="task-<?=$task_id; ?>" task="<?=$task_id; ?>" activity="<?=$activity_id; ?>">
				<td colspan="2">&nbsp;</td>
				<td><?=$task_name; ?></td>
				<td class="l_rt"><?=$RT; ?></td>
				<td class="h_rt">0</td>
				<td class="l_ot"><?=$OT; ?></td>
				<td class="h_ot">0</td>
				<td class="l_tt"><?=$TT; ?></td>
				<td class="h_tt">0</td>
			</tr>
<?php
		}
	}
	//END -- TASK -----------------------------
?>
			
			
			
			
<?php
				}
			}
	//END -- ACT -----------------------------
?>

			
			
			
<?php
			}
		}
	//END -- PROCESS -----------------------------
?>



<?php


	//END -- JOB ORDER -----------------------------
		}
	}

?>
			</tbody>
		</table>
		
	</div>
	<div class="zero"></div>
</div>


			
<script>



$('.task').each( function(){
	var taskID = $(this).attr('task');
	var thsActivity = parseInt( $('#task-' + taskID).attr('activity') );
	var l_rt = parseFloat( $('#task-' + taskID + ' .l_rt').html() );
	var h_rt = parseFloat( $('#task-' + taskID + ' .h_rt').html() );
	var l_ot = parseFloat( $('#task-' + taskID + ' .l_ot').html() );
	var h_ot = parseFloat( $('#task-' + taskID + ' .h_ot').html() );
	var l_tt = parseFloat( $('#task-' + taskID + ' .l_tt').html() );
	var h_tt = parseFloat( $('#task-' + taskID + ' .h_tt').html() );
	
	
	//get activity totals
	var a_l_rt = parseFloat( $('#activity-' + thsActivity + ' .l_rt').html() );
	var a_h_rt = parseFloat( $('#activity-' + thsActivity + ' .h_rt').html() );
	var a_l_ot = parseFloat( $('#activity-' + thsActivity + ' .l_ot').html() );
	var a_h_ot = parseFloat( $('#activity-' + thsActivity + ' .h_ot').html() );
	var a_l_tt = parseFloat( $('#activity-' + thsActivity + ' .l_tt').html() );
	var a_h_tt = parseFloat( $('#activity-' + thsActivity + ' .h_tt').html() );
	
	$('#activity-' + thsActivity + ' .l_rt').html( l_rt + a_l_rt );
	$('#activity-' + thsActivity + ' .h_rt').html( h_rt + a_h_rt );
	$('#activity-' + thsActivity + ' .l_ot').html( l_ot + a_l_ot );
	$('#activity-' + thsActivity + ' .h_ot').html( h_ot + a_h_ot );
	$('#activity-' + thsActivity + ' .l_tt').html( l_tt + a_l_tt );
	$('#activity-' + thsActivity + ' .h_tt').html( h_tt + a_h_tt );
} );








$('.activity').each( function(){
	var activityID = $(this).attr('activity');
	var thsProcess = parseInt( $('#activity-' + activityID).attr('process') );
	console.log( thsProcess );
	var l_rt = parseFloat( $('#activity-' + activityID + ' .l_rt').html() );
	var h_rt = parseFloat( $('#activity-' + activityID + ' .h_rt').html() );
	var l_ot = parseFloat( $('#activity-' + activityID + ' .l_ot').html() );
	var h_ot = parseFloat( $('#activity-' + activityID + ' .h_ot').html() );
	var l_tt = parseFloat( $('#activity-' + activityID + ' .l_tt').html() );
	var h_tt = parseFloat( $('#activity-' + activityID + ' .h_tt').html() );
	
	
	//get process totals
	var a_l_rt = parseFloat( $('#process-' + thsProcess + ' .l_rt').html() );
	var a_h_rt = parseFloat( $('#process-' + thsProcess + ' .h_rt').html() );
	var a_l_ot = parseFloat( $('#process-' + thsProcess + ' .l_ot').html() );
	var a_h_ot = parseFloat( $('#process-' + thsProcess + ' .h_ot').html() );
	var a_l_tt = parseFloat( $('#process-' + thsProcess + ' .l_tt').html() );
	var a_h_tt = parseFloat( $('#process-' + thsProcess + ' .h_tt').html() );
	
	$('#process-' + thsProcess + ' .l_rt').html( l_rt + a_l_rt );
	$('#process-' + thsProcess + ' .h_rt').html( h_rt + a_h_rt );
	$('#process-' + thsProcess + ' .l_ot').html( l_ot + a_l_ot );
	$('#process-' + thsProcess + ' .h_ot').html( h_ot + a_h_ot );
	$('#process-' + thsProcess + ' .l_tt').html( l_tt + a_l_tt );
	$('#process-' + thsProcess + ' .h_tt').html( h_tt + a_h_tt );
	
	
} );





$('.process').each( function(){
	var processID = $(this).attr('process');
	var thsJob = parseInt( $('#process-' + processID).attr('job') );
	var l_rt = parseFloat( $('#process-' + processID + ' .l_rt').html() );
	var h_rt = parseFloat( $('#process-' + processID + ' .h_rt').html() );
	var l_ot = parseFloat( $('#process-' + processID + ' .l_ot').html() );
	var h_ot = parseFloat( $('#process-' + processID + ' .h_ot').html() );
	var l_tt = parseFloat( $('#process-' + processID + ' .l_tt').html() );
	var h_tt = parseFloat( $('#process-' + processID + ' .h_tt').html() );
	
	
	//get job totals
	var a_l_rt = parseFloat( $('#job-' + thsJob + ' .l_rt').html() );
	var a_h_rt = parseFloat( $('#job-' + thsJob + ' .h_rt').html() );
	var a_l_ot = parseFloat( $('#job-' + thsJob + ' .l_ot').html() );
	var a_h_ot = parseFloat( $('#job-' + thsJob + ' .h_ot').html() );
	var a_l_tt = parseFloat( $('#job-' + thsJob + ' .l_tt').html() );
	var a_h_tt = parseFloat( $('#job-' + thsJob + ' .h_tt').html() );
	
	$('#job-' + thsJob + ' .l_rt').html( l_rt + a_l_rt );
	$('#job-' + thsJob + ' .h_rt').html( h_rt + a_h_rt );
	$('#job-' + thsJob + ' .l_ot').html( l_ot + a_l_ot );
	$('#job-' + thsJob + ' .h_ot').html( h_ot + a_h_ot );
	$('#job-' + thsJob + ' .l_tt').html( l_tt + a_l_tt );
	$('#job-' + thsJob + ' .h_tt').html( h_tt + a_h_tt );
	
	
} );

var activeJO = 0;
var activeProject = 0;
var joStatus = '';

function showJoDetails( projID, joID, joRef , detailsView ){
	joID = parseInt( joID );
	projID = parseInt( projID );
	
	$('#new-project_id').val( projID );
	$('#new-act-project_id').val( projID );
	$('#new-task-project_id').val( projID );
	
	$('#jo_items').html('');
	$('#rfq_supps').html('');
	$('#rfqSups').html('');
	$('#rfq_lists').html('');
	$('#addNewReqItemBtn').css('display', 'inline-block');
	
	
	joStatus = $('#joStatus-' + joID).html();
	set_tabber(1);
	activeJO      = joID;
	activeProject = projID;
	loadDetails( projID, joID, detailsView, joRef );
}
function loadDetails( projID, joID, detailsView, joRef ){
	start_loader("Loading Job Order Details...");
	$.ajax({
		url      :"<?=api_root; ?>job_orders/get_details.php",
		data     :{ 'job_order_id': joID },
		dataType :"json",
		type     :'POST',
		success  :function( response ){
				end_loader();
$('#' + detailsView + ' .job_order_id').val(response[0].job_order_id);
$('#' + detailsView + ' .created_date').val(response[0].created_date);
$('#' + detailsView + ' .job_order_type').val(response[0].job_order_type);

$('#' + detailsView + ' .project_manager').val(response[0].project_manager);
$('#' + detailsView + ' .job_order_ref').val(response[0].job_order_ref);
$('#' + detailsView + ' .job_order_type').val(response[0].job_order_type);

var job_order_id = parseInt( response[0].job_order_id );
if( job_order_id != 0 ){
	$('#' + detailsView + ' .job_order_id').val(response[0].job_order_ref);
	$('#' + detailsView + ' .project_no').val(response[0].project_name + ' - ' + response[0].job_order_type);
} else {
	$('#' + detailsView + ' .job_order_id').val("NA");
	$('#' + detailsView + ' .project_no').val("NA");
}

$('#' + detailsView + ' .job_order_status').val(response[0].job_order_status);
$('#' + detailsView + ' .job_order_notes').val(response[0].job_order_notes);
$('#' + detailsView + ' .created_by').val(response[0].created_by_name);
			//load items
			
			show_details(detailsView, joRef);
			
			if( joStatus != 'draft' ){
				$('#addNewReqItemBtn').css('display', 'none');
			}
				
			loadProcesses();
			
			},
		error    :function(){
				end_loader();
			alert('Data Error No: 5467653');
			},
		});
	
}




function loadProcesses(){
	start_loader('Loading Processes...');
	$.ajax({
		url      :"<?=api_root; ?>projects/processes/get_processes.php",
		data     :{ 'project_id': activeProject },
		dataType :"json",
		type     :'POST',
		success  :function( response ){
				end_loader();
				$('#new-act-process_id').html('');
				$('#new-task-process_id').html('');
				$('#new-act-process_id').append('<option value="0">Please Select</option>');
				$('#new-task-process_id').append('<option value="0">Please Select</option>');
				$('#jo_processes').html('');
				//load items
				var cc = 0;
				for( i=0 ; i < response.length ; i ++ ){
					cc++;
					var process_id    = parseInt( response[i].process_id );
					if( process_id != 0 ){
						
						var process_name       = response[i].process_name;
						
						var tr = '' + 
								'<tr id="process-' + process_id + '">' + 
								'	<td><i title="Delete this item" onclick="delProcess(' + process_id + ');" class="fas fa-trash"></i></td>' + 
								'	<td>' + cc + '</td>' + 
								'	<td>' + process_name + '</td>' + 
								'</tr>';
						$('#new-act-process_id').append('<option value="' + process_id + '">' + process_name + '</option>');
						$('#new-task-process_id').append('<option value="' + process_id + '">' + process_name + '</option>');
						$('#jo_processes').append(tr);
					}
				}
			
			},
		error    :function(){
				end_loader();
			alert('Data Error No: 5467653');
			},
		});
	
}
function delProcess( processId ){
	
	processId = parseInt( processId );
	if( processId != 0 ){
		var aa = confirm( 'Are you sure, this action cannot be undo ?' );
		if( aa == true ){
			
			start_loader('Deleting Process...');
		$.ajax({
			url      :"<?=api_root; ?>projects/processes/del_process.php",
			data     :{ 'process_id': processId },
			dataType :"html",
			type     :'POST',
			success  :function(data){
					end_loader();
					var aa = data.split('|');
					res = parseInt( aa[0] );
					if( res == 1 ){
						$('#process-' + processId).remove();
					} else {
						alert('Error deleting item - ' + aa[1]);
					}
					
				},
			error    :function(){
					end_loader();
				alert('Data Error No: 5467653');
				},
			});
		}
	}
	
}





function loadActivities(){
	start_loader('Loading Activities...');
	$.ajax({
		url      :"<?=api_root; ?>projects/activities/get_activities.php",
		data     :{ 'project_id': activeProject },
		dataType :"json",
		type     :'POST',
		success  :function( response ){
				end_loader();
				$('#jo_activities').html('');
			//load items
			var cc = 0;
			for( i=0 ; i < response.length ; i ++ ){
				cc++;
				var activity_id    = parseInt( response[i].activity_id );
				if( activity_id != 0 ){
					
					var activity_name       = response[i].activity_name;
					var process_name        = response[i].process_name;
					
					
					var tr = '' + 
							'<tr id="activity-' + activity_id + '">' + 
							'	<td><i title="Delete this item" onclick="delActivity(' + activity_id + ');" class="fas fa-trash"></i></td>' + 
							'	<td>' + cc + '</td>' + 
							'	<td>' + activity_name + '</td>' + 
							'	<td>' + process_name + '</td>' + 
							'</tr>';
							
					$('#jo_activities').append(tr);
				}
			}
			
			},
		error    :function(){
				end_loader();
			alert('Data Error No: 5467653');
			},
		});
	
}
function delActivity( activityId ){
	
	activityId = parseInt( activityId );
	if( activityId != 0 ){
		var aa = confirm( 'Are you sure, this action cannot be undo ?' );
		if( aa == true ){
			
			start_loader('Deleting Activity...');
		$.ajax({
			url      :"<?=api_root; ?>projects/activities/del_activity.php",
			data     :{ 'activity_id': activityId },
			dataType :"html",
			type     :'POST',
			success  :function(data){
					end_loader();
					var aa = data.split('|');
					res = parseInt( aa[0] );
					if( res == 1 ){
						$('#activity-' + activityId).remove();
					} else {
						alert('Error deleting item - ' + aa[1]);
					}
					
				},
			error    :function(){
					end_loader();
				alert('Data Error No: 5467653');
				},
			});
		}
	}
}














function loadTasks(){
	start_loader('Loading Tasks...');
	$.ajax({
		url      :"<?=api_root; ?>projects/tasks/get_tasks.php",
		data     :{ 'project_id': activeProject },
		dataType :"json",
		type     :'POST',
		success  :function( response ){
				end_loader();
				$('#jo_tasks').html('');
			//load items
			var cc = 0;
			for( i=0 ; i < response.length ; i ++ ){
				cc++;
				var task_id    = parseInt( response[i].task_id );
				if( task_id != 0 ){
					
					var task_name           = response[i].task_name;
					var process_name        = response[i].process_name;
					var activity_name       = response[i].activity_name;
					
					
					var tr = '' + 
							'<tr id="task-' + task_id + '">' + 
							'	<td><i title="Delete this item" onclick="delTask(' + task_id + ');" class="fas fa-trash"></i></td>' + 
							'	<td>' + cc + '</td>' + 
							'	<td>' + task_name + '</td>' + 
							'	<td>' + activity_name + '</td>' + 
							'	<td>' + process_name + '</td>' + 
							'</tr>';
					$('#jo_tasks').append(tr);
				}
			}
			
			},
		error    :function(){
				end_loader();
			alert('Data Error No: 5467653');
			},
		});
	
}
function delTask( taskId ){
	
	taskId = parseInt( taskId );
	if( taskId != 0 ){
		var aa = confirm( 'Are you sure, this action cannot be undo ?' );
		if( aa == true ){
			
			start_loader('Deleting Task...');
		$.ajax({
			url      :"<?=api_root; ?>projects/tasks/del_task.php",
			data     :{ 'task_id': taskId },
			dataType :"html",
			type     :'POST',
			success  :function(data){
					end_loader();
					var aa = data.split('|');
					res = parseInt( aa[0] );
					if( res == 1 ){
						$('#task-' + taskId).remove();
					} else {
						alert('Error deleting item - ' + aa[1]);
					}
					
				},
			error    :function(){
					end_loader();
				alert('Data Error No: 5467653');
				},
			});
		}
	}
}

</script>





<!--    ///////////////////      View REQ details VIEW START    ///////////////////            -->
<div class="DetailsViewer" id="viewJoDetails">
	<div class="viewerContainer">
		<div class="viewerHeader">
			<img src="<?=uploads_root; ?>/logo_icon.png" />
			<h1>REFREFREF</h1>
			<i onclick="hide_details('viewJoDetails');" class="fas fa-times"></i>
		</div>
		<div class="viewerBody">
			
			<div class="row col-33">
				<div class="nwFormGroup">
					<label><?=lang("job_order", "AAR"); ?></label>
					<input type="text" class="job_order_id readOnly">
				</div>
				<div class="nwFormGroup">
					<label><?=lang("Project_Name", "AAR"); ?></label>
					<input type="text" class="project_no readOnly">
				</div>
			</div>
			
			<div class="row col-33">
				<div class="nwFormGroup">
					<label><?=lang("job_order_type", "AAR"); ?></label>
					<input type="text" class="job_order_type readOnly">
				</div>
				<div class="nwFormGroup">
					<label><?=lang("Project_Manager", "AAR"); ?></label>
					<input type="text" class="project_manager important">
				</div>
			</div>
			
			<div class="row col-33">
				<div class="nwFormGroup">
					<label><?=lang("created_by", "AAR"); ?></label>
					<input type="text" class="created_by important">
				</div>
				<div class="nwFormGroup">
					<label><?=lang("Created_date", "AAR"); ?></label>
					<input type="text" class="created_date important">
				</div>
			</div>
			<div class="zero"></div>
			
			<div class="tabs">
				<div class="tabsHeader">
					<div onclick="set_tabber(1);loadProcesses();" class="tabsIdSel-1 activeHeaderTab"><?=lang("Processes", "AAR"); ?></div>
					<div onclick="set_tabber(2);loadActivities();" class="tabsIdSel-2"><?=lang("Activities", "AAR"); ?></div>
					<div onclick="set_tabber(3);loadTasks();" class="tabsIdSel-3"><?=lang("Tasks", "AAR"); ?></div>
					<div onclick="set_tabber(250);fetch_item_status(activeJO, 'job_orders');" class="tabsIdSel-250"><?=lang("Status_Change", "AAR"); ?></div>
				</div>
				<div class="tabsId-1 tabsBody tabsBodyActive">
					<table class="tabler" border="1">
						<thead>
							<tr>
								<th style="width:5%;">---</th>
								<th style="width:5%;"><?=lang("NO", "AAR"); ?></th>
								<th style="width:50%;"><?=lang("Process", "AAR"); ?></th>
								<!--th><?=lang("WL", "AAR"); ?></th>
								<th><?=lang("UOM", "AAR"); ?></th>
								<th><?=lang("Weightage", "AAR"); ?></th>
								<th><?=lang("Budget", "AAR"); ?></th>
								<th><?=lang("ManHour", "AAR"); ?></th-->
							</tr>
						</thead>
						<tbody id="jo_processes"></tbody>
					</table>
					<div class="viewerBodyButtons">
					</div>
				</div>
				<div class="tabsId-2 tabsBody">
					<table class="tabler" border="1">
						<thead>
							<tr>
								<th style="width:5%;">---</th>
								<th style="width:5%;"><?=lang("NO", "AAR"); ?></th>
								<th style="width:30%;"><?=lang("Activity", "AAR"); ?></th>
								<th style="width:30%;"><?=lang("Process", "AAR"); ?></th>
							</tr>
						</thead>
						<tbody id="jo_activities"></tbody>
					</table>
					<div class="viewerBodyButtons">
					</div>
				</div>
				<div class="tabsId-3 tabsBody">
					<table class="tabler" border="1">
						<thead>
							<tr>
								<th style="width:5%;">---</th>
								<th style="width:5%;"><?=lang("NO", "AAR"); ?></th>
								<th style="width:50%;"><?=lang("Task", "AAR"); ?></th>
								<th style="width:30%;"><?=lang("Activity", "AAR"); ?></th>
								<th style="width:30%;"><?=lang("Process", "AAR"); ?></th>
							</tr>
						</thead>
						<tbody id="jo_tasks"></tbody>
					</table>
					<div class="viewerBodyButtons">
					</div>
				</div>
				
				<div class="tabsId-250 tabsBody" id="fetched_status_change"></div>
			</div>
			
			
			<div class="viewerBodyButtons">
				<button id="addNewProcessBtn" type="button" onclick="show_details('NewProcessDetails', 'Add_New_Process');"><?=lang("Add_Process", "AAR"); ?></button>
				<button id="addNewActivityBtn" type="button" onclick="loadProcesses();show_details('NewActivityDetails', 'Add_New_Activity');"><?=lang("Add_Activity", "AAR"); ?></button>
				<button id="addNewTaskBtn" type="button" onclick="loadProcesses();show_details('NewTaskDetails', 'Add_New_Item');"><?=lang("Add_Task", "AAR"); ?></button>
				<button type="button" onclick="hide_details('viewJoDetails');"><?=lang("close", "AAR"); ?></button>
			</div>
			
			
		</div>
	</div>
</div>
<!--    ///////////////////      View REQ details VIEW END     ///////////////////            -->



<!--    ///////////////////      NewTaskDetails VIEW START    ///////////////////            -->
<div class="DetailsViewer ViewerOnTop" id="NewTaskDetails">
	<div class="viewerContainer">
		<div class="viewerHeader">
			<img src="<?=uploads_root; ?>/logo_icon.png" />
			<h1>REFREFREF</h1>
			<i onclick="hide_details('NewTaskDetails');" class="fas fa-times"></i>
		</div>
		<div class="viewerBody">
			<?php include('../forms/projects/tasks/add_new.php'); ?>
		</div>
	</div>
</div>
<!--    ///////////////////      NewTaskDetails VIEW END    ///////////////////            -->


<!--    ///////////////////      NewActivityDetails VIEW START    ///////////////////            -->
<div class="DetailsViewer ViewerOnTop" id="NewActivityDetails">
	<div class="viewerContainer">
		<div class="viewerHeader">
			<img src="<?=uploads_root; ?>/logo_icon.png" />
			<h1>REFREFREF</h1>
			<i onclick="hide_details('NewActivityDetails');" class="fas fa-times"></i>
		</div>
		<div class="viewerBody">
			<?php include('../forms/projects/activities/add_new.php'); ?>
		</div>
	</div>
</div>
<!--    ///////////////////      NewActivityDetails VIEW END    ///////////////////            -->






<!--    ///////////////////      NewProcessDetails VIEW START    ///////////////////            -->
<div class="DetailsViewer ViewerOnTop" id="NewProcessDetails">
	<div class="viewerContainer">
		<div class="viewerHeader">
			<img src="<?=uploads_root; ?>/logo_icon.png" />
			<h1>REFREFREF</h1>
			<i onclick="hide_details('NewProcessDetails');" class="fas fa-times"></i>
		</div>
		<div class="viewerBody">
			<?php include('../forms/projects/processes/add_new.php'); ?>
		</div>
	</div>
</div>
<!--    ///////////////////      NewProcessDetails VIEW END    ///////////////////            -->





<?php
	//PAGE DATA END   ----------------------------------------------///---------------------------------
	include('app/footer.php');
?>
<script>
init_nwFormGroup();
</script>

</body>
</html>
<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	
	$menuId = 1;
	$subPageID = 2;
	
	
	
	
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
		
		<table id="dataTable" class="tabler" border="2">
			<thead>
				<tr>
					<th><a href="labours_timesheets_new.php" class="text-danger"><?=lang("Add New", "AAR"); ?></a></th>
					<th><?=lang("TS_Date", "AAR"); ?></th>
					<th><?=lang("Prep.<br>By", "AAR"); ?></th>
					<th><?=lang("Rev.<br>By", "AAR"); ?></th>
					<th><?=lang("App.<br>By", "AAR"); ?></th>
					<th><?=lang("Job_Order", "AAR"); ?></th>
					<th style="width: 30%;"><?=lang("Project", "AAR"); ?></th>
					<th><?=lang("--", "AAR"); ?></th>
				</tr>
			</thead>
			<tbody>
<?php

	$JO_COND = "";
	if( $job_order_id != 0 ){
		$JO_COND = " ( `job_order_id` = '$job_order_id' ) ";
	}
	
	$FR_COND = "";
	if( $ts_date_from != "" ){
		$FR_COND = " ( `ts_date` >= '$ts_date_from' ) ";
	}
	
	$TO_COND = "";
	if( $ts_date_to != "" ){
		$TO_COND = " ( `ts_date` <= '$ts_date_to' ) ";
	}
	
	
	if( $JO_COND != "" ){
		$COND = $JO_COND;
	}
	
	
	if( $COND == "" && $FR_COND != "" ){
		$COND = $FR_COND;
	} else if( $COND != "" && $FR_COND != "" ){
		$COND = $COND." AND ".$FR_COND;
	}
	
	
	if( $COND == "" && $TO_COND != "" ){
		$COND = $TO_COND;
	} else if( $COND != "" && $TO_COND != "" ){
		$COND = $COND." AND ".$TO_COND;
	}
	
	
	if( $COND != "" ){
		$COND = " WHERE (".$COND.") LIMIT 30";
	}
	
	
	
	
	$sNo = 0;
	$qu_job_orders_timesheets_sel = "SELECT * FROM  `job_orders_timesheets` $COND ORDER BY `created_date` DESC";
	$qu_job_orders_timesheets_EXE = mysqli_query($KONN, $qu_job_orders_timesheets_sel);
	if(mysqli_num_rows($qu_job_orders_timesheets_EXE)){
		while($job_orders_timesheets_REC = mysqli_fetch_assoc($qu_job_orders_timesheets_EXE)){
			$sNo++;
		$timesheet_id = $job_orders_timesheets_REC['timesheet_id'];
		$job_order_idTHS = $job_orders_timesheets_REC['job_order_id'];
		$ts_date = $job_orders_timesheets_REC['ts_date'];
		$created_date = $job_orders_timesheets_REC['created_date'];
		$created_by = $job_orders_timesheets_REC['created_by'];
			
			
			
	$qu_job_orders_sel = "SELECT * FROM  `job_orders` WHERE `job_order_id` = $job_order_idTHS";
	$qu_job_orders_EXE = mysqli_query($KONN, $qu_job_orders_sel);
		$job_order_ref = "";
		$job_order_type = "";
		$job_order_status = "";
		$JOcreated_date = "";
		$JOcreated_by = "";
		
		$project_name = "";
		$job_order_type = "";
		$project_manager_id = "";
		$job_order_status = "";
		
	if(mysqli_num_rows($qu_job_orders_EXE)){
		$job_orders_DATA = mysqli_fetch_assoc($qu_job_orders_EXE);
	
		$job_order_ref = $job_orders_DATA['job_order_ref'];
		$job_order_type = $job_orders_DATA['job_order_type'];
		$job_order_status = $job_orders_DATA['job_order_status'];
		$JOcreated_date = $job_orders_DATA['created_date'];
		$JOcreated_by = $job_orders_DATA['created_by'];
		
		$project_name = $job_orders_DATA['project_name'];
		$job_order_type = $job_orders_DATA['job_order_type'];
		$project_manager_id = $job_orders_DATA['project_manager_id'];
		$job_order_status = $job_orders_DATA['job_order_status'];
	
		
		
		
		
		
		$project_manager = get_emp_name($KONN, $project_manager_id );
		
		$created_by_name = get_emp_name($KONN, $created_by );
		
		
		?>
			<tr id="ts-<?=$timesheet_id; ?>">
				<td>TS<?=date("y"); ?>-000<?=$timesheet_id; ?></td>
				<td><?=$created_date; ?></td>
				<td><?=$created_by_name; ?></td>
				<td><?=$created_by_name; ?></td>
				<td><?=$created_by_name; ?></td>
				<td><?=$job_order_ref; ?></td>
				<td><span class="text-primary"><?=$project_name; ?></span></td>
				<td>
					<a href="labours_timesheets_details.php?timesheet_id=<?=$timesheet_id; ?>" title="TS Details"><span id="projREF-<?=$timesheet_id; ?>" class="text-primary"><?=lang("Details", "ARR"); ?></span></a>
				</td>
			</tr>
		<?php
		
		
	}
		
		}
	}
?>
			</tbody>
		</table>
		
	</div>
	<div class="zero"></div>
</div>

<script>
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
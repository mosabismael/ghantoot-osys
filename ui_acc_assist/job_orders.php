<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	$pageID = 2;
	
	$menuId = 2;
	$subPageID = 6;
?>
<!DOCTYPE html>
<html dir="<?=$lang_dir; ?>" lang="<?=$lang; ?>">
<head>
	<?php include('app/meta.php'); ?>
    <?php include('app/assets.php'); ?>
</head>
<body>
<?php

	$WHERE = "job_orders";
	include('app/header.php');
	//PAGE DATA START -----------------------------------------------///---------------------------------
?>



<div class="row">
	<div class="col-100">
		
<a onclick="show_modal( 'add_new_modal', 'New Job Order' );" class="actionBtn"><button type="button"><i class="fas fa-plus"></i><?=lang("Add_New", "AAR"); ?></button></a>
<br>
		<table id="dataTable" class="tabler" border="2">
			<thead>
				<tr>
					<th><?=lang("NO.", "AAR"); ?></th>
					<th style="width: 30%;"><?=lang("REF", "AAR"); ?></th>
					<th><?=lang("Project_Name", "AAR"); ?></th>
					<th><?=lang("Type", "AAR"); ?></th>
					<th><?=lang("Created_date", "AAR"); ?></th>
					<th><?=lang("PM", "AAR"); ?></th>
					<th><?=lang("Status", "AAR"); ?></th>
				</tr>
			</thead>
			<tbody>
<?php
	$sNo = 0;
	$qu_job_orders_sel = "SELECT * FROM  `job_orders` ORDER BY `job_order_id` DESC";
	$qu_job_orders_EXE = mysqli_query($KONN, $qu_job_orders_sel);
	if(mysqli_num_rows($qu_job_orders_EXE)){
		while($job_orders_REC = mysqli_fetch_assoc($qu_job_orders_EXE)){
			$sNo++;
			
			$job_order_id = $job_orders_REC['job_order_id'];
			$job_order_ref = $job_orders_REC['job_order_ref'];
			$project_name = $job_orders_REC['project_name'];
			$job_order_type = $job_orders_REC['job_order_type'];
			$job_order_status = $job_orders_REC['job_order_status'];
			$created_date = $job_orders_REC['created_date'];
			$project_manager_id = $job_orders_REC['project_manager_id'];
		
		$project_manager = get_emp_name($KONN, $project_manager_id );
		
		
		?>
			<tr id="jo-<?=$job_order_id; ?>">
				<td><?=$sNo; ?></td>
				<td onclick="showJoDetails(<?=$job_order_id; ?>, '<?=$job_order_ref; ?>', 'viewJoDetails');"><span id="joREF-<?=$job_order_id; ?>" class="text-primary"><?=$job_order_ref; ?></span></td>
				<td><?=$project_name; ?></td>
				<td><?=$job_order_type; ?></td>
				<td><?=$created_date; ?></td>
				<td><?=$project_manager; ?></td>
				<td id="joStatus-<?=$job_order_id; ?>"><?=$job_order_status; ?></td>
			</tr>
		<?php
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
var joStatus = '';

function showJoDetails( joID, joRef , detailsView ){
	joID = parseInt( joID );
	$('#new-job_order_id').val(joID);
	$('#new-act-job_order_id').val(joID);
	$('#new-task-job_order_id').val(joID);
	
	$('#jo_items').html('');
	$('#rfq_supps').html('');
	$('#rfqSups').html('');
	$('#rfq_lists').html('');
	$('#addNewReqItemBtn').css('display', 'inline-block');
	
	
	joStatus = $('#joStatus-' + joID).html();
	set_tabber(1);
	activeJO = joID;
	loadDetails( joID, detailsView, joRef );
}
function loadDetails( joID, detailsView, joRef ){
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
		data     :{ 'job_order_id': activeJO },
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
		data     :{ 'job_order_id': activeJO },
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
		data     :{ 'job_order_id': activeJO },
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








<!--    ///////////////////      add_new_modal Modal START    ///////////////////            -->
<div class="modal" id="add_new_modal">
	<div class="modal-container">
		<div class="modal-header">
			<?php include("app/modal_header.php"); ?>
		</div>
		<div class="modal-body">
			<?php include('../forms/job_orders/add_new.php'); ?>
		</div>
	</div>
	<div class="zero"></div>
</div>
<!--    ///////////////////      add_new_modal Modal END    ///////////////////            -->



















<script>

$(document).ready(function(){
  $(".filterSearch").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    var TBL = $(this).attr('tbl-id');
    $("#" + TBL + " tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});









init_nwFormGroup();
</script>

</body>
</html>
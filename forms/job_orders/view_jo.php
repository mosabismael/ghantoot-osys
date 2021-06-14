
			<div class="row col-33">
				<div class="nwFormGroup">
					<label><?=lang("job_order", "AAR"); ?></label>
					<input type="text" class="job_order_id readOnly">
				</div>
				<div class="nwFormGroup">
					<label><?=lang("Project_Name", "AAR"); ?></label>
					<input type="text" class="project_no readOnly">
				</div>
				<div class="nwFormGroup">
					<label><?=lang("Project_Amount", "AAR"); ?></label>
					<input type="text" id="project_amount_edited" class="project_amount">
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
				<div class="nwFormGroup">
					<div class="viewerBodyButtons">
						<button type="button" onclick="saveAmount();"><?=lang("Save_Amount", "AAR"); ?></button>
					</div>
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
				<div class="nwFormGroup">
					<label><?=lang("Contract", "AAR"); ?></label>
					<label><a id="view_attach" href="" target="_blank"><?=lang("View", "AAR"); ?></a></label>
				</div>
			</div>
			
			<div class="zero"></div>
			
			<div class="tabs">
				<div class="tabsHeader">
					<div onclick="set_tabber(1);loadProcesses();" class="tabsIdSel-1 activeHeaderTab"><?=lang("Processes", "AAR"); ?></div>
					<div onclick="set_tabber(2);loadActivities();" class="tabsIdSel-2"><?=lang("Activities", "AAR"); ?></div>
					<div onclick="set_tabber(3);loadTasks();" class="tabsIdSel-3"><?=lang("Tasks", "AAR"); ?></div>
					<div onclick="set_tabber(5);loadBilling();" class="tabsIdSel-5"><?=lang("Billing", "AAR"); ?></div>
					<div onclick="set_tabber(250);fetch_item_status(activeJO, 'job_orders');" class="tabsIdSel-250"><?=lang("Status_Change", "AAR"); ?></div>
				</div>
				<div class="tabsId-5 tabsBody">
					<table class="tabler" border="1">
						<thead>
							<tr>
								<th style="width:5%;">---</th>
								<th style="width:5%;"><?=lang("Percentage", "AAR"); ?></th>
								<th style="width:30%;"><?=lang("Term", "AAR"); ?></th>
							</tr>
						</thead>
						<tbody id="jo_bills">
							<tr style="text-align:center;" id="added_bill_rows">
								<td colspan="3"><br></td>
							</tr>
							<tr style="text-align:center;">
								<td><!--i title="Delete this item" onclick="delProcess(10);" class="fas fa-trash"></i--></td>
								<td><input type="text" id="inputBillPercentage"></td>
								<td>
									<select id="record_term_id" class="frmData">
				<option value="0" selected><?=lang('Please_Select', 'AA', 1); ?></option>
<?php
	$qu_job_orders_billing_terms_recs_sel = "SELECT * FROM  `job_orders_billing_terms_recs`;";
	$qu_job_orders_billing_terms_recs_EXE = mysqli_query($KONN, $qu_job_orders_billing_terms_recs_sel);
	if(mysqli_num_rows($qu_job_orders_billing_terms_recs_EXE)){
		while($job_orders_billing_terms_recs_REC = mysqli_fetch_assoc($qu_job_orders_billing_terms_recs_EXE)){
		$record_term_id = $job_orders_billing_terms_recs_REC['record_term_id'];
		$namer = $job_orders_billing_terms_recs_REC['record_term'];
		?>
				<option value="<?=$record_term_id; ?>"><?=$namer; ?></option>
		<?php
		}
	}
?>
									</select>
								</td>
							</tr>
							<tr class="viewerBodyButtons">
								<td colspan="4"><button onclick="addBillingTerm();" type="button"><?=lang("Add", "AAR"); ?></button></td>
							</tr>
						</tbody>
					</table>
					<div class="viewerBodyButtons">
					</div>
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


<script>
var activeJO = 0;
var joStatus = '';


function addBillingTerm(){
	var inputBillPercentage = parseFloat( $('#inputBillPercentage').val() );
	var record_term_id = parseInt( $('#record_term_id').val() );
	
	
	if( inputBillPercentage != 0 && record_term_id != 0 && activeJO != 0 ){
		
		start_loader('Saving Billing Record...');
		$.ajax({
			url      :"<?=api_root; ?>job_orders/insert_bill_record.php",
			data     :{ 'job_order_id': activeJO, 'inputBillPercentage': inputBillPercentage, 'record_term_id': record_term_id },
			dataType :"html",
			type     :'POST',
			success  :function(data){
					end_loader();
					var aa = data.split('|');
					res = parseInt( aa[0] );
					if( res == 1 ){
						loadBilling();
					} else {
						alert('Error - ' + aa[1]);
					}
					
				},
			error    :function(){
					end_loader();
				alert('Data Error No: 5467653');
				},
			});
			
	}
	
	
}

function loadBilling(){
	
	start_loader('Loading Billing...');
	$('.insertedTerms').remove();
	$.ajax({
		url      :"<?=api_root; ?>job_orders/get_billing.php",
		data     :{ 'job_order_id': activeJO },
		dataType :"json",
		type     :'POST',
		success  :function( response ){
				end_loader();
				$('#inputBillPercentage').val('');
				$('#record_term_id').val(0);
				//load items
				var cc = 0;
				for( i=0 ; i < response.length ; i ++ ){
					cc++;
					var record_id    = parseInt( response[i].record_id );
					if( record_id != 0 ){
						
						var record_term       = response[i].record_term;
						var record_percentage = response[i].record_percentage;
						
						var tr = '' + 
								'<tr class="insertedTerms" id="bill-' + record_id + '">' + 
								'	<td>---</td>' + 
								'	<td>' + record_percentage + '</td>' + 
								'	<td>' + record_term + '</td>' + 
								'</tr>';
						$('#added_bill_rows').before(tr);
					}
				}
			
			},
		error    :function(){
				end_loader();
			alert('Data Error No: 5467653');
			},
		});
		
}






function saveAmount(){
	var amm = parseFloat( $('#project_amount_edited').val() );
	if( amm != 0 && activeJO != 0 ){
		start_loader('Saving Job Order...');
		$.ajax({
			url      :"<?=api_root; ?>job_orders/project_amount_edited.php",
			data     :{ 'job_order_id': activeJO, 'project_amount': amm },
			dataType :"html",
			type     :'POST',
			success  :function(data){
					end_loader();
					var aa = data.split('|');
					res = parseInt( aa[0] );
					if( res == 1 ){
						alert('Amount Saved');
					} else {
						alert('Error - ' + aa[1]);
					}
					
				},
			error    :function(){
					end_loader();
				alert('Data Error No: 5467653');
				},
			});
	}
	
}

function delJobOrder( JO_ID ){
	
	var aa = confirm( 'Are you sure, this action cannot be undo ?' );
	if( aa == true ){
		
		start_loader('Deleting Job Order...');
	$.ajax({
		url      :"<?=api_root; ?>job_orders/del_jorder.php",
		data     :{ 'job_order_id': JO_ID },
		dataType :"html",
		type     :'POST',
		success  :function(data){
				end_loader();
				var aa = data.split('|');
				res = parseInt( aa[0] );
				if( res == 1 ){
					$('#jo-' + JO_ID).remove();
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

function showJoDetails( joID, joRef , detailsView ){
	joID = parseInt( joID );
	$('#new-job_order_id').val(joID);
	$('#new-act-job_order_id').val(joID);
	$('#new-task-job_order_id').val(joID);
	
	$('#jo_items').html('');
	$('#rfq_supps').html('');
	$('#rfqSups').html('');
	$('#rfq_lists').html('');
	$('#view_attach').attr('href', '');
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
$('#' + detailsView + ' .project_amount').val(response[0].project_amount);

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

	$('#view_attach').attr('href', '../uploads/' + response[0].contract_attach);
	
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



<div class="row">
	<div class="col-100">
<form 
id="add-new-task-form" 
id-modal="add_new_requisition_item" 
id-details="NewTaskDetails" 
api="<?=api_root; ?>projects/tasks/add_new_task.php">

<input class="frmData" type="hidden" 
		id="new-task-job_order_id" 
		name="job_order_id" 
		value="" 
		req="1" 
		den="0" 
		alerter="<?=lang("Please_Check_job_order_id", "AAR"); ?>">

	<div class="zero"></div>

	<div class="col-100">
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('Process', 'ARR', 1); ?></label>
		<select class="frmData" 
				id="new-task-process_id" 
				name="process_id" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_Process", "AAR"); ?>">
		</select>
	</div>
	</div>

	<div class="col-100">
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('Activity', 'ARR', 1); ?></label>
		<select class="frmData" 
				id="new-task-activity_id" 
				name="activity_id" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_Activities", "AAR"); ?>">
		</select>
	</div>
	</div>

	<div class="col-100">
		<div class="nwFormGroup">
			<label class="lbl_class"><?=lang('Task_Name', 'ARR', 1); ?></label>
			<input class="frmData" type="text" 
					id="new-task_name" 
					name="task_name" 
					req="1" 
					den="" 
					alerter="<?=lang("Please_Check_task_name", "AAR"); ?>">
		</div>
	</div>

	<div class="zero"></div>
	<br>
	<br>
	<br>
	<div class="form-alerts"></div>
	<div class="zero"></div>

	<div class="col-100">
		<div class="viewerBodyButtons text-center">
			<button type="button" onclick="submit_form('add-new-task-form', 'close_details');">
				<?=lang('Add', 'ARR', 1); ?>
			</button>
			<button type="button" onclick="hide_details('NewTaskDetails');">
				<?=lang("Cancel", "AAR"); ?>
			</button>

		</div>
	</div>

	<div class="zero"></div>
</form>
		
		
	</div>
	<div class="zero"></div>
</div>

<script>
function change_process(){
	var dataID = parseInt( $('#new-task-process_id').val() );
	if( dataID != 0 ){
		$.ajax({
		url      :"<?=api_root; ?>projects/processes/get_activities.php",
		data     :{ 'data_id': dataID },
		dataType :"html",
		type     :'POST',
		success  :function(data){
			$('#new-task-activity_id').html(data);
			},
		error    :function(){
			alert('Data Error No: 5467653');
			},
		});
	}
}
$('#new-task-process_id').on( 'change', function(){
	change_process();
} );
</script>
<div class="row">
	<div class="col-100">
<form 
id="add-new-activity-form" 
id-modal="add_new_requisition_item" 
id-details="NewActivityDetails" 
api="<?=api_root; ?>projects/activities/add_new_activity.php">

<input class="frmData" type="hidden" 
		id="new-act-job_order_id" 
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
				id="new-act-process_id" 
				name="process_id" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_Process", "AAR"); ?>">
		</select>
	</div>
	</div>

	<div class="col-100">
		<div class="nwFormGroup">
			<label class="lbl_class"><?=lang('Activity_Name', 'ARR', 1); ?></label>
			<input class="frmData" type="text" 
					id="new-activity_name" 
					name="activity_name" 
					req="1" 
					den="" 
					alerter="<?=lang("Please_Check_activity_name", "AAR"); ?>">
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
			<button type="button" onclick="submit_form('add-new-activity-form', 'close_details');">
				<?=lang('Add', 'ARR', 1); ?>
			</button>
			<button type="button" onclick="hide_details('NewActivityDetails');">
				<?=lang("Cancel", "AAR"); ?>
			</button>

		</div>
	</div>

	<div class="zero"></div>
</form>
		
		
	</div>
	<div class="zero"></div>
</div>

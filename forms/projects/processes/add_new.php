<div class="row">
	<div class="col-100">
<form 
id="add-new-process-form" 
id-modal="add_new_requisition_item" 
id-details="NewProcessDetails" 
api="<?=api_root; ?>projects/processes/add_new_process.php">

<input class="frmData" type="hidden" 
		id="new-job_order_id" 
		name="job_order_id" 
		value="" 
		req="1" 
		den="0" 
		alerter="<?=lang("Please_Check_job_order_id", "AAR"); ?>">

	<div class="zero"></div>

	<div class="col-100">
		<div class="nwFormGroup">
			<label class="lbl_class"><?=lang('Process_Name', 'ARR', 1); ?></label>
			<input class="frmData" type="text" 
					id="new-process_name" 
					name="process_name" 
					req="1" 
					den="" 
					alerter="<?=lang("Please_Check_process_name", "AAR"); ?>">
		</div>
	</div>

	<div class="col-100">
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('Group', 'ARR', 1); ?></label>
		<select class="frmData" 
				id="new-pro-gruop_id" 
				name="gruop_id" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_Group", "AAR"); ?>">
		</select>
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
			<button type="button" onclick="submit_form('add-new-process-form', 'close_details');">
				<?=lang('Add', 'ARR', 1); ?>
			</button>
			<button type="button" onclick="hide_details('NewProcessDetails');">
				<?=lang("Cancel", "AAR"); ?>
			</button>

		</div>
	</div>

	<div class="zero"></div>
</form>
		
		
	</div>
	<div class="zero"></div>
</div>

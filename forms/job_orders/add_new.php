
				<form 
				id="add-new-form" 
				class="boxes-holder" 
				api="<?=api_root; ?>job_orders/add_new.php">
				
		<input  class="frmData" 
				type="hidden"
				id="new-job_order_status" 
				name="job_order_status" 
				value="active"
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_job_order_status", "AAR"); ?>">
				

<div class="col-50">
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('job_order_ref', 'ARR', 1); ?></label>
		<input  class="frmData" 
				type="text"
				id="new-job_order_ref" 
				name="job_order_ref" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_job_order_ref", "AAR"); ?>">
	</div>
</div>



<div class="col-50">
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('job_order_type', 'ARR', 1); ?></label>
		<select class="frmData" 
				id="new-job_order_type" 
				name="job_order_type" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_job_order_type", "AAR"); ?>">
				<option value="0" selected><?=lang("Please_Select", "غير محدد"); ?></option>
				<option value="marine"><?=lang("Marine", "AAR"); ?></option>
				<option value="steel"><?=lang("Steel", "AAR"); ?></option>
				<option value="gomi_yard"><?=lang("Gomi Yard", "AAR"); ?></option>
			</select>
	</div>
</div>

	<div class="zero"></div>

<div class="col-50">
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('Project_Manager', 'ARR', 1); ?></label>
		<select class="frmData" 
				id="new-project_manager_id" 
				name="project_manager_id" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_job_order_type", "AAR"); ?>">
				<option value="0" selected><?=lang("Please_Select", "غير محدد"); ?></option>
<?php
	$qu_hr_employees_sel = "SELECT `employee_id`, `employee_code`, `first_name`, `last_name` FROM  `hr_employees` WHERE `designation_id` = '13';";
	$qu_hr_employees_EXE = mysqli_query($KONN, $qu_hr_employees_sel);
	if(mysqli_num_rows($qu_hr_employees_EXE)){
		while($hr_employees_REC = mysqli_fetch_assoc($qu_hr_employees_EXE)){
		$employee_id = $hr_employees_REC['employee_id'];
		$namer = $hr_employees_REC['employee_code']."- ".$hr_employees_REC['first_name']." ".$hr_employees_REC['last_name'];
		?>
				<option value="<?=$employee_id; ?>"><?=$namer; ?></option>
		<?php
		}
	}
?>
			</select>
	</div>
</div>



<div class="col-50">
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('project_name', 'ARR', 1); ?></label>
		<input  class="frmData" 
				type="text"
				id="new-project_name" 
				name="project_name" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_project_name", "AAR"); ?>">
	</div>
</div>




	<div class="zero"></div>


<div class="col-50">
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('project_amount', 'ARR', 1); ?></label>
		<input  class="frmData" 
				type="text"
				id="new-project_amount" 
				name="project_amount" 
				req="1" 
				value="0" 
				den="" 
				alerter="<?=lang("Please_Check_project_amount", "AAR"); ?>">
	</div>
</div>


<div class="col-50">
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('client_name', 'ARR', 1); ?></label>
		<select class="frmData" 
				id="new-client_id" 
				name="client_id" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_job_order_type", "AAR"); ?>">
				<option value="0" selected><?=lang("Please_Select", "غير محدد"); ?></option>
<?php
	$qu_sel = "SELECT `client_id`, `client_name` FROM  `gen_clients` ORDER BY `client_name` ASC;";
	$qu_EXE = mysqli_query($KONN, $qu_sel);
	if(mysqli_num_rows($qu_EXE)){
		while($h_REC = mysqli_fetch_assoc($qu_EXE)){
		$Tclient_id = $h_REC['client_id'];
		$Tclient_name = $h_REC['client_name'];
		?>
				<option value="<?=$Tclient_id; ?>"><?=$Tclient_name; ?></option>
		<?php
		}
	}
?>
			</select>
	</div>
</div>



<div class="row col-100">
	<div class="nwFormGroup">
		<label><?=lang("Attach_Contract:", "AAR"); ?></label>
		<input  class="frmData" 
				type="file"
				id="contract_attach" 
				name="contract_attach" 
				req="1" 
				value="0" 
				den="" 
				alerter="<?=lang("Please_Check_File_attachment", "AAR"); ?>">
	</div>
	<div class="zero"></div>
</div>



	<div class="form-alerts"></div>
	<div class="zero"></div>

<div class="viewerBodyButtons">
		<button type="button" onclick="submit_form('add-new-form', 'reload_page');">
			<?=lang('Add', 'ARR', 1); ?>
		</button>
		<button type="button" onclick="hide_modal();">
			<?=lang('Cancel', 'ARR', 1); ?>
		</button>
</div>

	<div class="zero"></div>
	

</form>

				<form 
				id="add-new-form" 
				class="boxes-holder" 
				api="<?=api_root; ?>requisitions/add_new_requisition.php">
				
		<input  class="frmData" 
				type="hidden"
				id="new-requisition_status" 
				name="requisition_status" 
				value="draft"
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_requisition_status", "AAR"); ?>">
				

<div class="col-50">
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('requisition_REF', 'ARR', 1); ?></label>
		<input  class="" 
				type="text"
				value="AUTO"
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_requisition_type", "AAR"); ?>" disabled>
	</div>
</div>


<div class="col-50">
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('Created_By', 'ARR', 1); ?></label>
		<input  class="" 
				type="text" 
				value="<?=$USER_NAME; ?>"  disabled>
	</div>
</div>


<div class="col-50">
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('requisition_type', 'ARR', 1); ?></label>
		<select class="frmData" 
				id="new-requisition_type" 
				name="requisition_type" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_requisition_type", "AAR"); ?>">
				<option value="0" selected><?=lang("Please_Select", "غير محدد"); ?></option>
<?php
    if( $EMPLOYEE_ID == 229 ){
?>
				<option value="stock"><?=lang("Stock_Requisition", "AAR"); ?></option>
				<option value="management"><?=lang("Management_Requisition", "AAR"); ?></option>
<?php
}
?>
				<option value="joborder"><?=lang("job_order", "AAR"); ?></option>
			</select>
	</div>
</div>

<script>
$('#new-requisition_type').on( "change", function(){
	var reqType = $('#new-requisition_type').val();
	if( reqType == 'joborder' ){
		start_loader();
		$.ajax({
			url      :"<?=api_root; ?>job_orders/get_active_job_orders.php",
			data     :{ 'job_order_id': '0' },
			dataType :"html",
			type     :'POST',
			success  :function(data){
					end_loader();
					
					$('#new-job_order_id').html( data );
				},
			error    :function(){
					end_loader();
				alert('Data Error No: 5467653');
				},
			});
	} else {
		var aa = '<option value="100" selected><?=lang("NA", "غير محدد"); ?></option>';
		$('#new-job_order_id').html( aa );
	}
} );
</script>

<div class="col-50">
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('Job_Order', 'ARR', 1); ?></label>
		<select class="frmData" 
				id="new-job_order_id" 
				name="job_order_id" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_Job_Order", "AAR"); ?>">
				<option value="0" selected><?=lang("Please_Select", "غير محدد"); ?></option>
			</select>
	</div>
</div>

<!--div class="col-50">
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('Created_date', 'ARR', 1); ?></label>
		<input  class="frmData" 
				type="text"
				id="new-created_date" 
				name="created_date" 
				value="<?=date("Y-m-d"); ?>"
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_requisition_type", "AAR"); ?>" disabled>
	</div>
</div-->

<div class="col-50">
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('Required_delivery_date', 'ARR', 1); ?></label>
		<input  class="frmData has_date" 
				type="text"
				id="new-required_date" 
				name="required_date" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_Required_date", "AAR"); ?>">
	</div>
</div>


<!--div class="col-33">
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('Est-HHHHHH', 'ARR', 1); ?></label>
		<input  class="frmData" 
				type="text"
				id="new-estimated_date" 
				name="estimated_date" 
				value="AUTO_GENERATED" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_requisition_Delivery_date", "AAR"); ?>" disabled>
	</div>
</div-->

<div class="col-50">
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('requisition_notes', 'ARR', 1); ?></label>
		<textarea class="frmData" type="text" 
				id="new-requisition_notes" 
				name="requisition_notes" 
				req="0" 
				den="" 
				rows="8"
				alerter="<?=lang("Please_Check_requisition_notes", "AAR"); ?>"></textarea>
	</div>
</div>
	<div class="zero"></div>


<div class="col-50">
	<div class="nwFormGroup">
		<label class="lbl_class"><?=lang('requisition_material_type', 'ARR', 1); ?></label>
		<select class="frmData" 
				id="new-is_material" 
				name="is_material" 
				req="1" 
				den="100" 
				alerter="<?=lang("Please_Check_material_type", "AAR"); ?>">
				<option value="100" selected><?=lang("Please_Select", "غير محدد"); ?></option>
				<option value="1"><?=lang("Material_Requisition", "AAR"); ?></option>
				<option value="0"><?=lang("Man_Power/ machinery_Requisition", "AAR"); ?></option>
		</select>
	</div>
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



<div class="form-grp">
	<div class="form-title">
		<label><?=lang('Extra_details'); ?></label><div class="borderer"></div>
	</div>
</div>

<div class="form-grp">
	
<div class="form-item col-100">
	<label><?=lang('Packaging_and_transportations_amount'); ?></label>
<input class="frmData" type="text" 
		id="new-pak_tr_amount" 
		name="pak_tr_amount" 
		value="0"
		req="1" 
		den="" 
		alerter="<?=lang("Please_Check_Packaging_and_transportations_amount", "AAR"); ?>">
</div>

	
<div class="form-item col-100">
	<label><?=lang('Certificate_Of_Origin_cost'); ?></label>
<input class="frmData" type="text" 
		id="new-coo_amount" 
		name="coo_amount" 
		value="0"
		req="1" 
		den="" 
		alerter="<?=lang("Please_Check_Certificate_Of_Origin_cost", "AAR"); ?>">
</div>

	

	<div class="zero"></div>
</div>



<div class="btns-holder">
	<button class="btn btn-primary" type="button" onClick="set_tabber(3);"><?=lang('Previous'); ?></button>
	<button class="btn btn-success" type="button" onclick="submit_form('new-quotation-form', 'forward_page');"><?=lang('ADD Quotation'); ?></button>
</div>





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
	<button class="btn btn-primary" type="button" onClick="set_tabber(1);"><?=lang('Previous'); ?></button>
	<button class="btn btn-primary" type="button" onClick="set_tabber(1);">
	<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
  <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
  <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/>
</svg>	
	<?=lang('Print'); ?></button>
	<button class="btn btn-success" type="button" onclick="submit_form('new-quotation-form', 'forward_page');"><?=lang('ADD Quotation'); ?></button>
</div>


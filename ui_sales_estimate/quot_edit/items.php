<?php
	$is_Project_estimated = false;
	$estimateTotal = 0;
	$total = 0;
	
?>
<form 
id="edit-quotation-items-form" 
id-modal="edit_quotation_items_modal" 
api="<?=api_root; ?>sales/quotations/edit_items.php">
	
	<input class="frmData" type="hidden" 
	id="edit-quotation_id" 
	name="quotation_id" 
	req="1" 
	den="0" 
	value="<?=$quotation_id; ?>"
	alerter="<?=lang("Please_Check_quotation", "AAR"); ?>">
	
	<div class="form-grp">
		<div class="form-title">
			<label><?=lang('Added_items'); ?></label><div class="borderer"></div>
		</div>
	</div>
	
	<input type="hidden" class="frmData" 
	id="has-items" 
	name="has-items" 
	req="1" 
	den="0" 
	value="0"
	alerter="<?=lang("No_items_were_added", "AAR"); ?>">
	<div class="form-grp">
		<div class="form-item col-100">
			<label><?=lang('vat_included'); ?></label>
			<select class="frmData" 
			id="new-is_vat_included" 
			name="is_vat_included" 
			req="1" 
			den="100" 
			alerter="<?=lang("Please_Check_VAT", "AAR"); ?>">
				<option value="1" selected><?=lang('YES'); ?></option>
				<option value="0"><?=lang('NO'); ?></option>
			</select>
			<br>
			<script>
				$('#new-is_vat_included').val('<?=$is_vat_included; ?>');
				
				
			</script>
		</div>
		<div class="form-item col-100">
			<table class="tabler">
				<thead>
					<tr>
						<th><?=lang('---'); ?></th>
						<th><?=lang('No.'); ?></th>
						<th><?=lang('name'); ?></th>
						<th><?=lang('qty'); ?></th>
						<th><?=lang('price'); ?></th>
						<th><?=lang('Totals'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php
						$itemC = 0;
						
						$qu_sales_quotations_items_sel = "SELECT * FROM  `sales_quotations_items` WHERE `quotation_id` = $quotation_id";
						$qu_sales_quotations_items_EXE = mysqli_query($KONN, $qu_sales_quotations_items_sel);
						if(mysqli_num_rows($qu_sales_quotations_items_EXE)){
							
							while($sales_quotations_items_REC = mysqli_fetch_assoc($qu_sales_quotations_items_EXE)){
								$itemC++;
								$q_item_id = $sales_quotations_items_REC['q_item_id'];
								$q_item_name = $sales_quotations_items_REC['q_item_name'];
								$q_item_price = $sales_quotations_items_REC['q_item_price'];
								$q_item_qty = $sales_quotations_items_REC['q_item_qty'];
								$unit_id = $sales_quotations_items_REC['unit_id'];
								
								
								
								$qu_gen_items_units_sel = "SELECT * FROM  `gen_items_units` WHERE `unit_id` = $unit_id";
								$qu_gen_items_units_EXE = mysqli_query($KONN, $qu_gen_items_units_sel);
								$unit_name = "NA";
								if(mysqli_num_rows($qu_gen_items_units_EXE)){
									$gen_items_units_DATA = mysqli_fetch_assoc($qu_gen_items_units_EXE);
									$unit_name = $gen_items_units_DATA['unit_name'];
								}
								
								$total += $q_item_price *$q_item_qty;
								
								
								
							?>
							<tr id="itemo-<?=$itemC; ?>" class="quote_item" idler="<?=$itemC; ?>">
								
								<?php
									if( $quotation_status == 'draft' ){
									?>
									<td><i onclick="rem_item(<?=$itemC; ?>);" class="fa fa-trash" style="color:red;cursor:pointer;" area-hidden="true"></i></td>
									<?php
										} else {
									?>
									<td>--</td>
									<?php
									}
								?>
								<td class="item-c"><?=$itemC; ?></td>
								<td><?=$q_item_name; ?></td>
								<td><span class="qtyer"><?=$q_item_qty; ?></span>(<?=$unit_name; ?>)</td>
								<td class="pricer"><?=$q_item_price; ?></td>
								<td class="toter"><?=$q_item_price * $q_item_qty; ?></td>
								<input class="frmData" type="hidden" 
								id="new-q_item_id<?=$itemC; ?>" 
								name="q_item_ids[]" 
								req="1" 
								den="" 
								value="<?=$q_item_id; ?>" 
								alerter="Please_Check_Items"> 
								<input class="frmData" type="hidden" 
								id="new-item_names<?=$itemC; ?>" 
								name="item_names[]" 
								req="1" 
								den="" 
								value="<?=$q_item_name; ?>" 
								alerter="Please_Check_Items"> 
								<input class="frmData" type="hidden" 
								id="new-item_qtys<?=$itemC; ?>" 
								name="item_qtys[]" 
								req="1" 
								den="0" 
								value="<?=$q_item_qty; ?>" 
								alerter="Please_Check_Items">
								<input class="frmData" type="hidden" 
								id="new-item_units<?=$itemC; ?>" 
								name="item_units[]" 
								req="1" 
								den="0" 
								value="<?=$unit_id; ?>" 
								alerter="Please_Check_Items">
								<input class="frmData" type="hidden" 
								id="new-item_prices<?=$itemC; ?>" 
								name="item_prices[]" 
								req="1" 
								den="" 
								value="<?=$q_item_price; ?>" 
								alerter="Please_Check_Items">
								
							</tr>
							<?php
							}
							
							
							
						}
					?>
					
					
					
					
					<?php
						if( $quotation_status == 'draft' ){
						?>
						<tr id="added_items"><td colspan="6"><hr></td></tr>	
						<tr>
							<td colspan="2">
								<div class="form-item">
									<select id="item_unit" class="data-elem">
										<option value="0" disabled selected><?=lang('---select Unit ---'); ?></option>
										<?php
											$qpt = "SELECT * FROM `gen_items_units`";
											$QER_E = mysqli_query($KONN, $qpt);
											if(mysqli_num_rows($QER_E) > 0){
												while($pt_dt = mysqli_fetch_assoc($QER_E)){
												?>
												<option value="<?=$pt_dt['unit_id']; ?>" id="uniter-<?=$pt_dt['unit_id']; ?>" uniter="<?=$pt_dt['unit_name']; ?>"><?=$pt_dt['unit_name']; ?></option>
												<?php
												}
											}
										?>
									</select>
								</div>
							</td>
							<td>
								<div class="form-item">
									<input type="text" placeholder="<?=lang('item_name'); ?>" id="item_name" value="">
								</div>
							</td>
							<td>
								<div class="form-item">
									<input type="text" placeholder="<?=lang('item_qty'); ?>" id="item_qty">
								</div>
							</td>
							<td>
								<div class="form-item">
									<input type="text" placeholder="<?=lang('item_price'); ?>" id="item_price">
								</div>
							</td>
							<td>
								<div class="form-item">
									<button class="btn btn-info" onclick="add_item();" type="button">&nbsp;&nbsp;&nbsp;<?=lang('Add_item'); ?>&nbsp;&nbsp;&nbsp;</button>
								</div>
							</td>
						</tr>
						<?php
						}
					?>
					
				</tbody>
				<thead>
					<tr>
						<th colspan="5" style="text-align:right;"><?=lang('Sub_Total_:'); ?></th>
						<th id="sub_total"></th>
					</tr>
					<tr>
						<th colspan="5" style="text-align:right;"><?=lang('Discount_amount_:'); ?></th>
						<th id="discount_amount">
							
							<?php
								if( $quotation_status == 'draft' ){
								?>
								<input type="text" class="frmData" 
								id="txt_discount_amount" 
								name="discount_amount" 
								req="1" 
								den="" 
								value="<?=$discount_amount; ?>"
								alerter="<?=lang("Please_Check_discount_Value", "AAR"); ?>">
								<?php
									} else {
								?>
								<input type="text" class="frmData" 
								id="txt_discount_amount" 
								name="discount_amount" 
								req="1" 
								den="" 
								value="<?=$discount_amount; ?>"
								alerter="<?=lang("Please_Check_discount_Value", "AAR"); ?>" disabled>
								<?php
								}
							?>
							
						</th>
					</tr>
					<tr>
						<th colspan="5" style="text-align:right;"><?=lang('total_before_vat_:'); ?></th>
						<th id="total_before_vat"><?=lang('00'); ?></th>
					</tr>
					<tr>
						<th colspan="5" style="text-align:right;"><?=lang('VAT_(5%)_:'); ?></th>
						<th id="vat_total"><?=lang('00'); ?></th>
					</tr>
					<tr>
						<th colspan="5" style="text-align:right;"><?=lang('Total_:'); ?></th>
						<th id="all_total"><?=lang('00'); ?></th>
					</tr>
				</thead>
			</table>
		</div>
		<div class="zero"></div>
	</div>
	
	
	<br>
	<br>
	<br>
	
	
	
	
	
	<?php
		if( $quotation_status == 'draft' ){
		?>
		
		
		<div class="form-item col-100">
			<div class="col-100" id="edit_quotation_items_modal">
				<div class="form-alerts" style="width: 50%;margin: 0 auto;text-align: left;"></div>
			</div>
		</div>
		
		<div class="btns-holder">
			<button class="btn btn-success" type="button" onclick="submit_form('edit-quotation-items-form', 'reload_page');"><?=lang('Save Quotation'); ?></button>
		</div>
		
		
		<?php
		}
	?>
	
	
	<div id="project-estimater">
		<div>
			<h1>Remaining Sub Total</h1>
			<span id="proj-sub-tot">0.000</span>
		</div>
		<div>
			<h1>VAT Total</h1>
			<span id="proj-vat-tot">0.000</span>
		</div>
		<div>
			<h1>Remaining Project Total</h1>
			<span id="proj-tot">0.000</span>
		</div>
	</div>
	
	
</form>


<script>
	window.onload = function() {
		fix_counters();
	};
	var items_c    = <?=$itemC; ?>;
	var itemsCount = <?=$itemC; ?>;
	var estimated  = parseFloat( <?=$estimateTotal; ?> );
	var quot_tot = 0;
	function add_item(){
		//collect data
		items_c++;
		var item_name = $('#item_name').val();
		var item_qty = parseInt( $('#item_qty').val() );
		if( isNaN( item_qty ) ){
			item_qty = 0;
		}
		var item_unit = parseInt( $('#item_unit').val() );
		if( isNaN( item_unit ) ){
			item_unit = 0;
		}
		if( item_unit != 0 ){
			
			var ths_tot = 0;
			var item_unit_name = $('#uniter-' + item_unit).attr("uniter");
			var item_price = parseFloat( $('#item_price').val() );
			
			if( isNaN( item_price ) ){
				item_price = 0;
			}
			
			var inputer = '';
			
			inputer +=  '<input class="frmData" type="hidden" ' + 
			'		id="new-q_item_id' + items_c + '" ' + 
			'		name="q_item_ids[]" ' + 
			'		req="1" ' + 
			'		den="" ' + 
			'		value="0"' + 
			'		alerter="Please_Check_Items">';
			inputer +=  '<input class="frmData" type="hidden" ' + 
			'		id="new-item_names' + items_c + '" ' + 
			'		name="item_names[]" ' + 
			'		req="1" ' + 
			'		den="" ' + 
			'		value="' + item_name + '"' + 
			'		alerter="Please_Check_Items">';
			inputer +=  '<input class="frmData" type="hidden" ' + 
			'		id="new-item_qtys' + items_c + '" ' + 
			'		name="item_qtys[]" ' + 
			'		req="1" ' + 
			'		den="0" ' + 
			'		value="' + item_qty + '"' + 
			'		alerter="Please_Check_Items">';
			inputer +=  '<input class="frmData" type="hidden" ' + 
			'		id="new-item_units' + items_c + '" ' + 
			'		name="item_units[]" ' + 
			'		req="1" ' + 
			'		den="0" ' + 
			'		value="' + item_unit + '"' + 
			'		alerter="Please_Check_Items">';
			inputer +=  '<input class="frmData" type="hidden" ' + 
			'		id="new-item_prices' + items_c + '" ' + 
			'		name="item_prices[]" ' + 
			'		req="1" ' + 
			'		den="" ' + 
			'		value="' + item_price + '"' + 
			'		alerter="Please_Check_Items">';
			
			
			ths_tot = item_qty * item_price;
			
			
			if(item_name != ""){
				
				var nw_tr = '<tr id="itemo-' + items_c + '" class="quote_item" idler="' + items_c + '">'+ 
				'<td><i onclick="rem_item(' + items_c + ');" class="fa fa-trash" style="color:red;cursor:pointer;" area-hidden="true"></i></td>'+ 
				'<td class="item-c">' + items_c + '</td>'+ 
				'<td>' + item_name + '</td>'+ 
				'<td><span class="qtyer">' + item_qty + '</span>' + "(" + item_unit_name + ")" + '</td>'+ 
				'<td class="pricer">' + item_price.toFixed(3) + '</td>'+ 
				'<td class="pricer">' + ths_tot.toFixed(3) + '</td>'+ 
				'' + inputer +
				'</tr>';
				
				$('#added_items').before(nw_tr);
				ClearInputForm();
				itemsCount++;
				fix_counters();
				
				} else {
				alert( "Please Insert Item Name" );
			}
			
			} else {
			alert( "Please Select Item Unit" );
		}
		
		
		
		
		
	}
	
	function ClearInputForm(){
		$('#item_name').val('');
		$('#item_qty').val('');
		$('#item_unit').val('0');
		$('#item_price').val('');
	}
	
	function fixItemCheck(){
		if( itemsCount != 0 ){
			$('#has-items').val(1);
			}else {
			$('#has-items').val(0);
		}
	}
	
	function rem_item(idd){
		$('#itemo-' + idd).remove();
		itemsCount--;
		fix_counters();
	}
	
	function fix_counters(){
		fixItemCheck();
		var cc = 0;
		$('.item-c').each(function(){
			cc++;
			$(this).html(cc);
		});
		
		var sub_tot = 0;
		$('.quote_item').each(function(){
			var idd = parseInt($(this).attr('idler'));
			var ths_qty = parseFloat($('#itemo-' + idd + ' .qtyer').html());
			var ths_prc = parseFloat($('#itemo-' + idd + ' .pricer').html());
			sub_tot = (ths_qty * ths_prc) + sub_tot;
		});
		
		
		var discount_amount = parseFloat( $('#txt_discount_amount').val() );
		if( isNaN( discount_amount ) ){
			discount_amount = 0;
		}
		
		$('#sub_total').html(sub_tot.toFixed(3));
		// vat_total
		// all_total
		sub_tot = sub_tot - discount_amount;
		
		var isVat = parseInt( $('#new-is_vat_included').val() );
		var vat = 0;
		if( isVat == 1 ){
			var vat = sub_tot * 0.05;
		}
		
		
		
		
		quot_tot = sub_tot;
		
		
		var all = sub_tot + vat;
		
		// $('#txt_discount_amount').val(discount_amount.toFixed(3));
		$('#total_before_vat').html(sub_tot.toFixed(3));
		$('#vat_total').html(vat.toFixed(3));
		$('#all_total').html(all.toFixed(3));
		
		
		
	}
	
	$('#txt_discount_amount').on('input', function(){
		fix_counters();
	} );
	
	$('#new-is_vat_included').on('change', function(){
		fix_counters();
	} );
	
	
	
	
	
	
	function calcProject(){
		
		var estTot = estimated;
		
		estTot = estTot - quot_tot;
		
		
		
		var isVat = parseInt( $('#new-is_vat_included').val() );
		var vat = 0;
		if( isVat == 1 ){
			var vat = estTot * 0.05;
		}
		
		
		
		var allTot = vat + estTot;
		
		$('#proj-sub-tot').html(estTot.toFixed(3));
		$('#proj-vat-tot').html(vat.toFixed(3));
		$('#proj-tot').html(allTot.toFixed(3));
		
	}
	
	
	
	
	
	
	
	
	fix_counters();
</script>	
<?php
	
    
	$created_date = "";
	$required_date = "";
	$estimated_date = "";
	$requisition_ref = "";
	$requisition_type = "";
	$job_order_id = 0;
	$requisition_status = "";
	$requisition_notes = "";
	$ordered_by = 0;
	$price_list_id = 0;
	
	$currency_id = 0;
	$exchange_rate = 0;
	$is_vat_included = 0;
	$supplier_quotation_ref = "";
	$attached_supplier_quotation = "";
	$delivery_period_id = 0;
	$payment_term_id = 0;
	$discount_percentage = 0;
	$discount_amount = 0;
	$notes = "";
	$rfq_id = 0;
	
	if( $loadDt == true ){
		
		$qu_pur_requisitions_sel = "SELECT * FROM  `pur_requisitions` WHERE `requisition_id` = $requisition_id";
		$qu_pur_requisitions_EXE = mysqli_query($KONN, $qu_pur_requisitions_sel);
		$pur_requisitions_DATA;
		if(mysqli_num_rows($qu_pur_requisitions_EXE)){
			$pur_requisitions_DATA = mysqli_fetch_assoc($qu_pur_requisitions_EXE);
			$created_date = $pur_requisitions_DATA['created_date'];
			$required_date = $pur_requisitions_DATA['required_date'];
			$estimated_date = $pur_requisitions_DATA['estimated_date'];
			$requisition_ref = $pur_requisitions_DATA['requisition_ref'];
			$requisition_type = $pur_requisitions_DATA['requisition_type'];
			$job_order_id = ( int ) $pur_requisitions_DATA['job_order_id'];
			$requisition_status = $pur_requisitions_DATA['requisition_status'];
			$requisition_notes = $pur_requisitions_DATA['requisition_notes'];
			$ordered_by = ( int ) $pur_requisitions_DATA['ordered_by'];
		}
		
		
		
		
		
		$supplier_code = "";
		$supplier_name = "";
		
		$qu_suppliers_list_sel = "SELECT * FROM  `suppliers_list` WHERE `supplier_id` = $supplier_id";
		$qu_suppliers_list_EXE = mysqli_query($KONN, $qu_suppliers_list_sel);
		$suppliers_list_DATA;
		if(mysqli_num_rows($qu_suppliers_list_EXE)){
			$suppliers_list_DATA = mysqli_fetch_assoc($qu_suppliers_list_EXE);
			$supplier_code = $suppliers_list_DATA['supplier_code'];
			$supplier_name = $suppliers_list_DATA['supplier_name'];
		}
		
		
		
		
		//LOAD APPROVED P L DATA
		$qu_pur_requisitions_pls_items_sel = "SELECT `price_list_id` FROM  `pur_requisitions_pls_items` 
		WHERE ((`supplier_id` = $supplier_id) AND 
		(`requisition_id` = $requisition_id) AND 
		(`is_approved` = '1'));";
		
		$qu_pur_requisitions_pls_items_EXE = mysqli_query($KONN, $qu_pur_requisitions_pls_items_sel);
		$pur_requisitions_pls_items_DATA;
		if(mysqli_num_rows($qu_pur_requisitions_pls_items_EXE)){
			$pur_requisitions_pls_items_DATA = mysqli_fetch_assoc($qu_pur_requisitions_pls_items_EXE);
			$price_list_id = ( int ) $pur_requisitions_pls_items_DATA['price_list_id'];
		}
		
		
		if( $price_list_id != 0 ){
			
			
			$qu_pur_requisitions_pls_sel = "SELECT * FROM  `pur_requisitions_pls` WHERE `price_list_id` = $price_list_id";
			$qu_pur_requisitions_pls_EXE = mysqli_query($KONN, $qu_pur_requisitions_pls_sel);
			$pur_requisitions_pls_DATA;
			if(mysqli_num_rows($qu_pur_requisitions_pls_EXE)){
				$pur_requisitions_pls_DATA = mysqli_fetch_assoc($qu_pur_requisitions_pls_EXE);
				
				$currency_id                  = ( int ) $pur_requisitions_pls_DATA['currency_id'];
				$exchange_rate                = ( int ) $pur_requisitions_pls_DATA['exchange_rate'];
				$is_vat_included              = ( int ) $pur_requisitions_pls_DATA['is_vat_included'];
				$supplier_quotation_ref       = $pur_requisitions_pls_DATA['supplier_quotation_ref'];
				$attached_supplier_quotation  = $pur_requisitions_pls_DATA['attached_supplier_quotation'];
				$attached_supplier_quotation1  = $pur_requisitions_pls_DATA['attached_supplier_quotation1'];
				$delivery_period_id           = ( int ) $pur_requisitions_pls_DATA['delivery_period_id'];
				$payment_term_id              = ( int ) $pur_requisitions_pls_DATA['payment_term_id'];
				$discount_percentage          = ( double ) $pur_requisitions_pls_DATA['discount_percentage'];
				$discount_amount              = ( double ) $pur_requisitions_pls_DATA['discount_amount'];
				$notes                        = $pur_requisitions_pls_DATA['notes'];
				$rfq_id                       = ( int ) $pur_requisitions_pls_DATA['rfq_id'];
				
			}
		}
		
		
		
		
		
		
	}
	
?>
<form 
id="add-new-form" 
class="boxes-holder" 
api="<?=api_root; ?>purchase_orders/add_new_po_pl.php">
	
	
	<div class="row col-33">
		<div class="nwFormGroup">
			<label><?=lang("po_ref", "AAR"); ?></label>
			<input class="" 
			type="text"
			value="AUTO"
			req="1" 
			den="0" 
			alerter="<?=lang("Please_Check_requisition_type", "AAR"); ?>" disabled>
		</div>
		<div class="nwFormGroup">
			<label><?=lang("rev_no", "AAR"); ?></label>
			<input type="text" value="0" class="readOnly">
		</div>
		<div class="nwFormGroup">
			<label class="lbl_class"><?=lang('Created_By', 'ARR', 1); ?></label>
			<input  class="" 
			type="text" 
			value="<?=$USER_NAME; ?>"  disabled>
		</div>
	</div>
	
	<div class="row col-33">
		<div class="nwFormGroup">
			<label><?=lang("requisition", "AAR"); ?></label>
			<select class="frmData" 
			id="new-requisition_id" 
			name="requisition_id" 
			req="1" 
			den="0" 
			alerter="<?=lang("Please_Check_requisition", "AAR"); ?>">
				<option value="0" selected><?=lang("Please_Select", "غير محدد"); ?></option>
				<?php
					$sNo = 0;
					$qu_pur_requisitions_sel = "SELECT * FROM  `pur_requisitions` ORDER BY `requisition_id` DESC";
					$qu_pur_requisitions_EXE = mysqli_query($KONN, $qu_pur_requisitions_sel);
					if(mysqli_num_rows($qu_pur_requisitions_EXE)){
						while($pur_requisitions_REC = mysqli_fetch_assoc($qu_pur_requisitions_EXE)){
							
							$req_id = $pur_requisitions_REC['requisition_id'];
							$requisition_ref = $pur_requisitions_REC['requisition_ref'];
							$requisition_type = $pur_requisitions_REC['requisition_type'];
							
						?>
						<option id="new-sel-req-<?=$req_id; ?>" value="<?=$req_id; ?>"><?=$requisition_ref; ?>( <?=$requisition_type; ?> )</option>
						<?php
						}
					}
				?>
			</select>
		</div>
		<script>
			$('#new-requisition_id').val('<?=$requisition_id; ?>');
		</script>
		
		<div class="nwFormGroup">
			<label class="lbl_class"><?=lang('Job_Order', 'ARR', 1); ?></label>
			<select class="frmData" 
			id="new-job_order_id" 
			name="job_order_id" 
			req="1" 
			den="" 
			alerter="<?=lang("Please_Check_Job_Order", "AAR"); ?>">
				<option value="0" selected><?=lang("NA", "غير محدد"); ?></option>
				<?php
					$qu_job_orders_sel = "SELECT * FROM  `job_orders` WHERE `job_order_id` = $job_order_id";
					$qu_job_orders_EXE = mysqli_query($KONN, $qu_job_orders_sel);
					if(mysqli_num_rows($qu_job_orders_EXE)){
						while($job_orders_REC = mysqli_fetch_assoc($qu_job_orders_EXE)){
							$job_order_id = $job_orders_REC['job_order_id'];
							$job_order_ref = $job_orders_REC['job_order_ref'];
							$project_name = $job_orders_REC['project_name'];
							$job_order_type = $job_orders_REC['job_order_type'];
							$job_order_status = $job_orders_REC['job_order_status'];
							$created_date = $job_orders_REC['created_date'];
							$created_by = $job_orders_REC['created_by'];
						?>
						<option value="<?=$job_order_id; ?>"><?=$job_order_ref; ?> - <?=$project_name; ?> - <?=$job_order_type; ?></option>
						<?php
						}
					}
				?>
			</select>
		</div>
		<script>
			$('#new-job_order_id').val('<?=$job_order_id; ?>');
		</script>
		<div class="nwFormGroup">
			<label><?=lang("Project", "AAR"); ?></label>
			<input type="text" value="0" class="readOnly">
		</div>
	</div>
	
	<div class="row col-33">
		<div class="nwFormGroup">
			<label><?=lang("PO_Status", "AAR"); ?></label>
			<input type="text" value="NEW" class="readOnly">
		</div>
		
		<div class="nwFormGroup">
			<label><?=lang("PO_date", "AAR"); ?></label>
			<input type="text" value="<?=date('Y-m-d'); ?>" class="readOnly">
		</div>
	</div>
	
	
	
	<div class="row col-100">
		<hr>
	</div>
	<div class="zero"></div>
	
	
	
	<div class="col-33">
		
		<div class="nwFormGroup">
			<label><?=lang("Supplier", "AAR"); ?></label>
			<select class="frmData" 
			id="new-supplier_id" 
			name="supplier_id" 
			req="1" 
			den="0" 
			alerter="<?=lang("Please_Check_supplier", "AAR"); ?>">
				<option value="0" selected><?=lang("Please_Select", "غير محدد"); ?></option>
				<?php
					$sNo = 0;
					$qu_suppliers_list_sel = "SELECT * FROM  `suppliers_list` ORDER BY `supplier_id` DESC";
					$qu_suppliers_list_EXE = mysqli_query($KONN, $qu_suppliers_list_sel);
					if(mysqli_num_rows($qu_suppliers_list_EXE)){
						while($suppliers_list_REC = mysqli_fetch_assoc($qu_suppliers_list_EXE)){
							$sNo++;
							$supp_id = $suppliers_list_REC['supplier_id'];
							$supplier_code = $suppliers_list_REC['supplier_code'];
							$supplier_name = $suppliers_list_REC['supplier_name'];
							
						?>
						<option id="new-sel-supp-<?=$supp_id; ?>" value="<?=$supp_id; ?>"><?=$supplier_code; ?> - <?=$supplier_name; ?></option>
						<?php
						}
					}
				?>
			</select>
		</div>
		<script>
			$('#new-supplier_id').val('<?=$supplier_id; ?>');
		</script>
		
		<div class="nwFormGroup">
			<label class="lbl_class"><?=lang('Supplier quot. ref', 'AA', 1); ?></label>
			<input class="frmData" 
			id="new-supplier_quotation_ref" 
			name="supplier_quotation_ref" 
			type="text"
			value="<?=$supplier_quotation_ref; ?>"
			req="1" 
			den="" 
			alerter="<?=lang("Please_Check_supplier_quotation_ref", "AAR"); ?>">
		</div>
		
		<div class="nwFormGroup">
			<label class="lbl_class"><i class="fas fa-paperclip"></i>&nbsp;&nbsp;<?=lang('quotation', 'AA', 1); ?></label>
			<input class="frmData" 
			id="new-attached_supplier_quotation02" 
			name="data_file_old" 
			value="<?=$attached_supplier_quotation; ?>" 
			type="hidden"
			req="0" 
			den="0" 
			alerter="<?=lang("Please_Check_supplier_quotation_file", "AAR"); ?>">
			<input class="frmData" 
			id="new-attached_supplier_quotation021" 
			name="data_file_old1" 
			value="<?=$attached_supplier_quotation1; ?>" 
			type="hidden"
			req="0" 
			den="0" 
			alerter="<?=lang("Please_Check_supplier_quotation_file", "AAR"); ?>">
			<input class="frmData" 
			id="new-attached_supplier_quotation" 
			name="attached_supplier_quotation_filer" 
			type="file"
			req="0" 
			den="0" 
			alerter="<?=lang("Please_Check_supplier_quotation_file", "AAR"); ?>">
			
			<input class="frmData" 
			id="new-attached_supplier_quotation1" 
			name="attached_supplier_quotation_filer1" 
			type="file"
			req="0" 
			den="0" 
			alerter="<?=lang("Please_Check_supplier_quotation_file", "AAR"); ?>">
		</div>
		
		<div class="col-100">
			Selected Quotation file:<div class="element-to-paste-filename" style = "float:left"><?=$attached_supplier_quotation; ?>,<?=$attached_supplier_quotation1; ?></div>
		</div>	
		
		
		
		
		
	</div>
	
	
	<div class="col-33">
		
		<div class="nwFormGroup">
			<label class="lbl_class"><?=lang('delivery_period', 'ARR', 1); ?></label>
			<select class="frmData" 
			id="new-delivery_period_id" 
			name="delivery_period_id" 
			req="1" 
			den="0" 
			alerter="<?=lang("Please_Check_delivery_period", "AAR"); ?>">
				<option value="0" selected><?=lang('Please_Select', 'AA', 1); ?></option>
				<?php
					$qu_FETCH_sel = "SELECT `delivery_period_id`, `delivery_period_title` FROM  `gen_delivery_periods`";
					$qu_FETCH_EXE = mysqli_query($KONN, $qu_FETCH_sel);
					if(mysqli_num_rows($qu_FETCH_EXE)){
						while($fetched_DT = mysqli_fetch_array($qu_FETCH_EXE)){
						?>
						<option value="<?=$fetched_DT[0]; ?>"><?=$fetched_DT[1]; ?></option>
						<?php
						}
					}
				?>
			</select>
		</div>
		<script>
			$('#new-delivery_period_id').val('<?=$delivery_period_id; ?>');
		</script>
		
		<div class="nwFormGroup">
			<label class="lbl_class"><?=lang('payment_term', 'ARR', 1); ?></label>
			<select class="frmData" 
			id="new-payment_term_id" 
			name="payment_term_id" 
			req="1" 
			den="0" 
			alerter="<?=lang("Please_Check_payment_term", "AAR"); ?>">
				<option value="0" selected><?=lang('Please_Select', 'AA', 1); ?></option>
				<?php
					$qu_FETCH_sel = "SELECT `payment_term_id`, `payment_term_title` FROM  `gen_payment_terms`";
					$qu_FETCH_EXE = mysqli_query($KONN, $qu_FETCH_sel);
					if(mysqli_num_rows($qu_FETCH_EXE)){
						while($fetched_DT = mysqli_fetch_array($qu_FETCH_EXE)){
						?>
						<option value="<?=$fetched_DT[0]; ?>"><?=$fetched_DT[1]; ?></option>
						<?php
						}
					}
				?>
			</select>
		</div>
		<script>
			$('#new-payment_term_id').val('<?=$payment_term_id; ?>');
		</script>
		
	</div>
	
	
	<div class="col-33">
		<div class="nwFormGroup">
			<label class="lbl_class"><?=lang('currency', 'ARR', 1); ?></label>
			<select class="frmData" 
			id="new-currency_id" 
			name="currency_id" 
			req="1" 
			den="0" 
			alerter="<?=lang("Please_Check_currency", "AAR"); ?>">
				<option value="0" selected><?=lang('Please_Select', 'AA', 1); ?></option>
				<?php
					$qu_FETCH_sel = "SELECT `currency_id`, `currency_name` FROM  `gen_currencies`";
					$qu_FETCH_EXE = mysqli_query($KONN, $qu_FETCH_sel);
					if(mysqli_num_rows($qu_FETCH_EXE)){
						while($fetched_DT = mysqli_fetch_array($qu_FETCH_EXE)){
						?>
						<option id="cur-<?=$fetched_DT[0]; ?>" cur="<?=$fetched_DT[1]; ?>" value="<?=$fetched_DT[0]; ?>"><?=$fetched_DT[1]; ?></option>
						<?php
						}
					}
				?>
			</select>
		</div>
		<script>
			$('#new-currency_id').val('<?=$currency_id; ?>');
		</script>
		
		
		<div class="nwFormGroup">
			<label class="lbl_class"><?=lang('vat_included', 'ARR', 1); ?></label>
			<select class="frmData" 
			id="new-is_vat_included" 
			name="is_vat_included" 
			req="1" 
			den="100" 
			alerter="<?=lang("Please_Check_VAT", "AAR"); ?>">
				<option value="1" selected><?=lang('YES'); ?></option>
				<option value="0"><?=lang('NO'); ?></option>
			</select>
		</div>
		<script>
			$('#new-is_vat_included').val('<?=$is_vat_included; ?>');
		</script>
		
		
		
		<div class="nwFormGroup">
			<label class="lbl_class"><?=lang('notes', 'ARR', 1); ?></label>
			<textarea class="frmData" type="text" 
			id="new-notes" 
			name="notes" 
			req="0" 
			den="" 
			rows="3"
			alerter="<?=lang("Please_Check_requisition_notes", "AAR"); ?>"><?=$notes; ?></textarea>
		</div>
		
		
		
	</div>
	
	
	<div class="row col-100">
		<br>
		<hr>
		<br>
	</div>
	<div class="zero"></div>
	
	
	<table class="tabler" border="1">
		<thead>
			<tr>
				<th><span onclick="resetItems();" style="color:red;cursor:pointer;font-size:12px;"><?=lang('RESET'); ?></span></th>
				<th><?=lang('No.'); ?></th>
				<th><?=lang('name'); ?></th>
				<th style="width:10%;"><?=lang('qty'); ?></th>
				<th><?=lang('UOM'); ?></th>
				<th><?=lang('U.P'); ?></th>
				<th style="width:15%;"><?=lang('Total'); ?> ( <span id="cur_name">please select currency</span> )</th>
			</tr>
		</thead>
		<tbody id="added_PO_items">
			
			
			<?php
				
				$totBeforeVAT = 0;
				
				if( $loadDt == true ){
					
					$qu_pur_requisitions_pls_items_sel = "SELECT * FROM  `pur_requisitions_pls_items` WHERE 
					((`requisition_id` = $requisition_id) AND 
					(`supplier_id` = $supplier_id) AND 
					(`is_approved` = '1'))";
					$qu_pur_requisitions_pls_items_EXE = mysqli_query($KONN, $qu_pur_requisitions_pls_items_sel);
					if(mysqli_num_rows($qu_pur_requisitions_pls_items_EXE)){
						$CC=0;
						while($pur_requisitions_pls_items_REC = mysqli_fetch_assoc($qu_pur_requisitions_pls_items_EXE)){
							$CC++;
							$pl_record_id        = $pur_requisitions_pls_items_REC['pl_record_id'];
							$item_code_id        = $pur_requisitions_pls_items_REC['item_code_id'];
							$requisition_item_id = $pur_requisitions_pls_items_REC['requisition_item_id'];
							$item_qty            = ( double ) $pur_requisitions_pls_items_REC['item_qty'];
							$pl_item_price       = ( double ) $pur_requisitions_pls_items_REC['pl_item_price'];
							
							
							
							$qu_pur_requisitions_items_sel = "SELECT * FROM  `pur_requisitions_items` WHERE `req_item_id` = $requisition_item_id";
							$qu_pur_requisitions_items_EXE = mysqli_query($KONN, $qu_pur_requisitions_items_sel);
							$pur_requisitions_items_DATA;
							if(mysqli_num_rows($qu_pur_requisitions_items_EXE)){
								$pur_requisitions_items_DATA = mysqli_fetch_assoc($qu_pur_requisitions_items_EXE);
							}
							
							$item_code_id = $pur_requisitions_items_DATA['item_code_id'];
							
							$certificate_required = $pur_requisitions_items_DATA['certificate_required'];
							$item_unit_id = $pur_requisitions_items_DATA['item_unit_id'];
							
							
							$family_id = $pur_requisitions_items_DATA['family_id'];
							$lv2 = $pur_requisitions_items_DATA['section_id'];
							$lv3 = $pur_requisitions_items_DATA['division_id'];
							$lv4 = $pur_requisitions_items_DATA['subdivision_id'];
							$lv5 = $pur_requisitions_items_DATA['category_id'];
							
							
							$item_name = get_item_description( $pur_requisitions_items_DATA['req_item_id'], 'req_item_id', 'pur_requisitions_items', $KONN );
							
							$item_unit_name = get_unit_name( $pur_requisitions_items_DATA['item_unit_id'], $KONN );
							
							
							
							$thsTOT = $item_qty * $pl_item_price;
							
							$totBeforeVAT = $totBeforeVAT + $thsTOT;
							
							
							
						?>
						<tr id="poItem-<?=$pl_record_id; ?>" class="po_item_list" idler="<?=$pl_record_id; ?>">
							<input class="frmData"
							id="new-po_item_id<?=$pl_record_id; ?>"
							name="item_ids[]"
							type="hidden"
							value="<?=$pl_record_id; ?>"
							req="1"
							den="0"
							alerter="<?=lang("Please_Check_items", "AAR"); ?>">
							<td><i title="Delete this item" onclick="delPoItem('poItem-<?=$pl_record_id; ?>');" class="fas fa-trash"></i></td>
							<td><?=$CC; ?></td>
							<td><?=$item_name; ?></td>
							<td style="widtd:10%;">
								
								<input class="frmData item_qtys" 
								id="new-po_item_qty<?=$pl_record_id; ?>" 
								name="item_qtys[]" 
								type="text" 
								value="<?=$item_qty; ?>" 
								onclick="this.select();" 
								req="1" 
								den="0" 
								alerter="<?=lang("Please_Check_items", "AAR"); ?>">
								
							</td>
							<td><?=$item_unit_name; ?></td>
							<td>
								<input class="frmData item_prices" 
								id="new-po_item_price<?=$pl_record_id; ?>" 
								name="item_prices[]" 
								type="text" 
								value="<?=$pl_item_price; ?>" 
								onclick="this.select();" 
								req="1" 
								den="0" 
								alerter="<?=lang("Please_Check_items", "AAR"); ?>">
							</td>
							<td>
								<input class="" 
								id="new-po_item_tot<?=$pl_record_id; ?>" 
								name="item_tots[]" 
								type="text" 
								value="0" 
								onclick="this.select();" 
								req="1" 
								den="0" 
								alerter="<?=lang("Please_Check_items", "AAR"); ?>" disabled>
							</td>
						</tr>
						<?php
						}
					}
					
					//loadDt check
				}
			?>
			
			
			
			
			
		</tbody>
		<tbody>
			<?php
				/*
					<tr>
					<td colspan="5">&nbsp;</td>
					<td style="text-align:right;">
					Discount Amount 
					<input class="frmData discount_per " 
					id="new-discount_per" 
					name="discount_percentage" 
					value="<?=$discount_percentage; ?>"
					onClick="this.select();"
					type="number" 
					value="0" step="0.5" min="0" max="100" 
					req="1" 
					den="" 
					alerter="<?=lang("Please_Check_discount_percentage", "AAR"); ?>" readonly>
					(%) :
					</td>
					<td>
					<input class="frmData discount_amount" 
					id="new-discount_amount" 
					name="discount_amount" 
					type="text" 
					value="0"
					req="1" 
					den="" 
					alerter="<?=lang("Please_Check_discount_amount", "AAR"); ?>" readonly>
					</td>
					</tr>
				*/
			?>
			<input class="frmData" 
			id="DELnew-discount_amount" 
			name="discount_amount" 
			type="hidden" 
			value="0"
			req="1" 
			den="" 
			alerter="<?=lang("Please_Check_discount_amount", "AAR"); ?>" readonly>
			<input class="frmData" 
			id="DELnew-discount_per" 
			name="discount_percentage" 
			value="0" 
			type="hidden" 
			value="0" step="0.5" min="0" max="100" 
			req="1" 
			den="" 
			alerter="<?=lang("Please_Check_discount_percentage", "AAR"); ?>">
			<tr>
				<td class="text-center" colspan="7">
					<button type="button" onclick="showLimsList();">Add Predefined Item</button>
				</td>
			</tr>
			<?php
				$totBeforeVAT = $totBeforeVAT - $discount_amount;
			?>
			<tr>
				<td colspan="5">&nbsp;</td>
				<td style="text-align:right;">Sub Total :</td>
				<td style="text-align:center;">
					<input id="new-total_before_vat" type="text" value="<?=$totBeforeVAT; ?>" disabled>
				</td>
			</tr>
			<?php
				$VATamount = $totBeforeVAT * 0.05;
			?>
			<tr>
				<td colspan="5">&nbsp;</td>
				<td style="text-align:right;">Total Vat Amount :</td>
				<td style="text-align:center;">
					<input id="new-total_vat_amount" type="text" value="<?=$VATamount; ?>" disabled>
				</td>
			</tr>
			<?php
				$totAfterVAT = $totBeforeVAT + $VATamount;
			?>
			<tr>
				<td colspan="5">&nbsp;</td>
				<td style="text-align:right;">Total :</td>
				<td style="text-align:center;">
					<input id="new-all_total" type="text" value="<?=$totAfterVAT; ?>" disabled>
				</td>
			</tr>
			
			
		</tbody>
	</table>
	
	
	<div class="row col-100">
		<br>
		<hr>
		<br>
	</div>
	<div class="zero"></div>
	
	<table class="tabler" border="1">
		<thead>
			<tr>
				<th><span onclick="resetTerms();" style="color:red;cursor:pointer;font-size:12px;"><?=lang('RESET'); ?></span></th>
				<th><?=lang('No.'); ?></th>
				<th><?=lang('terms_and_conditions'); ?></th>
			</tr>
		</thead>
		<tbody id="added_PO_terms">
			
			<?php
				$qu_purchase_orders_terms_list_sel = "SELECT * FROM  `purchase_orders_terms_list`";
				$qu_purchase_orders_terms_list_EXE = mysqli_query($KONN, $qu_purchase_orders_terms_list_sel);
				if(mysqli_num_rows($qu_purchase_orders_terms_list_EXE)){
					$TC = 0;
					while($purchase_orders_terms_list_REC = mysqli_fetch_assoc($qu_purchase_orders_terms_list_EXE)){
						$TC++;
						$term_id = $purchase_orders_terms_list_REC['term_id'];
						$term_title = $purchase_orders_terms_list_REC['term_title'];
						$term_title_ar = $purchase_orders_terms_list_REC['term_title_ar'];
					?>
					<tr id="term-<?=$term_id; ?>">
						<td>
							<i title="Delete this item" onclick="$('#term-<?=$term_id; ?>').remove();fixTermsTable();" class="fas fa-trash"></i>
						</td>
						<th class="po_terms_count"><?=$TC; ?></td>
						<td>
							<input class="frmData"
							id="new-po_term<?=$term_id; ?>"
							name="term_ids[]"
							type="hidden"
							value="<?=$term_id; ?>"
							req="1"
							den="0"
							alerter="<?=lang("Please_Check_terms", "AAR"); ?>">
							<input class="frmData"
							id="new-po_termTXT<?=$term_id; ?>"
							name="term_texts[]"
							type="hidden"
							value=""
							req="1"
							den="0"
							alerter="<?=lang("Please_Check_terms", "AAR"); ?>">
							<?=$term_title; ?>
						</td>
					</tr>
					<?php
					}
				}
			?>
			<tr id="term-0">
				<td>
					<i title="Delete this item" onclick="$('#term-0').remove();fixTermsTable();" class="fas fa-trash"></i>
				</td>
				<th class="po_terms_count"><?=++$TC; ?></td>
				<td>
					<input class="frmData"
					id="new-po_term0"
					name="term_ids[]"
					type="hidden"
					value="0"
					req="1"
					den="1000"
					alerter="<?=lang("Please_Check_terms", "AAR"); ?>">
					<textarea class="frmData" style="width: 100%;" 
					id="new-po_termTXT0"
					name="term_texts[]" 
					req="1"
					den="0"
					alerter="<?=lang("Please_Check_terms", "AAR"); ?>"></textarea>
				</td>
			</tr>
			
		</tbody>
	</table>
	
	
	<div class="form-alerts"></div>
	<div class="zero"></div>
	
	<div class="viewerBodyButtons">
		<button type="button" onclick="submit_form('add-new-form', 'forward_page');show_details('poDefineAppsDetails', 'Define_Approvals');$('#appv-po_id').val( activePO );">
			<?=lang('Generate PO', 'ARR', 1); ?>
		</button>
		<button type="button" onclick="hide_details('addNewPOfromPLdetails');">
			<?=lang('Cancel', 'ARR', 1); ?>
		</button>
	</div>
	
</form>










<!--    ///////////////////      PreLimsView VIEW START    ///////////////////            -->
<div class="DetailsViewer ViewerOnTop" id="PreLimsView">
	<div class="viewerContainer">
		<div class="viewerHeader">
			<img src="<?=uploads_root; ?>/logo_icon.png" />
			<h1>REFREFREF</h1>
			<i onclick="hide_details('PreLimsView');" class="fas fa-times"></i>
		</div>
		<div class="viewerBody">
			<table class="tabler">
				<thead>
					<th><?=lang("Item", "AAR"); ?></th>
					<th><?=lang("Add", "AAR"); ?></th>
				</thead>
				<tbody id="predItemsRests">
					<?php
						$qu_purchase_orders_items_limited_list_sel = "SELECT * FROM  `purchase_orders_items_limited_list`";
						$qu_purchase_orders_items_limited_list_EXE = mysqli_query($KONN, $qu_purchase_orders_items_limited_list_sel);
						if(mysqli_num_rows($qu_purchase_orders_items_limited_list_EXE)){
							while($purchase_orders_items_limited_list_REC = mysqli_fetch_assoc($qu_purchase_orders_items_limited_list_EXE)){
								$limited_id = $purchase_orders_items_limited_list_REC['limited_id'];
								$limited_text = $purchase_orders_items_limited_list_REC['limited_text'];
							?>
							<tr id="limSlc-<?=$limited_id; ?>">
								<td id="lim-<?=$limited_id; ?>"><?=$limited_text; ?></td>
								<td><button type="button" onclick="addItemPre(<?=$limited_id; ?>);">Add To PO</button></td>
							</tr>
							<?php
							}
						}
					?>
				</tbody>
			</table>
			
			<div class="viewerBodyButtons">
				<button type="button" onclick="hide_details('PreLimsView');">
					<?=lang('Close', 'ARR', 1); ?>
				</button>
			</div>
			
		</div>
	</div>
</div>
<!--    ///////////////////      PreLimsView VIEW END    ///////////////////            -->











<script>
	var oldPreData = $('#predItemsRests').html();
	function addItemPre( limID ){
		limID = parseInt( limID );
		if( limID != 0 ){
			var txter = $('#lim-' + limID).text();
			if( txter != '' && $('#preId-' + limID).length == 0 ){
				
				
				var preItm = '<tr id="preId-' + limID + '" idler="' + limID + '" class="pred_po_items">' + 
				'<input class="frmData"' + 
				'id="new-po_lim_id' + limID + '"' + 
				'name="limited_ids[]"' + 
				'type="hidden"' + 
				'value="' + limID + '"' + 
				'req="1"' + 
				'den="0"' + 
				'alerter="<?=lang("Please_Check_lims", "AAR"); ?>">' + 
				'<td><i title="Delete this item" onclick="delPreItem(' + limID + ');" class="fas fa-trash"></i></td>' + 
				'<td>--</td>' + 
				'<td>' + txter + '</td>' + 
				'<td style="widtd:10%;">' + 
				'<input class="frmData item_qtys" ' + 
				'id="new-po_lim_qty' + limID + '" ' + 
				'name="limited_qtys[]" ' + 
				'type="text" ' + 
				'value="1" ' + 
				'onclick="this.select();" ' + 
				'req="1" ' + 
				'den="0" ' + 
				'alerter="<?=lang("Please_Check_items", "AAR"); ?>">' + 
				'</td>' +  
				'<td>NA</td>' + 
				'<td>' + 
				'	<input class="frmData item_prices" ' + 
				'			id="new-po_lim_price' + limID + '" ' + 
				'			name="limited_prices[]" ' + 
				'			type="text" ' + 
				'			value="0" ' + 
				'			onclick="this.select();" ' + 
				'			req="1" ' + 
				'			den="0" ' + 
				'			alerter="<?=lang("Please_Check_items", "AAR"); ?>">' + 
				'</td>' + 
				'<td>' + 
				'	<input class="" ' + 
				'			id="new-po_lim_tot' + limID + '" ' + 
				'			name="lims_tots[]" ' + 
				'			type="text" ' + 
				'			value="0" ' + 
				'			onclick="this.select();" ' + 
				'			req="1" ' + 
				'			den="0" ' + 
				'			alerter="<?=lang("Please_Check_items", "AAR"); ?>" disabled>' + 
				'</td>' + 
				'</tr>';
				
				
				$('#limSlc-' + limID).remove();
				$('#added_PO_items').append( preItm );
				initTableEvents();
			}
		}
		
		
		
	}
	function delPreItem( delID ){
		$('#preId-' + delID).remove();
	}
	
	
	function showLimsList(){
		show_details('PreLimsView', 'Comparison Sheet');
		$('#predItemsRests').html( oldPreData );
	}
	
	
	
	
	
	
	
	
	$('#new-currency_id').on( 'change', function(){
		var ths_vv = parseInt( $('#new-currency_id').val() );
		if( ths_vv != 0 ){
			var cur_n = $('#cur-' + ths_vv ).attr('cur');
			$('#cur_name').html( cur_n );
		}
	} );
	$('#new-currency_id').change();
	
	<?php
		if( $loadDt == true ){
		?>
		show_details( 'addNewPOfromPLdetails', 'Add New PO' );
		<?php
		}
		?>
		
		
		
		function fixTermsTable(){
		var TermsCount = 0;
		$('.po_terms_count').each( function(){
		TermsCount++;
		$(this).html( TermsCount );
		} );
		}
		
		
		
		
		
		
		function cal_table(){
		var totBeforeVat = 0;
		$('.po_item_list').each( function(){
		var itemId = $(this).attr('idler');
		// console.log(itemId );
		var ths_qty = parseFloat( $('#new-po_item_qty' + itemId).val() );
		if( isNaN( ths_qty ) ){
		ths_qty = 0;
		}
		
		var ths_price = parseFloat( $('#new-po_item_price' + itemId).val() );
		if( isNaN( ths_price ) ){
		ths_price = 0;
		}
		var thsTot = ths_qty * ths_price;
		totBeforeVat = totBeforeVat + thsTot;
		$('#new-po_item_tot' + itemId).val( insertDecimal(thsTot) );
		
		
		} );
		
		$('.pred_po_items').each( function(){
		var itemId = $(this).attr('idler');
		// console.log(itemId );
		var ths_qty = parseFloat( $('#new-po_lim_qty' + itemId).val() );
		if( isNaN( ths_qty ) ){
		ths_qty = 0;
		}
		
		var ths_price = parseFloat( $('#new-po_lim_price' + itemId).val() );
		if( isNaN( ths_price ) ){
		ths_price = 0;
		}
		
		var thsTot = ths_qty * ths_price;
		totBeforeVat = totBeforeVat + thsTot;
		$('#new-po_lim_tot' + itemId).val( insertDecimal(thsTot) );
		
		
		} );
		
		var disAmount = 0;
		/*
		var discount_percentage = parseFloat( $('#new-discount_per').val() );
		if( isNaN( discount_percentage ) ){
		discount_percentage = 0;
		}
		*/
		
		
		
		
		discount_percentage = 0;
		var is_vat = parseInt( $('#new-is_vat_included').val() );
		var discount_amount = totBeforeVat * (discount_percentage / 100 );
		
		
		vatPer = 0.05;
		if( is_vat == 0 ){
		vatPer = 0;
		}
		
		var totAfterVat = 0;
		var totVat      = 0;
		
		
		totBeforeVat = totBeforeVat - discount_amount;
		totVat = totBeforeVat * vatPer;
		totAfterVat = totBeforeVat + totVat;
		
		
		// $('#new-discount_amount').val( discount_amount.toFixed(3) );
		$('#new-total_before_vat').val( insertDecimal(totBeforeVat) );
		$('#new-total_vat_amount').val( insertDecimal(totVat) );
		$('#new-all_total').val( insertDecimal(totAfterVat) );
		
		
		}
		
		
		
		function delPoItem( IDD ){
		var aa = confirm('Are you sure, this will remove the item from PO, you can undo by refreshing the page ?');
		if( aa == true ){
		$('#' + IDD).remove();
		cal_table();
		}
		}
		
		
		
		
		
		function initTableEvents(){
		$('.item_qtys').on( 'input', function(){
		cal_table();
		} );
		$('.item_prices').on( 'input', function(){
		cal_table();
		} );
		$('#new-discount_amount').on( 'input', function(){
		// cal_table();
		} );
		$('#new-is_vat_included').on( 'input', function(){
		cal_table();
		} );
		$('#new-discount_per').on( 'input', function(){
		cal_table();
		} );
		}
		
		var added_PO_terms = $('#added_PO_terms').html();
		
		function resetTerms(){
		$('#added_PO_terms').html('');
		$('#added_PO_terms').html(added_PO_terms);
		}
		
		var added_PO_items = $('#added_PO_items').html();
		
		function resetItems(){
		$('#added_PO_items').html('');
		$('#added_PO_items').html(added_PO_items);
		cal_table();
		}
		
		
		
		init_nwFormGroup();
		
		initTableEvents();
		cal_table();
		</script>
				
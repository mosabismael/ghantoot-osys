<?php
	
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	try{
		
		if(!isset($_POST['requisition_id'])){
			die('7wiu');
		}
		if(!isset($_POST['req_item_id'])){
			die('7wiu02');
		}
		$is_print = 0;
		
		if( isset($_POST['is_print']) ){
			$is_print = 1;
		}
		
		
		$view_only = 0;
		
		if( isset($_POST['view_only']) ){
			$view_only = 1;
		}
		
		
		
		
		
		
		$requisition_id = (int) $_POST['requisition_id'];
		$req_item_id    = (int) $_POST['req_item_id'];
		
		
		$qu_pur_requisitions_sel = "SELECT * FROM  `pur_requisitions` WHERE `requisition_id` = $requisition_id";
		$userStatement = mysqli_prepare($KONN,$qu_pur_requisitions_sel);
		mysqli_stmt_execute($userStatement);
		$qu_pur_requisitions_EXE = mysqli_stmt_get_result($userStatement);
		$pur_requisitions_DATA;
		if(mysqli_num_rows($qu_pur_requisitions_EXE)){
			$pur_requisitions_DATA = mysqli_fetch_assoc($qu_pur_requisitions_EXE);
		}
		$created_date = $pur_requisitions_DATA['created_date'];
		$required_date = $pur_requisitions_DATA['required_date'];
		$estimated_date = $pur_requisitions_DATA['estimated_date'];
		$requisition_ref = $pur_requisitions_DATA['requisition_ref'];
		$requisition_type = $pur_requisitions_DATA['requisition_type'];
		$job_order_id = $pur_requisitions_DATA['job_order_id'];
		$requisition_status = $pur_requisitions_DATA['requisition_status'];
		$requisition_notes = $pur_requisitions_DATA['requisition_notes'];
		$ordered_by = $pur_requisitions_DATA['ordered_by'];
		$BY = get_emp_name($KONN, $pur_requisitions_DATA['ordered_by'] );
		
		
		
		
		$qu_pur_requisitions_items_sel = "SELECT * FROM  `pur_requisitions_items` WHERE `req_item_id` = $req_item_id";
		$userStatement = mysqli_prepare($KONN,$qu_pur_requisitions_items_sel);
		mysqli_stmt_execute($userStatement);
		$qu_pur_requisitions_items_EXE = mysqli_stmt_get_result($userStatement);
		$pur_requisitions_items_DATA;
		if(mysqli_num_rows($qu_pur_requisitions_items_EXE)){
			$pur_requisitions_items_DATA = mysqli_fetch_assoc($qu_pur_requisitions_items_EXE);
		}
		$req_item_id = $pur_requisitions_items_DATA['req_item_id'];
		$family_id = $pur_requisitions_items_DATA['family_id'];
		$section_id = $pur_requisitions_items_DATA['section_id'];
		$division_id = $pur_requisitions_items_DATA['division_id'];
		$subdivision_id = $pur_requisitions_items_DATA['subdivision_id'];
		$category_id = $pur_requisitions_items_DATA['category_id'];
		$item_code_id = $pur_requisitions_items_DATA['item_code_id'];
		$item_qty = (double) $pur_requisitions_items_DATA['item_qty'];
		$certificate_required = $pur_requisitions_items_DATA['certificate_required'];
		$item_unit_id = $pur_requisitions_items_DATA['item_unit_id'];
		$requisition_id = $pur_requisitions_items_DATA['requisition_id'];	
		
		
		$item_unit_name = get_unit_name( $pur_requisitions_items_DATA['item_unit_id'], $KONN );
		
		$family_id = $pur_requisitions_items_DATA['family_id'];
		$lv2 = $pur_requisitions_items_DATA['section_id'];
		$lv3 = $pur_requisitions_items_DATA['division_id'];
		$lv4 = $pur_requisitions_items_DATA['subdivision_id'];
		$lv5 = $pur_requisitions_items_DATA['category_id'];
		
		
		
		$item_name = get_item_description( $pur_requisitions_items_DATA['req_item_id'], 'req_item_id', 'pur_requisitions_items', $KONN );
		
		
		//check if this item is already approved or no
		$isApproved = false;
		$APP_pl_record_id = 0;
		$qu_pur_requisitions_pls_items_sel = "SELECT * FROM  `pur_requisitions_pls_items` WHERE 
		((`requisition_id` = $requisition_id) AND 
		(`is_approved` = '1') AND 
		(`requisition_item_id` = $req_item_id));";
		$userStatement = mysqli_prepare($KONN,$qu_pur_requisitions_pls_items_sel);
		mysqli_stmt_execute($userStatement);
		$qu_pur_requisitions_pls_items_EXE = mysqli_stmt_get_result($userStatement);
		$pur_requisitions_pls_items_DATA;
		if( mysqli_num_rows($qu_pur_requisitions_pls_items_EXE) == 1 ){
			$pur_requisitions_pls_items_DATA = mysqli_fetch_assoc($qu_pur_requisitions_pls_items_EXE);
			$APP_pl_record_id = ( int ) $pur_requisitions_pls_items_DATA['pl_record_id'];
			$isApproved = true;
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
	?>
	<table class="tabler" border="1">
		<thead>
			<?php
				if( $is_print == 0 ){
				?>
				<tr>
					<th colspan="9">
						
						<a href="prints/print_cr.php?req_item_id=<?=$req_item_id; ?>&requisition_id=<?=$requisition_id; ?>" target="_blank">
							<i class="fas fa-print"></i>
						</a>
					</th>
				</tr>
				<tr>
					<th colspan="9">
						<?=lang("Comparison_Sheet", "AAR"); ?>
					</th>
				</tr>
				<?php
				}
			?>
			<tr>
				<th rowspan="4"><?=$requisition_ref; ?></th>
				<?php
					$qu_pur_requisitions_pls_items_sel = "SELECT * FROM  `pur_requisitions_pls_items` WHERE 
					((`requisition_item_id` = $req_item_id) AND
					(`requisition_id` = $requisition_id))";
					$userStatement = mysqli_prepare($KONN,$qu_pur_requisitions_pls_items_sel);
					mysqli_stmt_execute($userStatement);
					$qu_pur_requisitions_pls_items_EXE = mysqli_stmt_get_result($userStatement);
					if(mysqli_num_rows($qu_pur_requisitions_pls_items_EXE)){
						while($pur_requisitions_pls_items_REC = mysqli_fetch_assoc($qu_pur_requisitions_pls_items_EXE)){
							
							$pl_record_id = $pur_requisitions_pls_items_REC['pl_record_id'];
							
							$pl_item_price = $pur_requisitions_pls_items_REC['pl_item_price'];
							$price_list_id = $pur_requisitions_pls_items_REC['price_list_id'];
							$rfq_id = $pur_requisitions_pls_items_REC['rfq_id'];
							$supplier_id = $pur_requisitions_pls_items_REC['supplier_id'];
							
							$supplier_name = get_supplier_name( $supplier_id, $KONN );
							$supplier_name_ARR = explode('-', $supplier_name);
							
							$CSS = '';
							if( $APP_pl_record_id == $pl_record_id ){
								$CSS = 'bs-green';
							}
						?>
						<th colspan="4" class="<?=$CSS; ?>">
							<?=trim($supplier_name_ARR[0]); ?><br><?=trim($supplier_name_ARR[1]); ?>
							<?php
								if( $isApproved == false ){
								?>
								
								<?php
									if( $is_print == 0 ){
									?>
									<div class="viewerBodyButtons">
										<button type="button" onclick="approvePriceListItem(  <?=$supplier_id; ?>,  <?=$rfq_id; ?>,  <?=$price_list_id; ?>,  <?=$req_item_id; ?> ,  <?=$requisition_id; ?> ,  <?=$pl_record_id; ?> );" title="Approve Price From <?=trim($supplier_name_ARR[1]); ?>" style="font-size: 10px;"><?=lang("Approve", "AAR"); ?></button>
									</div>
									<?php
									}
								?>
								
								<?php
								}
							?>
						</th>
						<?php
						}
					}
				?>
			</tr>
			<tr>
				<?php	$qu_pur_requisitions_pls_items_sel = "SELECT * FROM  `pur_requisitions_pls_items` WHERE 
					((`requisition_item_id` = $req_item_id) AND
					(`requisition_id` = $requisition_id))";
					$userStatement = mysqli_prepare($KONN,$qu_pur_requisitions_pls_items_sel);
					mysqli_stmt_execute($userStatement);
					$qu_pur_requisitions_pls_items_EXE = mysqli_stmt_get_result($userStatement);
					if(mysqli_num_rows($qu_pur_requisitions_pls_items_EXE)){
						while($pur_requisitions_pls_items_REC = mysqli_fetch_assoc($qu_pur_requisitions_pls_items_EXE)){
							
							
						?>
						<th title="Item Price" style="width: 8%;"><?=lang("Unit<br>Price", "AAR"); ?></th>
						<th title="Qty" style="width: 8%;"><?=lang("Qty", "AAR"); ?></th>
						<th title="delivery Period" style="width: 8%;"><?=lang("Delivery<br>Period", "AAR"); ?></th>
						<th title="Payment Term" style="width: 8%;"><?=lang("Payment<br>Term", "AAR"); ?></th>
						<?php
						}
					}
				?>
			</tr>
		</thead>
		<tbody class="text-center">
			<tr>
				<td><?=$item_name; ?></td>
				<?php
					$qu_pur_requisitions_pls_items_sel = "SELECT * FROM  `pur_requisitions_pls_items` WHERE 
					((`requisition_item_id` = $req_item_id) AND
					(`requisition_id` = $requisition_id))";
					$userStatement = mysqli_prepare($KONN,$qu_pur_requisitions_pls_items_sel);
					mysqli_stmt_execute($userStatement);
					$qu_pur_requisitions_pls_items_EXE = mysqli_stmt_get_result($userStatement);
					if(mysqli_num_rows($qu_pur_requisitions_pls_items_EXE)){
						while($pur_requisitions_pls_items_REC = mysqli_fetch_assoc($qu_pur_requisitions_pls_items_EXE)){
							
							$pl_record_id = $pur_requisitions_pls_items_REC['pl_record_id'];
							
							$pl_item_price = (double) $pur_requisitions_pls_items_REC['pl_item_price'];
							$item_qty = (double) $pur_requisitions_pls_items_REC['item_qty'];
							$price_list_id = $pur_requisitions_pls_items_REC['price_list_id'];
							$rfq_id = $pur_requisitions_pls_items_REC['rfq_id'];
							$supplier_id = $pur_requisitions_pls_items_REC['supplier_id'];
							
							$qu_gen_delivery_periods_sel = "SELECT `delivery_period_id`, `payment_term_id` FROM  `pur_requisitions_pls` WHERE `price_list_id` = $price_list_id";
							$userStatement = mysqli_prepare($KONN,$qu_gen_delivery_periods_sel);
							mysqli_stmt_execute($userStatement);
							$qu_pur_requisitions_pls_EXE = mysqli_stmt_get_result($userStatement);
							$pur_requisitions_pls_DATA;
							if(mysqli_num_rows($qu_pur_requisitions_pls_EXE)){
								$pur_requisitions_pls_DATA = mysqli_fetch_assoc($qu_pur_requisitions_pls_EXE);
							}
							$delivery_period_id = $pur_requisitions_pls_DATA['delivery_period_id'];
							$payment_term_id = $pur_requisitions_pls_DATA['payment_term_id'];
							
							$qu_gen_delivery_periods_sel = "SELECT `delivery_period_title` FROM  `gen_delivery_periods` WHERE `delivery_period_id` = $delivery_period_id";
							$userStatement = mysqli_prepare($KONN,$qu_gen_delivery_periods_sel);
							mysqli_stmt_execute($userStatement);
							$qu_gen_delivery_periods_EXE = mysqli_stmt_get_result($userStatement);
							$gen_delivery_periods_DATA;
							if(mysqli_num_rows($qu_gen_delivery_periods_EXE)){
								$gen_delivery_periods_DATA = mysqli_fetch_assoc($qu_gen_delivery_periods_EXE);
							}
							$delivery_period_title = $gen_delivery_periods_DATA['delivery_period_title'];
							
							
							$qu_gen_delivery_periods_sel = "SELECT `payment_term_title` FROM  `gen_payment_terms` WHERE `payment_term_id` = $payment_term_id";
							$userStatement = mysqli_prepare($KONN,$qu_gen_delivery_periods_sel);
							mysqli_stmt_execute($userStatement);
							$qu_gen_delivery_periods_EXE = mysqli_stmt_get_result($userStatement);
							$gen_delivery_periods_DATA;
							if(mysqli_num_rows($qu_gen_delivery_periods_EXE)){
								$gen_delivery_periods_DATA = mysqli_fetch_assoc($qu_gen_delivery_periods_EXE);
							}
							$payment_term_title = $gen_delivery_periods_DATA['payment_term_title'];
							
							
						?>
						<th title="unit Price"><?=number_format($pl_item_price, 3); ?></th>
						<th title="Qty Available"><?=$item_qty; ?></th>
						<th title="delivery Period"><?=$delivery_period_title; ?></th>
						<th title="Payment Term"><?=$payment_term_title; ?></th>
						<?php
						}
					}
				?>
			</tr>
			<tr>
				<td>Total Before VAT</td>
				<?php
					
					$qu_pur_requisitions_pls_items_sel = "SELECT `pl_record_id`, `pl_item_price`, `item_qty` FROM  `pur_requisitions_pls_items` WHERE 
					((`requisition_item_id` = $req_item_id) AND
					(`requisition_id` = $requisition_id))";
					$userStatement = mysqli_prepare($KONN,$qu_pur_requisitions_pls_items_sel);
					mysqli_stmt_execute($userStatement);
					$qu_pur_requisitions_pls_items_EXE = mysqli_stmt_get_result($userStatement);
					if(mysqli_num_rows($qu_pur_requisitions_pls_items_EXE)){
						while($pur_requisitions_pls_items_REC = mysqli_fetch_assoc($qu_pur_requisitions_pls_items_EXE)){
							
							$pl_record_id = (int) $pur_requisitions_pls_items_REC['pl_record_id'];
							$pl_item_price = (double) $pur_requisitions_pls_items_REC['pl_item_price'];
							$pl_item_qty = (double) $pur_requisitions_pls_items_REC['item_qty'];
							
							$ths_TOT = $pl_item_price * $pl_item_qty;
							
							$CSS = '';
							if( $APP_pl_record_id == $pl_record_id ){
								$CSS = 'bs-green';
							}
							
						?>
						<th title="Sub Total" colspan="4" class="<?=$CSS; ?>"><?=number_format($ths_TOT, 3); ?></th>
						<?php
						}
					}
				?>
			</tr>
			<tr>
				<td>VAT (5%)</td>
				<?php
					$qu_pur_requisitions_pls_items_sel = "SELECT `pl_record_id`, `pl_item_price`, `item_qty` FROM  `pur_requisitions_pls_items` WHERE 
					((`requisition_item_id` = $req_item_id) AND
					(`requisition_id` = $requisition_id))";
					$userStatement = mysqli_prepare($KONN,$qu_pur_requisitions_pls_items_sel);
					mysqli_stmt_execute($userStatement);
					$qu_pur_requisitions_pls_items_EXE = mysqli_stmt_get_result($userStatement);
					if(mysqli_num_rows($qu_pur_requisitions_pls_items_EXE)){
						while($pur_requisitions_pls_items_REC = mysqli_fetch_assoc($qu_pur_requisitions_pls_items_EXE)){
							
							$pl_record_id = (int) $pur_requisitions_pls_items_REC['pl_record_id'];
							$pl_item_price = (double) $pur_requisitions_pls_items_REC['pl_item_price'];
							$pl_item_qty = (double) $pur_requisitions_pls_items_REC['item_qty'];
							
							$ths_TOT = $pl_item_price * $pl_item_qty;
							$ths_VAT = $ths_TOT * 0.05;
							$CSS = '';
							if( $APP_pl_record_id == $pl_record_id ){
								$CSS = 'bs-green';
							}
							
						?>
						<th title="VAT Amount" colspan="4" class="<?=$CSS; ?>"><?=number_format($ths_VAT, 3); ?></th>
						<?php
						}
					}
				?>
			</tr>
			<tr>
				<td>Total After VAT</td>
				<?php
					$qu_pur_requisitions_pls_items_sel = "SELECT `pl_record_id`, `pl_item_price`, `item_qty` FROM  `pur_requisitions_pls_items` WHERE 
					((`requisition_item_id` = $req_item_id) AND
					(`requisition_id` = $requisition_id))";
					$userStatement = mysqli_prepare($KONN,$qu_pur_requisitions_pls_items_sel);
					mysqli_stmt_execute($userStatement);
					$qu_pur_requisitions_pls_items_EXE = mysqli_stmt_get_result($userStatement);
					if(mysqli_num_rows($qu_pur_requisitions_pls_items_EXE)){
						while($pur_requisitions_pls_items_REC = mysqli_fetch_assoc($qu_pur_requisitions_pls_items_EXE)){
							
							$pl_record_id = (int) $pur_requisitions_pls_items_REC['pl_record_id'];
							$pl_item_price = (double) $pur_requisitions_pls_items_REC['pl_item_price'];
							$pl_item_qty = (double) $pur_requisitions_pls_items_REC['item_qty'];
							
							$ths_TOT = $pl_item_price * $pl_item_qty;
							$ths_VAT = $ths_TOT * 0.05;
							$aftr_VAT = $ths_TOT + $ths_VAT;
							
							$CSS = '';
							if( $APP_pl_record_id == $pl_record_id ){
								$CSS = 'bs-green';
							}
							
						?>
						<th title="Total Amount" colspan="4" class="<?=$CSS; ?>"><?=number_format($aftr_VAT, 3); ?>
							<?php
								if( $APP_pl_record_id == $pl_record_id ){
								?>
								
								
								
								<?php
									if( $is_print == 0 ){
									?>
									<br>
									<button type="button" onclick="$( '#deciForm' ).slideToggle();"><?=lang("Change Decision", "AAR"); ?></button>
									
									<?php
									}
								?>
								
								
								
								<?php
								}
							?>
						</th>
						
						
						
						
						<?php
						}
					}
				?>
			</tr>
		</tbody>
	</table>
	
	<?php
		if( $is_print == 0 ){
		?>
		
		<?php
			if( $isApproved == true ){
			?>
			
			<div id="deciForm" class="row col-50" style="float: none !important;clear: both;display: block;margin: 0 auto !important;">
				<div class="nwFormGroup">
					<label style="width: 100%;text-align: center;"><?=lang("Reason", "AAR"); ?></label><br>
					<textarea style="width: 100%;" id="cd_notes" rows="5"></textarea>
				</div>
				
				<div class="viewerBodyButtons">
					<button type="button" onclick="changeCsDecision( <?=$APP_pl_record_id; ?>, <?=$req_item_id; ?> );"><?=lang("Change Decision", "AAR"); ?></button>
				</div>
			</div>
			
			<div class="zero"></div>
			<?php
			}
		?>		
		<?php
		}
	?>
	
	<?php
		if( $is_print == 0 ){
		?>
		
		<script>
			$( '#deciForm' ).slideUp('fast');
		</script>
		<?php
		}
	}
	catch(Exception $e){
		if ( is_resource($KONN)) {
			mysqli_close($KONN);
		}
	}
	finally{
		if ( is_resource($KONN)) {
			mysqli_close($KONN);
		}
	}
?>
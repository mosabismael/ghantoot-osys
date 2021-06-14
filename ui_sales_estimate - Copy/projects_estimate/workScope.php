
<div class="form-grp">
	<a id = "genQuote" href = "quotations_new.php?project_id=<?=$project_id?>">Generate quotation</a>
	<div class="form-item col-100">
		<table class="tabler">
			<thead>
				<tr>
					<th><?=lang('---')?></th>
					<th><?=lang('No.')?></th>
					<th><?=lang('name'); ?></th>
					<th><?=lang('UOM'); ?></th>
					<th><?=lang('qty'); ?></th>
					<th><?=lang('price'); ?></th>
					<th><?=lang('Totals'); ?></th>
				</tr>
			</thead>
			<tbody>
				
				<tr id="wos_added_items"><td colspan="6"><hr></td></tr>	
				<tr>
					<td>
						
					</td>
					<td>
						
					</td>
					<td>
						<div class="form-item">
							<input type="text" placeholder="<?=lang('item_name'); ?>" id="wos_name" value="">
						</div>
					</td>
					<td>
						<div class="form-item">
							<select id="wos_item_unit" class="data-elem">
								<option value="0" disabled selected><?=lang('---select Unit ---'); ?></option>
								<?php
									$qpt = "SELECT * FROM `gen_items_units`";
									$QER_E = mysqli_query($KONN, $qpt);
									if(mysqli_num_rows($QER_E) > 0){
										while($pt_dt = mysqli_fetch_assoc($QER_E)){
										?>
										<option value="<?=$pt_dt['unit_id']; ?>" id="wos_uniter-<?=$pt_dt['unit_id']; ?>" uniter="<?=$pt_dt['unit_name']; ?>"><?=$pt_dt['unit_name']; ?></option>
										<?php
										}
									}
								?>
							</select>
						</div>
					</td>
					<td>
						<div class="form-item">
							<input type="text" placeholder="<?=lang('item_qty'); ?>" id="wos_qty" >
						</div>
					</td>
					<td>
						<div class="form-item">
							<input type="text" placeholder="<?=lang('item_price'); ?>" id="wos_price" >
						</div>
					</td>
					
					<td>
						<div class="form-item">
							<button class="btn btn-info" onclick="add_item1();" type="button">&nbsp;&nbsp;&nbsp;<?=lang('Add_item'); ?>&nbsp;&nbsp;&nbsp;</button>
						</div>
					</td>
				</tr>
				
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>Total Amount </td>
					<td><div class="form-item">
						<input type="text" placeholder="<?=lang('item_price'); ?>" id="wos_total_amount" >
					</div></td>
				</tr>
			</tbody>
			
		</table>
		
	</div>
	<div class="zero"></div>
</div>



<script>
	var items_c = 0;
	var itemsCount = 0;
	function add_item1(){
		//collect data
		items_c++;
		var item_name = $('#wos_name').val();
		var item_qty = parseInt( $('#wos_qty').val() );
		if( isNaN( item_qty ) ){
			item_qty = 0;
		}
		var item_unit = "";
		
		var ths_tot = 0;
		var item_price = parseFloat( $('#wos_price').val() );
		
		if( isNaN( item_price ) ){
			item_price = 0;
		}
		var item_unit = parseInt( $('#wos_item_unit').val() );
				if( isNaN( item_unit ) ){
					item_unit = 0;
				}
		
		var inputer = '';
		var item_unit_name = $('#wos_uniter-' + item_unit).attr("uniter");
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
		if(document.getElementById('wos_total_amount').value!=""){
			var totalAmount=parseInt(document.getElementById('wos_total_amount').value)+parseInt(ths_tot);
			$('#wos_total_amount').val(totalAmount.toFixed(3));
		}
		else{
			$('#wos_total_amount').val(ths_tot.toFixed(3));
			
		}
		if(item_name != ""){
			var id = add_work_scope_table(item_name, item_qty, item_price,item_unit);
			var nw_tr = '<tr id="itemo-' + items_c + '" class="quote_item" idler="' + items_c + '">'+ 
			'<td><i onclick="rem_item1(' + id + ');" class="fa fa-trash" style="color:red;cursor:pointer;" area-hidden="true"></i></td>'+ 
			'<td class="item-c">' + items_c + '</td>'+ 
			'<td>' + item_name + '</td>'+ 
			'<td>'+item_unit_name+'</td>'+
			'<td><span class="qtyer">' + item_qty + '('+item_unit_name+ ')'+ '</td>'+ 
			'<td class="pricer">' + item_price.toFixed(3) + '</td>'+ 
			'<td class="pricer">' + ths_tot.toFixed(3) + '</td>'+ 
			'' + inputer +
			'</tr>';
			
			$('#wos_added_items').before(nw_tr);
			ClearInputForm1();
			itemsCount++;
			
			} else {
			alert( "Please Insert Item Name" );
		}
		
		
		
		
		
		
		
	}
	
	function ClearInputForm1(){
		$('#wos_name').val('');
		$('#wos_qty').val('');
		$('#wos_unit').val('0');
		$('#wos_price').val('');
		$('#wos_item_unit').val('0');
	}
	
	
	function rem_item1(idd){
		$('#itemo-' + idd).remove();
		itemsCount--;
		removeworkscope(idd);
		fix_counters();
	}
	function add_work_scope_table(item_name, item_qty, item_price, unit_id){
		$.ajax({
			type: "GET",
			url: "projects_estimate/add_work_scope_table.php",
			data: {'item_name':item_name,'item_qty':item_qty,'item_price':item_price,'project_id':<?=$project_id?>, "unit_id":unit_id},
			dataType :"json",
			success: function(response) {
				res = response;
			},
			error: function (error) {
				alert("ERR|add_work_scope_table");
			}
		});
	}
	
	function removeworkscope(id){
		$.ajax({
			type: "GET",
			url: "projects_estimate/remove_work_scope.php",
			data: {'scope_id':id},
			dataType :"json",
			success: function(response) {
				res = response;
			},
			error: function (error) {
				alert("ERR|removeworkscope");
			}
		});
	}
	
	
</script>
<script>
	function totalAmount(){
		var qty = $("wos_qty").val();
		var price = $("wos_price").vla();
		var total = qty*price;
		$("wos_total").val(total);
	}
</script>

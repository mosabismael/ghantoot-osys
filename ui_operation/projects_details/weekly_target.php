
	<div class="form-grp">
	
		<div class="form-item col-100">
			<table class="tabler">
				<thead>
					<tr>
						<th colspan="4">
							<select name="" class="monther">
								<option value="0" disabled selected><?=lang('---Select_Month ---'); ?></option>
<?php
	for($i=1;$i<=12;$i++){
		$iView = ( $i < 10 ) ? '0'.$i : ''.$i;
?>
		<option value="<?=$i; ?>"><?=$iView; ?></option>
<?php
	}
?>
							</select>
						</th>
						<th colspan="4">
							<select name="" class="weeker">
								<option value="0" disabled selected><?=lang('---Select_Week ---'); ?></option>
								<option value="1">W-01</option>
								<option value="2">W-02</option>
								<option value="3">W-03</option>
								<option value="4">W-04</option>
							</select>
						</th>
					</tr>
				</thead>
				<thead>
					<tr>
						<th style="width:40%;"><?=lang('---'); ?></th>
						<th><?=lang('1'); ?></th>
						<th><?=lang('2'); ?></th>
						<th><?=lang('3'); ?></th>
						<th><?=lang('4'); ?></th>
						<th><?=lang('5'); ?></th>
						<th><?=lang('6'); ?></th>
						<th><?=lang('7'); ?></th>
					</tr>
				</thead>
<?php
	$qu_job_orders_processes_sel = "SELECT * FROM  `job_orders_processes` WHERE `job_order_id` = $job_order_id";
	$qu_job_orders_processes_EXE = mysqli_query($KONN, $qu_job_orders_processes_sel);
	if(mysqli_num_rows($qu_job_orders_processes_EXE)){
		while($job_orders_processes_REC = mysqli_fetch_assoc($qu_job_orders_processes_EXE)){
			$process_id = $job_orders_processes_REC['process_id'];
			$process_name = $job_orders_processes_REC['process_name'];
			$job_order_id = $job_orders_processes_REC['job_order_id'];
		?>
				<tbody id="tl-process-<?=$process_id; ?>">
			<tr class="joProcess">
				<td class="text-left"><span class="jo_p">P</span><?=$process_name; ?></td>
				<td>---</td>
				<td>---</td>
				<td>---</td>
				<td>---</td>
				<td>---</td>
				<td>---</td>
				<td>---</td>
			</tr>
			
			
<?php
	$qu_job_orders_processes_acts_sel = "SELECT * FROM  `job_orders_processes_acts` WHERE `process_id` = $process_id";
	$qu_job_orders_processes_acts_EXE = mysqli_query($KONN, $qu_job_orders_processes_acts_sel);
	if(mysqli_num_rows($qu_job_orders_processes_acts_EXE)){
		while($job_orders_processes_acts_REC = mysqli_fetch_assoc($qu_job_orders_processes_acts_EXE)){
			$activity_id = $job_orders_processes_acts_REC['activity_id'];
			$activity_name = $job_orders_processes_acts_REC['activity_name'];
			$process_id = $job_orders_processes_acts_REC['process_id'];
			$job_order_id = $job_orders_processes_acts_REC['job_order_id'];
		?>
			<tr class="joActivity" id="tl-activity-<?=$activity_id; ?>">
				<td class="text-left"><span class="jo_a">A</span><?=$activity_name; ?></td>
				<td>---</td>
				<td>---</td>
				<td>---</td>
				<td>---</td>
				<td>---</td>
				<td>---</td>
				<td>---</td>
			</tr>
			
			
			
<?php
	$qu_job_orders_processes_acts_tasks_sel = "SELECT * FROM  `job_orders_processes_acts_tasks` WHERE `activity_id` = $activity_id";
	$qu_job_orders_processes_acts_tasks_EXE = mysqli_query($KONN, $qu_job_orders_processes_acts_tasks_sel);
	if(mysqli_num_rows($qu_job_orders_processes_acts_tasks_EXE)){
		while($job_orders_processes_acts_tasks_REC = mysqli_fetch_assoc($qu_job_orders_processes_acts_tasks_EXE)){
			$task_id = $job_orders_processes_acts_tasks_REC['task_id'];
			$task_name = $job_orders_processes_acts_tasks_REC['task_name'];
			$activity_id = $job_orders_processes_acts_tasks_REC['activity_id'];
			$process_id = $job_orders_processes_acts_tasks_REC['process_id'];
			$job_order_id = $job_orders_processes_acts_tasks_REC['job_order_id'];
		?>
			<tr class="joTask" id="tl-task-<?=$task_id; ?>">
				<td class="text-left"><span class="jo_t">T</span><?=$task_name; ?></td>
				<td>---</td>
				<td>---</td>
				<td>---</td>
				<td>---</td>
				<td>---</td>
				<td>---</td>
				<td>---</td>
			</tr>
		<?php
		}
	}
?>
			
			
			
		<?php
		}
	}
?>
			
			
			
			
			
			
				</tbody>
		<?php
		}
	}
?>
				
				
			</table>
		</div>
		<div class="zero"></div>
	</div>

	

<script>
var items_c = 0;
var itemsCount = 0;
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
					'		id="tl-new-item_names' + items_c + '" ' + 
					'		name="item_names[]" ' + 
					'		req="1" ' + 
					'		den="" ' + 
					'		value="' + item_name + '"' + 
					'		alerter="Please_Check_Items">';
		inputer +=  '<input class="frmData" type="hidden" ' + 
					'		id="tl-new-item_qtys' + items_c + '" ' + 
					'		name="item_qtys[]" ' + 
					'		req="1" ' + 
					'		den="0" ' + 
					'		value="' + item_qty + '"' + 
					'		alerter="Please_Check_Items">';
		inputer +=  '<input class="frmData" type="hidden" ' + 
					'		id="tl-new-item_units' + items_c + '" ' + 
					'		name="item_units[]" ' + 
					'		req="1" ' + 
					'		den="0" ' + 
					'		value="' + item_unit + '"' + 
					'		alerter="Please_Check_Items">';
		inputer +=  '<input class="frmData" type="hidden" ' + 
					'		id="tl-new-item_prices' + items_c + '" ' + 
					'		name="item_prices[]" ' + 
					'		req="1" ' + 
					'		den="" ' + 
					'		value="' + item_price + '"' + 
					'		alerter="Please_Check_Items">';
					
					
		ths_tot = item_qty * item_price;
		
		
		if(item_name != ""){
			
			var nw_tr = '<tr id="tl-itemo-' + items_c + '" class="quote_item" idler="' + items_c + '">'+ 
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


function rem_item(idd){
	$('#itemo-' + idd).remove();
	itemsCount--;
	fix_counters();
}

function fix_counters(){
	
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
	
	
	
	
	
	
	var all = sub_tot + vat;
	
	
}


</script>

<br>
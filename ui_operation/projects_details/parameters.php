
	<div class="form-grp">
	
		<div class="form-item col-100">
			<table class="tabler">
				<thead>
					<tr>
						<th style="width:40%;"><?=lang('---'); ?></th>
						<th><?=lang('WL'); ?></th>
						<th><?=lang('UOM'); ?>(Days)</th>
						<th><?=lang('KPI'); ?></th>
						<th><?=lang('total_mhr'); ?></th>
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
				<tbody id="para-process-<?=$process_id; ?>">
			<tr class="joProcess">
				<td class="text-left"><span class="jo_p">P</span><?=$process_name; ?></td>
				<td><input type="text" name="" class="wl" ></td>
				<td><select name="" class="uom" ></select></td>
				<td><input type="text" name="" class="kpi" ></td>
				<td><input type="text" name="" class="total" ></td>
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
			<tr class="joActivity" id="para-activity-<?=$activity_id; ?>">
				<td class="text-left"><span class="jo_a">A</span><?=$activity_name; ?></td>
				<td><input type="text" name="" class="wl" ></td>
				<td><select name="" class="uom" ></select></td>
				<td><input type="text" name="" class="kpi" ></td>
				<td><input type="text" name="" class="total" ></td>
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
			<tr class="joTask" id="para-task-<?=$task_id; ?>">
				<td class="text-left"><span class="jo_t">T</span><?=$task_name; ?></td>
				<td><input type="text" name="" class="wl" ></td>
				<td><select name="" class="uom" ></select></td>
				<td><input type="text" name="" class="kpi" ></td>
				<td><input type="text" name="" class="total" ></td>
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

<div id="uomContainer" style="display:none;">
			<option value="0" disabled selected><?=lang('---Select Unit ---'); ?></option>
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
</div>

<script>
function initUOM(){
	var UOMs = $('#uomContainer').html();
	$('.uom').each( function(){
		$(this).html( UOMs );
	} );
}




initUOM();
</script>

<br>
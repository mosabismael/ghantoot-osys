
<table class="tabler">
	<thead>
		<tr>
			<th><?=lang("Sys_Id", "AAR"); ?></th>
			<th><?=lang("employee_Name", "AAR"); ?></th>
			<th><?=lang("Leave_Type", "AAR"); ?></th>
			<th><?=lang("start_time", "AAR"); ?></th>
			<th><?=lang("end_time", "AAR"); ?></th>
			<th><?=lang("Status", "AAR"); ?></th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
<?php

	$qu_hr_employees_leaves_sel = "SELECT * FROM  `hr_employees_leaves` WHERE `employee_id` = $employee_id";
	$qu_hr_employees_leaves_EXE = mysqli_query($KONN, $qu_hr_employees_leaves_sel);
	if(mysqli_num_rows($qu_hr_employees_leaves_EXE)){
		while($hr_employees_leaves_REC = mysqli_fetch_assoc($qu_hr_employees_leaves_EXE)){
			
			$leave_id = $hr_employees_leaves_REC['leave_id'];
			$employee_id = $hr_employees_leaves_REC['employee_id'];
			$leave_type_id = $hr_employees_leaves_REC['leave_type_id'];
			$start_date = $hr_employees_leaves_REC['start_date'];
			$end_date = $hr_employees_leaves_REC['end_date'];
			
			$leave_status = get_current_state($KONN, $leave_id, "hr_employees_leaves" );


	$qu_hr_employees_leave_types_sel = "SELECT * FROM  `hr_employees_leave_types` WHERE `leave_type_id` = $leave_type_id";
	$qu_hr_employees_leave_types_EXE = mysqli_query($KONN, $qu_hr_employees_leave_types_sel);
	$hr_employees_leave_types_DATA;
	if(mysqli_num_rows($qu_hr_employees_leave_types_EXE)){
		$hr_employees_leave_types_DATA = mysqli_fetch_assoc($qu_hr_employees_leave_types_EXE);
	}
	
		$leave_type_name = $hr_employees_leave_types_DATA['leave_type_name'];
		
		?>
		<tr id="leave-<?=$leave_id; ?>">
			<td>HRLV-<?=$leave_id; ?></td>
			<td class="cell-title"><?=$employee_code; ?> - <?=$first_name." ".$last_name; ?></td>
			<td><?=$leave_type_name; ?></td>
			<td><?=$start_date; ?></td>
			<td><?=$end_date; ?></td>
			<td class="stater"><?=$leave_status; ?></td>
			<td class="text-center">
<?php
	if( $leave_status == 'draft' ){
?>
<a onclick="activateLeave(<?=$leave_id; ?>);" id="act-<?=$leave_id; ?>" title="<?=lang("Activate", "AAR"); ?>"><i class="fas fa-check"></i></a>

<a onclick="approveLeave(<?=$leave_id; ?>);" id="app-<?=$leave_id; ?>" style="display:none;" title="<?=lang("Approve", "AAR"); ?>"><i class="fas fa-thumbs-up"></i></a>
<a onclick="denyLeave(<?=$leave_id; ?>);" id="den-<?=$leave_id; ?>" style="display:none;" title="<?=lang("Deny", "AAR"); ?>"><i class="fas fa-times"></i></a>

<?php
	} else if( $leave_status == 'pending_approval' ){
?>
<a onclick="approveLeave(<?=$leave_id; ?>);" id="app-<?=$leave_id; ?>" title="<?=lang("Approve", "AAR"); ?>"><i class="fas fa-thumbs-up"></i></a>
<a onclick="denyLeave(<?=$leave_id; ?>);" id="den-<?=$leave_id; ?>" title="<?=lang("Deny", "AAR"); ?>"><i class="fas fa-times"></i></a>

<?php
	} else {
?>
	---
<?php
	}
?>
			</td>
		</tr>
		<?php
		
		}
	}
	
?>
	</tbody>
</table>

<script>
function changeLeaveStatus( recID, state ){
	start_loader();
	$.ajax({
		url      :"<?=api_root; ?>hr/employee_leaves_status.php",
		data     :{'record': recID, 'status': state},
		dataType :"JSON",
		type     :'POST',
		success  :function(response){
			var res = response['result'];
			
			if( res == true ){
				
				var nw_stater = response['nw_stater'];
				$('#leave-' + recID + ' .stater').text( nw_stater );
				
				if( nw_stater == 'pending_approval' ){
					$('#act-' + recID).remove();
					$('#app-' + recID).css('display', 'inline-block');
					$('#den-' + recID).css('display', 'inline-block');
				} else {
					$('#app-' + recID).remove();
					$('#den-' + recID).remove();
				}
				
				
				
			} else {
				alert( 'Failed' );
			}
			
			end_loader();
		},
		error    :function(){
			alert('Code Not Applied');
		},
	});
}

function activateLeave( recID ){
	var aa = confirm("This will Activate current record");
	if( aa == true ){
		changeLeaveStatus( recID, '3' );
	}
}
function approveLeave( recID ){
	var aa = confirm("This will Approve current record");
	if( aa == true ){
		changeLeaveStatus( recID, '1' );
	}
}
function denyLeave( recID ){
	var aa = confirm("This will Deny current record");
	if( aa == true ){
		changeLeaveStatus( recID, '2' );
	}
}

</script>
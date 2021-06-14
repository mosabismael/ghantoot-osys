
<table class="tabler">
	<thead>
		<tr>
			<th><?=lang("Sys_Id", "AAR"); ?></th>
			<th><?=lang("employee", "AAR"); ?></th>
			<th><?=lang("Join_date", "AAR"); ?></th>
			<th><?=lang("allowance", "AAR"); ?></th>
			<th><?=lang("Type", "AAR"); ?></th>
			<th><?=lang("amount", "AAR"); ?></th>
			<th><?=lang("date", "AAR"); ?></th>
			<th><?=lang("Status", "AAR"); ?></th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
<?php

	$qu_hr_employees_allowances_sel = "SELECT * FROM  `hr_employees_allowances` WHERE `employee_id` = $employee_id";
	$qu_hr_employees_allowances_EXE = mysqli_query($KONN, $qu_hr_employees_allowances_sel);
	if(mysqli_num_rows($qu_hr_employees_allowances_EXE)){
		while($hr_employees_allowances_REC = mysqli_fetch_assoc($qu_hr_employees_allowances_EXE)){
			
			
			
			
			$record_id = $hr_employees_allowances_REC['record_id'];
			$employee_id = $hr_employees_allowances_REC['employee_id'];
			$allowance_id = $hr_employees_allowances_REC['allowance_id'];
			$allowance_type = $hr_employees_allowances_REC['allowance_type'];
			$allowance_amount = $hr_employees_allowances_REC['allowance_amount'];
			
			$active_from = $hr_employees_allowances_REC['active_from'];
			$active_to = $hr_employees_allowances_REC['active_to'];
			
			
			$allowance_status = get_current_state($KONN, $record_id, "hr_employees_allowances" );
			


	$qu_hr_employees_allowances_ids_sel = "SELECT * FROM  `hr_employees_allowances_ids` WHERE `allowance_id` = $allowance_id";
	$qu_hr_employees_allowances_ids_EXE = mysqli_query($KONN, $qu_hr_employees_allowances_ids_sel);
	$hr_employees_allowances_ids_DATA;
	if(mysqli_num_rows($qu_hr_employees_allowances_ids_EXE)){
		$hr_employees_allowances_ids_DATA = mysqli_fetch_assoc($qu_hr_employees_allowances_ids_EXE);
	}
	
		$allowance_title = $hr_employees_allowances_ids_DATA['allowance_title'];
		$allowance_description = $hr_employees_allowances_ids_DATA['allowance_description'];
		
		?>
		<tr id="all-<?=$record_id; ?>">
			<td>HRALW-<?=$record_id; ?></td>
			<td class="cell-title"><?=$employee_code; ?> - <?=$first_name." ".$last_name; ?></td>
			<td><?=$join_date; ?></td>
			<td><?=$allowance_title; ?></td>
			<td><?=$allowance_type; ?></td>
			<td><?=number_format($allowance_amount, 3); ?></td>
			<td><?=$active_from; ?> - <?=$active_to; ?></td>
			<td class="stater"><?=$allowance_status; ?></td>
			<td class="text-center">
<?php
	if( $allowance_status == 'draft' ){
?>
<a onclick="approveAllowance(<?=$record_id; ?>);" id="app-<?=$record_id; ?>" title="<?=lang("Approve", "AAR"); ?>"><i class="fas fa-thumbs-up"></i></a>
<a onclick="denyAllowance(<?=$record_id; ?>);" id="den-<?=$record_id; ?>" title="<?=lang("Deny", "AAR"); ?>"><i class="fas fa-times"></i></a>
<a onclick="deleteAllowance(<?=$record_id; ?>);" id="del-<?=$record_id; ?>" title="<?=lang("Delete", "AAR"); ?>"><i class="fas fa-trash-alt"></i></a>
<a onclick="deActivateAllowance(<?=$record_id; ?>);" id="dea-<?=$record_id; ?>" style="display:none;" title="<?=lang("Deactivate", "AAR"); ?>"><i class="fas fa-ban"></i></a>

<?php
	} else if( $allowance_status == 'approved' ){
?>
<a onclick="deActivateAllowance(<?=$record_id; ?>);" id="dea-<?=$record_id; ?>" title="<?=lang("Deactivate", "AAR"); ?>"><i class="fas fa-ban"></i></a>
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
function changeAllowanceStatus( recID, state ){
	start_loader();
	$.ajax({
		url      :"<?=api_root; ?>hr/employee_allowance_status.php",
		data     :{'record': recID, 'status': state},
		dataType :"JSON",
		type     :'POST',
		success  :function(response){
			var res = response['result'];
			
			if( res == true ){
				var nw_stater = response['nw_stater'];
				$('#all-' + recID + ' .stater').text( nw_stater );
				if( nw_stater == 'approved' ){
					$('#app-' + recID).remove();
					$('#den-' + recID).remove();
					$('#del-' + recID).remove();
					$('#dea-' + recID).css('display', 'inline-block');
				} else {
					$('#app-' + recID).remove();
					$('#den-' + recID).remove();
					$('#del-' + recID).remove();
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

function approveAllowance( recID ){
	var aa = confirm("This will Approve current record");
	if( aa == true ){
		changeAllowanceStatus( recID, '1' );
	}
}
function denyAllowance( recID ){
	var aa = confirm("This will Deny current record");
	if( aa == true ){
		changeAllowanceStatus( recID, '2' );
	}
}
function deleteAllowance( recID ){
	var aa = confirm("This will delete current record");
	if( aa == true ){
		changeAllowanceStatus( recID, '3' );
	}
}
function deActivateAllowance( recID ){
	var aa = confirm("This will Deactivate current record");
	if( aa == true ){
		changeAllowanceStatus( recID, '4' );
	}
}
</script>


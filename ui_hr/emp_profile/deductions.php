	
<table class="tabler">
	<thead>
		<tr>
			<th><?=lang("Sys_Id", "AAR"); ?></th>
			<th><?=lang("employee_Name", "AAR"); ?></th>
			<th><?=lang("Join_date", "AAR"); ?></th>
			<th><?=lang("deduction_amount", "AAR"); ?></th>
			<th><?=lang("Submission_date", "AAR"); ?></th>
			<th><?=lang("Effective_date", "AAR"); ?></th>
			<th><?=lang("Status", "AAR"); ?></th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
<?php

	$qu_hr_employees_deductions_sel = "SELECT * FROM  `hr_employees_deductions` WHERE `employee_id` = $employee_id";
	$qu_hr_employees_deductions_EXE = mysqli_query($KONN, $qu_hr_employees_deductions_sel);
	if(mysqli_num_rows($qu_hr_employees_deductions_EXE)){
		while($hr_employees_deductions_REC = mysqli_fetch_assoc($qu_hr_employees_deductions_EXE)){
			
			$deduction_id = $hr_employees_deductions_REC['deduction_id'];
			$employee_id = $hr_employees_deductions_REC['employee_id'];
			$deduction_date = $hr_employees_deductions_REC['deduction_date'];
			$deduction_effective_date = $hr_employees_deductions_REC['deduction_effective_date'];
			$deduction_amount = $hr_employees_deductions_REC['deduction_amount'];
			
			$deduction_status = get_current_state($KONN, $deduction_id, "hr_employees_deductions" );
			
			
		
		?>
		<tr id="ded-<?=$deduction_id; ?>">
			<td>HRDED-<?=$deduction_id; ?></td>
			<td class="cell-title"><?=$employee_code; ?> - <?=$first_name." ".$last_name; ?></td>
			<td><?=$join_date; ?></td>
			<td><?=number_format($deduction_amount, 3); ?></td>
			<td><?=$deduction_date; ?></td>
			<td><?=$deduction_effective_date; ?></td>
			<td class="stater"><?=$deduction_status; ?></td>
			<td class="text-center">
<?php
	if( $deduction_status == 'draft' ){
?>
<a onclick="activateDeduction(<?=$deduction_id; ?>);" id="act-<?=$deduction_id; ?>" title="<?=lang("Activate", "AAR"); ?>"><i class="fas fa-check"></i></a>

<a onclick="approveDeduction(<?=$deduction_id; ?>);" id="app-<?=$deduction_id; ?>" style="display:none;" title="<?=lang("Approve", "AAR"); ?>"><i class="fas fa-thumbs-up"></i></a>
<a onclick="denyDeduction(<?=$deduction_id; ?>);" id="den-<?=$deduction_id; ?>" style="display:none;" title="<?=lang("Deny", "AAR"); ?>"><i class="fas fa-times"></i></a>



<?php
	} else if( $deduction_status == 'pending_approval' ){
?>
<a onclick="approveDeduction(<?=$deduction_id; ?>);" id="app-<?=$deduction_id; ?>" title="<?=lang("Approve", "AAR"); ?>"><i class="fas fa-thumbs-up"></i></a>
<a onclick="denyDeduction(<?=$deduction_id; ?>);" id="den-<?=$deduction_id; ?>" title="<?=lang("Deny", "AAR"); ?>"><i class="fas fa-times"></i></a>

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
function changeDeductionStatus( recID, state ){
	start_loader();
	$.ajax({
		url      :"<?=api_root; ?>hr/employee_deduction_status.php",
		data     :{'record': recID, 'status': state},
		dataType :"JSON",
		type     :'POST',
		success  :function(response){
			var res = response['result'];
			
			if( res == true ){
				
				var nw_stater = response['nw_stater'];
				$('#ded-' + recID + ' .stater').text( nw_stater );
				
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

function activateDeduction( recID ){
	var aa = confirm("This will Activate current record");
	if( aa == true ){
		changeDeductionStatus( recID, '3' );
	}
}
function approveDeduction( recID ){
	var aa = confirm("This will Approve current record");
	if( aa == true ){
		changeDeductionStatus( recID, '1' );
	}
}
function denyDeduction( recID ){
	var aa = confirm("This will Deny current record");
	if( aa == true ){
		changeDeductionStatus( recID, '2' );
	}
}

</script>




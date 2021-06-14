
<table class="tabler">
	<thead>
		<tr>
			<th><?=lang("Sys_Id", "AAR"); ?></th>
			<th><?=lang("employee_Name", "AAR"); ?></th>
			<th><?=lang("start_time", "AAR"); ?></th>
			<th><?=lang("end_time", "AAR"); ?></th>
			<th><?=lang("Status", "AAR"); ?></th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
<?php

	$qu_hr_employees_vacations_sel = "SELECT * FROM  `hr_employees_vacations` WHERE `employee_id` = $employee_id";
	$qu_hr_employees_vacations_EXE = mysqli_query($KONN, $qu_hr_employees_vacations_sel);
	if(mysqli_num_rows($qu_hr_employees_vacations_EXE)){
		while($hr_employees_vacations_REC = mysqli_fetch_assoc($qu_hr_employees_vacations_EXE)){
			
			$vacation_id = $hr_employees_vacations_REC['vacation_id'];
			$employee_id = $hr_employees_vacations_REC['employee_id'];
			
			$start_date = $hr_employees_vacations_REC['start_date'];
			$end_date = $hr_employees_vacations_REC['end_date'];
			
			
			$vacation_status = get_current_state($KONN, $vacation_id, "hr_employees_vacations" );
			
			
		?>
		<tr id="vac-<?=$vacation_id; ?>">
			<td>HRVAC-<?=$vacation_id; ?></td>
			<td class="cell-title"><?=$employee_code; ?> - <?=$first_name." ".$last_name; ?></td>
			<td><?=$start_date; ?></td>
			<td><?=$end_date; ?></td>
			<td class="stater"><?=$vacation_status; ?></td>
			<td class="text-center">
<?php
	if( $vacation_status == 'draft' ){
?>
<a onclick="activateVacation(<?=$vacation_id; ?>);" id="act-<?=$vacation_id; ?>" title="<?=lang("Activate", "AAR"); ?>"><i class="fas fa-check"></i></a>

<a onclick="approveVacation(<?=$vacation_id; ?>);" id="app-<?=$vacation_id; ?>" style="display:none;" title="<?=lang("Approve", "AAR"); ?>"><i class="fas fa-thumbs-up"></i></a>
<a onclick="denyVacation(<?=$vacation_id; ?>);" id="den-<?=$vacation_id; ?>" style="display:none;" title="<?=lang("Deny", "AAR"); ?>"><i class="fas fa-times"></i></a>



<?php
	} else if( $vacation_status == 'pending_approval' ){
?>
<a onclick="approveVacation(<?=$vacation_id; ?>);" id="app-<?=$vacation_id; ?>" title="<?=lang("Approve", "AAR"); ?>"><i class="fas fa-thumbs-up"></i></a>
<a onclick="denyVacation(<?=$vacation_id; ?>);" id="den-<?=$vacation_id; ?>" title="<?=lang("Deny", "AAR"); ?>"><i class="fas fa-times"></i></a>

<?php
	} else {
?>
	---
<?php
	}
?>
			</td>
		<?php
		
		}
	}
	
?>
	</tbody>
</table>


<script>
function changeVacationStatus( recID, state ){
	start_loader();
	$.ajax({
		url      :"<?=api_root; ?>hr/employee_vacations_status.php",
		data     :{'record': recID, 'status': state},
		dataType :"JSON",
		type     :'POST',
		success  :function(response){
			var res = response['result'];
			
			if( res == true ){
				
				var nw_stater = response['nw_stater'];
				$('#vac-' + recID + ' .stater').text( nw_stater );
				
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

function activateVacation( recID ){
	var aa = confirm("This will Activate current record");
	if( aa == true ){
		changeVacationStatus( recID, '3' );
	}
}
function approveVacation( recID ){
	var aa = confirm("This will Approve current record");
	if( aa == true ){
		changeVacationStatus( recID, '1' );
	}
}
function denyVacation( recID ){
	var aa = confirm("This will Deny current record");
	if( aa == true ){
		changeVacationStatus( recID, '2' );
	}
}

</script>

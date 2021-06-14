
<table class="tabler">
	<thead>
		<tr>
			<th><?=lang("Sys_Id", "AAR"); ?></th>
			<th><?=lang("employee_Name", "AAR"); ?></th>
			<th><?=lang("Action", "AAR"); ?></th>
			<th><?=lang("State", "AAR"); ?></th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
<?php

	$qu_hr_employees_disp_actions_sel = "SELECT * FROM  `hr_employees_disp_actions` WHERE `employee_id` = $employee_id";
	$qu_hr_employees_disp_actions_EXE = mysqli_query($KONN, $qu_hr_employees_disp_actions_sel);
	if(mysqli_num_rows($qu_hr_employees_disp_actions_EXE)){
		while($hr_employees_disp_actions_REC = mysqli_fetch_assoc($qu_hr_employees_disp_actions_EXE)){
			
			$record_id = $hr_employees_disp_actions_REC['record_id'];
			$employee_id = $hr_employees_disp_actions_REC['employee_id'];
			$disp_action_id = $hr_employees_disp_actions_REC['disp_action_id'];
			
			
			$disp_act_status = get_current_state($KONN, $record_id, "hr_employees_disp_actions" );
			

	$qu_hr_disp_actions_sel = "SELECT * FROM  `hr_disp_actions` WHERE `disp_action_id` = $disp_action_id";
	$qu_hr_disp_actions_EXE = mysqli_query($KONN, $qu_hr_disp_actions_sel);
	$hr_disp_actions_DATA;
	if(mysqli_num_rows($qu_hr_disp_actions_EXE)){
		$hr_disp_actions_DATA = mysqli_fetch_assoc($qu_hr_disp_actions_EXE);
	}
		$disp_action_code = $hr_disp_actions_DATA['disp_action_code'];
		$disp_action_text = $hr_disp_actions_DATA['disp_action_text'];

		
		?>
		<tr id="da-<?=$record_id; ?>">
			<td>HRDA-<?=$record_id; ?></td>
			<td class="cell-title"><?=$employee_code; ?> - <?=$first_name." ".$last_name; ?></td>
			<td><?=$disp_action_code; ?></td>
			<td class="stater"><?=$disp_act_status; ?></td>
			<td class="text-center">
<?php
	if( $disp_act_status == 'draft' ){
?>
<a onclick="activateDispAct(<?=$record_id; ?>);" id="act-<?=$record_id; ?>" title="<?=lang("Activate", "AAR"); ?>"><i class="fas fa-check"></i></a>

<a onclick="approveDispAct(<?=$record_id; ?>);" id="app-<?=$record_id; ?>" style="display:none;" title="<?=lang("Approve", "AAR"); ?>"><i class="fas fa-thumbs-up"></i></a>
<a onclick="denyDispAct(<?=$record_id; ?>);" id="den-<?=$record_id; ?>" style="display:none;" title="<?=lang("Deny", "AAR"); ?>"><i class="fas fa-times"></i></a>



<?php
	} else if( $disp_act_status == 'pending_approval' ){
?>
<a onclick="approveDispAct(<?=$record_id; ?>);" id="app-<?=$record_id; ?>" title="<?=lang("Approve", "AAR"); ?>"><i class="fas fa-thumbs-up"></i></a>
<a onclick="denyDispAct(<?=$record_id; ?>);" id="den-<?=$record_id; ?>" title="<?=lang("Deny", "AAR"); ?>"><i class="fas fa-times"></i></a>

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
function changeDispActStatus( recID, state ){
	start_loader();
	$.ajax({
		url      :"<?=api_root; ?>hr/employee_disp_act_status.php",
		data     :{'record': recID, 'status': state},
		dataType :"JSON",
		type     :'POST',
		success  :function(response){
			var res = response['result'];
			
			if( res == true ){
				
				var nw_stater = response['nw_stater'];
				$('#da-' + recID + ' .stater').text( nw_stater );
				
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

function activateDispAct( recID ){
	var aa = confirm("This will Activate current record");
	if( aa == true ){
		changeDispActStatus( recID, '3' );
	}
}
function approveDispAct( recID ){
	var aa = confirm("This will Approve current record");
	if( aa == true ){
		changeDispActStatus( recID, '1' );
	}
}
function denyDispAct( recID ){
	var aa = confirm("This will Deny current record");
	if( aa == true ){
		changeDispActStatus( recID, '2' );
	}
}

</script>



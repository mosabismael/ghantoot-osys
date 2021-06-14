<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	
	
	
	
	$menuId = 7;
	$subPageID = 16;
	
	
	
	
	$job_order_id = 0;
	$typer        = 0;
	$ts_date_from = "";
	$ts_date_to   = "";
	
	
	if( isset( $_GET['job_order_id'] ) ){
		$job_order_id = ( int ) test_inputs( $_GET['job_order_id'] );
	}
	
	if( isset( $_GET['ts_date_from'] ) ){
		$ts_date_from = test_inputs( $_GET['ts_date_from'] );
	}
	
	if( isset( $_GET['ts_date_to'] ) ){
		$ts_date_to = test_inputs( $_GET['ts_date_to'] );
	}
	
	if( isset( $_GET['typer'] ) ){
		$typer = ( int ) test_inputs( $_GET['typer'] );
	}
	
	
	
	$COND = "";
	
	
	
	
	
	
?>
<!DOCTYPE html>
<html dir="<?=$lang_dir; ?>" lang="<?=$lang; ?>">
	<head>
		<?php include('app/meta.php'); ?>
		<?php include('app/assets.php'); ?>
	</head>
	<body>
		<?php
			
			$WHERE = "projects";
			include('app/header.php');
			//PAGE DATA START -----------------------------------------------///---------------------------------
		?>
		
		
		
		<div class="row">
			<form class="col-100" method="GET">
				
				<div class="col-25">
					<div class="nwFormGroup">
						<label class="lbl_class"><?=lang('Job Order', 'ARR', 1); ?></label>
						<select class="frmData" 
						id="new-job_order_id" 
						name="job_order_id" 
						req="1" 
						den="0" 
						alerter="<?=lang("Please_Check_job_order", "AAR"); ?>">
							<option value="0" selected disabled><?=lang('--- Please Select ---', 'AA', 1); ?></option>
							<?php
								$qu_FETCH_sel = "SELECT `job_order_id`, `job_order_ref`, `project_name` FROM  `job_orders`";
								$qu_FETCH_EXE = mysqli_query($KONN, $qu_FETCH_sel);
								if(mysqli_num_rows($qu_FETCH_EXE)){
									while($fetched_DT = mysqli_fetch_array($qu_FETCH_EXE)){
										$job_order_idDT = $fetched_DT[0];
										
										$SEL = "";
										if( $job_order_id == $job_order_idDT ){
											$SEL = "selected";
										}
										
									?>
									<option value="<?=$fetched_DT[0]; ?>" id="prj-<?=$fetched_DT[0]; ?>" <?=$SEL; ?>><?=$fetched_DT[1].'-'.$fetched_DT[2]; ?></option>
									<?php
										
									}
								}
							?>
						</select>
					</div>
				</div>
				
				<div class="col-25">
					<div class="nwFormGroup">
						<label class="lbl_class"><?=lang('Level', 'ARR', 1); ?></label>
						<select class="frmData" 
						id="leveler" 
						name="leveler" 
						req="1" 
						den="0" 
						alerter="<?=lang("Please_Check_job_order", "AAR"); ?>">
							<option value="0" selected><?=lang('All', 'AA', 1); ?></option>
							<option value="2"><?=lang('Processes', 'AA', 1); ?></option>
							<option value="3"><?=lang('Activities', 'AA', 1); ?></option>
							<option value="4"><?=lang('Tasks', 'AA', 1); ?></option>
						</select>
					</div>
				</div>
				
				<script>
					$('#leveler').on( "change", function(){
						var lvl = parseInt( $('#leveler').val() );
						
						if( lvl == 1 ){
							//project
							//hide all
							$('.process').hide();
							$('.activity').hide();
							$('.task').hide();
							} else if( lvl == 2 ){
							//process
							$('.process').show();
							$('.activity').hide();
							$('.task').hide();
							
							} else if( lvl == 3 ){
							//activity
							$('.process').show();
							$('.activity').show();
							$('.task').hide();
							
							} else if( lvl == 4 ){
							//tasks
							$('.process').show();
							$('.activity').show();
							$('.task').show();
							} else if( lvl == 0 ){
							//all
							$('.process').show();
							$('.activity').show();
							$('.task').show();
						}
						
						
					} );
				</script>
				
				<div class="col-25">
					<div class="nwFormGroup">
						<label class="lbl_class"><?=lang('From', 'AA', 1); ?></label>
						<input class="frmData has_date" 
						id="new-ts_date_from" 
						name="ts_date_from" 
						value="<?=$ts_date_from; ?>" 
						type="text"
						req="1" 
						den="" 
						alerter="<?=lang("Please_Check_date", "AAR"); ?>">
					</div>
				</div>
				
				
				<div class="col-25">
					<div class="nwFormGroup">
						<label class="lbl_class"><?=lang('To', 'AA', 1); ?></label>
						<input class="frmData has_date" 
						id="new-ts_date_to" 
						name="ts_date_to" 
						value="<?=$ts_date_to; ?>" 
						type="text"
						req="1" 
						den="" 
						alerter="<?=lang("Please_Check_date", "AAR"); ?>">
					</div>
				</div>
				
				<div class="col-25">
					<div class="nwFormGroup">
						<label class="lbl_class"><?=lang('Result_Type', 'ARR', 1); ?></label>
						<select class="frmData" 
						id="typer" 
						name="typer" 
						req="1" 
						den="0" 
						alerter="<?=lang("Please_Check_job_order", "AAR"); ?>">
							<option value="1"><?=lang('Manhour', 'AA', 1); ?></option>
							<option value="2"><?=lang('Labour_Count', 'AA', 1); ?></option>
						</select>
					</div>
				</div>
				<script>
					$('#typer').val(<?=$typer; ?>);
				</script>
				<div class="col-25">
					<div class="btns-holder text-center">
						<button class="btn btn-success" type="submit"><?=lang('Search'); ?></button>
					</div>
				</div>
				
				
				
			</form>
			
			
			<div class="col-100">
				
				<table class="tabler" border="2">
					<thead>
						<tr>
							<th colspan="3" style="width:40%;" id="newTitle" rowspan="2"><?=lang("Project_Name", "AAR"); ?></th>
							<th colspan="2"><?=lang("RT", "AAR"); ?></th>
							<th colspan="2"><?=lang("OT", "AAR"); ?></th>
							<th colspan="2"><?=lang("TT", "AAR"); ?></th>
						</tr>
						<tr>
							<th><?=lang("GOMI", "AAR"); ?></th>
							<th><?=lang("HIRE", "AAR"); ?></th>
							<th><?=lang("GOMI", "AAR"); ?></th>
							<th><?=lang("HIRE", "AAR"); ?></th>
							<th><?=lang("GOMI", "AAR"); ?></th>
							<th><?=lang("HIRE", "AAR"); ?></th>
						</tr>
					</thead>
					<tbody>
						
						<?php
							//STR -- TASK -----------------------------
							$qu_job_orders_processes_acts_tasks_sel = "SELECT process.process_name ,process.process_id,act.activity_id ,act.activity_name , task.task_id, task.task_name, job.project_amount FROM `job_orders_processes_acts_tasks` task , job_orders_processes_acts act , job_orders_processes process , job_orders job WHERE task.job_order_id = $job_order_id and job.job_order_id = task.job_order_id and task.process_id = process.process_id and task.activity_id = act.activity_id order by process.process_id, act.activity_id asc ;";
							$qu_job_orders_processes_acts_tasks_EXE = mysqli_query($KONN, $qu_job_orders_processes_acts_tasks_sel);
							$process_RT = 0;
							$process_OT = 0;
							$process_TT = 0;
							$activity_RT = 0;
							$activity_OT = 0;
							$activity_TT = 0;
							$process_HIRE_RT = 0;
							$process_HIRE_OT = 0;
							$process_HIRE_TT = 0;
							$activity_HIRE_RT = 0;
							$activity_HIRE_OT = 0;
							$activity_HIRE_TT = 0;
							$sno = 0;
							$temp_process_name = "";
							$temp_activity_name = "";
							if(mysqli_num_rows($qu_job_orders_processes_acts_tasks_EXE)){
							?>
							<script>var x = $('new-job_order_id').val();
							var x = $('new-job_order_id').val();</script>
							<?php
								
									$total_RT =0;
									$total_OT =0;
									$total_TT =0;
									$total_HIRE_RT = 0;
									$total_HIRE_OT = 0;
									$total_HIRE_TT = 0;
									
								while($job_orders_processes_acts_tasks_REC = mysqli_fetch_assoc($qu_job_orders_processes_acts_tasks_EXE)){
									$sno++;
									$project_cost   = (double) $job_orders_processes_acts_tasks_REC['project_amount'];
									$activity_id = $job_orders_processes_acts_tasks_REC['activity_id'];
									$process_id = $job_orders_processes_acts_tasks_REC['process_id'];
									$task_id = $job_orders_processes_acts_tasks_REC['task_id'];
									$task_name = $job_orders_processes_acts_tasks_REC['task_name'];
									$activity_name = $job_orders_processes_acts_tasks_REC['activity_name'];
									$process_name = $job_orders_processes_acts_tasks_REC['process_name'];
									if($sno == 1){
										$temp1_process_name = $process_name;
									}
									
									
									//calc times
									//get related timesheets based on job_order_id 
									$RT = 0;
									$OT = 0;
									$TT = 0;
									$HIRE_RT = 0;
									$HIRE_OT = 0;
									$HIRE_TT = 0;
									if( $typer == 1 ){
										//manhour
										$qu_job_orders_timesheets_sel = "SELECT * FROM  `job_orders_timesheets` timesheet , job_orders_timesheets_recs recs WHERE timesheet.timesheet_id = recs.timesheet_id and  recs.task_id = $task_id and timesheet.job_order_id = $job_order_id ";
										if($ts_date_from != "" && $ts_date_to != ""){
											$qu_job_orders_timesheets_sel = "SELECT * FROM  `job_orders_timesheets` timesheet , job_orders_timesheets_recs recs WHERE timesheet.timesheet_id = recs.timesheet_id and  recs.task_id = $task_id and timesheet.job_order_id = $job_order_id and date_from >= '$ts_date_from' and date_to <= '$ts_date_to' " ;
										}
										else if($ts_date_from != ""){
											$qu_job_orders_timesheets_sel = "SELECT * FROM  `job_orders_timesheets` timesheet , job_orders_timesheets_recs recs WHERE timesheet.timesheet_id = recs.timesheet_id and  recs.task_id = $task_id and timesheet.job_order_id = $job_order_id and date_from >= '$ts_date_from' " ;
										}
										else if($ts_date_to != ""){
											$qu_job_orders_timesheets_sel = "SELECT * FROM  `job_orders_timesheets` timesheet , job_orders_timesheets_recs recs WHERE timesheet.timesheet_id = recs.timesheet_id and  recs.task_id = $task_id and timesheet.job_order_id = $job_order_id and date_to <= '$ts_date_to' " ;
										}
										$qu_job_orders_timesheets_EXE = mysqli_query($KONN, $qu_job_orders_timesheets_sel);
										if(mysqli_num_rows($qu_job_orders_timesheets_EXE)){
											while($job_orders_timesheets_recs_REC = mysqli_fetch_assoc($qu_job_orders_timesheets_EXE)){
												$regular_time = (double) $job_orders_timesheets_recs_REC['regular_time'];
												$ot_time      = (double) $job_orders_timesheets_recs_REC['ot_time'];
												$total_time   = (double) $job_orders_timesheets_recs_REC['total_time'];
												$is_local   = (double) $job_orders_timesheets_recs_REC['is_local'];
												if($is_local == 1){
													$RT = $RT + $regular_time;
													$OT = $OT + $ot_time;
													$TT = $TT + $total_time;
												}
												else{
													$HIRE_RT = $HIRE_RT + $regular_time;
													$HIRE_OT = $HIRE_OT + $ot_time;
													$HIRE_TT = $HIRE_TT + $total_time;
													
												}
												
											}
										}
										
										} else {
										//labour count
										
										$qu_job_orders_timesheets_recs_sel = "SELECT DISTINCT(`employee_id`) FROM  `job_orders_timesheets_recs` WHERE ((`job_order_id` = $job_order_id) AND (`is_local` = 1))";
										if($ts_date_from != "" && $ts_date_to != ""){
											$qu_job_orders_timesheets_recs_sel = "SELECT DISTINCT(`employee_id`) FROM  `job_orders_timesheets_recs` WHERE ((`job_order_id` = $job_order_id) AND (`is_local` = 1)) and date_from >= '$ts_date_from' and date_to <= '$ts_date_to'" ;
										}
										else if($ts_date_from != ""){
											$qu_job_orders_timesheets_recs_sel = "SELECT DISTINCT(`employee_id`) FROM  `job_orders_timesheets_recs` WHERE ((`job_order_id` = $job_order_id) AND (`is_local` = 1)) and date_from >= '$ts_date_from'" ;
										}
										else if($ts_date_to != ""){
											$qu_job_orders_timesheets_recs_sel = "SELECT DISTINCT(`employee_id`) FROM  `job_orders_timesheets_recs` WHERE ((`job_order_id` = $job_order_id) AND (`is_local` = 1)) and date_to <= '$ts_date_to'" ;
										}
										
										$qu_job_orders_timesheets_recs_EXE = mysqli_query($KONN, $qu_job_orders_timesheets_recs_sel);
										$totLocal = 0;
										if(mysqli_num_rows($qu_job_orders_timesheets_recs_EXE)){
											$job_orders_timesheets_recs_DATA = mysqli_fetch_array($qu_job_orders_timesheets_recs_EXE);
											$RT = ( int ) mysqli_num_rows($qu_job_orders_timesheets_recs_EXE);
										}
										
										
										$qu_job_orders_timesheets_recs_sel = "SELECT DISTINCT(`employee_id`) FROM  `job_orders_timesheets_recs` WHERE ((`job_order_id` = $job_order_id) AND (`is_local` = 0))";
										
										if($ts_date_from != "" && $ts_date_to != ""){
											$qu_job_orders_timesheets_recs_sel = "SELECT DISTINCT(`employee_id`) FROM  `job_orders_timesheets_recs` WHERE ((`job_order_id` = $job_order_id) AND (`is_local` = 0)) and date_from >= '$ts_date_from' and date_to <= '$ts_date_to'" ;
										}
										else if($ts_date_from != ""){
											$qu_job_orders_timesheets_recs_sel = "SELECT DISTINCT(`employee_id`) FROM  `job_orders_timesheets_recs` WHERE ((`job_order_id` = $job_order_id) AND (`is_local` = 0)) and date_from >= '$ts_date_from'" ;
										}
										else if($ts_date_to != ""){
											$qu_job_orders_timesheets_recs_sel = "SELECT DISTINCT(`employee_id`) FROM  `job_orders_timesheets_recs` WHERE ((`job_order_id` = $job_order_id) AND (`is_local` = 0)) and date_to <= '$ts_date_to'" ;
										}
										
										$qu_job_orders_timesheets_recs_EXE = mysqli_query($KONN, $qu_job_orders_timesheets_recs_sel);
										$totHire = 0;
										if(mysqli_num_rows($qu_job_orders_timesheets_recs_EXE)){
											$job_orders_timesheets_recs_DATA = mysqli_fetch_array($qu_job_orders_timesheets_recs_EXE);
											$HIRE_RT = ( int ) mysqli_num_rows($qu_job_orders_timesheets_recs_EXE);
										}
										
										
										
									}
									if($temp_process_name != $process_name){
										
									?>
									<tr class="process">
										<td><?=$process_name; ?></td>
										<td colspan="2"></td>
										<td class="l_rt" id = "pro-<?=$process_id?>-RT"></td>
										<td class="h_rt" id = "pro-hire-<?=$process_id?>-RT"></td>
										<td class="l_ot" id = "pro-<?=$process_id?>-OT"></td>
										<td class="h_ot" id = "pro-hire-<?=$process_id?>-OT"></td>
										<td class="l_tt" id = "pro-<?=$process_id?>-TT"></td>
										<td class="h_tt" id = "pro-hire-<?=$process_id?>-TT"></td>
									</tr>
									<?php
										$process_RT = 0;
										$process_OT = 0;
										$process_TT = 0;
										$process_HIRE_RT = 0;
										$process_HIRE_OT = 0;
										$process_HIRE_TT = 0;
									}	
									
									if($temp_activity_name != $activity_name){
									?>
									
									<tr class="activity">
										<td colspan="1">&nbsp;</td>
										<td><?=$activity_name; ?></td>
										<td colspan="1"></td>
										<td class="l_rt" id = "act-<?=$activity_id?>-RT"></td>
										<td class="h_rt" id = "act-hire-<?=$activity_id?>-RT">0</td>
										<td class="l_ot" id = "act-<?=$activity_id?>-OT"></td>
										<td class="h_ot" id = "act-hire-<?=$activity_id?>-OT">0</td>
										<td class="l_tt" id = "act-<?=$activity_id?>-TT"></td>
										<td class="h_tt" id = "act-hire-<?=$activity_id?>-TT">0</td>
									</tr>
									
									
									<?php
										$activity_RT = 0;
										$activity_OT = 0;
										$activity_TT = 0;
										$activity_HIRE_RT = 0;
										$activity_HIRE_OT = 0;
										$activity_HIRE_TT = 0;
									}	
									
									
								?>
								
								<tr class="task">
									<td colspan="2">&nbsp;</td>
									<td><?=$task_name; ?></td>
									<td class="l_rt"><?=$RT; ?></td>
									<td class="h_rt"><?=$HIRE_RT?></td>
									<td class="l_ot"><?=$OT; ?></td>
									<td class="h_ot"><?=$HIRE_OT?></td>
									<td class="l_tt"><?=$TT; ?></td>
									<td class="h_tt"><?=$HIRE_TT?></td>
								</tr>
								
								<?php
									$activity_RT += $RT;
									$activity_OT += $OT;
									$activity_TT += $TT;
									$process_RT += $RT;
									$process_OT += $OT;
									$process_TT += $TT;
									$activity_HIRE_RT += $HIRE_RT;
									$activity_HIRE_OT += $HIRE_OT;
									$activity_HIRE_TT += $HIRE_TT;
									$process_HIRE_RT += $HIRE_RT;
									$process_HIRE_OT += $HIRE_OT;
									$process_HIRE_TT += $HIRE_TT;
									$total_HIRE_RT += $HIRE_RT;
									$total_HIRE_OT += $HIRE_OT;
									$total_HIRE_TT += $HIRE_TT;
									$total_RT += $RT;
									$total_OT += $OT;
									$total_TT += $TT;
									
									$temp_process_name = $process_name;
									$temp_activity_name = $activity_name;
								?>
								<script>
									$('#act-<?=$activity_id?>-RT').html(<?=$activity_RT?>);
									$('#act-<?=$activity_id?>-OT').html(<?=$activity_OT?>);
									$('#act-<?=$activity_id?>-TT').html(<?=$activity_TT?>);
									$('#pro-<?=$process_id?>-RT').html(<?=$process_RT?>);
									$('#pro-<?=$process_id?>-OT').html(<?=$process_OT?>);
									$('#pro-<?=$process_id?>-TT').html(<?=$process_TT?>);
									
									$('#act-hire-<?=$activity_id?>-RT').html(<?=$activity_HIRE_RT?>);
									$('#act-hire-<?=$activity_id?>-OT').html(<?=$activity_HIRE_OT?>);
									$('#act-hire-<?=$activity_id?>-TT').html(<?=$activity_HIRE_TT?>);
									$('#pro-hire-<?=$process_id?>-RT').html(<?=$process_HIRE_RT?>);
									$('#pro-hire-<?=$process_id?>-OT').html(<?=$process_HIRE_OT?>);
									$('#pro-hire-<?=$process_id?>-TT').html(<?=$process_HIRE_TT?>);
									
								</script>
								<?php
								}?>
								<tr>
									<td colspan = "3">Total</td>
									<td><?=$total_RT?></td>
									<td><?=$total_HIRE_RT?></td>
									<td><?=$total_OT?></td>
									<td><?=$total_HIRE_OT?></td>
									<td><?=$total_TT?></td>
									<td><?=$total_HIRE_TT?></td>
								</tr>
								
								<tr>
									<td colspan = "6">Project cost</td>
									<td colspan = "3"><?=$project_cost?></td>
								</tr>
								<?php
								}
								else{
									$err = 'A project Should be selected to view Data';
									if( $job_order_id != 0 ){
										$err = 'No Data Found';
									}
								?>
								<td><?=$err; ?></td>
								<?php
									
								}
								
						?>
						
						
					</tbody>
				</table>
				
			</div>
			<div class="zero"></div>
		</div>
		
		
		
		<script>
			
			
			
			$('.task').each( function(){
				var taskID = $(this).attr('task');
				var thsActivity = parseInt( $('#task-' + taskID).attr('activity') );
				var l_rt = parseFloat( $('#task-' + taskID + ' .l_rt').html() );
				var h_rt = parseFloat( $('#task-' + taskID + ' .h_rt').html() );
				var l_ot = parseFloat( $('#task-' + taskID + ' .l_ot').html() );
				var h_ot = parseFloat( $('#task-' + taskID + ' .h_ot').html() );
				var l_tt = parseFloat( $('#task-' + taskID + ' .l_tt').html() );
				var h_tt = parseFloat( $('#task-' + taskID + ' .h_tt').html() );
				
				
				//get activity totals
				var a_l_rt = parseFloat( $('#activity-' + thsActivity + ' .l_rt').html() );
				var a_h_rt = parseFloat( $('#activity-' + thsActivity + ' .h_rt').html() );
				var a_l_ot = parseFloat( $('#activity-' + thsActivity + ' .l_ot').html() );
				var a_h_ot = parseFloat( $('#activity-' + thsActivity + ' .h_ot').html() );
				var a_l_tt = parseFloat( $('#activity-' + thsActivity + ' .l_tt').html() );
				var a_h_tt = parseFloat( $('#activity-' + thsActivity + ' .h_tt').html() );
				
				$('#activity-' + thsActivity + ' .l_rt').html( l_rt + a_l_rt );
				$('#activity-' + thsActivity + ' .h_rt').html( h_rt + a_h_rt );
				$('#activity-' + thsActivity + ' .l_ot').html( l_ot + a_l_ot );
				$('#activity-' + thsActivity + ' .h_ot').html( h_ot + a_h_ot );
				$('#activity-' + thsActivity + ' .l_tt').html( l_tt + a_l_tt );
				$('#activity-' + thsActivity + ' .h_tt').html( h_tt + a_h_tt );
			} );
			
			
			
			
			
			
			
			
			$('.activity').each( function(){
				var activityID = $(this).attr('activity');
				var thsProcess = parseInt( $('#activity-' + activityID).attr('process') );
				console.log( thsProcess );
				var l_rt = parseFloat( $('#activity-' + activityID + ' .l_rt').html() );
				var h_rt = parseFloat( $('#activity-' + activityID + ' .h_rt').html() );
				var l_ot = parseFloat( $('#activity-' + activityID + ' .l_ot').html() );
				var h_ot = parseFloat( $('#activity-' + activityID + ' .h_ot').html() );
				var l_tt = parseFloat( $('#activity-' + activityID + ' .l_tt').html() );
				var h_tt = parseFloat( $('#activity-' + activityID + ' .h_tt').html() );
				
				
				//get process totals
				var a_l_rt = parseFloat( $('#process-' + thsProcess + ' .l_rt').html() );
				var a_h_rt = parseFloat( $('#process-' + thsProcess + ' .h_rt').html() );
				var a_l_ot = parseFloat( $('#process-' + thsProcess + ' .l_ot').html() );
				var a_h_ot = parseFloat( $('#process-' + thsProcess + ' .h_ot').html() );
				var a_l_tt = parseFloat( $('#process-' + thsProcess + ' .l_tt').html() );
				var a_h_tt = parseFloat( $('#process-' + thsProcess + ' .h_tt').html() );
				
				$('#process-' + thsProcess + ' .l_rt').html( l_rt + a_l_rt );
				$('#process-' + thsProcess + ' .h_rt').html( h_rt + a_h_rt );
				$('#process-' + thsProcess + ' .l_ot').html( l_ot + a_l_ot );
				$('#process-' + thsProcess + ' .h_ot').html( h_ot + a_h_ot );
				$('#process-' + thsProcess + ' .l_tt').html( l_tt + a_l_tt );
				$('#process-' + thsProcess + ' .h_tt').html( h_tt + a_h_tt );
				
				
			} );
			
			
			
			
			
			$('.process').each( function(){
				var processID = $(this).attr('process');
				var thsJob = parseInt( $('#process-' + processID).attr('job') );
				var l_rt = parseFloat( $('#process-' + processID + ' .l_rt').html() );
				var h_rt = parseFloat( $('#process-' + processID + ' .h_rt').html() );
				var l_ot = parseFloat( $('#process-' + processID + ' .l_ot').html() );
				var h_ot = parseFloat( $('#process-' + processID + ' .h_ot').html() );
				var l_tt = parseFloat( $('#process-' + processID + ' .l_tt').html() );
				var h_tt = parseFloat( $('#process-' + processID + ' .h_tt').html() );
				
				
				//get job totals
				var a_l_rt = parseFloat( $('#job-' + thsJob + ' .l_rt').html() );
				var a_h_rt = parseFloat( $('#job-' + thsJob + ' .h_rt').html() );
				var a_l_ot = parseFloat( $('#job-' + thsJob + ' .l_ot').html() );
				var a_h_ot = parseFloat( $('#job-' + thsJob + ' .h_ot').html() );
				var a_l_tt = parseFloat( $('#job-' + thsJob + ' .l_tt').html() );
				var a_h_tt = parseFloat( $('#job-' + thsJob + ' .h_tt').html() );
				
				$('#job-' + thsJob + ' .l_rt').html( l_rt + a_l_rt );
				$('#job-' + thsJob + ' .h_rt').html( h_rt + a_h_rt );
				$('#job-' + thsJob + ' .l_ot').html( l_ot + a_l_ot );
				$('#job-' + thsJob + ' .h_ot').html( h_ot + a_h_ot );
				$('#job-' + thsJob + ' .l_tt').html( l_tt + a_l_tt );
				$('#job-' + thsJob + ' .h_tt').html( h_tt + a_h_tt );
				
				
			} );
			
			var activeJO = 0;
			var activeProject = 0;
			var joStatus = '';
			
			function showJoDetails( projID, joID, joRef , detailsView ){
				joID = parseInt( joID );
				projID = parseInt( projID );
				
				$('#new-project_id').val( projID );
				$('#new-act-project_id').val( projID );
				$('#new-task-project_id').val( projID );
				
				$('#jo_items').html('');
				$('#rfq_supps').html('');
				$('#rfqSups').html('');
				$('#rfq_lists').html('');
				$('#addNewReqItemBtn').css('display', 'inline-block');
				
				
				joStatus = $('#joStatus-' + joID).html();
				set_tabber(1);
				activeJO      = joID;
				activeProject = projID;
				loadDetails( projID, joID, detailsView, joRef );
			}
			function loadDetails( projID, joID, detailsView, joRef ){
				start_loader("Loading Job Order Details...");
				$.ajax({
					url      :"<?=api_root; ?>job_orders/get_details.php",
					data     :{ 'job_order_id': joID },
					dataType :"json",
					type     :'POST',
					success  :function( response ){
						end_loader();
						$('#' + detailsView + ' .job_order_id').val(response[0].job_order_id);
						$('#' + detailsView + ' .created_date').val(response[0].created_date);
						$('#' + detailsView + ' .job_order_type').val(response[0].job_order_type);
						
						$('#' + detailsView + ' .project_manager').val(response[0].project_manager);
						$('#' + detailsView + ' .job_order_ref').val(response[0].job_order_ref);
						$('#' + detailsView + ' .job_order_type').val(response[0].job_order_type);
						
						var job_order_id = parseInt( response[0].job_order_id );
						if( job_order_id != 0 ){
							$('#' + detailsView + ' .job_order_id').val(response[0].job_order_ref);
							$('#' + detailsView + ' .project_no').val(response[0].project_name + ' - ' + response[0].job_order_type);
							} else {
							$('#' + detailsView + ' .job_order_id').val("NA");
							$('#' + detailsView + ' .project_no').val("NA");
						}
						
						$('#' + detailsView + ' .job_order_status').val(response[0].job_order_status);
						$('#' + detailsView + ' .job_order_notes').val(response[0].job_order_notes);
						$('#' + detailsView + ' .created_by').val(response[0].created_by_name);
						//load items
						
						show_details(detailsView, joRef);
						
						if( joStatus != 'draft' ){
							$('#addNewReqItemBtn').css('display', 'none');
						}
						
						loadProcesses();
						
					},
					error    :function(){
						end_loader();
						alert('Data Error No: 5467653');
					},
				});
				
			}
			
			
			
			
			function loadProcesses(){
				start_loader('Loading Processes...');
				$.ajax({
					url      :"<?=api_root; ?>projects/processes/get_processes.php",
					data     :{ 'project_id': activeProject },
					dataType :"json",
					type     :'POST',
					success  :function( response ){
						end_loader();
						$('#new-act-process_id').html('');
						$('#new-task-process_id').html('');
						$('#new-act-process_id').append('<option value="0">Please Select</option>');
						$('#new-task-process_id').append('<option value="0">Please Select</option>');
						$('#jo_processes').html('');
						//load items
						var cc = 0;
						for( i=0 ; i < response.length ; i ++ ){
							cc++;
							var process_id    = parseInt( response[i].process_id );
							if( process_id != 0 ){
								
								var process_name       = response[i].process_name;
								
								var tr = '' + 
								'<tr id="process-' + process_id + '">' + 
								'	<td><i title="Delete this item" onclick="delProcess(' + process_id + ');" class="fas fa-trash"></i></td>' + 
								'	<td>' + cc + '</td>' + 
								'	<td>' + process_name + '</td>' + 
								'</tr>';
								$('#new-act-process_id').append('<option value="' + process_id + '">' + process_name + '</option>');
								$('#new-task-process_id').append('<option value="' + process_id + '">' + process_name + '</option>');
								$('#jo_processes').append(tr);
							}
						}
						
					},
					error    :function(){
						end_loader();
						alert('Data Error No: 5467653');
					},
				});
				
			}
			function delProcess( processId ){
				
				processId = parseInt( processId );
				if( processId != 0 ){
					var aa = confirm( 'Are you sure, this action cannot be undo ?' );
					if( aa == true ){
						
						start_loader('Deleting Process...');
						$.ajax({
							url      :"<?=api_root; ?>projects/processes/del_process.php",
							data     :{ 'process_id': processId },
							dataType :"html",
							type     :'POST',
						success  :function(data){
						end_loader();
						var aa = data.split('|');
						res = parseInt( aa[0] );
						if( res == 1 ){
						$('#process-' + processId).remove();
						} else {
						alert('Error deleting item - ' + aa[1]);
						}
						
						},
						error    :function(){
						end_loader();
						alert('Data Error No: 5467653');
						},
						});
						}
						}
						
						}
						
						
						
						
						
						function loadActivities(){
						start_loader('Loading Activities...');
						$.ajax({
						url      :"<?=api_root; ?>projects/activities/get_activities.php",
						data     :{ 'project_id': activeProject },
						dataType :"json",
						type     :'POST',
						success  :function( response ){
						end_loader();
						$('#jo_activities').html('');
						//load items
						var cc = 0;
						for( i=0 ; i < response.length ; i ++ ){
						cc++;
						var activity_id    = parseInt( response[i].activity_id );
						if( activity_id != 0 ){
						
						var activity_name       = response[i].activity_name;
						var process_name        = response[i].process_name;
						
						
						var tr = '' + 
						'<tr id="activity-' + activity_id + '">' + 
						'	<td><i title="Delete this item" onclick="delActivity(' + activity_id + ');" class="fas fa-trash"></i></td>' + 
						'	<td>' + cc + '</td>' + 
						'	<td>' + activity_name + '</td>' + 
						'	<td>' + process_name + '</td>' + 
						'</tr>';
						
						$('#jo_activities').append(tr);
						}
						}
						
						},
						error    :function(){
						end_loader();
						alert('Data Error No: 5467653');
						},
						});
						
						}
						function delActivity( activityId ){
						
						activityId = parseInt( activityId );
						if( activityId != 0 ){
						var aa = confirm( 'Are you sure, this action cannot be undo ?' );
						if( aa == true ){
						
						start_loader('Deleting Activity...');
						$.ajax({
						url      :"<?=api_root; ?>projects/activities/del_activity.php",
						data     :{ 'activity_id': activityId },
						dataType :"html",
						type     :'POST',
						success  :function(data){
						end_loader();
						var aa = data.split('|');
						res = parseInt( aa[0] );
						if( res == 1 ){
						$('#activity-' + activityId).remove();
						} else {
						alert('Error deleting item - ' + aa[1]);
						}
						
						},
						error    :function(){
						end_loader();
						alert('Data Error No: 5467653');
						},
						});
						}
						}
						}
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						function loadTasks(){
						start_loader('Loading Tasks...');
						$.ajax({
						url      :"<?=api_root; ?>projects/tasks/get_tasks.php",
						data     :{ 'project_id': activeProject },
						dataType :"json",
						type     :'POST',
						success  :function( response ){
						end_loader();
						$('#jo_tasks').html('');
						//load items
						var cc = 0;
						for( i=0 ; i < response.length ; i ++ ){
						cc++;
						var task_id    = parseInt( response[i].task_id );
						if( task_id != 0 ){
						
						var task_name           = response[i].task_name;
						var process_name        = response[i].process_name;
						var activity_name       = response[i].activity_name;
						
						
						var tr = '' + 
						'<tr id="task-' + task_id + '">' + 
						'	<td><i title="Delete this item" onclick="delTask(' + task_id + ');" class="fas fa-trash"></i></td>' + 
						'	<td>' + cc + '</td>' + 
						'	<td>' + task_name + '</td>' + 
						'	<td>' + activity_name + '</td>' + 
						'	<td>' + process_name + '</td>' + 
						'</tr>';
						$('#jo_tasks').append(tr);
						}
						}
						
						},
						error    :function(){
						end_loader();
						alert('Data Error No: 5467653');
						},
						});
						
						}
						function delTask( taskId ){
						
						taskId = parseInt( taskId );
						if( taskId != 0 ){
						var aa = confirm( 'Are you sure, this action cannot be undo ?' );
						if( aa == true ){
						
						start_loader('Deleting Task...');
						$.ajax({
						url      :"<?=api_root; ?>projects/tasks/del_task.php",
						data     :{ 'task_id': taskId },
						dataType :"html",
						type     :'POST',
						success  :function(data){
						end_loader();
						var aa = data.split('|');
						res = parseInt( aa[0] );
						if( res == 1 ){
						$('#task-' + taskId).remove();
						} else {
						alert('Error deleting item - ' + aa[1]);
						}
						
						},
						error    :function(){
						end_loader();
						alert('Data Error No: 5467653');
						},
						});
						}
						}
						}
						
						</script>
						
						
						
						
						
						
						
						
						<?php
						//PAGE DATA END   ----------------------------------------------///---------------------------------
						include('app/footer.php');
						?>
						<script>
						init_nwFormGroup();
						</script>
						
						<script>
						
						function changeTitle(){
						var thsVal = $('#new-job_order_id').val();
						var projectName = $('#prj-' + thsVal).text();
						$('#newTitle').html( projectName );
						}
						<?php
						if($job_order_id != 0){
						?>
						changeTitle();
						<?php
						}
						?>
						</script>
						
						
						</body>
						</html>																											
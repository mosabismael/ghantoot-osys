<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	
	
	
	
	$menuId = 7;
	$subPageID = 163;
	
	
	
	
	$employee_id = 0;
	$employee_type = "";
	$ts_date_from = "";
	$ts_date_to   = "";
	$job_order_id = 0;
	
	if( isset( $_GET['employee_id'] ) ){
		$employee_id = ( int ) test_inputs( $_GET['employee_id'] );
	}
	if( isset( $_GET['job_order_id'] ) ){
		$job_order_id = ( int ) test_inputs( $_GET['job_order_id'] );
	}
	if( isset( $_GET['ts_date_from'] ) ){
		$ts_date_from = test_inputs( $_GET['ts_date_from'] );
	}
	
	if( isset( $_GET['ts_date_to'] ) ){
		$ts_date_to = test_inputs( $_GET['ts_date_to'] );
	}
	
	if( isset( $_GET['employee_type'] ) ){
		$employee_type = test_inputs( $_GET['employee_type'] );
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
						<label class="lbl_class"><?=lang('employee_type', 'ARR', 1); ?></label>
						<select class="frmData" 
						id="employee_type" 
						name="employee_type" 
						req="1" 
						den="0" 
						alerter="<?=lang("Please_Check_job_order", "AAR"); ?>">
							<option value="0" selected disabled><?=lang('--- Please Select ---', 'AA', 1); ?></option>
							<option value="local"><?=lang('Local', 'AA', 1); ?></option>
							<option value="hire"><?=lang('Hire','AA', 1); ?></option>
						</select>
					</div>
				</div>
				
				
				
				<div class="col-25">
					<div class="nwFormGroup">
						<label class="lbl_class"><?=lang('Employee Name', 'ARR', 1); ?></label>
						<select class="frmData" 
						id="employee_id" 
						name="employee_id" 
						req="1" 
						den="0" 
						alerter="<?=lang("Please_Check_employee", "AAR"); ?>">
							
							<option value="0" selected disabled>--- Please Select ---</option>
						</select>
					</div>
				</div>
				<script>
					if(<?=$employee_type?> != ''){
						$('#employee_type').val("<?=$employee_type?>").change();
						jQuery(document).ready(function() {
							jQuery('#employee_type').trigger('change');
						});
					}
				</script>
				<div class="col-25">
					<div class="nwFormGroup">
						<label class="lbl_class"><?=lang('Project_Name', 'ARR', 1); ?></label>
						<select class="frmData" 
						id="new-job_order_id" 
						name="job_order_id" 
						req="1" 
						den="0" 
						alerter="<?=lang("Please_Check_job_order", "AAR"); ?>">
							<option value="0" selected><?=lang('--- Please Select ---', 'AA', 1); ?></option>
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
						<div class="btns-holder text-center">
							<button class="btn btn-success" type="submit"><?=lang('Search'); ?></button>
						</div>
					</div>
					
					
					
			</form>
			
			
			<div class="col-100">
				
				<table class="tabler" border="2">
					<thead>
						
						<tr>
							<th><?=lang("No", "AAR"); ?></th>
							<th><?=lang("Employee_code", "AAR"); ?></th>
							<th><?=lang("Project_name", "AAR"); ?></th>
							<th><?=lang("Task Name", "AAR"); ?></th>
							<th><?=lang("Date", "AAR"); ?></th>
							<th><?=lang("RT", "AAR"); ?></th>
							<th><?=lang("OT", "AAR"); ?></th>
							<th><?=lang("TT", "AAR"); ?></th>
						</tr>
					</thead>
					<tbody>
						
						<?php
							
							
							$qu_emp_SEL = "select * from job_orders_timesheets_recs rec ,job_orders_processes_acts_tasks tasks, job_orders job, hr_employees hr  where hr.employee_id = $employee_id and tasks.task_id = rec.task_id and rec.employee_id = $employee_id and job.job_order_id = rec.job_order_id";
							if($job_order_id != '0' && $employee_id == '0'){
								if($ts_date_from != '' && $ts_date_to != ''){
									$qu_emp_SEL = "select * from job_orders_timesheets_recs rec ,job_orders_processes_acts_tasks tasks, job_orders job, hr_employees hr  where hr.employee_id = rec.employee_id and tasks.task_id = rec.task_id  and job.job_order_id = rec.job_order_id  and job.job_order_id = $job_order_id and date_to <= '$ts_date_to' and date_from >= '$ts_date_from' and hr.employee_type = '$employee_type' order by rec.employee_id";	
								}
								else if ($ts_date_from!=''){
									$qu_emp_SEL = "select * from job_orders_timesheets_recs rec ,job_orders_processes_acts_tasks tasks, job_orders job, hr_employees hr  where hr.employee_id = rec.employee_id and tasks.task_id = rec.task_id and job.job_order_id = rec.job_order_id  and job.job_order_id = $job_order_id and date_from >= '$ts_date_to' and hr.employee_type = '$employee_type' order by rec.employee_id";
								}
								else if($ts_date_to!=''){
									$qu_emp_SEL = "select * from job_orders_timesheets_recs rec ,job_orders_processes_acts_tasks tasks, job_orders job, hr_employees hr  where hr.employee_id = rec.employee_id and tasks.task_id = rec.task_id and job.job_order_id = rec.job_order_id  and job.job_order_id = $job_order_id and date_to <= '$ts_date_to' and hr.employee_type = '$employee_type' order by rec.employee_id";
								}
								else{
									$qu_emp_SEL = "select * from job_orders_timesheets_recs rec ,job_orders_processes_acts_tasks tasks, job_orders job, hr_employees hr  where hr.employee_id = rec.employee_id and tasks.task_id = rec.task_id  and job.job_order_id = rec.job_order_id  and job.job_order_id = $job_order_id and hr.employee_type = '$employee_type' order by rec.employee_id;";
								}
							}
							else if($job_order_id!='0' && $ts_date_from != '' && $ts_date_to!=''){
								$qu_emp_SEL = "select * from job_orders_timesheets_recs rec ,job_orders_processes_acts_tasks tasks, job_orders job, hr_employees hr  where hr.employee_id = $employee_id and tasks.task_id = rec.task_id and rec.employee_id = $employee_id and job.job_order_id = rec.job_order_id and job.job_order_id = $job_order_id and date_from >= '$ts_date_from' and date_to <= '$ts_date_to'";
							}
							else if($ts_date_from != '' && $ts_date_to!=''){
								$qu_emp_SEL = "select * from job_orders_timesheets_recs rec ,job_orders_processes_acts_tasks tasks, job_orders job, hr_employees hr  where hr.employee_id = $employee_id and tasks.task_id = rec.task_id and rec.employee_id = $employee_id and job.job_order_id = rec.job_order_id and date_from >= '$ts_date_from' and date_to <= '$ts_date_to'";
							}
							else if($job_order_id!='0' && $ts_date_from != ''){
								$qu_emp_SEL = "select * from job_orders_timesheets_recs rec ,job_orders_processes_acts_tasks tasks, job_orders job, hr_employees hr  where hr.employee_id = $employee_id and tasks.task_id = rec.task_id and rec.employee_id = $employee_id and job.job_order_id = rec.job_order_id and job.job_order_id = $job_order_id and date_from >= '$ts_date_from' ";
							}
							else if($job_order_id!='0'  && $ts_date_to!=''){
								$qu_emp_SEL = "select * from job_orders_timesheets_recs rec ,job_orders_processes_acts_tasks tasks, job_orders job, hr_employees hr where hr.employee_id = $employee_id and tasks.task_id = rec.task_id and rec.employee_id = $employee_id and job.job_order_id = rec.job_order_id and job.job_order_id = $job_order_id and date_to <= '$ts_date_to'";
							}
							else if($job_order_id != '0'){
								$qu_emp_SEL = "select * from job_orders_timesheets_recs rec ,job_orders_processes_acts_tasks tasks, job_orders job, hr_employees hr  where hr.employee_id = $employee_id and tasks.task_id = rec.task_id and rec.employee_id = $employee_id and job.job_order_id = rec.job_order_id and job.job_order_id = $job_order_id ";
							}
							else if($ts_date_from != '' ){
								$qu_emp_SEL = "select * from job_orders_timesheets_recs rec ,job_orders_processes_acts_tasks tasks, job_orders job, hr_employees hr  where hr.employee_id = $employee_id and tasks.task_id = rec.task_id and rec.employee_id = $employee_id and job.job_order_id = rec.job_order_id and date_from >= '$ts_date_from' ";	
							}
							else if($ts_date_to!=''){
								$qu_emp_SEL = "select * from job_orders_timesheets_recs rec ,job_orders_processes_acts_tasks tasks, job_orders job, hr_employees hr  where hr.employee_id = $employee_id and tasks.task_id = rec.task_id and rec.employee_id = $employee_id and job.job_order_id = rec.job_order_id  and date_to <= '$ts_date_to'";
								
							}
							
							$qu_emp_EXE = mysqli_query($KONN, $qu_emp_SEL);
							if(mysqli_num_rows($qu_emp_EXE)){
								$no = 0;
								while($qu_emp_REC = mysqli_fetch_assoc($qu_emp_EXE)){
									$no++;
									$project_name = $qu_emp_REC['project_name'];
									$OT = $qu_emp_REC['ot_time'];
									$TT = $qu_emp_REC['total_time'];
									$RT = $qu_emp_REC['regular_time'];
									$task_name = $qu_emp_REC['task_name'];
									$date_from = $qu_emp_REC['date_from'];
									$employee_code = $qu_emp_REC['employee_code'].' - '. $qu_emp_REC['first_name'].' '.str_replace('undefined',"",$qu_emp_REC['second_name']).' '.str_replace('undefined',"",$qu_emp_REC['third_name']);
								?>
								<tr>
									<td><?=$no?></td>
									<td style = "width:15%"><?=$employee_code?></td>
									<td><?=$project_name?></td>
									<td><?=$task_name?></td>
									<td><?=$date_from?></td>
									<td><?=$RT?></td>
									<td><?=$OT?></td>
									<td><?=$TT?></td>
								</tr>
								<?php
								}
							}
							else{
								$err = 'Employee type and employee name/ project name should be selected to view Data';
								if( $employee_id != 0 || $job_order_id!='0'){
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
		<script>
			$('#employee_type').on('change', function (e) {
				$('#employee_id').html('');
				var emp_type =  $("#employee_type option:selected").val();
				$.ajax({
					url      :"get_employee_detals.php",
					data     :{ 'emp_type':emp_type, 'employee_id':<?=$employee_id?>},
					dataType :"json",
					type     :'GET',
					success  :function( response ){
						var option = '<option value="0" selected disabled>--- Please Select ---</option>';
						$('#employee_id').append(option);
						for(i =0; i<response.length;i++){
							var option = '<option value="'+response[i].emp_id+'" id="prj-'+response[i].emp_id+'" '+response[i].SEL+'>'+response[i].employee_code+' - '+response[i].first_name+" "+response[i].second_name+" "+response[i].third_name+'</option>';
							$('#employee_id').append(option);
						}
					}
				});
			});
		</script>
		
		
	</body>
</html>																		
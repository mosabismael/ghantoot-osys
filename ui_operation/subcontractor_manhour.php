<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	
	
	
	
	$menuId = 7;
	$subPageID = 162;
	
	
	
	
	$job_order_id = "";
	$ts_date_from = "";
	$ts_date_to   = "";
	
	
	if( isset( $_GET['job_order_id'] ) ){
		$job_order_id = test_inputs( $_GET['job_order_id'] );
	}
	
	if( isset( $_GET['ts_date_from'] ) ){
		$ts_date_from = test_inputs( $_GET['ts_date_from'] );
	}
	
	if( isset( $_GET['ts_date_to'] ) ){
		$ts_date_to = test_inputs( $_GET['ts_date_to'] );
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
						<label class="lbl_class"><?=lang('Sub Contractor', 'ARR', 1); ?></label>
						<select class="frmData" 
						id="new-job_order_id" 
						name="job_order_id" 
						req="1" 
						den="0" 
						alerter="<?=lang("Please_Check_Sub_Contractor_Name", "AAR"); ?>">
							<option selected disabled value="dummy" ><?=lang('--- Please Select ---', 'AA', 1); ?></option>
							<?php
								$qu_FETCH_sel = "SELECT `company_name` FROM  `hr_employees` where employee_type = 'hire' group by company_name;";
								$qu_FETCH_EXE = mysqli_query($KONN, $qu_FETCH_sel);
								if(mysqli_num_rows($qu_FETCH_EXE)){
									$no = 0;
									while($fetched_DT = mysqli_fetch_array($qu_FETCH_EXE)){
										$new_order_id = $fetched_DT[0];
										$SEL = "";
										echo $job_order_id ;
										echo $new_order_id;
										if( $job_order_id == $new_order_id ){
											$SEL = "selected";
										}
										
									?>
									<option value='<?=$fetched_DT[0];?>' id='prj-<?=$fetched_DT[0]; ?>' <?=$SEL;?>><?=$fetched_DT[0]?></option>
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
							<th><?=lang("Designation", "AAR"); ?></th>
							<th><?=lang("Labour count", "AAR"); ?></th>
							<th><?=lang("Hour count", "AAR"); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php
							$qu_desination_sel = "SELECT designation_id FROM `hr_employees` where employee_type = 'hire' and company_name = '$job_order_id' group by designation_id";
							$qu_desination_EXE = mysqli_query($KONN, $qu_desination_sel);
							$no = 0;
							if(mysqli_num_rows($qu_desination_EXE)){
								while($qu_desination_REC = mysqli_fetch_assoc($qu_desination_EXE)){
									$no++;
									$designation_name = "";
									$designation_id =  $qu_desination_REC['designation_id'];
									$qu_design_sel = "SELECT * FROM `hr_departments_designations` where designation_id = $designation_id;";
									$qu_design_EXE = mysqli_query($KONN, $qu_design_sel);
									if(mysqli_num_rows($qu_design_EXE)){
										while($qu_design_REC = mysqli_fetch_assoc($qu_design_EXE)){
											$designation_name =  $qu_design_REC['designation_name'];
											
										}
									}
									$totalTime = 0;
									$qu_design_sel = "SELECT total_time, date_from , date_to FROM `hr_employees` emp , job_orders_timesheets_recs rec where rec.employee_id = emp.employee_id and emp.designation_id = $designation_id" ;
									if($ts_date_from != "" && $ts_date_to != ""){
										$qu_design_sel = "SELECT * FROM `hr_employees` emp , job_orders_timesheets_recs rec where rec.employee_id = emp.employee_id and emp.designation_id = $designation_id and date_from >= '$ts_date_from' and date_to <= '$ts_date_to'" ;
									}
									else if($ts_date_from != ""){
										$qu_design_sel = "SELECT * FROM `hr_employees` emp , job_orders_timesheets_recs rec where rec.employee_id = emp.employee_id and emp.designation_id = $designation_id and date_from >= '$ts_date_from'" ;
									}
									else if($ts_date_to != ""){
										$qu_design_sel = "SELECT * FROM `hr_employees` emp , job_orders_timesheets_recs rec where rec.employee_id = emp.employee_id and emp.designation_id = $designation_id and date_to <= '$ts_date_to'" ;
									}
									$employee_count = 0;
									$qu_design_EXE = mysqli_query($KONN, $qu_design_sel);
									if(mysqli_num_rows($qu_design_EXE)){
										while($qu_design_REC = mysqli_fetch_assoc($qu_design_EXE)){
											$employee_count += 1;
											$totalTime += (int)$qu_design_REC['total_time'];
											
										}
									}
								?>
								
								<tr>
									<td><?=$no?></td>
									<td><?=$designation_name?></td>
									<td><?=$employee_count?></td>
									<td><?=$totalTime?></td>
								</tr>
								<?php
								}
							}
							else{
								$err = 'A Sub Contractor Should be selected to view Data';
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
				<hr>
				<table class="tabler" border="2">
					<thead>
						
						<tr>
							<th><?=lang("No", "AAR"); ?></th>
							<th><?=lang("Designation", "AAR"); ?></th>
							<th><?=lang("Man Hour cost", "AAR"); ?></th>
							<th><?=lang("Hour count", "AAR"); ?></th>
							<th><?=lang("Total", "AAR"); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php
							$qu_desination_sel = "SELECT designation_id FROM `hr_employees` where employee_type = 'hire' and company_name = '$job_order_id' group by designation_id";
							$qu_desination_EXE = mysqli_query($KONN, $qu_desination_sel);
							$no = 0;
							if(mysqli_num_rows($qu_desination_EXE)){
								while($qu_desination_REC = mysqli_fetch_assoc($qu_desination_EXE)){
									$no++;
									$designation_name = "";
									$designation_id =  $qu_desination_REC['designation_id'];
									$qu_design_sel = "SELECT * FROM `hr_departments_designations` where designation_id = $designation_id;";
									$qu_design_EXE = mysqli_query($KONN, $qu_design_sel);
									if(mysqli_num_rows($qu_design_EXE)){
										while($qu_design_REC = mysqli_fetch_assoc($qu_design_EXE)){
											$designation_name =  $qu_design_REC['designation_name'];
											
										}
									}
									$totalTime = 0;
									$qu_design_sel = "SELECT total_time, date_from , date_to FROM `hr_employees` emp , job_orders_timesheets_recs rec where rec.employee_id = emp.employee_id and emp.designation_id = $designation_id" ;
									if($ts_date_from != "" && $ts_date_to != ""){
										$qu_design_sel = "SELECT * FROM `hr_employees` emp , job_orders_timesheets_recs rec where rec.employee_id = emp.employee_id and emp.designation_id = $designation_id and date_from >= '$ts_date_from' and date_to <= '$ts_date_to'" ;
									}
									else if($ts_date_from != ""){
										$qu_design_sel = "SELECT * FROM `hr_employees` emp , job_orders_timesheets_recs rec where rec.employee_id = emp.employee_id and emp.designation_id = $designation_id and date_from >= '$ts_date_from'" ;
									}
									else if($ts_date_to != ""){
										$qu_design_sel = "SELECT * FROM `hr_employees` emp , job_orders_timesheets_recs rec where rec.employee_id = emp.employee_id and emp.designation_id = $designation_id and date_to <= '$ts_date_to'" ;
									}
									$employee_count = 0;
									$qu_design_EXE = mysqli_query($KONN, $qu_design_sel);
									if(mysqli_num_rows($qu_design_EXE)){
										while($qu_design_REC = mysqli_fetch_assoc($qu_design_EXE)){
											$employee_count += 1;
											$totalTime += (int)$qu_design_REC['total_time'];
											
										}
									}
								?>
								
								<tr>
									<td><?=$no?></td>
									<td><?=$designation_name?></td>
									<td><input type = "text" id = "manhourcost-<?=$designation_id?>" onkeyup = "calTotalCost(<?=$designation_id?>);" ></td>
									<td><input id = "manhour-<?=$designation_id?>" type = "text" value=<?=$totalTime?> disabled></td>
									<td><input id = "totalCost-<?=$designation_id?>" class = "totalCost" type = "text" value = "0" disabled></td>
								</tr>
								
								
								<?php
								}
							?>
							
							<tr>
								<td colspan="4">Total :</td>
								<td><input type = "text" id = "totalcost-manhour" value = "0" disabled></td>
								
							</tr>
							<?php
								
								
								
								} else {
								$err = 'A Sub Contractor Should be selected to view Data';
								if( $job_order_id != 0 ){
									$err = 'No Data Found';
								}
							?>
							<tr><td colspan="5"><?=$err; ?></td></tr>
							<?php
								
							}
						?>
						<script>
							function calTotalCost(des_id){
								var cost = $('#manhourcost-'+des_id).val();
								var manhour = $('#manhour-'+des_id).val();
								var totalCost = parseInt(cost)*parseInt(manhour);
								$('#totalCost-'+des_id).val(totalCost);
								var totalAmount = 0;
								var total = document.getElementsByClassName('totalCost');
								for (var i = 0; i < total.length; ++i) {
									var item = total[i];  
									totalAmount += parseInt(item.value);
								}
								$('#totalcost-manhour').val(totalAmount);
							}
						</script>
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
		
		
		</body>
		</html>		
<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 2;
	$subPageID = 4;
	
	
	
	$job_order_id = 0;
	$ts_date_from = "";
	$ts_date_to = "";
	
	
	if( isset( $_GET['job_order_id'] ) ){
		$job_order_id = ( int ) test_inputs( $_GET['job_order_id'] );
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
		<label class="lbl_class"><?=lang('Job Order', 'ARR', 1); ?></label>
		<select class="frmData" 
				id="new-job_order_id" 
				name="job_order_id" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_job_order", "AAR"); ?>">
				<option value="0" selected><?=lang('All_Projects', 'AA', 1); ?></option>
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
		<option value="<?=$fetched_DT[0]; ?>" <?=$SEL; ?>><?=$fetched_DT[1].'-'.$fetched_DT[2]; ?></option>
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
		
		<table id="dataTable" class="tabler" border="2">
			<thead>
				<tr>
					<th><a href="machines_timesheets_new.php" class="text-danger"><?=lang("Add New", "AAR"); ?></a></th>
					<th><?=lang("TS_Date", "AAR"); ?></th>
					<th><?=lang("Prep.<br>By", "AAR"); ?></th>
					<th><?=lang("Rev.<br>By", "AAR"); ?></th>
					<th><?=lang("App.<br>By", "AAR"); ?></th>
					<th><?=lang("Job_Order", "AAR"); ?></th>
					<th style="width: 30%;"><?=lang("Project", "AAR"); ?></th>
					<th><?=lang("--", "AAR"); ?></th>
				</tr>
			</thead>
			<tbody>
<?php

	$JO_COND = "";
	if( $job_order_id != 0 ){
		$JO_COND = " ( `job_order_id` = '$job_order_id' ) ";
	}
	
	$FR_COND = "";
	if( $ts_date_from != "" ){
		$FR_COND = " ( `ts_date` >= '$ts_date_from' ) ";
	}
	
	$TO_COND = "";
	if( $ts_date_to != "" ){
		$TO_COND = " ( `ts_date` <= '$ts_date_to' ) ";
	}
	
	
	if( $JO_COND != "" ){
		$COND = $JO_COND;
	}
	
	
	if( $COND == "" && $FR_COND != "" ){
		$COND = $FR_COND;
	} else if( $COND != "" && $FR_COND != "" ){
		$COND = $COND." AND ".$FR_COND;
	}
	
	
	if( $COND == "" && $TO_COND != "" ){
		$COND = $TO_COND;
	} else if( $COND != "" && $TO_COND != "" ){
		$COND = $COND." AND ".$TO_COND;
	}
	
	
	if( $COND != "" ){
		$COND = " WHERE (".$COND.") LIMIT 30";
	}
	
	
	
	
	$sNo = 0;
	$qu_job_orders_timesheets_machines_sel = "SELECT * FROM  `job_orders_timesheets_machines` $COND";
	$qu_job_orders_timesheets_machines_EXE = mysqli_query($KONN, $qu_job_orders_timesheets_machines_sel);
	if(mysqli_num_rows($qu_job_orders_timesheets_machines_EXE)){
		while($job_orders_timesheets_machines_REC = mysqli_fetch_assoc($qu_job_orders_timesheets_machines_EXE)){
			$sNo++;
		$timesheet_id = $job_orders_timesheets_machines_REC['timesheet_id'];
		$job_order_idTHS = $job_orders_timesheets_machines_REC['job_order_id'];
		$ts_date = $job_orders_timesheets_machines_REC['ts_date'];
		$created_date = $job_orders_timesheets_machines_REC['created_date'];
		$created_by = $job_orders_timesheets_machines_REC['created_by'];
			
			
			
	$qu_job_orders_sel = "SELECT * FROM  `job_orders` WHERE `job_order_id` = $job_order_idTHS";
	$qu_job_orders_EXE = mysqli_query($KONN, $qu_job_orders_sel);
	$job_orders_DATA;
	if(mysqli_num_rows($qu_job_orders_EXE)){
		$job_orders_DATA = mysqli_fetch_assoc($qu_job_orders_EXE);
	}
		$job_order_ref = $job_orders_DATA['job_order_ref'];
		$job_order_type = $job_orders_DATA['job_order_type'];
		$job_order_status = $job_orders_DATA['job_order_status'];
		$JOcreated_date = $job_orders_DATA['created_date'];
		$JOcreated_by = $job_orders_DATA['created_by'];
		
		$project_name = $job_orders_DATA['project_name'];
		$job_order_type = $job_orders_DATA['job_order_type'];
		$project_manager_id = $job_orders_DATA['project_manager_id'];
		$job_order_status = $job_orders_DATA['job_order_status'];

		
		
		
		
		
		$project_manager = get_emp_name($KONN, $project_manager_id );
		
		$created_by_name = get_emp_name($KONN, $created_by );
		
		
		?>
			<tr id="ts-<?=$timesheet_id; ?>">
				<td>TS<?=date("y"); ?>-000<?=$timesheet_id; ?></td>
				<td><?=$created_date; ?></td>
				<td><?=$created_by_name; ?></td>
				<td><?=$created_by_name; ?></td>
				<td><?=$created_by_name; ?></td>
				<td><?=$job_order_ref; ?></td>
				<td><span class="text-primary"><?=$project_name; ?></span></td>
				<td>
					<a href="machines_timesheets_details.php?timesheet_id=<?=$timesheet_id; ?>" title="TS Details"><span id="projREF-<?=$timesheet_id; ?>" class="text-primary"><?=lang("Details", "ARR"); ?></span></a>
				</td>
			</tr>
		<?php
		}
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
</body>
</html>
<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 3;
	$subPageID = 9;
	
	
	
	
	
	
if( isset($_POST['job_order_id']) && 
	isset($_POST['received_by']) ){

	$miv_id = 0;
	$miv_ref = "";
	$created_date = date('Y-m-d H:i:00');
	$created_by = $EMPLOYEE_ID;
	$miv_status = "draft";
	$job_order_id = ( int ) test_inputs($_POST['job_order_id']);
	$received_by  = ( int ) test_inputs($_POST['received_by']);
	





	//calc miv_ref
	$qu_inv_mivs_sel = "SELECT COUNT(`miv_id`) FROM  `inv_mivs` WHERE `created_date` LIKE '".date('Y-m-')."%' ";
	$qu_inv_mivs_EXE = mysqli_query($KONN, $qu_inv_mivs_sel);
	$nwNO         = 0;
	$tot_count_DB = 0;
	if(mysqli_num_rows($qu_inv_mivs_EXE)){
		$inv_mivs_DATA = mysqli_fetch_array($qu_inv_mivs_EXE);
		$tot_count_DB = ( int ) $inv_mivs_DATA[0];
	}
	
	$nwNO = $tot_count_DB + 1;
	$tot_count_DB_res = "";
	
		if($tot_count_DB < 10){
			$tot_count_DB_res = '000'.$nwNO;
		} else if( $tot_count_DB >= 10 && $tot_count_DB < 100 ){
			$tot_count_DB_res = '00'.$nwNO;
		} else if( $tot_count_DB >= 100 && $tot_count_DB < 1000 ){
			$tot_count_DB_res = '0'.$nwNO;
		} else {
			$tot_count_DB_res = ''.$nwNO;
		}
		$miv_ref = "MIV".date('ym').$tot_count_DB_res;
		

	$qu_inv_mivs_ins = "INSERT INTO `inv_mivs` (
						`miv_ref`, 
						`created_date`, 
						`created_by`, 
						`received_by`, 
						`miv_status`, 
						`job_order_id` 
					) VALUES (
						'".$miv_ref."', 
						'".$created_date."', 
						'".$created_by."', 
						'".$received_by."', 
						'".$miv_status."', 
						'".$job_order_id."' 
					);";

	if(mysqli_query($KONN, $qu_inv_mivs_ins)){
		$miv_id = mysqli_insert_id($KONN);
		if( $miv_id != 0 ){
			
			if( insert_state_change($KONN, $miv_status, $miv_id, "inv_mivs", $EMPLOYEE_ID) ) {
				header("location:miv_list.php?added=".$miv_id);
				die("DONE");
			} else {
				die('0|Data Status Error 65154');
			}
		}
	}

}

	
	
	
	
	
	
?>
<!DOCTYPE html>
<html dir="<?=$lang_dir; ?>" lang="<?=$lang; ?>">
<head>
	<?php include('app/meta.php'); ?>
    <?php include('app/assets.php'); ?>
</head>
<body>
<?php

	$WHERE = "requisitions";
	include('app/header.php');
	//PAGE DATA START -----------------------------------------------///---------------------------------
?>



<div class="row">
	<div class="col-100">
		<form action="miv_new_01.php" method="POST">
		
		
			<div class="row col-100">
				<div class="nwFormGroup">
					<label><?=lang("Select_Job_Order:", "AAR"); ?></label>
					<select class="frmData" id="new-job_order_id" name="job_order_id" required>
						<option value="0" disabled selected><?=lang("Please_Select", "غير محدد"); ?></option>
		<?php
			$qu_job_orders_sel = "SELECT * FROM  `job_orders` ORDER BY `job_order_ref` ASC";
			$qu_job_orders_EXE = mysqli_query($KONN, $qu_job_orders_sel);
			if(mysqli_num_rows($qu_job_orders_EXE)){
				while($job_orders_REC = mysqli_fetch_assoc($qu_job_orders_EXE)){
					$job_order_id  = ( int ) $job_orders_REC['job_order_id'];
					$job_order_ref = $job_orders_REC['job_order_ref'];
					$project_name = $job_orders_REC['project_name'];
				
				?>
						<option value="<?=$job_order_id; ?>"><?=$job_order_ref; ?> - <?=$project_name; ?></option>
				<?php
				}
			}
		?>
					</select>
				</div>
				<div class="zero"></div>
			</div>
		
		
			<div class="row col-100">
				<div class="nwFormGroup">
					<label><?=lang("Select_Receiver:", "AAR"); ?></label>
					<select class="frmData" id="new-received_by" name="received_by" required>
						<option value="0" disabled selected><?=lang("Please_Select", "غير محدد"); ?></option>
		<?php
			$qu_hr_employees_sel = "SELECT `employee_id`, `employee_code`, `first_name`, `last_name` FROM  `hr_employees` ORDER BY `first_name` ASC";
			$qu_hr_employees_EXE = mysqli_query($KONN, $qu_hr_employees_sel);
			if(mysqli_num_rows($qu_hr_employees_EXE)){
				while($hr_employees_REC = mysqli_fetch_assoc($qu_hr_employees_EXE)){
					$employee_id  = ( int ) $hr_employees_REC['employee_id'];
					$employee_code = $hr_employees_REC['employee_code'];
					$first_name = $hr_employees_REC['first_name'];
					$last_name = $hr_employees_REC['last_name'];
				
				?>
						<option value="<?=$employee_id; ?>"><?=$employee_code; ?> - <?=$first_name; ?> <?=$last_name; ?></option>
				<?php
				}
			}
		?>
					</select>
				</div>
				<div class="zero"></div>
			</div>
			
			
			<div class="zero"></div>
				


<div class="viewerBodyButtons">
		<a href="miv_list.php"><button type="button">
			<?=lang('Cancel', 'ARR', 1); ?>
		</button></a>
		<button type="submit">
			<?=lang('Next', 'ARR', 1); ?>
		</button>
</div>
			
		</form>
	</div>
	<div class="zero"></div>
</div>


<?php
	//PAGE DATA END   ----------------------------------------------///---------------------------------
	include('app/footer.php');
?>
</body>
</html>
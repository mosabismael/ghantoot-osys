<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 5;
	$subPageID = 17;
	

if( isset($_POST['bill_type']) && 
	isset($_POST['client_ref']) && 
	isset($_POST['client_contact']) && 
	isset($_POST['job_order_id'])
	){

	$bill_id = 0;
	$bill_type = test_inputs($_POST['bill_type']);
	$bill_ref = "NA";
	$client_ref = test_inputs($_POST['client_ref']);
	$client_contact = test_inputs($_POST['client_contact']);
	$created_date = date( 'Y-m-d H:i:00' );
	$created_by = $EMPLOYEE_ID;
	$job_order_id = test_inputs($_POST['job_order_id']);
	$bill_status = "draft";
	
	$f_C = strtoupper( substr($bill_type, 0, 1) );
	
	

	//calc bill_ref
	$qu_acc_biling_sel = "SELECT COUNT(`bill_id`) FROM  `acc_biling` WHERE `created_date` LIKE '".date('Y-m-')."%' ";
	$qu_acc_biling_EXE = mysqli_query($KONN, $qu_acc_biling_sel);
	$nwNO         = 0;
	$tot_count_DB = 0;
	if(mysqli_num_rows($qu_acc_biling_EXE)){
		$acc_biling_DATA = mysqli_fetch_array($qu_acc_biling_EXE);
		$tot_count_DB = ( int ) $acc_biling_DATA[0];
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
		$bill_ref = "B-".$f_C.date('ym').$tot_count_DB_res;
		
	
	
	
	$qu_acc_biling_ins = "INSERT INTO `acc_biling` (
						`bill_type`, 
						`bill_ref`, 
						`client_ref`, 
						`client_contact`, 
						`created_date`, 
						`created_by`, 
						`job_order_id`, 
						`bill_status` 
					) VALUES (
						'".$bill_type."', 
						'".$bill_ref."', 
						'".$client_ref."', 
						'".$client_contact."', 
						'".$created_date."', 
						'".$created_by."', 
						'".$job_order_id."', 
						'".$bill_status."' 
					);";

	if(mysqli_query($KONN, $qu_acc_biling_ins)){
		$bill_id = mysqli_insert_id($KONN);
		if( $bill_id != 0 ){
			
		//insert state change
			if( insert_state_change($KONN, $bill_status, $bill_id, "acc_biling", $EMPLOYEE_ID) ) {
				header("location:acc_biling_new_02.php?bill_id=".$bill_id);
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
		<form action="acc_biling_new_01.php" method="POST">
		
			<div class="row col-100">
				<div class="nwFormGroup">
					<label><?=lang("Select_Type:", "AAR"); ?></label>
					<select class="frmData" id="new-bill_type" name="bill_type" required>
						<option value="0" disabled selected><?=lang("Please_Select", "غير محدد"); ?></option>
						<option value="marine"><?=lang("Marine", "غير محدد"); ?></option>
						<option value="steel"><?=lang("Steel", "غير محدد"); ?></option>
					</select>
				</div>
				<div class="zero"></div>
			</div>
		
			<div class="row col-100">
				<div class="nwFormGroup">
					<label><?=lang("Select_Job_Order:", "AAR"); ?></label>
					<select class="frmData" id="new-job_order_id" name="job_order_id" required>
						<option value="0" disabled selected><?=lang("Please_Select", "غير محدد"); ?></option>
		<?php
			$sNo = 0;
			$qu_job_orders_sel = "SELECT * FROM  `job_orders` ORDER BY `job_order_ref` ASC";
			$qu_job_orders_EXE = mysqli_query($KONN, $qu_job_orders_sel);
			if(mysqli_num_rows($qu_job_orders_EXE)){
				while($job_orders_REC = mysqli_fetch_assoc($qu_job_orders_EXE)){
					$job_order_id       = ( int ) $job_orders_REC['job_order_id'];
					$job_order_ref = $job_orders_REC['job_order_ref'];
					$client_name = $job_orders_REC['client_name'];
				
				?>
						<option value="<?=$job_order_id; ?>"><?=$job_order_ref; ?> - <?=$client_name; ?></option>
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
					<label><?=lang("client_ref:", "AAR"); ?></label>
					<input type="text" class="frmData" id="new-client_ref" name="client_ref" required>
				</div>
				<div class="zero"></div>
			</div>
		
			<div class="row col-100">
				<div class="nwFormGroup">
					<label><?=lang("client_Contact:", "AAR"); ?></label>
					<input type="text" class="frmData" id="new-client_contact" name="client_contact" required>
				</div>
				<div class="zero"></div>
			</div>
			
			<div class="zero"></div>
				


<div class="viewerBodyButtons">
		<a href="acc_biling.php"><button type="button">
			<?=lang('Back', 'ARR', 1); ?>
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
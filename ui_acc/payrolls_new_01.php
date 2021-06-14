<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "Issue New Payroll";
	$menuId = 6;
	$subPageID = 18;
	$RES = "";
	
	
if( isset($_POST['payroll_year']) &&
	isset($_POST['payroll_month']) 
	){

	$payroll_id = 0;
	$payroll_year = test_inputs($_POST['payroll_year']);
	$payroll_month = test_inputs($_POST['payroll_month']);
	$created_date = date("Y-m-d H:i:00");
	$created_by = $EMPLOYEE_ID;
	
	//check if payroll exist
	$qu_acc_payrolls_sel = "SELECT * FROM  `acc_payrolls` WHERE ((`payroll_year` = '$payroll_year') AND (`payroll_month` = '$payroll_month'))";
	$qu_acc_payrolls_EXE = mysqli_query($KONN, $qu_acc_payrolls_sel);
	$acc_payrolls_DATA;
	if(mysqli_num_rows($qu_acc_payrolls_EXE)){
		$RES = 'Payroll already Exist<br><br>';
	} else {
		
		//insert data
		$qu_acc_payrolls_ins = "INSERT INTO `acc_payrolls` (
							`payroll_year`, 
							`payroll_month`, 
							`created_date`, 
							`created_by` 
						) VALUES (
							'".$payroll_year."', 
							'".$payroll_month."', 
							'".$created_date."', 
							'".$created_by."' 
						);";

		if(mysqli_query($KONN, $qu_acc_payrolls_ins)){
			$payroll_id = mysqli_insert_id($KONN);
			if( $payroll_id != 0 ){
				header("location:payrolls.php?added=".$payroll_id);
				die();
			}
		} else {
			$RES = 'ERR-2343';
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

	$WHERE = "Payrolls";
	include('app/header.php');
	//PAGE DATA START -----------------------------------------------///---------------------------------
?>



<div class="row">
	<div class="col-100">
		<form action="payrolls_new_01.php" method="POST">
		
			<div class="row col-100">
				<div class="nwFormGroup">
					<label><?=lang("Select_Year:", "AAR"); ?></label>
					<select class="frmData" id="new-payroll_year" name="payroll_year" required>
						<option value="0" disabled selected><?=lang("Please_Select", "غير محدد"); ?></option>
						
					<?php
					$yStart = ( int ) date('Y');
					$yEnd   = ( int ) date('Y') + 2;
					for( $Y = $yStart ; $Y <= $yEnd ; $Y++){
					?>
					<option value="<?=$Y; ?>"><?=$Y; ?></option>
					<?php
					}
					?>
					</select>
				</div>
				<div class="zero"></div>
			</div>
<script>
$('#new-payroll_year').val("<?=date('Y'); ?>");
</script>
			<div class="row col-100">
				<div class="nwFormGroup">
					<label><?=lang("Select_Month:", "AAR"); ?></label>
					<select class="frmData" id="new-payroll_month" name="payroll_month" required>
						<option value="0" disabled selected><?=lang("Please_Select", "غير محدد"); ?></option>
						
					<?php
					$mStart = 1;
					$mEnd   = 12;
					for( $M = $mStart ; $M <= $mEnd ; $M++){
						$M_v = ''.$M;
						if( $M < 10 ){
							$M_v = '0'.$M;
						}
					?>
					<option value="<?=$M_v; ?>"><?=$M_v; ?></option>
					<?php
					}
					?>
					</select>
				</div>
				<div class="zero"></div>
			</div>
<script>
$('#new-payroll_month').val("<?=date('m'); ?>");
</script>

		
			<div class="zero"></div>
				


<div class="viewerBodyButtons">
		<?=$RES; ?><br>
		<a href="payrolls.php"><button type="button">
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
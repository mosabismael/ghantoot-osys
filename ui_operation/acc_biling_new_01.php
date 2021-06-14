<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 9;
	$subPageID = 18;
	
	$RES = '';

if( isset($_POST['bill_type']) && 
	isset($_POST['client_ref']) && 
	isset($_POST['client_contact']) && 
	isset($_POST['client_id']) && 
	isset($_POST['job_order_id'])
	){

	$bill_id = 0;
	$client_id = 0;
	$bill_type = test_inputs($_POST['bill_type']);
	$bill_ref = "NA";
	$client_ref = test_inputs($_POST['client_ref']);
	$client_contact = test_inputs($_POST['client_contact']);
	$created_date = date( 'Y-m-d H:i:00' );
	$created_by = $EMPLOYEE_ID;
	$job_order_id = ( int ) test_inputs($_POST['job_order_id']);
	$client_id = ( int ) test_inputs($_POST['client_id']);
	$bill_status = "draft";
	
	$f_C = strtoupper( substr($bill_type, 0, 1) );
	
	
	
	
	//contract_attach
	
	$contract_attach = 'na';
	
	
	

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
	
		if($nwNO < 10){
			$tot_count_DB_res = '000'.$nwNO;
		} else if( $nwNO >= 10 && $nwNO < 100 ){
			$tot_count_DB_res = '00'.$nwNO;
		} else if( $nwNO >= 100 && $nwNO < 1000 ){
			$tot_count_DB_res = '0'.$nwNO;
		} else {
			$tot_count_DB_res = ''.$nwNO;
		}
		$bill_ref = "B-".$f_C.date('ym').$tot_count_DB_res;
		
	
	
	if( $client_id != 0 ){
		
		$qu_acc_biling_ins = "INSERT INTO `acc_biling` (
							`bill_type`, 
							`bill_ref`, 
							`client_id`, 
							`client_ref`, 
							`client_contact`, 
							`contract_attach`, 
							`created_date`, 
							`created_by`, 
							`job_order_id`, 
							`bill_status` 
						) VALUES (
							'".$bill_type."', 
							'".$bill_ref."', 
							'".$client_id."', 
							'".$client_ref."', 
							'".$client_contact."', 
							'".$contract_attach."', 
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
	
	} else {
		$RES = 'client not defined';
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
		<form action="acc_biling_new_01.php" method="POST" enctype="multipart/form-data">
		
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
<script>
var JO_DT;
$('#new-bill_type').on( 'change', function(){
	var tt = $('#new-bill_type').val();
	if( tt != '0' ){
		
		if( tt == 'steel' ){
			tt = 'marine';
		} else {
			tt = 'steel';
		}
		
		
		$('#new-job_order_id').html( JO_DT );
		$('.' + tt).each( function(){
			$(this).hide();
		} );
	}
	
} );
</script>
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
					$job_order_type = $job_orders_REC['job_order_type'];
					$client_idT = $job_orders_REC['client_id'];
					

		$qu_gen_clients_sel = "SELECT `client_id`, `client_name` FROM  `gen_clients` WHERE `client_id` = '$client_idT'";
		$qu_gen_clients_EXE = mysqli_query($KONN, $qu_gen_clients_sel);
		if(mysqli_num_rows($qu_gen_clients_EXE)){
			$gen_clients_DATA = mysqli_fetch_assoc($qu_gen_clients_EXE);
			$client_id = ( int ) $gen_clients_DATA['client_id'];
			$client_name = $gen_clients_DATA['client_name'];
			
		
				
				?>
						<option class="<?=$job_order_type; ?>" value="<?=$job_order_id; ?>" id="jo-<?=$job_order_id; ?>" data-cc="<?=$client_idT; ?>"><?=$job_order_ref; ?> - <?=$client_name; ?></option>
				<?php
				
				
		}
				}
			}
		?>
					</select>
				</div>
				<div class="zero"></div>
			</div>
<script>
$('#new-job_order_id').on( 'change', function(){
	var ths = $('#new-job_order_id').val();
	var cID = parseInt( $('#jo-' + ths).attr('data-cc') );
	if( cID != 0 ){
		$('#new-client_id').val( cID );
	}
} );
JO_DT = $('#new-job_order_id').html();
</script>
			<input type="hidden" id="new-client_id" name="client_id" required>
		
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
		<?=$RES; ?><br>
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
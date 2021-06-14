<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 9;
	$subPageID = 19;
	
	echo 'Sending To Accounts...';
	
	$bill_id = 0;
	
	if( isset( $_GET['bill_id'] ) ){
		$bill_id = ( int ) $_GET['bill_id'];
	} else {
		header("location:acc_biling.php?noBill=1");
	}
	
	
	$qu_acc_biling_sel = "SELECT * FROM  `acc_biling` WHERE `bill_id` = $bill_id";
	$qu_acc_biling_EXE = mysqli_query($KONN, $qu_acc_biling_sel);
	$acc_biling_DATA;
	if(mysqli_num_rows($qu_acc_biling_EXE)){
		$acc_biling_DATA = mysqli_fetch_assoc($qu_acc_biling_EXE);
	}
	
		$bill_type = $acc_biling_DATA['bill_type'];
		$bill_ref = $acc_biling_DATA['bill_ref'];
		$client_ref = $acc_biling_DATA['client_ref'];
		$created_date = $acc_biling_DATA['created_date'];
		$created_by = $acc_biling_DATA['created_by'];
		$job_order_id = $acc_biling_DATA['job_order_id'];
		$bill_status = $acc_biling_DATA['bill_status'];
	
	
	

		$bill_status = 'sent_to_acc';
		$qu_acc_biling_updt = "UPDATE  `acc_biling` SET 
							`bill_status` = '".$bill_status."' 
							WHERE `bill_id` = $bill_id;";

		if(mysqli_query($KONN, $qu_acc_biling_updt)){
			
			
	$current_state_id = get_current_state_id($KONN, $bill_id, 'acc_biling' );
	if( $current_state_id != 0 ){
		if( insert_state_change_dep($KONN, "send-acc", $bill_id, $bill_status, 'acc_biling', $EMPLOYEE_ID, $current_state_id) ){
			
			header("location:acc_biling.php?sent_acc=1");
			
			
		} else {
			die( 'comErr'.mysqli_error( $KONN ) );
		}
	} else {
		die('0|Component State Error 02');
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
		Sending To Accounts...
	</div>
	<div class="zero"></div>
</div>

<?php
	//PAGE DATA END   ----------------------------------------------///---------------------------------
	include('app/footer.php');
?>
</body>
</html>
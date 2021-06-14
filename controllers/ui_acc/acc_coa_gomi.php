	<?php
	require_once('../../bootstrap/app_config.php');
	require_once('../../bootstrap/chk_log_user.php');
	
	$IAM_ARRAY = array();
	
	
	$CUR_PAGE = 0;
	$per_page = 20;
	$totPages = 0;
	
	if( isset( $_POST['page'] ) ){
		$CUR_PAGE = ( int ) test_inputs( $_POST['page'] );
	}
	if( isset( $_POST['showperpage'] ) ){
		$per_page = ( int ) test_inputs( $_POST['showperpage'] );
	}
	
	$start=abs(($CUR_PAGE-1)*$per_page);
	
	
	
	
	
	
	
	$sNo = $start + 1;
	$qu_acc_coa_sel = "SELECT * FROM  `acc_coa` ORDER BY `account_no` ASC LIMIT $start,$per_page";


	$qu_acc_coa_EXE = mysqli_query($KONN, $qu_acc_coa_sel);
	if(mysqli_num_rows($qu_acc_coa_EXE)){
		while($acc_coa_REC = mysqli_fetch_assoc($qu_acc_coa_EXE)){
			$account_id = $acc_coa_REC['account_id'];
			$account_no = $acc_coa_REC['account_no'];
			$account_name = $acc_coa_REC['account_name'];
			$account_type_name = $acc_coa_REC['account_type'];
			$opening_balance = 0;
			$current_balance = 0;
	
$IAM_ARRAY[] = array(  "sNo" => $sNo,
						"account_id" => $account_id, 
						"account_no" => $account_no,
						"account_name" => $account_name,
						"current_balance" => $current_balance,
						"account_type_name" => $account_type_name
						);
						
		$sNo++;
		}
		
	}
	echo json_encode($IAM_ARRAY);
	
?>

	
	
	
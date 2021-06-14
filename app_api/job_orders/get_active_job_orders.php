<?php
	
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	try{
		
		if(!isset($_POST['job_order_id'])){
			die('7wiu');
		}
		
		$job_order_id = (int) $_POST['job_order_id'];
		
		$qu_job_orders_sel = "SELECT * FROM  `job_orders` WHERE `job_order_status` = 'active' ORDER BY `job_order_ref` ASC";
		$userStatement = mysqli_prepare($KONN,$qu_job_orders_sel);
		mysqli_stmt_execute($userStatement);
		$qu_job_orders_EXE = mysqli_stmt_get_result($userStatement);
		if(mysqli_num_rows($qu_job_orders_EXE)){
		?>
		<option value="0" selected><?=lang("Please_Select", "غير محدد"); ?></option>
		<?php
			while($job_orders_REC = mysqli_fetch_assoc($qu_job_orders_EXE)){
				$job_order_id = $job_orders_REC['job_order_id'];
				$job_order_ref = $job_orders_REC['job_order_ref'];
				$project_name = $job_orders_REC['project_name'];
				$job_order_type = $job_orders_REC['job_order_type'];
				$job_order_status = $job_orders_REC['job_order_status'];
				$created_date = $job_orders_REC['created_date'];
				$created_by = $job_orders_REC['created_by'];
			?>
			<option value="<?=$job_order_id; ?>"><?=$job_order_ref; ?> - <?=$project_name; ?></option>
			<?php
			}
			} else {
		?>
		<option value="0" selected><?=lang("NO_DATA_FOUND", "غير محدد"); ?></option>
		<?php
		}
	}
	catch(Exception $e){
		if ( is_resource($KONN)) {
			mysqli_close($KONN);
		}
	}
	finally{
		if ( is_resource($KONN)) {
			mysqli_close($KONN);
		}
	}
?>
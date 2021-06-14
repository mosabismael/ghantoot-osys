<?php
	
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		//this table name
		$DtTblName = "job_orders_processes_acts";
		//this table data name
		$DtTbl = "activity";
		//forign key name
		$DtTblHead = "process_id";
		
		
		if(!isset($_POST['data_id'])){
			die('7wiu');
		}
		
		$data_id = (int) $_POST['data_id'];
		$return_arr;
		
		$q = "SELECT `".$DtTbl."_id`, `".$DtTbl."_name` FROM `$DtTblName` WHERE `$DtTblHead` = '".$data_id."' ORDER BY `activity_id` ASC";
		$userStatement = mysqli_prepare($KONN,$q);
		mysqli_stmt_execute($userStatement);
		$q_exe1 = mysqli_stmt_get_result($userStatement);
		if(mysqli_num_rows($q_exe1) == 0){
		?>
		<option value="0" selected>NO DATA FOUND</option>
		<?php
			} else {
		?>
		<option value="0" selected>------- Please Select -------</option>
		<?php	
			// $ee=1;
			while( $DT = mysqli_fetch_array($q_exe1) ){
			?>
			<option value="<?=$DT[0]; ?>"><?=$DT[1]; ?></option>
			<?php	
			}
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

<?php
	
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		//this table name
		$DtTblName = "inv_06_codes";
		//this table data name
		$DtTbl = "code";
		//forign key name
		$DtTblHead = "category_id";
		
		
		if(!isset($_POST['data_id'])){
			die('7wiu');
		}
		
		$data_id = (int) $_POST['data_id'];
		$return_arr;
		
		$code_id = 0;
		$selected = 'selected';
		if(isset($_POST['item_code_id'])){
			$selected = "";
			$code_id = (int) $_POST['item_code_id'];
		}
		
		$q = "SELECT * FROM `$DtTblName` WHERE `category_id` = '".$data_id."' ORDER BY `code_id` ASC";
		$userStatement = mysqli_prepare($KONN,$q);
		mysqli_stmt_execute($userStatement);
		$q_exe1 = mysqli_stmt_get_result($userStatement);
		if(mysqli_num_rows($q_exe1) == 0){
		?>
		<option value="0" <?=$selected?>>NO DATA FOUND</option>
		<?php
			} else {
		?>
		<option value="0" <?=$selected?>>------- Please Select -------</option>
		<?php	
			// $ee=1;
			while( $DT = mysqli_fetch_assoc($q_exe1) ){
				$selected = "";
			if($code_id == $DT['code_id']){
					$selected = 'selected';
			}
			?>
			<option value="<?=$DT['code_id']; ?>"
			id="coder-<?=$DT['code_id']; ?>"
			uniter="<?=$DT['code_unit_id']; ?>"
			desc="<?=$DT['item_description']; ?>" <?=$selected?>><?=$DT['item_description']; ?> : <?=$DT['item_name']; ?></option>
			
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

<?php
	
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	try{
		
		if(!isset($_POST['data_id'])){
			die('7wiu');
		}
		
		$division_id = (int) $_POST['data_id'];
		
		$subdivision_id = 0;
		$selected = 'selected';
		if(isset($_POST['subdivision_id'])){
			$selected = "";
			$subdivision_id = (int) $_POST['subdivision_id'];
		}
		$return_arr;
		
		$q = "SELECT * FROM `inv_04_subdivisions` WHERE `division_id` = '".$division_id."' ORDER BY `subdivision_id` ASC";
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
			if($subdivision_id == $DT['subdivision_id']){
					$selected = 'selected';
			}
			?>
			<option value="<?=$DT['subdivision_id']; ?>" id="subdivs-<?=$DT['subdivision_id']; ?>" 
			is_finished="<?=$DT['is_finished']; ?>" 
			unit_id="<?=$DT['unit_id']; ?>" <?=$selected?>><?=$DT['subdivision_description']; ?> : <?=$DT['subdivision_name']; ?></option>
			
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

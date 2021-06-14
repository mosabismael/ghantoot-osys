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
		
		$section_id = (int) $_POST['data_id'];
		$division_id = 0;
		$selected = 'selected';
		if(isset($_POST['division_id'])){
			$selected = "";
			$division_id = (int) $_POST['division_id'];
		}
		
		$return_arr;
		
		$q = "SELECT * FROM `inv_03_divisions` WHERE `section_id` = '".$section_id."' ORDER BY `division_id` ASC";
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
			if($division_id == $DT['division_id']){
					$selected = 'selected';
			}
			?>
			
			<option value="<?=$DT['division_id']; ?>" 
			id="divs-<?=$DT['division_id']; ?>" 
			is_finished="<?=$DT['is_finished']; ?>" 
			unit_id="<?=$DT['unit_id']; ?>" <?=$selected?> ><?=$DT['division_description']; ?> : <?=$DT['division_name']; ?></option>
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
		
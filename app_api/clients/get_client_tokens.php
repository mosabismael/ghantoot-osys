<?php
	
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	
	try{
		
		$token_id = 0;
		if(isset($_POST['token_id'])){
			$token_id = (int) $_POST['token_id'];
		}
		
		
		if(!isset($_POST['client_id'])){
			die('7wiu');
		}
		if(!isset($_POST['operation'])){
			die('7wideu');
		}
		
		$client_id = $_POST['client_id'];
		$operation = (int) $_POST['operation'];
		$return_arr;
		
		$q = "SELECT * FROM `tkn_data` WHERE `client_id` = '".$client_id."' ";
		$userStatement = mysqli_prepare($KONN,$q);
		mysqli_stmt_execute($userStatement);
		$q_exe1 = mysqli_stmt_get_result($userStatement);
		if(mysqli_num_rows($q_exe1) == 0){
			
		?>
		<option value="0" selected><?=lang('---No Tokens Available---'); ?></option>
		<?php
			
			} else {
			$isSelected = " selected";
			if( $token_id != 0 ){
				$isSelected = "";
			}
			
		?>
		<option value="0" <?=$isSelected; ?>><?=lang('---Please_Select_Token---'); ?></option>
		<?php
			$ee=1;
			while($tkn_data_REC = mysqli_fetch_assoc($q_exe1)){
				$isSelected = "";
				if( $token_id == $tkn_data_REC['token_id'] ){
					$isSelected = " selected";
				}
			?>
			<option <?=$isSelected; ?> value="<?=$tkn_data_REC['token_id']; ?>" title="<?=$tkn_data_REC['token_notes']; ?>"><?=$tkn_data_REC['token_ref']; ?> - <?=$tkn_data_REC['token_date']; ?> ( <?=$tkn_data_REC['token_type']; ?> )</option>
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

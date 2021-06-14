<?php
	
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	try{
		
		
		
		if(!isset($_POST['client_id'])){
			die('7wiu');
		}
		if(!isset($_POST['operation'])){
			die('7wideu');
		}
		
		$client_id = $_POST['client_id'];
		$operation = (int) $_POST['operation'];
		$return_arr;
		
		$q = "SELECT * FROM `gen_clients` WHERE `client_id` = '".$client_id."' ";
		$userStatement = mysqli_prepare($KONN,$q);
		mysqli_stmt_execute($userStatement);
		$q_exe1 = mysqli_stmt_get_result($userStatement);
		if(mysqli_num_rows($q_exe1) == 0){
			
			die('0|error');
			
			} else {
			$ee=1;
			while($client_conts = mysqli_fetch_assoc($q_exe1)){
			?>
			<tr id="contact-<?=$client_conts['client_id']; ?>">
				<td class="contacts_count"><?=$ee++; ?></td>
				<td><input type="text" name="contact_name[]" value="<?=$client_conts['client_name']; ?>" required></td>
				<td><input type="text" name="contact_phone[]" value="<?=$client_conts['phone']; ?>" required></td>
				<td><input type="email" name="contact_email[]" value="<?=$client_conts['email']; ?>" required></td>
				<td><input type="email" name="contact_position[]" value="<?=$client_conts['client_category']; ?>" required></td>
				<td>
					<input class="frmData" type="hidden" 
					id="new-contact_ids<?=$client_conts['client_id']; ?>" 
					name="contact_ids[]" 
					value="<?=$client_conts['client_id']; ?>"
					req="1" 
					den="" 
					alerter="<?=lang("Please_Check_Contacts", "AAR"); ?>">
				<i onclick="$('#contact-<?=$client_conts['client_id']; ?>').remove();fix_cont_counters();" class="fa fa-trash"></i></td>
			</tr>
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

<?php
	
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	
	try{
		
		
		if(!isset($_POST['quotation_id'])){
			die('7wiu');
		}
		if(!isset($_POST['operation'])){
			die('7wideu');
		}
		
		$quotation_id = $_POST['quotation_id'];
		$operation = (int) $_POST['operation'];
		$return_arr;
		
		$q = "SELECT * FROM `sales_quotations_contacts` WHERE `quotation_id` = '".$quotation_id."' ";
		$userStatement = mysqli_prepare($KONN,$q);
		mysqli_stmt_execute($userStatement);
		$q_exe1 = mysqli_stmt_get_result($userStatement);
		if(mysqli_num_rows($q_exe1) == 0){
			
			die('0|error');
			
			} else {
			$ee=1;
			while($sales_quotations_contacts_DATA = mysqli_fetch_assoc($q_exe1)){
				
				$link_id = $sales_quotations_contacts_DATA['link_id'];
				$contact_id = $sales_quotations_contacts_DATA['contact_id'];
				
				$qu_gen_clients_contacts_sel = "SELECT * FROM  `gen_clients_contacts` WHERE `contact_id` = $contact_id";
				$userStatement = mysqli_prepare($KONN,$qu_gen_clients_contacts_sel);
				mysqli_stmt_execute($userStatement);
				$qu_gen_clients_contacts_EXE = mysqli_stmt_get_result($userStatement);
				$client_conts;
				if(mysqli_num_rows($qu_gen_clients_contacts_EXE)){
					$client_conts = mysqli_fetch_assoc($qu_gen_clients_contacts_EXE);
				}
				
				
			?>
			<tr id="contact-<?=$client_conts['contact_id']; ?>">
				<td class="contacts_count"><?=$ee++; ?></td>
				<td><input type="text" name="contact_name[]" value="<?=$client_conts['contact_name']; ?>" required></td>
				<td><input type="text" name="contact_phone[]" value="<?=$client_conts['contact_phone']; ?>" required></td>
				<td><input type="email" name="contact_email[]" value="<?=$client_conts['contact_email']; ?>" required></td>
				<td><input type="email" name="contact_position[]" value="<?=$client_conts['contact_position']; ?>" required></td>
				<td>
					<input class="frmData" type="hidden" 
					id="new-contact_ids<?=$client_conts['contact_id']; ?>" 
					name="contact_ids[]" 
					value="<?=$client_conts['contact_id']; ?>"
					req="1" 
					den="" 
					alerter="<?=lang("Please_Check_Contacts", "AAR"); ?>">
				<i onclick="$('#contact-<?=$client_conts['contact_id']; ?>').remove();fix_cont_counters();" class="fa fa-trash"></i></td>
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

<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	$page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	// $page_title=$page_description=$page_keywords=$page_author= "Site Title";
	
	
	$pageID = 0;
	$subPageID = 0;
	
?>
<!DOCTYPE html>
<html dir="<?=$lang_dir; ?>" lang="<?=$lang; ?>">
<html>
<head>
	<?php include('app/meta.php'); ?>
    <?php include('app/assets.php'); ?>
</head>
<body>
<?php
	$WHERE = lang("user_messages","AAR");
	include('app/header.php');
	//PAGE DATA START -----------------------------------------------///---------------------------------
?>

<div class="panel panelPrimary">
	<div class="panelHeader">
		<?=lang("my_messages","AAR"); ?>
	</div><!-- panelHeader END -->
	<div class="panelBody">
	
	
		
<table class="tabler">
	<thead>
		<tr>
			<th><?=lang("REF", "AAR"); ?></th>
			<th><?=lang("Sent", "AAR"); ?></th>
			<th><?=lang("Title", "AAR"); ?></th>
			<th><?=lang("Content", "AAR"); ?></th>
			<th><?=lang("Sender", "AAR"); ?></th>
		</tr>
	</thead>
	<tbody>
<?php
	
	//TODO :: switch this page into chat view
	 
	$qu_users_messages_sel = "SELECT * FROM  `users_messages` WHERE `receiver_id` = $EMPLOYEE_ID";
	$qu_users_messages_EXE = mysqli_query($KONN, $qu_users_messages_sel);
	if(mysqli_num_rows($qu_users_messages_EXE)){
		while($users_messages_REC = mysqli_fetch_assoc($qu_users_messages_EXE)){
			$message_id = $users_messages_REC['message_id'];
			$message_title = $users_messages_REC['message_title'];
			$message_content = $users_messages_REC['message_content'];
			$sender_id = $users_messages_REC['sender_id'];
			$receiver_id = $users_messages_REC['receiver_id'];
			$sent_time = $users_messages_REC['sent_time'];
			$received_time = $users_messages_REC['received_time'];
			$is_read = (int) $users_messages_REC['is_read'];
			
			if( $is_read == 0 ){
				$received_time = date('Y-m-d H:i:00');
				$qu_users_messages_updt = "UPDATE  `users_messages` SET 
									`received_time` = '".$received_time."', `is_read` = '1'
									WHERE `message_id` = $message_id;";

				if(!mysqli_query($KONN, $qu_users_messages_updt)){
					echo mysqli_error( $KONN );
				}
			}
			
	$qu_hr_employees_sel = "SELECT * FROM  `hr_employees` WHERE `employee_id` = $sender_id";
	$qu_hr_employees_EXE = mysqli_query($KONN, $qu_hr_employees_sel);
	$hr_employees_DATA;
	if(mysqli_num_rows($qu_hr_employees_EXE)){
		$hr_employees_DATA = mysqli_fetch_assoc($qu_hr_employees_EXE);
	}
		$employee_namer = $hr_employees_DATA['first_name'].' '.$hr_employees_DATA['last_name'];
			
			
		?>
		<tr id="mess-<?=$message_id; ?>">
			<td><?=$message_id; ?></td>
			<td><?=$sent_time; ?></td>
			<td><?=$message_title; ?></td>
			<td><?=$message_content; ?></td>
			<td><?=$employee_namer; ?></td>
		</tr>
		<?php
		}
	} else {
		?>
		<tr id="mess-0>">
			<td colspan="5"><?=lang("No Data Found", "AAR"); ?></td>
		</tr>
		<?php
	}
?>
	</tbody>
</table>
	
	
	</div><!-- panelBody END -->
	<div class="panelFooter">
		&nbsp;
	</div><!-- panelFooter END -->
</div><!-- panel END -->







<?php
	//PAGE DATA END   ----------------------------------------------///---------------------------------
	include('app/footer.php');
?>
<script>

</script>
</body>
</html>
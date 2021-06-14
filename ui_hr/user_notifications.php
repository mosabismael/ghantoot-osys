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
	$WHERE = lang("user_notifications","AAR");
	include('app/header.php');
	//PAGE DATA START -----------------------------------------------///---------------------------------
?>

<div class="panel panelPrimary">
	<div class="panelHeader">
		<?=lang("my_notifications","AAR"); ?>
	</div><!-- panelHeader END -->
	<div class="panelBody">
	
	
		
<table class="tabler">
	<thead>
		<tr>
			<th><?=lang("Sys_REF", "AAR"); ?></th>
			<th><?=lang("Date", "AAR"); ?></th>
			<th><?=lang("Title", "AAR"); ?></th>
			<th><?=lang("Content", "AAR"); ?></th>
			<th><?=lang("Sender", "AAR"); ?></th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
<?php
	$qu_users_notifications_sel = "SELECT * FROM  `users_notifications` WHERE `receiver_id` = $EMPLOYEE_ID";
	$qu_users_notifications_EXE = mysqli_query($KONN, $qu_users_notifications_sel);
	if(mysqli_num_rows($qu_users_notifications_EXE)){
		while($users_notifications_REC = mysqli_fetch_assoc($qu_users_notifications_EXE)){
			$notification_id = $users_notifications_REC['notification_id'];
			$notification_title = $users_notifications_REC['notification_title'];
			$notification_content = $users_notifications_REC['notification_content'];
			$receiver_id = $users_notifications_REC['receiver_id'];
			$notification_time = $users_notifications_REC['notification_time'];
			$is_notified = $users_notifications_REC['is_notified'];
			
		?>
		<tr id="not-<?=$notification_id; ?>">
			<td><?=$notification_id; ?></td>
			<td><?=$notification_time; ?></td>
			<td><?=$notification_title; ?></td>
			<td><?=$notification_content; ?></td>
			<td><?=$is_notified; ?></td>
			<td>--</td>
		</tr>
		<?php
		}
	} else {
		?>
		<tr id="not-0>">
			<td colspan="6"><?=lang("No Data Found", "AAR"); ?></td>
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
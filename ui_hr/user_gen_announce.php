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
	$WHERE = lang("general_announcements","AAR");
	include('app/header.php');
	//PAGE DATA START -----------------------------------------------///---------------------------------
?>

<div class="panel panelPrimary">
	<div class="panelHeader">
		<?=lang("general_announcements","AAR"); ?>
	</div><!-- panelHeader END -->
	<div class="panelBody">
	
	
		
<table class="tabler">
	<thead>
		<tr>
			<th><?=lang("REF", "AAR"); ?></th>
			<th><?=lang("Date", "AAR"); ?></th>
			<th><?=lang("Title", "AAR"); ?></th>
			<th><?=lang("Content", "AAR"); ?></th>
			<th><?=lang("Sender", "AAR"); ?></th>
		</tr>
	</thead>
	<tbody>
<?php
	$qu_users_announcements_sel = "SELECT * FROM  `users_announcements` WHERE `receiver_dept_id` = $DEPARTMENT_ID";
	$qu_users_announcements_EXE = mysqli_query($KONN, $qu_users_announcements_sel);
	if(mysqli_num_rows($qu_users_announcements_EXE)){
		while($users_announcements_REC = mysqli_fetch_assoc($qu_users_announcements_EXE)){
			$announcement_id = $users_announcements_REC['announcement_id'];
			$announcement_ref = $users_announcements_REC['announcement_ref'];
			$announcement_title = $users_announcements_REC['announcement_title'];
			$announcement_content = $users_announcements_REC['announcement_content'];
			$sender_id = $users_announcements_REC['sender_id'];
			$receiver_dept_id = $users_announcements_REC['receiver_dept_id'];
			$sent_time = $users_announcements_REC['sent_time'];
			
	$qu_hr_employees_sel = "SELECT * FROM  `hr_employees` WHERE `employee_id` = $sender_id";
	$qu_hr_employees_EXE = mysqli_query($KONN, $qu_hr_employees_sel);
	$hr_employees_DATA;
	if(mysqli_num_rows($qu_hr_employees_EXE)){
		$hr_employees_DATA = mysqli_fetch_assoc($qu_hr_employees_EXE);
	}
		$employee_namer = $hr_employees_DATA['first_name'].' '.$hr_employees_DATA['last_name'];
			
			
		?>
		<tr id="ann-<?=$announcement_id; ?>">
			<td><?=$announcement_ref; ?></td>
			<td><?=$sent_time; ?></td>
			<td><?=$announcement_title; ?></td>
			<td><?=$announcement_content; ?></td>
			<td><?=$employee_namer; ?></td>
		</tr>
		<?php
		}
	} else {
		?>
		<tr id="ann-0>">
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
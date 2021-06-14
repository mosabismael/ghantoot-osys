<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	$pageID = 0;
?>
<!DOCTYPE html>
<html dir="<?=$lang_dir; ?>" lang="<?=$lang; ?>">
<head>
	<?php include('app/meta.php'); ?>
    <?php include('app/assets.php'); ?>
</head>
<body>
<?php

	$WHERE = "users_notifications";
	include('app/header.php');
	//PAGE DATA START -----------------------------------------------///---------------------------------
?>



<div class="row">
	<div class="col-100">
		
		<table id="dataTable" class="tabler" border="2">
			<thead>
				<tr>
					<th><?=lang("NO.", "AAR"); ?></th>
					<th style="width: 25%;"><?=lang("Title", "AAR"); ?></th>
					<th style="width: 25%;"><?=lang("content", "AAR"); ?></th>
					<th style="width: 25%;"><?=lang("link", "AAR"); ?></th>
					<th style="width: 20%;"><?=lang("From", "AAR"); ?></th>
				</tr>
			</thead>
			<tbody>
<?php
	$sNo = 0;
	$qu_users_notifications_sel = "SELECT * FROM  `users_notifications` WHERE `receiver_id` = '$EMPLOYEE_ID' ORDER BY `notification_id` DESC";
	$qu_users_notifications_EXE = mysqli_query($KONN, $qu_users_notifications_sel);
	if(mysqli_num_rows($qu_users_notifications_EXE)){
		while($users_notifications_REC = mysqli_fetch_assoc($qu_users_notifications_EXE)){
			$sNo++;
			
			$notification_id = $users_notifications_REC['notification_id'];
		$notification_title = $users_notifications_REC['notification_title'];
		$notification_content = $users_notifications_REC['notification_content'];
		$notification_link = $users_notifications_REC['notification_link'];
		$sender_id = $users_notifications_REC['sender_id'];
		$notification_time = $users_notifications_REC['notification_time'];
		$is_notified = $users_notifications_REC['is_notified'];
		
		$sender = get_emp_name($KONN, $sender_id );
		
		
		?>
			<tr id="not-<?=$notification_id; ?>">
				<td><?=$sNo; ?></td>
				<td><?=$notification_title; ?></td>
				<td><?=$notification_content; ?></td>
				<td><?=$notification_link; ?></td>
				<td><?=$sender; ?></td>
			</tr>
		<?php
		}
	} else {
?>
			<tr>
				<td colspan="5">No Notifications Found</td>
			</tr>
<?php
	}
?>
			</tbody>
		</table>
		
	</div>
	<div class="zero"></div>
</div>

<?php
	//PAGE DATA END   ----------------------------------------------///---------------------------------
	include('app/footer.php');
?>








<!--    ///////////////////      add_new_modal Modal START    ///////////////////            -->
<div class="modal" id="add_new_modal">
	<div class="modal-container">
		<div class="modal-header">
			<?php include("app/modal_header.php"); ?>
		</div>
		<div class="modal-body">
			<?php 
				//include('../forms/users_notifications/add_new.php'); 
			?>
		</div>
	</div>
	<div class="zero"></div>
</div>
<!--    ///////////////////      add_new_modal Modal END    ///////////////////            -->



















<script>

$(document).ready(function(){
  $(".filterSearch").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    var TBL = $(this).attr('tbl-id');
    $("#" + TBL + " tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});









init_nwFormGroup();
</script>

</body>
</html>
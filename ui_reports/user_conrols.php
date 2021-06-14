
		<div class="row">
			

	<div class="col-25">
	
	
	
	

<div class="panel panelDanger">
	<!--div class="panelHeader">
		<i class="fas fa-calendar-alt"></i><?=lang("Today's_Events", "AAR"); ?>
	</div--><!-- panelHeader END -->
	<div class="panelBody">
	
				<ul class="index-list">
<?php
	$event_dateStart = date('Y-m-d 00:00:00');
	$event_dateEnd = date('Y-m-d 23:59:59');
	
	
	$qu_users_events_sel = "SELECT * FROM  `users_events` WHERE 
	`event_date` >= '$event_dateStart' AND 
	`event_date` <= '$event_dateEnd' ORDER BY `event_date` ASC";
	$qu_users_events_EXE = mysqli_query($KONN, $qu_users_events_sel);
	if(mysqli_num_rows($qu_users_events_EXE)){
		$tot_apps = 0;
		while($users_events_REC = mysqli_fetch_assoc($qu_users_events_EXE)){
			$tot_apps++;
			$event_title = $users_events_REC['event_title'];
?>
					<li>
						<h6><?=lang("Event NO.", "AAR"); ?><?=$tot_apps; ?></h6>
						<p><?=$event_title; ?></p>
					</li>
<?php
		}
	} else {
?>
					<li>
						<h6>&nbsp;</h6>
						<p><?=lang("No_Events_Found", "AAR"); ?></p>
					</li>
<?php
	}
?>
				</ul>
	
	
	
	
	</div><!-- panelBody END -->
	<div class="panelFooter">
		<a href="user_calendar.php"><?=lang("View_All", "AAR"); ?></a>
	</div><!-- panelFooter END -->
</div><!-- panel END -->


	</div>
	<div class="col-25">
	


<div class="panel panelDanger">
	<!--div class="panelHeader">
		<i class="fas fa-bullhorn"></i><?=lang("general_announcement", "AAR"); ?>
	</div --><!-- panelHeader END -->
	<div class="panelBody">
				<ul class="index-list">
<?php
	$qu_users_messages_sel = "SELECT * FROM  `users_announcements` ORDER BY `announcement_id` ASC";
	$qu_users_messages_EXE = mysqli_query($KONN, $qu_users_messages_sel);
	if(mysqli_num_rows($qu_users_messages_EXE)){
		while($users_messages_REC = mysqli_fetch_assoc($qu_users_messages_EXE)){
		?>
		<li>
			<h6><?=$users_messages_REC["announcement_title"]; ?></h6>
			<p><?=$users_messages_REC["announcement_content"]; ?></p>
		</li>
		
		<?php
		}
	} else {
?>
		<li>
			<h6>&nbsp;</h6>
			<p class="text-info"><?=lang("No_announcements_found", "AAR"); ?></p>
		</li>
<?php
	}
?>
				</ul>
	
	
	</div><!-- panelBody END -->
	<div class="panelFooter">
		<a href="user_gen_announce.php"><?=lang("View_All", "AAR"); ?></a>
	</div><!-- panelFooter END -->
</div><!-- panel END -->

	</div>
	<div class="col-25">
	

<div class="panel panelDanger">
	<!--div class="panelHeader">
		<i class="fas fa-envelope"></i><?=lang("My_Messages", "AAR"); ?>
	</div --><!-- panelHeader END -->
	<div class="panelBody">
				<ul class="index-list">
<?php
	$qu_users_messages_sel = "SELECT * FROM  `users_messages` WHERE `receiver_id` = $USER_ID AND `is_read` = 0";
	$qu_users_messages_EXE = mysqli_query($KONN, $qu_users_messages_sel);
	if(mysqli_num_rows($qu_users_messages_EXE)){
		while($users_messages_REC = mysqli_fetch_assoc($qu_users_messages_EXE)){
		?>
		<li>
			<h6><?=$users_messages_REC["message_title"]; ?></h6>
			<p><?=$users_messages_REC["message_content"]; ?></p>
		</li>
		
		<?php
		}
	} else {
?>
		<li>
			<h6>&nbsp;</h6>
			<p class="text-info"><?=lang("No_messages_found", "AAR"); ?></p>
		</li>
<?php
	}
?>

				</ul>
	
	
	</div><!-- panelBody END -->
	<div class="panelFooter">
		<a href="user_messages.php"><?=lang("View_All", "AAR"); ?></a>
	</div><!-- panelFooter END -->
</div><!-- panel END -->

	</div>
	<div class="col-25">
	

<div class="panel panelDanger">
	<!--div class="panelHeader">
		<i class="fas fa-bell"></i><?=lang("notifications", "AAR"); ?>
	</div --><!-- panelHeader END -->
	<div class="panelBody">
				<ul class="index-list">
<?php
	$qu_users_notifications_sel = "SELECT * FROM  `users_notifications` WHERE `receiver_id` = $USER_ID AND `is_notified` = 0";
	$qu_users_notifications_EXE = mysqli_query($KONN, $qu_users_notifications_sel);
	if(mysqli_num_rows($qu_users_notifications_EXE)){
		while($users_notifications_REC = mysqli_fetch_assoc($qu_users_notifications_EXE)){
		?>
		<li>
			<h6><?=$users_notifications_REC["notification_title"]; ?></h6>
			<p><?=$users_notifications_REC["notification_content"]; ?></p>
		</li>
		
		<?php
		}
	} else {
?>
		<li>
			<h6>&nbsp;</h6>
			<p class="text-info"><?=lang("You_have_no_new_notifications", "AAR"); ?></p>
		</li>
<?php
	}
?>

				</ul>
	
	
	</div><!-- panelBody END -->
	<div class="panelFooter">
		<a href="user_notifications.php"><?=lang("View_All", "AAR"); ?></a>
	</div><!-- panelFooter END -->
</div><!-- panel END -->

	</div>
	<div class="zero"></div>
			
			
			<div class="zero"></div>
		</div>
	<div class="zero"></div>
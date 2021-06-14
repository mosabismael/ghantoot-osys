<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 0;
	$subPageID = 1000;
?>
<!DOCTYPE html>
<html dir="<?=$lang_dir; ?>" lang="<?=$lang; ?>">
<head>
	<?php include('app/meta.php'); ?>
    <?php include('app/assets.php'); ?>
</head>
<body>
<?php

	$WHERE = "User Dashboard";
	include('app/header.php');
	//PAGE DATA START -----------------------------------------------///---------------------------------
?>


<div class="row">



	<div class="col-100">
		<div class="user-pic">
			<img src="<?=uploads_root; ?><?=$PROFILE_PIC; ?>" alt="<?=$USER_NAME; ?> - user picture" />
		</div>
		
		<div class="user-welcome">
			<span id="stater"><?=lang("Happy_day", "AAR"); ?>, </span>
			<h1><?=$USER_NAME; ?></h1>
		</div>
	</div>

	<div class="col-100">
		<div class="row">
			

	<div class="col-25">
	
	
	
	

<div class="panel panelDanger">
	<div class="panelHeader">
		<i class="fas fa-calendar-alt"></i><?=lang("Today's_Events", "AAR"); ?>
	</div><!-- panelHeader END -->
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
	<div class="panelHeader">
		<i class="fas fa-bullhorn"></i><?=lang("general_announcement", "AAR"); ?>
	</div><!-- panelHeader END -->
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
	<div class="panelHeader">
		<i class="fas fa-envelope"></i><?=lang("My_Messages", "AAR"); ?>
	</div><!-- panelHeader END -->
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
	<div class="panelHeader">
		<i class="fas fa-bell"></i><?=lang("notifications", "AAR"); ?>
	</div><!-- panelHeader END -->
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
	</div>







	<div class="col-100">
	
<div class="panel panelDanger">
	<div class="panelHeader">
		<i class="fas fa-archive"></i><?=lang("KPIs", "AAR"); ?>
	</div><!-- panelHeader END -->
	<div class="panelBody">
	
	
	
				<div class="kpi-holder">
				


<div class="kpi-box text-success">
								<?php
									$monthNumber = date('m');
									$dayNumber = intval(date('d'));
									$qu_pur_requisitions_sel = "SELECT count(*) as daysWorked, ts.ts_month, hr.employee_id FROM hr_employees_ts_days hr , hr_employees_ts ts where ts.ts_id = hr.ts_id and ts.ts_month = $monthNumber and hr.employee_id = $EMPLOYEE_ID group by hr.employee_id, hr.ts_id ;" ;
									//echo $qu_pur_requisitions_sel;
									$daysWorked=0 ;
									$qu_pur_requisitions_EXE = mysqli_query($KONN, $qu_pur_requisitions_sel);
									if(mysqli_num_rows($qu_pur_requisitions_EXE)){
										while($pur_requisitions_REC = mysqli_fetch_assoc($qu_pur_requisitions_EXE)){
											$dayWorked = intval($pur_requisitions_REC['daysWorked']);
										}
										$precentRate = round(($dayWorked) * (100/$dayNumber));
										
										
									}
									else{
										$precentRate = 100;
									}
									?>
									
									<div class="progress-bar1 text-success" data-percent="<?=$precentRate?>" data-duration="1000" data-color="#f1f1f1,#5cb85c"></div>
								
								
								<p class="kpi-name"><?=lang("Present Rate", "AAR"); ?></p>
							</div>
							
							
							<div class="kpi-box text-success">
								<?php
									$monthNumber = date('m');
									$dayNumber = intval(date('d'));
									$qu_pur_requisitions_sel = "SELECT count(*) as daysWorked, ts.ts_month, hr.employee_id FROM hr_employees_ts_days hr , hr_employees_ts ts where ts.ts_id = hr.ts_id and ts.ts_month = $monthNumber and hr.employee_id = $EMPLOYEE_ID group by hr.employee_id, hr.ts_id ;" ;
									$daysWorked=0 ;
									$absentRate = 0;
									$qu_pur_requisitions_EXE = mysqli_query($KONN, $qu_pur_requisitions_sel);
									if(mysqli_num_rows($qu_pur_requisitions_EXE)){
										while($pur_requisitions_REC = mysqli_fetch_assoc($qu_pur_requisitions_EXE)){
											$dayWorked = intval($pur_requisitions_REC['daysWorked']);
										}

										$numberOfDaysAbsent = $dayNumber-$dayWorked;
										$absentRate = round(($numberOfDaysAbsent /  $dayNumber) * 100);
										
										
									}?>
									
									<div class="progress-bar1 text-success" data-percent="<?=$absentRate?>" data-duration="1000" data-color="#f1f1f1,#5cb85c"></div>
								
								
								<p class="kpi-name"><?=lang("Absence Rate", "AAR"); ?></p>
							</div>
							
							
							
							
							<div class="kpi-box text-success">
								<?php
									$qu_pur_requisitions_sel = "SELECT count(*) as workedHour FROM `gen_status_change` where action_by = $EMPLOYEE_ID and status_date = CURDATE();;" ;
									$daysWorked=0 ;
									$effectiveness = 0;
									$qu_pur_requisitions_EXE = mysqli_query($KONN, $qu_pur_requisitions_sel);
									if(mysqli_num_rows($qu_pur_requisitions_EXE)){
										while($pur_requisitions_REC = mysqli_fetch_assoc($qu_pur_requisitions_EXE)){
											$daysWorked = intval($pur_requisitions_REC['workedHour']);
										}

										
										$effectiveness = round((3600-($daysWorked*10))/100);
										if($daysWorked == 0)
											$effectiveness = 0;
										
									}?>
								<div class="progress-bar1 text-danger" data-percent="<?=$effectiveness?>" data-duration="1000" data-color="#f1f1f1,#d9534f"></div>
								<p class="kpi-name"><?=lang("productivity rate", "AAR"); ?></p>
							</div>
							
							
							
							
							
							
							
							<div class="kpi-box text-success">
								<?php
									$percent = round((($effectiveness+$precentRate+$absentRate)/3)*100);
								?>
								<div class="progress-bar1 text-danger" data-percent="30" data-duration="1000" data-color="#f1f1f1,#d9534f"></div>
								<p class="kpi-name"><?=lang("effectiveness", "AAR"); ?></p>
							</div>
							
							</div>
	
	
	</div><!-- panelBody END -->
	<div class="panelFooter">
		&nbsp;
	</div><!-- panelFooter END -->
</div><!-- panel END -->
	
	
	
	
	
	
	</div>
	
	<div class="zero"></div>
<script src="<?=assets_root; ?>js/progressbar.js"></script>
<script>
//CODE FOR KPIs
$(".progress-bar1").loading();
</script>
</div>










<?php
	//PAGE DATA END   ----------------------------------------------///---------------------------------
	include('app/footer.php');
?>
<script>

</script>
</body>
</html>
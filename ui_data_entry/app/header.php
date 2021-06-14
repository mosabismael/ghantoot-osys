<?php
	require_once('../z_elements/ui_header.php');
?>


<header>
	<div class="mainMenuNav">
		<div data-ids="0" class="navItem specItem">
			<i class="fas fa-home"></i>
		</div>
		
		<div data-ids="1" class="navItem">
			<span><?=lang("Labours_TimeSheets", "AAR"); ?></span>
		</div>
		
		<div data-ids="2" class="navItem">
			<span><?=lang("Machinary_TimeSheets", "AAR"); ?></span>
		</div>
		
		<div data-ids="3" class="navItem">
			<span><?=lang("Reports", "AAR"); ?></span>
		</div>
	</div>
	
	<div class="menuSubNav" id="subMenuContainer"></div>
	
</header>

<div id="menuContent-0" style="display:none !important;">
		<a class="<?php if( $subPageID == 1000 ){ echo "activeSub"; } ?>" href="index.php">
			<i class="fas fa-home"></i>
			<span><?=lang("Main", "AAR"); ?></span>
		</a>
		<a class="<?php if( $subPageID == 2000 ){ echo "activeSub"; } ?>" href="z_notifications.php">
			<i class="fas fa-bell"></i>
			<span><?=lang("Notifications", "AAR"); ?></span>
		</a>
		<a class="<?php if( $subPageID == 3000 ){ echo "activeSub"; } ?>" href="logout.php">
			<i class="fas fa-sign-out-alt"></i>
			<span><?=lang("Log_Out", "AAR"); ?></span>
		</a>
</div>
<div id="menuContent-1" style="display:none !important;">

		<a class="<?php if( $subPageID == 1 ){ echo "activeSub"; } ?>" href="labours_timesheets_new.php">
			<i class="far fa-calendar-plus"></i>
			<span><?=lang("Add_New", "AAR"); ?></span>
		</a>

		<a class="<?php if( $subPageID == 2 ){ echo "activeSub"; } ?>" href="labours_timesheets.php">
			<i class="far fa-calendar-alt"></i>
			<span><?=lang("Labours_timesheets", "AAR"); ?></span>
		</a>
		
</div>
<div id="menuContent-2" style="display:none !important;">

		<a class="<?php if( $subPageID == 3 ){ echo "activeSub"; } ?>" href="machines_timesheets_new.php">
			<i class="fas fa-calendar-plus"></i>
			<span><?=lang("Add_New", "AAR"); ?></span>
		</a>
		
		<a class="<?php if( $subPageID == 4 ){ echo "activeSub"; } ?>" href="machines_timesheets.php">
			<i class="fas fa-calendar-alt"></i>
			<span><?=lang("machines_timesheets", "AAR"); ?></span>
		</a>
</div>
<div id="menuContent-3" style="display:none !important;">
		
		<a class="<?php if( $subPageID == 5 ){ echo "activeSub"; } ?>" href="labours_timesheets_reports.php">
			<i class="far fa-address-card"></i>
			<span><?=lang("Reports", "AAR"); ?></span>
		</a>
</div>


<script>
initMnu();
</script>
<article id="article">
<?php
	require_once('../z_elements/ui_header.php');
?>

<header>
	<div class="mainMenuNav">
		<div data-ids="0" class="navItem specItem">
			<i class="fas fa-home"></i>
		</div>
		
		<div data-ids="1" class="navItem">
			<span><?=lang("clients", "AAR"); ?></span>
		</div>
		<div data-ids="2" class="navItem">
			<span><?=lang("Enquiries ", "AAR"); ?></span>
		</div>
		<div data-ids="3" class="navItem">
			<span><?=lang("Estimation", "AAR"); ?></span>
		</div>
		<div data-ids="4" class="navItem">
			<span><?=lang("Quotations", "AAR"); ?></span>
		</div>
	
		<div data-ids="5" class="navItem">
			<span><?=lang("Project", "AAR"); ?></span>
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
		<a class="<?php if( $subPageID == 10 ){ echo "activeSub"; } ?>" href="clients_new.php">
			<i class="fas fa-plus"></i>
			<span><?=lang("Add_New", "AAR"); ?></span>
		</a>
		<a class="<?php if( $subPageID == 11 ){ echo "activeSub"; } ?>" href="clients.php">
			<i class="fas fa-users"></i>
			<span><?=lang("clients_List", "AAR"); ?></span>
		</a>
</div>



<div id="menuContent-2" style="display:none !important;">
		<a class="<?php if( $subPageID == 20 ){ echo "activeSub"; } ?>" href="enquiries_new.php">
			<i class="fas fa-plus"></i>
			<span><?=lang("Add_New", "AAR"); ?></span>
		</a>
		<a class="<?php if( $subPageID == 21 ){ echo "activeSub"; } ?>" href="enquiries_List.php">
			<i class="fas fa-clipboard-list"></i>
			<span><?=lang("enquiries_List", "AAR"); ?></span>
		</a>
</div>


<div id="menuContent-3" style="display:none !important;">
		<!-- <a class="<?php if( $subPageID == 30 ){ echo "activeSub"; } ?>" href="projects_new.php">
			<i class="fas fa-folder-plus"></i>
			<span></span>
		</a> -->
		<a class="<?php if( $subPageID == 31 ){ echo "activeSub"; } ?>" href="projects_list.php">
			<i class="fas fa-folder-open"></i>
			<span><?=lang("Estimation_List", "AAR"); ?></span>
		</a>
</div>

<div id="menuContent-4" style="display:none !important;">
		<a class="<?php if( $subPageID == 40 ){ echo "activeSub"; } ?>" href="quotations_new.php">
			<i class="fas fa-plus"></i>
			<span><?=lang("Add_New", "AAR"); ?></span>
		</a>
		<a class="<?php if( $subPageID == 41 ){ echo "activeSub"; } ?>" href="quotations_list.php">
			<i class="fab fa-buffer"></i>
			<span><?=lang("quotations_List", "AAR"); ?></span>
		</a>
</div>
<div id="menuContent-5" style="display:none !important;">
		<a class="<?php if( $subPageID == 50 ){ echo "activeSub"; } ?>" href="punchlist.php">
		<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-checklist" viewBox="0 0 16 16">
  <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
  <path d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0zM7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0z"/>
</svg>			
<span><?=lang("Project_Punchlist", "AAR"); ?></span>
</a>

		<a class="<?php if( $subPageID == 51 ){ echo "activeSub"; } ?>" href="checklist.php">
			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-door-closed-fill" viewBox="0 0 16 16">
  <path d="M12 1a1 1 0 0 1 1 1v13h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V2a1 1 0 0 1 1-1h8zm-2 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
</svg>
			<span><?=lang("Project_Closeout_Checklis", "AAR"); ?></span>
		</a>
</div>
<script>
initMnu();
</script>
<article id="article">
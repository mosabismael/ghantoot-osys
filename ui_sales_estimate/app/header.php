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
			<span><?=lang("Quotations", "AAR"); ?></span>
		</div>
		
		<div data-ids="3" class="navItem">
			<span><?=lang("Estimation", "AAR"); ?></span>
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
		<a class="<?php if( $subPageID == 20 ){ echo "activeSub"; } ?>" href="quotations_new.php">
			<i class="fas fa-plus"></i>
			<span><?=lang("Add_New", "AAR"); ?></span>
		</a>
		<a class="<?php if( $subPageID == 21 ){ echo "activeSub"; } ?>" href="quotations_list.php">
			<i class="fab fa-buffer"></i>
			<span><?=lang("quotations_List", "AAR"); ?></span>
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




<script>
initMnu();
</script>
<article id="article">
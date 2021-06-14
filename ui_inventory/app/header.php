<?php
	require_once('../z_elements/ui_header.php');
?>

<header>
	<div class="mainMenuNav">
		<div data-ids="0" class="navItem specItem">
			<i class="fas fa-home"></i>
		</div>
		<div data-ids="1" class="navItem">
			<span><?=lang("Warehouse", "AAR"); ?></span>
		</div>
		<div data-ids="2" class="navItem">
			<span><?=lang("MRVs", "AAR"); ?></span>
		</div>
		<div data-ids="3" class="navItem">
			<span><?=lang("MIVs", "AAR"); ?></span>
		</div>
		<div data-ids="4" class="navItem">
			<span><?=lang("Assets", "AAR"); ?></span>
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
	<a class="<?php if( $subPageID == 1 ){ echo "activeSub"; } ?>" href="wh_areas.php">
		<i class="fas fa-sign"></i>
		<span><?=lang("Areas", "AAR"); ?></span>
	</a>
	<a class="<?php if( $subPageID == 2 ){ echo "activeSub"; } ?>" href="wh_racks.php">
		<i class="fas fa-server"></i>
		<span><?=lang("Racks", "AAR"); ?></span>
	</a>
	<a class="<?php if( $subPageID == 3 ){ echo "activeSub"; } ?>" href="wh_shelfs.php">
		<i class="fab fa-stack-overflow"></i>
		<span><?=lang("Shelfs", "AAR"); ?></span>
	</a>
	<a class="<?php if( $subPageID == 4 ){ echo "activeSub"; } ?>" href="stock_list.php">
		<i class="fas fa-warehouse"></i>
		<span><?=lang("Stock", "AAR"); ?></span>
	</a>
</div>

<div id="menuContent-2" style="display:none !important;">
	<a class="<?php if( $subPageID == 5 ){ echo "activeSub"; } ?>" href="mrv_new_01.php">
		<i class="fas fa-plus"></i>
		<span><?=lang("Add_New", "AAR"); ?></span>
	</a>
	<a class="<?php if( $subPageID == 6 ){ echo "activeSub"; } ?>" href="mrv_list.php">
		<i class="fas fa-shipping-fast"></i>
		<span><?=lang("Drafts", "AAR"); ?></span>
	</a>
	<a class="<?php if( $subPageID == 7 ){ echo "activeSub"; } ?>" href="mrv_list_inspection_required.php">
		<i class="far fa-eye"></i>
		<span><?=lang("Pending_Inspection", "AAR"); ?></span>
	</a>
	<a class="<?php if( $subPageID == 8 ){ echo "activeSub"; } ?>" href="mrv_list_pending_placement.php">
		<i class="fas fa-business-time"></i>
		<span><?=lang("Pending_placement", "AAR"); ?></span>
	</a>
</div>

<div id="menuContent-3" style="display:none !important;">
	<a class="<?php if( $subPageID == 9 ){ echo "activeSub"; } ?>" href="miv_new_01.php">
		<i class="fas fa-plus"></i>
		<span><?=lang("Add_New", "AAR"); ?></span>
	</a>
	
	<a class="<?php if( $subPageID == 10 ){ echo "activeSub"; } ?>" href="miv_list.php">
		<i class="fas fa-th-list"></i>
		<span><?=lang("miv_list", "AAR"); ?></span>
	</a>
</div>

<div id="menuContent-4" style="display:none !important;">

	<a class="<?php if( $subPageID == 11 ){ echo "activeSub"; } ?>" href="assets_list.php">
		<i class="fas fa-th-list"></i>
		<span><?=lang("assets_list", "AAR"); ?></span>
	</a>
	
	<a class="<?php if( $subPageID == 12 ){ echo "activeSub"; } ?>" href="assets_categories.php">
		<i class="fas fa-cubes"></i>
		<span><?=lang("assets_Categories", "AAR"); ?></span>
	</a>
</div>

<?php
/*
<header>
	<div class="siteLogo">
		<a href="index.php"><img src="<?=uploads_root; ?>/logo_icon.png" /></a>
	</div>
	<nav class="userNav">
	

		
	</nav>
	<div class="userIcon">
		<i class="fas fa-user"></i>
		<a href="z_notifications.php" title="My Notifications"><i class="fas fa-bell"></i></a>
		<a href="logout.php" title="Log Out"><i class="fas fa-sign-out-alt"></i></a>
	</div>
	<div class="zero"></div>
</header>
 
<div class="subNavContainer">
	<nav class="subNav">

<?php if( $pageID == 2 ){ ?>

<?php } ?>

<?php if( $pageID == 3 ){ ?>
		<a class="<?php if( $subPageID == 8 ){ echo "activeSub"; } ?>" href="miv_list.php">
			<span><?=lang("miv_list", "AAR"); ?></span>
		</a>
<?php } ?>
		

		
	</nav>
</div>


*/
?>









<script>
initMnu();
</script>
<article id="article">
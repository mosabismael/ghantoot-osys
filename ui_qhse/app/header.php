<?php
	require_once('../z_elements/ui_header.php');
?>

<header>
	<div class="mainMenuNav">
		<div data-ids="0" class="navItem specItem">
			<i class="fas fa-home"></i>
		</div>
		
		<div data-ids="1" class="navItem">
			<span><?=lang("requisitions", "AAR"); ?></span>
		</div>

		<div data-ids="2" class="navItem">
			<span><?=lang("MRVs", "AAR"); ?></span>
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
<?php if( $subPageID == 1 || $subPageID == 2 || $subPageID == 3 || $subPageID == 4 ){ ?>
	<a class="activeNew" onclick="show_modal( 'add_new_modal', 'material requisition' );">
		<i class="fas fa-plus"></i>
		<span><?=lang("Add_New", "AAR"); ?></span>
	</a>
<?php } else { ?>
	<a href="requisitions_draft.php?add_new=1">
		<i class="fas fa-plus"></i>
		<span><?=lang("Add_New", "AAR"); ?></span>
	</a>
<?php } ?>
		
	<a class="<?php if( $subPageID == 1 ){ echo "activeSub"; } ?>" href="requisitions_my.php">
		<i class="fas fa-address-book"></i>
		<span><?=lang("My_Requisitions", "AAR"); ?></span>
	</a>
	<a class="<?php if( $subPageID == 2 ){ echo "activeSub"; } ?>" href="requisitions_draft.php">
		<i class="fas fa-list-ul"></i>
		<span><?=lang("Draft_Requisitions", "AAR"); ?></span>
	</a>
	<a class="<?php if( $subPageID == 3 ){ echo "activeSub"; } ?>" href="requisitions_rfq.php">
		<i class="fas fa-check-double"></i>
		<span><?=lang("Approved_Requisitions", "AAR"); ?></span>
	</a>
	<a class="<?php if( $subPageID == 4 ){ echo "activeSub"; } ?>" href="requisitions_waiting_supplier.php">
		<i class="far fa-clock"></i>
		<span><?=lang("waiting_quotations", "AAR"); ?></span>
	</a>
</div>


<div id="menuContent-2" style="display:none !important;">
	<a class="<?php if( $subPageID == 5 ){ echo "activeSub"; } ?>" href="mrv_list.php">
		<i class="fas fa-th-list"></i>
		<span><?=lang("MRVs_list", "AAR"); ?></span>
	</a>
</div>


<script>
initMnu();
</script>
<article id="article">
<div id="loader" class="loader-showed">
	<img src="../uploads/loader.gif" alt="loading...">
	<span>Loading Data...</span>
</div>
<script>
	function start_loader( txt ){
		
		$('#loader span').html( txt );
		$('#loader').addClass("loader-blocked");
		setTimeout( function(){
			$('#loader').addClass("loader-showed");
		}, 100 );
		
		
		set_loader( 0 );
		return true;
	}
	function end_loader(){
		set_loader( 100 );
		setTimeout( function(){
			$('#loader').removeClass("loader-showed");
		}, 500 );
		
		setTimeout( function(){
		$('#loader').removeClass("loader-blocked");
		}, 1000 );
		return true;
	}
	function set_loader( percentage ){
		$('#loader .loader-bar').css("width", percentage + "%");
		return true;
	}
	start_loader('Loading Data...');
	set_loader(1);


var doc_w = $(window).width();
var doc_h = $(window).height();
var header_h = $('header').height();
</script>
<?php
$nw_langA = '';
switch($lang){
	case 'en':
		$nw_langA = 'ar';
		break;
	case 'ar':
		$nw_langA = 'en';
		break;
}
?>

<header>
	<div class="siteLogo">
		<a href="index.php"><img src="<?=uploads_root; ?>/logo_icon.png" /></a>
	</div>
	<nav class="userNav">
	
		<a class="<?php if( $pageID == 100 ){ echo "active"; } ?>" href="#">
			<span><?=lang("Projects", "AAR"); ?></span>
		</a>
		
		<a class="<?php if( $pageID == 100 ){ echo "active"; } ?>" href="#">
			<span><?=lang("Accounting", "AAR"); ?></span>
		</a>
		
		<a class="<?php if( $pageID == 100 ){ echo "active"; } ?>" href="#">
			<span><?=lang("Procurement", "AAR"); ?></span>
		</a>
		
		<a class="<?php if( $pageID == 100 ){ echo "active"; } ?>" href="#">
			<span><?=lang("QHSE", "AAR"); ?></span>
		</a>
		
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
<?php if( $pageID == 1 ){ ?>
		<a class="activeNew" onclick="show_modal( 'add_new_modal', 'material requisition' );">
			<span><?=lang("Add_New", "AAR"); ?></span>
		</a>
		<a class="<?php if( $subPageID == 1 ){ echo "active"; } ?>" href="requisitions_draft.php">
			<span><?=lang("Drafts", "AAR"); ?></span>
		</a>
		<a class="<?php if( $subPageID == 2 ){ echo "active"; } ?>" href="requisitions_rfq.php">
			<span><?=lang("Approved", "AAR"); ?></span>
		</a>
		<a class="<?php if( $subPageID == 3 ){ echo "active"; } ?>" href="requisitions_waiting_supplier.php">
			<span><?=lang("waiting_quotations", "AAR"); ?></span>
		</a>
<?php } ?>
		

<?php if( $pageID == 4 ){ ?>
		<a class="activeNew" onclick="show_modal( 'add_new_modal', 'New Job Order' );">
			<span><?=lang("Add_New", "AAR"); ?></span>
		</a>
<?php } ?>
		

<?php if( $pageID == 120 ){ ?>
		<a class="<?php if( $subPageID == 0 ){ echo "active"; } ?>" href="projects_reports.php">
			<span><?=lang("Material Tracking", "AAR"); ?></span>
		</a>
		<a class="<?php if( $subPageID == 0 ){ echo "active"; } ?>" href="projects_reports.php">
			<span><?=lang("Cost Reports", "AAR"); ?></span>
		</a>
<?php } ?>
		
	</nav>
</div>


<article id="article">
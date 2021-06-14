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
			<span><?=lang("purchase_orders", "AAR"); ?></span>
		</div>
		<div data-ids="3" class="navItem">
			<span><?=lang("Coding", "AAR"); ?></span>
		</div>
		<div data-ids="4" class="navItem">
			<span><?=lang("Suppliers", "AAR"); ?></span>
		</div>
		<div data-ids="5" class="navItem">
			<span><?=lang("PO_Options", "AAR"); ?></span>
		</div>
		<div data-ids="6" class="navItem">
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
	
	<?php if( $subPageID == 1 || $subPageID == 2 || $subPageID == 3 || $subPageID == 4 ){ ?>
		<a class="activeNew" onclick="show_modal( 'add_new_modal', 'material requisition' );">
			<i class="fas fa-plus"></i>
			<span><?=lang("Add_New", "AAR"); ?></span>
		</a>
		<?php } else { ?>
		<a href="requisitions.php?add_new=1">
			<i class="fas fa-plus"></i>
			<span><?=lang("Add_New", "AAR"); ?></span>
		</a>
	<?php } ?>
	<a class="<?php if( $subPageID == 1 ){ echo "activeSub"; } ?>" href="requisitions.php">
		<i class="far fa-clock"></i>
		<span class="badge" id = "badge1" style = "display:none;"></span>
		<span><?=lang("Drafts", "AAR"); ?></span>
	</a>
	<a class="<?php if( $subPageID == 2 ){ echo "activeSub"; } ?>" href="requisitions_rfq.php">
		<i class="far fa-paper-plane"></i>
		<span class="badge" id = "badge2" style = "display:none;"></span>
		<span><?=lang("Send_Enquiry", "AAR"); ?></span>
	</a>
	<a class="<?php if( $subPageID == 3 ){ echo "activeSub"; } ?>" href="requisitions_waiting_supplier.php">
		<i class="fas fa-tags"></i>
		<span class="badge" id = "badge3" style = "display:none;"></span>
		<span><?=lang("Add_quoted_prices", "AAR"); ?></span>
	</a>
	<a class="<?php if( $subPageID == 4 ){ echo "activeSub"; } ?>" href="requisitions_finished.php">
		<i class="fas fa-check-double"></i>
		<span class="badge" id = "badge4" style = "display:none;"></span>
		<span><?=lang("Finished", "AAR"); ?></span>
	</a>
	<a class="<?php if( $subPageID == 5 ){ echo "activeSub"; } ?>" href="all_requsitions.php">
		<i class="fas fa-list-ul"></i>
		<span class="badge" id = "badge5" style = "display:none;"></span>
		<span><?=lang("ALL", "AAR"); ?></span>
	</a>
</div>

<div id="menuContent-2" style="display:none !important;">
	<a class="<?php if( $subPageID == 6 ){ echo "activeSub"; } ?>" href="purchase_orders_rejected.php">
		<i class="fas fa-ban"></i>
		<span class="badge" id = "badge6" style = "display:none;"></span>
		<span><?=lang("Rejected", "AAR"); ?></span>
	</a>
	<a class="<?php if( $subPageID == 7 ){ echo "activeSub"; } ?>" href="purchase_orders_drafts.php">
		<i class="fas fa-tasks"></i>
		<span class="badge" id = "badge7" style = "display:none;"></span>
		<span><?=lang("Drafts", "AAR"); ?></span>
	</a>
	<a class="<?php if( $subPageID == 8 ){ echo "activeSub"; } ?>" href="purchase_orders_generated.php">
		<i class="fas fa-plug"></i>
		<span class="badge" id = "badge8" style = "display:none;"></span>
		<span><?=lang("Generated", "AAR"); ?></span>
	</a>
	<a class="<?php if( $subPageID == 9 ){ echo "activeSub"; } ?>" href="purchase_orders_pending_my_approval.php">
		<i class="fas fa-spell-check"></i>
		<span class="badge" id = "badge9" style = "display:none;"></span>
		<span><?=lang("Pending_My_Approval", "AAR"); ?></span>
	</a>
	<a class="<?php if( $subPageID == 10 ){ echo "activeSub"; } ?>" href="purchase_orders_pending_approval.php">
		<i class="fas fa-user-check"></i>
		<span class="badge" id = "badge10" style = "display:none;"></span>
		<span><?=lang("Pending_Approval", "AAR"); ?></span>
	</a>
	<a class="<?php if( $subPageID == 11 ){ echo "activeSub"; } ?>" href="purchase_orders_approved.php">
		<i class="fas fa-list"></i>
		<span class="badge" id = "badge11" style = "display:none;"></span>	
		<span><?=lang("Approved", "AAR"); ?></span>
	</a>
	<a class="<?php if( $subPageID == 111 ){ echo "activeSub"; } ?>" href="purchase_orders_all.php">
		<i class="fas fa-list-ul"></i>
		<span class="badge" id = "badge111" style = "display:none;"></span>
		<span><?=lang("All", "AAR"); ?></span>
	</a>
	<a class="<?php if( $subPageID == 1111 ){ echo "activeSub"; } ?>" href="stock_rejected_materials.php">
		<i class="fas fa-ban"></i>
		<span class="badge" id = "badge1111" style = "display:none;"></span>
		<span><?=lang("Rejected_Materials", "AAR"); ?></span>
	</a>
</div>


<div id="menuContent-3" style="display:none !important;">
	<a class="<?php if( $subPageID == 12 ){ echo "activeSub"; } ?>" href="inv_codification.php">
		<i class="fas fa-database"></i>
		<span><?=lang("Inventory_Coding", "AAR"); ?></span>
	</a>
</div>


<div id="menuContent-4" style="display:none !important;">
	<a class="<?php if( $subPageID == 13 ){ echo "activeSub"; } ?>" href="suppliers_new.php">
		<i class="fas fa-plus-square"></i>
		<span><?=lang("Add_New", "AAR"); ?></span>
	</a>
	<a class="<?php if( $subPageID == 14 ){ echo "activeSub"; } ?>" href="suppliers.php">
		<i class="fas fa-truck-moving"></i>
		<span><?=lang("suppliers_List", "AAR"); ?></span>
	</a>
	<a class="<?php if( $subPageID == 141 ){ echo "activeSub"; } ?>" href="suppliers_approved.php">
		<i class="fas fa-check"></i>
		<span><?=lang("approved_suppliers_List", "AAR"); ?></span>
	</a>
</div>

<div id="menuContent-5" style="display:none !important;">
	<a class="<?php if( $subPageID == 15 ){ echo "activeSub"; } ?>" href="purchase_orders_lim.php">
		<i class="fas fa-cogs"></i>
		<span><?=lang("PO_Options", "AAR"); ?></span>
	</a>
</div>

<div id="menuContent-6" style="display:none !important;">
	
	<a class="<?php if( $subPageID == 16 ){ echo "activeSub"; } ?>" href="assets_list.php">
		<i class="fas fa-th-list"></i>
		<span><?=lang("assets_list", "AAR"); ?></span>
	</a>
	
	<a class="<?php if( $subPageID == 17 ){ echo "activeSub"; } ?>" href="assets_categories.php">
		<i class="fas fa-cubes"></i>
		<span><?=lang("assets_Categories", "AAR"); ?></span>
	</a>
</div>






<script>
	notificationMenu();
	function notificationMenu(){
		$.ajax({
			url      :"<?=api_root; ?>notification/header_notification.php",
			data	 :{'cond':'AND receiver_id = <?=$EMPLOYEE_ID?>'},
			dataType :"json",
			type     :'POST',
			success  :function( response ){
				totalCount = 0;
				$('#badge6').hide();
				$('#badge7').hide();
				$('#badge11').hide();
				$('#badge10').hide();
				$('#badge111').hide();
												
				for(i=0;i<response.length;i++){
					if(response[i].po_status == 'draft_po'){
						$('#badge7').show();
						$('#badge7').html(response[i].count);
					}
					if(response[i].po_status == 'canceled'){
						$('#badge6').show();
						$('#badge6').html(response[i].count);
						totalCount += response[i].count;
					}
					if(response[i].po_status == 'pending_arrival'){
						$('#badge11').show();
						$('#badge11').html(response[i].count);
						totalCount += response[i].count;
					}
					if(response[i].po_status == 'pending_approval'){
						$('#badge10').show();
						$('#badge10').html(response[i].count);
						totalCount += response[i].count;
					}
					if(response[i].po_status == 'pm_denied'){
						//$('#badge10').show();
						//$('#badge10').html(response[i].count);
						totalCount += response[i].count;
					}
					if(totalCount > 0){
						$('#badge111').show();
						$('#badge111').html(totalCount);
						
					}
				}
			}
		});
		$.ajax({
			url      :"<?=api_root; ?>notification/header_notify_req.php",
			data	 :{'cond':'AND receiver_id = <?=$EMPLOYEE_ID?>'},
			dataType :"json",
			type     :'POST',
			success  :function( response ){
				totalCount = 0;
				$('#badge1').hide();
				$('#badge2').hide();
				$('#badge3').hide();
				$('#badge4').hide();
				$('#badge5').hide();
				
				for(i=0;i<response.length;i++){
					if(response[i].requisition_status == 'finish_req'){
						$('#badge4').show();
						$('#badge4').html(response[i].count);
						totalCount += response[i].count;
					}
					if(response[i].requisition_status == 'draft_req'){
						$('#badge1').show();
						$('#badge1').html(response[i].count);
						totalCount += response[i].count;
					}
					
					
					if(response[i].requisition_status == 'approve_req'){
						$('#badge2').show();
						$('#badge2').html(response[i].count);
						totalCount += response[i].count;
					}
					if(response[i].requisition_status == 'waiting_supplier'){
						$('#badge3').show();
						$('#badge3').html(response[i].count);
						totalCount += response[i].count;
					}
					if(totalCount > 0){
						$('#badge5').show();
						$('#badge5').html(totalCount);
						
					}
				}
			}
		});
		
	}
	initMnu();
</script>
<article id="article">	
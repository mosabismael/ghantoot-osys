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
			<span><?=lang("coding", "AAR"); ?></span>
		</div>
		
		<div data-ids="3" class="navItem">
			<span><?=lang("job_orders", "AAR"); ?></span>
		</div>
		<div data-ids="4" class="navItem">
			<span><?=lang("purchase_orders", "AAR"); ?></span>
		</div>
		<div data-ids="5" class="navItem">
			<span><?=lang("Users", "AAR"); ?></span>
		</div>
		<div data-ids="6" class="navItem">
			<span><?=lang("Settings", "AAR"); ?></span>
		</div>
		<div data-ids="7" class="navItem">
			<span><?=lang("Reports", "AAR"); ?></span>
		</div>
		<div data-ids="8" class="navItem">
			<span><?=lang("MRVs", "AAR"); ?></span>
		</div>
		<div data-ids="9" class="navItem">
			<span><?=lang("Billing", "AAR"); ?></span>
		</div>
		<div data-ids="10" class="navItem">
			<span><?=lang("PL", "AAR"); ?></span>
		</div>
		<div data-ids="11" class="navItem">
			<span><?=lang("Progress_Monitor", "AAR"); ?></span>
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
	<?php if( $subPageID == 2 || $subPageID == 3 || $subPageID == 4 ){ ?>
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
	
	<a class="<?php if( $subPageID == 2 ){ echo "activeSub"; } ?>" href="requisitions_my.php">
		<i class="fas fa-address-book"></i>
		<span class="badge" id = "badge2" style = "display:none;"></span>
		<span><?=lang("My_Requisitions", "AAR"); ?></span>
	</a>
	<a class="<?php if( $subPageID == 3 ){ echo "activeSub"; } ?>" href="requisitions_draft.php">
		<i class="fas fa-list-ul"></i>
		<span class="badge" id = "badge3" style = "display:none;"></span>
		<span><?=lang("Draft_Requisitions", "AAR"); ?></span>
	</a>
	<a class="<?php if( $subPageID == 4 ){ echo "activeSub"; } ?>" href="requisitions_rfq.php">
		<i class="fas fa-check-double"></i>
		<span class="badge" id = "badge4" style = "display:none;"></span>
		<span><?=lang("Approved_Requisitions", "AAR"); ?></span>
	</a>
	<a class="<?php if( $subPageID == 5 ){ echo "activeSub"; } ?>" href="requisitions_waiting_supplier.php">
		<i class="far fa-clock"></i>
		<span class="badge" id = "badge5" style = "display:none;"></span>
		<span><?=lang("waiting_quotations", "AAR"); ?></span>
	</a>
	<a class="<?php if( $subPageID == 6 ){ echo "activeSub"; } ?>" href="all_requsitions.php">
		<i class="fas fa-list-ol"></i>
		<span class="badge" id = "badge6" style = "display:none;"></span>
		<span><?=lang("ALL_Requisitions", "AAR"); ?></span>
	</a>
	<a class="<?php if( $subPageID == 61 ){ echo "activeSub"; } ?>" href="requisitions_deleted.php">
		<i class="fas fa-ban"></i>
		<span class="badge" id = "badge61" style = "display:none;"></span>
		<span><?=lang("Deleted_Requisitions", "AAR"); ?></span>
	</a>
	<a class="<?php if( $subPageID == 161 ){ echo "activeSub"; } ?>" href="requisitions_archive.php">
		<i class="fas fa-tasks"></i>
		<span class="badge" id = "badge161" style = "display:none;"></span>
		<span><?=lang("Archive_Requisitions", "AAR"); ?></span>
	</a>
</div>

<div id="menuContent-2" style="display:none !important;">
	
	<?php
		if( $EMPLOYEE_ID == 229 || $EMPLOYEE_ID == 281 || $EMPLOYEE_ID == 225 || $EMPLOYEE_ID == 223 ){
		?>
		<a class="<?php if( $subPageID == 7 ){ echo "activeSub"; } ?>" href="inv_codification.php">
			<i class="fas fa-database"></i>
			<span><?=lang("Inventory_Coding", "AAR"); ?></span>
		</a>
		<?php
		}
	?>
</div>

<div id="menuContent-3" style="display:none !important;">
	<?php
		if( $EMPLOYEE_ID == 229 || $EMPLOYEE_ID == 282 ){
		?>
		<?php if( $subPageID == 8 ){ ?>
			<a class="activeNew" onclick="show_modal( 'add_new_modal', 'New Job Order' );">
				<i class="fas fa-folder-plus"></i>
				<span><?=lang("Add_New", "AAR"); ?></span>
			</a>
			<?php } else { ?>
			<a href="job_orders.php?add_new=1">
				<i class="fas fa-folder-plus"></i>
				<span><?=lang("Add_New", "AAR"); ?></span>
			</a>
		<?php } ?>
		
		<a class="<?php if( $subPageID == 8 ){ echo "activeSub"; } ?>" href="job_orders.php">
			<i class="fas fa-folder-open"></i>
			<span><?=lang("job_orders", "AAR"); ?></span>
		</a>
		<?php
		}
	?>
</div>

<div id="menuContent-4" style="display:none !important;">
	<?php
		if( $EMPLOYEE_ID == 229 || $EMPLOYEE_ID == 222 || $EMPLOYEE_ID == 140 || $EMPLOYEE_ID == 274 ){
		?>
		<a class="<?php if( $subPageID == 9 ){ echo "activeSub"; } ?>" href="purchase_orders.php">
			<i class="fas fa-tasks"></i>
			<span class="badge" id = "badge9" style = "display:none;"></span>
			<span><?=lang("Waiting_My_approval", "AAR"); ?></span>
		</a>
		<a class="<?php if( $subPageID == 10 ){ echo "activeSub"; } ?>" href="purchase_orders_all.php">
			<i class="fas fa-list"></i>
			<span class="badge" id = "badge10" style = "display:none;"></span>
			<span><?=lang("ALL", "AAR"); ?></span>
		</a>
		<?php
		}
	?>
</div>

<div id="menuContent-5" style="display:none !important;">
	
	<?php
		if( $EMPLOYEE_ID == 229 ){
		?>
		
		<?php if( $subPageID == 11 ){ ?>
			<a class="activeNew" onclick="add_new_modal_user();">
				<i class="fas fa-user-plus"></i>
				<span><?=lang("Add_New", "AAR"); ?></span>
			</a>
			<?php } else { ?>
			<a href="users.php?add_new=1">
				<i class="fas fa-folder-plus"></i>
				<span><?=lang("Add_New", "AAR"); ?></span>
			</a>
		<?php } ?>
		
		<a class="<?php if( $subPageID == 11 ){ echo "activeSub"; } ?>" href="users.php">
			<i class="fas fa-users-cog"></i>
			<span><?=lang("Active_Users", "AAR"); ?></span>
		</a>
		<?php
		}
	?>
</div>

<div id="menuContent-6" style="display:none !important;">
	<?php
		if( $EMPLOYEE_ID == 229 || $EMPLOYEE_ID == 282 ){
		?>
		<a class="<?php if( $subPageID == 12 ){ echo "activeSub"; } ?>" href="uom.php">
			<i class="fas fa-ruler"></i>
			<span><?=lang("UOM", "AAR"); ?></span>
		</a>
		
		<a class="<?php if( $subPageID == 13 ){ echo "activeSub"; } ?>" href="billing_terms.php">
			<i class="fas fa-hand-holding-usd"></i>
			<span><?=lang("Billing Terms", "AAR"); ?></span>
		</a>
		
		<a class="<?php if( $subPageID == 131 ){ echo "activeSub"; } ?>" href="company_norms.php">
			<i class="fas fa-tachometer-alt"></i>
			<span><?=lang("Company_Norms", "AAR"); ?></span>
		</a>
		<?php
		}
	?>
</div>

<div id="menuContent-7" style="display:none !important;">
	<a class="<?php if( $subPageID == 14 ){ echo "activeSub"; } ?>" href="material_tracking.php">
		<i class="fas fa-truck-moving"></i>
		<span><?=lang("project_material_tracking", "AAR"); ?></span>
	</a>
	
	<a class="<?php if( $subPageID == 15 ){ echo "activeSub"; } ?>" href="material_costing.php">
		<i class="fas fa-dollar-sign"></i>
		<span><?=lang("project_material_Costing", "AAR"); ?></span>
	</a>
	
	<a class="<?php if( $subPageID == 16 ){ echo "activeSub"; } ?>" href="manpower_deployment.php">
		<i class="fas fa-people-arrows"></i>
		<span><?=lang("Manpower_Deployment", "AAR"); ?></span>
	</a>
	<a class="<?php if( $subPageID == 164 ){ echo "activeSub"; } ?>" href="machinery_deployment.php">
		<i class="fas fa-tram"></i>
		<span><?=lang("Machinery_Deployment", "AAR"); ?></span>
	</a>
	<a class="<?php if( $subPageID == 162 ){ echo "activeSub"; } ?>" href="subcontractor_manhour.php">
		<i class="far fa-clock"></i>
		<span><?=lang("Manpower_SubContractor", "AAR"); ?></span>
	</a>
	<a class="<?php if( $subPageID == 163 ){ echo "activeSub"; } ?>" href="manpower_deployment_employeewise.php">
		<i class="fas fa-user-clock"></i>
		<span><?=lang("Manpower_Employeewise", "AAR"); ?></span>
	</a>
	
	<a class="<?php if( $subPageID == 161 ){ echo "activeSub"; } ?>" href="charts_test.php">
		<i class="fas fa-people-arrows"></i>
		<span><?=lang("Charts test", "AAR"); ?></span>
	</a>
</div>

<div id="menuContent-8" style="display:none !important;">
	<a class="<?php if( $subPageID == 17 ){ echo "activeSub"; } ?>" href="mrv_list.php">
		<i class="fas fa-th-list"></i>
		<span><?=lang("MRVs_List", "AAR"); ?></span>
	</a>
</div>

<div id="menuContent-9" style="display:none !important;">
	
	<a class="<?php if( $subPageID == 18 ){ echo "activeSub"; } ?>" href="acc_biling_new_01.php">
		<i class="fas fa-file-invoice-dollar"></i>
		<span><?=lang("Add_New", "AAR"); ?></span>
	</a>
	
	<a class="<?php if( $subPageID == 19 ){ echo "activeSub"; } ?>" href="acc_biling.php">
		<i class="fas fa-file-invoice-dollar"></i>
		<span><?=lang("Biling", "AAR"); ?></span>
	</a>
	
	<a class="<?php if( $subPageID == 20 ){ echo "activeSub"; } ?>" href="acc_biling_tree.php">
		<i class="fas fa-tree"></i>
		<span><?=lang("Tree", "AAR"); ?></span>
	</a>
	
</div>

<div id="menuContent-10" style="display:none !important;">
	<?php
		if( $EMPLOYEE_ID == 229 ){
		?>
		<a class="<?php if( $subPageID == 21 ){ echo "activeSub"; } ?>" href="punch_list.php">
			<i class="fas fa-list-ol"></i>
			<span><?=lang("Open", "AAR"); ?></span>
		</a>
		<a class="<?php if( $subPageID == 22 ){ echo "activeSub"; } ?>" href="punch_check.php">
			<i class="far fa-eye"></i>
			<span><?=lang("Need_Checking", "AAR"); ?></span>
		</a>
		<a class="<?php if( $subPageID == 23 ){ echo "activeSub"; } ?>" href="punch_close.php">
			<i class="far fa-check-square"></i>
			<span><?=lang("Closed", "AAR"); ?></span>
		</a>
		<?php
		}
	?>
</div>

<div id="menuContent-11" style="display:none !important;">
	<a class="<?php if( $subPageID == 100 ){ echo "activeSub"; } ?>" href="pm_projects_list.php">
		<i class="fas fa-list-ol"></i>
		<span><?=lang("Active_Projects", "AAR"); ?></span>
	</a>
</div>

<script>
	notificationMenu();
	
	function notificationMenu(){
		$.ajax({
			url      :"<?=api_root; ?>notification/header_notification.php",
			data	 : {'cond':'AND receiver_id = <?=$EMPLOYEE_ID?>'},
			dataType :"json",
			type     :'POST',
			success  :function( response ){
				totalCount = 0;
				$('#badge7').hide();
				$('#badge11').hide();
				$('#badge10').hide();
				$('#badge9').hide();
				
				for(i=0;i<response.length;i++){
					if(response[i].po_status == 'pending_approval'){
						$('#badge9').show();
						$('#badge9').html(response[i].count);
						totalCount += response[i].count;
					}
					if(totalCount > 0){
						$('#badge10').show();
						$('#badge10').html(totalCount);
						
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
				$('#badge2').hide();
				$('#badge3').hide();
				$('#badge4').hide();
				$('#badge5').hide();
				$('#badge6').hide();
				$('#badge61').hide();
				$('#badge161').hide();
				
				for(i=0;i<response.length;i++){
					if(response[i].requisition_status == 'finish_req'){
						$('#badge9').show();
						$('#badge9').html(response[i].count);
						totalCount += response[i].count;
					}
					if(response[i].requisition_status == 'draft_req'){
						$('#badge3').show();
						$('#badge3').html(response[i].count);
						totalCount += response[i].count;
					}
					if(response[i].requisition_status == 'delete_req'){
						$('#badge61').show();
						$('#badge61').html(response[i].count);
						//totalCount -= response[i].count;
					}
					if(response[i].requisition_status == 'archive_req'){
						$('#badge161').show();
						$('#badge161').html(response[i].count);
						totalCount += response[i].count;
					}
					if(response[i].requisition_status == 'approve_req'){
						$('#badge4').show();
						$('#badge4').html(response[i].count);
						totalCount += response[i].count;
					}
					if(response[i].requisition_status == 'waiting_supplier'){
						$('#badge5').show();
						$('#badge5').html(response[i].count);
						totalCount += response[i].count;
					}
					if(totalCount > 0){
						$('#badge2').show();
						$('#badge2').html(totalCount);
						$('#badge6').show();
						$('#badge6').html(totalCount);
						
					}
				}
			}
		});
		
	}	
	
	initMnu();
</script>
<article id="article">	
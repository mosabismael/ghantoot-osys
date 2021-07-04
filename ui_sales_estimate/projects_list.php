<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 3;
	$subPageID = 31;
?>
<!DOCTYPE html>
<html dir="<?=$lang_dir; ?>" lang="<?=$lang; ?>">
<head>
	<?php include('app/meta.php'); ?>
    <?php include('app/assets.php'); ?>
</head>
<body>
<?php
	$WHERE = "requisitions";
	include('app/header.php');
	//PAGE DATA START -----------------------------------------------///---------------------------------
?>



<div class="row">
	<div class="col-100">
	

<table id="dataTable" class="tabler" border="2">
	<thead>
		<tr>
			<th><?=lang("Sys_Id", "AAR"); ?></th>
			<th><?=lang("Created_Date", "AAR"); ?></th>
			<th><?=lang("Client_Name", "AAR"); ?></th>
			<th><?=lang("Status", "AAR"); ?></th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
<?php
	$qu_z_project_sel = "SELECT * FROM  `z_project`";
	$qu_z_project_EXE = mysqli_query($KONN, $qu_z_project_sel);
	if(mysqli_num_rows($qu_z_project_EXE)){
		while($z_project_REC = mysqli_fetch_assoc($qu_z_project_EXE)){
			$project_id = $z_project_REC['project_id'];
			$project_name = $z_project_REC['project_name'];
			$client_id = $z_project_REC['client_id'];
			$created_date = $z_project_REC['created_date'];
			$quotation_id = $z_project_REC['quotation_id'];
			$project_status = $z_project_REC['project_status'];
			
			
	$qu_gen_clients_sel = "SELECT * FROM  `gen_clients` WHERE `client_id` = $client_id";
	$qu_gen_clients_EXE = mysqli_query($KONN, $qu_gen_clients_sel);
	$client_name = "NA";
	if(mysqli_num_rows($qu_gen_clients_EXE)){
		$gen_clients_DATA = mysqli_fetch_assoc($qu_gen_clients_EXE);
		$client_id = $gen_clients_DATA['client_id'];
		$client_name = $gen_clients_DATA['client_name'];
	}
	$project_status_td = '<div class="w3-light-grey"><div class="w3-green" style="height:24px;width:100%"></div></div>Completed';
	
	if($project_status == 'draft'){
		$project_status_td = '<div class="w3-light-grey"><div class="w3-red" style="height:24px;width:50%"></div></div>In Progress';
	}
		?>
					<form action='quotations_new.php'> 

		<tr id="quote-<?=$project_id; ?>">
			<td><?=$project_id; ?></td>
			<td><?=$created_date; ?></td>
			<td><?=$client_name; ?></td>
			<td><?=$project_status_td?></td>
			<td class="text-center">
				<a href="projects_details.php?project_id=<?=$project_id; ?>" title="<?=lang("Project_Details", "AAR"); ?>"><button class="btn" type="button">Details</button></a>
				<a href="projects_estimation.php?project_id=<?=$project_id; ?>" title="<?=lang("Estimation", "AAR"); ?>"><button class="btn" type="button">Estimation</button></a>
				<?php
				if($quotation_id == 0){
					
				?>
				<a href="quotations_details.php?quotation_id=1" title="<?=lang("Quotation", "AAR"); ?>"><button type="button" class="btn"><i class="fa fa-bars"></i> Quotation</button></a>
					<?php
				}
					?>
						<?php
				if($quotation_id != 0){

				?>
			
				<input type='hidden' name='project_id' value='<?= $project_id ?>'>
				<button type="submit" class="btn"><i class="fa fa-folder"></i> Quotation</button>
					<?php
				}
					?>
			</td>
		</tr>
		</form>

		<?php
		}
	} else {
		?>
		<tr id="quote-0">
			<td colspan="8"><?=lang("No Data Found", "AAR"); ?></td>
		</tr>
		<?php
	}
?>
	</tbody>
</table>
		
	</div>
	<div class="zero"></div>
</div>


<?php
	//PAGE DATA END   ----------------------------------------------///---------------------------------
	include('app/footer.php');
?>
</body>
</html>
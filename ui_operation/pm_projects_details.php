<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 11;
	$subPageID = 100;
	
	
	$job_order_id = 0;
	if( !isset( $_GET['job_order_id'] ) ){
		header("location:pm_projects_list.php");
	} else {
		$job_order_id = (int) test_inputs( $_GET['job_order_id'] );
	}
	
	$qu_job_orders_sel = "SELECT * FROM  `job_orders` WHERE `job_order_id` = $job_order_id";
	$qu_job_orders_EXE = mysqli_query($KONN, $qu_job_orders_sel);
	$job_orders_DATA;
	if(mysqli_num_rows($qu_job_orders_EXE)){
		$job_orders_DATA = mysqli_fetch_assoc($qu_job_orders_EXE);
	}
		$job_order_ref = $job_orders_DATA['job_order_ref'];
		$project_name = $job_orders_DATA['project_name'];
		$client_id = $job_orders_DATA['client_id'];
		$project_amount = $job_orders_DATA['project_amount'];
		$contract_attach = $job_orders_DATA['contract_attach'];
		$job_order_type = $job_orders_DATA['job_order_type'];
		$project_manager_id = $job_orders_DATA['project_manager_id'];
		$job_order_status = $job_orders_DATA['job_order_status'];
		$created_date = $job_orders_DATA['created_date'];
		$created_by = $job_orders_DATA['created_by'];


	
	
	$qu_gen_clients_sel = "SELECT * FROM  `gen_clients` WHERE `client_id` = $client_id";
	$qu_gen_clients_EXE = mysqli_query($KONN, $qu_gen_clients_sel);
	$client_name = "NA";
	if(mysqli_num_rows($qu_gen_clients_EXE)){
		$gen_clients_DATA = mysqli_fetch_assoc($qu_gen_clients_EXE);
		$client_id = $gen_clients_DATA['client_id'];
		$client_name = $gen_clients_DATA['client_name'];
	}

			
			
			
	$qu_hr_employees_sel = "SELECT * FROM  `hr_employees` WHERE `employee_id` = $created_by";
	$qu_hr_employees_EXE = mysqli_query($KONN, $qu_hr_employees_sel);
	$hr_employees_DATA;
	if(mysqli_num_rows($qu_hr_employees_EXE)){
		$hr_employees_DATA = mysqli_fetch_assoc($qu_hr_employees_EXE);
	}
		$employee_namer = $hr_employees_DATA['employee_code'].'-'.$hr_employees_DATA['first_name'].' '.$hr_employees_DATA['last_name'];
			
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
		<div class="page-details text-left">
			<br>
			<h1><?=$job_order_ref; ?> - <?=$project_name; ?></h1>
			<br>
		</div>
		
		<div class="tabber">
			<ul class="tabber-header">
				<li id="sel-1" onclick="set_tabber(1);" class="active"><?=lang("Timeline", "AAR"); ?></li>
				<li id="sel-2" onclick="set_tabber(2);" class=""><?=lang("Parameters", "AAR"); ?></li>
				<li id="sel-3" onclick="set_tabber(3);" class=""><?=lang("Weekly_Target", "AAR"); ?></li>
				<li id="sel-4" onclick="set_tabber(4);" class=""><?=lang("Graphs", "AAR"); ?></li>
				<li id="sel-200" onclick="set_tabber(200);fetch_item_status(<?=$job_order_id; ?>, 'job_orders');"><?=lang("Status_Change", "AAR"); ?></li>
			</ul>
			

			
			<div class="tabber-body">





<div class="tabber-1 tabber-content tabber-active">
<?php
	include('projects_details/timeline.php');
?>
</div>
<div class="tabber-2 tabber-content">
<?php
	include('projects_details/parameters.php');
?>
</div>
<div class="tabber-3 tabber-content">
<?php
	include('projects_details/weekly_target.php');
?>
</div>
<div class="tabber-4 tabber-content">
<?php
	include('projects_details/graphs.php');
?>
</div>







<div class="tabber-200 tabber-content" id="fetched_status_change"></div>



			</div>
		</div>
		
	</div>
	
	
	<div class="zero"></div>
</div>


<?php
	//PAGE DATA END   ----------------------------------------------///---------------------------------
	include('app/footer.php');
?>
<script>
	function set_tabber(tID){
		$('.tabber-header .active').removeClass('active');
		$('.tabber-body .tabber-active').removeClass('tabber-active');
		
		$('.tabber-header #sel-' + tID).addClass('active');
		$('.tabber-body .tabber-' + tID).addClass('tabber-active');
	}
</script>
</body>
</html>
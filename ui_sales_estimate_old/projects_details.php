<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 3;
	$subPageID = 31;
	
	
	$project_id = 0;
	if( !isset( $_GET['project_id'] ) ){
		header("location:sales_projects.php");
	} else {
		$project_id = (int) test_inputs( $_GET['project_id'] );
	}
	
	$qu_sales_projects_sel = "SELECT * FROM  `sales_projects` WHERE `project_id` = $project_id";
	$qu_sales_projects_EXE = mysqli_query($KONN, $qu_sales_projects_sel);
	$sales_projects_DATA;
	if(mysqli_num_rows($qu_sales_projects_EXE)){
		$sales_projects_DATA = mysqli_fetch_assoc($qu_sales_projects_EXE);
	}
		$project_name = $sales_projects_DATA['project_name'];
		$created_date = $sales_projects_DATA['created_date'];
		$created_date = $sales_projects_DATA['created_date'];
		$project_notes = $sales_projects_DATA['project_notes'];
		$client_id = $sales_projects_DATA['client_id'];
		$employee_id = $sales_projects_DATA['employee_id'];
		$project_status = $sales_projects_DATA['project_status'];

	

	
	
	$qu_gen_clients_sel = "SELECT * FROM  `gen_clients` WHERE `client_id` = $client_id";
	$qu_gen_clients_EXE = mysqli_query($KONN, $qu_gen_clients_sel);
	$client_name = "NA";
	if(mysqli_num_rows($qu_gen_clients_EXE)){
		$gen_clients_DATA = mysqli_fetch_assoc($qu_gen_clients_EXE);
		$client_id = $gen_clients_DATA['client_id'];
		$client_name = $gen_clients_DATA['client_name'];
	}

			
			
			
	$qu_hr_employees_sel = "SELECT * FROM  `hr_employees` WHERE `employee_id` = $employee_id";
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
			<h1><?=strtoupper( $client_name.'-' ); ?>  ( <?=strtoupper( $project_name ); ?> )</h1>
			<h3>By :<?=strtoupper( $employee_namer ); ?></h3>
			<br>
		</div>
		
		<div class="tabber">
			<ul class="tabber-header">
				<li id="sel-1" onclick="set_tabber(1);" class="active"><?=lang("Client_Details", "AAR"); ?></li>
				<li id="sel-200" onclick="set_tabber(200);fetch_item_status(<?=$project_id; ?>, 'sales_projects');"><?=lang("Status_Change", "AAR"); ?></li>
			</ul>
			

			
			<div class="tabber-body">





<div class="tabber-1 tabber-content tabber-active">
<?php
	include('clients/get_details.php');
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
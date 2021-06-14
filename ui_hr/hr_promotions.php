<?php
header("location:index.php");
die();

	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	$page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	// $page_title=$page_description=$page_keywords=$page_author= "Site Title";
	
	
	
	$menuId = 8;
	$subPageID = 11;
	
	//service operations
	$MainServiceID = 1;
	$subServiceID  = 0;
	//load service data
	//check if service is allowed for this user or no
	//require_once('../bootstrap/load_service_user.php');
?>
<!DOCTYPE html>
<html dir="<?=$lang_dir; ?>" lang="<?=$lang; ?>">
<html>
<head>
	<?php include('app/meta.php'); ?>
    <?php include('app/assets.php'); ?>
</head>
<body>
<?php
	include('app/header.php');
	//PAGE DATA START -----------------------------------------------///---------------------------------
?>





<div class="row">
	<div class="col-100">
		<div class="panel text-left">
			<div class="panel-header has_opts">
				<h1><i class="fas fa-list-ol"></i><?=lang("Employees_allowances_List", "AAR"); ?></h1>
				<div class="panel-opts">
					<a onclick="add_new_modal();"><button type="button" class="btn btn-success"><?=lang("Add_New", "AAR"); ?></button></a>
				</div>
				<div class="zero"></div>
			</div>
			<div class="panel-body">
			
<table class="tabler">
	<thead>
		<tr>
			<th><?=lang("Sys_Id", "AAR"); ?></th>
			<th><?=lang("employee_code", "AAR"); ?></th>
			<th><?=lang("Name", "AAR"); ?></th>
			<th><?=lang("Join_date", "AAR"); ?></th>
			<th><?=lang("allowance", "AAR"); ?></th>
			<th><?=lang("Type", "AAR"); ?></th>
			<th><?=lang("amount", "AAR"); ?></th>
			<th><?=lang("date", "AAR"); ?></th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
<?php
/*
	$qu_hr_employees_allowances_sel = "SELECT * FROM  `hr_employees_allowances` ORDER BY `record_id` ASC";
	$qu_hr_employees_allowances_EXE = mysqli_query($KONN, $qu_hr_employees_allowances_sel);
	if(mysqli_num_rows($qu_hr_employees_allowances_EXE)){
		while($HRemp_allowances_REC = mysqli_fetch_assoc($qu_hr_employees_allowances_EXE)){
			$employee_id = $HRemp_allowances_REC['employee_id'];
			
			
			
	$qu_hr_employees_sel = "SELECT * FROM  `hr_employees` WHERE `employee_id` = $employee_id";
	$qu_hr_employees_EXE = mysqli_query($KONN, $qu_hr_employees_sel);
	$hr_employees_REC;
	if(mysqli_num_rows($qu_hr_employees_EXE)){
		$hr_employees_REC = mysqli_fetch_assoc($qu_hr_employees_EXE);
		$employee_id = $hr_employees_REC['employee_id'];
		$employee_code = $hr_employees_REC['employee_code'];
		$first_name = $hr_employees_REC['first_name'];
		$last_name = $hr_employees_REC['last_name'];
		$join_date = $hr_employees_REC['join_date'];
		$designation_id = $hr_employees_REC['designation_id'];
		$department_id = $hr_employees_REC['department_id'];
	}

			
			
			
			
			$department_id = $hr_employees_REC["department_id"];
			$designation_id = $hr_employees_REC["designation_id"];
			$department_name = "";
			$designation_name = "";
			$qu_gen_departments_sel = "SELECT * FROM  `gen_departments` WHERE `department_id` = $department_id";
			$qu_gen_departments_EXE = mysqli_query($KONN, $qu_gen_departments_sel);
			$gen_departments_DATA;
			if(mysqli_num_rows($qu_gen_departments_EXE)){
				$gen_departments_DATA = mysqli_fetch_assoc($qu_gen_departments_EXE);
				$department_name = $gen_departments_DATA['department_name'];
			}
			$qu_gen_departments_designations_sel = "SELECT * FROM  `gen_departments_designations` WHERE `designation_id` = $designation_id";
			$qu_gen_departments_designations_EXE = mysqli_query($KONN, $qu_gen_departments_designations_sel);
			$gen_departments_designations_DATA;
			if(mysqli_num_rows($qu_gen_departments_designations_EXE)){
				$gen_departments_designations_DATA = mysqli_fetch_assoc($qu_gen_departments_designations_EXE);
				$designation_name = $gen_departments_designations_DATA['designation_name'];
			}


		?>
		<tr id="emp-<?=$hr_employees_REC["employee_id"]; ?>">
			<td><?=$hr_employees_REC["employee_id"]; ?></td>
			<td><?=$hr_employees_REC["employee_code"]; ?></td>
			<td class="cell-title"><?=$hr_employees_REC["first_name"]." ".$hr_employees_REC["last_name"]; ?></td>
			<td><?=$hr_employees_REC["join_date"]; ?></td>
			<td><?=$country_name; ?></td>
			<td><?=$department_name; ?> - <?=$designation_name; ?></td>
			<td class="text-center">
				<a onclick="view_employee_profile(<?=$hr_employees_REC["employee_id"]; ?>);" title="<?=lang("profile", "AAR"); ?>"><i class="far fa-id-card"></i></a>
				<a onclick="view_employee_creds(<?=$hr_employees_REC["employee_id"]; ?>);" title="<?=lang("credintials", "AAR"); ?>"><i class="far fa-credit-card"></i></a>
			</td>
		</tr>
		<?php
		
		}
	}
	*/
?>
	</tbody>
</table>
			
			</div>
		</div>
	</div>
	
	
	<div class="zero"></div>
</div>





























<!--    ///////////////////      add_new_modal Modal START    ///////////////////            -->
<div class="modal" id="add_new_modal">
	<div class="modal-closer" onclick="hide_modal();"><i class="far fa-times-circle"></i></div>
	<div class="modal-container">
		<div class="modal-header">
			<h1></h1>
		</div>
		<div class="modal-body">
			
<form method="post" class="form_class">

ssssssssssssssssssss
	
	<div class="zero"></div>
	

</form>
			
			
		</div>
	</div>
	<div class="zero"></div>
</div>


<!--    ///////////////////      add_new_employee Modal END    ///////////////////            -->


<script>


function add_new_modal(){
	var titler = '<?=lang("Add_New_Employee SSS", "AAR"); ?>';
	show_modal( 'add_new_modal' , titler );
}


</script>





<?php
	//PAGE DATA END   ----------------------------------------------///---------------------------------
	include('app/footer.php');
?>
<script>

</script>
</body>
</html>
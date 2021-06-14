<?php
	require_once('../../bootstrap/app_config.php');
	require_once('../../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "Site Title";
	
	
$site_logo = "";

	$menuId = 8;
	$subPageID = 11;
	
	//service operations
	$MainServiceID = 1;
	$subServiceID  = 0;
	//load service data
	//check if service is allowed for this user or no
	// require_once('../bootstrap/load_service_user.php');
	
	
	$print_id = 0;
	if( !isset( $_GET['idd'] ) ){
		header("location:index.php");
	} else {
		$print_id = (int) test_inputs( $_GET['idd'] );
	}
	
	
	
	$qu_hr_employees_disp_actions_sel = "SELECT * FROM  `hr_employees_disp_actions` WHERE `record_id` = $print_id";
	$qu_hr_employees_disp_actions_EXE = mysqli_query($KONN, $qu_hr_employees_disp_actions_sel);
	$hr_employees_disp_actions_DATA;
	if(mysqli_num_rows($qu_hr_employees_disp_actions_EXE)){
		$hr_employees_disp_actions_DATA = mysqli_fetch_assoc($qu_hr_employees_disp_actions_EXE);
	}
	
		$created_date = $hr_employees_disp_actions_DATA['created_date'];
		$disp_action_id = $hr_employees_disp_actions_DATA['disp_action_id'];
		$warning = $hr_employees_disp_actions_DATA['warning'];
		$deductions = $hr_employees_disp_actions_DATA['deductions'];
		$memo = $hr_employees_disp_actions_DATA['memo'];
		$employee_id = $hr_employees_disp_actions_DATA['employee_id'];

		
		
	$qu_hr_disp_actions_sel = "SELECT * FROM  `hr_disp_actions` WHERE `disp_action_id` = $disp_action_id";
	$qu_hr_disp_actions_EXE = mysqli_query($KONN, $qu_hr_disp_actions_sel);
	$hr_disp_actions_DATA;
	if(mysqli_num_rows($qu_hr_disp_actions_EXE)){
		$hr_disp_actions_DATA = mysqli_fetch_assoc($qu_hr_disp_actions_EXE);
	}
	
		$disp_action_code = $hr_disp_actions_DATA['disp_action_code'];
		$disp_action_text = $hr_disp_actions_DATA['disp_action_text'];

		
		
		
		
		
		$disp_act_status = get_current_state($KONN, $print_id, "hr_employees_disp_actions" );



//----------------------------------------------

	$qu_hr_employees_sel = "SELECT * FROM  `hr_employees` WHERE `employee_id` = $employee_id";
	$qu_hr_employees_EXE = mysqli_query($KONN, $qu_hr_employees_sel);
	$hr_employees_DATA;
	if(mysqli_num_rows($qu_hr_employees_EXE)){
		$hr_employees_DATA = mysqli_fetch_assoc($qu_hr_employees_EXE);
	}

		$employee_code = $hr_employees_DATA['employee_code'];
		$first_name = $hr_employees_DATA['first_name'];
		if($hr_employees_DATA['second_name']=='undefined')
			$second_name = "";
		else
			$second_name = $hr_employees_DATA['second_name'];
		if($hr_employees_DATA['third_name']=='undefined')
			$third_name = "";
		else
			$third_name = $hr_employees_DATA['third_name'];
		$last_name = $hr_employees_DATA['last_name'];
		
		$join_date = $hr_employees_DATA['join_date'];
		
		$designation_id = $hr_employees_DATA['designation_id'];
		$department_id = $hr_employees_DATA['department_id'];




	$qu_hr_departments_sel = "SELECT * FROM  `hr_departments` WHERE `department_id` = $department_id";
	$qu_hr_departments_EXE = mysqli_query($KONN, $qu_hr_departments_sel);
	$hr_departments_DATA;
	if(mysqli_num_rows($qu_hr_departments_EXE)){
		$hr_departments_DATA = mysqli_fetch_assoc($qu_hr_departments_EXE);
	}
	
		$department_name = $hr_departments_DATA['department_name'];


	$qu_hr_departments_designations_sel = "SELECT * FROM  `hr_departments_designations` WHERE `designation_id` = $designation_id";
	$qu_hr_departments_designations_EXE = mysqli_query($KONN, $qu_hr_departments_designations_sel);
	$hr_departments_designations_DATA;
	if(mysqli_num_rows($qu_hr_departments_designations_EXE)){
		$hr_departments_designations_DATA = mysqli_fetch_assoc($qu_hr_departments_designations_EXE);

	}

		$designation_name = $hr_departments_designations_DATA['designation_name'];



		$THS_REF = 'HRDA-'.$print_id;
?>
<!DOCTYPE html>
<html dir="<?=$lang_dir; ?>" lang="<?=$lang; ?>">
<html>
<head>
	<?php include('../app/meta.php'); ?>
    <?php include('../app/assets.php'); ?>
	
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?=$THS_REF; ?></title>
	
	
	
<!-- Jquery files -->
<script type="text/javascript" src="../<?=assets_root; ?>js/jquery-2.0.3.min.js"></script>
<script type="text/javascript" src="../<?=assets_root; ?>js/jquery-migrate-1.2.1.min.js"></script>

<script type="text/javascript" src="../<?=assets_root; ?>barcode/jquery-barcode.js"></script>


<style>
body {
	float:none !important;
	width:auto;
	margin:0 auto;
	background-color:#FFF;
	font-size:12pt;	
	}

@media print {
   .repeatable {display: table-header-group;}
}
</style>

</head>



<body id="contenter">


<table style="width:100%;margin: 0 auto;">
   <thead class="repeatable">
      <tr>
        <th colspan="2" style="width:66.66%;text-align: left;">
			<img src="print_header.png" style="width: 90%;vertical-align:top;" alt="System logo">
<div style="width: 50%;text-align: left;">
	<div style="text-align:left;font-size: 14px;font-weight: 600;width:100%;margin: 0 auto;margin: 0;" id="bcTarget">
		<script>$("#bcTarget").barcode("<?=$THS_REF; ?>", "code39", {barWidth:2}); </script>
		</div>
</div>
		</th>
        <th style="width:33.33%;text-align: right;">
			<h1 style="font-size: 18pt;padding: 0;margin:0;color: #33611e;">EMPLOYEE DISCIPLANARY ACTION</h1>
			<div style="display: block;">
				<span style="margin: 0 10px;font-size: 8pt;text-align: right;display: inline-block;">
				SUBMISSION DATE
				</span>
				<span style="width: 70px;display: inline-block;text-align: center;padding: 5px;border: 1px solid #000000;font-size: 8pt;">
				<?=$created_date?>
				</span>
			</div>
			<div style="display: block;">
				<span style="margin: 0 10px;font-size: 8pt;text-align: right;display: inline-block;">
				ACTION REF
				</span>
				<span style="width: 70px;display: inline-block;text-align: center;padding: 5px;border: 1px solid #000000;font-size: 8pt;">
				<?=$THS_REF?>
				</span>
			</div>
			
		</th>
      </tr>
   </thead>
  <tbody>
	   <tr><td colspan="3"><br></td>
      </tr>
      <tr>
        <th style="width:33.33%;text-align: left;background: #33611e;color: white;font-size: 10pt;padding-left: 10px;">
			EMPLOYEE DETAILS
		</th>
       
      </tr>
	  
      <tr>
        <th style="width:33.33%;text-align: left;padding-left: 16px;">
			<div style="font-size: 8pt;text-align: left;">
				<div><?=$first_name; ?> <?=$last_name?></div>
				<div>Employee Id: <?=$employee_id; ?></div>
				<div>Employee Code: <?=$employee_code; ?></div>
				<div>Department Name: <?=$department_name; ?></div>
				<div>Designation Name :<?=$designation_name; ?></div>
			</div>
		</th>
      </tr>
	</tbody>
</table>
<h3> DISCIPLANARY ACTION DETAILS</h3>
<table style = "width:100%;margin: 0 auto;border-collapse: separate;border-spacing: 0; border : 2px solid black;">
   
      <tr>
         <td style="width:33.33%;color: #33611e;font-size: 14pt;font-weight: bold;">Employee Name</td>
	<td style = "width:33.33%;font-size: 14pt;"><?=$first_name.' '.$second_name.' '.$third_name.' '.$last_name; ?></td>
</tr>
<tr>
         <td style="width:33.33%;color: #33611e;font-size: 14pt;font-weight: bold;">Join Date</td>
	<td style = "width:33.33%;font-size: 14pt;"><?=$join_date; ?></td>
</tr>
<tr>
         <td style="width:33.33%;color: #33611e;font-size: 14pt;font-weight: bold;">Department</td>
	<td style = "width:33.33%;font-size: 14pt;"><?=$department_name.' - '.$designation_name; ?></td>
</tr>
<tr>
         <td style="width:33.33%;color: #33611e;font-size: 14pt;font-weight: bold;">Employee Code</td>
	<td style = "width:33.33%;font-size: 14pt;"><?=$employee_code; ?></td>
</tr>
<tr>
         <td style="width:33.33%;color: #33611e;font-size: 14pt;font-weight: bold;">Employee ID</td>
	<td style = "width:33.33%;font-size: 14pt;"><?=$employee_id; ?></td>
</tr>
	<tr>
         <td style="width:33.33%;color: #33611e;font-size: 14pt;font-weight: bold;">Submission Date</td>
	<td style = "width:33.33%;font-size: 14pt;"><?=$created_date; ?></td>
</tr>
<?php
$warn_txt = '';
switch( $warning ){
	case 0:
		$warn_txt = "No Warning";
		break;
	case 1:
		$warn_txt = "First Warning";
		break;
	case 2:
		$warn_txt = "Second Warning";
		break;
	case 3:
		$warn_txt = "Third Warning";
		break;
	case 4:
		$warn_txt = "Final Warning";
		break;
		
}
?>
<tr>
         <td style="width:33.33%;color: #33611e;font-size: 14pt;font-weight: bold;">warning</td>
	<td style = "width:33.33%;font-size: 14pt;"><?=$warn_txt; ?></td>
</tr>
<?php
$ded_txt = '';
switch( $deductions ){
	case 0:
		$ded_txt = "No Deduction";
		break;
	case 1:
		$ded_txt = "1 - Day Deduction";
		break;
	case 2:
		$ded_txt = "2 - Day Deduction";
		break;
	case 3:
		$ded_txt = "3 - Day Deduction";
		break;
		
		
}
?>
<tr>
         <td style="width:33.33%;color: #33611e;font-size: 14pt;font-weight: bold;">deductions</td>
	<td style = "width:33.33%;font-size: 14pt;"><?=$ded_txt; ?></td>
</tr>
	<tr>
         <td style="width:33.33%;color: #33611e;font-size: 14pt;font-weight: bold;">Current Status</td>
	<td style = "width:33.33%;font-size: 14pt;"><?=$disp_act_status; ?></td>
</tr>
<tr>
         <td style="width:33.33%;color: #33611e;font-size: 14pt;font-weight: bold;">Memo</td>
	<td style = "width:33.33%;font-size: 14pt;"><?=$memo; ?></td>
</tr>

<tr>
         <td style="width:33.33%;color: #33611e;font-size: 14pt;font-weight: bold;">Action By Employee</td>
	<td style = "width:33.33%;font-size: 14pt;"><?=$disp_action_code.' - '.$disp_action_text; ?> </td>
      </tr>
	 </table>
<h3></h3>
<table style="width: 100%;margin:0 auto;">
	<thead style="text-align:center;">
		<tr>
			<th><?=lang("Date", "AAR"); ?></th>
			<th><?=lang("By", "AAR"); ?></th>
			<th><?=lang("Action","AAR"); ?></th>
		</tr>
	</thead>
	<tbody>
<?php
	$qu_gen_status_change_sel = "SELECT * FROM  `gen_status_change` WHERE `item_type` = 'hr_employees_disp_actions' AND `item_id` = $print_id ORDER BY `status_id` ASC";
	$qu_gen_status_change_EXE = mysqli_query($KONN, $qu_gen_status_change_sel);
	if(mysqli_num_rows($qu_gen_status_change_EXE)){
		while($gen_status_change_REC = mysqli_fetch_assoc($qu_gen_status_change_EXE)){
			$action_by = $gen_status_change_REC['action_by'];
			$emp_name = get_emp_name($KONN, $action_by );
		?>
		<tr>
			<td><?=$gen_status_change_REC['status_date']; ?></td>
			<td><?=$emp_name; ?></td>
			<td><?=$gen_status_change_REC['status_action']; ?></td>
		</tr>
		
		<?php
		}
	}
?>

	</tbody>
</table>
		




<script>

</script>
</body>
</html>
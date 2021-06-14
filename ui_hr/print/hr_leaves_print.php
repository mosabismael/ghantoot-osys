<?php
	require_once('../../bootstrap/app_config.php');
	require_once('../../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "Print";
	
	
// $site_logo =  $SETTINGS['site_logo'];

	
	$menuId = 8;
	$subPageID = 11;
	
	//service operations
	$MainServiceID = 1;
	$subServiceID  = 0;
	//load service data
	//check if service is allowed for this user or no
	// require_once('../bootstrap/load_service_user.php');
	
	
	$leave_id = 0;
	if( !isset( $_GET['idd'] ) ){
		header("location:index.php");
	} else {
		$leave_id = (int) test_inputs( $_GET['idd'] );
	}
	
		$qu_hr_employees_leaves_sel = "SELECT * FROM  `hr_employees_leaves` WHERE `leave_id` = $leave_id";
	$qu_hr_employees_leaves_EXE = mysqli_query($KONN, $qu_hr_employees_leaves_sel);
	$hr_employees_leaves_DATA;
	if(mysqli_num_rows($qu_hr_employees_leaves_EXE)){
		$hr_employees_leaves_DATA = mysqli_fetch_assoc($qu_hr_employees_leaves_EXE);
	}
	
	
		$leave_date = $hr_employees_leaves_DATA['leave_date'];
		$start_date = $hr_employees_leaves_DATA['start_date'];
		$end_date = $hr_employees_leaves_DATA['end_date'];
		$leave_type_id = $hr_employees_leaves_DATA['leave_type_id'];
		$total_days = $hr_employees_leaves_DATA['total_days'];
		$memo = $hr_employees_leaves_DATA['memo'];
		$is_deducted = $hr_employees_leaves_DATA['is_deducted'];
		$employee_id = $hr_employees_leaves_DATA['employee_id'];
		
		$leave_status = get_current_state($KONN, $leave_id, "hr_employees_leaves" );





	$qu_hr_employees_leave_types_sel = "SELECT * FROM  `hr_employees_leave_types` WHERE `leave_type_id` = $leave_type_id";
	$qu_hr_employees_leave_types_EXE = mysqli_query($KONN, $qu_hr_employees_leave_types_sel);
	$hr_employees_leave_types_DATA;
	if(mysqli_num_rows($qu_hr_employees_leave_types_EXE)){
		$hr_employees_leave_types_DATA = mysqli_fetch_assoc($qu_hr_employees_leave_types_EXE);
	}
		$leave_type_id = $hr_employees_leave_types_DATA['leave_type_id'];
		$leave_type_name = $hr_employees_leave_types_DATA['leave_type_name'];
		$leave_type_name_ar = $hr_employees_leave_types_DATA['leave_type_name_ar'];














	$qu_hr_employees_sel = "SELECT * FROM  `hr_employees` WHERE `employee_id` = $employee_id";
	$qu_hr_employees_EXE = mysqli_query($KONN, $qu_hr_employees_sel);
	$hr_employees_DATA;
	$second_name = "";
	$third_name= "";
	$last_name = "";
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



		$THS_REF = 'HRLV-'.$leave_id;
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
			<h1 style="font-size: 18pt;padding: 0;margin:0;color: #33611e;">Employee Leave</h1>
			<div style="display: block;">
				<span style="margin: 0 10px;font-size: 8pt;text-align: right;display: inline-block;">
				SUBMISSION DATE
				</span>
				<span style="width: 70px;display: inline-block;text-align: center;padding: 5px;border: 1px solid #000000;font-size: 8pt;">
				<?=$leave_date?>
				</span>
			</div>
			<div style="display: block;">
				<span style="margin: 0 10px;font-size: 8pt;text-align: right;display: inline-block;">
				LEAVE REF
				</span>
				<span style="width: 70px;display: inline-block;text-align: center;padding: 5px;border: 1px solid #000000;font-size: 8pt;">
				HRALW-<?=$leave_id;?>
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
		 
<tr><td style="width:33.33%;color: #33611e;font-size: 14pt;font-weight: bold;">Employee Code</td>
	<td style = "width:33.33%;font-size: 14pt;"><?=$employee_code; ?></td>
</tr>
<tr><td style="width:33.33%;color: #33611e;font-size: 14pt;font-weight: bold;">Employee ID</td>
	<td style = "width:33.33%;font-size: 14pt;"><?=$employee_id; ?></td>
</tr>
		
<tr><td style="width:33.33%;color: #33611e;font-size: 14pt;font-weight: bold;">Submission Date</td>
	<td style = "width:33.33%;font-size: 14pt;"><?=$leave_date; ?></td>
</tr>
<tr><td style="width:33.33%;color: #33611e;font-size: 14pt;font-weight: bold;">From</td>
	<td style = "width:33.33%;font-size: 14pt;"><?=$start_date; ?></td>
</tr>
<tr><td style="width:33.33%;color: #33611e;font-size: 14pt;font-weight: bold;">To</td>
	<td style = "width:33.33%;font-size: 14pt;"><?=$end_date; ?></td>
</tr>
	<hr style="opacity:0.05;">
<tr><td style="width:33.33%;color: #33611e;font-size: 14pt;font-weight: bold;">Current Status</td>
	<td style = "width:33.33%;font-size: 14pt;"><?=$leave_status; ?></td>
</div>
<tr><td style="width:33.33%;color: #33611e;font-size: 14pt;font-weight: bold;">Type</td>
	<td style = "width:33.33%;font-size: 14pt;"><?=$leave_type_name; ?></td>
</div>
<?php
$deducted = 'NO';
if( $is_deducted == 1 ){
	$deducted = 'YES';
}
?>
<tr><td style="width:33.33%;color: #33611e;font-size: 14pt;font-weight: bold;">Deducted</td>
	<td style = "width:33.33%;font-size: 14pt;"><?=$deducted; ?></td>
</tr>

		
<tr><td style="width:33.33%;color: #33611e;font-size: 14pt;font-weight: bold;">Memo</td>
	<td style = "width:33.33%;font-size: 14pt;"><?=$memo; ?></td>
</tr>
		 
<tr><td style="width:33.33%;color: #33611e;font-size: 14pt;font-weight: bold;">Status Change Updates</td>
</tr>

</table>




<script>

</script>
</body>
</html>
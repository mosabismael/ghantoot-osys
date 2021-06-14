<?php
	require_once('../../bootstrap/app_config.php');
	require_once('../../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "Site Title";
	
	
$site_logo =  "logo_print.jpg";

	$menuId = 8;
	$subPageID = 11;
	
	
	$print_id = 0;
	if( !isset( $_GET['idd'] ) ){
		header("location:index.php");
	} else {
		$print_id = (int) test_inputs( $_GET['idd'] );
	}
	
	
	$qu_hr_employees_allowances_sel = "SELECT * FROM  `hr_employees_allowances` WHERE `record_id` = $print_id";
	$qu_hr_employees_allowances_EXE = mysqli_query($KONN, $qu_hr_employees_allowances_sel);
	$hr_employees_allowances_DATA;
	if(mysqli_num_rows($qu_hr_employees_allowances_EXE)){
		$hr_employees_allowances_DATA = mysqli_fetch_assoc($qu_hr_employees_allowances_EXE);
	}
	
		$employee_id = $hr_employees_allowances_DATA['employee_id'];
		$allowance_id = $hr_employees_allowances_DATA['allowance_id'];
		$allowance_type = $hr_employees_allowances_DATA['allowance_type'];
		$allowance_amount = $hr_employees_allowances_DATA['allowance_amount'];
		$active_from = $hr_employees_allowances_DATA['active_from'];
		$active_to = $hr_employees_allowances_DATA['active_to'];



			$allowance_status = get_current_state($KONN, $print_id, "hr_employees_allowances" );






	$qu_hr_employees_sel = "SELECT * FROM  `hr_employees` WHERE `employee_id` = $employee_id";
	$qu_hr_employees_EXE = mysqli_query($KONN, $qu_hr_employees_sel);
	$hr_employees_DATA;
	if(mysqli_num_rows($qu_hr_employees_EXE)){
		$hr_employees_DATA = mysqli_fetch_assoc($qu_hr_employees_EXE);
	}

		$employee_code = $hr_employees_DATA['employee_code'];
		$first_name = $hr_employees_DATA['first_name'];
		$second_name = $hr_employees_DATA['second_name'];
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



	$qu_hr_employees_allowances_ids_sel = "SELECT * FROM  `hr_employees_allowances_ids` WHERE `allowance_id` = $allowance_id";
	$qu_hr_employees_allowances_ids_EXE = mysqli_query($KONN, $qu_hr_employees_allowances_ids_sel);
	$hr_employees_allowances_ids_DATA;
	if(mysqli_num_rows($qu_hr_employees_allowances_ids_EXE)){
		$hr_employees_allowances_ids_DATA = mysqli_fetch_assoc($qu_hr_employees_allowances_ids_EXE);
	}
	
		$allowance_title = $hr_employees_allowances_ids_DATA['allowance_title'];
		$allowance_description = $hr_employees_allowances_ids_DATA['allowance_description'];


?>
<!DOCTYPE html>
<html dir="<?=$lang_dir; ?>" lang="<?=$lang; ?>">
<html>
<head>
	<?php include('../app/meta.php'); ?>
    <?php include('../app/assets.php'); ?>
	
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>HRALW-<?=$print_id; ?></title>
	
	
	
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
   thead {display: table-header-group;}
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
		<script>$("#bcTarget").barcode("HRALW-<?=$print_id;?>", "code39", {barWidth:2}); </script>
		</div>
</div>
		</th>
        <th style="width:33.33%;text-align: right;">
			<h1 style="font-size: 18pt;padding: 0;margin:0;color: #33611e;">HR ALLOWANCE</h1>
			<div style="display: block;">
				<span style="margin: 0 10px;font-size: 8pt;text-align: right;display: inline-block;">
				ALLOWANCE DATE
				</span>
				<span style="width: 70px;display: inline-block;text-align: center;padding: 5px;border: 1px solid #000000;font-size: 8pt;">
				<?=$active_from?>
				</span>
			</div>
			<div style="display: block;">
				<span style="margin: 0 10px;font-size: 8pt;text-align: right;display: inline-block;">
				ALLOWANCE REF
				</span>
				<span style="width: 70px;display: inline-block;text-align: center;padding: 5px;border: 1px solid #000000;font-size: 8pt;">
				HRALW-<?=$print_id;?>
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
<h3> Allowance Details</h3>
<table style = "width:100%;margin: 0 auto;border-collapse: separate;border-spacing: 0; border : 2px solid black;">
	<tr>
<td style = "width:33.33%;color: #33611e;font-size: 16pt;font-weight: bold;">Allowance id  </td>
<td style = "width:33.33%;font-size: 16pt;"><?=$allowance_id?></td></tr>
<td style = "width:33.33%;color: #33611e;font-size: 16pt;font-weight: bold;">Allowance type  </td>
<td style = "width:33.33%;font-size: 16pt;"><?=$allowance_type?></td></tr>
<td style = "width:33.33%;color: #33611e;font-size: 16pt;font-weight: bold;">Allowance amount  </td>
<td style = "width:33.33%;font-size: 16pt;"><?=$allowance_amount?></td></tr>
<td style = "width:33.33%;color: #33611e;font-size: 16pt;font-weight: bold;">Active from  </td>
<td style = "width:33.33%;font-size: 16pt;"><?=$active_from?></td></tr>
<td style = "width:33.33%;color: #33611e;font-size: 16pt;font-weight: bold;">Active to  </td>
<td style = "width:33.33%;font-size: 16pt;"><?=$active_to?></td></tr>
<td style = "width:33.33%;color: #33611e;font-size: 16pt;font-weight: bold;">Allowance Status  </td>
<td style = "width:33.33%;font-size: 16pt;"><?=$allowance_status?></td></tr>
<td style = "width:33.33%;color: #33611e;font-size: 16pt;font-weight: bold;">Allowance title  </td>
<td style = "width:33.33%;font-size: 16pt;"><?=$allowance_title?></td></tr>
<td style = "width:33.33%;color: #33611e;font-size: 16pt;font-weight: bold;">Allowance description  </td>
<td style = "width:33.33%;font-size: 16pt;"><?=$allowance_description?></td>
</tr>
</table>


</body>
</html>
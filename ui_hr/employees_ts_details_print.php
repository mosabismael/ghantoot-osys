<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "TimeSheet";
	
	
$site_logo =  "logo_print.jpg";

	$menuId = 8;
	$subPageID = 11;
	
	//service operations
	$MainServiceID = 1;
	$subServiceID  = 0;
	//load service data
	//check if service is allowed for this user or no
	//require_once('../bootstrap/load_service_user.php');
	
	
	$employee_id = 0;
	if( !isset( $_GET['employee_id'] ) ){
		die("sss");
		header("location:index.php");
	} else {
		$employee_id = (int) test_inputs( $_GET['employee_id'] );
	}
	
	$ts_id = 0;
	if( !isset( $_GET['ts_id'] ) ){
		die("sss");
		header("location:index.php");
	} else {
		$ts_id = (int) test_inputs( $_GET['ts_id'] );
	}
	


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
		$department_id  = $hr_employees_DATA['department_id'];




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


	$qu_hr_employees_ts_sel = "SELECT * FROM  `hr_employees_ts` WHERE `ts_id` = $ts_id";
	$qu_hr_employees_ts_EXE = mysqli_query($KONN, $qu_hr_employees_ts_sel);
	$hr_employees_ts_DATA;
	if(mysqli_num_rows($qu_hr_employees_ts_EXE)){
		$hr_employees_ts_DATA = mysqli_fetch_assoc($qu_hr_employees_ts_EXE);
	}
		$ts_ref = $hr_employees_ts_DATA['ts_ref'];
		$ts_year = $hr_employees_ts_DATA['ts_year'];
		$ts_month = $hr_employees_ts_DATA['ts_month'];
		$created_date = $hr_employees_ts_DATA['created_date'];
		$created_by = $hr_employees_ts_DATA['created_by'];
		$ts_status = $hr_employees_ts_DATA['ts_status'];

?>
<!DOCTYPE html>
<html dir="<?=$lang_dir; ?>" lang="<?=$lang; ?>">
<html>
<head>
	<?php include('app/meta.php'); ?>
    <?php include('app/assets.php'); ?>
	
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?=$ts_ref; ?></title>
	
	
	
<!-- Jquery files -->
<script type="text/javascript" src="<?=assets_root; ?>js/jquery-2.0.3.min.js"></script>
<script type="text/javascript" src="<?=assets_root; ?>js/jquery-migrate-1.2.1.min.js"></script>

<script type="text/javascript" src="<?=assets_root; ?>barcode/jquery-barcode.js"></script>


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
   <thead>
      <tr>
         <th>
<div style="text-align:left;width:45%;display:inline-block;vertical-align:bottom;">
<img src="<?=uploads_root.$site_logo; ?>" alt="System logo">
</div>
<div style="text-align:right;width:45%;display:inline-block;vertical-align:bottom;">
	<h2>Employee Attendance Report</h2>
</div>
<hr>
		 </th>
      </tr>
   </thead>
   <tbody>
      <tr>
         <td>
		 <br>
<div style="text-align:center;width:30%;display:inline-block;vertical-align:bottom;">
	<h4 style="text-align:center;">Employee Name</h4>
	<span><?=$first_name.' '.$last_name; ?></span>
</div>
<div style="text-align:center;width:30%;display:inline-block;vertical-align:bottom;">
	<h4 style="text-align:center;">Join Date</h4>
	<span><?=$join_date; ?></span>
</div>
<div style="text-align:center;width:30%;display:inline-block;vertical-align:bottom;">
	<h4 style="text-align:center;">Department</h4>
	<span><?=$department_name.' - '.$designation_name; ?></span>
</div>
	<hr style="opacity:0.05;">
		 
		 
		 </td>
      </tr>
      <tr>
         <td>
		 <br>
<div style="text-align:center;width:30%;display:inline-block;vertical-align:bottom;">
	<h4 style="text-align:center;">Employee Code</h4>
	<span><?=$employee_code; ?></span>
</div>
<div style="text-align:center;width:30%;display:inline-block;vertical-align:bottom;">
	<h4 style="text-align:center;">Employee ID</h4>
	<span><?=$employee_id; ?></span>
</div>
<div style="text-align:center;width:30%;display:inline-block;vertical-align:bottom;">
	<h4 style="text-align:center;">Year - Month</h4>
	<span><?=$ts_year.' - '.$ts_month; ?></span>
</div>
	<hr style="opacity:0.05;">
		 
		 
		 </td>
      </tr>
	  
			<table class="tabler" style="width:100%;" border="1">
				<thead>
					<tr>
						<th style="font-size: 12px;"><?=lang('Day'); ?></th>
						<th style="font-size: 12px;width:40%;"><?=lang('Date'); ?></th>
						<th style="font-size: 12px;"><?=lang('Check_In'); ?></th>
						<th style="font-size: 12px;"><?=lang('Check_Out'); ?></th>
<?php
	if( $employee_id != 0 ){
?>
						<th style="font-size: 12px;"><?=lang('Delay - Minutes'); ?></th>
<?php
	}
?>
					</tr>
				</thead>
				<tbody>
				
<?php
$totDelay = 0;

if( $ts_id != 0 ){
	
	$empCond = "";
	if( $employee_id != 0 ){
		$empCond = " AND (`employee_id` = $employee_id)";
	}
	
	$qu_hr_employees_ts_days_sel = "SELECT * FROM  `hr_employees_ts_days` WHERE ( (`ts_id` = $ts_id) $empCond ) ORDER BY `day_date` ASC";
	
	$qu_hr_employees_ts_days_EXE = mysqli_query($KONN, $qu_hr_employees_ts_days_sel);
	if(mysqli_num_rows($qu_hr_employees_ts_days_EXE)){
		$CC = 0;
		$totDelay = 0;
		while($hr_employees_ts_days_REC = mysqli_fetch_assoc($qu_hr_employees_ts_days_EXE)){
			$CC++;
			
			
			
			$day_id        = $hr_employees_ts_days_REC['day_id'];
			$day_date      = $hr_employees_ts_days_REC['day_date'];
			$time_in       = $hr_employees_ts_days_REC['time_in'];
			$time_out      = $hr_employees_ts_days_REC['time_out'];
			$employee_idT  = $hr_employees_ts_days_REC['employee_id'];
			$dayName       = date('D', strtotime($day_date));
			
			$toARR = explode(":", $time_out);
			$tOut  = $toARR[0].":".$toARR[1];
			$inARR = explode(":", $time_in);
			$tIn   = $inARR[0].":".$inARR[1];
			
			
			
			$datetime1 = strtotime($day_date.' 07:30:00');
			$datetime2 = strtotime($day_date.' '.$tIn);
			$interval  = abs($datetime2 - $datetime1);
			$minutes   = round($interval / 60);
			$delay     = $minutes;
			$totDelay  = $totDelay + $delay;
			

?>
<tr class="ts_record" id="rec-<?=$CC; ?>" ids="<?=$CC; ?>"  night="1">
	<td style="text-align: center;font-size: 12px;"><?=$dayName; ?></td>
	<td style="text-align: center;font-size: 12px;"><?=$day_date; ?></td>
	<td style="text-align: center;font-size: 12px;"><?=$tIn; ?></td>
	<td style="text-align: center;font-size: 12px;"><?=$tOut; ?></td>
<?php
	if( $employee_id != 0 ){
?>
	<td style="text-align: center;font-size: 12px;"><?=$delay; ?></td>
<?php
	}
?>
</tr>
<?php
		}
	}
}



	if( $employee_id != 0 ){
$hours = intval($totDelay/60);
$minutes = $totDelay - ($hours * 60);
?>
<tr class="ts_record" id="rec-<?=$CC; ?>" ids="<?=$CC; ?>"  night="1">
	<td colspan="4" style="text-align: right;" >Total Delay :</td>
	<td  style="text-align: center;"><?='('.$hours.') Hour AND ('.$minutes.') Minutes'; ?></td>
</tr>
<?php
	}
?>
				</tbody>
			</table>
	  
      <tr>
		 <td><hr>
		 </td>
      </tr>
   </tbody>
</table>




<script>

</script>
</body>
</html>
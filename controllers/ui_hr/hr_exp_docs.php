<?php
	require_once('../../bootstrap/app_config.php');
	require_once('../../bootstrap/chk_log_user.php');
	
	$IAM_ARRAY = array();
	
	
	$CUR_PAGE = 1;
	$per_page = 20;
	$totPages = 0;
	
	if( isset( $_POST['page'] ) ){
		$CUR_PAGE = ( int ) test_inputs( $_POST['page'] );
	}
	if( isset( $_POST['showperpage'] ) ){
		$per_page = ( int ) test_inputs( $_POST['showperpage'] );
	}
	
	$start=abs(($CUR_PAGE-1)*$per_page);
	
	
	
	
	
	
	
	$sNo = $start + 1;
	$qu_hr_employees_allowances_sel = "SELECT * FROM `hr_employees_creds` where (passport_expiry_date <= adddate(now(),-7) and passport_expiry_date != 0) or (visa_expiry_date <= adddate(now(),-7) and visa_expiry_date != 0) or (eid_expiry_date <=adddate(now(),-7)and eid_expiry_date != 0) or (labour_expiry_date <= adddate(now(),-7)and labour_expiry_date != 0) or (license_expiry_date <= adddate(now(),-7) and license_expiry_date != 0) LIMIT $start,$per_page";
	
	$qu_hr_employees_allowances_EXE = mysqli_query($KONN, $qu_hr_employees_allowances_sel);
	if(mysqli_num_rows($qu_hr_employees_allowances_EXE)){
		while($HRemp_allowances_REC = mysqli_fetch_assoc($qu_hr_employees_allowances_EXE)){
			$employee_id = $HRemp_allowances_REC['employee_id'];
			$passport_expiry_date = $HRemp_allowances_REC['passport_expiry_date'];
			$visa_expiry_date = $HRemp_allowances_REC['visa_expiry_date'];
			$eid_expiry_date = $HRemp_allowances_REC['eid_expiry_date'];
			$labour_expiry_date = $HRemp_allowances_REC['labour_expiry_date'];
			$license_expiry_date = $HRemp_allowances_REC['license_expiry_date'];
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
				
			}
			$expiry_before_date = strtotime("+7 day");
			$date = date('Y-m-d', $expiry_before_date);
			if( $date >  $passport_expiry_date && $passport_expiry_date!='0000-00-00'){
				if((date("Y-m-d") >  $passport_expiry_date)	){
					$color = "RED";
					$startTimeStamp = strtotime(date('Y-m-d'));
					$endTimeStamp = strtotime($passport_expiry_date);
					
					$timeDiff = abs($endTimeStamp - $startTimeStamp);
					
					$numberDays = intval($timeDiff/86400); 
					
				}
				else {
					$color = "";
					$startTimeStamp = strtotime(date('Y-m-d'));
					$endTimeStamp = strtotime($passport_expiry_date);
					$timeDiff = abs($endTimeStamp - $startTimeStamp);
					$numberDays = intval($timeDiff/86400); 
					
				}	
				$IAM_ARRAY[] = array(  "employee_id" => $hr_employees_REC["employee_id"], 
				"sNo" => $sNo,
				"employee_code" => $hr_employees_REC["employee_code"],
				"first_name" => $hr_employees_REC["first_name"], 
				"last_name" => $hr_employees_REC["last_name"], 
				"join_date" => $hr_employees_REC["join_date"], 
				"document_name" => "PASSPORT", 
				"color" => $color, 
				"numberDays" => $numberDays, 
				"expiry_date" => $passport_expiry_date
				);
				$sNo++;
			}
			if( $date >  $visa_expiry_date && $visa_expiry_date!='0000-00-00'){
				if((date("Y-m-d") >  $visa_expiry_date)	){
					$color = "RED";
					$startTimeStamp = strtotime(date('Y-m-d'));
					$endTimeStamp = strtotime($visa_expiry_date);
					
					$timeDiff = abs($endTimeStamp - $startTimeStamp);
					
					$numberDays = intval($timeDiff/86400); 
					
				}
				else {
					$color = "";
					$startTimeStamp = strtotime(date('Y-m-d'));
					$endTimeStamp = strtotime($visa_expiry_date);
					$timeDiff = abs($endTimeStamp - $startTimeStamp);
					$numberDays = intval($timeDiff/86400); 
					
				}	
				$IAM_ARRAY[] = array(  "employee_id" => $hr_employees_REC["employee_id"], 
				"sNo" => $sNo,
				"employee_code" => $hr_employees_REC["employee_code"],
				"first_name" => $hr_employees_REC["first_name"], 
				"last_name" => $hr_employees_REC["last_name"], 
				"join_date" => $hr_employees_REC["join_date"], 
				"document_name" => "VISA", 
				"color" => $color, 
				"numberDays" => $numberDays, 
				"expiry_date" => $visa_expiry_date
				);
				$sNo++;
			}
			if( $date >  $license_expiry_date && $license_expiry_date!='0000-00-00'){
				if((date("Y-m-d") >  $license_expiry_date)	){
					$color = "RED";
					$startTimeStamp = strtotime(date('Y-m-d'));
					$endTimeStamp = strtotime($license_expiry_date);
					
					$timeDiff = abs($endTimeStamp - $startTimeStamp);
					
					$numberDays = intval($timeDiff/86400); 
					
				}
				else {
					$color = "";
					$startTimeStamp = strtotime(date('Y-m-d'));
					$endTimeStamp = strtotime($license_expiry_date);
					$timeDiff = abs($endTimeStamp - $startTimeStamp);
					$numberDays = intval($timeDiff/86400); 
					
				}	
				$IAM_ARRAY[] = array(  "employee_id" => $hr_employees_REC["employee_id"], 
				"sNo" => $sNo,
				"employee_code" => $hr_employees_REC["employee_code"],
				"first_name" => $hr_employees_REC["first_name"], 
				"last_name" => $hr_employees_REC["last_name"], 
				"join_date" => $hr_employees_REC["join_date"], 
				"document_name" => "LICENSE", 
				"color" => $color, 
				"numberDays" => $numberDays, 
				"expiry_date" => $license_expiry_date
				);
				$sNo++;
			}
			if( $date >  $labour_expiry_date && $labour_expiry_date!='0000-00-00'){
				if((date("Y-m-d") >  $labour_expiry_date)	){
					$color = "RED";
					$startTimeStamp = strtotime(date('Y-m-d'));
					$endTimeStamp = strtotime($labour_expiry_date);
					
					$timeDiff = abs($endTimeStamp - $startTimeStamp);
					
					$numberDays = intval($timeDiff/86400); 
					
				}
				else {
					$color = "";
					$startTimeStamp = strtotime(date('Y-m-d'));
					$endTimeStamp = strtotime($labour_expiry_date);
					$timeDiff = abs($endTimeStamp - $startTimeStamp);
					$numberDays = intval($timeDiff/86400); 
					
				}	
				$IAM_ARRAY[] = array(  "employee_id" => $hr_employees_REC["employee_id"], 
				"sNo" => $sNo,
				"employee_code" => $hr_employees_REC["employee_code"],
				"first_name" => $hr_employees_REC["first_name"], 
				"last_name" => $hr_employees_REC["last_name"], 
				"join_date" => $hr_employees_REC["join_date"], 
				"document_name" => "LABOUR", 
				"color" => $color, 
				"numberDays" => $numberDays, 
				"expiry_date" => $labour_expiry_date
				);
				$sNo++;
			}
			if( $date >  $eid_expiry_date && $eid_expiry_date!='0000-00-00'){
				if((date("Y-m-d") >  $eid_expiry_date)	){
					$color = "RED";
					$startTimeStamp = strtotime(date('Y-m-d'));
					$endTimeStamp = strtotime($eid_expiry_date);
					
					$timeDiff = abs($endTimeStamp - $startTimeStamp);
					
					$numberDays = intval($timeDiff/86400); 
					
				}
				else {
					$color = "";
					$startTimeStamp = strtotime(date('Y-m-d'));
					$endTimeStamp = strtotime($eid_expiry_date);
					$timeDiff = abs($endTimeStamp - $startTimeStamp);
					$numberDays = intval($timeDiff/86400); 
					
				}	
				$IAM_ARRAY[] = array(  "employee_id" => $hr_employees_REC["employee_id"], 
				"sNo" => $sNo,
				"employee_code" => $hr_employees_REC["employee_code"],
				"first_name" => $hr_employees_REC["first_name"], 
				"last_name" => $hr_employees_REC["last_name"], 
				"join_date" => $hr_employees_REC["join_date"], 
				"document_name" => "EID", 
				"color" => $color, 
				"numberDays" => $numberDays, 
				"expiry_date" => $eid_expiry_date
				);
				$sNo++;
			}
		}
	}
	echo json_encode($IAM_ARRAY);
?>















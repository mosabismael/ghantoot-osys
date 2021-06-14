<?php
	$last_id = 1;
	
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	try{
		
		if(isset($_FILES["file1"]) &&
		isset($_POST['requisition_id']) &&
		isset($_POST['file_local_link']) &&
		isset($_POST['media_description'])) {
			
			$targer_dir = $main_pointer."uploads/";
			
			$fileName = $_FILES["file1"]["name"]; // The file name
			$fileTmpLoc = $_FILES["file1"]["tmp_name"]; // File in the PHP tmp folder
			$fileType = $_FILES["file1"]["type"]; // The type of file it is
			$fileSize = $_FILES["file1"]["size"]; // File size in bytes
			$fileErrorMsg = $_FILES["file1"]["error"]; // 0 for false... and 1 for true
			if (!$fileTmpLoc) { // if file not chosen
				echo '<span style="color:red;font-size:65%;">File NOT Found, Please Select a file first</span><br>';
				exit();
			}
			
			//check extensions
			$ths_ext = $fileType;
			$booler = 0;
			if($ths_ext == 'image/png' ||
			$ths_ext == 'image/jpeg' ||
			$ths_ext == 'application/pdf' ||
			$ths_ext == 'application/x-pdf' ||
			$ths_ext == 'text/plain' ||
			$ths_ext == 'video/mp4' ||
			$ths_ext == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' ||
			$ths_ext == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'){
				//file is OK
				$booler = 1;
				//echo 'gd<br>';
				} else {
				//file is NOT ACCEPTED
				$booler = 0;
				$ths_ext = test_inputs($ths_ext);
				echo '<span style="color:red;font-size:65%;">File is NOT ALLOWED, error 1900 | '.$ths_ext.'</span><br>';
				exit();
			}
			
			//check sizes
			if($booler!=0){
				$ths_size = $fileSize;
				$ths_size = round($ths_size/1024);
				if($ths_size > 3000){
					$booler = 0;
					echo '<span style="color:red;font-size:65%;">File Size is Big, error 1901</span><br>';
					exit();
					} else {
					$booler = 1;
					//echo 'gd<br>';
				}
			}
			
			
			//upload file and insert into db
			if($booler!=0){
				//validate data
				$requisition_id = test_inputs($_POST['requisition_id']);
				$media_description = test_inputs($_POST['media_description']);
				$file_local_link = test_inputs($_POST['file_local_link']);
				
				$ext = explode(".", $fileName);
				$extensiom = end($ext);
				$New_name = 'GOMI_'.generate_guid();
				$db_file_name = $New_name.'.'.$extensiom;
				if(move_uploaded_file($fileTmpLoc, $targer_dir.$New_name.'.'.$extensiom)){
					//insert media file into DB
					$qu = "INSERT INTO `pur_requisitions_media` ( 
					`file_path` ,
					`file_type` ,
					`file_size` ,
					`file_description` ,
					`file_date` ,
					`requisition_id`, 
					`employee_id`, 
					`file_local_link` 
					) VALUES ( ?, ?, ?, ?, '".date('Y-m-d H:i:00')."', ?, ?, ?);";
					$stmtC = mysqli_prepare($KONN, $qu);
					$stmtC = mysqli_stmt_init($KONN);
					if(!mysqli_stmt_prepare($stmtC, $qu)){echo "1111";}
					$sizer = round($fileSize/1024);
					if($sizer == 0 ){$sizer = 1;}
					mysqli_stmt_bind_param($stmtC, 'ssisiis', $db_file_name, $fileType, $sizer, $media_description, $requisition_id, $EMPLOYEE_ID, $file_local_link);
					if(mysqli_stmt_execute($stmtC)){
						
						$current_state_id = get_current_state_id($KONN, $requisition_id, 'pur_requisitions' );
						if( $current_state_id != 0 ){
							
							
							if( insert_state_change_dep($KONN, "Media_Inserted-".$db_file_name, $requisition_id, "New_File_Uploaded-".$fileType, 'pur_requisitions_media', $EMPLOYEE_ID, $current_state_id) ){
								echo '<span style="color:green;font-size:65%;">File Upload Completed, you can upload another file</span><br>';
								} else {
								echo '<span style="color:red;font-size:65%;">Component State Error 01</span><br>';
							}
							} else {
							echo '<span style="color:red;font-size:65%;">Component State Error 02</span><br>';
						}
						
						
						
						
						
						
						
						
						
						
						
						} else {
						echo '<span style="color:red;font-size:65%;">Please Contact Support, error 1902</span><br>';
						$booler = 0;
					}
					
					
					
					} else {
					echo '<span style="color:red;font-size:65%;">Please Contact Support, error 19220</span><br>';
				}
				
				
				
				
			}//------------------//
			
			
			} else {
			echo '<span style="color:red;font-size:65%;">File Rejected or No file chosed, error 19330</span><br>';
		}
		
		
		
		die();
	}
	catch(Exception $e){
		if ( is_resource($KONN)) {
			mysqli_close($KONN);
		}
	}
	finally{
		if ( is_resource($KONN)) {
			mysqli_close($KONN);
		}
	}
?>
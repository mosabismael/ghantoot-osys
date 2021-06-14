<?php
	
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	try{
		
		if(!isset($_POST['token_id'])){
			die('7wiu');
		}
		
		$token_id = (int) $_POST['token_id'];
	?>
	
	
	<?php
		$qu_tkn_data_media_sel = "SELECT * FROM  `tkn_data_media` WHERE `token_id` = $token_id";
		$userStatement = mysqli_prepare($KONN,$qu_tkn_data_media_sel);
		mysqli_stmt_execute($userStatement);
		$qu_tkn_data_media_EXE = mysqli_stmt_get_result($userStatement);
		if(mysqli_num_rows($qu_tkn_data_media_EXE)){
			while($tkn_data_media_REC = mysqli_fetch_assoc($qu_tkn_data_media_EXE)){
				
				$media_id = $tkn_data_media_REC['media_id'];
				$file_path = $tkn_data_media_REC['file_path'];
				$file_type = $tkn_data_media_REC['file_type'];
				$file_size = $tkn_data_media_REC['file_size'];
				$file_description = $tkn_data_media_REC['file_description'];
				$file_date = $tkn_data_media_REC['file_date'];
				$token_id = $tkn_data_media_REC['token_id'];
				$employee_id = $tkn_data_media_REC['employee_id'];
				$emp_name = get_emp_name($KONN, $employee_id );
				
				$img_refrence = 0;
				$fileType = "";
				
				switch($file_type){
					case 'application/vnd.openxmlformats-officedocument.word';
					$img_refrence = 0;
					$fileType = "Document";
					break;
					case 'image/jpeg':
					$img_refrence = 1;
					$fileType = "Image";
					break;
					case 'application/x-pdf':
					$img_refrence = 0;
					$fileType = "PDF";
					break;
					case 'application/pdf':
					$img_refrence = 0;
					$fileType = "PDF";
					break;
					case 'text/plain':
					$img_refrence = 0;
					$fileType = "Text";
					break;
					case 'image/png':
					$img_refrence = 1;
					$fileType = "Image";
					break;
					default :
					$img_refrence = 0;
					$fileType = "File";
					break;
				}
			?>
			<tr>
				<td class="text-center">
					<?php if($img_refrence == 0){ ?>
						<a href="../uploads/<?php echo $file_path; ?>" target="_blank"><i class="fa fa-eye reder fa-2x"></i></a>
						<?php } elseif($img_refrence == 1){ ?>
						<a href="../uploads/<?php echo $file_path; ?>" target="_blank"><img class="am_img" style="width:100px;height:100px;cursor:pointer;" src="../uploads/<?php echo $file_path; ?>" alt="<?php echo $file_description; ?>"></a>
					<?php } ?>
				</td>
				<td><?=$tkn_data_media_REC['file_date']; ?></td>
				<td><?=$tkn_data_media_REC['file_description']; ?></td>
				<td><?=$emp_name; ?></td>
				<td><?=$fileType; ?></td>
			</tr>
			<?php
			}
		}
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

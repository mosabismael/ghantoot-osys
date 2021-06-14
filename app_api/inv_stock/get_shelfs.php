<?php
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		if( !isset( $_POST['rack_id'] ) ){
			die('0|ERR_REQ_453334653');
		}
		
		$rack_id = ( int ) $_POST['rack_id'];
		$qu_wh_shelfs_sel = "SELECT * FROM  `wh_shelfs` WHERE `rack_id` = $rack_id";
		$userStatement = mysqli_prepare($KONN,$qu_wh_shelfs_sel);
		mysqli_stmt_execute($userStatement);
		$qu_wh_shelfs_EXE = mysqli_stmt_get_result($userStatement);
		if(mysqli_num_rows($qu_wh_shelfs_EXE)){
		?>
		<option value="0" selected>Please Select</option>
		<?php
			while($wh_shelfs_REC = mysqli_fetch_assoc($qu_wh_shelfs_EXE)){
				$Tshelf_id = $wh_shelfs_REC['shelf_id'];
				$Tshelf_name = $wh_shelfs_REC['shelf_name'];
			?>
			<option value="<?=$Tshelf_id; ?>"><?=$Tshelf_name; ?></option>
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

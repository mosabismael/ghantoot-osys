<?php
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		if( !isset( $_POST['area_id'] ) ){
			die('0|ERR_REQ_453334653');
		}
		
		$area_id = ( int ) $_POST['area_id'];
		$qu_wh_racks_sel = "SELECT * FROM  `wh_racks` WHERE `area_id` = $area_id";
		$userStatement = mysqli_prepare($KONN,$qu_wh_racks_sel);
		mysqli_stmt_execute($userStatement);
		$qu_wh_racks_EXE = mysqli_stmt_get_result($userStatement);
		if(mysqli_num_rows($qu_wh_racks_EXE)){
		?>
		<option value="0" selected>Please Select</option>
		<?php
			while($wh_racks_REC = mysqli_fetch_assoc($qu_wh_racks_EXE)){
				$Track_id = $wh_racks_REC['rack_id'];
				$Track_name = $wh_racks_REC['rack_name'];
			?>
			<option value="<?=$Track_id; ?>"><?=$Track_name; ?></option>
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

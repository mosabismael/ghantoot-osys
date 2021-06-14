<?php
	
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	try{
		
		if(!isset($_POST['quotation_id'])){
			die('7wiu');
		}
		
		$quotation_id = (int) $_POST['quotation_id'];
		
	?>
	
	
	<?php
		$qu_gen_status_change_sel = "SELECT * FROM  `gen_status_change` WHERE `item_type` = 'sales_quotations' AND `item_id` = $quotation_id ORDER BY `status_id` ASC";
		$userStatement = mysqli_prepare($KONN,$qu_gen_status_change_sel);
		mysqli_stmt_execute($userStatement);
		$qu_gen_status_change_EXE = mysqli_stmt_get_result($userStatement);
		if(mysqli_num_rows($qu_gen_status_change_EXE)){
			while($gen_status_change_REC = mysqli_fetch_assoc($qu_gen_status_change_EXE)){
				$status_id = $gen_status_change_REC['status_id'];
				$action_by = $gen_status_change_REC['action_by'];
				$emp_name = get_emp_name($KONN, $action_by );
			?>
			<tr>
				<td><b><?=$gen_status_change_REC['status_date']; ?></b></td>
				<td><b><?=$emp_name; ?></b></td>
				<td><b><?=$gen_status_change_REC['status_action']; ?></b></td>
			</tr>
			<?php
				$qu_gen_status_change_depandancy_sel = "SELECT * FROM  `gen_status_change_depandancy` WHERE `status_id` = '$status_id' ORDER BY `dep_id` ASC";
				$userStatement = mysqli_prepare($KONN,$qu_gen_status_change_depandancy_sel);
				mysqli_stmt_execute($userStatement);
				$qu_gen_status_change_depandancy_EXE = mysqli_stmt_get_result($userStatement);
				if(mysqli_num_rows($qu_gen_status_change_depandancy_EXE)){
					while($gen_status_change_depandancy_REC = mysqli_fetch_assoc($qu_gen_status_change_depandancy_EXE)){
						
						
						
						
					?>
					<tr>
						<td><?=$gen_status_change_depandancy_REC['dep_date']; ?></td>
						<td><?=$emp_name; ?></td>
						<td><?=$gen_status_change_depandancy_REC['dep_action']; ?>( <?=$gen_status_change_depandancy_REC['item_name']; ?> )</td>
					</tr>
					<?php
					}
				}
			?>
			
			
			
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

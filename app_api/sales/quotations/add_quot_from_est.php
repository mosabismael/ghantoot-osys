<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	
	try{
		if(isset($pID) && $pID != ''){
			$count = 0;
			$qu_select = "select count(*) as count from sales_quotations_items where quotation_id = '$rfq_no'";
			echo $qu_select;
			$qu_z_work_scope_EXE = mysqli_query($KONN, $qu_select);
			if(mysqli_num_rows($qu_z_work_scope_EXE)){
				$z_work_scope_REC = mysqli_fetch_assoc($qu_z_work_scope_EXE);
				$count = $z_work_scope_REC['count'];
				if($count == 0){
					$qu_z_work_scope_sel = "SELECT * FROM  `z_work_scope` WHERE `project_id` = $pID";
					$qu_z_work_scope_EXE = mysqli_query($KONN, $qu_z_work_scope_sel);
					if(mysqli_num_rows($qu_z_work_scope_EXE)){
						while($z_work_scope_REC = mysqli_fetch_assoc($qu_z_work_scope_EXE)){
							
							
							$item_name = $z_work_scope_REC['item_name'];
							$item_qty = $z_work_scope_REC['item_qty'];
							$unit_id = $z_work_scope_REC['unit_id'];
							$item_price = $z_work_scope_REC['item_price'];
							$qu_sales_quotations_ins = "INSERT INTO `sales_quotations_items` (
							`q_item_name`, 
							`q_item_price`, 
							`q_item_qty`, 
							`unit_id`, 
							`quotation_id`
							) VALUES (
							'".$item_name."', 
							'".$item_price."', 
							'".$item_qty."', 
							'".$unit_id."', 
							'".$rfq_no."'
							);";
							$insertStatement = mysqli_prepare($KONN,$qu_sales_quotations_ins);
							
						}
					}
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

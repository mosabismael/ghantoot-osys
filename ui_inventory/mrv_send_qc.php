<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 2;
	$subPageID = 6;
	
	if( isset( $_POST['mrv_id'] ) && isset( $_POST['inspector_id'] ) ){
		$mrv_id      = ( int ) $_POST['mrv_id'];
		$inspector_id = ( int ) $_POST['inspector_id'];
		
		
		
		
		
		//get PO ID
	$qu_inv_mrvs_sel = "SELECT `po_id` FROM  `inv_mrvs` WHERE `mrv_id` = $mrv_id";
	$qu_inv_mrvs_EXE = mysqli_query($KONN, $qu_inv_mrvs_sel);
	$po_id = 0;
	if(mysqli_num_rows($qu_inv_mrvs_EXE)){
		$inv_mrvs_DATA = mysqli_fetch_assoc($qu_inv_mrvs_EXE);
		$po_id = (int) $inv_mrvs_DATA['po_id'];
	}

		
		
		
		
		
		
		
		
		
		
		
		
		
		$mrv_status = 'sent_to_inspection';
		$qu_inv_mrvs_updt = "UPDATE  `inv_mrvs` SET 
							`inspected_by` = '".$inspector_id."', 
							`mrv_status` = '".$mrv_status."' 
							WHERE `mrv_id` = $mrv_id;";

		if(mysqli_query($KONN, $qu_inv_mrvs_updt)){
			
			
	$current_state_id = get_current_state_id($KONN, $mrv_id, 'inv_mrvs' );
	if( $current_state_id != 0 ){
		if( insert_state_change_dep($KONN, "send-inspect", $mrv_id, $mrv_status, 'inv_mrvs', $EMPLOYEE_ID, $current_state_id) ){
			
			
			//assign mrv to new user
			$mrv_status = 'inspection_required';
			$qu_inv_mrvs_updt = "UPDATE  `inv_mrvs` SET 
								`mrv_status` = '".$mrv_status."' 
								WHERE `mrv_id` = $mrv_id;";

			if(mysqli_query($KONN, $qu_inv_mrvs_updt)){
				//insert state change
					if( insert_state_change($KONN, $mrv_status, $mrv_id, "inv_mrvs", $inspector_id) ) {
						
	$stock_status = 'under_inspection';
	$qu_inv_stock_updt = "UPDATE  `inv_stock` SET 
						`stock_status` = '".$stock_status."' 
						WHERE `mrv_id` = $mrv_id;";

	if(!mysqli_query($KONN, $qu_inv_stock_updt)){
		die('0|item--updt-err-52554');
	}
						
						
						
						
						
						
						header("location:mrv_list.php?updated=".$mrv_id);
						
					} else {
						die('0|Data Status Error 65154');
					}
				
			} else {
				die( 'sdds'.mysqli_error( $KONN ) );
			}
			
			
			
			
			die('0|Component State Error 01');
		} else {
			die( 'comErr'.mysqli_error( $KONN ) );
		}
	} else {
		die('0|Component State Error 02');
	}
			
			
			
			
			
		} else {
			die( 'eerw'.mysqli_error( $KONN ) );
		}
		
		
		
	}
	
	
	
	
	
	$mrv_id = 0;
	if( isset( $_GET['mrv_id'] ) ){
		$mrv_id = ( int ) $_GET['mrv_id'];
	} else {
		header("location:mrv_list.php?noMRV=1");
	}
	
	//get ordered_by ID
	$qu_inv_mrvs_sel = "SELECT `po_id` FROM  `inv_mrvs` WHERE `mrv_id` = $mrv_id";
	$qu_inv_mrvs_EXE = mysqli_query($KONN, $qu_inv_mrvs_sel);
	$po_id = 0;
	if(mysqli_num_rows($qu_inv_mrvs_EXE)){
		$inv_mrvs_DATA = mysqli_fetch_assoc($qu_inv_mrvs_EXE);
		$po_id = ( int ) $inv_mrvs_DATA['po_id'];
	} else {
		header("location:mrv_list.php?noMRV=1");
	}

	
	//load PO details
	$qu_purchase_orders_sel = "SELECT `requisition_id` FROM  `purchase_orders` WHERE `po_id` = $po_id";
	$qu_purchase_orders_EXE = mysqli_query($KONN, $qu_purchase_orders_sel);
	$requisition_id = 0;
	if(mysqli_num_rows($qu_purchase_orders_EXE)){
		$purchase_orders_DATA = mysqli_fetch_assoc($qu_purchase_orders_EXE);
		$requisition_id = ( int ) $purchase_orders_DATA['requisition_id'];
	} else {
		header("location:mrv_list.php?noPO=1");
	}

	
	$qu_pur_requisitions_sel = "SELECT * FROM  `pur_requisitions` WHERE `requisition_id` = $requisition_id";
	$qu_pur_requisitions_EXE = mysqli_query($KONN, $qu_pur_requisitions_sel);
	$ordered_by = 0;
	if(mysqli_num_rows($qu_pur_requisitions_EXE)){
		$pur_requisitions_DATA = mysqli_fetch_assoc($qu_pur_requisitions_EXE);
		$ordered_by = ( int ) $pur_requisitions_DATA['ordered_by'];
	} else {
		header("location:mrv_list.php?noREQ=1");
	}

	
?>
<!DOCTYPE html>
<html dir="<?=$lang_dir; ?>" lang="<?=$lang; ?>">
<head>
	<?php include('app/meta.php'); ?>
    <?php include('app/assets.php'); ?>
</head>
<body>
<?php

	$WHERE = "requisitions";
	include('app/header.php');
	//PAGE DATA START -----------------------------------------------///---------------------------------
?>



<div class="row">
	<div class="col-100">
		<form action="mrv_send_qc.php" method="POST">
					<input class="frmData" name="mrv_id" type="hidden" value="<?=$mrv_id; ?>">
		
			<div class="row col-100">
				<div class="nwFormGroup">
					<label><?=lang("Select_Inspector:", "AAR"); ?></label>
					<select class="frmData" id="new-inspector_id" name="inspector_id" required>
						<option value="0" disabled selected><?=lang("Please_Select", "غير محدد"); ?></option>
		<?php
			$qu_users_sel = "SELECT `employee_id` FROM  `users` WHERE `dept_code` = 'QC'";
			$qu_users_EXE = mysqli_query($KONN, $qu_users_sel);
			if(mysqli_num_rows($qu_users_EXE)){
				while($users_REC = mysqli_fetch_assoc($qu_users_EXE)){
					$Temployee_id       = ( int ) $users_REC['employee_id'];
					$namerT = get_emp_name($KONN, $Temployee_id );
				
				?>
						<option value="<?=$Temployee_id; ?>"><?=$namerT; ?> ( QHSE Inspector )</option>
				<?php
				}
			}
		?>
		<?php
			$qu_users_sel = "SELECT `employee_id` FROM  `users` WHERE `dept_code` = 'INV'";
			$qu_users_EXE = mysqli_query($KONN, $qu_users_sel);
			if(mysqli_num_rows($qu_users_EXE)){
				while($users_REC = mysqli_fetch_assoc($qu_users_EXE)){
					$employee_idD       = ( int ) $users_REC['employee_id'];
					$namerD = get_emp_name($KONN, $employee_idD );
				
				?>
						<option value="<?=$employee_idD; ?>"><?=$namerD; ?> ( Stock Inspector )</option>
				<?php
				}
			}
		?>
		<?php
			$qu_users_sel2 = "SELECT `employee_id` FROM  `users` WHERE `dept_code` = 'OPR'";
			$qu_users_EXE2 = mysqli_query($KONN, $qu_users_sel2);
			if(mysqli_num_rows($qu_users_EXE2)){
				while($users_REC2 = mysqli_fetch_assoc($qu_users_EXE2)){
					$employee_id2       = ( int ) $users_REC2['employee_id'];
					$namer2 = get_emp_name($KONN, $employee_id2 );
				
				?>
						<option value="<?=$employee_id2; ?>"><?=$namer2; ?> ( Operation Dept )</option>
				<?php
				}
			}
		?>
					</select>
				</div>
				<div class="zero"></div>
			</div>
			
			
			<div class="zero"></div>
				


<div class="viewerBodyButtons">
		<a href="mrv_list.php"><button type="button">
			<?=lang('Cancel', 'ARR', 1); ?>
		</button></a>
		<button type="submit">
			<?=lang('Send_For_Approval', 'ARR', 1); ?>
		</button>
</div>
			
		</form>
	</div>
	<div class="zero"></div>
</div>


<?php
	//PAGE DATA END   ----------------------------------------------///---------------------------------
	include('app/footer.php');
?>
</body>
</html>
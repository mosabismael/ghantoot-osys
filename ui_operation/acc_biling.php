<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "Inv Coding";
	
	
	$menuId = 9;
	$subPageID = 19;
	
?>
<!DOCTYPE html>
<html dir="<?=$lang_dir; ?>" lang="<?=$lang; ?>">
	<html>
		<head>
			<?php include('app/meta.php'); ?>
			<?php include('app/assets.php'); ?>
		</head>
		<body>
			<?php
				include('app/header.php');
				//PAGE DATA START -----------------------------------------------///---------------------------------
			?>
			
			
			
			<script>
				function reload() {
					window.location = window.location.href;
				}
				function mySearchFunction() {
					// Declare variables
					var input, filter, table, tr, td, i, txtValue;
					input = document.getElementById("searcherBox");
					filter = input.value.toUpperCase();
					table = document.getElementById("dataTable");
					tr = table.getElementsByTagName("tr");
					indexNumber = $('#search_option').val();
					// Loop through all table rows, and hide those who don't match the search query
					for (i = 0; i < tr.length; i++) {
						td = tr[i].getElementsByTagName("td")[indexNumber];
						if (td) {
							txtValue = td.textContent || td.innerText;
							if (txtValue.toUpperCase().indexOf(filter) > -1) {
								tr[i].style.display = "";
								} else {
								tr[i].style.display = "none";
							}
						}
					}
				}
			</script>
			
			<div class="row">
				<div class="col-100">
					
					<div class="tableForm">
						<div class="tableFormGroup">
							<select id = "search_option">
								<option value = "" selected disabled> Select Column</option>
								<option value = "1">Job order</option>
								<option value = "2">Client</option>
								<option value = "3">Client REF</option>
								<option value = "4">Created Date</option>
								<option value = "5">Type</option>
								<option value = "6">Status</option>
							</select>
							<input type="text" name="searcher" id="searcherBox" onkeyup="mySearchFunction()" autocomplete="off" placeholder="Search..." />
							<div class="resultClass" id = "resulter"></div>
							<button id = "reload" onclick = "reload()">X</button>
							
						</div>
					</div>
					<a href="acc_biling_new_01.php" class="actionBtn"><button type="button"><i class="fas fa-plus"></i><?=lang("Add_New", "AAR"); ?></button></a>
					
					<table id="dataTable" class="tabler" border="2">
						<thead>
							<tr>
								<th><?=lang("Bill_REF", "AAR"); ?></th>
								<th><?=lang("Job_Order", "AAR"); ?></th>
								<th><?=lang("Client", "AAR"); ?></th>
								<th><?=lang("Client_REF", "AAR"); ?></th>
								<th><?=lang("Created_Date", "AAR"); ?></th>
								<th><?=lang("Type", "AAR"); ?></th>
								<th><?=lang("Status", "AAR"); ?></th>
								<th><?=lang("Options", "AAR"); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$sNo = 0;
								$qu_acc_biling_sel = "SELECT * FROM  `acc_biling`";
								$qu_acc_biling_EXE = mysqli_query($KONN, $qu_acc_biling_sel);
								if(mysqli_num_rows($qu_acc_biling_EXE)){
									while($acc_biling_REC = mysqli_fetch_assoc($qu_acc_biling_EXE)){
										$sNo++;
										$bill_id = $acc_biling_REC['bill_id'];
										$bill_type = $acc_biling_REC['bill_type'];
										$bill_ref = $acc_biling_REC['bill_ref'];
										$client_ref = $acc_biling_REC['client_ref'];
										$created_date = $acc_biling_REC['created_date'];
										$created_by = $acc_biling_REC['created_by'];
										$job_order_id = $acc_biling_REC['job_order_id'];
										$bill_status = $acc_biling_REC['bill_status'];
										
										// $BY       = get_emp_name($KONN, $employee_id );
										
										
										$qu_job_orders_sel = "SELECT * FROM  `job_orders` WHERE `job_order_id` = $job_order_id";
										$qu_job_orders_EXE = mysqli_query($KONN, $qu_job_orders_sel);
										$job_orders_DATA;
										if(mysqli_num_rows($qu_job_orders_EXE)){
											$job_orders_DATA = mysqli_fetch_assoc($qu_job_orders_EXE);
										}
										
										$project_name = $job_orders_DATA['project_name'];
									$client_id = $job_orders_DATA['client_id'];
									$job_order_type = $job_orders_DATA['job_order_type'];
									$project_manager_id = $job_orders_DATA['project_manager_id'];
									$job_order_status = $job_orders_DATA['job_order_status'];
									// $created_date = $job_orders_DATA['created_date'];
									$created_by = $job_orders_DATA['created_by'];
									$job_order_ref = $job_orders_DATA['job_order_ref'];
									
									$qu_gen_clients_sel = "SELECT `client_name` FROM  `gen_clients` WHERE `client_id` = $client_id";
									$qu_gen_clients_EXE = mysqli_query($KONN, $qu_gen_clients_sel);
									$client_name = '';
									if(mysqli_num_rows($qu_gen_clients_EXE)){
									$gen_clients_DATA = mysqli_fetch_assoc($qu_gen_clients_EXE);
									$client_name = $gen_clients_DATA['client_name'];
									}
									
									
									
									?>
									<tr id="boxdata-<?=$bill_id; ?>">
									<td class="text-primary"><a href="acc_billing_details.php?bill_id=<?=$bill_id; ?>"><?=$bill_ref; ?></a></td>
									<td><?=$job_order_ref; ?></td>
									<td><?=$client_name; ?></td>
									<td><?=$client_ref; ?></td>
									<td><?=$created_date; ?></td>
									<td><?=$bill_type; ?></td>
									<td><?=$bill_status; ?></td>
									<td>
									<?php
									if( $bill_status == 'draft' ){
									?>
									<a href="acc_billing_send_acc.php?bill_id=<?=$bill_id; ?>"><button type="button">Send To ACC</button></a>
									<a href="acc_biling_new_02.php?bill_id=<?=$bill_id; ?>"><button type="button">Edit Items</button></a>
									<a href="prints/acc_biling_print.php?bill_id=<?=$bill_id; ?>" target="_blank"><button type="button">Payment Application</button></a>
									<?php
									} else if( $bill_status == 'sent_to_acc' ){
									?>
									<a href="acc_billing_details.php?bill_id=<?=$bill_id; ?>"><button type="button">View Details</button></a>
									<?php
									}
									?>
									<a href="acc_billing_attachments.php?bill_id=<?=$bill_id; ?>"><button type="button">Attachments</button></a>
									</td>
									</tr>
									<?php
									}
									} else {
									?>
									<tr>
									<td colspan="7">NO DATA FOUND</td>
									</tr>
									
									<?php
									}
									
									?>
									</tbody>
									</table>
									
									</div>
									<div class="zero"></div>
									</div>
									
									
									
									
									
									
									
									<?php
									//PAGE DATA END   ----------------------------------------------///---------------------------------
									include('app/footer.php');
									?>
									<script>
									
									</script>
									</body>
									</html>									
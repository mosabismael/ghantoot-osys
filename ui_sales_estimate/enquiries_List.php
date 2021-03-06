<?php
require_once('../bootstrap/app_config.php');
require_once('../bootstrap/chk_log_user.php');
// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
$page_title = $page_description = $page_keywords = $page_author = "GOMI ERP";

$menuId = 2;
$subPageID = 21;




$client_id = 0;
$client_name = "";
if (isset($_GET['client_id'])) {
	$client_id = (int) test_inputs($_GET['client_id']);
}




if ($client_id != 0) {
	//load client name
	$qu_gen_clients_sel = "SELECT `client_name` FROM  `gen_clients` WHERE `client_id` = $client_id";
	$qu_gen_clients_EXE = mysqli_query($KONN, $qu_gen_clients_sel);
	$gen_clients_DATA;
	if (mysqli_num_rows($qu_gen_clients_EXE)) {
		$gen_clients_DATA = mysqli_fetch_assoc($qu_gen_clients_EXE);
		$client_name = $gen_clients_DATA['client_name'];
	}
}



?>
<!DOCTYPE html>
<html dir="<?= $lang_dir; ?>" lang="<?= $lang; ?>">

<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	</script>
	<script src="./script.js"></script>
	<script>
		$(document).ready(function() {
			$("#myInput").on("keyup", function() {
				var value = $(this).val().toLowerCase();
				$("#myTable tr").filter(function() {
					$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
				});
			});
		});
	</script>

	<?php include('app/meta.php'); ?>
	<?php include('app/assets.php'); ?>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel='stylesheet' href='https://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css'>
	<link rel="stylesheet" href="./style.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<style>
		.filterable {
			margin-top: 15px;
		}

		.filterable .panel-heading .pull-right {
			margin-top: -20px;
		}

		.filterable .filters input[disabled] {
			background-color: transparent;
			border: none;
			cursor: auto;
			box-shadow: none;
			padding: 0;
			height: auto;
		}

		.filterable .filters input[disabled]::-webkit-input-placeholder {
			color: #333;
		}

		.filterable .filters input[disabled]::-moz-placeholder {
			color: #333;
		}

		.filterable .filters input[disabled]:-ms-input-placeholder {
			color: #333;
		}

		.pagination {
			display: inline-block;
		}

		.pagination a {
			color: black;
			float: left;
			padding: 8px 16px;
			text-decoration: none;
			transition: background-color .3s;
			border: 1px solid #ddd;
		}

		.pagination a.active {
			background-color: #4CAF50;
			color: white;
			border: 1px solid #4CAF50;
		}

		.pagination a:hover:not(.active) {
			background-color: #ddd;
		}

		input[type=text],
		select,
		textarea {
			width: 100%;
			padding: 12px;
			border: 1px solid #ccc;
			border-radius: 4px;
			box-sizing: border-box;
			margin-top: 6px;
			margin-bottom: 16px;
			resize: vertical;
		}

		input[type=date] {
			width: 100%;
			padding: 12px;
			border: 1px solid #ccc;
			border-radius: 4px;
			box-sizing: border-box;
			margin-top: 6px;
			margin-bottom: 16px;
			resize: vertical;
		}

		input[type=submit] {
			background-color: #04AA6D;
			color: white;
			padding: 12px 20px;
			border: none;
			border-radius: 4px;
			cursor: pointer;
		}

		#myInput {
			background-image: url('/app/searchicon.png');
			background-position: 10px 12px;
			background-repeat: no-repeat;
			width: 100%;
			font-size: 16px;
			padding: 12px 20px 12px 40px;
			border: 1px solid #ddd;
			margin-bottom: 12px;
		}

		input[type=submit]:hover {
			background-color: #45a049;
		}

		.container {
			border-radius: 5px;
			background-color: #f2f2f2;
			padding: 20px;
		}
	</style>
</head>

<body>

	<?php
	$WHERE = "";
	include('app/header.php');
	//PAGE DATA START -----------------------------------------------///---------------------------------
	?>

	<div class="row">
		<div class="col-33">
			<!-- <button style=" background-color: #2e6da4;
				color: white;
				padding: 12px 20px;
				border: none;
				border-radius: 4px;
			cursor: pointer;" onclick="sortTable()">Sort</button> -->
		</div>
		<div class="col-33">
			<input id="myInput" type="text" placeholder="Search..">

		</div>
		<iframe id="myFrame" style="display:none" width="600" height="300"></iframe>

	</div>
	<div class="row">
		<div class="panel panel-primary filterable">
			<div class="panel-heading">
				<h3 class="panel-title">Enquiries List</h3>
				<div class="pull-right"><button class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filter</button></div>
			</div>
			<table class="table" border="2">

				<thead>
					<tr class="filters">
						<th></th>
						<th><input type="text" class="form-control" placeholder="Sys Id" disabled></th>
						<th><input type="text" class="form-control" placeholder="Enquiry Type" disabled></th>
						<th><input type="text" class="form-control" placeholder="Date" disabled></th>
						<th><input type="text" class="form-control" placeholder="Client Name" disabled></th>
						<th><input type="text" class="form-control" placeholder="Subject" disabled></th>
						<th><input type="text" class="form-control" placeholder="Budget" disabled></th>
						<th><input type="text" class="form-control" placeholder="Attachments" disabled></th>
						<th>
							<p class="form-control">Print</p>
						</th>
						<th><input type="text" class="form-control" placeholder="Action" disabled></th>
					</tr>
				</thead>
				<tbody id="myTable">
					<?php
					$qu_enquiries_sel = "SELECT * FROM  `enquiries`";
					$qu_enquiries_EXE = mysqli_query($KONN, $qu_enquiries_sel);
					if (mysqli_num_rows($qu_enquiries_EXE)) {
						while ($enquiries_REC = mysqli_fetch_assoc($qu_enquiries_EXE)) {
							$enquiry_id  = $enquiries_REC['enquiry_id'];
							$client_id = $enquiries_REC['client_id'];
							$date = $enquiries_REC['date'];
							$enquiry_type = $enquiries_REC['enquiry_type'];
							$details = $enquiries_REC['details'];

							$qu_z_project_sel = "SELECT * FROM  `z_project` WHERE `enquiries_id` = $enquiry_id";
							$qu_z_project_EXE = mysqli_query($KONN, $qu_z_project_sel);
							$project_id = "NA";
							if (mysqli_num_rows($qu_z_project_EXE)) {

								$gen_z_projec_DATA = mysqli_fetch_assoc($qu_z_project_EXE);
								$project_id = $gen_z_projec_DATA['project_id'];
							}

							$status = "<a href='projects_estimation.php?enquiry_id=$enquiry_id' ><button  type='button' style='background-color: #4CAF50;
								border: none;
								color: white;
								padding: 15px 32px;
								text-align: center;
								text-decoration: none;
								display: inline-block;
								font-size: 16px;
								margin: 4px 2px;
								cursor: pointer;'>Done</button></a>";

							$isExpired = false;
							if ($enquiries_REC['status'] == 0) {
								$status = "<form action='new_estimation.php'> 
									<input type='hidden' name='user' value='$client_id'>
									<input type='hidden' name='enquiry_id' value='$enquiry_id'>
									
									<input 
									style='background-color: #f44336;
									
									border: none;
									color: white;
									padding: 15px 32px;
									text-align: center;
									text-decoration: none;
									display: inline-block;
									font-size: 16px;
									margin: 4px 2px;
									cursor: pointer;'
									type='submit'
									value='Start Estimation'></form>";
							} else {
								if ($enquiries_REC['status'] == 2) {
									$status = "<a href='projects_estimation.php?project_id=$project_id' ><button  type='button' style='background-color: #555555;
										border: none;
										color: white;
										padding: 15px 32px;
										text-align: center;
										text-decoration: none;
										display: inline-block;
										font-size: 16px;
										margin: 4px 2px;
										cursor: pointer;'> In Progress</button>";
								}
							}


							$qu_gen_clients_sel = "SELECT * FROM  `gen_clients` WHERE `client_id` = $client_id";
							$qu_gen_clients_EXE = mysqli_query($KONN, $qu_gen_clients_sel);
							$client_name = "NA";
							if (mysqli_num_rows($qu_gen_clients_EXE)) {
								$gen_clients_DATA = mysqli_fetch_assoc($qu_gen_clients_EXE);
								$client_id = $gen_clients_DATA['client_id'];
								$client_name = $gen_clients_DATA['client_name'];
							}


					?>
							<tr id="quote-<?= $enquiry_id; ?>">
								<td><a href="enquiry_edit.php?enquiry_id=<?=$enquiry_id?>"><i class="far fa-edit"></i></a><a href=""><i onclick ="delete_enquiry(<?=$enquiry_id?>)" class="fas fa-trash"></i></a></td>
								<td><?= $enquiry_id; ?></td>
								<td><?= $enquiries_REC["enquiry_type"]; ?></td>
								<td><?= $enquiries_REC["date"]; ?></td>
								<td><?= $client_name; ?></td>
								<td><?= $enquiries_REC["subject"]; ?></td>
								<td><i style="font-size:24px; color:green" class="fa">&#xf155;</i> <?= $enquiries_REC["budget"]; ?></td>
								<td>
									<?php
									$qu_enquiries_sel1 = "SELECT * FROM  `enquiry_attachment` where enquiry_id = $enquiry_id";
									$qu_enquiries_EXE1 = mysqli_query($KONN, $qu_enquiries_sel1);
									if (mysqli_num_rows($qu_enquiries_EXE1)) {
										while ($enquiries_REC1 = mysqli_fetch_assoc($qu_enquiries_EXE1)) {
											$attachment  = $enquiries_REC1['attachment'];
											$title  = $enquiries_REC1['title'];

									?>
											<p>Title: <?= $title ?></p> <a href="fileupload/<?= $attachment ?>" target='_blank'><input type="button" value="<?= $attachment ?>" /><a></br>
											<?php
										}
									}
											?>
								</td>
								
								<td><button onclick="window.print()">Print</button></td>

								<td><?= $status; ?></td>
							</tr>
						<?php
						}
					} else {
						?>
						<tr id="quote-0">
							<td colspan="8"><?= lang("No Data Found", "AAR"); ?></td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>

	<div class="pagination">
		<a href="#">&laquo;</a>
		<a href="#" class="active">1</a>
		<a href="#">2</a>
		<a href="#">3</a>
		<a href="#">4</a>
		<a href="#">5</a>
		<a href="#">6</a>
		<a href="#">&raquo;</a>
	</div>
	</div>
	<div class="zero"></div>
	</div>

	<?php
	//PAGE DATA END   ----------------------------------------------///---------------------------------
	include('app/footer.php');
	?>
	<script>
		function myFunction() {
			var input, filter, table, tr, td, i, txtValue;
			input = document.getElementById("myInput");
			filter = input.value.toUpperCase();
			table = document.getElementById("dataTable");
			tr = table.getElementsByTagName("tr");
			for (i = 0; i < tr.length; i++) {
				td = tr[i].getElementsByTagName("td")[3];
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

		function openPdf(value) {
			var omyFrame = document.getElementById("myFrame");
			omyFrame.style.display = "block";
			omyFrame.src = "fileupload/".value;
		}
		function delete_enquiry(id){
				$.ajax({
					type: "GET",
					url: "delete_enquiry.php",
					data: {'enquiry_id':id},
					dataType: "json",
					success: function(response) {
						alert("deleted");
					}
				});
				
			}
	</script>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
	<script src="./script.js"></script>

</body>

</html>
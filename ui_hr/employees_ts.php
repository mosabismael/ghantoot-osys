<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "Time Tables";
	
	
	
	$menuId = 8;
	$subPageID = 11;
		
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
							<option value = "0">Timesheet Id</option>
							<option value = "1">Month</option>
							<option value = "2">Year</option>
							<option value = "3">Created By</option>
							<option value = "4">Created Date</option>
						</select>
						<input type="text" name="searcher" id="searcherBox" onkeyup="mySearchFunction()" autocomplete="off" placeholder="Search..." />
						<div class="resultClass" id = "resulter"></div>
						<button id = "reload" onclick = "reload()">X</button>
						
					</div>
				</div>
		<table id="dataTable" class="tabler" border="2">
			<thead>
				<tr>
					<th>
<a href="employees_ts_new.php"><button type="button" class="btn-success"><?=lang("Add_New", "AAR"); ?></button></a>
					</th>
					<th><?=lang("Month", "AAR"); ?></th>
					<th><?=lang("Year", "AAR"); ?></th>
					<th><?=lang("Created_By", "AAR"); ?></th>
					<th><?=lang("Created_Date", "AAR"); ?></th>
					<th>--</th>
				</tr>
			</thead>
			<tbody>
<?php
	$sNo = 0;
	$qu_hr_employees_ts_sel = "SELECT * FROM  `hr_employees_ts` ORDER BY `ts_id` DESC";
	$qu_hr_employees_ts_EXE = mysqli_query($KONN, $qu_hr_employees_ts_sel);
	if(mysqli_num_rows($qu_hr_employees_ts_EXE)){
		while($hr_employees_ts_REC = mysqli_fetch_assoc($qu_hr_employees_ts_EXE)){
		$ts_id = $hr_employees_ts_REC['ts_id'];
		$ts_ref = $hr_employees_ts_REC['ts_ref'];
		$ts_year = $hr_employees_ts_REC['ts_year'];
		$ts_month = $hr_employees_ts_REC['ts_month'];
		$created_date = $hr_employees_ts_REC['created_date'];
		$created_by = $hr_employees_ts_REC['created_by'];
		$ts_status = $hr_employees_ts_REC['ts_status'];
		
		
			
	$qu_hr_employees_sel = "SELECT `employee_code`, `first_name`, `last_name`, `join_date` FROM  `hr_employees` WHERE `employee_id` = $created_by";
	$qu_hr_employees_EXE = mysqli_query($KONN, $qu_hr_employees_sel);
	$hr_employees_DATA;
	if(mysqli_num_rows($qu_hr_employees_EXE)){
		$hr_employees_DATA = mysqli_fetch_assoc($qu_hr_employees_EXE);
	}
		$NAMER = $hr_employees_DATA['first_name'].' '.$hr_employees_DATA['last_name'];
		?>
			<tr id="boxdata-<?=$ts_id; ?>">
				<td onclick="edit_data(<?=$ts_id; ?>);"><span id="poREF-<?=$ts_id; ?>" class="text-primary"><?=$ts_ref; ?></span></td>
				<td><?=$ts_month; ?></td>
				<td><?=$ts_year; ?></td>
				<td><?=$NAMER; ?></td>
				<td><?=$created_date; ?></td>
				<td>
<?php
	if( $ts_status == 'draft' ){
?>
	<a href="employees_ts_new_01.php?ts_id=<?=$ts_id; ?>"><button type="button">Add Attendance</button></a>
	<a href="employees_ts_view.php?ts_id=<?=$ts_id; ?>"><button type="button">View</button></a>
<?php
	}
?>
<?php
	if( $ts_status == 'active' ){
?>
	<a href="employees_ts_new_02.php?ts_id=<?=$ts_id; ?>"><button type="button">Define Days</button></a>
<?php
	}
?>
				
				
				</td>
			</tr>
		<?php
		}
	} else {
?>
			<tr>
				<td colspan="8">NO DATA FOUND</td>
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
<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "Time Tables";
	
	$menuId = 8;
	$subPageID = 10;
		
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
							<option value = "1">Shift</option>
							<option value = "2">From</option>
							<option value = "3">To</option>
						</select>
						<input type="text" name="searcher" id="searcherBox" onkeyup="mySearchFunction()" autocomplete="off" placeholder="Search..." />
						<div class="resultClass" id = "resulter"></div>
						<button id = "reload" onclick = "reload()">X</button>
						
					</div>
				</div>
		<table id="dataTable" class="tabler" border="2">
			<thead>
				<tr>
                    <th style="width: 30%;" colspan="2">
                        <a onclick="add_new_modal_shift();"><button type="button" class="btn-success"><?=lang("Add_New", "AAR"); ?></button></a>
                    </th>
					<th style="width: 40%;" colspan="2"><?=lang("Time", "AAR"); ?></th>
				</tr>
				<tr>
                    <th>NO.</th>
					<th><?=lang("Shift", "AAR"); ?></th>
					<th><?=lang("From", "AAR"); ?></th>
					<th><?=lang("To", "AAR"); ?></th>
				</tr>
			</thead>
			<tbody>
<?php
	$sNo = 0;
	$qu_hr_shifts_timetable_sel = "SELECT * FROM  `hr_shifts_timetable`";
	$qu_hr_shifts_timetable_EXE = mysqli_query($KONN, $qu_hr_shifts_timetable_sel);
	if(mysqli_num_rows($qu_hr_shifts_timetable_EXE)){
		while($hr_shifts_timetable_REC = mysqli_fetch_assoc($qu_hr_shifts_timetable_EXE)){
			$sNo++;
		$shift_id = $hr_shifts_timetable_REC['shift_id'];
		$hr_from = $hr_shifts_timetable_REC['hr_from'];
		$hr_to = $hr_shifts_timetable_REC['hr_to'];
		$day_shift = $hr_shifts_timetable_REC['day_shift'];
		$typo = $hr_shifts_timetable_REC['typo'];
		
		
		?>
			<tr id="boxdata-<?=$shift_id; ?>">
				<td><?=$sNo; ?></td>
				<td onclick="edit_data(<?=$shift_id; ?>);"><span id="poREF-<?=$shift_id; ?>" class="text-primary"><?=$typo; ?></span></td>
				<td><?=$hr_from; ?></td>
				<td><?=$hr_to; ?></td>
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




<!--    ///////////////////      add_new_modal_shift Modal START    ///////////////////            -->
<div class="modal" id="add_new_modal_shift">
	<div class="modal-container">
		<div class="modal-header">
			<?php include("app/modal_header.php"); ?>
		</div>
		<div class="modal-body">
			
				<form 
				id="add-new-shift-form" 
				id-modal="add_new_modal_shift" 
				class="boxes-holder" 
				api="<?=api_root; ?>hr_shifts_timetable/add_new.php">

				
<div class="col-50">
	<div class="form-grp">
		<label>typo</label>
        <input class="frmData" type="text" 
        		id="new-typo" 
        		name="typo" 
        		req="1" 
        		den="" 
        		alerter="<?=lang("Please_Check_typo", "AAR"); ?>">
	</div>
</div>

<div class="col-50">
	<div class="form-grp">
		<label>day Shiting</label>
        <input class="frmData" type="text" 
        		id="new-day_shift" 
        		name="day_shift" 
        		req="1" 
        		den="" 
        		alerter="<?=lang("Please_Check_day_shift", "AAR"); ?>">
	</div>
</div>

	<div class="zero"></div>

				
<div class="col-50">
	<div class="form-grp">
		<label>From</label>
        <input class="frmData" type="time" 
        		id="new-hr_from" 
        		name="hr_from" 
        		req="1" 
        		den="" 
        		alerter="<?=lang("Please_Check_from", "AAR"); ?>">
	</div>
</div>
				
<div class="col-50">
	<div class="form-grp">
		<label>To</label>
        <input class="frmData" type="time" 
        		id="new-hr_to" 
        		name="hr_to" 
        		req="1" 
        		den="" 
        		alerter="<?=lang("Please_Check_To", "AAR"); ?>">
	</div>
</div>
				

<div class="zero"></div>

	<div class="form-alerts"></div>
	<div class="zero"></div>

<div class="viewerBodyButtons">
		<button type="button" onclick="submit_form('add-new-shift-form', 'reload_page');">
			<?=lang('Add', 'ARR', 1); ?>
		</button>
		<button type="button" onclick="hide_modal();">
			<?=lang('Cancel', 'ARR', 1); ?>
		</button>
</div>


	

</form>
			
			
		</div>
	</div>
	<div class="zero"></div>
</div>


<!--    ///////////////////      add_new_modal_shift Modal END    ///////////////////            -->



<!--    ///////////////////      edit_modal_shift Modal START    ///////////////////            -->
<div class="modal" id="edit_modal_shift">
	<div class="modal-container">
		<div class="modal-header">
			<?php include("app/modal_header.php"); ?>
		</div>
		<div class="modal-body">
			
				<form 
				id="edit-shift-form" 
				id-modal="edit_modal_shift" 
				class="boxes-holder" 
				api="<?=api_root; ?>hr_shifts_timetable/edit_data.php">


<input class="frmData" type="hidden" 
		id="edit-shift_id" 
		name="shift_id" 
		value="0" 
		req="1" 
		den="0" 
		alerter="<?=lang("Please_Check_shift", "AAR"); ?>">

				
<div class="col-50">
	<div class="form-grp">
		<label>typo</label>
        <input class="frmData" type="text" 
        		id="edit-typo" 
        		name="typo" 
        		req="1" 
        		den="" 
        		alerter="<?=lang("Please_Check_typo", "AAR"); ?>">
	</div>
</div>

<div class="col-50">
	<div class="form-grp">
		<label>day Shiting</label>
        <input class="frmData" type="text" 
        		id="edit-day_shift" 
        		name="day_shift" 
        		req="1" 
        		den="" 
        		alerter="<?=lang("Please_Check_day_shift", "AAR"); ?>">
	</div>
</div>

	<div class="zero"></div>

				
<div class="col-50">
	<div class="form-grp">
		<label>From</label>
        <input class="frmData" type="time" 
        		id="edit-hr_from" 
        		name="hr_from" 
        		req="1" 
        		den="" 
        		alerter="<?=lang("Please_Check_from", "AAR"); ?>">
	</div>
</div>
				
<div class="col-50">
	<div class="form-grp">
		<label>To</label>
        <input class="frmData" type="time" 
        		id="edit-hr_to" 
        		name="hr_to" 
        		req="1" 
        		den="" 
        		alerter="<?=lang("Please_Check_To", "AAR"); ?>">
	</div>
</div>

	<div class="zero"></div>


	<div class="form-alerts"></div>
	<div class="zero"></div>

<div class="viewerBodyButtons">
		<button type="button" onclick="submit_form('edit-shift-form', 'reload_page');">
			<?=lang('Save', 'ARR', 1); ?>
		</button>
		<button type="button" onclick="hide_modal();">
			<?=lang('Cancel', 'ARR', 1); ?>
		</button>
</div>

	

</form>
			
			
		</div>
	</div>
	<div class="zero"></div>
</div>
<!--    ///////////////////      edit_modal_shift Modal END    ///////////////////            -->

<script>
function del_data( ids_id ){
	var aa = confirm("Are you sure, action cannot be undone ?");
	if( aa == true ){
		alert("Unit Assigned with items, cannot be deleted !");
		/*
		$.ajax({
			url      :"<?=api_root; ?>hr_shifts_timetable/rem_data.php",
			data     :{'typo': 'pc_call', 'shift_id': ids_id},
			dataType :"html",
			type     :'POST',
			success  :function(response){
				$('#boxdata-' + ids_id).remove();
			},
			error    :function(){
				alert('Code Not Applied');
			},
		});
		*/
	}
}





function edit_data( ids_id ){
	var titler = '<?=lang("Edit", "AAR"); ?>' + ' :: ';
	
	titler = titler + $('#boxdata-' + ids_id + ' .cell-title').text();
	
	$.ajax({
		url      :"<?=api_root; ?>hr_shifts_timetable/get_data.php",
		data     :{'typo': 'pc_call', 'ids_id': ids_id},
		dataType :"JSON",
		type     :'POST',
		success  :function(response){
			
$('#edit-shift_id').val(response[0].shift_id);

$('#edit-hr_from').val(response[0].hr_from);
$('#edit-hr_to').val(response[0].hr_to);
$('#edit-day_shift').val(response[0].day_shift);
$('#edit-typo').val(response[0].typo);


			show_modal( 'edit_modal_shift' , titler );

				// end_loader();
				
		},
		error    :function(){
			alert('Code Not Applied');
		},
	});
}

function add_new_modal_shift(){
	var titler = '<?=lang("Add_New_Entry", "AAR"); ?>';
	show_modal( 'add_new_modal_shift' , titler );
}
</script>





<?php
	//PAGE DATA END   ----------------------------------------------///---------------------------------
	include('app/footer.php');
?>
<script>

</script>
</body>
</html>
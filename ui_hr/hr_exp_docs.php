<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "Site Title";
	
	
	$menuId = 7;
	$subPageID = 9;
	
	$page = 1;
	$showPerPage = 20;
	$totPages = 0;
	$qu_COUNT_sel = "SELECT count(*) FROM  `hr_employees_creds` where passport_expiry_date >= adddate(now(),-7) and passport_expiry_date != 0";
	$qu_COUNT_EXE = mysqli_query($KONN, $qu_COUNT_sel);
	if(mysqli_num_rows($qu_COUNT_EXE)){
		$job_COUNT_DATA = mysqli_fetch_array($qu_COUNT_EXE);
		$totPages = ( int ) $job_COUNT_DATA[0];
	}
	$qu_COUNT_sel = "SELECT count(*) FROM  `hr_employees_creds` where visa_expiry_date >= adddate(now(),-7) and visa_expiry_date != 0";
	$qu_COUNT_EXE = mysqli_query($KONN, $qu_COUNT_sel);
	if(mysqli_num_rows($qu_COUNT_EXE)){
		$job_COUNT_DATA = mysqli_fetch_array($qu_COUNT_EXE);
		$totPages += ( int ) $job_COUNT_DATA[0];
	}
	$qu_COUNT_sel = "SELECT count(*) FROM  `hr_employees_creds` where eid_expiry_date >= adddate(now(),-7) and eid_expiry_date != 0";
	$qu_COUNT_EXE = mysqli_query($KONN, $qu_COUNT_sel);
	if(mysqli_num_rows($qu_COUNT_EXE)){
		$job_COUNT_DATA = mysqli_fetch_array($qu_COUNT_EXE);
		$totPages += ( int ) $job_COUNT_DATA[0];
	}
	$qu_COUNT_sel = "SELECT count(*) FROM  `hr_employees_creds` where labour_expiry_date >= adddate(now(),-7) and labour_expiry_date != 0";
	$qu_COUNT_EXE = mysqli_query($KONN, $qu_COUNT_sel);
	if(mysqli_num_rows($qu_COUNT_EXE)){
		$job_COUNT_DATA = mysqli_fetch_array($qu_COUNT_EXE);
		$totPages += ( int ) $job_COUNT_DATA[0];
	}
	$qu_COUNT_sel = "SELECT count(*) FROM  `hr_employees_creds` where license_expiry_date >= adddate(now(),-7) and license_expiry_date != 0";
	$qu_COUNT_EXE = mysqli_query($KONN, $qu_COUNT_sel);
	if(mysqli_num_rows($qu_COUNT_EXE)){
		$job_COUNT_DATA = mysqli_fetch_array($qu_COUNT_EXE);
		$totPages += ( int ) $job_COUNT_DATA[0];
	}
	$totPages = ceil($totPages / $showPerPage);
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
								<option value = "1">Employee id</option>
								<option value = "2">Employee_code</option>
								<option value = "3">Name</option>
								<option value = "4">Join Date</option>
								<option value = "5">Document</option>
								<option value = "6">Expiry Date</option>
								<option value = "7">Time remain</option>
								<option value = "8">Status</option>
							</select>
							<input type="text" name="searcher" id="searcherBox" onkeyup="mySearchFunction()" autocomplete="off" placeholder="Search..." />
							<div class="resultClass" id = "resulter"></div>
							<button id = "reload" onclick = "reload()">X</button>
							
						</div>
					</div>
					<table id="dataTable" class="tabler" border="2" style="font-size:10px;">
						<thead>
							<tr>
								<th><?=lang("Sno", "AAR"); ?></th>
								<th><?=lang("Employee_id", "AAR"); ?></th>
								<th><?=lang("employee_code", "AAR"); ?></th>
								<th><?=lang("Name", "AAR"); ?></th>
								<th><?=lang("join_date", "AAR"); ?></th>
								<th><?=lang("Document", "AAR"); ?></th>
								<th><?=lang("expiry_date", "AAR"); ?></th>
								<th><?=lang("Time_Remain(days)", "AAR"); ?></th>
								<th><?=lang("Status", "AAR"); ?></th>
							</tr>
						</thead>
						<tbody id = "tableBody"></tbody>
					</table>
					<div class="tablePagination">
						<div class="pageNum arrowPager" id="prePatchBtn" onclick="showPrePageBatch('ui_hr/<?=basename($_SERVER['PHP_SELF']); ?>', <?=$showPerPage; ?>, <?=$totPages; ?>);"><i class="fas fa-angle-double-left"></i></div>
						<?php
							for( $i=$page ; $i<$page+5 ; $i++ ){
								$CLS = '';
								if( $page == $i ){
									$CLS = 'activePage';
								}
								$iView = ''.$i;
								if( $i < 10 ){
									$iView = '0'.$i;
								}
								if( $i <= $totPages ){
								?>
								<div onclick="loadTableData( <?=$i; ?>, <?=$showPerPage; ?>, 'ui_hr/<?=basename($_SERVER['PHP_SELF']); ?>' );" class="pageNum imVarPager pn-<?=$i; ?> <?=$CLS; ?>"><?=$iView; ?></div>
								<?php
								}
							}
						?>
						<div id="addPagerPoint"></div>
						<div class="pageNum arrowPager" id="nextPatchBtn" onclick="showNextPageBatch('ui_hr/<?=basename($_SERVER['PHP_SELF']); ?>', <?=$showPerPage; ?>, <?=$totPages; ?>);"><i class="fas fa-angle-double-right"></i></div>
					</div>
					<script>
						var thsPage = 'ui_hr/<?=basename($_SERVER['PHP_SELF']); ?>';
						function bindData( response ){
							$('#tableBody').html('');
							var cc = 0;
							for( i=0 ; i < response.length ; i ++ ){
								cc++;
								var status = 'Going to expire';
								if(response[i].color == 'RED'){
									status = 'expired';
								}
								var tr = '' + 
								'<tr id="emp-' + response[i].employee_id + '">' + 
								'	<td> '+ response[i].sNo + '</td>' + 
								'	<td>' + response[i].employee_id + '</td>' + 
								'	<td>' + response[i].employee_code + '</td>' + 
								'	<td>' + response[i].first_name + ' '+ response[i].last_name +'</td>' + 
								'	<td>' + response[i].join_date + '</td>' + 
								'	<td>' + response[i].document_name + '</td>' + 
								'	<td style = "color:'+response[i].color+'""> '+ response[i].expiry_date + '</td>'+
								'	<td style = "color:'+response[i].color+'""> '+ response[i].numberDays + '</td>'+
								'	<td>'+status+'</td>'+
								'</tr>';
								$('#tableBody').append( tr );
								
								
							}
						}
						
						
					</script>
				</div>
				
				
				
				
			</div>
			
			
			<div class="zero"></div>
		</div>
		
		
		
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	<!--    ///////////////////      add_new_modal Modal START    ///////////////////            -->
	<div class="modal" id="add_new_modal">
	
	<div class="modal-container">
	<div class="modal-header">
	<?php include("app/modal_header.php"); ?>
	</div>
	<div class="modal-body">
	
	<form method="post" class="form_class">
	
	ssssssssssssssssssss
	
	
	<div class="form-alerts"></div>
	<div class="zero"></div>
	
	<div class="viewerBodyButtons">
	<button type="button" onclick="submit_form('sss', 'reload_page');">
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
	
	
	<!--    ///////////////////      add_new_employee Modal END    ///////////////////            -->
	
	
	<script>
	
	
	function add_new_modal(){
	var titler = '<?=lang("Add_New_Employee SSS", "AAR"); ?>';
	show_modal( 'add_new_modal' , titler );
	}
	function dateDifference(date1, date2){
	diffDays = date2.getDate() - date1.getDate(); 
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
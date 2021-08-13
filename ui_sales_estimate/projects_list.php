<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 3;
	$subPageID = 31;
?>
<!DOCTYPE html>
<html dir="<?=$lang_dir; ?>" lang="<?=$lang; ?>">
<head>
<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
<script>

function openPdf()
{
var omyFrame = document.getElementById("myFrame");
omyFrame.style.display="block";
omyFrame.src = "1dummy.pdf";
}


</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
</style>
	<?php include('app/meta.php'); ?>
    <?php include('app/assets.php'); ?>
	<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel='stylesheet' href='https://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css'><link rel="stylesheet" href="./style.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
</head>
<body>
<?php
	$WHERE = "requisitions";
	include('app/header.php');
	//PAGE DATA START -----------------------------------------------///---------------------------------
?>



<div class="row">
	<div class="col-100">
	<div class="col-33">
<input id="myInput" type="text" placeholder="Search..">

</div>
<div class="row">
    <div class="panel panel-primary filterable">
      <div class="panel-heading">
        <h3 class="panel-title">Estimate List</h3>
        <div class="pull-right"><button class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filter</button></div>
      </div>
      <table class="table" border="2">

        <thead>
          <tr class="filters">
		  <th><input type="text" class="form-control" placeholder="Sys_Id" disabled></th>
            <th><input type="text" class="form-control" placeholder="Created_Date" disabled></th>
            <th><input type="text" class="form-control" placeholder="Client Name" disabled></th>
            <th><input type="text" class="form-control" placeholder="Status" disabled></th>
          </tr>
        </thead>
		
	<tbody id="myTable">
<?php
	$qu_z_project_sel = "SELECT * FROM  `z_project`";
	$qu_z_project_EXE = mysqli_query($KONN, $qu_z_project_sel);
	if(mysqli_num_rows($qu_z_project_EXE)){
		while($z_project_REC = mysqli_fetch_assoc($qu_z_project_EXE)){
			$project_id = $z_project_REC['project_id'];
			$project_name = $z_project_REC['project_name'];
			$client_id = $z_project_REC['client_id'];
			$created_date = $z_project_REC['created_date'];
			$quotation_id = $z_project_REC['quotation_id'];
			$project_status = $z_project_REC['project_status'];
			
			
	$qu_gen_clients_sel = "SELECT * FROM  `gen_clients` WHERE `client_id` = $client_id";
	$qu_gen_clients_EXE = mysqli_query($KONN, $qu_gen_clients_sel);
	$client_name = "NA";
	if(mysqli_num_rows($qu_gen_clients_EXE)){
		$gen_clients_DATA = mysqli_fetch_assoc($qu_gen_clients_EXE);
		$client_id = $gen_clients_DATA['client_id'];
		$client_name = $gen_clients_DATA['client_name'];
	}
	$project_status_td = '<div class="w3-light-grey"><div class="w3-green" style="height:24px;width:100%"></div></div>Completed';
	
	if($project_status == 'draft'){
		$project_status_td = '<div class="w3-light-grey"><div class="w3-red" style="height:24px;width:50%"></div></div>In Progress';
	}
		?>
					<form action='quotations_new.php'> 

		<tr id="quote-<?=$project_id; ?>">
			<td><?=$project_id; ?></td>
			<td><?=$created_date; ?></td>
			<td><?=$client_name; ?></td>
			<td><?=$project_status_td?></td>
			<td class="text-center">
				<a href="projects_details.php?project_id=<?=$project_id; ?>" title="<?=lang("Project_Details", "AAR"); ?>"><button class="btn" type="button">Details</button></a>
				<a href="projects_estimation.php?project_id=<?=$project_id; ?>" title="<?=lang("Estimation", "AAR"); ?>"><button class="btn" type="button">Estimation</button></a>
				<?php
				if($quotation_id != 0){
					
				?>
				<a href="quotations_details.php?quotation_id=<?= $quotation_id; ?>" title="<?=lang("Quotation", "AAR"); ?>"><button type="button" class="btn"><i class="fa fa-bars"></i> Quotation</button></a>
					<?php
				}
					?>
						<?php
				if($quotation_id == 0){

				?>
			
				<input type='hidden' name='project_id' value='<?= $project_id ?>'>
				<input type='hidden' name='client_id' value='<?= $client_id ?>'>

				<button type="submit" class="btn"><i class="fa fa-folder"></i> Quotation</button>
					<?php
				}
					?>
			</td>
		</tr>
		</form>

		<?php
		}
	} else {
		?>
		<tr id="quote-0">
			<td colspan="8"><?=lang("No Data Found", "AAR"); ?></td>
		</tr>
		<?php
	}
?>
	</tbody>
</table>
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


</script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script><script  src="./script.js"></script>

</body>
</html>
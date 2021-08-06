<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 4;
	$subPageID = 41;
?>
<!DOCTYPE html>
<html dir="<?=$lang_dir; ?>" lang="<?=$lang; ?>">
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
<style>

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
<style>
.styled {
    border: 0;
    line-height: 2.5;
    padding: 0 20px;
    font-size: 1rem;
    text-align: center;
    color: #fff;
    text-shadow: 1px 1px 1px #000;
    border-radius: 10px;
    background-color: rgba(220, 0, 0, 1);
    background-image: linear-gradient(to top left,
                                      rgba(0, 0, 0, .2),
                                      rgba(0, 0, 0, .2) 30%,
                                      rgba(0, 0, 0, 0));
    box-shadow: inset 2px 2px 3px rgba(255, 255, 255, .6),
                inset -2px -2px 3px rgba(0, 0, 0, .6);
}

.styled:hover {
    background-color: rgba(255, 0, 0, 1);
}

.styled:active {
    box-shadow: inset -2px -2px 3px rgba(255, 255, 255, .6),
                inset 2px 2px 3px rgba(0, 0, 0, .6);
}

</style>

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
	<div class="col-33">
<input id="myInput" type="text" placeholder="Search..">

</div>
<table id="dataTable" class="tabler" border="2">
	<thead>
		<tr>
			<th><?=lang("Sys_Id", "AAR"); ?></th>
			<th><?=lang("REF", "AAR"); ?># - <?=lang("REV", "AAR"); ?></th>
			<th><?=lang("RFQ", "AAR"); ?></th>
			<th><?=lang("Date", "AAR"); ?></th>
			<th><?=lang("Token_-_Client_Name", "AAR"); ?></th>
			<th><?=lang("Valid_Until", "AAR"); ?></th>
			<th><?=lang("Status", "AAR"); ?></th>
			<th width="200px"  ><?=lang("convert", "AAR"); ?></th>

			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody id="myTable">
<?php
	$qu_sales_quotations_sel = "SELECT * FROM  `sales_quotations`";
	$qu_sales_quotations_EXE = mysqli_query($KONN, $qu_sales_quotations_sel);
	if(mysqli_num_rows($qu_sales_quotations_EXE)){
		while($sales_quotations_REC = mysqli_fetch_assoc($qu_sales_quotations_EXE)){
			$quotation_id = $sales_quotations_REC['quotation_id'];
			$client_id = $sales_quotations_REC['client_id'];
			$valider_std = $sales_quotations_REC['valid_date'];
			$valider = $sales_quotations_REC['valid_date'];
			$quotation_status = $sales_quotations_REC['quotation_status'];
			$stater = $quotation_status;
			
			$isExpired = false;
			
			
	$qu_gen_clients_sel = "SELECT * FROM  `gen_clients` WHERE `client_id` = $client_id";
	$qu_gen_clients_EXE = mysqli_query($KONN, $qu_gen_clients_sel);
	$client_name = "NA";
	if(mysqli_num_rows($qu_gen_clients_EXE)){
		$gen_clients_DATA = mysqli_fetch_assoc($qu_gen_clients_EXE);
		$client_id = $gen_clients_DATA['client_id'];
		$client_name = $gen_clients_DATA['client_name'];
	}
	
			if($valider_std < date('Y-m-d')){
				$valider = '<span style="color:red;">'.$valider.'</span>';
				$isExpired = false;
				$stater = $quotation_status." - Expired";
			}
			$convert = "<form action='projects_new.php'> 
			<input type='hidden' name='quotation_id' value='$quotation_id'>

			<input class='favorite styled'
			type='submit'
			value='Project'></form>";

		?>
		<tr id="quote-<?=$quotation_id; ?>">
			<td><?=$quotation_id; ?></td>
			<td><?=$sales_quotations_REC["quotation_ref"]; ?> - <?=$sales_quotations_REC["rev_no"]; ?></td>
			<td><?=$sales_quotations_REC["rfq_no"]; ?></td>
			<td><?=$sales_quotations_REC["quotation_date"]; ?></td>
			<td><?=$client_name; ?></td>
			<td><?=$valider; ?></td>
			<td><?=$stater; ?></td>
			<td ><?=$convert; ?></td>

			<td class="text-center">
				<a href="punchlist.php" title="<?=lang("Account Details", "AAR"); ?>"><i class="fas fa-info-circle"></i></a>
			</td>
		</tr>
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
	<div class="zero"></div>
</div>


<?php
	//PAGE DATA END   ----------------------------------------------///---------------------------------
	include('app/footer.php');
?>
</body>
</html>
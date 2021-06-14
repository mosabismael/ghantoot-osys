<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 4;
	$subPageID = 10;
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
	
		<table id="dataTable" class="tabler" border="2">
			<thead>
				<tr>
					<th><?=lang("NO.", "AAR"); ?></th>
					<th><?=lang("Account No", "AAR"); ?></th>
					<th><?=lang("Name", "AAR"); ?></th>
					<th><?=lang("TRN", "AAR"); ?></th>
					<th><?=lang("Phone", "AAR"); ?></th>
					<th><?=lang("email", "AAR"); ?></th>
				</tr>
			</thead>
			<tbody>
<?php
	$sNo = 0;
	$qu_suppliers_list_sel = "SELECT * FROM  `suppliers_list` ORDER BY `supplier_name` ASC";
	$qu_suppliers_list_EXE = mysqli_query($KONN, $qu_suppliers_list_sel);
	if(mysqli_num_rows($qu_suppliers_list_EXE)){
		while($suppliers_list_REC = mysqli_fetch_assoc($qu_suppliers_list_EXE)){
		$sNo++;
		$supplier_id = $suppliers_list_REC['supplier_id'];
		$supplier_code = $suppliers_list_REC['supplier_code'];
		$supplier_name = $suppliers_list_REC['supplier_name'];
		$supplier_type = $suppliers_list_REC['supplier_type'];
		$supplier_cat = $suppliers_list_REC['supplier_cat'];
		$supplier_email = $suppliers_list_REC['supplier_email'];
		$website = $suppliers_list_REC['website'];
		$country = $suppliers_list_REC['country'];
		$address = $suppliers_list_REC['address'];
		$supplier_phone = $suppliers_list_REC['supplier_phone'];
		$trn_no = $suppliers_list_REC['trn_no'];
		
		?>
			<tr id="req-<?=$supplier_id; ?>">
				<td><?=$sNo; ?></td>
				<td><a href="suppliers_edit.php?supplier_id=<?=$supplier_id; ?>" id="reqREF-<?=$supplier_id; ?>" class="text-primary"><?=$supplier_code; ?></a></td>
				<td><?=$supplier_name; ?></td>
				<td><?=$trn_no; ?></td>
				<td><?=$supplier_phone; ?></td>
				<td><?=$supplier_email; ?></td>
			</tr>
		<?php
		}
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

$(document).ready(function(){
  $(".filterSearch").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    var TBL = $(this).attr('tbl-id');
    $("#" + TBL + " tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});


init_nwFormGroup();
</script>

</body>
</html>
<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "Inv Coding";
	
	$menuId = 10;
	$subPageID = 23;
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





<div class="row">
	<div class="col-100">
		
		<table id="dataTable" class="tabler" border="2">
			<thead>
				<tr>
					<th><?=lang("S.NO.", "AAR"); ?></th>
					<th style="width: 50%;"><?=lang("Item", "AAR"); ?></th>
					<th><?=lang("open_date", "AAR"); ?></th>
					<th><?=lang("check_date", "AAR"); ?></th>
					<th><?=lang("close_date", "AAR"); ?></th>
				</tr>
			</thead>
			<tbody>
<?php
	$sNo = 0;
	$qu_punch_list_sel = "SELECT * FROM  `punch_list` WHERE `punch_status` = 'close' ";
	$qu_punch_list_EXE = mysqli_query($KONN, $qu_punch_list_sel);
	if(mysqli_num_rows($qu_punch_list_EXE)){
		while($punch_list_REC = mysqli_fetch_assoc($qu_punch_list_EXE)){
			$sNo++;
		$punch_id = $punch_list_REC['punch_id'];
		$punch_txt = $punch_list_REC['punch_txt'];
		$punch_status = $punch_list_REC['punch_status'];
		$open_date = $punch_list_REC['open_date'];
		$check_date = $punch_list_REC['check_date'];
		$close_date = $punch_list_REC['close_date'];
		
		
		?>
			<tr id="boxdata-<?=$punch_id; ?>">
				<td><?=$sNo; ?></td>
				<td style="text-align:left;"><?=$punch_txt; ?></td>
				<td><?=$open_date; ?></td>
				<td><?=$check_date; ?></td>
				<td><?=$close_date; ?></td>
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
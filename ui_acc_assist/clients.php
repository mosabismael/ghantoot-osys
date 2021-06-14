<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 5;
	$subPageID = 15;
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
		
<a href="clients_new.php" class="actionBtn"><button type="button"><i class="fas fa-plus"></i><?=lang("Add_New", "AAR"); ?></button></a>
<br>

<table id="dataTable" class="tabler" border="2">
	<thead>
		<tr>
			<th><?=lang("Sys_Id", "AAR"); ?></th>
			<th style="width: 40%;"><?=lang("Name", "AAR"); ?></th>
			<th><?=lang("Account No.", "AAR"); ?></th>
			<th><?=lang("Address", "AAR"); ?></th>
		</tr>
	</thead>
	<tbody>
<?php
	$qu_gen_clients_sel = "SELECT * FROM  `gen_clients`";
	$qu_gen_clients_EXE = mysqli_query($KONN, $qu_gen_clients_sel);
	if(mysqli_num_rows($qu_gen_clients_EXE)){
		while($gen_clients_REC = mysqli_fetch_assoc($qu_gen_clients_EXE)){
			$client_id  = ( int ) $gen_clients_REC['client_id'];
			$city_id    = ( int ) $gen_clients_REC['city'];
			$country_id = ( int ) $gen_clients_REC['country'];
			
			$city_name = $country_name = 'NA';
			if( $city_id != '' || $city_id != '0'){
				$qu_gen_countries_cities_sel = "SELECT * FROM  `gen_countries_cities` WHERE `city_id` = $city_id";
				$qu_gen_countries_cities_EXE = mysqli_query($KONN, $qu_gen_countries_cities_sel);
				$gen_countries_cities_DATA;
				if(mysqli_num_rows($qu_gen_countries_cities_EXE)){
					$gen_countries_cities_DATA = mysqli_fetch_assoc($qu_gen_countries_cities_EXE);
				}
				$city_name = $gen_countries_cities_DATA['city_name'];

			}
			
			
			if( $country_id != '' || $country_id != '0'){
				$qu_gen_countries_sel = "SELECT * FROM  `gen_countries` WHERE `country_id` = $country_id";
				$qu_gen_countries_EXE = mysqli_query($KONN, $qu_gen_countries_sel);
				$gen_countries_DATA;
				if(mysqli_num_rows($qu_gen_countries_EXE)){
					$gen_countries_DATA = mysqli_fetch_assoc($qu_gen_countries_EXE);
				}
				$country_name = $gen_countries_DATA['country_name'];
			}
		?>
		<tr id="emp-<?=$gen_clients_REC["client_id"]; ?>">
			<td><?=$client_id; ?></td>
<td><a href="clients_edit.php?client_id=<?=$client_id; ?>" id="reqREF-<?=$client_id; ?>" class="text-primary"><?=$gen_clients_REC["client_name"]; ?></a></td>
			<td><?=$gen_clients_REC["client_code"]; ?></td>
			<td><?=$city_name.' - '.$country_name; ?></td>
		</tr>
		<?php
		}
	} else {
		?>
		<tr id="emp-<?=$gen_clients_REC["client_id"]; ?>">
			<td colspan="5"><?=lang("No Data Found", "AAR"); ?></td>
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
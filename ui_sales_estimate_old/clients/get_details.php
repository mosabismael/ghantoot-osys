<?php

if( !isset( $loadData ) ){
	
	
	
	$qu_gen_clients_sel = "SELECT * FROM  `gen_clients` WHERE `client_id` = $client_id";
	$qu_gen_clients_EXE = mysqli_query($KONN, $qu_gen_clients_sel);
	$gen_clients_DATA;
	if(mysqli_num_rows($qu_gen_clients_EXE)){
		$gen_clients_DATA = mysqli_fetch_assoc($qu_gen_clients_EXE);
	}
	
		$client_code = $gen_clients_DATA['client_code'];
		$client_name = $gen_clients_DATA['client_name'];
		$client_category = $gen_clients_DATA['client_category'];
		$website = $gen_clients_DATA['website'];
		$phone = $gen_clients_DATA['phone'];
		$email = $gen_clients_DATA['email'];
		$city_id = $gen_clients_DATA['city'];
		$country_id = $gen_clients_DATA['country'];
		$address = $gen_clients_DATA['address'];
		$trn_no = $gen_clients_DATA['trn_no'];
		$is_deleted = $gen_clients_DATA['is_deleted'];
	
	

	$qu_gen_countries_cities_sel = "SELECT * FROM  `gen_countries_cities` WHERE `city_id` = $city_id";
	$qu_gen_countries_cities_EXE = mysqli_query($KONN, $qu_gen_countries_cities_sel);
	$gen_countries_cities_DATA;
	if(mysqli_num_rows($qu_gen_countries_cities_EXE)){
		$gen_countries_cities_DATA = mysqli_fetch_assoc($qu_gen_countries_cities_EXE);
	}
	$city_name = $gen_countries_cities_DATA['city_name'];
	
	
	$qu_gen_countries_sel = "SELECT * FROM  `gen_countries` WHERE `country_id` = $country_id";
	$qu_gen_countries_EXE = mysqli_query($KONN, $qu_gen_countries_sel);
	$gen_countries_DATA;
	if(mysqli_num_rows($qu_gen_countries_EXE)){
		$gen_countries_DATA = mysqli_fetch_assoc($qu_gen_countries_EXE);
	}
	$country_name = $gen_countries_DATA['country_name'];

}
?>
	<div class="info-cell">
		<span><?=lang("Account_NO.", "AAR"); ?></span>
		<p><?=$client_id.' - '.$client_code; ?></p>
	</div>
	<div class="info-cell">
		<span><?=lang("Client_Name", "AAR"); ?></span>
		<p><?=$client_name; ?></p>
	</div>
	<div class="info-cell">
		<span><?=lang("client_category", "AAR"); ?></span>
		<p><?=$client_category; ?></p>
	</div>
	<div class="info-cell">
		<span><?=lang("website", "AAR"); ?></span>
		<p><?=$website; ?></p>
	</div>
	<div class="info-cell">
		<span><?=lang("phone", "AAR"); ?></span>
		<p><?=$phone; ?></p>
	</div>
	<div class="info-cell">
		<span><?=lang("email", "AAR"); ?></span>
		<p><?=$email; ?></p>
	</div>
	<div class="info-cell">
		<span><?=lang("trn_no", "AAR"); ?></span>
		<p><?=$trn_no; ?></p>
	</div>
	<div class="info-cell">
		<span>&nbsp;</span>
		<p>&nbsp;</p>
	</div>
	<div class="info-cell">
		<span>&nbsp;</span>
		<p>&nbsp;</p>
	</div>
	
	<script>
	$('#client-namer').html('<?=$client_code; ?> - <?=strtoupper( $client_name ); ?>');
	</script>
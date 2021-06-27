
<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
    $menuId = 2;
	$subPageID = 20;
	
	

	
	$client_id = 0;
	$client_name = "";
	if( isset( $_GET['client_id'] ) ){
		$client_id = (int) test_inputs( $_GET['client_id'] );
	}
	
	
	
	
	if( $client_id != 0 ){
		//load client name
		$qu_gen_clients_sel = "SELECT `client_name` FROM  `gen_clients` WHERE `client_id` = $client_id";
		$qu_gen_clients_EXE = mysqli_query($KONN, $qu_gen_clients_sel);
		$gen_clients_DATA;
		if(mysqli_num_rows($qu_gen_clients_EXE)){
			$gen_clients_DATA = mysqli_fetch_assoc($qu_gen_clients_EXE);
			$client_name = $gen_clients_DATA['client_name'];
		}
	}
	
	
	
?>
<!DOCTYPE html>
<html dir="<?=$lang_dir; ?>" lang="<?=$lang; ?>">

<head>
    <?php include('app/meta.php'); ?>
    <?php include('app/assets.php'); ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>


input[type=text], select, textarea {
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

<h2>Enquiry Form</h2>
<p>Complete this Enquiry Form to obtain additional information about our services or send personal complaints. We will analyze your enquiry and return to you shortly by email or phone.</p>
<div class="container">
  <form action="/action_page.php">
    <label for="fname">Client Name</label>
    <input class="frmData" type="text" 
					id="new-client_name" 
					name="client_name" 
					list="clients-data"
					value="<?=$client_name; ?>"
					req="1" 
					den="" 
					placeholder="<?=lang('Type Client Name to Select'); ?>" 
					alerter="<?=lang("Please_Check_client_name", "AAR"); ?>">
		<datalist id="clients-data">
<?php
$q = "SELECT `client_name` FROM `gen_clients`";
$q_exe = mysqli_query($KONN, $q);
if(mysqli_num_rows($q_exe) > 0){
	while($record = mysqli_fetch_assoc($q_exe)){
?>
<option><?=$record['client_name']; ?></option>
<?php
		}
	}
?>
		</datalist>
    <!-- <label for="lname">Last Name</label>
    <input type="text" id="lname" name="lastname" placeholder="Your last name.."> -->
    <h4>
    Please be specific of the enquiry you want to submit in this Enquiry Form, so we can return to you fast with the information you are looking for. Thank you!
    </h4>
    <br>
    <label for="enquiry">Enquiry type</label>
    <select id="enquiry" name="enquiry">
      <option value="pricing_levels">Pricing levels</option>
      <option value="maintenance">Maintenance</option>
      <option value="testing">Testing</option>
      <option value="complaints">Complaints</option>

    </select>
    <label for="date">Date</label>
    <input type="date" id="date" name="date">
    <label for="details">Details</label>
    <textarea id="details" name="details" placeholder="Detail your enquiry here..." style="height:200px"></textarea>
    <div class="btns-holder">
	<button class="btn btn-primary" type="button" onClick="set_tabber(1);"><?=lang('cancel'); ?></button>
	<button class="btn btn-primary" type="button" onClick=""><?=lang('SEND ENQUIRY'); ?></button>
</div>
  </form>
</div>
<?php
	//PAGE DATA END   ----------------------------------------------///---------------------------------
	include('app/footer.php');
?>
</body>
</html>

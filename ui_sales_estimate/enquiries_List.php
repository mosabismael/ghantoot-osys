
<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
    $menuId = 2;
	$subPageID = 21;
	
	

	
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

<div class="row">
	<div class="col-100">
	
<table id="dataTable" class="tabler" border="2">
	<thead>
		<tr>
			<th><?=lang("Sys_Id", "AAR"); ?></th>
			<th><?=lang("Enquiry Type", "AAR"); ?></th>
			<th><?=lang("Date", "AAR"); ?></th>
			<th><?=lang("Details", "AAR"); ?></th>
			<th><?=lang("Client Name", "AAR"); ?></th>
			<th><?=lang("Status", "AAR"); ?></th>
		</tr>
	</thead>
	<tbody>
<?php
	$qu_enquiries_sel = "SELECT * FROM  `enquiries`";
	$qu_enquiries_EXE = mysqli_query($KONN, $qu_enquiries_sel);
	if(mysqli_num_rows($qu_enquiries_EXE)){
		while($enquiries_REC = mysqli_fetch_assoc($qu_enquiries_EXE)){
			$enquiry_id  = $enquiries_REC['enquiry_id'];
			$client_id = $enquiries_REC['client_id'];
			$date = $enquiries_REC['date'];
			$enquiry_type = $enquiries_REC['enquiry_type'];
			$details = $enquiries_REC['details'];
			
			$isExpired = false;
			
			
	$qu_gen_clients_sel = "SELECT * FROM  `gen_clients` WHERE `client_id` = $client_id";
	$qu_gen_clients_EXE = mysqli_query($KONN, $qu_gen_clients_sel);
	$client_name = "NA";
	if(mysqli_num_rows($qu_gen_clients_EXE)){
		$gen_clients_DATA = mysqli_fetch_assoc($qu_gen_clients_EXE);
		$client_id = $gen_clients_DATA['client_id'];
		$client_name = $gen_clients_DATA['client_name'];
	}
	
			$convert = "<form action='projects_new.php'> 
			<input type='hidden' name='user' value='$client_name'>

			<input class='favorite styled'
			type='submit'
			value='Estimation >>  '></form>";

		?>
		<tr id="quote-<?=$enquiry_id; ?>">
			<td><?=$enquiry_id; ?></td>
			<td><?=$enquiries_REC["enquiry_type"]; ?></td>
			<td><?=$enquiries_REC["date"]; ?></td>
			<td><?=$client_name; ?></td>
			<td><?=$enquiries_REC["details"]; ?></td>
			<td></td>
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

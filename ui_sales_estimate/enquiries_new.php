
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
  
  <div class="row">


<form 
id="add-new-enquiries-form" 
id-modal="add_new_enquiries" 
class="boxes-holder" 
api="<?=api_root; ?>sales_projects/add_new_enquiries.php">
<div class="col-33">

<div class="form-grp">
	<label class="lbl_class"><?=lang('To_Client:', 'ARR', 1); ?></label>
<select class="frmData" type="text" 
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
$q = "SELECT `client_name`,`client_id` FROM `gen_clients`";
$q_exe = mysqli_query($KONN, $q);
if(mysqli_num_rows($q_exe) > 0){
while($record = mysqli_fetch_assoc($q_exe)){
?>
<option value="<?=$record['client_id']; ?>"><?=$record['client_name']; ?></option>
<?php
	}
}
?>
	</datalist>
</select>
</div>
</div>
<div class="col-33">
	<div class="form-grp">
	<label class="lbl_class"><?=lang('Attn:', 'ARR', 1); ?></label>
		<input class="frmData" type="text" 
				id="new-attn_name" 
				name="attn_name" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_attn_name", "AAR"); ?>" required>
	</div>
	</div>
<div class="col-30">
	<div class="form-grp">
		<label class="lbl_class"><?=lang('Date', 'ARR', 1); ?></label>
		<input class="frmData" type="date"
				id="new-date" 
				name="date" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_date", "AAR"); ?>" required>

			</input>
	</div>

</div>

<div class="zero"></div>
<div class="col-33">
	<div class="form-grp">
	<label class="lbl_class"><?=lang('Subject:', 'ARR', 1); ?></label>
		<input class="frmData" type="text" 
				id="new-subject" 
				placeholder="Title here..."
				name="subject_name" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_subject_name", "AAR"); ?>" required>
	</div>
	</div>
	<div class="col-100">
	<div class="form-grp">
		<label class="lbl_class"><?=lang('Details', 'ARR', 1); ?></label>
		<textarea class="frmData" type="text" 
        placeholder="Detail your enquiry here..."
				id="new-details" 
				name="details"
				req="1" 
				den="" 
        style="height:200px"
				alerter="<?=lang("Please_Check_details", "AAR"); ?> " required></textarea>
				
	</div>
	<div class="form-grp">

	<label for="attachments">Choose a attachments:</label>
	<input type="file" title="Type search term here" name="pdf_file"  accept=".pdf,.docx,.xls,.csv" multiple required/>
            <input type="hidden" name="MAX_FILE_SIZE" value="67108864"/> <!--64 MB's worth in bytes-->

		
</div>
</div>

<div class="col-100">
	<div class="form-grp">
		<label class="lbl_class"><?=lang('Enquiry type', 'ARR', 1); ?></label>
		<select class="frmData" type="text" 
				id="new-enquiry_type" 
				name="enquiry_type" 
				alerter="<?=lang("Please_Check_enquiry_type", "AAR"); ?>">
        <option value="pricing_levels">Pricing levels</option>
      <option value="maintenance">Maintenance</option>
      <option value="testing">Testing</option>
      <option value="complaints">Complaints</option>
      </select>

	</div>
</div>


	<div class="zero"></div>
	
<div class="col-100 text-center" id="add_new_enquiries">
		<!-- <div class="form-alerts"></div> -->
<a  href="enquiries_List.php"><button class="btn btn-primary" type="button" onClick="enquiries_List.php"><?=lang('cancel'); ?></button></a>
    <button type="submit"  onclick="submit_form('add-new-enquiries-form', 'forward_page');" class="btn btn-primary"><?=lang("CREATE_ENQUIRY", "AAR"); ?></button>
		
</div>

</form>
</div>
<?php
	//PAGE DATA END   ----------------------------------------------///---------------------------------
	include('app/footer.php');
?>
</body>
</html>

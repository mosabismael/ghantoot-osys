
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
	
	
	if(
	isset($_POST['client_name']) &&
	isset($_POST['enquiry_type']) &&
	isset($_POST['date']) &&
	isset($_POST['subject_name']) &&
	isset($_POST['details']) &&
	isset($_POST['attn_name'])){		
		$enquiry_id = 0;
		$client_name = test_inputs($_POST['client_name']);
		$enquiry = test_inputs($_POST['enquiry_type']);
		$date = test_inputs($_POST['date']);
		$details = test_inputs($_POST['details']);
		$subject = test_inputs($_POST['subject_name']);
		$attn = test_inputs($_POST['attn_name']);
		
		
		
		
		
		
		$qu_gen_enquiry_ins = "INSERT INTO `enquiries` (
		`client_id`, 
		`enquiry_type`, 
		`date`, 
		`subject`,
		`attn`,
		`details`,
		`attachment`
		) VALUES (
		'".$client_name."', 
		'".$enquiry."', 
		'".$date."', 
		'".$subject."',
		'".$attn."',
		'".$details."',
		''
		);";
		
		$insertStatement = mysqli_prepare($KONN,$qu_gen_enquiry_ins);
		
		mysqli_stmt_execute($insertStatement);
		
		$enquiry_id = mysqli_insert_id($KONN);
		if( $enquiry_id != 0 ){
			
			$files = array_filter($_FILES['customFile']['name']); //something like that to be used before processing files.
			
			// Count # of uploaded files in array
			$total = count($_FILES['customFile']['name']);
			//echo $total;
			// Loop through each file
			for( $i=0 ; $i < $total ; $i++ ) {
				
				//Get the temp file path
				$tmpFilePath = $_FILES['customFile']['tmp_name'][$i];
				
				//Make sure we have a file path
				if ($tmpFilePath != ""){
					//Setup our new file path
					move_uploaded_file($_FILES["customFile"]["tmp_name"][$i],
					"fileupload/" . $_FILES["customFile"]["name"][$i]);
					$qu_gen_enquiry_ins = "INSERT INTO `enquiry_attachment` (
					`enquiry_id`, 
					`attachment_tite`, 
					`attachment`
					) VALUES (
					'".$enquiry_id."', 
					'".$files[$i]."', 
					'".$files[$i]."'
					);";
					//echo $qu_gen_enquiry_ins;
					$insertStatement = mysqli_prepare($KONN,$qu_gen_enquiry_ins);
					
					mysqli_stmt_execute($insertStatement);
				}
			}
		//	die();
			
			if( insert_state_change($KONN, 'Enquiries_added', $enquiry_id, "enquiries", $EMPLOYEE_ID) ){
				header("location: enquiries_List.php");
				die();
			}
			
			
			
		}	
	}
	
	
	
?>
<!DOCTYPE html>
<html dir="<?=$lang_dir; ?>" lang="<?=$lang; ?>">
<<<<<<< HEAD

<head>
<meta charset="UTF-8">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.css'><link rel="stylesheet" href="./style.css">

    <?php include('app/meta.php'); ?>
    <?php include('app/assets.php'); ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>


h1 {
  font-size: 20px;
  margin-bottom: 20px;
  color: #fff;
}

.wrap {
  width: 50%;
  margin: auto;
  position: -webkit-sticky;
  position: sticky;
  left: 50%;
  transform: translate(-50%);
  border-radius: 4px;
  background-color: #2e4261;
  box-shadow: 0 1px 2px 0 #c9ced1;
  padding: 1.25rem;
  margin-bottom: 1.25rem;
  
}

.file {
  position: relative;
  max-width: 22.5rem;
  font-size: 1.0625rem;
  font-weight: 600;
}
.file__input, .file__value {
  background-color: rgba(255, 255, 255, 0.1);
  border-radius: 3px;
  margin-bottom: 0.875rem;
  color: rgba(255, 255, 255, 0.3);
  padding: 0.9375rem 1.0625rem;
}
.file__input--file {
  position: absolute;
  opacity: 0;
}
.file__input--label {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 0;
  cursor: pointer;
}
.file__input--label:after {
  content: attr(data-text-btn);
  border-radius: 3px;
  background-color: #536480;
  box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.18);
  padding: 0.9375rem 1.0625rem;
  margin: -0.9375rem -1.0625rem;
  color: white;
  cursor: pointer;
}
.file__value {
  display: flex;
  justify-content: space-between;
  align-items: center;
  color: rgba(255, 255, 255, 0.6);
}
.file__value:hover:after {
  color: white;
}
.file__value:after {
  content: "X";
  cursor: pointer;
}
.file__value:after:hover {
  color: white;
}
.file__remove {
  display: block;
  width: 20px;
  height: 20px;
  border: 1px solid #000;
}
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
.box {
  box-shadow:
  0 2.8px 2.2px rgba(0, 0, 0, 0.034),
  0 6.7px 5.3px rgba(0, 0, 0, 0.048),
  0 12.5px 10px rgba(0, 0, 0, 0.06),
  0 22.3px 17.9px rgba(0, 0, 0, 0.072),
  0 41.8px 33.4px rgba(0, 0, 0, 0.086),
  0 100px 80px rgba(0, 0, 0, 0.12)
;

  
  
  min-height: 200px;
  width: 60vw;
  margin: 100px auto;
  background: white;
  border-radius: 5px;
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
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>

<script>

$(document).ready(function() {
	 
	 // ------------  File upload BEGIN ------------
	 $('.file__input--file').on('change',function(event){
		 var files = event.target.files;
		 for (var i = 0; i < files.length; i++) {
			 var file = files[i];

			 $("<div class='file__value'><div class='file__value--text'>" + file.name + "</div><div class='file__value--remove' data-id='" + file.name + "' ></div></div><input type='text' 	placeholder='title...' id='fname' name='fname'>").insertAfter('#file__input');
		 }	
	 });
	 //Click to remove item
	 $('body').on('click', '.file__value', function() {
		 $(this).remove();
	 });
	 // ------------ File upload END ------------ 
	 
	 
	 
 });</script>

<?php

	$WHERE = "";
	include('app/header.php');
	//PAGE DATA START -----------------------------------------------///---------------------------------
?>
<h2>Enquiry Form</h2>
<p>Complete this Enquiry Form to obtain additional information about our services or send personal complaints. We will analyze your enquiry and return to you shortly by email or phone.</p>
<div class="box">

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
  <div class="col-33">
	<div class="form-grp">
	<label class="lbl_class"><?=lang('Budget:', 'ARR', 1); ?></label>
		<input class="frmData" type="number" 
				id="new-budget" 
				placeholder="budget"
				name="budget" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_budget", "AAR"); ?>" required>
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
	
	<div class="wrap">
  <h1>File upload multiple</h1>
  <h1>Choose a attachments</h1>
  <form action="#" name="form" method="get">
    <div class="file">
      <div class="file__input" id="file__input">
        <input class="file__input--file" id="customFile" type="file"  multiple="multiple" name="files[]"/>
        <label class="file__input--label" for="customFile" data-text-btn="Upload">Add file:</label>
      </div>
    </div>
  </form>
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
=======
>>>>>>> 04b4f9da6ba8c4293bc5e8e3e472698292bc1013
	
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
		<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>
		<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.css'><link rel="stylesheet" href="./style.css">
		
		<?php include('app/meta.php'); ?>
		<?php include('app/assets.php'); ?>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<style>
			
			
			h1 {
			font-size: 20px;
			margin-bottom: 20px;
			color: #fff;
			}
			
			.wrap {
			width: 500px;
			margin: auto;
			position: -webkit-sticky;
			position: sticky;
			left: 50%;
			transform: translate(-50%);
			border-radius: 4px;
			background-color: #2e4261;
			box-shadow: 0 1px 2px 0 #c9ced1;
			padding: 1.25rem;
			margin-bottom: 1.25rem;
			
			}
			
			.file {
			position: relative;
			max-width: 22.5rem;
			font-size: 1.0625rem;
			font-weight: 600;
			}
			.file__input, .file__value {
			background-color: rgba(255, 255, 255, 0.1);
			border-radius: 3px;
			margin-bottom: 0.875rem;
			color: rgba(255, 255, 255, 0.3);
			padding: 0.9375rem 1.0625rem;
			}
			.file__input--file {
			position: absolute;
			opacity: 0;
			}
			.file__input--label {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 0;
			cursor: pointer;
			}
			.file__input--label:after {
			content: attr(data-text-btn);
			border-radius: 3px;
			background-color: #536480;
			box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.18);
			padding: 0.9375rem 1.0625rem;
			margin: -0.9375rem -1.0625rem;
			color: white;
			cursor: pointer;
			}
			.file__value {
			display: flex;
			justify-content: space-between;
			align-items: center;
			color: rgba(255, 255, 255, 0.6);
			}
			.file__value:hover:after {
			color: white;
			}
			.file__value:after {
			content: "X";
			cursor: pointer;
			}
			.file__value:after:hover {
			color: white;
			}
			.file__remove {
			display: block;
			width: 20px;
			height: 20px;
			border: 1px solid #000;
			}
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
			.box {
			box-shadow:
			0 2.8px 2.2px rgba(0, 0, 0, 0.034),
			0 6.7px 5.3px rgba(0, 0, 0, 0.048),
			0 12.5px 10px rgba(0, 0, 0, 0.06),
			0 22.3px 17.9px rgba(0, 0, 0, 0.072),
			0 41.8px 33.4px rgba(0, 0, 0, 0.086),
			0 100px 80px rgba(0, 0, 0, 0.12)
			;
			
			
			
			min-height: 200px;
			width: 60vw;
			margin: 100px auto;
			background: white;
			border-radius: 5px;
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
		<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
		
		<script>
			
			$(document).ready(function() {
			
			// ------------  File upload BEGIN ------------
			$('.file__input--file').on('change',function(event){
			var files = event.target.files;
			for (var i = 0; i < files.length; i++) {
			var file = files[i];
      $("<div class='file__value'><div class='file__value--text'>" + file.name + "</div><div class='file__value--remove' data-id='" + file.name + "' ></div></div><div><input type='text' placeholder='Tite...' id='attachment_tite' name='attachment_tite'></div>").insertAfter('#file__input');

			}	
			});
			//Click to remove item
			$('body').on('click', '.file__value', function() {
			$(this).remove();
			});
			// ------------ File upload END ------------ 
			
			
			
		});</script>
		
		<?php
			
			$WHERE = "";
			include('app/header.php');
			//PAGE DATA START -----------------------------------------------///---------------------------------
		?>
		<h2>Enquiry Form</h2>
		<p>Complete this Enquiry Form to obtain additional information about our services or send personal complaints. We will analyze your enquiry and return to you shortly by email or phone.</p>
		<div class="box">
			
			<div class="row">
				
				
				<form 
				id="add-new-enquiries-form" 
				id-modal="add_new_enquiries" 
				class="boxes-holder" 
				api="<?=api_root; ?>sales_projects/add_new_enquiries.php"  method="post" enctype="multipart/form-data" >
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
					<div class="col-33">
						<div class="form-grp">
							<label class="lbl_class"><?=lang('Budget:', 'ARR', 1); ?></label>
							<input class="frmData" type="number" 
							id="new-budget" 
							placeholder="budget"
							name="budget" 
							req="1" 
							den="" 
							alerter="<?=lang("Please_Check_budget", "AAR"); ?>" required>
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
						
						<div class="wrap">
							<h1>File upload multiple</h1>
							<h1>Choose a attachments</h1>
							<div class="file form-grp">
								<div class="file__input form-grp" id="file__input">
									<input class="file__input--file frmData" id = "customFile" name="customFile[]" type="file" multiple="multiple" />
									<label class="file__input--label" for="customFile" data-text-btn="Upload">Add file:</label>
								</div>
							</div>
							
						</div>
						
						<div class="col-100">
							<div class="form-grp">
								<label class="lbl_class"><?=lang('Enquiry type', 'ARR', 1); ?></label>
								<select class="frmData" type="text" 
								id="new-enquiry_type" 
								name="enquiry_type" 
								alerter="<?=lang("Please_Check_enquiry_type", "AAR"); ?>">
									<option value="pricing levels">Pricing levels</option>
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
							<button type="submit"  class="btn btn-primary"><?=lang("CREATE_ENQUIRY", "AAR"); ?></button>
							
						</div>
						
					</form>
				</div>
			</div>
			
			<?php
				//PAGE DATA END   ----------------------------------------------///---------------------------------
				include('app/footer.php');
			?>
		</body>
	</html>

<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 4;
	$subPageID = 40;
	
	

	
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
</head>
<body>
<?php

	$WHERE = "";
	include('app/header.php');
	
	//PAGE DATA START -----------------------------------------------///---------------------------------
?>



<div class="row">
<?php
$project_id = $_GET['project_id'];
$get_client_id = $_GET['client_id'];

?>
<form 
id="new-quotation-form" 
id-modal="add_new_quotation_modal" 
api="<?=api_root; ?>sales/quotations/add_new.php">

<div class="row">
	<div class="col-100">
	
		<div class="form-grp">
			<label><?=lang('Client_Name'); ?></label>
			<select class="frmData" type="text" 
					id="new-client_name" 
					name="client_name" 
					list="clients-data"
					value="4"
					req="1" 
					den="" 
					placeholder="<?=lang('Type Client Name to Select'); ?>" 
					alerter="<?=lang("Please_Check_client_name", "AAR"); ?>">
					<option value = "<?=$client_name; ?>" selected><?= $client_name; ?></option>


					<span class="noter" id="clien_load_res">* <?=lang('fill client name to load information'); ?></span>
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
</select>
		</datalist>
		</div>
	</div>
	
	
	
</div>
	
	
<div class="row">
	<div class="col-100" id="add_new_quotation_modal">
		<div class="form-alerts" style="width: 50%;margin: 0 auto;text-align: left;"></div>
	</div>
</div>
	
	
	
	
<div class="row">
	<div class="col-100">
		<div class="tabber">
			<ul class="tabber-header">
				<li id="sel-1" onclick="set_tabber(1);" class="active"><?=lang("general", "AAR"); ?></li>
				<li id="sel-2" onclick="set_tabber(2);"><?=lang("contacts", "AAR"); ?></li>
				<li id="sel-3" onclick="set_tabber(3);"><?=lang("items", "AAR"); ?></li>
				<li id="sel-4" onclick="set_tabber(4);"><?=lang("extra_details", "AAR"); ?></li>
			</ul>
			
			<div class="tabber-body">

			<input class="frmData" type="hidden" 
					id="new-client_id" 
					name="client_id" 
					req="1" 
					den="0" 
					value="0"
					alerter="<?=lang("Please_Check_Client_Name", "AAR"); ?>">


<div class="tabber-1 tabber-content tabber-active">
<?php
	include('quot_new/general.php');
?>
</div>

<div class="tabber-2 tabber-content">
<?php
	include('quot_new/contacts.php');
?>
</div>

<div class="tabber-3 tabber-content">
<?php
	include('quot_new/items.php');
?>
</div>

<div class="tabber-4 tabber-content">
<?php
	include('quot_new/extra_details.php');
?>
</div>


			</div>
			
		</div>
		
	</div>
	
	
	<div class="zero"></div>
</div>

<script>

function loadClient(){
	var client_name = $('#new-client_name').val().trim();
	if(client_name != ''){
		
		$.ajax({
		url      :"<?=api_root; ?>/clients/get_client_info.php",
		data     :{'client_name': client_name, 'operation': 1},
		dataType :"JSON",
		type     :'POST',
		success  :function(response){
				var client_id = response[0].client_id;
				var client_name = response[0].client_name;
				var payment_term_id = response[0].payment_term_id;
				payment_term_id = parseInt(payment_term_id);
				$('#payment_term_id').val(payment_term_id);
				
				$('#new-client_id').val(client_id);
				console.log(response);

				// $('#new-client_name').val(client_name);
				if(client_id != '0'){
					$('#clien_load_res').html('<span style="color:green;">Client Information Loaded</span>');
					isClientSelected = true;
					load_contacts();
				} else {
					isClientSelected = false;
					$('#clien_load_res').html('<span style="color:red;">Client Information ERROR</span>');
				}
				if(payment_term_id == 0 && client_id != '0'){
					alert('PLEASE UPDATE CLIENTS PAYMENT TERMS AT ACCOUNTING DEPARTMENT');
					isClientSelected = false;
					$('#clien_load_res').html('<span style="color:red;">Client Information ERROR, UPDATE PAYMENT TERM</span>');
				}
			},
		error    :function(){
			alert('Data Error No: 5467653');
			isClientSelected = false;
			},
		});
	}
}

$("#new-client_name").on('input',function(){
	loadClient();

});




function load_contacts(){
	var dd = parseInt($('#new-client_id').val());
	if(dd != 0){
		$('#added_contacts').html('LOADING DATA...');
		$.ajax({
		url      :"../app_api/clients/get_client_contacts.php",
		data     :{'client_id': dd, 'operation': 1},
		dataType :"html",
		type     :'POST',
		success  :function(data){
			$('#added_contacts').html(data);
			fix_cont_counters();
			},
		error    :function(){
			alert('Data Error No: 5467653');
			},
		});
				
	} else {
		
	}
}
function fix_cont_counters(){
	var cc = 0;
	$('.contacts_count').each(function(){
		cc++;
		$(this).html(cc);
	});
}
</script>










	<div class="zero"></div>
	
	<div class="zero"></div>

</form>

	<div class="zero"></div>
</div>


<?php
	//PAGE DATA END   ----------------------------------------------///---------------------------------
	include('app/footer.php');
?>







<script>
function set_tabber(tID){
	$('.tabber-header .active').removeClass('active');
	$('.tabber-body .tabber-active').removeClass('tabber-active');
	
	$('.tabber-header #sel-' + tID).addClass('active');
	$('.tabber-body .tabber-' + tID).addClass('tabber-active');
	
	
	
}
</script>








</body>
</html>
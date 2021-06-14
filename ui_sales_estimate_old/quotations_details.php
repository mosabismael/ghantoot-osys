<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 2;
	$subPageID = 21;
	
	
	$quotation_id = 0;
	if( !isset( $_GET['quotation_id'] ) ){
		header("location:sales_quotations.php");
	} else {
		$quotation_id = (int) test_inputs( $_GET['quotation_id'] );
	}
	
	
	$qu_sales_quotations_sel = "SELECT * FROM  `sales_quotations` WHERE `quotation_id` = $quotation_id";
	$qu_sales_quotations_EXE = mysqli_query($KONN, $qu_sales_quotations_sel);
	$sales_quotations_DATA;
	if(mysqli_num_rows($qu_sales_quotations_EXE)){
		$sales_quotations_DATA = mysqli_fetch_assoc($qu_sales_quotations_EXE);
	}
	
		$quotation_ref = $sales_quotations_DATA['quotation_ref'];
		$rev_no = $sales_quotations_DATA['rev_no'];
		$rfq_no = $sales_quotations_DATA['rfq_no'];
		$quotation_date = $sales_quotations_DATA['quotation_date'];
		$payment_term_id = $sales_quotations_DATA['payment_term_id'];
		$currency_id = $sales_quotations_DATA['currency_id'];
		$delivery_period_id = $sales_quotations_DATA['delivery_period_id'];
		$delivery_method = $sales_quotations_DATA['delivery_method'];
		$quotation_notes = $sales_quotations_DATA['quotation_notes'];
		$valid_until = $sales_quotations_DATA['valid_until'];
		$valid_date = $sales_quotations_DATA['valid_date'];
		$pak_tr_amount = $sales_quotations_DATA['pak_tr_amount'];
		$coo_amount = $sales_quotations_DATA['coo_amount'];
		$discount_amount = $sales_quotations_DATA['discount_amount'];
		$is_vat_included = $sales_quotations_DATA['is_vat_included'];
		$client_id = $sales_quotations_DATA['client_id'];
		$employee_id = $sales_quotations_DATA['employee_id'];
		$quotation_status = $sales_quotations_DATA['quotation_status'];
	
	

	
	
	$qu_gen_payment_terms_sel = "SELECT * FROM  `gen_payment_terms` WHERE `payment_term_id` = $payment_term_id";
	$qu_gen_payment_terms_EXE = mysqli_query($KONN, $qu_gen_payment_terms_sel);
	$gen_payment_terms_DATA;
	if(mysqli_num_rows($qu_gen_payment_terms_EXE)){
		$gen_payment_terms_DATA = mysqli_fetch_assoc($qu_gen_payment_terms_EXE);
		$payment_term_id = $gen_payment_terms_DATA['payment_term_id'];
	}

		$payment_term_title = $gen_payment_terms_DATA['payment_term_title'];
		$advanced_percentage = $gen_payment_terms_DATA['advanced_percentage'];
		$due_days = $gen_payment_terms_DATA['due_days'];
		$pay_on_delivery = $gen_payment_terms_DATA['pay_on_delivery'];
	
	

			
			
			
	$qu_hr_employees_sel = "SELECT * FROM  `hr_employees` WHERE `employee_id` = $employee_id";
	$qu_hr_employees_EXE = mysqli_query($KONN, $qu_hr_employees_sel);
	$hr_employees_DATA;
	if(mysqli_num_rows($qu_hr_employees_EXE)){
		$hr_employees_DATA = mysqli_fetch_assoc($qu_hr_employees_EXE);
	}
		$employee_namer = $hr_employees_DATA['employee_code'].'-'.$hr_employees_DATA['first_name'].' '.$hr_employees_DATA['last_name'];
			
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
		<div class="page-details text-left">
			<br>
			<h1><?=strtoupper( $quotation_ref.'-'.$rev_no ); ?>  ( <?=strtoupper( $quotation_status ); ?> )</h1>
			<h3 id="client-namer"></h3>
			<h3><?=strtoupper( $employee_namer ); ?></h3>
			<br>
		</div>
		
		<div class="tabber">
			<ul class="tabber-header">
				<li id="sel-1" onclick="set_tabber(1);" class="active"><?=lang("Client_Details", "AAR"); ?></li>
				<li id="sel-2" onclick="set_tabber(2);"><?=lang("Quotation_Details", "AAR"); ?></li>
				<li id="sel-3" onclick="set_tabber(3);"><?=lang("Quotation_Items", "AAR"); ?></li>
				<li id="sel-4" onclick="set_tabber(4);load_quotation_contacts();"><?=lang("Quotation_Contacts", "AAR"); ?></li>
				<li id="sel-5" onclick="set_tabber(5);"><?=lang("Quotation_Options", "AAR"); ?></li>
				<li id="sel-200" onclick="set_tabber(200);fetch_item_status(<?=$quotation_id; ?>, 'sales_quotations');"><?=lang("Status_Change", "AAR"); ?></li>
			</ul>
			

			
			<div class="tabber-body">





<div class="tabber-1 tabber-content tabber-active">
<?php
	include('clients/get_details.php');
?>
</div>



<div class="tabber-2 tabber-content">
<?php
	include('quot_edit/general.php');
?>
</div>





<div class="tabber-3 tabber-content">
<?php
	include('quot_edit/items.php');
?>
</div>

<div class="tabber-4 tabber-content">
<?php
	include('quot_edit/contacts.php');
?>
</div>


<div class="tabber-5 tabber-content">
	<div class="info-cell">
		<span style="color:#000;"><?=lang("Print_Quotation", "AAR"); ?></span><br>
		<a href="quotations_print.php?quotation_id=<?=$quotation_id; ?>" target="_blank">
			<button type="button" class="btn btn-primary"><?=lang("Proceed", "sss"); ?></button>
		</a>
	</div><br>
<?php
	if( $quotation_status == 'draft' ){
?>
	<div class="info-cell">
		<span style="color:#000;"><?=lang("activate_Quotation", "AAR"); ?></span><br>
		<button onclick="activate_quotation();" type="button" class="btn btn-primary"><?=lang("Proceed", "sss"); ?></button>
	</div>
<?php
	}
?>
<?php
	if( $quotation_status == 'activated' ){
?>
	<div class="info-cell">
		<span style="color:#000;"><?=lang("request_Quotation_approval", "AAR"); ?></span><br>
		<button onclick="request_quotation_approval();" type="button" class="btn btn-primary"><?=lang("Proceed", "sss"); ?></button>
	</div>
<?php
	}
?>
<?php
	if( $quotation_status == 'awaiting_approval' && $quotation_approval_allowed == true ){
?>
	<div class="info-cell">
		<span style="color:#000;"><?=lang("approve_quotation", "AAR"); ?></span><br>
		<button onclick="approve_quotation();" type="button" class="btn btn-success"><?=lang("APPROVE", "sss"); ?></button>
	</div>
	<div class="info-cell">
		<span style="color:#000;"><?=lang("deny_quotation", "AAR"); ?></span><br>
		<button onclick="deny_quotation();" type="button" class="btn btn-danger"><?=lang("DENY", "sss"); ?></button>
	</div>
<?php
	}
?>
<?php
	if( $quotation_status == 'published' ){
?>
	<div class="info-cell">
		<span style="color:#000;"><?=lang("request_client_approval", "AAR"); ?></span><br>
		<button onclick="request_client_approval();" type="button" class="btn btn-primary"><?=lang("Proceed", "sss"); ?></button>
	</div>
<?php
	}
?>

<?php
	if( $quotation_status == 'awaiting_client_approval' ){
?>
	<div class="info-cell">
		<span style="color:#000;"><?=lang("client_approved", "AAR"); ?></span><br>
		<button onclick="client_approved();" type="button" class="btn btn-success"><?=lang("Hooray", "sss"); ?></button>
	</div>
	<div class="info-cell">
		<span style="color:#000;"><?=lang("client_denied", "AAR"); ?></span><br>
		<a href="sales_quotations_denied.php?quotation_id=<?=$quotation_id; ?>">
			<button type="button" class="btn btn-danger"><?=lang("Ooops", "sss"); ?></button>
		</a>
	</div>
	<!--div class="info-cell">
		<span><?=lang("client_canceled", "AAR"); ?></span><br>
		<button onclick="cancel_quotation();" type="button" class="btn btn-warning"><?=lang("Cancel_Quotation", "sss"); ?></button>
	</div-->
<?php
	}
?>


<?php
	if( $quotation_status == 'client_denied' ){
?>
	<div class="info-cell">
		<span style="color:#000;"><?=lang("Revise_quotation", "AAR"); ?></span><br>
		<button onclick="revise_quotation();" type="button" class="btn btn-primary"><?=lang("Proceed", "sss"); ?></button>
	</div>
	<div class="info-cell">
		<span style="color:#000;"><?=lang("Cancel_Quotation", "AAR"); ?></span><br>
		<a href="sales_quotations_canceled.php?quotation_id=<?=$quotation_id; ?>">
			<button type="button" class="btn btn-danger"><?=lang("Cancel_Quotation", "sss"); ?></button>
		</a>
	</div>
<?php
	}
?>
</div>





<div class="tabber-200 tabber-content" id="fetched_status_change"></div>





<br>
<script>
function revise_quotation(){
	var aa = confirm("Are You Sure, this will mark this quotation as draft and set it to be revised?");
	if( aa == true ){
		start_loader();
		$.ajax({
			url      :"<?=api_root; ?>sales/quotations/revise_quotation.php",
			data     :{ 'quotation_id': <?=$quotation_id; ?> },
			dataType :"html",
			type     :'POST',
			success  :function(data){
					end_loader();
					dt_arr = data.split('|');
					dt_res = parseInt(dt_arr[0]);
					if(dt_res == 1){
						location.reload();
					} else {
						alert(dt_arr[1]);
					}
				},
			error    :function(){
				alert('Data Error No: 5467653');
				},
			});
	} else {
		end_loader();
	}
}

function client_approved(){
	var aa = confirm("Are You Sure, this will mark this quotation as approved from client side?");
	if( aa == true ){
		start_loader();
		$.ajax({
			url      :"<?=api_root; ?>sales/quotations/client_approved.php",
			data     :{ 'quotation_id': <?=$quotation_id; ?> },
			dataType :"html",
			type     :'POST',
			success  :function(data){
					end_loader();
					dt_arr = data.split('|');
					dt_res = parseInt(dt_arr[0]);
					if(dt_res == 1){
						location.reload();
					} else {
						alert(dt_arr[1]);
					}
				},
			error    :function(){
				alert('Data Error No: 5467653');
				},
			});
	} else {
		end_loader();
	}
}

function request_client_approval(){
	var aa = confirm("Are You Sure, this will mark this quotation as sent to client for approval?");
	if( aa == true ){
		start_loader();
		$.ajax({
			url      :"<?=api_root; ?>sales/quotations/request_client_approval.php",
			data     :{ 'quotation_id': <?=$quotation_id; ?> },
			dataType :"html",
			type     :'POST',
			success  :function(data){
					end_loader();
					dt_arr = data.split('|');
					dt_res = parseInt(dt_arr[0]);
					if(dt_res == 1){
						location.reload();
					} else {
						alert(dt_arr[1]);
					}
				},
			error    :function(){
				alert('Data Error No: 5467653');
				},
			});
	} else {
		end_loader();
	}
}

function approve_quotation(){
	var aa = confirm("Are You Sure, this will approve the current quotation?");
	if( aa == true ){
		start_loader();
		$.ajax({
			url      :"<?=api_root; ?>sales/quotations/approve_quotation.php",
			data     :{ 'quotation_id': <?=$quotation_id; ?> },
			dataType :"html",
			type     :'POST',
			success  :function(data){
					end_loader();
					dt_arr = data.split('|');
					dt_res = parseInt(dt_arr[0]);
					if(dt_res == 1){
						location.reload();
					} else {
						alert(dt_arr[1]);
					}
				},
			error    :function(){
				alert('Data Error No: 5467653');
				},
			});
	} else {
		end_loader();
	}
}

function deny_quotation(){
	var aa = confirm("Are You Sure, this will deny the current quotation and set it back to draft?");
	if( aa == true ){
		start_loader();
		$.ajax({
			url      :"<?=api_root; ?>sales/quotations/deny_quotation.php",
			data     :{ 'quotation_id': <?=$quotation_id; ?> },
			dataType :"html",
			type     :'POST',
			success  :function(data){
					end_loader();
					dt_arr = data.split('|');
					dt_res = parseInt(dt_arr[0]);
					if(dt_res == 1){
						location.reload();
					} else {
						alert(dt_arr[1]);
					}
				},
			error    :function(){
				alert('Data Error No: 5467653');
				},
			});
	} else {
		end_loader();
	}
}

function request_quotation_approval(){
	var aa = confirm("Are You Sure, this will raise the current quotation for approval?");
	if( aa == true ){
		start_loader();
		$.ajax({
			url      :"<?=api_root; ?>sales/quotations/request_quotation_approval.php",
			data     :{ 'quotation_id': <?=$quotation_id; ?> },
			dataType :"html",
			type     :'POST',
			success  :function(data){
					end_loader();
					dt_arr = data.split('|');
					dt_res = parseInt(dt_arr[0]);
					if(dt_res == 1){
						location.reload();
					} else {
						alert(dt_arr[1]);
					}
				},
			error    :function(){
				alert('Data Error No: 5467653');
				},
			});
	} else {
		end_loader();
	}
}

function activate_quotation(){
	var aa = confirm("Are You Sure, this will activate the current quotation ?");
	if( aa == true ){
		start_loader();
		$.ajax({
			url      :"<?=api_root; ?>sales/quotations/activate_quotation.php",
			data     :{ 'quotation_id': <?=$quotation_id; ?> },
			dataType :"html",
			type     :'POST',
			success  :function(data){
					end_loader();
					dt_arr = data.split('|');
					dt_res = parseInt(dt_arr[0]);
					if(dt_res == 1){
						location.reload();
					} else {
						alert(dt_arr[1]);
					}
				},
			error    :function(){
				alert('Data Error No: 5467653');
				},
			});
	} else {
		end_loader();
	}
}


function fetch_quotation_status(){
	start_loader();
			$('#fetched_ststus').html();
			$.ajax({
				url      :"<?=api_root; ?>sales/quotations/get_quotation_status.php",
				data     :{ 'quotation_id': <?=$quotation_id; ?> },
				dataType :"html",
				type     :'POST',
				success  :function(data){
						end_loader();
						$('#fetched_ststus').html(data);
					},
				error    :function(){
					alert('Data Error No: 5467653');
					},
				});
	
}

</script>
			</div>
		</div>
		
	</div>
	
	
	<div class="zero"></div>
</div>


<script>

function fix_cont_counters(){
	var cc = 0;
	$('.contacts_count').each(function(){
		cc++;
		$(this).html(cc);
	});
}


function load_quotation_contacts(){
	dd = parseInt( <?=$quotation_id; ?> );
	if(dd != 0){
		start_loader();
		$('#added_contacts').html('LOADING DATA...');
		$.ajax({
		url      :"../app_api/sales/quotations/get_quotation_contacts.php",
		data     :{'quotation_id': dd, 'operation': 1},
		dataType :"html",
		type     :'POST',
		success  :function(data){
			$('#added_contacts').html(data);
			fix_cont_counters();
			end_loader();
			},
		error    :function(){
			alert('Data Error No: 5467653');
			},
		});
				
	} else {
		
	}
}
</script>



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
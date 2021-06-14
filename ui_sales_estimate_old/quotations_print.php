<?php

	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 2;
	$subPageID = 21;
	
	
	$quotation_id = 0;
	if( !isset( $_GET['quotation_id'] ) ){
		header("location:index.php");
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
	
	
	
	
	$qu_gen_currencies_sel = "SELECT * FROM  `gen_currencies` WHERE `currency_id` = $currency_id";
	$qu_gen_currencies_EXE = mysqli_query($KONN, $qu_gen_currencies_sel);
	$gen_currencies_DATA;
	if(mysqli_num_rows($qu_gen_currencies_EXE)){
		$gen_currencies_DATA = mysqli_fetch_assoc($qu_gen_currencies_EXE);
	}
		$currency_name = $gen_currencies_DATA['currency_name'];
		$currency_full_name = $gen_currencies_DATA['currency_full_name'];
		$exchange_rate = $gen_currencies_DATA['exchange_rate'];

	
	
	
	$qu_gen_delivery_periods_sel = "SELECT * FROM  `gen_delivery_periods` WHERE `delivery_period_id` = $delivery_period_id";
	$qu_gen_delivery_periods_EXE = mysqli_query($KONN, $qu_gen_delivery_periods_sel);
	$gen_delivery_periods_DATA;
	if(mysqli_num_rows($qu_gen_delivery_periods_EXE)){
		$gen_delivery_periods_DATA = mysqli_fetch_assoc($qu_gen_delivery_periods_EXE);
	}
		$delivery_period_title = $gen_delivery_periods_DATA['delivery_period_title'];
		$delivery_period_days = $gen_delivery_periods_DATA['delivery_period_days'];

	
	
	
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
		// $payment_term_id = $gen_clients_DATA['payment_term_id'];
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
			
			







		$THS_REF = $quotation_ref.'-'.$rev_no;
?>
<!DOCTYPE html>
<html dir="<?=$lang_dir; ?>" lang="<?=$lang; ?>">
<html>
<head>
	<?php include('app/meta.php'); ?>
    <?php include('app/assets.php'); ?>
	
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?=$THS_REF; ?></title>
	
	
	
<!-- Jquery files -->
<script type="text/javascript" src="<?=assets_root; ?>js/jquery-2.0.3.min.js"></script>
<script type="text/javascript" src="<?=assets_root; ?>js/jquery-migrate-1.2.1.min.js"></script>

<script type="text/javascript" src="<?=assets_root; ?>barcode/jquery-barcode.js"></script>


<style>
body {
	float:none !important;
	width:auto;
	margin:0 auto;
	background-color:#FFF;
	font-size:12pt;	
	}

@media print {
   .repeatable {display: table-header-group;}
}


.tabler {
	width: 98%;
	margin: 0 auto;
}
.tabler thead tr th {
	text-align: center;
	font-weight: bolder;
	background: var(--main-L);
	color: #FFFFFF;
	padding: 5px;
	text-transform: uppercase;
}
.tabler tbody tr td {
	border-bottom: 1px solid var(--border-color) !important;
	padding: 5px;
	text-transform: capitalize;
	text-align: left;
	cursor: default;
}

.tabler tbody tr:hover {
	background: rgba(0,0,0,0.05);
}

.tabler tbody tr td i {
	border-bottom: 1px solid var(--border-color) !important;
	padding: 5px;
	cursor: pointer;
}

h4 {
	text-transform: capitalize;
}


</style>

</head>



<body id="contenter">


<table style="width:100%;margin: 0 auto;">
   <thead class="repeatable">
      <tr>
         <th>
<div style="text-align:left;width:45%;display:inline-block;vertical-align:bottom;">
<img src="<?=uploads_root.$site_logo; ?>" alt="System logo">
</div>
<div style="text-align:right;width:45%;display:inline-block;vertical-align:bottom;">
	<h2>Quotation ( <?=$quotation_status; ?> )</h2>
</div>
<hr>
		 </th>
      </tr>
   </thead>
   <tbody>
      <tr>
         <td>
		 <br>
<div style="text-align:center;width:48%;display:inline-block;vertical-align:bottom;">
	<div style="text-align:center;font-size: 14px;font-weight: 600;width:100%;margin: 0 auto;" id="bcTarget"></div>
	<script>$("#bcTarget").barcode("<?=$THS_REF; ?>", "code39", {barWidth:2}); </script>
</div>
<div style="text-align:center;width:48%;display:inline-block;vertical-align:bottom;">
	<span style="font-size:10px;">Printed On <?=date('Y-m-d H:i:00'); ?></span><br>
	<span style="font-size:10px;">This Document is digitally Signed</span>
</div>
	<hr style="opacity:0.05;">
		 
		 
		 </td>
      </tr>
	  
	  
	  
	  
	  
<?php /* ------------------------------------------------ */ ?>
      <tr>
         <td>
		 <br>
<div style="text-align:center;width:30%;display:inline-block;vertical-align:bottom;">
	<h4 style="text-align:center;"><?=lang("Client_Name", "AAR"); ?></h4>
	<span><?=$client_name; ?></span>
</div>
<div style="text-align:center;width:30%;display:inline-block;vertical-align:bottom;">
	<h4 style="text-align:center;"><?=lang("Employee_Name", "AAR"); ?></h4>
	<span><?=$employee_namer; ?></span>
</div>
<div style="text-align:center;width:30%;display:inline-block;vertical-align:bottom;">
	<h4 style="text-align:center;"><?=lang("quotation_date", "AAR"); ?></h4>
	<span><?=$quotation_date; ?></span>
</div>
	<hr style="opacity:0.05;">
		 </td>
      </tr>
	  
	  
	  
	  
<?php /* ------------------------------------------------ */ ?>
      <tr>
         <td>
		 <br>
<div style="text-align:center;width:30%;display:inline-block;vertical-align:bottom;">
	<h4 style="text-align:center;"><?=lang("payment_term", "AAR"); ?></h4>
	<span><?=$payment_term_title; ?></span>
</div>
<div style="text-align:center;width:30%;display:inline-block;vertical-align:bottom;">
	<h4 style="text-align:center;"><?=lang("currency", "AAR"); ?></h4>
	<span><?=$currency_name; ?></span>
</div>
<div style="text-align:center;width:30%;display:inline-block;vertical-align:bottom;">
	<h4 style="text-align:center;"><?=lang("delivery_period", "AAR"); ?></h4>
	<span><?=$delivery_period_title; ?></span>
</div>
	<hr style="opacity:0.05;">
		 </td>
      </tr>
	  
	  
	  
<?php /* ------------------------------------------------ */ ?>
      <tr>
         <td>
		 <br>
<div style="text-align:center;width:48%;display:inline-block;vertical-align:bottom;">
	<h4 style="text-align:center;"><?=lang("valid_until", "AAR"); ?></h4>
	<span><?=$valid_date; ?></span>
</div>
<div style="text-align:center;width:48%;display:inline-block;vertical-align:bottom;">
	<h4 style="text-align:center;"><?=lang("delivery_method", "AAR"); ?></h4>
	<span><?=$delivery_method; ?></span>
</div>
	<hr style="opacity:0.05;">
		 </td>
      </tr>
	  
	  
        
      <tr>
         <td>
		 <hr>
		 <br>
<table class="tabler" style="color:#000;">
				<thead>
					<tr>
						<th  style="color:#000;"><?=lang('No.'); ?></th>
						<th style="width:70%;color:#000;"><?=lang('name'); ?></th>
						<th style="color:#000;"><?=lang('qty'); ?></th>
						<th style="color:#000;"><?=lang('price'); ?></th>
						<th style="color:#000;"><?=lang('Totals'); ?></th>
					</tr>
				</thead>
				<tbody>
<?php
$subTotal = 0;
	$qu_sales_quotations_items_sel = "SELECT * FROM  `sales_quotations_items` WHERE `quotation_id` = $quotation_id";
	$qu_sales_quotations_items_EXE = mysqli_query($KONN, $qu_sales_quotations_items_sel);
	if(mysqli_num_rows($qu_sales_quotations_items_EXE)){
	$itemC = 0;
		while($sales_quotations_items_REC = mysqli_fetch_assoc($qu_sales_quotations_items_EXE)){
			$itemC++;
			$q_item_id = $sales_quotations_items_REC['q_item_id'];
			$q_item_name = $sales_quotations_items_REC['q_item_name'];
			$q_item_price = (double) $sales_quotations_items_REC['q_item_price'];
			$q_item_qty = (double) $sales_quotations_items_REC['q_item_qty'];
			$unit_id = $sales_quotations_items_REC['unit_id'];
			
			
			
	$qu_gen_items_units_sel = "SELECT * FROM  `gen_items_units` WHERE `unit_id` = $unit_id";
	$qu_gen_items_units_EXE = mysqli_query($KONN, $qu_gen_items_units_sel);
	$unit_name = "NA";
	if(mysqli_num_rows($qu_gen_items_units_EXE)){
		$gen_items_units_DATA = mysqli_fetch_assoc($qu_gen_items_units_EXE);
		$unit_name = $gen_items_units_DATA['unit_name'];
	}

			$thsTotal = $q_item_price * $q_item_qty;
			$subTotal = $subTotal + $thsTotal;
			
			
		?>
<tr id="itemo-<?=$itemC; ?>" class="quote_item" idler="<?=$itemC; ?>">
	<td style="color:#000;" class="item-c"><?=$itemC; ?></td>
	<td style="color:#000;"><?=$q_item_name; ?></td>
	<td style="color:#000;"><span class="qtyer"><?=$q_item_qty; ?></span>(<?=$unit_name; ?>)</td>
	<td class="pricer" style="color:#000;"><?=number_format( $q_item_price, 3 ); ?></td>
	<td class="toter" style="color:#000;"><?=number_format( $thsTotal, 3 ); ?></td>
</tr>
		<?php
		}
	}
	
	$VatPercentage = 0;
	if( $is_vat_included == 1 ){
		$VatPercentage = 0.05;
	}
	
	
	$totBeforeVat = 0;
	$totBeforeVat = $subTotal - $discount_amount;
	$totVat = $totBeforeVat * $VatPercentage;
	$AllTotal = $totVat + $totBeforeVat;
?>
				</tbody>
				<thead>
					<tr>
						<th colspan="4" style="text-align:right;color:#000;"><?=lang('Sub_Total_:'); ?></th>
						<th style="color:#000;" id="sub_total"><?=number_format( $subTotal, 3 ); ?></th>
					</tr>
					<tr>
						<th colspan="4" style="text-align:right;color:#000;"><?=lang('Discount_amount_:'); ?></th>
						<th style="color:#000;" id="sub_total"><?=number_format( $discount_amount, 3 ); ?></th>
					</tr>
					<tr>
						<th colspan="4" style="text-align:right;color:#000;"><?=lang('total_before_vat_:'); ?></th>
						<th style="color:#000;" id="sub_total"><?=number_format( $totBeforeVat, 3 ); ?></th>
					</tr>
					<tr>
						<th colspan="4" style="text-align:right;color:#000;"><?=lang('VAT_(5%)_:'); ?></th>
						<th style="color:#000;" id="sub_total"><?=number_format( $totVat, 3 ); ?></th>
					</tr>
					<tr>
						<th colspan="4" style="text-align:right;color:#000;"><?=lang('Total_:'); ?></th>
						<th style="color:#000;" id="sub_total"><?=number_format( $AllTotal, 3 ); ?></th>
					</tr>
				</thead>
			</table>
		 </td>
      </tr>
	  
	  
	  
	  
	  
	  
   </tbody>
</table>




<script>

</script>
</body>
</html>
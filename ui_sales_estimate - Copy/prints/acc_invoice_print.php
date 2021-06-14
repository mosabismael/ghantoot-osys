<?php
	require_once('../../bootstrap/app_config.php');
	require_once('../../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "Site Title";
	
	
	$site_logo =  'logo22.png';

	
	
	
	$invoice_id = 0;
	if( !isset( $_GET['invoice_id'] ) ){
		header("location:../index.php");
	} else {
		$invoice_id = (int) test_inputs( $_GET['invoice_id'] );
	}
	
	$qu_acc_invoices_sel = "SELECT * FROM  `acc_invoices` WHERE `invoice_id` = $invoice_id";
	$qu_acc_invoices_EXE = mysqli_query($KONN, $qu_acc_invoices_sel);
	$acc_invoices_DATA;
	if(mysqli_num_rows($qu_acc_invoices_EXE)){
		$acc_invoices_DATA = mysqli_fetch_assoc($qu_acc_invoices_EXE);
	}
		$invoice_id = $acc_invoices_DATA['invoice_id'];
		$invoice_ref = $acc_invoices_DATA['invoice_ref'];
		$invoice_type = $acc_invoices_DATA['invoice_type'];
		$payment_term_id = $acc_invoices_DATA['payment_term_id'];
		$client_id = $acc_invoices_DATA['client_id'];
		$client_ref = $acc_invoices_DATA['client_ref'];
		$client_contact = $acc_invoices_DATA['client_contact'];
		$invoice_date = $acc_invoices_DATA['invoice_date'];
		$due_date = $acc_invoices_DATA['due_date'];
		$job_order_id = $acc_invoices_DATA['job_order_id'];
		$bill_id = $acc_invoices_DATA['bill_id'];
		$created_date = $acc_invoices_DATA['created_date'];
		$created_by = $acc_invoices_DATA['created_by'];
		$invoice_status = $acc_invoices_DATA['invoice_status'];
	
	
	
	
	
		$employee_name             = get_emp_name( $KONN, $acc_invoices_DATA['created_by'] );
		$payment_term_title        = get_payment_term_title($acc_invoices_DATA['payment_term_id'], $KONN );
		$currency_name             = "AED";
		
		
		
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
		$city = $gen_clients_DATA['city'];
		$country = $gen_clients_DATA['country'];
		$address = $gen_clients_DATA['address'];
		$trn_no = $gen_clients_DATA['trn_no'];
		
	
	$job_order_ref = '--';
	$project_name = '--';
	if( $job_order_id != 0 ){
		$qu_job_orders_sel = "SELECT * FROM  `job_orders` WHERE `job_order_id` = $job_order_id";
		$qu_job_orders_EXE = mysqli_query($KONN, $qu_job_orders_sel);
		$job_orders_DATA;
		if(mysqli_num_rows($qu_job_orders_EXE)){
			$job_orders_DATA = mysqli_fetch_assoc($qu_job_orders_EXE);
		}
			$job_order_ref = $job_orders_DATA['job_order_ref'];
			$project_name = $job_orders_DATA['project_name'];
			
	}
		
		$project = $job_order_ref.' - '.$project_name;
		
	
	$is_vat_included = 1;
	
		
		$THS_REF = $invoice_ref;
?>
<!DOCTYPE html>
<html dir="<?=$lang_dir; ?>" lang="<?=$lang; ?>">
<html>
<head>
	<meta name="charset" content="UTF-8">
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?=$THS_REF; ?></title>
	<!-- Jquery files -->
	<script type="text/javascript" src="../<?=assets_root; ?>js/jquery-2.0.3.min.js"></script>
	<script type="text/javascript" src="../<?=assets_root; ?>js/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript" src="../<?=assets_root; ?>barcode/jquery-barcode.js"></script>
<link href="../<?=assets_root; ?>styles/print<?=$lang_db; ?>.css" rel="stylesheet" media="print">
<style>

body {
	float:none !important;
	width:auto;
	margin:0 auto;
	background-color:#FFF;
	font-size:10pt;	
	font-family: 'calibri';
	}

@media print {
   .repeatable {display: table-header-group;}
}
</style>

</head>



<body id="contenter">

	



<table style="width:100%;margin: 0 auto;">
	<thead class="repeatable">
		<tr>
			<th style="width:50%;text-align: left;border-bottom: 3px solid #1d05FF;">
				<img src="print_header.png" style="width: 100%;margin: 0 auto;" alt="System logo">
			</th>
			<th style="width:50%;text-align: right;border-bottom: 3px solid #1d05FF;">
				<h1 style="width:100%;font-size: 21pt;padding: 0;margin:0;letter-spacing: 6px;">TAX INVOICE</h1>
			</th>
		</tr>
   </thead>
   
   
   
   
   
   
	<tbody>
		<tr>
			
			
			<th style="width:50%;text-align: left;border-bottom: 3px solid #1d05FF;">
				<div style="font-size: 10pt;text-align: left;">
					<span style="color:#1d05FF">Invoice To :</span> <?=$client_name; ?>
				</div>
<?php
if( $address != '' ){
?>
				<div style="font-size: 10pt;text-align: left;">
					<span style="color:#1d05FF">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> <?=$address; ?>
				</div>
<?php
}
?>
				<div style="font-size: 10pt;text-align: left;">
					<span style="color:#1d05FF">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> <?=$phone; ?>
				</div>
				<div style="font-size: 10pt;text-align: left;">
					<span style="color:#1d05FF">Project &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</span> <?=$project_name; ?>
				</div>
				
			</th>
			
			<th style="width:50%;text-align: right;border-bottom: 3px solid #1d05FF;">
				<div style="font-size: 10pt;text-align: right;">
					<span style="color:#1d05FF">Date :</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?=$invoice_date; ?>
				</div>
				<div style="font-size: 10pt;text-align: right;">
					<span style="color:#1d05FF">INVOICE # :</span> <?=$invoice_ref; ?>
				</div>
				<div style="font-size: 10pt;text-align: right;">
					<span style="color:#1d05FF">CUSTOMER ID :</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?=$client_code; ?>
				</div>
				
			</th>
		</tr>
	  
	  
	  
   
    <tr>
         <td colspan="2"><br></td>
	</tr>
      <tr>
         <td colspan="2">
		 
		
	<table style="width:100%;margin: 0 auto;border-collapse: separate;border-spacing: 0;">
			<thead>
				<tr>
					<th style="color:#FFF;background:#153289;text-align: center;font-size: 12pt;border-left: 1px solid #000;border-right: 1px solid #000;border-top: 1px solid #000;border-bottom: 1px solid #000;">
						<?=lang('NO.'); ?>
					</th>
					<th style="color:#FFF;background:#153289;width:40%;text-align: center;font-size: 12pt;border-right: 1px solid #000;border-top: 1px solid #000;border-bottom: 1px solid #000;">
						<?=lang('DESCRIPTION'); ?>
					</th>
					<th style="color:#FFF;background:#153289;width:10%;text-align: center;font-size: 12pt;border-right: 1px solid #000;border-top: 1px solid #000;border-bottom: 1px solid #000;">
						<?=lang('QTY'); ?>
					</th>
					<th style="color:#FFF;background:#153289;text-align: center;font-size: 12pt;border-right: 1px solid #000;border-top: 1px solid #000;border-bottom: 1px solid #000;">
						<?=lang('U.P.'); ?>
					</th>
					<th style="color:#FFF;background:#153289;text-align: center;font-size: 12pt;border-top: 1px solid #000;border-right: 1px solid #000;border-bottom: 1px solid #000;">
						<?=lang('TOTAL'); ?>( <span id="cur_name_view"><?=$currency_name; ?></span> )
					</th>
				</tr>
			</thead>
			
			<tbody>
			
<?php
	$ItemsTotal = 0;
	$qu_acc_invoices_items_sel = "SELECT * FROM  `acc_invoices_items` WHERE `invoice_id` = $invoice_id";
	$qu_acc_invoices_items_EXE = mysqli_query($KONN, $qu_acc_invoices_items_sel);
	if(mysqli_num_rows($qu_acc_invoices_items_EXE)){
		$COUNT = 0;
		$REM = 10;
		while($acc_invoices_items_REC = mysqli_fetch_assoc($qu_acc_invoices_items_EXE)){
			$thsTot = 0;
			$COUNT++;
			$item_desc = $acc_invoices_items_REC['item_desc'];
			$unit_id = $acc_invoices_items_REC['unit_id'];
			$item_qty               = ( double ) $acc_invoices_items_REC['item_qty'];
			$item_price             = ( double ) $acc_invoices_items_REC['item_price'];
			$REM--;
			
			
			$thsTot = $item_qty * $item_price;
			$ItemsTotal = $ItemsTotal + $thsTot;
			$item_unit_name = get_item_unit_name( $acc_invoices_items_REC['unit_id'], $KONN );
		
			$item_name = $item_desc;
		?>
<tr>
	<td style="text-align:center;border-bottom: 1px solid #000;border-left: 1px solid #000;border-right: 1px solid #000;padding: 5px 0;font-size: 10pt;">
	<?=$COUNT; ?>
	</td>
	<td style="text-align:center;border-bottom: 1px solid #000;border-right: 1px solid #000;padding: 5px 0;font-size: 10pt;padding-left: 10px;">
	<?=$item_name; ?>
	</td>
	<td style="text-align:center;border-bottom: 1px solid #000;border-right: 1px solid #000;padding: 5px 0;font-size: 10pt;">
	<?=$item_qty; ?> (<?=$item_unit_name; ?>)
	</td>
	<td style="text-align:center;border-bottom: 1px solid #000;border-right: 1px solid #000;padding: 5px 0;font-size: 10pt;">
	<?=number_format($item_price, 3); ?>
	</td>
	<td style="text-align:center;border-bottom: 1px solid #000;border-right: 1px solid #000;padding: 5px 0;font-size: 10pt;">
	<?=number_format($thsTot, 3); ?>
	</td>
</tr>
		<?php
		}
	}
	
	
	for( $L=1; $L<=$REM ; $L++ ){
		?>
<tr>
	<td style="text-align:center;border-bottom: 1px solid #000;border-left: 1px solid #000;border-right: 1px solid #000;padding: 5px 0;font-size: 10pt;">
	<br>
	</td>
	<td style="text-align:center;border-bottom: 1px solid #000;border-right: 1px solid #000;padding: 5px 0;font-size: 10pt;padding-left: 10px;">
	<br>
	</td>
	<td style="text-align:center;border-bottom: 1px solid #000;border-right: 1px solid #000;padding: 5px 0;font-size: 10pt;">
	<br>
	</td>
	<td style="text-align:center;border-bottom: 1px solid #000;border-right: 1px solid #000;padding: 5px 0;font-size: 10pt;">
	<br>
	</td>
	<td style="text-align:center;border-bottom: 1px solid #000;border-right: 1px solid #000;padding: 5px 0;font-size: 10pt;">
	<br>
	</td>
</tr>
		<?php
	}
	
	
?>

			</tbody>
			<thead>
				<tr>
					<th colspan="5" style="text-align: left;font-size: 10pt;border-left: 1px solid #000;border-right: 1px solid #000;border-top: none;border-bottom: 1px solid #000;">
						Payment Term : <?=$payment_term_title; ?>
					</th>
				</tr>
				<tr>
					<th colspan="5" style="text-align: center;font-size: 10pt;border-left: 1px solid #000;border-right: 1px solid #000;border-top: none;border-bottom: 1px solid #000;">
						<br>
					</th>
				</tr>
				
				<tr>
					<th colspan="4" style="text-align: right;font-size: 10pt;border-left: 1px solid #000;border-top: none;border-bottom: 1px solid #000;">
						<span style="color:#1d05FF">TOTAL &nbsp;&nbsp;&nbsp;&nbsp;( <span id="cur_name_view"><?=$currency_name; ?></span> ) :&nbsp;&nbsp;&nbsp;</span>
					</th>
					<th style="text-align: center;font-size: 10pt;border-left: 1px solid #000;border-right: 1px solid #000;border-top: none;border-bottom: 1px solid #000;">
						<?=number_format($ItemsTotal, 3); ?>
					</th>
				</tr>
				
				

<?php
$totAL = $ItemsTotal;
if( $is_vat_included == 1 ){
	$VAT = 0.0;
	$VAT = $ItemsTotal * 0.05;
	$totAL = $ItemsTotal + $VAT;
?>
				<tr>
					<th colspan="4" style="text-align: right;font-size: 10pt;border-left: 1px solid #000;;border-top: none;border-bottom: 1px solid #000;">
						<span style="color:#1d05FF">VAT 5% &nbsp;&nbsp;&nbsp;&nbsp;( <span id="cur_name_view"><?=$currency_name; ?></span> ) :&nbsp;&nbsp;&nbsp;</span>
					</th>
					<th style="text-align: center;font-size: 10pt;border-left: 1px solid #000;border-right: 1px solid #000;border-top: none;border-bottom: 1px solid #000;">
						<?=number_format($VAT, 3); ?>
					</th>
				</tr>
<?php
}
?>
				<tr>
					<th colspan="4" style="text-align: right;font-size: 10pt;border-left: 1px solid #000;border-top: none;border-bottom: 1px solid #000;">
						<span style="color:#1d05FF">Net Amount to be Paid &nbsp;&nbsp;&nbsp;&nbsp;( <span id="cur_name_view"><?=$currency_name; ?></span> ) :&nbsp;&nbsp;&nbsp;</span>
					</th>
					<th style="text-align: center;font-size: 10pt;border-left: 1px solid #000;border-right: 1px solid #000;border-top: none;border-bottom: 1px solid #000;">
						<?=number_format($totAL, 3); ?>
					</th>
				</tr>
				
				
			</thead>
		</table>
		 
		 
		 
		 
		 
		 <br>
		 <br>
		 <br>
		 <br>
		 <br>
		 <br>


	<table style="width:100%;margin: 0 auto;border-collapse: separate;border-spacing: 0;">
			<thead>
				<tr>
					<th style="text-align: left;font-size: 12pt;border-left: 1px solid #000;border-right: 1px solid #000;border-top: 1px solid #000;border-bottom: 1px solid #000;">
<div>
Payment to be made in favor of : GHANTOOT OFFSHORE MARINE INDUSTRIES LLC
</div>
<div style="margin-left:30px;">
	<span style="width:12%;display:inline-block;font-size: 10pt;">Acct. Name</span>: <span style="font-size: 9pt;">GHANTOOT OFFSHORE MARINE INDUSTRIES LLC</span>
</div>
<div style="margin-left:30px;">
	<span style="width:12%;display:inline-block;font-size: 10pt;">BANK</span>: <span style="font-size: 9pt;">COMMERCIAL BANK OF DUBAI</span>
</div>
<div style="margin-left:30px;">
	<span style="width:12%;display:inline-block;font-size: 10pt;">A/C No.</span>: <span style="font-size: 9pt;">1001815750 (Dirham Account)</span>
</div>
<div style="margin-left:30px;">
	<span style="width:12%;display:inline-block;font-size: 10pt;">IBAN No.</span>: <span style="font-size: 9pt;">AE300230000001001815750</span>
</div>
<div style="margin-left:30px;">
	<span style="width:12%;display:inline-block;font-size: 10pt;">Branch</span>: <span style="font-size: 9pt;">30-Electra, Abu Dhabi - UAE</span>
</div>
<div style="margin-left:30px;">
	<span style="width:12%;display:inline-block;font-size: 10pt;">Swift Code</span>: <span style="font-size: 9pt;">CBDUAEAD</span>
</div>
					
					</th>
				</tr>
			</thead>
	</table>
		 

		 <br>
		 <br>
		 <br>

	<table style="width:100%;margin: 0 auto;border-collapse: separate;border-spacing: 0;">
			<thead>
				<tr>
					<th style="color:#FFF;background:#153289;width:50%;text-align: center;font-size: 12pt;border-left: 1px solid #000;border-right: 1px solid #000;border-top: 1px solid #000;border-bottom: 1px solid #000;">		
					    PROJECT MANAGER
					</th>
					<th style="color:#FFF;background:#153289;width:50%;text-align: center;font-size: 12pt;border-left: 1px solid #000;border-right: 1px solid #000;border-top: 1px solid #000;border-bottom: 1px solid #000;">		
					    FINANCE MANAGER
					</th>
				</tr>
				<tr>
					<th style="text-align: center;font-size: 12pt;border-left: 1px solid #000;border-right: 1px solid #000;border-top: 1px solid #000;border-bottom: 1px solid #000;">		
					    <br><br><br><br>
					</th>
					<th style="text-align: center;font-size: 12pt;border-left: 1px solid #000;border-right: 1px solid #000;border-top: 1px solid #000;border-bottom: 1px solid #000;">		
					    <br>
					</th>
				</tr>
			</thead>
	</table>
		 
		 
		 
		 
		 
		 
		 
		 </td>
      </tr>

      <tr>
         <td colspan="2"><br></td>
      </tr>
   </tbody>
</table>




<script>

</script>
</body>
</html>
<?php
	require_once('../../bootstrap/app_config.php');
	require_once('../../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "Site Title";
	
	
	$site_logo =  'logo22.png';

	
	
	
	$bill_id = 0;
	if( !isset( $_GET['bill_id'] ) ){
		header("location:../index.php");
	} else {
		$bill_id = (int) test_inputs( $_GET['bill_id'] );
	}
	
	$qu_acc_biling_sel = "SELECT * FROM  `acc_biling` WHERE `bill_id` = $bill_id";
	$qu_acc_biling_EXE = mysqli_query($KONN, $qu_acc_biling_sel);
	$acc_biling_DATA;
	if(mysqli_num_rows($qu_acc_biling_EXE)){
		$acc_biling_DATA = mysqli_fetch_assoc($qu_acc_biling_EXE);
	}
		$bill_id = $acc_biling_DATA['bill_id'];
		$bill_type = $acc_biling_DATA['bill_type'];
		$bill_ref = $acc_biling_DATA['bill_ref'];
		$client_id = $acc_biling_DATA['client_id'];
		$client_ref = $acc_biling_DATA['client_ref'];
		$client_contact = $acc_biling_DATA['client_contact'];
		$created_date = $acc_biling_DATA['created_date'];
		$created_by = $acc_biling_DATA['created_by'];
		$job_order_id = $acc_biling_DATA['job_order_id'];
		$bill_status = $acc_biling_DATA['bill_status'];
	
	
	
	
	
		$employee_name             = get_emp_name( $KONN, $acc_biling_DATA['created_by'] );
		// $payment_term_title        = get_payment_term_title($acc_biling_DATA['payment_term_id'], $KONN );
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
	
		
		$THS_REF = $bill_ref;
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
        <th style="width:33.33%;text-align: left;">
			<img src="Logo_print.png" style="" alt="System logo">
			<div style="font-size: 8pt;text-align: left;letter-spacing: 1px;">
				<div>Mussafah Industrial Area</div>
				<div>ABUDHABI - UAE,</div>
				<div>TEL : +971 2 550 14 46</div>
				<div>FAX : +971 2 553 92 22</div>
				<div>TRN : 100301305700003</div>
			</div>
		</th>
        <th style="width:33.33%;"></th>
        <th style="width:33.33%;text-align: right;">
			<h1 style="font-size: 21pt;padding: 0;margin:0;color: #ae1e23;">TAX INVOICE</h1>
			<div style="display: block;">
				<span style="margin: 0 10px;font-size: 10pt;text-align: right;display: inline-block;">
				DATE
				</span>
				<span style="width: 70px;display: inline-block;text-align: center;padding: 5px;border: 1px solid #000000;font-size: 8pt;">
				<?=$created_date; ?>
				</span>
			</div>
			<div style="display: block;">
				<span style="margin: 0 10px;font-size: 10pt;text-align: right;display: inline-block;">
				REF
				</span>
				<span style="width: 70px;display: inline-block;text-align: center;padding: 5px;border: 1px solid #000000;font-size: 8pt;">
				<?=$bill_ref; ?>
				</span>
			</div>
			<div style="display: block;">
				<span style="margin: 0 10px;font-size: 10pt;text-align: right;display: inline-block;">
				Project
				</span>
				<span style="width: 70px;display: inline-block;text-align: center;padding: 5px;border: 1px solid #000000;font-size: 8pt;">
				<?=$project; ?>
				</span>
			</div>
		</th>
      </tr>
   </thead>
   <tbody>
      <tr><td colspan="3"><br></td>
      </tr>
      <tr>
        <th style="width:33.33%;text-align: left;background: #ae1e23;color: white;font-size: 10pt;padding-left: 10px;">
			Client
		</th>
        <th style="width:33.33%;"></th>
        <th style="width:33.33%;text-align: left;background: #ae1e23;color: white;font-size: 10pt;padding-left: 10px;">
			Ghantoot Offshore Marine Ind.
		</th>
      </tr>
	  
      <tr>
        <th style="width:33.33%;text-align: left;padding-left: 16px;">
			<div style="font-size: 8pt;text-align: left;">
				<div><?=$client_code; ?> - <?=$client_name; ?></div>
				<div><?=$address; ?></div>
				<div><?=$phone; ?></div>
			</div>
		</th>
        <th style="width:33.33%;"></th>
        <th style="width:33.33%;text-align: left;padding-left: 16px;">
			<div style="font-size: 8pt;text-align: left;">
				<div>Ghantoot Offshore Marine Industries</div>
				<div>Mussafah Industrial Area</div>
				<div>ABUDHABI - UAE,</div>
				<div>TEL : +971 2 550 14 46</div>
			</div>
		</th>
      </tr>
	  
      <tr>
        <th style="width:33.33%;text-align: center;background: #ae1e23;color: white;font-size: 10pt;">
			JOB ORDER
		</th>
        <th style="width:33.33%;text-align: center;background: #ae1e23;color: white;font-size: 10pt;">
			Project Name
		</th>
        <th style="width:33.33%;text-align: center;background: #ae1e23;color: white;font-size: 10pt;">
			CREATED BY
		</th>
      </tr>
      <tr>
        <th style="width:33.33%;text-align: center;font-size: 8pt;text-transform:capitalize;">
			<?=$job_order_ref; ?>
		</th>
        <th style="width:33.33%;text-align: center;font-size: 8pt;text-transform:capitalize;">
			<?=$project_name; ?>
		</th>
        <th style="width:33.33%;text-align: center;font-size: 8pt;text-transform:capitalize;">
			<?=$employee_name; ?>
		</th>
      </tr>
	  
    <tr>
         <td colspan="3"><br></td>
	</tr>
      <tr>
         <td colspan="3">
		 
		
	<table style="width:100%;margin: 0 auto;border-collapse: separate;border-spacing: 0;">
			<thead>
				<tr>
					<th style="text-align: center;background: #ae1e23;color: white;font-size: 8pt;border-left: 1px solid #000;border-right: 0.1pt dotted #000;border-top: 1px solid #000;">
						<?=lang('NO.'); ?>
					</th>
					<th style="width:40%;text-align: center;background: #ae1e23;color: white;font-size: 8pt;border-right: 0.1pt dotted #000;border-top: 1px solid #000;">
						<?=lang('ITEM'); ?>
					</th>
					<th style="width:10%;text-align: center;background: #ae1e23;color: white;font-size: 8pt;border-right: 0.1pt dotted #000;border-top: 1px solid #000;">
						<?=lang('QTY'); ?>
					</th>
					<th style="text-align: center;background: #ae1e23;color: white;font-size: 8pt;border-right: 0.1pt dotted #000;border-top: 1px solid #000;">
						<?=lang('UOM'); ?>
					</th>
					<th style="text-align: center;background: #ae1e23;color: white;font-size: 8pt;border-right: 0.1pt dotted #000;border-top: 1px solid #000;">
						<?=lang('UNIT_PRICE'); ?>
					</th>
					<th style="text-align: center;background: #ae1e23;color: white;font-size: 8pt;border-top: 1px solid #000;border-right: 1px solid #000;">
						<?=lang('TOTAL'); ?>( <span id="cur_name_view"><?=$currency_name; ?></span> )
					</th>
				</tr>
			</thead>
			
			<tbody>
			
<?php
	$ItemsTotal = 0;
	$qu_acc_biling_items_sel = "SELECT * FROM  `acc_biling_items` WHERE `bill_id` = $bill_id";
	$qu_acc_biling_items_EXE = mysqli_query($KONN, $qu_acc_biling_items_sel);
	if(mysqli_num_rows($qu_acc_biling_items_EXE)){
		$COUNT = 0;
		while($acc_biling_items_REC = mysqli_fetch_assoc($qu_acc_biling_items_EXE)){
			$thsTot = 0;
			$COUNT++;
			$is_tree = ( int ) $acc_biling_items_REC['is_tree'];
			$item_desc = $acc_biling_items_REC['item_desc'];
			$unit_id = $acc_biling_items_REC['unit_id'];
			$item_qty               = ( double ) $acc_biling_items_REC['item_qty'];
			$item_price             = ( double ) $acc_biling_items_REC['item_price'];
			
			
			
			$thsTot = $item_qty * $item_price;
			$ItemsTotal = $ItemsTotal + $thsTot;
			$item_unit_name = get_item_unit_name( $acc_biling_items_REC['unit_id'], $KONN );
		
			$item_name = $item_desc;
			
			if( $is_tree != 1 ){
				
			
			
		?>
<tr>
	<td style="text-align:center;border-bottom: 0.1pt dotted #000;border-left: 1px solid #000;padding: 5px 0;font-size: 8pt;">
	<?=$COUNT; ?>
	</td>
	<td style="text-align:center;border-bottom: 0.1pt dotted #000;border-right: 0.1pt dotted #000;padding: 5px 0;font-size: 8pt;padding-left: 10px;">
	<?=$item_name; ?>
	</td>
	<td style="text-align:center;border-bottom: 0.1pt dotted #000;border-right: 0.1pt dotted #000;padding: 5px 0;font-size: 8pt;">
	<?=$item_qty; ?>
	</td>
	<td style="text-align:center;border-bottom: 0.1pt dotted #000;border-right: 0.1pt dotted #000;padding: 5px 0;font-size: 8pt;">
	<?=$item_unit_name; ?>
	</td>
	<td style="text-align:center;border-bottom: 0.1pt dotted #000;border-right: 0.1pt dotted #000;padding: 5px 0;font-size: 8pt;">
	<?=number_format($item_price, 3); ?>
	</td>
	<td style="text-align:center;border-bottom: 0.1pt dotted #000;border-right: 1px solid #000;padding: 5px 0;font-size: 8pt;">
	<?=number_format($thsTot, 3); ?>
	</td>
</tr>
		<?php
			}
		}
	}
?>

			</tbody>
		</table>
		 
		 
		 </td>
      </tr>

      <tr>
         <td colspan="3"><br></td>
      </tr>
      <tr>
         <td colspan="3" style="text-align:center;">
	
	

<div style="width:45%;display:inline-block;text-align:right;">
	<table style="width:40%;margin-left:70%;display:block;vertical-align:top;border-collapse: separate;border-spacing: 0;">
			<tbody>

<tr style="font-size: 10pt;">
	<td style="padding:10px;text-align:right;border-right: 0.1pt dotted #000;border-bottom: 0.1pt dotted #000;border-top: 2px solid #000;border-left: 2px solid #000;">Sub Total</td>
	<td style="padding:10px;text-align:center;border-right: 2px solid #000;border-bottom: 0.1pt dotted #000;border-top: 2px solid #000;">
		<?=number_format($ItemsTotal, 3); ?>
	</td>
</tr>
<?php
$totAL = $ItemsTotal;
if( $is_vat_included == 1 ){
	$VAT = 0.0;
	$VAT = $ItemsTotal * 0.05;
	$totAL = $ItemsTotal + $VAT;
?>
<tr style="font-size: 10pt;">
	<td style="padding:10px;text-align:right;border-right: 0.1pt dotted #000;border-bottom: 0.1pt dotted #000;border-left: 2px solid #000;border-bottom: 2px solid #000;">Total Vat Amount</td>
	<td style="padding:10px;text-align:center;border-right: 2px solid #000;border-bottom: 0.1pt dotted #000;border-bottom: 2px solid #000;">
		<?=number_format($VAT, 3); ?>
	</td>
</tr>
<?php
}
?>
<tr style="font-size: 10pt;">
	<td style="padding:10px;text-align:right;border-right: 0.1pt dotted #000;border-bottom: 2px solid #000;border-left: 2px solid #000;">Total</td>
	<td style="padding:10px;text-align:center;border-right: 2px solid #000;border-bottom: 2px solid #000;">
		<?=number_format($totAL, 3); ?>
	</td>
</tr>
			</tbody>
	</table>
</div>
	
	
	
	
	
	
		 </td>
      
	  
	  
	  
	  </tr>
	  
	  
	  
	  
	  
   </tbody>
</table>




<script>

</script>
</body>
</html>
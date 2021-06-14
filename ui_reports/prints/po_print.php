<?php
	require_once('../../bootstrap/app_config.php');
	require_once('../../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "Site Title";
	
	
	$site_logo =  'logo22.png';

	
	
	
	$po_id = 0;
	if( !isset( $_GET['po_id'] ) ){
		header("location:../index.php");
	} else {
		$po_id = (int) test_inputs( $_GET['po_id'] );
	}
	
	$qu_purchase_orders_sel = "SELECT * FROM  `purchase_orders` WHERE `po_id` = $po_id";
	$qu_purchase_orders_EXE = mysqli_query($KONN, $qu_purchase_orders_sel);
	$purchase_orders_DATA;
	if(mysqli_num_rows($qu_purchase_orders_EXE)){
		$purchase_orders_DATA = mysqli_fetch_assoc($qu_purchase_orders_EXE);
	}

		$po_id = $purchase_orders_DATA['po_id'];
		$po_ref = $purchase_orders_DATA['po_ref'];
		$rev_no = $purchase_orders_DATA['rev_no'];
		$po_date = $purchase_orders_DATA['po_date'];
		$delivery_date = $purchase_orders_DATA['delivery_date'];
		$delivery_period_id = $purchase_orders_DATA['delivery_period_id'];
		$discount_percentage = ( double ) $purchase_orders_DATA['discount_percentage'];
		$discount_amount = ( double ) $purchase_orders_DATA['discount_amount'];
		$is_vat_included = ( int ) $purchase_orders_DATA['is_vat_included'];
		$payment_term_id = $purchase_orders_DATA['payment_term_id'];
		$currency_id = $purchase_orders_DATA['currency_id'];
		$exchange_rate = $purchase_orders_DATA['exchange_rate'];
		$supplier_quotation_ref = $purchase_orders_DATA['supplier_quotation_ref'];
		$attached_supplier_quotation = $purchase_orders_DATA['attached_supplier_quotation'];
		$notes = $purchase_orders_DATA['notes'];
		$po_status = $purchase_orders_DATA['po_status'];
		$supplier_id = $purchase_orders_DATA['supplier_id'];
		$requisition_id = $purchase_orders_DATA['requisition_id'];
		$job_order_id = $purchase_orders_DATA['job_order_id'];
		$employee_id = $purchase_orders_DATA['employee_id'];
	
	
	
	
	
	
		$employee_name             = get_emp_name( $KONN, $purchase_orders_DATA['employee_id'] );
		$supplier_name             = get_supplier_name($purchase_orders_DATA['supplier_id'], $KONN );
		$payment_term_title        = get_payment_term_title($purchase_orders_DATA['payment_term_id'], $KONN );
		$delivery_period_title     = get_delivery_period_title($purchase_orders_DATA['delivery_period_id'], $KONN );
		$currency_name             = get_currency_name($purchase_orders_DATA['currency_id'], $KONN );
		$requisition_ref           = get_requisition_ref($purchase_orders_DATA['requisition_id'], $KONN );
	
	
	
	$qu_suppliers_list_sel = "SELECT * FROM  `suppliers_list` WHERE `supplier_id` = $supplier_id";
	$qu_suppliers_list_EXE = mysqli_query($KONN, $qu_suppliers_list_sel);
	$suppliers_list_DATA;
	if(mysqli_num_rows($qu_suppliers_list_EXE)){
		$suppliers_list_DATA = mysqli_fetch_assoc($qu_suppliers_list_EXE);
	}
		$supplier_code = $suppliers_list_DATA['supplier_code'];
		$supplier_name = $suppliers_list_DATA['supplier_name'];
		$supplier_type = $suppliers_list_DATA['supplier_type'];
		$supplier_cat = $suppliers_list_DATA['supplier_cat'];
		$website = $suppliers_list_DATA['website'];
		$country = $suppliers_list_DATA['country'];
		$supplier_address = $suppliers_list_DATA['address'];
		$supplier_phone = $suppliers_list_DATA['supplier_phone'];
		$trn_no = $suppliers_list_DATA['trn_no'];
	
	
	
	
	
	
	
		
		$THS_REF = $po_ref;
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
	font-size:12pt;	
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
			<div style="font-size: 10pt;text-align: left;letter-spacing: 1px;">
				<div>Mussafah Industrial Area</div>
				<div>ABUDHABI - UAE,</div>
				<div>TEL : +971 2 550 14 46</div>
				<div>FAX : +971 2 553 92 22</div>
				<div>TRN : 100301305700003</div>
			</div>
		</th>
        <th style="width:33.33%;"></th>
        <th style="width:33.33%;text-align: right;">
			<h1 style="font-size: 18pt;padding: 0;margin:0;color: #ae1e23;">PURCHASE ORDER</h1>
			<div style="display: block;">
				<span style="margin: 0 10px;font-size: 12pt;text-align: right;display: inline-block;">
				DATE
				</span>
				<span style="width: 70px;display: inline-block;text-align: center;padding: 5px;border: 1px solid #000000;font-size: 10pt;">
				<?=$po_date; ?>
				</span>
			</div>
			<div style="display: block;">
				<span style="margin: 0 10px;font-size: 12pt;text-align: right;display: inline-block;">
				PO REF
				</span>
				<span style="width: 70px;display: inline-block;text-align: center;padding: 5px;border: 1px solid #000000;font-size: 10pt;">
				<?=$po_ref; ?>
				</span>
			</div>
		</th>
      </tr>
   </thead>
   <tbody>
      <tr><td colspan="3"><br></td>
      </tr>
      <tr>
        <th style="width:33.33%;text-align: left;background: #ae1e23;color: white;font-size: 12pt;padding-left: 10px;">
			SUPPLIER
		</th>
        <th style="width:33.33%;"></th>
        <th style="width:33.33%;text-align: left;background: #ae1e23;color: white;font-size: 12pt;padding-left: 10px;">
			SHIP TO
		</th>
      </tr>
	  
      <tr>
        <th style="width:33.33%;text-align: left;padding-left: 16px;">
			<div style="font-size: 10pt;text-align: left;">
				<div><?=$supplier_code; ?> - <?=$supplier_name; ?></div>
				<div><?=$supplier_address; ?></div>
				<div><?=$supplier_phone; ?></div>
				<div>ATTN :</div>
				<div> CONTACT PERSON +971 52 100 99 64</div>
			</div>
		</th>
        <th style="width:33.33%;"></th>
        <th style="width:33.33%;text-align: left;padding-left: 16px;">
			<div style="font-size: 10pt;text-align: left;">
				<div>CONTACT NAME</div>
				<div>PHONE</div>
				<div>EMAIL</div>
			</div>
		</th>
      </tr>
	  
      <tr>
        <th style="width:33.33%;text-align: center;background: #ae1e23;color: white;font-size: 12pt;">
			Payment Term
		</th>
        <th style="width:33.33%;text-align: center;background: #ae1e23;color: white;font-size: 12pt;">
			Delivery Term
		</th>
        <th style="width:33.33%;text-align: center;background: #ae1e23;color: white;font-size: 12pt;">
			Delivery Date
		</th>
      </tr>
      <tr>
        <th style="width:33.33%;text-align: center;font-size: 10pt;text-transform:capitalize;">
			<?=$payment_term_title; ?>
		</th>
        <th style="width:33.33%;text-align: center;font-size: 10pt;text-transform:capitalize;">
			<?=$delivery_period_title; ?>
		</th>
        <th style="width:33.33%;text-align: center;font-size: 10pt;text-transform:capitalize;">
			<?=$delivery_date; ?>
		</th>
      </tr>
	  
      <tr>
        <th style="width:33.33%;text-align: center;background: #ae1e23;color: white;font-size: 12pt;">
			Requisition
		</th>
        <th style="width:33.33%;text-align: center;background: #ae1e23;color: white;font-size: 12pt;">
			JOB ORDER
		</th>
        <th style="width:33.33%;text-align: center;background: #ae1e23;color: white;font-size: 12pt;">
			CREATED BY
		</th>
      </tr>
      <tr>
        <th style="width:33.33%;text-align: center;font-size: 10pt;text-transform:capitalize;">
			<?=$requisition_ref; ?>
		</th>
        <th style="width:33.33%;text-align: center;font-size: 10pt;text-transform:capitalize;">
			<?=$job_order_id; ?>
		</th>
        <th style="width:33.33%;text-align: center;font-size: 10pt;text-transform:capitalize;">
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
					<th style="text-align: center;background: #ae1e23;color: white;font-size: 10pt;border-bottom: 1px solid #000;">
						<?=lang('NO.'); ?>
					</th>
					<th style="width:40%;text-align: center;background: #ae1e23;color: white;font-size: 10pt;border-bottom: 1px solid #000;">
						<?=lang('ITEM'); ?>
					</th>
					<th style="width:10%;text-align: center;background: #ae1e23;color: white;font-size: 10pt;border-bottom: 1px solid #000;">
						<?=lang('QTY'); ?>
					</th>
					<th style="text-align: center;background: #ae1e23;color: white;font-size: 10pt;border-bottom: 1px solid #000;">
						<?=lang('UOM'); ?>
					</th>
					<th style="text-align: center;background: #ae1e23;color: white;font-size: 10pt;border-bottom: 1px solid #000;">
						<?=lang('U.P'); ?>
					</th>
					<th style="text-align: center;background: #ae1e23;color: white;font-size: 10pt;border-bottom: 1px solid #000;">
						<?=lang('TOTAL'); ?>( <span id="cur_name_view"><?=$currency_name; ?></span> )
					</th>
				</tr>
			</thead>
			
			<tbody>
			
<?php
	$ItemsTotal = 0;
	$qu_purchase_orders_items_sel = "SELECT * FROM  `purchase_orders_items` WHERE `po_id` = $po_id";
	$qu_purchase_orders_items_EXE = mysqli_query($KONN, $qu_purchase_orders_items_sel);
	if(mysqli_num_rows($qu_purchase_orders_items_EXE)){
		$COUNT = 0;
		while($purchase_orders_items_REC = mysqli_fetch_assoc($qu_purchase_orders_items_EXE)){
			$thsTot = 0;
			$COUNT++;
			$po_item_id             = $purchase_orders_items_REC['po_item_id'];
			$family_id              = $purchase_orders_items_REC['family_id'];
			$section_id             = $purchase_orders_items_REC['section_id'];
			$division_id            = $purchase_orders_items_REC['division_id'];
			$subdivision_id         = $purchase_orders_items_REC['subdivision_id'];
			$category_id            = $purchase_orders_items_REC['category_id'];
			$item_code_id           = $purchase_orders_items_REC['item_code_id'];
			$unit_id                = $purchase_orders_items_REC['unit_id'];
			$item_qty               = ( double ) $purchase_orders_items_REC['item_qty'];
			$item_price             = ( double ) $purchase_orders_items_REC['item_price'];
			$certificate_required   = $purchase_orders_items_REC['certificate_required'];
			
			
			$thsTot = $item_qty * $item_price;
			$ItemsTotal = $ItemsTotal + $thsTot;
		$item_unit_name = get_item_unit_name( $purchase_orders_items_REC['item_code_id'], $KONN );
			
		$family_id = $purchase_orders_items_REC['family_id'];
		$lv2       = $purchase_orders_items_REC['section_id'];
		$lv3       = $purchase_orders_items_REC['division_id'];
		$lv4       = $purchase_orders_items_REC['subdivision_id'];
		$lv5       = $purchase_orders_items_REC['category_id'];
		
		$item_name = get_item_name( $purchase_orders_items_REC['item_code_id'], $lv5, $lv4, $lv3, $lv2, 1, $KONN );
		?>
<tr>
	<td style="text-align:center;border: 1px solid #000;background: rgba(0,0,0,0.1);padding: 5px 0;font-size: 10pt;">
	<?=$COUNT; ?>
	</td>
	<td style="text-align:center;border: 1px solid #000;background: rgba(0,0,0,0.1);padding: 5px 0;font-size: 10pt;">
	<?=$item_name; ?>
	</td>
	<td style="text-align:center;border: 1px solid #000;background: rgba(0,0,0,0.1);padding: 5px 0;font-size: 10pt;">
	<?=$item_qty; ?>
	</td>
	<td style="text-align:center;border: 1px solid #000;background: rgba(0,0,0,0.1);padding: 5px 0;font-size: 10pt;">
	<?=$item_unit_name; ?>
	</td>
	<td style="text-align:center;border: 1px solid #000;background: rgba(0,0,0,0.1);padding: 5px 0;font-size: 10pt;">
	<?=number_format($item_price, 3); ?>
	</td>
	<td style="text-align:center;border: 1px solid #000;background: rgba(0,0,0,0.1);padding: 5px 0;font-size: 10pt;">
	<?=number_format($thsTot, 3); ?>
	</td>
</tr>
		<?php
		}
	}
?>

<?php
$ItemsTotal = $ItemsTotal - $discount_amount;
?>

<tr style="font-size: 10pt;">
	<td colspan="4" style="border: 1px solid #000;">&nbsp;</td>
	<td style="text-align:right;border: 1px solid #000;">
	Discount Amount (<?=$discount_percentage; ?> %)
	</td>
	<td style="text-align:center;border: 1px solid #000;">
		<?=number_format($discount_amount, 3); ?>
	</td>
</tr>
<tr style="font-size: 10pt;">
	<td colspan="4" style="border: 1px solid #000;">&nbsp;</td>
	<td style="text-align:right;border: 1px solid #000;">Sub Total</td>
	<td style="text-align:center;border: 1px solid #000;">
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
	<td colspan="4" style="border: 1px solid #000;">&nbsp;</td>
	<td style="text-align:right;border: 1px solid #000;">Total Vat Amount</td>
	<td style="text-align:center;border: 1px solid #000;">
		<?=number_format($VAT, 3); ?>
	</td>
</tr>
<?php
}
?>
<tr style="font-size: 10pt;">
	<td colspan="4" style="border: 1px solid #000;">&nbsp;</td>
	<td style="text-align:right;border: 1px solid #000;">Total</td>
	<td style="text-align:center;border: 1px solid #000;">
		<?=number_format($totAL, 3); ?>
	</td>
</tr>

			</tbody>
		</table>
		 
		 
		 
		 
		 
		 </td>
      </tr>

      <tr>
         <td colspan="3"><br></td>
      </tr>
      <tr>
         <td colspan="3">
		 
		
	<table style="width:100%;margin: 0 auto;border-collapse: separate;border-spacing: 0;">
			<thead>
				<tr>
					<th style="text-align: center;background: #ae1e23;color: white;font-size: 10pt;border-bottom: 1px solid #000;">
						<?=lang('NO.'); ?>
					</th>
					<th style="width:95%;text-align: center;background: #ae1e23;color: white;font-size: 10pt;border-bottom: 1px solid #000;">
						<?=lang('Conditions And Terms'); ?>
					</th>
				</tr>
			</thead>
			<tbody>
<?php
	$qu_purchase_orders_terms_sel = "SELECT * FROM  `purchase_orders_terms` WHERE `po_id` = $po_id";
	$qu_purchase_orders_terms_EXE = mysqli_query($KONN, $qu_purchase_orders_terms_sel);
	if(mysqli_num_rows($qu_purchase_orders_terms_EXE)){
		$CC=0;
		while($purchase_orders_terms_REC = mysqli_fetch_assoc($qu_purchase_orders_terms_EXE)){
			$CC++;
			$record_id = $purchase_orders_terms_REC['record_id'];
			$term_id = $purchase_orders_terms_REC['term_id'];
			
			$qu_purchase_orders_terms_list_sel = "SELECT `term_title` FROM  `purchase_orders_terms_list` WHERE `term_id` = $term_id";
			$qu_purchase_orders_terms_list_EXE = mysqli_query($KONN, $qu_purchase_orders_terms_list_sel);
			$purchase_orders_terms_list_DATA;
			if(mysqli_num_rows($qu_purchase_orders_terms_list_EXE)){
				$purchase_orders_terms_list_DATA = mysqli_fetch_assoc($qu_purchase_orders_terms_list_EXE);
			}
				$term_title = $purchase_orders_terms_list_DATA['term_title'];

			
			
		?>
<tr style="font-size: 10pt;">
	<td style="text-align:center;border: 1px solid #000;"><?=$CC; ?></td>
	<td style="text-align:left;border: 1px solid #000;padding-left:10px;"><?=$term_title; ?></td>
</tr>
		<?php
		}
	}
?>
			</tbody>
		 </td>
      </tr>
	  
	  
	  
	  
	  
   </tbody>
</table>




<script>

</script>
</body>
</html>
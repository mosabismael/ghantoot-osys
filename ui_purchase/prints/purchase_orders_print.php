<?php
	require_once('../../bootstrap/app_config.php');
	require_once('../../bootstrap/chk_log_user.php');
	$page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	// $page_title=$page_description=$page_keywords=$page_author= "Site Title";
	
	
$site_logo =  $SETTINGS['site_logo'];

	
	
	
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
	
		$po_ref = $purchase_orders_DATA['po_ref'];
		$rev_no = $purchase_orders_DATA['rev_no'];
		$po_date = $purchase_orders_DATA['po_date'];
		$due_date = $purchase_orders_DATA['due_date'];
		$delivery_date = $purchase_orders_DATA['delivery_date'];
		$delivery_period_id = $purchase_orders_DATA['delivery_period_id'];
		$discount_amount = $purchase_orders_DATA['discount_amount'];
		$is_vat_included = $purchase_orders_DATA['is_vat_included'];
		$payment_term_id = $purchase_orders_DATA['payment_term_id'];
		$currency_id = $purchase_orders_DATA['currency_id'];
		$exchange_rate = $purchase_orders_DATA['exchange_rate'];
		$mrv_id = $purchase_orders_DATA['mrv_id'];
		$notes = $purchase_orders_DATA['notes'];
		$po_status = $purchase_orders_DATA['po_status'];
		$price_list_id = $purchase_orders_DATA['price_list_id'];
		$supplier_id = $purchase_orders_DATA['supplier_id'];
		$po_id = $purchase_orders_DATA['po_id'];
		$employee_id = $purchase_orders_DATA['employee_id'];
	
		$qu_pur_requisitions_pls_sel = "SELECT `supplier_quotation_ref` FROM  `pur_requisitions_pls` WHERE `price_list_id` = $price_list_id";
	$qu_pur_requisitions_pls_EXE = mysqli_query($KONN, $qu_pur_requisitions_pls_sel);
	$supplier_quotation_ref = 'NA';
	if(mysqli_num_rows($qu_pur_requisitions_pls_EXE)){
		$pur_requisitions_pls_DATA = mysqli_fetch_assoc($qu_pur_requisitions_pls_EXE);
		$supplier_quotation_ref = $pur_requisitions_pls_DATA['supplier_quotation_ref'];
	}

	
	
		
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
		$address = $suppliers_list_DATA['address'];
		$trn_no = $suppliers_list_DATA['trn_no'];

		
		
		
		
	$qu_hr_employees_sel = "SELECT * FROM  `hr_employees` WHERE `employee_id` = $employee_id";
	$qu_hr_employees_EXE = mysqli_query($KONN, $qu_hr_employees_sel);
	$hr_employees_DATA;
	if(mysqli_num_rows($qu_hr_employees_EXE)){
		$hr_employees_DATA = mysqli_fetch_assoc($qu_hr_employees_EXE);
	}
	
		$employee_code = $hr_employees_DATA['employee_code'];
		$first_name = $hr_employees_DATA['first_name'];
		$last_name = $hr_employees_DATA['last_name'];
		
		
		$employee_name = $first_name.' '.$last_name;
		
		
		
		
		
		$THS_REF = $po_ref.'RFQ'.$po_id;
?>
<!DOCTYPE html>
<html dir="<?=$lang_dir; ?>" lang="<?=$lang; ?>">
<html>
<head>

	<meta name="charset" content="UTF-8">
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <?php include('../app/assets.php'); ?>
	
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?=$THS_REF; ?></title>
	
	
	
<!-- Jquery files -->
<script type="text/javascript" src="../<?=assets_root; ?>js/jquery-2.0.3.min.js"></script>
<script type="text/javascript" src="../<?=assets_root; ?>js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="../<?=assets_root; ?>barcode/jquery-barcode.js"></script>


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
</style>

</head>



<body id="contenter">


<table style="width:100%;margin: 0 auto;">
   <thead class="repeatable">
      <tr>
         <th>
<div style="text-align:left;width:45%;display:inline-block;vertical-align:bottom;">
<img src="../<?=uploads_root.$site_logo; ?>" alt="System logo">
</div>
<div style="text-align:right;width:45%;display:inline-block;vertical-align:bottom;">
	<h2>Purchase Order</h2>
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
	  
      <tr>
         <td>
		 <br>
		 
<div style="text-align:center;width:30%;display:inline-block;vertical-align:bottom;">
	<h4 style="text-align:center;">Created Date</h4>
	<span><?=$po_date; ?></span>
</div>

<div style="text-align:center;width:30%;display:inline-block;vertical-align:bottom;">
	<h4 style="text-align:center;">PO Ref</h4>
	<span><?=$po_ref; ?></span>
</div>

<div style="text-align:center;width:30%;display:inline-block;vertical-align:bottom;">
	<h4 style="text-align:center;">Created By</h4>
	<span><?=$employee_name; ?></span>
</div>
	<hr style="opacity:0.05;">
		 
		 
		 </td>
      </tr>
      <tr>
         <td>
		 <br>
<div style="text-align:left;width:90%;margin:0 auto;display:block;vertical-align:bottom;">
	<h4 style="text-align:left;margin: 0;">TO :</h4>
	<span><?=$supplier_name; ?></span><br>
</div>
	<hr style="opacity:0.05;">
		 
		 
		 </td>
      </tr>
	  
	  
	  
	  
      <tr>
         <td>
		 <hr>
<table style="width: 100%;margin:0 auto;">
				<thead>
					<tr>
						<th><?=lang('No.'); ?></th>
						<th><?=lang('Item'); ?></th>
						<th><?=lang('Qty'); ?></th>
						<th><?=lang('UOM'); ?></th>
						<th><?=lang('U.P.'); ?></th>
						<th><?=lang('Total'); ?></th>
					</tr>
				</thead>
				<tbody>
<?php
	$itemC = 0;
	$SUB_TOT = 0;
	$qu_purchase_orders_items_sel = "SELECT * FROM  `purchase_orders_items` 
										WHERE ((`po_id` = $po_id) )";
	
	$qu_purchase_orders_items_EXE = mysqli_query($KONN, $qu_purchase_orders_items_sel);
	if(mysqli_num_rows($qu_purchase_orders_items_EXE)){
	
		while($purchase_orders_items_REC = mysqli_fetch_assoc($qu_purchase_orders_items_EXE)){
			$itemC++;
			$po_item_id = $purchase_orders_items_REC['po_item_id'];
			$item_qty = (double) $purchase_orders_items_REC['item_qty'];
			$item_price = (double) $purchase_orders_items_REC['item_price'];
			$item_code_id = $purchase_orders_items_REC['item_code_id'];
			
			$hirarcy = get_item_name( $item_code_id, $KONN );
			$unit_name = get_item_unit_name( $item_code_id, $KONN );
			
			$thsTot = $item_qty * $item_price;
			$SUB_TOT = $SUB_TOT + $thsTot;
		?>
<tr>

<td class="item-c"><?=$itemC; ?></td>
<td><?=$hirarcy; ?></td>
<td><?=$item_qty; ?></td>
<td><?=$unit_name; ?></td>
<td><?=$item_price; ?></td>
<td><?=number_format($thsTot, 3); ?></td>
</tr>
		<?php
		}
	}
?>

<tr>
	<td colspan="4">&nbsp;</td>
	<td style="text-align:right;"><?=lang("Sub_Total", "AAR"); ?> :</td>
	<td><?=number_format($SUB_TOT, 3); ?></td>
</tr>

<tr>
	<td colspan="4">&nbsp;</td>
	<td style="text-align:right;"><?=lang("Discount", "AAR"); ?> :</td>
	<td><?=number_format($discount_amount, 3); ?></td>
</tr>
<?php
$totBeforeVAT = 0;
$totBeforeVAT = $SUB_TOT - $discount_amount;
$totAfterVAT = $totBeforeVAT;
?>

<?php

if( $is_vat_included == 1 ){
	$VAT_amount = $totBeforeVAT * 0.05;
	$totAfterVAT = $totBeforeVAT + $VAT_amount;
?>
<tr>
	<td colspan="4">&nbsp;</td>
	<td style="text-align:right;"><?=lang("Total_Before_VAT", "AAR"); ?> :</td>
	<td><?=number_format($totBeforeVAT, 3); ?></td>
</tr>
<tr>
	<td colspan="4">&nbsp;</td>
	<td style="text-align:right;"><?=lang("VAT_amount", "AAR"); ?> (5%) :</td>
	<td><?=number_format($VAT_amount, 3); ?></td>
</tr>

<?php
}
?>
<tr>
	<td colspan="4">&nbsp;</td>
	<td style="text-align:right;"><?=lang("Total", "AAR"); ?> :</td>
	<td><?=number_format($totAfterVAT, 3); ?></td>
</tr>

<tr>
	<td colspan="6">&nbsp;</td>
</tr>
<tr>
	<td colspan="6">&nbsp;</td>
</tr>

				</tbody>
			</table>
		 </td>
      </tr>
	  
	  
	  
	  
      <tr>
		 <td><hr>
		 </td>
      </tr>
	  
   </tbody>
</table>




<script>

</script>
</body>
</html>
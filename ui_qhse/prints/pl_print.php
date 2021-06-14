<?php
	require_once('../../bootstrap/app_config.php');
	require_once('../../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "Site Title";
	
	
	$site_logo =  'logo22.png';

	
	
	
	$rfq_id = 0;
	if( !isset( $_GET['rfq_id'] ) ){
		header("location:../index.php");
	} else {
		$rfq_id = (int) test_inputs( $_GET['rfq_id'] );
	}
	
	
		$qu_pur_requisitions_rfq_sel = "SELECT * FROM  `pur_requisitions_rfq` WHERE `rfq_id` = $rfq_id";
	$qu_pur_requisitions_rfq_EXE = mysqli_query($KONN, $qu_pur_requisitions_rfq_sel);
	$pur_requisitions_rfq_DATA;
	if(mysqli_num_rows($qu_pur_requisitions_rfq_EXE)){
		$pur_requisitions_rfq_DATA = mysqli_fetch_assoc($qu_pur_requisitions_rfq_EXE);
	}

		$supplier_id = $pur_requisitions_rfq_DATA['supplier_id'];
		$requisition_id = $pur_requisitions_rfq_DATA['requisition_id'];
		$created_date = $pur_requisitions_rfq_DATA['created_date'];
		$employee_id = $pur_requisitions_rfq_DATA['employee_id'];
		
	$qu_pur_requisitions_sel = "SELECT * FROM  `pur_requisitions` WHERE `requisition_id` = $requisition_id";
	$qu_pur_requisitions_EXE = mysqli_query($KONN, $qu_pur_requisitions_sel);
	$pur_requisitions_DATA;
	if(mysqli_num_rows($qu_pur_requisitions_EXE)){
		$pur_requisitions_DATA = mysqli_fetch_assoc($qu_pur_requisitions_EXE);
	}

		$created_date = $pur_requisitions_DATA['created_date'];
		$required_date = $pur_requisitions_DATA['required_date'];
		$estimated_date = $pur_requisitions_DATA['estimated_date'];
		$requisition_ref = $pur_requisitions_DATA['requisition_ref'];
		$requisition_type = $pur_requisitions_DATA['requisition_type'];
		$job_order_id = $pur_requisitions_DATA['job_order_id'];
		$requisition_status = $pur_requisitions_DATA['requisition_status'];
		$requisition_notes = $pur_requisitions_DATA['requisition_notes'];
		$ordered_by = $pur_requisitions_DATA['ordered_by'];
		
		
		
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
		
		
		
		
		
		$THS_REF = $requisition_ref.'RFQ'.$rfq_id;
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
	<h2>Request For Quotation</h2>
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
	<span><?=$created_date; ?></span>
</div>

<div style="text-align:center;width:30%;display:inline-block;vertical-align:bottom;">
	<h4 style="text-align:center;">Requisition Ref</h4>
	<span><?=$requisition_ref; ?></span>
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
	<span>please quote us with your best prices on the items showed below</span>
</div>
	<hr style="opacity:0.05;">
		 
		 
		 </td>
      </tr>
	  
	  
	  
	  
      <tr>
         <td>
		 <hr>
<table style="width: 100%;margin:0 auto;">
	<thead style="text-align:center;">
		<tr>
			<th><?=lang("NO", "AAR"); ?></th>
			<th><?=lang("Item", "AAR"); ?></th>
			<th><?=lang("Qty","AAR"); ?></th>
			<th><?=lang("UOM","AAR"); ?></th>
		</tr>
	</thead>
	<tbody>
<?php
	$CC = 0;
	$qu_pur_requisitions_rfq_items_sel = "SELECT * FROM  `pur_requisitions_rfq_items` WHERE ( (`rfq_id` = $rfq_id ) )";
	$qu_pur_requisitions_rfq_items_EXE = mysqli_query($KONN, $qu_pur_requisitions_rfq_items_sel);
	if(mysqli_num_rows($qu_pur_requisitions_rfq_items_EXE)){
		while($pur_requisitions_rfq_items_REC = mysqli_fetch_assoc($qu_pur_requisitions_rfq_items_EXE)){
			$CC++;
			$rfq_item_id = $pur_requisitions_rfq_items_REC['rfq_item_id'];
			$req_item_id = $pur_requisitions_rfq_items_REC['req_item_id'];
			$supplier_id = $pur_requisitions_rfq_items_REC['supplier_id'];
			$rfq_id = $pur_requisitions_rfq_items_REC['rfq_id'];
				
				
				
	$qu_pur_requisitions_items_sel = "SELECT * FROM  `pur_requisitions_items` WHERE `req_item_id` = $req_item_id";
	$qu_pur_requisitions_items_EXE = mysqli_query($KONN, $qu_pur_requisitions_items_sel);
	$pur_requisitions_items_DATA;
	if(mysqli_num_rows($qu_pur_requisitions_items_EXE)){
		$pur_requisitions_items_DATA = mysqli_fetch_assoc($qu_pur_requisitions_items_EXE);
	}
		$req_item_id = $pur_requisitions_items_DATA['req_item_id'];
		$family_id = $pur_requisitions_items_DATA['family_id'];
		$section_id = $pur_requisitions_items_DATA['section_id'];
		$division_id = $pur_requisitions_items_DATA['division_id'];
		$subdivision_id = $pur_requisitions_items_DATA['subdivision_id'];
		$category_id = $pur_requisitions_items_DATA['category_id'];
		$item_code_id = $pur_requisitions_items_DATA['item_code_id'];
		$item_qty = $pur_requisitions_items_DATA['item_qty'];
		$certificate_required = $pur_requisitions_items_DATA['certificate_required'];
		$item_unit_id = $pur_requisitions_items_DATA['item_unit_id'];
		$requisition_id = $pur_requisitions_items_DATA['requisition_id'];


		$lv2 = $pur_requisitions_items_DATA['section_id'];
		$lv3 = $pur_requisitions_items_DATA['division_id'];
		$lv4 = $pur_requisitions_items_DATA['subdivision_id'];
		$lv5 = $pur_requisitions_items_DATA['category_id'];
		
			$item_name = get_item_name( $item_code_id, $lv5, $lv4, $lv3, $lv2, 1, $KONN );
			
			$unit_name = get_item_unit_name( $item_code_id, $KONN );
			
		?>
		<tr>
			<td><?=$CC; ?></td>
			<td><?=$item_name; ?></td>
			<td><?=$item_qty; ?></td>
			<td><?=$unit_name; ?></td>
		</tr>
		
		<?php
		}
	}
?>

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
<?php
	require_once('../../bootstrap/app_config.php');
	require_once('../../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "Site Title";
	
	
	$site_logo =  'logo22.png';

	
	
	if(!isset($_GET['requisition_id'])){
		die('7wiusss');
	}
	if(!isset($_GET['req_item_id'])){
		die('7wiu02');
	}
	
	$requisition_id = (int) $_GET['requisition_id'];
	$req_item_id    = (int) $_GET['req_item_id'];
	
	
	
	
?>
<!DOCTYPE html>
<html dir="<?=$lang_dir; ?>" lang="<?=$lang; ?>">
<html>
<head>

	<meta name="charset" content="UTF-8">
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <?php include('../app/assets.php'); ?>
	
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Comparison Sheet</title>
	
	
	
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
	<h2>Comparison Sheet</h2>
</div>
<hr>
		 </th>
      </tr>
   </thead>
   <tbody>
   
      <tr>
         <td id="fetched_CS"></td>
      </tr>
	  
	  
	  
	  
	  
	  
      <tr><td><hr></td></tr>
   </tbody>
</table>

<script>
function loadComparisonSheet(){
	$('#fetched_CS').html( '' );
	
	$.ajax({
		url      :"../<?=api_root; ?>requisitions/load_cs_details.php",
		data     :{ 'is_print': '1', 'requisition_id': <?=$requisition_id; ?>, 'req_item_id': <?=$req_item_id; ?> },
		dataType :"html",
		type     :'POST',
		success  :function( response ){
				$('#fetched_CS').html( response );
			},
		error    :function(){
				end_loader();
			alert('Data Error No: 5467653');
			},
		});
}

loadComparisonSheet();
</script>

</body>
</html>
<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 4;
	$subPageID = 11;
	
	$RES = '';


	
	$asset_id = 0;
	
	if( isset( $_GET['asset_id'] ) ){
		$asset_id = ( int ) $_GET['asset_id'];
	} else {
		header("location:inv_assets.php?noBill=1");
	}
	
	
	$qu_inv_assets_sel = "SELECT * FROM  `inv_assets` WHERE `asset_id` = $asset_id";
	$qu_inv_assets_EXE = mysqli_query($KONN, $qu_inv_assets_sel);
	$inv_assets_DATA;
	if(mysqli_num_rows($qu_inv_assets_EXE)){
		$inv_assets_DATA = mysqli_fetch_assoc($qu_inv_assets_EXE);
	} else {
		header("location:inv_assets.php?noBill=2");
		die();
	}
	
		$asset_tag = $inv_assets_DATA['asset_tag'];
		$asset_name = $inv_assets_DATA['asset_name'];
		$asset_sno = $inv_assets_DATA['asset_sno'];
		$asset_brand = $inv_assets_DATA['asset_brand'];
		$asset_po = $inv_assets_DATA['asset_po'];
		$asset_certificate = $inv_assets_DATA['asset_certificate'];
		$asset_status = $inv_assets_DATA['asset_status'];
		$asset_cat_id = $inv_assets_DATA['asset_cat_id'];

?>
<!DOCTYPE html>
<html dir="<?=$lang_dir; ?>" lang="<?=$lang; ?>">
<head>
	<?php include('app/meta.php'); ?>
    <?php include('app/assets.php'); ?>
</head>
<body>
<?php

	$WHERE = "inv_assets";
	include('app/header.php');
	//PAGE DATA START -----------------------------------------------///---------------------------------
?>



<div class="row">
	<div class="col-100">
	


<div class="row">
	<div class="col-100">

<form id="upload_form" enctype="multipart/form-data" method="post" style="border-bottom: 1px solid rgba(0,0,0,0.1);">

<input class="frmData" type="hidden" 
		id="new-asset_id" 
		name="asset_id" 
		value="<?=$asset_id; ?>" 
		req="1" 
		den="0" 
		alerter="<?=lang("Please_Check_asset_id", "AAR"); ?>">


	<div class="row">
		<div class="zero"></div>
	</div>
	
	<div class="zero"></div>





<div class="zero"></div>
<div class="col-33">
	<div class="nwFormGroupCol">
		<label class="lbl_class"><?=lang('Document_File', 'ARR', 1); ?></label>
		<input class="frmData" type="file" 
				id="file1" name="file_array[]"
				req="1" 
				den="0" 
				value="0" 
				alerter="<?=lang("Please_Check_Document_File", "AAR"); ?>">
		<label class="text-center col-100 text-danger" style="font-size: 13px;line-height: 1;"><?=lang('Max Allowed File Size : 3 MB, Allowed Extensions : jpg, png, txt, docx, pdf, mp4'); ?></label>
	</div>
</div>


<div class="col-33">
	<div class="nwFormGroupCol">
		<label><?=lang('file_link'); ?></label>
		<textarea class="frmData" 
				id="new-file_local_link" 
				name="file_local_link" 
				req="0" 
				den="0" 
				alerter="<?=lang("Please_Check_Description", "AAR"); ?>"></textarea>
	</div>
</div>



<div class="col-33">
	<div class="nwFormGroupCol">
		<label class="lbl_class"><?=lang('Document_Details', 'ARR', 1); ?></label>
		<textarea class="frmData" 
				id="new-media_description" 
				name="media_description" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_Description", "AAR"); ?>"></textarea>
	</div>
</div>


	<div class="zero"></div>

	<div class="form-alerts"></div>
	<div class="zero"></div>

<div class="col-100">
	<div class="viewerBodyButtons">
		<button onclick="uploadFile();" id="upload-btn" type="button"><?=lang('Upload', 'ARR', 1); ?></button>
	</div>
</div>

<div class="form-grp">
	<div class="form-item col-100">
		<div id="upload_result" style="visibility:hidden;">
		  <progress id="progressBar" value="0" max="100" style="width:100%;"></progress>
		  <h3 id="status"></h3>
		  <p id="loaded_n_total"></p>
		</div>
	</div>
</div>

					<div class="zero"></div>
</form>
		
		
	</div>
	<div class="zero"></div>
</div>

	<script>

	function _(el){
		return document.getElementById(el);
	}
	function uploadFile(){
		$('#upload-btn').prop('disabled', true);
		var file = _("file1").files[0];
		var asset_id = $('#new-asset_id').val();
		var description = $('#new-media_description').val();
		var file_local_link = $('#new-file_local_link').val();
		
		
		
		
		if( file ){
			if( description != '' ){
				$('#upload_result').css('visibility', 'visible');
				var formdata = new FormData();
				formdata.append("file1", file);
				formdata.append("asset_id", asset_id);
				formdata.append("media_description", description);
				formdata.append("file_local_link", file_local_link);
				
				var ajax = new XMLHttpRequest();
				ajax.upload.addEventListener("progress", progressHandler, false);
				ajax.addEventListener("load", completeHandler, false);
				ajax.addEventListener("error", errorHandler, false);
				ajax.addEventListener("abort", abortHandler, false);
				ajax.open("POST", "<?=api_root; ?>inv_assets/media_parser.php");
				ajax.send(formdata);
			} else {
				alert("Please Insert Description");
				$('#upload-btn').prop('disabled', false);
			}
		} else {
			alert("Please Select File to Upload");
			$('#upload-btn').prop('disabled', false);
		}
	}
	function progressHandler(event){
		_("loaded_n_total").innerHTML = "Uploaded "+event.loaded+" bytes of "+event.total;
		var percent = (event.loaded / event.total) * 100;
		_("progressBar").value = Math.round(percent);
		_("status").innerHTML = Math.round(percent)+"% uploaded... please wait";
	}
	function completeHandler(event){
		_("status").innerHTML = event.target.responseText;
		_("progressBar").value = 100;
		_("loaded_n_total").innerHTML = "";
		clearThings();
	}
	function errorHandler(event){
		_("status").innerHTML = "Upload Failed, please check your file";
		clearThings();
	}
	function abortHandler(event){
		_("status").innerHTML = "Upload Aborted by user";
		clearThings();
	}
	
	
	function clearThings(){
		$('#upload-btn').prop('disabled', false);
		$("#file1").val('');
		$('#new-media_description').val('');
		fetch_biling_media();
	}
</script>
	
	
	
	</div>
	<div class="zero"></div>
</div>

	<table class="tabler">
		<thead>
			<tr>
				<th><?=lang("Preview","AAR"); ?></th>
				<th><?=lang("Link", "AAR"); ?></th>
				<th><?=lang("Date", "AAR"); ?></th>
				<th><?=lang("Description", "AAR"); ?></th>
				<th><?=lang("By", "AAR"); ?></th>
				<th><?=lang("Type","AAR"); ?></th>
			</tr>
		</thead>
		<tbody id="fetched_biling_media"></tbody>
	</table>
<script>
function fetch_biling_media(){
	start_loader("Loading Billing Media ...");
			$('#fetched_ststus').html();
			var asset_id = parseInt( $('#new-asset_id').val() );
			$.ajax({
				url      :"<?=api_root; ?>inv_assets/get_media.php",
				data     :{ 'asset_id': asset_id, 'test': asset_id},
				dataType :"html",
				type     :'POST',
				success  :function(data){
						end_loader();
						$('#fetched_biling_media').html(data);
					},
				error    :function(){
					alert('Data Error No: 5467653');
					},
				});
	
}
</script>

<?php
	//PAGE DATA END   ----------------------------------------------///---------------------------------
	include('app/footer.php');
?>
<script>
fetch_biling_media();
</script>
</body>
</html>
<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "Inv Coding";
	
	
	$menuId = 2;
	$subPageID = 7;
?>
<!DOCTYPE html>
<html dir="<?=$lang_dir; ?>" lang="<?=$lang; ?>">
<html>
<head>
	<?php include('app/meta.php'); ?>
    <?php include('app/assets.php'); ?>
</head>
<body>
<?php
	include('app/header.php');
	//PAGE DATA START -----------------------------------------------///---------------------------------
?>

<div class="row">
	<div class="col-100">
	<div class="search-box" style = "margin-top:-3%">
        <input type="text" id = "searchresult" autocomplete="off" placeholder="Search Coding..." />
        <div class="result" id = "result"></div>
		<div class = "enterButton" onclick = "drawLastChart()"><i class="fas fa-arrow-right"></i></div>
		<div class="text-left topmargin">
	
<?php
	$qu_inv_01_families_sel = "SELECT * FROM  `inv_01_families` ORDER BY `family_name` ASC";
	$qu_inv_01_families_EXE = mysqli_query($KONN, $qu_inv_01_families_sel);
	if(mysqli_num_rows($qu_inv_01_families_EXE)){
		$CC = 0;
		while($inv_01_families_REC = mysqli_fetch_assoc($qu_inv_01_families_EXE)){
			$family_id = $inv_01_families_REC['family_id'];
			
			$CC++;
			
		
		?>
			<div class="box-view" id="boxdata-<?=$family_id; ?>">
				<span class="id"><?=$family_id; ?></span>
				<span class="iconer"><i class="<?=$inv_01_families_REC["family_icon"]; ?>"></i></span>
				<h1 class="cell-title"><?=$inv_01_families_REC["family_name"]; ?></h1>
				<div class="opt">
					<a href="inv_lvl02.php?ids=<?=$family_id; ?>"><i class="fas fa-folder-open"></i></a>
					<span class="box-sep"></span>
					<a onclick="edit_data(<?=$family_id; ?>);"><i class="fas fa-edit"></i></a>
					<span class="box-sep"></span>
					<a onclick="edit_desc_data(<?=$family_id; ?>);"><i class="fas fa-list"></i></a>
				</div>
			</div>
		<?php
		
		}
	}
	
?>
	
			<div class="box-view" id="boxdata-0" onclick="add_new_modal_inv_01_families();" style="opacity:0.8;">
				<span class="id">&nbsp;</span>
				<span class="iconer"><i class="far fa-plus-square"></i></span>
				<h1>ADD NEW</h1>
				<div class="opt">
					<a>&nbsp;</a>
				</div>
			</div>
		</div>
	</div>
	
	
	<div class="zero"></div>
</div>





























<!--    ///////////////////      add_new_modal_inv_01_families Modal START    ///////////////////            -->
<div class="modal" id="add_new_modal_inv_01_families">
	<div class="modal-container">
		<div class="modal-header">
			<?php include("app/modal_header.php"); ?>
		</div>
		<div class="modal-body">
			
				<form 
				id="add-new-inv01-form" 
				id-modal="add_new_modal_inv_01_families" 
				class="boxes-holder" 
				api="<?=api_root; ?>inventory/lvl01/add_new.php">



<div class="col-100">
	<div class="form-grp">
		<label>Family Icon</label>
<input class="frmData" type="text" 
		id="new-family_icon" 
		name="family_icon" 
		req="1" 
		den="" 
		alerter="<?=lang("Please_Check_Family_icon", "AAR"); ?>">
	</div>
</div>

<div class="col-50">
	<div class="form-grp">
		<label>Family Code.</label>
<input class="frmData" type="text" 
		id="new-family_code" 
		name="family_code" 
		req="1" 
		den="" 
		alerter="<?=lang("Please_Check_Family_Code", "AAR"); ?>">
	</div>
</div>

<div class="col-50">
	<div class="form-grp">
		<label>Family Name</label>
<input class="frmData" type="text" 
		id="new-family_name" 
		name="family_name" 
		req="1" 
		den="" 
		alerter="<?=lang("Please_Check_Family_Name", "AAR"); ?>">
	</div>
</div>

<!--div class="col-50">
	<div class="form-grp">
		<label>account type</label>
		<select class="frmData" 
				id="new-family_type_id" 
				name="family_type_id" 
				req="1" 
				den="0" 
				alerter="<?=lang("Please_Check_Family_Type", "AAR"); ?>">
					<option value="0" selected>--- Please Select---</option>
<?php
	/*
	$qu_inv_01_families_types_sel = "SELECT `family_type_id`, `family_type_name` FROM  `inv_01_families_types`";
	$qu_inv_01_families_types_EXE = mysqli_query($KONN, $qu_inv_01_families_types_sel);
	if(mysqli_num_rows($qu_inv_01_families_types_EXE)){
		while($inv_01_families_types_REC = mysqli_fetch_array($qu_inv_01_families_types_EXE)){
		?>
		<option value="<?=$inv_01_families_types_REC[0]; ?>"><?=$inv_01_families_types_REC[1]; ?></option>
		<?php
		}
	}
	*/
?>
		</select>
	</div>
</div-->


<div class="col-100">
	<div class="form-grp">
		<label>Family Description</label>
<textarea class="frmData" type="text" 
		id="new-family_description" 
		name="family_description" 
		req="1" 
		den="" 
		alerter="<?=lang("Please_Check_description", "AAR"); ?>"></textarea>
	</div>
</div>


					<div class="zero"></div>


	<div class="form-alerts"></div>
	<div class="zero"></div>

	<div class="viewerBodyButtons">
			<button type="button" onclick="submit_form('add-new-inv01-form', 'reload_page');">
				<?=lang('Add', 'ARR', 1); ?>
			</button>
			<button type="button" onclick="hide_modal();">
				<?=lang('Cancel', 'ARR', 1); ?>
			</button>
	</div>


	

</form>
			
			
		</div>
	</div>
	<div class="zero"></div>
</div>


<!--    ///////////////////      add_new_modal_inv_01_families Modal END    ///////////////////            -->



<!--    ///////////////////      edit_modal_inv_01_families Modal START    ///////////////////            -->
<div class="modal" id="edit_modal_inv_01_families">
	<div class="modal-container">
		<div class="modal-header">
			<?php include("app/modal_header.php"); ?>
		</div>
		<div class="modal-body">
			
				<form 
				id="edit-inv01-form" 
				id-modal="edit_modal_inv_01_families" 
				class="boxes-holder" 
				api="<?=api_root; ?>inventory/lvl01/edit_data.php">


<input class="frmData" type="hidden" 
		id="edit-family_id" 
		name="family_id" 
		req="1" 
		den="0" 
		alerter="<?=lang("Please_Check_Family_icon", "AAR"); ?>">

<div class="col-100">
	<div class="form-grp">
		<label>Family Icon</label>
<input class="frmData" type="text" 
		id="edit-family_icon" 
		name="family_icon" 
		req="1" 
		den="" 
		alerter="<?=lang("Please_Check_Family_icon", "AAR"); ?>">
	</div>
</div>

<div class="col-50">
	<div class="form-grp">
		<label>Family Code.</label>
<input class="frmData" type="text" 
		id="edit-family_code" 
		name="family_code" 
		req="1" 
		den="" 
		alerter="<?=lang("Please_Check_Family_Code", "AAR"); ?>">
	</div>
</div>

<div class="col-50">
	<div class="form-grp">
		<label>Family Name</label>
<input class="frmData" type="text" 
		id="edit-family_name" 
		name="family_name" 
		req="1" 
		den="" 
		alerter="<?=lang("Please_Check_Family_Name", "AAR"); ?>">
	</div>
</div>




<div class="col-100">
	<div class="form-grp">
		<label>Family Description</label>
<textarea class="frmData" type="text" 
		id="edit-family_description" 
		name="family_description" 
		req="1" 
		den="" 
		alerter="<?=lang("Please_Check_description", "AAR"); ?>"></textarea>
	</div>
</div>



					<div class="zero"></div>


	<div class="form-alerts"></div>
	<div class="zero"></div>

	<div class="viewerBodyButtons">
			<button type="button" onclick="submit_form('edit-inv01-form', 'reload_page');">
				<?=lang('Add', 'ARR', 1); ?>
			</button>
			<button type="button" onclick="hide_modal();">
				<?=lang('Cancel', 'ARR', 1); ?>
			</button>
	</div>

	

</form>
			
			
		</div>
	</div>
	<div class="zero"></div>
</div>


<!--    ///////////////////      edit_modal_inv_01_families Modal END    ///////////////////            -->






<!--    ///////////////////      edit_modal_descs_families Modal START    ///////////////////            -->
<div class="modal" id="edit_modal_descs_families">
	<div class="modal-container">
		<div class="modal-header">
			<?php include("app/modal_header.php"); ?>
		</div>
		<div class="modal-body">
			
				<form 
				id="edit-inv01-descs-form" 
				id-modal="edit_modal_descs_families" 
				class="boxes-holder" 
				api="<?=api_root; ?>inventory/lvl01/edit_data_descs.php">


<input class="frmData" type="hidden" 
		id="editer-family_id" 
		name="family_id" 
		req="1" 
		den="0" 
		alerter="<?=lang("Please_Check_Family_icon", "AAR"); ?>">
		
<div class="col-50">
	<div class="form-grp">
		<label>lvl01 Name</label>
<input class="frmData" type="text" 
		id="edit-lvl01" 
		name="lvl01" 
		req="1" 
		den="" 
		alerter="<?=lang("Please_Check_lvl01", "AAR"); ?>">
	</div>
</div>
		
<div class="col-50">
	<div class="form-grp">
		<label>lvl02 Name</label>
<input class="frmData" type="text" 
		id="edit-lvl02" 
		name="lvl02" 
		req="1" 
		den="" 
		alerter="<?=lang("Please_Check_lvl02", "AAR"); ?>">
	</div>
</div>
		
<div class="col-50">
	<div class="form-grp">
		<label>lvl03 Name</label>
<input class="frmData" type="text" 
		id="edit-lvl03" 
		name="lvl03" 
		req="1" 
		den="" 
		alerter="<?=lang("Please_Check_lvl03", "AAR"); ?>">
	</div>
</div>
		
<div class="col-50">
	<div class="form-grp">
		<label>lvl04 Name</label>
<input class="frmData" type="text" 
		id="edit-lvl04" 
		name="lvl04" 
		req="1" 
		den="" 
		alerter="<?=lang("Please_Check_lvl04", "AAR"); ?>">
	</div>
</div>
		
<div class="col-50">
	<div class="form-grp">
		<label>lvl05 Name</label>
<input class="frmData" type="text" 
		id="edit-lvl05" 
		name="lvl05" 
		req="1" 
		den="" 
		alerter="<?=lang("Please_Check_lvl05", "AAR"); ?>">
	</div>
</div>
		
<div class="col-50">
	<div class="form-grp">
		<label>lvl06 Name</label>
<input class="frmData" type="text" 
		id="edit-lvl06" 
		name="lvl06" 
		req="1" 
		den="" 
		alerter="<?=lang("Please_Check_lvl06", "AAR"); ?>">
	</div>
</div>


					<div class="zero"></div>


	<div class="form-alerts"></div>
	<div class="zero"></div>

	<div class="viewerBodyButtons">
			<button type="button" onclick="submit_form('edit-inv01-descs-form', 'reload_page');">
				<?=lang('Save', 'ARR', 1); ?>
			</button>
			<button type="button" onclick="hide_modal();">
				<?=lang('Cancel', 'ARR', 1); ?>
			</button>
	</div>

	

</form>
			
			
		</div>
	</div>
	<div class="zero"></div>
</div>


<!--    ///////////////////      edit_modal_descs_families Modal END    ///////////////////            -->


<script>
function edit_desc_data( ids_id ){
	var titler = '<?=lang("Edit_::", "AAR"); ?>';
	titler = titler + $('#boxdata-' + ids_id + ' .cell-title').text();
	
	$.ajax({
		url      :"<?=api_root; ?>inventory/lvl01/get_desc_data.php",
		data     :{'typo': 'pc_call', 'ids_id': ids_id},
		dataType :"JSON",
		type     :'POST',
		success  :function(response){
			
			$('#editer-family_id').val(response[0].family_id);
			$('#edit-lvl01').val(response[0].lvl01);
			$('#edit-lvl02').val(response[0].lvl02);
			$('#edit-lvl03').val(response[0].lvl03);
			$('#edit-lvl04').val(response[0].lvl04);
			$('#edit-lvl05').val(response[0].lvl05);
			$('#edit-lvl06').val(response[0].lvl06);

			show_modal( 'edit_modal_descs_families' , titler );

				// end_loader();
				
		},
		error    :function(){
			alert('Code Not Applied');
		},
	});
}


function edit_data( ids_id ){
	var titler = '<?=lang("Edit_::", "AAR"); ?>';
	titler = titler + $('#boxdata-' + ids_id + ' .cell-title').text();
	
	$.ajax({
		url      :"<?=api_root; ?>inventory/lvl01/get_data.php",
		data     :{'typo': 'pc_call', 'ids_id': ids_id},
		dataType :"JSON",
		type     :'POST',
		success  :function(response){
			
			$('#edit-family_id').val(response[0].family_id);
			$('#edit-family_code').val(response[0].family_code);
			$('#edit-family_name').val(response[0].family_name);
			$('#edit-family_icon').val(response[0].family_icon);
			$('#edit-family_description').val(response[0].family_description);

			show_modal( 'edit_modal_inv_01_families' , titler );

				// end_loader();
				
		},
		error    :function(){
			alert('Code Not Applied');
		},
	});
}



function add_new_modal_inv_01_families(){
	var titler = '<?=lang("Add_New_Entry", "AAR"); ?>';
	show_modal( 'add_new_modal_inv_01_families' , titler );
}

$(document).ready(function(){
    $('.search-box input[type="text"]').on("keyup input", function(){
        /* Get input value on change */
        var inputVal = $(this).val();
        var resultDropdown = $(this).siblings(".result");
        if(inputVal.length){
            $.get("CodingSearch.php", {term: inputVal}).done(function(data){
                // Display the returned data in browser
                resultDropdown.html(data);
				document.getElementById("result").style.display = "block"; 
            });
        } else{
            resultDropdown.empty();
			document.getElementById("result").style.display = "none"; 
        }
    });
    
    // Set search input value on click of result item
    $(document).on("click", ".result p", function(){
        $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
        $(this).parent(".result").empty();
    });
});
window.onclick = function(event) {
    if (!event.target.matches('#searchresult')) {

        document.getElementById("result").style.display = "none";
        
    }   
}
</script>





<?php
	//PAGE DATA END   ----------------------------------------------///---------------------------------
	include('app/footer.php');
?>
<script>

</script>
</body>
</html>
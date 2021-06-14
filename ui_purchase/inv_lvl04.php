<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "Inv Coding";
	
	
	
	$menuId = 3;
	$subPageID = 12;
	
	
	
	
	$division_id = 0;
	if( !isset( $_GET['ids'] ) ){
		header("location:inv_codification.php");
	} else {
		$division_id = (int) test_inputs( $_GET['ids'] );
	}
	
	
	if( $division_id == 0){
		header("location:inv_codification.php");
	}
	
	
	
	$qu_inv_03_divisions_sel = "SELECT * FROM  `inv_03_divisions` WHERE `division_id` = $division_id";
	$qu_inv_03_divisions_EXE = mysqli_query($KONN, $qu_inv_03_divisions_sel);
	$inv_03_divisions_DATA;
	if(mysqli_num_rows($qu_inv_03_divisions_EXE)){
		$inv_03_divisions_DATA = mysqli_fetch_assoc($qu_inv_03_divisions_EXE);
	}
	
		$division_code = $inv_03_divisions_DATA['division_code'];
		$division_name = $inv_03_divisions_DATA['division_name'];
		$division_description = $inv_03_divisions_DATA['division_description'];
		$section_id = $inv_03_divisions_DATA['section_id'];

	
	
	$qu_inv_02_sections_sel = "SELECT * FROM  `inv_02_sections` WHERE `section_id` = $section_id";
	$qu_inv_02_sections_EXE = mysqli_query($KONN, $qu_inv_02_sections_sel);
	$inv_02_sections_DATA;
	if(mysqli_num_rows($qu_inv_02_sections_EXE)){
		$inv_02_sections_DATA = mysqli_fetch_assoc($qu_inv_02_sections_EXE);
	}
	
		$section_code = $inv_02_sections_DATA['section_code'];
		$section_name = $inv_02_sections_DATA['section_name'];
		$section_description = $inv_02_sections_DATA['section_description'];
		$family_id = $inv_02_sections_DATA['family_id'];

	
	$qu_inv_01_families_sel = "SELECT * FROM  `inv_01_families` WHERE `family_id` = $family_id";
	$qu_inv_01_families_EXE = mysqli_query($KONN, $qu_inv_01_families_sel);
	$inv_01_families_DATA;
	if(mysqli_num_rows($qu_inv_01_families_EXE)){
		$inv_01_families_DATA = mysqli_fetch_assoc($qu_inv_01_families_EXE);
	}
	
		$family_code = $inv_01_families_DATA['family_code'];
		$family_name = $inv_01_families_DATA['family_name'];
		$family_icon = $inv_01_families_DATA['family_icon'];
		$family_description = $inv_01_families_DATA['family_description'];
		
		
		
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
		<div class="page-tree" style="color:red;">
			<a href="inv_codification.php">Main</a>&nbsp; \ &nbsp;
			<a href="inv_lvl02.php?ids=<?=$family_id; ?>"><?=$family_name; ?></a>&nbsp; \ &nbsp;
			<a href="inv_lvl03.php?ids=<?=$section_id; ?>"><?=$section_name; ?></a>&nbsp; \ &nbsp;
			<a><?=$division_name; ?></a>
		</div>
		<br>
	
<?php

	$qu_inv_04_subdivisions_sel = "SELECT * FROM  `inv_04_subdivisions` WHERE (`division_id` = '$division_id') ORDER BY `subdivision_name` ASC";
	$qu_inv_04_subdivisions_EXE = mysqli_query($KONN, $qu_inv_04_subdivisions_sel);
	if(mysqli_num_rows($qu_inv_04_subdivisions_EXE)){
		$CC = 0;
		while($inv_04_subdivisions_REC = mysqli_fetch_assoc($qu_inv_04_subdivisions_EXE)){
			$subdivision_id = $inv_04_subdivisions_REC['subdivision_id'];
			
		?>
			<div class="box-view" id="boxdata-<?=$subdivision_id; ?>">
				<span class="id"><?=$subdivision_id; ?></span>
				<span class="iconer"><?=$inv_04_subdivisions_REC["subdivision_name"]; ?></span>
				<div class="opt">
					<a href="inv_lvl05.php?ids=<?=$subdivision_id; ?>"><i class="fas fa-folder-open"></i></a>
					<span class="box-sep"></span>
					<a onclick="edit_data(<?=$subdivision_id; ?>);"><i class="fas fa-edit"></i></a>
					<span class="box-sep"></span>
					<a onclick="del_data(<?=$subdivision_id; ?>);"><i class="fas fa-trash"></i></a>
				</div>
			</div>
		<?php
		
		}
	}
	
?>
	
			<div class="box-view" id="family-0" onclick="add_new_modal_inv_04_subdivisions();" style="opacity:0.7;">
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
























<!--    ///////////////////      add_new_modal_inv_04_subdivisions Modal START    ///////////////////            -->
<div class="modal" id="add_new_modal_inv_04_subdivisions">
	<div class="modal-container">
		<div class="modal-header">
			<?php include("app/modal_header.php"); ?>
		</div>
		<div class="modal-body">
			
				<form 
				id="add-new-inv04-form" 
				id-modal="add_new_modal_inv_04_subdivisions" 
				class="boxes-holder" 
				api="<?=api_root; ?>inventory/lvl04/add_new.php">


<input class="frmData" type="hidden" 
		id="new-division_id" 
		name="division_id" 
		value="<?=$division_id; ?>" 
		req="1" 
		den="0" 
		alerter="<?=lang("Please_Check_Division", "AAR"); ?>">

<div class="col-100">
	<div class="form-grp">
		<label>Subdivision Name</label>
<input class="frmData" type="text" 
		id="new-subdivision_name" 
		name="subdivision_name" 
		req="1" 
		den="" 
		alerter="<?=lang("Please_Check_Subdivision_Name", "AAR"); ?>">
	</div>
</div>


<div class="col-100">
	<div class="form-grp">
		<label>Subdivision Description</label>
<textarea class="frmData" type="text" 
		id="new-subdivision_description" 
		name="subdivision_description" 
		req="1" 
		den="" 
		alerter="<?=lang("Please_Check_description", "AAR"); ?>"></textarea>
	</div>
</div>


	<div class="zero"></div>

<div class="col-50">
	<div class="form-grp">
		<label class="lbl_class"><?=lang('is_final_level', 'ARR', 1); ?></label>
		<select class="frmData" 
				id="new-is_finished" 
				name="is_finished" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_final_level", "AAR"); ?>">
					<option value="1">YES</option>
					<option value="0" selected>NO</option>
		</select>
	</div>
</div>

<div class="col-50">
	<div class="form-grp" id="uniter">
		<label class="lbl_class"><?=lang('item_unit', 'ARR', 1); ?></label>
		<select class="frmData" 
				id="new-unit_id" 
				name="unit_id" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_item_unit", "AAR"); ?>">
					<option value="0" selected>--- Please Select Code---</option>
<?php
	$qu_gen_items_units_sel = "SELECT `unit_id`, `unit_name` FROM  `gen_items_units`";
	$qu_gen_items_units_EXE = mysqli_query($KONN, $qu_gen_items_units_sel);
	if(mysqli_num_rows($qu_gen_items_units_EXE)){
		while($gen_items_units_REC = mysqli_fetch_array($qu_gen_items_units_EXE)){
		?>
		<option value="<?=$gen_items_units_REC[0]; ?>"><?=$gen_items_units_REC[1]; ?></option>
		<?php
		}
	}
?>
		</select>
	</div>
</div>

	<div class="zero"></div>
<script>
$('#uniter').hide();

$('#new-is_finished').on('change', function(){
	var tt = parseInt( $('#new-is_finished').val() );
	if( tt == 1 ){
		$('#uniter').show();
	} else {
		$('#uniter').hide();
	}
} );

</script>


	<div class="form-alerts"></div>
	<div class="zero"></div>

<div class="viewerBodyButtons">
		<button type="button" onclick="submit_form('add-new-inv04-form', 'reload_page');">
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


<!--    ///////////////////      add_new_modal_inv_04_subdivisions Modal END    ///////////////////            -->











<!--    ///////////////////      edit_modal_inv_04_subdivisions Modal START    ///////////////////            -->
<div class="modal" id="edit_modal_inv_04_subdivisions">
	<div class="modal-container">
		<div class="modal-header">
			<?php include("app/modal_header.php"); ?>
		</div>
		<div class="modal-body">
			
				<form 
				id="edit-inv04-form" 
				id-modal="edit_modal_inv_04_subdivisions" 
				class="boxes-holder" 
				api="<?=api_root; ?>inventory/lvl04/edit_data.php">


<input class="frmData" type="hidden" 
		id="edit-subdivision_id" 
		name="subdivision_id" 
		req="1" 
		den="0" 
		alerter="<?=lang("Please_Check_Subdivision", "AAR"); ?>">

<div class="col-100">
	<div class="form-grp">
		<label>Subdivision Name</label>
<input class="frmData" type="text" 
		id="edit-subdivision_name" 
		name="subdivision_name" 
		req="1" 
		den="" 
		alerter="<?=lang("Please_Check_Subdivision_Name", "AAR"); ?>">
	</div>
</div>


<div class="col-100">
	<div class="form-grp">
		<label>Subdivision Description</label>
<textarea class="frmData" type="text" 
		id="edit-subdivision_description" 
		name="subdivision_description" 
		req="1" 
		den="" 
		alerter="<?=lang("Please_Check_description", "AAR"); ?>"></textarea>
	</div>
</div>



	<div class="zero"></div>

<div class="col-50">
	<div class="form-grp">
		<label class="lbl_class"><?=lang('is_final_level', 'ARR', 1); ?></label>
		<select class="frmData" 
				id="edit-is_finished" 
				name="is_finished" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_final_level", "AAR"); ?>">
					<option value="1">YES</option>
					<option value="0" selected>NO</option>
		</select>
	</div>
</div>

<div class="col-50">
	<div class="form-grp" id="uniter_edit">
		<label class="lbl_class"><?=lang('item_unit', 'ARR', 1); ?></label>
		<select class="frmData" 
				id="edit-unit_id" 
				name="unit_id" 
				req="1" 
				den="" 
				alerter="<?=lang("Please_Check_item_unit", "AAR"); ?>">
					<option value="0" selected>--- Please Select Code---</option>
<?php
	$qu_gen_items_units_sel = "SELECT `unit_id`, `unit_name` FROM  `gen_items_units`";
	$qu_gen_items_units_EXE = mysqli_query($KONN, $qu_gen_items_units_sel);
	if(mysqli_num_rows($qu_gen_items_units_EXE)){
		while($gen_items_units_REC = mysqli_fetch_array($qu_gen_items_units_EXE)){
		?>
		<option value="<?=$gen_items_units_REC[0]; ?>"><?=$gen_items_units_REC[1]; ?></option>
		<?php
		}
	}
?>
		</select>
	</div>
</div>

	<div class="zero"></div>
<script>
// $('#uniter_edit').hide();

$('#edit-is_finished').on('change', function(){
	var tt = parseInt( $('#edit-is_finished').val() );
	if( tt == 1 ){
		$('#uniter_edit').show();
	} else {
		$('#uniter_edit').hide();
	}
} );

</script>


	<div class="form-alerts"></div>
	<div class="zero"></div>

<div class="viewerBodyButtons">
		<button type="button" onclick="submit_form('edit-inv04-form', 'reload_page');">
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


<!--    ///////////////////      edit_modal_inv_04_subdivisions Modal END    ///////////////////            -->














<script>
function del_data( ids_id ){
	var aa = confirm("Are you sure, action cannot be undone ?");
	if( aa == true ){
		
		$.ajax({
			url      :"<?=api_root; ?>inventory/lvl04/rem_data.php",
			data     :{'typo': 'pc_call', 'code_id': ids_id},
			dataType :"html",
			type     :'POST',
			success  :function(response){
				$('#boxdata-' + ids_id).remove();
			},
			error    :function(){
				alert('Code Not Applied');
			},
		});
	}
}

function edit_data( ids_id ){
	var titler = '<?=lang("Edit_::", "AAR"); ?>';
	titler = titler + $('#boxdata-' + ids_id + ' .cell-title').text();
	
	$.ajax({
		url      :"<?=api_root; ?>inventory/lvl04/get_data.php",
		data     :{'typo': 'pc_call', 'ids_id': ids_id},
		dataType :"JSON",
		type     :'POST',
		success  :function(response){
			
			
$('#edit-subdivision_id').val(response[0].subdivision_id);
$('#edit-subdivision_code').val(response[0].subdivision_code);
$('#edit-subdivision_name').val(response[0].subdivision_name);
$('#edit-subdivision_description').val(response[0].subdivision_description);
$('#edit-section_id').val(response[0].section_id);
$('#edit-is_finished').val(response[0].is_finished);
$('#edit-unit_id').val(response[0].unit_id);





			show_modal( 'edit_modal_inv_04_subdivisions' , titler );

				// end_loader();


$('#edit-is_finished').change();
				
		},
		error    :function(){
			alert('Code Not Applied');
		},
	});
}


function add_new_modal_inv_04_subdivisions(){
	var titler = '<?=lang("Add_New_Entry", "AAR"); ?>';
	titler = titler + ' :: ' + '<?=$family_name; ?> - <?=$section_name; ?> - <?=$division_name; ?>' ;
	show_modal( 'add_new_modal_inv_04_subdivisions' , titler );
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
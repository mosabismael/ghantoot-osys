<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "Inv Coding";
	
	
	
	$menuId = 2;
	$subPageID = 7;
	
	
	
	$category_id = 0;
	if( !isset( $_GET['ids'] ) ){
		header("location:inv_codification.php");
	} else {
		$category_id = (int) test_inputs( $_GET['ids'] );
	}
	
	
	if( $category_id == 0){
		header("location:inv_codification.php");
	}
	
	
	$qu_inv_05_categories_sel = "SELECT * FROM  `inv_05_categories` WHERE `category_id` = $category_id";
	$qu_inv_05_categories_EXE = mysqli_query($KONN, $qu_inv_05_categories_sel);
	$inv_05_categories_DATA;
	if(mysqli_num_rows($qu_inv_05_categories_EXE)){
		$inv_05_categories_DATA = mysqli_fetch_assoc($qu_inv_05_categories_EXE);
	}
	
		$category_code = $inv_05_categories_DATA['category_code'];
		$category_name = $inv_05_categories_DATA['category_name'];
		$category_description = $inv_05_categories_DATA['category_description'];
		$subdivision_id = $inv_05_categories_DATA['subdivision_id'];

	
	
	
	$qu_inv_04_subdivisions_sel = "SELECT * FROM  `inv_04_subdivisions` WHERE `subdivision_id` = $subdivision_id";
	$qu_inv_04_subdivisions_EXE = mysqli_query($KONN, $qu_inv_04_subdivisions_sel);
	$inv_04_subdivisions_DATA;
	if(mysqli_num_rows($qu_inv_04_subdivisions_EXE)){
		$inv_04_subdivisions_DATA = mysqli_fetch_assoc($qu_inv_04_subdivisions_EXE);
	}
	
		$subdivision_code = $inv_04_subdivisions_DATA['subdivision_code'];
		$subdivision_name = $inv_04_subdivisions_DATA['subdivision_name'];
		$subdivision_description = $inv_04_subdivisions_DATA['subdivision_description'];
		$division_id = $inv_04_subdivisions_DATA['division_id'];

	
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
        <div class="result" id = "result" ></div>
		<div class = "enterButton" onclick = "drawLastChart()"><i class="fas fa-arrow-right"></i></div>
		<div class="text-left topmargin">
			<div class="page-tree" style="color:red;">
				<a href="inv_codification.php">Main</a>&nbsp; \ &nbsp;
				<a href="inv_lvl02.php?ids=<?=$family_id; ?>"><?=$family_name; ?></a>&nbsp; \ &nbsp;
				<a href="inv_lvl03.php?ids=<?=$section_id; ?>"><?=$section_name; ?></a>&nbsp; \ &nbsp;
				<a href="inv_lvl04.php?ids=<?=$division_id; ?>"><?=$division_name; ?></a>&nbsp; \ &nbsp;
				<a href="inv_lvl05.php?ids=<?=$subdivision_id; ?>"><?=$subdivision_name; ?></a>&nbsp; \ &nbsp;
				<a><?=$category_name; ?></a>
			</div>
	
	
		</div>
	</div>
	
	
	<div class="zero"></div>
</div>







<div class="row">
	<div class="col-100">
		<div class="panel text-left">
			<div class="panel-header has_opts">
				<h1><i class="fas fa-list-ol"></i></h1>
				<div class="panel-opts">
					<a onclick="add_new_modal_inv_06_codes();"><button type="button" class="btn btn-success"><?=lang("Add_New_Code", "AAR"); ?></button></a>
				</div>
				<div class="zero"></div>
			</div>
			<div class="panel-body">
			
<table class="tabler">
	<thead>
		<tr>
			<th><?=lang("Ref_NO", "AAR"); ?></th>
			<th><?=lang("Code", "AAR"); ?></th>
			<th><?=lang("Item_Name", "AAR"); ?></th>
			<th><?=lang("Unit", "AAR"); ?></th>
			<th><?=lang("Surface Area(ton)", "AAR"); ?></th>
			<th><?=lang("Weight(kg/m)", "AAR"); ?></th>
			<th><?=lang("Hierarchy", "AAR"); ?></th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
<?php
	$qu_inv_06_codes_sel = "SELECT * FROM  `inv_06_codes` WHERE (`category_id` = '$category_id') ORDER BY `item_name` ASC";
	$qu_inv_06_codes_EXE = mysqli_query($KONN, $qu_inv_06_codes_sel);
	if(mysqli_num_rows($qu_inv_06_codes_EXE)){
		$CC = 0;
		while($inv_06_codes_REC = mysqli_fetch_assoc($qu_inv_06_codes_EXE)){
			$code_id = $inv_06_codes_REC['code_id'];
			$code_unit_id = $inv_06_codes_REC['code_unit_id'];
			
	$qu_gen_items_units_sel = "SELECT * FROM  `gen_items_units` WHERE `unit_id` = $code_unit_id";
	$qu_gen_items_units_EXE = mysqli_query($KONN, $qu_gen_items_units_sel);
	$gen_items_units_DATA;
	if(mysqli_num_rows($qu_gen_items_units_EXE)){
		$gen_items_units_DATA = mysqli_fetch_assoc($qu_gen_items_units_EXE);
		$unit_id = $gen_items_units_DATA['unit_id'];
		$unit_name = $gen_items_units_DATA['unit_name'];
		$surface_area = $inv_06_codes_REC['surface_area'];
		$weight = $inv_06_codes_REC['weight'];
		$data_type = $gen_items_units_DATA['data_type'];
	}

			
$hirarcy = $family_name.' - '.$section_name.' - '.$division_name.' - '.$subdivision_name.' - '.$category_name;
		?>
		<tr id="boxdata-<?=$code_id; ?>">
			<td><?=$code_id; ?></td>
			<td style="color:red;"><?=$inv_06_codes_REC["code_tag"]; ?></td>
			<td class="cell-title"><?=$inv_06_codes_REC["item_name"]; ?></td>
			<td><?=$unit_name; ?></td>
			<td><?=$surface_area; ?></td>
			<td><?=$weight; ?></td>
			<td><?=$hirarcy; ?></td>
			<td class="text-center">
				<a onclick="edit_data(<?=$code_id; ?>);" title="<?=lang("Edit_Item", "AAR"); ?>"><i class="far fa-edit"></i></a>
				<a onclick="del_data(<?=$code_id; ?>);" title="<?=lang("Delete_Item", "AAR"); ?>"><i class="fas fa-trash"></i></a>
			</td>
		</tr>
		<?php
		
		}
	}
	
?>
	</tbody>
</table>
			
			</div>
		</div>
	</div>
	
	
	<div class="zero"></div>
</div>



<!--    ///////////////////      add_new_modal_inv_06_codes Modal START    ///////////////////            -->
<div class="modal" id="add_new_modal_inv_06_codes">
	<div class="modal-container">
		<div class="modal-header">
			<?php include("app/modal_header.php"); ?>
		</div>
		<div class="modal-body">
			
				<form 
				id="add-new-inv06-form" 
				id-modal="add_new_modal_inv_06_codes" 
				class="boxes-holder" 
				api="<?=api_root; ?>inventory/lvl06/add_new.php">


<input class="frmData" type="hidden" 
		id="new-category_id" 
		name="category_id" 
		value="<?=$category_id; ?>" 
		req="1" 
		den="0" 
		alerter="<?=lang("Please_Check_Categroy", "AAR"); ?>">

<div class="col-50">
	<div class="form-grp">
		<label>Item Name</label>
<input class="frmData" type="text" 
		id="new-item_name" 
		name="item_name" 
		req="1" 
		den="" 
		alerter="<?=lang("Please_Check_Item_Name", "AAR"); ?>">
	</div>
</div>



<div class="col-50">
	<div class="form-grp">
		<label class="lbl_class"><?=lang('item_unit', 'ARR', 1); ?></label>
		<select class="frmData" 
				id="new-code_unit_id" 
				name="code_unit_id" 
				req="1" 
				den="0" 
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
<script>
    $('#new-code_unit_id').val('13');
</script>


<div class="col-50">
	<div class="form-grp">
		<label>Item Surface Area(ton)</label>
<input class="frmData" type="text" 
		id="new-item_sa" 
		name="item_sa" 
		req="1" 
		den="" 
		alerter="<?=lang("Please_Check_Surface_Area", "AAR"); ?>">
	</div>
</div>



<div class="col-50">
	<div class="form-grp">
		<label>Item Weight(kg/m)</label>
<input class="frmData" type="text" 
		id="new-item_weight" 
		name="item_weight" 
		req="1" 
		den="" 
		alerter="<?=lang("Please_Check_Weight", "AAR"); ?>">
	</div>
</div>

<div class="col-100">
	<div class="form-grp">
		<label>Item Description</label>
<textarea class="frmData" type="text" 
		id="new-item_description" 
		name="item_description" 
		req="1" 
		den="" 
		alerter="<?=lang("Please_Check_description", "AAR"); ?>"></textarea>
	</div>
</div>


	<div class="zero"></div>


	<div class="form-alerts"></div>
	<div class="zero"></div>

<div class="viewerBodyButtons">
		<button type="button" onclick="submit_form('add-new-inv06-form', 'reload_page');">
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


<!--    ///////////////////      add_new_modal_inv_06_codes Modal END    ///////////////////            -->



<!--    ///////////////////      edit_modal_inv_06_codes Modal START    ///////////////////            -->
<div class="modal" id="edit_modal_inv_06_codes">
	<div class="modal-container">
		<div class="modal-header">
			<?php include("app/modal_header.php"); ?>
		</div>
		<div class="modal-body">
			
				<form 
				id="edit-inv06-form" 
				id-modal="edit_modal_inv_06_codes" 
				class="boxes-holder" 
				api="<?=api_root; ?>inventory/lvl06/edit_data.php">


<input class="frmData" type="hidden" 
		id="edit-code_id" 
		name="code_id" 
		value="0" 
		req="1" 
		den="0" 
		alerter="<?=lang("Please_Check_Categroy", "AAR"); ?>">

<div class="col-50">
	<div class="form-grp">
		<label>Item Name</label>
<input class="frmData" type="text" 
		id="edit-item_name" 
		name="item_name" 
		req="1" 
		den="" 
		alerter="<?=lang("Please_Check_Item_Name", "AAR"); ?>">
	</div>
</div>

<div class="col-50">
	<div class="form-grp">
		<label class="lbl_class"><?=lang('item_unit', 'ARR', 1); ?></label>
		<select class="frmData" 
				id="edit-code_unit_id" 
				name="code_unit_id" 
				req="1" 
				den="0" 
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
<div class="col-50">
	<div class="form-grp">
		<label>Item Surface Area(ton)</label>
<input class="frmData" type="text" 
		id="edit-item_sa" 
		name="item_sa" 
		req="1" 
		den="" 
		alerter="<?=lang("Please_Check_Surface_Area", "AAR"); ?>">
	</div>
</div>



<div class="col-50">
	<div class="form-grp">
		<label>Item Weight(kg/m)</label>
<input class="frmData" type="text" 
		id="edit-item_weight" 
		name="item_weight" 
		req="1" 
		den="" 
		alerter="<?=lang("Please_Check_Weight", "AAR"); ?>">
	</div>
</div>
<div class="col-100">
	<div class="form-grp">
		<label>Item Description</label>
<textarea class="frmData" type="text" 
		id="edit-item_description" 
		name="item_description" 
		req="1" 
		den="" 
		alerter="<?=lang("Please_Check_description", "AAR"); ?>"></textarea>
	</div>
</div>


	<div class="zero"></div>


	<div class="form-alerts"></div>
	<div class="zero"></div>

<div class="viewerBodyButtons">
		<button type="button" onclick="submit_form('edit-inv06-form', 'reload_page');">
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


<!--    ///////////////////      edit_modal_inv_06_codes Modal END    ///////////////////            -->

<script>
function del_data( ids_id ){
	var aa = confirm("Are you sure, action cannot be undone ?");
	if( aa == true ){
		
		$.ajax({
			url      :"<?=api_root; ?>inventory/lvl06/rem_data.php",
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
	var titler = '<?=lang("Edit", "AAR"); ?>';
	titler = titler + ' :: ' + '<?=$family_name; ?> - <?=$section_name; ?> - <?=$division_name; ?> - <?=$subdivision_name; ?> - ' ;
	titler = titler + $('#boxdata-' + ids_id + ' .cell-title').text();
	
	$.ajax({
		url      :"<?=api_root; ?>inventory/lvl06/get_data.php",
		data     :{'typo': 'pc_call', 'ids_id': ids_id},
		dataType :"JSON",
		type     :'POST',
		success  :function(response){
			
$('#edit-code_id').val(response[0].code_id);
$('#edit-item_name').val(response[0].item_name);
$('#edit-code_unit_id').val(response[0].code_unit_id);
$('#edit-item_description').val(response[0].item_description);
$('#edit-item_sa').val(response[0].surface_area);
$('#edit-item_weight').val(response[0].weight);

			show_modal( 'edit_modal_inv_06_codes' , titler );

				// end_loader();
				
		},
		error    :function(){
			alert('Code Not Applied');
		},
	});
}

function add_new_modal_inv_06_codes(){
	var titler = '<?=lang("Add_New_Entry", "AAR"); ?>';
	titler = titler + ' :: ' + '<?=$family_name; ?> - <?=$section_name; ?> - <?=$division_name; ?> - <?=$subdivision_name; ?> - <?=$category_name; ?>' ;
	show_modal( 'add_new_modal_inv_06_codes' , titler );
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
<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 3;
	$subPageID = 31;
	
	
	$project_id = 0;
	if( !isset( $_GET['project_id'] ) ){
		header("location:z_project.php");
		} else {
		$project_id = (int) test_inputs( $_GET['project_id'] );
	}
	$level1_id = 0;
	if(isset($_GET['level1_id'])){
		$level1_id = $_GET['level1_id'];
	}
	$level2_id = 0;
	if(isset($_POST['level2_id'])){
		$level2_id = $_POST['level2_id'];
	}
	$level3_id = 0;
	if(isset($_POST['level3_id'])){
		$level3_id = $_POST['level3_id'];
	}
	$level4_id = 0;
	if(isset($_POST['level4_id'])){
		$level4_id = $_POST['level4_id'];
	}
	$qu_z_project_sel = "SELECT * FROM  `z_project` WHERE `project_id` = $project_id";
	$qu_z_project_EXE = mysqli_query($KONN, $qu_z_project_sel);
	$z_project_DATA;
	if(mysqli_num_rows($qu_z_project_EXE)){
		$z_project_DATA = mysqli_fetch_assoc($qu_z_project_EXE);
	}
	$project_name = $z_project_DATA['project_name'];
	$created_date = $z_project_DATA['created_date'];
	$created_date = $z_project_DATA['created_date'];
	$project_notes = $z_project_DATA['project_notes'];
	$client_id = $z_project_DATA['client_id'];
	$employee_id = $z_project_DATA['employee_id'];
	$project_status = $z_project_DATA['project_status'];
	
	
	
	
	
	$qu_gen_clients_sel = "SELECT * FROM  `gen_clients` WHERE `client_id` = $client_id";
	$qu_gen_clients_EXE = mysqli_query($KONN, $qu_gen_clients_sel);
	$client_name = "NA";
	if(mysqli_num_rows($qu_gen_clients_EXE)){
		$gen_clients_DATA = mysqli_fetch_assoc($qu_gen_clients_EXE);
		$client_id = $gen_clients_DATA['client_id'];
		$client_name = $gen_clients_DATA['client_name'];
	}
	
	
	
	/*
		$qu_hr_employees_sel = "SELECT * FROM  `hr_employees` WHERE `employee_id` = $employee_id";
		$qu_hr_employees_EXE = mysqli_query($KONN, $qu_hr_employees_sel);
		$hr_employees_DATA;
		if(mysqli_num_rows($qu_hr_employees_EXE)){
		$hr_employees_DATA = mysqli_fetch_assoc($qu_hr_employees_EXE);
		}
		$employee_namer = $hr_employees_DATA['employee_code'].'-'.$hr_employees_DATA['first_name'].' '.$hr_employees_DATA['last_name'];
		
	*/
	
	
?>
<!DOCTYPE html>
<html dir="<?=$lang_dir; ?>" lang="<?=$lang; ?>">
	<head>
		<?php include('app/meta.php'); ?>
		<?php include('app/assets.php'); ?>
		<link rel="stylesheet" href="https://unpkg.com/treeflex/dist/css/treeflex.css">
	</head>
	<body>
		<?php
			$WHERE = "requisitions";
			include('app/header.php');
			//PAGE DATA START -----------------------------------------------///---------------------------------
		?>
		
		<div class="row">
			<div class="col-100">
				<div class="page-details text-left">
					<br>
					<h1><?=strtoupper( $project_name ); ?></h1>
					<h3>By :<?=strtoupper( $client_name ); ?></h3>
					<br>
				</div>
				<div class = "totAmount" style = "float: right;font-size: 20px;margin-top: -1%;width:19%">Total amount : <input type = "text" id = "totalAmount" value = '0' style = "border:none; background-color:inherit;font-size:20px;width:20%"> AED</div>	
				
				<div class="tabber">
					<ul class="tabber-header">
						<li id="sel-1" style = "min-width:8%" onclick="set_tabber(1);loadLevel0Data(<?=$project_id?>);" class=""><?=lang("Cost summary sheet", "AAR"); ?></li>
						<li id="sel-2" style = "min-width:8%" onclick="set_tabber(2);loadData('-2');" class=""><?=lang("LV02", "AAR"); ?></li>
						<li id="sel-3" style = "min-width:8%" onclick="set_tabber(3);loadData('-3');" class=""><?=lang("LV03", "AAR"); ?></li>
						<li id="sel-4" style = "min-width:8%" onclick="set_tabber(4);loadData('-4');" class=""><?=lang("LV04", "AAR"); ?></li>
						<li id="sel-5" style = "min-width:8%" onclick="set_tabber(5);loadData('-5');" class=""><?=lang("LV05", "AAR"); ?></li>
						<li id="sel-6" style = "min-width:8%" onclick="set_tabber(6);load_Boq_details(<?=$project_id?>);" class=""><?=lang("BOQ", "AAR"); ?></li>
						<li id="sel-200" style = "min-width:8%" onclick="set_tabber(200);fetch_item_status(<?=$project_id; ?>, 'z_project');"><?=lang("Status_Change", "AAR"); ?></li>
						<li id="sel-8" style = "min-width:8%" onclick="set_tabber(8);load_work_scope(<?=$project_id?>)" class=""><?=lang("Quotation Items", "AAR"); ?></li>
						<li id="sel-7" style = "min-width:8%" onclick="set_tabber(7);" class=""><?=lang("Tree View", "AAR"); ?></li>
					</ul>
					
					<div class="tabber-body">
						
						
						
						
						
						
						<div class="tabber-1 tabber-content tabber-active">
							<div class = "heirarchy" id = "heirarchy1"></div>
							
							<?php
								include('projects_estimate/firstLevel.php');
							?>
						</div>
						
						<div class="tabber-2 tabber-content">
							<div class = "heirarchy" id = "heirarchy2"></div>
							<div id = "excelupload" style = "display:none;">
								<input type = "file" id = "materialfile" name = "filetoUpload"/>
								<button type = "submit" name = "submitexcel" onclick="Upload()" >submit</button>
								<div id="loading" style = "display:none">
									<div id="loading-image"></div> 
								</div>
							</div>
							
							<?php
								include('projects_estimate/secondLevel.php');
							?>
						</div>
						<div class="tabber-3 tabber-content">
							<div class = "heirarchy" id = "heirarchy3"></div>
							<?php
								include('projects_estimate/thirdLevel.php');
							?>
						</div>
						<div class="tabber-4 tabber-content">
							<div class = "heirarchy" id = "heirarchy4"></div>
							<?php
								include('projects_estimate/fourthLevel.php');
							?>
						</div>
						
						<div class="tabber-5 tabber-content">
							<div class = "heirarchy" id = "heirarchy5"></div>
							<?php
								include('projects_estimate/fifthLevel.php');
							?>
						</div>
						
						<div class="tabber-6 tabber-content">
							
							<?php
								include('projects_estimate/full_boq.php');
							?>
						</div>
						
						<div class="tabber-7 tabber-content">
							<div class = "heirarchy" id = "heirarchy7"></div>
							<?php
								include('projects_estimate/getTreeView.php');
							?>
						</div>
						
						<div class="tabber-8 tabber-content">
							<div class = "heirarchy" id = "heirarchy7"></div>
							<?php
								include('projects_estimate/workScope.php');
							?>
						</div>
						
						
						
						<div class="tabber-200 tabber-content" id="fetched_status_change"></div>
						
						
						
					</div>
					<div class = "history" id = "history">
						History
						<i class="fas fa-times" onclick = "closehistory();" style = "float: right;margin-right: 2%;margin-top: 1%;"></i>
						<div class="table">
							<div class = "tableHeader">
								<div class = "tr">
									<div class = "th"><?=lang('No.'); ?></div>
									<div class = "th"><?=lang('name'); ?></div>
									<div class = "th"><?=lang('item_price'); ?></div>
									<div class = "th"><?=lang('item_qty'); ?></div>
									<div class = "th"><?=lang('po_ref'); ?></div>
									<div class = "th"><?=lang('supplier_code'); ?></div>
									<div class = "th"><?=lang('requisition_REF'); ?></div>
									<div class = "th"><?=lang('po_date'); ?></div>
									
								</div>
							</div>
							<div class = "tableBody" id = "historybody">
							</div>
						</div>
						
					</div>
				</div>
				
			</div>
			
			
			<div class="zero"></div>
		</div>
		
		
		<?php
			//PAGE DATA END   ----------------------------------------------///---------------------------------
			include('app/footer.php');
		?>
		<script>
			function closehistory(){
				$('#history').hide();
			}
			function loadBoq(type_name, id, sno, level1_id, level2_id, level3_id, level4_id, level5_id, boq_id, name){
				if($('.tabber-boq-'+id).hasClass('notdisplayed')){
					$('.tabber-boq-'+id).removeClass('notdisplayed');
					$('.tabber-boq-'+id).addClass('displayed');
					$('#tabber_id').val('-'+id+'-'+sno);
					
					if(type_name == 'labour'){
						$('#manhour-input-'+id).show();
						$('#qty-boq-'+id).html('WL');
						$('#cost-boq-'+id).html('KPI');
						$('#manhour-boq-'+id).show();
						$('#manhour-value').show();
					}
					else{
						$('#manhour-input-'+id).hide();
						$('#qty-boq-'+id).html('weight');
						$('#cost-boq-'+id).html('cost');
						$('#manhour-boq-'+id).hide();
						$('#manhour-value').hide();
					}
					if($('#completed-'+id+'-'+sno).find('i').hasClass('fas fa-check complete')){
						add_boq(level1_id, level2_id, level3_id, level4_id, level5_id);
						if(type_name =='labour'){
							$('#manhour-value').show();
						}
						else{
							$('#manhour-value').hide();
						}
					}
					else if($('#completed-'+id+'-'+sno).find('i').hasClass('fas fa-folder')){
						if(boq_id =='0'){
							boq_id = $('#boq_id').val();
						}
						view_boq_details(boq_id, id, type_name);
						$('#boq_id').val(boq_id);
						if(type_name =='labour'){
							$('#manhour-value').show();
						}
						else{
							$('#manhour-value').hide();
						}
					}
					
					$('#header-boq-title-'+id).html(name);
					$('#completed-'+id+'-'+sno).find('i').removeClass('fas fa-check complete');
					$('#completed-'+id+'-'+sno).find('i').removeClass('fas fa-folder');
					$('#completed-'+id+'-'+sno).find('i').addClass('far fa-folder-open');
				}
				else if($('.tabber-boq-'+id).hasClass('displayed')){
					$('.tabber-boq-'+id).removeClass('displayed');
					$('.tabber-boq-'+id).addClass('notdisplayed');
					$('#completed-'+id+'-'+sno).find('i').removeClass('far fa-folder-open');
					$('#completed-'+id+'-'+sno).find('i').addClass('fas fa-folder');
					$('.quote_item').remove();
				}
			}
			function set_tabber(tID){
				$('.tabber-header .active').removeClass('active');
				$('.tabber-body .tabber-active').removeClass('tabber-active');
				
				$('.tabber-header #sel-' + tID).addClass('active');
				$('.tabber-body .tabber-' + tID).addClass('tabber-active');
			}
			
			set_tabber(1);loadLevel0Data(<?=$project_id?>);
		</script>
		<script>
			function loadData(id){
				$('.tabber-boq-1').removeClass('displayed');
				$('.tabber-boq-1').addClass('notdisplayed');
				$('.tabber-boq-2').removeClass('displayed');
				$('.tabber-boq-2').addClass('notdisplayed');
				$('.tabber-boq-3').removeClass('displayed');
				$('.tabber-boq-3').addClass('notdisplayed');
				$('.tabber-boq-4').removeClass('displayed');
				$('.tabber-boq-4').addClass('notdisplayed');
				$('.tabber-boq-5').removeClass('displayed');
				$('.tabber-boq-5').addClass('notdisplayed');
				
				if(id == '-2' || id == 'ProductLevel2'){
					set_tabber(2); loadLevel1Data($('#level1_id').val(),$('#level1_name').val())	;
				}
				else if(id == '-3'){
					set_tabber(3); loadLevel2Data($('#level2_id').val(),$('#level2_name').val(),$('#level1_id').val())	;
				}
				else if(id == '-4'){
					set_tabber(4); loadLevel3Data($('#level3_id').val(),$('#level3_name').val(),$('#level1_id').val(),$('#level2_id').val());
				}
				else if(id == '-5'){
					set_tabber(5); loadLevel4Data($('#level4_id').val(),$('#level4_name').val(),$('#level1_id').val(),$('#level2_id').val(),$('#level3_id').val())	;
				}
				$('#loading').css('display','none');
			}
		</script>
		<script>
			
			function getLvl3Data(id){
				$.post("projects_estimation.php", {level2_id: id}, function(result){
				});
			}
			function getLvl4Data(id){
				$.post("projects_estimation.php", {level3_id: id}, function(result){
				});
			}
			function getLvl5Data(id){
				$.post("projects_estimation.php", {level4_id: id}, function(result){
				});
			}
			function openaddItem(type){
				
				level = document.getElementById("add"+type);
				level.className = "add-new displayed";
				$(level).find('#prodid').val("0");
				$(level).find('#id').val("0");
				$(level).find('#button-add').text("ADD");
				$(level).find('#displayName').text("Add product");
				$(level).find('#name').val("");
				$(level).find('#description').val("");
				$(level).find('#type_id')[0].selectedIndex = ""; 
			}
			function openaddRecord(type){
				
				level = document.getElementById("add"+type);
				level.className = "add-new displayed";
				$('#prodid').val("0");
				$('#type_id').val("");
				$('#prodname').val("");
				$('#qty').val("");
				$('#displayName').text("Add Record");
				$('#button-add').text("ADD");
			}
			function closeaddItem(type){
				
				level = document.getElementById("add"+type);
				level.className = "add-new notdisplayed";
				
			}
			
			function openEditRecord(uid, name , qty, measure_id){
				level = document.getElementById("addRecord");
				level.className = "add-new displayed";
				$('#prodid').val(uid);
				$('#type_id').val(measure_id);
				$('#prodname').val(name);
				$('#qty').val(qty);
				$('#displayName').text("Edit record");
				$('#button-add').text("EDIT");
			}
			function openEdit(name,id, desc , type_id,idName){
				level = document.getElementById(idName);
				level.className = "add-new displayed";
				$(level).find('#name').val(name);
				$(level).find('#id').val(id);
				$(level).find('#description').val(desc);
				$(level).find('#button-add').text('Edit');
				$(level).find('#displayName').text("Edit product");
				$(level).find('#type_id')[0].selectedIndex = type_id; 
			}
			function deleteProduct(levelName , id){
				$.ajax({
					type: "GET",
					url: "delete_product.php",
					data: "levelName="+levelName+"&id="+id,
					success: function(response) {
						if(response.status == "1") {
							alert("Cannot be deleted");
							} else if(response.status=="2"){
							alert ("data not selected for delete");
						}
						else{
							$('#'+levelName+'-'+id).remove();
						}
					},
					error: function (error){
						alert(error);	
					}
				});
			}
		</script>	
		
		<script>
			var items_c = 0;
			var itemsCount = 0;
			
			function add_boq_details_table(tabber_id_sno,tabber_id , items_c , manhour, item_unit_name, ths_tot,item_name, item_qty, item_price, item_tot, item_unit, item_manhour, boq_id, complexity,family_id, section_id, subdivision_id, division_id, category_id, item_code_id, item_surfacearea, item_length, boq_length_unit_id, unit_name_length, boq_surfacearea_unit_id, unit_name_surfacearea ){
				var boq = parseInt(boq_id);
				var res = "";
				$.ajax({
					type: "GET",
					url: "projects_estimate/add_boq_details_table.php",
					data: {'item_name':item_name,'item_qty':item_qty,'item_price':item_price,'item_tot':item_tot,'item_unit':item_unit, 'item_manhour':item_manhour,'boq_id':boq,'complexity':complexity, 'family_id':family_id , 'section_id':section_id, 'division_id':division_id, 'subdivision_id':subdivision_id,'category_id':category_id,'item_code_id':item_code_id, 'item_surfacearea':item_surfacearea, 'item_length':item_length, 'item_surfacearea_unit':boq_surfacearea_unit_id, 'item_length_unit':boq_length_unit_id},
					dataType :"json",
					success: function(response) {
						id = response;
						alert(id);
						var nw_tr = '<div id="itemo-' + id + '" class="tr quote_item" idler="' + items_c + '">'+ 
						'<div class = "td">'+
						'<i onclick="rem_item(' + id + ",'"+tabber_id_sno+"'"+ ",'"+ths_tot+"'"+",'"+id+"'"+');" class="fa fa-trash" style="color:red;cursor:pointer;" area-hidden="true"></i>'+
						'<i id = "edit-'+id+'" onclick="edit_item(' + id + ');" class="far fa-edit" style="color:red;cursor:pointer;" area-hidden="true"></i>'+
						'</div>'+ 
						'<div class="td item-c">' + items_c + '</div>'+ 
						'<div class ="td" onclick = "viewItemDetails('+family_id+","+section_id+","+division_id+","+subdivision_id+","+category_id+","+item_code_id+",'"+item_name+"'"+');"><input type = "text" id = "boq_name-'+id+'" value = "' + item_name + '" disabled onkeyup = "autocompleteName('+id+')"><div id="result-boq-'+id+'" class = "result-boq-'+id+'" style = "z-index: 99;position: absolute;background-color: white;width: 25%;margin-left: 2%;text-align: left;overflow: auto;"></div></div>'+ 
						'<div class = "td"><span class="qtyer"><input onkeyup = calculateTotalBoq('+id+",'"+tabber_id_sno+"'"+'); type = "text" id = "boq_qty-'+id+'" value = "' + item_qty + '" disabled><select id = "boq_item_unit-'+id+'" disabled><option value="'+item_unit+'" selected>'+item_unit_name+'</option></select></span></div>'+ 
						'<div class = "td"><select id = "boq_complexity-'+id+'" disabled><option value = "'+complexity+'">'+complexity+'</select></div>'+
						'<div class = "td"><input style = "width: 35%;margin-right: 10%;" type = "text" id = "boq_length-'+id+'" value =  "' + item_length + '" disabled><select id = "boq_length_unit-'+id+'" disabled><option value = "'+boq_length_unit_id+'">'+unit_name_length+'</option></select></div>'+ 
						'<div class = "td"><input style = "width: 35%;margin-right: 10%;" type = "text" id = "boq_surfacearea-'+id+'" value =  "' + item_surfacearea + '" disabled><select id = "boq_surfacearea_unit-'+id+'" disabled><option value = "'+boq_surfacearea_unit_id+'">'+unit_name_surfacearea+'</option></select></select></div>'+ 
						'<div class="td pricer"><input onkeyup = calculateTotalBoq('+id+",'"+tabber_id_sno+"'"+'); type = "text" id = "boq_price-'+id+'" value = "' + item_price.toFixed(3) + '" disabled></div>'+ 
						manhour+ 
						'<div class="td pricer"><input type = "text" id = "boq_total-'+id+'" value= "' + ths_tot.toFixed(3) + '" disabled></div>'+ 
						'</div>';
						
						
						
						
						
						$('#added_items'+tabber_id).before(nw_tr);
					},
					error: function (error) {
						alert("ERR|add_boq_details_table");
					}
				});
				return res;
			}
			
			function add_item(tabber_id){
				//collect data
				items_c++;
				var item_manhour = parseInt( $('#item_manhour'+tabber_id).val() );
				var display = 1;
				if( isNaN( item_manhour ) ){
					display = 0;
					item_manhour = 1;
				}
				
				
				
				var item_qty = parseInt( $('#item_qty'+tabber_id).val() );
				if( isNaN( item_qty ) ){
					item_qty = 0;
				}
				
				var item_name = $('#item_name'+tabber_id).val();
				var complexity = $('#item_complexity'+tabber_id).val();
				var item_unit = parseInt( $('#item_unit'+tabber_id).val() );
				var item_unit_length = parseInt( $('#item_unit_length'+tabber_id).val() );
				var item_unit_surfacearea = parseInt( $('#item_unit_surface_area'+tabber_id).val() );
				var family_id = $('#family_id'+tabber_id).val();
				var item_code_id = $('#item_code_id'+tabber_id).val();
				var division_id = $('#division_id'+tabber_id).val();
				var subdivision_id = $('#subdivision_id'+tabber_id).val();
				var category_id = $('#category_id'+tabber_id).val();
				var section_id = $('#section_id'+tabber_id).val();
				var item_length = $('#item_length'+tabber_id).val();
				var item_surfacearea = $('#item_surface_area'+tabber_id).val();
				if( isNaN( item_unit ) ){
					item_unit = 0;
				}
				
				if( item_unit != 0 ){
					
					var ths_tot = 0;
					var item_unit_name = $('#uniter-' + item_unit+tabber_id).attr("uniter");
					var item_unit_name_length = $('#uniter-length-' + item_unit_length+tabber_id).attr("uniter");
					var item_unit_name_area = $('#uniter-sa-' + item_unit_surfacearea+tabber_id).attr("uniter");
					var item_price = parseFloat( $('#item_price'+tabber_id).val() );
					if( isNaN( item_price ) ){
						item_price = 0;
					}
					var inputer = '';
					
					inputer +=  '<input class="frmData" type="hidden" ' + 
					'		id="new-item_names' + items_c + '" ' + 
					'		name="item_names[]" ' + 
					'		req="1" ' + 
					'		den="" ' + 
					'		value="' + item_name + '"' + 
					'		alerter="Please_Check_Items">';
					inputer +=  '<input class="frmData" type="hidden" ' + 
					'		id="new-item_qtys' + items_c + '" ' + 
					'		name="item_qtys[]" ' + 
					'		req="1" ' + 
					'		den="0" ' + 
					'		value="' + item_qty + '"' + 
					'		alerter="Please_Check_Items">';
					inputer +=  '<input class="frmData" type="hidden" ' + 
					'		id="new-item_units' + items_c + '" ' + 
					'		name="item_units[]" ' + 
					'		req="1" ' + 
					'		den="0" ' + 
					'		value="' + item_unit + '"' + 
					'		alerter="Please_Check_Items">';
					inputer +=  '<input class="frmData" type="hidden" ' + 
					'		id="new-item_prices' + items_c + '" ' + 
					'		name="item_prices[]" ' + 
					'		req="1" ' + 
					'		den="" ' + 
					'		value="' + item_price + '"' + 
					'		alerter="Please_Check_Items">';
					
					
					ths_tot = item_qty * item_price * item_manhour;
					var manhour = '<div class="td" id = "manhour-value">' + item_manhour+ '</div>';
					if(display == 0){
						manhour = '';
					}
					
					if(item_name != ""){
						var tabber_id_sno = $('#tabber_id').val();
						add_boq_details_table(tabber_id_sno, tabber_id, items_c , manhour, item_unit_name, ths_tot,item_name, item_qty, item_price, ths_tot, item_unit,item_manhour, $('#boq_id').val(), complexity, family_id, section_id, subdivision_id, division_id, category_id, item_code_id, item_surfacearea, item_length ,item_unit_length, item_unit_name_length, item_unit_surfacearea, item_unit_name_area);
						
						$('#totalAmount').val(parseInt($('#totalAmount').val())+parseInt(ths_tot));
						
						
						if(document.getElementById('amount'+tabber_id_sno).value!=""){
							var totalAmount=parseInt(document.getElementById('amount'+tabber_id_sno).value)+parseInt(ths_tot);
							$('#amount'+tabber_id_sno).val(totalAmount.toFixed(3));
							
						}
						else{
							$('#amount'+tabber_id_sno).val(ths_tot.toFixed(3));
							
						}
						ClearInputForm(tabber_id);
						itemsCount++;
						fix_counters();
						} else {
						alert( "Please Insert Item Name" );
					}
					
					} else {
					alert( "Please Select Item Unit" );
				}
				
				
				
				
				
			}
			
			function add_boq(level1_id, level2_id, level3_id, level4_id, level5_id){
				$.ajax({
					type: "GET",
					url: "projects_estimate/add_boq.php",
					data: "level1_id="+level1_id+"&level2_id="+level2_id+"&level3_id="+level3_id+"&level4_id="+level4_id+"&level5_id="+level5_id,
					success: function(response) {
						alert("added"+response);
						$('#boq_id').val(response);
					}
				});
			}
			function edit_boq_detail(boq_detail_id, boq_name, boq_qty, boq_price, unit_id){
				var boq_id = $('#boq_id').val();
				$.ajax({
					type: "GET",
					url: "projects_estimate/edit_boq_details.php",
					data: "boq_detail_id="+boq_detail_id+"&item_name="+boq_name+"&item_qty="+boq_qty+"&item_price="+boq_price+"&boq_id="+boq_id+"&unit_id="+unit_id,
					success: function(response) {
						alert("edited"+response);
					}
				});
			}
			function delete_boq(id){
				boq = $('#boq_id').val();
				$.ajax({
					type: "GET",
					url: "projects_estimate/delete_boq.php",
					data: {'boq_id':boq},
					dataType: "json",
					success: function(response) {
						alert("deleted");
						$('#totalAmount').val($('#totalAmount').val()-parseInt(response));
					}
				});
				$('.tabber-boq'+id).removeClass('displayed');
				$('.tabber-boq'+id).addClass('notdisplayed');
				if(id == '-1'){
					set_tabber(1); loadLevel0Data(<?=$project_id?>)	;
				}
				else if(id == '-2'){
					set_tabber(2); loadLevel1Data($('#level1_id').val(),$('#level1_name').val())	;
				}
				else if(id == '-3'){
					set_tabber(3); loadLevel2Data($('#level2_id').val(),$('#level2_name').val(),$('#level1_id').val())	;
				}
				else if(id == '-4'){
					set_tabber(4); loadLevel3Data($('#level3_id').val(),$('#level3_name').val(),$('#level1_id').val(),$('#level2_id').val());
				}
				else if(id == '-5'){
					set_tabber(5); loadLevel4Data($('#level4_id').val(),$('#level4_name').val(),$('#level1_id').val(),$('#level2_id').val(),$('#level3_id').val())	;
				}
			}
			
			function rem_boq_detail(boq_detail_id){
				$.ajax({
					type: "GET",
					url: "projects_estimate/delete_boq_detail.php",
					data: {'boq_detail_id':boq_detail_id},
					dataType: "json",
					success: function(response) {
						alert("deleted");
					}
				});
			}
			function view_boq_details(boq_id, tabber_id, type){
				$.ajax({
					type: "GET",
					url: "projects_estimate/view_boq_details.php",
					data     :{ 'boq_id': boq_id},
					dataType :"json",
					success: function(response) {
						var tabber_id_sno = $('#tabber_id').val();
						var cc = 0;
						for( i=0 ; i < response.length ; i ++ ){
							var manhour = '';
							if(type == 'labour'){
								manhour = '<div class="td" id = "manhour-value">' + response[i].manhour + '</div>';	
							}
							cc++;
							
							var nw_tr = '<div id="itemo-' + response[i].boq_detail_id + '" class="tr quote_item" idler="' + response[i].boq_detail_id + '">'+ 
							'<div class = "td">'+
							'<i onclick="rem_item(' + response[i].boq_detail_id + ",'"+tabber_id_sno+"'"+ ",'"+response[i].boq_total+"'"+","+response[i].boq_detail_id+');" class="fa fa-trash" style="color:red;cursor:pointer;" area-hidden="true"></i>'+
							'<i id = "edit-'+response[i].boq_detail_id+'" onclick="edit_item(' + response[i].boq_detail_id +');" class="far fa-edit" style="color:red;cursor:pointer;" area-hidden="true"></i>'+
							'</div>'+ 
							'<div class="td item-c">' + response[i].no + '</div>'+ 
							'<div class ="td" onclick = "viewItemDetails('+response[i].family_id+","+response[i].section_id+","+response[i].division_id+","+response[i].subdivision_id+","+response[i].category_id+","+response[i].item_code_id+",'"+response[i].boq_name+"'"+');"><input type = "text" id = "boq_name-'+response[i].boq_detail_id+'" value =  "' + response[i].boq_name + '" disabled onkeyup = "autocompleteName('+response[i].boq_detail_id+')"></input><div id="result-boq-'+response[i].boq_detail_id+'" class = "result-boq-'+response[i].boq_detail_id+'" style = "z-index: 99;position: absolute;background-color: white;width: 25%;margin-left: 2%;text-align: left;overflow: auto;"></div></div>'+ 
							'<div class = "td" style = "width:15%"><span class="qtyer"><input style = "width: 35%;margin-right: 10%;" onkeyup = calculateTotalBoq('+response[i].boq_detail_id+",'"+tabber_id_sno+"'"+'); type = "text" id = "boq_qty-'+response[i].boq_detail_id+'" value =  "' + response[i].boq_qty + '" disabled><select id = "boq_item_unit-'+response[i].boq_detail_id+'" disabled><option value="'+response[i].type_id+'" selected>'+response[i].type_name+'</option></select></span></div>'+ 
							'<div class = "td"><select id = "boq_complexity-'+response[i].boq_detail_id+'" disabled><option value = "'+response[i].complexity+'">'+response[i].complexity+'</select></div>'+
							'<div class = "td"><input style = "width: 35%;margin-right: 10%;" type = "text" id = "boq_length-'+response[i].boq_detail_id+'" value =  "' + response[i].boq_length + '" disabled><select id = "boq_length_unit-'+response[i].boq_detail_id+'" disabled><option value = "'+response[i].boq_length_unit_id+'">'+response[i].unit_name_length+'</option></select></div>'+ 
							'<div class = "td"><input style = "width: 35%;margin-right: 10%;" type = "text" id = "boq_surfacearea-'+response[i].boq_detail_id+'" value =  "' + response[i].boq_surfacearea + '" disabled><select id = "boq_surfacearea_unit-'+response[i].boq_detail_id+'" disabled><option value = "'+response[i].boq_surfacearea_unit_id+'">'+response[i].unit_name_surfacearea+'</option></select></select></div>'+ 
							'<div class="td pricer"><input onkeyup = calculateTotalBoq('+response[i].boq_detail_id+",'"+tabber_id_sno+"'"+'); type = "text" id = "boq_price-'+response[i].boq_detail_id+'" value =  "' + response[i].boq_price + '" disabled></div>'+ 
							manhour+
							'<div class="td pricer" ><input type = "text" id = "boq_total-'+response[i].boq_detail_id+'" value= "' + response[i].boq_total + '" disabled></div>'+ 
							'</div>';
							$('#added_items-'+tabber_id).before(nw_tr);
						}
						
						
					}
				});
			}
			function viewItemDetails(family_id, section_id, division_id, subdivision_id, category_id, item_code_id, item_name){
				$('#history').show();
				$.ajax({
					type: "GET",
					url: "projects_estimate/view_item_history.php",
					data     :{ 'family_id': family_id, 'section_id':section_id, 'division_id':division_id,'subdivision_id':subdivision_id,'category_id':category_id,'item_code_id':item_code_id},
					dataType :"json",
					success: function(response) {
						$('#historybody').html('');
						for( i=0 ; i < response.length ; i ++ ){
							var new_tr = '<div class = "tr">'+
							'<div class = "td">'+response[i].no+'</div>'+
							'<div class = "td">'+item_name+'</div>'+
							'<div class = "td">'+response[i].item_price+'</div>'+
							'<div class = "td">'+response[i].item_qty+'</div>'+
							'<div class = "td">'+response[i].po_ref+'</div>'+
							'<div class = "td">'+response[i].supplier_code+'</div>'+
							'<div class = "td">'+response[i].requisition_REF+'</div>'+
							'<div class = "td">'+response[i].po_date+'</div>'+
							'</div>';
							$('#historybody').append(new_tr);
						}
						
						
					}
				});
			}
			function calculateTotalBoq(boq_detail_id, tabber_id_sno){
				var qty = $('#boq_qty-'+boq_detail_id).val();
				var cost = $('#boq_price-'+boq_detail_id).val();
				$('#totalAmount').val(parseInt($('#totalAmount').val()) - parseInt($('#amount'+tabber_id_sno).val()));
				$('#amount'+tabber_id_sno).val((parseFloat($('#amount'+tabber_id_sno).val()) - parseFloat($('#boq_total-'+boq_detail_id).val())).toFixed(3));
				
				$('#boq_total-'+boq_detail_id).val((qty*cost).toFixed(3));
				$('#amount'+tabber_id_sno).val((parseFloat($('#amount'+tabber_id_sno).val()) + parseFloat($('#boq_total-'+boq_detail_id).val())).toFixed(3));
				$('#totalAmount').val(parseInt($('#totalAmount').val()) + parseInt(Math.round($('#amount'+tabber_id_sno).val())));
			}
			function edit_item(boq_detail_id){
				if($("#edit-"+boq_detail_id).hasClass("fas fa-check")){
					edit_boq_detail(boq_detail_id, $('#boq_name-'+boq_detail_id).val(), $('#boq_qty-'+boq_detail_id).val(), $('#boq_price-'+boq_detail_id).val(), $('#boq_item_unit-'+boq_detail_id).val());
					$("#itemo-"+boq_detail_id+" :input").attr("disabled", true);
					$('#boq_item_unit-'+boq_detail_id).prop('disabled', true);
					$('#boq_complexity-'+boq_detail_id).prop('disabled', true);
					$('#boq_length_unit-'+boq_detail_id).prop('disabled', true);
					$('#boq_surfacearea_unit-'+boq_detail_id).prop('disabled', true);
					$("#edit-"+boq_detail_id).removeClass("fas fa-check");
					$("#edit-"+boq_detail_id).addClass("far fa-edit");
				}
				else{
					$("#itemo-"+boq_detail_id+" :input").attr("disabled", false);
					$('#boq_item_unit-'+boq_detail_id).prop('disabled', false);
					$('#boq_complexity-'+boq_detail_id).prop('disabled', false);
					$('#boq_length_unit-'+boq_detail_id).prop('disabled', false);
					$('#boq_surfacearea_unit-'+boq_detail_id).prop('disabled', false);
					load_select_option(boq_detail_id);
					load_select_option_length_unit(boq_detail_id);
					load_select_option_surface_area_unit(boq_detail_id);
					$("#edit-"+boq_detail_id).removeClass("far fa-edit");
					$("#edit-"+boq_detail_id).addClass("fas fa-check");
				}
			}
			function load_select_option(boq_detail_id){
				$.ajax({
					url      :"get_units.php",
					dataType :"json",
					type     :'GET',
					success  :function( response ){
						for(i =0; i<response.length;i++){
							var option = '<option value="'+response[i].unit_id+'">'+response[i].unit_name+'</option>';
							$('#boq_item_unit-'+boq_detail_id).append(option);
						}
					}
				});
				var option = ''+
				'<option value="extra light" ><?=lang('extra light'); ?></option>'+
				'<option value="light" ><?=lang('light'); ?></option>'+
				'<option value="medium" ><?=lang('medium'); ?></option>'+
				'<option value="heavy" ><?=lang('heavy'); ?></option>'+
				'<option value="extra heavy" ><?=lang('extra heavy'); ?></option>'+
				'<option value="jumbo" ><?=lang('jumbo'); ?></option>'
				$('#boq_complexity-'+boq_detail_id).append(option);
			}
			function load_select_option_length_unit(boq_detail_id){
				$.ajax({
					url      :"get_units.php",
					dataType :"json",
					type     :'GET',
					success  :function( response ){
						for(i =0; i<response.length;i++){
							
							var option = '<option value="'+response[i].unit_id+'">'+response[i].unit_name+'</option>';
							$('#boq_length_unit-'+boq_detail_id).append(option);
						}
					}
				});
				
			}
			function load_select_option_surface_area_unit(boq_detail_id){
				$.ajax({
					url      :"get_units.php",
					dataType :"json",
					type     :'GET',
					success  :function( response ){
						for(i =0; i<response.length;i++){
							
							var option = '<option value="'+response[i].unit_id+'" >'+response[i].unit_name+'</option>';
							$('#boq_surfacearea_unit-'+boq_detail_id).append(option);
						}
					}
				});
				
			}
			function load_Boq_details(project_id){
				$('#tableBody-boq').html('');
				$.ajax({
					type: "GET",
					url: "projects_estimate/view_boq_details_project.php",
					data     :{ 'project_id': project_id},
					dataType :"json",
					success: function(response) {
						var tabber_id_sno = "";
						var cc = 0;
						var totalAmount = 0;
						for( i=0 ; i < response.length ; i ++ ){
							cc++;
							var nw_tr = '<div id="itemo-' + response[i].boq_detail_id + '" class="tr quote_item" idler="' + response[i].boq_detail_id + '">'+ 
							'<div class="td item-c">' + response[i].no + '</div>'+ 
							'<div class ="td">' + response[i].boq_name + '</div>'+ 
							'<div class = "td">'+response[i].type_name+'</div>'+
							'<div class = "td"><span class="qtyer">' + response[i].boq_qty + '</span>' + "(" + response[i].type_name + ")" + '</div>'+ 
							'<div class="td pricer">' + response[i].boq_price + '</div>'+ 
							'<div class="td pricer">' + response[i].boq_total + '</div>'+ 
							'</div>';
							totalAmount += parseInt(response[i].boq_total);
							$('#tableBody-boq').append(nw_tr);
						}
						
						var nw_tr = '<div class = "tr">'+
						'<div class = "td"></div>'+
						'<div class = "td"></div>'+
						'<div class = "td"></div>'+
						'<div class = "td"></div>'+
						'<div class = "td">Total Amount </div>'+
						'<div class = "td">'+totalAmount.toFixed(3);+'</div>'+
						'</div>';
						$('#tableBody-boq').append(nw_tr);
						
					}
				});
			}
			
			function ClearInputForm(tabber_id){
				$('#item_name'+tabber_id).val('');
				$('#item_qty'+tabber_id).val('');
				$('#item_unit'+tabber_id).val('0');
				$('#item_complexity'+tabber_id).val('0');
				$('#item_price'+tabber_id).val('');
				$('#item_unit_length'+tabber_id).val('0');
				$('#item_unit_surface_area'+tabber_id).val('0');
				$('#item_length'+tabber_id).val('');
				$('#item_surface_area'+tabber_id).val('');
			}
			
			
			function rem_item(idd, tabber_id_sno, ths_tot, boq_detail_id){
				if(document.getElementById('amount'+tabber_id_sno).value!=""){
					var totalAmount=parseInt(document.getElementById('amount'+tabber_id_sno).value)-parseInt(ths_tot);
					$('#amount'+tabber_id_sno).val(totalAmount.toFixed(3));
				}
				
				$('#itemo-' + idd).remove();
				itemsCount--;
				fix_counters();
				
				rem_boq_detail(boq_detail_id);
			}
			
			function fix_counters(){
				
				var cc = 0;
				$('.item-c').each(function(){
					cc++;
					$(this).html(cc);
				});
				
				var sub_tot = 0;
				$('.quote_item').each(function(){
					var idd = parseInt($(this).attr('idler'));
					var ths_qty = parseFloat($('#itemo-' + idd + ' .qtyer').html());
					var ths_prc = parseFloat($('#itemo-' + idd + ' .pricer').html());
					sub_tot = (ths_qty * ths_prc) + sub_tot;
				});
				
				
				
				
				
				
				
				
			}
			function setlabourKPI(input , KPI , manhour, unit_id){
				var x = $('#tabber_id').val().split('-')[1];
				$('#item_name-'+x).val(input);
				$('#item_price-'+x).val(KPI);
				$('#item_manhour-'+x).val(manhour);
				$('#item_unit-'+x).val(unit_id);
				$(".result-name-boq").hide();
			}
			function setvalue(input, family_id , section_id, division_id , subdivision_id, category_id, item_code_id,boq_detail_id){
				var x = $('#tabber_id').val().split('-')[1];
				if(!boq_detail_id){
					$('#item_name-'+x).val(input);
					$('#item_code_id-'+x).val(item_code_id);
					$('#category_id-'+x).val(category_id);
					$('#division_id-'+x).val(division_id);
					$('#subdivision_id-'+x).val(subdivision_id);
					$('#section_id-'+x).val(section_id);
					$('#family_id-'+x).val(family_id);
				}
				$(".result-name-boq").hide();
				$('#boq_name-'+boq_detail_id).val(input);
				$(".result-boq-"+boq_detail_id).hide();
			}
			function autocompleteName(boq_detail_id){
				var inputVal = $('#boq_name-'+boq_detail_id).val();
				$(".result-boq-"+boq_detail_id).html('');
				if(inputVal.length){
					$.get("CodingSearch.php", {term: inputVal, id:boq_detail_id}).done(function(data){
						// Display the returned data in browser
						$(".result-boq-"+boq_detail_id).append(data);
					});
				}
				else{
					$(".result-name-boq").hide();
				}
			}
			window.onclick = function(event) {
				if (!event.target.matches('#autocomplete-name')) {
					
					$(".result-name-boq").hide();
					
				}   
			}
			$('#autocomplete-name input[type="text"]').on("keyup input", function(){
				var inputVal = $(this).val();
				var resultDropdown = $(this).siblings(".result-name-boq");
				var x = $('#tabber_id').val().split('-')[1];
				if(inputVal.length){
					if($("#manhour-boq-"+x).is(":hidden")){
						$.get("CodingSearch.php", {term: inputVal}).done(function(data){
							// Display the returned data in browser
							resultDropdown.html(data);
							$(".result-name-boq").show();
						});
					}
					else{
						$.get("ProjectParameter.php", {term: inputVal}).done(function(data){
							// Display the returned data in browser
							resultDropdown.html(data);
							$(".result-name-boq").show();
						});
					}
				} 
				else{
					resultDropdown.empty();
					$(".result-name-boq").hide();
				}
			});
			
			function load_work_scope(project_id){
				$.ajax({
					type: "GET",
					url: "projects_estimate/view_scope_details.php",
					data     :{ 'project_id': project_id},
					dataType :"json",
					success: function(response) {
						var cc = 0;
						for( i=0 ; i < response.length ; i ++ ){
							
							cc++;
							var nw_tr = '<tr id="itemo-' + response[i].scope_id + '" class="quote_item" idler="' + response[i].scope_id + '">'+ 
							'<td><i onclick="rem_item1(' + response[i].scope_id + ');" class="fa fa-trash" style="color:red;cursor:pointer;" area-hidden="true"></i></td>'+ 
							'<td class="item-c">' + response[i].scope_id + '</td>'+ 
							'<td>' + response[i].item_name + '</td>'+ 
							'<td>'+response[i].unit_name+'</td>'+
							'<td><span class="qtyer">' + response[i].item_qty + '('+response[i].unit_name+')'+ '</td>'+ 
							'<td class="pricer">' + response[i].item_price.toFixed(3) + '</td>'+ 
							'<td class="pricer">' + response[i].ths_tot.toFixed(3) + '</td>'+ 
							'</tr>';
							
							$('#wos_added_items').before(nw_tr);
						}
						
						
					}
				});
			}
			
			function Upload() {
				//Reference the FileUpload element.
				$('#loading').show();
				var fileUpload = document.getElementById("materialfile");
				
				//Validate whether File is valid Excel file.
				var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xls|.xlsx)$/;
				if (regex.test(fileUpload.value.toLowerCase())) {
					if (typeof (FileReader) != "undefined") {
						var reader = new FileReader();
						
						//For Browsers other than IE.
						if (reader.readAsBinaryString) {
							reader.onload = function (e) {
								ProcessExcel(e.target.result);
							};
							reader.readAsBinaryString(fileUpload.files[0]);
							} else {
							//For IE Browser.
							reader.onload = function (e) {
								var data = "";
								var bytes = new Uint8Array(e.target.result);
								for (var i = 0; i < bytes.byteLength; i++) {
									data += String.fromCharCode(bytes[i]);
								}
								ProcessExcel(data);
							};
							reader.readAsArrayBuffer(fileUpload.files[0]);
						}
						} else {
						alert("This browser does not support HTML5.");
					}
					} else {
					alert("Please upload a valid Excel file.");
				}
			};
			function ProcessExcel(data) {
				//Read the Excel File data.
				$('#loading').show();
				var workbook = XLSX.read(data, {
					type: 'binary'
				});
				
				//Fetch the name of First Sheet.
				var firstSheet = workbook.SheetNames[0];
				
				//Read all rows from First Sheet into an JSON array.
				var excelRows = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[firstSheet]);
				
				
				var profile = "";
				//Add the data rows from Excel file.
				for (var i = 0; i < excelRows.length; i++) {
					//Add the data row.
					if(excelRows[i].Grade){
						if(excelRows[i].Grade == 'Total'){
							var splitName = profile.split("*");
							var length = splitName.length;
							var complexity = "NA";
							if(length > 2){
								var complexity_value = profile.split('*')[2]
								if(complexity_value>=0 && complexity_value <=20){
									complexity = "extra light";
								}
								else if(complexity_value>=21 && complexity_value <=40){
									complexity = "light";
								}
								else if(complexity_value>=41 && complexity_value <=80){
									complexity = "medium";
								}
								else if(complexity_value>=81 && complexity_value <=120){
									complexity = "heavy";
								}
								else if(complexity_value>=121 && complexity_value <=200){
									complexity = "extra heavy";
								}
								else{
									complexity = "jumbo";
								}
							}
							$.ajax({
								type: "GET",
								url: "projects_estimate/export_material_excel.php",
								data     :{ 'profile': profile , 'weight' : excelRows[i].weight, 'level1_id':$('#level1_id').val() ,  'complexity': complexity, 'length':excelRows[i].Length ,'surfacearea':excelRows[i].surfaceArea},
								dataType :"json",
								success: function(response) {
									//alert("success");
									
								},
								error:function(error){
									//alert("error");
								}
							});
						}
						if(excelRows[i].Profile){
							profile = excelRows[i].Profile
						}
						
					}
					
				}
				loadData('-2');
				
			};
			
		</script>
		
		<?php
			if ( isset($_FILES["filetoUpload"]) ) {
				echo "in";
				try {
					if (!move_uploaded_file($_FILES["filetoUpload"]["tmp_name"], "fileupload/" . $_FILES["filetoUpload"]["name"])) {
						die ('File didn\'t upload');
						} else {            
						//opens the uploaded file for extraction
						echo 'Upload Complete!';
					}
				} 
				catch (Exception $e) {
					die ('File did not upload: ' . $e->getMessage());
				}
				echo "moved";
				
			}
		?>
	</body>
</html>


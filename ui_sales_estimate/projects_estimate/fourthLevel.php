
<!-- <div class = "prodList">
	<div class = "table">
		<div class="tableHeader">
			<div class="tr">
				<div class = "th">No.</div>
				<div class = "th">Product Name</div>
				<div class = "th">Product Type</div>
				<div class = "th">Edit</div>
				<div class = "th">Delete</div>
				<div class = "th">Start Estimation</div>
				<div class = "th">Total </div>
			</div>
		</div>
		<div class="tableBody" id = "level4Body">
			
		</div>

	</div>
</div> -->


<input type = "hidden" id = "tabber_id" name = "tabber_id">
<input type = "hidden" id = "boq_id" name = "boq_id">
<div  id = "addProductLeveltest">

<form method="post" name="firstLevel" class = "addform" id = "level4Form">

<div class  ="header-title"   id = "header-boq-title<?=$tabber_id?>" style = "float: left;font-size: 25px;"></div>


<div class="table" id = "boq_normal<?=$tabber_id?>">
	<div class = "tableHeader">
		<div class = "tr">
			<div class = "th"><i onclick = "delete_boq(<?=$tabber_id?>);" class="fa fa-trash" ></i></div>
			<div class = "th"><?=lang('No.'); ?></div>
			<div class = "th" style = "width:20%"><?=lang('name'); ?></div>
			<div class = "th" style = "width:15%" id = "qty-boq<?=$tabber_id?>"><?=lang('Quantity'); ?></div>
			<div class = "th" style = "width:15%" id = "complexity-boq<?=$tabber_id?>"><?=lang('Complexity'); ?></div>
			<div class = "th" style = "width:15%" id = "length-boq<?=$tabber_id?>"><?=lang('Length'); ?></div>
			<div class = "th" style = "width:15%" id = "sa-boq<?=$tabber_id?>"><?=lang('surface area'); ?></div>
			<div class = "th" style = "width:15%" id = "cost-boq<?=$tabber_id?>"><?=lang('Cost'); ?></div>
			<div class = "th" style = "display:none" id = "manhour-boq<?=$tabber_id?>"><?=lang('Manhour'); ?></div>
			<div class = "th" style = "width:35%" ><?=lang('Total'); ?></div>
		</div>
	</div>
	<div class="tableBody" id = "level4Body">
			
		</div>

	<div class = "tableBody">
		<div class = "tr" id="added_items<?=$tabber_id?>"><hr></div>	
		<div class = "tr">
			<div class = "td"></div>
			<div class = "td"></div>
			<div class = "td">
				<div class="form-item" id ="autocomplete-name">
					<select class="data-elem"  id="name" name="name" required >

			<option id="structural_sections_id" value="" disabled selected>Choose a Name</option>
			<?php

				$qu_type_sel = "SELECT * FROM  `structural_sections`";
				$qu_type_EXE = mysqli_query($KONN, $qu_type_sel);
				if(mysqli_num_rows($qu_type_EXE)){
					while($type_REC = mysqli_fetch_assoc($qu_type_EXE)){
						$Column_1 = $type_REC['Hot_finished_Square_Hollow_Sections_in_accordance_with_EN_10210'];
						$Column_2 = $type_REC['Column_2'];
						$Column_3 = $type_REC['Column_3'];
					?>
					<option value="<?=$Column_1?> | <?=$Column_2?>"><?=$Column_1?>  | <?=$Column_2?></option>
					<?php
						
					}
				}

			?>
		</select>
					<div id="result-name-boq" class = "result-name-boq"></div>
				</div>
			</div>
			
			<div class = "td"  >
				<div class="form-item">
					<input type="text" placeholder="<?=lang('item_qty'); ?>" id="item_qty<?=$tabber_id?>" style = "width: 35%;margin-right: 10%;">
					<select id="item_unit4" class="data-elem" style = "width: 40%;">
						<option value="0" disabled selected><?=lang('---select Unit ---'); ?></option>
						<?php
							$qpt = "SELECT * FROM `gen_items_units`";
							$QER_E = mysqli_query($KONN, $qpt);
							if(mysqli_num_rows($QER_E) > 0){
								while($pt_dt = mysqli_fetch_assoc($QER_E)){
								?>
								<option value="<?=$pt_dt['unit_id']; ?>" id="uniter-<?=$pt_dt['unit_id']; ?><?=$tabber_id?>" uniter="<?=$pt_dt['unit_name']; ?>"><?=$pt_dt['unit_name']; ?></option>
								<?php
								}
							}
						?>
					</select>
				</div>
			</div>
			<div class = "td" id = "boq-complexity-value<?=$tabber_id?>">
				<div class="form-item">
					<select id="item_complexity<?=$tabber_id?>" class="data-elem" style = "width:100%">
						<option value="0" disabled selected><?=lang('---select Unit ---'); ?></option>
						<option value="extra light" ><?=lang('extra light'); ?></option>
						<option value="light" ><?=lang('light'); ?></option>
						<option value="medium" ><?=lang('medium'); ?></option>
						<option value="heavy" ><?=lang('heavy'); ?></option>
						<option value="extra heavy" ><?=lang('extra heavy'); ?></option>
						<option value="jumbo" ><?=lang('jumbo'); ?></option>
					</select>
				</div>
			</div>
	
<script>
		var temp="jumbo"; 
    $("#item_complexity<?=$tabber_id?>").val(temp);


	

	

</script>
			<div class = "td" id = "boq-qty-value<?=$tabber_id?>">
				<div class="form-item">
					<input type="text" placeholder="<?=lang('item_length'); ?>" id="item_length<?=$tabber_id?>" style = "width: 35%;margin-right: 5%;">
					<select id="item_unit_length<?=$tabber_id?>" class="data-elem" style ="width:40%">
						<option value="0" disabled selected><?=lang('---select Unit ---'); ?></option>
						<?php
							$qpt = "SELECT * FROM `gen_items_units`";
							$QER_E = mysqli_query($KONN, $qpt);
							if(mysqli_num_rows($QER_E) > 0){
								while($pt_dt = mysqli_fetch_assoc($QER_E)){
								?>
								<option value="<?=$pt_dt['unit_id']; ?>" id="uniter-length-<?=$pt_dt['unit_id']; ?><?=$tabber_id?>" uniter="<?=$pt_dt['unit_name']; ?>"><?=$pt_dt['unit_name']; ?></option>
								<?php
								}
							}
						?>
					</select>
				</div>
			</div>
			
			<div class = "td" id = "boq-sa-value<?=$tabber_id?>">
				<div class="form-item">
					<input type="text" placeholder="<?=lang('item_surface_area'); ?>" id="item_surface_area<?=$tabber_id?>" style = "width: 35%;margin-right: 5%;">
					<select id="item_unit_surface_area<?=$tabber_id?>" class="data-elem" style = "width:30%">
						<option value="0" disabled selected><?=lang('---select Unit ---'); ?></option>
						<?php
							$qpt = "SELECT * FROM `gen_items_units`";
							$QER_E = mysqli_query($KONN, $qpt);
							if(mysqli_num_rows($QER_E) > 0){
								while($pt_dt = mysqli_fetch_assoc($QER_E)){
								?>
								<option value="<?=$pt_dt['unit_id']; ?>" id="uniter-sa-<?=$pt_dt['unit_id']; ?><?=$tabber_id?>" uniter="<?=$pt_dt['unit_name']; ?>"><?=$pt_dt['unit_name']; ?></option>
								<?php
								}
							}
						?>
					</select>
				</div>
			</div>
			
			<div class = "td">
				<div class="form-item">
					<input type="text" placeholder="<?=lang('item_cost'); ?>" id="item_price<?=$tabber_id?>">
					
				</div>
			</div>
			
			<div class = "td notdisplayed" style = "display:none" id = "manhour-input<?=$tabber_id?>">
				<div class="form-item">
					<input type="text" placeholder="<?=lang('item_manhour'); ?>" id="item_manhour<?=$tabber_id?>">
				</div>
			</div>
			<div class = "td">
				<div class="form-item">
					<!-- <button class="btn btn-info" onclick = "closeaddItem('ProductLevel4')" type="button" style = "font-size:15px">&nbsp;&nbsp;&nbsp;<?=lang('Add_item'); ?>&nbsp;&nbsp;&nbsp;</button> -->
					<button class="btn btn-info"  type = "submit" name = "submitRecordLevel4" id = "button-add" onclick = "closeaddItem('ProductLevel4')"><?=lang('Add_item'); ?>&nbsp;&nbsp;&nbsp;</button>

				</div>
			</div>
			<input type = "text" id = "item_code_id<?=$tabber_id?>" hidden>
			<input type = "text" id = "category_id<?=$tabber_id?>" hidden>
			<input type = "text" id = "section_id<?=$tabber_id?>" hidden>
			<input type = "text" id = "subdivision_id<?=$tabber_id?>" hidden>
			<input type = "text" id = "division_id<?=$tabber_id?>" hidden>
			<input type = "text" id = "family_id<?=$tabber_id?>" hidden>
		</div>
		
	</div>
	
</div>
</form>
						</div>

						<div class = "tabber-boq-4 notdisplayed" style = "margin-top: 5%;">

<?php
    $tabber_id = "-4";
    $complexity_id = "heavy";
    include('boq.php');

    
?>

</div>
<!-- <i class="far fa-plus-square addbutton displayed" id = "addbutton"   onclick = "openaddItem('ProductLevel4')"></i> -->


<div class = "add-new notdisplayed" id = "addProductLevel4">
	<?php 
		$headerName = 'ProductLevel4';
		
		include('addHeader.php');

	?>
		<label for ="no">Product Name</label>
		<select id="name" name="name" required >

			<option id="structural_sections_id" value="" disabled selected>Choose a Name</option>
			<?php

				$qu_type_sel = "SELECT * FROM  `structural_sections`";
				$qu_type_EXE = mysqli_query($KONN, $qu_type_sel);
				if(mysqli_num_rows($qu_type_EXE)){
					while($type_REC = mysqli_fetch_assoc($qu_type_EXE)){
						$Column_1 = $type_REC['Hot_finished_Square_Hollow_Sections_in_accordance_with_EN_10210'];
						$Column_2 = $type_REC['Column_2'];
						$Column_3 = $type_REC['Column_3'];
					?>
					<option value="<?=$Column_1?> | <?=$Column_2?>"><?=$Column_1?>  | <?=$Column_2?></option>
					<?php
						
					}
				}

			?>
		</select>
		<!-- <input type = "text" id = "name" name = "name" required ><br> -->
		
		<input type = "text" id = "level3_id" name = "level3_id" value = "<?=$level3_id?>" hidden ><br>
		<input type = "text" id = "level3_name" name = "level3_name" hidden>

		<input type = "text" id="id" name = "id" hidden>
		<label for ="type_name">Type</label>
		<select id="type_id" name="type_id" disabled>
			<?php
				$qu_type_sel = "SELECT * FROM  `z_levels_type`";
				$qu_type_EXE = mysqli_query($KONN, $qu_type_sel);
				if(mysqli_num_rows($qu_type_EXE)){
					while($type_REC = mysqli_fetch_assoc($qu_type_EXE)){
						$type_id = $type_REC['type_id'];
						$type_name = $type_REC['type_name'];
					?>
					<?php
							if($type_id == 4){
					?>
					<option selected value="<?=$type_id?>" ><?=$type_name?></option>
					<?php		
				}
			?>

					<?php
					}
				}
			?>

		</select>
		<button type = "submit" name = "submitRecordLevel4" id = "button-add" onclick = "closeaddItem('ProductLevel4')">Add</button>

</div>



<script>
	document.getElementById('level4Form').onsubmit =function addlevel4Data() {

		var name = $('#addProductLeveltest').find('#name').val();
		var desc = '';
		var level3_id = $('#level3_id').val();
		var type_id = $('#addProductLevel4').find('#type_id').val();
		var id = 0;
		console.log(name,level3_id,type_id,id);

		$.ajax({
			url: "projects_estimate/add_level4_data.php",
			data     :{ 'name': name,'level3_id':level3_id, 'description':desc,'type_id':type_id,'id':id },
			dataType :"json",
			type     :'GET',
			success: function (response) {
				alert("Success");
				loadData('-4');
			},
			error: function(error){
				alert(error);
			},
			compete: function(rr){
				alert(rr);
			}
		});
		return false;
	};
	function loadLevel4Data(id, name, level1_id, level2_id, level3_id){
		console.log(name);
		$.ajax({
			url      :"projects_estimate/fourthLevelData.php",
			data     :{ 'id': id,'level1_id':level1_id,'level2_id':level2_id,'level3_id':level3_id},
			dataType :"json",
			type     :'POST',
			success  :function( response ){
				$('#level5Body').html('');
				$('#level4_id').val(id);
				$('#level4_name').val(name);
				$('#heirarchy5').html($('#heirarchy4').text()+" / " + name);
				$('#sel-5').html(name);
				var cc = 0;
				for( i=0 ; i < response.length ; i ++ ){
					cc++;
					var req_item_id = parseInt( response[i].req_item_id );
					var boq_td = '';
					if(response[i].show_complete == '0'){
						boq_td = '<i class="fas fa-folder" onclick = "loadBoq('+"'"+response[i].type_name+"'"+","+"5"+","+"'"+response[i].level5_id+"'"+","+level1_id+","+level2_id+","+level3_id+","+id+","+response[i].level5_id+","+response[i].boq_id+","+"'"+response[i].level5_name+"'"+');"></i>';
						if(response[i].boq_id=='0'){
							boq_td = '<i class="fas fa-check complete" onclick = "loadBoq('+"'"+response[i].type_name+"'"+","+"5"+","+ "'"+response[i].level5_id+"',"+level1_id+","+level2_id+","+level3_id+","+"'"+id+"',"+response[i].level5_id+", 0"+","+"'"+response[i].level5_name+"'"+');"></i>';

						}
					}

					var tr = '' + 
					'<div class = "tr" id = "level5-'+response[i].level5_id+'">'+
					'<div class = "td">' + response[i].sno + '</div>'+
					'<div class = "td"><a>'+response[i].level5_name+'</a> </div>'+
					'<div class = "td">'+response[i].type_name+'</div>'+
					'<div class = "td"><i class="far fa-edit " onclick = "openEdit('+ "'" +response[i].level5_name+ "'" +","+response[i].level5_id+","+ "'" +response[i].level5_description+ "'" +","+response[i].type_id+ ", 'addProductLevel5'" + ')"></i></div>'+
					'<div class = "td"><i class="fas fa-trash" onclick = "deleteProduct(' + "'" + 'level5' + "'," + response[i].level5_id + ')"></i></div>'+
					'<div class = "td" id = "completed-5-'+response[i].level5_id+'" style = "width: 10%;">'+boq_td+
					'</div>'+
					'<div class = "td" style = "width: 15%;"><input class = "estimation_amount" style = "border:none;" type = "text" id = "amount-5-'+response[i].level5_id+'" value = '+response[i].total_amount+'></div>'+			
					'</div>'

					$('#level5Body').append( tr );
				}
			},
			error    :function( rr ){
				alert('Data Error No: 5467653');
			},
		});
	}
	
</script>
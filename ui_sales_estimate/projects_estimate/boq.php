
<input type = "hidden" id = "tabber_id" name = "tabber_id">
<input type = "hidden" id = "boq_id" name = "boq_id">
<div class  ="header-title"   id = "header-boq-title<?=$tabber_id?>" style = "float: left;font-size: 25px;"></div>



<div class="table" id = "boq_normal<?=$tabber_id?>">
	<div class = "tableHeader">
		<div class = "tr">
			<div class = "th"><i onclick = "delete_boq(<?=$tabber_id?>);" class="fa fa-trash" ></i></div>
			<div class = "th"><?=lang('No.'); ?></div>
			<div class = "th" style = "width:40%"><?=lang('name'); ?></div>
			<div class = "th" style = "width:10%" id = "qty-boq<?=$tabber_id?>"><?=lang('Quantity'); ?></div>
			<div class = "th" style = "width:10%" id = "complexity-boq<?=$tabber_id?>"><?=lang('Complexity'); ?></div>
			<div class = "th" style = "width:10%" id = "length-boq<?=$tabber_id?>"><?=lang('Length'); ?></div>
			<div class = "th" style = "width:10%" id = "sa-boq<?=$tabber_id?>"><?=lang('surface area'); ?></div>
			<div class = "th" id = "cost-boq<?=$tabber_id?>"><?=lang('Cost'); ?></div>
			<div class = "th" style = "display:none" id = "manhour-boq<?=$tabber_id?>"><?=lang('Manhour'); ?></div>
			<div class = "th"><?=lang('Total'); ?></div>
		</div>
	</div>

	<div class = "tableBody">
		<div class = "tr" id="added_items<?=$tabber_id?>"><hr></div>	
		<div class = "tr">
			<div class = "td"></div>
			<div class = "td"></div>
			<div class = "td">
				<div class="form-item" id ="autocomplete-name">
					<input type="text" placeholder="<?=lang('item_name'); ?>" id="item_name<?=$tabber_id?>" value="">
					<div id="result-name-boq" class = "result-name-boq"></div>
				</div>
			</div>
			
			<div class = "td"  >
				<div class="form-item">
					<input type="text" placeholder="<?=lang('item_qty'); ?>" id="item_qty<?=$tabber_id?>" style = "width: 35%;margin-right: 10%;">
					<select id="item_unit<?=$tabber_id?>" class="data-elem" style = "width: 40%;">
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
					<button class="btn btn-info" onclick="add_item('<?=$tabber_id?>');" type="button" style = "font-size:15px">&nbsp;&nbsp;&nbsp;<?=lang('Add_item'); ?>&nbsp;&nbsp;&nbsp;</button>
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


<div class="table" id = "boq_manpower<?=$tabber_id?>">
	<div class = "tableHeader">
		<div class = "tr">
			<div class = "th"><i onclick = "delete_boq(<?=$tabber_id?>);" class="fa fa-trash" ></i></div>
			<div class = "th"><?=lang('No.'); ?></div>
			<div class = "th" id = "head-name<?=$tabber_id?>"><?=lang('Complexity'); ?></div>
			<div class = "th" id="head-weight<?=$tabber_id?>" ><?=lang('weight'); ?></div>
			<div class = "th" id = "head-group<?=$tabber_id?>" style = "display:none;"><?=lang('Group'); ?></div>
			<div class = "th" id = "head-standard<?=$tabber_id?>" style = "display:none;"><?=lang('Standard'); ?></div>
			<div class = "th" id = "head-coat<?=$tabber_id?>" style = "display:none;"><?=lang('Number of Coat'); ?></div>
			<div class = "th" id = "head-sa<?=$tabber_id?>" style = "display:none;"><?=lang('Surface Area'); ?></div>
			<div class = "th"><?=lang('Man Hour'); ?></div>
			<div class = "th"><?=lang('ManHour cost'); ?></div>
			<div class = "th"><?=lang('Unit of cost'); ?></div>
			<div class = "th"><?=lang('Total'); ?></div>
		</div>
	</div>
	<div class = "tableBody">
		<div class = "tr" id="added_items1<?=$tabber_id?>"><hr></div>	
		<div class = "tr">
			<div class = "td"></div>
			<div class = "td"></div>
			<div class = "td">
				<div class="form-item" id ="autocomplete-name1">
					<input type="text" placeholder="<?=lang('Complexity'); ?>" id="item_name1<?=$tabber_id?>" value="">
					<div id="result-name-boq1" class = "result-name-boq1"></div>
				</div>
			</div>
			
			<div class = "td"  id = "weight1<?=$tabber_id?>">
							<div class="form-item">
					<input type="text" placeholder="<?=lang('item_weight'); ?>" id="item_qty1<?=$tabber_id?>">
					<select id="item_unit1<?=$tabber_id?>" class="data-elem">
						<option value="0" disabled selected><?=lang('---select Unit ---'); ?></option>
						<?php
							$qpt = "SELECT * FROM `gen_items_units`";
							$QER_E = mysqli_query($KONN, $qpt);
							if(mysqli_num_rows($QER_E) > 0){
								while($pt_dt = mysqli_fetch_assoc($QER_E)){
								?>
								<option value="<?=$pt_dt['unit_id']; ?>" id="uniter1-<?=$pt_dt['unit_id']; ?><?=$tabber_id?>" uniter="<?=$pt_dt['unit_name']; ?>"><?=$pt_dt['unit_name']; ?></option>
								<?php
								}
							}
						?>
					</select>
				</div>
			</div>
			
			
			
			<div  class = "td" id = "item-group<?=$tabber_id?>" style = "display:none; width:25%;">
				<div class="form-item" >
					<select id="item_group1<?=$tabber_id?>" class="data-elem" style = "width:100%">
						<option value="0" disabled selected><?=lang('---select Unit ---'); ?></option>
						<option value="Section">Section</option>
						<option value="Plate">Plate</option>
						<option value="Pipes">Pipes</option>
					</select>
				</div>
			</div>
			
			<div class = "td" id = "standard-input1<?=$tabber_id?>" style = "display:none;">
				<div class="form-item">
					<select id="item_standard1<?=$tabber_id?>" class="data-elem" style = "width:100%">
						<option value="0" disabled selected><?=lang('---select Unit ---'); ?></option>
						<option value="2.5">SA 2.5</option>
						<option value="2">SA 2</option>
						<option value="3">SA 3</option>
					</select>
				</div>
			</div>
			
			<div class = "td" id = "coat-input1<?=$tabber_id?>" style = "display:none;">
				<div class="form-item">
					<input type="text" placeholder="<?=lang('Number of coat'); ?>" id="item_coat<?=$tabber_id?>" onkeyup = "calculateItemCost(<?=$tabber_id?>);">
				</div>
			</div>
			
			
			<div class = "td" id = "surfacearea-input1<?=$tabber_id?>" style = "display:none;">
				<div class="form-item">
					<input type="text" placeholder="<?=lang('item_surface_area'); ?>" id="item_surface_area1<?=$tabber_id?>" onkeyup = "calculateItemCost(<?=$tabber_id?>);">
				</div>
			</div>
			
			
			<div class = "td" id = "manhour-input1<?=$tabber_id?>">
				<div class="form-item">
					<input type="text" placeholder="<?=lang('item_manhour'); ?>" id="item_manhour1<?=$tabber_id?>" onkeyup = "calculateItemCost(<?=$tabber_id?>);">
				</div>
			</div>
			
			<div class = "td"  id = "manhour-cost-input1<?=$tabber_id?>">
				<div class="form-item">
					<input type="text" placeholder="<?=lang('item_manhour_cost'); ?>" id="item_manhour_cost1<?=$tabber_id?>" onkeyup = "calculateItemCost(<?=$tabber_id?>);">
				</div>
			</div>
			
			<div class = "td">
				<div class="form-item">
					<input type="text" placeholder="<?=lang('item_cost'); ?>" id="item_price1<?=$tabber_id?>">
				</div>
			</div>
			
			<div class = "td">
				<div class="form-item">
					<button class="btn btn-info" onclick="add_item_manhour('<?=$tabber_id?>');" type="button" style = "font-size:15px">&nbsp;&nbsp;&nbsp;<?=lang('Add_item'); ?>&nbsp;&nbsp;&nbsp;</button>
				</div>
			</div>
		</div>
		
	</div>	
</div>


<div class="table" id = "boq_st<?=$tabber_id?>" style = "table-layout: fixed;">
	<div class = "tableHeader">
		<div class = "tr">
			<div class = "th" style = "width:2%"><i onclick = "delete_boq(<?=$tabber_id?>);" class="fa fa-trash" ></i></div>
			<div class = "th" style = "width:3%"><?=lang('No.'); ?></div>
			<div class = "th"><?=lang('Name'); ?></div>
			<div class = "th" ><?=lang('Number of Coat'); ?></div>
			<div class = "th"  ><?=lang('Surface Area'); ?></div>
			<div class = "th"><?=lang('Volume Solids'); ?></div>
			<div class = "th"><?=lang('Loss Factor(%)'); ?></div>
			<div class = "th"><?=lang('Ind. calc Factor'); ?></div>
			<div class = "th"><?=lang('Qty'); ?></div>
			<div class = "th"><?=lang('Avg DFT (micron)'); ?></div>
			<div class = "th"><?=lang('Total Paint'); ?></div>
			<div class = "th"><?=lang('Percentage'); ?></div>
			<div class = "th"><?=lang('Cost'); ?></div>
			<div class = "th"><?=lang('Total'); ?></div>
		</div>
	</div>
	<div class = "tableBody">
		<div class = "tr" id="added_items2<?=$tabber_id?>"><hr></div>	
		<div class = "tr">
			<div class = "td"></div>
			<div class = "td"></div>
			<div class = "td" >
				<div class="form-item" id ="autocomplete-name3">
					<input type="text" placeholder="<?=lang('Name'); ?>" id="item_name2<?=$tabber_id?>" value="" style = "width: 100%;" onkeyup = "autocompletevalue(<?=$tabber_id?>);"> 
				</div>
			</div>
			
			<div class = "td">
				<div class="form-item" id ="no_of_coat">
					<input type="text" placeholder="<?=lang('No of Coat'); ?>" id="coat-input2<?=$tabber_id?>" value="1" style = "width: 100%;">
				</div>
			</div>
			
			<div class = "td" id = "sa1<?=$tabber_id?>" >
				<div class="form-item">
					<input type="text" placeholder="<?=lang('item_weight'); ?>" id="sa2<?=$tabber_id?>" style = "width: 60%;margin-rigth:10%">
					<select id="sa_item_unit2<?=$tabber_id?>" class="data-elem" style = "width: 30%;">
						<option value="0" disabled selected><?=lang('---select Unit ---'); ?></option>
						<?php
							$qpt = "SELECT * FROM `gen_items_units`";
							$QER_E = mysqli_query($KONN, $qpt);
							if(mysqli_num_rows($QER_E) > 0){
								while($pt_dt = mysqli_fetch_assoc($QER_E)){
								?>
								<option value="<?=$pt_dt['unit_id']; ?>" id="uniter1-<?=$pt_dt['unit_id']; ?><?=$tabber_id?>" uniter="<?=$pt_dt['unit_name']; ?>"><?=$pt_dt['unit_name']; ?></option>
								<?php
								}
							}
						?>
					</select>
				</div>
			</div>
			
			<div class = "td">
				<div class="form-item" id ="volume_solids">
					<input type="text" placeholder="<?=lang('volume_solid'); ?>" id="vs-input2<?=$tabber_id?>" value="70" style = "width: 100%;" onkeyup = "autocompletevalue(<?=$tabber_id?>);">
				</div>
			</div>
			<div class = "td">
				<div class="form-item" id ="loss_factor">
					<input type="text" placeholder="<?=lang('loss_factor'); ?>" id="lf-input2<?=$tabber_id?>" value="30" style = "width: 100%;" onkeyup = "autocompletevalue(<?=$tabber_id?>);">
				</div>
			</div>
			<div class = "td">
				<div class="form-item" id ="ind_cal_factor">
					<input type="text" placeholder="<?=lang('ind_cal'); ?>" id="icf-input2<?=$tabber_id?>" value="10" style = "width: 100%;" onkeyup = "autocompletevalue(<?=$tabber_id?>);">
				</div>
			</div>
			<div class = "td">
				<div class="form-item" id ="qty2">
					<input type="text" placeholder="<?=lang('item_qty'); ?>" id="qty-input2<?=$tabber_id?>" value="0" style = "width: 100%;">
				</div>
			</div>
			<div class = "td">
				<div class="form-item" id ="avg_dft">
					<input type="text" placeholder="<?=lang('average DFT'); ?>" id="avgdft-input2<?=$tabber_id?>" value="300" style = "width: 100%;" onkeyup = "autocompletevalue(<?=$tabber_id?>);">
				</div>
			</div>
			<div class = "td">
				<div class="form-item" id ="total_paint">
					<input type="text" placeholder="<?=lang('total paint'); ?>" id="totpaint-input2<?=$tabber_id?>" value="0" style = "width: 100%;">
				</div>
			</div>
			<div class = "td">
				<div class="form-item" id ="percentage">
					<input type="text" placeholder="<?=lang('percentage'); ?>" id="percentage-input2<?=$tabber_id?>" value="0" style = "width: 100%;">
				</div>
			</div>
			
			
			<div class = "td">
				<div class="form-item">
					<input type="text" placeholder="<?=lang('item_cost'); ?>" id="item_price2<?=$tabber_id?>" value = "0" style = "width: 100%;">
				</div>
			</div>
			
			<div class = "td">
				<div class="form-item">
					<button class="btn btn-info" onclick="add_item_st('<?=$tabber_id?>');" type="button" style = "font-size:10px">&nbsp;&nbsp;&nbsp;<?=lang('Add_item'); ?>&nbsp;&nbsp;&nbsp;</button>
				</div>
			</div>
		</div>
		
	</div>	
</div>

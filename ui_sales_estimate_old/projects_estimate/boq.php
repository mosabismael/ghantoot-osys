<input type = "hidden" id = "tabber_id" name = "tabber_id">
<input type = "hidden" id = "boq_id" name = "boq_id">
<div class  ="header-title" id = "header-boq-title<?=$tabber_id?>" style = "float: left;font-size: 25px;"></div>
<div class="table">
	<div class = "tableHeader">
		<div class = "tr">
			<div class = "th"><i onclick = "delete_boq(<?=$tabber_id?>);" class="fa fa-trash" ></i></div>
			<div class = "th"><?=lang('No.'); ?></div>
			<div class = "th"><?=lang('name'); ?></div>
			<div class = "th" id = "qty-boq<?=$tabber_id?>"><?=lang('weight'); ?></div>
			<div class = "th" style = "width:15%"><?=lang('Complexity'); ?></div>
			<div class = "th"><?=lang('length'); ?></div>
			<div class = "th"><?=lang('surface area'); ?></div>
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
			
			<div class = "td" >
				<div class="form-item">
					<input type="text" placeholder="<?=lang('item_qty'); ?>" id="item_qty<?=$tabber_id?>">
					<select id="item_unit<?=$tabber_id?>" class="data-elem">
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
			<div class = "td">
				<div class="form-item">
					<select id="item_complexity<?=$tabber_id?>" class="data-elem">
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
			
			<div class = "td">
				<div class="form-item">
					<input type="text" placeholder="<?=lang('item_length'); ?>" id="item_length<?=$tabber_id?>">
					<select id="item_unit_length<?=$tabber_id?>" class="data-elem">
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
			
			<div class = "td">
				<div class="form-item">
					<input type="text" placeholder="<?=lang('item_surface_area'); ?>" id="item_surface_area<?=$tabber_id?>">
					<select id="item_unit_surface_area<?=$tabber_id?>" class="data-elem">
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
					<button class="btn btn-info" onclick="add_item('<?=$tabber_id?>');" type="button">&nbsp;&nbsp;&nbsp;<?=lang('Add_item'); ?>&nbsp;&nbsp;&nbsp;</button>
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




<br>
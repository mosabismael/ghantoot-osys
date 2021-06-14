<input type = "hidden" id = "tabber_id" name = "tabber_id">
<input type = "hidden" id = "boq_id" name = "boq_id">
<div class  ="header-title" id = "header-boq-title<?=$tabber_id?>" style = "float: left;font-size: 25px;"></div>
<div class="table">
	<div class = "tableHeader">
		<div class = "tr">
			<div class = "th"><i onclick = "delete_boq(<?=$tabber_id?>);" class="fa fa-trash" ></i></div>
			<div class = "th"><?=lang('No.'); ?></div>
			<div class = "th"><?=lang('activity'); ?></div>
			<div class = "th"><?=lang('UOM'); ?></div>
			<div class = "th"><?=lang('WL'); ?></div>
			<div class = "th"><?=lang('KPI'); ?></div>
			<div class = "th"><?=lang('manhour'); ?></div>
			<div class = "th"><?=lang('Total'); ?></div>
		</div>
	</div>
	<div class = "tableBody">
		<div class = "tr" id="added_items<?=$tabber_id?>"><hr></div>	
		<div class = "tr">
			<div class = "td"></div>
			<div class = "td"></div>
			<div class = "td">
				<div class="form-item">
					<input type="text" placeholder="<?=lang('item_name'); ?>" id="item_name<?=$tabber_id?>" value="">
				</div>
			</div>
			<div class = "td">
				<div class="form-item">
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
					<input type="text" placeholder="<?=lang('item_wl'); ?>" id="item_qty<?=$tabber_id?>">
				</div>
			</div>
			<div class = "td">
				<div class="form-item">
					<input type="text" placeholder="<?=lang('item_kpi'); ?>" id="item_price<?=$tabber_id?>">
				</div>
			</div>
			<div class = "td">
				<div class="form-item">
					<input type="text" placeholder="<?=lang('item_manhour'); ?>" id="item_manhour<?=$tabber_id?>">
				</div>
			</div>
			<div class = "td">
				<div class="form-item">
					<button class="btn btn-info" onclick="add_item('<?=$tabber_id?>');" type="button">&nbsp;&nbsp;&nbsp;<?=lang('Add_item'); ?>&nbsp;&nbsp;&nbsp;</button>
				</div>
			</div>
		</div>
		
	</div>
	
</div>




<br>
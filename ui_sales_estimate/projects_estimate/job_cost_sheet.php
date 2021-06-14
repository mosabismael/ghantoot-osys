
<div class="form-grp">
	<div class="form-item col-100">
		<table class="tabler">
			<thead>
				<tr>
					<th><?=lang('---')?></th>
					<th><?=lang('name'); ?></th>
					<th><?=lang('price'); ?></th>
				</tr>
			</thead>
			<tbody id  = "job_cost_sheet_data">
				
				
				
				
				<tr>
					<td></td>
					<td>Total Amount </td>
					<td><div class="form-item">
						<input type="text" placeholder="<?=lang('item_price'); ?>" id="jcs_total_amount" >
					</div></td>
				</tr>
			</tbody>
			
		</table>
		<script>
			function switchInnerLevel(level1_id){
				
				if($('.level1_'+level1_id).css('display') == 'none'){
					$('.level1_'+level1_id).css('display','revert');
				}
				else{
					$('.level1_'+level1_id).css('display','none');
				}
			}
			
			function jcsData(id){
				$.ajax({
					url      :"projects_estimate/zeroLevelData.php",
					data     :{ 'project_id': id},
					dataType :"json",
					type     :'POST',
					success  :function( res ){
						jcsDataRes( res);
					},
					error    :function( rr ){
						alert('Data Error No: 5467653');
					},
				});
			}
			function jcsDataRes(response){
				$('#job_cost_sheet_data').html('');
				
				var cc = 0;
				for( i=0 ; i < response.length ; i ++ ){
					cc++;
					
					var tr = '' + 
					'<tr id = "parent-'+response[i].level1_id+'"><td>'+cc+'</td>'+
					'<td onclick = "switchInnerLevel('+response[i].level1_id+')">'+response[i].level1_name+'</td>'+
					'<td>'+response[i].total_amount+'</td></tr>';
					$('#job_cost_sheet_data').append( tr );
					
					jcsInnerData(response[i].level1_id);
					
				}
				
			}
			function jcsInnerData(id){
				$.ajax({
					url      :"projects_estimate/firstLevelData.php",
					data     :{ 'id': id},
					dataType :"json",
					type     :'POST',
					success  :function( response ){
						var cc1 = 0;
						for( i=0 ; i < response.length ; i ++ ){
							
							
							var tr = '' + 
							'<tr class = "level1_'+id+'" style = "display:none; background-color:antiquewhite;"><td></td>'+
							'<td>'+response[i].level2_name+'</td>'+
							'<td>'+response[i].total_amount+'</td></tr>';
							$('#parent-'+id).after( tr );
							
						}
					},
					error    :function( rr ){
						alert('Data Error No: 5467653');
					},
				});
				
				
			}
			
		</script>
		
	</div>
	<div class="zero"></div>
</div>


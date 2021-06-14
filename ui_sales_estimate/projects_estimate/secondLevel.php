
<div class = "prodList">
	<div class = "table">
		<div class="tableHeader">
			<div class="tr">
				<div class = "th">No.</div>
				<div class = "th">Product Name</div>
				<div class = "th" id = "other-prodType">Product Type</div>
				<div class = "th" id = "other-startEst">Start Estimation</div>
				<div class = "th" id = "other-qty" style = "display:none;">Quantity</div>
				<div class = "th" id = "other-dur" style = "display:none;">Duration(days)</div>
				<div class = "th" id = "other-cost" style = "display:none;">Cost</div>
				<div class = "th">Total </div>
				<div class = "th">Edit</div>
				<div class = "th">Delete</div>
				
			</div>
		</div>
		<div class="tableBody" id = "level2Body">
			
		</div>
	</div>
</div>
<div class = "tabber-boq-2 notdisplayed" style = "margin-top: 5%;">
	<?php
		$tabber_id = "-2";
		include('boq.php');
	?>
	
</div>
<i class="far fa-plus-square addbutton displayed" id = "addbutton"onclick = "openaddItem('ProductLevel2')"></i>
<div class = "add-new notdisplayed" id = "addProductLevel2" >
	<?php 
		$headerName = 'ProductLevel2';
		include('addHeader.php');
	?>
	<form method="post" name="firstLevel" class = "addform" id = "level2Form">
		<label for ="no">Product Name</label>
		<input type = "text" id = "name" name = "name" required ><br>
		<label for ="name" id= "prod_desc">Product description</label>
		<input type = "text" id = "description" name = "description" value = "" ><br>
		<label for ="name" id = "quantity_name" style = "display:none;">Quantity</label>
		<input type = "text" id = "quantity" style = "display:none;" value = "0" name = "quantity" required ><br>
		<label for ="name" id = "cost_name">Cost</label>
		<input type = "text" id = "cost" style = "display:none;" name = "cost" value = "0" required ><br>
		<label for ="name" id = "dur_name">Duration</label>
		<input type = "text" id = "duration" style = "display:none;" name = "duration" value = "1" required ><br>
		
		<input type = "hidden" id = "level1_id" name = "level1_id" >
		<input type = "text" id = "level1_name" name = "level1_name" hidden>
		<input type = "text" id = "id" name = "id" hidden>
		<label for ="type_name" id= "type_name">Type</label>
		<select id="type_id" name="type_id" >
			<option value="" disabled selected>Choose a group</option>
			<?php
				$qu_type_sel = "SELECT * FROM  `z_levels_type`";
				$qu_type_EXE = mysqli_query($KONN, $qu_type_sel);
				if(mysqli_num_rows($qu_type_EXE)){
					while($type_REC = mysqli_fetch_assoc($qu_type_EXE)){
						$type_id = $type_REC['type_id'];
						$type_name = $type_REC['type_name'];
					?>
					<option value="<?=$type_id?>"><?=$type_name?></option>
					<?php
					}
				}
			?>
		</select>
		
		<button type = "submit" name = "submitRecordLevel2" id = "button-add" onclick = "closeaddItem('ProductLevel2');">Add</button>
	</form>
</div>



<script>
	document.getElementById('level2Form').onsubmit =function addlevel2Data() {
		var name = $('#addProductLevel2').find('#name').val();
		var desc = $('#addProductLevel2').find('#description').val();
		var level1_id = $('#level1_id').val();
		var type_id = $('#addProductLevel2').find('#type_id').val();
		var id = $('#addProductLevel2').find('#id').val();
		var quantity = $('#addProductLevel2').find('#quantity').val();
		var cost = $('#addProductLevel2').find('#cost').val();
		var duration = $('#addProductLevel2').find('#duration').val();
		$.ajax({
			url: "projects_estimate/add_level2_data.php",
			data     :{ 'name': name,'level1_id':level1_id, 'description':desc,'type_id':type_id,'id':id ,'quantity':quantity,'cost':cost , 'duration':duration},
			dataType :"json",
			type     :'GET',
			success: function (response) {
				alert("Success");
				loadData('-2');
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
	
	function loadLevel2Data(id, name, level1_id){
		$.ajax({
			url      :"projects_estimate/secondLevelData.php",
			data     :{ 'id': id,'level1_id':level1_id},
			dataType :"json",
			type     :'POST',
			success  :function( response ){
				$('#heirarchy3').html($('#heirarchy2').text()+" / " + name);
				$('#level3Body').html('');
				if(name == "Steel"){
					$('#excelupload').show();
				}
				else{
					$('#excelupload').hide();
				}
				$('#level2_name').val(name);
				$('#level2_id').val(id);
				$('#sel-3').html(name);
				$('#sel-4').html('LV04');
				$('#sel-5').html('LV05');
				var cc = 0;
				for( i=0 ; i < response.length ; i ++ ){
					cc++;
					var req_item_id = parseInt( response[i].req_item_id );
					var boq_td = '';
					var onclick = 'onclick = "set_tabber(4);loadLevel3Data('+response[i].level3_id+ ",'" +response[i].level3_name+ "'" +","+level1_id+","+id +' );"';
					
					if(response[i].show_complete == '0'){
						boq_td = '<i class="fas fa-folder" onclick = "loadBoq('+"'"+response[i].type_name+"'"+","+"3"+","+"'"+response[i].level3_id+"'"+","+level1_id+","+id+","+response[i].level3_id+",0,0,"+response[i].boq_id+","+"'"+response[i].level3_name+"'"+');"></i>';
						onclick = '';
						if(response[i].boq_id=='0'){
							boq_td = '<i class="fas fa-check complete" onclick = "loadBoq('+"'"+response[i].type_name+"'"+","+"3"+","+ "'"+response[i].level3_id+"',"+level1_id+","+"'"+id+"',"+response[i].level3_id+", 0, 0, 0"+","+"'"+response[i].level3_name+"'"+');"></i>';
							onclick = 'onclick = "set_tabber(4);loadLevel3Data('+response[i].level3_id+ ",'" +response[i].level3_name+ "'" +","+level1_id+","+id +' );"';
						}
					}
					
					var tr = '' + 
					'<div class = "tr" id = "level3-'+response[i].level3_id+'">'+
					'<div class = "td">' + response[i].sno + '</div>'+
					'<div class = "td"><button  '+onclick+'>'+response[i].level3_name+'</button> </div>'+

						// '<div class = "td"><a '+onclick+'>'+response[i].level3_name+'</a> </div>'+
					'<div class = "td">'+response[i].type_name+'</div>'+
					'<div class = "td"><i class="far fa-edit " onclick = "openEdit('+ "'" +response[i].level3_name+ "'" +","+response[i].level3_id+","+ "'" +response[i].level3_description+ "'" +","+response[i].type_id+  ", 'addProductLevel3'" + ')"></i></div>'+
					'<div class = "td"><i class="fas fa-trash" onclick = "deleteProduct(' + "'" + 'level3' + "'," + response[i].level3_id + ')"></i></div>'+
					'<div class = "td" id = "completed-3-'+response[i].level3_id+'" style = "width: 10%;">'+boq_td+
					'</div>'+
					'<div class = "td" style = "width: 15%;"><input class = "estimation_amount" style = "border:none;" type = "text" id = "amount-3-'+response[i].level3_id+'" value = '+response[i].total_amount+'></div>'+			
					'</div>';
					
					
					$('#level3Body').append( tr );
				}
			},
			error    :function( rr ){
				alert('Data Error No: 5467653');
			},
		});
	}
	
</script>

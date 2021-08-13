
<div class = "prodList">
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
		<div class="tableBody" id = "level3Body">
			
		</div>
	</div>
</div>
<div class = "tabber-boq-3 notdisplayed" style = "margin-top: 5%;">
	<?php
		$tabber_id = "-3";
		include('boq.php');
	?>
	
</div>
<i class="far fa-plus-square addbutton displayed" id = "addbutton"onclick = "openaddItem('ProductLevel3')"></i>
<div class = "add-new notdisplayed" id = "addProductLevel3" >
	<?php 
		$headerName = 'ProductLevel3';
		include('addHeader.php');
	?>
	<form method="post" name="firstLevel" class = "addform" id = "level3Form" >
		<label for ="no">Product Name</label>
		<input type = "text" id = "name" name = "name" required ><br>
		<label for ="name">Product description</label>
		<input type = "text" id = "description" name = "description" required ><br>
		<input type = "text" id = "level2_id" name = "level2_id" value = <?=$level2_id?> hidden>
		<input type = "text" id = "level2_name" name = "level2_name" hidden>
		<input type = "text" id = "id" name = "id"  hidden>
		<label for ="type_name">Type</label>
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
		<button type = "submit" name = "submitRecordLevel3" id = "button-add" onclick = "closeaddItem('ProductLevel3')">Add</button>
	</form>
</div>

<script>
	document.getElementById('level3Form').onsubmit =function addlevel3Data() {
		var name = $('#addProductLevel3').find('#name').val();
		var desc = $('#addProductLevel3').find('#description').val();
		var level2_id = $('#level2_id').val();
		var type_id = $('#addProductLevel3').find('#type_id').val();
		var id = $('#addProductLevel3').find('#id').val();
		$.ajax({
			url: "projects_estimate/add_level3_data.php",
			data     :{ 'name': name,'level2_id':level2_id, 'description':desc,'type_id':type_id,'id':id },
			dataType :"json",
			type     :'GET',
			success: function (response) {
				alert("Success");
				loadData('-3');
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
	function loadLevel3Data(id, name, level1_id , level2_id){

		$.ajax({
			url      :"projects_estimate/thirdLevelData.php",
			data     :{ 'id': id,'level1_id':level1_id,'level2_id':level2_id},
			dataType :"json",
			type     :'POST',
			success  :function( response ){
				$('#level4Body').html('');
				$('#level3_id').val(id);
				$('#level3_name').val(name);
				$('#heirarchy4').html($('#heirarchy3').text()+" / " + name);
				$('#sel-4').html(name);
				$('#sel-5').html('LV05');
				var cc = 0;
				for( i=0 ; i < response.length ; i ++ ){
					cc++;
					console.log(response[i]);
					var req_item_id = parseInt( response[i].req_item_id );
					var boq_td = '';
					var onclick = 'onclick = "set_tabber(5);loadLevel4Data('+response[i].level4_id+",'" +response[i].level4_name+ "'"+","+level1_id+","+level2_id+","+id+');"';
					if(response[i].show_complete == '0'){
						boq_td = '<i class="fas fa-folder" onclick = "loadBoq('+"'"+response[i].type_name+"'"+","+"4"+","+"'"+response[i].level4_id+"'"+","+level1_id+","+level2_id+","+id+","+response[i].level4_id+",0,"+response[i].boq_id+","+"'"+response[i].level4_name+"'"+');"></i>';
						onclick = '';
						if(response[i].boq_id=='0'){
							boq_td = '<i class="fas fa-check complete" onclick = "loadBoq('+"'"+response[i].type_name+"'"+","+"4"+","+ "'"+response[i].level4_id+"',"+level1_id+","+level2_id+","+"'"+id+"',"+response[i].level4_id+", 0, 0"+","+"'"+response[i].level4_name+"'"+');"></i>';
							onclick = 'onclick = "set_tabber(5);loadLevel4Data('+response[i].level4_id+",'" +response[i].level4_name+ "'"+","+level1_id+","+level2_id+","+id+');"';
						}
					}
					var tr = '' + 
					'<div class = "tr" id = "level4-'+response[i].level4_id+'">'+
					'<div class = "td"></div>'+
					// '<div class = "td"><a '+onclick+'>'+response[i].level4_name+'</a> </div>'+
					'<div class = "td">' + response[i].sno + '</div>'+
					'<div class = "td"><button '+onclick+'>'+response[i].level4_name+'</button> </div>'+
					'<div class = "td">'+ response[i].quantity +'</div>'+
					'<div class = "td">'+response[i].complexity+'</div>'+
					'<div class = "td">'+response[i].length+'</div>'+
					'<div class = "td">'+response[i].surface_area+'</div>'+
					'<div class = "td">'+response[i].cost+'</div>'+

					'<div class = "td" style = "width: 15%;"><input class = "estimation_amount" style = "border:none;" type = "text" id = "amount-4-'+response[i].level4_id+'" value = '+response[i].total_amount+'></div>'+			

					'<div class = "td"><i class="far fa-edit " onclick = "openEdit('+ "'" +response[i].level4_name+ "'" +","+response[i].level4_id+","+ "'" +response[i].level4_description+ "'" +","+response[i].type_id+   ", 'addProductLevel4'" + ')"></i></div>'+
					'<div class = "td"><i class="fas fa-trash" onclick = "deleteProduct(' + "'" + 'level4' + "'," + response[i].level4_id + ')"></i></div>'+
					// '<div class = "td" id = "completed-4-'+response[i].level4_id+'" style = "width: 10%;">'+boq_td+
					// '</div>'
					
					'</div>';
					
					$('#level4Body').append( tr );
				}
			},
			error    :function( rr ){
				alert('Data Error No: 5467653');
			},
		});
	}
	
	
</script>


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
		<div class="tableBody" id = "level4Body">
			
		</div>
	</div>
</div>
<script>
</script>
<div class = "tabber-boq-4 notdisplayed" style = "margin-top: 5%;">

	<?php
		$tabber_id = "-4";
		$complexity_id = "heavy";
		include('boq.php');

		
	?>
	
</div>
<i class="far fa-plus-square addbutton displayed" id = "addbutton" onclick =  "openaddItem('ProductLevel4')"></i>
<div class = "add-new notdisplayed" id = "addProductLevel4">
	<?php 
		$headerName = 'ProductLevel4';
		
		include('addHeader.php');

	?>
	<form method="post" name="firstLevel" class = "addform" id = "level4Form">
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
		<label for ="name">Product description</label>
		<input type = "text" id = "description" name = "description" required ><br>
		<input type = "text" id = "level3_id" name = "level3_id" value = "<?=$level3_id?>" hidden ><br>
		<input type = "text" id = "level3_name" name = "level3_name" hidden>
		<input type = "text" id="id" name = "id" hidden>
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
		<button type = "submit" name = "submitRecordLevel4" id = "button-add" onclick = "closeaddItem('ProductLevel4')">Add</button>
	</form>

</div>



<script>
	document.getElementById('level4Form').onsubmit =function addlevel4Data() {
		var name = $('#addProductLevel4').find('#name').val();
		var desc = $('#addProductLevel4').find('#description').val();
		var level3_id = $('#level3_id').val();
		var type_id = $('#addProductLevel4').find('#type_id').val();
		var id = $('#addProductLevel4').find('#id').val();
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
		console.log(data4);

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
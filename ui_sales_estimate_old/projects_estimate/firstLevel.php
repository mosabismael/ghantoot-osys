
<div class = "prodList">
	<div class = "table">
		<div class="tableHeader">
			<div class="tr">
				<div class = "th">No.</div>
				<div class = "th">Cost Headers</div>
				<div class = "th">Edit</div>
				<div class = "th">Delete</div>
				<div class = "th">Total </div>
			</div>
		</div>
		<div class="tableBody" id = "level1Body">
			
			
			
		</div>
		
	</div>
	<div  class = "costDisplay">Direct cost<span style = "padding-left:25%"><input id = "directCost" type = "text" value = "0.00 AED" disabled></span></div>
		<div class = "costDisplay">Indirect Cost<span style = "padding-left:23%"><input  id = "indirectCost" type = "text" value = "0.00 AED" disabled></span></div>
</div>

<div class = "tabber-boq-1 notdisplayed" style = "margin-top: 5%;">
	<?php
		$tabber_id = "-1";
		include('boq.php');
	?>
	
</div>
<i class="far fa-plus-square addbutton displayed" id = "addbutton"onclick = "openaddItem('Product')"></i>

<div class = "add-new notdisplayed" id = "addProduct">
	<?php 
		$headerName = 'Product';
		include('addHeader.php');
	?>
	<form  method="post" name="firstLevel" class = "addform">
		<label for ="no">Product Name</label>
		<input type = "text" id = "name" name = "name" required ><br>
		<label for ="name">Product description</label>
		<input type = "text" id = "description" name = "description" required ><br>
		<input type = "text" id = "project_id" name = "project_id" value = <?=$project_id?> hidden>
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
		<button type = "submit" name = "submitRecord" id = "button-add" onclick = "closeaddItem('Product')">Add</button>
	</form>
</div>
<?php
	if( isset($_POST['submitRecord'])){
		
		$product_name = $_POST['name'];
		$prod_desc = $_POST['description'];
		$project_id = $_POST['project_id'];
		$id = $_POST['id'];
		$type_id = $_POST['type_id'];
		echo $id;
		if($id==0){
			$qu_project_level1_ins = "INSERT INTO `z_project_level1` (
			`level1_name`, 
			`project_id`,
			`level1_description`,
			`type_id`
			) VALUES (
			'".$product_name."', 
			'".$project_id."',
			'".$prod_desc."',
			'".$type_id."'
			);";
		}
		else{
			$qu_project_level1_ins = "update `z_project_level1` set
			`level1_name` = '".$product_name."', 
			`project_id` ='".$project_id."',
			`level1_description` ='".$prod_desc."',
			`type_id` ='".$type_id."'
			where level1_id = '".$id."';";
		}
		mysqli_query($KONN, $qu_project_level1_ins);
		
	}
?>

<script>
	
	function loadLevel0Data(id){
		$.ajax({
			url      :"projects_estimate/zeroLevelData.php",
			data     :{ 'project_id': id},
			dataType :"json",
			type     :'POST',
			success  :function( res ){
				getLvl1Data( res);
			},
			error    :function( rr ){
				alert('Data Error No: 5467653');
			},
		});
	}
	function getLvl1Data(response){
		$('#level1Body').html('');
		
		var cc = 0;
		var totalAmount=0;
		for( i=0 ; i < response.length ; i ++ ){
			cc++;
			var req_item_id = parseInt( response[i].req_item_id );
			var boq_td = '';
			var onclick = 'onclick = "set_tabber(2);loadLevel1Data('+response[i].level1_id + ",'" +response[i].level1_name+ "'"+' );"';
			
			if(response[i].show_complete == '0'){
				boq_td = '<i class="fas fa-folder" onclick = "loadBoq('+"'"+response[i].type_name+"'"+","+"1"+","+"'"+response[i].level1_id+"'"+","+response[i].level1_id+",0,0,0,0,"+response[i].boq_id+","+"'"+response[i].level1_name+"'"+');"></i>';
				onclick = '';
				if(response[i].boq_id=='0'){
					boq_td = '<i class="fas fa-check complete" onclick = "loadBoq('+"'"+response[i].type_name+"'"+","+"1"+","+ "'"+response[i].level1_id+"',"+response[i].level1_id+", 0, 0, 0,0, 0"+","+"'"+response[i].level1_name+"'"+');"></i>';
					onclick = 'onclick = "set_tabber(2);loadLevel1Data('+response[i].level1_id + ",'" +response[i].level1_name+ "'"+' );"';
				}
			}
			
			var tr = '' + 
			'<div class = "tr" id = "level1-'+response[i].level1_id+'">'+
			'<div class = "td">' + response[i].sno + '</div>'+
			'<div class = "td"><a '+onclick+'>'+response[i].level1_name+'</a> </div>'+
			'<div class = "td"><i class="far fa-edit " onclick = "openEdit('+ "'" +response[i].level1_name+ "'" +","+response[i].level1_id+","+ "'" +response[i].level1_description+ "'" +","+response[i].type_id+  ", 'addProduct'"+')"></i></div>'+
			'<div class = "td"><i class="fas fa-trash" onclick = "deleteProduct(' + "'" + 'level1' + "'," + response[i].level1_id + ')"></i></div>'+
			'<div class = "td" style = "width: 15%;"><input class = "estimation_amount" style = "border:none;" type = "text" id = "amount-1-'+response[i].level1_id+'" value = '+response[i].total_amount+'></div>'+			
			'</div>'
			$('#level1Body').append( tr );
			totalAmount += parseInt(Math.round(response[i].total_amount));
			
		}
		$('#totalAmount').val(totalAmount.toFixed(2));
		$('#directCost').val(totalAmount.toFixed(2)+' AED');
	}
	function loadLevel1Data(id, name){
		$.ajax({
			url      :"projects_estimate/firstLevelData.php",
			data     :{ 'id': id},
			dataType :"json",
			type     :'POST',
			success  :function( res ){
				$('#heirarchy2').html(name);
				if(name == "materials"){
						$('#excelupload').show();
				}
				$('#level1_id').val(id);
				$('#level1_name').val(name);
				$('#sel-2').html(name);
				$('#sel-3').html('LV03');
				$('#sel-4').html('LV04');
				$('#sel-5').html('LV05');
				getLvl2Data( res , id);
			},
			error    :function( rr ){
				alert('Data Error No: 5467653');
			},
		});
	}
	function getLvl2Data(response, id){
		$('#level2Body').html('');
		
		var cc = 0;
		for( i=0 ; i < response.length ; i ++ ){
			cc++;
			var req_item_id = parseInt( response[i].req_item_id );
			var boq_td = '';
			var onclick = 'onclick = "set_tabber(3);loadLevel2Data('+response[i].level2_id + ",'" +response[i].level2_name+ "',"+ id +' );"';
			if(response[i].show_complete == '0'){
				boq_td = '<i class="fas fa-folder" onclick = "loadBoq('+"'"+response[i].type_name+"'"+","+"2"+","+"'"+response[i].level2_id+"'"+","+id+","+response[i].level2_id+",0,0,0,"+response[i].boq_id+","+"'"+response[i].level2_name+"'"+');"></i>';
				onclick = '';
				if(response[i].boq_id=='0'){
					boq_td = '<i class="fas fa-check complete" onclick = "loadBoq('+"'"+response[i].type_name+"'"+","+"2"+","+ "'"+response[i].level2_id+"',"+"'"+id+"',"+response[i].level2_id+", 0, 0, 0, 0"+","+"'"+response[i].level2_name+"'"+');"></i>';
					onclick = 'onclick = "set_tabber(3);loadLevel2Data('+response[i].level2_id + ",'" +response[i].level2_name+ "',"+ id +' );"';
				}
			}
			
			var tr = '' + 
			'<div class = "tr" id = "level2-'+response[i].level2_id+'">'+
			'<div class = "td">' + response[i].sno + '</div>'+
			'<div class = "td"><a '+onclick+'>'+response[i].level2_name+'</a> </div>'+
			'<div class = "td">'+response[i].type_name+'</div>'+
			'<div class = "td"><i class="far fa-edit " onclick = "openEdit('+ "'" +response[i].level2_name+ "'" +","+response[i].level2_id+","+ "'" +response[i].level2_description+ "'" +","+response[i].type_id+  ", 'addProductLevel2'"+')"></i></div>'+
			'<div class = "td"><i class="fas fa-trash" onclick = "deleteProduct(' + "'" + 'level2' + "'," + response[i].level2_id + ')"></i></div>'+
			'<div class = "td" id = "completed-2-'+response[i].level2_id+'" style = "width: 10%;">'+boq_td+
			'</div>'+
			'<div class = "td" style = "width: 15%;"><input class = "estimation_amount" style = "border:none;" type = "text" id = "amount-2-'+response[i].level2_id+'" value = '+response[i].total_amount+'></div>'+			
			'</div>'
			$('#level2Body').append( tr );
		}
	}
	</script>																											
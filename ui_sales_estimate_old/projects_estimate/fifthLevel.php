
<div class = "prodList" id = "level5_display">
	<div class = "table">
		<div class="tableHeader">
			<div class="tr">
				<div class = "th">No.</div>
				<div class = "th">Product Name</div>
				<div class = "th">Product Type</div>
				<div class = "th">Edit</div>
				<div class = "th">Delete</div>
				<div class = "th">Completed</div>
				<div class = "th">Total </div>
			</div>
		</div>
		<div class="tableBody" id = "level5Body">
			
		</div>
	</div>
</div>
<div class = "tabber-boq-5 notdisplayed" style = "margin-top: 5%;">
	<?php
		$tabber_id = "-5";
		include('boq.php');
	?>
	
</div>
<i class="far fa-plus-square addbutton displayed" id = "addbutton"onclick = "openaddItem('ProductLevel5')"></i>
<div class = "add-new notdisplayed" id = "addProductLevel5">
	<?php 
		$headerName = 'ProductLevel5';
		include('addHeader.php');
	?>
	<form method="post" name="firstLevel" class = "addform" id = "level5Form">
		<label for ="no">Product Name</label>
		<input type = "text" id = "name" name = "name" required ><br>
		<label for ="name">Product description</label>
		<input type = "text" id = "description" name = "description" required ><br>
		<input type = "text" id = "level4_id" name = "level4_id" value = "<?=$level4_id?>" hidden >
		<input type = "text" id = "level4_name" name = "level4_name" hidden>
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
		<button type = "submit" name = "submitRecordLevel5" id = "button-add" onclick = "closeaddItem('ProductLevel5')">Add</button>
	</form>
</div>
<script>
	document.getElementById('level5Form').onsubmit =function addlevel5Data() {
		var name = $('#addProductLevel5').find('#name').val();
		var desc = $('#addProductLevel5').find('#description').val();
		var level4_id = $('#level4_id').val();
		var type_id = $('#addProductLevel5').find('#type_id').val();
		var id = $('#addProductLevel5').find('#id').val();
		$.ajax({
			url: "projects_estimate/add_level5_data.php",
			data     :{ 'name': name,'level4_id':level4_id, 'description':desc,'type_id':type_id,'id':id },
			dataType :"json",
			type     :'GET',
			success: function (response) {
				alert("Success");
				loadData('-5');
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
</script>

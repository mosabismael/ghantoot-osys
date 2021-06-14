<?php
		require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
	
	<head>
		<title>Estimation</title>
		<?php
			$project_id = "1";
		?>
		<?php include('app/meta.php'); ?>
		<?php include('app/assets.php'); ?>
	</head>
	<body onload="document.getElementById('<?=$selectedTab?>').click();">
		<header></header>
		<h1 class="pageTitler">PROJECT_NAME </h1>
		
		
			<?php
				$level2_id = 0;
				$level1_id = 0;
				$level3_id = 0;
				$level4_id= 0;
				$level5_id=0;
				$familyName = "";
				if(isset($_GET['level1_id'])){
					$familyName = "<a href = 'firstLevel.php'>Main</a>";
					$level1_id = $_GET['level1_id'];	
					$qu_project_level1_sel = "SELECT * FROM  `project_level1` WHERE `level1_id` = $level1_id";
					$qu_project_level1_EXE = mysqli_query($conn, $qu_project_level1_sel);
					$project_level1_DATA;
					if(mysqli_num_rows($qu_project_level1_EXE)){
						$project_level1_DATA = mysqli_fetch_assoc($qu_project_level1_EXE);
						$level1_name = $project_level1_DATA['level1_name'];
					}
					$familyName = $familyName."/"."<a href = 'secondLevel.php?level1_id=".$level1_id."'>".$level1_name."</a>";
				}
				if(isset($_GET['level2_id'])){
					$level2_id = $_GET['level2_id'];
					$qu_project_level2_sel = "SELECT * FROM  `project_level2` WHERE `level2_id` = $level2_id";
					$qu_project_level2_EXE = mysqli_query($conn, $qu_project_level2_sel);
					$project_level2_DATA;
					if(mysqli_num_rows($qu_project_level2_EXE)){
						$project_level2_DATA = mysqli_fetch_assoc($qu_project_level2_EXE);
						$level2_name = $project_level2_DATA['level2_name'];
					}
					$familyName = $familyName."/"."<a href = 'thirdLevel.php?level1_id=".$level1_id."&level2_id=".$level2_id."'>".$level2_name."</a>";
				}
				
				if(isset($_GET['level3_id'])){
					$level3_id = $_GET['level3_id'];
					$qu_project_level3_sel = "SELECT * FROM  `project_level3` WHERE `level3_id` = $level3_id";
					$qu_project_level3_EXE = mysqli_query($conn, $qu_project_level3_sel);
					$project_level3_DATA;
					if(mysqli_num_rows($qu_project_level3_EXE)){
						$project_level3_DATA = mysqli_fetch_assoc($qu_project_level3_EXE);
						$level3_name = $project_level3_DATA['level3_name'];
					}
					$familyName = $familyName."/"."<a href = 'fourthLevel.php?level1_id=".$level1_id."&level2_id=".$level2_id."&level3_id=".$level3_id."'>".$level3_name."</a>";
				}
				if(isset($_GET['level4_id'])){
					$level4_id = $_GET['level4_id'];
					$qu_project_level4_sel = "SELECT * FROM  `project_level4` WHERE `level4_id` = $level4_id";
					$qu_project_level4_EXE = mysqli_query($conn, $qu_project_level4_sel);
					$project_level4_DATA;
					if(mysqli_num_rows($qu_project_level4_EXE)){
						$project_level4_DATA = mysqli_fetch_assoc($qu_project_level4_EXE);
						$level4_name = $project_level4_DATA['level4_name'];
					}
					$familyName = $familyName."/"."<a href = 'fifthLevel.php?level1_id=".$level1_id."&level2_id=".$level2_id."&level3_id=".$level3_id."&level4_id=".$level4_id."'>".$level4_name."</a>";
				}
				if(isset($_GET['level5_id'])){
					$level5_id = $_GET['level5_id'];
					$qu_project_level5_sel = "SELECT * FROM  `project_level5` WHERE `level5_id` = $level5_id";
					$qu_project_level5_EXE = mysqli_query($conn, $qu_project_level5_sel);
					$project_level5_DATA;
					if(mysqli_num_rows($qu_project_level5_EXE)){
						$project_level5_DATA = mysqli_fetch_assoc($qu_project_level5_EXE);
						$level5_name = $project_level5_DATA['level5_name'];
					}
					$familyName = $familyName."/".$level5_name;
				}
			?>
			<div class="tab">
				<a class="tablinks selected displayed" id = "tab-Level 1" href = "projects_estimate/firstLevel.php" >Level 1</a>
				<a class="tablinks notselected notdisplayed" id = "tab-Level 2" href = "projects_estimate/secondLevel.php?level1_id=<?=$level1_id?>" >Level 2</a>
				<a class="tablinks notselected notdisplayed" id = "tab-Level 3" href = "projects_estimate/thirdLevel.php?level1_id=<?=$level1_id?>&level2_id=<?=$level2_id?>" >Level 3</a> 
				<a class="tablinks notselected notdisplayed" id = "tab-Level 4" href = "projects_estimate/fourthLevel.php?level1_id=<?=$level1_id?>&level2_id=<?=$level2_id?>&level3_id=<?=$level3_id?>" >Level 4</a>
				<a class="tablinks notselected notdisplayed" id = "tab-Level 5" href = "projects_estimate/fifthLevel.php?level1_id=<?=$level1_id?>&level2_id=<?=$level2_id?>&level3_id=<?=$level3_id?>&level4_id=<?=$level4_id?>" >Level 5</a>
				<a class="tablinks displayed" id = "tab-BOQ" href = "view_boq.php" >BOQ</a>
			</div>
			<div class ="tabDetail displayed" id = "tabDetail">
				<?=$familyName?>
			</div>
			<script>
				openlevel('<?=$tabSelected?>');
				function openlevel(levelNumber) {
				
				tabcontent = document.getElementsByClassName("tabcontent");
				for (i = 0; i < tabcontent.length; i++) {
				tabcontent[i].style.display = "none";
				}
				$(".tablinks").removeClass("selected");
				$(".tablinks").addClass("notselected");
				level = document.getElementById("tab-"+levelNumber);
				level.className = "tablinks selected displayed";
				if(levelNumber == "BOQ"){
					document.getElementById("tabDetail").className="tabDetail notdisplayed";
				}
				else{
					document.getElementById("tabDetail").className="tabDetail displayed";
				}
				number = parseInt(levelNumber.split(" ")[1]);
				for(no=1 ;no<number;no++){
					level = document.getElementById("tab-Level "+no);
					level.className = "tablinks notselected displayed";
				} 
				for(no=number+1 ;no<=5;no++){
					level = document.getElementById("tab-Level "+no);
					level.className = "tablinks notselected notdisplayed";
				} 
				document.getElementById(levelNumber).style.display = "block";
			} 
			function Switchlevel(levelNumber) {
				
				tabcontent = document.getElementsByClassName("tabcontent");
				for (i = 0; i < tabcontent.length; i++) {
					tabcontent[i].style.display = "none";
				}
				$(".tablinks").removeClass("selected");
				$(".tablinks").addClass("notselected");
				level = document.getElementById("tab-"+levelNumber);
				level.className = "tablinks selected displayed";
				document.getElementById(levelNumber).style.display = "block";
			} 
			function openaddItem(type){
				
				level = document.getElementById("add"+type);
				level.className = "add-new displayed";
				$('#prodid').val("0");
				$('#id').val("0");
				$('#button-add').text("ADD");
				$('#displayName').text("Add product");
				$('#name').val("");
				$('#description').val("");
				document.getElementById("type_id").selectedIndex = ""; 
			}
			function openaddRecord(type){
				
				level = document.getElementById("add"+type);
				level.className = "add-new displayed";
				$('#prodid').val("0");
				$('#type_id').val("");
				$('#prodname').val("");
				$('#qty').val("");
				$('#displayName').text("Add Record");
				$('#button-add').text("ADD");
			}
			function closeaddItem(type){
				
				level = document.getElementById("add"+type);
				level.className = "add-new notdisplayed";
				
			}
			function openEditRecord(uid, name , qty, measure_id){
				level = document.getElementById("addRecord");
				level.className = "add-new displayed";
				$('#prodid').val(uid);
				$('#type_id').val(measure_id);
				$('#prodname').val(name);
				$('#qty').val(qty);
				$('#displayName').text("Edit record");
				$('#button-add').text("EDIT");
			}
			function openEdit(name,id, desc , type_id,idName){
				level = document.getElementById(idName);
				level.className = "add-new displayed";
				$('#name').val(name);
				$('#id').val(id);
				$('#description').val(desc);
				$('#button-add').text('Edit');
				$('#displayName').text("Edit product");
				document.getElementById("type_id").selectedIndex = type_id; 
			}
			function deleteProduct(levelName , id){
				$.ajax({
					type: "GET",
					url: "delete_product.php",
					data: "levelName="+levelName+"&id="+id,
					success: function(response) {
						if(response.status == "1") {
						alert("Cannot be deleted");
						} else if(response.status=="2"){
						alert ("data not selected for delete");
					}
					else{
						window.location.href = window.location.href;
					}
				}
			});
		}
	</script>	
	
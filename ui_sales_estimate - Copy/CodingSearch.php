<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/app_db.php');
	$flag = 0;
	$itemDesc = "";
	if(isset($_REQUEST["term"]) && strlen($_REQUEST["term"]) >0){
		// Prepare a select statement
		$id = "";
		if(isset($_REQUEST["id"])){
			$id = $_REQUEST["id"];
		}
		
		$name = "";
		if(isset($_REQUEST["name"]) && $_REQUEST["name"] == 'Consumables'){
			$name = "and fam.family_name = '".$_REQUEST["name"]."'";
		}
		else if(isset($_REQUEST["name"]) && $_REQUEST["name"] == 'UB/UC'){
			$name = "and (sec.section_name LIKE '%(UB)%' or sec.section_name LIKE '%(UC)%')";
		}
		else if(isset($_REQUEST["name"]) && $_REQUEST["name"] == 'SHS/RHS'){
			$name = "and (sec.section_name LIKE '%(SHS)%' or sec.section_name LIKE '%(RHS)%')";
		}
		else if(isset($_REQUEST["name"]) && $_REQUEST["name"] == 'Chequered Plates'){
			$name = "and (sec.section_name LIKE '%Chequered%')";
		}
		else if(isset($_REQUEST["name"]) && $_REQUEST["name"] == 'Plates'){
			$name = "and (sec.section_name LIKE '%Plate%')";
		}
		else{
			
		}
		$sql = "SELECT * FROM inv_06_codes codes, inv_05_categories cat, inv_04_subdivisions subdiv, inv_03_divisions divs , inv_02_sections sec , inv_01_families fam WHERE fam.family_id = sec.family_id $name and sec.section_id = divs.section_id and divs.division_id = subdiv.division_id and subdiv.subdivision_id = cat.subdivision_id and cat.category_id = codes.category_id and (codes.item_name LIKE ? or cat.category_name LIKE ? or subdiv.subdivision_name LIKE ? or divs.division_name LIKE ? or sec.section_name LIKE ? or fam.family_name LIKE ?) ";
		
		if($stmt = mysqli_prepare($KONN, $sql)){
			// Bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmt, "ssssss", $param_term,$param_term,$param_term,$param_term,$param_term,$param_term);
			
			// Set parameters
			$param_term = '%' . $_REQUEST["term"] . '%';
			
			// Attempt to execute the prepared statement
			if(mysqli_stmt_execute($stmt)){
				$result = mysqli_stmt_get_result($stmt);
				$count = 0;
				// Check number of rows in the result set
				if(mysqli_num_rows($result) > 0){
					// Fetch result rows as an associative array
					while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
						$lvl01_N = $row['family_description'];
						$lvl01_V = $row['family_name'];
						$itemDesc = "";
						
						if( $lvl01_N == 'undefined' || $lvl01_N == ''  ){
							$lvl01_N = '--';
						}
						$itemDesc .= "<strong>".$lvl01_N."</strong> :".$lvl01_V."<br>";
						
						$lvl02_N = $row['section_description'];
						$lvl02_V = $row['section_name'];
						
						
						if( $lvl02_N == 'undefined' || $lvl02_N == ''  ){
							$lvl02_N = '--';
						}
						$itemDesc .= "<strong>".$lvl02_N."</strong> :".$lvl02_V."<br>";
						
						
						$lvl03_N = $row['division_description'];
						$lvl03_V = $row['division_name'];
						
						
						if( $lvl03_N == 'undefined' || $lvl03_N == ''  ){
							$lvl03_N = '--';
						}
						$itemDesc .= "<strong>".$lvl03_N."</strong> :".$lvl03_V."<br>";
						
						
						$lvl04_N = $row['subdivision_description'];
						$lvl04_V = $row['subdivision_name'];
						
						
						if( $lvl04_N == 'undefined' || $lvl04_N == ''  ){
							$lvl04_N = '--';
						}
						$itemDesc .= "<strong>".$lvl04_N."</strong> :".$lvl04_V."<br>";
						
						
						$lvl05_N = $row['category_description'];
						$lvl05_V = $row['category_name'];
						
						
						if( $lvl05_N == 'undefined' || $lvl05_N == ''  ){
							$lvl05_N = '--';
						}
						$itemDesc .= "<strong>".$lvl05_N."</strong> :".$lvl05_V."<br>";
						
						$lvl06_N = $row['item_description'];
						$lvl06_V = $row['item_name'];
						
						
						if( $lvl06_N == 'undefined' || $lvl06_N == ''  ){
							$lvl06_N = '--';
						}
						$itemDesc .= "<strong>".$lvl06_N."</strong> :".$lvl06_V;
						//echo $itemDesc;
						
						echo  '<div onclick = "setvalue('."'".$itemDesc."',".$row["surface_area"].",".$row["weight"].",".$row["family_id"].",".$row["section_id"].",".$row["division_id"].",".$row["subdivision_id"].",".$row["category_id"].",".$row["code_id"].",".$id.');">'.$row["family_name"]."/".$row["section_name"]."/".$row["division_name"]."/".$row["subdivision_name"]."/".$row["category_name"]."/".$row["item_name"]."</div>";
						$flag = 1;
						$count+=1;
						if($count==15){
						break;
						}
					}
					
				}
			}
		}
		
	}
	if($flag ==0 ){
		echo "No match found";
	}
	
	
?>
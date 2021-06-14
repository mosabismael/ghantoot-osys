<?php
require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/app_db.php');
$flag = 0;
if(isset($_REQUEST["term"]) && strlen($_REQUEST["term"]) >0){
    // Prepare a select statement
    $id = "";
	if(isset($_REQUEST["id"])){
			$id = $_REQUEST["id"];
	}
	$sql = "SELECT * FROM inv_06_codes codes, inv_05_categories cat, inv_04_subdivisions subdiv, inv_03_divisions divs , inv_02_sections sec , inv_01_families fam WHERE fam.family_id = sec.family_id and sec.section_id = divs.section_id and divs.division_id = subdiv.division_id and subdiv.subdivision_id = cat.subdivision_id and cat.category_id = codes.category_id and (codes.item_name LIKE ? or cat.category_name LIKE ? or subdiv.subdivision_name LIKE ? or divs.division_name LIKE ? or sec.section_name LIKE ? or fam.family_name LIKE ?) ";
    
    if($stmt = mysqli_prepare($KONN, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ssssss", $param_term,$param_term,$param_term,$param_term,$param_term,$param_term);
        
        // Set parameters
        $param_term = '%' . $_REQUEST["term"] . '%';
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            
            // Check number of rows in the result set
            if(mysqli_num_rows($result) > 0){
                // Fetch result rows as an associative array
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    echo  '<div onclick = "setvalue('."'".$row["category_name"]." - ".$row["item_name"]."',".$row["family_id"].",".$row["section_id"].",".$row["division_id"].",".$row["subdivision_id"].",".$row["category_id"].",".$row["code_id"].",".$id.');">'.$row["family_name"]."/".$row["section_name"]."/".$row["division_name"]."/".$row["subdivision_name"]."/".$row["category_name"]."/".$row["item_name"]."</div>";
					$flag = 1;
			   }
            }
        }
    }
    
}
if($flag ==0 ){
	echo "No match found";
}
 

?>
<?php
require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/app_db.php');
$flag = 0;
if(isset($_REQUEST["term"]) && strlen($_REQUEST["term"]) >0){
    // Prepare a select statement
    $sql = "SELECT * FROM inv_01_families WHERE family_name LIKE ?";
    
    if($stmt = mysqli_prepare($KONN, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_term);
        
        // Set parameters
        $param_term = '%' . $_REQUEST["term"] . '%';
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            
            // Check number of rows in the result set
            if(mysqli_num_rows($result) > 0){
                // Fetch result rows as an associative array
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    echo "<a href='inv_lvl02.php?ids=".$row["family_id"]."'>" . $row["family_name"] . " - Level 1</a>";
					$flag = 1;
				}
            }
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($KONN);
        }
    }
	    $sql = "SELECT * FROM inv_02_sections WHERE section_name LIKE ?";
    
    if($stmt = mysqli_prepare($KONN, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_term);
        
        // Set parameters
        $param_term = '%' . $_REQUEST["term"] . '%';
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            
            // Check number of rows in the result set
            if(mysqli_num_rows($result) > 0){
                // Fetch result rows as an associative array
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    echo "<a href='inv_lvl03.php?ids=".$row["section_id"]."'>" . $row["section_name"] . " - Level 2</a>";
					$flag = 1;
				}
            } 
        }
    }
	    $sql = "SELECT * FROM inv_03_divisions WHERE division_name LIKE ?";
    
    if($stmt = mysqli_prepare($KONN, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_term);
        
        // Set parameters
        $param_term = '%' . $_REQUEST["term"] . '%';
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            
            // Check number of rows in the result set
            if(mysqli_num_rows($result) > 0){
                // Fetch result rows as an associative array
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    echo "<a href='inv_lvl04.php?ids=".$row["division_id"]."'>" . $row["division_name"] . " - Level 3</a>";
					$flag = 1;
				}
            } 
        }
    }
	    $sql = "SELECT * FROM inv_04_subdivisions WHERE subdivision_name LIKE ?";
    
    if($stmt = mysqli_prepare($KONN, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_term);
        
        // Set parameters
        $param_term = '%' . $_REQUEST["term"] . '%';
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            
            // Check number of rows in the result set
            if(mysqli_num_rows($result) > 0){
                // Fetch result rows as an associative array
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    echo "<a href='inv_lvl05.php?ids=".$row["subdivision_id"]."'>" . $row["subdivision_name"] . " - Level 4</a>";
					$flag = 1;
				}
            } 
        }
    }
	    $sql = "SELECT * FROM inv_05_categories WHERE category_name LIKE ?";
    
    if($stmt = mysqli_prepare($KONN, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_term);
        
        // Set parameters
        $param_term = '%' . $_REQUEST["term"] . '%';
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            
            // Check number of rows in the result set
            if(mysqli_num_rows($result) > 0){
                // Fetch result rows as an associative array
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    echo "<a href='inv_lvl06.php?ids=".$row["category_id"]."'>" . $row["category_name"] . " - Level 5</a>";
					$flag = 1;
				}
            } 
        } 
    }
	    $sql = "SELECT * FROM inv_06_codes WHERE item_name LIKE ?";
    
    if($stmt = mysqli_prepare($KONN, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_term);
        
        // Set parameters
        $param_term = '%' . $_REQUEST["term"] . '%';
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            
            // Check number of rows in the result set
            if(mysqli_num_rows($result) > 0){
                // Fetch result rows as an associative array
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    echo "<a href='inv_lvl06.php?ids=".$row["category_id"]."'>" . $row["item_name"] . " - Level 6</a>";
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
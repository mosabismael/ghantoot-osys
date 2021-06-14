<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	
	try{
		
		if( isset($_POST['item_name']) &&
		isset($_POST['code_unit_id']) &&
		isset($_POST['category_id']) 
		){
			
			
			$code_id = 0;
			$code_tag = "ERROR";
			$item_name = test_inputs($_POST['item_name']);
			$code_unit_id = (int) test_inputs($_POST['code_unit_id']);
			$category_id = (int) test_inputs($_POST['category_id']);
			$surface_area = (int) test_inputs($_POST['item_sa']);
			$weight = (int) test_inputs($_POST['item_weight']);
			
			$item_description = "";
			if( isset($_POST['item_description']) ){
				$item_description = test_inputs( $_POST['item_description'] );
			}
			
			
			//get cat first letter
			$CatChar = "0";
			$qu_inv_05_categories_sel = "SELECT `category_name` FROM  `inv_05_categories` WHERE `category_id` = $category_id";
			$qu_inv_05_categories_EXE = mysqli_query($KONN, $qu_inv_05_categories_sel);
			$inv_05_categories_DATA;
			if(mysqli_num_rows($qu_inv_05_categories_EXE)){
				$inv_05_categories_DATA = mysqli_fetch_assoc($qu_inv_05_categories_EXE);
				$category_name = $inv_05_categories_DATA['category_name'];
				$CatChar = strtoupper( $category_name[0] );
			}
			
			if( $CatChar == "0" || $CatChar == false ){
				//	die( "0|Code Error, Contact Support" );
			}
			
			//get count and set to 3 digits
			$ItemCount = 0;
			$ItemClass = '';
			$qu_inv_06_codes_sel = "SELECT COUNT(`code_id`) FROM  `inv_06_codes` WHERE `category_id` = $category_id";
			$qu_inv_06_codes_EXE = mysqli_query($KONN, $qu_inv_06_codes_sel);
			$inv_06_codes_DATA;
			if(mysqli_num_rows($qu_inv_06_codes_EXE)){
				$inv_06_codes_DATA = mysqli_fetch_array($qu_inv_06_codes_EXE);
				$ItemCount = $inv_06_codes_DATA[0];
			}
			
			
			$ItemCount = $ItemCount + 1;
			
			if( $ItemCount < 10 ){
				$ItemClass = "00";
				} else if( $ItemCount >= 10 && $ItemCount < 99 ){
				$ItemClass = "0";
				} else if( $ItemCount > 99 ){
				$ItemClass = "";
			}
			
			
			$code_tag = $CatChar.$ItemClass.$ItemCount;
			$qu_inv_06_codes_sel = "SELECT * FROM  `inv_06_codes` WHERE ((`item_name` = '$item_name') AND (`category_id` = $category_id))";
			$qu_inv_06_codes_EXE = mysqli_query($KONN, $qu_inv_06_codes_sel);
			$inv_06_codes_DATA;
			if( mysqli_num_rows($qu_inv_06_codes_EXE) > 0 ){
				die( "0|Item name already exist" );
			}
			
			
			
			
			// die( "0|".$code_tag );
			
			
			
			
			//merge item code into one code
			
			$qu_inv_05_categories_sel = "SELECT `category_code`, `subdivision_id` FROM  `inv_05_categories` WHERE `category_id` = $category_id";
			$qu_inv_05_categories_EXE = mysqli_query($KONN, $qu_inv_05_categories_sel);
			$inv_05_categories_DATA;
			if(mysqli_num_rows($qu_inv_05_categories_EXE)){
				$inv_05_categories_DATA = mysqli_fetch_assoc($qu_inv_05_categories_EXE);
			}
			
			$category_code = $inv_05_categories_DATA['category_code'];
			$subdivision_id = $inv_05_categories_DATA['subdivision_id'];
			
			
			
			
			$qu_inv_04_subdivisions_sel = "SELECT `subdivision_code`, `division_id` FROM  `inv_04_subdivisions` WHERE `subdivision_id` = $subdivision_id";
			$qu_inv_04_subdivisions_EXE = mysqli_query($KONN, $qu_inv_04_subdivisions_sel);
			$inv_04_subdivisions_DATA;
			if(mysqli_num_rows($qu_inv_04_subdivisions_EXE)){
				$inv_04_subdivisions_DATA = mysqli_fetch_assoc($qu_inv_04_subdivisions_EXE);
			}
			
			$subdivision_code = $inv_04_subdivisions_DATA['subdivision_code'];
			$division_id = $inv_04_subdivisions_DATA['division_id'];
			
			
			$qu_inv_03_divisions_sel = "SELECT `division_code`, `section_id` FROM  `inv_03_divisions` WHERE `division_id` = $division_id";
			$qu_inv_03_divisions_EXE = mysqli_query($KONN, $qu_inv_03_divisions_sel);
			$inv_03_divisions_DATA;
			if(mysqli_num_rows($qu_inv_03_divisions_EXE)){
				$inv_03_divisions_DATA = mysqli_fetch_assoc($qu_inv_03_divisions_EXE);
			}
			
			$division_code = $inv_03_divisions_DATA['division_code'];
			$section_id = $inv_03_divisions_DATA['section_id'];
			
			
			
			$qu_inv_02_sections_sel = "SELECT `section_code`, `family_id` FROM  `inv_02_sections` WHERE `section_id` = $section_id";
			$userStatement = mysqli_prepare($KONN,$qu_inv_01_families_sel);
			mysqli_stmt_execute($userStatement);
			$qu_inv_01_families_EXE = mysqli_stmt_get_result($userStatement);
			$inv_02_sections_DATA;
			if(mysqli_num_rows($qu_inv_02_sections_EXE)){
				$inv_02_sections_DATA = mysqli_fetch_assoc($qu_inv_02_sections_EXE);
			}
			
			$section_code = $inv_02_sections_DATA['section_code'];
			$family_id = $inv_02_sections_DATA['family_id'];
			
			
			$qu_inv_01_families_sel = "SELECT `family_code` FROM  `inv_01_families` WHERE `family_id` = $family_id";
			$userStatement = mysqli_prepare($KONN,$qu_inv_01_families_sel);
			mysqli_stmt_execute($userStatement);
			$qu_inv_01_families_EXE = mysqli_stmt_get_result($userStatement);
			$inv_01_families_DATA;
			if(mysqli_num_rows($qu_inv_01_families_EXE)){
				$inv_01_families_DATA = mysqli_fetch_assoc($qu_inv_01_families_EXE);
			}
			
			$family_code = $inv_01_families_DATA['family_code'];
			
			
			
			$code_tag = $family_code.'.'.$section_code.'-'.$division_code.'.'.$subdivision_code.'-'.$category_code.$code_tag;
			
			// die("0|".$code_tag);
			
			$qu_inv_06_codes_ins = "INSERT INTO `inv_06_codes` (
			`code_tag`, 
			`item_name`, 
			`code_unit_id`, 
			`item_description`,  
			`category_id` ,
			`surface_area`,
			`weight`
			) VALUES (
			'".$code_tag."', 
			'".$item_name."', 
			'".$code_unit_id."', 
			'".$item_description."', 
			'".$category_id."' ,
			'".$surface_area."',
			'".$weight."'
			);";
			
			
			$insertStatement = mysqli_prepare($KONN,$qu_inv_06_codes_ins);
			mysqli_stmt_execute($insertStatement);
			$code_id = mysqli_insert_id($KONN);
			
			if( $code_id != 0 ){
				
				if( insert_state_change($KONN, "INV-Itm-".$item_name, $code_id, "inv_06_codes", $EMPLOYEE_ID) ) {
					die('1|Item Added');
					} else {
					die('0|Data Status Error 65154');
				}
				
				} else {
				die( mysqli_error($KONN) );
			}
			
			
			
			
			
			} else {
			die('0|7wiu');
		}
	}
	catch(Exception $e){
		if ( is_resource($KONN)) {
			mysqli_close($KONN);
		}
	}
	finally{
		if ( is_resource($KONN)) {
			mysqli_close($KONN);
		}
	}
?>

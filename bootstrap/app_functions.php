<?php

function generate_guid(){
    if (function_exists('com_create_guid')){
        return com_create_guid();
    }else{
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid =  substr($charid, 0, 8).$hyphen
                .substr($charid, 8, 4).$hyphen
                .substr($charid,12, 4).$hyphen
                .substr($charid,16, 4).$hyphen
                .substr($charid,20,12);
        return $uuid."-".round(microtime(true));
    }
}

function test_inputs($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   $data = str_replace("'", "", $data);
   $data = str_replace("'", "", $data);
   $data = str_replace(",", " ", $data);
   return $data;
}

function test_inputs_2($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlentities($data);
   $data = str_replace("'", "", $data);
   $data = str_replace("'", "", $data);
   $data = str_replace(",", " ", $data);
   return $data;
}


function printer($dt = ''){
	
	$rr = html_entity_decode($dt);
	return $rr;
}
function get_item_description_02( $itemId, $tblPK, $itemTbl, $db_conn ){
	$itemDesc = "";
			$qu_QQ_sel = "SELECT `family_id`,
								`section_id`,
								`division_id`,
								`subdivision_id`,
								`category_id`,
								`item_code_id`
									FROM  `$itemTbl` WHERE `$tblPK` = $itemId";
			$qu_QQ_EXE = mysqli_query($db_conn, $qu_QQ_sel);
			$QQ_DATA;
			if(mysqli_num_rows($qu_QQ_EXE)){
				$QQ_DATA = mysqli_fetch_assoc($qu_QQ_EXE);
				$family_id       = ( int ) $QQ_DATA['family_id'];
				$section_id      = ( int ) $QQ_DATA['section_id'];
				$division_id     = ( int ) $QQ_DATA['division_id'];
				$subdivision_id  = ( int ) $QQ_DATA['subdivision_id'];
				$category_id     = ( int ) $QQ_DATA['category_id'];
				$code_id         = ( int ) $QQ_DATA['item_code_id'];
				
				$GetDesc = false;
				$lvl01_N = "";
				$lvl02_N = "";
				$lvl03_N = "";
				$lvl04_N = "LV-04";
				$lvl05_N = "LV-05";
				$lvl06_N = "LV-06";
				
				
				
			if( $family_id  == 1 ){
				$qu_inv_01_families_descs_sel = "SELECT * FROM  `inv_01_families_descs` WHERE `family_id` = $family_id";
				$qu_inv_01_families_descs_EXE = mysqli_query($db_conn, $qu_inv_01_families_descs_sel);
				$inv_01_families_descs_DATA;
				if(mysqli_num_rows($qu_inv_01_families_descs_EXE)){
					$inv_01_families_descs_DATA = mysqli_fetch_assoc($qu_inv_01_families_descs_EXE);
					$lvl01_N = $inv_01_families_descs_DATA['lvl01'];
					$lvl02_N = $inv_01_families_descs_DATA['lvl02'];
					$lvl03_N = $inv_01_families_descs_DATA['lvl03'];
					$lvl04_N = $inv_01_families_descs_DATA['lvl04'];
					$lvl05_N = $inv_01_families_descs_DATA['lvl05'];
					$lvl06_N = $inv_01_families_descs_DATA['lvl06'];
				} else {
					$GetDesc = true;
				}
			} else {
				$GetDesc = true;
			}

				
				//get values for each level
				$lvl01_V = '';
				$lvl02_V = '';
				$lvl03_V = '';
				$lvl04_V = '';
				$lvl05_V = '';
				$lvl06_V = '';
				
				
				
				$qu_VV_sel = "SELECT `family_name` FROM  `inv_01_families` WHERE `family_id` = $family_id";
				$qu_VV_EXE = mysqli_query($db_conn, $qu_VV_sel);
				$inv_VV_DATA;
				if(mysqli_num_rows($qu_VV_EXE)){
					$inv_VV_DATA = mysqli_fetch_assoc($qu_VV_EXE);
					$lvl01_V = $inv_VV_DATA['family_name'];
				}
				
				$qu_VV_sel = "SELECT `section_name`, `section_description` FROM  `inv_02_sections` WHERE `section_id` = $section_id";
				$qu_VV_EXE = mysqli_query($db_conn, $qu_VV_sel);
				$inv_VV_DATA;
				if(mysqli_num_rows($qu_VV_EXE)){
					$inv_VV_DATA = mysqli_fetch_assoc($qu_VV_EXE);
					$lvl02_V = $inv_VV_DATA['section_name'];
					if( $GetDesc == true ){
						$lvl02_N = $inv_VV_DATA['section_description'];
					}
					
				}
				
				$qu_VV_sel = "SELECT `division_name`, `division_description` FROM  `inv_03_divisions` WHERE `division_id` = $division_id";
				$qu_VV_EXE = mysqli_query($db_conn, $qu_VV_sel);
				$inv_VV_DATA;
				if(mysqli_num_rows($qu_VV_EXE)){
					$inv_VV_DATA = mysqli_fetch_assoc($qu_VV_EXE);
					$lvl03_V = $inv_VV_DATA['division_name'];
					if( $GetDesc == true ){
						$lvl03_N = $inv_VV_DATA['division_description'];
					}
					
				}
				
				$qu_VV_sel = "SELECT `subdivision_name`, `subdivision_description` FROM  `inv_04_subdivisions` WHERE `subdivision_id` = $subdivision_id";
				$qu_VV_EXE = mysqli_query($db_conn, $qu_VV_sel);
				$inv_VV_DATA;
				if(mysqli_num_rows($qu_VV_EXE)){
					$inv_VV_DATA = mysqli_fetch_assoc($qu_VV_EXE);
					$lvl04_V = $inv_VV_DATA['subdivision_name'];
					if( $GetDesc == true ){
						$lvl04_N = $inv_VV_DATA['subdivision_description'];
					}
				}
				
				$qu_VV_sel = "SELECT `category_name`, `category_description` FROM  `inv_05_categories` WHERE `category_id` = $category_id";
				$qu_VV_EXE = mysqli_query($db_conn, $qu_VV_sel);
				$inv_VV_DATA;
				if(mysqli_num_rows($qu_VV_EXE)){
					$inv_VV_DATA = mysqli_fetch_assoc($qu_VV_EXE);
					$lvl05_V = $inv_VV_DATA['category_name'];
					if( $GetDesc == true ){
						$lvl05_N = $inv_VV_DATA['category_description'];
					}
				}
				
				$qu_VV_sel = "SELECT `item_name`, `item_description` FROM  `inv_06_codes` WHERE `code_id` = $code_id";
				$qu_VV_EXE = mysqli_query($db_conn, $qu_VV_sel);
				$inv_VV_DATA;
				if(mysqli_num_rows($qu_VV_EXE)){
					$inv_VV_DATA = mysqli_fetch_assoc($qu_VV_EXE);
					$lvl06_V = $inv_VV_DATA['item_name'];
					if( $GetDesc == true ){
						$lvl06_N = $inv_VV_DATA['item_description'];
					}
				}
				
				
				$itemDesc = $lvl01_V." - ".$lvl02_V." - ".$lvl03_V." - ".$lvl04_V." - ".$lvl05_V." - ".$lvl06_V;
				
				
				
				
			}
			return $itemDesc;
	
}
function get_item_description_dashed( $itemId, $tblPK, $itemTbl, $db_conn ){
	$itemDesc = "";
				
			$qu_QQ_sel = "SELECT `family_id`,
								`section_id`,
								`division_id`,
								`subdivision_id`,
								`category_id`,
								`item_code_id`
									FROM  `$itemTbl` WHERE `$tblPK` = $itemId";
			$qu_QQ_EXE = mysqli_query($db_conn, $qu_QQ_sel);
			$QQ_DATA;
			if(mysqli_num_rows($qu_QQ_EXE)){
				$QQ_DATA = mysqli_fetch_assoc($qu_QQ_EXE);
				$family_id       = ( int ) $QQ_DATA['family_id'];
				$section_id      = ( int ) $QQ_DATA['section_id'];
				$division_id     = ( int ) $QQ_DATA['division_id'];
				$subdivision_id  = ( int ) $QQ_DATA['subdivision_id'];
				$category_id     = ( int ) $QQ_DATA['category_id'];
				$code_id         = ( int ) $QQ_DATA['item_code_id'];
				
				$GetDesc = false;
				$lvl01_N = "LV-01";
				$lvl02_N = "LV-02";
				$lvl03_N = "LV-03";
				$lvl04_N = "LV-04";
				$lvl05_N = "LV-05";
				$lvl06_N = "LV-06";
				
				
				
			if( $family_id  == 1 ){
				$qu_inv_01_families_descs_sel = "SELECT * FROM  `inv_01_families_descs` WHERE `family_id` = $family_id";
				$qu_inv_01_families_descs_EXE = mysqli_query($db_conn, $qu_inv_01_families_descs_sel);
				$inv_01_families_descs_DATA;
				if(mysqli_num_rows($qu_inv_01_families_descs_EXE)){
					$inv_01_families_descs_DATA = mysqli_fetch_assoc($qu_inv_01_families_descs_EXE);
					$lvl01_N = $inv_01_families_descs_DATA['lvl01'];
					$lvl02_N = $inv_01_families_descs_DATA['lvl02'];
					$lvl03_N = $inv_01_families_descs_DATA['lvl03'];
					$lvl04_N = $inv_01_families_descs_DATA['lvl04'];
					$lvl05_N = $inv_01_families_descs_DATA['lvl05'];
					$lvl06_N = $inv_01_families_descs_DATA['lvl06'];
				} else {
					$GetDesc = true;
				}
			} else {
				$GetDesc = true;
			}
				
				//get values for each level
				$lvl01_V = '';
				$lvl02_V = '';
				$lvl03_V = '';
				$lvl04_V = '';
				$lvl05_V = '';
				$lvl06_V = '';
				
				
				if( $family_id != 0 ){
					
					$qu_VV_sel = "SELECT `family_name` FROM  `inv_01_families` WHERE `family_id` = $family_id";
					$qu_VV_EXE = mysqli_query($db_conn, $qu_VV_sel);
					$inv_VV_DATA;
					if(mysqli_num_rows($qu_VV_EXE)){
						$inv_VV_DATA = mysqli_fetch_assoc($qu_VV_EXE);
						$lvl01_V = $inv_VV_DATA['family_name'];
					}
					
				}
				
				$itemDesc  = '<div style="text-align:left;">';
				// $itemDesc .= "<b>- ".$lvl01_V."</b><br>";
				
				
				if( $section_id != 0 ){
					
					$qu_VV_sel = "SELECT `section_name`, `section_description` FROM  `inv_02_sections` WHERE `section_id` = $section_id";
					$qu_VV_EXE = mysqli_query($db_conn, $qu_VV_sel);
					$inv_VV_DATA;
					if(mysqli_num_rows($qu_VV_EXE)){
						$inv_VV_DATA = mysqli_fetch_assoc($qu_VV_EXE);
						$lvl02_V = $inv_VV_DATA['section_name'];
					if( $GetDesc == true ){
						$lvl02_N = $inv_VV_DATA['section_description'];
					}
				// $itemDesc .= "<strong>".$lvl02_N."</strong> :".$lvl02_V."<br>";
				$itemDesc .= "".$lvl02_V."";
					}
					
				}
					
				
				
				
				if( $division_id != 0 ){
					
					$qu_VV_sel = "SELECT `division_name`, `division_description` FROM  `inv_03_divisions` WHERE `division_id` = $division_id";
					$qu_VV_EXE = mysqli_query($db_conn, $qu_VV_sel);
					$inv_VV_DATA;
					if(mysqli_num_rows($qu_VV_EXE)){
						$inv_VV_DATA = mysqli_fetch_assoc($qu_VV_EXE);
						$lvl03_V = $inv_VV_DATA['division_name'];
					if( $GetDesc == true ){
						$lvl03_N = $inv_VV_DATA['division_description'];
					}
				// $itemDesc .= "<strong>".$lvl03_N."</strong> :".$lvl03_V."<br>";
				$itemDesc .= "-".$lvl03_V."";
					}
				
				}
				
				
				
				if( $subdivision_id != 0 ){
					
					$qu_VV_sel = "SELECT `subdivision_name`, `subdivision_description` FROM  `inv_04_subdivisions` WHERE `subdivision_id` = $subdivision_id";
					$qu_VV_EXE = mysqli_query($db_conn, $qu_VV_sel);
					$inv_VV_DATA;
					if(mysqli_num_rows($qu_VV_EXE)){
						$inv_VV_DATA = mysqli_fetch_assoc($qu_VV_EXE);
						$lvl04_V = $inv_VV_DATA['subdivision_name'];
					if( $GetDesc == true ){
						$lvl04_N = $inv_VV_DATA['subdivision_description'];
					}
				// $itemDesc .= "<strong>".$lvl04_N."</strong> :".$lvl04_V."<br>";
				$itemDesc .= "-".$lvl04_V."";
					}
					
				}
				
				
				
				if( $category_id != 0 ){
					
					$qu_VV_sel = "SELECT `category_name`, `category_description` FROM  `inv_05_categories` WHERE `category_id` = $category_id";
					$qu_VV_EXE = mysqli_query($db_conn, $qu_VV_sel);
					$inv_VV_DATA;
					if(mysqli_num_rows($qu_VV_EXE)){
						$inv_VV_DATA = mysqli_fetch_assoc($qu_VV_EXE);
						$lvl05_V = $inv_VV_DATA['category_name'];
					if( $GetDesc == true ){
						$lvl05_N = $inv_VV_DATA['category_description'];
					}
				// $itemDesc .= "<strong>".$lvl05_N."</strong> :".$lvl05_V."<br>";
				$itemDesc .= "-".$lvl05_V."";
					}
					
				}
					
				if( $code_id != 0 ){
					
					$qu_VV_sel = "SELECT `item_name`, `item_description` FROM  `inv_06_codes` WHERE `code_id` = $code_id";
					$qu_VV_EXE = mysqli_query($db_conn, $qu_VV_sel);
					$inv_VV_DATA;
					if(mysqli_num_rows($qu_VV_EXE)){
						$inv_VV_DATA = mysqli_fetch_assoc($qu_VV_EXE);
						$lvl06_V = $inv_VV_DATA['item_name'];
					if( $GetDesc == true ){
						$lvl06_N = $inv_VV_DATA['item_description'];
					}
				// $itemDesc .= "<strong>".$lvl06_N."</strong> :".$lvl06_V."<br>";
				$itemDesc .= "-".$lvl06_V."";
					}
				}
				
				
				
				
				$itemDesc .= "</div>";
				
				
				
				
			}
			return $itemDesc;
	
}
function get_item_description( $itemId, $tblPK, $itemTbl, $db_conn ){
	$itemDesc = "";
				
			$qu_QQ_sel = "SELECT `family_id`,
								`section_id`,
								`division_id`,
								`subdivision_id`,
								`category_id`,
								`item_code_id`
									FROM  `$itemTbl` WHERE `$tblPK` = $itemId";
			$qu_QQ_EXE = mysqli_query($db_conn, $qu_QQ_sel);
			$QQ_DATA;
			if(mysqli_num_rows($qu_QQ_EXE)){
				$QQ_DATA = mysqli_fetch_assoc($qu_QQ_EXE);
				$family_id       = ( int ) $QQ_DATA['family_id'];
				$section_id      = ( int ) $QQ_DATA['section_id'];
				$division_id     = ( int ) $QQ_DATA['division_id'];
				$subdivision_id  = ( int ) $QQ_DATA['subdivision_id'];
				$category_id     = ( int ) $QQ_DATA['category_id'];
				$code_id         = ( int ) $QQ_DATA['item_code_id'];
				
				$GetDesc = false;
				$lvl01_N = "LV-01";
				$lvl02_N = "LV-02";
				$lvl03_N = "LV-03";
				$lvl04_N = "LV-04";
				$lvl05_N = "LV-05";
				$lvl06_N = "LV-06";
				
				
				
			if( $family_id  == 1 ){
				$qu_inv_01_families_descs_sel = "SELECT * FROM  `inv_01_families_descs` WHERE `family_id` = $family_id";
				$qu_inv_01_families_descs_EXE = mysqli_query($db_conn, $qu_inv_01_families_descs_sel);
				$inv_01_families_descs_DATA;
				if(mysqli_num_rows($qu_inv_01_families_descs_EXE)){
					$inv_01_families_descs_DATA = mysqli_fetch_assoc($qu_inv_01_families_descs_EXE);
					$lvl01_N = $inv_01_families_descs_DATA['lvl01'];
					$lvl02_N = $inv_01_families_descs_DATA['lvl02'];
					$lvl03_N = $inv_01_families_descs_DATA['lvl03'];
					$lvl04_N = $inv_01_families_descs_DATA['lvl04'];
					$lvl05_N = $inv_01_families_descs_DATA['lvl05'];
					$lvl06_N = $inv_01_families_descs_DATA['lvl06'];
				} else {
					$GetDesc = true;
				}
			} else {
				$GetDesc = true;
			}
				//get values for each level
				$lvl01_V = '';
				$lvl02_V = '';
				$lvl03_V = '';
				$lvl04_V = '';
				$lvl05_V = '';
				$lvl06_V = '';
				
				
				if( $family_id != 0 ){
					
					$qu_VV_sel = "SELECT `family_name` FROM  `inv_01_families` WHERE `family_id` = $family_id";
					$qu_VV_EXE = mysqli_query($db_conn, $qu_VV_sel);
					$inv_VV_DATA;
					if(mysqli_num_rows($qu_VV_EXE)){
						$inv_VV_DATA = mysqli_fetch_assoc($qu_VV_EXE);
						$lvl01_V = $inv_VV_DATA['family_name'];
					}
					
				}
				
				$itemDesc  = '<div style="text-align:left;">';
				$itemDesc .= "<b>- ".$lvl01_V."</b><br>";
				
				
				if( $section_id != 0 ){
					
					$qu_VV_sel = "SELECT `section_name`, `section_description` FROM  `inv_02_sections` WHERE `section_id` = $section_id";
					$qu_VV_EXE = mysqli_query($db_conn, $qu_VV_sel);
					$inv_VV_DATA;
					if(mysqli_num_rows($qu_VV_EXE)){
						$inv_VV_DATA = mysqli_fetch_assoc($qu_VV_EXE);
						$lvl02_V = $inv_VV_DATA['section_name'];
					if( $GetDesc == true ){
						$lvl02_N = $inv_VV_DATA['section_description'];
					}
					
					
					if( $lvl02_N == 'undefined' || $lvl02_N == '' ){
					    $lvl02_N = '--';
					}
					
					
					
				$itemDesc .= "<strong>".$lvl02_N."</strong> :".$lvl02_V."<br>";
					}
					
				}
					
				
				
				
				if( $division_id != 0 ){
					
					$qu_VV_sel = "SELECT `division_name`, `division_description` FROM  `inv_03_divisions` WHERE `division_id` = $division_id";
					$qu_VV_EXE = mysqli_query($db_conn, $qu_VV_sel);
					$inv_VV_DATA;
					if(mysqli_num_rows($qu_VV_EXE)){
						$inv_VV_DATA = mysqli_fetch_assoc($qu_VV_EXE);
						$lvl03_V = $inv_VV_DATA['division_name'];
					if( $GetDesc == true ){
						$lvl03_N = $inv_VV_DATA['division_description'];
					}
					
					
					if( $lvl03_N == 'undefined' || $lvl03_N == ''  ){
					    $lvl03_N = '--';
					}
					
					
					
				$itemDesc .= "<strong>".$lvl03_N."</strong> :".$lvl03_V."<br>";
					}
				
				}
				
				
				
				if( $subdivision_id != 0 ){
					
					$qu_VV_sel = "SELECT `subdivision_name`, `subdivision_description` FROM  `inv_04_subdivisions` WHERE `subdivision_id` = $subdivision_id";
					$qu_VV_EXE = mysqli_query($db_conn, $qu_VV_sel);
					$inv_VV_DATA;
					if(mysqli_num_rows($qu_VV_EXE)){
						$inv_VV_DATA = mysqli_fetch_assoc($qu_VV_EXE);
						$lvl04_V = $inv_VV_DATA['subdivision_name'];
					if( $GetDesc == true ){
						$lvl04_N = $inv_VV_DATA['subdivision_description'];
					}
					
					
					if( $lvl04_N == 'undefined' || $lvl04_N == ''  ){
					    $lvl04_N = '--';
					}
					
					
					
				$itemDesc .= "<strong>".$lvl04_N."</strong> :".$lvl04_V."<br>";
					}
					
				}
				
				
				
				if( $category_id != 0 ){
					
					$qu_VV_sel = "SELECT `category_name`, `category_description` FROM  `inv_05_categories` WHERE `category_id` = $category_id";
					$qu_VV_EXE = mysqli_query($db_conn, $qu_VV_sel);
					$inv_VV_DATA;
					if(mysqli_num_rows($qu_VV_EXE)){
						$inv_VV_DATA = mysqli_fetch_assoc($qu_VV_EXE);
						$lvl05_V = $inv_VV_DATA['category_name'];
					if( $GetDesc == true ){
						$lvl05_N = $inv_VV_DATA['category_description'];
					}
					
					
					if( $lvl05_N == 'undefined' || $lvl05_N == ''  ){
					    $lvl05_N = '--';
					}
					
					
					
				$itemDesc .= "<strong>".$lvl05_N."</strong> :".$lvl05_V."<br>";
					}
					
				}
					
				if( $code_id != 0 ){
					
					$qu_VV_sel = "SELECT `item_name`, `item_description` FROM  `inv_06_codes` WHERE `code_id` = $code_id";
					$qu_VV_EXE = mysqli_query($db_conn, $qu_VV_sel);
					$inv_VV_DATA;
					if(mysqli_num_rows($qu_VV_EXE)){
						$inv_VV_DATA = mysqli_fetch_assoc($qu_VV_EXE);
						$lvl06_V = $inv_VV_DATA['item_name'];
					if( $GetDesc == true ){
						$lvl06_N = $inv_VV_DATA['item_description'];
					}
					
					
					if( $lvl06_N == 'undefined' || $lvl06_N == ''  ){
					    $lvl06_N = '--';
					}
					
					
					
				$itemDesc .= "<strong>".$lvl06_N."</strong> :".$lvl06_V."<br>";
					}
				}
				
				
				
				
				$itemDesc .= "</div>";
				
				
				
				
			}
			return $itemDesc;
	
}

function get_item_unit_id( $item_code_id, $db_conn ){
	
			$qu_inv_06_codes_sel = "SELECT `code_unit_id` FROM  `inv_06_codes` WHERE `code_id` = $item_code_id";
			$qu_inv_06_codes_EXE = mysqli_query($db_conn, $qu_inv_06_codes_sel);
			$inv_06_codes_DATA;
			if(mysqli_num_rows($qu_inv_06_codes_EXE)){
				$inv_06_codes_DATA = mysqli_fetch_assoc($qu_inv_06_codes_EXE);
			}
			
			$code_unit_id = $inv_06_codes_DATA['code_unit_id'];
			
			return $code_unit_id;
	
}

function get_requisition_ref( $requisition_id, $db_conn ){
	
	$qu_pur_requisitions_sel = "SELECT `requisition_ref` FROM  `pur_requisitions` WHERE `requisition_id` = $requisition_id";
	$qu_pur_requisitions_EXE = mysqli_query($db_conn, $qu_pur_requisitions_sel);
	$pur_requisitions_DATA;
	if(mysqli_num_rows($qu_pur_requisitions_EXE)){
		$pur_requisitions_DATA = mysqli_fetch_assoc($qu_pur_requisitions_EXE);
		$requisition_ref = $pur_requisitions_DATA['requisition_ref'];
		
		return $requisition_ref;
	} else {
		return false;
	}
}

function get_currency_name( $currency_id, $db_conn ){
	
	$qu_gen_currencies_sel = "SELECT `currency_name` FROM  `gen_currencies` WHERE `currency_id` = $currency_id";
	$qu_gen_currencies_EXE = mysqli_query($db_conn, $qu_gen_currencies_sel);
	$gen_currencies_DATA;
	if(mysqli_num_rows($qu_gen_currencies_EXE)){
		$gen_currencies_DATA = mysqli_fetch_assoc($qu_gen_currencies_EXE);
		$currency_name = $gen_currencies_DATA['currency_name'];
		
		return $currency_name;
	} else {
		return false;
	}
}

function get_delivery_period_title( $delivery_period_id, $db_conn ){
	
	$qu_gen_delivery_periods_sel = "SELECT `delivery_period_title` FROM  `gen_delivery_periods` WHERE `delivery_period_id` = $delivery_period_id";
	$qu_gen_delivery_periods_EXE = mysqli_query($db_conn, $qu_gen_delivery_periods_sel);
	$gen_delivery_periods_DATA;
	if(mysqli_num_rows($qu_gen_delivery_periods_EXE)){
		$gen_delivery_periods_DATA = mysqli_fetch_assoc($qu_gen_delivery_periods_EXE);
		$delivery_period_title = $gen_delivery_periods_DATA['delivery_period_title'];
		
		return $delivery_period_title;
	} else {
		return false;
	}
}

function get_payment_term_title( $payment_term_id, $db_conn ){
	
	$qu_gen_payment_terms_sel = "SELECT `payment_term_title` FROM  `gen_payment_terms` WHERE `payment_term_id` = $payment_term_id";
	$qu_gen_payment_terms_EXE = mysqli_query($db_conn, $qu_gen_payment_terms_sel);
	$gen_payment_terms_DATA;
	if(mysqli_num_rows($qu_gen_payment_terms_EXE)){
		$gen_payment_terms_DATA = mysqli_fetch_assoc($qu_gen_payment_terms_EXE);
		$payment_term_title = $gen_payment_terms_DATA['payment_term_title'];
		
		return $payment_term_title;
	} else {
		return false;
	}
}

function get_supplier_name( $supplier_id, $db_conn ){
	
	$qu_suppliers_list_sel = "SELECT `supplier_code`, `supplier_name` FROM  `suppliers_list` WHERE `supplier_id` = $supplier_id";
	$qu_suppliers_list_EXE = mysqli_query($db_conn, $qu_suppliers_list_sel);
	$suppliers_list_DATA;
	if(mysqli_num_rows($qu_suppliers_list_EXE)){
		$suppliers_list_DATA = mysqli_fetch_assoc($qu_suppliers_list_EXE);
		$supplier_code = $suppliers_list_DATA['supplier_code'];
		$supplier_name = $suppliers_list_DATA['supplier_name'];
		return $supplier_code.' - '.$supplier_name;
	} else {
		return false;
	}
}

function get_unit_name( $code_unit_id, $db_conn ){
	
			$qu_gen_items_units_sel = "SELECT `unit_name` FROM  `gen_items_units` WHERE `unit_id` = $code_unit_id";
			$qu_gen_items_units_EXE = mysqli_query($db_conn, $qu_gen_items_units_sel);
			$unit_name = 'ERROR-1569';
			if(mysqli_num_rows($qu_gen_items_units_EXE)){
				$gen_items_units_DATA = mysqli_fetch_assoc($qu_gen_items_units_EXE);
				$unit_name = $gen_items_units_DATA['unit_name'];
			}
			
			return $unit_name;
}

function get_item_unit_name( $item_code_id, $db_conn ){
	
			$qu_inv_06_codes_sel = "SELECT `code_unit_id` FROM  `inv_06_codes` WHERE `code_id` = $item_code_id";
			$qu_inv_06_codes_EXE = mysqli_query($db_conn, $qu_inv_06_codes_sel);
			$code_unit_id = 0;
			if(mysqli_num_rows($qu_inv_06_codes_EXE)){
				$inv_06_codes_DATA = mysqli_fetch_assoc($qu_inv_06_codes_EXE);
				$code_unit_id = $inv_06_codes_DATA['code_unit_id'];
			}
			
			
			
			$qu_gen_items_units_sel = "SELECT `unit_name` FROM  `gen_items_units` WHERE `unit_id` = $code_unit_id";
			$qu_gen_items_units_EXE = mysqli_query($db_conn, $qu_gen_items_units_sel);
			$unit_name = 'ERROR-1569';
			if(mysqli_num_rows($qu_gen_items_units_EXE)){
				$gen_items_units_DATA = mysqli_fetch_assoc($qu_gen_items_units_EXE);
				$unit_name = $gen_items_units_DATA['unit_name'];
			}
			
			return $unit_name;
}

function get_item_name( $item_code_id, $lv5, $lv4, $lv3, $lv2, $hideFam, $db_conn ){
	
			$qu_inv_06_codes_sel = "SELECT * FROM  `inv_06_codes` WHERE `code_id` = $item_code_id";
			$qu_inv_06_codes_EXE = mysqli_query($db_conn, $qu_inv_06_codes_sel);
			$inv_06_codes_DATA;
			if(mysqli_num_rows($qu_inv_06_codes_EXE)){
				$inv_06_codes_DATA = mysqli_fetch_assoc($qu_inv_06_codes_EXE);
			}
			$item_name = $inv_06_codes_DATA['item_name'];
			// $family_id = $inv_06_codes_DATA['family_id'];
			

	$qu_inv_05_categories_sel = "SELECT * FROM  `inv_05_categories` WHERE `category_id` = $lv5";
	$qu_inv_05_categories_EXE = mysqli_query($db_conn, $qu_inv_05_categories_sel);
	$inv_05_categories_DATA;
	if(mysqli_num_rows($qu_inv_05_categories_EXE)){
		$inv_05_categories_DATA = mysqli_fetch_assoc($qu_inv_05_categories_EXE);
	}
	
		$category_code = $inv_05_categories_DATA['category_code'];
		$category_name = $inv_05_categories_DATA['category_name'];

	
	
	
	$qu_inv_04_subdivisions_sel = "SELECT * FROM  `inv_04_subdivisions` WHERE `subdivision_id` = $lv4";
	$qu_inv_04_subdivisions_EXE = mysqli_query($db_conn, $qu_inv_04_subdivisions_sel);
	$inv_04_subdivisions_DATA;
	if(mysqli_num_rows($qu_inv_04_subdivisions_EXE)){
		$inv_04_subdivisions_DATA = mysqli_fetch_assoc($qu_inv_04_subdivisions_EXE);
	}
	
		$subdivision_code = $inv_04_subdivisions_DATA['subdivision_code'];
		$subdivision_name = $inv_04_subdivisions_DATA['subdivision_name'];

	
	$qu_inv_03_divisions_sel = "SELECT * FROM  `inv_03_divisions` WHERE `division_id` = $lv3";
	$qu_inv_03_divisions_EXE = mysqli_query($db_conn, $qu_inv_03_divisions_sel);
	$inv_03_divisions_DATA;
	if(mysqli_num_rows($qu_inv_03_divisions_EXE)){
		$inv_03_divisions_DATA = mysqli_fetch_assoc($qu_inv_03_divisions_EXE);
	}
	
		$division_code = $inv_03_divisions_DATA['division_code'];
		$division_name = $inv_03_divisions_DATA['division_name'];

	
	
	$qu_inv_02_sections_sel = "SELECT * FROM  `inv_02_sections` WHERE `section_id` = $lv2";
	$qu_inv_02_sections_EXE = mysqli_query($db_conn, $qu_inv_02_sections_sel);
	$inv_02_sections_DATA;
	if(mysqli_num_rows($qu_inv_02_sections_EXE)){
		$inv_02_sections_DATA = mysqli_fetch_assoc($qu_inv_02_sections_EXE);
	}
	
		$section_code = $inv_02_sections_DATA['section_code'];
		$section_name = $inv_02_sections_DATA['section_name'];
		$family_id = $inv_02_sections_DATA['family_id'];
	
	$qu_inv_01_families_sel = "SELECT * FROM  `inv_01_families` WHERE `family_id` = $family_id";
	$qu_inv_01_families_EXE = mysqli_query($db_conn, $qu_inv_01_families_sel);
	$inv_01_families_DATA;
	if(mysqli_num_rows($qu_inv_01_families_EXE)){
		$inv_01_families_DATA = mysqli_fetch_assoc($qu_inv_01_families_EXE);
	}
	
		$family_code = $inv_01_families_DATA['family_code'];
		$family_name = $inv_01_families_DATA['family_name'];
		$family_icon = $inv_01_families_DATA['family_icon'];
		
		$family_name = $family_name.' :';
		if( $hideFam == 1 ){
			$family_name = "";
		}
$hirarcy = $family_name.' '.$section_name.' - '.$division_name.' : '.$subdivision_name.' : '.$category_name.' :( '.$item_name.' )';

	return $hirarcy;	
			
}

function get_emp_name($db_conn, $bring_id ){
	

	$qu_hr_employees_sel = "SELECT * FROM  `hr_employees` WHERE `employee_id` = $bring_id";
	$qu_hr_employees_EXE = mysqli_query($db_conn, $qu_hr_employees_sel);
	$hr_employees_DATA;
	if(mysqli_num_rows($qu_hr_employees_EXE)){
		$hr_employees_DATA = mysqli_fetch_assoc($qu_hr_employees_EXE);
		$DT = $hr_employees_DATA['first_name'].' '.$hr_employees_DATA['last_name'];
		
		
		return $DT;
		
	} else {
		return false;
	}
	
}


function get_current_state($db_conn, $item_id, $item_type ){
	
	$qu_gen_status_change_sel = "SELECT `status_action` FROM  `gen_status_change` WHERE 
								`item_id` = '$item_id' AND 
								`item_type` = '$item_type' ORDER BY `status_id` DESC LIMIT 1";
	$qu_gen_status_change_EXE = mysqli_query($db_conn, $qu_gen_status_change_sel);
	$gen_status_change_DATA;
	if(mysqli_num_rows( $qu_gen_status_change_EXE) > 0 ){
		
		$gen_status_change_DATA = mysqli_fetch_assoc($qu_gen_status_change_EXE);
		
		$status_action = $gen_status_change_DATA['status_action'];
		
		return $status_action;
		
	} else {
		return false;
	}
}
function get_current_state_id($db_conn, $item_id, $item_type ){
	
	$qu_gen_status_change_sel = "SELECT `status_id` FROM  `gen_status_change` WHERE 
								`item_id` = '$item_id' AND 
								`item_type` = '$item_type' ORDER BY `status_id` DESC LIMIT 1";
	$qu_gen_status_change_EXE = mysqli_query($db_conn, $qu_gen_status_change_sel);
	$gen_status_change_DATA;
	if(mysqli_num_rows( $qu_gen_status_change_EXE) > 0 ){
		
		$gen_status_change_DATA = mysqli_fetch_assoc($qu_gen_status_change_EXE);
		
		$status_id = $gen_status_change_DATA['status_id'];
		if( $status_id != 0 ){
			return $status_id;
		} else {
			return 0;
		}
		
		
	} else {
		return 0;
	}
}



function insert_notification_for_user($db_conn, $notification_title, $notification_content, $notification_link, $sender_id, $receiver_id){
	
	$notification_time = date( "Y-m-d H:i:00" );

			$notification_id = 0;

			$qu_users_notifications_ins = "INSERT INTO `users_notifications` (
								`notification_title`, 
								`notification_content`, 
								`notification_link`, 
								`sender_id`, 
								`receiver_id`, 
								`notification_time`
							) VALUES (
								'".$notification_title."', 
								'".$notification_content."', 
								'".$notification_link."', 
								'".$sender_id."', 
								'".$receiver_id."', 
								'".$notification_time."'
							);";

			if(mysqli_query($db_conn, $qu_users_notifications_ins)){
				$notification_id = mysqli_insert_id($db_conn);
				if( $notification_id != 0 ){
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
	
}

function insert_state_change($db_conn, $status_action, $item_id, $item_type, $action_by){
	
	$status_date = date( "Y-m-d H:i:00" );
	$qu_gen_status_change_ins = "INSERT INTO `gen_status_change` (
						`status_action`, 
						`status_date`, 
						`item_id`, 
						`item_type`, 
						`action_by` 
					) VALUES (
						'".$status_action."', 
						'".$status_date."', 
						'".$item_id."', 
						'".$item_type."', 
						'".$action_by."' 
					);";

	if(mysqli_query($db_conn, $qu_gen_status_change_ins)){
		$status_id = mysqli_insert_id($db_conn);
		if( $status_id != 0 ){
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}
	
}

function insert_state_change_dep($db_conn, $dep_action, $item_id, $item_name, $item_type, $action_by, $status_id){
	
	$dep_date = date( "Y-m-d H:i:00" );
	$qu_gen_status_change_depandancy_ins = "INSERT INTO `gen_status_change_depandancy` (
											`dep_action`, 
											`dep_date`, 
											`item_id`, 
											`item_name`, 
											`item_type`, 
											`action_by`, 
											`status_id` 
										) VALUES (
											'".$dep_action."', 
											'".$dep_date."', 
											'".$item_id."', 
											'".$item_name."', 
											'".$item_type."', 
											'".$action_by."', 
											'".$status_id."' 
										);";

	if(mysqli_query($db_conn, $qu_gen_status_change_depandancy_ins)){
		$dep_id = mysqli_insert_id($db_conn);
		if( $dep_id != 0 ){
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}
	
}






function upload_file($file_req, $sizer = 3000, $directory='uploads', $pointers='../'){
	if(isset($_FILES[$file_req])){
		$targer_dir = $pointers.$directory."/";

		//data collection
		$fileName = $_FILES[$file_req]["name"]; // The file name
		$fileTmpLoc = $_FILES[$file_req]["tmp_name"]; // File in the PHP tmp folder
		$fileType = $_FILES[$file_req]["type"]; // The type of file it is
		$fileSize = $_FILES[$file_req]["size"]; // File size in bytes
		$fileErrorMsg = $_FILES[$file_req]["error"]; // 0 for false... and 1 for true
		
		if (!$fileTmpLoc) { // if file not chosen
			return false;
		}
		
		//check extensions
		$ths_ext = $fileType;
		if(!($ths_ext == 'image/svg+xml' || $ths_ext == 'image/jpeg' || $ths_ext == 'image/jpg' || $ths_ext == 'image/png' || $ths_ext == 'application/pdf' || $ths_ext == 'video/mp4' || $ths_ext == 'video/mp4' || $ths_ext == 'application/msword')){
			//file is NOT ACCEPTED
			return false;
		}
		
		
		//check sizes
		$ths_size = $fileSize;
		$ths_size = round($ths_size/1024);
		if($ths_size > $sizer){
			return false;
		}
		
		/*
		//manipulate image width and height
		$x = 480;
		$y = 540;
		$nw_img = @imagecreate($x, $y);
		*/
		
			$ext = explode(".", $fileName);
			$extensiom = end($ext);
			$New_name = 'p_'.generate_guid();
			$db_file_name = $New_name.'.'.$extensiom;
			if(move_uploaded_file($fileTmpLoc, $targer_dir.$New_name.'.'.$extensiom)){
				return $db_file_name;
			} else {
				return false;
			}
		
		
		
		
		
		
	}//end of isset
}

function upload_picture($file_req, $sizer = 3000, $directory='uploads', $pointers='../'){
	if(isset($_FILES[$file_req])){
		$targer_dir = $pointers.$directory."/";

		//data collection
		$fileName = $_FILES[$file_req]["name"]; // The file name
		$fileTmpLoc = $_FILES[$file_req]["tmp_name"]; // File in the PHP tmp folder
		$fileType = $_FILES[$file_req]["type"]; // The type of file it is
		$fileSize = $_FILES[$file_req]["size"]; // File size in bytes
		$fileErrorMsg = $_FILES[$file_req]["error"]; // 0 for false... and 1 for true
		
		if (!$fileTmpLoc) { // if file not chosen
			die('rere444'.$file_req);
			return false;
		}
		
		//check extensions 
		$ths_ext = $fileType;
		if(!($ths_ext == 'image/svg+xml' || $ths_ext == 'image/jpeg' || $ths_ext == 'image/jpg' || $ths_ext == 'image/png' || $ths_ext == 'application/pdf' || $ths_ext == 'video/mp4' || $ths_ext == 'video/mp4' || $ths_ext == 'application/msword')){
			//file is NOT ACCEPTED
			echo $ths_ext;
			die('ggg');
			return false;
		}
		
		
		//check sizes
		$ths_size = $fileSize;
		$ths_size = round($ths_size/1024);
		if($ths_size > $sizer){
			die('sserrere');
			return false;
		}
		
		/*
		//manipulate image width and height
		$x = 480;
		$y = 540;
		$nw_img = @imagecreate($x, $y);
		*/
		
			$ext = explode(".", $fileName);
			$extensiom = end($ext);
			$New_name = 'p_'.generate_guid();
			$db_file_name = $New_name.'.'.$extensiom;
			if(move_uploaded_file($fileTmpLoc, $targer_dir.$New_name.'.'.$extensiom)){
				return $db_file_name;
			} else {
				return false;
			}
		
		
		
		
		
		
	}//end of isset
}




function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function detectDevice(){
	$userAgent = $_SERVER["HTTP_USER_AGENT"];
	$devicesTypes = array(
        "computer" => array("msie 10", "msie 9", "msie 8", "windows.*firefox", "windows.*chrome", "x11.*chrome", "x11.*firefox", "macintosh.*chrome", "macintosh.*firefox", "opera"),
        "tablet"   => array("tablet", "android", "ipad", "tablet.*firefox"),
        "mobile"   => array("mobile ", "android.*mobile", "iphone", "ipod", "opera mobi", "opera mini"),
        "bot"      => array("googlebot", "mediapartners-google", "adsbot-google", "duckduckbot", "msnbot", "bingbot", "ask", "facebook", "yahoo", "addthis")
    );
 	foreach($devicesTypes as $deviceType => $devices) {           
        foreach($devices as $device) {
            if(preg_match("/" . $device . "/i", $userAgent)) {
                $deviceName = $deviceType;
            }
        }
    }
    return ucfirst($deviceName);
 	}
 	
 	
 	
 	

function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
    $output = NULL;
    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($deep_detect) {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    }
    $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
    $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
    $continents = array(
        "AF" => "Africa",
        "AN" => "Antarctica",
        "AS" => "Asia",
        "EU" => "Europe",
        "OC" => "Australia (Oceania)",
        "NA" => "North America",
        "SA" => "South America"
    );
    if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
        $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
            switch ($purpose) {
                case "location":
                    $output = array(
                        "city"           => @$ipdat->geoplugin_city,
                        "state"          => @$ipdat->geoplugin_regionName,
                        "country"        => @$ipdat->geoplugin_countryName,
                        "country_code"   => @$ipdat->geoplugin_countryCode,
                        "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                        "continent_code" => @$ipdat->geoplugin_continentCode
                    );
                    break;
                case "address":
                    $address = array($ipdat->geoplugin_countryName);
                    if (@strlen($ipdat->geoplugin_regionName) >= 1)
                        $address[] = $ipdat->geoplugin_regionName;
                    if (@strlen($ipdat->geoplugin_city) >= 1)
                        $address[] = $ipdat->geoplugin_city;
                    $output = implode(", ", array_reverse($address));
                    break;
                case "city":
                    $output = @$ipdat->geoplugin_city;
                    break;
                case "state":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "region":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "country":
                    $output = @$ipdat->geoplugin_countryName;
                    break;
                case "countrycode":
                    $output = @$ipdat->geoplugin_countryCode;
                    break;
            }
        }
    }
    return $output;
}

 	




?>
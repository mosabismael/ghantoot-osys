<?php
	require_once('../../bootstrap/app_config.php');
	require_once('../../bootstrap/chk_log_user.php');
	
	if(isset($_GET['family_id'])){
		$family_id = $_GET['family_id'];
	}
	if(isset($_GET['section_id'])){
		$section_id = $_GET['section_id'];
	}
	if(isset($_GET['division_id'])){
		$division_id = $_GET['division_id'];
	}
	if(isset($_GET['subdivision_id'])){
		$subdivision_id = $_GET['subdivision_id'];
	}
	if(isset($_GET['category_id'])){
		$category_id = $_GET['category_id'];
	}
	if(isset($_GET['item_code_id'])){
		$item_code_id = $_GET['item_code_id'];
	}
	$IAM_ARRAY = array();
	$qu_po_SEL = "select * from purchase_orders_items poi , purchase_orders po, suppliers_list sl, pur_requisitions req where poi.family_id = $family_id and poi.division_id = $division_id and poi.subdivision_id = $subdivision_id and poi.category_id = $category_id and poi.section_id = $section_id and poi.item_code_id = $item_code_id and po.po_id = poi.po_id and sl.supplier_id = po.supplier_id and req.requisition_id = po.requisition_id;";
	$qu_project_level1_EXE = mysqli_query($KONN, $qu_po_SEL);
	$no = 0;
	if(mysqli_num_rows($qu_project_level1_EXE)){
		while($project_level1_REC = mysqli_fetch_assoc($qu_project_level1_EXE)){
			$no++;
			$requisition_REF = $project_level1_REC['requisition_ref'];
			$supplier_code = $project_level1_REC['supplier_code'];
			$po_ref = $project_level1_REC['po_ref'];
			$item_qty = $project_level1_REC['item_qty'];
			$item_price = $project_level1_REC['item_price'];
			$po_date = $project_level1_REC['po_date'];
			$IAM_ARRAY[] = array(  "no" => $no,
						"item_price" => $item_price, 
						"item_qty" => $item_qty,
						"po_ref" => $po_ref,
						"supplier_code" => $supplier_code,
						"requisition_REF" => $requisition_REF,
						"po_date" => $po_date
						);
		}
	}
echo json_encode($IAM_ARRAY);

?>

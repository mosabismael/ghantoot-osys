<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "ACC COA";
	
	$menuId = 1;
	$subPageID = 4;
?>
<!DOCTYPE html>
<html dir="<?=$lang_dir; ?>" lang="<?=$lang; ?>">
<html>
<head>
	<?php include('app/meta.php'); ?>
    <?php include('app/assets.php'); ?>
</head>
<body>
<?php
	include('app/header.php');
	//PAGE DATA START -----------------------------------------------///---------------------------------
?>




<div class="row">
	<div class="col-100">

<table class="tabler">
	<thead>
		<tr>
			<th style="width:50%;">SOURCE</th>
			<th>DESTINATION</th>
		</tr>
	</thead>
	<tbody>
		
		<tr>
			<td>
			

<table class="tabler">
	<thead>
		<tr>
			<th>ACC</th>
			<th>AMOUNT</th>
		</tr>
	</thead>
	<tbody>
		<tr id="addedSrcPoint">
			<td class="text-center" colspan="2">
<button onclick="addSrc();" type="button" class="btn btn-primary"><?=lang("Add_Source", "sss"); ?></button>

			</td>
		</tr>
	</tbody>
</table>
			
			</td>
			<td>
			
<table class="tabler">
	<thead>
		<tr>
			<th>ACC</th>
			<th>AMOUNT</th>
		</tr>
	</thead>
	<tbody>
		<tr id="addedDestPoint">
			<td class="text-center" colspan="2">
<button onclick="addDest();" type="button" class="btn btn-primary"><?=lang("Add_Destination", "sss"); ?></button>

			</td>
		</tr>
	</tbody>
</table>
			
			</td>
		</tr>
	</tbody>
</table>
			







<script>

function addDest(){
	var ll = '<tr>' + 
			'	<td>' + 
			'		<div class="form-grp">' + 
			'			<select name="acc_dests[]" class="">' + 
			'				<option value="0" selected="">Please Select</option>' + 
	<?php
		$qu_acc_accounts_sel = "SELECT `account_id`, `account_name` FROM  `acc_accounts` ORDER BY `account_name` ASC";
		$qu_acc_accounts_EXE = mysqli_query($KONN, $qu_acc_accounts_sel);
		if(mysqli_num_rows($qu_acc_accounts_EXE)){
			while($acc_accounts_REC = mysqli_fetch_assoc($qu_acc_accounts_EXE)){
			?>
			'<option value="<?=$acc_accounts_REC['account_id']; ?>"><?=$acc_accounts_REC['account_name']; ?></option>' + 
			<?php
			}
		}
	?>
			'			</select>' + 
			'		</div>' + 
			'	</td>' + 
			'	<td>' + 
			'		<div class="form-grp">' + 
			'			<input type="text" name="dest_amounts[]" placeholder="Transaction Amount">' + 
			'		</div>' + 
			'	</td>' + 
			'</tr>';
		
	$('#addedDestPoint').before( ll );
}


function addSrc(){
	var ll = '<tr>' + 
			'	<td>' + 
			'		<div class="form-grp">' + 
			'			<select name="acc_srcs[]" class="">' + 
			'				<option value="0" selected="">Please Select</option>' + 
	<?php
		$qu_acc_accounts_sel = "SELECT `account_id`, `account_name` FROM  `acc_accounts` ORDER BY `account_name` ASC";
		$qu_acc_accounts_EXE = mysqli_query($KONN, $qu_acc_accounts_sel);
		if(mysqli_num_rows($qu_acc_accounts_EXE)){
			while($acc_accounts_REC = mysqli_fetch_assoc($qu_acc_accounts_EXE)){
			?>
			'<option value="<?=$acc_accounts_REC['account_id']; ?>"><?=$acc_accounts_REC['account_name']; ?></option>' + 
			<?php
			}
		}
	?>
			'			</select>' + 
			'		</div>' + 
			'	</td>' + 
			'	<td>' + 
			'		<div class="form-grp">' + 
			'			<input type="text" name="src_amounts[]" placeholder="Transaction Amount">' + 
			'		</div>' + 
			'	</td>' + 
			'</tr>';
		
	$('#addedSrcPoint').before( ll );
}





var src_acc = 0;
var dst_acc = 0;
var amount = 0;


function do_exchange(){
	var notes = $('#notes').val();
	if(src_acc != 0 && dst_acc != 0 && amount != 0){
		if(src_acc !=  dst_acc ){
			var conf = confirm(' Are You Sure, This Will make Double record Transaction ?');
			if(conf == true){
				calc_all();
				$.ajax({
					url      :"../app_api/accounts/double_exchange.php",
					data     :{'src_id': src_acc, 'dst_id': dst_acc, 'amount': amount, 'notes': notes},
					dataType :"JSON",
					type     :'POST',
					success  :function(data){
						// alert(data[0].balance);
						var res = parseFloat(data[0].balance);
						if(data[0].res == 'success'){
							window.location.replace('acc_coa.php');
						} else {
							alert('GENERAL ERROR, PLEASE CONTACT SUPPORT');
						}
						calc_all();
						end_loader();
					},
					error    :function(){
						alert('Code Not Applied');
					},
				});
				
				
				
				
				
			}
		} else {
			alert(' Source Account And Destination Cannot Be The Same !!!');
		}
	} else {
		alert(' Please Check Your Inputs !!!');
	}
}






function get_acc_amt(acc_id, typo){
	acc_id = parseInt(acc_id);
	start_loader();
	$.ajax({
		url      :"../app_api/accounts/get_account_balance.php",
		data     :{'account_id': acc_id},
		dataType :"JSON",
		type     :'POST',
		success  :function(data){
			// alert(data[0].balance);
			var res = parseFloat(data[0].balance);
			if(typo == 'src'){
				$('#src_org_amt').val(res.toFixed(3));
			} else if(typo == 'dst'){
				$('#dst_org_amt').val(res.toFixed(3));
			}
			calc_all();
			end_loader();
		},
		error    :function(){
			alert('Code Not Applied');
		},
	});
}
</script>
			
			
			
			
	</div>
	
	
	<div class="zero"></div>
</div>





<?php
	//PAGE DATA END   ----------------------------------------------///---------------------------------
	include('app/footer.php');
?>
<script>

</script>
</body>
</html>
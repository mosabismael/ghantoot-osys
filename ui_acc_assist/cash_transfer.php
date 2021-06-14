<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "ACC COA";
	
	$menuId = 1;
	$subPageID = 3;
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
			<th colspan="2"> SOURCE</th>
			<td>&nbsp;</td>
			<th colspan="2"> DESTINATION</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="2">
				<div class="form-grp">
					<select id="acc_src_sel" class="">
						<option value="0" selected=""> Please Select</option>
<?php
	$qu_acc_accounts_sel = "SELECT `account_id`, `account_name` FROM  `acc_accounts` ORDER BY `account_name` ASC";
	$qu_acc_accounts_EXE = mysqli_query($KONN, $qu_acc_accounts_sel);
	if(mysqli_num_rows($qu_acc_accounts_EXE)){
		while($acc_accounts_REC = mysqli_fetch_assoc($qu_acc_accounts_EXE)){
		?>
		<option value="<?=$acc_accounts_REC['account_id']; ?>"><?=$acc_accounts_REC['account_name']; ?></option>
		<?php
		}
	}
?>
						
					</select>
				</div>
			</td>
			<td>&nbsp;</td>
			<td colspan="2">
				<div class="form-grp">
					<select id="acc_des_sel" class="">
						<option value="0" selected=""> Please Select</option>
<?php
	$qu_acc_accounts_sel = "SELECT `account_id`, `account_name` FROM  `acc_accounts` ORDER BY `account_name` ASC";
	$qu_acc_accounts_EXE = mysqli_query($KONN, $qu_acc_accounts_sel);
	if(mysqli_num_rows($qu_acc_accounts_EXE)){
		while($acc_accounts_REC = mysqli_fetch_assoc($qu_acc_accounts_EXE)){
		?>
		<option value="<?=$acc_accounts_REC['account_id']; ?>"><?=$acc_accounts_REC['account_name']; ?></option>
		<?php
		}
	}
?>
					</select>
				</div>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<div class="form-grp">
					<input type="text" id="acc_amount" placeholder="Transaction Amount">
				</div>
			</td>
			<td>&nbsp;</td>
			<td colspan="2">
				<div class="form-grp">
					<label><br></label>
					<textarea id="notes" placeholder="Transaction Notes"></textarea>
				</div>
				
			</td>
		</tr>
	</tbody>
	<thead>
		<tr>
			<th> Original Balance</th>
			<th> New Balance</th>
			<td>&nbsp;</td>
			<th> Original Balance</th>
			<th> New Balance</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><input type="text" id="src_org_amt" class="text-danger" readonly="" disabled="" style="text-align: center;font-size: 26px;"></td>
			<td><input type="text" id="src_dst_amt" class="" readonly="" disabled="" style="text-align: center;font-size: 26px;"></td>
			<td>&nbsp;</td>
			<td><input type="text" id="dst_org_amt" class="text-danger" readonly="" disabled="" style="text-align: center;font-size: 26px;"></td>
			<td><input type="text" id="dst_dst_amt" class="" readonly="" disabled="" style="text-align: center;font-size: 26px;"></td>
		</tr>
		<tr>
			<td class="text-center" colspan="5">
<button onclick="do_exchange();" type="button" class="btn btn-success"><?=lang("Transfer Funds", "sss"); ?></button>

			</td>
		</tr>
	</tbody>
</table>
			







<script>
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




function calc_all(){
	//calc src
	var src_original_amt = parseFloat($('#src_org_amt').val());
	
	var src_new_amt = src_original_amt - amount;
		if(isNaN(src_new_amt)){
			src_new_amt = 0;
		}
	
	$('#src_dst_amt').val(src_new_amt.toFixed(3));
	
	//calc dest
	var dst_original_amt = parseFloat($('#dst_org_amt').val());
	
	var dst_new_amt = dst_original_amt + amount;
		if(isNaN(dst_new_amt)){
			dst_new_amt = 0;
		}
	
	$('#dst_dst_amt').val(dst_new_amt.toFixed(3));
	
	
	
}











$('#acc_src_sel').on('change', function(){
	var tt = $(this).val();
	if(tt != '0'){
		src_acc = tt;
		get_acc_amt(tt, 'src');
	}
});

$('#acc_des_sel').on('change', function(){
	var tt = $(this).val();
	if(tt != '0'){
		dst_acc = tt;
		get_acc_amt(tt, 'dst');
	}
	
});

$('#acc_amount').on('input', function(){
	var tt = $(this).val();
	if(src_acc != 0 && dst_acc != 0){
		if(isNaN(tt)){
			tt = 0;
		}
		amount = parseFloat(tt);
		if(isNaN(amount)){
			amount = 0;
		}
		calc_all();
	}
	
});




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
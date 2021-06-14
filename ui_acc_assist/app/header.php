<?php
	require_once('../z_elements/ui_header.php');
?>

<header>
	<div class="mainMenuNav">
		<div data-ids="0" class="navItem specItem">
			<i class="fas fa-home"></i>
		</div>
		
		<div data-ids="1" class="navItem">
			<span><?=lang("COA", "AAR"); ?></span>
		</div>
		<div data-ids="2" class="navItem">
			<span><?=lang("job_orders", "AAR"); ?></span>
		</div>
		<div data-ids="3" class="navItem">
			<span><?=lang("purchase_orders", "AAR"); ?></span>
		</div>
		<div data-ids="4" class="navItem">
			<span><?=lang("Expenses", "AAR"); ?></span>
		</div>
		<div data-ids="5" class="navItem">
			<span><?=lang("clients", "AAR"); ?></span>
		</div>
		<div data-ids="6" class="navItem">
			<span><?=lang("payrolls", "AAR"); ?></span>
		</div>
		<div data-ids="7" class="navItem">
			<span><?=lang("Reports", "AAR"); ?></span>
		</div>
	</div>
	
	
	<div class="menuSubNav" id="subMenuContainer"></div>
	
</header>

<div id="menuContent-0" style="display:none !important;">
		<a class="<?php if( $subPageID == 1000 ){ echo "activeSub"; } ?>" href="index.php">
			<i class="fas fa-home"></i>
			<span><?=lang("Main", "AAR"); ?></span>
		</a>
		<a class="<?php if( $subPageID == 2000 ){ echo "activeSub"; } ?>" href="z_notifications.php">
			<i class="fas fa-bell"></i>
			<span><?=lang("Notifications", "AAR"); ?></span>
		</a>
		<a class="<?php if( $subPageID == 3000 ){ echo "activeSub"; } ?>" href="logout.php">
			<i class="fas fa-sign-out-alt"></i>
			<span><?=lang("Log_Out", "AAR"); ?></span>
		</a>
</div>

<div id="menuContent-1" style="display:none !important;">
		<a class="<?php if( $subPageID == 1 ){ echo "activeSub"; } ?>" href="acc_coa.php">
			<i class="fas fa-network-wired"></i>
			<span><?=lang("COA", "AAR"); ?></span>
		</a>
		<a class="<?php if( $subPageID == 11 ){ echo "activeSub"; } ?>" href="acc_coa_gomi.php">
			<i class="fas fa-network-wired"></i>
			<span><?=lang("COA_GOMI", "AAR"); ?></span>
		</a>
		<a class="<?php if( $subPageID == 2 ){ echo "activeSub"; } ?>" href="acc_accounts_types.php">
			<i class="fas fa-cubes"></i>
			<span><?=lang("Account_Types", "AAR"); ?></span>
		</a>
		<a class="<?php if( $subPageID == 3 ){ echo "activeSub"; } ?>" href="cash_transfer.php">
			<i class="far fa-file"></i>
			<span><?=lang("Simple_Journal", "AAR"); ?></span>
		</a>
		<a class="<?php if( $subPageID == 4 ){ echo "activeSub"; } ?>" href="cash_transfer_compound.php">
			<i class="far fa-copy"></i>
			<span><?=lang("Compound_Journal", "AAR"); ?></span>
		</a>
		<a class="<?php if( $subPageID == 5 ){ echo "activeSub"; } ?>" href="acc_cycle.php">
			<i class="fas fa-recycle"></i>
			<span><?=lang("All_Transactions", "AAR"); ?></span>
		</a>
</div>

<div id="menuContent-2" style="display:none !important;">
		<a class="<?php if( $subPageID == 6 ){ echo "activeSub"; } ?>" href="job_orders.php">
			<i class="fas fa-list"></i>
			<span><?=lang("Job_Orders", "AAR"); ?></span>
		</a>
</div>

<div id="menuContent-3" style="display:none !important;">
		<a class="<?php if( $subPageID == 7 ){ echo "activeSub"; } ?>" href="purchase_orders.php">
			<i class="far fa-hourglass"></i>
			<span><?=lang("Waiting_Approval", "AAR"); ?></span>
		</a>
		<a class="<?php if( $subPageID == 8 ){ echo "activeSub"; } ?>" href="purchase_orders_all.php">
			<i class="far fa-folder-open"></i>
			<span><?=lang("All", "AAR"); ?></span>
		</a>
</div>

<div id="menuContent-4" style="display:none !important;">
		<a class="<?php if( $subPageID == 9 ){ echo "activeSub"; } ?>" href="suppliers_new.php">
			<i class="fas fa-plus"></i>
			<span><?=lang("Add_New", "AAR"); ?></span>
		</a>
		<a class="<?php if( $subPageID == 10 ){ echo "activeSub"; } ?>" href="suppliers.php">
			<i class="fas fa-truck"></i>
			<span><?=lang("Suppliers_List", "AAR"); ?></span>
		</a>
		<a class="<?php if( $subPageID == 11 ){ echo "activeSub"; } ?>" href="suppliers_new_invoice_01.php">
			<i class="fas fa-file-invoice"></i>
			<span><?=lang("Invoices_Submission", "AAR"); ?></span>
		</a>
		<a class="<?php if( $subPageID == 12 ){ echo "activeSub"; } ?>" href="suppliers_invoices.php">
			<i class="fas fa-money-check-alt"></i>
			<span><?=lang("suppliers_invoices", "AAR"); ?></span>
		</a>
		<a class="<?php if( $subPageID == 13 ){ echo "activeSub"; } ?>" href="suppliers_pay_expense_01.php">
			<i class="fas fa-hand-holding-usd"></i>
			<span><?=lang("Pay_Expense", "AAR"); ?></span>
		</a>
</div>

<div id="menuContent-5" style="display:none !important;">
		<a class="<?php if( $subPageID == 14 ){ echo "activeSub"; } ?>" href="clients_new.php">
			<i class="fas fa-plus"></i>
			<span><?=lang("Add_New", "AAR"); ?></span>
		</a>
		<a class="<?php if( $subPageID == 15 ){ echo "activeSub"; } ?>" href="clients.php">
			<i class="fas fa-users"></i>
			<span><?=lang("clients_List", "AAR"); ?></span>
		</a>
		<a class="<?php if( $subPageID == 16 ){ echo "activeSub"; } ?>" href="clients_invoices.php">
			<i class="fas fa-file-invoice-dollar"></i>
			<span><?=lang("Clients_Invoices", "AAR"); ?></span>
		</a>
		<a class="<?php if( $subPageID == 17 ){ echo "activeSub"; } ?>" href="acc_biling.php">
			<i class="fas fa-dollar-sign"></i>
			<span><?=lang("Biling", "AAR"); ?></span>
		</a>
		<a class="<?php if( $subPageID == 170 ){ echo "activeSub"; } ?>" href="clients_receive_payment.php">
			<i class="fas fa-money-bill-wave"></i>
			<span><?=lang("receive_payment", "AAR"); ?></span>
		</a>
</div>

<div id="menuContent-6" style="display:none !important;">
		<a class="<?php if( $subPageID == 18 ){ echo "activeSub"; } ?>" href="payrolls_new_01.php">
			<i class="fas fa-folder-plus"></i>
			<span><?=lang("Issue_payroll", "AAR"); ?></span>
		</a>
		<a class="<?php if( $subPageID == 181 ){ echo "activeSub"; } ?>" href="payrolls.php">
			<i class="fas fa-hand-holding-usd"></i>
			<span><?=lang("payrolls", "AAR"); ?></span>
		</a>
</div>

<div id="menuContent-7" style="display:none !important;">
		<a class="<?php if( $subPageID == 19 ){ echo "activeSub"; } ?>" href="acc_reports.php">
			<i class="fas fa-globe"></i>
			<span><?=lang("All", "AAR"); ?></span>
		</a>
		<a class="<?php if( $subPageID == 20 ){ echo "activeSub"; } ?>" href="acc_reports.php">
			<i class="fas fa-clipboard-list"></i>
			<span><?=lang("Audit_Log", "AAR"); ?></span>
		</a>
		<a class="<?php if( $subPageID == 21 ){ echo "activeSub"; } ?>" href="report_balance_sheet.php">
			<i class="fas fa-balance-scale"></i>
			<span><?=lang("Balance_Sheet", "AAR"); ?></span>
		</a>
		<a class="<?php if( $subPageID == 22 ){ echo "activeSub"; } ?>" href="acc_reports.php">
			<i class="fas fa-file-image"></i>
			<span><?=lang("Business_Snapshot", "AAR"); ?></span>
		</a>
		<a class="<?php if( $subPageID == 23 ){ echo "activeSub"; } ?>" href="report_Profit_and_Loss_Detail.php">
			<i class="fas fa-hourglass-start"></i>
			<span><?=lang("Profit_and_Loss_Detail", "AAR"); ?></span>
		</a>
		<a class="<?php if( $subPageID == 24 ){ echo "activeSub"; } ?>" href="acc_reports.php">
			<i class="fab fa-black-tie"></i>
			<span><?=lang("Profit_and_Loss_by_Customer", "AAR"); ?></span>
		</a>
		<a class="<?php if( $subPageID == 25 ){ echo "activeSub"; } ?>" href="acc_reports.php">
			<i class="far fa-calendar-alt"></i>
			<span><?=lang("Profit_and_Loss_by_Month", "AAR"); ?></span>
		</a>
		<a class="<?php if( $subPageID == 26 ){ echo "activeSub"; } ?>" href="acc_reports.php">
			<i class="fas fa-cash-register"></i>
			<span><?=lang("Statement_of_Cash_Flows", "AAR"); ?></span>
		</a>
		<a class="<?php if( $subPageID == 27 ){ echo "activeSub"; } ?>" href="acc_reports.php">
			<i class="fas fa-equals"></i>
			<span><?=lang("Statement_of_Changes_in_Equity", "AAR"); ?></span>
		</a>
</div>


<script>
initMnu();
</script>
<article id="article">
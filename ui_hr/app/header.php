<?php
	require_once('../z_elements/ui_header.php');
?>

<header>
	<div class="mainMenuNav">
		<div data-ids="0" class="navItem specItem">
			<i class="fas fa-home"></i>
		</div>
		
		<div data-ids="1" class="navItem">
			<span><?=lang("employees", "AAR"); ?></span>
		</div>
		<div data-ids="2" class="navItem">
			<span><?=lang("allowances", "AAR"); ?></span>
		</div>
		<div data-ids="3" class="navItem">
			<span><?=lang("Leaves", "AAR"); ?></span>
		</div>
		<div data-ids="4" class="navItem">
			<span><?=lang("vacations", "AAR"); ?></span>
		</div>
		<div data-ids="5" class="navItem">
			<span><?=lang("displanary_actions", "AAR"); ?></span>
		</div>
		<div data-ids="6" class="navItem">
			<span><?=lang("deductions", "AAR"); ?></span>
		</div>
		<div data-ids="7" class="navItem">
			<span><?=lang("expired_documents", "AAR"); ?></span>
		</div>
		<div data-ids="8" class="navItem">
			<span><?=lang("Settings", "AAR"); ?></span>
		</div>
		<div data-ids="9" class="navItem">
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
<?php
if( $subPageID == 1 ){
?>
		<a onclick="add_new_employee();">
			<i class="fas fa-user-plus"></i>
			<span><?=lang("Add_New", "AAR"); ?></span>
		</a>
<?php
} else {
?>
		<a href="hr_employees.php?add_new_emp=1">
			<i class="fas fa-user-plus"></i>
			<span><?=lang("Add_New", "AAR"); ?></span>
		</a>
<?php
}
?>
		<a class="<?php if( $subPageID == 1 ){ echo "activeSub"; } ?>" href="hr_employees.php">
			<i class="fas fa-users-cog"></i>
			<span><?=lang("All", "AAR"); ?></span>
		</a>
		<a class="<?php if( $subPageID == 2 ){ echo "activeSub"; } ?>" href="hr_employees_local.php">
			<i class="fas fa-users"></i>
			<span><?=lang("Local_Employees", "AAR"); ?></span>
		</a>
		<a class="<?php if( $subPageID == 3 ){ echo "activeSub"; } ?>" href="hr_employees_hire.php">
			<i class="fas fa-user-tag"></i>
			<span><?=lang("Hired_Employees", "AAR"); ?></span>
		</a>
		<a class="<?php if( $subPageID == 31 ){ echo "activeSub"; } ?>" href="hr_interviews.php">
			<i class="fas fa-user-tie"></i>
			<span><?=lang("Interview_Form", "AAR"); ?></span>
		</a>
</div>


<div id="menuContent-2" style="display:none !important;">
<?php
if( $subPageID == 4 ){
?>
		<a class="activeNew" onclick="add_new_employee_allowance();">
			<i class="fas fa-plus-circle"></i>
			<span><?=lang("new_allowance", "AAR"); ?></span>
		</a>
<?php
} else {
?>
		<a href="hr_allowances.php?add_new=1">
			<i class="fas fa-plus-circle"></i>
			<span><?=lang("new_allowance", "AAR"); ?></span>
		</a>
<?php
}
?>
		<a class="<?php if( $subPageID == 4 ){ echo "activeSub"; } ?>" href="hr_allowances.php">
			<i class="fas fa-list"></i>
			<span><?=lang("Allowances_List", "AAR"); ?></span>
		</a>
</div>

<div id="menuContent-3" style="display:none !important;">
<?php
if( $subPageID == 5 ){
?>
		<a class="activeNew" onclick="add_new_leave_modal();">
			<i class="fas fa-plus-circle"></i>
			<span><?=lang("Add_New", "AAR"); ?></span>
		</a>
<?php
} else {
?>
		<a href="hr_leaves.php?add_new=1">
			<i class="fas fa-plus-circle"></i>
			<span><?=lang("Add_New", "AAR"); ?></span>
		</a>
<?php
}
?>
		<a class="<?php if( $subPageID == 5 ){ echo "activeSub"; } ?>" href="hr_leaves.php">
			<i class="fas fa-list"></i>
			<span><?=lang("Leaves_List", "AAR"); ?></span>
		</a>
</div>

<div id="menuContent-4" style="display:none !important;">
<?php
if( $subPageID == 6 ){
?>
		<a class="activeNew" onclick="add_new_vacation_modal();">
			<i class="fas fa-plus-circle"></i>
			<span><?=lang("Add_New", "AAR"); ?></span>
		</a>
<?php
} else {
?>
		<a href="hr_vacations.php?add_new=1">
			<i class="fas fa-plus-circle"></i>
			<span><?=lang("Add_New", "AAR"); ?></span>
		</a>
<?php
}
?>
		<a class="<?php if( $subPageID == 6 ){ echo "activeSub"; } ?>" href="hr_vacations.php">
			<i class="fas fa-list"></i>
			<span><?=lang("vacations_List", "AAR"); ?></span>
		</a>
</div>

<div id="menuContent-5" style="display:none !important;">
<?php
if( $subPageID == 7 ){
?>
		<a class="activeNew" onclick="add_new_da_modal();">
			<i class="fas fa-plus-circle"></i>
			<span><?=lang("Add_New", "AAR"); ?></span>
		</a>
<?php
} else {
?>
		<a href="hr_disp_act.php?add_new=1">
			<i class="fas fa-plus-circle"></i>
			<span><?=lang("Add_New", "AAR"); ?></span>
		</a>
<?php
}
?>
		<a class="<?php if( $subPageID == 7 ){ echo "activeSub"; } ?>" href="hr_disp_act.php">
			<i class="fas fa-list"></i>
			<span><?=lang("DA_List", "AAR"); ?></span>
		</a>
</div>

<div id="menuContent-6" style="display:none !important;">
<?php
if( $subPageID == 8 ){
?>
		<a class="activeNew" onclick="add_new_employee_deduction();">
			<i class="fas fa-plus-circle"></i>
			<span><?=lang("Add_New", "AAR"); ?></span>
		</a>
<?php
} else {
?>
		<a href="hr_deductions.php?add_new=1">
			<i class="fas fa-plus-circle"></i>
			<span><?=lang("Add_New", "AAR"); ?></span>
		</a>
<?php
}
?>
		<a class="<?php if( $subPageID == 8 ){ echo "activeSub"; } ?>" href="hr_deductions.php">
			<i class="fas fa-list"></i>
			<span><?=lang("Deductions_List", "AAR"); ?></span>
		</a>
</div>

<div id="menuContent-7" style="display:none !important;">
		<a class="<?php if( $subPageID == 9 ){ echo "activeSub"; } ?>" href="hr_exp_docs.php">
			<i class="fas fa-list"></i>
			<span><?=lang("Expired_Documents", "AAR"); ?></span>
		</a>
</div>

<div id="menuContent-8" style="display:none !important;">
	<a class="<?php if( $subPageID == 10 ){ echo "activeSub"; } ?>" href="work_timing.php">
		<i class="far fa-clock"></i>
		<span><?=lang("work_timing", "AAR"); ?></span>
	</a>

	<a class="<?php if( $subPageID == 11 ){ echo "activeSub"; } ?>" href="employees_ts.php">
		<i class="fas fa-calendar-alt"></i>
		<span><?=lang("Employees_Timesheets", "AAR"); ?></span>
	</a>

	<a class="<?php if( $subPageID == 111 ){ echo "activeSub"; } ?>" href="employees_ts_details.php">
		<i class="fas fa-calendar-alt"></i>
		<span><?=lang("Timesheets_Report", "AAR"); ?></span>
	</a>

	<a class="<?php if( $subPageID == 12 ){ echo "activeSub"; } ?>" href="hr_disp_actions.php">
		<i class="fas fa-exclamation-triangle"></i>
		<span><?=lang("Displinary_Actions", "AAR"); ?></span>
	</a>

	<a class="<?php if( $subPageID == 13 ){ echo "activeSub"; } ?>" href="departments.php">
		<i class="fas fa-cube"></i>
		<span><?=lang("Departments", "AAR"); ?></span>
	</a>

	<a class="<?php if( $subPageID == 14 ){ echo "activeSub"; } ?>" href="departments_designations.php">
		<i class="fas fa-cubes"></i>
		<span><?=lang("Designations", "AAR"); ?></span>
	</a>
</div>

<div id="menuContent-9" style="display:none !important;">
	<a class="<?php if( $subPageID == 15 ){ echo "activeSub"; } ?>" href="employees_ts_details.php">
		<i class="fas fa-calendar-alt"></i>
		<span><?=lang("Timesheets_Report", "AAR"); ?></span>
	</a>
	<a class="<?php if( $subPageID == 16 ){ echo "activeSub"; } ?>" href="hr_employees_profile.php">
		<i class="fas fa-calendar-alt"></i>
		<span><?=lang("Employee_Details", "AAR"); ?></span>
	</a>
</div>




<script>
initMnu();
</script>
<article id="article">
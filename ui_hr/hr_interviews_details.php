<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "Time Tables";
	
	$menuId = 1;
	$subPageID = 31;
	

	
	$interview_id = 0;
	if( !isset( $_GET['interview_id'] ) ){
		header("location:hr_interviews.php");
	} else {
		$interview_id = (int) test_inputs( $_GET['interview_id'] );
	}
	
	
	$qu_hr_interviews_sel = "SELECT * FROM  `hr_interviews` WHERE `interview_id` = $interview_id";
	$qu_hr_interviews_EXE = mysqli_query($KONN, $qu_hr_interviews_sel);
	$hr_interviews_DATA;
	if(mysqli_num_rows($qu_hr_interviews_EXE)){
		$hr_interviews_DATA = mysqli_fetch_assoc($qu_hr_interviews_EXE);
	} else {
		header("location:hr_interviews.php");
	}
		$interview_id = $hr_interviews_DATA['interview_id'];
		$candidate_name = $hr_interviews_DATA['candidate_name'];
		$candidate_age = $hr_interviews_DATA['candidate_age'];
		$candidate_gender = $hr_interviews_DATA['candidate_gender'];
		$candidate_nationality = $hr_interviews_DATA['candidate_nationality'];
		$candidate_religion = $hr_interviews_DATA['candidate_religion'];
		$candidate_education = $hr_interviews_DATA['candidate_education'];
		$candidate_last_employer = $hr_interviews_DATA['candidate_last_employer'];
		$candidate_last_salary = $hr_interviews_DATA['candidate_last_salary'];
		$candidate_last_designation = $hr_interviews_DATA['candidate_last_designation'];
		$job_title = $hr_interviews_DATA['job_title'];
		$total_experience = $hr_interviews_DATA['total_experience'];
		$notice_period = $hr_interviews_DATA['notice_period'];
		$personal_hygiene = $hr_interviews_DATA['personal_hygiene'];
		$body_language = $hr_interviews_DATA['body_language'];
		$eye_contact = $hr_interviews_DATA['eye_contact'];
		$team_work = $hr_interviews_DATA['team_work'];
		$leadership_qualities = $hr_interviews_DATA['leadership_qualities'];
		$financial_planning = $hr_interviews_DATA['financial_planning'];
		$communication_skills = $hr_interviews_DATA['communication_skills'];
		$customer_service_skills = $hr_interviews_DATA['customer_service_skills'];
		$realistic_appraisal = $hr_interviews_DATA['realistic_appraisal'];
		$reason_interest = $hr_interviews_DATA['reason_interest'];
		$career_goals = $hr_interviews_DATA['career_goals'];
		$academic_brilliance = $hr_interviews_DATA['academic_brilliance'];
		$professional_knowledge = $hr_interviews_DATA['professional_knowledge'];
		$computer_proficiency = $hr_interviews_DATA['computer_proficiency'];
		$knowledge_position = $hr_interviews_DATA['knowledge_position'];
		$overall_evaluation = $hr_interviews_DATA['overall_evaluation'];
		$additional_comments = $hr_interviews_DATA['additional_comments'];
		$created_date = $hr_interviews_DATA['created_date'];
		$created_by = $hr_interviews_DATA['created_by'];

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
		<form action="hr_interviews_new.php" method="POST">
			
			<div class="row col-100">
				<div class="nwFormGroup">
					<h1 style="width:100%;text-align:left;"><?=lang("Candidate_General_Information :", "AAR"); ?><hr></h1>
					
				</div>
				<div class="zero"></div>
			</div>
			
			<div class="row col-50">
				<div class="nwFormGroup">
					<label><?=lang("candidate_name:", "AAR"); ?></label>
					<h4><?=$candidate_name; ?></h4>
				</div>
				<div class="zero"></div>
			</div>
			
		
			<div class="row col-50">
				<div class="nwFormGroup">
					<label><?=lang("job_title:", "AAR"); ?></label>
					<h4><?=$job_title; ?></h4>
				</div>
				<div class="zero"></div>
			</div>
			
		
			<div class="row col-50">
				<div class="nwFormGroup">
					<label><?=lang("candidate_education:", "AAR"); ?></label>
					<h4><?=$candidate_education; ?></h4>
				</div>
				<div class="zero"></div>
			</div>
			
		
			<div class="row col-50">
				<div class="nwFormGroup">
					<label><?=lang("total_experience:", "AAR"); ?></label>
					<h4><?=$total_experience; ?></h4>
				</div>
				<div class="zero"></div>
			</div>
			
		
			<div class="row col-50">
				<div class="nwFormGroup">
					<label><?=lang("current/last_employer:", "AAR"); ?></label>
					<h4><?=$candidate_last_employer; ?></h4>
				</div>
				<div class="zero"></div>
			</div>
			
		
			<div class="row col-50">
				<div class="nwFormGroup">
					<label><?=lang("current/last_designation:", "AAR"); ?></label>
					<h4><?=$candidate_last_designation; ?></h4>
				</div>
				<div class="zero"></div>
			</div>
			
		
			<div class="row col-50">
				<div class="nwFormGroup">
					<label><?=lang("current/last_salary:", "AAR"); ?></label>
					<h4><?=$candidate_last_salary; ?></h4>
				</div>
				<div class="zero"></div>
			</div>
			
		
			<div class="row col-50">
				<div class="nwFormGroup">
					<label><?=lang("notice_period:", "AAR"); ?></label>
					<h4><?=$notice_period; ?></h4>
				</div>
				<div class="zero"></div>
			</div>
			
			<div class="row col-100">
				<div class="nwFormGroup">
					<h1 style="width:100%;text-align:left;"><?=lang("Candidate_Details :", "AAR"); ?><hr></h1>
					
				</div>
				<div class="zero"></div>
			</div>
		
			<div class="row col-50">
				<div class="nwFormGroup">
					<label><?=lang("gender:", "AAR"); ?></label>
					<h4><?=$candidate_gender; ?></h4>
				</div>
				<div class="zero"></div>
			</div>

		
			<div class="row col-50">
				<div class="nwFormGroup">
					<label><?=lang("nationality:", "AAR"); ?></label>
					<h4><?=$candidate_nationality; ?></h4>
				</div>
				<div class="zero"></div>
			</div>

				<div class="zero"></div>
		
			<div class="row col-50">
				<div class="nwFormGroup">
					<label><?=lang("age:", "AAR"); ?></label>
					<h4><?=$candidate_age; ?></h4>
				</div>
				<div class="zero"></div>
			</div>

		
			<div class="row col-50">
				<div class="nwFormGroup">
					<label><?=lang("religion:", "AAR"); ?></label>
					<h4><?=$candidate_religion; ?></h4>
				</div>
				<div class="zero"></div>
			</div>
			
			<div class="row col-100">
				<div class="nwFormGroup">
					<h1 style="width:100%;text-align:left;"><?=lang("Candidate_Competency : 1- ATITUDE :", "AAR"); ?><hr></h1>
				</div>
				<div class="zero"></div>
			</div>
		
			<div class="zero"></div>
<div class="row col-100">
	<table class="tabler">
		<tr>
			<td style="width: 50%;">
<div class="nwFormGroup">
	<label><?=lang("POINT", "AAR"); ?></label>
</div>
			</td>
			<td>
<div class="nwFormGroup">
	<label><?=lang("SCORE", "AAR"); ?></label>
</div>
			</td>
		</tr>
		
		<tr>
			<td style="width: 50%;">
<div class="nwFormGroup">
	<label style="width:100%;"><?=lang("Personal_hygiene:", "AAR"); ?></label>
</div>
			</td>
			<td>
<div class="nwFormGroup">
					<h4><?=$personal_hygiene; ?></h4>
</div>
<div class="zero"></div>
			</td>
		</tr>
		
		<tr>
			<td style="width: 50%;">
<div class="nwFormGroup">
	<label style="width:100%;"><?=lang("body_language:", "AAR"); ?></label>
</div>
			</td>
			<td>
<div class="nwFormGroup">
					<h4><?=$body_language; ?></h4>
</div>
<div class="zero"></div>
			</td>
		</tr>
		
		<tr>
			<td style="width: 50%;">
<div class="nwFormGroup">
	<label style="width:100%;"><?=lang("eye_contact:", "AAR"); ?></label>
</div>
			</td>
			<td>
<div class="nwFormGroup">
					<h4><?=$eye_contact; ?></h4>
</div>
<div class="zero"></div>
			</td>
		</tr>
		
		<tr>
			<td style="width: 50%;">
<div class="nwFormGroup">
	<label style="width:100%;"><?=lang("liking_toward_team_work:", "AAR"); ?></label>
</div>
			</td>
			<td>
<div class="nwFormGroup">
					<h4><?=$team_work; ?></h4>
</div>
<div class="zero"></div>
			</td>
		</tr>
		
		<tr>
			<td style="width: 50%;">
<div class="nwFormGroup">
	<label style="width:100%;"><?=lang("leadership_qualities:", "AAR"); ?></label>
</div>
			</td>
			<td>
<div class="nwFormGroup">
					<h4><?=$leadership_qualities; ?></h4>
</div>
<div class="zero"></div>
			</td>
		</tr>
		
		<tr>
			<td style="width: 50%;">
<div class="nwFormGroup">
	<label style="width:100%;"><?=lang("financial_planning, staff supervision, management of resources:", "AAR"); ?></label>
</div>
			</td>
			<td>
<div class="nwFormGroup">
					<h4><?=$financial_planning; ?></h4>
</div>
<div class="zero"></div>
			</td>
		</tr>
		
		<tr>
			<td style="width: 50%;">
<div class="nwFormGroup">
	<label style="width:100%;"><?=lang("communication_skills:", "AAR"); ?></label>
</div>
			</td>
			<td>
<div class="nwFormGroup">
					<h4><?=$communication_skills; ?></h4>
</div>
<div class="zero"></div>
			</td>
		</tr>
		
		<tr>
			<td style="width: 50%;">
<div class="nwFormGroup">
	<label style="width:100%;"><?=lang("customer_service_skills:", "AAR"); ?></label>
</div>
			</td>
			<td>
<div class="nwFormGroup">
					<h4><?=$customer_service_skills; ?></h4>
</div>
<div class="zero"></div>
			</td>
		</tr>
		
	</table>
	<div class="zero"></div>
</div>

			
			<div class="row col-100">
				<div class="nwFormGroup">
					<h1 style="width:100%;text-align:left;"><?=lang("Candidate_Competency : 2- GOALS/PERCEPTION OF SELF :", "AAR"); ?><hr></h1>
				</div>
				<div class="zero"></div>
			</div>
			<div class="zero"></div>
<div class="row col-100">
	<table class="tabler">
		<tr>
			<td style="width: 50%;">
<div class="nwFormGroup">
	<label><?=lang("POINT", "AAR"); ?></label>
</div>
			</td>
			<td>
<div class="nwFormGroup">
	<label><?=lang("SCORE", "AAR"); ?></label>
</div>
			</td>
		</tr>
		
		<tr>
			<td style="width: 50%;">
<div class="nwFormGroup">
	<label style="width:100%;"><?=lang("realistic_appraisal of self:", "AAR"); ?></label>
</div>
			</td>
			<td>
<div class="nwFormGroup">
					<h4><?=$realistic_appraisal; ?></h4>
</div>
<div class="zero"></div>
			</td>
		</tr>
		
		<tr>
			<td style="width: 50%;">
<div class="nwFormGroup">
	<label style="width:100%;"><?=lang("reason_for_interest_in_field:", "AAR"); ?></label>
</div>
			</td>
			<td>
<div class="nwFormGroup">
					<h4><?=$reason_interest; ?></h4>
</div>
<div class="zero"></div>
			</td>
		</tr>
		
		<tr>
			<td style="width: 50%;">
<div class="nwFormGroup">
	<label style="width:100%;"><?=lang("realistic_career_goals:", "AAR"); ?></label>
</div>
			</td>
			<td>
<div class="nwFormGroup">
					<h4><?=$career_goals; ?></h4>
</div>
<div class="zero"></div>
			</td>
		</tr>
		
	</table>
	<div class="zero"></div>
</div>

			
			<div class="row col-100">
				<div class="nwFormGroup">
					<h1 style="width:100%;text-align:left;"><?=lang("Candidate_Competency : 3- KNOWLEDGE TRAITS :", "AAR"); ?><hr></h1>
				</div>
				<div class="zero"></div>
			</div>
			<div class="zero"></div>
<div class="row col-100">
	<table class="tabler">
		<tr>
			<td style="width: 50%;">
<div class="nwFormGroup">
	<label><?=lang("POINT", "AAR"); ?></label>
</div>
			</td>
			<td>
<div class="nwFormGroup">
	<label><?=lang("SCORE", "AAR"); ?></label>
</div>
			</td>
		</tr>
		
		<tr>
			<td style="width: 50%;">
<div class="nwFormGroup">
	<label style="width:100%;"><?=lang("academic_brilliance:", "AAR"); ?></label>
</div>
			</td>
			<td>
<div class="nwFormGroup">
					<h4><?=$academic_brilliance; ?></h4>
</div>
<div class="zero"></div>
			</td>
		</tr>
		
		<tr>
			<td style="width: 50%;">
<div class="nwFormGroup">
	<label style="width:100%;"><?=lang("professional_knowledge:", "AAR"); ?></label>
</div>
			</td>
			<td>
<div class="nwFormGroup">
					<h4><?=$professional_knowledge; ?></h4>
</div>
<div class="zero"></div>
			</td>
		</tr>
		
		<tr>
			<td style="width: 50%;">
<div class="nwFormGroup">
	<label style="width:100%;"><?=lang("computer_proficiency:", "AAR"); ?></label>
</div>
			</td>
			<td>
<div class="nwFormGroup">
					<h4><?=$computer_proficiency; ?></h4>
</div>
<div class="zero"></div>
			</td>
		</tr>
		
		<tr>
			<td style="width: 50%;">
<div class="nwFormGroup">
	<label style="width:100%;"><?=lang("product/field knowledge for the position:", "AAR"); ?></label>
</div>
			</td>
			<td>
<div class="nwFormGroup">
					<h4><?=$knowledge_position; ?></h4>
</div>
<div class="zero"></div>
			</td>
		</tr>
		
	</table>
	<div class="zero"></div>
</div>

			
			<div class="row col-100">
				<div class="nwFormGroup">
					<h1 style="width:100%;text-align:left;"><?=lang("Candidate_Competency : 4- OVERALL :", "AAR"); ?><hr></h1>
				</div>
				<div class="zero"></div>
			</div>
			<div class="zero"></div>
<div class="row col-100">
	<table class="tabler">
		<tr>
			<td style="width: 50%;">
<div class="nwFormGroup">
	<label><?=lang("POINT", "AAR"); ?></label>
</div>
			</td>
			<td>
<div class="nwFormGroup">
	<label><?=lang("SCORE", "AAR"); ?></label>
</div>
			</td>
		</tr>
		
		<tr>
			<td style="width: 50%;">
<div class="nwFormGroup">
	<label style="width:100%;"><?=lang("overall_evaluation:", "AAR"); ?></label>
</div>
			</td>
			<td>
<div class="nwFormGroup">
					<h4><?=$overall_evaluation; ?></h4>
</div>
<div class="zero"></div>
			</td>
		</tr>
		
	</table>
	<div class="zero"></div>
</div>

<div class="row col-100">
	<div class="nwFormGroup">
		<label><?=lang("additional_comments:", "AAR"); ?></label>
		<h4><?=$additional_comments; ?></h4>
	</div>
	<div class="zero"></div>
</div>

<div class="viewerBodyButtons">
		<a href="hr_interviews.php"><button type="button">
			<?=lang('Back', 'ARR', 1); ?>
		</button></a>
</div>
			
		</form>
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
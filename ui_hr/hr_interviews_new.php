<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "Time Tables";
	
	$menuId = 1;
	$subPageID = 31;
	
	
if( isset($_POST['candidate_name']) &&
	isset($_POST['candidate_age']) &&
	isset($_POST['candidate_gender']) &&
	isset($_POST['candidate_nationality']) &&
	isset($_POST['candidate_religion']) &&
	isset($_POST['candidate_education']) &&
	isset($_POST['candidate_last_employer']) &&
	isset($_POST['candidate_last_salary']) &&
	isset($_POST['candidate_last_designation']) &&
	isset($_POST['job_title']) &&
	isset($_POST['total_experience']) &&
	isset($_POST['notice_period']) &&
	isset($_POST['personal_hygiene']) &&
	isset($_POST['body_language']) &&
	isset($_POST['eye_contact']) &&
	isset($_POST['team_work']) &&
	isset($_POST['leadership_qualities']) &&
	isset($_POST['financial_planning']) &&
	isset($_POST['communication_skills']) &&
	isset($_POST['customer_service_skills']) &&
	isset($_POST['realistic_appraisal']) &&
	isset($_POST['reason_interest']) &&
	isset($_POST['career_goals']) &&
	isset($_POST['academic_brilliance']) &&
	isset($_POST['professional_knowledge']) &&
	isset($_POST['computer_proficiency']) &&
	isset($_POST['knowledge_position']) &&
	isset($_POST['overall_evaluation']) &&
	isset($_POST['additional_comments']) 
	){

	$interview_id = 0;
	$candidate_name = test_inputs($_POST['candidate_name']);
	$candidate_age = test_inputs($_POST['candidate_age']);
	$candidate_gender = test_inputs($_POST['candidate_gender']);
	$candidate_nationality = test_inputs($_POST['candidate_nationality']);
	$candidate_religion = test_inputs($_POST['candidate_religion']);
	$candidate_education = test_inputs($_POST['candidate_education']);
	$candidate_last_employer = test_inputs($_POST['candidate_last_employer']);
	$candidate_last_salary = test_inputs($_POST['candidate_last_salary']);
	$candidate_last_designation = test_inputs($_POST['candidate_last_designation']);
	$job_title = test_inputs($_POST['job_title']);
	$total_experience = test_inputs($_POST['total_experience']);
	$notice_period = test_inputs($_POST['notice_period']);
	$personal_hygiene = test_inputs($_POST['personal_hygiene']);
	$body_language = test_inputs($_POST['body_language']);
	$eye_contact = test_inputs($_POST['eye_contact']);
	$team_work = test_inputs($_POST['team_work']);
	$leadership_qualities = test_inputs($_POST['leadership_qualities']);
	$financial_planning = test_inputs($_POST['financial_planning']);
	$communication_skills = test_inputs($_POST['communication_skills']);
	$customer_service_skills = test_inputs($_POST['customer_service_skills']);
	$realistic_appraisal = test_inputs($_POST['realistic_appraisal']);
	$reason_interest = test_inputs($_POST['reason_interest']);
	$career_goals = test_inputs($_POST['career_goals']);
	$academic_brilliance = test_inputs($_POST['academic_brilliance']);
	$professional_knowledge = test_inputs($_POST['professional_knowledge']);
	$computer_proficiency = test_inputs($_POST['computer_proficiency']);
	$knowledge_position = test_inputs($_POST['knowledge_position']);
	$overall_evaluation = test_inputs($_POST['overall_evaluation']);
	$additional_comments = test_inputs($_POST['additional_comments']);
	$created_date = date('Y-m-d');
	$created_by = $EMPLOYEE_ID;

	$qu_hr_interviews_ins = "INSERT INTO `hr_interviews` (
						`candidate_name`, 
						`candidate_age`, 
						`candidate_gender`, 
						`candidate_nationality`, 
						`candidate_religion`, 
						`candidate_education`, 
						`candidate_last_employer`, 
						`candidate_last_salary`, 
						`candidate_last_designation`, 
						`job_title`, 
						`total_experience`, 
						`notice_period`, 
						`personal_hygiene`, 
						`body_language`, 
						`eye_contact`, 
						`team_work`, 
						`leadership_qualities`, 
						`financial_planning`, 
						`communication_skills`, 
						`customer_service_skills`, 
						`realistic_appraisal`, 
						`reason_interest`, 
						`career_goals`, 
						`academic_brilliance`, 
						`professional_knowledge`, 
						`computer_proficiency`, 
						`knowledge_position`, 
						`overall_evaluation`, 
						`additional_comments`, 
						`created_date`, 
						`created_by` 
					) VALUES (
						'".$candidate_name."', 
						'".$candidate_age."', 
						'".$candidate_gender."', 
						'".$candidate_nationality."', 
						'".$candidate_religion."', 
						'".$candidate_education."', 
						'".$candidate_last_employer."', 
						'".$candidate_last_salary."', 
						'".$candidate_last_designation."', 
						'".$job_title."', 
						'".$total_experience."', 
						'".$notice_period."', 
						'".$personal_hygiene."', 
						'".$body_language."', 
						'".$eye_contact."', 
						'".$team_work."', 
						'".$leadership_qualities."', 
						'".$financial_planning."', 
						'".$communication_skills."', 
						'".$customer_service_skills."', 
						'".$realistic_appraisal."', 
						'".$reason_interest."', 
						'".$career_goals."', 
						'".$academic_brilliance."', 
						'".$professional_knowledge."', 
						'".$computer_proficiency."', 
						'".$knowledge_position."', 
						'".$overall_evaluation."', 
						'".$additional_comments."', 
						'".$created_date."', 
						'".$created_by."' 
					);";

	if(mysqli_query($KONN, $qu_hr_interviews_ins)){
		$interview_id = mysqli_insert_id($KONN);
		if( $interview_id != 0 ){
			header( "location:hr_interviews.php?added" );
		}
	}

}

	
	
	
		
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
					<input type="text" class="frmData" id="new-candidate_name" name="candidate_name" required>
				</div>
				<div class="zero"></div>
			</div>
			
		
			<div class="row col-50">
				<div class="nwFormGroup">
					<label><?=lang("job_title:", "AAR"); ?></label>
					<input type="text" class="frmData" id="new-job_title" name="job_title" required>
				</div>
				<div class="zero"></div>
			</div>
			
		
			<div class="row col-50">
				<div class="nwFormGroup">
					<label><?=lang("candidate_education:", "AAR"); ?></label>
					<input type="text" class="frmData" id="new-candidate_education" name="candidate_education" required>
				</div>
				<div class="zero"></div>
			</div>
			
		
			<div class="row col-50">
				<div class="nwFormGroup">
					<label><?=lang("total_experience:", "AAR"); ?></label>
					<input type="text" class="frmData" id="new-total_experience" name="total_experience" required>
				</div>
				<div class="zero"></div>
			</div>
			
		
			<div class="row col-50">
				<div class="nwFormGroup">
					<label><?=lang("current/last_employer:", "AAR"); ?></label>
					<input type="text" class="frmData" id="new-candidate_last_employer" name="candidate_last_employer" required>
				</div>
				<div class="zero"></div>
			</div>
			
		
			<div class="row col-50">
				<div class="nwFormGroup">
					<label><?=lang("current/last_designation:", "AAR"); ?></label>
					<input type="text" class="frmData" id="new-candidate_last_designation" name="candidate_last_designation" required>
				</div>
				<div class="zero"></div>
			</div>
			
		
			<div class="row col-50">
				<div class="nwFormGroup">
					<label><?=lang("current/last_salary:", "AAR"); ?></label>
					<input type="text" class="frmData" id="new-candidate_last_salary" name="candidate_last_salary" required>
				</div>
				<div class="zero"></div>
			</div>
			
		
			<div class="row col-50">
				<div class="nwFormGroup">
					<label><?=lang("notice_period:", "AAR"); ?></label>
					<input type="text" class="frmData" id="new-notice_period" name="notice_period" required>
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
					<select class="frmData" id="new-candidate_gender" name="candidate_gender" required>
						<option value="0" selected disabled>Please Select</option>
						<option value="male">Male</option>
						<option value="female">Female</option>
					</select>
				</div>
				<div class="zero"></div>
			</div>

		
			<div class="row col-50">
				<div class="nwFormGroup">
					<label><?=lang("nationality:", "AAR"); ?></label>
					<input type="text" class="frmData" id="new-candidate_nationality" name="candidate_nationality" required>
				</div>
				<div class="zero"></div>
			</div>

				<div class="zero"></div>
		
			<div class="row col-50">
				<div class="nwFormGroup">
					<label><?=lang("age:", "AAR"); ?></label>
					<input type="number" class="frmData" id="new-candidate_age" name="candidate_age" required>
				</div>
				<div class="zero"></div>
			</div>

		
			<div class="row col-50">
				<div class="nwFormGroup">
					<label><?=lang("religion:", "AAR"); ?></label>
					<input type="text" class="frmData" id="new-candidate_religion" name="candidate_religion" required>
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
	<select class="frmData" id="new-personal_hygiene" name="personal_hygiene" required>
		<option value="0" selected disabled>Please Select</option>
		<option value="poor">Poor</option>
		<option value="fair">Fair</option>
		<option value="average">Average</option>
		<option value="good">Good</option>
		<option value="superior">Superior</option>
	</select>
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
	<select class="frmData" id="new-body_language" name="body_language" required>
		<option value="0" selected disabled>Please Select</option>
		<option value="poor">Poor</option>
		<option value="fair">Fair</option>
		<option value="average">Average</option>
		<option value="good">Good</option>
		<option value="superior">Superior</option>
	</select>
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
	<select class="frmData" id="new-eye_contact" name="eye_contact" required>
		<option value="0" selected disabled>Please Select</option>
		<option value="poor">Poor</option>
		<option value="fair">Fair</option>
		<option value="average">Average</option>
		<option value="good">Good</option>
		<option value="superior">Superior</option>
	</select>
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
	<select class="frmData" id="new-team_work" name="team_work" required>
		<option value="0" selected disabled>Please Select</option>
		<option value="poor">Poor</option>
		<option value="fair">Fair</option>
		<option value="average">Average</option>
		<option value="good">Good</option>
		<option value="superior">Superior</option>
	</select>
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
	<select class="frmData" id="new-leadership_qualities" name="leadership_qualities" required>
		<option value="0" selected disabled>Please Select</option>
		<option value="poor">Poor</option>
		<option value="fair">Fair</option>
		<option value="average">Average</option>
		<option value="good">Good</option>
		<option value="superior">Superior</option>
	</select>
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
	<select class="frmData" id="new-financial_planning" name="financial_planning" required>
		<option value="0" selected disabled>Please Select</option>
		<option value="poor">Poor</option>
		<option value="fair">Fair</option>
		<option value="average">Average</option>
		<option value="good">Good</option>
		<option value="superior">Superior</option>
	</select>
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
	<select class="frmData" id="new-communication_skills" name="communication_skills" required>
		<option value="0" selected disabled>Please Select</option>
		<option value="poor">Poor</option>
		<option value="fair">Fair</option>
		<option value="average">Average</option>
		<option value="good">Good</option>
		<option value="superior">Superior</option>
	</select>
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
	<select class="frmData" id="new-customer_service_skills" name="customer_service_skills" required>
		<option value="0" selected disabled>Please Select</option>
		<option value="poor">Poor</option>
		<option value="fair">Fair</option>
		<option value="average">Average</option>
		<option value="good">Good</option>
		<option value="superior">Superior</option>
	</select>
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
	<select class="frmData" id="new-realistic_appraisal" name="realistic_appraisal" required>
		<option value="0" selected disabled>Please Select</option>
		<option value="poor">Poor</option>
		<option value="fair">Fair</option>
		<option value="average">Average</option>
		<option value="good">Good</option>
		<option value="superior">Superior</option>
	</select>
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
	<select class="frmData" id="new-reason_interest" name="reason_interest" required>
		<option value="0" selected disabled>Please Select</option>
		<option value="poor">Poor</option>
		<option value="fair">Fair</option>
		<option value="average">Average</option>
		<option value="good">Good</option>
		<option value="superior">Superior</option>
	</select>
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
	<select class="frmData" id="new-career_goals" name="career_goals" required>
		<option value="0" selected disabled>Please Select</option>
		<option value="poor">Poor</option>
		<option value="fair">Fair</option>
		<option value="average">Average</option>
		<option value="good">Good</option>
		<option value="superior">Superior</option>
	</select>
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
	<select class="frmData" id="new-academic_brilliance" name="academic_brilliance" required>
		<option value="0" selected disabled>Please Select</option>
		<option value="poor">Poor</option>
		<option value="fair">Fair</option>
		<option value="average">Average</option>
		<option value="good">Good</option>
		<option value="superior">Superior</option>
	</select>
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
	<select class="frmData" id="new-professional_knowledge" name="professional_knowledge" required>
		<option value="0" selected disabled>Please Select</option>
		<option value="poor">Poor</option>
		<option value="fair">Fair</option>
		<option value="average">Average</option>
		<option value="good">Good</option>
		<option value="superior">Superior</option>
	</select>
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
	<select class="frmData" id="new-computer_proficiency" name="computer_proficiency" required>
		<option value="0" selected disabled>Please Select</option>
		<option value="poor">Poor</option>
		<option value="fair">Fair</option>
		<option value="average">Average</option>
		<option value="good">Good</option>
		<option value="superior">Superior</option>
	</select>
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
	<select class="frmData" id="new-knowledge_position" name="knowledge_position" required>
		<option value="0" selected disabled>Please Select</option>
		<option value="poor">Poor</option>
		<option value="fair">Fair</option>
		<option value="average">Average</option>
		<option value="good">Good</option>
		<option value="superior">Superior</option>
	</select>
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
	<select class="frmData" id="new-overall_evaluation" name="overall_evaluation" required>
		<option value="0" selected disabled>Please Select</option>
		<option value="poor">Poor</option>
		<option value="fair">Fair</option>
		<option value="average">Average</option>
		<option value="good">Good</option>
		<option value="superior">Superior</option>
	</select>
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
		<textarea class="frmData" id="new-additional_comments" name="additional_comments" required></textarea>
	</div>
	<div class="zero"></div>
</div>

<div class="viewerBodyButtons">
		<a href="hr_interviews.php"><button type="button">
			<?=lang('Cancel', 'ARR', 1); ?>
		</button></a>
		<button type="submit">
			<?=lang('Next', 'ARR', 1); ?>
		</button>
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
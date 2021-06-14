<?php
	
	//page settings
	$no_session = false;
	$main_pointer = '';
	$main_pointer = '../../';
	require_once($main_pointer.'bootstrap/app_config.php');
	require_once($main_pointer.'bootstrap/chk_log_user.php');
	try{
		if( isset($_POST['day']) &&
		isset($_POST['month']) &&
		isset($_POST['year'])
		){
			
			$event_date = "";
			$day = (int) test_inputs($_POST['day']);
			$month = (int) test_inputs($_POST['month']);
			$year = (int) test_inputs($_POST['year']);
			
			
			$event_dateStart = $year.'-'.$month.'-'.$day.' 00:00:00';
			$event_dateEnd = $year.'-'.$month.'-'.$day.' 23:59:59';
			
			
			$qu_gen_events_sel = "SELECT * FROM  `gen_events` WHERE 
			`event_date` >= '$event_dateStart' AND 
			`event_date` <= '$event_dateEnd' ORDER BY `event_date` ASC";
			$userStatement = mysqli_prepare($KONN,$qu_gen_events_sel);
			mysqli_stmt_execute($userStatement);
			$qu_gen_events_EXE = mysqli_stmt_get_result($userStatement);
			if(mysqli_num_rows($qu_gen_events_EXE)){
				$tot_apps = 0;
				while($gen_events_REC = mysqli_fetch_assoc($qu_gen_events_EXE)){
					$tot_apps++;
					$event_id = $gen_events_REC['event_id'];
					$event_title = $gen_events_REC['event_title'];
					$notes = $gen_events_REC['notes'];
					
					
					
					$appointmentDateTime = $gen_events_REC['event_date'];
					$appointmentDateTime_arr = explode(' ', $appointmentDateTime);
					
					$appointmentDate = $appointmentDateTime_arr[0];
					$appointmentTime = $appointmentDateTime_arr[1];
					$stt = '';
				?>
				<tr id="app-<?=$event_id; ?>" onclick="show_app_details(<?=$event_id; ?>);"
				app-title="<?=$event_title; ?>"
				app-time="<?=$appointmentTime; ?>"
				app-notes="<?=$notes; ?>"
				>
					<td><?=$tot_apps; ?></td>
					<td><?=$appointmentTime; ?></td>
					<td><?=$event_title; ?></td>
				</tr>
				<?php
				}
				} else {
			?>
			<tr>
				<td colspan="5">No Events Found</td>
			</tr>
			<?php
			}
			
			
			
			
			//send data about rest of month
		?>
		<script>
			<?php
				$monthStart = $year.'-'.$month.'-1 00:00:00';
				$monthEnd = $year.'-'.$month.'-31 23:59:59';
				
				$qu_gen_events_sel = "SELECT * FROM  `gen_events` WHERE 
				`event_date` >= '$monthStart' AND `event_date` <= '$monthEnd' ORDER BY `event_date` ASC";
				$userStatement = mysqli_prepare($KONN,$qu_gen_events_sel);
				mysqli_stmt_execute($userStatement);
				$qu_gen_events_EXE = mysqli_stmt_get_result($userStatement);
				if(mysqli_num_rows($qu_gen_events_EXE)){
					$tot_apps = 0;
					while($gen_events_REC = mysqli_fetch_assoc($qu_gen_events_EXE)){
						
						$event_id = $gen_events_REC['event_id'];
						$event_title = $gen_events_REC['event_title'];
						$notes = $gen_events_REC['notes'];
						
						$appointmentDateTime = $gen_events_REC['event_date'];
						$appointmentDateTime_arr = explode(' ', $appointmentDateTime);
						
						$appointmentDate = $appointmentDateTime_arr[0];
						$appointmentDate_arr = explode('-', $appointmentDate);
						
						$day_num = $appointmentDate_arr[2];
					?>
					$("#day-<?=$day_num; ?>").addClass("has-app");
					<?php
					}
				}
				
			?>
		</script>
		<?php
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			} else {
			die("0|5555649879");
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

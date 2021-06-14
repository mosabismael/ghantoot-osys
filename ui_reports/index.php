<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	$pageID = 50000;
?>
<!DOCTYPE html>
<html dir="<?=$lang_dir; ?>" lang="<?=$lang; ?>">
<head>
	<?php include('app/meta.php'); ?>
    <?php include('app/assets.php'); ?>
	
	
	
	
	
	
	
<script src="<?=assets_root; ?>google_charts/loader.js"></script>
<script type="text/javascript">

      // Load the Visualization API and the piechart package.
      google.charts.load('current', { 
			packages: ['corechart', 'table', 'bar', 'sankey']
	  });

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawSteelProjects);
      google.charts.setOnLoadCallback(drawMarineProjects);
      google.charts.setOnLoadCallback(drawManPower);
      google.charts.setOnLoadCallback(drawInvoiced);
      google.charts.setOnLoadCallback(drawDue);
      google.charts.setOnLoadCallback(drawRec);

      // Callback that creates and populates a data table, 
      // instantiates the pie chart, passes in the data and
      // draws it.
	  
	  
function drawSteelProjects() {
      var data = google.visualization.arrayToDataTable([
        ['Project', 'Progress', 'Budget Consumption'],
        ['Project 01', 50, 30],
        ['Project 02', 80, 90],
        ['Project 03', 25, 50],
      ]);

      var options = {
        title: 'Completion Percentage',
        chartArea: {width: '50%'},
        hAxis: {
          title: 'Steel Projects',
          minValue: 0, maxValue: 100,
          textStyle: {
            bold: true,
            fontSize: 12,
            color: '#4d4d4d'
          },
          titleTextStyle: {
            bold: true,
            fontSize: 18,
            color: '#4d4d4d'
          }
        },
        vAxis: {
          title: 'Projects',
          textStyle: {
            fontSize: 14,
            bold: true,
            color: '#848484'
          },
          titleTextStyle: {
            fontSize: 14,
            bold: true,
            color: '#848484'
          }
        }
      };
      var chart = new google.visualization.BarChart(document.getElementById('steel_projects'));
      chart.draw(data, options);
    }
	
function drawMarineProjects() {
      var data = google.visualization.arrayToDataTable([
        ['Project', 'Progress', 'Budget Consumption'],
        ['Project 05', 80, 90],
        ['Project 04', 50, 30],
        ['Project 06', 25, 50],
      ]);

      var options = {
        title: 'Percentage',
        chartArea: {width: '50%'},
        hAxis: {
          title: 'Marine Projects',
          minValue: 0, maxValue: 100,
          textStyle: {
            bold: true,
            fontSize: 12,
            color: '#4d4d4d'
          },
          titleTextStyle: {
            bold: true,
            fontSize: 18,
            color: '#4d4d4d'
          }
        },
        vAxis: {
          title: 'Completion Projects',
          textStyle: {
            fontSize: 14,
            bold: true,
            color: '#848484'
          },
          titleTextStyle: {
            fontSize: 14,
            bold: true,
            color: '#848484'
          }
        }
      };
      var chart = new google.visualization.BarChart(document.getElementById('marine_projects'));
      chart.draw(data, options);
    }
	
	
function drawManPower() {
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Name of Month');
      data.addColumn('number', 'Local');
      data.addColumn('number', 'Hire');

      data.addRows([
        ['JAN', 90, 25],
        ['FEB', 90, 15],
        ['MAR', 90, 10],
      ]);

      var options = {
        title: 'Manpower Deployments',
        hAxis: {
          title: 'Year Quarters',
          viewWindow: {
            min: [0],
            max: [3]
          }
        },
        vAxis: {
          title: 'Total Manpower'
        }
      };

      var chart = new google.visualization.ColumnChart(
        document.getElementById('man_power'));

      chart.draw(data, options);
    }
	
	
	
	
	
	
	
	
	
	

	
function drawInvoiced() {
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Name of Month');
      data.addColumn('number', 'Total AED');

      data.addRows([
        ['JAN', 15000],
        ['FEB', 9000],
        ['MAR', 13300],
      ]);

      var options = {
        title: 'Amount Invoiced',
        hAxis: {
          title: 'Year Quarters',
          viewWindow: {
            min: [0],
            max: [3]
          }
        },
        vAxis: {
          title: 'Total Invoiced'
        }
      };

      var chart = new google.visualization.ColumnChart(
        document.getElementById('Invoiced'));

      chart.draw(data, options);
    }
	
function drawDue() {
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Name of Month');
      data.addColumn('number', 'Total AED');

      data.addRows([
        ['JAN', 5000],
        ['FEB', 4500],
        ['MAR', 10000],
      ]);

      var options = {
        title: 'Due Amount',
        hAxis: {
          title: 'Year Quarters',
          viewWindow: {
            min: [0],
            max: [3]
          }
        },
        vAxis: {
          title: 'Total Due'
        }
      };

      var chart = new google.visualization.ColumnChart(
        document.getElementById('Dued'));

      chart.draw(data, options);
    }
	
function drawRec() {
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Name of Month');
      data.addColumn('number', 'Total AED');

      data.addRows([
        ['JAN', 10000],
        ['FEB', 4500],
        ['MAR', 3300],
      ]);

      var options = {
        title: 'Payment Recieved',
        hAxis: {
          title: 'Year Quarters',
          viewWindow: {
            min: [0],
            max: [3]
          }
        },
        vAxis: {
          title: 'Total Due'
        }
      };

      var chart = new google.visualization.ColumnChart(
        document.getElementById('Rec'));

      chart.draw(data, options);
    }
	
	
	
	
</script>
	
	
	
	
</head>
<body>
<?php

	$WHERE = "User Dashboard";
	include('app/header.php');
	//PAGE DATA START -----------------------------------------------///---------------------------------
?>

<div class="row">



	<div class="col-100">
		<div class="user-pic">
			<img src="<?=uploads_root; ?><?=$PROFILE_PIC; ?>" alt="<?=$USER_NAME; ?> - user picture" />
		</div>
		
		<div class="user-welcome">
			<span id="stater"><?=lang("Happy_day", "AAR"); ?>, </span>
			<h1><?=$USER_NAME; ?></h1>
		</div>
	</div>

	<div class="col-100">
		<?php include('user_conrols.php'); ?>
	</div>



	<div class="col-100">
<div class="panel panelDanger">
	<div class="panelBody">
				<div class="kpi-holder">
<div class="kpi-box text-primary" style="width: 100%;margin: 0 auto;">
	<p class="kpi-name"><?=lang("Avg. procurement cycle time", "AAR"); ?></p>
</div>
<div class="kpi-box text-danger" style="width: auto;margin: 0 -3%;padding: 0;padding-top: 7%;">
	<i class="fas fa-asterisk"></i>
	<p class="kpi-name"><?=lang("Requisitions", "AAR"); ?></p>
</div>
<div class="kpi-box text-success">
	<div class="progress-bar1 text-success" data-percent="30" data-duration="1000" data-color="#f1f1f1,#5cb85c"></div>
</div>
<div class="kpi-box text-danger" style="width: auto;margin: 0 -2%;padding: 0;padding-top: 7%;">
	<i class="fas fa-asterisk"></i>
	<p class="kpi-name"><?=lang("POs", "AAR"); ?></p>
</div>

<div class="kpi-box text-success">
	<div class="progress-bar1 text-warning" data-percent="60" data-duration="1000" data-color="#f1f1f1,#f0ad4e"></div>
</div>
<div class="kpi-box text-danger" style="width: auto;margin: 0 -2%;padding: 0;padding-top: 7%;">
	<i class="fas fa-asterisk"></i>
	<p class="kpi-name"><?=lang("Delivery", "AAR"); ?></p>
</div>
				

<div class="kpi-box text-success">
	<div class="progress-bar1 text-danger" data-percent="30" data-duration="1000" data-color="#f1f1f1,#d9534f"></div>
</div>
<div class="kpi-box text-danger" style="width: auto;margin: 0 -3%;padding: 0;padding-top: 7%;">
	<i class="fas fa-asterisk"></i>
	<p class="kpi-name"><?=lang("Invoice", "AAR"); ?></p>
</div>
				</div>
				<br>
	</div><!-- panelBody END -->
</div><!-- panel END -->
	</div>




	<div class="col-50">
<div class="panel panelDanger">
	<div class="panelBody">
		<br><div id="marine_projects" style="width:400; height:300"></div><br>
	</div><!-- panelBody END -->
</div><!-- panel END -->
	</div>



	<div class="col-50">
<div class="panel panelDanger">
	<div class="panelBody">
		<br><div id="steel_projects" style="width:400; height:300"></div><br>
	</div><!-- panelBody END -->
</div><!-- panel END -->
	<br>
	</div>
	
	

	<div class="col-100">
<div class="panel panelDanger">
	<div class="panelBody">
		<br><div id="man_power" style="width:400; height:300"></div><br>
	</div><!-- panelBody END -->
</div><!-- panel END -->
	<br>
	</div>

	<div class="col-33">
<div class="panel panelDanger">
	<div class="panelBody">
		<br><div id="Invoiced" style="width:400; height:300"></div><br>
	</div><!-- panelBody END -->
</div><!-- panel END -->
	</div>

	<div class="col-33">
<div class="panel panelDanger">
	<div class="panelBody">
		<br><div id="Dued" style="width:400; height:300"></div><br>
	</div><!-- panelBody END -->
</div><!-- panel END -->
	</div>

	<div class="col-33">
<div class="panel panelDanger">
	<div class="panelBody">
		<br><div id="Rec" style="width:400; height:300"></div><br>
	</div><!-- panelBody END -->
</div><!-- panel END -->
	<br>
	</div>
	
	<div class="zero"></div>
	
<script src="<?=assets_root; ?>js/progressbar.js"></script>
<script>
//CODE FOR KPIs
$(".progress-bar1").loading();
</script>

</div>


<?php
	//PAGE DATA END   ----------------------------------------------///---------------------------------
	include('app/footer.php');
?>

</body>
</html>

	<div class="form-grp">
	
		<div class="form-item col-100">
			<div id="chart_div" style="width: 100%; height: 600px"></div>
		</div>
		<div class="zero"></div>
	</div>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

	<script type="text/javascript">
      google.charts.load('current', {packages: ['corechart', 'line']});
      google.charts.setOnLoadCallback(drawBasic);


function drawBasic() {

      var data = new google.visualization.DataTable();
      data.addColumn('number', 'X');
      data.addColumn('number', 'EV');
      data.addColumn('number', 'AV');

      data.addRows([
        [0, 0, 0],   [0, 0, 0],  [0, 0, 0],  [0, 0, 0],  [0, 0, 0],  [0, 0, 0],
        [0, 0, 0],   [0, 0, 0],  [0, 0, 0],  [0, 0, 0],  [0, 0, 0],  [0, 0, 0],
        [0, 0, 0],   [0, 0, 0],  [0, 0, 0],  [0, 0, 0],  [0, 0, 0],  [0, 0, 0],
        [0, 0, 0],   [0, 0, 0],  [0, 0, 0],  [0, 0, 0],  [0, 0, 0],  [0, 0, 0],
        [0, 0, 0],   [0, 0, 0],  [0, 0, 0],  [0, 0, 0],  [0, 0, 0],  [0, 0, 0],
        [0, 0, 0],   [0, 0, 0],  [0, 0, 0],  [0, 0, 0],  [0, 0, 0],  [0, 0, 0],
        [0, 0, 0],   [0, 0, 0],  [0, 0, 0],  [0, 0, 0],  [0, 0, 0],  [0, 0, 0],
        [0, 0, 0],   [0, 0, 0],  [0, 0, 0],  [0, 0, 0],  [0, 0, 0],  [0, 0, 0],
        [0, 0, 0],   [0, 0, 0],  [0, 0, 0],  [0, 0, 0],  [0, 0, 0],  [0, 0, 0],
        [0, 0, 0],   [0, 0, 0],  [0, 0, 0],  [0, 0, 0],  [0, 0, 0],  [0, 0, 0],
        [0, 0, 0],   [0, 0, 0],  [0, 0, 0],  [0, 0, 0],  [0, 0, 0],  [0, 0, 0],
        [0, 0, 0], [0, 0, 0], [0, 0, 0], [0, 0, 0]
      ]);

      var options = {
        hAxis: {
          title: 'Duration'
        },
        vAxis: {
          title: 'Production'
        }
      };

      var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

      chart.draw(data, options);
    }
    </script>

<br>
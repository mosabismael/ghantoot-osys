<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	// $page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	$page_title=$page_description=$page_keywords=$page_author= "GOMI ERP";
	
	$menuId = 7;
	$subPageID = 161;
	
	
	
	
	
?>
<!DOCTYPE html>
<html dir="<?=$lang_dir; ?>" lang="<?=$lang; ?>">
<head>
	<?php include('app/meta.php'); ?>
    <?php include('app/assets.php'); ?>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>

<body>
<?php

	$WHERE = "projects";
	include('app/header.php');
	//PAGE DATA START -----------------------------------------------///---------------------------------
?>



<div class="row">
	<div class="col-100">
		<div id = "most_used"></div><hr>
		<div id = "Item_performance"></div><hr>
		<div class="search-box">
        <input type="text" id = "searchresult" autocomplete="off" placeholder="Search Stock Barcode..." />
        <div class="result" ></div>
		<div class = "enterButton" onclick = "drawLastChart()"><i class="fas fa-arrow-right"></i></div>
    </div>
		<div id = "boq_data"></div>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        $.ajax({
          url: "getInvStockLevel.php",
          dataType: "json",
            type: "GET",
            contentType: "application/json; charset=utf-8",
		  success: function (data) {
		  var tdata = new google.visualization.DataTable();
		   tdata.addColumn('string', 'Item Name');
		   tdata.addColumn('number', 'qty');
		  
                   
			var arrStock = [['qty', 'ItemName']]; 
		 for (var i = 0; i < data.length; i++) {
                    tdata.addRow([data[i].item_name, data[i].qty]);
		}

		var options = {
                    'title': 'Most Used Item',
					'width':1600,
                     'height':600,
					  hAxis: {title: 'ItemName', titleTextStyle: {color: 'black'}, count: -1, viewWindowMode: 'pretty', slantedText: true},
					 vAxis: {title: 'Quantity', titleTextStyle: {color: 'black'}, count: -1},
					'is3D':true,
					 chartArea: {
   top: 95,
   height: '45%' 
}

				};
       
        //var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
		//var chart = new google.visualization.PieChart(document.getElementById('curve_chart'));
		var chart = new google.visualization.ColumnChart(document.getElementById('most_used'));
		chart.draw(tdata, options);
		
      }
	  });
	  }
    </script>
	<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        $.ajax({
          url: "performanceReport.php",
          dataType: "json",
            type: "GET",
            contentType: "application/json; charset=utf-8",
		  success: function (data) {
		  var tdata = new google.visualization.DataTable();
		   tdata.addColumn('string', 'Item Name');
		   tdata.addColumn('number', 'qty');
		  tdata.addColumn({type: 'string', role: 'tooltip', 'p': {'html': true}});
                   
			var arrStock = [['qty', 'ItemName']]; 
		 for (var i = 0; i < data.length; i++) {
                    var poniterinfo = "quantity remaining : "+data[i].qty + " <br>ordered on :"+ data[i].invoicedate+ " <br>received on :"+ data[i].receiveddate + "<br>date diff : "+data[i].date+" days";
                   tdata.addRow([data[i].item_name, data[i].qty, poniterinfo]);
		}

		var options = {
                    'title': 'Item Performance',
					'width':1600,
                     'height':600,
					  hAxis: {title: 'ItemName', titleTextStyle: {color: 'black'}, count: -1, viewWindowMode: 'pretty', slantedText: true},
					 vAxis: {title: 'Shelf Time', titleTextStyle: {color: 'black'}, count: -1},
					'is3D':true,
					tooltip: {isHtml: true},
					 chartArea: {
   top: 95,
   height: '40%' 
}
					 
				};
       
        //var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
		//var chart = new google.visualization.PieChart(document.getElementById('curve_chart'));
		var chart = new google.visualization.ColumnChart(document.getElementById('Item_performance'));
		chart.draw(tdata, options);
		
      }
	  });
	  }
    </script>
	<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawLastChart);

      function drawLastChart() {
	  searchresult = document.getElementById('searchresult').value;
        $.ajax({
          url: "boqGraphData.php",
          dataType: "json",
		  data: {'barcode':searchresult},
            type: "GET",
            contentType: "application/json; charset=utf-8",
		  success: function (data) {
		  var tdata = new google.visualization.DataTable();
		   
		   tdata.addColumn('number', 'qty');
		   tdata.addColumn('number', 'date');
		   tdata.addColumn({type: 'string', role: 'tooltip', 'p': {'html': true}});
                   
			
		 for (var i = 0; i < data.length; i++) {
					var poniterinfo = "quantity remaining : "+data[i].qty + " <br>ordered on :"+ data[i].invoicedate+ " <br>received on :"+ data[i].receiveddate + "<br>date diff : "+data[i].date+" days";
                    tdata.addRow([   data[i].qty,data[i].date,poniterinfo]);
		}

		var options = {
                    'title': 'Item Lead Time',
					'width':1600,
                     'height':600,
					 tooltip: {isHtml: true},
					 hAxis: {title: 'Quantity', titleTextStyle: {color: 'black'}, count: -1, viewWindowMode: 'pretty', slantedText: true},
					 vAxis: {title: 'Shelf Date', titleTextStyle: {color: 'black'}, count: -1}

					 
				};
       
       var chart = new google.visualization.LineChart(document.getElementById('boq_data'));
		//var chart = new google.visualization.ComboChart(document.getElementById('boq_data'));
		//var chart = new google.visualization.PieChart(document.getElementById('curve_chart'));
		//var chart = new google.visualization.ColumnChart(document.getElementById('boq_data'));
		chart.draw(tdata, options);
		},
		error:function(){
				document.getElementById('boq_data').innerHTML= "Sorry no data available";
			
		}
	  });
	  }
	  
$(document).ready(function(){
    $('.search-box input[type="text"]').on("keyup input", function(){
        /* Get input value on change */
        var inputVal = $(this).val();
        var resultDropdown = $(this).siblings(".result");
        if(inputVal.length){
            $.get("StockSearch.php", {term: inputVal}).done(function(data){
                // Display the returned data in browser
                resultDropdown.html(data);
            });
        } else{
            resultDropdown.empty();
        }
    });
    
    // Set search input value on click of result item
    $(document).on("click", ".result p", function(){
        $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
        $(this).parent(".result").empty();
    });
});

    </script>
	</div>
	<div class="zero"></div>
</div>
	

<?php
	//PAGE DATA END   ----------------------------------------------///---------------------------------
	include('app/footer.php');
?>

</body>
</html>
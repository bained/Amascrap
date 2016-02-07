
		<h2>Price Traktor</h2>
		<div id="chart_div"></div>


	<script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1.1','packages':['corechart', 'timeline']}]}"></script>

	<script>

    google.load('visualization', '1', {packages: ['corechart']});
    google.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = new google.visualization.DataTable();
      data.addColumn('datetime', 'Time of Day');
      data.addColumn('number', 'Motivation Level');

      data.addRows([
        <?php echo $formatdatearray; ?>
      ]);

      var options = {
        width: 900,
        height: 500,
        legend: {position: 'none'},
        enableInteractivity: false,
        chartArea: {
          width: '85%'
        }

      };

      var chart = new google.visualization.LineChart(
        document.getElementById('chart_div'));

      chart.draw(data, options);

      var button = document.getElementById('change');
      var isChanged = false;

    }


	</script>
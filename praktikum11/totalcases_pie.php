<?php
include'koneksi.php';

$total = mysqli_query($koneksi,"SELECT * FROM tb_covid");
while($row = mysqli_fetch_array($total)){
	$negara[] = $row['negara'];
	
	$query = mysqli_query($koneksi,"SELECT sum(totalkasus) as totalkasus FROM tb_covid WHERE id='".$row['id']."'");
	$row = $query->fetch_array();
	$totalkasus[] = $row['totalkasus'];
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Chart Covid</title>
    <h1><center>Covid Pie Chart : Total Cases</center></h1> 
	<script type="text/javascript" src="Chart.js"></script>
</head>
 <center>
<body>
	<div id="canvas-holder" style="width:50%">
		<canvas id="chart-area"></canvas>
	</div>
	<script>
		var config = {
			type: 'pie',
			data: {
				datasets: [{
					data:<?php echo json_encode($totalkasus); ?>,
					backgroundColor: [
						'rgba(255, 99, 132, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(12, 116, 111, 0.2)',
                    'rgba(108, 22, 34, 0.2)',
                    'rgba(171, 206, 86, 0.2)',
                    'rgba(194, 98, 26, 0.2)',
                    'rgba(25, 76, 86, 0.2)',
                    'rgba(70, 86, 23, 0.2)',
                    'rgba(252, 206, 87, 0.2)',
					'rgba(75, 192, 192, 0.2)'
					],
					borderColor: [
                    'rgba(255, 99, 132, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(72, 116, 51, 1)',
                    'rgba(108, 22, 34, 1)',
                    'rgba(171, 206, 86, 1)',
                    'rgba(194, 98, 26, 1)',
                    'rgba(25, 76, 86, 1)',
                    'rgba(70, 86, 23, 1)',
                    'rgba(252, 206, 87, 1)',
					'rgba(75, 192, 192, 1)'
					],
					label: 'Total Kasus'
				}],
				labels: <?php echo json_encode($negara); ?>},
			options: {
				responsive: true
			}
		};
		window.onload = function() {
			var ctx = document.getElementById('chart-area').getContext('2d');
			window.myPie = new Chart(ctx, config);
		};
		document.getElementById('randomizeData').addEventListener('click', function() {
			config.data.datasets.forEach(function(dataset) {
				dataset.data = dataset.data.map(function() {
					return randomScalingFactor();
				});
			});
			window.myPie.update();
		});
		var colorNames = Object.keys(window.chartColors);
		document.getElementById('addDataset').addEventListener('click', function() {
			var newDataset = {
				backgroundColor: [],
				data: [],
				label: 'New dataset ' + config.data.datasets.length,
			};
			for (var index = 0; index < config.data.labels.length; ++index) {
				newDataset.data.push(randomScalingFactor());
 
				var colorName = colorNames[index % colorNames.length];
				var newColor = window.chartColors[colorName];
				newDataset.backgroundColor.push(newColor);
			}
			config.data.datasets.push(newDataset);
			window.myPie.update();
		});
		document.getElementById('removeDataset').addEventListener('click', function() {
			config.data.datasets.splice(0, 1);
			window.myPie.update();
		});
	</script>
    </center>
</body>
</html>
<?php
include'koneksi.php';

$total = mysqli_query($koneksi,"SELECT * FROM tb_covid");
while($row = mysqli_fetch_array($total)){
	$negara[] = $row['negara'];
	
	$query = mysqli_query($koneksi,"SELECT sum(kematianbaru) as kematianbaru FROM tb_covid WHERE id ='".$row['id']."'");
	$kematianbaru[] = $row['kematianbaru'];
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Chart Covid</title>
    <h1><center>Covid Doughnut Chart : New Deaths</center></h1>
	<script type="text/javascript" src="Chart.js"></script>
</head>
<center> 
<body>
	<div id="canvas-holder" style="width:50%">
		<canvas id="chart-area"></canvas>
	</div>
	<script>
		var config = {
			type: 'doughnut',
			data: {
				datasets: [{
					data:<?php echo json_encode($kematianbaru); ?>,
					backgroundColor: [
					'rgba(255, 99, 132, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(255, 206, 86, 0.2)',
					'rgba(75, 192, 192, 0.2)',
					'rgba(245, 40, 145, 0.8)',
					'rgba(39, 187, 245, 0.8)',
					'rgba(245, 39, 226, 0.8)',
					'rgba(39, 245, 45, 0.8)',
					'rgba(222, 245, 39, 0.8)',
					'rgba(245, 118, 39, 0.8)'
					],
					borderColor: [
					'rgba(255,99,132,1)',
					'rgba(54, 162, 235, 1)',
					'rgba(255, 206, 86, 1)',
					'rgba(75, 192, 192, 1)',
					'rgba(55, 163, 234, 0.2)',
					'rgba(57, 167, 237, 0.2)',
					'rgba(58, 168, 238, 0.2)',
					'rgba(59, 169, 239, 0.2)',
					'rgba(74, 119, 221, 0.2)',
					'rgba(70, 110, 210, 0.2)'
					],
					label: 'Kematian Baru'
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
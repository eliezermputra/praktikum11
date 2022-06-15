<?php
include'koneksi.php';

$total = mysqli_query($koneksi,"SELECT * FROM tb_covid");
while($row = mysqli_fetch_array($total)){
	$negara[] = $row['negara'];
	
	$query = mysqli_query($koneksi,"SELECT sum(totalsembuh) as totalsembuh FROM tb_covid WHERE id='".$row['id']."'");
	$row = $query->fetch_array();
	$totalsembuh[] = $row['totalsembuh'];
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Pie Chart</title>
	<script type="text/javascript" src="Chart.js"></script>
</head>
 
<body>
	<div id="canvas-holder" style="width:50%">
		<canvas id="chart-area"></canvas>
	</div>
	<script>
		var config = {
			type: 'pie',
			data: {
				datasets: [{
					data:<?php echo json_encode($totalsembuh); ?>,
					backgroundColor: [
					'rgba(255, 99, 132, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(74, 116, 56, 0.2)',
                    'rgba(105, 22, 36, 0.2)',
                    'rgba(175, 206, 86, 0.2)',
                    'rgba(194, 98, 26, 0.2)',
                    'rgba(25, 76, 86, 0.2)',
                    'rgba(75, 86, 86, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
					'rgba(75, 192, 192, 0.2)'
					],
					borderColor: [
					'rgba(255,99,132,1)',
					'rgba(54, 162, 235, 1)',
					'rgba(255, 206, 86, 1)',
                    'rgba(74, 116, 56, 1)',
                    'rgba(105, 22, 36, 1)',
                    'rgba(175, 206, 86, 1)',
                    'rgba(194, 98, 26, 1)',
                    'rgba(25, 76, 86, 1)',
                    'rgba(75, 86, 86, 1)',
                    'rgba(255, 206, 86, 1)',
					'rgba(75, 192, 192, 1)'
					],
					label: 'Presentase Penjualan Barang'
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
</body>
</html>
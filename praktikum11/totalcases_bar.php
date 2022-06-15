<?php
include'koneksi.php';
$label = ["India","S.Korea","Turkey","Vietnam","Japan","Iran","Indonesia","Malaysia","Thailand","Israel"];
 
for($negara = 1;$negara < 11;$negara++) {
	$query = mysqli_query($koneksi,"SELECT sum(totalkasus) as totalkasus FROM tb_covid WHERE ID='$negara'");
	$row = $query->fetch_array();
	$totalkasus[] = $row['totalkasus'];
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>CHART COVID</title>
    <h1><center>Covid Bar Chart : Total Cases</center></h1>
	<script type="text/javascript" src="Chart.js"></script>
</head>
<body>
	<div style="width: 800px;height: 800px">
		<canvas id="myChart"></canvas>
	</div>
	
	<script>
		var ctx = document.getElementById("myChart").getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: <?php echo json_encode($label); ?>,
				datasets: [{
					label: 'Total Cases',
					data: <?php echo json_encode($totalkasus); ?>,
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
					borderWidth: 1
				}]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero:true
						}
					}]
				}
			}
		});
	</script>
</body>
</html>
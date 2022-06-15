<?php
include('koneksi.php');

$total = mysqli_query($koneksi,"SELECT * FROM tb_covid");
while($row = mysqli_fetch_array($total)){
	$negara[] = $row['negara'];
	
	$query = mysqli_query($koneksi,"SELECT sum(kasusbaru) as kasusbaru FROM tb_covid WHERE id ='".$row['id']."'");
	$row = $query->fetch_array();
	$kasusbaru[] = $row['kasusbaru'];
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Chart Covid</title>
    <h1><center>Covid Line Chart : New Cases</center></h1>
	<script type="text/javascript" src="chart.js"></script>
</head>
<center>
<body>
	<div style="width: 800px;height: 800px">
		<canvas id="myChart"></canvas>
	</div>

	<script>
		var ctx = document.getElementById("myChart").getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'line',
			data: {
				labels: <?php echo json_encode($negara); ?>,
				datasets: [{
					label: 'Covid Line Chart',
					data: <?php echo json_encode($kasusbaru); ?>,
					borderColor: 'rgb(75, 192, 192, 2)',
                    backgroundColor : 'rgba(175, 206, 86, 0.2)',
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
    </center>
</body>
</html>
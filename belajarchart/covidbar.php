<?php
include'koneksi.php';
$label = ["India","S.Korea","Turkey","Vietnam","Japan","Iran","Indonesia","Malaysia","Thailand","Israel"];
 
for($negara = 1;$negara < 11;$negara++) {
	$query = mysqli_query($koneksi,"SELECT sum(totalsembuh) as totalsembuh FROM tb_covid WHERE ID='$negara'");
	$row = $query->fetch_array();
	$totalsembuh[] = $row['totalsembuh'];
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Membuat Grafik Menggunakan Chart JS</title>
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
					label: 'Grafik Penjualan',
					data: <?php echo json_encode($totalsembuh); ?>,
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
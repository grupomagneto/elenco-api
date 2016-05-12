<?php header("Content-type: text/html; charset=ISO-8859-15");
include("conecta.php");
	$start_month = 1;
	$end_month = 12;
	$start_year = 2016;
	$end_year = 2018;
	$year = $start_year;

while ($year <= $end_year) {
  	while ($month <= $end_month) {
		$sql_despesas = "SELECT SUM(valor_original_despesa) AS despesas FROM financeiro WHERE YEAR(data_venc_despesa) = '$year' AND MONTH(data_venc_despesa) = '$month'";
		$result2 = mysqli_query($link, $sql_despesas);
		$row2 = mysqli_fetch_array($result2);
		$despesas = $row2['despesas'];
			if ($despesas > 0){
			${'despesas'.$month.$year} = $despesas;
			} else {
			${'despesas'.$month.$year} = 0;
			}
			$month++;
	}
	$year++;
	$month = 1;
}
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' lang='pt-BR'>
<head>
<meta http-equiv='Content-type' content='text/html; charset=ISO-8859-15' />
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Roboto:300,400' />
<link rel='stylesheet' type='text/css' href='DataTables/datatables.min.css'/>
<link rel='stylesheet' type='text/css' href='DataTables/style.css'/>
	<style type='text/css'>
	h1 { font-family: 'Roboto', sans-serif; font-weight: 400; }
	body { font-family: 'Roboto', sans-serif; font-weight: 300; }
	.set-width {
	  width: 85px;
	}
	</style>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ['', '2016', '2017', '2018'],
      ['Jan',  <?php echo $despesas12016;?>, <?php echo $despesas12017;?>, <?php echo $despesas12018;?>],
      ['Fev',  <?php echo $despesas22016;?>, <?php echo $despesas22017;?>, <?php echo $despesas22018;?>],
      ['Mar',  <?php echo $despesas32016;?>, <?php echo $despesas32017;?>, <?php echo $despesas32018;?>],
	  ['Abr',  <?php echo $despesas42016;?>, <?php echo $despesas42017;?>, <?php echo $despesas42018;?>],
	  ['Mai',  <?php echo $despesas52016;?>, <?php echo $despesas52017;?>, <?php echo $despesas52018;?>],
	  ['Jun',  <?php echo $despesas62016;?>, <?php echo $despesas62017;?>, <?php echo $despesas62018;?>],
	  ['Jul',  <?php echo $despesas72016;?>, <?php echo $despesas72017;?>, <?php echo $despesas72018;?>],
	  ['Ago',  <?php echo $despesas82016;?>, <?php echo $despesas82017;?>, <?php echo $despesas82018;?>],
	  ['Set',  <?php echo $despesas92016;?>, <?php echo $despesas92017;?>, <?php echo $despesas92018;?>],
	  ['Out',  <?php echo $despesas102016;?>, <?php echo $despesas102017;?>, <?php echo $despesas102018;?>],
	  ['Nov',  <?php echo $despesas112016;?>, <?php echo $despesas112017;?>, <?php echo $despesas112018;?>],
	  ['Dez',  <?php echo $despesas122016;?>, <?php echo $despesas122017;?>, <?php echo $despesas122018;?>]
    ]);

    var options = {
      title: 'Despesas Previstas 2016-2018',
      curveType: 'function',
      legend: { position: 'right' }
    };

    var chart = new google.visualization.LineChart(document.getElementById('despesas'));

    chart.draw(data, options);
  }
</script>
</head>
<body>
<center>
    <div id="despesas" style="width: 1000px; height: 400px"></div>
  </body>
</html>
<?php
mysqli_close($link);
?>
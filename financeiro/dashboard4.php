<?php
include("conecta.php");
	$start_month = 1;
	$end_month = 12;
	$start_year = 2012;
	$end_year = 2019;
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
<meta http-equiv='Content-type' content='text/html; charset=UTF-8' />
<title>Dashboard - Magneto Elenco</title>
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
      ['', '2012', '2013', '2014', '2015', '2016', '2017', '2018', '2019'],
      ['Jan',  <?php echo $despesas12012;?>, <?php echo $despesas12013;?>, <?php echo $despesas12014;?>, <?php echo $despesas12015;?>, <?php echo $despesas12016;?>, <?php echo $despesas12017;?>, <?php echo $despesas12018;?>, <?php echo $despesas12019;?>],
      ['Fev',  <?php echo $despesas22012;?>, <?php echo $despesas22013;?>, <?php echo $despesas22014;?>, <?php echo $despesas22015;?>, <?php echo $despesas22016;?>, <?php echo $despesas22017;?>, <?php echo $despesas22018;?>, <?php echo $despesas22019;?>],
      ['Mar',  <?php echo $despesas32012;?>, <?php echo $despesas32013;?>, <?php echo $despesas32014;?>, <?php echo $despesas32015;?>, <?php echo $despesas32016;?>, <?php echo $despesas32017;?>, <?php echo $despesas32018;?>, <?php echo $despesas32019;?>],
	  ['Abr',  <?php echo $despesas42012;?>, <?php echo $despesas42013;?>, <?php echo $despesas42014;?>, <?php echo $despesas42015;?>, <?php echo $despesas42016;?>, <?php echo $despesas42017;?>, <?php echo $despesas42018;?>, <?php echo $despesas42019;?>],
	  ['Mai',  <?php echo $despesas52012;?>, <?php echo $despesas52013;?>, <?php echo $despesas52014;?>, <?php echo $despesas52015;?>, <?php echo $despesas52016;?>, <?php echo $despesas52017;?>, <?php echo $despesas52018;?>, <?php echo $despesas52019;?>],
	  ['Jun',  <?php echo $despesas62012;?>, <?php echo $despesas62013;?>, <?php echo $despesas62014;?>, <?php echo $despesas62015;?>, <?php echo $despesas62016;?>, <?php echo $despesas62017;?>, <?php echo $despesas62018;?>, <?php echo $despesas62019;?>],
	  ['Jul',  <?php echo $despesas72012;?>, <?php echo $despesas72013;?>, <?php echo $despesas72014;?>, <?php echo $despesas72015;?>, <?php echo $despesas72016;?>, <?php echo $despesas72017;?>, <?php echo $despesas72018;?>, <?php echo $despesas72019;?>],
	  ['Ago',  <?php echo $despesas82012;?>, <?php echo $despesas82013;?>, <?php echo $despesas82014;?>, <?php echo $despesas82015;?>, <?php echo $despesas82016;?>, <?php echo $despesas82017;?>, <?php echo $despesas82018;?>, <?php echo $despesas82019;?>],
	  ['Set',  <?php echo $despesas92012;?>, <?php echo $despesas92013;?>, <?php echo $despesas92014;?>, <?php echo $despesas92015;?>, <?php echo $despesas92016;?>, <?php echo $despesas92017;?>, <?php echo $despesas92018;?>, <?php echo $despesas92019;?>],
	  ['Out',  <?php echo $despesas102012;?>, <?php echo $despesas102013;?>, <?php echo $despesas102014;?>, <?php echo $despesas102015;?>, <?php echo $despesas102016;?>, <?php echo $despesas102017;?>, <?php echo $despesas102018;?>, <?php echo $despesas102019;?>],
	  ['Nov',  <?php echo $despesas112012;?>, <?php echo $despesas112013;?>, <?php echo $despesas112014;?>, <?php echo $despesas112015;?>, <?php echo $despesas112016;?>, <?php echo $despesas112017;?>, <?php echo $despesas112018;?>, <?php echo $despesas112019;?>],
	  ['Dez',  <?php echo $despesas122012;?>, <?php echo $despesas122013;?>, <?php echo $despesas122014;?>, <?php echo $despesas122015;?>, <?php echo $despesas122016;?>, <?php echo $despesas122017;?>, <?php echo $despesas122018;?>, <?php echo $despesas122019;?>]
    ]);

    var options = {
      title: 'Despesas 2012-2019',
      curveType: 'function',
      legend: { position: 'bottom' }
    };

    var chart = new google.visualization.LineChart(document.getElementById('despesas'));

    chart.draw(data, options);
  }
</script>
</head>
<body>
<center><div>
	<h1>Dashboard</h1>
    <div id="despesas" style="width: 1000px; height: 500px"></div>
  </body>
</html>
<?php
mysqli_close($link);
?>
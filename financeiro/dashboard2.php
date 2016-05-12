<?php header("Content-type: text/html; charset=ISO-8859-15");
include("conecta.php");
	$start_month = 1;
	$end_month = 12;
	$start_year = 2012;
	$end_year = 2016;
	$year = $start_year;

while ($year <= $end_year) {
  	while ($month <= $end_month) {
		$sql_receitas = "SELECT SUM(cache_bruto) - SUM(cache_liquido) + SUM(valor_venda) AS receitas FROM financeiro WHERE MONTH(data_job) = '$month' AND YEAR(data_job) = '$year' OR MONTH(data_venda) = '$month' AND YEAR(data_venda) = '$year'";
		$sql_despesas = "SELECT SUM(valor_despesa) AS despesas FROM financeiro WHERE YEAR(data_despesa) = '$year' AND MONTH(data_despesa) = '$month'";
		$result = mysqli_query($link, $sql_receitas);
		$row = mysqli_fetch_array($result);
		$receitas = $row['receitas'];
			if ($receitas > 0){
			${'receitas'.$month.$year} = $receitas;
			} else {
			${'receitas'.$month.$year} = 0;
			}
		$result2 = mysqli_query($link, $sql_despesas);
		$row2 = mysqli_fetch_array($result2);
		$despesas = $row2['despesas'];
			if ($despesas > 0){
			${'despesas'.$month.$year} = $despesas;
			} else {
			${'despesas'.$month.$year} = 0;
			}
			${'resultado'.$month.$year} = ${'receitas'.$month.$year} - ${'despesas'.$month.$year};
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
      ['', '2012', '2013', '2014', '2015', '2016'],
      ['Jan',  <?php echo $receitas12012;?>, <?php echo $receitas12013;?>, <?php echo $receitas12014;?>, <?php echo $receitas12015;?>, <?php echo $receitas12016;?>],
      ['Fev',  <?php echo $receitas22012;?>, <?php echo $receitas22013;?>, <?php echo $receitas22014;?>, <?php echo $receitas22015;?>, <?php echo $receitas22016;?>],
      ['Mar',  <?php echo $receitas32012;?>, <?php echo $receitas32013;?>, <?php echo $receitas32014;?>, <?php echo $receitas32015;?>, <?php echo $receitas32016;?>],
	  ['Abr',  <?php echo $receitas42012;?>, <?php echo $receitas42013;?>, <?php echo $receitas42014;?>, <?php echo $receitas42015;?>, <?php echo $receitas42016;?>],
	  ['Mai',  <?php echo $receitas52012;?>, <?php echo $receitas52013;?>, <?php echo $receitas52014;?>, <?php echo $receitas52015;?>, <?php echo $receitas52016;?>],
	  ['Jun',  <?php echo $receitas62012;?>, <?php echo $receitas62013;?>, <?php echo $receitas62014;?>, <?php echo $receitas62015;?>, <?php echo $receitas62016;?>],
	  ['Jul',  <?php echo $receitas72012;?>, <?php echo $receitas72013;?>, <?php echo $receitas72014;?>, <?php echo $receitas72015;?>, <?php echo $receitas72016;?>],
	  ['Ago',  <?php echo $receitas82012;?>, <?php echo $receitas82013;?>, <?php echo $receitas82014;?>, <?php echo $receitas82015;?>, <?php echo $receitas82016;?>],
	  ['Set',  <?php echo $receitas92012;?>, <?php echo $receitas92013;?>, <?php echo $receitas92014;?>, <?php echo $receitas92015;?>, <?php echo $receitas92016;?>],
	  ['Out',  <?php echo $receitas102012;?>, <?php echo $receitas102013;?>, <?php echo $receitas102014;?>, <?php echo $receitas102015;?>, <?php echo $receitas102016;?>],
	  ['Nov',  <?php echo $receitas112012;?>, <?php echo $receitas112013;?>, <?php echo $receitas112014;?>, <?php echo $receitas112015;?>, <?php echo $receitas112016;?>],
	  ['Dez',  <?php echo $receitas122012;?>, <?php echo $receitas122013;?>, <?php echo $receitas122014;?>, <?php echo $receitas122015;?>, <?php echo $receitas122016;?>]
    ]);

    var options = {
      title: 'Receita Líquida 2012-2016',
      curveType: 'function',
      legend: { position: 'bottom' }
    };

    var chart = new google.visualization.LineChart(document.getElementById('receitas'));

    chart.draw(data, options);
  }
</script>
</head>
<body>
<center><div>
	<h1>Dashboard</h1>
    <div id="receitas" style="width: 1000px; height: 500px"></div>
  </body>
</html>
<?php
mysqli_close($link);
?>
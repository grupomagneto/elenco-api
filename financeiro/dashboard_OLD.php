<?php header("Content-type: text/html; charset=ISO-8859-15");
include("conecta.php");
	$start_year = 2012;
	$end_year = 2016;
	$year = $start_year;

	while ($year <= $end_year) {
		$sql_receitas = "SELECT SUM(cache_bruto) - SUM(cache_liquido) + SUM(valor_venda) AS receitas FROM financeiro WHERE YEAR(data_job) = '$year' OR YEAR(data_venda) = '$year'";
		$sql_despesas = "SELECT SUM(valor_despesa) AS despesas FROM financeiro WHERE YEAR(data_despesa) = '$year'";
		$result = mysqli_query($link, $sql_receitas);
		$row = mysqli_fetch_array($result);
		$receitas = $row['receitas'];
			if ($receitas > 0){
			${'receitas'.$year} = $receitas;
			} else {
			${'receitas'.$year} = 0;
			}
		$result2 = mysqli_query($link, $sql_despesas);
		$row2 = mysqli_fetch_array($result2);
		$despesas = $row2['despesas'];
			if ($despesas > 0){
			${'despesas'.$year} = $despesas;
			} else {
			${'despesas'.$year} = 0;
			}
			${'resultado'.$year} = ${'receitas'.$year} - ${'despesas'.$year};
			$year++;
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
  google.charts.load('current', {'packages':['bar']});
  google.charts.setOnLoadCallback(drawChart);
  function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ['', 'Receitas', 'Despesas', 'Resultado'],
      ['2012', <?php echo $receitas2012;?>, <?php echo $despesas2012;?>, <?php echo $resultado2012;?>],
      ['2013', <?php echo $receitas2013;?>, <?php echo $despesas2013;?>, <?php echo $resultado2013;?>],
      ['2014', <?php echo $receitas2014;?>, <?php echo $despesas2014;?>, <?php echo $resultado2014;?>],
      ['2015', <?php echo $receitas2015;?>, <?php echo $despesas2015;?>, <?php echo $resultado2015;?>],
      ['2016', <?php echo $receitas2016;?>, <?php echo $despesas2016;?>, <?php echo $resultado2016;?>]
    ]);

    var options = {
      chart: {
        title: 'Performance da Empresa',
        subtitle: 'Receitas, Despesas, e Resultado: 2012-2016',
      }
    };

    var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

    chart.draw(data, options);
  }
</script>
</head>
<body>
<center><div>
	<h1>Dashboard</h1>
    <div id='columnchart_material' style='width: 900px; height: 400px;'></div>
  </body>
</html>
<?php
mysqli_close($link);
?>
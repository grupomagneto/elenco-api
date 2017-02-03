<?php
include("conecta.php");
	$start_month = 1;
	$end_month = 12;
	$start_year = 2015;
	$end_year = 2015;
	$year = $start_year;

while ($year <= $end_year) {
  	while ($month <= $end_month) {
		$sql_pago = "SELECT SUM(cache_bruto) - SUM(cache_liquido) AS pago FROM financeiro WHERE MONTH(data_job) = '$month' AND YEAR(data_job) = '$year' AND tipo_cache = 'Cadastro pago'";
		$sql_gratuitos = "SELECT SUM(cache_bruto) - SUM(cache_liquido) AS gratuitos FROM financeiro WHERE MONTH(data_job) = '$month' AND YEAR(data_job) = '$year' AND tipo_cache = 'Cadastro Gratuito'";
		$sql_primeiros = "SELECT SUM(cache_bruto) - SUM(cache_liquido) AS primeiros FROM financeiro WHERE MONTH(data_job) = '$month' AND YEAR(data_job) = '$year' AND tipo_cache = '1° Cache Cadastro Gratuito'";
		$sql_vendas = "SELECT SUM(valor_venda) AS vendas FROM financeiro WHERE YEAR(data_venda) = '$year' AND MONTH(data_venda) = '$month'";
		$result = mysqli_query($link, $sql_pago);
		$row = mysqli_fetch_array($result);
		$pago = $row['pago'];
			if ($pago > 0){
			${'pago'.$month.$year} = $pago;
			} else {
			${'pago'.$month.$year} = 0;
			}
		$result2 = mysqli_query($link, $sql_primeiros);
		$row2 = mysqli_fetch_array($result2);
		$primeiros = $row2['primeiros'];
			if ($primeiros > 0){
			${'primeiros'.$month.$year} = $primeiros;
			} else {
			${'primeiros'.$month.$year} = 0;
			}
		$result3 = mysqli_query($link, $sql_vendas);
		$row3 = mysqli_fetch_array($result3);
		$vendas = $row3['vendas'];
			if ($vendas > 0){
			${'vendas'.$month.$year} = $vendas;
			} else {
			${'vendas'.$month.$year} = 0;
			}
		$result4 = mysqli_query($link, $sql_gratuitos);
		$row4 = mysqli_fetch_array($result4);
		$gratuitos = $row4['gratuitos'];
			if ($gratuitos > 0){
			${'gratuitos'.$month.$year} = $gratuitos;
			} else {
			${'gratuitos'.$month.$year} = 0;
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
google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawStacked);

function drawStacked() {
      var data = google.visualization.arrayToDataTable([
        ['Mês', '1º Cachê', 'Gratuito', 'Pago', 'Vendas'],
		['Jan',  <?php echo $primeiros12015;?>, <?php echo $gratuitos12015;?>, <?php echo $pago12015;?>, <?php echo $vendas12015;?>],
		['Fev',  <?php echo $primeiros22015;?>, <?php echo $gratuitos22015;?>, <?php echo $pago22015;?>, <?php echo $vendas22015;?>],
		['Mar',  <?php echo $primeiros32015;?>, <?php echo $gratuitos32015;?>, <?php echo $pago32015;?>, <?php echo $vendas32015;?>],
		['Abr',  <?php echo $primeiros42015;?>, <?php echo $gratuitos42015;?>, <?php echo $pago42015;?>, <?php echo $vendas42015;?>],
		['Mai',  <?php echo $primeiros52015;?>, <?php echo $gratuitos52015;?>, <?php echo $pago52015;?>, <?php echo $vendas52015;?>],
		['Jun',  <?php echo $primeiros62015;?>, <?php echo $gratuitos62015;?>, <?php echo $pago62015;?>, <?php echo $vendas62015;?>],
		['Jul',  <?php echo $primeiros72015;?>, <?php echo $gratuitos72015;?>, <?php echo $pago72015;?>, <?php echo $vendas72015;?>],
		['Ago',  <?php echo $primeiros82015;?>, <?php echo $gratuitos82015;?>, <?php echo $pago82015;?>, <?php echo $vendas82015;?>],
		['Set',  <?php echo $primeiros92015;?>, <?php echo $gratuitos92015;?>, <?php echo $pago92015;?>, <?php echo $vendas92015;?>],
		['Out',  <?php echo $primeiros102015;?>, <?php echo $gratuitos102015;?>, <?php echo $pago102015;?>, <?php echo $vendas102015;?>],
		['Nov',  <?php echo $primeiros112015;?>, <?php echo $gratuitos112015;?>, <?php echo $pago112015;?>, <?php echo $vendas112015;?>],
		['Dez',  <?php echo $primeiros122015;?>, <?php echo $gratuitos122015;?>, <?php echo $pago122015;?>, <?php echo $vendas122015;?>]
      ]);

      var options = {
        title: 'Análise da Origem da Receita',
        chartArea: {width: '50%'},
        isStacked: true,
        hAxis: {
          title: '',
          minValue: 0,
        },
        vAxis: {
          title: ''
        }
      };
      var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    }
</script>
</head>
<body>
<center><div>
    <div id="chart_div" style="width: 1000px; height: 400px"></div>
  </body>
</html>
<?php
mysqli_close($link);
?>
<?php
include("conecta.php");
	$start_month = 1;
	$end_month = 12;
	$start_year = 2016;
	$end_year = 2016;
	$year = $start_year;

while ($year <= $end_year) {
  	while ($month <= $end_month) {
		$sql_premium = "SELECT SUM(cache_bruto) - SUM(cache_liquido) AS premium FROM financeiro WHERE MONTH(data_job) = '$month' AND YEAR(data_job) = '$year' AND tipo_cache = 'Cadastro Premium'";
		$sql_gratuitos = "SELECT SUM(cache_bruto) - SUM(cache_liquido) AS gratuitos FROM financeiro WHERE MONTH(data_job) = '$month' AND YEAR(data_job) = '$year' AND tipo_cache = 'Cadastro Gratuito'";
		$sql_primeiros = "SELECT SUM(cache_bruto) - SUM(cache_liquido) AS primeiros FROM financeiro WHERE MONTH(data_job) = '$month' AND YEAR(data_job) = '$year' AND tipo_cache = '1° Cache Cadastro Gratuito'";
		$sql_vendas = "SELECT SUM(valor_venda) AS vendas FROM financeiro WHERE YEAR(data_venda) = '$year' AND MONTH(data_venda) = '$month'";
		$result = mysqli_query($link, $sql_premium);
		$row = mysqli_fetch_array($result);
		$premium = $row['premium'];
			if ($premium > 0){
			${'premium'.$month.$year} = $premium;
			} else {
			${'premium'.$month.$year} = 0;
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
        ['Mês', '1º Cachê', 'Gratuito', 'Premium', 'Vendas'],
		['Jan',  <?php echo $primeiros12016;?>, <?php echo $gratuitos12016;?>, <?php echo $premium12016;?>, <?php echo $vendas12016;?>],
		['Fev',  <?php echo $primeiros22016;?>, <?php echo $gratuitos22016;?>, <?php echo $premium22016;?>, <?php echo $vendas22016;?>],
		['Mar',  <?php echo $primeiros32016;?>, <?php echo $gratuitos32016;?>, <?php echo $premium32016;?>, <?php echo $vendas32016;?>],
		['Abr',  <?php echo $primeiros42016;?>, <?php echo $gratuitos42016;?>, <?php echo $premium42016;?>, <?php echo $vendas42016;?>],
		['Mai',  <?php echo $primeiros52016;?>, <?php echo $gratuitos52016;?>, <?php echo $premium52016;?>, <?php echo $vendas52016;?>],
		['Jun',  <?php echo $primeiros62016;?>, <?php echo $gratuitos62016;?>, <?php echo $premium62016;?>, <?php echo $vendas62016;?>],
		['Jul',  <?php echo $primeiros72016;?>, <?php echo $gratuitos72016;?>, <?php echo $premium72016;?>, <?php echo $vendas72016;?>],
		['Ago',  <?php echo $primeiros82016;?>, <?php echo $gratuitos82016;?>, <?php echo $premium82016;?>, <?php echo $vendas82016;?>],
		['Set',  <?php echo $primeiros92016;?>, <?php echo $gratuitos92016;?>, <?php echo $premium92016;?>, <?php echo $vendas92016;?>],
		['Out',  <?php echo $primeiros102016;?>, <?php echo $gratuitos102016;?>, <?php echo $premium102016;?>, <?php echo $vendas102016;?>],
		['Nov',  <?php echo $primeiros112016;?>, <?php echo $gratuitos112016;?>, <?php echo $premium112016;?>, <?php echo $vendas112016;?>],
		['Dez',  <?php echo $primeiros122016;?>, <?php echo $gratuitos122016;?>, <?php echo $premium122016;?>, <?php echo $vendas122016;?>]
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
	<h1>Dashboard</h1>
    <div id="chart_div"></div>
  </body>
</html>
<?php
mysqli_close($link);
?>
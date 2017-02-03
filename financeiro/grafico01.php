<?php
include("conecta.php");
	$start_month = 1;
	$end_month = 12;
	$start_year = 2016;
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
<meta http-equiv='Content-type' content='text/html; charset=UTF-8' />
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
      ['', 'Receitas Líquidas', 'Despesas Pagas', 'Resultado'],
      ['Jan', <?php echo $receitas12016;?>, <?php echo $despesas12016;?>, <?php echo $resultado12016;?>],
      ['Fev', <?php echo $receitas22016;?>, <?php echo $despesas22016;?>, <?php echo $resultado22016;?>],
      ['Mar', <?php echo $receitas32016;?>, <?php echo $despesas32016;?>, <?php echo $resultado32016;?>],
      ['Abr', <?php echo $receitas42016;?>, <?php echo $despesas42016;?>, <?php echo $resultado42016;?>],
      ['Mai', <?php echo $receitas52016;?>, <?php echo $despesas52016;?>, <?php echo $resultado52016;?>],
      ['Jun', <?php echo $receitas62016;?>, <?php echo $despesas62016;?>, <?php echo $resultado62016;?>],
      ['Jul', <?php echo $receitas72016;?>, <?php echo $despesas72016;?>, <?php echo $resultado72016;?>],
      ['Ago', <?php echo $receitas82016;?>, <?php echo $despesas82016;?>, <?php echo $resultado82016;?>],
      ['Set', <?php echo $receitas92016;?>, <?php echo $despesas92016;?>, <?php echo $resultado92016;?>],
      ['Out', <?php echo $receitas102016;?>, <?php echo $despesas102016;?>, <?php echo $resultado102016;?>],
      ['Nov', <?php echo $receitas112016;?>, <?php echo $despesas112016;?>, <?php echo $resultado112016;?>],
      ['Dez', <?php echo $receitas122016;?>, <?php echo $despesas122016;?>, <?php echo $resultado122016;?>]
    ]);

    var options = {
      chart: {
        title: 'Performance da Empresa',
        subtitle: 'Receitas Líquidas, Despesas, e Resultado 2016',
      }
    };

    var chart = new google.charts.Bar(document.getElementById('resultado'));

    chart.draw(data, options);
  }
</script>
</head>
<body>
<center>
    <div id='resultado' style='width: 1000px; height: 400px;'></div>
  </body>
</html>
<?php
mysqli_close($link);
?>
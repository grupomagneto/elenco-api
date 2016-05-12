<?php header("Content-type: text/html; charset=ISO-8859-15");
include("conecta.php");
	$adicional = 45;
// Gr�fico 01
	$start_month = 1;
	$end_month = 12;
	$start_year = 2016;
	$end_year = 2016;
	$year = $start_year;
	$month = $start_month;
while ($year <= $end_year) {
  	while ($month <= $end_month) {
  		$sql_bruto = "SELECT SUM(cache_bruto) AS bruto FROM financeiro WHERE status_recebimento = '1' AND MONTH(data_recebimento) = '$month' AND YEAR(data_recebimento) = '$year'";
		$sql_liquido = "SELECT SUM(cache_bruto) - SUM(cache_liquido) + SUM(valor_venda) AS liquido FROM financeiro WHERE MONTH(data_job) = '$month' AND YEAR(data_job) = '$year' OR MONTH(data_venda) = '$month' AND YEAR(data_venda) = '$year'";
		$sql_despesas = "SELECT SUM(valor_despesa) AS despesas FROM financeiro WHERE YEAR(data_despesa) = '$year' AND MONTH(data_despesa) = '$month'";
		$result = mysqli_query($link, $sql_liquido);
		$row = mysqli_fetch_array($result);
		$liquido = $row['liquido'];
			if ($liquido > 0){
			${'liquido'.$month.$year} = $liquido;
			} else {
			${'liquido'.$month.$year} = 0;
			}
		$result2 = mysqli_query($link, $sql_despesas);
		$row2 = mysqli_fetch_array($result2);
		$despesas = $row2['despesas'];
			if ($despesas > 0){
			${'despesas'.$month.$year} = $despesas;
			} else {
			${'despesas'.$month.$year} = 0;
			}
		$result3 = mysqli_query($link, $sql_bruto);
		$row3 = mysqli_fetch_array($result3);
		$bruto = $row3['bruto'];
			if ($bruto > 0){
			${'bruto'.$month.$year} = $bruto;
			} else {
			${'bruto'.$month.$year} = 0;
			}
			${'resultado'.$month.$year} = ${'liquido'.$month.$year} - ${'despesas'.$month.$year};
			$month++;
	}
	$year++;
	$month = 1;
}

// Gr�fico 02
	$start_mes = 1;
	$end_mes = 12;
	$start_ano = 2016;
	$end_ano = 2016;
	$ano = $start_ano;
	$mes = $start_mes;

while ($ano <= $end_ano) {
  	while ($mes <= $end_mes) {
		$comando_pago = "SELECT SUM(cache_bruto) - SUM(cache_liquido) AS pago FROM financeiro WHERE MONTH(data_job) = '$mes' AND YEAR(data_job) = '$ano' AND tipo_cache = 'Cadastro Premium'";
		$comando_gratuitos = "SELECT SUM(cache_bruto) - SUM(cache_liquido) AS gratuitos FROM financeiro WHERE MONTH(data_job) = '$mes' AND YEAR(data_job) = '$ano' AND tipo_cache = 'Cadastro Gratuito'";
		$comando_primeiros = "SELECT SUM(cache_bruto) - SUM(cache_liquido) AS primeiros FROM financeiro WHERE MONTH(data_job) = '$mes' AND YEAR(data_job) = '$ano' AND tipo_cache = '1� Cach� Cadastro Gratuito'";
		$comando_vendas = "SELECT SUM(valor_venda) AS vendas FROM financeiro WHERE forma_pagamento <> 'Abatimento de Cach�' AND YEAR(data_venda) = '$ano' AND MONTH(data_venda) = '$mes'";
		$comando_abatimento = "SELECT SUM(valor_venda) AS abatimento FROM financeiro WHERE forma_pagamento = 'Abatimento de Cach�' AND YEAR(data_venda) = '$ano' AND MONTH(data_venda) = '$mes'";
		$igual = mysqli_query($link, $comando_pago);
		$linha = mysqli_fetch_array($igual);
		$pago = $linha['pago'];
			if ($pago > 0){
			${'pago'.$mes.$ano} = $pago;
			} else {
			${'pago'.$mes.$ano} = 0;
			}
		$igual2 = mysqli_query($link, $comando_primeiros);
		$linha2 = mysqli_fetch_array($igual2);
		$primeiros = $linha2['primeiros'];
			if ($primeiros > 0){
			${'primeiros'.$mes.$ano} = $primeiros;
			} else {
			${'primeiros'.$mes.$ano} = 0;
			}
		$igual3 = mysqli_query($link, $comando_vendas);
		$linha3 = mysqli_fetch_array($igual3);
		$vendas = $linha3['vendas'];
			if ($vendas > 0){
			${'vendas'.$mes.$ano} = $vendas;
			} else {
			${'vendas'.$mes.$ano} = 0;
			}
		$igual4 = mysqli_query($link, $comando_gratuitos);
		$linha4 = mysqli_fetch_array($igual4);
		$gratuitos = $linha4['gratuitos'];
			if ($gratuitos > 0){
			${'gratuitos'.$mes.$ano} = $gratuitos;
			} else {
			${'gratuitos'.$mes.$ano} = 0;
			}
		$igual5 = mysqli_query($link, $comando_abatimento);
		$linha5 = mysqli_fetch_array($igual5);
		$abatimento = $linha5['abatimento'];
			if ($abatimento > 0){
			${'abatimento'.$mes.$ano} = $abatimento;
			} else {
			${'abatimento'.$mes.$ano} = 0;
			}
			$mes++;
	}
	$ano++;
	$mes = 1;
}
// Gr�fico 03
	$sql_recebido = "SELECT SUM(cache_bruto) AS recebido FROM financeiro WHERE MONTH(data_recebimento) = MONTH(CURRENT_DATE) AND YEAR(data_recebimento) = YEAR(CURRENT_DATE) AND status_recebimento = 1";
		$igual = mysqli_query($link, $sql_recebido);
		$linha = mysqli_fetch_array($igual);
		$recebido = $linha['recebido'];

	$sql_caches_pagos = "SELECT SUM(cache_liquido) - SUM(abatimento_cache) AS caches_pagos FROM financeiro WHERE MONTH(data_pagamento) = MONTH(CURRENT_DATE) AND YEAR(data_pagamento) = YEAR(CURRENT_DATE) AND status_pagamento = 1";
		$igual = mysqli_query($link, $sql_caches_pagos);
		$linha = mysqli_fetch_array($igual);
		$caches_pagos = $linha['caches_pagos'];

	$sql_despesas = "SELECT SUM(valor_despesa) AS despesas FROM financeiro WHERE YEAR(data_despesa) = YEAR(CURRENT_DATE) AND MONTH(data_despesa) = MONTH(CURRENT_DATE)";
		$igual = mysqli_query($link, $sql_despesas);
		$linha = mysqli_fetch_array($igual);
		$despesas = $linha['despesas'];

	$saldo = $recebido - $caches_pagos - $despesas;

// Gr�fico 04 (barras)
// 	$start_mes = 1;
// 	$end_mes = 12;
// 	$start_ano = 2016;
// 	$end_ano = 2016;
// 	$ano = $start_ano;
// 	$mes = $start_mes;
// while ($ano <= $end_ano) {
//   	while ($mes <= $end_mes) {
// 	$sql_previsto = "SELECT SUM(cache_bruto) AS previsto FROM financeiro WHERE MONTH(data_job + INTERVAL previsao_pagamento DAY) = '$mes' AND year(data_job + INTERVAL previsao_pagamento DAY) = '$ano'";
// 		$igual = mysqli_query($link, $sql_previsto);
// 		$linha = mysqli_fetch_array($igual);
// 		$previsto = $linha['previsto'];
// 			if ($previsto > 0){
// 			${'previsto'.$mes.$ano} = $previsto;
// 			} else {
// 			${'previsto'.$mes.$ano} = 0;
// 			}

// 	$sql_pg_recebido = "SELECT SUM(cache_bruto) AS pg_recebido FROM financeiro WHERE MONTH(data_recebimento) = '$mes' AND YEAR(data_recebimento) = '$ano' AND status_recebimento = 1";
// 	$igual = mysqli_query($link, $sql_pg_recebido);
// 	$linha = mysqli_fetch_array($igual);
// 	$pg_recebido = $linha['pg_recebido'];
// 		if ($pg_recebido > 0){
// 		${'pg_recebido'.$mes.$ano} = $pg_recebido;
// 		} else {
// 		${'pg_recebido'.$mes.$ano} = 0;
// 		}

// 		${'atrasado'.$mes.$ano} = ${'previsto'.$mes.$ano} - ${'pg_recebido'.$mes.$ano};
// 		$mes++;
// }
// $ano++;
// $mes = 1;
// }

//Gr�fico 04 (linhas)
	$start_month = 1;
	$end_month = 12;
	$start_year = 2016;
	$end_year = 2016;
	$year = $start_year;
	$month = $start_month;
while ($year <= $end_year) {
  	while ($month <= $end_month) {
	$sql_totais = "SELECT * FROM (SELECT SUM(cache_bruto) AS bruto_recebido FROM financeiro WHERE status_recebimento = '1' AND MONTH(data_recebimento) = '$month' AND YEAR(data_recebimento) = '$year') A CROSS JOIN 
(SELECT SUM(cache_bruto) AS bruto_a_receber FROM financeiro WHERE MONTH(data_job + INTERVAL previsao_pagamento DAY) = '$month' AND year(data_job + INTERVAL previsao_pagamento DAY) = '$year' AND status_recebimento = '0') B CROSS JOIN 
(SELECT SUM(valor_despesa) AS despesas_pagas FROM financeiro WHERE YEAR(data_despesa) = '$year' AND MONTH(data_despesa) = '$month' AND status_despesa = '1') C CROSS JOIN
(SELECT SUM(valor_original_despesa) AS despesas_a_pagar FROM financeiro WHERE YEAR(data_venc_despesa) = '$year' AND MONTH(data_venc_despesa) = '$month' AND status_despesa = '0') D CROSS JOIN
(SELECT SUM(cache_liquido) - SUM(abatimento_cache) AS caches_pagos FROM financeiro WHERE MONTH(data_pagamento) = '$month' AND YEAR(data_pagamento) = '$year' AND status_pagamento = '1') E CROSS JOIN
(SELECT SUM(cache_liquido) AS caches_a_pagar FROM financeiro WHERE MONTH(data_job + INTERVAL previsao_pagamento + $adicional DAY) = '$month' AND year(data_job + INTERVAL previsao_pagamento + $adicional DAY) = '$year' AND status_pagamento = '0') F";
		$result = mysqli_query($link, $sql_totais);
		$row = mysqli_fetch_array($result);
		$bruto_recebido = $row['bruto_recebido'];
		$bruto_a_receber = $row['bruto_a_receber'];
		$despesas_pagas = $row['despesas_pagas'];
		$despesas_a_pagar = $row['despesas_a_pagar'];
		$cache_pagos = $row['caches_pagos'];
		$caches_a_pagar = $row['caches_a_pagar'];
		if ($bruto_recebido > 0){
		${'bruto_recebido'.$month.$year} = $bruto_recebido;
		} else {
		${'bruto_recebido'.$month.$year} = 0;
		}
		if ($bruto_a_receber > 0){
		${'bruto_a_receber'.$month.$year} = $bruto_a_receber;
		} else {
		${'bruto_a_receber'.$month.$year} = 0;
		}
		if ($despesas_pagas > 0){
		${'despesas_pagas'.$month.$year} = $despesas_pagas;
		} else {
		${'despesas_pagas'.$month.$year} = 0;
		}
		if ($despesas_a_pagar > 0){
		${'despesas_a_pagar'.$month.$year} = $despesas_a_pagar;
		} else {
		${'despesas_a_pagar'.$month.$year} = 0;
		}
		if ($cache_pagos > 0){
		${'cache_pagos'.$month.$year} = $cache_pagos;
		} else {
		${'cache_pagos'.$month.$year} = 0;
		}
		if ($caches_a_pagar > 0){
		${'caches_a_pagar'.$month.$year} = $caches_a_pagar;
		} else {
		${'caches_a_pagar'.$month.$year} = 0;
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
	table, th, td {
	   border: 0px solid #ccc;
	}
	</style>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  	google.charts.load('current', {packages: ['corechart', 'bar', 'line']});
	google.charts.setOnLoadCallback(grafico01);
	google.charts.setOnLoadCallback(grafico02);
	google.charts.setOnLoadCallback(grafico03);
	google.charts.setOnLoadCallback(grafico04);
  function grafico01() {
    var data = google.visualization.arrayToDataTable([
      ['', 'Bruto Recebido', 'L�quido Gerado', 'Despesas Pagas', 'Resultado'],
      ['Jan', <?php echo $bruto12016;?>, <?php echo $liquido12016;?>, <?php echo $despesas12016;?>, <?php echo $resultado12016;?>],
      ['Fev', <?php echo $bruto22016;?>, <?php echo $liquido22016;?>, <?php echo $despesas22016;?>, <?php echo $resultado22016;?>],
      ['Mar', <?php echo $bruto32016;?>, <?php echo $liquido32016;?>, <?php echo $despesas32016;?>, <?php echo $resultado32016;?>],
      ['Abr', <?php echo $bruto42016;?>, <?php echo $liquido42016;?>, <?php echo $despesas42016;?>, <?php echo $resultado42016;?>],
      ['Mai', <?php echo $bruto52016;?>, <?php echo $liquido52016;?>, <?php echo $despesas52016;?>, <?php echo $resultado52016;?>],
      ['Jun', <?php echo $bruto62016;?>, <?php echo $liquido62016;?>, <?php echo $despesas62016;?>, <?php echo $resultado62016;?>],
      ['Jul', <?php echo $bruto72016;?>, <?php echo $liquido72016;?>, <?php echo $despesas72016;?>, <?php echo $resultado72016;?>],
      ['Ago', <?php echo $bruto82016;?>, <?php echo $liquido82016;?>, <?php echo $despesas82016;?>, <?php echo $resultado82016;?>],
      ['Set', <?php echo $bruto92016;?>, <?php echo $liquido92016;?>, <?php echo $despesas92016;?>, <?php echo $resultado92016;?>],
      ['Out', <?php echo $bruto102016;?>, <?php echo $liquido102016;?>, <?php echo $despesas102016;?>, <?php echo $resultado102016;?>],
      ['Nov', <?php echo $bruto112016;?>, <?php echo $liquido112016;?>, <?php echo $despesas112016;?>, <?php echo $resultado112016;?>],
      ['Dez', <?php echo $bruto122016;?>, <?php echo $liquido122016;?>, <?php echo $despesas122016;?>, <?php echo $resultado122016;?>]
    ]);

    var options = {
      colors: ['#4285f4', '#36802d', '#db4437', '#f4b400'],
      chart: {
        title: 'Performance da Empresa',
        subtitle: 'em 1000 Reais (R$)'
      }
    };

    var chart = new google.charts.Bar(document.getElementById('grafico-01'));
    chart.draw(data, options);
  }
  function grafico02() {
      var data = google.visualization.arrayToDataTable([
        ['', '1� Cach� em R$', 'Gratuito em R$', 'Premium em R$', 'Vendas em R$', 'Abatimento de Cach�s em R$', {role: 'style'}],
		['Jan',  <?php echo $primeiros12016;?>, <?php echo $gratuitos12016;?>, <?php echo $pago12016;?>, <?php echo $vendas12016;?>, <?php echo $abatimento12016;?>, ''],
		['Fev',  <?php echo $primeiros22016;?>, <?php echo $gratuitos22016;?>, <?php echo $pago22016;?>, <?php echo $vendas22016;?>, <?php echo $abatimento22016;?>, ''],
		['Mar',  <?php echo $primeiros32016;?>, <?php echo $gratuitos32016;?>, <?php echo $pago32016;?>, <?php echo $vendas32016;?>, <?php echo $abatimento32016;?>, ''],
		['Abr',  <?php echo $primeiros42016;?>, <?php echo $gratuitos42016;?>, <?php echo $pago42016;?>, <?php echo $vendas42016;?>, <?php echo $abatimento42016;?>, ''],
		['Mai',  <?php echo $primeiros52016;?>, <?php echo $gratuitos52016;?>, <?php echo $pago52016;?>, <?php echo $vendas52016;?>, <?php echo $abatimento52016;?>, ''],
		['Jun',  <?php echo $primeiros62016;?>, <?php echo $gratuitos62016;?>, <?php echo $pago62016;?>, <?php echo $vendas62016;?>, <?php echo $abatimento62016;?>, ''],
		['Jul',  <?php echo $primeiros72016;?>, <?php echo $gratuitos72016;?>, <?php echo $pago72016;?>, <?php echo $vendas72016;?>, <?php echo $abatimento72016;?>, ''],
		['Ago',  <?php echo $primeiros82016;?>, <?php echo $gratuitos82016;?>, <?php echo $pago82016;?>, <?php echo $vendas82016;?>, <?php echo $abatimento82016;?>, ''],
		['Set',  <?php echo $primeiros92016;?>, <?php echo $gratuitos92016;?>, <?php echo $pago92016;?>, <?php echo $vendas92016;?>, <?php echo $abatimento92016;?>, ''],
		['Out',  <?php echo $primeiros102016;?>, <?php echo $gratuitos102016;?>, <?php echo $pago102016;?>, <?php echo $vendas102016;?>, <?php echo $abatimento102016;?>, ''],
		['Nov',  <?php echo $primeiros112016;?>, <?php echo $gratuitos112016;?>, <?php echo $pago112016;?>, <?php echo $vendas112016;?>, <?php echo $abatimento112016;?>, ''],
		['Dez',  <?php echo $primeiros122016;?>, <?php echo $gratuitos122016;?>, <?php echo $pago122016;?>, <?php echo $vendas122016;?>, <?php echo $abatimento122016;?>, '']
      ]);

      var options = {
        title: 'An�lise da Origem da Receita L�quida',
        chartArea: {width: '50%'},
        isStacked: true,
        // hAxis: {
        //   title: '',
        //   minValue: 0,
        // },
        // vAxis: {
        //   title: ''
        // }
        series: {
		    0:{color:'#234d20'},
		    1:{color:'#36802d'},
		    2:{color:'#77ab59'},
		    3:{color:'#c9df8a'},
		    4:{color:'#ebf9c4'}
		}
      };
      var chart = new google.visualization.BarChart(document.getElementById('grafico-02'));
      chart.draw(data, options);
    }
    function grafico03() {
      var data = google.visualization.arrayToDataTable([
        ["Opera��o", "Valores em R$", { role: "style" }],
        ["Bruto Recebido", <?php echo $recebido;?>, "#4285f4"],
        ["Cach�s Pagos", <?php echo $caches_pagos;?>, "#872bb7"],
        ["Despesas Pagas", <?php echo $despesas;?>, "#db4437"],
        ["Saldo", <?php echo $saldo;?>, "#f4b400"]
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Fluxo de Caixa do M�s",
        width: 500,
        height: 350,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("grafico-03"));
      chart.draw(view, options);
  }
  // function grafico04() {
  //       var data = google.visualization.arrayToDataTable([
	 //      ['M�s', 'Recebido', 'Previsto', 'Atrasado'],
	 //      ['Jan', <?php echo $pg_recebido12016;?>, <?php echo $previsto12016;?>, <?php echo $atrasado12016;?>],
	 //      ['Fev', <?php echo $pg_recebido22016;?>, <?php echo $previsto22016;?>, <?php echo $atrasado22016;?>],
	 //      ['Mar', <?php echo $pg_recebido32016;?>, <?php echo $previsto32016;?>, <?php echo $atrasado32016;?>],
	 //      ['Abr', <?php echo $pg_recebido42016;?>, <?php echo $previsto42016;?>, <?php echo $atrasado42016;?>],
	 //      ['Mai', <?php echo $pg_recebido52016;?>, <?php echo $previsto52016;?>, <?php echo $atrasado52016;?>],
	 //      ['Jun', <?php echo $pg_recebido62016;?>, <?php echo $previsto62016;?>, <?php echo $atrasado62016;?>],
	 //      ['Jul', <?php echo $pg_recebido72016;?>, <?php echo $previsto72016;?>, <?php echo $atrasado72016;?>],
	 //      ['Ago', <?php echo $pg_recebido82016;?>, <?php echo $previsto82016;?>, <?php echo $atrasado82016;?>],
	 //      ['Set', <?php echo $pg_recebido92016;?>, <?php echo $previsto92016;?>, <?php echo $atrasado92016;?>],
	 //      ['Out', <?php echo $pg_recebido102016;?>, <?php echo $previsto102016;?>, <?php echo $atrasado102016;?>],
	 //      ['Nov', <?php echo $pg_recebido112016;?>, <?php echo $previsto112016;?>, <?php echo $atrasado112016;?>],
	 //      ['Dez', <?php echo $pg_recebido122016;?>, <?php echo $previsto122016;?>, <?php echo $atrasado122016;?>]
  //       ]);

  //       var options = {
  //         chart: {
  //           title: 'Pagamentos',
  //           subtitle: 'Recebido, a Receber e Atrasado',
  //         },
  //         bars: 'vertical',
  //         vAxis: {format: 'decimal'},
  //         colors: ['#1b9e77', '#d95f02', '#7570b3']
  //       };

  //       var chart = new google.charts.Bar(document.getElementById('grafico-04'));
	 //    chart.draw(data, options);

  //     }
    function grafico04() {

   //    var data = new google.visualization.DataTable();
   //    data.addColumn('number', 'Bruto Recebido');
   //    data.addColumn('number', 'Bruto a receber');
   //    data.addColumn('number', 'Despesas pagas');
   //    data.addColumn('number', 'Despesas a pagar');
	  // data.addColumn('number', 'Cach�s Pagos');
	  // data.addColumn('number', 'Cach�s a pagar');
	        // data.addRows([
		var data = google.visualization.arrayToDataTable([
		['', 'Cach�s a pagar', 'Despesas a pagar', 'Bruto a receber', 'Cach�s Pagos', 'Despesas pagas', 'Bruto Recebido'],
		['Jan', <?php echo $caches_a_pagar12016;?>, <?php echo $despesas_a_pagar12016;?>, <?php echo $bruto_a_receber12016;?>, <?php echo $cache_pagos12016;?>, <?php echo $despesas_pagas12016;?>, <?php echo $bruto_recebido12016;?>],
		['Fev', <?php echo $caches_a_pagar22016;?>, <?php echo $despesas_a_pagar22016;?>, <?php echo $bruto_a_receber22016;?>, <?php echo $cache_pagos22016;?>, <?php echo $despesas_pagas22016;?>, <?php echo $bruto_recebido22016;?>],
		['Mar', <?php echo $caches_a_pagar32016;?>, <?php echo $despesas_a_pagar32016;?>, <?php echo $bruto_a_receber32016;?>, <?php echo $cache_pagos32016;?>, <?php echo $despesas_pagas32016;?>, <?php echo $bruto_recebido32016;?>],
		['Abr', <?php echo $caches_a_pagar42016;?>, <?php echo $despesas_a_pagar42016;?>, <?php echo $bruto_a_receber42016;?>, <?php echo $cache_pagos42016;?>, <?php echo $despesas_pagas42016;?>, <?php echo $bruto_recebido42016;?>],
		['Mai', <?php echo $caches_a_pagar52016;?>, <?php echo $despesas_a_pagar52016;?>, <?php echo $bruto_a_receber52016;?>, <?php echo $cache_pagos52016;?>, <?php echo $despesas_pagas52016;?>, <?php echo $bruto_recebido52016;?>],
		['Jun', <?php echo $caches_a_pagar62016;?>, <?php echo $despesas_a_pagar62016;?>, <?php echo $bruto_a_receber62016;?>, <?php echo $cache_pagos62016;?>, <?php echo $despesas_pagas62016;?>, <?php echo $bruto_recebido62016;?>],
		['Jul', <?php echo $caches_a_pagar72016;?>, <?php echo $despesas_a_pagar72016;?>, <?php echo $bruto_a_receber72016;?>, <?php echo $cache_pagos72016;?>, <?php echo $despesas_pagas72016;?>, <?php echo $bruto_recebido72016;?>],
		['Ago', <?php echo $caches_a_pagar82016;?>, <?php echo $despesas_a_pagar82016;?>, <?php echo $bruto_a_receber82016;?>, <?php echo $cache_pagos82016;?>, <?php echo $despesas_pagas82016;?>, <?php echo $bruto_recebido82016;?>],
		['Set', <?php echo $caches_a_pagar92016;?>, <?php echo $despesas_a_pagar92016;?>, <?php echo $bruto_a_receber92016;?>, <?php echo $cache_pagos92016;?>, <?php echo $despesas_pagas92016;?>, <?php echo $bruto_recebido92016;?>],
		['Out', <?php echo $caches_a_pagar102016;?>, <?php echo $despesas_a_pagar102016;?>, <?php echo $bruto_a_receber102016;?>, <?php echo $cache_pagos102016;?>, <?php echo $despesas_pagas102016;?>, <?php echo $bruto_recebido102016;?>],
		['Nov', <?php echo $caches_a_pagar112016;?>, <?php echo $despesas_a_pagar112016;?>, <?php echo $bruto_a_receber112016;?>, <?php echo $cache_pagos112016;?>, <?php echo $despesas_pagas112016;?>, <?php echo $bruto_recebido112016;?>],
		['Dez', <?php echo $caches_a_pagar122016;?>, <?php echo $despesas_a_pagar122016;?>, <?php echo $bruto_a_receber122016;?>, <?php echo $cache_pagos122016;?>, <?php echo $despesas_pagas122016;?>, <?php echo $bruto_recebido122016;?>]
		]);

      var options = {
        chart: {
          title: 'An�lise do Fluxo de Caixa',
          subtitle: 'em 1000 Reais (R$)'
        },
		colors: ['#f4e3fd', '#fae3e1', '#e3edfd', '#872bb7', '#db4437', '#4285f4'],
		// legend: [ position: 'bottom' ],
        width: 1000,
        height: 350
      };

      var chart = new google.charts.Line(document.getElementById('grafico-04'));
      chart.draw(data, options);
    }
</script>
</head>
<body>
<center>
<table>
	<tr>
	<td><div id="grafico-01" style="width: 1000px; height: 350px"></div></td>
	<td><div id="grafico-03" style="width: 500px; height: 350px"></div></td>
	</tr>
	<tr>
	<td><div id="grafico-04" style="width: 1000px; height: 350px"></div></td>
	<td><div id="grafico-02" style="width: 500px; height: 350px"></div></td>
	</tr>
</table>
  </body>
</html>
<?php
mysqli_close($link);
?>
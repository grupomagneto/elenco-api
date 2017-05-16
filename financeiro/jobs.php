<?php
include("conecta.php");
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' lang="pt-BR">
<head>
<meta http-equiv='Content-type' content='text/html; charset=UTF-8' />
<title>Jobs - Magneto Elenco</title>
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Roboto:300,300italic,900,900italic,400,400italic' />
<link rel='stylesheet' type='text/css' href='DataTables/datatables.min.css'/>
<link rel='stylesheet' type='text/css' href='DataTables/style.css'/>
	<style type='text/css'>
	h1 { font-family: 'Roboto', sans-serif; font-weight: 400; }
	p { font-family: 'Roboto', sans-serif; font-weight: 300; }
	.set-width {
	  width: 85px;
	}
	#cento_vinte {
		color: red;
	}
	#noventa {
		color: red;
	}
	#sessenta {
		color: orange;
	}
	#em_dia {
		color: green;
	}
	</style>
<script type='text/javascript' src='http://code.jquery.com/jquery-latest.min.js'></script>
<script type='text/javascript' src='DataTables/datatables.min.js'></script>
<script type='text/javascript'>
$(document).ready(function(){
    $('#resultado').DataTable( {
		"aaSorting": [[0,'asc'], [1,'asc']]
    } );
} );
</script>
</head>
<body>
<center><div>
	<h1>Jobs</h1>
<?php
	$hoje = date('Y-m-d', time());
	$result = mysqli_query($link, "SELECT data_job, campanha, cliente_job, produzido_por, status_recebimento, data_recebimento, id, SUM(cache_bruto) AS valor, COUNT(nome) AS quantidade, emitiu_nota, n_nota_fiscal, data_nota, SUM(cache_bruto) - SUM(cache_liquido) AS lucro FROM financeiro WHERE tipo_entrada = 'cache' AND (status_recebimento = 0 OR status_recebimento IS NULL) GROUP BY data_job, campanha, cliente_job, produzido_por UNION ALL SELECT data_job, campanha, cliente_job, produzido_por, status_recebimento, data_recebimento, id, SUM(cache_bruto) AS valor, COUNT(nome) AS quantidade, emitiu_nota, n_nota_fiscal, data_nota, SUM(cache_bruto) - SUM(cache_liquido) AS lucro FROM financeiro WHERE tipo_entrada = 'cache'  AND status_recebimento = 1 GROUP BY data_job, campanha, cliente_job, produzido_por ORDER BY data_job DESC");
		if (!$result) {
		 die("Database query failed: " . mysqli_error());
}
?>
	<table id='resultado' class='compact nowrap stripe hover row-border order-column' cellspacing='0' width='100%'>
		<thead>
 			<tr>
     			<th>Status</th>
				<th>Data do Job</th>
     			<th>Produtora - Cliente - Campanha</th>
				<th>Participantes</th>
				<th>Bruto</th>
				<th>Líquido</th>
				<th>Nº da Nota</th>
				<th>Nota Fiscal</th>
	  			<th>Recebimento</th>
			</tr>
		</thead>
		<tbody>
<?php
	while ($row = mysqli_fetch_array($result)) {
		$id = $row['id'];
		$_SESSION['data_job'.$id] = $row['data_job'];
		$_SESSION['produzido_por'.$id] = $row['produzido_por'];
		$_SESSION['cliente_job'.$id] = $row['cliente_job'];
		$_SESSION['campanha'.$id] = $row['campanha'];
		$_SESSION['status_recebimento'.$id] = $row['status_recebimento'];
		$status = $row['status_recebimento'];
		$_SESSION['quantidade'.$id] = $row['quantidade'];
		$valor = $row['valor'];
		$valor_format = number_format($valor,2,",","");
		$lucro = number_format($row['lucro'],2,",","");
		$_SESSION['data_recebimento'.$id] = $row['data_recebimento'];
		$sessenta = date('Y-m-d', strtotime($row['data_job']. ' + 60 days'));
		$noventa = date('Y-m-d', strtotime($row['data_job']. ' + 90 days'));	
		$cento_vinte = date('Y-m-d', strtotime($row['data_job']. ' + 120 days'));
		$_SESSION['emitiu_nota'.$id] = $row['emitiu_nota'];
		$_SESSION['n_nota_fiscal'.$id] = $row['n_nota_fiscal'];
		$_SESSION['data_nota'.$id] = $row['data_nota'];
echo " 			<tr>";
echo "     			<td>";
					if ($status == 1) {
					    echo "(5) Recebido";
					} elseif ($status == 0 && $hoje >= $sessenta && $hoje < $noventa) {
					    echo "<div id='sessenta'><strong>(3) Atrasado (60+)</strong></div>";
					} elseif ($status == 0 && $hoje >= $noventa && $hoje < $cento_vinte) {
					    echo "<div id='noventa'><strong>(2) Atrasado (90+)</strong></div>";
					} elseif ($status == 0 && $hoje >= $cento_vinte) {
					    echo "<div id='cento_vinte'><strong>(1) Atrasado (120+)</strong></div>";
					} elseif ($status == 0 && $hoje <= $sessenta) {
					    echo "<div id='em_dia'>(4) A Receber (60-)</div>";
					}
echo "				</td>";
echo "     			<td>".$row['data_job']."</td>";
echo "     			<td>".$row['produzido_por']." - ".$row['cliente_job']." - ".$row['campanha']."</td>";
echo "     			<td>".$row['quantidade']."</td>";
echo "     			<td><strong>R$ ".$valor_format."</strong></td>";
echo "     			<td>R$ ".$lucro."</td>";
					if ($row['emitiu_nota'] == 1) {
					    echo "<td>".$row['n_nota_fiscal']."</td>";
					} else {
						echo "<td>--</td>";
					}
echo "				<td><form id='nota".$id."' method='post' action='action_nota.php' target='resultado".$id."'><input type='hidden' name='id' value='$id'><button type='button' id='emitir".$id."'>Alterar</button></form></td>";
echo "				<script type='text/javascript'>
						document.getElementById('emitir".$id."').addEventListener('click', function() {
							window.open('action_nota.php', 'resultado".$id."', 'toolbar=no,scrollbars=no,directories=no,titlebar=yes,resizable=no,location=no,status=no,menubar=no,top=300,left=300,width=400,height=400');
							document.getElementById('nota".$id."').submit();
						});
					</script>";
echo "				<form id='form_receber".$id."' action='action_jobs.php' method='post'>";
echo "     			<td><input type='text' name='nova_data_recebimento".$id."' size='10' class='input' ";
					if ($row['data_recebimento'] != NULL) {
					    echo "value='".$row['data_recebimento']."'> <button name='id' id='receber".$id."' value='$id' type='submit'>Receber</button></form></td>";
					} else {
						echo "placeholder='$hoje' value=''> <button name='id' value='$id' type='submit'>Receber</button></form></td>";
					}
echo " 			</tr>";
}
	$result2 = mysqli_query($link, "SELECT SUM(cache_bruto) AS bruto, SUM(cache_bruto) - SUM(cache_liquido) as liquido FROM financeiro WHERE status_recebimento=0");
		if (!$result2) {
		 die("Database query failed: " . mysqli_error());
}
	while ($row2 = mysqli_fetch_array($result2)) {
		$bruto = number_format($row2['bruto'],2,",",".");
		$liquido = number_format($row2['liquido'],2,",",".");
}
?>
		</tbody>
		<tr>
			<th>A Receber</th>
 			<th></th>
 			<th></th>
 			<th></th>
			<th><?php echo "R$: $bruto"; ?></th>
 			<th><?php echo "R$: $liquido"; ?></th>
 			<th></th>
 			<th></th>
		</tr>
	</table>
</div></center>
</body>
</html>
<?php
mysqli_close($link);
?>
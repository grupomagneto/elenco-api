<?php header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('America/Sao_Paulo');
if(!session_id()) {
    session_start();
}
include("conecta.php");
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' lang="pt-BR">
<head>
<meta http-equiv='Content-type' content='text/html; charset=utf-8' />
<title>Caches - Magneto Elenco</title>
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Roboto:300,300italic,900,900italic,400,400italic' />
<link rel='stylesheet' type='text/css' href='DataTables/datatables.min.css'/>
<link rel='stylesheet' type='text/css' href='DataTables/style.css'/>
	<style type='text/css'>
	h1 { font-family: 'Roboto', sans-serif; font-weight: 400; }
	p { font-family: 'Roboto', sans-serif; font-weight: 300; }
	.set-width {
	  width: 85px;
	}
	#alerta {
		color: red;
	}
	#no_prazo {
		color: orange;
	}
	#ok {
		color: green;
	}
		input[type='number'] {
	   width:50px;
	}
	</style>
<script type='text/javascript' src='http://code.jquery.com/jquery-latest.min.js'></script>
<script type='text/javascript' src='DataTables/datatables.min.js'></script>
<script type='text/javascript'>
$(document).ready(function(){
    $('#resultado').DataTable( {
		"aaSorting": [[0,'asc'], [5,'asc']]
    } );
} );
</script>
</head>
<body>
<center><div>
	<h1>Transferências</h1>
<?php
	$hoje = date('d-m-Y', time());
	$result = mysqli_query($link, "SELECT id, nome, email, id_elenco_financeiro, status_pagamento, request_timestamp, bank_number, bank_name, bank_agency, bank_account, cpf, full_name, from_account, produzido_por, cliente_job, campanha, (SUM(cache_liquido) - ifnull(SUM(abatimento_cache), 0) - ifnull(SUM(valor_pago), 0)) AS valor FROM financeiro WHERE request_timestamp IS NOT NULL AND status_pagamento<>'1' GROUP BY id_elenco_financeiro ORDER BY request_timestamp ASC");
?>
	<table id='resultado' class='compact nowrap stripe hover row-border order-column' cellspacing='0' width='100%'>
		<thead>
 			<tr>
				<th>Data</th>
				<th>Banco</th>
				<th>Agência</th>
				<th>Conta</th>
				<th>CPF</th>
				<th>Favorecido</th>
				<!-- <th>Job</th> -->
				<th>Valor</th>
				<th>Conta Remessa</th>
				<th>Operação</th>
			</tr>
		</thead>
		<tbody>
<?php
	while ($row = mysqli_fetch_array($result)) {
		$id = $row['id_elenco_financeiro'];
		// $job = $row['produzido_por']." - ".$row['cliente_job']." - ".$row['campanha'];
		$status_pagamento = $row['status_pagamento'];
		$request_timestamp = date('d-m-Y', strtotime($row['request_timestamp']));
		$bank_number = $row['bank_number'];
		$bank_name = $row['bank_name'];
		$bank = $bank_number." - ".$bank_name;
		$bank_agency = $row['bank_agency'];
		$bank_account = $row['bank_account'];
		$cpf = $row['cpf'];
		$full_name = $row['full_name'];
		$nome = $row['nome'];
		$email = $row['email'];
		$taxa = 10;
		$from_account = "13.001.386-8";
		$valor = $row['valor'] - $taxa;
		$valor = number_format($valor,2,",",".");
echo " 			<tr>";
echo "     			<td>";
echo "<form id='transferencia".$id."' method='post' action='action_transferencias.php'>";
					if  ($hoje < date('d-m-Y', strtotime($request_timestamp."+1 WEEKDAY"))) {
					    echo "<div id='ok'><strong>$request_timestamp</strong></div>";
					} elseif ($hoje < date('d-m-Y', strtotime($request_timestamp."+2 WEEKDAYS"))) {
					    echo "<div id='no_prazo'><strong>$request_timestamp</strong></div>";
					} elseif ($hoje < date('d-m-Y', strtotime($request_timestamp."+3 WEEKDAYS")) || $hoje >= date('d-m-Y', strtotime($request_timestamp."+3 WEEKDAYS"))) {
					    echo "<div id='alerta'><strong>$request_timestamp</strong></div>";
					}
echo "				</td>";
echo "     			<td>$bank<input type='hidden' name='bank' value='$bank' /></td>";
echo "     			<td>$bank_agency<input type='hidden' name='bank_agency' value='$bank_agency' /></td>";
echo "     			<td>$bank_account<input type='hidden' name='bank_account' value='$bank_account' /></td>";
echo "     			<td>$cpf<input type='hidden' name='cpf' value='$cpf' /></td>";
echo "     			<td>$full_name<input type='hidden' name='full_name' value='$full_name' /></td>";
// echo "     			<td>".$job."</td>";
echo "     			<td>R$ $valor<input type='hidden' name='valor' value='$valor' /></td>";
echo "     			<td>$from_account<input type='hidden' name='from_account' value='$from_account' /></td>";
echo "
<td>
<button type='submit'>
<input type='hidden' name='id_elenco' value='$id' />
<input type='hidden' name='email' value='$email' />
<input type='hidden' name='nome' value='$nome' />
Transferir</button>
</form></td>";
echo " 			</tr>";
}
$result2 = mysqli_query($link, "SELECT (SUM(cache_liquido) - ifnull(SUM(abatimento_cache), 0) - ifnull(SUM(valor_pago), 0)) AS total FROM financeiro WHERE request_timestamp IS NOT NULL AND status_pagamento<>'1' AND id_elenco_financeiro IS NOT NULL AND tipo_entrada = 'cache'");
$row2 = mysqli_fetch_array($result2);
$total = $row2['total'];
$total_format = number_format($total,2,",",".");

?>
		</tbody>
		<tr>
			<th>A pagar</th>
 			<th></th>
 			<th></th>
 			<th></th>
 			<th></th>
			<th></th>
 			<th></th>
 			<th><?php echo "R$: $total_format"; ?></th>
 			<th></th>
		</tr>
	</table>
</div></center>
</body>
</html>
<?php
 mysqli_close($link);
?>

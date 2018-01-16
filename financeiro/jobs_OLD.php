<?php header("Content-type: text/html; charset=ISO-8859-15");
	$db = mysql_connect("p3plcpnl0612.prod.phx3.secureserver.net","vinigoulart1","ThM]HETPv@"); 
	if (!$db) {
	die("Database connection failed miserably: " . mysql_error());
	}
	$db_select = mysql_select_db("testecadastro",$db);
	if (!$db_select) {
	die("Database selection also failed miserably: " . mysql_error());
	}
	session_start();
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' lang="pt-BR">
<head>
<meta http-equiv='Content-type' content='text/html; charset=ISO-8859-15' />
<title>Jobs - Magneto Elenco</title>
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Roboto:300,300italic,900,900italic,400,400italic' />
<link rel='stylesheet' type='text/css' href='DataTables/datatables.min.css'/>
<link rel='stylesheet' type='text/css' href='DataTables/style.css'/>
	<style type='text/css'>
	h1 { font-family: 'Roboto', sans-serif; font-weight: 400; }
	p { font-family: 'Roboto', sans-serif; font-weight: 300; }
	#corpo {
	    max-width:90%;
	}
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
<center><div id='corpo'>
	<h1>Jobs</h1>
<?php
	$hoje = date('Y-m-d', time());
	$result = mysql_query("SELECT nome, data_job, campanha, cliente_job, produzido_por, status_recebimento, data_recebimento, id, SUM(cache_bruto) AS valor, COUNT(nome) AS quantidade FROM financeiro WHERE tipo_entrada = 'cache' GROUP BY data_job, campanha, cliente_job, produzido_por ORDER BY data_job DESC", $db);
		if (!$result) {
		 die("Database query failed: " . mysql_error());
}
?>
<form action='action_jobs.php' method='post'>
	<table id='resultado' class='compact nowrap stripe hover row-border order-column' cellspacing='0' width='100%'>
		<thead>
 			<tr>
     			<th>Status</th>
				<th>Data do Job</th>
     			<th>Produtora</th>
     			<th>Cliente - Campanha</th>
				<th>Agenciados</th>
				<th>Valor</th>
	  			<th>Data Recebimento</th>
				<th>Operação</th>
			</tr>
		</thead>
		<tbody>
<?php
	while ($row = mysql_fetch_array($result)) {
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
		$_SESSION['data_recebimento'.$id] = $row['data_recebimento'];
		$sessenta = date('Y-m-d', strtotime($row['data_job']. ' + 60 days'));
		$noventa = date('Y-m-d', strtotime($row['data_job']. ' + 90 days'));	
		$cento_vinte = date('Y-m-d', strtotime($row['data_job']. ' + 120 days'));		
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
echo "     			<td>".$row['produzido_por']."</td>";
echo "     			<td>".$row['cliente_job']." - ".$row['campanha']."</td>";
echo "     			<td><center>".$row['quantidade']."</center></td>";
echo "     			<td>R$ ".$valor_format."</td>";
echo "     			<td><input type='text' name='nova_data_recebimento".$id."' size='10' class='input' ";
					if ($row['data_recebimento'] != NULL) {
					    echo "value='".$row['data_recebimento']."'></td>";
					} else {
						echo "placeholder='$hoje' value=''></td>";
					}
echo "     			<td><button class='enviar' name='id' value='$id' type='submit'>Alterar Status</button></td>";
echo " 			</tr>";
}
	$result2 = mysql_query("SELECT SUM(cache_bruto) AS total FROM financeiro WHERE status_recebimento=0", $db);
		if (!$result2) {
		 die("Database query failed: " . mysql_error());
}
	while ($row2 = mysql_fetch_array($result2)) {
		$total = $row2['total'];
		$total_format = number_format($total,2,",",".");
}
?>
		</tbody>
		<tr>
			<th>A Receber</th>
 			<th></th>
 			<th></th>
 			<th></th>
 			<th></th>
			<th><?php echo "R$: $total_format"; ?></th>
 			<th></th>
 			<th></th>
		</tr>
	</table>
</form>
</div></center>
</body>
</html>
<?php
 mysql_close($db);
?>
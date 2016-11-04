<?php
include("conecta.php");
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' lang="pt-BR">
<head>
<meta http-equiv='Content-type' content='text/html; charset=UTF-8' />
<title>Jobs - Magneto Elenco</title>
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Roboto:300,300italic,900,900italic,400,400italic' />
<link rel='stylesheet' type='text/css' href='DataTables/datatables.css'/>
<link rel='stylesheet' type='text/css' href='DataTables/style.css'/>
	<style type='text/css'>
	h1 { font-family: 'Roboto', sans-serif; font-weight: 400; }
	p { font-family: 'Roboto', sans-serif; font-weight: 300; }
	#corpo {
	    max-width:90%;
	}
	#atrasadas {
		color: red;
	}
	.set-width {
	  width: 85px;
	}
	</style>
<script type='text/javascript' src='http://code.jquery.com/jquery-latest.min.js'></script>
<script type='text/javascript' src='DataTables/datatables.js'></script>
<script type='text/javascript'>
$(document).ready(function(){
    $('#resultado').DataTable( {
            'language': {
			    'sEmptyTable': 'Nenhum registro encontrado',
			    'sInfo': 'Mostrando de _START_ até _END_ de _TOTAL_ registros',
			    'sInfoEmpty': 'Mostrando 0 até 0 de 0 registros',
			    'sInfoFiltered': '(Filtrados de _MAX_ registros)',
			    'sInfoPostFix': '',
			    'sInfoThousands': '.',
			    'sLengthMenu': 'Mostrar _MENU_ resultados por página',
			    'sLoadingRecords': 'Carregando...',
			    'sProcessing': 'Processando...',
			    'sZeroRecords': 'Nenhum registro encontrado',
			    'sSearch': 'Pesquisar',
			    'oPaginate': {
			        'sNext': 'Próximo',
			        'sPrevious': 'Anterior',
			        'sFirst': 'Primeiro',
			        'sLast': 'Último'
			    },
			    'oAria': {
			        'sSortAscending': ': Ordenar colunas de forma ascendente',
			        'sSortDescending': ': Ordenar colunas de forma descendente'
			    }
			}
        } );
    } );
	</script>
</head>
<body>
<center><div id='corpo'>
	<h1>Jobs realizados</h1>
<?php
	$hoje = date('Y-m-d', time());
	$result = mysqli_query($link, "SELECT data_job, campanha, cliente_job, produzido_por, status_recebimento, data_recebimento, id, SUM(cache_bruto) AS valor, COUNT(id) AS quantidade FROM financeiro WHERE tipo_entrada = 'cache' GROUP BY data_job, campanha, cliente_job, produzido_por ORDER BY data_job DESC");
		if (!$result) {
		 die("Database query failed: " . mysqli_error());
}
?>
<form action='action_jobs.php' method='post'>
	<table id='resultado' class='compact nowrap stripe hover row-border order-column' cellspacing='0' width='100%'>
		<thead>
 			<tr>
				<th>Data do Job</th>
     			<th>Produtora</th>
     			<th>Cliente - Campanha</th>
     			<th>Status</th>
				<th>Agenciados</th>
				<th>Valor</th>
	  			<th>Data Recebimento</th>
				<th>Operação</th>
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
		$_SESSION['data_recebimento'.$id] = $row['data_recebimento'];		
echo " 			<tr>";
echo "     			<td>".$row['data_job']."</td>";
echo "     			<td>".$row['produzido_por']."</td>";
echo "     			<td>".$row['cliente_job']." - ".$row['campanha']."</td>";
echo "     			<td>";
					if ($status == 1) {
					    echo "Recebido";
					} elseif ($status == 0) {
					    echo "A Receber";
					} else {
						echo "Vazio";
					}
echo "				</td>";
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
	$result2 = mysqli_query($link, "SELECT SUM(cache_bruto) AS total FROM financeiro WHERE status_recebimento=0");
		if (!$result2) {
		 die("Database query failed: " . mysqli_error());
}
	while ($row2 = mysqli_fetch_array($result2)) {
		$total = $row2['total'];
		$total_format = number_format($total,2,",",".");
}
?>
		</tbody>
		<tr>
			<th>TOTAL</th>
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
 mysqli_close($link);
?>
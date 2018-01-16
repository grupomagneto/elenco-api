<?php
include("conecta.php");
if(!session_id()) {
  session_start();
}
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' lang="pt-BR">
<head>
<meta http-equiv='Content-type' content='text/html; charset=UTF-8' />
<title>Despesas - Magneto Elenco</title>
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Roboto:300,300italic,900,900italic,400,400italic' />
<link rel='stylesheet' type='text/css' href='DataTables/datatables.min.css'/>
<link rel='stylesheet' type='text/css' href='DataTables/style.css'/>
 	<style type='text/css'>
	h1 { font-family: 'Roboto', sans-serif; font-weight: 400; }
	p { font-family: 'Roboto', sans-serif; font-weight: 300; }
	#atrasadas {
		color: red;
	}
	#hoje {
		color: green;
	}
	</style>
<script type='text/javascript' src='http://code.jquery.com/jquery-latest.min.js'></script>
<script type="text/javascript" src="DataTables/datatables.min.js"></script>
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
	<h1>Despesas</h1>
<?php
	$hoje = date('Y-m-d', time());
	$result = mysqli_query($link, "SELECT data_venc_despesa, tipo_despesa, descricao_despesa, id, valor_original_despesa, valor_despesa, data_despesa, status_despesa FROM financeiro WHERE tipo_entrada='despesa' ORDER BY data_venc_despesa DESC");
		if (!$result) {
		 die("Database query failed: " . mysqli_error());
}
?>
	<form action='action_despesas.php' method='post'>
	<table id='resultado' class='compact nowrap stripe hover row-border order-column' cellspacing='0'>
		<thead>
 			<tr>
     			<th>Status</th>
				<th>Data de Vencimento</th>
     			<th>Tipo de Despesa</th>
     			<th>Descrição</th>
				<th>Valor Original</th>
				<th>Valor Pago</th>
     			<th>Data de Pagamento</th>
				<th>Operação</th>
			</tr>
		</thead>
		<tbody>
<?php
	while ($row = mysqli_fetch_array($result)) {
		$id = $row['id'];
		$_SESSION['data_venc_despesa'.$id] = $row['data_venc_despesa'];
		$_SESSION['tipo_despesa'.$id] = $row['tipo_despesa'];
		$_SESSION['descricao_despesa'.$id] = $row['descricao_despesa'];
		$_SESSION['valor_original_despesa'.$id] = $row['valor_original_despesa'];
		$_SESSION['data_despesa'.$id] = $row['data_despesa'];
		$_SESSION['valor_despesa'.$id] = $row['valor_despesa'];
		$_SESSION['status_despesa'.$id] = $row['status_despesa'];
		$valor = $row['valor_despesa'];
		$valor_format = number_format($valor,2,",","");
		$valor_original = $row['valor_original_despesa'];
		$valor_original_format = number_format($valor_original,2,",","");
		$data_despesa = $row['data_despesa'];
		$status_despesa = $row['status_despesa'];
		$data_venc_despesa = $row['data_venc_despesa'];
echo " 			<tr>";
echo "     			<td>";
					if ($status_despesa == 0 && $hoje > $data_venc_despesa) {
					    echo "<div id='atrasadas'><strong>(1) Em aberto - Vencida</strong></div>";
					} elseif ($status_despesa == 0 && $hoje < $data_venc_despesa) {
					    echo "(3) Em aberto - A vencer";
					} elseif ($status_despesa == 0 && $hoje = $data_venc_despesa) {
					    echo "<div id='hoje'><strong>(2) Em aberto - VENCE HOJE</strong></div>";
					} elseif ($status_despesa == 1 && $data_despesa <= $data_venc_despesa) {
					    echo "(5) Paga - Em dia";
					} elseif ($status_despesa == 1 && $data_despesa >= $data_venc_despesa) {
					    echo "(4) Paga - Com atraso";
					}
echo "     			</td>";
echo "     			<td><center>".$row['data_venc_despesa']."</center></td>";
echo "     			<td>".$row['tipo_despesa']."</td>";
echo "     			<td>".$row['descricao_despesa']."</td>";
echo "     			<td><strong>R$ ".$valor_original_format."</strong></td>";
echo "     			<td>R$ <input type='text' name='novo_valor_despesa".$id."' size='8' class='input' ";
					if ($row['valor_despesa'] != NULL) {
					    echo "value='$valor_format'></td>";
					} else {
						echo "placeholder='$valor_original_format' value=''></td>";
					}
echo "     			<td><input type='text' name='nova_data_despesa".$id."' size='10' class='input' ";
					if ($row['data_despesa'] != NULL) {
					    echo "value='".$row['data_despesa']."'></td>";
					} else {
						echo "placeholder='$hoje' value=''></td>";
					}
echo "     			<td><button type='submit' name='alterar' value='$id'>Alterar</button> <button type='submit' name='excluir' value='$id' onclick='return confirm()'>Excluir</button></td>";
echo " 			</tr>";
}
		$result2 = mysqli_query($link, "SELECT SUM(valor_original_despesa) AS total FROM financeiro WHERE status_despesa=0");
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
			<th>Em aberto</th>
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
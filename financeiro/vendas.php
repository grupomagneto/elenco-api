<?php
include("conecta.php");
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' lang="pt-BR">
<head>
<meta http-equiv='Content-type' content='text/html; charset=UTF-8' />
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Roboto:300,300italic,900,900italic,400,400italic' />
<link rel='stylesheet' type='text/css' href='DataTables/datatables.min.css'/>
<link rel='stylesheet' type='text/css' href='DataTables/style.css'/>
 	<style type='text/css'>
	h1 { font-family: 'Roboto', sans-serif; font-weight: 400; }
	p { font-family: 'Roboto', sans-serif; font-weight: 300; }
	</style>
<script type='text/javascript' src='http://code.jquery.com/jquery-latest.min.js'></script>
<script type="text/javascript" src="DataTables/datatables.min.js"></script>
<script type='text/javascript'>
$(document).ready(function(){
    $('#resultado').DataTable( {
		"aaSorting": [[0,'desc'], [1,'asc']]
    } );
} );
</script>
</head>
<body>
<center><div>
	<h1>Vendas</h1>
<?php
	$hoje = date('Y-m-d', time());
	$result = mysqli_query($link, "SELECT data_venda, nome, sobrenome, produto, qtd, forma_pagamento, n_parcelas, valor_venda, id FROM financeiro WHERE tipo_entrada='Venda' AND valor_venda > 0 ORDER BY data_venda DESC");
		if (!$result) {
		 die("Database query failed: " . mysqli_error());
}
?>
	<form action='action_vendas.php' method='post'>
	<table id='resultado' class='compact nowrap stripe hover row-border order-column' cellspacing='0'>
		<thead>
 			<tr>
     			<th>Data da Venda</th>
				<th>Nome e Sobrenome</th>
     			<th>Produto</th>
				<th>Qtd</th>
				<th>Valor da Venda</th>
				<th>Forma de Pagamento</th>
     			<th>Nº de Parcelas</th>
				<th>Operação</th>
			</tr>
		</thead>
		<tbody>
<?php
	while ($row = mysqli_fetch_array($result)) {
		$id = $row['id'];
		$valor = $row['valor_venda'];
		$valor_format = number_format($valor,2,",","");
echo " 			<tr>";
echo "     			<td>".$row['data_venda']."</td>";
echo "     			<td>".$row['nome']." ".$row['sobrenome']."</td>";
echo "     			<td>".$row['produto']."</td>";
echo "     			<td>".$row['qtd']."</td>";
echo "     			<td><strong>R$ ".$valor_format."</strong></td>";
echo "     			<td>".$row['forma_pagamento']."</td>";
echo "     			<td>".$row['n_parcelas']."</td>";
echo "     			<td><button type='submit' name='id' value='$id' onclick='return confirm()'>Excluir</button></td>";
echo " 			</tr>";
}
		$result2 = mysqli_query($link, "SELECT SUM(valor_venda) AS total FROM financeiro WHERE tipo_entrada='Venda' AND YEAR(data_venda)='2016'");
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
			<th>Vendas 2016</th>
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
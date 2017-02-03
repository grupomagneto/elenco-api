<?php
include("conecta.php");
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' lang="pt-BR">
<head>
<meta http-equiv='Content-type' content='text/html; charset=UTF-8' />
<title>Contratos - Magneto Elenco</title>
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Roboto:300,300italic,900,900italic,400,400italic' />
<link rel='stylesheet' type='text/css' href='DataTables/datatables.min.css'/>
<link rel='stylesheet' type='text/css' href='DataTables/style.css'/>
	<style type='text/css'>
	h1 { font-family: 'Roboto', sans-serif; font-weight: 400; }
	p { font-family: 'Roboto', sans-serif; font-weight: 300; }
	.set-width {
	  width: 85px;
	}
	#premium {
		color: red;
	}
	#gratuito {
		color: orange;
	}
	#ator {
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
		"aaSorting": [[6,'desc'], [0,'asc']]
    } );
} );
</script>
</head>
<body>
<center><div>
	<h1>Contratos</h1>
<?php
	$result = mysqli_query($link2, "SELECT id_elenco, nome_artistico, tipo_cadastro_vigente, data_contrato_vigente, data_1o_contrato, tl_celular, email, dt_insercao FROM tb_elenco WHERE data_contrato_vigente IS NULL OR TIMESTAMPDIFF(YEAR, data_contrato_vigente, CURDATE()) > '2' ORDER BY dt_insercao DESC LIMIT 0, 100");
		if (!$result) {
		 die('Erro: ' . mysqli_error($link2));
	}
?>
<table id='resultado' class='compact nowrap stripe hover row-border order-column' cellspacing='0' width='100%'>
		<thead>
 			<tr>
     			<th>Nome Artístico</th>
				<th>Cadastro</th>
     			<th>Último Contrato</th>
				<th>1º Contrato</th>
				<th>Celular</th>
     			<th>E-mail</th>
				<th>Inserção</th>
				<th>Operação</th>
			</tr>
		</thead>
		<tbody>
<?php
	while ($row = mysqli_fetch_array($result)) {
		$id = $row['id_elenco'];
		$nome = $row['nome_artistico'];
		$tipo_cadastro_vigente = $row['tipo_cadastro_vigente'];
		$data_contrato_vigente = $row['data_contrato_vigente'];
		$data_1o_contrato = $row['data_1o_contrato'];
		$celular = $row['tl_celular'];
		$email = strtolower($row['email']);
		$insercao = date('Y-m-d',strtotime($row['dt_insercao']));

		if ($tipo_cadastro_vigente != NULL && $tipo_cadastro_vigente == 'Ator') {
			$tipo_cadastro_vigente = "<div id='ator'><strong>Ator</strong></div>";
		} elseif ($tipo_cadastro_vigente != NULL && $tipo_cadastro_vigente == 'Premium') {
			$tipo_cadastro_vigente = "<div id='premium'><strong>Premium</strong></div>";
		} elseif ($tipo_cadastro_vigente != NULL && $tipo_cadastro_vigente == 'Gratuito') {
			$tipo_cadastro_vigente = "<div id='gratuito'><strong>Gratuito</strong></div>";
		}

		if ($tipo_cadastro_vigente == NULL || $tipo_cadastro_vigente == '') {
			$tipo_cadastro_vigente = "<div id='premium'><strong>Preencher</strong></div>";
		}
		if ($data_contrato_vigente == NULL || $data_contrato_vigente == '') {
			$data_contrato_vigente = "<div id='premium'><strong>Preencher</strong></div>";
		}
		if ($data_1o_contrato == NULL || $data_1o_contrato == '') {
			$data_1o_contrato = "<div id='premium'><strong>Preencher</strong></div>";
		}

		$operacao = "<form id='checar".$id."' method='get' action='action_atualiza_contrato.php' target='resultado2".$id."'><input type='hidden' name='checar' value='$id'><button type='button' id='checa".$id."'>Atualizar</button></form>
		<script type='text/javascript'>
		document.getElementById('checa".$id."').addEventListener('click', function() {
		window.open('action_checar.php', 'resultado2".$id."', 'toolbar=no,scrollbars=no,directories=no,titlebar=yes,resizable=no,location=no,status=no,menubar=no,top=100,left=700,width=400,height=300');
		document.getElementById('checar".$id."').submit();
		});
		</script>";
echo " 			<tr>";
echo "     			<td>".$nome."</td>";
echo "     			<td>".$tipo_cadastro_vigente."</td>";
echo "     			<td>".$data_contrato_vigente."</td>";
echo "     			<td>".$data_1o_contrato."</td>";
echo "     			<td>".$celular."</td>";
echo "     			<td>".$email."</td>";
echo "     			<td>".$insercao."</td>";
echo "     			<td>".$operacao."</td>";
echo " 			</tr>";
}
?>
		</tbody>
	</table>
</div></center>
</body>
</html>
<?php
mysqli_close($link2);
?>
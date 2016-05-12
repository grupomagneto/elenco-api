<?php header("Content-type: text/html; charset=UTF-8");
session_start();
	$data_job = $_SESSION['data_job'];
	$produzido_por = $_SESSION['produzido_por'];
	$cliente_job = $_SESSION['cliente_job'];
	$campanha = $_SESSION['campanha'];
	$midia = $_SESSION['midia'];
	$praca = $_SESSION['praca'];
	$periodo = $_SESSION['periodo'];
	$periodo_tipo = $_SESSION['periodo_tipo'];
	$valor_total_job = $_SESSION['valor_total_job'];
	$n_participantes = $_SESSION['n_participantes'];
	$previsao_pagamento = $_SESSION['previsao_pagamento'];
	$emitiu_nota = $_SESSION['emitiu_nota'];
	$n_nota_fiscal = $_SESSION['n_nota_fiscal'];
	$data_nota = $_SESSION['data_nota'];
	$status_recebimento = $_SESSION['status_recebimento'];
	$data_recebimento = $_SESSION['data_recebimento'];
echo "	
	<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
	<html xmlns='http://www.w3.org/1999/xhtml' lang='pt-BR'>
	<head>
	<meta http-equiv='Content-type' content='text/html; charset=UTF-8' />
	<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Roboto:300,300italic,900,900italic,400,400italic' />
	<link rel='stylesheet' type='text/css' href='DataTables/datatables.css'/>
	<link rel='stylesheet' type='text/css' href='DataTables/style.css'/>
	 	<style type='text/css'>
		h1 { font-family: 'Roboto', sans-serif; font-weight: 400; }
		p { font-family: 'Roboto', sans-serif; font-weight: 300; }
		input[type='number'] {
		   width:50px;
		}
		</style>
    <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css'>
    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js'></script>
    <script src='typeahead.min.js'></script>
    <script>
    $(document).ready(function(){";
		$part = 1;
		while ($part <= $n_participantes) {
echo "
	$('input.typeahead').typeahead({
        name: 'typeahead".$part."',
        remote:'search.php?key=%QUERY',
        limit : 10
	});";
		$part++;
		}
echo"
});
    </script>
	</head>
	<body>
	<center>
	<h1>Inserir Participantes</h1>
	<form action='insert_nomes_teste.php' method='post'>
	<table id='resultado' class='compact nowrap stripe hover row-border order-column' cellspacing='0' width='100%'>
		<tr>
			<th scope='col'>Nome</th>
			<th scope='col'>Cachê Bruto</th>
			<th scope='col'>Cachê Líquido</th>
			<th scope='col'>Tipo do Job</th>
			<th scope='col'>Tipo do Cachê</th>
		</tr>";
		$part = 1;
		while ($part <= $n_participantes) {
echo "
	<tr>
		<td><div><input type='text' name='typeahead".$part."' class='typeahead tt-query' autocomplete='off' spellcheck='false' placeholder='Nome Artístico'></div></td>
		<td>R$: <input type='text' name='cache_bruto".$part."' size='10' placeholder='1000.00' required /></td>
		<td>R$: <input type='text' name='cache_liquido".$part."' size='10' placeholder='1000.00' required /></td>
		<td>
		    <select name='tipo_job".$part."' required >
				<option disabled selected> -- Selecionar -- </option>
			    <option value='Principal - Fotografia'>Principal - Fotografia</option>
			    <option value='Principal - Vídeo'>Principal - Vídeo</option>
			    <option value='Concorrência'>Concorrência</option>
				<option value='Recepção'>Recepção</option>
				<option value='Figuração'>Figuração</option>
				<option value='Cinema'>Cinema</option>
	    </select>
	    </td>
		<td>
		    <select name='tipo_cache".$part."' required >
				<option disabled selected> -- Selecionar -- </option>
			    <option value='1º Cachê Cadastro Gratuito'>1º Cachê Cadastro Gratuito</option>
			    <option value='Cadastro Gratuito'>Cadastro Gratuito</option>
			    <option value='Cadastro Premium'>Cadastro Premium</option>
	    </select>
	    </td>
	</tr>
		";
		$part++;
		}
echo"
</table>
	<button type='submit' name='incluir_cache'>Incluir ".$n_participantes." Participante(s)</button>
</form>
</center>
</body>
</html>
";	
?>
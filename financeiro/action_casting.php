<?php header('Content-type: text/html; charset=ISO-8859-15');
include('conecta.php');
include('functions.php');
	$casting = $_GET['casting'];
	$casting = str_replace("http://www.magnetoelenco.com.br/v2/meu_casting.php?id_casting=", "", "$casting");
	$sql = "SELECT * FROM (SELECT cd_elenco id FROM ta_casting_elenco WHERE cd_casting = '$casting') T1 INNER JOIN (SELECT id_elenco id, nome_artistico, email, tipo_cadastro_vigente, tl_celular, tl_residencial, tl_comercial, bairro, data_contrato_vigente, nome_responsavel FROM tb_elenco) T2 USING (id)";
	$sql_2 = "SELECT nome AS nome_casting FROM tb_casting WHERE id_casting = '$casting'";
		$result = mysqli_query($link2, $sql_2);
		$row = mysqli_fetch_array($result);
		$nome_casting = $row['nome_casting'];
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' lang="pt-BR">
<head>
<meta http-equiv='Content-type' content='text/html; charset=ISO-8859-15' />
<title>Caches - Magneto Elenco</title>
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Roboto:300,400' />
<link rel='stylesheet' type='text/css' href='DataTables/datatables.min.css'/>
<link rel='stylesheet' type='text/css' href='DataTables/style.css'/>
	<style type='text/css'>
	h1 { font-family: 'Roboto', sans-serif; font-weight: 400; }
	p { font-family: 'Roboto', sans-serif; font-weight: 300; }
	</style>
<script type='text/javascript' src='http://code.jquery.com/jquery-latest.min.js'></script>
<script type='text/javascript' src='DataTables/datatables.min.js'></script>
<script type='text/javascript'>
$(document).ready(function(){
    $('#resultado').DataTable( {
		"aaSorting": [[1,'asc'], [3,'asc']]
    } );
} );
</script>
</head>
<body>
<center><div>
	<h1>Casting: <?php echo $nome_casting; ?></h1>
	<table id='resultado' class='compact nowrap stripe hover row-border order-column' cellspacing='0' width='100%'>
		<thead>
 			<tr>
     			<th>ID</th>
				<th>Nome</th>
				<th>Responsável</th>
				<th>Cadastro</th>
				<th>Bairro</th>
     			<th>Celular</th>
				<th>Residencial</th>
				<th>Comercial</th>
     			<th>E-mail</th>
				<th>Contrato</th>
			</tr>
		</thead>
		<tbody>
<?php
	$hoje = date('Y-m-d', time());
	$result = mysqli_query($link2, $sql);
	while ($row = mysqli_fetch_array($result)) {
		$id = $row['id'];
		$nome = $row['nome_artistico'];
		$email = $row['email'];
		$cadastro = $row['tipo_cadastro_vigente'];
		if ($row['tl_celular'] != NULL || $row['tl_celular'] != '') {
			$celular = $row['tl_celular'];
			$celular = str_replace('(', '', $celular);
			$celular = str_replace(')', '', $celular);
			$celular = str_replace('-', '', $celular);
			$celular = str_replace(' ', '', $celular);
			$celular = str_replace('.', '', $celular);
			$celular = mask($celular, '(##) ####-####');
		} else {
			$celular = "--";
		}
		if ($row['tl_residencial'] != NULL || $row['tl_residencial'] != '') {
			$residencial = $row['tl_residencial'];
			$residencial = str_replace('(', '', $residencial);
			$residencial = str_replace(')', '', $residencial);
			$residencial = str_replace('-', '', $residencial);
			$residencial = str_replace(' ', '', $residencial);
			$residencial = str_replace('.', '', $residencial);
			$residencial = mask($residencial, '(##) ####-####');
		} else {
			$residencial = "--";
		}
		if ($row['tl_comercial'] != NULL || $row['tl_comercial'] != '') {
			$comercial = $row['tl_comercial'];
			$comercial = str_replace('(', '', $comercial);
			$comercial = str_replace(')', '', $comercial);
			$comercial = str_replace('-', '', $comercial);
			$comercial = str_replace(' ', '', $comercial);
			$comercial = str_replace('.', '', $comercial);
			$comercial = mask($comercial, '(##) ####-####');
		} else {
			$comercial = "--";
		}
		$bairro = $row['bairro'];
		$data_contrato_vigente = $row['data_contrato_vigente'];
		$responsavel = $row['nome_responsavel'];
			if ($hoje <= date('Y-m-d', strtotime($row['data_contrato_vigente']."+2 years")) && $row['data_contrato_vigente'] != NULL) {
				$contrato = "<font color='green'><strong>OK</strong></font>";
			} elseif ($hoje > date('Y-m-d', strtotime($row['data_contrato_vigente']."+2 years")) && $row['data_contrato_vigente'] != NULL) {
				$contrato = "<font color='red'><strong>Vencido</strong></font>";
			} elseif ($row['data_contrato_vigente'] == NULL) {
				$contrato = "<font color='orange'><strong>Checar</strong></font>";
			}
echo "
		<tr>
			<td>$id</td>
			<td>$nome</td>
			<td>$responsavel</td>
			<td>$cadastro</td>
			<td>$bairro</td>
			<td>$celular</td>
			<td>$residencial</td>
			<td>$comercial</td>
			<td>$email</td>
			<td>$contrato</td>
		</tr>";
	}
echo "
</tbody></table>
</div></center>
</body>
</html>";
mysqli_close($link2);
?>
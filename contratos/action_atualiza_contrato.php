<?php
include('conecta.php');
	$id_elenco = $_GET['checar'];
	$sql = "SELECT nome_artistico FROM tb_elenco WHERE id_elenco='$id_elenco'";
	$result = mysqli_query($link2, $sql);
	$row = mysqli_fetch_array($result);
	$nome = $row['nome_artistico'];
	?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' lang='pt-BR'>
<head>
<meta http-equiv='Content-type' content='text/html; charset=UTF-8' />
<title>Atualizar Informações</title>
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Roboto:300,400' />
<link rel='stylesheet' type='text/css' href='DataTables/datatables.min.css' />
<style type='text/css'>
	h1 { font-family: 'Roboto', sans-serif; font-weight: 400; }
	body { font-family: 'Roboto', sans-serif; font-weight: 300; }
	#corpo {
		width: 300px;
		align: center;
		text-align: left;
		margin-top: 30px;
		margin-left: 30px;
	}
	#titulo {
		align: left;
		text-align: left;
		margin-top: 40px;
	}
	#texto {
		align: left;
		text-align: left;
		margin-top: 30px;
	}
	input[type='date'] {
	   width:150px;
	}
	th {
	    border: 0px;
	    text-align: right;
	}
	</style>
</head>
<body>
<div id='corpo'>
<div id='titulo'><h1><?php echo $nome; ?></h1></div>
<div id='texto'>
<form name='atualiza' action='action_atualiza.php' method='post'>
<table border='0'>
<tr>
    <th>Tipo do Cadastro:&nbsp;</th>
    <td align='left'>
	    <select name='tipo_cadastro_vigente' required>
			<option value=''> -- Selecionar -- </option>
			<option value='Ator'>Ator</option>
			<option value='Gratuito'>Gratuito</option>
			<option value='Premium'>Premium</option>
			<option value='Profissional'>Profissional</option>
		</select>
	</td>
</tr>
<tr>
    <th>Contrato Vigente:&nbsp;</th>
	<td align='left'><input type='date' name='data_contrato_vigente' required></td>
</tr>
<tr>
    <th>1º Contrato:&nbsp;</th>
	<td align='left'><input type='date' name='data_1o_contrato' required></td>
</tr>
</table><br /><br />
<center><input type='hidden' name='id_elenco' value='<?php echo $id_elenco; ?>' /><button>Atualizar</button></form></center>
</div></form></div>
</body>
</html>
<?php
mysqli_close($link2);
?>
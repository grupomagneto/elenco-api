<?php
include('conecta.php');
	$hoje = date('Y-m-d', time());
	$id = $_GET['pagar'];
	$sql = "SELECT * FROM (SELECT id id_cache, data_job, nome, sobrenome, id_elenco_financeiro id, campanha, cliente_job, produzido_por, status_recebimento, liberado, previsao_pagamento, status_pagamento, data_pagamento, data_recebimento, n_ligacoes, cache_liquido, valor_cheque, abatimento_cache FROM financeiro WHERE id = '$id') T1 INNER JOIN (SELECT id_elenco id, email, tipo_cadastro_vigente, data_contrato_vigente, tl_celular FROM tb_elenco comum) T2 USING (id) ORDER BY data_job DESC";
	$result = mysqli_query($link, $sql);
	$row = mysqli_fetch_array($result);
	$id_elenco_financeiro = $row['id'];
	$nome = $row['nome']." ".$row['sobrenome'];
	$cadastro = $row['tipo_cadastro_vigente'];
	$liberado = $row['liberado'];
	if ($cadastro == 'Gratuito') {
		$cadastro = "<font color='red'><strong>Gratuito</strong></font>";
	} elseif ($cadastro == 'Premium') {
		$cadastro = "<font color='orange'><strong>Premium</strong></font>";
	} elseif ($cadastro == 'Ator') {
		$cadastro = "<font color='orange'><strong>Ator</strong></font>";
	} elseif ($cadastro == 'Profissional') {
		$cadastro = "<font color='green'><strong>Profissional</strong></font>";
	}
	$contrato = $row['data_contrato_vigente'];
		if ($hoje <= date('Y-m-d', strtotime($contrato."+2 years")) && $contrato != NULL) {
			$contrato = "<font color='green'><strong>OK</strong></font>";
			// echo $contrato;
		} elseif ($hoje > date('Y-m-d', strtotime($contrato."+2 years")) && $contrato != NULL) {
			$contrato = "<font color='red'><strong>Vencido</strong></font>";
			// echo $contrato;
		} elseif ($contrato == NULL || $contrato == '') {
			$contrato = "<font color='orange'><strong>Checar</strong></font>";
		}
		$cache_liquido = $row['cache_liquido'];
		$abatimento_cache = $row['abatimento_cache'];
		$valor_cheque = $row['valor_cheque'];
		$saldo_cache = $cache_liquido - $abatimento_cache - $valor_cheque;
		$cache_liquido_format = number_format($cache_liquido,2,",",".");
		$abatimento_cache_format = number_format($abatimento_cache,2,",",".");
		$valor_cheque_format = number_format($valor_cheque,2,",",".");
		$saldo_cache_format = number_format($saldo_cache,2,",",".");
		$adicional = 45;
		$previsao_pagamento = $row['previsao_pagamento'] + $adicional;
		$previsao = date('Y-m-d', strtotime($row['data_job']." + ".$previsao_pagamento." days"));
		if ($previsao <= $hoje || $liberado == '1' && $row['status_recebimento'] == 1 && $hoje <= date('Y-m-d', strtotime($row['data_contrato_vigente']."+2 years")) && $row['data_contrato_vigente'] != NULL) {
			$status_cache = "<font color='green'><strong> Liberado</strong></font>";
			$saque = NULL;
		} elseif ($previsao <= $hoje && $row['status_recebimento'] == 1 && $hoje > date('Y-m-d', strtotime($row['data_contrato_vigente']."+2 years")) || $row['data_contrato_vigente'] == NULL) {
			$status_cache = "<font color='orange'><strong> Pendência</strong></font>";
			$saque = "disabled";
		} else {
			$status_cache = "<font color='red'><strong>Indisponível para saque</strong></font>";
			$saque = "disabled";
		}
		$sql2 = "SELECT SUM(cache_liquido) AS saldo_a_receber, SUM(abatimento_cache) AS abatimento, SUM(valor_cheque) AS cheque FROM financeiro WHERE status_pagamento = 0 AND id_elenco_financeiro = '$id_elenco_financeiro'";
		$result2 = mysqli_query($link, $sql2);
		$row2 = mysqli_fetch_array($result2);
		if ($row2['abatimento'] == NULL || $row2['abatimento'] == '' || $row2['abatimento'] == '0') {
			$abatimento_total = 0;
		} elseif ($row2['abatimento'] != NULL && $row2['abatimento'] != '' || $row2['abatimento'] != '0') {
			$abatimento_total = $row2['abatimento'];
		}
		if ($row2['cheque'] == NULL || $row2['cheque'] == '') {
			$cheque_total = 0;
		} elseif ($row2['cheque'] != NULL && $row2['cheque'] != '') {
			$cheque_total = $row2['cheque'];
		}
			$saldo_a_receber = $row2['saldo_a_receber'] - $abatimento_total - $cheque_total;
			$saldo_a_receber_format = number_format($saldo_a_receber,2,",",".");

		// Define Valores dos Produtos
		$premium01 = 299;
		$premium02 = 249;
		$profissional01 = 999;
		$profissional02 = 899;
		$tresporquatro = 30;

		if ($saldo_a_receber < $profissional01) {
			if ($saldo_a_receber < $profissional02){
				if ($saldo_a_receber < $premium01){
					if ($saldo_a_receber < $premium02){
						$maximo = $saldo_a_receber;
					} else {$maximo = $premium02;}
				} else {$maximo = $premium01;}
			} else {$maximo = $profissional02;}
		} else {$maximo = $profissional01;}
		if ($contrato == "<font color='green'><strong>OK</strong></font>" && $status_cache == "<font color='green'><strong> Liberado</strong></font>") {
			$select = "		<option name='Ensaio' value='".$saldo_a_receber."'>Compra de Ensaio Fotográfico</option>";
			if ($maximo >= $tresporquatro) {$select .= "	<option name='3x4' value='$tresporquatro'>Compra de fotos 3x4</option>";}
			if ($maximo >= $premium02 && $row['tipo_cadastro_vigente'] == 'Gratuito') {$select .= "	<option name='Premium' Value='$premium02'>Upgrade p/ Premium - PROMOÇÃO!</option>";}
			if ($maximo >= $profissional02 && $row['tipo_cadastro_vigente'] != 'Profissional') {$select .= "	<option name='Profissional' Value='$profissional02'>Upgrade p/ PROFISSIONAL</option>";}
			$select .= "	<option name='Transferência' disabled>Transferência para outro agenciado</option>";
		} elseif ($contrato == "<font color='green'><strong>OK</strong></font>" && $status_cache == "<font color='red'><strong>Indisponível para saque</strong></font>") {
			$select = "		<option name='Ensaio' value='".$saldo_a_receber."'>Compra de Ensaio Fotográfico</option>";
			if ($maximo >= $tresporquatro) {$select .= "	<option name='3x4' value='$tresporquatro'>Compra de fotos 3x4</option>";}
			if ($maximo >= $premium01 && $row['tipo_cadastro_vigente'] == 'Gratuito') {$select .= "	<option name='Premium_01' Value='$premium01'>Upgrade p/ PREMIUM (à vista)</option>";}
			if ($maximo >= $premium02 && $row['tipo_cadastro_vigente'] == 'Gratuito') {$select .= "	<option name='Premium_02' Value='$premium02'>Upgrade p/ PREMIUM (previsão)</option>";}
			if ($maximo >= $profissional01 && $row['tipo_cadastro_vigente'] != 'Profissional') {$select .= "	<option name='Profissional_01' Value='$profissional01'>Upgrade p/ PROFISSIONAL (à vista)</option>";}
			if ($maximo >= $profissional02 && $row['tipo_cadastro_vigente'] != 'Profissional') {$select .= "	<option name='Profissional_02' Value='$profissional02'>Upgrade p/ PROFISSIONAL (previsão)</option>";}
			$select .= "	<option name='Transferência' disabled>Transferência para outro agenciado</option>";
		} elseif ($contrato == "<font color='red'><strong>Vencido</strong></font>" && $status_cache == "<font color='red'><strong>Indisponível para saque</strong></font>") {
			$select = "		<option name='Ensaio' value='".$saldo_a_receber."'>Compra de Ensaio Fotográfico</option>";
			if ($maximo >= $tresporquatro) {$select .= "	<option name='3x4' value='$tresporquatro'>Compra de fotos 3x4</option>";}
			if ($maximo >= $premium01 && $row['tipo_cadastro_vigente'] == 'Gratuito') {$select .= "	<option name='Premium_01' Value='$premium01'>Upgrade p/ PREMIUM</option>";}
			if ($maximo >= $premium01 && $row['tipo_cadastro_vigente'] == 'Premium') {$select .= "	<option name='Premium_01' Value='$premium01'>Renovar PREMIUM</option>";}
			if ($maximo >= $profissional01 && $row['tipo_cadastro_vigente'] != 'Profissional') {$select .= "	<option name='Profissional_01' Value='$profissional01'>Upgrade p/ PROFISSIONAL</option>";}
			$select .= "	<option name='Transferência' disabled>Transferência para outro agenciado</option>";
		} elseif ($contrato == "<font color='red'><strong>Vencido</strong></font>" && $status_cache == "<font color='orange'><strong> Pendência</strong></font>") {
			$select = "		<option name='Ensaio' value='".$saldo_a_receber."'>Compra de Ensaio Fotográfico</option>";
			if ($maximo >= $tresporquatro) {$select .= "	<option name='3x4' value='$tresporquatro'>Compra de fotos 3x4</option>";}
			if ($maximo >= $premium01 && $row['tipo_cadastro_vigente'] == 'Gratuito') {$select .= "	<option name='Premium_01' Value='$premium01'>Upgrade p/ PREMIUM</option>";}
			if ($maximo >= $premium01 && $row['tipo_cadastro_vigente'] == 'Premium') {$select .= "	<option name='Premium_01' Value='$premium01'>Renovar PREMIUM</option>";}
			if ($maximo >= $profissional01 && $row['tipo_cadastro_vigente'] != 'Profissional') {$select .= "	<option name='Profissional_01' Value='$profissional01'>Upgrade p/ PROFISSIONAL</option>";}
			$select .= "	<option name='Transferência' disabled>Transferência para outro agenciado</option>";
		} elseif ($contrato == "<font color='red'><strong>Vencido</strong></font>" && $status_cache == "<font color='green'><strong> Liberado</strong></font>") {
			$select = "		<option name='Ensaio' value='".$saldo_a_receber."'>Compra de Ensaio Fotográfico</option>";
			if ($maximo >= $tresporquatro) {$select .= "	<option name='3x4' value='$tresporquatro'>Compra de fotos 3x4</option>";}
			if ($maximo >= $premium01 && $row['tipo_cadastro_vigente'] == 'Gratuito') {$select .= "	<option name='Premium_01' Value='$premium01'>Upgrade p/ PREMIUM</option>";}
			if ($maximo >= $premium01 && $row['tipo_cadastro_vigente'] == 'Premium') {$select .= "	<option name='Premium_01' Value='$premium01'>Renovar PREMIUM</option>";}
			if ($maximo >= $profissional01 && $row['tipo_cadastro_vigente'] != 'Profissional') {$select .= "	<option name='Profissional_01' Value='$profissional01'>Upgrade p/ PROFISSIONAL</option>";}
			$select .= "	<option name='Transferência' disabled>Transferência para outro agenciado</option>";
		} else {
			$select = "		<option name='Ensaio' value='".$saldo_a_receber."'>Compra de Ensaio Fotográfico</option>";
			if ($maximo >= $tresporquatro) {$select .= "	<option name='3x4' value='$tresporquatro'>Compra de fotos 3x4</option>";}
			if ($maximo >= $premium01 && $row['tipo_cadastro_vigente'] == 'Gratuito') {$select .= "	<option name='Premium' Value='$premium01'>Upgrade p/ Premium (previsão)</option>";}
			if ($maximo >= $profissional01 && $row['tipo_cadastro_vigente'] != 'Profissional') {$select .= "	<option name='Profissional' Value='$profissional01'>Upgrade p/ Profissional (previsão)</option>";}
			$select .= "	<option name='Transferência' disabled>Transferência para outro agenciado</option>";
		}
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' lang='pt-BR'>
<head>
<meta http-equiv='Content-type' content='text/html; charset=UTF-8' />
<title>Pagar Cachê</title>
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Roboto:300,400' />
<link rel='stylesheet' type='text/css' href='DataTables/datatables.min.css' />
<style type='text/css'>
	h1 { font-family: 'Roboto', sans-serif; font-weight: 400; }
	body { font-family: 'Roboto', sans-serif; font-weight: 300; }
	#corpo {
		width: 300px;
		align: center;
		text-align: left;
		margin-top: 10px;
		margin-left: 40px;
	}
	#titulo {
		align: left;
		text-align: left;
		margin-top: 20px;
	}
	#subtitulo {
		align: left;
		text-align: left;
		margin-top: -5px;
		font-size: medium;
	}
	#texto {
		align: left;
		text-align: left;
		margin-top: 20px;
	}
	#descritivo {
		font-size: small;
	}
/*	input[type='number'] {
	   width:80px;
	}*/
	input#saldo_sacado {
	   width:50px;
	}
	input#saldo_utilizado {
	   width:68px;
	}
	input#n_cheque {
	   width:110px;
	}
	input[type='date'] {
	   width:150px;
	}
	th {
	    border: 0px;
	    text-align: right;
	}
	</style>
	<script type="text/javascript">
	function ChooseContact(data) {
		document.getElementById ("saldo_utilizado").value = data.value;
	}
	</script>
</head>
<body>
<div id='corpo'>
<div id='titulo'><h1><?php echo $nome; ?></h1></div>
<div id='subtitulo'>Cadastro: <?php echo $cadastro." - Contrato: <strong>".$contrato; ?></strong></div>
<div id='descritivo'>Total em cachês a receber: <strong><font color='green'>R$ <?php echo $saldo_a_receber_format; ?></font></strong></div>
<div id='texto'>
<form name='pagar' action='action_pagar_query.php' method='get'>
<table border='0'>
<tr>
	<th scope='row' align='right'>Cachê:&nbsp;</th>
	<td align='left'><?php echo $status_cache; ?></td>
</tr>
<tr>
	<th scope='row' align='right'>Original:&nbsp;</th>
	<td align='left'>R$ <?php echo $cache_liquido_format; ?></td>
</tr>
<?php
if ($abatimento_cache != NULL && $abatimento_cache != '' && $abatimento_cache != '0') {
echo "<tr>
	<th scope='row' align='right'>Abatimento:&nbsp;</th>
	<td align='left'><div style='color: red;'>-R$ $abatimento_cache_format</div></td>
</tr>";
}
if ($valor_cheque != NULL && $valor_cheque != '') {
echo "<tr>
	<th scope='row' align='right'>Cheque Pago:&nbsp;</th>
	<td align='left'><div style='color: red;'>-R$ $valor_cheque_format</div></td>
</tr>";
}
if ($valor_cheque != NULL && $valor_cheque != '' || $abatimento_cache != NULL && $abatimento_cache != '') {
echo "<tr>
	<th scope='row' align='right'>Saldo:&nbsp;</th>
	<td align='left'><font color='green'><strong>R$ $saldo_cache_format</strong></font></td>
</tr>";
}
?>
<tr>
	<th scope='row' align='right'>Data:&nbsp;</th>
	<td align='left'><input type='date' name='data_pagamento' class='input' required></td>
</tr>
</table>
  <br /><br />
<table border='0'>
<tr>
    <td style='width:90px' align='left'><label><input type='checkbox' name='utilizar' value='true' id='utilizar' onclick="document.getElementById('saldo_utilizado').removeAttribute('disabled');document.getElementById('operacao').removeAttribute('disabled');" /> Utilizar</label></th>
<?php echo "    <td align='left'>R$: <input type='number' name='saldo_utilizado' id='saldo_utilizado' min='1' max='$saldo_a_receber' disabled required /></td>"; ?>
    <td></td>
</tr>
<tr>
    <th></th>
    <td align='left'>
	    <select name='operacao' id='operacao' onchange='ChooseContact(this)' disabled required>
			<option disabled selected> -- Selecionar -- </option>
			<?php echo $select; ?>
		</select></td>
    <td></td>
</tr>
</table><br />
<table border='0'>
<tr>
    <td style='width:90px' align='left'><label><input type='checkbox' name='sacar' value='true' id='sacar' <?php echo $saque; ?> onclick="document.getElementById('saldo_sacado').removeAttribute('disabled');document.getElementById('n_cheque').removeAttribute('disabled');document.getElementById('conta').removeAttribute('disabled');" /> Sacar</label></th>
<?php echo "    <td align='left'>R$: <input type='number' name='saldo_sacado' id='saldo_sacado' min='1' max='$saldo_cache' disabled required /></td>"; ?>
    <td></td>
</tr>
<tr>
    <th></th>
    <td align='left'>Nº Cheque:</td>
    <td align='left'><input type='number' name='n_cheque' id='n_cheque' disabled required /></td>
</tr>
<tr>
    <th></th>
    <td align='left'>Conta:</td>
    <td align='left'>
    	<select name='conta' id='conta' disabled required>
			<option selected disabled> -- Selecionar -- </option>
	    	<option name='conta'>13.01386-8</option>
	    	<option name='conta'>13.01473-5</option>
    	</select></td>
</tr>
</table><br /><br />
<center>
<?php echo "    <td align='left'><input type='hidden' name='id' value='$id' /><button>Pagar</button></form></td>"; ?>
</center></div>
</body>
</html>
<?php
mysqli_close($link);
?>

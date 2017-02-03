<?php header("Content-type: text/html; charset=ISO-8859-15");
include("conecta.php");
session_start();
function mask($val, $mask)
	{
	 $maskared = '';
	 $k = 0;
	 for($i = 0; $i<=strlen($mask)-1; $i++)
	 {
	 if($mask[$i] == '#')
	 {
	 if(isset($val[$k]))
	 $maskared .= $val[$k++];
	 }
	 else
	 {
	 if(isset($mask[$i]))
	 $maskared .= $mask[$i];
	 }
	 }
	 return $maskared;
	}
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' lang='pt-BR'>
<head>
<meta http-equiv='Content-type' content='text/html; charset=ISO-8859-15' />
<title>Informações Adicionais</title>
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Roboto:300,400' />
<style type='text/css'>
	h1 { font-family: 'Roboto', sans-serif; font-weight: 400; }
	body { font-family: 'Roboto', sans-serif; font-weight: 300; }
	#corpo {
		max-width: 80%;
		align: center;
		text-align: left;
		margin-top: 30px;
	}
	</style>
</head>
<body>
<?php
		$id = $_GET['info'];
		$_SESSION['id'] = $id;
		$sql = "SELECT * FROM novo_cadastro LEFT OUTER JOIN nova_agenda ON novo_cadastro.id_elenco = nova_agenda.id_elenco_agenda LEFT OUTER JOIN financeiro ON novo_cadastro.id_elenco = financeiro.id_elenco_financeiro WHERE id_elenco = '$id'";
		$result = mysqli_query($link, $sql);
		while ($row = mysqli_fetch_array($result)) {
			$nome 						= $row[1]." ".$row[2];
			$email 						= $row['email'];
			$nome_responsavel 			= $row['nome_responsavel'];
			$cpf_responsavel 			= $row['cpf_responsavel'];
			$cpf 						= $row['cpf'];
				if ($cpf_responsavel != NULL) {
					$cpf_responsavel 	= mask($cpf_responsavel, '###.###.###-##');
				} if ($cpf != NULL) {
					$cpf 				= mask($cpf, '###.###.###-##');
				}
			$tipo_cadastro_efetivado 	= $row['tipo_cadastro_efetivado'];
			$dt_nascimento 				= $row['dt_nascimento'];
			$dt_nascimento 				= date('d/m/Y', strtotime($dt_nascimento));
			$sexo 						= $row['sexo'];
			$bairro 					= $row['bairro'];
			$cor_pele 					= $row['cor_pele'];
			$facebook 					= $row['facebook'];
			$instagram 					= $row['instagram'];
			$twitter 					= $row['twitter'];
			$observacao 				= $row['observacao'];
			$timestamp 					= $row['dt_insercao'];
			$timestamp					= date('Y-m-d', strtotime($timestamp));
			$arquivo					= $id."_".$timestamp;
			$comparecimento 			= $row['comparecimento'];
			$status_venda				= $row['status_venda'];
			$produto					= $row['produto'];
			$forma_pagamento			= $row['forma_pagamento'];
			$n_parcelas					= $row['n_parcelas'];
			$valor_venda 				= $row['valor_venda'];
		}
if ($arquivo != NULL) {
echo"	<center><div id='corpo'><a href='../cadastro/fotos/".$arquivo."_01.jpg'><img src='../cadastro/fotos/".$arquivo."_01.jpg' height=100></a>
		<a href='../cadastro/fotos/".$arquivo."_02.jpg'><img src='../cadastro/fotos/".$arquivo."_02.jpg' height=100></a>";
}
echo"<h1>".$nome."</h1>
<p><table border='0' cellpadding='2' cellspacing='0' align='center'>
	<tr>
	<th scope='row' align='right'>Contrato:</th>
	<td align='left'><form target='_blank' name='imprime' action='action_imprime_contrato.php' method='get'><input type='hidden' name='id' value='$id' /><button>Imprimir</button></form></td></tr>";
if ($nome_responsavel != NULL){
	echo " 
	<tr>
	<th scope='row' align='right'>Nome do Responsável:</th>
	<td align='left'>$nome_responsavel</td>
	</tr>";
}
if ($cpf_responsavel != NULL){
	echo " 
    <tr>
      <th scope='row' align='right'>CPF do Responsável:</th>
      <td align='left'>$cpf_responsavel</td>
    </tr>";
}
if ($cpf != NULL){
	echo " 
    <tr>
      <th scope='row' align='right'>CPF:</th>
      <td align='left'>$cpf</td>
    </tr>";
}
if ($bairro != NULL){
	echo " 
    <tr>
      <th scope='row' align='right'>Bairro:</th>
      <td align='left'>$bairro</td>
    </tr>";
}
if ($sexo == "M"){
	echo " 
    <tr>
      <th scope='row' align='right'>Sexo:</th>
      <td align='left'>Maculino</td>
    </tr>";
}
if ($sexo == "F"){
	echo " 
    <tr>
      <th scope='row' align='right'>Sexo:</th>
      <td align='left'>Feminino</td>
    </tr>";
}
if ($cor_pele != NULL){
	echo "
    <tr>
      <th scope='row' align='right'>Cor da Pele:</th>
      <td align='left'>$cor_pele</td>
    </tr>";
}
if ($email != NULL){
	echo "
    <tr>
      <th scope='row' align='right'>E-mail:</th>
      <td align='left'><a href='mailto:$email?Subject=[Magneto%20Elenco]' target='_top'>$email</a></td>
    </tr>";
}
if ($dt_nascimento != NULL){
	echo "
    <tr>
      <th scope='row' align='right'>Nascimento:</th>
      <td align='left'>$dt_nascimento</td>
    </tr>";
}
if ($facebook != NULL){
	echo "
    <tr>
      <th scope='row' align='right'>Facebook:</th>
      <td align='left'><a href='http://www.facebook.com/$facebook' target='_blank'>$facebook</a></td>
    </tr>";
}
if ($instagram != NULL){
	echo "
    <tr>
      <th scope='row' align='right'>Instagram:</th>
      <td align='left'><a href='http://www.instagram.com/$instagram' target='_blank'>$instagram</a></td>
    </tr>";
}
if ($twitter != NULL){
	echo "
    <tr>
      <th scope='row' align='right'>Twitter:</th>
      <td align='left'><a href='http://www.twitter.com/$twitter' target='_blank'>$twitter</a></td>
    </tr>";
}
	if (isset($comparecimento) && $comparecimento == 'Sim') {
echo "<tr><th scope='row' align='right'>Comparecimento:</th><td align='left'>
	<form action='action_comparecimento.php' method='post'>
	<select name='comparecimento_post' onchange='this.form.submit()'>
		<option disabled> -- </option>
		<option disabled selected value='Sim-".$id."'>Sim</option>
		<option value='Não-".$id."'>Não</option>
	</select>
	<noscript><input type='submit' name='comparecimento_post' value='Submit'></noscript>
	</form></td></tr>";
	} elseif (isset($comparecimento) && $comparecimento == 'Não') {
echo "<tr><th scope='row' align='right'>Comparecimento:</th><td align='left'>
	<form action='action_comparecimento.php' method='post'>
	<select name='comparecimento_post' onchange='this.form.submit()'>
		<option disabled> -- </option>
		<option value='Sim-".$id."'>Sim</option>
		<option disabled selected value='Não-".$id."'>Não</option>
    </select>
	<noscript><input type='submit' name='comparecimento_post' value='Submit'></noscript>
	</form></td></tr>";
	} elseif (!isset($comparecimento) || $comparecimento == '') {
echo "<tr><th scope='row' align='right'>Comparecimento:</th><td align='left'>
	<form action='action_comparecimento.php' method='post'>
	<select name='comparecimento_post' onchange='this.form.submit()'>
		<option disabled selected> -- </option>
		<option value='Sim-".$id."'>Sim</option>
		<option value='Não-".$id."'>Não</option>
    </select>
	<noscript><input type='submit' name='comparecimento_post' value='Submit'></noscript>
	</form></td></tr>";
	}
	if (!isset($tipo_cadastro_efetivado) || $tipo_cadastro_efetivado =='') {
echo "<tr><th scope='row' align='right'>Cadastro Final:</th><td align='left'>
<form action='action_tipo_cadastro_efetivado.php' method='post'>
<select name='tipo_cadastro_efetivado_post' onchange='this.form.submit()'>
	<option selected disabled> -- </option>
	<option value='Ator-".$id."'>Ator</option>
	<option value='Gratuito-".$id."'>Gratuito</option>
	<option value='Premium-".$id."'>Premium</option>
	<option value='Ensaio-".$id."'>Ensaio</option>
	<option value='Cancelado-".$id."'>Cancelado</option>
</select>
<noscript><input type='submit' name='tipo_cadastro_efetivado_post' value='Submit'></noscript>
</form></td></tr>";
} elseif (isset($tipo_cadastro_efetivado) && $tipo_cadastro_efetivado == 'Ator') {
echo "<tr><th scope='row' align='right'>Cadastro Final:</th><td align='left'>
<form action='action_tipo_cadastro_efetivado.php' method='post'>
<select name='tipo_cadastro_efetivado_post' onchange='this.form.submit()'>
	<option disabled> -- </option>
	<option disabled selected value='Ator-".$id."'>Ator</option>
	<option value='Gratuito-".$id."'>Gratuito</option>
	<option value='Premium-".$id."'>Premium</option>
	<option value='Ensaio-".$id."'>Ensaio</option>
	<option value='Cancelado-".$id."'>Cancelado</option>
</select>
<noscript><input type='submit' name='tipo_cadastro_efetivado_post' value='Submit'></noscript>
</form></td></tr>";
} elseif (isset($tipo_cadastro_efetivado) && $tipo_cadastro_efetivado == 'Gratuito') {
echo "<tr><th scope='row' align='right'>Cadastro Final:</th><td align='left'>
<form action='action_tipo_cadastro_efetivado.php' method='post'>
<select name='tipo_cadastro_efetivado_post' onchange='this.form.submit()'>
	<option disabled> -- </option>
	<option value='Ator-".$id."'>Ator</option>
	<option disabled selected value='Gratuito-".$id."'>Gratuito</option>
	<option value='Premium-".$id."'>Premium</option>
	<option value='Ensaio-".$id."'>Ensaio</option>
	<option value='Cancelado-".$id."'>Cancelado</option>
</select>
<noscript><input type='submit' name='tipo_cadastro_efetivado_post' value='Submit'></noscript>
</form></td></tr>";
} elseif (isset($tipo_cadastro_efetivado) && $tipo_cadastro_efetivado == 'Premium') {
echo "<tr><th scope='row' align='right'>Cadastro Final:</th><td align='left'>
<form action='action_tipo_cadastro_efetivado.php' method='post'>
<select name='tipo_cadastro_efetivado_post' onchange='this.form.submit()'>
	<option disabled> -- </option>
	<option value='Ator-".$id."'>Ator</option>
	<option value='Gratuito-".$id."'>Gratuito</option>
	<option disabled selected value='Premium-".$id."'>Premium</option>
	<option value='Ensaio-".$id."'>Ensaio</option>
	<option value='Cancelado-".$id."'>Cancelado</option>
</select>
<noscript><input type='submit' name='tipo_cadastro_efetivado_post' value='Submit'></noscript>
</form></td></tr>";
} elseif (isset($tipo_cadastro_efetivado) && $tipo_cadastro_efetivado == 'Ensaio') {
echo "<tr><th scope='row' align='right'>Cadastro Final:</th><td align='left'>
<form action='action_tipo_cadastro_efetivado.php' method='post'>
<select name='tipo_cadastro_efetivado_post' onchange='this.form.submit()'>
	<option disabled> -- </option>
	<option value='Ator-".$id."'>Ator</option>
	<option value='Gratuito-".$id."'>Gratuito</option>
	<option value='Premium-".$id."'>Premium</option>
	<option disabled selected value='Ensaio-".$id."'>Ensaio</option>
	<option value='Cancelado-".$id."'>Cancelado</option>
</select>
<noscript><input type='submit' name='tipo_cadastro_efetivado_post' value='Submit'></noscript>
</form></td></tr>";
} elseif (isset($tipo_cadastro_efetivado) && $tipo_cadastro_efetivado == 'Cancelado') {
echo "<tr><th scope='row' align='right'>Cadastro Final:</th><td align='left'>
<form action='action_tipo_cadastro_efetivado.php' method='post'>
<select name='tipo_cadastro_efetivado_post' onchange='this.form.submit()'>
	<option disabled> -- </option>
	<option value='Ator-".$id."'>Ator</option>
	<option value='Gratuito-".$id."'>Gratuito</option>
	<option value='Premium-".$id."'>Premium</option>
	<option value='Ensaio-".$id."'>Ensaio</option>
	<option disabled selected value='Cancelado-".$id."'>Cancelado</option>
</select>
<noscript><input type='submit' name='tipo_cadastro_efetivado_post' value='Submit'></noscript>
</form></td></tr>";
}
if ($tipo_cadastro_efetivado == 'Ensaio') {
	if (!isset($produto) || $produto == '') {
	echo "<tr><th scope='row' align='right'>Tipo do Ensaio:</th>
	<td align='left'><form action='action_tipo_ensaio.php' method='post'>
	<select name='tipo_ensaio_post' onchange='this.form.submit()'>
		<option disabled selected> -- </option>
		<option value='Ensaio Infantil-".$id."'>Ensaio Infantil</option>
		<option value='Ensaio Estúdio-".$id."'>Ensaio Estúdio</option>
		<option value='Ensaio Externo-".$id."'>Ensaio Externo</option>
	</select>
	<noscript><input type='submit' name='tipo_ensaio_post' value='Submit'></noscript>
	</form></td></tr>";
	} elseif ($produto == 'Ensaio Infantil') {
	echo "<tr><th scope='row' align='right'>Tipo do Ensaio:</th>
	<td align='left'><form action='action_tipo_ensaio.php' method='post'>
	<select name='tipo_ensaio_post' onchange='this.form.submit()'>
		<option disabled> -- </option>
		<option disabled selected value='Ensaio Infantil-".$id."'>Ensaio Infantil</option>
		<option value='Ensaio Estúdio-".$id."'>Ensaio Estúdio</option>
		<option value='Ensaio Externo-".$id."'>Ensaio Externo</option>
	</select>
	<noscript><input type='submit' name='tipo_ensaio_post' value='Submit'></noscript>
	</form></td></tr>";
	} elseif ($produto == 'Ensaio Estúdio') {
	echo "<tr><th scope='row' align='right'>Tipo do Ensaio:</th>
	<td align='left'><form action='action_tipo_ensaio.php' method='post'>
	<select name='tipo_ensaio_post' onchange='this.form.submit()'>
		<option disabled> -- </option>
		<option value='Ensaio Infantil-".$id."'>Ensaio Infantil</option>
		<option disabled selected value='Ensaio Estúdio-".$id."'>Ensaio Estúdio</option>
		<option value='Ensaio Externo-".$id."'>Ensaio Externo</option>
	</select>
	<noscript><input type='submit' name='tipo_ensaio_post' value='Submit'></noscript>
	</form></td></tr>";
	} elseif ($produto == 'Ensaio Externo') {
	echo "<tr><th scope='row' align='right'>Tipo do Ensaio:</th>
	<td align='left'><form action='action_tipo_ensaio.php' method='post'>
	<select name='tipo_ensaio_post' onchange='this.form.submit()'>
		<option disabled> -- </option>
		<option value='Ensaio Infantil-".$id."'>Ensaio Infantil</option>
		<option value='Ensaio Estúdio-".$id."'>Ensaio Estúdio</option>
		<option disabled selected value='Ensaio Externo-".$id."'>Ensaio Externo</option>
	</select>
	<noscript><input type='submit' name='tipo_ensaio_post' value='Submit'></noscript>
	</form></td></tr>";
	} if (!isset($forma_pagamento) || $forma_pagamento == '') {
	echo "<tr><th scope='row' align='right'>Forma de Pagamento:</th>
	<td align='left'><form action='action_forma_pagamento.php' method='post'>
	<select name='forma_pagamento_post' onchange='this.form.submit()'>
		<option disabled selected> -- </option>
	    <option value='Cartão de Crédito-".$id."'>Cartão de Crédito</option>
	    <option value='Cartão de Débito-".$id."'>Cartão de Débito</option>
	    <option value='Dinheiro-".$id."'>Dinheiro</option>
	    <option value='PagSeguro-".$id."'>PagSeguro</option>
	</select>
	<noscript><input type='submit' name='forma_pagamento_post' value='Submit'></noscript>
	</form></td></tr>";
	} elseif ($forma_pagamento == 'Cartão de Crédito') {
	echo "<tr><th scope='row' align='right'>Forma de Pagamento:</th>
	<td align='left'><form action='action_forma_pagamento.php' method='post'>
	<select name='forma_pagamento_post' onchange='this.form.submit()'>
		<option disabled> -- </option>
	    <option disabled selected value='Cartão de Crédito-".$id."'>Cartão de Crédito</option>
	    <option value='Cartão de Débito-".$id."'>Cartão de Débito</option>
	    <option value='Dinheiro-".$id."'>Dinheiro</option>
	    <option value='PagSeguro-".$id."'>PagSeguro</option>
	</select>
	<noscript><input type='submit' name='forma_pagamento_post' value='Submit'></noscript>
	</form></td></tr>";
	} elseif ($forma_pagamento == 'Cartão de Débito') {
	echo "<tr><th scope='row' align='right'>Forma de Pagamento:</th>
	<td align='left'><form action='action_forma_pagamento.php' method='post'>
	<select name='forma_pagamento_post' onchange='this.form.submit()'>
		<option disabled> -- </option>
	    <option value='Cartão de Crédito-".$id."'>Cartão de Crédito</option>
	    <option disabled selected value='Cartão de Débito-".$id."'>Cartão de Débito</option>
	    <option value='Dinheiro-".$id."'>Dinheiro</option>
	    <option value='PagSeguro-".$id."'>PagSeguro</option>
	</select>
	<noscript><input type='submit' name='forma_pagamento_post' value='Submit'></noscript>
	</form></td></tr>";
	} elseif ($forma_pagamento == 'Dinheiro') {
	echo "<tr><th scope='row' align='right'>Forma de Pagamento:</th>
	<td align='left'><form action='action_forma_pagamento.php' method='post'>
	<select name='forma_pagamento_post' onchange='this.form.submit()'>
		<option disabled> -- </option>
	    <option value='Cartão de Crédito-".$id."'>Cartão de Crédito</option>
	    <option value='Cartão de Débito-".$id."'>Cartão de Débito</option>
	    <option disabled selected value='Dinheiro-".$id."'>Dinheiro</option>
	    <option value='PagSeguro-".$id."'>PagSeguro</option>
	</select>
	<noscript><input type='submit' name='forma_pagamento_post' value='Submit'></noscript>
	</form></td></tr>";
	} elseif ($forma_pagamento == 'PagSeguro') {
	echo "<tr><th scope='row' align='right'>Forma de Pagamento:</th>
	<td align='left'><form action='action_forma_pagamento.php' method='post'>
	<select name='forma_pagamento_post' onchange='this.form.submit()'>
		<option disabled> -- </option>
	    <option value='Cartão de Crédito-".$id."'>Cartão de Crédito</option>
	    <option value='Cartão de Débito-".$id."'>Cartão de Débito</option>
	    <option value='Dinheiro-".$id."'>Dinheiro</option>
	    <option disabled selected value='PagSeguro-".$id."'>PagSeguro</option>
	</select>
	<noscript><input type='submit' name='forma_pagamento_post' value='Submit'></noscript>
	</form></td></tr>";
	} 
	if (!isset($n_parcelas) || $n_parcelas == '') {
	echo "<tr><th scope='row' align='right'>Nº de Parcelas:</th>
	<td align='left'><form action='action_n_parcelas.php' method='post'>
	<select name='n_parcelas_post' onchange='this.form.submit()'>
		<option selected disabled> -- </option>
		<option value='1-".$id."'>01</option>
	    <option value='2-".$id."'>02</option>
	    <option value='3-".$id."'>03</option>
	    <option value='4-".$id."'>04</option>
	    <option value='5-".$id."'>05</option>
	    <option value='6-".$id."'>06</option>
	    <option value='7-".$id."'>07</option>
	    <option value='8-".$id."'>08</option>
	    <option value='9-".$id."'>09</option>
	    <option value='10-".$id."'>10</option>
	</select>
	<noscript><input type='submit' name='n_parcelas_post' value='Submit'></noscript>
	</form></td></tr>";
	} elseif ($n_parcelas == '1') {
	echo "<tr><th scope='row' align='right'>Nº de Parcelas:</th>
	<td align='left'><form action='action_n_parcelas.php' method='post'>
	<select name='n_parcelas_post' onchange='this.form.submit()'>
		<option disabled> -- </option>
		<option selected disabled value='1-".$id."'>01</option>
	    <option value='2-".$id."'>02</option>
	    <option value='3-".$id."'>03</option>
	    <option value='4-".$id."'>04</option>
	    <option value='5-".$id."'>05</option>
	    <option value='6-".$id."'>06</option>
	    <option value='7-".$id."'>07</option>
	    <option value='8-".$id."'>08</option>
	    <option value='9-".$id."'>09</option>
	    <option value='10-".$id."'>10</option>
	</select>
	<noscript><input type='submit' name='n_parcelas_post' value='Submit'></noscript>
	</form></td></tr>";
	} elseif ($n_parcelas == '2') {
	echo "<tr><th scope='row' align='right'>Nº de Parcelas:</th>
	<td align='left'><form action='action_n_parcelas.php' method='post'>
	<select name='n_parcelas_post' onchange='this.form.submit()'>
		<option disabled> -- </option>
		<option value='1-".$id."'>01</option>
	    <option selected disabled value='2-".$id."'>02</option>
	    <option value='3-".$id."'>03</option>
	    <option value='4-".$id."'>04</option>
	    <option value='5-".$id."'>05</option>
	    <option value='6-".$id."'>06</option>
	    <option value='7-".$id."'>07</option>
	    <option value='8-".$id."'>08</option>
	    <option value='9-".$id."'>09</option>
	    <option value='10-".$id."'>10</option>
	</select>
	<noscript><input type='submit' name='n_parcelas_post' value='Submit'></noscript>
	</form></td></tr>";
	} elseif ($n_parcelas == '3') {
	echo "<tr><th scope='row' align='right'>Nº de Parcelas:</th>
	<td align='left'><form action='action_n_parcelas.php' method='post'>
	<select name='n_parcelas_post' onchange='this.form.submit()'>
		<option disabled> -- </option>
		<option value='1-".$id."'>01</option>
	    <option value='2-".$id."'>02</option>
	    <option selected disabled value='3-".$id."'>03</option>
	    <option value='4-".$id."'>04</option>
	    <option value='5-".$id."'>05</option>
	    <option value='6-".$id."'>06</option>
	    <option value='7-".$id."'>07</option>
	    <option value='8-".$id."'>08</option>
	    <option value='9-".$id."'>09</option>
	    <option value='10-".$id."'>10</option>
	</select>
	<noscript><input type='submit' name='n_parcelas_post' value='Submit'></noscript>
	</form></td></tr>";
	} elseif ($n_parcelas == '4') {
	echo "<tr><th scope='row' align='right'>Nº de Parcelas:</th>
	<td align='left'><form action='action_n_parcelas.php' method='post'>
	<select name='n_parcelas_post' onchange='this.form.submit()'>
		<option disabled> -- </option>
		<option value='1-".$id."'>01</option>
	    <option value='2-".$id."'>02</option>
	    <option value='3-".$id."'>03</option>
	    <option selected disabled value='4-".$id."'>04</option>
	    <option value='5-".$id."'>05</option>
	    <option value='6-".$id."'>06</option>
	    <option value='7-".$id."'>07</option>
	    <option value='8-".$id."'>08</option>
	    <option value='9-".$id."'>09</option>
	    <option value='10-".$id."'>10</option>
	</select>
	<noscript><input type='submit' name='n_parcelas_post' value='Submit'></noscript>
	</form></td></tr>";
	} elseif ($n_parcelas == '5') {
	echo "<tr><th scope='row' align='right'>Nº de Parcelas:</th>
	<td align='left'><form action='action_n_parcelas.php' method='post'>
	<select name='n_parcelas_post' onchange='this.form.submit()'>
		<option disabled> -- </option>
		<option value='1-".$id."'>01</option>
	    <option value='2-".$id."'>02</option>
	    <option value='3-".$id."'>03</option>
	    <option value='4-".$id."'>04</option>
	    <option selected disabled value='5-".$id."'>05</option>
	    <option value='6-".$id."'>06</option>
	    <option value='7-".$id."'>07</option>
	    <option value='8-".$id."'>08</option>
	    <option value='9-".$id."'>09</option>
	    <option value='10-".$id."'>10</option>
	</select>
	<noscript><input type='submit' name='n_parcelas_post' value='Submit'></noscript>
	</form></td></tr>";
	} elseif ($n_parcelas == '6') {
	echo "<tr><th scope='row' align='right'>Nº de Parcelas:</th>
	<td align='left'><form action='action_n_parcelas.php' method='post'>
	<select name='n_parcelas_post' onchange='this.form.submit()'>
		<option disabled> -- </option>
		<option value='1-".$id."'>01</option>
	    <option value='2-".$id."'>02</option>
	    <option value='3-".$id."'>03</option>
	    <option value='4-".$id."'>04</option>
	    <option value='5-".$id."'>05</option>
	    <option selected disabled value='6-".$id."'>06</option>
	    <option value='7-".$id."'>07</option>
	    <option value='8-".$id."'>08</option>
	    <option value='9-".$id."'>09</option>
	    <option value='10-".$id."'>10</option>
	</select>
	<noscript><input type='submit' name='n_parcelas_post' value='Submit'></noscript>
	</form></td></tr>";
	} elseif ($n_parcelas == '7') {
	echo "<tr><th scope='row' align='right'>Nº de Parcelas:</th>
	<td align='left'><form action='action_n_parcelas.php' method='post'>
	<select name='n_parcelas_post' onchange='this.form.submit()'>
		<option disabled> -- </option>
		<option value='1-".$id."'>01</option>
	    <option value='2-".$id."'>02</option>
	    <option value='3-".$id."'>03</option>
	    <option value='4-".$id."'>04</option>
	    <option value='5-".$id."'>05</option>
	    <option value='6-".$id."'>06</option>
	    <option selected disabled value='7-".$id."'>07</option>
	    <option value='8-".$id."'>08</option>
	    <option value='9-".$id."'>09</option>
	    <option value='10-".$id."'>10</option>
	</select>
	<noscript><input type='submit' name='n_parcelas_post' value='Submit'></noscript>
	</form></td></tr>";
	} elseif ($n_parcelas == '8') {
	echo "<tr><th scope='row' align='right'>Nº de Parcelas:</th>
	<td align='left'><form action='action_n_parcelas.php' method='post'>
	<select name='n_parcelas_post' onchange='this.form.submit()'>
		<option disabled> -- </option>
		<option value='1-".$id."'>01</option>
	    <option value='2-".$id."'>02</option>
	    <option value='3-".$id."'>03</option>
	    <option value='4-".$id."'>04</option>
	    <option value='5-".$id."'>05</option>
	    <option value='6-".$id."'>06</option>
	    <option value='7-".$id."'>07</option>
	    <option selected disabled value='8-".$id."'>08</option>
	    <option value='9-".$id."'>09</option>
	    <option value='10-".$id."'>10</option>
	</select>
	<noscript><input type='submit' name='n_parcelas_post' value='Submit'></noscript>
	</form></td></tr>";
	} elseif ($n_parcelas == '9') {
	echo "<tr><th scope='row' align='right'>Nº de Parcelas:</th>
	<td align='left'><form action='action_n_parcelas.php' method='post'>
	<select name='n_parcelas_post' onchange='this.form.submit()'>
		<option disabled> -- </option>
		<option value='1-".$id."'>01</option>
	    <option value='2-".$id."'>02</option>
	    <option value='3-".$id."'>03</option>
	    <option value='4-".$id."'>04</option>
	    <option value='5-".$id."'>05</option>
	    <option value='6-".$id."'>06</option>
	    <option value='7-".$id."'>07</option>
	    <option value='8-".$id."'>08</option>
	    <option selected disabled value='9-".$id."'>09</option>
	    <option value='10-".$id."'>10</option>
	</select>
	<noscript><input type='submit' name='n_parcelas_post' value='Submit'></noscript>
	</form></td></tr>";
	} elseif ($n_parcelas == '10') {
	echo "<tr><th scope='row' align='right'>Nº de Parcelas:</th>
	<td align='left'><form action='action_n_parcelas.php' method='post'>
	<select name='n_parcelas_post' onchange='this.form.submit()'>
		<option disabled> -- </option>
		<option value='1-".$id."'>01</option>
	    <option value='2-".$id."'>02</option>
	    <option value='3-".$id."'>03</option>
	    <option value='4-".$id."'>04</option>
	    <option value='5-".$id."'>05</option>
	    <option value='6-".$id."'>06</option>
	    <option value='7-".$id."'>07</option>
	    <option value='8-".$id."'>08</option>
	    <option value='9-".$id."'>09</option>
	    <option selected disabled value='10-".$id."'>10</option>
	</select>
	<noscript><input type='submit' name='n_parcelas_post' value='Submit'></noscript>
	</form></td></tr>";
	}
	if (!isset($status_venda) || $status_venda == '') {
	echo "<tr><th scope='row' align='right'>Status do Ensaio:</th>
	<td align='left'><form action='action_status_venda.php' method='post'>
	<select name='status_venda' onchange='this.form.submit()'>
		<option selected disabled> -- </option>
		<option value='Pago-".$id."'>Pago</option>
		<option value='Realizado-".$id."'>Realizado</option>
		<option value='Pronto-".$id."'>Pronto</option>
		<option value='Entregue-".$id."'>Entregue</option>
	</select>
	<noscript><input type='submit' name='status_venda' value='Submit'></noscript>
	</form></td></tr>";
	} elseif ($status_venda == 'Pago') {
	echo "<tr><th scope='row' align='right'>Status do Ensaio:</th>
	<td align='left'><form action='action_status_venda.php' method='post'>
	<select name='status_venda' onchange='this.form.submit()'>
		<option disabled> -- </option>
		<option selected disabled value='Pago-".$id."'>Pago</option>
		<option value='Realizado-".$id."'>Realizado</option>
		<option value='Pronto-".$id."'>Pronto</option>
		<option value='Entregue-".$id."'>Entregue</option>
	</select>
	<noscript><input type='submit' name='status_venda' value='Submit'></noscript>
	</form></td></tr>";
	} elseif ($status_venda == 'Realizado') {
	echo "<tr><th scope='row' align='right'>Status do Ensaio:</th>
	<td align='left'><form action='action_status_venda.php' method='post'>
	<select name='status_venda' onchange='this.form.submit()'>
		<option disabled> -- </option>
		<option value='Pago-".$id."'>Pago</option>
		<option selected disabled value='Realizado-".$id."'>Realizado</option>
		<option value='Pronto-".$id."'>Pronto</option>
		<option value='Entregue-".$id."'>Entregue</option>
	</select>
	<noscript><input type='submit' name='status_venda' value='Submit'></noscript>
	</form></td></tr>";
	} elseif ($status_venda == 'Pronto') {
	echo "<tr><th scope='row' align='right'>Status do Ensaio:</th>
	<td align='left'><form action='action_status_venda.php' method='post'>
	<select name='status_venda' onchange='this.form.submit()'>
		<option disabled> -- </option>
		<option value='Pago-".$id."'>Pago</option>
		<option value='Realizado-".$id."'>Realizado</option>
		<option selected disabled value='Pronto-".$id."'>Pronto</option>
		<option value='Entregue-".$id."'>Entregue</option>
	</select>
	<noscript><input type='submit' name='status_venda' value='Submit'></noscript>
	</form></td></tr>";
	} elseif ($status_venda == 'Entregue') {
	echo "<tr><th scope='row' align='right'>Status do Ensaio:</th>
	<td align='left'><form action='action_status_venda.php' method='post'>
	<select name='status_venda' onchange='this.form.submit()'>
		<option disabled> -- </option>
		<option value='Pago-".$id."'>Pago</option>
		<option value='Realizado-".$id."'>Realizado</option>
		<option value='Pronto-".$id."'>Pronto</option>
		<option selected disabled value='Entregue-".$id."'>Entregue</option>
	</select>
	<noscript><input type='submit' name='status_venda' value='Submit'></noscript>
	</form></td></tr>";
	}
	echo "<tr><th scope='row' align='right'>R$:</th>
	<td align='left'><form action='action_valor_venda.php' method='post'><input type='text' name='valor_venda_post' size='10' ";
	if ($valor_venda == NULL) {
		echo"placeholder='0.00' /> <button type='submit'>Salvar</button></form></td></tr>";
	} elseif ($valor_venda != NULL) {
		echo"value='$valor_venda' /> <button type='submit'>Salvar</button></form></td></tr>";
	}
}
if ($tipo_cadastro_efetivado == 'Premium') {
	if (!isset($forma_pagamento) || $forma_pagamento == '') {
	echo "<tr><th scope='row' align='right'>Forma de Pagamento:</th>
	<td align='left'><form action='action_forma_pagamento.php' method='post'>
	<select name='forma_pagamento_post' onchange='this.form.submit()'>
		<option disabled selected> -- </option>
	    <option value='Cartão de Crédito-".$id."'>Cartão de Crédito</option>
	    <option value='Cartão de Débito-".$id."'>Cartão de Débito</option>
	    <option value='Dinheiro-".$id."'>Dinheiro</option>
	    <option value='PagSeguro-".$id."'>PagSeguro</option>
	</select>
	<noscript><input type='submit' name='forma_pagamento_post' value='Submit'></noscript>
	</form></td></tr>";
	} elseif ($forma_pagamento == 'Cartão de Crédito') {
	echo "<tr><th scope='row' align='right'>Forma de Pagamento:</th>
	<td align='left'><form action='action_forma_pagamento.php' method='post'>
	<select name='forma_pagamento_post' onchange='this.form.submit()'>
		<option disabled> -- </option>
	    <option disabled selected value='Cartão de Crédito-".$id."'>Cartão de Crédito</option>
	    <option value='Cartão de Débito-".$id."'>Cartão de Débito</option>
	    <option value='Dinheiro-".$id."'>Dinheiro</option>
	    <option value='PagSeguro-".$id."'>PagSeguro</option>
	</select>
	<noscript><input type='submit' name='forma_pagamento_post' value='Submit'></noscript>
	</form></td></tr>";
	} elseif ($forma_pagamento == 'Cartão de Débito') {
	echo "<tr><th scope='row' align='right'>Forma de Pagamento:</th>
	<td align='left'><form action='action_forma_pagamento.php' method='post'>
	<select name='forma_pagamento_post' onchange='this.form.submit()'>
		<option disabled> -- </option>
	    <option value='Cartão de Crédito-".$id."'>Cartão de Crédito</option>
	    <option disabled selected value='Cartão de Débito-".$id."'>Cartão de Débito</option>
	    <option value='Dinheiro-".$id."'>Dinheiro</option>
	    <option value='PagSeguro-".$id."'>PagSeguro</option>
	</select>
	<noscript><input type='submit' name='forma_pagamento_post' value='Submit'></noscript>
	</form></td></tr>";
	} elseif ($forma_pagamento == 'Dinheiro') {
	echo "<tr><th scope='row' align='right'>Forma de Pagamento:</th>
	<td align='left'><form action='action_forma_pagamento.php' method='post'>
	<select name='forma_pagamento_post' onchange='this.form.submit()'>
		<option disabled> -- </option>
	    <option value='Cartão de Crédito-".$id."'>Cartão de Crédito</option>
	    <option value='Cartão de Débito-".$id."'>Cartão de Débito</option>
	    <option disabled selected value='Dinheiro-".$id."'>Dinheiro</option>
	    <option value='PagSeguro-".$id."'>PagSeguro</option>
	</select>
	<noscript><input type='submit' name='forma_pagamento_post' value='Submit'></noscript>
	</form></td></tr>";
	} elseif ($forma_pagamento == 'PagSeguro') {
	echo "<tr><th scope='row' align='right'>Forma de Pagamento:</th>
	<td align='left'><form action='action_forma_pagamento.php' method='post'>
	<select name='forma_pagamento_post' onchange='this.form.submit()'>
		<option disabled> -- </option>
	    <option value='Cartão de Crédito-".$id."'>Cartão de Crédito</option>
	    <option value='Cartão de Débito-".$id."'>Cartão de Débito</option>
	    <option value='Dinheiro-".$id."'>Dinheiro</option>
	    <option disabled selected value='PagSeguro-".$id."'>PagSeguro</option>
	</select>
	<noscript><input type='submit' name='forma_pagamento_post' value='Submit'></noscript>
	</form></td></tr>";
	} 
	if (!isset($n_parcelas) || $n_parcelas == '') {
	echo "<tr><th scope='row' align='right'>Nº de Parcelas:</th>
	<td align='left'><form action='action_n_parcelas.php' method='post'>
	<select name='n_parcelas_post' onchange='this.form.submit()'>
		<option selected disabled> -- </option>
		<option value='1-".$id."'>01</option>
	    <option value='2-".$id."'>02</option>
	    <option value='3-".$id."'>03</option>
	    <option value='4-".$id."'>04</option>
	    <option value='5-".$id."'>05</option>
	    <option value='6-".$id."'>06</option>
	    <option value='7-".$id."'>07</option>
	    <option value='8-".$id."'>08</option>
	    <option value='9-".$id."'>09</option>
	    <option value='10-".$id."'>10</option>
	</select>
	<noscript><input type='submit' name='n_parcelas_post' value='Submit'></noscript>
	</form></td></tr>";
	} elseif ($n_parcelas == '1') {
	echo "<tr><th scope='row' align='right'>Nº de Parcelas:</th>
	<td align='left'><form action='action_n_parcelas.php' method='post'>
	<select name='n_parcelas_post' onchange='this.form.submit()'>
		<option disabled> -- </option>
		<option selected disabled value='1-".$id."'>01</option>
	    <option value='2-".$id."'>02</option>
	    <option value='3-".$id."'>03</option>
	    <option value='4-".$id."'>04</option>
	    <option value='5-".$id."'>05</option>
	    <option value='6-".$id."'>06</option>
	    <option value='7-".$id."'>07</option>
	    <option value='8-".$id."'>08</option>
	    <option value='9-".$id."'>09</option>
	    <option value='10-".$id."'>10</option>
	</select>
	<noscript><input type='submit' name='n_parcelas_post' value='Submit'></noscript>
	</form></td></tr>";
	} elseif ($n_parcelas == '2') {
	echo "<tr><th scope='row' align='right'>Nº de Parcelas:</th>
	<td align='left'><form action='action_n_parcelas.php' method='post'>
	<select name='n_parcelas_post' onchange='this.form.submit()'>
		<option disabled> -- </option>
		<option value='1-".$id."'>01</option>
	    <option selected disabled value='2-".$id."'>02</option>
	    <option value='3-".$id."'>03</option>
	    <option value='4-".$id."'>04</option>
	    <option value='5-".$id."'>05</option>
	    <option value='6-".$id."'>06</option>
	    <option value='7-".$id."'>07</option>
	    <option value='8-".$id."'>08</option>
	    <option value='9-".$id."'>09</option>
	    <option value='10-".$id."'>10</option>
	</select>
	<noscript><input type='submit' name='n_parcelas_post' value='Submit'></noscript>
	</form></td></tr>";
	} elseif ($n_parcelas == '3') {
	echo "<tr><th scope='row' align='right'>Nº de Parcelas:</th>
	<td align='left'><form action='action_n_parcelas.php' method='post'>
	<select name='n_parcelas_post' onchange='this.form.submit()'>
		<option disabled> -- </option>
		<option value='1-".$id."'>01</option>
	    <option value='2-".$id."'>02</option>
	    <option selected disabled value='3-".$id."'>03</option>
	    <option value='4-".$id."'>04</option>
	    <option value='5-".$id."'>05</option>
	    <option value='6-".$id."'>06</option>
	    <option value='7-".$id."'>07</option>
	    <option value='8-".$id."'>08</option>
	    <option value='9-".$id."'>09</option>
	    <option value='10-".$id."'>10</option>
	</select>
	<noscript><input type='submit' name='n_parcelas_post' value='Submit'></noscript>
	</form></td></tr>";
	} elseif ($n_parcelas == '4') {
	echo "<tr><th scope='row' align='right'>Nº de Parcelas:</th>
	<td align='left'><form action='action_n_parcelas.php' method='post'>
	<select name='n_parcelas_post' onchange='this.form.submit()'>
		<option disabled> -- </option>
		<option value='1-".$id."'>01</option>
	    <option value='2-".$id."'>02</option>
	    <option value='3-".$id."'>03</option>
	    <option selected disabled value='4-".$id."'>04</option>
	    <option value='5-".$id."'>05</option>
	    <option value='6-".$id."'>06</option>
	    <option value='7-".$id."'>07</option>
	    <option value='8-".$id."'>08</option>
	    <option value='9-".$id."'>09</option>
	    <option value='10-".$id."'>10</option>
	</select>
	<noscript><input type='submit' name='n_parcelas_post' value='Submit'></noscript>
	</form></td></tr>";
	} elseif ($n_parcelas == '5') {
	echo "<tr><th scope='row' align='right'>Nº de Parcelas:</th>
	<td align='left'><form action='action_n_parcelas.php' method='post'>
	<select name='n_parcelas_post' onchange='this.form.submit()'>
		<option disabled> -- </option>
		<option value='1-".$id."'>01</option>
	    <option value='2-".$id."'>02</option>
	    <option value='3-".$id."'>03</option>
	    <option value='4-".$id."'>04</option>
	    <option selected disabled value='5-".$id."'>05</option>
	    <option value='6-".$id."'>06</option>
	    <option value='7-".$id."'>07</option>
	    <option value='8-".$id."'>08</option>
	    <option value='9-".$id."'>09</option>
	    <option value='10-".$id."'>10</option>
	</select>
	<noscript><input type='submit' name='n_parcelas_post' value='Submit'></noscript>
	</form></td></tr>";
	} elseif ($n_parcelas == '6') {
	echo "<tr><th scope='row' align='right'>Nº de Parcelas:</th>
	<td align='left'><form action='action_n_parcelas.php' method='post'>
	<select name='n_parcelas_post' onchange='this.form.submit()'>
		<option disabled> -- </option>
		<option value='1-".$id."'>01</option>
	    <option value='2-".$id."'>02</option>
	    <option value='3-".$id."'>03</option>
	    <option value='4-".$id."'>04</option>
	    <option value='5-".$id."'>05</option>
	    <option selected disabled value='6-".$id."'>06</option>
	    <option value='7-".$id."'>07</option>
	    <option value='8-".$id."'>08</option>
	    <option value='9-".$id."'>09</option>
	    <option value='10-".$id."'>10</option>
	</select>
	<noscript><input type='submit' name='n_parcelas_post' value='Submit'></noscript>
	</form></td></tr>";
	} elseif ($n_parcelas == '7') {
	echo "<tr><th scope='row' align='right'>Nº de Parcelas:</th>
	<td align='left'><form action='action_n_parcelas.php' method='post'>
	<select name='n_parcelas_post' onchange='this.form.submit()'>
		<option disabled> -- </option>
		<option value='1-".$id."'>01</option>
	    <option value='2-".$id."'>02</option>
	    <option value='3-".$id."'>03</option>
	    <option value='4-".$id."'>04</option>
	    <option value='5-".$id."'>05</option>
	    <option value='6-".$id."'>06</option>
	    <option selected disabled value='7-".$id."'>07</option>
	    <option value='8-".$id."'>08</option>
	    <option value='9-".$id."'>09</option>
	    <option value='10-".$id."'>10</option>
	</select>
	<noscript><input type='submit' name='n_parcelas_post' value='Submit'></noscript>
	</form></td></tr>";
	} elseif ($n_parcelas == '8') {
	echo "<tr><th scope='row' align='right'>Nº de Parcelas:</th>
	<td align='left'><form action='action_n_parcelas.php' method='post'>
	<select name='n_parcelas_post' onchange='this.form.submit()'>
		<option disabled> -- </option>
		<option value='1-".$id."'>01</option>
	    <option value='2-".$id."'>02</option>
	    <option value='3-".$id."'>03</option>
	    <option value='4-".$id."'>04</option>
	    <option value='5-".$id."'>05</option>
	    <option value='6-".$id."'>06</option>
	    <option value='7-".$id."'>07</option>
	    <option selected disabled value='8-".$id."'>08</option>
	    <option value='9-".$id."'>09</option>
	    <option value='10-".$id."'>10</option>
	</select>
	<noscript><input type='submit' name='n_parcelas_post' value='Submit'></noscript>
	</form></td></tr>";
	} elseif ($n_parcelas == '9') {
	echo "<tr><th scope='row' align='right'>Nº de Parcelas:</th>
	<td align='left'><form action='action_n_parcelas.php' method='post'>
	<select name='n_parcelas_post' onchange='this.form.submit()'>
		<option disabled> -- </option>
		<option value='1-".$id."'>01</option>
	    <option value='2-".$id."'>02</option>
	    <option value='3-".$id."'>03</option>
	    <option value='4-".$id."'>04</option>
	    <option value='5-".$id."'>05</option>
	    <option value='6-".$id."'>06</option>
	    <option value='7-".$id."'>07</option>
	    <option value='8-".$id."'>08</option>
	    <option selected disabled value='9-".$id."'>09</option>
	    <option value='10-".$id."'>10</option>
	</select>
	<noscript><input type='submit' name='n_parcelas_post' value='Submit'></noscript>
	</form></td></tr>";
	} elseif ($n_parcelas == '10') {
	echo "<tr><th scope='row' align='right'>Nº de Parcelas:</th>
	<td align='left'><form action='action_n_parcelas.php' method='post'>
	<select name='n_parcelas_post' onchange='this.form.submit()'>
		<option disabled> -- </option>
		<option value='1-".$id."'>01</option>
	    <option value='2-".$id."'>02</option>
	    <option value='3-".$id."'>03</option>
	    <option value='4-".$id."'>04</option>
	    <option value='5-".$id."'>05</option>
	    <option value='6-".$id."'>06</option>
	    <option value='7-".$id."'>07</option>
	    <option value='8-".$id."'>08</option>
	    <option value='9-".$id."'>09</option>
	    <option selected disabled value='10-".$id."'>10</option>
	</select>
	<noscript><input type='submit' name='n_parcelas_post' value='Submit'></noscript>
	</form></td></tr>";
	}
	if (!isset($status_venda) || $status_venda == '') {
	echo "<tr><th scope='row' align='right'>Status do Premium:</th>
	<td align='left'><form action='action_status_venda.php' method='post'>
	<select name='status_venda' onchange='this.form.submit()'>
		<option selected disabled> -- </option>
		<option value='Pago-".$id."'>Pago</option>
		<option value='Realizado-".$id."'>Realizado</option>
	</select>
	<noscript><input type='submit' name='status_venda' value='Submit'></noscript>
	</form></td></tr>";
	} elseif ($status_venda == 'Pago') {
	echo "<tr><th scope='row' align='right'>Status do Premium:</th>
	<td align='left'><form action='action_status_venda.php' method='post'>
	<select name='status_venda' onchange='this.form.submit()'>
		<option disabled> -- </option>
		<option selected disabled value='Pago-".$id."'>Pago</option>
		<option value='Realizado-".$id."'>Realizado</option>
	</select>
	<noscript><input type='submit' name='status_venda' value='Submit'></noscript>
	</form></td></tr>";
	} elseif ($status_venda == 'Realizado') {
	echo "<tr><th scope='row' align='right'>Status do Premium:</th>
	<td align='left'><form action='action_status_venda.php' method='post'>
	<select name='status_venda' onchange='this.form.submit()'>
		<option disabled> -- </option>
		<option value='Pago-".$id."'>Pago</option>
		<option selected disabled value='Realizado-".$id."'>Realizado</option>
	</select>
	<noscript><input type='submit' name='status_venda' value='Submit'></noscript>
	</form></td></tr>";
	} 
	echo "<tr><th scope='row' align='right'>R$:</th>
	<td align='left'><form action='action_valor_venda.php' method='post'><input type='text' name='valor_venda_post' size='10' ";
	if ($valor_venda == NULL) {
		echo"placeholder='0.00' /> <button type='submit'>Salvar</button></form></td></tr>";
	} elseif ($valor_venda != NULL) {
		echo"value='$valor_venda' /> <button type='submit'>Salvar</button></form></td></tr>";
	}
}
	if ($observacao != NULL){
		echo "
	    <tr>
	      <th scope='row' align='right'>Observação:</th>
	      <td align='left'><form action='action_observacao.php' method='post'><textarea name='observacao' cols='30' rows='3' style='width:200px; height:75px; font-size: 10pt;' maxlength='255'>$observacao</textarea><BR/><button type='submit'>Salvar</button></form></td>
	    </tr>";
	} elseif ($observacao == NULL){
		echo "
	    <tr>
	      <th scope='row' align='right'>Observação:</th>
	      <td align='left'><form action='action_observacao.php' method='post'><textarea name='observacao' cols='30' rows='3' style='width:200px; height:75px; font-size: 10pt;' placeholder='Digite aqui' maxlength='255'></textarea><BR/><button type='submit'>Salvar</button></form></td>
	    </tr>";
	}
?>
</table></p>
</div></center>
</body>
</html>
<?php
mysqli_close($link);
?>
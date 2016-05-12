<?php header("Content-type: text/html; charset=ISO-8859-15");
include("conecta.php");
session_start();
date_default_timezone_set('America/Sao_Paulo');
	$id_elenco = $_POST['id'];
	$cpf = $_POST['cpf'];
    $tipo_cadastro_vigente = $_SESSION['novo_cadastro'];
	$hoje = date('Y-m-d', time());
	$hoje_hora = date('Y-m-d H:i:s');
	$sql_caches = "SELECT id, cache_liquido, abatimento_cache, valor_cheque FROM financeiro WHERE status_pagamento = 0 AND id_elenco_financeiro = '$id_elenco' ORDER BY cache_liquido DESC";
	$result = mysqli_query($link, $sql_caches);
	if (!$result) {
		die("Database query failed: " . mysqli_error());
	}
			$n = 1;
			while ($row = mysqli_fetch_array($result)) {
				${'id_novo_cache_'.$n} = $row['id'];
				${'cache_liquido_'.$n} = $row['cache_liquido'];
				${'abatimento_cache_'.$n} = $row['abatimento_cache'];
				${'valor_cheque_'.$n} = $row['valor_cheque'];
				$n++;
			}
	$sql_saldo = "SELECT financeiro.nome, sobrenome, cpf, email, valor_premium, valor_profissional, SUM(cache_liquido) AS saldo_a_receber, SUM(abatimento_cache) AS abatimento, SUM(valor_cheque) AS cheque FROM financeiro LEFT OUTER JOIN tb_elenco ON tb_elenco.id_elenco = financeiro.id_elenco_financeiro LEFT OUTER JOIN promo_maio ON promo_maio.id = financeiro.id_elenco_financeiro WHERE tipo_entrada = 'Cache' AND status_pagamento = 0 AND id_elenco_financeiro = '$id_elenco'";
		$result2 = mysqli_query($link, $sql_saldo);
		if (!$result2) {
			die("Database query failed: " . mysqli_error());
		}
		$row2 = mysqli_fetch_array($result2);
			$nome = $row2['nome'];
			$sobrenome = $row2['sobrenome'];
			$cpf_original = $row2['cpf'];
			$email = $row2['email'];
			$cpf_original = str_replace('.', '', $cpf_original);
			$cpf_original = str_replace('-', '', $cpf_original);
			$cpf_original = str_replace(' ', '', $cpf_original);
			$valor_premium = $row2['valor_premium'];
			$valor_profissional = $row2['valor_profissional'];

	if ($cpf == $cpf_original) {
		if ($tipo_cadastro_vigente == 'Premium') {
			$produto = "Cadastro Premium";
			$descontado = $valor_premium;
			$valor = $valor_premium;
			$sql_tb_elenco = "UPDATE tb_elenco SET tipo_cadastro_vigente = '$tipo_cadastro_vigente', data_contrato_vigente = '$hoje' WHERE id_elenco = '$id_elenco'";
			mysqli_query($link, $sql_tb_elenco);
			mysqli_query($link2, $sql_tb_elenco);
		} if ($tipo_cadastro_vigente == 'Profissional') {
			$produto = "Cadastro Profissional";
			$descontado = $valor_profissional;
			$valor = $valor_profissional;
			$sql_tb_elenco = "UPDATE tb_elenco SET tipo_cadastro_vigente = '$tipo_cadastro_vigente', data_contrato_vigente = '$hoje' WHERE id_elenco = '$id_elenco'";
			mysqli_query($link, $sql_tb_elenco);
			mysqli_query($link2, $sql_tb_elenco);
		} if ($tipo_cadastro_vigente == 'Ator') {
			$descontado = 0;
			$sql_tb_elenco = "UPDATE tb_elenco SET tipo_cadastro_vigente = '$tipo_cadastro_vigente', data_contrato_vigente = '$hoje' WHERE id_elenco = '$id_elenco'";
			mysqli_query($link, $sql_tb_elenco);
			mysqli_query($link2, $sql_tb_elenco);
		} if ($tipo_cadastro_vigente == 'Gratuito') {
			$descontado = 0;
			$sql_tb_elenco = "UPDATE tb_elenco SET tipo_cadastro_vigente = '$tipo_cadastro_vigente', data_contrato_vigente = '$hoje' WHERE id_elenco = '$id_elenco'";
			mysqli_query($link, $sql_tb_elenco);
			mysqli_query($link2, $sql_tb_elenco);
		}
		if ($descontado != 0) {
			$n = 1;
			while ($descontado > 0) {
				if ($descontado > ${'cache_liquido_'.$n}) {
					${'sql_utilizar_novo_'.$n} = "UPDATE financeiro SET abatimento_cache = '${'cache_liquido_'.$n}', data_abatimento = '$hoje', produto_abatimento = '$produto', liberado = '1', status_pagamento = '1' WHERE id = '${'id_novo_cache_'.$n}'";
					mysqli_query($link, ${'sql_utilizar_novo_'.$n});
					$descontado = $descontado - ${'cache_liquido_'.$n};					
				} elseif ($descontado == ${'cache_liquido_'.$n}) {
					${'sql_utilizar_novo_'.$n} = "UPDATE financeiro SET abatimento_cache = '${'cache_liquido_'.$n}', data_abatimento = '$hoje', produto_abatimento = '$produto', liberado = '1', status_pagamento = '1' WHERE id = '${'id_novo_cache_'.$n}'";
					mysqli_query($link, ${'sql_utilizar_novo_'.$n});
					$descontado = 0;
				} elseif ($descontado < ${'cache_liquido_'.$n}) {
					${'sql_utilizar_novo_'.$n} = "UPDATE financeiro SET abatimento_cache = '$descontado', data_abatimento = '$hoje', produto_abatimento = '$produto' WHERE id = '${'id_novo_cache_'.$n}'";
					mysqli_query($link, ${'sql_utilizar_novo_'.$n});
					$descontado = 0;
				}
				$n++;
			}
			$sql_venda = "INSERT INTO financeiro (tipo_entrada, nome, sobrenome, id_elenco_financeiro, produto, status_venda, qtd, valor_venda, data_venda, forma_pagamento, n_parcelas) VALUES ('Venda', '$nome','$sobrenome','$id_elenco','$produto','Pago','1','$valor','$hoje','Abatimento de Cachê','1')";
			mysqli_query($link, $sql_venda);
		}
		$sql_promo = "UPDATE promo_maio SET data_efetivacao = '$hoje_hora', cadastro_escolhido = '$tipo_cadastro_vigente' WHERE id = '$id_elenco'";					
		mysqli_query($link, $sql_promo);

		if ($row2['abatimento'] == NULL || $row2['abatimento'] == '' || $row2['abatimento'] == '0') {
			$abatimento_total = 0;
		} elseif ($row2['abatimento'] != NULL && $row2['abatimento'] != '' || $row2['abatimento'] != '0') {
			$abatimento_total = $row2['abatimento'];
		} if ($row2['cheque'] == NULL || $row2['cheque'] == '') {
			$cheque_total = 0;
		} elseif ($row2['cheque'] != NULL && $row2['cheque'] != '') {
			$cheque_total = $row2['cheque'];
		}
			$saldo_a_receber = $row2['saldo_a_receber'] - $abatimento_total - $cheque_total - $valor;
			$saldo_a_receber_format = number_format($saldo_a_receber,2,",",".");

echo "<!DOCTYPE html>
<html xmlns='http://www.w3.org/1999/xhtml' lang='pt-BR'>
<head>
<meta http-equiv='Content-type' content='text/html; charset=ISO-8859-15' />
<title>Magneto Elenco - Promoção do Mês de Maio</title>
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Roboto:300,400' />
<style type='text/css'>
	h1 { font-family: 'Roboto', sans-serif; font-weight: 400; }
	body {
		font-family: 'Roboto', sans-serif; font-weight: 300;
		font-size: large;
		color: white;
		position: relative;
		background: url(images/bg.jpg) no-repeat top center;
		height: 100%;
		width: 100%;
		overflow: hidden;
	}
	#corpo {
		max-width: 90%;
		align: center;
		text-align: left;
		margin-top: 30px;
	}
	#texto {
		max-width: 80%;
		align: center;
		text-align: left;
		margin-top: 60px;
	}
	table {
    border-collapse: collapse;
	}
	th, td {
	    border-bottom: 1px solid white;
		font-family: 'Roboto', sans-serif; font-weight: 300;
		font-size: medium;
		color: white;
	}
	</style>
	</head>
<body>
<center><div id='corpo'>
<img src='images/logo.svg' /><BR /><BR />
<center><div id='texto'>
<p><h1>Seu contrato foi renovado!</h1></p><BR />
<p>Muito obrigado por demonstrar mais uma vez sua confiança na Magneto Elenco, $nome.<BR />Seu cadastro acaba de ser reativado e você já pode participar de novos trabalhos com o Cadastro $tipo_cadastro_vigente.</p><BR />
<p></p>
<table border='0' cellpadding='2' cellspacing='0'>
<tr>
    <th scope='row' align='left'><div style='font-size: large'>Você ainda tem:</div></th>
    <td align='right'><div style='font-size: x-large'><strong>R$ $saldo_a_receber,00</strong></div></td>
    <td align='left'><div style='font-size: small'>(no total em cachês a receber)</div></td>
</tr>
</table><br />
<p>Que venham muitos trabalhos! :)</p>
</div></div></center>
</body>
</html>";
	} else {
	function mask($val, $mask) {
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
	$cpf = mask($cpf, '###.###.###-##');
echo "<!DOCTYPE html>
<html xmlns='http://www.w3.org/1999/xhtml' lang='pt-BR'>
<head>
<meta http-equiv='Content-type' content='text/html; charset=ISO-8859-15' />
<title>Magneto Elenco - Promoção do Mês de Maio</title>
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Roboto:300,400' />
<style type='text/css'>
	h1 { font-family: 'Roboto', sans-serif; font-weight: 400; }
	body {
		font-family: 'Roboto', sans-serif; font-weight: 300;
		font-size: large;
		color: white;
		position: relative;
		background: url(images/bg.jpg) no-repeat top center;
		height: 100%;
		width: 100%;
		overflow: hidden;
	}
	#corpo {
		max-width: 90%;
		align: center;
		text-align: left;
		margin-top: 30px;
	}
	#texto {
		max-width: 80%;
		align: center;
		text-align: left;
		margin-top: 60px;
	}
	a:link {color:white;text-decoration:none;}
	a:visited {color:white;text-decoration:none;}
	a:hover {color:purple;text-decoration:none;}
	a:active {color:white;text-decoration:none;}
	</style>
	</head>
<body>
<center><div id='corpo'>
<img src='images/logo.svg' /><BR /><BR />
<center><div id='texto'>
<p><h1>Ops! Tem certeza que seu CPF é esse, $nome?</h1></p><BR />
<p>Você digitou este CPF:<BR /><strong>$cpf</p></strong></p><BR />
<p>Se ele estiver correto e ainda estiver dando erro, me <a href='mailto:vini@magnetoelenco.com.br'><strong><u>manda um e-mail</strong></u></a> ou me liga que eu resolvo pra você:<BR /><BR />Vini Goulart<BR />(61) 3202-7266</p>
</div></div></center>
</body>
</html>";
}
mysqli_close($link);
mysqli_close($link2);
?>
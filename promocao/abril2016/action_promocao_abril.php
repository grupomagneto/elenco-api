<?php header("Content-type: text/html; charset=ISO-8859-15");
include("conecta.php");
		$id_elenco = $_POST['id'];
		$cpf = $_POST['cpf'];
		$hoje = date('Y-m-d', time());
		$sql = "SELECT id_elenco_financeiro, financeiro.nome, sobrenome, cache_liquido, cliente_job, campanha, data_job, previsao_pagamento, email, cpf FROM financeiro LEFT OUTER JOIN tb_elenco ON tb_elenco.id_elenco = financeiro.id_elenco_financeiro WHERE id_elenco = '$id_elenco' AND tipo_cache = '1º Cachê Cadastro Gratuito'";
		$result = mysqli_query($link, $sql);
			if (!$result) {
			 die("Database query failed: " . mysqli_error());
			}
		$row = mysqli_fetch_array($result);
			$nome = $row['nome'];
			$sobrenome = $row['sobrenome'];
			$cache_liquido = $row['cache_liquido'];
			$novo_cache = $cache_liquido - 199.00;
			$cache_liquido = number_format($cache_liquido,2,",",".");
			$cliente_job = $row['cliente_job'];
			$campanha = $row['campanha'];
			$data_job = $row['data_job'];
			$previsao_pagamento = $row['previsao_pagamento'];
			$email = $row['email'];
			$cpf_original = $row['cpf'];
			$cpf_original = str_replace('.', '', $cpf_original);
			$cpf_original = str_replace('-', '', $cpf_original);
			$cpf_original = str_replace(' ', '', $cpf_original);
			$previsao = date('d/m/Y', strtotime($data_job." + ".$previsao_pagamento." days"));
			$data_job = date('d/m/Y', strtotime($data_job));

	if ($cpf == $cpf_original) {
		$sql_cadastro = "UPDATE tb_elenco SET tipo_cadastro_vigente = 'Premium', exclusivo = '1', observacoes = NULL WHERE id_elenco = '$id_elenco'";
		$sql_cache = "UPDATE financeiro SET liberado = '1', abatimento_cache = '199' WHERE tipo_cache = '1º Cachê Cadastro Gratuito' AND id_elenco_financeiro = '$id_elenco'";
		$sql_venda = "INSERT INTO financeiro (tipo_entrada, nome, sobrenome, id_elenco_financeiro, produto, qtd, valor_venda, status_venda, data_venda, forma_pagamento, n_parcelas) VALUES ('Venda', '$nome','$sobrenome','$id_elenco','Cadastro Premium','1','199','Pago','$hoje','Abatimento Cachê','1')";
		mysqli_query($link, $sql_cadastro);
		mysqli_query($link, $sql_cache);
		mysqli_query($link, $sql_venda);

// 		$remetente = 'vini@magneto';
// 		$to      = 'To: Vinicius Goulart <vinicius.goulart@gmail.com>';
// 		$subject = 'Você agora é Premium!';
// 		$message = 'Teste de E-mail';
// 		$headers = 'MIME-Version: 1.0\r\n';
// 		$headers .= 'Content-type: text/html; charset=ISO-8859-15\r\n';
// 		$headers .= 'From: Magneto Elenco <vini@magnetoelenco.com.br>\r\n';
// 		$headers .= 'Reply-To: vini@magnetoelenco.com.br\r\n';
// 		$headers .= 'X-Mailer: PHP/' . phpversion();
// 		// $headers .= 'From: vini@magnetoelenco.com.br' . "\r\n" .
// 		//     'Reply-To: webmaster@example.com' . "\r\n" .
// 		//     'X-Mailer: PHP/' . phpversion();

// $email_remetente = "eu@seudominio.com";
// $headers = "MIME-Version: 1.1\n";
// $headers .= "Content-type: text/plain; charset=iso-8859-1\n";
// $headers .= "From: $email_remetente\n"; // remetente
// $headers .= "Return-Path: $email_remetente\n"; // return-path
// $headers .= "Reply-To: $email_usuario\n"; // Endereço (devidamente validado) que o seu usuário informou no contato
// $envio = mail("destinatario@algum-email.com", "Assunto", "Mensagem", $headers, "-f$email_remetente");


// 		if (mail($to, $subject, $message, $headers, "-f$email_remetente")) {
// 			echo "Sucesso";
// 		}

echo "<!DOCTYPE html>
<html xmlns='http://www.w3.org/1999/xhtml' lang='pt-BR'>
<head>
<meta http-equiv='Content-type' content='text/html; charset=ISO-8859-15' />
<title>Magneto Elenco - Promoção do Mês de Abril</title>
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
<p><h1>Você agora é Premium!</h1></p><BR />
<p>Parabéns $nome! A partir de agora você aproveita as vantagens de ser Premium e já pode vir retirar o saldo restante do seu cachê:</p>
<table border='0' cellpadding='2' cellspacing='0'>
<tr>
    <th scope='row' align='left'><div style='font-size: large'>Você ainda tem:</div></th>
    <td align='right'><div style='font-size: x-large'><strong>R$ $novo_cache,00</strong></div></td>
</tr>
</table><br />
<p>Obrigado pela confiança e até o próximo trabalho!</p>
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
<title>Magneto Elenco - Promoção do Mês de Abril</title>
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
<p><h1>Ops! Tem certeza que seu CPF é esse?</h1></p><BR />
<p>Você digitou este CPF:<BR /><strong>$cpf</p></strong></p><BR />
<p>Se ele estiver correto e ainda estiver dando erro, me <a href='mailto:vini@magnetoelenco.com.br'><strong><u>manda um e-mail</strong></u></a> ou me liga que eu resolvo pra você:<BR /><BR />Vini Goulart<BR />(61) 3202-7266</p>
</div></div></center>
</body>
</html>";
	}
?>

<?php
mysqli_close($link);
?>
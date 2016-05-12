<?php header("Content-type: text/html; charset=ISO-8859-15");
include("conecta.php");
session_start();
date_default_timezone_set('America/Sao_Paulo');
		$hoje = date('Y-m-d', time());
		if ($hoje > '2016-05-31'){
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
	</style>
	<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-22229864-1', 'auto');
  ga('send', 'pageview');

</script>
</head>
<body>
<center><div id='corpo'>
<img src='images/logo.svg' /><BR /><BR />
<center><div id='texto'>
<p><h1>Essa Promoção acabou... :(</h1></p><BR />
<p>Mas você ainda pode aproveitar seu Saldo de Cachês para mudar para o Renovar seu contrato. Entre em contato pelo telefone (61) 3202-7266 que a gente te ajuda!</p><BR />
</div></div></center>
</body>
</html>";
		} else {
		$id_elenco = $_GET['id'];
		$novo_cadastro = $_GET['cadastro'];
		$_SESSION['novo_cadastro'] = $novo_cadastro;
		$original_premium = 299;
		$original_profissional = 999;
		$sql = "SELECT tb_elenco.id_elenco, financeiro.nome, financeiro.sobrenome, SUM(financeiro.cache_liquido)-SUM(financeiro.abatimento_cache)-SUM(financeiro.valor_cheque) AS saldo, promo_maio.valor_premium, promo_maio.valor_profissional, tb_elenco.email, tb_elenco.cpf FROM tb_elenco LEFT OUTER JOIN financeiro ON financeiro.id_elenco_financeiro = tb_elenco.id_elenco LEFT OUTER JOIN promo_maio ON promo_maio.id = tb_elenco.id_elenco WHERE tb_elenco.id_elenco = '$id_elenco' AND financeiro.status_pagamento = '0' AND promo_maio.data_efetivacao IS NULL";
			$result = mysqli_query($link, $sql);
			if (!$result) {
			 die("Database query failed: " . mysqli_error());
			}
			$row = mysqli_fetch_array($result);
			$saldo_inicial = $row['saldo'];
			$saldo_inicial = number_format($saldo_inicial,0,"",".");
			if ($novo_cadastro == 'Premium' || $novo_cadastro == 'premium') {
				$utilizado = $row['valor_premium'];
				$utilizado = number_format($utilizado,0,"",".");
			} if ($novo_cadastro == 'Profissional' || $novo_cadastro == 'profissional') {
				$utilizado = $row['valor_profissional'];
				$utilizado = number_format($utilizado,0,"",".");
			}
			if ($row['nome'] == NULL){
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
					<script>
					(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
					(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
					m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
					})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

					ga('create', 'UA-22229864-1', 'auto');
					ga('send', 'pageview');

					</script>
					</head>
				<body>
				<center><div id='corpo'>
				<img src='images/logo.svg' /><BR /><BR />
				<center><div id='texto'>
				<p><h1>Ops! Você já utilizou essa promoção.</h1></p><BR />
				<p>Mas você ainda pode aproveitar seu saldo restante de cachês para outros produtos Magneto Elenco.<BR />Entre em contato pelo <a href='mailto:vini@magnetoelenco.com.br'><strong><u>e-mail</strong></u></a> ou telefone (61) 3202-7266 que a gente te ajuda!</p><BR />
				<p>Obrigado!</p>
				</div></div></center>
				</body>
				</html>";
			} else {
				if ($utilizado > $saldo_inicial) {
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
					<script>
					(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
					(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
					m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
					})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

					ga('create', 'UA-22229864-1', 'auto');
					ga('send', 'pageview');

					</script>
					</head>
				<body>
				<center><div id='corpo'>
				<img src='images/logo.svg' /><BR /><BR />
				<center><div id='texto'>
				<p><h1>Desculpe!</h1></p><BR />
				<p>Mas você não tem saldo para esta operação.<BR />Entre em contato pelo <a href='mailto:vini@magnetoelenco.com.br'><strong><u>e-mail</strong></u></a> ou telefone (61) 3202-7266 que a gente te ajuda!</p><BR />
				<p>Obrigado!</p>
				</div></div></center>
				</body>
				</html>";
				} elseif ($utilizado <= $saldo_inicial) {
			$nome = $row['nome'];
			$sobrenome = $row['sobrenome'];
			$email = $row['email'];
			$cpf = $row['cpf'];
			$saldo = $row['saldo'];
			$valor_premium = $row['valor_premium'];
			$valor_profissional = $row['valor_profissional'];
				if ($novo_cadastro == 'Premium' || $novo_cadastro == 'premium') {
					$desconto = 1 - ($valor_premium / $original_premium);
					// $formatter = new NumberFormatter('pt_BR', NumberFormatter::PERCENT);
					// $desconto = $formatter->format($desconto);
					$desconto = $desconto * 100;
					$desconto = number_format($desconto,0,"",".");
					$desconto = $desconto."%";
					$valor = $valor_premium;
					$balcao = 299;
				}
				elseif ($novo_cadastro == 'Profissional' || $novo_cadastro == 'profissional') {
					$prefixo = "R$ ";
					$desconto = $original_profissional - $valor_profissional;
					$valor = $valor_profissional;
					$balcao = 999;
					$desconto = number_format($desconto,2,",",".");
				}
			$valor = number_format($valor,2,",",".");
			$restante = $saldo - $valor;
			$restante = number_format($restante,2,",",".");
?>
<!DOCTYPE html>
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
	#botao01 {
		max-width: 160px;
		align: left;
	}
	#botao02 {
		max-width: 160px;
		align: left;
		text-align: center;
		margin-left: 100px;
	}
	input[type="number"] {
		background: rgba(215,215,215,0.30);
		border: 2px solid #ECECEC;
		border-radius: 8px;
		width: 200px;
		height: 35px;
		padding-left: 10px;
		color:#fff;
		font-family: Roboto;
		font-size:16px; 
		text-transform: capitalize;
		position: absolute;
	}
	button {
		background: rgba(215,215,215,0.30);
		border: 2px solid #ECECEC;
		border-radius: 8px;
		width: 220px;
		height: 40px;
		padding-left: 10px;
		color:#fff;
		font-family: Roboto;
		font-size:16px; 
		text-transform: capitalize;
		position: absolute;
	}
	button:hover {
		background: rgba(215,215,215,0.60);
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
	a:link {color:white;text-decoration:none;}
	a:visited {color:white;text-decoration:none;}
	a:hover {color:purple;text-decoration:none;}
	a:active {color:white;text-decoration:none;}
	</style>
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-22229864-1', 'auto');
		ga('send', 'pageview');

	</script>
	<script type="text/javascript">
	function isNumberKey(evt){
		var charCode = (evt.which) ? evt.which : event.keyCode
			if (charCode > 31 && (charCode < 48 || charCode > 57))
			return false;
		return true;
	}
	function limit(element){
	    var max_chars = 11;
	    if(element.value.length > max_chars) {
	        element.value = element.value.substr(0, max_chars);
	    }
	}
	</script>
</head>
<body>
<center><div id='corpo'>
<img src="images/logo.svg" /><BR /><BR />
<center><div id='texto'>
<form action='action_promocao_maio.php' method='post'>
<p><h1>Legal <?php echo $nome;?>!</h1></p><BR />
<?php
if ($novo_cadastro == 'Premium' || $novo_cadastro == 'premium' || $novo_cadastro == 'Profissional' || $novo_cadastro == 'profissional') {
	if ($novo_cadastro == 'Premium' || $novo_cadastro == 'premium') {
		$preencher = "Premium";
	}
	if ($novo_cadastro == 'Profissional' || $novo_cadastro == 'profissional') {
		$preencher = "Profissional";
	}
	echo "<p>Fico feliz que você queira continuar na Magneto Elenco e aproveitar seu <i>desconto exclusivo de $prefixo $desconto<sup>*</sup></i> para renovar seu cadastro como $preencher. :)<BR />Antes, eu só preciso confirmar seu CPF e que você dê uma lida no novo contrato, ok?</p><BR />";
}
if ($novo_cadastro == 'Ator' || $novo_cadastro == 'Gratuito' || $novo_cadastro == 'gratuito') {
	if ($novo_cadastro == 'Ator') {
		$preencher = "Ator/Atriz (Premium)";
	}
	if ($novo_cadastro == 'Gratuito' || $novo_cadastro == 'gratuito') {
		$preencher = "Gratuito";
	}
	echo "<p>Fico feliz que você queira continuar na Magneto Elenco e renovar seu cadastro como $preencher.<BR />Antes, eu só preciso confirmar seu CPF e que você dê uma lida no novo contrato, ok?</p><BR />";
}
?>
Confirma pra mim o seu CPF?<BR />
<input type="number" name="cpf" onkeypress="return isNumberKey(event)" onkeydown="limit(this);" onkeyup="limit(this);" autofocus autocomplete="off" required /><BR /><BR /><BR />
<?php
if ($novo_cadastro == 'Premium' || $novo_cadastro == 'premium' || $novo_cadastro == 'Profissional' || $novo_cadastro == 'profissional') {
echo "Para deixar tudo bem claro, montamos uma tabela para mostrar quanto vai ser abatido do seu saldo de cachês a receber.<BR />Se estiver tudo ok, basta clicar no botão abaixo e pronto: você já estará de contrato novo!<BR /><BR />
<table border='0' cellpadding='2' cellspacing='0'>
<tr>
    <th scope='row' align='left'>Você tem:</th>
    <td align='right'>R$ $saldo</td>
    <td align='left'><div style='font-size: small'>(em cachês a receber)</div></td>
</tr>
<tr>
    <th scope='row' align='left'>Vamos abater:</th>
    <td align='right'>-R$ $valor</td>
    <td align='left'><div style='font-size: small'>(renovando como $novo_cadastro)</div></td>
</tr>
<tr>
    <th scope='row' align='left'>Ainda terá:</th>
    <td align='right'><strong>R$ $restante</strong></td>
    <td align='left'><div style='font-size: small'>(em créditos a receber)</div></td>
</tr>
</table>
<BR />";
}
if ($preencher == 'Ator/Atriz (Premium)') {
	echo "Ao renovar o contrato, seu cadastro volta a estar ativo e você já pode participar de novos trabalhos. E que sejam muitos! :)";
}
if ($preencher == 'Gratuito') {
	echo "Só pra te lembrar, dá uma olhada como vão ficar seus próximos cachês:<BR /><BR />
<table border='0' cellpadding='2' cellspacing='0'>
<tr>
    <th scope='row' align='left'>Você recebe no 1º Trabalho: </th>
    <td align='right'><b>20% do Cachê Líquido</b><sup>*</sup> </td>
    <td align='left'><div style='font-size: small'>(excluíndo trabalhos de figuração ou recepção)</div></td>
</tr>
<tr>
    <th scope='row' align='left'>Já a partir do 2º Trabalho: </th>
    <td align='right'><b>60% do Cachê Líquido</b><sup>*</sup> </td>
    <td align='left'><div style='font-size: small'>(para todos os tipos de trabalho)</div></td>
</tr>
</table>
<BR />";
}
?>
<p><a href="action_imprime_contrato.php?id=<?php echo $id_elenco;?>" target="_blank"><strong><u>Clique aqui para ler o novo contrato</u></strong></a></p><BR />
<div id="botao01"><button><input type="hidden" name="id" value="<?php echo $id_elenco;?>"><input type="hidden" name="aceito" value="sim">Renovar como <?php echo $novo_cadastro; ?></button></div><BR /><BR />
<?php
if ($novo_cadastro == 'Premium' || $novo_cadastro == 'premium' || $novo_cadastro == 'Profissional' || $novo_cadastro == 'profissional') {
echo "<p><div style='font-size: small'><sup>*</sup> Valor integral do Cadastro $novo_cadastro para pagamento na loja: R$ $balcao. Esse desconto promocional é oferecido exclusivamente a você e válido apenas por meio deste site até o dia 31/05/2016.</div></p>";
}
if ($novo_cadastro == 'Gratuito' || $novo_cadastro == 'gratuito') {
echo "<p><div style='font-size: small'><sup>*</sup> O Cachê Líquido é o valor resultante do cachê após pagar taxas e impostos.</div></p>";
}
?>
</div></div></center>
</form>
</body>
</html>
<?php
}
}
}
mysqli_close($link);
?>
<?php header("Content-type: text/html; charset=ISO-8859-15");
include("conecta.php");
date_default_timezone_set('America/Sao_Paulo');
		$hoje = date('Y-m-d', time());
		if ($hoje > '2016-04-30'){
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
	</style>
	</head>
<body>
<center><div id='corpo'>
<img src='images/logo.svg' /><BR /><BR />
<center><div id='texto'>
<p><h1>Essa Promoção acabou...</h1></p><BR />
<p>Mas você ainda pode aproveitar seu Saldo de Cachês para mudar para o Cadastro Premium e aumentar seus próximos cachês. Entre em contato pelo telefone (61) 3202-7266 e peça para trocar.</p><BR />
</div></div></center>
</body>
</html>";
		} else {
		$id_elenco = $_GET['id_elenco'];
		$sql = "SELECT id_elenco_financeiro, financeiro.nome, sobrenome, cache_liquido, cliente_job, campanha, data_job, previsao_pagamento, email, cpf FROM financeiro LEFT OUTER JOIN tb_elenco ON tb_elenco.id_elenco = financeiro.id_elenco_financeiro WHERE id_elenco = '$id_elenco' AND tipo_cache = '1º Cachê Cadastro Gratuito'";
		$result = mysqli_query($link, $sql);
			if (!$result) {
			 die("Database query failed: " . mysqli_error());
			}
		// $row = mysqli_fetch_array($result);
		while ($row = mysqli_fetch_array($result)) {
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
			$cpf = $row['cpf'];
			$previsao = date('d/m/Y', strtotime($data_job." + ".$previsao_pagamento." days"));
			$data_job = date('d/m/Y', strtotime($data_job));
		}
?>
<!DOCTYPE html>
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
<form action='action_promocao_abril.php' method='post'>
<p><h1>Vamos lá <?php echo $nome;?>,</h1></p><BR />
<p>Fico feliz que você escolheu aproveitar seu <i>desconto exclusivo de R$ 100</i> e migrar seu cadastro para Premium.<BR />Antes, eu só preciso confirmar seu CPF e que você dê uma lida no novo contrato, ok?</p><BR />

Confirma pra mim o seu CPF?<BR />
<input type="number" name="cpf" onkeypress="return isNumberKey(event)" onkeydown="limit(this);" onkeyup="limit(this);" autofocus autocomplete="off" required /><BR /><BR /><BR />
O Seu Cachê do trabalho "<i><?php echo $cliente_job."-".$campanha;?></i>" vai ficar assim então:<BR /><BR />
<table border='0' cellpadding='2' cellspacing='0'>
<tr>
    <th scope="row" align='left'>Você tinha:</th>
    <td align='right'>R$ <?php echo $cache_liquido;?></td>
    <td align='left'><div style="font-size: small">(no total a receber)</div></td>
</tr>
<tr>
    <th scope="row" align='left'>Vamos abater:</th>
    <td align='right'>-R$ 199,00</td>
    <td align='left'><div style="font-size: small">(mudança para Premium)</div></td>
</tr>
<tr>
    <th scope="row" align='left'>Ainda vai ter:</th>
    <td align='right'><strong>R$ <?php echo $novo_cache;?>,00</strong></td>
    <td align='left'><div style="font-size: small">(disponível a partir de hoje<sup>*</sup> )</div></td>
</tr>
</table>
<BR />
<p><a href="action_imprime_contrato.php?id=<?php echo $id_elenco;?>" target="_blank"><strong><u>Clique aqui para ler o novo contrato</u></strong></a></p><BR />
<div id="botao01"><button><input type="hidden" name="id" value="<?php echo $id_elenco;?>"><input type="hidden" name="aceito" value="sim">Mudar para Premium</button></div><BR /><BR />
<p><div style="font-size: small"><sup>*</sup> Seu cachê só fica disponível para saque imediato caso você concorde em participar desta Promoção. Caso contrário a previsão de pagamento dele é a partir do dia <?php echo $previsao;?>.</div></p>
</div></div></center>
</form>
</body>
</html>
<?php
}
mysqli_close($link);
?>
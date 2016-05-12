<?php header("Content-type: text/html; charset=ISO-8859-15");
include("conecta.php");
// session_start();
$hoje = date('Y-m-d', time());
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
function extenso($valor = 0, $maiusculas = false) {

	$singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
	$plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões", "quatrilhões");

	$c = array("", "cem", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
	$d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta", "sessenta", "setenta", "oitenta", "noventa");
	$d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", "dezesete", "dezoito", "dezenove");
	$u = array("", "um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove");

	$z = 0;
	$rt = "";

	$valor = number_format($valor, 2, ".", ".");
	$inteiro = explode(".", $valor);
		for($i=0;$i<count($inteiro);$i++)
		for($ii=strlen($inteiro[$i]);$ii<3;$ii++)
	$inteiro[$i] = "0".$inteiro[$i];

	$fim = count($inteiro) - ($inteiro[count($inteiro)-1] > 0 ? 1 : 2);
		for ($i=0;$i<count($inteiro);$i++) {
	$valor = $inteiro[$i];
	$rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
	$rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
	$ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

	$r = $rc.(($rc && ($rd || $ru)) ? " e " : "").$rd.(($rd && $ru) ? " e " : "").$ru;
	$t = count($inteiro)-1-$i;
	$r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : "";
		if ($valor == "000")$z++; elseif ($z > 0) $z--;
		if (($t==1) && ($z>0) && ($inteiro[0] > 0)) $r .= (($z>1) ? " de " : "").$plural[$t];
		if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
		}

	if(!$maiusculas){
		return($rt ? $rt : "zero");
	} else {

	// if ($rt) $rt=ereg_replace(" E "," e ",ucwords($rt)); 
	if ($rt) $rt=ereg_replace(" E "," e ",strtolower($rt));
	return (($rt) ? ($rt) : "Zero");
	}

}

	if (!empty($_GET['id'])) {
	    $id = $_GET['id'];
	    $sql = "SELECT * FROM (SELECT id id_cache, data_job, id_elenco_financeiro id, campanha, cliente_job, produzido_por, status_recebimento, data_recebimento, previsao_pagamento, status_pagamento, data_pagamento, liberado, cache_liquido, n_cheque, valor_cheque, abatimento_cache, data_abatimento, produto_abatimento FROM financeiro WHERE id = '$id') T1 INNER JOIN (SELECT id_elenco id, nome, cpf, tipo_cadastro_vigente, data_contrato_vigente FROM tb_elenco comum) T2 USING (id)";
    	$result = mysqli_query($link, $sql);
		$row = mysqli_fetch_array($result);
		    $data_job = $row['data_job'];
			$nome = $row['nome'];
			$nome = strtoupper($nome);
			$cpf = $row['cpf'];
			$cpf = mask($cpf, '###.###.###-##');
			$campanha = $row['campanha'];
			$cliente_job = $row['cliente_job'];
			$produzido_por = $row['produzido_por'];	
			$status_pagamento = $row['status_pagamento'];
			$cache_liquido = $row['cache_liquido'];
			$n_cheque = $row['n_cheque'];
			$valor_cheque = $row['valor_cheque'];
			$abatimento_cache = $row['abatimento_cache'];
			$data_abatimento = $row['data_abatimento'];
			$data_pagamento = $row['data_pagamento'];
			$produto_abatimento = $row['produto_abatimento'];
			$saldo = $cache_liquido - $abatimento_cache - $valor_cheque;
			if ($saldo != 0) {
				$sacado = $abatimento_cache + $valor_cheque;
			} elseif ($saldo == 0) {
				$sacado = $cache_liquido;
			}
			$valor_cheque = number_format($valor_cheque, 2, ",", ".");
			$abatimento_cache = number_format($abatimento_cache, 2, ",", ".");

			$sacado_extenso = extenso($sacado);
			$sacado_extenso = ereg_replace(" E "," e ",strtolower($sacado_extenso));
			$sacado = number_format($sacado, 2, ",", ".");

			$cache_liquido_extenso = extenso($cache_liquido);
			$cache_liquido_extenso = ereg_replace(" E "," e ",strtolower($cache_liquido_extenso));
			$cache_liquido = number_format($cache_liquido, 2, ",", ".");

			$saldo_extenso = extenso($saldo);
			$saldo_extenso = ereg_replace(" E "," e ",strtolower($saldo_extenso));
			$saldo = number_format($saldo, 2, ",", ".");

		if ($sacado == 0) {
			echo "Não existe pagamento registrado para este cachê.";
		} elseif ($sacado > 0){

			$dia_abatimento = date('d', strtotime($data_abatimento));
			$mes_abatimento = date('m', strtotime($data_abatimento));
			$ano_abatimento = date('Y', strtotime($data_abatimento));
			$dia_cheque = date('d', strtotime($data_pagamento));
			$mes_cheque = date('m', strtotime($data_pagamento));
			$ano_cheque = date('Y', strtotime($data_pagamento));
			$dia_job = date('d', strtotime($data_job));
			$mes_job = date('m', strtotime($data_job));
			$ano_job = date('Y', strtotime($data_job));
			$dia_hoje = date('d', strtotime($hoje));
			$mes_hoje = date('m', strtotime($hoje));
			$ano_hoje = date('Y', strtotime($hoje));
			$semana_hoje = date('w');
			switch ($mes_abatimento){
			case 1: $mes_abatimento = "janeiro"; break;
			case 2: $mes_abatimento = "fevereiro"; break;
			case 3: $mes_abatimento = "março"; break;
			case 4: $mes_abatimento = "abril"; break;
			case 5: $mes_abatimento = "maio"; break;
			case 6: $mes_abatimento = "junho"; break;
			case 7: $mes_abatimento = "julho"; break;
			case 8: $mes_abatimento = "agosto"; break;
			case 9: $mes_abatimento = "setembro"; break;
			case 10: $mes_abatimento = "outubro"; break;
			case 11: $mes_abatimento = "novembro"; break;
			case 12: $mes_abatimento = "dezembro"; break;
			}
			switch ($mes_cheque){
			case 1: $mes_cheque = "janeiro"; break;
			case 2: $mes_cheque = "fevereiro"; break;
			case 3: $mes_cheque = "março"; break;
			case 4: $mes_cheque = "abril"; break;
			case 5: $mes_cheque = "maio"; break;
			case 6: $mes_cheque = "junho"; break;
			case 7: $mes_cheque = "julho"; break;
			case 8: $mes_cheque = "agosto"; break;
			case 9: $mes_cheque = "setembro"; break;
			case 10: $mes_cheque = "outubro"; break;
			case 11: $mes_cheque = "novembro"; break;
			case 12: $mes_cheque = "dezembro"; break;
			}
			switch ($mes_job){
			case 1: $mes_job = "janeiro"; break;
			case 2: $mes_job = "fevereiro"; break;
			case 3: $mes_job = "março"; break;
			case 4: $mes_job = "abril"; break;
			case 5: $mes_job = "maio"; break;
			case 6: $mes_job = "junho"; break;
			case 7: $mes_job = "julho"; break;
			case 8: $mes_job = "agosto"; break;
			case 9: $mes_job = "setembro"; break;
			case 10: $mes_job = "outubro"; break;
			case 11: $mes_job = "novembro"; break;
			case 12: $mes_job = "dezembro"; break;
			}
			switch ($mes_hoje){
			case 1: $mes_hoje = "janeiro"; break;
			case 2: $mes_hoje = "fevereiro"; break;
			case 3: $mes_hoje = "março"; break;
			case 4: $mes_hoje = "abril"; break;
			case 5: $mes_hoje = "maio"; break;
			case 6: $mes_hoje = "junho"; break;
			case 7: $mes_hoje = "julho"; break;
			case 8: $mes_hoje = "agosto"; break;
			case 9: $mes_hoje = "setembro"; break;
			case 10: $mes_hoje = "outubro"; break;
			case 11: $mes_hoje = "novembro"; break;
			case 12: $mes_hoje = "dezembro"; break;
			}
			switch ($semana_hoje) {
			case 0: $semana_hoje = "domingo"; break;
			case 1: $semana_hoje = "segunda-feira"; break;
			case 2: $semana_hoje = "terça-feira"; break;
			case 3: $semana_hoje = "quarta-feira"; break;
			case 4: $semana_hoje = "quinta-feira"; break;
			case 5: $semana_hoje = "sexta-feira"; break;
			case 6: $semana_hoje = "sábado"; break;
			}
	
		echo "
			<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
			<html xmlns='http://www.w3.org/1999/xhtml' lang='pt-BR'>
			<head>
			<meta http-equiv='Content-type' content='text/html; charset=ISO-8859-15' />
			<title>Recibo de Quitação</title>
			<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Roboto:300,300italic,900,900italic,400,400italic' />
				<style type='text/css'>
				h1 { 
					font-family: 'Roboto', sans-serif;
					font-weight: 400;
				}
				p { 
					font-family: 'Roboto', sans-serif;
					font-weight: 300;
					text-indent: 30px;
				}
				.todo {
				    max-width: 1000px;
				    margin: auto;
				    position: relative;
				    background-color: e5e5e5;
				}
				.conteudo {
				    margin: auto;
				    max-width: 800px;
				    height: 300px;
				    background-color: white;
				}
				#observacao {
					font-size: small;
					font-family: 'Roboto', sans-serif;
					font-weight: 300;
					text-indent: 30px;
				}
				</style>
				<script type='text/javascript'>
				 window.onload = function() { window.print(); }
				</script>
			</head>
			<body>
			<div class='todo'>
			    <center>
				<img src='images/logo.png' width='150' height='150' />
				<h1>Recibo de Quitação</h1>
				<BR /><BR /></center>
				<div class='conteudo' align='justify'>
				<p>   Eu, <strong>$nome</strong>, portador(a) de CPF: $cpf, declaro ter recebido da empresa MAGNETO ELENCO com sede no
				CENTRO DE ATIVIDADES 02, BLOCO A, LOJA 01 - LAGO NORTE, BRASÍLIA - DF, a importância de
				<strong>R$: $sacado ($sacado_extenso )</strong>, de um total de R$: $cache_liquido ($cache_liquido_extenso ), referente aos serviços por mim prestados ao cliente
				<strong>$cliente_job</strong> no dia <strong>$dia_job de $mes_job de $ano_job</strong>, para a campanha
				<strong>$campanha</strong> produzida pela produtora <strong>$produzido_por</strong>,
				nos termos do contrato entre nós firmados e pagos na forma de:</p>";
				if ($abatimento_cache != NULL && $abatimento_cache > 0) {
					echo "<p>- Utilização de <strong>R$: $abatimento_cache</strong> para: <strong>$produto_abatimento</strong> em $dia_abatimento de $mes_abatimento de $ano_abatimento;</p>";
				} if ($n_cheque != NULL && $n_cheque > 0) {
					echo "<p>- Cheque de <strong>Nº $n_cheque</strong> no valor de <strong>R$: $valor_cheque</strong> entregue em $dia_cheque de $mes_cheque de $ano_cheque.<BR /></p>";
				}
				if ($saldo != 0) {
					echo "<p><div id='observacao'><strong>Obsservação: Estou ciente da existência de um saldo de R$: $saldo ($saldo_extenso ) em meu favor.</strong></p></div>";
				} echo "			
				<BR /><p>Para maior clareza, firmo o presente, dando plena, irrestrita e irrevogável quitação dos valores supracitados.</p>
				<BR /><BR /><center>
				<p>Brasília, $semana_hoje, $dia_hoje de $mes_hoje de $ano_hoje.</p>
				<BR /><BR />
				<p>______________________________________________</p>
				<p>$nome</p>
				</center>
			</div></div>
			</body>
			</html>";
		}
}
	mysqli_close($link);
?>
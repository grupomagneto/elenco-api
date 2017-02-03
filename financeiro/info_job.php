<?php header('Content-Type: text/html; charset=utf-8');
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
	$valor_total_job = number_format($valor_total_job,2,",",".");
	$data_job = date("d-m-Y", strtotime($data_job));
	$data_nota = date("d-m-Y", strtotime($data_nota));
	$data_recebimento = date("d-m-Y", strtotime($data_recebimento));
echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' lang='pt-BR'>
<head>
<meta http-equiv='Content-type' content='text/html; charset=UTF-8' />
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Roboto:300,400' />
<style type='text/css'>
h1 { font-family: 'Roboto', sans-serif; font-weight: 400; }
body { font-family: 'Roboto', sans-serif; font-weight: 300; }
table {
    border-collapse: collapse;
}
th, td {
    border-bottom: 1px solid #ddd;
}
</style>
</head>
<body>
<center><h1>Job</h1><center>
<p><table border='0' cellpadding='2' cellspacing='0' align='center'>
  <tr>
    <th scope='row' align='right'>Cliente:</th>
    <td align='left'>$cliente_job</td>
  </tr>
  <tr>
    <th scope='row' align='right'>Produtora:</th>
    <td align='left'>$produzido_por</td>
  </tr>
  <tr>
    <th scope='row' align='right'>Campanha/Evento:</th>
    <td align='left'>$campanha</td>
  </tr>
  <tr>
    <th scope='row' align='right'>Data do Job:</th>
    <td align='left'>$data_job</td>
  </tr>
  <tr>
    <th scope='row' align='right'>Mídia:</th>
    <td align='left'>$midia</td>
  </tr>
  <tr>
    <th scope='row' align='right'>Praça:</th>
    <td align='left'>$praca</td>
  </tr>
  <tr>
    <th scope='row' align='right'>Período:</th>
    <td align='left'>$periodo $periodo_tipo</td>
  </tr>
  <tr>
    <th scope='row' align='right'>Valor do Job:</th>
    <td align='left'>R$: $valor_total_job</td>
  </tr>
  <tr>
    <th scope='row' align='right'>Participantes:</th>
    <td align='left'>$n_participantes</td>
  </tr>
  <tr>
    <th scope='row' align='right'>Previsão de Pgto.:</th>
    <td align='left'>$previsao_pagamento dias</td>
  </tr>
  <tr>
    <th scope='row' align='right'>Emitiu Nota?</th>";
	if ($emitiu_nota == 0){
		echo "<td align='left'>Não</td>
			</tr>";
	} elseif ($emitiu_nota == 1){
		echo "<td align='left'>Sim</td>
			</tr>
		    <tr>
		      <th scope='row' align='right'>Nº da Nota:</th>
		      <td align='left'>$n_nota_fiscal</td>
		    </tr>
		    <tr>
		      <th scope='row' align='right'>Data da Nota:</th>
		      <td align='left'>$data_nota</td>
		    </tr>";
	} echo "
  <tr>
    <th scope='row' align='right'>Recebido?</th>";
	if ($status_recebimento == 0){
		echo "<td align='left'>Não</td>
			</tr>";
	} elseif ($status_recebimento == 1){
		echo "<td align='left'>Sim</td>
			</tr>
		    <tr>
		      <th scope='row' align='right'>Recebimento:</th>
		      <td align='left'>$data_recebimento</td>
		    </tr>";
	} echo "	
</table></p>
</body>
</html>";
?>

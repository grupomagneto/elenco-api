<?php header("Content-type: text/html; charset=ISO-8859-15");
session_start();
	$_SESSION['data_job'] = $_POST['data_job'];
	$_SESSION['produzido_por'] = $_POST['produzido_por'];
	$_SESSION['cliente_job'] = $_POST['cliente_job'];
	$_SESSION['campanha'] = $_POST['campanha'];
	$_SESSION['midia'] = $_POST['midia'];
	$_SESSION['praca'] = $_POST['praca'];
	$_SESSION['periodo'] = $_POST['periodo'];
	$_SESSION['periodo_tipo'] = $_POST['periodo_tipo'];
	$_SESSION['valor_total_job'] = $_POST['valor_total_job'];
	$_SESSION['n_participantes'] = $_POST['n_participantes'];
	$_SESSION['previsao_pagamento'] = $_POST['previsao_pagamento'];
	$_SESSION['emitiu_nota'] = $_POST['emitiu_nota'];
	$_SESSION['n_nota_fiscal'] = $_POST['n_nota_fiscal'];
	$_SESSION['data_nota'] = $_POST['data_nota'];
	$_SESSION['status_recebimento'] = $_POST['status_recebimento'];
	$_SESSION['data_recebimento'] = $_POST['data_recebimento'];
echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' lang='pt-BR'>
<head>
<meta http-equiv='Content-type' content='text/html; charset=ISO-8859-15' />
<style type='text/css'>
#corpo {
    max-width:90%;
}
</style>
</head>
  <frameset id='corpo' cols='30%,*' frameborder='no' border='0' framespacing='10'>
    <frame src='info_job.php' name='info_job' scrolling='no' id='info_job' title='info_job' />
    <frame src='insert_nomes.php' name='insert_nomes' scrolling='yes' id='insert_nomes' title='insert_nomes' />
</frameset>
<body>
</body>
</html>";
?>

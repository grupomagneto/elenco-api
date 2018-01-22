<?php
	// Inclui os arquivos de sistema
	include("../api/Basic.php");

	// Recebe os dados do formulario
	$nome_remetente     = $_POST['nome_remetente'];
	$email_remetente    = $_POST['email_remetente'];
	$nome_destinatario  = $_POST['nome_destinatario'];
	$email_destinatario = $_POST['email_destinatario'];
	$assunto            = $_POST['assunto'];
	$mensagem           = nl2br($_POST['mensagem']);
	$telefone           = $_POST['telefone'];
	$empresa            = $_POST['empresa'];
	$midia              = $_POST['midia'];
	$periodo            = $_POST['periodo'];
	$praca              = $_POST['praca'];
	$exclusividade      = $_POST['exclusividade'];
	$arquivo_email      = $_POST['arquivo_email'];
	$pagina_resposta    = $_POST['pagina_resposta'];

	// Faz o tratamento de variaveis vazias
	if($nome_remetente == "") $nome_remetente = "Magneto Elenco";
	if($email_remetente == "") $email_remetente = "elenco@grupomagneto.com.br";
	if($nome_destinatario == "") $nome_destinatario = "Magneto Elenco";
	if($email_destinatario == "") $email_destinatario = "elenco@grupomagneto.com.br";

	// Define o corpo da mensagem
	$corpo_email = file_get_contents("/home/grupomagneto/public_html/magnetoelenco/v2/email/$arquivo_email");

	$corpo_email = str_replace("#nome_remetente#", $nome_remetente, $corpo_email);
	$corpo_email = str_replace("#email_remetente#", $email_remetente, $corpo_email);
	$corpo_email = str_replace("#nome_destinatario#", $nome_destinatario, $corpo_email);
	$corpo_email = str_replace("#email_destinatario#", $email_destinatario, $corpo_email);
	$corpo_email = str_replace("#mensagem#", $mensagem, $corpo_email);
	$corpo_email = str_replace("#telefone#", $telefone, $corpo_email);
	$corpo_email = str_replace("#empresa#", $empresa, $corpo_email);
	$corpo_email = str_replace("#midia#", $midia, $corpo_email);
	$corpo_email = str_replace("#periodo#", $periodo, $corpo_email);
	$corpo_email = str_replace("#praca#", $praca, $corpo_email);
	$corpo_email = str_replace("#exclusividade#", $exclusividade, $corpo_email);

	// Faz a chamada da funcao para envio de email
	sendEmail($nome_remetente, $email_remetente, $email_destinatario, $assunto, $corpo_email);

	// Direciona o usuario para a pagina de resposta
	header("Location: /v2/$pagina_resposta");
?>

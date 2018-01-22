<?php
	// Inclui os arquivos de sistema
	include("../api/DataManipulation.php");
	include("../api/Basic.php");
	
	// Chamada da funcao de conexao com o banco de dados
	$idconn = conectaBD();	

	// Recebe os dados do formulario
	$assunto  = $_POST['assunto'];
	$titulo   = $_POST['titulo'];
	$mensagem = nl2br($_POST['mensagem']);
	
	// Faz o tratamento das informacoes do remetente
	if($nome_remetente == "") $nome_remetente = "Magneto Elenco";
	if($email_remetente == "") $email_remetente = "elenco@grupomagneto.com.br";
	
	// Busca os destinatarios do email
	$sql = "select nome_artistico, email 
			from tb_elenco 
			where email is not null 
			and email <> '' 
			and cd_status_elenco = 2 
			order by nome_artistico";
			
	$rs = mysql_query($sql);
	$contador_enviados = 0;
	while($row = mysql_fetch_array($rs)){
		
		// Define as variaveis
		$nome_artistico = $row['nome_artistico'];
		$email_destinatario = $row['email'];
		
		// Define o corpo da mensagem
		$corpo_email = file_get_contents($_SERVER['DOCUMENT_ROOT']."/emailmkt/emkt.html");
	
		$corpo_email = str_replace("#titulo#", $titulo, $corpo_email);
		$corpo_email = str_replace("#nome_destinatario#", $nome_artistico, $corpo_email);
		$corpo_email = str_replace("#mensagem#", $mensagem, $corpo_email);
			
		// Faz a chamada da funcao para envio de email
		if(sendEmail($nome_remetente, $email_remetente, $email_destinatario, $assunto, $corpo_email)) $contador_enviados++;
	
	}
	
	// Chamada da funcao para desconexao com o banco de dados
	desconectaBD($idconn);	
		
	// Direciona o usuario para a pagina de resposta
	header("Location: /admin/mensagem/index.php?flag=$contador_enviados");
?>

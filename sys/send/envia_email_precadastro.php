<?php
	// Inclui os arquivos de sistema
	include("../api/DataManipulation.php");
	include("../api/Basic.php");
	include("../Model/Agenda.php");
	
	// Chamada da funcao de conexao com o banco de dados
	$idconn = conectaBD();	

	// Recebe o id criptografado do agendamento
	$id_agenda_hashed = $_GET['id'];
	
	// Faz o tratamento das informacoes do remetente
	if($nome_remetente == "") $nome_remetente = "Magneto Elenco";
	if($email_remetente == "") $email_remetente = "elenco@grupomagneto.com.br";
	
	// Instancia o agendamento
	$agendamento = Agenda::inicializaAgendaPorIdCriptografado($id_agenda_hashed);
	
	// Chamada da funcao para desconexao com o banco de dados
	desconectaBD($idconn);		
	
	// Formata a data do agendamento de forma amigavel
	$agendamento_stamp = strtotime($agendamento->dh_agendamento);
	$agendamento_hora = date("H:i", $agendamento_stamp);
	$agendamento_dia = date("d", $agendamento_stamp);
	$agendamento_mes = getNomeMes(date("m", $agendamento_stamp));
	$agendamento_ano = date("Y", $agendamento_stamp);
	$agendamento_diasemana = getDiaSemana(date("w", $agendamento_stamp));	
	
	if($agendamento->email != ""){
		
		// Define as variaveis
		$nome_artistico = $agendamento->nome;
		$email_destinatario = $agendamento->email;
		$titulo = "Pré-cadastro - Instruções para sessão de fotos";
		
		// Define a mensagem
		$mensagem = "<p>Seu pr&eacute;-cadastro foi conclu&iacute;do e sua sess&atilde;o de fotos e v&iacute;deo agendada para:<br>";
		$mensagem .= "$agendamento_dia de $agendamento_mes de $agendamento_ano, $agendamento_diasemana, &agrave;s $agendamento_hora.</p>";
		$mensagem .= "<p>no seguinte endere&ccedil;o:<br>SHIN CA 02 Bloco A Loja 01 &ndash; Lago Norte - Bras&iacute;lia - DF</p>";
		$mensagem .= "<p>Favor comparecer 15 minutos mais cedo para esclarecimento de d&uacute;vidas, assinatura do Contrato de Ades&atilde;o e r&aacute;pido treinamento antes da sess&atilde;o.</p>";
		$mensagem .= "<p><strong>Homens:</strong> trazer barbeador, traje social completo, cal&ccedil;a jeans e camisa p&oacute;lo.<br>Opcional: cal&ccedil;&atilde;o de banho.<br>";
		$mensagem .= "<strong>Mulheres: </strong>maquiagem leve, traje social, cal&ccedil;a jeans e blusinha, vestido/saia.<br>Opcional: biquini (n&atilde;o serve mai&ocirc;).</p>";
		$mensagem .= "<p>Remarca&ccedil;&otilde;es e informa&ccedil;&otilde;es pelo telefone: (61) 3202-7266</p>";
		
		// Define o corpo da mensagem
		$corpo_email = file_get_contents($_SERVER['DOCUMENT_ROOT']."/emailmkt/emkt.html");
	
		$corpo_email = str_replace("#titulo#", $titulo, $corpo_email);
		$corpo_email = str_replace("#nome_destinatario#", $nome_artistico, $corpo_email);
		$corpo_email = str_replace("#mensagem#", $mensagem, $corpo_email);
			
		// Faz a chamada da funcao para envio de email
		sendEmail($nome_remetente, $email_remetente, $email_destinatario, $titulo, $corpo_email);
	
	}
		
	// Direciona o usuario para a pagina de resposta
	header("Location: /v2/pre_cadastro_confirmacao.php?flag=2&id_agenda=".$agendamento->getIdAgenda()."&enviado=1");
?>

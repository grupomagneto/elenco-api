<?php
	// Inclui os arquivos de sistema
	include($_SERVER['DOCUMENT_ROOT']."/admin/includes/valida_acesso_adm.php");	
	include($_SERVER['DOCUMENT_ROOT']."/sys/api/Basic.php");
	include($_SERVER['DOCUMENT_ROOT']."/sys/api/DataManipulation.php");
	include($_SERVER['DOCUMENT_ROOT']."/sys/Model/Agenda.php");

	// Recebe a data selecionada
	$data = $_GET["data"];
	$data_selecionada = formataDataBanco($_GET["data"]);
	
	// Define a mensagem padrao
	$mensagem = "Prezado(a) #nome#,<br><br>";
	$mensagem .= "Informamos que as sessões de fotos agendadas para o dia $data foram canceladas.<br>";
	$mensagem .= "Pedimos desculpas por quaisquer inconvenientes causados e em breve entraremos em contato para agendar um novo horário.<br><br>";
	$mensagem .= "Atenciosamente,<br>Equipe Magneto Elenco<br>www.magnetoelenco.com.br";
	
	// Chamada da funcao de conexao com o banco de dados
	$idconn = conectaBD();
	
	// Seleciona os elencos agendados para o dia
	$agendamentos = Agenda::consultaAgendamentosPorDia($data_selecionada);
	foreach($agendamentos as $agendamento){
		if($agendamento->removeAgendamento()){
			$mensagem_usuario = str_replace("#nome#", $agendamento->nome, $mensagem);
			sendEmail("Magneto Elenco", "elenco@grupomagneto.com.br", $agendamento->email, "Cancelamento de sessão de fotos", $mensagem_usuario);
		}
	}
	
	// Chama o metodo de cancelamento de dia
	Agenda::cancelaDia($data_selecionada, $_SESSION['id_admin']);
	
	// Chamada da funcao para desconexao com o banco de dados
	desconectaBD($idconn);
	
	// Direciona o admin para a pagina da agenda
	header("Location: /admin/elenco/agenda.php?data=$data");
?>
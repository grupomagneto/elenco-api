<?php
	// Inclui os arquivos de sistema
	include($_SERVER['DOCUMENT_ROOT']."/admin/includes/valida_acesso_adm.php");	
	include($_SERVER['DOCUMENT_ROOT']."/sys/api/Basic.php");
	include($_SERVER['DOCUMENT_ROOT']."/sys/api/DataManipulation.php");
	include($_SERVER['DOCUMENT_ROOT']."/sys/Model/Agenda.php");

	// Recebe a data selecionada
	$data = $_GET["data"];
	$data_selecionada = formataDataBanco($_GET["data"]);
	
	// Chamada da funcao de conexao com o banco de dados
	$idconn = conectaBD();
	
	// Chama o metodo de reativacao de dia
	Agenda::reativaDia($data_selecionada);
	
	// Chamada da funcao para desconexao com o banco de dados
	desconectaBD($idconn);
	
	// Direciona o admin para a pagina da agenda
	header("Location: /admin/elenco/agenda.php?data=$data");
?>
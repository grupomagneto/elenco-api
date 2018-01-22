<?php
	// Inclui os arquivos de sistema
	include("../../admin/includes/valida_acesso_adm.php");
	include("../api/Basic.php");
	include("../api/DataManipulation.php");

	// Recebe os dados
	$id_agenda = $_GET['id_agenda'];
	$data      = $_GET['data'];
	
	// Chamada da funcao de conexao com o banco de dados
	$idconn = conectaBD();
	
	// Chama a funcao para deletar o registro de agenda no banco de dados
	deletaDados("tb_agenda", "id_agenda = $id_agenda");
	
	// Chamada da funcao para desconexao com o banco de dados
	desconectaBD($idconn);
	
	// Direciona o usuario para a agenda
	header("Location: /magnetoelenco/admin/elenco/agenda.php?data=$data");
?>
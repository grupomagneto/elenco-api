<?php
	// Inclui os arquivos de sistema
	include("../../admin/includes/valida_acesso_adm.php");
	include("../api/Basic.php");
	include("../api/DataManipulation.php");

	// Recebe o id do elenco
	$id_elenco = $_GET['id_elenco'];
	
	// Chamada da funcao de conexao com o banco de dados
	$idconn = conectaBD();
	
	// Chama a funcao para deletar o registro de elenco no banco de dados
	deletaDados("tb_elenco", "id_elenco = $id_elenco");
	
	// Chamada da funcao para desconexao com o banco de dados
	desconectaBD($idconn);
	
	// Direciona o usuario para a lista de registros de elenco
	header("Location: /magnetoelenco/admin/elenco/index.php?msg=1");
?>
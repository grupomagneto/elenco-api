<?php
	// Inclui os arquivos de sistema
	include("../api/Basic.php");
	include("../api/DataManipulation.php");

	// Recebe o id do casting
	$id_casting = $_GET['id_casting'];	
	
	// Chamada da funcao de conexao com o banco de dados
	$idconn = conectaBD();
	
	// Chama a funcao para remover o casting
	deletaDados("tb_casting", "id_casting = $id_casting");
	
	// Chamada da funcao para desconexao com o banco de dados
	desconectaBD($idconn);	
	
	// Direciona o usuario para o casting
	header("Location: /magnetoelenco/v2/meu_casting.php");	
?>
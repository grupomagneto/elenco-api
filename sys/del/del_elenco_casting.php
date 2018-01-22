<?php
	// Inclui os arquivos de sistema
	include("../api/Basic.php");
	include("../api/DataManipulation.php");

	// Recebe os ids do elenco e do casting
	$id_elenco  = $_GET['id_elenco'];
	$id_casting = $_GET['id_casting'];	
	
	// Chamada da funcao de conexao com o banco de dados
	$idconn = conectaBD();
	
	// Chama a funcao para remover o elenco do casting em questao
	deletaDados("ta_casting_elenco", "cd_elenco = $id_elenco and cd_casting = $id_casting");
	
	// Chamada da funcao para desconexao com o banco de dados
	desconectaBD($idconn);	
	
	// Direciona o usuario para o casting
	header("Location: /magnetoelenco/v2/meu_casting.php?id_casting=$id_casting");	
?>
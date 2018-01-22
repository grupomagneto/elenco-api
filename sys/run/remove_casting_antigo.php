<?php
	// Inclui os arquivos de sistema
	include("../api/Basic.php");
	include("../api/DataManipulation.php");

	// Define a data limite para remocao dos castings
	$data_validade = dateAdd(date("Y-m-d"), -3) . " " . date("H:i:s");
	
	// Chamada da funcao de conexao com o banco de dados
	$idconn = conectaBD();
	
	// Chama a funcao para remover o casting
	$afetados = deletaDados("tb_casting", "dh_cadastro <= '$data_validade'");
	echo "$afetados castings deletados.";
	
	// Chamada da funcao para desconexao com o banco de dados
	desconectaBD($idconn);	
?>
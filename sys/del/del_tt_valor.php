<?php
	// Inclui os arquivos de sistema
	include("../../admin/includes/valida_acesso_adm.php");
	include("../api/DataManipulation.php");

	// Define as variaveis com o valor da tabela tradicional
	$id_tt              = $_GET['id_tt'];
	$tabela_tradicional = $_GET['tabela_tradicional'];
	
	// Define o nome da colunas de chave primaria da tabela tradicional
	$coluna_id    = "id_".str_replace("tt_", "", $tabela_tradicional);
	
	// Chamada da funcao de conexao com o banco de dados
	$idconn = conectaBD();
	
	// Chama a funcao para deletar o registro na tabela tradicional
	deletaDados($tabela_tradicional, "$coluna_id = $id_tt");
	
	// Chamada da funcao para desconexao com o banco de dados
	desconectaBD($idconn);
	
	// Direciona o usuario para o gerenciamento da tabela tradicional
	header("Location: /magnetoelenco/admin/tabelas_tradicionais/tabela.php?tabela_tradicional=$tabela_tradicional&operacao=3");
?>
<?php
	// Inclui os arquivos de sistema
	include("../../admin/includes/valida_acesso_adm.php");
	include("../api/Basic.php");
	include("../api/DataManipulation.php");

	// Recebe o nome do arquivo e o id do elenco
	$id_destaque = $_GET['id_destaque'];
	$arquivo     = $_GET['arquivo'];
	
	// Chamada da funcao de conexao com o banco de dados
	$idconn = conectaBD();
	
	// Chama a funcao para deletar o registro de destaque no banco de dados
	deletaDados("tb_destaque", "id_destaque = $id_destaque");
	
	// Chamada da funcao para desconexao com o banco de dados
	desconectaBD($idconn);	
	
	// Deleta o arquivo do diretorio de destaques
	$diretorio = "/home/vinigoulart1/public_html/magnetoelenco/destaques/";
	$caminho_arquivo = $diretorio . $arquivo;
	unlink($caminho_arquivo);
	
	// Direciona o usuario para o formulario de upload de fotos
	header("Location: /magnetoelenco/admin/elenco/destaques_home.php");	
?>
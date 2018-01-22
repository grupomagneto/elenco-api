<?php
	// Inclui os arquivos de sistema
	include("../../admin/includes/valida_acesso_adm.php");
	include("../api/Basic.php");
	include("../api/DataManipulation.php");

	// Recebe o nome do arquivo e o id do elenco
	$id_elenco     = $_GET['id_elenco'];
	$id_tipo_video = $_GET['id_tipo_video'];
	$id_video      = $_GET['id_video'];
	$arquivo       = $_GET['arquivo'];
	
	// Define o formulario de origem
	switch($id_tipo_video){
		case 1:
			$pagina_retorno = "video.php";
			break;
		case 2:
			$pagina_retorno = "videofolio.php";
			break;		
	}		
	
	// Chamada da funcao de conexao com o banco de dados
	$idconn = conectaBD();
	
	// Chama a funcao para deletar o registro de foto no banco de dados
	deletaDados("tb_video", "id_video = $id_video");
	
	// Chamada da funcao para desconexao com o banco de dados
	desconectaBD($idconn);	
	
	// Deleta o arquivo do diretorio de videos
	$diretorio = "/home/vinigoulart/public_html/magnetoelenco/videos/";
	$caminho_arquivo = $diretorio . $arquivo;
	unlink($caminho_arquivo);
	
	// Direciona o usuario para o formulario de upload de videos
	header("Location: /magnetoelenco/admin/elenco/$pagina_retorno?id_elenco=$id_elenco&msg=3");	
?>
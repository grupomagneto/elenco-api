<?php
	// Permite abertura de links externos
	ini_set("allow_url_fopen", 1);
	
	// Inclui os arquivos de sistema
	include("../../admin/includes/valida_acesso_adm.php");
	include("../api/Basic.php");
	include("../api/DataManipulation.php");

	// Recebe os dados do formulario
	$arquivo     = $_FILES['arquivo']['name'];
	$arquivo_tmp = $_FILES['arquivo']['tmp_name'];
	$link       = $_POST['link'];
	$descricao  = $_POST['descricao'];
	
	// Define o diretorio para uplad do arquivo
	$diretorio = "/home/vinigoulart1/public_html/magnetoelenco/destaques/";
	
	// Define o nome do arquivo no padrao do sistema
	$extensao_arquivo = getExtensaoArquivo($arquivo);
	$data_formatada = date("YmdHis");
	$nome_formatado = "destaque_".$data_formatada.".".$extensao_arquivo;	
	
	// Chama a funcao para formatacao e upload do arquivo
	if($arquivo != "") uploadArquivo($arquivo_tmp, $nome_formatado, $diretorio);
	
	// Chamada da funcao de conexao com o banco de dados
	$idconn = conectaBD();	
	
	// Monta os arrays e chama a funcao para insercao no banco de dados
	$colunas = array("arquivo", "link", "descricao");
	$valores = array(toString($nome_formatado), toString($link), toString($descricao));
	$id_destaque = insereDados("tb_destaque", $colunas, $valores);
	
	// Chamada da funcao para desconexao com o banco de dados
	desconectaBD($idconn);		
	
	// Direciona o usuario para o formulario de upload de fotos
	header("Location: /admin/elenco/destaques_home.php");
?>
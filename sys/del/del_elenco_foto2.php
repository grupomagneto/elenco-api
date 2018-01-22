<?php
	// Inclui os arquivos de sistema
	include("../../admin/includes/valida_acesso_adm.php");
	include("../api/Basic.php");
	include("../api/DataManipulation.php");

	// Recebe o nome do arquivo e o id do elenco
	$id_elenco    = $_GET['id_elenco'];
	$id_foto      = $_GET['id_foto'];
	$arquivo      = $_GET['arquivo'];
	$id_tipo_foto = $_GET['id_tipo_foto'];

	// Define o formulario de origem
	switch($id_tipo_foto){
		case 1:
			$pagina_retorno = "fotos_fotobook2.php";
			break;
		case 2:
			$pagina_retorno = "fotos_portfolio2.php";
			break;
	}

	// Chamada da funcao de conexao com o banco de dados
	$idconn = conectaBD();

	// Chama a funcao para deletar o registro de foto no banco de dados
	deletaDados("tb_foto", "id_foto = $id_foto");

	// Chamada da funcao para desconexao com o banco de dados
	desconectaBD($idconn);

	// Deleta o arquivo do diretorio de fotos
	$diretorio = "/home/storage/d/a5/64/grupomagneto/public_html/magnetoelenco/fotos/";
	$caminho_arquivo = $diretorio . $arquivo;
	unlink($caminho_arquivo);

	// Direciona o usuario para o formulario de upload de fotos
	header("Location: /magnetoelenco/admin/elenco/$pagina_retorno?id_elenco=$id_elenco&msg=3");
?>

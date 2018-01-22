<?php
	// Inclui os arquivos de sistema
	include("../../admin/includes/valida_acesso_adm.php");
	include("../api/Basic.php");
	include("../api/DataManipulation.php");

	// Recebe os dados do formulario
	$cd_elenco     = $_POST['cd_elenco'];
	$cd_tipo_video = $_POST['cd_tipo_video'];
	$arquivo       = $_FILES['arquivo']['name'];
	$arquivo_tmp   = $_FILES['arquivo']['tmp_name'];
	
	// Define o diretorio para uplad do arquivo
	$diretorio = "/home/vinigoulart1/public_html/magnetoelenco/videos/";
	
	// Define a pagina de resposta
	if($cd_tipo_video == 1){ // Video
		$pagina_resposta = "video.php";
	}
	else{ // Videofolio
		$pagina_resposta = "videofolio.php";
	}
	
	// Define o nome do arquivo no padrao do sistema
	$extensao_arquivo = getExtensaoArquivo($arquivo);
	$cd_elenco_formatado = str_pad($cd_elenco, 6, "0", STR_PAD_LEFT);
	$data_formatada = date("YmdHis");
	$nome_formatado = "elenco_".$cd_elenco_formatado."_".$data_formatada.".".$extensao_arquivo;
	
	// Chama a funcao para o upload do arquivo
	if(uploadArquivo($arquivo_tmp, $nome_formatado, $diretorio)){
		// Upload do arquivo efetuado. Gravar as informacoes no banco de dados
		// Chamada da funcao de conexao com o banco de dados
		$idconn = conectaBD();
		
		// Monta os arrays e chama a funcao para insercao no banco de dados
		$colunas = array("arquivo", "cd_elenco", "cd_tipo_video");
		$valores = array(toString($nome_formatado), $cd_elenco, $cd_tipo_video);
		$id_elenco = insereDados("tb_video", $colunas, $valores);	
		
		// Chamada da funcao para desconexao com o banco de dados
		desconectaBD($idconn);
		
		// Direciona o usuario para o formulario de upload
		header("Location: /admin/elenco/$pagina_resposta?id_elenco=$cd_elenco&msg=1");
	}
	else{
		// Erro no upload do arquivo. Exibir mensagem de erro
		// Direciona o usuario para o formulario de upload
		header("Location: /admin/elenco/$pagina_resposta?id_elenco=$cd_elenco&msg=2");		
	}
?>
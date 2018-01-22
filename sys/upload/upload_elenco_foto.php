<?php
	// Permite abertura de links externos
	ini_set("allow_url_fopen", 1);
	
	// Inclui os arquivos de sistema
	include("../../admin/includes/valida_acesso_adm.php");
	include("../api/Basic.php");
	include("../api/DataManipulation.php");

	// Recebe os dados do formulario
	$cd_elenco    = $_POST['cd_elenco'];
	$cd_tipo_foto = $_POST['cd_tipo_foto'];
	
	$arquivo1     = $_FILES['arquivo1']['name'];
	$arquivo_tmp1 = $_FILES['arquivo1']['tmp_name'];
	$dt_foto1     = $_POST['dt_foto'];
	
	$arquivo2     = $_FILES['arquivo2']['name'];
	$arquivo_tmp2 = $_FILES['arquivo2']['tmp_name'];
	$dt_foto2     = $_POST['dt_foto'];
	
	$arquivo3     = $_FILES['arquivo3']['name'];
	$arquivo_tmp3 = $_FILES['arquivo3']['tmp_name'];
	$dt_foto3     = $_POST['dt_foto'];
	
	$arquivo4     = $_FILES['arquivo4']['name'];
	$arquivo_tmp4 = $_FILES['arquivo4']['tmp_name'];
	$dt_foto4     = $_POST['dt_foto'];
	
	$arquivo5     = $_FILES['arquivo5']['name'];
	$arquivo_tmp5 = $_FILES['arquivo5']['tmp_name'];
	$dt_foto5     = $_POST['dt_foto'];
	
	$arquivo6     = $_FILES['arquivo6']['name'];
	$arquivo_tmp6 = $_FILES['arquivo6']['tmp_name'];
	$dt_foto6     = $_POST['dt_foto'];	
	
	// Define o formulario de origem
	switch($cd_tipo_foto){
		case 1:
			$pagina_retorno = "fotos_fotobook.php";
			$gera_thumb_pdf = true;
			break;
		case 2:
			$pagina_retorno = "fotos_portfolio.php";
			$gera_thumb_pdf = false;
			break;		
	}
	
	// Define o diretorio para uplad do arquivo
	$diretorio = "/home/vinigoulart1/public_html/magnetoelenco/fotos/";
	
	// Chama a funcao para formatacao e upload do arquivo
	if($arquivo1 != "") enviaArquivo($arquivo_tmp1, $arquivo1, $cd_elenco, $cd_tipo_foto, $diretorio, $dt_foto1, true, $gera_thumb_pdf);
	sleep(1);
	if($arquivo2 != "") enviaArquivo($arquivo_tmp2, $arquivo2, $cd_elenco, $cd_tipo_foto, $diretorio, $dt_foto2, true, $gera_thumb_pdf);
	sleep(1);
	if($arquivo3 != "") enviaArquivo($arquivo_tmp3, $arquivo3, $cd_elenco, $cd_tipo_foto, $diretorio, $dt_foto3, true, $gera_thumb_pdf);
	sleep(1);
	if($arquivo4 != "") enviaArquivo($arquivo_tmp4, $arquivo4, $cd_elenco, $cd_tipo_foto, $diretorio, $dt_foto4, true, $gera_thumb_pdf);
	sleep(1);
	if($arquivo5 != "") enviaArquivo($arquivo_tmp5, $arquivo5, $cd_elenco, $cd_tipo_foto, $diretorio, $dt_foto5, true, $gera_thumb_pdf);
	sleep(1);
	if($arquivo6 != "") enviaArquivo($arquivo_tmp6, $arquivo6, $cd_elenco, $cd_tipo_foto, $diretorio, $dt_foto6, true, $gera_thumb_pdf);
		
	// Direciona o usuario para o formulario de upload de fotos
	header("Location: /admin/elenco/$pagina_retorno?id_elenco=$cd_elenco");
?>
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

	$arquivo7     = $_FILES['arquivo7']['name'];
	$arquivo_tmp7 = $_FILES['arquivo7']['tmp_name'];
	$dt_foto7     = $_POST['dt_foto'];

	$arquivo8     = $_FILES['arquivo8']['name'];
	$arquivo_tmp8 = $_FILES['arquivo8']['tmp_name'];
	$dt_foto8     = $_POST['dt_foto'];

	$arquivo9     = $_FILES['arquivo9']['name'];
	$arquivo_tmp9 = $_FILES['arquivo9']['tmp_name'];
	$dt_foto9     = $_POST['dt_foto'];

	$arquivo10     = $_FILES['arquivo10']['name'];
	$arquivo_tmp10 = $_FILES['arquivo10']['tmp_name'];
	$dt_foto10     = $_POST['dt_foto'];

	$arquivo11     = $_FILES['arquivo11']['name'];
	$arquivo_tmp11 = $_FILES['arquivo11']['tmp_name'];
	$dt_foto11     = $_POST['dt_foto'];

	$arquivo12     = $_FILES['arquivo12']['name'];
	$arquivo_tmp12 = $_FILES['arquivo12']['tmp_name'];
	$dt_foto12     = $_POST['dt_foto'];

	$arquivo13     = $_FILES['arquivo13']['name'];
	$arquivo_tmp13 = $_FILES['arquivo13']['tmp_name'];
	$dt_foto13     = $_POST['dt_foto'];

	$arquivo14     = $_FILES['arquivo14']['name'];
	$arquivo_tmp14 = $_FILES['arquivo14']['tmp_name'];
	$dt_foto14     = $_POST['dt_foto'];

	$arquivo15     = $_FILES['arquivo15']['name'];
	$arquivo_tmp15 = $_FILES['arquivo15']['tmp_name'];
	$dt_foto15     = $_POST['dt_foto'];

	$arquivo16     = $_FILES['arquivo16']['name'];
	$arquivo_tmp16 = $_FILES['arquivo16']['tmp_name'];
	$dt_foto16     = $_POST['dt_foto'];

	$arquivo17     = $_FILES['arquivo17']['name'];
	$arquivo_tmp17 = $_FILES['arquivo17']['tmp_name'];
	$dt_foto17     = $_POST['dt_foto'];

	$arquivo18     = $_FILES['arquivo18']['name'];
	$arquivo_tmp18 = $_FILES['arquivo18']['tmp_name'];
	$dt_foto18     = $_POST['dt_foto'];

	$arquivo19     = $_FILES['arquivo19']['name'];
	$arquivo_tmp19 = $_FILES['arquivo19']['tmp_name'];
	$dt_foto19     = $_POST['dt_foto'];

	$arquivo20     = $_FILES['arquivo20']['name'];
	$arquivo_tmp20 = $_FILES['arquivo20']['tmp_name'];
	$dt_foto20     = $_POST['dt_foto'];

	// Define o formulario de origem
	switch($cd_tipo_foto){
		case 1:
			$pagina_retorno = "fotos_fotobook2.php";
			$gera_thumb_pdf = true;
			break;
		case 2:
			$pagina_retorno = "fotos_portfolio2.php";
			$gera_thumb_pdf = false;
			break;
	}

	// Define o diretorio para uplad do arquivo
	// $diretorio = "/home/vinigoulart1/public_html/magnetoelenco/fotos/";
	$diretorio = "/home/storage/d/a5/64/grupomagneto/public_html/magnetoelenco/fotos/";


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
	sleep(1);
	if($arquivo7 != "") enviaArquivo($arquivo_tmp7, $arquivo7, $cd_elenco, $cd_tipo_foto, $diretorio, $dt_foto7, true, $gera_thumb_pdf);
	sleep(1);
	if($arquivo8 != "") enviaArquivo($arquivo_tmp8, $arquivo8, $cd_elenco, $cd_tipo_foto, $diretorio, $dt_foto8, true, $gera_thumb_pdf);
	sleep(1);
	if($arquivo9 != "") enviaArquivo($arquivo_tmp9, $arquivo9, $cd_elenco, $cd_tipo_foto, $diretorio, $dt_foto9, true, $gera_thumb_pdf);
	sleep(1);
	if($arquivo10 != "") enviaArquivo($arquivo_tmp10, $arquivo10, $cd_elenco, $cd_tipo_foto, $diretorio, $dt_foto10, true, $gera_thumb_pdf);
	sleep(1);
	if($arquivo11 != "") enviaArquivo($arquivo_tmp11, $arquivo11, $cd_elenco, $cd_tipo_foto, $diretorio, $dt_foto11, true, $gera_thumb_pdf);
	sleep(1);
	if($arquivo12 != "") enviaArquivo($arquivo_tmp12, $arquivo12, $cd_elenco, $cd_tipo_foto, $diretorio, $dt_foto12, true, $gera_thumb_pdf);
	sleep(1);
	if($arquivo13 != "") enviaArquivo($arquivo_tmp13, $arquivo13, $cd_elenco, $cd_tipo_foto, $diretorio, $dt_foto13, true, $gera_thumb_pdf);
	sleep(1);
	if($arquivo14 != "") enviaArquivo($arquivo_tmp14, $arquivo14, $cd_elenco, $cd_tipo_foto, $diretorio, $dt_foto14, true, $gera_thumb_pdf);
	sleep(1);
	if($arquivo15 != "") enviaArquivo($arquivo_tmp15, $arquivo15, $cd_elenco, $cd_tipo_foto, $diretorio, $dt_foto15, true, $gera_thumb_pdf);
	sleep(1);
	if($arquivo16 != "") enviaArquivo($arquivo_tmp16, $arquivo16, $cd_elenco, $cd_tipo_foto, $diretorio, $dt_foto16, true, $gera_thumb_pdf);
	sleep(1);
	if($arquivo17 != "") enviaArquivo($arquivo_tmp17, $arquivo17, $cd_elenco, $cd_tipo_foto, $diretorio, $dt_foto17, true, $gera_thumb_pdf);
	sleep(1);
	if($arquivo18 != "") enviaArquivo($arquivo_tmp18, $arquivo18, $cd_elenco, $cd_tipo_foto, $diretorio, $dt_foto18, true, $gera_thumb_pdf);
	sleep(1);
	if($arquivo19 != "") enviaArquivo($arquivo_tmp19, $arquivo19, $cd_elenco, $cd_tipo_foto, $diretorio, $dt_foto19, true, $gera_thumb_pdf);
	sleep(1);
	if($arquivo20 != "") enviaArquivo($arquivo_tmp20, $arquivo20, $cd_elenco, $cd_tipo_foto, $diretorio, $dt_foto20, true, $gera_thumb_pdf);

	// Direciona o usuario para o formulario de upload de fotos
	header("Location: /magnetoelenco/admin/elenco/$pagina_retorno?id_elenco=$cd_elenco");
?>

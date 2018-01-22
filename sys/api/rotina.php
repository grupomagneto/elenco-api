<?php
	// Permite abertura de links externos
	ini_set("allow_url_fopen", 1);
	
	// Inclui os arquivos de sistema
	include("Basic.php");
	
	$lista_arquivos = listaArquivos("/home/vinigoulart1/public_html/magnetoelenco/fotos/");
	
	foreach($lista_arquivos as $valor){
		if(getExtensaoArquivo($valor) == "jpg"){
			$array_arquivo = explode(".", $valor);
			
			$nome_thumb214 = $array_arquivo[0]."_214x214.".$array_arquivo[1];
			file_get_contents("http://www.magnetoelenco.com.br/v2/thumb_pdf.php?src=".$valor."&dest=".$nome_thumb214."&x=214&y=214");
			
			$nome_thumb103 = $array_arquivo[0]."_103x103.".$array_arquivo[1];
			file_get_contents("http://www.magnetoelenco.com.br/v2/thumb_pdf.php?src=".$valor."&dest=".$nome_thumb103."&x=103&y=103");						
		}
	}
?>
<?
	// Define o header do XML
	header ("content-type: text/xml");

	// Inclui os arquivos de sistema
	include("../../sys/api/Basic.php");
	include("../../sys/api/DataManipulation.php");

	// Inicializa a string XML
	$xml .= "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
	$xml .= "<galerie>\n";

	// Recebe o id do elenco
	$id_elenco = $_REQUEST['id_elenco'];

	// Chamada da funcao de conexao com o banco de dados
	$idconn = conectaBD();

	// Consulta as fotos do elenco
	$sql_fotos = "select id_foto, arquivo, dt_foto
				  from tb_foto
				  where cd_elenco = $id_elenco
				  and cd_tipo_foto <> 2
				  order by id_foto";
	$rs_fotos = mysql_query($sql_fotos);

	while($row = mysql_fetch_array($rs_fotos)){
		$id_foto   = $row['id_foto'];
		$arquivo   = $row['arquivo'];
		$dt_foto   = formataData($row['dt_foto']);

		// Definindo o nome do arquivo de thumb
		// $array_arquivo = explode(".", $arquivo);
		// $nome_thumb = $array_arquivo[0]."_72x72.".$array_arquivo[1];
		$nome_thumb = $arquivo;

		$xml .= "<img thumbEvents='true' thumbnail='/magnetoelenco/thumb/$nome_thumb' large='/magnetoelenco/fotos/$arquivo' description='DATA DA FOTO: $dt_foto.'/>\n";

	}
	$xml .= "</galerie>";

	// Chamada da funcao para desconexao com o banco de dados
	desconectaBD($idconn);

	echo $xml;

?>

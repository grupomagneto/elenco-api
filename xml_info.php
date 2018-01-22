<?
	// Define o header do XML
	header ("content-type: text/xml");
	
	// Inclui os arquivos de sistema
	include("../../sys/api/Basic.php");
	include("../../sys/api/DataManipulation.php");
	
	// Inicializa a string XML
	$xml .= "<?xml version=\"1.0\" encoding=\"iso-8859-1\" ?>\n";
	
	// Recebe o id do elenco
	$id_elenco = $_REQUEST['id_elenco'];
	
	// Chamada da funcao de conexao com o banco de dados
	$idconn = conectaBD();
	
	// Consulta a qualificacao do elenco
	$sql = "select q.qualificacao, e.exclusivo 
			from tb_elenco as e, tt_qualificacao as q
			where e.id_elenco = $id_elenco
			and e.cd_qualificacao = q.id_qualificacao";
	$rs = mysql_query($sql);
	
	if($row = mysql_fetch_array($rs)){
		$qualificacao   = strtoupper($row['qualificacao']);
		$exclusivo      = $row['exclusivo'];
		
		// Define a qualificacao
		if($exclusivo) $qualificacao .= "+";
		
		// Consulta os videos do elenco
		$sql_videos = "select id_video 
					  from tb_video
					  where cd_elenco = $id_elenco
					  and cd_tipo_video = 1";
	
		$rs_videos = mysql_query($sql_videos);
		if(mysql_num_rows($rs_videos) > 0) $videobook = "videobook=\"xml/xml_galeriavideobook.php?id_elenco=$id_elenco\"";
		else $videobook = "";
		
		// Consulta o videofolio do elenco
		$sql_videofolio = "select id_video 
					  from tb_video
					  where cd_elenco = $id_elenco
					  and cd_tipo_video = 2";
	
		$rs_videofolio = mysql_query($sql_videofolio);
		if(mysql_num_rows($rs_videofolio) > 0) $videofolio = "videofolio=\"xml/xml_galeriavideofolio.php?id_elenco=$id_elenco\"";
		else $videofolio = "";		
		
		// Consulta as fotos de fotobook do elenco
		$sql_fotobook = "select id_foto 
					  from tb_foto 
					  where cd_elenco = $id_elenco
					  and cd_tipo_foto = 1";
	
		$rs_fotobook = mysql_query($sql_fotobook);
		if(mysql_num_rows($rs_fotobook) > 0) $fotobook = "fotobook=\"xml/xml_galeriafotobook.php?id_elenco=$id_elenco\"";
		else $fotobook = "";	
		
		// Consulta as fotos de portfolio do elenco
		$sql_fotos = "select id_foto 
					  from tb_foto 
					  where cd_elenco = $id_elenco
					  and cd_tipo_foto = 2";
	
		$rs_fotos = mysql_query($sql_fotos);
		if(mysql_num_rows($rs_fotos) > 0) $portfolio = "portfolio=\"xml/xml_galeriaportfolio.php?id_elenco=$id_elenco\"";
		else $portfolio = "";
		
		$xml .= "<infoElenco 
					id=\"1\" 
					qualificacao=\"$qualificacao\" 
					$videobook
					$portfolio
					$fotobook
					$videofolio 
				/>";
	
	}
	
	echo $xml;

?>
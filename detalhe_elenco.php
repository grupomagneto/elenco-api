<?php
	// Inclui os arquivos de sistema
	include("../sys/api/Basic.php");
	include("../sys/api/DataManipulation.php");
	include("../sys/api/MagnetoElenco.php");

	// Recebe o parametro enviado pela URL amigavel
	$cod = $_GET['cod'];
	if(strstr($cod, "/")){
		$array_cod = split("/", $cod);
		$nome_artistico = limpaString(trim(str_replace("_", " ", $array_cod[1])));
		$nome_artistico = trim($nome_artistico);
	}
	else{
		header("Location: nao_encontrado.php");
	}

	// Define o nome do arquivo pdf
	$nome_pdf = str_replace(" ", "_", $nome_artistico) . ".pdf";

	// Define a pagina de origem
	$pagina_origem = $_SERVER['HTTP_REFERER'];

	// Chamada da funcao de conexao com o banco de dados
	$idconn = conectaBD();

	// Inicializa o controle de sessao
	session_start();

	// Consulta o id do elenco
	$id_elenco = getIdElenco($nome_artistico);
	if(!isset($id_elenco)){
		header("Location: nao_encontrado.php");
	}

// Checa o tipo de Cadastro e se o Contrato está vencido
	date_default_timezone_set('America/Sao_Paulo');
	$hoje = date('Y-m-d', time());
	$sql_cadastro = "SELECT id_elenco, email, tipo_cadastro_vigente, data_contrato_vigente, tl_celular FROM tb_elenco WHERE id_elenco='$id_elenco'";
	$result = mysql_query($sql_cadastro);
		if (!$result) {
		 die('Erro: ' . mysql_error($link));
	}
	while ($row = mysql_fetch_array($result)) {
		$cadastro = $row['tipo_cadastro_vigente'];
		$contrato = $row['data_contrato_vigente'];
		if ($hoje <= date('Y-m-d', strtotime($contrato."+2 years")) && $contrato != NULL) {
			$contrato = "OK";
		} elseif ($hoje > date('Y-m-d', strtotime($contrato."+2 years"))) {
			$contrato = date('d/m/Y', strtotime($contrato."+2 years"));
			$contrato = "VENCIDO EM ".$contrato;
		} elseif ($contrato == NULL) {
			$contrato = "VENCIDO";
		}
	}

	// Definre arrays com as informacoes de contato e caracteristicas fisicas
	$elenco_contato = getInfoContatoExtenso($id_elenco);
	$elenco_fisicas = getCaracteristicasFisicasExtenso($id_elenco);

	// Define arrays com os valores de relacionamentos n:n
	$registros_categoria = getRegistrosRelacionamento("ta_elenco_categoria", "tt_categoria", "categoria", "cd_elenco", $id_elenco);
	$registros_tatuagem = getRegistrosRelacionamento("ta_elenco_tatuagem", "tt_tatuagem", "tatuagem", "cd_elenco", $id_elenco);
	$registros_piercing = getRegistrosRelacionamento("ta_elenco_piercing", "tt_piercing", "piercing", "cd_elenco", $id_elenco);
	$registros_aptidao = getRegistrosRelacionamento("ta_elenco_aptidao", "tt_aptidao", "aptidao", "cd_elenco", $id_elenco);
	$registros_esporte = getRegistrosRelacionamento("ta_elenco_esporte", "tt_esporte", "esporte", "cd_elenco", $id_elenco);
	$registros_danca = getRegistrosRelacionamento("ta_elenco_danca", "tt_danca", "danca", "cd_elenco", $id_elenco);
	$registros_lingua = getRegistrosRelacionamento("ta_elenco_lingua", "tt_lingua", "lingua", "cd_elenco", $id_elenco);
	$registros_sotaque = getRegistrosRelacionamento("ta_elenco_sotaque", "tt_sotaque", "sotaque", "cd_elenco", $id_elenco);
	$registros_instrumento = getRegistrosRelacionamento("ta_elenco_instrumento", "tt_instrumento", "instrumento", "cd_elenco", $id_elenco);

	// Define arrays com o valor de relacionamentos 1:n
	if($elenco_contato['alergia']){
		$registro_alergia = getRegistrosTabelaAssociativa("tt_alergia", "alergia", "id_alergia", $elenco_contato['cd_alergia']);
		$alergia = "sim, ".$registro_alergia['0'];
	}
	else{
		$alergia = "não";
	}

	if($elenco_contato['fobia']){
		$registro_fobia = getRegistrosTabelaAssociativa("tt_fobia", "fobia", "id_fobia", $elenco_contato['cd_fobia']);
		$fobia = "sim, ".$registro_fobia['0'];
	}
	else{
		$fobia = "não";
	}

	if($elenco_contato['restricao_religiosa']){
		$registro_restricao_religiosa = getRegistrosTabelaAssociativa("tt_restricao_religiosa", "restricao_religiosa", "id_restricao_religiosa", $elenco_contato['cd_restricao_religiosa']);
		$restricao_religiosa = "sim, ".$registro_restricao_religiosa['0'];
	}
	else{
		$restricao_religiosa = "não";
	}

	if($elenco_contato['restricao_alimentar']){
		$registros_restricao_alimentar = getRegistrosTabelaAssociativa("tt_restricao_alimentar", "restricao_alimentar", "id_restricao_alimentar", $elenco_contato['cd_restricao_alimentar']);
		$restricao_alimentar = "sim, ".$registros_restricao_alimentar['0'];
	}
	else{
		$restricao_alimentar = "não";
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Magneto Elenco</title>
<link rel="stylesheet" type="text/css" href="estilo.css">
<!-- <link rel="stylesheet" type="text/css" href="swiper.css"> -->
<script src="js/script.js" type="text/javascript"></script>
<script src="js/AC_RunActiveContent.js" type="text/javascript"></script>

<link rel="stylesheet" href="box/jquery.modal.css" media="screen,projection" type="text/css" />
<script type="text/javascript" src="box/jquery.js"></script>
<script type="text/javascript" src="box/modal.js"></script>
</head>
<body>

<div class="tudo">

<?php include("includes/menu_branco.php"); ?>

<!--  conteudo -->
<div class="conteudo">

<!-- interna swf -->
<div class="interna_swf">

<!-- div com tarja - display none ou block-->
<?php
	if(isElencoViajando($id_elenco)) $exibe_viajando = "block";
	else $exibe_viajando = "none";
?>
<div class="elenco_viajando" style="display:<?= $exibe_viajando; ?>;"><img src="img/elenco_viajando.png" width="151" height="100"></div>

<!-- Slider main container -->
		<!-- <div class="swiper-container"> -->
				<!-- Additional required wrapper -->
		<!-- 		<div class="swiper-wrapper">

		<?php
		$sql_foto = "SELECT arquivo FROM tb_foto WHERE cd_elenco='$id_elenco' AND cd_tipo_foto<>2 ORDER BY arquivo ASC";
		$result_foto = mysql_query($sql_foto);
		while($row_foto = mysql_fetch_array($result_foto)){
			$arquivo = $row_foto['arquivo'];
			echo "
			<div class='swiper-slide'>
			<img class='image__single' src='http://www.grupomagneto.com.br/magnetoelenco/fotos/$arquivo' />
			</div>";
		}
		?>
				</div> -->
				<!-- If we need pagination -->
				<!-- <div class="swiper-pagination"></div></div> -->
<!-- END Slider main container -->

<script language="javascript">
	if (AC_FL_RunContent == 0) {
		alert("This page requires AC_RunActiveContent.js.");
	} else {
		AC_FL_RunContent(
			'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0',
			'width', '550',
			'height', '540',
			'src', 'Galeria',
			'quality', 'high',
			'pluginspage', 'http://www.macromedia.com/go/getflashplayer',
			'align', 'middle',
			'play', 'true',
			'loop', 'true',
			'scale', 'showall',
			'wmode', 'transparent',
			'devicefont', 'false',
			'id', 'Galeria',
			'bgcolor', '#e7e7e9',
			'name', 'Galeria',
			'menu', 'true',
			'allowFullScreen', 'false',
			'allowScriptAccess','sameDomain',
			'movie', 'Galeria',
			'flashvars', 'infoUrl=http://www.grupomagneto.com.br/magnetoelenco/v2/xml/xml_info.php?id_elenco=<?= $id_elenco; ?>',
			'salign', ''
			); //end AC code
	}
</script>
<noscript>
	<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="550" height="540" id="Galeria" align="middle">
	<param name="allowScriptAccess" value="sameDomain" />
	<param name="allowFullScreen" value="false" />
	<param name="movie" value="Galeria.swf" /><param name="quality" value="high" /><param name="bgcolor" value="#e7e7e9" />	<embed src="Galeria.swf" quality="high" bgcolor="#e7e7e9" width="550" height="540" name="Galeria" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
	</object>
</noscript>
</div>
<!-- fim interna swf -->



<!-- bloco detalhe swf -->
<div class="bloco_detalhe_swf">

<div class="tit_swf"><?= $elenco_contato['nome_artistico']; ?></div>
Cadastro: <strong><?= $cadastro; ?></strong><br>
Contrato: <strong><?= $contrato; ?></strong><br>
Cidade: <strong><?= $elenco_contato['cidade']; ?></strong><br>
Casting: <strong><?= getCasting($id_elenco); ?></strong><br>
Melhor(es) dia(s) para trabalhos: <strong><?= $elenco_contato['melhor_dia']; ?></strong><br>
Melhor(es) hor&aacute;rios(s) para trabalhos: <strong><?= $elenco_contato['melhor_horario']; ?></strong>



<div class="detalhe_a">
<div class="font_red">Características físicas:</div>
Idade: <strong><?= $elenco_contato['idade']; ?> anos</strong><br>
Altura: <strong><?= number_format($elenco_fisicas['altura'], 2, ",", "."); ?> m</strong><br>
Peso: <strong><?= $elenco_fisicas['peso']; ?></strong><br>
Tipo Físico: <strong><?= $elenco_fisicas['tipo_fisico']; ?></strong><br>
Pele: <strong><?= $elenco_fisicas['pele']; ?></strong><br>
Olhos: <strong><?= $elenco_fisicas['olho']; ?></strong><br>
Cabelo: <strong><?= $elenco_fisicas['cabelo']; ?></strong><br>
Cor do cabelo: <strong><?= $elenco_fisicas['cor_cabelo']; ?></strong><br>
Compr. do cabelo: <strong><?= $elenco_fisicas['comprimento_cabelo']; ?></strong><br>
<?
	if($elenco_contato['sexo'] == 'F'){
?>
Busto: <strong><?= $elenco_fisicas['busto']; ?></strong><br>
Cintura: <strong><?= $elenco_fisicas['cintura']; ?></strong><br>
Quadril: <strong><?= $elenco_fisicas['quadril']; ?></strong><br>
<?
	}
	else{
?>
Camisa: <strong><?= $elenco_fisicas['camisa']; ?></strong><br>
Terno: <strong><?= $elenco_fisicas['terno']; ?></strong><br>
<?
	}
?>
Manequim: <strong><?= $elenco_fisicas['manequim']; ?></strong><br>
Sapato: <strong><?= $elenco_fisicas['sapato']; ?></strong><br>
Tatuagem: <strong><?= arrayParaStringComSeparador($registros_tatuagem, ",", "não"); ?></strong><br>
Piercing: <strong><?= arrayParaStringComSeparador($registros_piercing, ",", "não"); ?></strong><br>
Aparelho nos dentes: <strong><?= printSimNao($elenco_contato['aparelho']); ?></strong>
</div>


<div class="detalhe_b">
<div class="font_red">Restrições:</div>
Aceita cortar/pintar o cabelo: <strong><?= printSimNao($elenco_contato['producao_cabelo']); ?></strong><br>
Alergia: <strong><?= $alergia; ?></strong><br>
Fobia: <strong><?= $fobia; ?></strong><br>
Restrição religiosa:  <strong><?= $restricao_religiosa; ?></strong>

<div class="font_red">Habilidades:</div>
<?
	if(sizeof($registros_categoria) > 0){
?>
Categorias: <strong><?= arrayParaStringComSeparador($registros_categoria, ","); ?></strong><br>
<?
	}
	if(sizeof($registros_aptidao) > 0){
?>
Aptidões: <strong><?= arrayParaStringComSeparador($registros_aptidao, ",", "não"); ?></strong><br>
<?
	}
	if(sizeof($registros_esporte) > 0){
?>
Esportes: <strong><?= arrayParaStringComSeparador($registros_esporte, ",", "não"); ?></strong><br>
<?
	}
	if(sizeof($registros_danca) > 0){
?>
Danças: <strong><?= arrayParaStringComSeparador($registros_danca, ",", "não"); ?></strong><br>
<?
	}
	if(sizeof($registros_lingua) > 0){
?>
Línguas: <strong><?= arrayParaStringComSeparador($registros_lingua, ",", "não"); ?></strong><br>
<?
	}
	if(sizeof($registros_sotaque) > 0){
?>
Sotaques: <strong><?= arrayParaStringComSeparador($registros_sotaque, ",", "não"); ?></strong><br>
<?
	}
	if(sizeof($registros_instrumento) > 0){
?>
Instrumentos: <strong><?= arrayParaStringComSeparador($registros_instrumento, ",", "não"); ?></strong>
<?
	}
?>
</div>

<div class="lmp"></div>

<?
	if($elenco_fisicas['cursos'] != ""){
?>
<div class="font_red">Formação artísica:</div>
<?
		echo nl2br($elenco_fisicas['cursos']);
	}
?>

<?
	if($elenco_fisicas['trab_realizados'] != ""){
?>
<div class="font_red">Trabalhos realizados:</div>
<?
		echo nl2br($elenco_fisicas['trab_realizados']);
	}
?>

<?
	if($elenco_fisicas['observacoes'] != ""){
?>
<div class="font_red">Observações:</div>
<?
		echo nl2br($elenco_fisicas['observacoes']);
	}
?>

<p>
<?php
	if(!strpos($pagina_origem, "meu_casting.php")){
?>
<a href="#" onclick="document.getElementById('manipula_casting').src = 'adiciona_casting.php?id_elenco=<?= $id_elenco; ?>'; $('.modal').modalToggle(); return false;"><img src="img/bt_adicionar_meu_cast.gif" class="lft"></a>
<?
	}
?>
<a href="http://www.grupomagneto.com.br/magnetoelenco/sys/run/gera_pdf_elenco.php?id_elenco=<?= $id_elenco; ?>" target="_blank"><img src="img/bt_download_composite.gif" class="rgt"></a></p>

<div class="lmp"></div>

<div class="dez">
<?php
	if(strpos($pagina_origem, "pesquisa_resultado.php")){
?>
<a href="javascript:history.back();"><img src="img/bt_retornar.gif"></a>
<?
	}
?>
</div>

</div>
<!-- fim bloco detlhe swf -->




</div>
<!-- fim conteudo -->




<div><img src="img/bg_pe.gif"></div>
<!-- fim pesquisa -->

<div class="lmp"></div>

<?php include("includes/rodape.php"); ?>

</div>

<!-- lightbox adicionar ao casting -->
<div class="modal mod_adiciona_cast">
	<a href="#" onclick="$('.modal').modalToggle(); return false;"><img src="img/bt_fechar.gif" class="fechar_a"></a>
	<iframe id="manipula_casting" width="470" height="200" frameborder="0" scrolling="no" class="ifr"></iframe>
</div>
<!-- fim lightbox adicionar ao castingl -->
<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script src="swiper.jquery.min.js"></script>
<script src="swiper.min.js"></script> -->
</body>
</html>
<?php
	// Chamada da funcao para desconexao com o banco de dados
	desconectaBD($idconn);
?>

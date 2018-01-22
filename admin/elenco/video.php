<?php
	// Include dos arquivos de sistema e validacao
	include("../includes/valida_acesso_adm.php");
	include("../../sys/api/DataManipulation.php");
	include("../../sys/api/Basic.php");
	include("../../sys/api/MagnetoElenco.php");

	// Include do arquivo com o topo
	include("../includes/topo_adm.php");

	// Chamada da funcao de conexao com o banco de dados
	$idconn = conectaBD();

	// Recebe o id do elenco
	$id_elenco = $_GET['id_elenco'];

	// Define um array com as informacoes de contato
	$elenco_contato = getInfoContato($id_elenco);
?>
<script type="text/javascript" src="flash.js"></script>

<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#c3161c">
  <tr>
    <td style=" font-size:31px; padding:5px 0 5px 10px; color:#FFF;"><?= $elenco_contato['nome']; ?></td>
    <td align="right"></td>
  </tr>
</table>


<img src="../img/tit_videobook.gif" width="191" height="68" class="tit"/>


<form enctype="multipart/form-data" method="post" action="/magnetoelenco/sys/upload/upload_elenco_video.php">
<table width="600" border="0" cellpadding="4">
  <tr>
    <td> Arquivo: </td>
    <td><input name="arquivo" type="file" id="arquivo" size="40" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
		<input type="hidden" name="cd_tipo_video" value="1" />
		<input type="hidden" name="cd_elenco" value="<?= $id_elenco; ?>" />
		<input name="brnGravar" type="image"  src="../img/bt_gravar.gif" id="brnGravar" />
	</td>
  </tr>
</table>
</form>
<hr width="98%" />
<?php
	// Consulta os videos do elenco
	$sql_videos = "select id_video, arquivo
				  from tb_video
				  where cd_elenco = $id_elenco
				  and cd_tipo_video = 1";

	$rs_videos = mysql_query($sql_videos);
	if(mysql_num_rows($rs_videos) > 0){
?>
<table width="400" border="0" cellpadding="2" class="tit">
<?php
		while($row = mysql_fetch_array($rs_videos)){
			$id_video   = $row['id_video'];
			$arquivo   = $row['arquivo'];
?>
  <tr>
    <td>
	<script language="JavaScript" type="text/javascript">
		AC_FL_RunContent(
			'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0',
			'width', '480',
			'height', '360',
			'src', 'player',
			'quality', 'high',
			'pluginspage', 'http://www.adobe.com/go/getflashplayer',
			'align', 'middle',
			'play', 'true',
			'loop', 'true',
			'scale', 'showall',
			'wmode', 'window',
			'devicefont', 'false',
			'id', 'player',
			'bgcolor', '#ffffff',
			'name', 'player',
			'menu', 'true',
			'allowFullScreen', 'false',
			'allowScriptAccess','sameDomain',
			'movie', 'player',
			'salign', '',
			'FlashVars', 'flvAddress=/videos/<?= $arquivo; ?>'
			); //end AC code
	</script>
	<noscript>
		<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="250" height="250" id="teste" align="middle">
		<param name="allowScriptAccess" value="sameDomain" />
		<param name="allowFullScreen" value="false" />
		<param name="movie" value="player.swf" /><param name="quality" value="high" /><param name="bgcolor" value="#ffffff" />	<embed src="player.swf" quality="high" bgcolor="#ffffff" width="250" height="250" name="teste" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/go/getflashplayer" />
		</object>
	</noscript>
	</td>
    <td><a href="#a" onclick="javascript: confirmaExclusao('/magnetoelenco/sys/del/del_elenco_video.php?id_tipo_video=1&id_elenco=<?= $id_elenco; ?>&id_video=<?= $id_video; ?>&arquivo=<?= $arquivo; ?>');">excluir</a></td>
  </tr>
<?php
		}
?>
</table>
<?php
	}
	else{
?>
	<p class="tit">Nenhum vídeo cadastrado.</p>
<?php
	}
?>

 <!-- final -->
 </td>
  </tr>
	<tr>
	  <td colspan="2" bgcolor="#FFFFFF"><img src="/magnetoelenco/admin/img/menu_pe.gif" width="990" height="26"></td>
  </tr>
</table>
</body>
</html>
<?php
	// Chamada da funcao para desconexao com o banco de dados
	desconectaBD($idconn);
?>

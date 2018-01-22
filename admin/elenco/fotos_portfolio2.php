<?php
	// Include dos arquivos de sistema e validacao
	include("../includes/valida_acesso_adm.php");
	include("../../sys/api/DataManipulation.php");
	include("../../sys/api/MagnetoElenco.php");
	include("../../sys/api/Basic.php");

	// Include do arquivo com o topo
	include("../includes/topo_adm.php");

	// Chamada da funcao de conexao com o banco de dados
	$idconn = conectaBD();

	// Recebe o id do elenco
	$id_elenco = $_GET['id_elenco'];

	// Define um array com as informacoes de contato
	$elenco_contato = getInfoContato($id_elenco);
?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#c3161c">
  <tr>
    <td style="font-size:31px; padding:5px 0 5px 10px; color:#FFF;"><?= $elenco_contato['nome']; ?></td>
    <td align="right"></td>
  </tr>
</table>


<img src="../img/tit_portifolio.gif" width="171" height="68" class="tit" />





<form enctype="multipart/form-data" method="post" action="/magnetoelenco/sys/upload/upload_elenco_foto2.php">
<table width="98%" align="center" border="0" cellpadding="4">
  <tr>
    <td> Arquivo 1:</td>
    <td><input name="arquivo1" type="file" id="arquivo1" size="40" /></td>
  </tr>
  <tr>
    <td> Arquivo 2:</td>
    <td><input name="arquivo2" type="file" id="arquivo2" size="40" /></td>
  </tr>
  <tr>
    <td> Arquivo 3:</td>
    <td><input name="arquivo3" type="file" id="arquivo3" size="40" /></td>
  </tr>
  <tr>
    <td> Arquivo 4:</td>
    <td><input name="arquivo4" type="file" id="arquivo4" size="40" /></td>
  </tr>
  <tr>
    <td> Arquivo 5:</td>
    <td><input name="arquivo5" type="file" id="arquivo5" size="40" /></td>
  </tr>
  <tr>
    <td> Arquivo 6:</td>
    <td><input name="arquivo6" type="file" id="arquivo6" size="40" /></td>
  </tr>
   <tr>
    <td> Arquivo 7:</td>
    <td><input name="arquivo7" type="file" id="arquivo7" size="40" /></td>
  </tr>
  <tr>
    <td> Arquivo 8:</td>
    <td><input name="arquivo8" type="file" id="arquivo8" size="40" /></td>
  </tr>
  <tr>
    <td> Arquivo 9:</td>
    <td><input name="arquivo9" type="file" id="arquivo9" size="40" /></td>
  </tr>
  <tr>
    <td> Arquivo 10</td>
    <td><input name="arquivo10" type="file" id="arquivo10" size="40" /></td>
  </tr>
  <tr>
    <td> Arquivo 11:</td>
    <td><input name="arquivo11" type="file" id="arquivo11" size="40" /></td>
  </tr>
  <tr>
    <td> Arquivo 12:</td>
    <td><input name="arquivo12" type="file" id="arquivo12" size="40" /></td>
  </tr>
  <tr>
    <td> Arquivo 13:</td>
    <td><input name="arquivo13" type="file" id="arquivo13" size="40" /></td>
  </tr>
  <tr>
    <td> Arquivo 14:</td>
    <td><input name="arquivo14" type="file" id="arquivo14" size="40" /></td>
  </tr>
  <tr>
    <td> Arquivo 15:</td>
    <td><input name="arquivo15" type="file" id="arquivo15" size="40" /></td>
  </tr>
  <tr>
    <td> Arquivo 16:</td>
    <td><input name="arquivo16" type="file" id="arquivo16" size="40" /></td>
  </tr>
  <tr>
    <td> Arquivo 17:</td>
    <td><input name="arquivo17" type="file" id="arquivo17" size="40" /></td>
  </tr>
  <tr>
    <td> Arquivo 18:</td>
    <td><input name="arquivo18" type="file" id="arquivo18" size="40" /></td>
  </tr>
  <tr>
    <td> Arquivo 19:</td>
    <td><input name="arquivo19" type="file" id="arquivo19" size="40" /></td>
  </tr>
  <tr>
    <td> Arquivo 20:</td>
    <td><input name="arquivo20" type="file" id="arquivo20" size="40" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
		<input type="hidden" name="cd_tipo_foto" id="cd_tipo_foto" value="2" />
		<input type="hidden" name="cd_elenco" value="<?= $id_elenco; ?>" />
		<input name="brnGravar" type="image" src="../img/bt_gravar.gif" id="brnGravar" />
	</td>
  </tr>
</table>
</form>
<hr width="98%" />
<?php
	// Consulta as fotos do elenco
	$sql_fotos = "select id_foto, arquivo
				  from tb_foto
				  where cd_elenco = $id_elenco
				  and cd_tipo_foto = 2
				  order by id_foto";

	$rs_fotos = mysql_query($sql_fotos);
	if(mysql_num_rows($rs_fotos) > 0){
?>
<table width="200" border="0" cellpadding="2" class="tit">
<?php
		while($row = mysql_fetch_array($rs_fotos)){
			$id_foto   = $row['id_foto'];
			$arquivo   = $row['arquivo'];

			// Definindo o nome do arquivo de thumb
			$array_arquivo = explode(".", $arquivo);
			$nome_thumb = $array_arquivo[0]."_72x72.".$array_arquivo[1];
?>
  <tr>
    <td><img border="0" src="/magnetoelenco/fotos/thumb/<?= $nome_thumb ?>" /></td>
    <td><a href="#a" onclick="javascript: confirmaExclusao('/sys/del/del_elenco_foto2.php?id_tipo_foto=2&id_elenco=<?= $id_elenco; ?>&id_foto=<?= $id_foto; ?>&arquivo=<?= $arquivo; ?>');">excluir</a></td>
  </tr>
<?php
		}
?>
</table>
<?php
	}
	else{
?>
	<p class="tit">Nenhuma foto cadastrada.</p>
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

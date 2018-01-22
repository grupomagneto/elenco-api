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
?>


<img src="../img/tit_destaque_pag_inicial.gif" width="477" height="68" class="tit" />

<form enctype="multipart/form-data" method="post" action="/magnetoelenco/sys/upload/upload_destaques_home.php">
<table width="98%" align="center" border="0" cellpadding="4">
  <tr>
    <td> Arquivo:</td>
    <td><input name="arquivo" type="file" id="arquivo" size="40" /></td>
  </tr>
  <tr>
    <td> Link:</td>
    <td><input name="link" type="text" id="link" style="width:320px;" maxlength="250" /></td>
  </tr>
  <tr>
    <td> Descri&ccedil;&atilde;o:</td>
    <td><input name="descricao" type="text" id="descricao" style="width:320px;" maxlength="400" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
		<input name="brnGravar" type="image"  src="../img/bt_gravar.gif" id="brnGravar" />	</td>
  </tr>
</table>
</form>
<hr width="98%" />
<?php
	// Consulta as fotos do elenco
	$sql_destaques = "select id_destaque, arquivo
				  from tb_destaque
				  order by id_destaque";

	$rs_destaques = mysql_query($sql_destaques);
	if(mysql_num_rows($rs_destaques) > 0){
?>
<table width="98%" align="center" border="0" cellpadding="2">
<?php
		while($row = mysql_fetch_array($rs_destaques)){
			$id_destaque = $row['id_destaque'];
			$arquivo     = $row['arquivo'];
?>
  <tr>
    <td width="50%"><img border="0" src="/destaques/<?= $arquivo ?>" /></td>
    <td><a href="#a" class="tit" onclick="javascript: confirmaExclusao('/magnetoelenco/sys/del/del_destaque_home.php?id_destaque=<?= $id_destaque; ?>&arquivo=<?= $arquivo; ?>');">excluir destaque</a></td>
  </tr>
<?php
		}
?>
</table>
<?php
	}
	else{
?>
	<p>Nenhum destaque cadastrado.</p>
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

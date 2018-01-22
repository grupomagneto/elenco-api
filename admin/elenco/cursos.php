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
	
	// Seleciona o conteudo de cursos
	$sql = "select texto from tb_conteudo";
	$rs = mysql_query($sql);
	if($row = mysql_fetch_array($rs)){
		$texto = $row['texto'];
	}
?>

<img src="../img/tit_cursos.gif" width="126" height="68" class="tit" />

<form method="post" action="/sys/update/up_conteudo.php">
<table width="98%" align="center" border="0" cellpadding="4"> 
  <tr>
    <td valign="top"> Cursos:</td>
    <td><textarea name="texto" id="texto" style="width:600px; height:400px;"><?= $texto; ?></textarea></td>
  </tr> 
  <tr>
    <td>&nbsp;</td>
    <td>
		<input name="brnGravar" type="image"  src="../img/bt_gravar.gif" id="brnGravar" />	</td>
  </tr>
</table>
</form>

 <!-- final -->
 </td>
  </tr>
	<tr>
	  <td colspan="2" bgcolor="#FFFFFF"><img src="/admin/img/menu_pe.gif" width="990" height="26"></td>
  </tr>
</table>
</body>
</html>
<?php
	// Chamada da funcao para desconexao com o banco de dados
	desconectaBD($idconn);	
?>
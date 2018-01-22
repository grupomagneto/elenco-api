<?php
	// Include dos arquivos de sistema e validacao
	include("../includes/valida_acesso_adm.php");
	include("../../sys/api/DataManipulation.php");

	// Include do arquivo com o topo
	include("../includes/topo_adm.php");
?>

<img src="../img/tit_gerenciamento_usuarios.gif" width="488" height="68" class="tit" />

<p class="tit"><a href="admin.php">Inserir</a></p>
<?php
	// Chamada da funcao de conexao com o banco de dados
	$idconn = conectaBD();

	// Seleciona os registros de admin inseridos no banco de dados
	$sql_admin = "select id_admin, login from tb_admin order by login";
	$rs_admin = mysql_query($sql_admin);

	if(mysql_num_rows($rs_admin) > 0){
?>
<table width="450" border="0" cellpadding="2" class="tit">
  <tr>
    <td><strong>login</strong></td>
	<td><strong>a&ccedil;&otilde;es</strong></td>
  </tr>
<?php
		while($row = mysql_fetch_array($rs_admin)){
			$id    = $row[0];
			$login = $row[1];
?>
  <tr>
    <td><?= $login; ?></td>
	<td>
		<a href="admin.php?id=<?= $id; ?>">alterar senha</a> |
<?
			if($id == $_SESSION['id_admin']){
?>
		excluir
<?
			}
			else{
?>
		<a href="#a" onclick="javascript: confirmaExclusao('/sys/del/del_admin.php?id=<?= $id; ?>');">excluir</a>
<?
			}
?>
	</td>
  </tr>
<?php
		}
?>
</table>
<?php
	}

	// Chamada da funcao para desconexao com o banco de dados
	desconectaBD($idconn);
?>
<p>&nbsp; </p>

 <!-- final -->
 </td>
  </tr>
	<tr>
	  <td colspan="2" bgcolor="#FFFFFF"><img src="/magnetoelenco/admin/img/menu_pe.gif" width="990" height="26"></td>
  </tr>
</table>

</body>
</html>

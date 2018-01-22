<?php
	// Include dos arquivos de sistema e validacao
	include("../includes/valida_acesso_adm.php");
	include("../../sys/api/DataManipulation.php");
	include("../../sys/api/Basic.php");

	// Include do arquivo com o topo
	include("../includes/topo_adm.php");

	// Chamada da funcao de conexao com o banco de dados
	$idconn = conectaBD();

	// Recebe o o nome da tabela tradicional
	$tabela_tradicional = $_REQUEST['tabela_tradicional'];

	// Define os nomes das colunas da tabela tradicional
	$coluna_id    = "id_".str_replace("tt_", "", $tabela_tradicional);
	$coluna_valor = str_replace("tt_", "", $tabela_tradicional);
?>

<img src="../img/tit_gerenciamento_tabelas.gif" width="457" height="68" class="tit" />


<h1 class="tit">Tabela tradicional: <?= $tabela_tradicional; ?></h1>
<form name="form_gerencia_tt" method="post" action="/sys/insert/ins_tt_valor.php">
<table width="600" border="0" cellpadding="4" class="tit">
  <tr>
    <td>Valor: </td>
    <td><input name="valor" id="valor" type="text" size="40" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
		<input type="hidden" name="tabela_tradicional" value="<?= $tabela_tradicional; ?>" />
		<input name="brnGravar" type="image" src="../img/bt_gravar.gif" id="brnGravar" />
	</td>
  </tr>
</table>
</form>
<hr width="98%" />
<?php
	// Consulta os registros da tabela tradicional
	$sql_valores = "select * from $tabela_tradicional order by $coluna_valor";
	$rs_valores = mysql_query($sql_valores);
	if(mysql_num_rows($rs_valores) > 0){
?>
<table width="400" border="0" cellpadding="2" class="tit">
<?php
		while($row = mysql_fetch_array($rs_valores)){
			$id_tt    = $row['0'];
			$valor_tt = $row['1'];
?>
  <tr>
    <td><?= $valor_tt; ?></td>
    <td><a href="#a" onclick="javascript: confirmaExclusao('/sys/del/del_tt_valor.php?id_tt=<?= $id_tt; ?>&tabela_tradicional=<?= $tabela_tradicional; ?>');">excluir</a></td>
  </tr>
<?php
		}
?>
</table>
<?php
	}
	else{
?>
	<p>Nenhum valor cadastrado.</p>
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

<?php
	// Include dos arquivos de sistema e validacao
	include("../includes/valida_acesso_adm.php");
	include("../../sys/api/DataManipulation.php");

	// Include do arquivo com o topo
	include("../includes/topo_adm.php");

	// Chamada da funcao de conexao com o banco de dados
	$idconn = conectaBD();

	// Seleciona as tabelas tradicionais
	$sql_tables = "show tables where Tables_in_vinigoulart12 like 'tt_%' and Tables_in_vinigoulart12 not like 'tt_tipo_foto' and Tables_in_vinigoulart12 not like 'tt_tipo_video'";
	$rs_tables = mysql_query($sql_tables);

	if(mysql_num_rows($rs_tables) > 0){
?>

<img src="../img/tit_gerenciamento_tabelas.gif" width="457" height="68" class="tit" />

<form name="form_tt" method="post" action="tabela.php">
<table width="400" border="0" cellpadding="0" cellspacing="0" class="tit">
  <tr>
    <td height="30">Selecione a tabela cujos valores deseja gerenciar:</td>
  </tr>
  <tr>
    <td>
	  <select name="tabela_tradicional" id="tabela_tradicional">
		<option value="">-------------------------------</option>
<?php
			while($row = mysql_fetch_array($rs_tables)){
				$tabela_tradicional = $row['Tables_in_vinigoulart12'];
?>
		<option value="<?= $tabela_tradicional; ?>"><?= $tabela_tradicional; ?></option>
<?php
			}
?>
	  </select>
	</td>
  </tr>
  <tr>
    <td><br />      <input type="image" src="../img/bt_ok.gif" name="btn_ok" id="btn_ok" /></td>
  </tr>
</table>
</form>
<?php
	}
	else{
?>
<p class="tit">N&atilde;o existem tabelas tradicionais.</p>
<?php
	}

	// Chamada da funcao para desconexao com o banco de dados
	desconectaBD($idconn);
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

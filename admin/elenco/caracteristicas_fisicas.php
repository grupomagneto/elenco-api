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

	// Recebe o id do registro de elenco
	$id_elenco = $_GET['id_elenco'];

	// Consulta as caracteristicas fisicas ja cadastradas
	$elenco_fisicas = getCaracteristicasFisicas($id_elenco);

	// Define um array com as informacoes de contato
	$elenco_contato = getInfoContato($id_elenco);

	// Consulta os registros das tabelas associativas
	$registros_tatuagem = getRegistrosTabelaAssociativa("ta_elenco_tatuagem", "cd_tatuagem", "cd_elenco", $id_elenco);
	$registros_piercing = getRegistrosTabelaAssociativa("ta_elenco_piercing", "cd_piercing", "cd_elenco", $id_elenco);
	$registros_aptidao = getRegistrosTabelaAssociativa("ta_elenco_aptidao", "cd_aptidao", "cd_elenco", $id_elenco);
	$registros_categoria = getRegistrosTabelaAssociativa("ta_elenco_categoria", "cd_categoria", "cd_elenco", $id_elenco);
	$registros_esporte = getRegistrosTabelaAssociativa("ta_elenco_esporte", "cd_esporte", "cd_elenco", $id_elenco);
	$registros_danca = getRegistrosTabelaAssociativa("ta_elenco_danca", "cd_danca", "cd_elenco", $id_elenco);
	$registros_lingua = getRegistrosTabelaAssociativa("ta_elenco_lingua", "cd_lingua", "cd_elenco", $id_elenco);
	$registros_sotaque = getRegistrosTabelaAssociativa("ta_elenco_sotaque", "cd_sotaque", "cd_elenco", $id_elenco);
	$registros_instrumento = getRegistrosTabelaAssociativa("ta_elenco_instrumento", "cd_instrumento", "cd_elenco", $id_elenco);

	// Define o sexo do elenco
	$sexo = getSexo($id_elenco);
?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#c3161c">
  <tr>
    <td style="font-size:31px; padding:5px 0 5px 10px; color:#FFF;"><?= $elenco_contato['nome']; ?></td>
    <td align="right"></td>
  </tr>
</table>

<img src="../img/tit_caracteristicas_fisicas.gif" width="405" height="68" class="tit" />


<form name="info_contato" method="post" action="/magnetoelenco/sys/insert/ins_elenco_caracteristicas_fisicas.php">

<table width="80%" border="0" style="margin-left:10px; margin-top:25px;">
  <tr>
    <td>Peso:<br />
<input name="peso" type="text" id="peso" style="width:60%;" maxlength="6" value="<?= $elenco_fisicas['peso']; ?>" /></td>
    <td>&nbsp;</td>
    <td>Altura<br />
<input name="altura" type="text" id="altura" style="width:60%;" maxlength="4" onkeydown="mascara(this,'#.##');" value="<?= $elenco_fisicas['altura']; ?>" /></td>
    <td>&nbsp;</td>
    <td>Manequim:<br />
<input name="manequim" type="text" id="manequim" style="width:60%;" maxlength="6" value="<?= $elenco_fisicas['manequim']; ?>" /></td>
    <td>&nbsp;</td>

<?php
	if($sexo =='F'){
?>
    <td>Sapato:<br />
<input name="sapato" type="text" id="sapato" style="width:60%;" maxlength="2" value="<?= $elenco_fisicas['sapato']; ?>" /></td>
    <td>&nbsp;</td>
    <td>Busto:<br />
<input name="busto" type="text" id="busto" style="width:60%;" maxlength="6" value="<?= $elenco_fisicas['busto']; ?>" /></td>
    <td>&nbsp;</td>
    <td>Cintura:<br />
<input name="cintura" type="text" id="cintura" style="width:60%;" maxlength="6" value="<?= $elenco_fisicas['cintura']; ?>" /></td>
    <td>&nbsp;</td>
    <td>Quadril:<br />
<input name="quadril" type="text" id="quadril" style="width:60%;" maxlength="6" value="<?= $elenco_fisicas['quadril']; ?>" /></td>
    <td>&nbsp;</td>
   <?php
	}
	else{
?>

    <td>Sapato:<br />
<input name="sapato" type="text" id="sapato" style="width:60%;" maxlength="5" value="<?= $elenco_fisicas['sapato']; ?>" /></td>
    <td>&nbsp;</td>
    <td>Camisa:<br />
<input name="camisa" type="text" id="camisa" style="width:60%;" maxlength="2" value="<?= $elenco_fisicas['camisa']; ?>" /></td>
    <td>&nbsp;</td>
    <td>Terno:<br />
<input name="terno" type="text" id="terno" style="width:60%;" maxlength="4" value="<?= $elenco_fisicas['terno']; ?>" /></td>
    <td>&nbsp;</td>
<?php
	}
?>
    <td width="110">Sinais no corpo:<br />
<input name="sinais" type="radio" value="1" <?php selecionaRadio($elenco_fisicas['sinais'], 1); ?> /> sim &nbsp; &nbsp;<input name="sinais" type="radio" value="0" <?php selecionaRadio($elenco_fisicas['sinais'], 0); ?> /> n&atilde;o
</td>
    <td>&nbsp;</td>
    <td>Onde?<br /><input name="sinais_onde" type="text" id="sinais_onde" maxlength="40" value="<?= $elenco_fisicas['sinais_onde']; ?>" /></td>
   </tr>
 </table>

<table width="98%" border="0" align="center">
  <tr>
    <td colspan="11" height="7"></td>
    </tr>
  <tr>
    <td>Etnia:<br />
<?php echo montaCampoSelect("tt_pele", "cd_pele", "pele", "id_pele", 1, false, "id_pele", "width:100%;", $elenco_fisicas['cd_pele']); ?></td>
    <td>&nbsp;</td>
    <td>Cor dos olhos:<br />
<?php echo montaCampoSelect("tt_olho", "cd_olho", "olho", "id_olho", 1, false, "id_olho", "width:100%;", $elenco_fisicas['cd_olho']); ?></td>
    <td>&nbsp;</td>
    <td>Tipo f&iacute;sico:<br />
    <?php echo montaCampoSelect("tt_tipo_fisico", "cd_tipo_fisico", "tipo_fisico", "id_tipo_fisico", 1, false, "id_tipo_fisico", "width:100%;", $elenco_fisicas['cd_tipo_fisico']); ?></td>
    <td>&nbsp;</td>
    <td>Cabelo:<br />
<?php echo montaCampoSelect("tt_cabelo", "cd_cabelo", "cabelo", "id_cabelo", 1, false, "id_cabelo", "width:100%;", $elenco_fisicas['cd_cabelo']); ?></td>
    <td>&nbsp;</td>
    <td>Comprimento do cabelo:<br />
<?php echo montaCampoSelect("tt_comprimento_cabelo", "cd_comprimento_cabelo", "comprimento_cabelo", "id_comprimento_cabelo", 1, false, "id_comprimento_cabelo", "width:100%;", $elenco_fisicas['cd_comprimento_cabelo']); ?></td>
    <td>&nbsp;</td>
    <td>Cor do cabelo:<br />
    <?php echo montaCampoSelect("tt_cor_cabelo", "cd_cor_cabelo", "cor_cabelo", "id_cor_cabelo", 1, false, "id_cor_cabelo", "width:100%;", $elenco_fisicas['cd_cor_cabelo']); ?>
</td>
  </tr>
</table>

<table width="98%" border="0" align="center">
  <tr>
    <td colspan="7" height="7"></td>
    </tr>
  <tr>
    <td>Tatuagem:<br />
<?php echo montaCampoSelect("tt_tatuagem", "cd_tatuagem", "tatuagem", "id_tatuagem",5, true, "id_tatuagem", "width:100%;", $registros_tatuagem); ?></td>
    <td>&nbsp;</td>
    <td>Piercing:<br />
<?php echo montaCampoSelect("tt_piercing", "cd_piercing", "piercing", "id_piercing",5, true, "id_piercing", "width:100%;", $registros_piercing); ?></td>
    <td>&nbsp;</td>
    <td>Aptid&otilde;es:<br />
    <?php echo montaCampoSelect("tt_aptidao", "cd_aptidao", "aptidao", "id_aptidao",5, true, "id_aptidao", "width:100%;", $registros_aptidao); ?>
    </td>
    <td>&nbsp;</td>
    <td>Categoria<br />
<?php echo montaCampoSelect("tt_categoria", "cd_categoria", "categoria", "id_categoria",5, true, "id_categoria", "width:100%;", $registros_categoria); ?></td>
  </tr>
  <tr>
    <td colspan="7" height="5"></td>
    </tr>
  <tr>
    <td>Esporte:<br />
<?php echo montaCampoSelect("tt_esporte", "cd_esporte", "esporte", "id_esporte",5, true, "id_esporte", "width:100%;", $registros_esporte); ?></td>
    <td>&nbsp;</td>
    <td>Dan&ccedil;as:<br />
<?php echo montaCampoSelect("tt_danca", "cd_danca", "danca", "id_danca",5, true, "id_danca", "width:100%;", $registros_danca); ?></td>
    <td>&nbsp;</td>
    <td>L&iacute;nguas:<br />
<?php echo montaCampoSelect("tt_lingua", "cd_lingua", "lingua", "id_lingua",5, true, "id_lingua", "width:100%;", $registros_lingua); ?></td>
    <td>&nbsp;</td>
    <td>Sotaques:<br />
<?php echo montaCampoSelect("tt_sotaque", "cd_sotaque", "sotaque", "id_sotaque",5, true, "id_sotaque", "width:100%;", $registros_sotaque); ?></td>
  </tr>
  <tr>
    <td colspan="7" height="5"></td>
    </tr>
  <tr>
    <td>Instrumentos:<br />
<?php echo montaCampoSelect("tt_instrumento", "cd_instrumento", "instrumento", "id_instrumento",5, true, "id_instrumento", "width:100%;", $registros_instrumento); ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>


<table width="98%" border="0" align="center">
  <tr>
    <td colspan="5" height="15"></td>
    </tr>
  <tr>
    <td>Forma&ccedil;&atilde;o art&iacute;stica:<br />
    <textarea name="cursos" id="cursos" style="width:100%; height:150px;"><?= $elenco_fisicas['cursos']; ?></textarea></td>
    <td>&nbsp;</td>
    <td>Trabalhos realizados:<br />
    <textarea name="trab_realizados" id="trab_realizados" style="width:100%; height:150px;"><?= $elenco_fisicas['trab_realizados']; ?></textarea></td>
    <td>&nbsp;</td>
    <td>Observa&ccedil;&otilde;es:<br />
<textarea name="observacoes" id="observacoes" style="width:100%; height:150px;"><?= $elenco_fisicas['observacoes']; ?></textarea></td>
  </tr>
  <tr>
    <td colspan="5" height="15"></td>
    </tr>
  <tr>
    <td colspan="5"><input type="hidden" name="id_elenco" id="id_elenco" value="<?= $id_elenco; ?>" />
		<input name="btnGravar" id="btnGravar" value="gravar" type="image" src="../img/bt_gravar.gif" />&nbsp;
		<input name="btnGravar" id="btnGravar" value="gravar e avan&ccedil;ar" type="image"  src="../img/bt_gravar_avancar.gif" /></td>
    </tr>
</table>
</form>

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
	// Fecha a conexao com o banco de dados
	desconectaBD($idconn);
?>

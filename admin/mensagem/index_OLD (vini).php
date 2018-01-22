<?php
	// Include dos arquivos de sistema e validacao
	include("../includes/valida_acesso_adm.php");
	include("../../sys/api/DataManipulation.php");
	include("../../sys/api/MagnetoElenco.php");
	include("../../sys/api/Basic.php");
	
	// Include do arquivo com o topo
	include("../includes/topo_adm.php");
	
	// Faz o tratamento da mensagem de confirmacao de envio
	$flag = $_GET['flag'];
	if($flag != ""){
		if(intval($flag) > 0) $mensagem_confirmacao = "<p style=\"margin-left:20px; color:#FF0000; font-weight:bold\">Envio de mensagem processado com sucesso para $flag destinatários</p>";
		else $mensagem_confirmacao = "<p style=\"margin-left:20px; color:#FF0000; font-weight:bold\">Falha no envio da mensagem.</p>";
	}
	else{
		$mensagem_confirmacao = "";
	}
?>

<img src="../img/tit_cursos.gif" width="126" height="68" class="tit" />
<?= $mensagem_confirmacao; ?>
<form name="form_emkt" method="post" action="/sys/send/envia_emailmkt.php">
<table width="70%" align="center" border="0" cellpadding="4" style="float:left; margin: 0px 0px 0px 10px;">
  <tr>
    <td valign="top">Assunto:</td>
    <td><input type="text" name="assunto" id="assunto" style="width:600px;" /></td>
  </tr> 
  <tr>
    <td valign="top">Título:</td>
    <td><input type="text" name="titulo" id="titulo" style="width:600px;" /></td>
  </tr>   
  <tr>
    <td valign="top">Mensagem:</td>
    <td><textarea name="mensagem" id="mensagem" style="width:600px; height:200px;"></textarea></td>
  </tr> 
  <tr>
    <td>&nbsp;</td>
    <td>
		<input name="brnGravar" type="image"  src="../img/bt_enviar.gif" id="brnGravar" />
	</td>
  </tr>
</table>
</form>

<form name="form_exportacao" method="post" action="/sys/run/exporta_mailing.php">
<table cellpadding="4" style="margin: 0px 0px 0px 20px; float:left;">
	<tr>
		<td>Exportar mailing</td>
	</tr>
	<tr>
		<td>
		<select name="separador">
			<option value="">Selecione o separador</option>
			<option value=";">ponto e vírgula</option>
			<option value=",">vírgula</option>
		</select>
		</td>
	</tr>
	<tr>
		<td><input name="brnOk" type="image"  src="../img/bt_ok.gif" id="brnOk" /></td>
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
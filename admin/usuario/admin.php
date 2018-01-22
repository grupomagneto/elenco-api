<?php
	// Include dos arquivos de sistema e validacao
	include("../includes/valida_acesso_adm.php");
	include("../../sys/api/DataManipulation.php");
	include("../../sys/api/Basic.php");

	// Include do arquivo com o topo
	include("../includes/topo_adm.php");

	// Chamada da funcao de conexao com o banco de dados
	$idconn = conectaBD();

	// Verifica se o formulario esta em modo de insercao ou edicao
	$id = $_GET['id'];
	if($id == ""){ // Modo de insercao
		$exibe_login = true;
		$label_botao = "gravar";
		$action_formulario = "/sys/insert/ins_admin.php";
	}
	else{ // Modo de edicao de senha
		$exibe_login = false;
		$label_botao = "alterar senha";
		$action_formulario = "/sys/update/up_admin_senha.php";
	}

	// Define as mensagens de confirmacao
	$msg = $_GET['msg'];
	switch($msg){
		 case 1:
		 	$mensagem_confirmacao = "<p>usu&aacute;rio cadastrado</p>";
			break;
		 case 2:
		 	$mensagem_confirmacao = "<p>Erro: o login informado j&aacute; existe</p>";
			break;
		 case 3:
		 	$mensagem_confirmacao = "<p>Erro: confirma&ccedil;&atilde;o de senha incorreta</p>";
			break;
		 case 4:
		 	$mensagem_confirmacao = "<p>senha alterada</p>";
			break;
		 default:
		 	$mensagem_confirmacao = "";
	}
?>

<img src="../img/tit_gerenciamento_usuarios.gif" width="488" height="68" class="tit" />

<?= $mensagem_confirmacao; ?>
<form name="admin" method="post" action="<?= $action_formulario; ?>">
<table width="790" border="0" cellpadding="4" class="tit">
<?
	if($exibe_login){
?>
  <tr>
    <td>Login:</td>
    <td><input name="login" type="text" id="login" style="width:200px;" maxlength="30" /></td>
  </tr>
  <tr>
    <td>Perfil:</td>
    <td>
	<?php echo montaCampoSelect("tb_tipo_admin", "cd_tipo_admin", "tipo_admin", "id_tipo_admin", 1, false, "id_tipo_admin", "width:200px;"); ?>
	</td>
  </tr>
<?
	}
?>
  <tr>
    <td>Senha:</td>
    <td><input name="senha" type="password" id="senha" style="width:200px;" maxlength="15" /></td>
  </tr>
  <tr>
    <td>Confirma&ccedil;&atilde;o de senha:</td>
    <td><input name="confirmacao_senha" type="password" id="confirmacao_senha" style="width:200px;" maxlength="15" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
	<input type="hidden" name="id" id="id" value="<?= $id; ?>" />
	<input name="btnGravar" type="submit" id="btnGravar" value="<?= $label_botao; ?>" />&nbsp;</td>
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
	// Chamada da funcao para desconexao com o banco de dados
	desconectaBD($idconn);
?>

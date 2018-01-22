<?
	$erro = $_GET['erro'];

	switch($erro){
		case 1:
			$mensagem = "<p>Dados inválidos</p>";
			break;
		default:
			$mensagem = "";
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Magneto Elenco - Área administrativa</title>
<link href="/magnetoelenco/admin/css/estilo.css" rel="stylesheet" type="text/css" />
</head>

<body onload="document.form_adm.login.focus();">


<div class="login_box">
<img src="img/logo_login.gif" width="410" height="92" />
<div class="login_tab">


<form name="form_adm" method="post" action="autentica_login_adm.php">
<table width="90%" align="center" border="0">
  <tr>
    <td width="50%">Login:</td>
    <td>Senha:</td>
  </tr>
  <tr>
    <td><input name="login" type="text" id="login" class="ipt"></td>
    <td><input name="senha" type="password" id="senha" class="ipt"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td style="color:#F00" align="center"><?= $mensagem ?></td>
    <td align="right"><input name="btn_logar" type="image" src="img/bt_acessar.gif" id="btn_logar" value="Acessar"></td>
  </tr>
</table>
</form>


</div>
</div>


</body>
</html>

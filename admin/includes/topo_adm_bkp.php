<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Magneto Elenco - Área administrativa</title>
<link href="/admin/css/admin.css" rel="stylesheet" type="text/css" />
<link href="/admin/css/admin_estilo.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/sys/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="/sys/js/admin.js"></script>
<script type="text/javascript" src="/admin/js/script.js"></script>
</head>
<body>

<table style="margin-top:20px; margin-bottom:40px;" align="center" width="990" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td rowspan="2"><img src="/admin/img/logo.gif" width="293" height="73" alt=""></td>
		<td align="right"><a href="/admin/logoff.php"><img src="/admin/img/bt_sair.gif" alt=""></a></td>
	</tr>
	<tr>
		<td height="42" width="697" valign="bottom">
        <a href="/admin/index.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('home','','/admin/img/mn_home_over.gif',1)"><img src="/admin/img/mn_home.gif" name="home" width="69" height="42" border="0" id="home" /></a><a href="/admin/elenco/index.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('elenco','','/admin/img/mn_elenco_over.gif',1)"><img src="/admin/img/mn_elenco.gif" name="elenco" width="77" height="42" border="0" id="elenco" /></a><a href="/admin/tabelas_tradicionais/index.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('tabs','','/admin/img/mn_tabs_over.gif',1)"><img src="/admin/img/mn_tabs.gif" name="tabs" width="81" height="42" border="0" id="tabs" /></a><a href="/admin/elenco/destaques_home.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('dest','','/admin/img/mn_destaque_over.gif',1)"><img src="/admin/img/mn_destaque.gif" name="dest" width="125" height="42" border="0" id="dest" /></a><a href="/admin/elenco/cursos.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('cursos','','/admin/img/mn_cursos_over.gif',1)"><img src="/admin/img/mn_cursos.gif" name="cursos" width="80" height="42" border="0" id="cursos" /></a><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('agenda','','/admin/img/mn_agenda_over.gif',1)"><img src="/admin/img/mn_agenda.gif" name="agenda" width="81" height="42" border="0" id="agenda" /></a><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('msn','','/admin/img/mn_mensagen_over.gif',1)"><img src="/admin/img/mn_mensagem.gif" name="msn" width="89" height="42" border="0" id="msn" /></a><?
	if($_SESSION['id_tipo_admin'] == 1){
	?><a href="/admin/usuario/index.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('usuarios','','/admin/img/mn_usuarios_over.gif',1)"><img src="/admin/img/mn_usuarios.gif" name="usuarios" width="88" height="42" border="0" id="usuarios" /></a><?
	}
	else{
		echo "&nbsp;";
	}
	?></td>
	</tr>
	<tr>
		<td colspan="2" bgcolor="#FFFFFF"><img src="/magnetoelenco/admin/img/menu_top.gif" width="990" height="18" alt=""></td>
	</tr>
	<tr>
	  <td colspan="2" bgcolor="#FFFFFF">


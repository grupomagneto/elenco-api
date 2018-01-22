<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Magneto Elenco - Área administrativa</title>
<link href="/magnetoelenco/admin/css/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/sys/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="/sys/js/admin.js"></script>
</head>
<body>
<table width="860" border="0" cellpadding="2">
  <tr>
    <td width="58"><a href="/magnetoelenco/admin/index.php">home</a></td>
    <td width="68"><a href="/magnetoelenco/admin/elenco/index.php">elenco</a></td>
    <td width="100"><a href="/magnetoelenco/admin/tabelas_tradicionais/index.php">tabelas tradicionais</a></td>
	<td width="100"><a href="/magnetoelenco/admin/elenco/destaques_home.php">destaques home</a></td>
	<td width="110"><a href="/magnetoelenco/admin/elenco/cursos.php">cursos</a></td>
    <td width="152">
	<?
	if($_SESSION['id_tipo_admin'] == 1){
	?>
	<a href="/magnetoelenco/admin/usuario/index.php">usu&aacute;rios</a>
	<?
	}
	else{
		echo "&nbsp;";
	}
	?>
	</td>
    <td width="80"><div align="right"><a href="/magnetoelenco/admin/logoff.php">sair</a></div></td>
  </tr>
</table>
<hr width="860" align="left" />

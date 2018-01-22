<?php
	// Include dos arquivos de sistema e validacao
	include("../includes/valida_acesso_adm.php");
	include("../../sys/api/DataManipulation.php");
	include("../../sys/api/MagnetoElenco.php");
	include("../../sys/api/Basic.php");
	include("../../sys/Model/Agenda.php");

	// Chamada da funcao de conexao com o banco de dados
	$idconn = conectaBD();
	
	// Verifica se o formulario foi acionado
	if(isset($_POST['btnBuscar'])){
		$busca_acionada = true;
		
		// Monta e executa a query de busca
		$chave_busca = limpaString($_POST['chave_busca']);
		$sql_busca = "select id_elenco, nome, nome_artistico from tb_elenco where nome like '%$chave_busca%' or nome_artistico like '%$chave_busca%' order by nome_artistico";
		$rs_busca = mysql_query($sql_busca);
		$total_resultados = mysql_num_rows($rs_busca);	
	}
	else{
		$busca_acionada = false;
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Agendamento</title>
<link href="../css/box_estilo.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form name="form_busca_agendamento" method="post">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr valign="bottom">
    <td width="15%"><img src="../img/tit_digite_nome_elenco.gif" width="201" height="15"></td>
    <td width="28%" valign="bottom"><input type="text" name="chave_busca" id="chave_busca" style="width:184px;"></td>
    <td width="57%">
	<input type="hidden" name="id_agenda" id="id_agenda" value="<?= id_agenda; ?>" />
	<input type="image" name="btnBuscar" value="buscar" src="../img/bt_ok.gif">
	</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
</table>
</form>

<?php
	if($busca_acionada){
		if($total_resultados > 0){
?>
<table width="100%" border="0" cellpadding="3" cellspacing="0" class="tab_cor">
  <tr bgcolor="#c3161c">
    <td width="33%" class="font_br">NOME</td>
    <td width="31%" class="font_br">NOME ART&Iacute;STICO</td>
    <td width="36%" class="font_br">A&Ccedil;&Atilde;O</td>
  </tr>
<?php
			$bg = "#f5f5f5";
			while($row = mysql_fetch_array($rs_busca)){
				$id_elenco      = $row['id_elenco'];
				$nome           = $row['nome'];
				$nome_artistico = $row['nome_artistico'];
				
				if($bg == "#f5f5f5") $bg = "";
				else $bg = "#f5f5f5";
?>  
  <tr bgcolor="<?= $bg; ?>">
    <td><?= $nome; ?></td>
    <td><?= $nome_artistico; ?></td>
    <td><a href="agendar.php?id_elenco=<?= $id_elenco; ?>">Selecionar</a></td>
  </tr>
<?php
			}
?>
</table>
<?php
		}
		else{
?>
<p>Nenhum registro encontrado.</p>
<?php
		}
	}
	else{
?>
<p>Busque pelo nome ou pelo nome art&iacute;stico.</p>
<?php
	}
?>

<p>&nbsp;</p>
</body>
</html>
<?php
	// Chamada da funcao para desconexao com o banco de dados
	desconectaBD($idconn);	
?>
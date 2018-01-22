<?php
	// Include dos arquivos de sistema e validacao
	include("../includes/valida_acesso_adm.php");
	include("../../sys/api/DataManipulation.php");

	// Include do arquivo com o topo
	include("../includes/topo_adm.php");
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="52%"><img src="../img/tit_elencos_cadastrados.gif" width="378" height="68" class="tit" /></td>
    <td width="48%">
<?php include("../mensagem/form_busca_elenco.php"); ?>

    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right"><a href="info_contato.php"><img src="../img/bt_cadastrar_novo_elenco.gif" width="217" height="68" class="cad_novo" /></a></td>
  </tr>
</table>
<?php
	// Chamada da funcao de conexao com o banco de dados
	$idconn = conectaBD();

	// Consulta o total de registros de elenco
	$sql_total = "select id_elenco from tb_elenco";
	$rs_total = mysql_query($sql_total);
	$total_registros = mysql_num_rows($rs_total);

	//define os parametros de paginaçao
	$tamanho_pagina = 20;
	$total_paginas = ceil($total_registros/$tamanho_pagina);

	$pagina = $_GET['pagina'];
	if(!$pagina){
		$pagina = 1;
		$inicio = 0;
	}
	else{
		$inicio = ($pagina - 1) * $tamanho_pagina;
	}

	//define a próxima página e a página anterior
	$exibe_paginacao = true;
	if($total_paginas <= 1){
		$exibe_paginacao = false;
	}
	else{
		if($pagina == 1){
			$next = $pagina + 1;
			$prev = NULL;
		}
		else{
			if($pagina < $total_paginas){
				$next = $pagina + 1;
				$prev = $pagina - 1;
			}
			else{
				$next = NULL;
				$prev = $pagina - 1;
			}
		}
	}

	// Define os parametros de ordenacao da lista
	if($_GET['ordenacao'] != "") $ordenacao = $_GET['ordenacao'];
	else $ordenacao = "nome";

	if($_GET['sentido'] != "") $sentido = $_GET['sentido'];
	else $sentido = "asc";

	// Define as setas de cada ordenacao
	if($ordenacao == "nome"){
		if($sentido == "asc"){
			$img_seta_nome     = "seta_abaixo.gif";
			$link_sentido_nome = "desc";
			$img_seta_artistico     = "seta_abaixo.gif";
			$link_sentido_artistico = "desc";
		}
		else{
			$img_seta_nome     = "seta_cima.gif";
			$link_sentido_nome = "asc";
			$img_seta_artistico     = "seta_abaixo.gif";
			$link_sentido_artistico = "desc";
		}
	}
	else{
		if($sentido == "asc"){
			$img_seta_artistico     = "seta_abaixo.gif";
			$link_sentido_artistico = "desc";
			$img_seta_nome     = "seta_abaixo.gif";
			$link_sentido_nome = "desc";
		}
		else{
			$img_seta_artistico     = "seta_cima.gif";
			$link_sentido_artistico = "asc";
			$img_seta_nome     = "seta_abaixo.gif";
			$link_sentido_nome = "desc";
		}
	}


	// Seleciona os registros de elenco da pagina atual
	$sql_elenco = "select id_elenco, nome, nome_artistico, email
				   from tb_elenco order by $ordenacao $sentido
				   limit $inicio, $tamanho_pagina";
	$rs_elenco = mysql_query($sql_elenco);

	if(mysql_num_rows($rs_elenco) > 0){
?>
<table width="98%" align="center" border="0" cellpadding="5" cellspacing="0">
  <tr bgcolor="#c3161c">
    <td class="font_br">
		<table>
			<tr>
				<td><a href="<? echo $_SERVER['PHP_SELF']."?ordenacao=nome&sentido=$link_sentido_nome&pagina=1"; ?>"><img src="/admin/img/<?= $img_seta_nome; ?>" border="0" /></a></td>
				<td class="font_br">NOME</td>
			</tr>
		</table>
	</td>
    <td class="font_br">
		<table>
			<tr>
				<td><a href="<? echo $_SERVER['PHP_SELF']."?ordenacao=nome_artistico&sentido=$link_sentido_artistico&pagina=1"; ?>"><img src="/admin/img/<?= $img_seta_artistico; ?>" border="0" /></a></td>
				<td class="font_br">NOME ARTÍSTICO</td>
			</tr>
		</table>
	</td>
	<td class="font_br">AÇÕES</td>
  </tr>
<?php
		while($row = mysql_fetch_array($rs_elenco)){
			$id_elenco      = $row['id_elenco'];
			$nome           = $row['nome'];
			$nome_artistico = $row['nome_artistico'];
			$email          = $row['email'];
?>
  <tr>
    <td><?= $nome; ?></td>
    <td><?= $nome_artistico; ?></td>
	<td><a href="info_contato.php?id_elenco=<?= $id_elenco; ?>">info contato</a> | <a href="caracteristicas_fisicas.php?id_elenco=<?= $id_elenco; ?>">carac f&iacute;sicas</a> | <a href="fotos_fotobook.php?id_elenco=<?= $id_elenco; ?>">fotobook</a> | <a href="fotos_portfolio.php?id_elenco=<?= $id_elenco; ?>">portfolio</a> | <a href="video.php?id_elenco=<?= $id_elenco; ?>">videobook</a> | <a href="videofolio.php?id_elenco=<?= $id_elenco; ?>">videofolio</a> | <a href="#a" onclick="javascript: confirmaExclusao('/sys/del/del_elenco.php?id_elenco=<?= $id_elenco; ?>');">excluir</a></td>
  </tr>
<?php
		}
?>
</table>
<?php
	}

	// Chamada da funcao para desconexao com o banco de dados
	desconectaBD($idconn);

	// Exibe o controle de paginacao
	if($exibe_paginacao){
?>
<br />
<hr width="98%" />

<table align="center" width="80%" border="0">
  <tr>
  	<td># p&aacute;gina <strong><?= $pagina; ?></strong> de <strong><?= $total_paginas; ?></strong></td>
    <td width="50">
		<?php
		if($pagina == 1){
		?>
		Primeira
		<?
		}
		else{
		?>
		<a href="<? echo $_SERVER['PHP_SELF']."?ordenacao=$ordenacao&sentido=$sentido&pagina=1"; ?>">Primeira</a>
		<?php
		}
		?>
	</td>
    <td width="60"><?php
		if(!is_null($prev)){
		?>
			<a href="<? echo $_SERVER['PHP_SELF']."?ordenacao=$ordenacao&sentido=$sentido&pagina=".$prev; ?>"><< anterior</a>
		<?php
		}
		else{
			echo "<< anterior";
		}
		?></td>
    <td align="center">
		<?php
		for($i = 1; $i <= $total_paginas; $i++){
			if($i == $pagina) $print_i = "<strong>[$i]</strong>";
			else $print_i = "$i";
		?>
			<a href="<? echo $_SERVER['PHP_SELF']."?ordenacao=$ordenacao&sentido=$sentido&pagina=".$i; ?>"><?= $print_i; ?></a>
		<?php
		}
		?>
	</td>
    <td width="60"><?php
		if(!is_null($next)){
		?>
			<a href="<? echo $_SERVER['PHP_SELF']."?ordenacao=$ordenacao&sentido=$sentido&pagina=".$next; ?>">pr&oacute;xima >></a>
		<?php
		}
		else{
			echo "pr&oacute;xima >>";
		}
		?></td>
    <td width="50">
		<?php
		if($pagina == $total_paginas){
		?>
		Última
		<?
		}
		else{
		?>
		<a href="<? echo $_SERVER['PHP_SELF']."?ordenacao=$ordenacao&sentido=$sentido&pagina=$total_paginas"; ?>">Última</a>
		<?php
		}
		?>
	</td>
  </tr>
</table>



<?php
	}
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

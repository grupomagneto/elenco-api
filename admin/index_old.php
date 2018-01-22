<?php
	//Include dos arquivos de sistema e validacao
	include("includes/valida_acesso_adm.php");
	include("../sys/api/Basic.php");
	include("../sys/api/DataManipulation.php");
	
	//Include do arquivo com o topo
	include("includes/topo_adm.php");
	
	// Chamada da funcao de conexao com o banco de dados
	$idconn = conectaBD();	
?>
<link rel="stylesheet" href="box/jquery.modal.css" media="screen,projection" type="text/css" />
<script type="text/javascript" src="box/jquery.js"></script>
<script type="text/javascript" src="box/modal.js"></script>
<script type="text/javascript">
	function setEnderecoModal(id_elenco){
		var obj_janela = document.getElementById('janela_agendamento');
		obj_janela.src = "/admin/elenco/agendar.php?id_elenco="+id_elenco;
	}
</script>
      
<img src="img/tit_seja_bemvindo.gif" width="257" height="68" class="tit" /><br /><br />
     
<div class="home_pad">
     
<!-- primeira tabela  reconvocar novas fotos -->
<?php
	// Define a validade das fotos em dias (6 meses menos 10 dias)
	$validade_fotos = (6 * 30) - 10;
	
	// Seleciona os registros de elenco fotos vencidas
	$sql_fotos_vencidas = "select distinct id_elenco, nome, nome_artistico, email, tl_celular, dias_passados 
				           from vw_vencimento_foto 
						   where dias_passados > $validade_fotos
						   and id_elenco not in (select distinct cd_elenco from tb_agenda where dh_agendamento > CURDATE())
						   order by dias_passados desc, nome";
	
	$sql_fotos_vencidas = "	SELECT DISTINCT id_elenco, nome, nome_artistico, email, tl_celular, dias_passados
							FROM vw_vencimento_foto
							LEFT JOIN (
								SELECT	cd_elenco
								FROM tb_agenda
								WHERE tb_agenda.dh_agendamento > NOW()
								GROUP BY tb_agenda.cd_elenco
							) AS agenda ON agenda.cd_elenco <> vw_vencimento_foto.id_elenco
							WHERE dias_passados > $validade_fotos
							ORDER BY dias_passados DESC, nome";
	$rs_fotos_vencidas = mysql_query($sql_fotos_vencidas);
	
?>
<table width="100%" border="0" cellpadding="3" cellspacing="0" class="tab_cor">
  <tr>
    <td colspan="3" class="pln"><img src="img/tit_reconvocar_foto.gif" width="291" height="50" /></td>
  </tr>
<?php
	if(mysql_num_rows($rs_fotos_vencidas) > 0){
?>  
  <tr bgcolor="#c3161c">
    <td width="30%" class="font_br">NOME</td>
    <td width="20%" class="font_br">NOME ARTÍSTICO</td>
	<td width="15%" class="font_br">CELULAR</td>
    <td width="15%" class="font_br">AÇÃO</td>
  </tr>
<?php
		$bgcolor="#f5f5f5";
		while($row = mysql_fetch_array($rs_fotos_vencidas)){
			$id_elenco      = $row['id_elenco'];
			$nome           = $row['nome'];
			$nome_artistico = $row['nome_artistico'];
			$dh_cadastro    = $row['dh_cadastro'];
			$tl_celular     = $row['tl_celular'];
			
			if($bgcolor == "#f5f5f5") $bgcolor = "";
			else $bgcolor = "#f5f5f5";			
?>  
  <tr bgcolor="<?= $bgcolor; ?>">
    <td><?= $nome; ?></td>
    <td><?= $nome_artistico; ?></td>
	<td><?= $tl_celular; ?></td>
    <td><a href="#" onclick="setEnderecoModal(<?= $id_elenco; ?>); $('.modal2').modalToggle(); return false;">Agendar nova foto</a></td>
  </tr>
<?php
		}
	}
	else{
?>
	<tr>
		<td colspan="4">Nenhum perfil com fotos vencidas.</td>
	</tr>
<?php
	}
?>
</table>
<!-- fim primeira tabela  reconvocar novas fotos -->


<!-- segunda tabela reconvocar novo contrato  -->
<?php
	// Define a validade do contrato em dias (23 meses)
	$validade_contrato = (23 * 30);
	
	// Seleciona os registros de elenco fotos vencidas
	$sql_contrato = "select id_elenco, nome, nome_artistico, email, tl_celular 
					 from tb_elenco 
					 where TO_DAYS(NOW()) - TO_DAYS(dt_validade_contrato) > $validade_contrato
					 order by dt_validade_contrato desc";
	$rs_contrato = mysql_query($sql_contrato);
?>
<table width="100%" border="0" cellpadding="3" cellspacing="0" class="tab_cor">
  <tr>
    <td colspan="3" class="pln"><img src="img/tit_reconvocar_contrato.gif" width="291" height="50" /></td>
  </tr>
<?php
	if(mysql_num_rows($rs_contrato) > 0){
?>  
  <tr bgcolor="#c3161c">
    <td width="25%" class="font_br">NOME</td>
    <td width="20%" class="font_br">NOME ARTÍSTICO</td>
	<td width="15%" class="font_br">CELULAR</td>
    <td width="40%" class="font_br">AÇÃO</td>
  </tr>
<?php
		$bgcolor="#f5f5f5";
		while($row = mysql_fetch_array($rs_contrato)){
			$id_elenco      = $row['id_elenco'];
			$nome           = $row['nome'];
			$nome_artistico = $row['nome_artistico'];
			$dh_cadastro    = $row['dh_cadastro'];
			$tl_celular     = $row['tl_celular'];
			
			if($bgcolor == "#f5f5f5") $bgcolor = "";
			else $bgcolor = "#f5f5f5";			
?>    
  <tr bgcolor="<?= $bgcolor; ?>">
    <td><?= $nome; ?></td>
    <td><?= $nome_artistico; ?></td>
	<td><?= $tl_celular; ?></td>
    <td>Nova data de contrato: <input class="ipth"></input> <input type="submit" value="Gravar" class="ipt_gravar" ></input></td>
  </tr>
<?php
		}
	}
	else{
?>
	<tr>
		<td colspan="4">Nenhum contrato vencido.</td>
	</tr>
<?php
	}
?>
</table>
<!-- fim segunda tabela reconvocar novo contrato -->


<!-- terceira tabela perfis não publicados  -->
<?php
	// Seleciona os registros de elenco nao publicados
	$sql_nao_publicados = "select id_elenco, nome, nome_artistico, email, tl_celular 
				           from tb_elenco 
						   where publicado = 0
						   order by dt_insercao";
	$rs_nao_publicados = mysql_query($sql_nao_publicados);
?>
<table width="100%" border="0" cellpadding="3" cellspacing="0" class="tab_cor">
  <tr>
    <td colspan="3" class="pln"><img src="img/tit_perfis_npublicados.gif" width="197" height="50" /></td>
  </tr>
<?php
	if(mysql_num_rows($rs_nao_publicados) > 0){
?>  
  <tr bgcolor="#c3161c">
    <td width="27%" class="font_br">NOME</td>
    <td width="32%" class="font_br">NOME ARTÍSTICO</td>
    <td width="41%" class="font_br">AÇÃO</td>
  </tr>
<?php
		$bgcolor="#f5f5f5";
		while($row = mysql_fetch_array($rs_nao_publicados)){
			$id_elenco      = $row['id_elenco'];
			$nome           = $row['nome'];
			$nome_artistico = $row['nome_artistico'];
			$email          = $row['email'];
			
			if($bgcolor == "#f5f5f5") $bgcolor = "";
			else $bgcolor = "#f5f5f5";			
?>  
  <tr bgcolor="<?= $bgcolor; ?>">
    <td><?= $nome; ?></td>
    <td><?= $nome_artistico; ?></td>
    <td><a href="/admin/elenco/info_contato.php?id_elenco=<?= $id_elenco; ?>">Ver detalhe</a></td>
  </tr>
<?php
		}
	}
	else{
?>
	<tr>
		<td colspan="4">Nenhum perfil não publicado.</td>
	</tr>
<?php
	}
?>
</table>
<!-- fim terceira tabela perfis não publicados -->
      
</div>

<!-- lightbox agendar -->
<div class="modal2 mod_remarcar">
	<a href="#" onclick="$('.modal2').modalToggle(); return false;"><img src="img/bt_fechar.gif" class="fechar_a"></a>
    <div class="mod_remarcar_txt">
  	<iframe id="janela_agendamento" width="720" height="380" frameborder="0"></iframe>
    </div>
</div>
<!-- fim lightbox agendar -->  

 <!-- final -->
 </td>
  </tr>
	<tr>
	  <td colspan="2" bgcolor="#FFFFFF"><img src="/admin/img/menu_pe.gif" width="990" height="26"></td>
  </tr>
</table>
</body>
</html>
<?php
	// Chamada da funcao para desconexao com o banco de dados
	desconectaBD($idconn);
?>
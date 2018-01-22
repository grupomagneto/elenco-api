<?php
	// Include dos arquivos de sistema e validacao
	include("../includes/valida_acesso_adm.php");
	include("../../sys/api/DataManipulation.php");
	include("../../sys/api/MagnetoElenco.php");
	include("../../sys/api/Basic.php");
	include("../../sys/api/Calendario.php");
	include("../../sys/Model/Agenda.php");
	
	// Include do arquivo com o topo
	include("../includes/topo_adm.php");
	
	// Chamada da funcao de conexao com o banco de dados
	$idconn = conectaBD();
	
	// Instancia o objeto calendario
	$calendario = new calendario;
	$calendario->pagina_link = "/admin/elenco/agenda.php?";
	
	// Recebe a data selecionada e formata a data por extenso
	$data_selecionada = $_GET["data"];
	if($data_selecionada == "") $data_selecionada = date("d/m/Y");
	$data_formatada = formataDataBanco($data_selecionada);
	
	$feriado = $calendario->getFeriado(date('d',strtotime($data_formatada)),date('m',strtotime($data_formatada)));
	
	$stamp = strtotime($data_formatada);
	switch(date("w", $stamp)){
		case 0:
			$dia_semana = "domingo";
			break;
		case 1:
			$dia_semana = "segunda";
			break;
		case 2:
			$dia_semana = "terça";
			break;
		case 3:
			$dia_semana = "quarta";
			break;
		case 4:
			$dia_semana = "quinta";
			break;
		case 5:
			$dia_semana = "sexta";
			break;
		case 6:
			$dia_semana = "sábado";
			break;
	}
	$digito_dia = date("d", $stamp);
	$nome_mes   = $calendario->getNomeMes(date("m", $stamp));
	$digito_ano = date("Y", $stamp);
	$data_extenso = "$dia_semana, $digito_dia de $nome_mes de $digito_ano";
	
	// Define o proximo dia e o dia anterior
	$proximo_dia  = dateAdd($data_formatada, 1);
	$anterior_dia = dateAdd($data_formatada, -1);
	
	// Verifica se o dia foi cancelado
	if(Agenda::verificaCancelamento($data_formatada)) $dia_cancelado = true;
	else $dia_cancelado = false;
?>
<link rel="stylesheet" href="../box/jquery.modal.css" media="screen,projection" type="text/css" />
<link rel="stylesheet" href="/css/calendario.css" type="text/css" />
<script type="text/javascript" src="../box/jquery.js"></script>
<script type="text/javascript" src="../box/modal.js"></script>
<script type="text/javascript">
	function setEnderecoModal(id_agenda){
		if(id_agenda != ''){
			var obj_janela = document.getElementById('janela_reagendamento');
			obj_janela.src = "reagendar.php?id_agenda="+id_agenda;
		}
		else{
			var obj_janela = document.getElementById('janela_agendamento');
			obj_janela.src = "pre_remarcar.php";
		}
	}
</script>

<!-- inicio conteudo -->

<img src="../img/tit_agenda.gif" width="140" height="68" class="tit" /><br /><br />

<!-- coluna A com calendario -->
<div class="coluna_a">
<table width="155" border="0" cellspacing="0">
  <tr>
    <td colspan="3">
	<?php
	$calendario->cria($data_selecionada);	
	?>
	</td>
    </tr>
</table>
</div>
<!-- coluna A com calendario fim -->

<!-- coluna B com dados -->
<div class="coluna_b">

<table width="100%" border="0" cellspacing="0">
  <tr>
    <td colspan="3" height="40" align="right">
	<?php
	if($dia_cancelado){
	?>
		<a href="#a" onclick="javascript: confirmaReativamentoDia('/sys/run/reativa_dia_agenda.php?data=<?= $data_selecionada; ?>');"><img src="../img/bt_reativar_dia.gif" width="160" height="33" /></a>
	<?php
	}
	else{
	?>
		<a href="#a" onclick="javascript: confirmaCancelamentoDia('/sys/run/cancela_dia_agenda.php?data=<?= $data_selecionada; ?>');"><img src="../img/bt_cancelar_dia.gif" width="160" height="33" /></a>	
	<?php
	}
	?>
		<a href="imprimir_agenda_dia.php?data=<?= $data_selecionada; ?>" target="_blank"><img src="../img/bt_imprimir_dia.gif" width="160" height="33" class="tit" /></a>
	</td>
    </tr>
  <tr bgcolor="#b3141a">
    <td width="25"><a href="?data=<?= formataData($anterior_dia); ?>"><img src="../img/seta_esq.gif" width="25" height="22" /></a></td>
    <td  align="center" class="font_br" style="text-transform:uppercase;"><?= $data_extenso ?></td>
    <td width="25" align="right"><a href="?data=<?= formataData($proximo_dia); ?>"><img src="../img/seta_dir.gif" width="25" height="22" /></a></td>
  </tr>
</table>

<?php
	if($dia_cancelado){
?>
<p style="text-transform:uppercase; font-weight:bold;">Dia cancelado</p>
<?php
	}else if($dia_semana == 'domingo'){
?>
<p style="text-transform:uppercase; font-weight:bold;"><?php echo ucwords($dia_semana);?> é um dia que não se trabalha</p>
<?php
	}else if($feriado){
?>
<p style="text-transform:uppercase; font-weight:bold;"><?php echo ucwords($feriado);?> é um dia que não se trabalha</p>
<?php
	}else{
?>
<table width="100%" border="0" cellpadding="3" cellspacing="0" class="tab_cor">
  <tr bgcolor="#c3161c">
    <td width="12%" class="font_br">HORÁRIO</td>
    <td width="52%" class="font_br">NOME ARTÍSTICO</td>
    <td width="36%" class="font_br">AÇÕES</td>
  </tr>
<?php
		$horario_agendamento = "$data_formatada 08:45:00";
		$bgcolor="#f5f5f5";
		for($i = 0; $i < 40; $i++){
			$horario_agendamento = Agenda::proximoHorario($horario_agendamento, 15);
			if($bgcolor == "#f5f5f5") $bgcolor = "";
			else $bgcolor = "#f5f5f5";
			
			// Consulta se existe agendamento para o horario
			$agendamento = Agenda::consultaAgendamentoPorHorario($horario_agendamento);
			if($agendamento){
				if($agendamento->cd_status_elenco == 1) $agendamento->nome_artistico = "Pré-cadastro - ".$agendamento->nome;
?>  
  <tr bgcolor="<?= $bgcolor; ?>">
    <td><?= formataHora($horario_agendamento); ?></td>
    <td><?= $agendamento->nome_artistico; ?></td>
    <td><a href="#" onclick="setEnderecoModal(<?= $agendamento->getIdAgenda(); ?>); $('.modal').modalToggle(); return false;">remarcar</a> | <a href="info_contato.php?id_elenco=<?= $agendamento->cd_elenco; ?>">editar elenco</a> | <a href="#a" onclick="javascript: confirmaExclusao('/sys/del/del_agenda.php?data=<?= $data_selecionada; ?>&id_agenda=<?= $agendamento->getIdAgenda(); ?>');">excluir agendamento</a></td>
  </tr>
<?php
			}
			else{
?>
  <tr bgcolor="<?= $bgcolor; ?>">
    <td><?= formataHora($horario_agendamento); ?></td>
    <td><a href="#" onclick="setEnderecoModal(''); $('.modal2').modalToggle(); return false;">Horário livre - clique para agendar horário</a></td>
    <td>&nbsp;</td>
  </tr>
<?php
			}
		}
?>

</table>
<?php
	}
?>
</div>
<!-- coluna B com dados fim -->


<!-- lightbox remarcar -->
<div class="modal mod_agendar">
	<a href="#" onclick="$('.modal').modalToggle(); return false;"><img src="../img/bt_fechar.gif" class="fechar_a"></a>
	<div class="mod_agendar_txt">
	<iframe id="janela_reagendamento" width="720" height="330" frameborder="0"></iframe>
	</div>
</div>
<!-- fim lightbox remarcar -->

<!-- lightbox agendar -->
<div class="modal2 mod_remarcar">
	<a href="#" onclick="$('.modal2').modalToggle(); return false;"><img src="../img/bt_fechar.gif" class="fechar_a"></a>
    <div class="mod_remarcar_txt">
  	<iframe id="janela_agendamento" width="720" height="380" frameborder="0"></iframe>
    </div>
</div>
<!-- fim lightbox agendar -->  

<!-- fim conteudo -->
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
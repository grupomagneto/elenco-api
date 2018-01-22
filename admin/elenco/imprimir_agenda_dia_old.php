<?php
	// Include dos arquivos de sistema e validacao
	include("../includes/valida_acesso_adm.php");
	include("../../sys/api/DataManipulation.php");
	include("../../sys/api/MagnetoElenco.php");
	include("../../sys/api/Basic.php");
	include("../../sys/api/Calendario.php");
	include("../../sys/Model/Agenda.php");
	
	// Chamada da funcao de conexao com o banco de dados
	$idconn = conectaBD();
	
	// Instancia o objeto calendario
	$calendario = new calendario;
	$calendario->pagina_link = "/admin/elenco/agenda.php?";
	
	// Recebe a data selecionada e formata a data por extenso
	$data_selecionada = $_GET["data"];
	$data_formatada = formataDataBanco($data_selecionada);
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Magento Elenco</title>
<link rel="stylesheet" type="text/css" href="../css/print.css"/>
</head>
<body>
<table width="100%" border="0">
  <tr>
    <td><img src="../img/tit_agenda_dia.gif" width="257" height="68" /></td>
    <td align="right"><img src="../img/logo_print.gif" width="257" height="68" /></td>
  </tr>

</table>




<div class="dia_atual"><?= $data_extenso; ?></div>

<table width="100%" border="0" cellpadding="3" cellspacing="0" class="tab_cor">
  <tr bgcolor="#c3161c">
    <td width="15%" class="font_br">HORÁRIO</td>
    <td width="27%" class="font_br">NOME</td>
    <td width="35%" class="font_br">NOME ARTÍSTICO</td>
    <td width="23%" class="font_br">TELEFONE</td>
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
		if($agendamento->cd_status_elenco == 1) $agendamento->nome_artistico = "Pré-cadastro";
?>  
  <tr bgcolor="<?= $bgcolor; ?>">
    <td><?= formataHora($horario_agendamento); ?></td>
    <td><?= $agendamento->nome; ?></td>
    <td><?= $agendamento->nome_artistico; ?></td>
    <td><?= $agendamento->tl_celular; ?></td>
  </tr>
<?php
	}
?>
</table>

</body>
</html>
<?php
	// Chamada da funcao para desconexao com o banco de dados
	desconectaBD($idconn);	
?>
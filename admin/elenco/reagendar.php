<?php
	// Include dos arquivos de sistema e validacao
	include("../includes/valida_acesso_adm.php");
	include("../../sys/api/DataManipulation.php");
	include("../../sys/api/MagnetoElenco.php");
	include("../../sys/api/Basic.php");
	include("../../sys/api/Calendario.php");
	include("../../sys/Model/Agenda.php");

	// Recebe o id do agendamento que será modificado
	$id_agenda = intval($_GET['id_agenda']);
	if($id_agenda == "") header("Location: reagendar_confirmacao.php?flag=1");

	// Chamada da funcao de conexao com o banco de dados
	$idconn = conectaBD();

	// Instancia o objeto calendario
	$calendario = new calendario;
	$calendario->pagina_link = "/magnetoelenco/admin/elenco/reagendar.php?id_agenda=$id_agenda&";

	// Recebe a data selecionada e formata a data por extenso
	$data_selecionada = $_GET["data"];
	if($data_selecionada == "") $data_selecionada = date("d/m/Y");
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

	// Define o proximo dia e o dia anterior
	$proximo_dia  = dateAdd($data_formatada, 1);
	$anterior_dia = dateAdd($data_formatada, -1);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Magneto Elenco - Reagendamento</title>
<link href="../css/box_estilo.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="/css/calendario.css" type="text/css" />

<script type="text/javascript" src="/sys/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="/sys/js/agenda.js"></script>

</head>

<body>

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
  <tr bgcolor="#b3141a">
    <td width="25"><a href="?id_agenda=<?= $id_agenda; ?>&data=<?= formataData($anterior_dia); ?>"><img src="../img/seta_esq.gif" width="25" height="22" /></a></td>
    <td  align="center" class="font_br" style="text-transform:uppercase;"><?= $data_extenso ?></td>
    <td width="25" align="right"><a href="?id_agenda=<?= $id_agenda; ?>&data=<?= formataData($proximo_dia); ?>"><img src="../img/seta_dir.gif" width="25" height="22" /></a></td>
  </tr>
</table><br>

<!--  coluna 1 -->
<div class="box">
<ul class="tempo">
<?php
	$horario_agendamento = "$data_formatada 08:45:00";
	for($i = 0; $i < 11; $i++){
		$horario_agendamento = Agenda::proximoHorario($horario_agendamento, 15);

		// Consulta se existe agendamento para o horario
		$agendamento = Agenda::consultaAgendamentoPorHorario($horario_agendamento);
		if($agendamento){
?>
	<li class="ocupado"><?= formataHora($horario_agendamento); ?></li>
<?php
		}
		else{
?>
	<li class="selecionar" id="<?= formataHora($horario_agendamento); ?>"><a href="#a" onClick="selecionaHorario('<?= formataHora($horario_agendamento); ?>');"><?= formataHora($horario_agendamento); ?></a></li>
<?php
		}
	}
?>
</ul>
</div>
<!--  coluna 1 fim -->

<!--  coluna 2  -->
<div class="box">
<ul class="tempo">
<?php
	$horario_agendamento = "$data_formatada 13:45:00";
	for($i = 0; $i < 11; $i++){
		$horario_agendamento = Agenda::proximoHorario($horario_agendamento, 15);

		// Consulta se existe agendamento para o horario
		$agendamento = Agenda::consultaAgendamentoPorHorario($horario_agendamento);
		if($agendamento){
?>
	<li class="ocupado"><?= formataHora($horario_agendamento); ?></li>
<?php
		}
		else{
?>
	<li class="selecionar" id="<?= formataHora($horario_agendamento); ?>"><a href="#a" onClick="selecionaHorario('<?= formataHora($horario_agendamento); ?>');"><?= formataHora($horario_agendamento); ?></a></li>
<?php
		}
	}
?>
</ul>
</div>
<!--  coluna 2 fim -->

<!--  coluna 3 -->
<div class="box nada">
<div class="box">
<ul class="tempo">
<?php
	$horario_agendamento = "$data_formatada 16:30:00";
	for($i = 0; $i < 8; $i++){
		$horario_agendamento = Agenda::proximoHorario($horario_agendamento, 15);

		// Consulta se existe agendamento para o horario
		$agendamento = Agenda::consultaAgendamentoPorHorario($horario_agendamento);
		if($agendamento){
?>
	<li class="ocupado"><?= formataHora($horario_agendamento); ?></li>
<?php
		}
		else{
?>
	<li class="selecionar" id="<?= formataHora($horario_agendamento); ?>"><a href="#a" onClick="selecionaHorario('<?= formataHora($horario_agendamento); ?>');"><?= formataHora($horario_agendamento); ?></a></li>
<?php
		}
	}
?>
</ul>
</ul>
</div>
<!--  coluna 3 fim -->


</div>
<!-- coluna B com dados fim -->
<div class="lmp"></div>

<div class="btr">
<form name="form_reagendar" id="form_reagendar" method="post" action="/magnetoelenco/sys/update/up_agenda_horario.php">
	<input type="hidden" name="id_agenda" id="id_agenda" value="<?= $id_agenda; ?>" />
	<input type="hidden" name="novo_horario" id="novo_horario" />
	<input type="hidden" name="novo_dia" id="novo_dia" value="<?= $data_formatada; ?>" />
	<input type="image" src="../img/bt_remarcar.gif" width="160" height="33" />
</form>
</div>
</body>
</html>
<?php
	// Chamada da funcao para desconexao com o banco de dados
	desconectaBD($idconn);
?>

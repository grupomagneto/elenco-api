<?php
header("Content-type: text/html; charset=ISO-8859-15");
include("conecta.php");
session_start();
	date_default_timezone_set('America/Sao_Paulo');
	$hora = date('H:i');
	$input = $_POST['comparecimento_post'];
	$pieces = explode("-", $input);
	$novo_comparecimento 		= $pieces[0];
	$id 						= $pieces[1];
	$sql_in = "SELECT * FROM novo_cadastro LEFT OUTER JOIN nova_agenda ON novo_cadastro.id_elenco = nova_agenda.id_elenco_agenda LEFT OUTER JOIN financeiro ON novo_cadastro.id_elenco = financeiro.id_elenco_financeiro WHERE id_elenco = '$id'";
	$result = mysqli_query($link, $sql_in);
		while ($row = mysqli_fetch_array($result)) {
			$comparecimento				= $row['comparecimento'];
			$hora_chegada				= $row['hora_chegada'];
			$tipo_cadastro_efetivado	= $row['tipo_cadastro_efetivado'];
		}
	if ($novo_comparecimento != 'Sim' && $tipo_cadastro_efetivado == NULL) {
		if ($comparecimento == NULL && $hora_chegada == NULL) {
			$sql = "UPDATE nova_agenda SET comparecimento = '$novo_comparecimento', hora_chegada = '$hora' WHERE id_elenco_agenda = '$id'";
			$sql2 = "UPDATE novo_cadastro SET tipo_cadastro_efetivado = 'Cancelado' WHERE id_elenco = '$id'";
		} elseif ($comparecimento != NULL && $hora_chegada != NULL) {
			$sql = "UPDATE nova_agenda SET comparecimento = REPLACE(comparecimento,'$comparecimento','$novo_comparecimento'), hora_chegada = REPLACE(hora_chegada,'$hora_chegada','$hora') WHERE id_elenco_agenda = '$id'";
			$sql2 = "UPDATE novo_cadastro SET tipo_cadastro_efetivado = 'Cancelado' WHERE id_elenco = '$id'";
		}
	} elseif ($novo_comparecimento != 'Sim' && $tipo_cadastro_efetivado != NULL) {
		if ($comparecimento == NULL && $hora_chegada == NULL) {
			$sql = "UPDATE nova_agenda SET comparecimento = '$novo_comparecimento', hora_chegada = '$hora' WHERE id_elenco_agenda = '$id'";
			$sql2 = "UPDATE novo_cadastro SET tipo_cadastro_efetivado = REPLACE(tipo_cadastro_efetivado,'$tipo_cadastro_efetivado','Cancelado') WHERE id_elenco = '$id'";
		} elseif ($comparecimento != NULL && $hora_chegada != NULL) {
			$sql = "UPDATE nova_agenda SET comparecimento = REPLACE(comparecimento,'$comparecimento','$novo_comparecimento'), hora_chegada = REPLACE(hora_chegada,'$hora_chegada','$hora') WHERE id_elenco_agenda = '$id'";
			$sql2 = "UPDATE novo_cadastro SET tipo_cadastro_efetivado = REPLACE(tipo_cadastro_efetivado,'$tipo_cadastro_efetivado','Cancelado') WHERE id_elenco = '$id'";
		}
	} elseif ($novo_comparecimento == 'Sim') {
		if ($comparecimento == NULL && $hora_chegada == NULL) {
			$sql = "UPDATE nova_agenda SET comparecimento = '$novo_comparecimento', hora_chegada = '$hora' WHERE id_elenco_agenda = '$id'";
		} elseif ($comparecimento != NULL && $hora_chegada != NULL) {
			$sql = "UPDATE nova_agenda SET comparecimento = REPLACE(comparecimento,'$comparecimento','$novo_comparecimento'), hora_chegada = REPLACE(hora_chegada,'$hora_chegada','$hora') WHERE id_elenco_agenda = '$id'";
		}
	}
	mysqli_query($link, $sql);
	if (isset($sql2)){
		mysqli_query($link, $sql2);
	}
	header("Location: mais_info.php?info=$id");
	mysqli_close($link);
?>
		
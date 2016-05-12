<?php
header("Content-type: text/html; charset=ISO-8859-15");
include("conecta.php");
session_start();
	date_default_timezone_set('America/Sao_Paulo');
	$hora = date('H:i');
	$hoje = date('Y-m-d', time());
	$input = $_POST['tipo_cadastro_efetivado_post'];
	$pieces = explode("-", $input);
	$novo_tipo_cadastro_efetivado	= $pieces[0];
	$id 							= $pieces[1];
	$sql_in = "SELECT * FROM novo_cadastro LEFT OUTER JOIN nova_agenda ON novo_cadastro.id_elenco = nova_agenda.id_elenco_agenda LEFT OUTER JOIN financeiro ON novo_cadastro.id_elenco = financeiro.id_elenco_financeiro WHERE id_elenco = '$id'";
	$result = mysqli_query($link, $sql_in);
		while ($row = mysqli_fetch_array($result)) {
			$nome 		= $row[1];
			$sobrenome 	= $row[2];
			$data_venda = $row['data_venda'];
			$tipo_cadastro_efetivado = $row['tipo_cadastro_efetivado'];
		}
		if ($tipo_cadastro_efetivado == NULL) {
			$sql = "UPDATE novo_cadastro SET tipo_cadastro_efetivado = '$novo_tipo_cadastro_efetivado' WHERE id_elenco = '$id'";
		} elseif ($tipo_cadastro_efetivado != NULL) {
			$sql = "UPDATE novo_cadastro SET tipo_cadastro_efetivado = REPLACE(tipo_cadastro_efetivado,'$tipo_cadastro_efetivado','$novo_tipo_cadastro_efetivado') WHERE id_elenco = '$id'";
		}
		if ($row['id_elenco_financeiro'] == NULL) {
			$sql2 = "INSERT INTO financeiro (tipo_entrada, nome, sobrenome, id_elenco_financeiro, qtd, data_venda) VALUES ('Venda', '$nome', '$sobrenome', '$id', 1, '$hoje')";
			mysqli_query($link, $sql2);
		} elseif ($row['id_elenco_financeiro'] != NULL && $data_venda != NULL){
			$sql2 = "UPDATE financeiro SET data_venda = REPLACE(data_venda,'$data_venda','$hoje') WHERE id_elenco = '$id'";
			mysqli_query($link, $sql2);
		}
	mysqli_query($link, $sql);
	header("Location: mais_info.php?info=$id");
	mysqli_close($link);
?>
		
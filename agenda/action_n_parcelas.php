<?php
header("Content-type: text/html; charset=ISO-8859-15");
include("conecta.php");
session_start();
	$input = $_POST['n_parcelas_post'];
	$pieces = explode("-", $input);
	$novo_n_parcelas			= $pieces[0];
	$id 					= $pieces[1];
	$sql_in = "SELECT * FROM novo_cadastro LEFT OUTER JOIN nova_agenda ON novo_cadastro.id_elenco = nova_agenda.id_elenco_agenda LEFT OUTER JOIN financeiro ON novo_cadastro.id_elenco = financeiro.id_elenco_financeiro WHERE id_elenco = '$id'";
	$result = mysqli_query($link, $sql_in);
		while ($row = mysqli_fetch_array($result)) {
			if ($row['id_elenco_financeiro'] != NULL) {
				$n_parcelas = $row['n_parcelas'];
				}
				if ($n_parcelas == NULL) {
					$sql = "UPDATE financeiro SET n_parcelas = '$novo_n_parcelas' WHERE id_elenco_financeiro = '$id'";
				} elseif ($n_parcelas != NULL) {
					$sql = "UPDATE financeiro SET n_parcelas = REPLACE(n_parcelas,'$n_parcelas','$novo_n_parcelas') WHERE id_elenco_financeiro = '$id'";
				}
			}
	mysqli_query($link, $sql);
	header("Location: mais_info.php?info=$id");
	mysqli_close($link);
?>
		
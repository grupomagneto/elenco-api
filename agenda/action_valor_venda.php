<?php
header("Content-type: text/html; charset=ISO-8859-15");
include("conecta.php");
session_start();
	$id 				= $_SESSION['id'];
	$novo_valor_venda	= $_POST['valor_venda_post'];
	$sql_in = "SELECT * FROM novo_cadastro LEFT OUTER JOIN nova_agenda ON novo_cadastro.id_elenco = nova_agenda.id_elenco_agenda LEFT OUTER JOIN financeiro ON novo_cadastro.id_elenco = financeiro.id_elenco_financeiro WHERE id_elenco = '$id'";
	$result = mysqli_query($link, $sql_in);
		while ($row = mysqli_fetch_array($result)) {
			if ($row['id_elenco_financeiro'] != NULL) {
				$valor_venda = $row['valor_venda'];
				}
				if ($valor_venda == NULL) {
					$sql = "UPDATE financeiro SET valor_venda = '$novo_valor_venda' WHERE id_elenco_financeiro = '$id'";
				} elseif ($valor_venda != NULL) {
					$sql = "UPDATE financeiro SET valor_venda = REPLACE(valor_venda,'$valor_venda','$novo_valor_venda') WHERE id_elenco_financeiro = '$id'";
				}
			}
	mysqli_query($link, $sql);
	header("Location: mais_info.php?info=$id");
	mysqli_close($link);
?>
		
<?php
header("Content-type: text/html; charset=ISO-8859-15");
include("conecta.php");
session_start();
	$id 				= $_SESSION['id'];
	$novo_observacao	= $_POST['observacao'];
	$sql_in = "SELECT * FROM novo_cadastro WHERE id_elenco = '$id'";
	$result = mysqli_query($link, $sql_in);
		while ($row = mysqli_fetch_array($result)) {
				$observacao = $row['observacao'];
				}
				if ($observacao == NULL) {
					$sql = "UPDATE novo_cadastro SET observacao = '$novo_observacao' WHERE id_elenco = '$id'";
				} elseif ($observacao != NULL) {
					$sql = "UPDATE novo_cadastro SET observacao = REPLACE(observacao,'$observacao','$novo_observacao') WHERE id_elenco = '$id'";
				}
			
	mysqli_query($link, $sql);
	header("Location: mais_info.php?info=$id");
	mysqli_close($link);
?>
		
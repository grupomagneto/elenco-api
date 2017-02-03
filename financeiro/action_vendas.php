<?php
include("conecta.php");
	$id = $_POST['id'];
	$sql = "DELETE FROM financeiro WHERE id='$id'";
		mysqli_query($link, $sql);
		header("Location: vendas.php");
		mysqli_close($link);
?>

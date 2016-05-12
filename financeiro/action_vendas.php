<?php header("Content-type: text/html; charset=ISO-8859-15");
include("conecta.php");
session_start();
	$id = $_POST['id'];
	$sql = "DELETE FROM financeiro WHERE id='$id'";
		mysqli_query($link, $sql);
		header("Location: vendas.php");
		mysqli_close($link);
?>

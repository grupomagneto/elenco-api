<?php
include('conecta.php');
	$id = $_POST['id_elenco'];
	$tipo_cadastro_vigente = $_POST['tipo_cadastro_vigente'];
	$data_contrato_vigente = $_POST['data_contrato_vigente'];
	$data_1o_contrato = $_POST['data_1o_contrato'];
	$sql = "UPDATE tb_elenco SET tipo_cadastro_vigente = '$tipo_cadastro_vigente', data_contrato_vigente = '$data_contrato_vigente', data_1o_contrato = '$data_1o_contrato' WHERE id_elenco = '$id'";
mysqli_query($link2, $sql);
mysqli_query($link, $sql);
mysqli_close($link2);
mysqli_close($link);
echo "<script type='text/javascript'>
	window.onload = function() { window.close(); }
</script>";
?>